<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Payroll;
use Carbon\Carbon;

class PayrollCalculator
{
    public function generate(int $month, int $year): int
    {
        $start = Carbon::create($year, $month, 1)->startOfMonth();
        $end = $start->copy()->endOfMonth();
        $workingDays = 0;

        // Iş günleri dynç günlerini (şenbe we ýekşenbe) hasaba almaýar.
        for ($day = $start->copy(); $day->lte($end); $day->addDay()) {
            if ($day->isWeekday()) {
                $workingDays++;
            }
        }

        // Gatnaşyklary öňünden ýüklemek bilen her işgär üçin aýratyn soragyň öňüni alýarys.
        $employees = Employee::with(['attendances' => function ($query) use ($start, $end) {
            $query->where('status', 'absent')->whereBetween('date', [$start->toDateString(), $end->toDateString()]);
        }])->get();

        foreach ($employees as $employee) {
            $payroll = Payroll::firstOrNew([
                'employee_id' => $employee->id,
                'month' => $month,
                'year' => $year,
            ]);

            $baseSalary = (float) $employee->base_salary;
            $bonus = (float) ($payroll->bonus ?? 0);
            $absentDays = $employee->attendances->count();
            $deduction = round(($baseSalary / $workingDays) * $absentDays, 2);
            $taxable = $baseSalary - $deduction + $bonus;
            $tax = round($taxable * 0.10, 2);

            $payroll->fill([
                'base_salary' => $baseSalary,
                'bonus' => $bonus,
                'deduction' => $deduction,
                'tax' => $tax,
                'net_salary' => round($taxable - $tax, 2),
            ]);
            // Töleg edilen ýazgy gaýtadan hasaplansa-da paid ýagdaýynda galýar.
            if (! $payroll->exists) {
                $payroll->status = 'draft';
            }
            $payroll->save();
        }

        return $employees->count();
    }
}
