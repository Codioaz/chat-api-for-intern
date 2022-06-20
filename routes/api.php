<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\ProfileController;
use App\Http\Controllers\Api\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([ 'prefix' => 'v1','as' => 'v1.'], function () {
    Route::group(['as' => 'auth.', 'prefix' => 'auth'], function (){
        Route::group(['middleware' => 'auth:sanctum'], function (){
            Route::get('profile', [ ProfileController::class,'show' ])->name('profile.show');
            Route::put('profile', [ ProfileController::class,'update' ])->name('profile.update');
        });

        Route::post('login', [ LoginController::class,'login' ])->name('login');
        Route::post('register', [ RegisterController::class,'register' ])->name('register');
    });
});
