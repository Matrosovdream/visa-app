<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Manager\IndexController;

Route::group(['as' => '','prefix' =>'manager','namespace' => '', 'middleware' => ['auth', 'verified', 'isAdmin']],function(){

    // Index page
    Route::get('/', [IndexController::class, 'index'])->name('manager.index');

});