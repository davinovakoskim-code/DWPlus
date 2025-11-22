<?php

namespace Locations;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Kascat\EasyModule\Core\Service;
use Throwable;

class LocationService extends Service
{
    /**
     * @param array $filters
     * @return array{response: \Illuminate\Support\Collection<int, Location>|LengthAwarePaginator, status:int}
     */
    public function listLocations(array $filters = []): array
    {
        $query = Location::query()->orderBy(Location::NAME);

        $perPage = (int) ($filters[self::PER_PAGE] ?? 0);
        if ($perPage > 0) {
            $paginator = $query->paginate($perPage)->appends(Arr::except($filters, [self::PER_PAGE]));
            return self::buildReturn($paginator);
        }

        return self::buildReturn($query->get());
    }

    public function show(Location $location): array
    {
        $location->load('equipments');
        return self::buildReturn($location);
    }

    public function create(array $data): array
    {
        DB::beginTransaction();

        try {
            /** @var Location $location */
            $location = Location::create($data);

            DB::commit();

            return self::buildReturn($location, 201);
        } catch (Throwable $exception) {
            DB::rollBack();

            Log::error('LocationService: error while creating location', [
                'message' => $exception->getMessage(),
                'namespace' => __CLASS__,
            ]);
            report($exception);

            return self::buildReturn(['message' => 'Falha ao cadastrar local'], 500);
        }
    }

    public function update(Location $location, array $data): array
    {
        DB::beginTransaction();

        try {
            $location->fill($data);
            $location->save();

            DB::commit();

            return self::buildReturn($location);
        } catch (Throwable $exception) {
            DB::rollBack();

            Log::error('LocationService: error while updating location', [
                'message' => $exception->getMessage(),
                'namespace' => __CLASS__,
                'location_id' => $location->id,
            ]);
            report($exception);

            return self::buildReturn(['message' => 'Falha ao atualizar local'], 500);
        }
    }

    public function delete(Location $location): array
    {
        DB::beginTransaction();

        try {
            $location->delete();

            DB::commit();

            return self::buildReturn(status: 204);
        } catch (Throwable $exception) {
            DB::rollBack();

            Log::error('LocationService: error while deleting location', [
                'message' => $exception->getMessage(),
                'namespace' => __CLASS__,
                'location_id' => $location->id,
            ]);
            report($exception);

            return self::buildReturn(['message' => 'Falha ao excluir local'], 500);
        }
    }
}
