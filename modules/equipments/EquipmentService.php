<?php

namespace Equipments;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Kascat\EasyModule\Core\Service; 
use Throwable;

class EquipmentService extends Service
{
    /**
     * @param array $filters
     * @return array{response: Collection<int, Equipment>|LengthAwarePaginator, status:int}
     */
    public function listEquipments(array $filters = []): array
    {
        $query = Equipment::query()->with([
            'subgroup.group',
            'department',
            'location',
        ])->orderBy(Equipment::NAME);

        $query = $this->applyFilters($query, $filters);

        
        $perPage = (int) ($filters[self::PER_PAGE] ?? 0);
        if ($perPage > 0) {
            $paginator = $query->paginate($perPage)->appends(Arr::except($filters, [self::PER_PAGE]));
            return self::buildReturn($paginator);
        }

        return self::buildReturn($query->get());
    }

    public function show(Equipment $equipment): array
    {
        $equipment->load(['subgroup.group', 'department', 'location']);
        return self::buildReturn($equipment);
    }

    public function create(array $data): array
    {
        
        $data = $this->normalizePayload($data);

        DB::beginTransaction();

        try {
            /** @var Equipment $equipment */
            $equipment = Equipment::create($data);
            
            
            if ($equipment->subgroup_id) $equipment->load('subgroup.group');
            if ($equipment->department_id) $equipment->load('department');
            if ($equipment->location_id) $equipment->load('location');

            DB::commit();

            return self::buildReturn($equipment, 201);
        
        } catch (Throwable $exception) {
            DB::rollBack();

           
            Log::error('EquipmentService: error while creating equipment', [
                'message' => $exception->getMessage(),
                'namespace' => __CLASS__,
            ]);
            report($exception);

            return self::buildReturn(['message' => 'Falha ao cadastrar patrimônio: ' . $exception->getMessage()], 500);
        }
    }

    public function update(Equipment $equipment, array $data): array
    {
        $data = $this->normalizePayload($data);

        DB::beginTransaction();

        try {
            $equipment->fill($data);
            $equipment->save();
            
            if ($equipment->subgroup_id) $equipment->load('subgroup.group');
            
            DB::commit();

            return self::buildReturn($equipment);
        } catch (Throwable $exception) {
            DB::rollBack();

            Log::error('EquipmentService: error while updating equipment', [
                'message' => $exception->getMessage(),
                'namespace' => __CLASS__,
                'equipment_id' => $equipment->id,
            ]);
            report($exception);

            return self::buildReturn(['message' => 'Falha ao atualizar patrimônio'], 500);
        }
    }

    public function delete(Equipment $equipment): array
    {
        DB::beginTransaction();

        try {
            $equipment->delete();

            DB::commit();

            return self::buildReturn(status: 204);
        } catch (Throwable $exception) {
            DB::rollBack();

            Log::error('EquipmentService: error while deleting equipment', [
                'message' => $exception->getMessage(),
                'namespace' => __CLASS__,
                'equipment_id' => $equipment->id,
            ]);
            report($exception);

            return self::buildReturn(['message' => 'Falha ao excluir patrimônio'], 500);
        }
    }

    private function applyFilters(Builder $query, array $filters): Builder
    {
        if (!empty($filters[Equipment::ASSET_CODE])) {
            $query->where(Equipment::ASSET_CODE, 'like', '%' . $filters[Equipment::ASSET_CODE] . '%');
        }

        if (!empty($filters[Equipment::NAME])) {
            $query->where(Equipment::NAME, 'like', '%' . $filters[Equipment::NAME] . '%');
        }

        if (!empty($filters[Equipment::STATUS])) {
            $query->where(Equipment::STATUS, $filters[Equipment::STATUS]);
        }

        if (!empty($filters[Equipment::DEPARTMENT_ID])) {
            $query->where(Equipment::DEPARTMENT_ID, $filters[Equipment::DEPARTMENT_ID]);
        }

        if (!empty($filters[Equipment::LOCATION_ID])) {
            $query->where(Equipment::LOCATION_ID, $filters[Equipment::LOCATION_ID]);
        }

        if (!empty($filters[Equipment::SUBGROUP_ID])) {
            $query->where(Equipment::SUBGROUP_ID, $filters[Equipment::SUBGROUP_ID]);
        }

        if (array_key_exists(Equipment::RENTED, $filters)) {
            $rented = filter_var($filters[Equipment::RENTED], FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE);

            if ($rented !== null) {
                $query->where(Equipment::RENTED, $rented);
            }
        }

        return $query;
    }
    
    private function normalizePayload(array $data): array
    {
        if (array_key_exists(Equipment::RENTED, $data)) {
            $normalized = filter_var($data[Equipment::RENTED], FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE);
            if ($normalized !== null) {
                $data[Equipment::RENTED] = $normalized;
            }
        }

        return $data;
    }
}