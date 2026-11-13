<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    // Işgärleriň gündelik gatnaşyk ýazgylaryny döredýäris.
    public function run(): void
    {
        $emails = ['ayna@example.com', 'merdan@example.com', 'oguljahan@example.com', 'begenc@example.com', 'leyli@example.com'];

        foreach ($emails as $index => $email) {
            $user = User::query()->where('email', $email)->first();
            $employee = Employee::query()->where('user_id', $user->id)->first();

            foreach ([
                '2026-10-27' => 'present',
                '2026-10-28' => $index % 2 === 0 ? 'absent' : 'present',
                '2026-10-29' => $index === 4 ? 'leave' : 'present',
            ] as $date => $status) {
                if (! Attendance::query()->where('employee_id', $employee->id)->whereDate('date', $date)->exists()) {
                    Attendance::factory()->create([
                        'employee_id' => $employee->id,
                        'date' => $date,
                        'status' => $status,
                    ]);
                }
            }
        }
    }
}
