<?php

namespace Locations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function __construct(private readonly LocationService $service) {}

    public function index(Request $request): mixed
    {
        $result = $this->service->listLocations($request->all());
        return response($result[LocationService::RESPONSE], $result[LocationService::HTTP_STATUS]);
    }

    public function store(LocationRequest $request): mixed
    {
        $result = $this->service->create($request->validated());
        return response($result[LocationService::RESPONSE], $result[LocationService::HTTP_STATUS]);
    }

    public function show(Location $location): mixed
    {
        $result = $this->service->show($location);
        return response($result[LocationService::RESPONSE], $result[LocationService::HTTP_STATUS]);
    }

    public function update(LocationRequest $request, Location $location): mixed
    {
        $result = $this->service->update($location, $request->validated());
        return response($result[LocationService::RESPONSE], $result[LocationService::HTTP_STATUS]);
    }

    public function destroy(Location $location): mixed
    {
        $result = $this->service->delete($location);
        return response($result[LocationService::RESPONSE], $result[LocationService::HTTP_STATUS]);
    }
}
