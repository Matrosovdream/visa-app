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



Route::group(['as' => '','prefix' =>'admin','namespace' => '', 'middleware' => ['auth', 'verified', 'isAdmin']],function(){
    
    // Home dashboard page
    Route::get('/', [AdminHomeController::class, 'index'])->name('admin.home');

    // User
    Route::get('users', [AdminUsersController::class, 'index'])->name('admin.users.index');
    Route::get('users/{user_id}', [AdminUsersController::class, 'show'])->name('admin.users.show');

    // Countries
    Route::get('countries', [AdminCountriesController::class, 'index'])->name('admin.countries.index');

    // Directions
    Route::get('directions', [AdminDirectionsController::class, 'index'])->name('admin.directions.index');

    // Products
    Route::get('products', [AdminProductsController::class, 'index'])->name('admin.products.index');

    // Orders
    Route::get('orders', [AdminOrdersController::class, 'index'])->name('admin.orders.index');

    // Articles
    Route::get('articles', [AdminArticlesController::class, 'index'])->name('admin.articles.index');

    // Settings
    Route::get('settings', [AdminSettingsController::class, 'index'])->name('admin.settings.index');

});

