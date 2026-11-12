<?php

use App\Http\Controllers\Api\V1\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Api\V1\Admin\DepartmentController;
use App\Http\Controllers\Api\V1\Admin\EmployeeController;
use App\Http\Controllers\Api\V1\Admin\LeaveRequestController as AdminLeaveRequestController;
use App\Http\Controllers\Api\V1\Admin\PayrollController as AdminPayrollController;
use App\Http\Controllers\Api\V1\AttendanceController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\LeaveRequestController;
use App\Http\Controllers\Api\V1\PayrollController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\EnsureEmployee;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('me', [AuthController::class, 'me'])->name('me');

        Route::middleware(EnsureEmployee::class)->group(function () {
            Route::get('payrolls', [PayrollController::class, 'index'])->name('payrolls.index');
            Route::get('payrolls/{payroll}', [PayrollController::class, 'show'])
                ->whereNumber('payroll')->name('payrolls.show');
            Route::get('attendances', [AttendanceController::class, 'index'])->name('attendances.index');
            Route::get('leave-requests', [LeaveRequestController::class, 'index'])->name('leave-requests.index');
            Route::post('leave-requests', [LeaveRequestController::class, 'store'])->name('leave-requests.store');
        });

        Route::prefix('admin')->name('admin.')->middleware(AdminMiddleware::class)->group(function () {
            Route::apiResource('departments', DepartmentController::class);
            Route::apiResource('employees', EmployeeController::class);
            Route::get('attendances', [AdminAttendanceController::class, 'index'])->name('attendances.index');
            Route::post('attendances', [AdminAttendanceController::class, 'store'])->name('attendances.store');
            Route::match(['put', 'patch'], 'attendances/{attendance}', [AdminAttendanceController::class, 'update'])
                ->whereNumber('attendance')->name('attendances.update');
            Route::get('leave-requests', [AdminLeaveRequestController::class, 'index'])->name('leave-requests.index');
            Route::patch('leave-requests/{leaveRequest}/decide', [AdminLeaveRequestController::class, 'decide'])
                ->whereNumber('leaveRequest')->name('leave-requests.decide');
            Route::post('payrolls/generate', [AdminPayrollController::class, 'generate'])->name('payrolls.generate');
            Route::get('payrolls', [AdminPayrollController::class, 'index'])->name('payrolls.index');
            Route::patch('payrolls/{payroll}/pay', [AdminPayrollController::class, 'pay'])
                ->whereNumber('payroll')->name('payrolls.pay');
        });
    });
});
