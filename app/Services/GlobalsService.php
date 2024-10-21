<?php
namespace App\Services;

use App\Models\Language;
use App\Services\LocationService;


class GlobalsService {

    private $locationService;

    public function __construct() {
        $this->locationService = new LocationService();
    }

    public function getGlobals() {
        return [
            'geoData' => $this->locationService->getLocation(),
            'languages' => $this->getLanguages()
        ];
    }

    public function getGeoData() {
        return $this->locationService->getLocation();
    }

    public function getLanguages() {
        return Language::all();
    }

}