<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\WorkSchedule;
use Database\Seeders\WorkScheduleSeeder as SeedersWorkScheduleSeeder;
use Illuminate\Database\Seeder;
use WorkScheduleSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            DepartmentSeeder::class,
            WorkScheduleTableSeeder::class,
            DoctorSeeder::class,
            ImageSeeder::class,
            ServiceSeeder::class,
            PatientSeeder::class,
            LaboratoryEmployeeSeeder::class,
            GroupSeeder::class,
            ServiceGroupSeeder::class

        ]);


       
    }
}
