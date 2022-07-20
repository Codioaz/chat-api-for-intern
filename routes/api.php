<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\User\FollowerController;
use App\Http\Controllers\Api\User\ProfileController;
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
    Route::get('', function (){
        return ['site' => 'codio.az'];
    });

    Route::group(['as' => 'auth.', 'prefix' => 'auth'], function (){
        Route::group(['middleware' => 'auth:sanctum'], function (){
            
            Route::controller(ProfileController::class)
                ->as('profile.')
                ->prefix('profile')
                ->group(function (){
                    Route::get('','show')->name('show');
                    Route::put('','update')->name('update');
                });

            Route::controller(MessageController::class)
                ->as('message.')
                ->prefix('message')
                ->group(function (){
                    Route::get('', 'index')->name('show');
                    Route::post('', 'store')->name('store');
                    Route::get('{user:id}/user', 'show')->name('show');
                });

            Route::controller(FollowerController::class)
                ->as('user.')
                ->group(function (){
                    Route::get('pending/followers', [ FollowerController::class,'pending' ])->name('followers.pending');
                    Route::get('{user:id}/followers', [ FollowerController::class,'followers' ])->name('followers');
                    Route::get('{user:id}/following', [ FollowerController::class,'following' ])->name('following');
                    Route::post('{user:id}/follow',[ FollowerController::class, 'follow'])->name('follow');
                    Route::post('{user:id}/unfollow',[ FollowerController::class, 'unfollow'])->name('unfollow');
                    Route::post('{user:id}/follow/approve',[ FollowerController::class, 'approve'])->name('approve');
                    Route::post('{user:id}/follow/reject',[ FollowerController::class, 'reject'])->name('reject');
                    Route::post('{user:id}/follow/cancel',[ FollowerController::class, 'cancel'])->name('cancel');
                });

            Route::controller(ProfileController::class)
                ->as('user.')
                ->group(function (){
                    Route::get('{user:id}/profile', 'showProfile')->name('showProfile');
                });

        });

        Route::post('login', [ LoginController::class,'login' ])->name('login');
        Route::post('register', [ RegisterController::class,'register' ])->name('register');
    });
});
