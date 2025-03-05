<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ProfileController;
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
    Route::get('/profile/{user}', [ProfileController::class, 'profile'])->name('profile.index');
    Route::put('/profile/{user}', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/password-update/{user}', [ProfileController::class, 'updatePassword'])->name('user.password.update');
    Route::get('/categories', [CategoryController::class, 'getCategories'])->name('categories');
    Route::get('/transactions', [TransactionController::class, 'list'])->name('transactions.list');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
    Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::get('/calculate/total-balance', [TransactionController::class, 'calculateTotalBalance'])->name('transactions.calculate.total-balance');
    Route::post('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
});


require __DIR__ . '/auth.php';
