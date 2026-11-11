<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PayrollResource;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        $payrolls = $request->user()->employee->payrolls()
            ->orderByDesc('year')->orderByDesc('month')->get();

        return PayrollResource::collection($payrolls);
    }

    public function show(Request $request, int $payrollId)
    {
        // ID başga işgäriň ýazgysyna degişli bolsa hem bu sorag 404 gaýtarýar.
        $payroll = $request->user()->employee->payrolls()->findOrFail($payrollId);

        return PayrollResource::make($payroll);
    }
}
