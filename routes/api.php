<?php

use App\Http\Controllers\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;

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

Route::prefix('v1')->group(function () {
    Route::middleware(['guest'])->group(function () {
        Route::prefix('auth')->controller(AuthController::class)->group(function () {
            Route::post('login', 'login');
        });
    });

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::prefix('messages')->controller(MessageController::class)->group(function () {
            Route::get('load/{roomId}', 'loadMessage');
            Route::post('save', 'saveMessage');
        });

        Route::prefix('rooms')->controller(RoomController::class)->group(function () {
            Route::post('create', 'create');
        });
    });
});
