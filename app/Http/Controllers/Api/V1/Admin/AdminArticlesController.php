<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminArticlesController extends Controller
{
    public function index(): JsonResponse
    {
        $articles = Article::orderByDesc('id')
            ->limit(500)
            ->get(['id', 'title', 'slug', 'short_description', 'published', 'created_at']);

        return response()->json(['data' => $articles]);
    }

    public function show(int $id): JsonResponse
    {
        $article = Article::findOrFail($id);

        return response()->json(['data' => $article]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['title'], null);
        $data['author_id'] = $request->user()->id;

        $article = Article::create($data);

        return response()->json(['data' => $article], 201);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $article = Article::findOrFail($id);
        $data = $this->validated($request, $article->id);

        if (!empty($data['slug'])) {
            $data['slug'] = $this->uniqueSlug($data['slug'], $article->id);
        } else {
            unset($data['slug']);
        }

        $article->fill($data)->save();

        return response()->json(['data' => $article->fresh()]);
    }

    public function destroy(int $id): JsonResponse
    {
        Article::findOrFail($id)->delete();
        return response()->json(['message' => 'Article deleted.']);
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'title'             => ['required', 'string', 'max:255'],
            'slug'              => ['nullable', 'string', 'max:255',
                                    Rule::unique('articles', 'slug')->ignore($ignoreId)],
            'short_description' => ['nullable', 'string', 'max:2000'],
            'content'           => ['nullable', 'string'],
            'published'         => ['sometimes', 'boolean'],
        ]);
    }

    private function uniqueSlug(string $source, ?int $ignoreId): string
    {
        $base = Str::slug($source) ?: 'article';
        $slug = $base;
        $i = 1;
        while (Article::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '<>', $ignoreId))
                ->exists()) {
            $slug = $base . '-' . (++$i);
        }
        return $slug;
    }
}
