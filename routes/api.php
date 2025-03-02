<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

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

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum']], function () {
    Route::resource('users', AdminUserController::class)->except(['create', 'store', 'edit']);
    Route::resource('orders', AdminOrderController::class)->except(['create', 'edit']);
});

Route::group(['middleware' => 'guest'], function () {
    $limiter = config('auth.limiters.login');

    Route::post('login', [ AuthController::class, 'login' ])->middleware(
        array_filter([$limiter ? 'throttle:' . $limiter : null])
    )->name('login');
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('register', [ AuthController::class, 'register' ])
        ->name('register');

    Route::post('logout', [ AuthController::class, 'logout' ])
        ->name('logout');

    Route::get('user', [ AuthController::class, 'user' ])
        ->name('user');

    Route::post('uploadPhoto', [ UserController::class, 'uploadPhoto' ])
        ->name('uploadPhoto');

    Route::post('removePhoto', [ UserController::class, 'destroyPhoto' ])
        ->name('destroyPhoto');

    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('', [ ProfileController::class, 'index' ])
            ->name('index');
        Route::put('update', [ ProfileController::class, 'update' ])
            ->name('update');
        Route::delete('delete', [ ProfileController::class, 'update' ])
            ->name('delete');
    });

});
