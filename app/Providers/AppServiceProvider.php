<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\GlobalsService;
use App\Models\Language;
use App\Models\Currency;

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
        //\View::share('geoData', $globalsService->getGlobals()['geoData']);
        \View::share('languages', $globalsService->getLanguages());
        \View::share('currencies', $globalsService->getCurrencies());
        \View::share('activeLanguage', $globalsService->getActiveLanguage());
        \View::share('activeCurrency', $globalsService->getActiveCurrency());
        \View::share('siteSettings', $globalsService->getGlobals()['siteSettings']);

        // if GET parameter is set, set the language
        if (isset($_GET['setlang'])) {
            $language = Language::where('code', $_GET['setlang'])->first();
            if ($language) {
                setcookie('language', $language->code, time() + 60 * 60 * 24 * 30, '/');
                //return redirect()->back();
            }
        }

        // if GET parameter is set, set the currency
        if (isset($_GET['setcurrency'])) {
            $currency = Currency::where('code', $_GET['setcurrency'])->first();
            if ($currency) {
                setcookie('currency', $currency->code, time() + 60 * 60 * 24 * 30, '/');
                //return redirect()->back();
            }
        }



    }
}
