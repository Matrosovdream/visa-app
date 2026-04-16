<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content\SiteSettings;
use App\Services\SiteSettingsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminSettingsController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => SiteSettingsService::getAllSettings() ?: (object) [],
        ]);
    }

    /**
     * Bulk-update settings. Payload:
     *   { "settings": { "sitename": "…", "phone": "…", … } }
     *
     * Unknown keys are inserted, known keys are updated. No delete.
     */
    public function update(Request $request): JsonResponse
    {
        $data = $request->validate([
            'settings'        => ['required', 'array'],
            'settings.*'      => ['nullable', 'string', 'max:10000'],
        ]);

        foreach ($data['settings'] as $key => $value) {
            SiteSettings::set($key, (string) $value);
        }

        // Blow the globals cache so the frontend bootstrap picks up changes.
        Cache::forget('globals.site_settings');

        return response()->json([
            'data'    => SiteSettingsService::getAllSettings() ?: (object) [],
            'message' => 'Settings updated.',
        ]);
    }
}
