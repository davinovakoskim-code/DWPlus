<?php

namespace Departments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct(private readonly DepartmentService $service) {}

    public function index(Request $request): mixed
    {
        $result = $this->service->listDepartments($request->all());
        return response($result[DepartmentService::RESPONSE], $result[DepartmentService::HTTP_STATUS]);
    }

    public function store(DepartmentRequest $request): mixed
    {
        $result = $this->service->create($request->validated());
        return response($result[DepartmentService::RESPONSE], $result[DepartmentService::HTTP_STATUS]);
    }

    public function show(Department $department): mixed
    {
        $result = $this->service->show($department);
        return response($result[DepartmentService::RESPONSE], $result[DepartmentService::HTTP_STATUS]);
    }

    public function update(DepartmentRequest $request, Department $department): mixed
    {
        $result = $this->service->update($department, $request->validated());
        return response($result[DepartmentService::RESPONSE], $result[DepartmentService::HTTP_STATUS]);
    }

    public function destroy(Department $department): mixed
    {
        $result = $this->service->delete($department);
        return response($result[DepartmentService::RESPONSE], $result[DepartmentService::HTTP_STATUS]);
    }
}
