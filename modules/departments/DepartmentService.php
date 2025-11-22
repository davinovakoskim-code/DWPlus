<?php

namespace Departments;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Kascat\EasyModule\Core\Service;
use Throwable;

class DepartmentService extends Service
{
    /**
     * @param array $filters
     * @return array{response: \Illuminate\Support\Collection<int, Department>|LengthAwarePaginator, status:int}
     */
    public function listDepartments(array $filters = []): array
    {
        $query = Department::query()->orderBy(Department::NAME);

        $perPage = (int) ($filters[self::PER_PAGE] ?? 0);
        if ($perPage > 0) {
            $paginator = $query->paginate($perPage)->appends(Arr::except($filters, [self::PER_PAGE]));
            return self::buildReturn($paginator);
        }

        return self::buildReturn($query->get());
    }

    public function show(Department $department): array
    {
        $department->load('equipments');
        return self::buildReturn($department);
    }

    public function create(array $data): array
    {
        DB::beginTransaction();

        try {
            /** @var Department $department */
            $department = Department::create($data);

            DB::commit();

            return self::buildReturn($department, 201);
        } catch (Throwable $exception) {
            DB::rollBack();

            Log::error('DepartmentService: error while creating department', [
                'message' => $exception->getMessage(),
                'namespace' => __CLASS__,
            ]);
            report($exception);

            return self::buildReturn(['message' => 'Falha ao cadastrar departamento'], 500);
        }
    }

    public function update(Department $department, array $data): array
    {
        DB::beginTransaction();

        try {
            $department->fill($data);
            $department->save();

            DB::commit();

            return self::buildReturn($department);
        } catch (Throwable $exception) {
            DB::rollBack();

            Log::error('DepartmentService: error while updating department', [
                'message' => $exception->getMessage(),
                'namespace' => __CLASS__,
                'department_id' => $department->id,
            ]);
            report($exception);

            return self::buildReturn(['message' => 'Falha ao atualizar departamento'], 500);
        }
    }

    public function delete(Department $department): array
    {
        DB::beginTransaction();

        try {
            $department->delete();

            DB::commit();

            return self::buildReturn(status: 204);
        } catch (Throwable $exception) {
            DB::rollBack();

            Log::error('DepartmentService: error while deleting department', [
                'message' => $exception->getMessage(),
                'namespace' => __CLASS__,
                'department_id' => $department->id,
            ]);
            report($exception);

            return self::buildReturn(['message' => 'Falha ao excluir departamento'], 500);
        }
    }
}
