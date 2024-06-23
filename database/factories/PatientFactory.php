<?php

namespace Database\Factories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $phone = $this->faker->phoneNumber;
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $phone,
            'address' => $this->faker->address,
            'password' => Hash::make($phone), // Hash the phone number as the password
            'birth_date' => $this->faker->date(),
            'gender' => $this->faker->randomElement(['mail', 'femail']),
            'blood_group' => $this->faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
