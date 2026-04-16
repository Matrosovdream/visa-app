<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminProductsController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Product::orderByDesc('id')
            ->limit(500)
            ->get(['id', 'name', 'slug', 'price', 'published', 'created_at']);

        return response()->json(['data' => $products]);
    }

    public function show(int $id): JsonResponse
    {
        $product = Product::findOrFail($id);

        return response()->json(['data' => $product]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['name'], null);

        $product = Product::create($data);

        return response()->json(['data' => $product], 201);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $product = Product::findOrFail($id);
        $data = $this->validated($request, $product->id);

        if (!empty($data['slug'])) {
            $data['slug'] = $this->uniqueSlug($data['slug'], $product->id);
        } else {
            unset($data['slug']);
        }

        $product->fill($data)->save();

        return response()->json(['data' => $product->fresh()]);
    }

    public function destroy(int $id): JsonResponse
    {
        Product::findOrFail($id)->delete();
        return response()->json(['message' => 'Product deleted.']);
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'slug'        => ['nullable', 'string', 'max:255',
                              Rule::unique('products', 'slug')->ignore($ignoreId)],
            'description' => ['nullable', 'string'],
            'content'     => ['nullable', 'string'],
            'image'       => ['nullable', 'string', 'max:255'],
            'price'       => ['required', 'numeric', 'min:0'],
            'published'   => ['sometimes', 'boolean'],
        ]);
    }

    private function uniqueSlug(string $source, ?int $ignoreId): string
    {
        $base = Str::slug($source) ?: 'product';
        $slug = $base;
        $i = 1;
        while (Product::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '<>', $ignoreId))
                ->exists()) {
            $slug = $base . '-' . (++$i);
        }
        return $slug;
    }
}
