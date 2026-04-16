<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product\ProductExtras;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminProductExtrasController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = ProductExtras::with('product:id,name,slug')
            ->orderByDesc('id');

        if ($request->filled('product_id')) {
            $query->where('product_id', (int) $request->input('product_id'));
        }

        return response()->json(['data' => $query->limit(500)->get()]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->validated($request);
        $extra = ProductExtras::create($data);
        return response()->json(['data' => $extra->load('product:id,name,slug')], 201);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $extra = ProductExtras::findOrFail($id);
        $extra->fill($this->validated($request, $extra->id))->save();
        return response()->json(['data' => $extra->fresh('product:id,name,slug')]);
    }

    public function destroy(int $id): JsonResponse
    {
        ProductExtras::findOrFail($id)->delete();
        return response()->json(['message' => 'Extra deleted.']);
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
