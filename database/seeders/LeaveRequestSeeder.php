<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Database\Seeder;

class LeaveRequestSeeder extends Seeder
{
    // Işgärleriň rugsat soraglaryny döredýäris.
    public function run(): void
    {
        $emails = ['ayna@example.com', 'merdan@example.com', 'oguljahan@example.com'];

        foreach ([
            ['2026-11-20', '2026-11-21', 'Maşgala sebäpli rugsat', 'pending'],
            ['2026-11-22', '2026-11-23', 'Şahsy iş üçin rugsat', 'approved'],
            ['2026-11-24', '2026-11-25', 'Saglyk sebäpli rugsat', 'rejected'],
        ] as $index => [$start, $end, $reason, $status]) {
            $user = User::query()->where('email', $emails[$index])->first();
            $employee = Employee::query()->where('user_id', $user->id)->first();

            if (! LeaveRequest::query()->where('employee_id', $employee->id)->whereDate('start_date', $start)->exists()) {
                LeaveRequest::factory()->create([
                    'employee_id' => $employee->id,
                    'start_date' => $start,
                    'end_date' => $end,
                    'reason' => $reason,
                    'status' => $status,
                    'admin_comment' => $status === 'pending' ? null : 'Synag üçin döredildi.',
                ]);
            }
        }
    }
}
