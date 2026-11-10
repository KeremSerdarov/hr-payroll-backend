<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\LeaveRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LeaveRequest>
 */
class LeaveRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('+1 day', '+10 days');

        return [
            'employee_id' => Employee::factory(),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => (clone $startDate)->modify('+'.fake()->numberBetween(1, 5).' days')->format('Y-m-d'),
            'reason' => fake()->sentence(),
            'status' => 'pending',
            'admin_comment' => null,
        ];
    }
}
