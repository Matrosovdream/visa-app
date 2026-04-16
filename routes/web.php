<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authorization routes
require __DIR__.'/auth.php';

// User routes
require __DIR__.'/user.php';

// Legacy dashboard.php is now retired — the Vue SPA below serves /dashboard.
// require __DIR__.'/dashboard.php';

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

// Auth pages served by the Vue SPA.
Route::get('/login',           fn () => view('user.app'))->name('login');
Route::get('/register',        fn () => view('user.app'))->name('register');
Route::get('/forgot-password', fn () => view('user.app'))->name('password.request');
Route::get('/reset-password/{token}', fn () => view('user.app'))->name('password.reset');

// Authenticated user pages — the SPA handles auth in the browser (token in
// localStorage). Server returns the shell for any /account/* deep link.
Route::get('/account', fn () => view('user.app'))->name('web.account.index');
Route::get('/account/orders', fn () => view('user.app'))->name('web.account.orders');
Route::get('/account/orders/{id}', fn () => view('user.app'))->name('web.account.order');
Route::get('/account/orders/{id}/{any}', fn () => view('user.app'))
    ->where('any', '.*')
    ->name('web.account.order.any');

// Public order preview (by hash) also served by the SPA.
// Parameter name matches the legacy user.php route so Laravel treats them as
// the same URI template and my registration (later) wins.
Route::get('/orders/{order_hash}', fn () => view('user.app'))->name('web.order.show');

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

