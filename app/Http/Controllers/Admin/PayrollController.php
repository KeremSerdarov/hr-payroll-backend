<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use App\Services\PayrollCalculator;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'month' => ['sometimes', 'integer', 'between:1,12'],
            'year' => ['sometimes', 'integer', 'between:2000,2100'],
        ]);
        $month = $filters['month'] ?? now()->month;
        $year = $filters['year'] ?? now()->year;

        return view('admin.payrolls.index', [
            'month' => $month,
            'year' => $year,
            'payrolls' => Payroll::with(['employee.user', 'employee.department'])
                ->where('month', $month)->where('year', $year)->orderBy('employee_id')->get(),
        ]);
    }

    public function generate(Request $request, PayrollCalculator $calculator)
    {
        $data = $request->validate([
            'month' => ['required', 'integer', 'between:1,12'],
            'year' => ['required', 'integer', 'between:2000,2100'],
        ]);

        $count = $calculator->generate($data['month'], $data['year']);

        return redirect()->route('admin.payrolls.index', $data)
            ->with('success', "$count işgär üçin aýlyk hasaplandy.");
    }
}
