<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

class AccountController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return response()->json(['data' => $request->user()->load('roles')]);
    }

    public function settings(Request $request): JsonResponse
    {
        return response()->json(['data' => $request->user()]);
    }

    public function updateSettings(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'email', 'max:255', 'unique:users,email,' . $request->user()->id],
            'password' => ['sometimes', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = $request->user();
        $user->update($request->only(['name', 'email']));

        if ($request->filled('password')) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        return response()->json(['data' => $user->fresh()]);
    }
}
