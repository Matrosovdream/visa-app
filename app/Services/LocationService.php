<?php
namespace App\Services;

use Stevebauman\Location\Facades\Location;

class LocationService
{

    public static function getLocation($ipAddress = null)
    {

        $location = Location::get($ipAddress);

        if ($location) {
            return [
                'ip' => $location->ip,
                'country' => $location->countryName,
                'countryCode' => $location->countryCode,
                'region' => $location->regionName,
                'city' => $location->cityName,
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
                'currencyCode' => $location->currencyCode,
            ];
        } else {
            return [
                'ip' => '',
                'country' => '',
                'countryCode' => '',
                'region' => '',
                'city' => '',
                'latitude' => '',
                'longitude' => '',
                'currencyCode' => '',
            ];
        }

    }

}
