<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Geo\TravelDirection;
use App\Repositories\Geo\TravelDirectionRepo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DirectionController extends Controller
{
    public function __construct(
        private TravelDirectionRepo $directionRepo,
    ) {}

    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'from' => ['required', 'string'],
            'to' => ['required', 'string'],
        ]);

        $direction = TravelDirection::where('country_from_code', $request->input('from'))
            ->where('country_to_code', $request->input('to'))
            ->first();

        if (!$direction) {
            return response()->json(['message' => 'Direction not found.'], 404);
        }

        $mapped = $this->directionRepo->mapItem($direction);

        return response()->json(['data' => $mapped]);
    }
}
