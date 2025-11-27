<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| ROTAS PÚBLICAS
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return Inertia::render('Auth/Login');
    })->name('login');

    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});


 //ROTAS PROTEGIDAS

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

    // --- HOME / DASHBOARD ---
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    //USER
    Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
    Route::get('/usuarios/criar', [UserController::class, 'create'])->name('users.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('users.store');
    Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // --- EQUIPAMENTOS ---
    Route::get('/equipamentos', [EquipmentController::class, 'index'])->name('equipments.index');
    Route::get('/equipamentos/criar', [EquipmentController::class, 'create'])->name('equipments.create');
    Route::post('/equipamentos', [EquipmentController::class, 'store'])->name('equipments.store');
    Route::get('/equipamentos/{equipment}', [EquipmentController::class, 'show'])->name('equipments.show');
    Route::get('/equipamentos/{equipment}/editar', [EquipmentController::class, 'edit'])->name('equipments.edit');
    Route::put('/equipamentos/{equipment}', [EquipmentController::class, 'update'])->name('equipments.update');
    Route::delete('/equipamentos/{equipment}', [EquipmentController::class, 'destroy'])->name('equipments.destroy');

    // --- LOCAIS ---
    Route::get('/locais', [LocationController::class, 'index'])->name('locations.index');
    Route::get('/locais/criar', [LocationController::class, 'create'])->name('locations.create');
    Route::post('/locais', [LocationController::class, 'store'])->name('locations.store');
    Route::get('/locais/{location}/editar', [LocationController::class, 'edit'])->name('locations.edit');
    Route::put('/locais/{location}', [LocationController::class, 'update'])->name('locations.update');
    Route::delete('/locais/{location}', [LocationController::class, 'destroy'])->name('locations.destroy');

});