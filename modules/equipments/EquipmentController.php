<?php

namespace Equipments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function __construct(private readonly EquipmentService $equipmentService) {}

    public function index(Request $request): mixed
    {
        $result = $this->equipmentService->listEquipments($request->all());
        return response($result[EquipmentService::RESPONSE], $result[EquipmentService::HTTP_STATUS]);
    }

    public function store(EquipmentRequest $request): mixed
    {
        $result = $this->equipmentService->create($request->validated());
        return response($result[EquipmentService::RESPONSE], $result[EquipmentService::HTTP_STATUS]);
    }

    public function show(Equipment $equipment): mixed
    {
        $result = $this->equipmentService->show($equipment);
        return response($result[EquipmentService::RESPONSE], $result[EquipmentService::HTTP_STATUS]);
    }

    public function update(EquipmentRequest $request, Equipment $equipment): mixed
    {
        $result = $this->equipmentService->update($equipment, $request->validated());
        return response($result[EquipmentService::RESPONSE], $result[EquipmentService::HTTP_STATUS]);
    }

    public function destroy(Equipment $equipment): mixed
    {
        $result = $this->equipmentService->delete($equipment);
        return response($result[EquipmentService::RESPONSE], $result[EquipmentService::HTTP_STATUS]);
    }
}
