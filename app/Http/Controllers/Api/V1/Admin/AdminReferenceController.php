<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Geo\Country;
use App\Models\Geo\TravelDirection;
use App\Models\Order\OrderStatus;
use App\Models\Payment\PaymentGateway;
use App\Models\User\Role;
use Illuminate\Http\JsonResponse;

/**
 * Read-only reference data feeds for dashboard dropdowns and index pages.
 */
class AdminReferenceController extends Controller
{
    public function roles(): JsonResponse
    {
        return response()->json([
            'data' => Role::orderBy('id')->get(['id', 'title', 'slug']),
        ]);
    }

    public function orderStatuses(): JsonResponse
    {
        return response()->json([
            'data' => OrderStatus::orderBy('id')->get(['id', 'name', 'slug', 'color', 'is_default']),
        ]);
    }

    public function directions(): JsonResponse
    {
        $directions = TravelDirection::with(['countryFrom:id,name,code', 'countryTo:id,name,code'])
            ->orderBy('id')
            ->limit(1000)
            ->get(['id', 'name', 'slug', 'country_from_id', 'country_to_id', 'country_from_code', 'country_to_code', 'visa_req']);

        return response()->json(['data' => $directions]);
    }

    public function direction(int $id): JsonResponse
    {
        $direction = TravelDirection::with(['countryFrom', 'countryTo', 'products'])
            ->findOrFail($id);

        return response()->json(['data' => $direction]);
    }

    public function gateways(): JsonResponse
    {
        return response()->json([
            'data' => PaymentGateway::orderBy('id')->get(['id', 'name', 'slug', 'description', 'image', 'is_active']),
        ]);
    }

    public function countries(): JsonResponse
    {
        return response()->json([
            'data' => Country::orderBy('name')->get(['id', 'name', 'code', 'slug']),
        ]);
    }
}
