<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\AdminArticlesController;
use App\Http\Controllers\Admin\AdminCountriesController;
use App\Http\Controllers\Admin\AdminDirectionsController;
use App\Http\Controllers\Admin\AdminOrdersController;
use App\Http\Controllers\Admin\AdminProductsController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\AdminGatewaysController;



Route::group(['as' => '','prefix' =>'admin','namespace' => '', 'middleware' => ['auth', 'verified', 'isAdmin']],function(){
    
    // Home dashboard page
    Route::get('/', [AdminHomeController::class, 'index'])->name('admin.home');

    // User
    Route::get('users', [AdminUsersController::class, 'index'])->name('admin.users.index');
    Route::get('users/{user_id}', [AdminUsersController::class, 'show'])->name('admin.users.show');
    Route::delete('users/{user_id}', [AdminUsersController::class, 'destroy'])->name('admin.users.destroy');

    // Countries
    Route::get('countries', [AdminCountriesController::class, 'index'])->name('admin.countries.index');

    // Directions
    Route::get('directions', [AdminDirectionsController::class, 'index'])->name('admin.directions.index');
    Route::get('directions/{direction_id}', [AdminDirectionsController::class, 'show'])->name('admin.directions.show');

    // Products
    Route::get('products', [AdminProductsController::class, 'index'])->name('admin.products.index');
    Route::get('products/create', [AdminProductsController::class, 'create'])->name('admin.products.create');
    Route::post('products', [AdminProductsController::class, 'store'])->name('admin.products.store');
    Route::get('products/{product_id}', [AdminProductsController::class, 'show'])->name('admin.products.show');
    Route::get('products/{product_id}/edit', [AdminProductsController::class, 'edit'])->name('admin.products.edit');
    Route::post('products/{product_id}', [AdminProductsController::class, 'update'])->name('admin.products.update');
    Route::delete('products/{product_id}', [AdminProductsController::class, 'destroy'])->name('admin.products.destroy');

    // Orders
    Route::get('orders', [AdminOrdersController::class, 'index'])->name('admin.orders.index');
    Route::get('orders/create', [AdminOrdersController::class, 'edit'])->name('admin.orders.create');
    Route::get('orders/{order_id}', [AdminOrdersController::class, 'show'])->name('admin.orders.show');
    Route::get('orders/{order_id}/edit', [AdminOrdersController::class, 'edit'])->name('admin.orders.edit');
    Route::post('orders/{order_id}', [AdminOrdersController::class, 'update'])->name('admin.orders.update');
    Route::delete('orders/{order_id}', [AdminOrdersController::class, 'destroy'])->name('admin.orders.destroy');

    // Payment gateways
    Route::get('gateways', [AdminGatewaysController::class, 'index'])->name('admin.gateways.index');

    // Articles
    Route::get('articles', [AdminArticlesController::class, 'index'])->name('admin.articles.index');
    Route::get('articles/create', [AdminArticlesController::class, 'create'])->name('admin.articles.create');
    Route::post('articles', [AdminArticlesController::class, 'store'])->name('admin.articles.store');
    Route::get('articles/{article_id}', [AdminArticlesController::class, 'show'])->name('admin.articles.show');
    Route::get('articles/{article_id}/edit', [AdminArticlesController::class, 'edit'])->name('admin.articles.edit');
    Route::post('articles/{article_id}', [AdminArticlesController::class, 'update'])->name('admin.articles.update');
    Route::delete('articles/{article_id}', [AdminArticlesController::class, 'destroy'])->name('admin.articles.destroy');


    // Settings
    Route::get('settings', [AdminSettingsController::class, 'index'])->name('admin.settings.index');

});

