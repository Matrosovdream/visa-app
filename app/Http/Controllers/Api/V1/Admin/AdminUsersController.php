<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\User\Role;
use App\Models\User\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUsersController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::with('roles:id,title,slug')
            ->orderByDesc('id')
            ->limit(500)
            ->get(['id', 'name', 'email', 'is_active', 'created_at']);

        return response()->json(['data' => $users]);
    }

    public function show(int $id): JsonResponse
    {
        $user = User::with('roles:id,title,slug')->findOrFail($id);

        return response()->json([
            'data' => [
                'id'         => $user->id,
                'name'       => $user->name,
                'email'      => $user->email,
                'is_active'  => (bool) $user->is_active,
                'role_id'    => optional($user->roles->first())->id,
                'has_pin'    => !empty($user->pin),
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'  => ['required', 'string', 'min:6'],
            'is_active' => ['sometimes', 'boolean'],
            'role_id'   => ['required', 'integer', Rule::exists('roles', 'id')],
            'pin'       => ['nullable', 'string', 'min:3', 'max:20'],
        ]);

        $user = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => $data['password'],
            'is_active' => $data['is_active'] ?? true,
            'pin'       => !empty($data['pin']) ? $data['pin'] : null,
        ]);

        $user->roles()->sync([$data['role_id']]);

        return response()->json(['data' => $user->load('roles:id,title,slug')], 201);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name'      => ['sometimes', 'required', 'string', 'max:255'],
            'email'     => ['sometimes', 'required', 'email', 'max:255',
                            Rule::unique('users', 'email')->ignore($user->id)],
            'is_active' => ['sometimes', 'boolean'],
            'role_id'   => ['sometimes', 'integer', Rule::exists('roles', 'id')],
        ]);

        $user->fill(array_intersect_key($data, array_flip(['name', 'email', 'is_active'])));
        $user->save();

        if (array_key_exists('role_id', $data)) {
            $user->roles()->sync([$data['role_id']]);
        }

        return response()->json(['data' => $user->fresh()->load('roles:id,title,slug')]);
    }

    public function destroy(int $id, Request $request): JsonResponse
    {
        $user = User::findOrFail($id);

        if ($request->user()->id === $user->id) {
            return response()->json([
                'message' => 'You cannot delete yourself.',
            ], 422);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted.']);
    }

    public function updatePassword(int $id, Request $request): JsonResponse
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'password' => ['required', 'string', 'min:6'],
        ]);

        $user->password = $data['password'];
        $user->save();

        return response()->json(['message' => 'Password updated.']);
    }

    public function updatePin(int $id, Request $request): JsonResponse
    {
        $user = User::findOrFail($id);

        // Empty / missing pin = remove it.
        if (!$request->filled('pin')) {
            $user->forceFill(['pin' => null])->saveQuietly();
            return response()->json(['message' => 'PIN removed.']);
        }

        $request->validate([
            'pin' => ['required', 'string', 'min:3', 'max:20'],
        ]);

        $user->pin = $request->input('pin');
        $user->save();

        return response()->json(['message' => 'PIN updated.']);
    }
}
