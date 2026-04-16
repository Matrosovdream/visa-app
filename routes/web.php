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

// Authenticated user pages — the SPA handles auth in the browser (token in
// localStorage). Server returns the shell for any /account/* deep link.
Route::get('/account', fn () => view('user.app'))->name('web.account.index');
Route::get('/account/orders', fn () => view('user.app'))->name('web.account.orders');
Route::get('/account/orders/{id}', fn () => view('user.app'))->name('web.account.order');

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

/*
|--------------------------------------------------------------------------
| Dashboard SPA + session-authed admin JSON API
|--------------------------------------------------------------------------
| The dashboard is a separate Vue SPA. It uses the existing session cookie
| (admin logs in via /backend-login) rather than Sanctum tokens, so its
| read endpoints live in the web group where session middleware is active.
|
| /api/v1/admin/* → JSON used by the dashboard SPA
| /dashboard*     → serves the SPA shell (Vue Router handles sub-paths)
*/
Route::prefix('api/v1/admin')
    ->middleware(['auth', 'hasRole:admin,manager'])
    ->group(function () {
        Route::get('me',        [App\Http\Controllers\Api\V1\Admin\AdminController::class, 'me']);
        Route::get('stats',     [App\Http\Controllers\Api\V1\Admin\AdminController::class, 'stats']);
        Route::get('users',     [App\Http\Controllers\Api\V1\Admin\AdminController::class, 'users']);
        Route::get('orders',    [App\Http\Controllers\Api\V1\Admin\AdminController::class, 'orders']);
        Route::get('products',  [App\Http\Controllers\Api\V1\Admin\AdminController::class, 'products']);
        Route::get('articles',  [App\Http\Controllers\Api\V1\Admin\AdminController::class, 'articles']);
        Route::get('countries', [App\Http\Controllers\Api\V1\Admin\AdminController::class, 'countries']);
        Route::get('settings',  [App\Http\Controllers\Api\V1\Admin\AdminController::class, 'settings']);
    });

// New admin SPA lives at /admin-panel/* so the legacy Blade /dashboard keeps
// working while we rebuild CRUD. Vue Router handles sub-paths client-side.
Route::middleware(['auth', 'hasRole:admin,manager'])->group(function () {
    Route::get('/admin-panel', fn () => view('dashboard.spa'))->name('admin.spa');
    Route::get('/admin-panel/{any}', fn () => view('dashboard.spa'))
        ->where('any', '.*')
        ->name('admin.spa.any');
});
