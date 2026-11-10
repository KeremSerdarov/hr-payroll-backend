<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    public function index()
    {
        return view('admin.leave-requests.index', [
            'leaveRequests' => LeaveRequest::with(['employee.user', 'employee.department'])
                ->latest()->get(),
        ]);
    }

    public function decide(Request $request, LeaveRequest $leaveRequest)
    {
        $data = $request->validate([
            'status' => ['required', 'in:approved,rejected'],
            'admin_comment' => ['nullable', 'string', 'max:5000'],
        ]);

        $leaveRequest->update($data);

        return redirect()->route('admin.leave-requests.index')
            ->with('success', 'Rugsat haýyşy boýunça karar saklandy.');
    }
}
