<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CountryController;
use App\Http\Controllers\Api\V1\DirectionController;
use App\Http\Controllers\Api\V1\ArticleController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\AccountController;
use App\Http\Controllers\Api\V1\SiteGlobalsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| api/v1   - SPA endpoints
| rest     - Webhooks (empty for now)
| web      - HTTP requests (blade templates)
|
*/

Route::prefix('v1')->group(function () {

    // --- Public routes ---

    // Auth
    Route::post('auth/register', [AuthController::class, 'register']);
    Route::post('auth/login', [AuthController::class, 'login']);

    // Countries
    Route::get('countries', [CountryController::class, 'index']);
    Route::get('countries/{slug}', [CountryController::class, 'show']);
    Route::get('countries/{slug}/products', [CountryController::class, 'products']);

    // Directions
    Route::get('directions/search', [DirectionController::class, 'search']);

    // Articles
    Route::get('articles', [ArticleController::class, 'index']);
    Route::get('articles/{slug}', [ArticleController::class, 'show']);

    // Site globals
    Route::get('languages', [SiteGlobalsController::class, 'languages']);
    Route::get('currencies', [SiteGlobalsController::class, 'currencies']);
    Route::get('site/bootstrap', [SiteGlobalsController::class, 'bootstrap']);

    // Order preview (public, by hash)
    Route::get('orders/preview/{order_hash}', [OrderController::class, 'preview']);

    // --- Authenticated routes ---

    Route::middleware('auth:sanctum')->group(function () {

        // Auth
        Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::get('auth/user', [AuthController::class, 'user']);

        // Account
        Route::get('account', [AccountController::class, 'index']);
        Route::get('account/settings', [AccountController::class, 'settings']);
        Route::put('account/settings', [AccountController::class, 'updateSettings']);

        // Orders
        Route::get('orders', [OrderController::class, 'index']);
        Route::get('orders/{order_id}', [OrderController::class, 'show'])
            ->whereNumber('order_id');

        // Order trip details
        Route::get('orders/{order_id}/trip', [OrderController::class, 'tripDetails']);
        Route::put('orders/{order_id}/trip', [OrderController::class, 'updateTripDetails']);

        // Order documents
        Route::get('orders/{order_id}/documents', [OrderController::class, 'documents']);

        // Applicant sections
        Route::prefix('orders/{order_id}/applicants/{applicant_id}')->group(function () {

            // Documents
            Route::get('documents', [OrderController::class, 'applicantDocuments']);
            Route::post('documents', [OrderController::class, 'storeApplicantDocuments']);
            Route::delete('documents/{document_id}', [OrderController::class, 'deleteApplicantDocument']);

            // Fields
            Route::post('fields', [OrderController::class, 'updateApplicantFields']);

            // Personal
            Route::get('personal', [OrderController::class, 'applicantPersonal']);
            Route::put('personal', [OrderController::class, 'updateApplicantPersonal']);

            // Passport
            Route::get('passport', [OrderController::class, 'applicantPassport']);
            Route::put('passport', [OrderController::class, 'updateApplicantPassport']);

            // Family
            Route::get('family', [OrderController::class, 'applicantFamily']);
            Route::put('family', [OrderController::class, 'updateApplicantFamily']);

            // Past travel
            Route::get('past-travel', [OrderController::class, 'applicantPastTravel']);
            Route::put('past-travel', [OrderController::class, 'updateApplicantPastTravel']);

            // Declarations
            Route::get('declarations', [OrderController::class, 'applicantDeclarations']);
            Route::put('declarations', [OrderController::class, 'updateApplicantDeclarations']);
        });
    });
});

// --- Webhook routes (empty for now) ---

Route::prefix('rest')->group(function () {
    // Webhooks will go here
});
