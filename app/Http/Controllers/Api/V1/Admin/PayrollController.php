<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\GeneratePayrollRequest;
use App\Http\Requests\Api\V1\PayrollFilterRequest;
use App\Http\Resources\PayrollResource;
use App\Models\Payroll;
use App\Services\PayrollCalculator;

class PayrollController extends Controller
{
    public function generate(GeneratePayrollRequest $request, PayrollCalculator $calculator)
    {
        $data = $request->validated();
        $count = $calculator->generate($data['month'], $data['year']);
        $payrolls = Payroll::with(['employee.user', 'employee.department'])
            ->where('month', $data['month'])->where('year', $data['year'])->orderBy('employee_id')->get();

        return response()->json(['generated' => $count, 'payrolls' => PayrollResource::collection($payrolls)]);
    }

    public function index(PayrollFilterRequest $request)
    {
        $query = Payroll::with(['employee.user', 'employee.department'])->orderByDesc('year')->orderByDesc('month');
        $filters = $request->validated();
        $query->when(isset($filters['month']), fn ($q) => $q->where('month', $filters['month']));
        $query->when(isset($filters['year']), fn ($q) => $q->where('year', $filters['year']));
        return PayrollResource::collection($query->get());
    }

    public function pay(Payroll $payroll)
    {
        $payroll->update(['status' => 'paid']);
        return PayrollResource::make($payroll->refresh()->load(['employee.user', 'employee.department']));
    }
}
