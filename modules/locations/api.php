<?php

use Illuminate\Support\Facades\Route;
use Locations\LocationController;

Route::middleware('auth.token')
    ->prefix('assets/locations')
    ->group(function () {
        Route::get('/', [LocationController::class, 'index']);
        Route::post('/', [LocationController::class, 'store']);
        Route::get('/{location}', [LocationController::class, 'show']);
        Route::put('/{location}', [LocationController::class, 'update']);
        Route::delete('/{location}', [LocationController::class, 'destroy']);
    });
