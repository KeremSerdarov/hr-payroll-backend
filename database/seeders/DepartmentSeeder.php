<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    // Bölümleri döredýäris.
    public function run(): void
    {
        foreach ([
            ['name' => 'Işgärler bölümi', 'description' => 'Işgär dolandyryşy'],
            ['name' => 'Maliýe bölümi', 'description' => 'Hasap we maliýe işleri'],
        ] as $data) {
            Department::query()->where('name', $data['name'])->first()
                ?? Department::factory()->create($data);
        }
    }
}
