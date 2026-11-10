<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Adminiň roly Fillable sanawyna goşulmaz ýaly ony aýratyn belleýäris.
        $admin = User::query()->firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Taslama Admini', 'password' => 'password'],
        );
        $admin->forceFill(['role' => 'admin'])->save();

        $departments = collect([
            ['name' => 'Işgärler bölümi', 'description' => 'Işgär dolandyryşy'],
            ['name' => 'Maliýe bölümi', 'description' => 'Hasap we maliýe işleri'],
        ])->map(function (array $data) {
            return Department::query()->where('name', $data['name'])->first()
                ?? Department::factory()->create($data);
        });

        $employeeData = [
            ['name' => 'Aýna Meredowa', 'email' => 'ayna@example.com', 'department' => 0, 'position' => 'HR hünärmeni', 'salary' => 8000],
            ['name' => 'Merdan Annaýew', 'email' => 'merdan@example.com', 'department' => 0, 'position' => 'Işgär dolandyryjysy', 'salary' => 9500],
            ['name' => 'Oguljahan Saparowa', 'email' => 'oguljahan@example.com', 'department' => 1, 'position' => 'Hasapçy', 'salary' => 7500],
            ['name' => 'Begenç Geldiýew', 'email' => 'begenc@example.com', 'department' => 1, 'position' => 'Maliýe hünärmeni', 'salary' => 9000],
            ['name' => 'Leýli Öwezowa', 'email' => 'leyli@example.com', 'department' => 0, 'position' => 'Kadr hünärmeni', 'salary' => 8200],
        ];

        $employees = collect($employeeData)->map(function (array $data) use ($departments) {
            $user = User::query()->where('email', $data['email'])->first()
                ?? User::factory()->create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => 'password',
                ]);

            return Employee::query()->where('user_id', $user->id)->first()
                ?? Employee::factory()->create([
                    'user_id' => $user->id,
                    'department_id' => $departments[$data['department']]->id,
                    'position' => $data['position'],
                    'base_salary' => $data['salary'],
                    'hired_at' => '2024-01-15',
                ]);
        });

        // Her işgäriň birnäçe günlük gatnaşyk ýazgysyny görkezýäris.
        foreach ($employees as $index => $employee) {
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

        foreach ([
            [0, '2026-11-20', '2026-11-21', 'Maşgala sebäpli rugsat', 'pending'],
            [1, '2026-11-22', '2026-11-23', 'Şahsy iş üçin rugsat', 'approved'],
            [2, '2026-11-24', '2026-11-25', 'Saglyk sebäpli rugsat', 'rejected'],
        ] as [$index, $start, $end, $reason, $status]) {
            if (! LeaveRequest::query()->where('employee_id', $employees[$index]->id)->whereDate('start_date', $start)->exists()) {
                LeaveRequest::factory()->create([
                    'employee_id' => $employees[$index]->id,
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
