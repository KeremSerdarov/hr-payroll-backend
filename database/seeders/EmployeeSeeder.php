<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    // Işgärleri degişli bölüm we ulanyjy bilen döredýäris.
    public function run(): void
    {
        foreach ([
            ['name' => 'Aýna Meredowa', 'email' => 'ayna@example.com', 'department' => 'Işgärler bölümi', 'position' => 'HR hünärmeni', 'salary' => 8000],
            ['name' => 'Merdan Annaýew', 'email' => 'merdan@example.com', 'department' => 'Işgärler bölümi', 'position' => 'Işgär dolandyryjysy', 'salary' => 9500],
            ['name' => 'Oguljahan Saparowa', 'email' => 'oguljahan@example.com', 'department' => 'Maliýe bölümi', 'position' => 'Hasapçy', 'salary' => 7500],
            ['name' => 'Begenç Geldiýew', 'email' => 'begenc@example.com', 'department' => 'Maliýe bölümi', 'position' => 'Maliýe hünärmeni', 'salary' => 9000],
            ['name' => 'Leýli Öwezowa', 'email' => 'leyli@example.com', 'department' => 'Işgärler bölümi', 'position' => 'Kadr hünärmeni', 'salary' => 8200],
        ] as $data) {
            $user = User::query()->where('email', $data['email'])->first();
            $department = Department::query()->where('name', $data['department'])->first();

            Employee::query()->where('user_id', $user->id)->first()
                ?? Employee::factory()->create([
                    'user_id' => $user->id,
                    'department_id' => $department->id,
                    'position' => $data['position'],
                    'base_salary' => $data['salary'],
                    'hired_at' => '2024-01-15',
                ]);
        }
    }
}
