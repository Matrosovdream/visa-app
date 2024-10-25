<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Dashboard\DashboardHomeController;
use App\Http\Controllers\Dashboard\DashboardUsersController;
use App\Http\Controllers\Dashboard\DashboardArticlesController;
use App\Http\Controllers\Dashboard\DashboardCountriesController;
use App\Http\Controllers\Dashboard\DashboardDirectionsController;
use App\Http\Controllers\Dashboard\DashboardOrdersController;
use App\Http\Controllers\Dashboard\DashboardProductsController;
use App\Http\Controllers\Dashboard\DashboardSettingsController;
use App\Http\Controllers\Dashboard\DashboardGatewaysController;
use App\Http\Controllers\Dashboard\DashboardMyOrdersController;
use App\Http\Controllers\Dashboard\DashboardProfileController;



Route::group(['as' => '','prefix' =>'dashboard','namespace' => '', 'middleware' => ['auth', 'verified']],function(){
    
    // Home dashboard page
    Route::get('/', [DashboardHomeController::class, 'index'])->name('dashboard.home');

    // Admin routes
    Route::middleware('isAdmin')->group(function () {

        // User
        Route::get('users', [DashboardUsersController::class, 'index'])->name('dashboard.users.index');
        Route::get('users/{user_id}', [DashboardUsersController::class, 'show'])->name('dashboard.users.show');
        Route::delete('users/{user_id}', [DashboardUsersController::class, 'destroy'])->name('dashboard.users.destroy');

        // Countries
        Route::get('countries', [DashboardCountriesController::class, 'index'])->name('dashboard.countries.index');

        // Directions
        Route::get('directions', [DashboardDirectionsController::class, 'index'])->name('dashboard.directions.index');
        Route::get('directions/{direction_id}', [DashboardDirectionsController::class, 'show'])->name('dashboard.directions.show');

        // Products
        Route::get('products', [DashboardProductsController::class, 'index'])->name('dashboard.products.index');
        Route::get('products/create', [DashboardProductsController::class, 'create'])->name('dashboard.products.create');
        Route::post('products', [DashboardProductsController::class, 'store'])->name('dashboard.products.store');
        Route::get('products/{product_id}', [DashboardProductsController::class, 'show'])->name('dashboard.products.show');
        Route::get('products/{product_id}/edit', [DashboardProductsController::class, 'edit'])->name('dashboard.products.edit');
        Route::post('products/{product_id}', [DashboardProductsController::class, 'update'])->name('dashboard.products.update');
        Route::delete('products/{product_id}', [DashboardProductsController::class, 'destroy'])->name('dashboard.products.destroy');

        // Orders
        Route::get('orders', [DashboardOrdersController::class, 'index'])->name('dashboard.orders.index');
        Route::get('orders/create', [DashboardOrdersController::class, 'edit'])->name('dashboard.orders.create');
        Route::get('orders/{order_id}', [DashboardOrdersController::class, 'show'])->name('dashboard.orders.show');
        Route::get('orders/{order_id}/edit', [DashboardOrdersController::class, 'edit'])->name('dashboard.orders.edit');
        Route::post('orders/{order_id}', [DashboardOrdersController::class, 'update'])->name('dashboard.orders.update');
        Route::delete('orders/{order_id}', [DashboardOrdersController::class, 'destroy'])->name('dashboard.orders.destroy');

        // Payment gateways
        Route::get('gateways', [DashboardGatewaysController::class, 'index'])->name('dashboard.gateways.index');

        // Articles
        Route::get('articles', [DashboardArticlesController::class, 'index'])->name('dashboard.articles.index');
        Route::get('articles/create', [DashboardArticlesController::class, 'create'])->name('dashboard.articles.create');
        Route::post('articles', [DashboardArticlesController::class, 'store'])->name('dashboard.articles.store');
        Route::get('articles/{article_id}', [DashboardArticlesController::class, 'show'])->name('dashboard.articles.show');
        Route::get('articles/{article_id}/edit', [DashboardArticlesController::class, 'edit'])->name('dashboard.articles.edit');
        Route::post('articles/{article_id}', [DashboardArticlesController::class, 'update'])->name('dashboard.articles.update');
        Route::delete('articles/{article_id}', [DashboardArticlesController::class, 'destroy'])->name('dashboard.articles.destroy');


        // Settings
        Route::get('settings', [DashboardSettingsController::class, 'index'])->name('dashboard.settings.index');
        Route::post('settings', [DashboardSettingsController::class, 'store'])->name('dashboard.settings.store');

    });

    // User routes
    Route::middleware('isUser')->group(function () {

        // dashboard.profile.destroy, dashboard.password.update, dashboard.profile.update

        // User
        Route::get('profile', [DashboardProfileController::class, 'profile'])->name('dashboard.profile');
        Route::post('profile', [DashboardProfileController::class, 'updateProfile'])->name('dashboard.profile.update');
        Route::post('profile/password', [DashboardProfileController::class, 'updatePassword'])->name('dashboard.password.update');
        Route::post('profile/destroy', [DashboardProfileController::class, 'destroy'])->name('dashboard.profile.destroy');

        // Orders
        Route::get('my-orders', [DashboardMyOrdersController::class, 'index'])->name('dashboard.my-orders');
        Route::get('my-orders/{order_id}', [DashboardMyOrdersController::class, 'show'])->name('dashboard.my-orders.show');

    });

});

