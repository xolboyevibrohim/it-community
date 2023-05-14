<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Post\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});
Route::group(['middleware' => 'auth:api'], function () {
    Route::prefix('auth')->group(function () {
        Route::put('refresh-token',[AuthController::class,'refreshToken']);
        Route::get('logout',[AuthController::class,'logout']);
    });
    Route::apiResource('posts', PostController::class);
    Route::get('category',[CategoryController::class,'categoryList']);
});
