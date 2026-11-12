<?php

namespace App\Http\Requests\Api\V1;

use App\Models\Employee;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $employee = $this->route('employee');
        $employee = $employee instanceof Employee ? $employee : ($employee ? Employee::find($employee) : null);
        $userId = $employee?->user_id;
        $partial = in_array($this->method(), ['PUT', 'PATCH'], true);
        $required = $partial ? 'sometimes' : 'required';

        return [
            'name' => [$required, 'string', 'max:255'],
            'email' => [$required, 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'password' => [$partial ? 'sometimes' : 'required', 'string', 'min:8'],
            'department_id' => [$required, 'integer', 'exists:departments,id'],
            'position' => [$required, 'string', 'max:255'],
            'base_salary' => [$required, 'numeric', 'min:0'],
            'hired_at' => [$required, 'date'],
        ];
    }
}
