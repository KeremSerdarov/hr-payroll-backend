<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminAttendanceRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $required = $this->isMethod('post') ? 'required' : 'sometimes';
        return [
            'employee_id' => [$required, 'integer', 'exists:employees,id'],
            'date' => [$required, 'date'],
            'status' => [$required, Rule::in(['present', 'absent', 'leave'])],
        ];
    }
}
