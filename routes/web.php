<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Rota da Home que criamos antes
Route::get('/', function () {
    return Inertia::render('Home');
});

// --- NOVA ROTA DE LOGIN ---
Route::get('/login', function () {
    // Note o caminho: Auth/Login (pasta/arquivo)
    return Inertia::render('Auth/Login');
})->name('login');

use App\Http\Controllers\AuthController;

// Rota que recebe o POST do formulário de login
Route::post('/login', [AuthController::class, 'store'])->name('login.store');

// Rota de sair
Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

// Rota para a lista de equipamentos
Route::get('/equipamentos', [App\Http\Controllers\EquipmentController::class, 'index'])->name('equipments.index');

use App\Http\Controllers\EquipmentController;

// Listagem (já existia)
Route::get('/equipamentos', [EquipmentController::class, 'index'])->name('equipments.index');

// Formulário de Criação (NOVA)
Route::get('/equipamentos/criar', [EquipmentController::class, 'create'])->name('equipments.create');

// Salvar no Banco (NOVA)
Route::post('/equipamentos', [EquipmentController::class, 'store'])->name('equipments.store');