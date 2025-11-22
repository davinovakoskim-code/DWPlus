<?php

namespace EquipmentGroups;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Kascat\EasyModule\Core\Service;
use Throwable;

class EquipmentGroupService extends Service
{
    /**
     * @param array $filters
     * @return array{response: \Illuminate\Support\Collection<int, EquipmentGroup>|LengthAwarePaginator, status:int}
     */
    public function listGroups(array $filters = []): array
    {
        $query = EquipmentGroup::query()->orderBy(EquipmentGroup::NAME);

        $perPage = (int) ($filters[self::PER_PAGE] ?? 0);
        if ($perPage > 0) {
            $paginator = $query->paginate($perPage)->appends(Arr::except($filters, [self::PER_PAGE]));
            return self::buildReturn($paginator);
        }

        return self::buildReturn($query->get());
    }

    public function show(EquipmentGroup $group): array
    {
        $group->load('subgroups');
        return self::buildReturn($group);
    }

    public function create(array $data): array
    {
        DB::beginTransaction();

        try {
            /** @var EquipmentGroup $group */
            $group = EquipmentGroup::create($data);

            DB::commit();

            return self::buildReturn($group, 201);
        } catch (Throwable $exception) {
            DB::rollBack();

            Log::error('EquipmentGroupService: error while creating group', [
                'message' => $exception->getMessage(),
                'namespace' => __CLASS__,
            ]);
            report($exception);

            return self::buildReturn(['message' => 'Falha ao cadastrar grupo'], 500);
        }
    }

    public function update(EquipmentGroup $group, array $data): array
    {
        DB::beginTransaction();

        try {
            $group->fill($data);
            $group->save();

            DB::commit();

            return self::buildReturn($group);
        } catch (Throwable $exception) {
            DB::rollBack();

            Log::error('EquipmentGroupService: error while updating group', [
                'message' => $exception->getMessage(),
                'namespace' => __CLASS__,
                'group_id' => $group->id,
            ]);
            report($exception);

            return self::buildReturn(['message' => 'Falha ao atualizar grupo'], 500);
        }
    }

    public function delete(EquipmentGroup $group): array
    {
        DB::beginTransaction();

        try {
            $group->delete();

            DB::commit();

            return self::buildReturn(status: 204);
        } catch (Throwable $exception) {
            DB::rollBack();

            Log::error('EquipmentGroupService: error while deleting group', [
                'message' => $exception->getMessage(),
                'namespace' => __CLASS__,
                'group_id' => $group->id,
            ]);
            report($exception);

            return self::buildReturn(['message' => 'Falha ao excluir grupo'], 500);
        }
    }
}
