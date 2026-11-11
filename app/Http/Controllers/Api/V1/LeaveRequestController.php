<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CreateLeaveRequest as CreateLeaveRequestForm;
use App\Http\Resources\LeaveRequestResource;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    public function index(Request $request)
    {
        $leaveRequests = $request->user()->employee->leaveRequests()
            ->orderByDesc('start_date')->get();

        return LeaveRequestResource::collection($leaveRequests);
    }

    public function store(CreateLeaveRequestForm $request)
    {
        // Işgär ID-si body-dan alynmaýar; diňe tokeniň eýesine ýazylýar.
        $leaveRequest = $request->user()->employee->leaveRequests()->create($request->validated());

        return LeaveRequestResource::make($leaveRequest)->response()->setStatusCode(201);
    }
}
