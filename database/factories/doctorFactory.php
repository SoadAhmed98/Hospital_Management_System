<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    protected $model = Doctor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // Ensure the password is encrypted
            'phone' => $this->faker->phoneNumber,
            'consultation_fees' => $this->faker->randomElement([100, 200, 300, 400, 500]),
            'department_id' => Department::all()->random()->id,

        ];
    }
}
