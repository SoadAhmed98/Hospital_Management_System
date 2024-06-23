<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('services')->delete();
        DB::table('services')->insert([
            [
                'name' => 'General Consultation',
                'status' => true,
                'price' => 50.00,
                'description' => 'Basic general health consultation.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Cardiology Checkup',
                'status' => true,
                'price' => 150.00,
                'description' => 'Specialized heart health checkup.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Dental Cleaning',
                'status' => false,
                'price' => 75.00,
                'description' => 'Comprehensive dental cleaning service.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
