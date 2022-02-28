<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

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

Route::middleware('auth.basic')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken('admin@admin.com'); //!hardcoded $request->token_name

    return ['token' => $token->plainTextToken];
})->middleware('auth.basic');

Route::get('/orders/all', [AdminOrderController::class, 'index']);
Route::get('/orders/{orderID}/{courierID}/', [AdminOrderController::class, 'update']);
