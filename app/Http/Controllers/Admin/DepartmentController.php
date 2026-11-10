<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    public function index()
    {
        return view('admin.departments.index', [
            'departments' => Department::withCount('employees')->orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.departments.form', ['department' => new Department]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:departments,name'],
            'description' => ['nullable', 'string'],
        ]);

        Department::create($data);

        return redirect()->route('admin.departments.index')->with('success', 'Bölüm goşuldy.');
    }

    public function edit(Department $department)
    {
        return view('admin.departments.form', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('departments', 'name')->ignore($department->id)],
            'description' => ['nullable', 'string'],
        ]);

        $department->update($data);

        return redirect()->route('admin.departments.index')->with('success', 'Bölüm täzelendi.');
    }

    public function destroy(Department $department)
    {
        if ($department->employees()->exists()) {
            return back()->withErrors(['department' => 'Ilki bu bölümdäki işgärleri başga bölüme geçirip aýryň.']);
        }

        $department->delete();

        return redirect()->route('admin.departments.index')->with('success', 'Bölüm aýryldy.');
    }
}
