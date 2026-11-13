<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    // Adminiň we işgärleriň ulanyjylaryny döredýäris.
    public function run(): void
    {
        $admin = User::query()->firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Taslama Admini', 'password' => 'password'],
        );
        $admin->forceFill(['role' => 'admin'])->save();

        foreach ([
            ['name' => 'Aýna Meredowa', 'email' => 'ayna@example.com'],
            ['name' => 'Merdan Annaýew', 'email' => 'merdan@example.com'],
            ['name' => 'Oguljahan Saparowa', 'email' => 'oguljahan@example.com'],
            ['name' => 'Begenç Geldiýew', 'email' => 'begenc@example.com'],
            ['name' => 'Leýli Öwezowa', 'email' => 'leyli@example.com'],
        ] as $data) {
            User::query()->where('email', $data['email'])->first()
                ?? User::factory()->create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => 'password',
                ]);
        }
    }
}
