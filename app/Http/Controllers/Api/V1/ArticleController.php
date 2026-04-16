<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Repositories\Content\ArticleRepo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function __construct(
        private ArticleRepo $articleRepo,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $q = trim((string) $request->query('q', ''));

        $articles = $q !== ''
            ? $this->articleRepo->search($q)
            : $this->articleRepo->getAll();

        return response()->json(['data' => $articles]);
    }

    public function show(string $slug): JsonResponse
    {
        $article = $this->articleRepo->getBySlug($slug);

        if (!$article) {
            return response()->json(['message' => 'Article not found.'], 404);
        }

        return response()->json(['data' => $article]);
    }
}
