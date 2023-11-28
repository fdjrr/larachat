<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;

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

Route::prefix('auth')->middleware(['guest'])->controller(AuthController::class)->group(function () {
    Route::get('login', 'login')->name('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', [MessageController::class, 'index'])->name('messages');
});
