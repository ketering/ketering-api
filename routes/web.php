<?php

use App\Http\Controllers\AdminPanel\CategoryController;
use App\Http\Controllers\AdminPanel\MealController;
use App\Http\Controllers\AdminPanel\OrderController;
use App\Http\Controllers\AdminPanel\StatusController;
use App\Http\Controllers\AdminPanel\TypeController;
use App\Http\Controllers\AdminPanel\UserController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
})->name('home')->middleware('auth');

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::resource('/users', UserController::class);

    Route::resource('/categories', CategoryController::class);
    Route::resource('/types', TypeController::class);
    Route::resource('/meals', MealController::class);
    Route::resource('/statuses', StatusController::class);

    Route::resource('/orders', OrderController::class);
    Route::post('/change-order-status/{order}', [OrderController::class, 'changeStatus'])->name('order.change-status');
});
