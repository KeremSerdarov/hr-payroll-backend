<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['employee_id', 'month', 'year', 'base_salary', 'bonus', 'deduction', 'tax', 'net_salary', 'status'])]
class Payroll extends Model
{
    protected function casts(): array
    {
        return [
            'month' => 'integer',
            'year' => 'integer',
            'base_salary' => 'decimal:2',
            'bonus' => 'decimal:2',
            'deduction' => 'decimal:2',
            'tax' => 'decimal:2',
            'net_salary' => 'decimal:2',
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
