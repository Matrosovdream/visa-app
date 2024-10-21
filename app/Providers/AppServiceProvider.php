<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\GlobalsService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        /*$this->app->singleton(GlobalsService::class, function ($app) {
            return new GlobalsService();
        });*/
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(GlobalsService $globalsService): void
    {
        /*\View::share('geoData', $globalsService->getGlobals()['geoData']);
        \View::share('languages', $globalsService->getGlobals()['languages']);*/
    }
}
