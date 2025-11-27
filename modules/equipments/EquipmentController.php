<?php

namespace Modules\Equipments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Modules\Departments\Department;
use Modules\EquipmentGroups\EquipmentGroup;
use Modules\EquipmentSubgroups\EquipmentSubgroup;
use Modules\Locations\Location;

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
            'attachment_filename' => 'nullable|file|image|max:5120' 
        ]);

        
        if ($request->hasFile('attachment_filename')) {
            $path = $request->file('attachment_filename')->store('equipments', 'public');
            $data['attachment_filename'] = $path;
        }

        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        $this->equipmentService->create($data);

        
        return redirect()->route('equipments.index')->with('message', 'Equipamento cadastrado com sucesso!');
    }

    public function show($id)
    {
        $equipment = Equipment::with(['location', 'department', 'group', 'subgroup', 'creator', 'updater'])->findOrFail($id);

        
        $imageUrl = null;
        if ($equipment->attachment_filename && Storage::disk('public')->exists($equipment->attachment_filename)) {
            $imageUrl = Storage::url($equipment->attachment_filename);
        }

        return Inertia::render('Equipments/Show', [
            'equipment' => $equipment,
            'image_url' => $imageUrl,
        ]);
    }

    public function edit($id)
    {
        $equipment = Equipment::findOrFail($id);

        return Inertia::render('Equipments/Edit', [
            'equipment'   => $equipment,
            'locations'   => Location::select('id', 'name', 'scope')->orderBy('name')->get(),
            'departments' => Department::select('id', 'name')->orderBy('name')->get(),
            'groups'      => EquipmentGroup::select('id', 'name')->orderBy('name')->get(),
            'subgroups'   => EquipmentSubgroup::select('id', 'name', 'group_id')->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $equipment = Equipment::findOrFail($id);

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
            
            if ($equipment->attachment_filename && Storage::disk('public')->exists($equipment->attachment_filename)) {
                Storage::disk('public')->delete($equipment->attachment_filename);
            }

           
            $path = $request->file('attachment_filename')->store('equipments', 'public');

            
            $data['attachment_filename'] = $path;
        } else {
            
            unset($data['attachment_filename']);
        }
        

        $data['updated_by'] = auth()->id();

        $this->equipmentService->update($equipment, $data);

        
        return redirect()->route('equipments.index')->with('message', 'Equipamento atualizado com sucesso!');
    }

    public function destroy(Equipment $equipment)
    {
        
        if ($equipment->attachment_filename && Storage::disk('public')->exists($equipment->attachment_filename)) {
            Storage::disk('public')->delete($equipment->attachment_filename);
        }

        $this->equipmentService->delete($equipment);

        return redirect()->route('equipments.index')->with('message', 'Equipamento excluído com sucesso!');
    }
}