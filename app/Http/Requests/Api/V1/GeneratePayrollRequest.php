<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class GeneratePayrollRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return ['month' => ['required', 'integer', 'between:1,12'], 'year' => ['required', 'integer', 'between:2000,2200']];
    }
}
