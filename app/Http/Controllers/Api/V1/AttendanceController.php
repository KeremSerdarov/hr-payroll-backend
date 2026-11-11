<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendanceResource;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $attendances = $request->user()->employee->attendances()
            ->orderByDesc('date')->get();

        return AttendanceResource::collection($attendances);
    }
}