// PIN-based login for staff (same login page, second tab).
Route::post('/backend-login/pin', [App\Http\Controllers\Auth\PinLoginController::class, 'store'])
    ->middleware('guest')
    ->name('backend.login.pin');

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
        // Session / identity
        Route::get('me',    [App\Http\Controllers\Api\V1\Admin\AdminController::class, 'me']);
        Route::get('stats', [App\Http\Controllers\Api\V1\Admin\AdminController::class, 'stats']);

        // Users — full CRUD, plus dedicated password/pin endpoints
        Route::get('users',                    [App\Http\Controllers\Api\V1\Admin\AdminUsersController::class, 'index']);
        Route::post('users',                   [App\Http\Controllers\Api\V1\Admin\AdminUsersController::class, 'store']);
        Route::get('users/{id}',               [App\Http\Controllers\Api\V1\Admin\AdminUsersController::class, 'show'])->whereNumber('id');
        Route::put('users/{id}',               [App\Http\Controllers\Api\V1\Admin\AdminUsersController::class, 'update'])->whereNumber('id');
        Route::delete('users/{id}',            [App\Http\Controllers\Api\V1\Admin\AdminUsersController::class, 'destroy'])->whereNumber('id');
        Route::put('users/{id}/password',      [App\Http\Controllers\Api\V1\Admin\AdminUsersController::class, 'updatePassword'])->whereNumber('id');
        Route::put('users/{id}/pin',           [App\Http\Controllers\Api\V1\Admin\AdminUsersController::class, 'updatePin'])->whereNumber('id');

        // Products — full CRUD
        Route::get('products',         [App\Http\Controllers\Api\V1\Admin\AdminProductsController::class, 'index']);
        Route::post('products',        [App\Http\Controllers\Api\V1\Admin\AdminProductsController::class, 'store']);
        Route::get('products/{id}',    [App\Http\Controllers\Api\V1\Admin\AdminProductsController::class, 'show'])->whereNumber('id');
        Route::put('products/{id}',    [App\Http\Controllers\Api\V1\Admin\AdminProductsController::class, 'update'])->whereNumber('id');
        Route::delete('products/{id}', [App\Http\Controllers\Api\V1\Admin\AdminProductsController::class, 'destroy'])->whereNumber('id');

        // Articles — full CRUD
        Route::get('articles',         [App\Http\Controllers\Api\V1\Admin\AdminArticlesController::class, 'index']);
        Route::post('articles',        [App\Http\Controllers\Api\V1\Admin\AdminArticlesController::class, 'store']);
        Route::get('articles/{id}',    [App\Http\Controllers\Api\V1\Admin\AdminArticlesController::class, 'show'])->whereNumber('id');
        Route::put('articles/{id}',    [App\Http\Controllers\Api\V1\Admin\AdminArticlesController::class, 'update'])->whereNumber('id');
        Route::delete('articles/{id}', [App\Http\Controllers\Api\V1\Admin\AdminArticlesController::class, 'destroy'])->whereNumber('id');

        // Orders — full CRUD (store lets admin create an order manually)
        Route::get('orders',         [App\Http\Controllers\Api\V1\Admin\AdminOrdersController::class, 'index']);
        Route::post('orders',        [App\Http\Controllers\Api\V1\Admin\AdminOrdersController::class, 'store']);
        Route::get('orders/{id}',    [App\Http\Controllers\Api\V1\Admin\AdminOrdersController::class, 'show'])->whereNumber('id');
        Route::put('orders/{id}',    [App\Http\Controllers\Api\V1\Admin\AdminOrdersController::class, 'update'])->whereNumber('id');
        Route::delete('orders/{id}', [App\Http\Controllers\Api\V1\Admin\AdminOrdersController::class, 'destroy'])->whereNumber('id');

        // Order travellers (nested)
        Route::get('orders/{id}/travellers',                  [App\Http\Controllers\Api\V1\Admin\AdminOrderTravellersController::class, 'index'])->whereNumber('id');
        Route::post('orders/{id}/travellers',                 [App\Http\Controllers\Api\V1\Admin\AdminOrderTravellersController::class, 'store'])->whereNumber('id');
        Route::get('orders/{id}/travellers/{travellerId}',    [App\Http\Controllers\Api\V1\Admin\AdminOrderTravellersController::class, 'show'])->whereNumber('id')->whereNumber('travellerId');
        Route::put('orders/{id}/travellers/{travellerId}',    [App\Http\Controllers\Api\V1\Admin\AdminOrderTravellersController::class, 'update'])->whereNumber('id')->whereNumber('travellerId');
        Route::delete('orders/{id}/travellers/{travellerId}', [App\Http\Controllers\Api\V1\Admin\AdminOrderTravellersController::class, 'destroy'])->whereNumber('id')->whereNumber('travellerId');

        // Product offers + extras (CRUD; list can filter by ?product_id=)
        Route::get('offers',         [App\Http\Controllers\Api\V1\Admin\AdminProductOffersController::class, 'index']);
        Route::post('offers',        [App\Http\Controllers\Api\V1\Admin\AdminProductOffersController::class, 'store']);
        Route::put('offers/{id}',    [App\Http\Controllers\Api\V1\Admin\AdminProductOffersController::class, 'update'])->whereNumber('id');
        Route::delete('offers/{id}', [App\Http\Controllers\Api\V1\Admin\AdminProductOffersController::class, 'destroy'])->whereNumber('id');

        Route::get('extras',         [App\Http\Controllers\Api\V1\Admin\AdminProductExtrasController::class, 'index']);
        Route::post('extras',        [App\Http\Controllers\Api\V1\Admin\AdminProductExtrasController::class, 'store']);
        Route::put('extras/{id}',    [App\Http\Controllers\Api\V1\Admin\AdminProductExtrasController::class, 'update'])->whereNumber('id');
        Route::delete('extras/{id}', [App\Http\Controllers\Api\V1\Admin\AdminProductExtrasController::class, 'destroy'])->whereNumber('id');

        // Settings — bulk get + bulk update
        Route::get('settings', [App\Http\Controllers\Api\V1\Admin\AdminSettingsController::class, 'index']);
        Route::put('settings', [App\Http\Controllers\Api\V1\Admin\AdminSettingsController::class, 'update']);

        // Reference data (read-only lookups + basic listings)
        Route::get('roles',           [App\Http\Controllers\Api\V1\Admin\AdminReferenceController::class, 'roles']);
        Route::get('order-statuses',  [App\Http\Controllers\Api\V1\Admin\AdminReferenceController::class, 'orderStatuses']);
        Route::get('directions',      [App\Http\Controllers\Api\V1\Admin\AdminReferenceController::class, 'directions']);
        Route::get('directions/{id}', [App\Http\Controllers\Api\V1\Admin\AdminReferenceController::class, 'direction'])->whereNumber('id');
        Route::get('gateways',        [App\Http\Controllers\Api\V1\Admin\AdminReferenceController::class, 'gateways']);
        Route::get('countries',       [App\Http\Controllers\Api\V1\Admin\AdminReferenceController::class, 'countries']);
    });

// Admin SPA at /dashboard/*. Vue Router handles sub-paths client-side.
Route::middleware(['auth', 'hasRole:admin,manager'])->group(function () {
    Route::get('/dashboard', fn () => view('dashboard.spa'))->name('dashboard.home');
    Route::get('/dashboard/{any}', fn () => view('dashboard.spa'))
        ->where('any', '.*')
        ->name('dashboard.any');
});

// Legacy path bookmark → new path. Preserves the sub-route for deep links.
Route::get('/admin-panel/{any?}', function (string $any = '') {
    return redirect('/dashboard' . ($any !== '' ? '/' . $any : ''), 301);
})->where('any', '.*')->middleware(['auth', 'hasRole:admin,manager']);
