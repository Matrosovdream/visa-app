<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\IndexController;
use App\Http\Controllers\User\CountryController;
use App\Http\Controllers\User\ArticleController;
use App\Http\Controllers\User\OrderController;


// Index page
Route::get('/', [IndexController::class, 'index'])->name('user.index');
Route::post('/', [IndexController::class, 'directionApply'])->name('user.direction.apply');

// Countries
Route::get('/country/{country}', [CountryController::class, 'index'])->name('user.country.index');
Route::get('/country/{country}/apply-now', [CountryController::class, 'apply'])->name('user.country.apply');

// Orders processing
Route::post('/orders/create-apply', [OrderController::class, 'createApply'])->name('user.order.create-apply');
Route::get('/orders/{order_hash}', [OrderController::class, 'show'])->name('user.order.show');
Route::post('/orders/{order_hash}/pay', [OrderController::class, 'pay'])->name('user.order.pay');


// Articles
Route::get('/articles', [ArticleController::class, 'index'])->name('user.articles.index');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('user.articles.show');


