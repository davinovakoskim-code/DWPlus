<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Equipments\Equipment;        // O Model (para leitura rápida no Index)
use Equipments\EquipmentService; // O Serviço (para salvar com as regras do seu amigo)

class EquipmentController extends Controller
{
    // 1. CONSTRUTOR: Injetamos o serviço aqui para poder usar no 'store'
    public function __construct(
        protected EquipmentService $equipmentService
    ) {}

    // 2. TELA: LISTAGEM (Index)
    public function index()
    {
        // Busca os equipamentos ordenados do mais novo pro antigo
        $equipments = Equipment::latest()->get(); 

        return Inertia::render('Equipments/Index', [
            'equipments' => $equipments
        ]);
    }

    // 3. TELA: FORMULÁRIO DE CADASTRO (Create)
    public function create()
    {
        return Inertia::render('Equipments/Create', [
            // Mandamos arrays vazios por enquanto para os selects não quebrarem.
            // Futuramente, aqui você vai colocar: Location::all(), Department::all(), etc.
            'locations' => [],
            'departments' => [],
            'subgroups' => []
        ]);
    }

    // 4. AÇÃO: SALVAR NO BANCO (Store)
    public function store(Request $request)
    {
        // Validação dos dados vindos do formulário
        $data = $request->validate([
            'asset_code' => 'required', // Código do patrimônio
            'name' => 'required',
            'description' => 'nullable',
            'location_id' => 'nullable',
            'department_id' => 'nullable',
            'subgroup_id' => 'nullable',
            'status' => 'required',
            'rented' => 'boolean',
            'attachment_filename' => 'nullable'
        ]);

        // MÁGICA: Chamamos o serviço do seu amigo para salvar
        // Ele pega o array $data e faz o insert no banco
        $this->equipmentService->create($data);

        // Redireciona de volta para a lista de equipamentos
        return redirect()->route('equipments.index');
    }
}