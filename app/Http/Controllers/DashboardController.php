<?php

namespace App\Http\Controllers;

use Inertia\Inertia;


use Equipments\Equipment;
use Locations\Location; 


class DashboardController extends Controller
{
    public function index()
    {
        
        
        
        $totalAssets = Equipment::count();
        
        
        $emUso       = Equipment::where('status', 'Em Uso')->count();
        $disponivel  = Equipment::where('status', 'Disponível')->count();
        $manutencao  = Equipment::where('status', 'Manutenção')->count();
        
        
        $rented      = Equipment::where('is_rented', true)->count();
        
       
        $internalCount = Equipment::whereHas('location', function($q) {
            $q->where('scope', 'Interno');
        })->count();

        $externalCount = Equipment::whereHas('location', function($q) {
            $q->where('scope', 'Externo');
        })->count();

        
        $recent = Equipment::with('location')->latest()->take(5)->get();

        return Inertia::render('Home', [
            'stats' => [
                'total'      => $totalAssets,
                'em_uso'     => $emUso,
                'disponivel' => $disponivel,
                'manutencao' => $manutencao,
                'rented'     => $rented,
                'chartData'  => [$internalCount, $externalCount]
            ],
            'recent' => $recent
        ]);
    }
}