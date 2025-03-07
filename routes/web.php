<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Frontend\API\CategoryController;
use App\Http\Controllers\Frontend\API\ReportController;
use App\Http\Controllers\Frontend\API\TransactionController;
use App\Http\Controllers\Frontend\HomeController;
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


Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');

    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/{user}', [UserController::class, 'profile'])->name('index');
        Route::put('/{user}', [UserController::class, 'updateProfile'])->name('update');
        Route::put('/password-update/{user}', [UserController::class, 'updatePassword'])->name('password.update');
    });

    Route::group(['prefix' => 'transactions', 'as' => 'transactions.'], function () {
        Route::get('/', [TransactionController::class, 'getTransactions'])->name('list');
        Route::post('/', [TransactionController::class, 'store'])->name('store');
        Route::delete('/{transaction}', [TransactionController::class, 'destroy'])->name('destroy');
        Route::put('/{transaction}', [TransactionController::class, 'update'])->name('update');
        Route::get('/calculate-budget', [TransactionController::class, 'calculateBudget'])->name('calculate.budget');
    });

    Route::get('/categories', [CategoryController::class, 'getCategories'])->name('categories');
});


require __DIR__ . '/auth.php';
