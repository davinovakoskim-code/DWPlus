<?php

use EquipmentSubgroups\EquipmentSubgroupController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth.token')
    ->prefix('assets/equipment-subgroups')
    ->group(function () {
        Route::get('/', [EquipmentSubgroupController::class, 'index']);
        Route::post('/', [EquipmentSubgroupController::class, 'store']);
        Route::get('/{subgroup}', [EquipmentSubgroupController::class, 'show']);
        Route::put('/{subgroup}', [EquipmentSubgroupController::class, 'update']);
        Route::delete('/{subgroup}', [EquipmentSubgroupController::class, 'destroy']);
    });
