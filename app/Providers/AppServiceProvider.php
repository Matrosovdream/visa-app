<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\GlobalsService;
use App\Models\Language;
use App\Models\Currency;
use App;
use App\Services\CurrencyService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(GlobalsService::class, function ($app) {
            return new GlobalsService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(GlobalsService $globalsService): void
    {

        // if GET parameter is set, set the language
        if (isset($_GET['setlang'])) {
            $globalsService->setLanguage($_GET['setlang']);
        }

        // if GET parameter is set, set the currency
        if (isset($_GET['setcurrency'])) {
            $globalsService->setCurrency($_GET['setcurrency']);
        }

        // set the locale
        if( isset($globalsService->getActiveLanguage()->code) ) {
            App::setLocale( strtolower($globalsService->getActiveLanguage()->code) );
        }

        //\View::share('geoData', $globalsService->getGlobals()['geoData']);
        \View::share('languages', $globalsService->getLanguages());
        \View::share('menuTop', $globalsService->getMenuTop());
        \View::share('currencies', $globalsService->getCurrencies());
        \View::share('countries', $globalsService->getCountries());
        \View::share('activeLanguage', $globalsService->getActiveLanguage());
        \View::share('activeCurrency', $globalsService->getActiveCurrency());
        \View::share('siteSettings', $globalsService->getGlobals()['siteSettings']);

        
    }
}
