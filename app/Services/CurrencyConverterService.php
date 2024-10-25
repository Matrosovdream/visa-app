<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Mixins\Converters\ExchangeRateConverter;

class CurrencyConverterService
{

    public static function convert(string $fromCurrency, string $toCurrency, float $amount): float
    {
        
        $service = new ExchangeRateConverter();
        return round( $service->convert($fromCurrency, $toCurrency, $amount) );

    }

}
