<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authorization routes
require __DIR__.'/auth.php';

// User routes
require __DIR__.'/user.php';

// Dashboard routes
require __DIR__.'/dashboard.php';

/*
|--------------------------------------------------------------------------
| User-facing Vue SPA (override)
|--------------------------------------------------------------------------
| Declared AFTER the auth/user/dashboard requires so they win on URI clash.
| Laravel keeps the last-registered route for a given method+URI.
| Dashboard/admin/account routes stay untouched (Blade).
*/
Route::get('/', fn () => view('user.app'))->name('web.index');
Route::get('/articles', fn () => view('user.app'))->name('web.articles.index');
Route::get('/articles/{article}', fn () => view('user.app'))->name('web.articles.show');
Route::get('/country/{country}', fn () => view('user.app'))->name('web.country.index');
Route::get('/login', fn () => view('user.app'))->name('login');

/*
|--------------------------------------------------------------------------
| Backend / admin login (Blade, session auth)
|--------------------------------------------------------------------------
| The public /login is the Vue SPA which issues Sanctum tokens only (no
| session). The Blade dashboard uses session auth, so admins/managers need
| a traditional login page that runs through AuthenticatedSessionController
| and sets a session cookie.
*/
Route::get('/backend-login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('backend.login');
