<?php
namespace App\Services;

use App\Models\Language;
use App\Models\Currency;
use App\Models\Country;
use App\Services\LocationService;
use App\Services\SiteSettingsService;
use App\Helpers\userSettingsHelper;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;
use Throwable;

class GlobalsService
{
    private LocationService $locationService;

    public function __construct()
    {
        $this->locationService = new LocationService();
    }

    public function getGlobals(): array
    {
        return [
            'languages'    => $this->getLanguages(),
            'currencies'   => $this->getCurrencies(),
            'countries'    => $this->getCountries(),
            'siteSettings' => $this->getSiteSettings(),
        ];
    }

    public function getGeoData()
    {
        return $this->safe(fn () => $this->locationService->getLocation());
    }

    public function getLanguages()
    {
        return $this->safe(function () {
            $list = Cache::remember('globals.languages', 3600, fn () => Language::all()->take(5));
            $active = $this->getActiveLanguage();
            foreach ($list as $language) {
                $language->active = $active && $language->code === $active->code;
            }
            return $list;
        }, new Collection());
    }

    public function getCountries()
    {
        return $this->safe(
            fn () => Cache::remember('globals.countries', 3600, fn () => Country::all()),
            new Collection()
        );
    }

    public function getCurrencies()
    {
        return $this->safe(function () {
            $list = Cache::remember('globals.currencies', 3600, fn () => Currency::all()->take(5));
            $active = $this->getActiveCurrency();
            foreach ($list as $currency) {
                $currency->active = $active && $currency->code === $active->code;
            }
            return $list;
        }, new Collection());
    }

    public function getSiteSettings()
    {
        return $this->safe(
            fn () => Cache::remember('globals.site_settings', 3600, fn () => SiteSettingsService::getAllSettings())
        );
    }

    public function getActiveLanguage()
    {
        $code = $_COOKIE['language'] ?? 'EN';
        return $this->safe(fn () => Language::where('code', $code)->first());
    }

    public function getActiveCurrency()
    {
        $code = $_COOKIE['currency'] ?? 'USD';
        return $this->safe(fn () => Currency::where('code', $code)->first());
    }

    public function getMenuTop()
    {
        return $this->safe(fn () => userSettingsHelper::getTopMenu(), []);
    }

    public static function setCurrency($code): void
    {
        setcookie('currency', $code, time() + 60 * 60 * 24 * 30, '/');
    }

    public static function setLanguage($code): void
    {
        setcookie('language', $code, time() + 60 * 60 * 24 * 30, '/');
    }

    private function safe(callable $fn, mixed $fallback = null): mixed
    {
        try {
            return $fn();
        } catch (Throwable $e) {
            report($e);
            return $fallback;
        }
    }
}
