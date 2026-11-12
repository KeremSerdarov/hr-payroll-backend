<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\DecideLeaveRequest;
use App\Http\Resources\LeaveRequestResource;
use App\Models\LeaveRequest;

class LeaveRequestController extends Controller
{
    public function index()
    {
        return LeaveRequestResource::collection(LeaveRequest::with(['employee.user', 'employee.department'])->orderByDesc('created_at')->get());
    }

    public function decide(DecideLeaveRequest $request, LeaveRequest $leaveRequest)
    {
        $leaveRequest->update($request->validated());
        return LeaveRequestResource::make($leaveRequest->refresh()->load('employee.user'));
    }
}
