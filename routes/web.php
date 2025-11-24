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