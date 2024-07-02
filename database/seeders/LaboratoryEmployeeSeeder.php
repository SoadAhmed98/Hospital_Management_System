<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class LaboratoryEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('laboratory_employees')->delete();
        DB::table('laboratory_employees')->insert([
            'name' => 'lab_employee',
            'email' => 'lab_employee@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
