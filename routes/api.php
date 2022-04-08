<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\FirebaseController;
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

Route::group(['prefix' => 'admin', 'middleware' => 'auth:sanctum'], function () {
    Route::resource('user', AdminUserController::class)->except(['create', 'store', 'edit']);
    Route::resource('orders', AdminOrderController::class)->except(['create', 'edit']);
});

Route::middleware('guest')->group(
    function () {
        $limiter = config('auth.limiters.login');

        Route::post('login', [ AuthController::class, 'login' ])->middleware(
            array_filter([$limiter ? 'throttle:' . $limiter : null])
        );
    }
);


Route::middleware('auth:sanctum')->group(
    function () {
        Route::post('register', [ AuthController::class, 'register' ]);

        Route::post('logout', [ AuthController::class, 'logout' ]);

        Route::get('user', [ AuthController::class, 'user' ]);
    }
);

//Route::get('firebase', [FirebaseController::class, 'index']);
//Route::get('firebase/create', [FirebaseController::class, 'create']);
//Route::get('firebase/delete', [FirebaseController::class, 'delete']);
