<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\CurrencyConverterService;

class CurrencyConverterFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CurrencyConverterService::class;
    }
}
