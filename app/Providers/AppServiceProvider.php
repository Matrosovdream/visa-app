<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\GlobalsService;
use App\Models\User;
use App\Models\Order;
use App\Observers\UserObserver;
use App\Observers\OrderObserver;
use App\View\Composers\GlobalsComposer;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(GlobalsService::class, fn () => new GlobalsService());
    }

    public function boot(): void
    {
        View::composer('*', GlobalsComposer::class);

        User::observe(UserObserver::class);
        Order::observe(OrderObserver::class);
    }
}
