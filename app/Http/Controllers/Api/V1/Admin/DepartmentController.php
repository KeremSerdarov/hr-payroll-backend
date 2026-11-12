<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\DepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        return DepartmentResource::collection(Department::withCount('employees')->orderBy('name')->get());
    }

    public function store(DepartmentRequest $request)
    {
        return DepartmentResource::make(Department::create($request->validated()))->response()->setStatusCode(201);
    }

    public function show(Department $department)
    {
        return DepartmentResource::make($department->loadCount('employees'));
    }

    public function update(DepartmentRequest $request, Department $department)
    {
        $department->update($request->validated());
        return DepartmentResource::make($department->refresh());
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return response()->noContent();
    }
}
