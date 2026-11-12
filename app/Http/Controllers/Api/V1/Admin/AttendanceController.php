<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\AdminAttendanceRequest;
use App\Http\Requests\Api\V1\AttendanceFilterRequest;
use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function index(AttendanceFilterRequest $request)
    {
        $query = Attendance::with(['employee.user', 'employee.department'])->orderByDesc('date');
        $filters = $request->validated();
        $query->when(isset($filters['employee_id']), fn ($q) => $q->where('employee_id', $filters['employee_id']));
        $query->when(isset($filters['date']), fn ($q) => $q->whereDate('date', $filters['date']));
        $query->when(isset($filters['from']), fn ($q) => $q->whereDate('date', '>=', $filters['from']));
        $query->when(isset($filters['to']), fn ($q) => $q->whereDate('date', '<=', $filters['to']));
        return AttendanceResource::collection($query->get());
    }

    public function store(AdminAttendanceRequest $request)
    {
        $attendance = Attendance::create($request->validated());
        return AttendanceResource::make($attendance->load('employee.user'))->response()->setStatusCode(201);
    }

    public function update(AdminAttendanceRequest $request, Attendance $attendance)
    {
        $attendance->update($request->validated());
        return AttendanceResource::make($attendance->refresh()->load('employee.user'));
    }
}
