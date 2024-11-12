<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\GlobalsService;
use App\Models\User;
use App\Models\Order;
use App\Observers\UserObserver;
use App\Observers\OrderObserver;


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
        \View::share('menuTop', $globalsService->getMenuTop());
        \View::share('currencies', $globalsService->getCurrencies());
        \View::share('countries', $globalsService->getCountries());
        \View::share('activeLanguage', $globalsService->getActiveLanguage());
        \View::share('activeCurrency', $globalsService->getActiveCurrency());
        \View::share('siteSettings', $globalsService->getGlobals()['siteSettings']);

        // Observers
        User::observe(UserObserver::class);
        Order::observe(OrderObserver::class);

    }
}
