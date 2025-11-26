<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

// --- VOLTANDO AO MODO ANTIGO ---
// Usando os namespaces diretos conforme sua configuração original
use Equipments\Equipment;
use Equipments\EquipmentService;
use Locations\Location;
use Departments\Department;
use EquipmentGroups\EquipmentGroup;
use EquipmentSubgroups\EquipmentSubgroup;
// -------------------------------

class EquipmentController extends Controller
{

    public function __construct(
        protected EquipmentService $equipmentService
    ) {}


    public function index()
    {
        $equipments = Equipment::with(['location', 'department', 'group', 'subgroup'])->latest()->get();

        return Inertia::render('Equipments/Index', [
            'equipments' => $equipments
        ]);
    }

    public function create()
    {
        return Inertia::render('Equipments/Create', [
            'locations'   => Location::select('id', 'name', 'scope')->orderBy('name')->get(),
            'departments' => Department::select('id', 'name')->orderBy('name')->get(),
            'groups'      => EquipmentGroup::select('id', 'name')->orderBy('name')->get(),
            'subgroups'   => EquipmentSubgroup::select('id', 'name', 'group_id')->orderBy('name')->get(),
        ]);
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'asset_code'          => 'required|max:50|unique:equipments,asset_code',
            'name'                => 'required|max:180',
            'description'         => 'nullable',
            'location_id'         => 'nullable|integer',
            'department_id'       => 'nullable|integer',
            'group_id'            => 'nullable|integer',
            'subgroup_id'         => 'nullable|integer',
            'status'              => 'required|max:30',
            'is_rented'           => 'boolean',
            'attachment_filename' => 'nullable'
        ]);


        if ($request->hasFile('attachment_filename')) {
            $path = $request->file('attachment_filename')->store('equipments', 'public');
            $data['attachment_filename'] = $path;
        }


        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();


        // Chama o serviço (usando o namespace antigo que funciona pra você)
        $this->equipmentService->create($data);


        // SEM DD AQUI. Redireciona para a listagem.
        return redirect()->route('equipments.index')->with('message', 'Equipamento cadastrado com sucesso!');
    }


    public function show(Equipment $equipment)
    {
        $equipment->load(['location', 'department', 'group', 'subgroup', 'creator']);


        $imageUrl = $equipment->attachment_filename
            ? Storage::url($equipment->attachment_filename)
            : null;

        return Inertia::render('Equipments/Show', [
            'equipment' => $equipment,
            'image_url' => $imageUrl
        ]);
    }


    public function edit(Equipment $equipment)
    {
        return Inertia::render('Equipments/Edit', [
            'equipment'   => $equipment,
            'locations'   => Location::select('id', 'name', 'scope')->orderBy('name')->get(),
            'departments' => Department::select('id', 'name')->orderBy('name')->get(),
            'groups'      => EquipmentGroup::select('id', 'name')->orderBy('name')->get(),
            'subgroups'   => EquipmentSubgroup::select('id', 'name', 'group_id')->orderBy('name')->get(),
        ]);
    }


    public function update(Request $request, Equipment $equipment)
    {
        $data = $request->validate([
            'asset_code'          => 'required|max:50|unique:equipments,asset_code,' . $equipment->id,
            'name'                => 'required|max:180',
            'description'         => 'nullable',
            'location_id'         => 'nullable|integer',
            'department_id'       => 'nullable|integer',
            'group_id'            => 'nullable|integer',
            'subgroup_id'         => 'nullable|integer',
            'status'              => 'required|max:30',
            'is_rented'           => 'boolean',
            'attachment_filename' => 'nullable'
        ]);

        if ($request->hasFile('attachment_filename')) {
            $data['attachment_filename'] = $request->file('attachment_filename')->store('equipments', 'public');
        }

        $data['updated_by'] = auth()->id();

        $this->equipmentService->update($equipment, $data);

        return redirect()->route('equipments.index')->with('message', 'Equipamento atualizado com sucesso!');
    }


    public function destroy(Equipment $equipment)
    {
        $this->equipmentService->delete($equipment);

        return redirect()->route('equipments.index')->with('message', 'Equipamento excluído com sucesso!');
    }
}