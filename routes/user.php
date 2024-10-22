<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\IndexController;
use App\Http\Controllers\User\CountryController;
use App\Http\Controllers\User\ArticleController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\PaymentController;


// Index page
Route::get('/', [IndexController::class, 'index'])->name('web.index');
Route::post('/', [IndexController::class, 'directionApply'])->name('web.direction.apply');

// Countries
Route::get('/country/{country}', [CountryController::class, 'index'])->name('web.country.index');
Route::get('/country/{country}/apply-now', [CountryController::class, 'apply'])->name('web.country.apply');

// Orders processing
Route::post('/orders/create-apply', [OrderController::class, 'createApply'])->name('web.order.create-apply');
Route::get('/orders/{order_hash}', [OrderController::class, 'show'])->name('web.order.show');
Route::post('/orders/{order_hash}/pay', [OrderController::class, 'pay'])->name('web.order.pay');


// Articles
Route::get('/articles', [ArticleController::class, 'index'])->name('web.articles.index');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('web.articles.show');

// Payment
Route::post('charge', [PaymentController::class, 'charge'])->name('charge');


