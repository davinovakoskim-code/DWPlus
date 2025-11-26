<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
// Comentamos a importação do Modelo para ele não tentar buscar o arquivo se ainda estiver com erro
// use Modules\Equipments\Equipment;

class DashboardController extends Controller
{
    public function index()
    {
        // --- VERSÃO TEMPORÁRIA (SEGURA) ---
        // Como o Home.vue está usando dados fake locais,
        // aqui nós só precisamos mandar a estrutura básica zerada
        // para o Inertia não reclamar que faltam propriedades.

        return Inertia::render('Home', [
            'stats' => [
                'total'      => 0,
                'em_uso'     => 0,
                'disponivel' => 0,
                'manutencao' => 0,
                'rented'     => 0,
                // 'chartData' => [0, 0] // Se seu front esperar isso
            ],
            'recent' => [] // Manda um array vazio para não quebrar o loop
        ]);
    }
}