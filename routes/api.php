<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\MealController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\TypeController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Http\Request;
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

Route::group(["middleware" => 'check.token'], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login')->name('api-login');
        Route::post('register', 'register')->name('api-register');
    });
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('api-password.reset');
});

Route::group(["middleware" => 'auth:sanctum'], function () {

    Route::controller(AuthController::class)->group(function () {
        Route::post('logout', 'logout')->name('api-logout');
    });

    Route::controller(CategoryController::class)->group(function () {
        Route::get('/categories', 'index');
        Route::get('/categories/{category}', 'show');
    });

    Route::controller(TypeController::class)->group(function () {
        Route::get('/types', 'index');
        Route::post('/types/filter', 'show');
    });

    Route::controller(MealController::class)->group(function () {
        Route::post('/meals', 'index');
        Route::get('/meals/{meal}', 'show');
    });

    Route::controller(OrderController::class)->group(function () {
        Route::get('/orders', 'index');
        Route::post('/orders/store', 'store');
        Route::get('/orders/{order}', 'show');
        Route::post('/orders/{order}/rate', 'rate');
    });
});
