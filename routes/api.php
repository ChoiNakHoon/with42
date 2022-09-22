<?php

use App\Http\Controllers\Auth\AuthController;
use \App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('/auth')->group(function () {
    Route::get('/token',[AuthController::class,'createToken'])->name('user.createToken');
});

Route::prefix('/user')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('user.register');
    Route::post('/login', [AuthController::class, 'login'])->name('user.login');
    Route::middleware('auth:api')->group(function() {
        Route::post('/me',[UserController::class, 'me'])->name('user.me');
    });
});
