<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Repositories\Geo\CountryRepo;
use App\Repositories\Product\ProductRepo;
use App\Repositories\Geo\TravelDirectionRepo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function __construct(
        private CountryRepo $countryRepo,
        private ProductRepo $productRepo,
        private TravelDirectionRepo $directionRepo,
    ) {}

    public function index(): JsonResponse
    {
        $countries = $this->countryRepo->getAll();

        return response()->json(['data' => $countries]);
    }

    public function show(string $slug): JsonResponse
    {
        $country = $this->countryRepo->findBySlug($slug);

        if (!$country) {
            return response()->json(['message' => 'Country not found.'], 404);
        }

        return response()->json(['data' => $country]);
    }

    public function products(string $slug, Request $request): JsonResponse
    {
        $country = $this->countryRepo->findBySlug($slug);

        if (!$country) {
            return response()->json(['message' => 'Country not found.'], 404);
        }

        $fromCountryCode = $request->input('from', null);
        $direction = null;

        if ($fromCountryCode) {
            $direction = $this->directionRepo->findPair($fromCountryCode, $country['Model']->code);
        }

        $products = $direction
            ? $this->productRepo->getAll(['direction_id' => $direction['id']])
            : $this->productRepo->getAll(['country_slug' => $slug]);

        return response()->json(['data' => $products]);
    }
}
