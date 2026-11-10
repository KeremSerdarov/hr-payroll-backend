<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\Payroll;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'employeeCount' => Employee::count(),
            'departmentCount' => Department::count(),
            'pendingLeaveCount' => LeaveRequest::where('status', 'pending')->count(),
            'attendanceCount' => Attendance::whereDate('date', today())->count(),
            'recentLeaveRequests' => LeaveRequest::with('employee.user')
                ->latest()->take(5)->get(),
            'recentPayrolls' => Payroll::with('employee.user')
                ->latest()->take(5)->get(),
        ]);
    }
}
