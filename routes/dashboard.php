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
use App\Http\Controllers\Dashboard\DashboardOrderCertificatesController;
use App\Http\Controllers\Dashboard\ProductOffersController;
use App\Http\Controllers\Dashboard\ProductExtrasController;




Route::group(['as' => '','prefix' =>'dashboard','namespace' => '', 'middleware' => ['auth', 'hasRole:admin,manager']],function(){
    
    // Home dashboard page
    Route::get('/', [DashboardHomeController::class, 'index'])->name('dashboard.home');

    // Admin routes
    Route::middleware('hasRole:admin,manager')->group(function () {

        Route::middleware('hasRole:admin')->group(function() {

            // User
            Route::get('users', [DashboardUsersController::class, 'index'])->name('dashboard.users.index');
            Route::get('users/create', [DashboardUsersController::class, 'create'])->name('dashboard.users.create');
            Route::post('users', [DashboardUsersController::class, 'store'])->name('dashboard.users.store');
            Route::get('users/{user_id}', [DashboardUsersController::class, 'show'])->name('dashboard.users.show');
            Route::post('users/{user_id}', [DashboardUsersController::class, 'update'])->name('dashboard.users.update');
            Route::delete('users/{user_id}', [DashboardUsersController::class, 'destroy'])->name('dashboard.users.destroy');

        });

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

        // Product offers
        Route::get('offers', [ProductOffersController::class, 'index'])->name('dashboard.offers.index');
        Route::post('offers/create', [ProductOffersController::class, 'create'])->name('dashboard.offers.create');
        Route::delete('offers/{offer}', [ProductOffersController::class, 'destroy'])->name('dashboard.offers.destroy');
        Route::post('offers/{offer}', [ProductOffersController::class, 'update'])->name('dashboard.offers.update');

        // Product extras
        Route::get('extras', [ProductExtrasController::class, 'index'])->name('dashboard.extras.index');
        Route::post('extras/create', [ProductExtrasController::class, 'create'])->name('dashboard.extras.create');
        Route::delete('extras/{extra}', [ProductExtrasController::class, 'destroy'])->name('dashboard.extras.destroy');
        Route::post('extras/{extra}', [ProductExtrasController::class, 'update'])->name('dashboard.extras.update');

        // Orders
        Route::get('orders', [DashboardOrdersController::class, 'index'])->name('dashboard.orders.index');
        Route::get('orders/create', [DashboardOrdersController::class, 'create'])->name('dashboard.orders.create');
        Route::post('orders', [DashboardOrdersController::class, 'store'])->name('dashboard.orders.store');
        Route::get('orders/{order_id}', [DashboardOrdersController::class, 'show'])->name('dashboard.orders.show');
        Route::get('orders/{order_id}/edit', [DashboardOrdersController::class, 'edit'])->name('dashboard.orders.edit');
        Route::post('orders/{order}', [DashboardOrdersController::class, 'update'])->name('dashboard.orders.update');
        Route::delete('orders/{order_id}', [DashboardOrdersController::class, 'destroy'])->name('dashboard.orders.destroy');

        // Order certificates
        Route::post('orders/{order}/certificates/create', [DashboardOrderCertificatesController::class, 'create'])->name('dashboard.orders.certificate.create');
        Route::delete('orders/{order}/certificates/{certificate}/destroy', [DashboardOrderCertificatesController::class, 'destroy'])->name('dashboard.orders.certificate.destroy');

        // Order travellers
        Route::get('orders/{order_id}/travellers', [DashboardOrdersController::class, 'travellersList'])->name('dashboard.orders.travellers');
        Route::get('orders/{order}/travellers/create', [DashboardOrdersController::class, 'travellersCreate'])->name('dashboard.orders.traveller.create');
        Route::post('orders/{order}/travellers', [DashboardOrdersController::class, 'travellersStore'])->name('dashboard.orders.traveller.store');
        Route::get('orders/{order_id}/travellers/{traveller_id}', [DashboardOrdersController::class, 'travellerShow'])->name('dashboard.orders.traveller.show');
        Route::get('orders/{order_id}/travellers/{traveller_id}/edit', [DashboardOrdersController::class, 'travellerEdit'])->name('dashboard.orders.traveller.edit');
        Route::post('orders/{order}/travellers/{traveller}/update', [DashboardOrdersController::class, 'travellerUpdate'])->name('dashboard.orders.traveller.update');
        Route::delete('orders/{order}/travellers/{traveller}', [DashboardOrdersController::class, 'travellersDestroy'])->name('dashboard.orders.traveller.destroy');

        // Order traveller documents
        Route::delete('orders/{order}/travellers/{traveller}/documents/{document}/destroy', [DashboardOrdersController::class, 'travellerDocumentDestroy'])->name('dashboard.orders.traveller.document.destroy');
        Route::post('orders/{order}/travellers/{traveller}/documents/store', [DashboardOrdersController::class, 'travellerDocumentStore'])->name('dashboard.orders.traveller.document.store');

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

