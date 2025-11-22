<?php

use EquipmentGroups\EquipmentGroupController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth.token')
    ->prefix('assets/equipment-groups')
    ->group(function () {
        Route::get('/', [EquipmentGroupController::class, 'index']);
        Route::post('/', [EquipmentGroupController::class, 'store']);
        Route::get('/{group}', [EquipmentGroupController::class, 'show']);
        Route::put('/{group}', [EquipmentGroupController::class, 'update']);
        Route::delete('/{group}', [EquipmentGroupController::class, 'destroy']);
    });
