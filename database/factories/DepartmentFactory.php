<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    protected $model = Department::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->randomElement([
                'Neurology Department',
                'Surgery Department',
                'Pediatrics Department',
                'Obstetrics and Gynecology Department',
                'Ophthalmology Department',
                'Internal Medicine Department',
                'Cardiology Department',
                'Dermatology Department',
                'Endocrinology Department',
                'Gastroenterology Department'
            ]),
            'description' => $this->faker->paragraph,
        ];
    }
}
