<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\EmployeeRequest;
use App\Http\Resources\AdminEmployeeResource;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index()
    {
        return AdminEmployeeResource::collection(Employee::with(['user', 'department'])->orderBy('id')->get());
    }

    public function store(EmployeeRequest $request)
    {
        $data = $request->validated();
        $employee = DB::transaction(function () use ($data) {
            $user = User::create(['name' => $data['name'], 'email' => $data['email'], 'password' => $data['password'], 'role' => 'employee']);
            return $user->employee()->create(collect($data)->only(['department_id', 'position', 'base_salary', 'hired_at'])->all());
        });

        return AdminEmployeeResource::make($employee->load(['user', 'department']))->response()->setStatusCode(201);
    }

    public function show(Employee $employee)
    {
        return AdminEmployeeResource::make($employee->load(['user', 'department']));
    }

    public function update(EmployeeRequest $request, Employee $employee)
    {
        $data = $request->validated();
        DB::transaction(function () use ($employee, $data) {
            $employee->user->fill(collect($data)->only(['name', 'email', 'password'])->all())->save();
            $employee->fill(collect($data)->only(['department_id', 'position', 'base_salary', 'hired_at'])->all())->save();
        });

        return AdminEmployeeResource::make($employee->refresh()->load(['user', 'department']));
    }

    public function destroy(Employee $employee)
    {
        $employee->user->delete();
        return response()->noContent();
    }
}
