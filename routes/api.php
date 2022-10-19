<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Friend\FriendController;
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
        Route::get('/logout', [AuthController::class, 'logout'])->name('user.logout');
        Route::post('/me',[UserController::class, 'me'])->name('user.me');
        Route::post('/avatar', [UserController::class, 'avatar'])->name('user.avatar');
    });
});

Route::prefix('/friend')->group(function () {
    Route::middleware('auth:api')->group(function(){
        Route::get('/reject/list', [FriendController::class, 'rejectList'])->name('friend.rejectList');
        Route::get('/list', [FriendController::class, 'list'])->name('friend.list');
        Route::post('/accept', [FriendController::class, 'accept'])->name('friend.accept');
        Route::post('/reject', [FriendController::class, 'reject'])->name('friend.reject');
        Route::post('/add', [FriendController::class, 'add'])->name('friend.add');
        Route::post('/del', [FriendController::class, 'del'])->name('friend.del');
    });
});

