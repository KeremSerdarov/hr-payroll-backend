<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->query('date', today()->toDateString());

        return view('admin.attendances.index', [
            'date' => $date,
            'employees' => Employee::with(['user', 'department'])->orderBy('id')->get(),
            'attendances' => Attendance::with('employee.user')
                ->whereDate('date', $date)->latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => ['required', 'exists:employees,id'],
            'date' => ['required', 'date'],
            'status' => ['required', 'in:present,absent,leave'],
        ]);

        // Bir işgär we gün üçin diňe bir ýazgy bolýar; täzeden iberilse täzelenýär.
        Attendance::updateOrCreate(
            ['employee_id' => $data['employee_id'], 'date' => $data['date']],
            ['status' => $data['status']],
        );

        return redirect()->route('admin.attendances.index', ['date' => $data['date']])
            ->with('success', 'Gatnaşyk ýazgysy saklandy.');
    }
}
