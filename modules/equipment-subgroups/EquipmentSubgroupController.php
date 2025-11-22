<?php

namespace EquipmentSubgroups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EquipmentSubgroupController extends Controller
{
    public function __construct(private readonly EquipmentSubgroupService $service) {}

    public function index(Request $request): mixed
    {
        $result = $this->service->listSubgroups($request->all());
        return response($result[EquipmentSubgroupService::RESPONSE], $result[EquipmentSubgroupService::HTTP_STATUS]);
    }

    public function store(EquipmentSubgroupRequest $request): mixed
    {
        $result = $this->service->create($request->validated());
        return response($result[EquipmentSubgroupService::RESPONSE], $result[EquipmentSubgroupService::HTTP_STATUS]);
    }

    public function show(EquipmentSubgroup $subgroup): mixed
    {
        $result = $this->service->show($subgroup);
        return response($result[EquipmentSubgroupService::RESPONSE], $result[EquipmentSubgroupService::HTTP_STATUS]);
    }

    public function update(EquipmentSubgroupRequest $request, EquipmentSubgroup $subgroup): mixed
    {
        $result = $this->service->update($subgroup, $request->validated());
        return response($result[EquipmentSubgroupService::RESPONSE], $result[EquipmentSubgroupService::HTTP_STATUS]);
    }

    public function destroy(EquipmentSubgroup $subgroup): mixed
    {
        $result = $this->service->delete($subgroup);
        return response($result[EquipmentSubgroupService::RESPONSE], $result[EquipmentSubgroupService::HTTP_STATUS]);
    }
}
