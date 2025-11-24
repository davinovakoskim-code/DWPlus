<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Faz o Login
    public function store(Request $request)
    {
        // Valida os campos
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tenta logar usando a sessão do Laravel
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redireciona para a Home
            return redirect()->intended('/');
        }

        // Se falhar, devolve erro pro Vue
        throw ValidationException::withMessages([
            'email' => 'As credenciais fornecidas estão incorretas.',
        ]);
    }
    
    // Faz o Logout
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}