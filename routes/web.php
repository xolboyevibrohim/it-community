<?php

use App\Http\Controllers\web\AuthController;
use App\Http\Controllers\web\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (auth()->check()){
        return redirect()->route('home');
    }else{
        return redirect()->route('login');
    }
});
Route::get('login', [AuthController::class, 'loginForm'])->name('login.form');
Route::get('register', [AuthController::class, 'registerPage'])->name('register.form');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::group(['middleware' => 'auth'],function(){
    Route::get('logout',[AuthController::class,'logout']);
    Route::get('home', [AuthController::class, 'homePage'])->name('home');
    Route::get('post/create', [PostController::class, 'postPage'])->name('post');
    Route::post('post/create', [PostController::class, 'postCreate'])->name('post.create');
    Route::get('post/{post_id}', [PostController::class, 'show'])->name('post.show');
    Route::get('my-posts', [PostController::class, 'myPosts'])->name('post.show');

});

