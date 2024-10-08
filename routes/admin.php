<?php
Route::group(['as' => '','prefix' =>'dashboard','namespace' => '', 'middleware' => ['auth', 'verified', 'isAdmin']],function(){
    
    Route::get('users', function () {
        return 123;
    });

});

/*
Route::prefix('dashboard')->group(function () {

    Route::get('/', function () {
        return view('admin.index');
    });

    Route::get('users', function () {
        return 123;
    });

    Route::get('countries', function () {
        return view('admin.countries');
    });

    Route::get('directions', function () {
        return view('admin.directions');
    });

    Route::get('products', function () {
        return view('admin.products');
    });

    Route::get('orders', function () {
        return view('admin.orders');
    });

    Route::get('articles', function () {
        return view('admin.articles');
    });

    Route::get('settings', function () {
        return view('admin.settings');
    });

})->middleware(['auth', 'verified', 'isAdmin']);
*/