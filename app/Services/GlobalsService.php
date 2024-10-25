<?php
namespace App\Services;

use App\Models\Language;
use App\Models\Currency;
use App\Services\LocationService;
use App\Models\SiteSettings;


class GlobalsService {

    private $locationService;

    public function __construct() {
        $this->locationService = new LocationService();
    }

    public function getGlobals() {
        return [
            //'geoData' => $this->locationService->getLocation(),
            'languages' => $this->getLanguages(),
            'siteSettings' => $this->getSiteSettings()
        ];
    }

    public function getGeoData() {
        return $this->locationService->getLocation();
    }

    public function getLanguages() {
        $list = Language::all()->take(5);

        foreach ($list as $language) {
            $language->active = $language->code == $this->getActiveLanguage()->code;
        }
        return $list;
    }

    public function getCurrencies() {
        $list = Currency::all()->take(5);

        foreach ($list as $currency) {
            $currency->active = $currency->code == $this->getActiveCurrency()->code;
        }
        return $list;
    }

    public function getSiteSettings() {
        return SiteSettingsService::getAllSettings();
    }

    public function getActiveLanguage() {

        if (isset($_COOKIE['language'])) {
            $code = $_COOKIE['language'];
        } else {
            $code = 'EN';
        }
        return Language::where('code', $code)->first();
    }

    public function getActiveCurrency() {
        
        if (isset($_COOKIE['currency'])) {
            $code = $_COOKIE['currency'];
        } else {
            $code = 'USD';
        }
        return Currency::where('code', $code)->first();
    }

    public function setCurrency($code) {
        setcookie('currency', $code, time() + 60 * 60 * 24 * 30, '/');
    }

    public function setLanguage($code) {
        setcookie('language', $code, time() + 60 * 60 * 24 * 30, '/');
    }

}