<?php

namespace Database\Seeders;
use App\Models\Doctor; 

use App\Models\Department;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departmentId = Department::firstOrCreate(['name' => 'Neurology'])->id;
        Doctor::factory()->count(30)->create();
        DB::table('doctors')->insert([
            'name' => 'doctor',
            'email' => 'doctor@gmail.com',
            'password' => Hash::make('12345678'),
            'department_id' => $departmentId,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
