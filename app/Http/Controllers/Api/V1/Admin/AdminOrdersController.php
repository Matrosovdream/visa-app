<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminOrdersController extends Controller
{
    public function index(): JsonResponse
    {
        $orders = Order::with(['user:id,name,email', 'status:id,name,slug,color'])
            ->orderByDesc('id')
            ->limit(500)
            ->get(['id', 'hash', 'user_id', 'status_id', 'is_paid', 'total_price', 'created_at']);

        return response()->json(['data' => $orders]);
    }

    public function show(int $id): JsonResponse
    {
        $order = Order::with([
            'user:id,name,email',
            'status:id,name,slug,color',
            'travellers',
            'cartProducts',
            'payments',
        ])->findOrFail($id);

        return response()->json(['data' => $order]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'user_id'     => ['nullable', 'integer', Rule::exists('users', 'id')],
            'status_id'   => ['nullable', 'integer', Rule::exists('order_statuses', 'id')],
            'total_price' => ['required', 'numeric', 'min:0'],
            'is_paid'     => ['sometimes', 'boolean'],
        ]);

        $order = Order::create($data);

        return response()->json([
            'data' => $order->fresh(['user:id,name,email', 'status:id,name,slug,color']),
        ], 201);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $order = Order::findOrFail($id);

        $data = $request->validate([
            'status_id'   => ['sometimes', 'integer', Rule::exists('order_statuses', 'id')],
            'is_paid'     => ['sometimes', 'boolean'],
            'total_price' => ['sometimes', 'numeric', 'min:0'],
        ]);

        $order->fill($data)->save();

        return response()->json(['data' => $order->fresh(['user:id,name,email', 'status:id,name,slug,color'])]);
    }

    public function destroy(int $id): JsonResponse
    {
        Order::findOrFail($id)->delete();
        return response()->json(['message' => 'Order deleted.']);
    }
}
