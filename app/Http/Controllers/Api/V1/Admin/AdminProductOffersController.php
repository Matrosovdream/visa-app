<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product\Product;
use App\Models\Product\ProductOffers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminProductOffersController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = ProductOffers::with('product:id,name,slug')
            ->orderByDesc('id');

        if ($request->filled('product_id')) {
            $query->where('product_id', (int) $request->input('product_id'));
        }

        return response()->json(['data' => $query->limit(500)->get()]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->validated($request);
        $offer = ProductOffers::create($data);
        return response()->json(['data' => $offer->load('product:id,name,slug')], 201);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $offer = ProductOffers::findOrFail($id);
        $offer->fill($this->validated($request, $offer->id))->save();
        return response()->json(['data' => $offer->fresh('product:id,name,slug')]);
    }

    public function destroy(int $id): JsonResponse
    {
        ProductOffers::findOrFail($id)->delete();
        return response()->json(['message' => 'Offer deleted.']);
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'product_id'  => ['required', 'integer', Rule::exists('products', 'id')],
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price'       => ['required', 'numeric', 'min:0'],
        ]);
    }
}
