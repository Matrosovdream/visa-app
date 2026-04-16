<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\GlobalsService;
use Illuminate\Http\JsonResponse;
use App\Models\Geo\Language;
use App\Models\Geo\Currency;

class SiteGlobalsController extends Controller
{
    public function __construct(
        private GlobalsService $globals,
    ) {}

    public function languages(): JsonResponse
    {
        $languages = Language::where('is_active', true)->get();

        return response()->json(['data' => $languages]);
    }

    public function currencies(): JsonResponse
    {
        $currencies = Currency::where('is_active', true)->get();

        return response()->json(['data' => $currencies]);
    }

    /**
     * Single bootstrap call the Vue layout uses to populate header/footer.
     * Returns everything the GlobalsComposer used to inject into Blade.
     */
    public function bootstrap(): JsonResponse
    {
        $activeLanguage = $this->globals->getActiveLanguage();

        return response()->json([
            'data' => [
                'site_settings'   => $this->globals->getSiteSettings(),
                'menu_top'        => $this->globals->getMenuTop(),
                'languages'       => $this->globals->getLanguages(),
                'currencies'      => $this->globals->getCurrencies(),
                'countries'       => $this->globals->getCountries(),
                'active_language' => $activeLanguage,
                'active_currency' => $this->globals->getActiveCurrency(),
                'locale'          => strtolower($activeLanguage->code ?? 'en'),
                'translations'    => $this->globals->getTranslations(),
            ],
        ]);
    }
}
