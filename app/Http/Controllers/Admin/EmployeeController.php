<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('admin.employees.index', [
            'employees' => Employee::with(['user', 'department'])->orderBy('id')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.employees.form', [
            'employee' => new Employee,
            'departments' => Department::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'department_id' => ['required', 'exists:departments,id'],
            'position' => ['required', 'string', 'max:255'],
            'base_salary' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'hired_at' => ['required', 'date'],
        ]);

        DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);

            $user->forceFill(['role' => 'employee'])->save();

            Employee::create([
                'user_id' => $user->id,
                'department_id' => $data['department_id'],
                'position' => $data['position'],
                'base_salary' => $data['base_salary'],
                'hired_at' => $data['hired_at'],
            ]);
        });

        return redirect()->route('admin.employees.index')->with('success', 'Işgär goşuldy.');
    }

    public function edit(Employee $employee)
    {
        $employee->load('user');

        return view('admin.employees.form', [
            'employee' => $employee,
            'departments' => Department::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Employee $employee)
    {
        $employee->load('user');

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($employee->user_id)],
            'password' => ['nullable', 'string', 'min:8'],
            'department_id' => ['required', 'exists:departments,id'],
            'position' => ['required', 'string', 'max:255'],
            'base_salary' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'hired_at' => ['required', 'date'],
        ]);

        DB::transaction(function () use ($data, $employee) {
            $employee->user->fill([
                'name' => $data['name'],
                'email' => $data['email'],
            ]);

            if (! empty($data['password'])) {
                $employee->user->password = $data['password'];
            }

            $employee->user->save();
            $employee->update([
                'department_id' => $data['department_id'],
                'position' => $data['position'],
                'base_salary' => $data['base_salary'],
                'hired_at' => $data['hired_at'],
            ]);
        });

        return redirect()->route('admin.employees.index')->with('success', 'Işgär maglumatlary täzelendi.');
    }

    public function destroy(Employee $employee)
    {
        // Ulanyjyny aýyrmak işgär we oňa bagly ýazgylary FK arkaly pozýar.
        $employee->user()->delete();

        return redirect()->route('admin.employees.index')->with('success', 'Işgär aýryldy.');
    }
}
