<?php

namespace EquipmentSubgroups;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Kascat\EasyModule\Core\Service;
use Throwable;

class EquipmentSubgroupService extends Service
{
    /**
     * @param array $filters
     * @return array{response: \Illuminate\Support\Collection<int, EquipmentSubgroup>|LengthAwarePaginator, status:int}
     */
    public function listSubgroups(array $filters = []): array
    {
        $query = EquipmentSubgroup::query()->with('group')->orderBy(EquipmentSubgroup::NAME);

        if (!empty($filters[EquipmentSubgroup::GROUP_ID])) {
            $query->where(EquipmentSubgroup::GROUP_ID, $filters[EquipmentSubgroup::GROUP_ID]);
        }

        $perPage = (int) ($filters[self::PER_PAGE] ?? 0);
        if ($perPage > 0) {
            $paginator = $query->paginate($perPage)->appends(Arr::except($filters, [self::PER_PAGE]));
            return self::buildReturn($paginator);
        }

        return self::buildReturn($query->get());
    }

    public function show(EquipmentSubgroup $subgroup): array
    {
        $subgroup->load(['group', 'equipments']);
        return self::buildReturn($subgroup);
    }

    public function create(array $data): array
    {
        DB::beginTransaction();

        try {
            /** @var EquipmentSubgroup $subgroup */
            $subgroup = EquipmentSubgroup::create($data);

            DB::commit();

            return self::buildReturn($subgroup, 201);
        } catch (Throwable $exception) {
            DB::rollBack();

            Log::error('EquipmentSubgroupService: error while creating subgroup', [
                'message' => $exception->getMessage(),
                'namespace' => __CLASS__,
            ]);
            report($exception);

            return self::buildReturn(['message' => 'Falha ao cadastrar subgrupo'], 500);
        }
    }

    public function update(EquipmentSubgroup $subgroup, array $data): array
    {
        DB::beginTransaction();

        try {
            $subgroup->fill($data);
            $subgroup->save();

            DB::commit();

            return self::buildReturn($subgroup);
        } catch (Throwable $exception) {
            DB::rollBack();

            Log::error('EquipmentSubgroupService: error while updating subgroup', [
                'message' => $exception->getMessage(),
                'namespace' => __CLASS__,
                'subgroup_id' => $subgroup->id,
            ]);
            report($exception);

            return self::buildReturn(['message' => 'Falha ao atualizar subgrupo'], 500);
        }
    }

    public function delete(EquipmentSubgroup $subgroup): array
    {
        DB::beginTransaction();

        try {
            $subgroup->delete();

            DB::commit();

            return self::buildReturn(status: 204);
        } catch (Throwable $exception) {
            DB::rollBack();

            Log::error('EquipmentSubgroupService: error while deleting subgroup', [
                'message' => $exception->getMessage(),
                'namespace' => __CLASS__,
                'subgroup_id' => $subgroup->id,
            ]);
            report($exception);

            return self::buildReturn(['message' => 'Falha ao excluir subgrupo'], 500);
        }
    }
}
