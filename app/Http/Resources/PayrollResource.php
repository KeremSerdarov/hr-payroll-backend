<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PayrollResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'month' => $this->month,
            'year' => $this->year,
            'base_salary' => $this->base_salary,
            'bonus' => $this->bonus,
            'deduction' => $this->deduction,
            'tax' => $this->tax,
            'net_salary' => $this->net_salary,
            'status' => $this->status,
        ];
    }
}
