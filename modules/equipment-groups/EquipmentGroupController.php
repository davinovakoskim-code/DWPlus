<?php

namespace EquipmentGroups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EquipmentGroupController extends Controller
{
    public function __construct(private readonly EquipmentGroupService $service) {}

    public function index(Request $request): mixed
    {
        $result = $this->service->listGroups($request->all());
        return response($result[EquipmentGroupService::RESPONSE], $result[EquipmentGroupService::HTTP_STATUS]);
    }

    public function store(EquipmentGroupRequest $request): mixed
    {
        $result = $this->service->create($request->validated());
        return response($result[EquipmentGroupService::RESPONSE], $result[EquipmentGroupService::HTTP_STATUS]);
    }

    public function show(EquipmentGroup $group): mixed
    {
        $result = $this->service->show($group);
        return response($result[EquipmentGroupService::RESPONSE], $result[EquipmentGroupService::HTTP_STATUS]);
    }

    public function update(EquipmentGroupRequest $request, EquipmentGroup $group): mixed
    {
        $result = $this->service->update($group, $request->validated());
        return response($result[EquipmentGroupService::RESPONSE], $result[EquipmentGroupService::HTTP_STATUS]);
    }

    public function destroy(EquipmentGroup $group): mixed
    {
        $result = $this->service->delete($group);
        return response($result[EquipmentGroupService::RESPONSE], $result[EquipmentGroupService::HTTP_STATUS]);
    }
}
