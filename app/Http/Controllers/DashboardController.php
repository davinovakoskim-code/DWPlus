<?php

namespace App\Http\Controllers;

use Inertia\Inertia;


class DashboardController extends Controller
{
    public function index()
    {
        

        return Inertia::render('Home', [
            'stats' => [
                'total'      => 0,
                'em_uso'     => 0,
                'disponivel' => 0,
                'manutencao' => 0,
                'rented'     => 0,
                
            ],
            'recent' => [] 
        ]);
    }
}