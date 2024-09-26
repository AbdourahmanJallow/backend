<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $specializations = [
            'Cardiology',
            'Dermatology',
            'Pediatrics',
            'Orthopedics',
            'Neurology',
            'Gynecology',
            'General Surgery',
            'Psychiatry',
            'Radiology',
            'Oncology',
        ];

        return [
            'user_id' => User::factory(), // This will automatically create and associate a User with this Doctor
            'specialization' => $this->faker->randomElement($specializations),
            'yearsOfExperience' => $this->faker->numberBetween(1, 20),
            'bio' => $this->faker->paragraph(),
            'clinicalAddress' => $this->faker->address(),
        ];
    }
}
