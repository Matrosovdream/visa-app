<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\IndexController;
use App\Http\Controllers\User\CountryController;
use App\Http\Controllers\User\ArticleController;


// Index page
Route::get('/', [IndexController::class, 'index'])->name('user.index');

// Countries
Route::get('/country/{country}', [CountryController::class, 'index'])->name('user.country.index');
Route::get('/country/{country}/apply-now', [CountryController::class, 'apply'])->name('user.country.apply');

// Articles
Route::get('/articles', [ArticleController::class, 'index'])->name('user.articles.index');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('user.articles.show');


