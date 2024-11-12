<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\IndexController;
use App\Http\Controllers\User\CountryController;
use App\Http\Controllers\User\ArticleController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\User\AccountController;
use App\Http\Controllers\User\SiteGlobalsController;
use App\Http\Controllers\FileController;


// Index page
Route::get('/', [IndexController::class, 'index'])->name('web.index');
Route::post('/', [IndexController::class, 'directionApply'])->name('web.direction.apply');

// Countries
Route::get('/country/{country}', [CountryController::class, 'index'])->name('web.country.index');
Route::get('/country/{country}/apply-now', [CountryController::class, 'apply'])->name('web.country.apply');

// Orders processing
Route::post('/orders/create-apply', [OrderController::class, 'createApply'])->name('web.order.create-apply');
Route::get('/orders/{order_hash}', [OrderController::class, 'showPreview'])->name('web.order.show');
Route::post('/orders/{order_hash}/pay', [OrderController::class, 'pay'])->name('web.order.pay');

// Site settings controller
Route::post('/set-lang', [SiteGlobalsController::class, 'setLanguage'])->name('web.language.set');
Route::post('/set-currency', [SiteGlobalsController::class, 'setCurrency'])->name('web.currency.set');

// Account
Route::group(['as' => '','prefix' =>'account','namespace' => '', 'middleware' => ['auth']],function(){

    // User account
    Route::get('/', [AccountController::class, 'index'])->name('web.account.index');
    Route::get('/settings/', [AccountController::class, 'settings'])->name('web.account.settings');
    Route::post('/settings/', [AccountController::class, 'settingsUpdate'])->name('web.account.settings.update');
    
    // Orders list
    Route::get('/orders/', [OrderController::class, 'index'])->name('web.account.orders');

    // Order details
    Route::group(['as' => '','prefix' =>'/order/{order_id}','namespace' => '', 'middleware' => ['auth', 'isUserOrder', 'isOrderPaid']],function(){

        Route::get('/', [OrderController::class, 'show'])->name('web.account.order');
        Route::get('/trip', [OrderController::class, 'tripDetails'])->name('web.account.order.trip');
        Route::post('/trip', [OrderController::class, 'tripDetailsUpdate'])->name('web.account.order.trip.update');
        Route::get('/documents', [OrderController::class, 'documents'])->name('web.account.order.documents');

        // Applicants
        for($i = 1; $i <= 15; $i++) {

            // Documents
            Route::get('/applicant/{applicant_id}/documents', [OrderController::class, 'applicantDocuments'])->name('web.account.order.applicant.documents');
            Route::post('/applicant/{applicant_id}/documents', [OrderController::class, 'applicantDocumentsUpdate'])->name('web.account.order.applicant.documents.store');

            // Document single
            Route::delete('/applicant/{applicant_id}/document/{document_id}', [OrderController::class, 'applicantDocumentDelete'])->name('web.account.order.applicant.document.delete');

            // Fields update
            Route::post('/applicant/{applicant_id}/fields', [OrderController::class, 'applicantFieldsUpdate'])->name('web.account.order.applicant.fields.update');
            
            // Personal
            Route::get('/applicant/{applicant_id}/personal', [OrderController::class, 'applicantPersonal'])->name('web.account.order.applicant.personal');
            Route::post('/applicant/{applicant_id}/personal', [OrderController::class, 'applicantPersonalUpdate'])->name('web.account.order.applicant.personal');

            // Passport
            Route::get('/applicant/{applicant_id}/passport', [OrderController::class, 'applicantPassport'])->name('web.account.order.applicant.passport');
            Route::post('/applicant/{applicant_id}/passport', [OrderController::class, 'applicantPassportUpdate'])->name('web.account.order.applicant.passport');

            // Family
            Route::get('/applicant/{applicant_id}/family', [OrderController::class, 'applicantFamily'])->name('web.account.order.applicant.family');
            Route::post('/applicant/{applicant_id}/family', [OrderController::class, 'applicantFamilyUpdate'])->name('web.account.order.applicant.family');

            // Past travel
            Route::get('/applicant/{applicant_id}/past-travel', [OrderController::class, 'applicantPastTravel'])->name('web.account.order.applicant.past-travel');
            Route::post('/applicant/{applicant_id}/past-travel', [OrderController::class, 'applicantPastTravelUpdate'])->name('web.account.order.applicant.past-travel');

            // Declarations
            Route::get('/applicant/{applicant_id}/declarations', [OrderController::class, 'applicantDeclarations'])->name('web.account.order.applicant.declarations');
            Route::post('/applicant/{applicant_id}/declarations', [OrderController::class, 'applicantDeclarationsUpdate'])->name('web.account.order.applicant.declarations');
        
        }

    });

});


// Articles
Route::get('/articles', [ArticleController::class, 'index'])->name('web.articles.index');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('web.articles.show');

// Payment
Route::post('charge', [PaymentController::class, 'charge'])->name('charge');

// Files
Route::get('file/{file}', [FileController::class, 'download'])->name('file.download');


