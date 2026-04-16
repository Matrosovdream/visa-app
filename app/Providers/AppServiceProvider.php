<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\GlobalsService;
use App\Models\User\User;
use App\Models\Order\Order;
use App\Observers\UserObserver;
use App\Observers\OrderObserver;
use App\View\Composers\GlobalsComposer;

use App\Repositories\Order\OrderRepo;
use App\Repositories\Product\ProductRepo;
use App\Repositories\User\UserRepo;
use App\Repositories\Content\SiteSettingsRepo;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(GlobalsService::class, fn () => new GlobalsService());

        $this->app->singleton(OrderRepo::class);
        $this->app->singleton(ProductRepo::class);
        $this->app->singleton(UserRepo::class);
        $this->app->singleton(SiteSettingsRepo::class);
    }

    public function boot(): void
    {
        View::composer('*', GlobalsComposer::class);

        User::observe(UserObserver::class);
        Order::observe(OrderObserver::class);
    }
}
