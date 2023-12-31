<?php

use App\Http\Controllers\AdminPanel\CategoryController;
use App\Http\Controllers\AdminPanel\InvoiceController;
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

Route::group(['middleware' => ['auth', 'admin']], function () {

    Route::get('/', function () {
        return view('home');
    });
    Route::resource('/users', UserController::class);

    Route::resource('/categories', CategoryController::class);
    Route::resource('/types', TypeController::class);
    Route::resource('/meals', MealController::class);
    Route::post('/meal-generate', [MealController::class, 'generateImg']);
    Route::resource('/statuses', StatusController::class);

    Route::resource('/orders', OrderController::class);
    Route::post('/change-order-status/{order}', [OrderController::class, 'changeStatus'])->name('order.change-status');

    Route::get('/invoices', [InvoiceController::class, 'index']);
    Route::post('/invoices/generate', [InvoiceController::class, 'generate'])->name('invoices.generate');
});
