<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureAuth;
use App\Http\Middleware\SessionMiddleware;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware(SessionMiddleware::class)->group(function () {

    Route::view("/register","register")->name("register");
    Route::post("/register", [RegisterController::class, "register_post"])->name("register_post");

    Route::view("/login", "login")->name("login");
    Route::post("/login", [LoginController::class, "login_post"])->name("login_post");
});

Route::middleware(EnsureAuth::class)->group( function () {
    Route::get('/profile', [ProfileController::class, "profile"])->name("profile");

    Route::get("/logout", function () {
        Auth::logout();
        return redirect("login");
    });

    Route::get('d{any}', function ($any) {
        return redirect("profile");
    })->where('any', '.*');
});

