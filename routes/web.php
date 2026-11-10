<?php

use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\LeaveRequestController;
use App\Http\Controllers\Admin\PayrollController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('admin.login'));

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

    // Admin middleware sessiýadaky ulanyjynyň roluny barlaýar.
    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('departments', DepartmentController::class)->except('show');
        Route::resource('employees', EmployeeController::class)->except('show');
        Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
        Route::post('/attendances', [AttendanceController::class, 'store'])->name('attendances.store');
        Route::get('/leave-requests', [LeaveRequestController::class, 'index'])->name('leave-requests.index');
        Route::post('/leave-requests/{leaveRequest}/decision', [LeaveRequestController::class, 'decide'])
            ->name('leave-requests.decide');
        Route::get('/payrolls', [PayrollController::class, 'index'])->name('payrolls.index');
        Route::post('/payrolls/generate', [PayrollController::class, 'generate'])->name('payrolls.generate');
    });
});
