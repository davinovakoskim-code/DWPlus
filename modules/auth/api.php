<?php

use Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login',    [AuthController::class, 'login']);

    Route::middleware('auth.token')->group(function () {
        Route::get('me',    [AuthController::class, 'me']);
        Route::post('logout',[AuthController::class, 'logout']);
    });
});
