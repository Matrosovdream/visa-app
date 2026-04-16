<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use App\Models\Traveller\Traveller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminOrderTravellersController extends Controller
{
    public function index(int $orderId): JsonResponse
    {
        $order = Order::findOrFail($orderId);

        return response()->json([
            'data' => $order->travellers()->get(),
        ]);
    }

    public function show(int $orderId, int $travellerId): JsonResponse
    {
        $order = Order::findOrFail($orderId);
        $traveller = $order->travellers()->where('travellers.id', $travellerId)->firstOrFail();
        $traveller->load('meta');

        return response()->json(['data' => $traveller]);
    }

    public function store(int $orderId, Request $request): JsonResponse
    {
        $order = Order::findOrFail($orderId);
        $data = $this->validated($request);

        $traveller = Traveller::create($data);
        $order->travellers()->attach($traveller->id);

        return response()->json(['data' => $traveller], 201);
    }

    public function update(int $orderId, int $travellerId, Request $request): JsonResponse
    {
        $order = Order::findOrFail($orderId);
        $traveller = $order->travellers()->where('travellers.id', $travellerId)->firstOrFail();
        $traveller->fill($this->validated($request, $traveller->id))->save();

        return response()->json(['data' => $traveller->fresh()]);
    }

    public function destroy(int $orderId, int $travellerId): JsonResponse
    {
        $order = Order::findOrFail($orderId);
        $order->travellers()->detach($travellerId);

        // If no other order references this traveller, hard delete it.
        $t = Traveller::find($travellerId);
        if ($t && !$t->orders()->exists()) {
            $t->delete();
        }

        return response()->json(['message' => 'Applicant removed.']);
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name'     => ['required', 'string', 'max:120'],
            'lastname' => ['required', 'string', 'max:120'],
            'birthday' => ['nullable', 'string', 'max:32'],
            'passport' => ['nullable', 'string', 'max:64'],
        ]);
    }
}
