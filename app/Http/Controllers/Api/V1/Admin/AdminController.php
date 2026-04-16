<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content\Article;
use App\Models\Geo\Country;
use App\Models\Order\Order;
use App\Models\Product\Product;
use App\Models\User\User;
use App\Services\SiteSettingsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Read-only admin endpoints backing the dashboard SPA.
 * CRUD endpoints will be added in a follow-up pass.
 */
class AdminController extends Controller
{
    public function me(Request $request): JsonResponse
    {
        $user = $request->user()?->load('roles');
        return response()->json(['data' => $user]);
    }

    public function stats(): JsonResponse
    {
        return response()->json([
            'data' => [
                'users'        => User::count(),
                'orders'       => Order::count(),
                'orders_paid'  => Order::where('is_paid', true)->count(),
                'products'     => Product::count(),
                'articles'     => Article::count(),
                'countries'    => Country::count(),
            ],
        ]);
    }

    public function users(): JsonResponse
    {
        $users = User::with('roles:id,title,slug')
            ->orderByDesc('id')
            ->limit(500)
            ->get(['id', 'name', 'email', 'is_active', 'created_at']);

        return response()->json(['data' => $users]);
    }

    public function orders(): JsonResponse
    {
        $orders = Order::with(['user:id,name,email', 'status:id,name,slug,color'])
            ->orderByDesc('id')
            ->limit(500)
            ->get(['id', 'hash', 'user_id', 'status_id', 'is_paid', 'total_price', 'created_at']);

        return response()->json(['data' => $orders]);
    }

    public function products(): JsonResponse
    {
        $products = Product::orderByDesc('id')
            ->limit(500)
            ->get(['id', 'name', 'slug', 'price', 'published', 'created_at']);

        return response()->json(['data' => $products]);
    }

    public function articles(): JsonResponse
    {
        $articles = Article::orderByDesc('id')
            ->limit(500)
            ->get(['id', 'title', 'slug', 'created_at']);

        return response()->json(['data' => $articles]);
    }

    public function countries(): JsonResponse
    {
        $countries = Country::orderBy('name')
            ->get(['id', 'name', 'code', 'slug']);

        return response()->json(['data' => $countries]);
    }

    public function settings(): JsonResponse
    {
        $all = method_exists(SiteSettingsService::class, 'getAllSettings')
            ? SiteSettingsService::getAllSettings()
            : [];

        return response()->json(['data' => $all ?: (object) []]);
    }
}
