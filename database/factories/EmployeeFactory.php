<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'department_id' => Department::factory(),
            'position' => fake()->jobTitle(),
            'base_salary' => fake()->randomFloat(2, 3000, 12000),
            'hired_at' => fake()->dateTimeBetween('-5 years', 'today')->format('Y-m-d'),
        ];
    }
}
