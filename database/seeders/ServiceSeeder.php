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
        DB::table('services')->insert(
            [
                [
                    "id" => 1,
                    "price" => "50.00",
                    "description" => "Basic general health consultation.",
                    "status" => 1,
                    "name" => "General Consultation",
                    "created_at" => $now,
                    "updated_at" => $now
                ],
                [
                    "id" => 2,
                    "price" => "150.00",
                    "description" => "Specialized heart health checkup.",
                    "status" => 1,
                    "name" => "Cardiology Checkup",
                    "created_at" => $now,
                    "updated_at" => $now
                ],
                [
                    "id" => 3,
                    "price" => "75.00",
                    "description" => "Comprehensive dental cleaning service.",
                    "status" => 0,
                    "name" => "Dental Cleaning",
                    "created_at" => $now,
                    "updated_at" => $now
                ],
                [
                    "id" => 4,
                    "price" => "50.00",
                    "description" => "Blood Test service.",
                    "status" => 1,
                    "name" => "Blood Test",
                    "created_at" => $now,
                    "updated_at" => $now
                ],
                [
                    "id" => 5,
                    "price" => "150.00",
                    "description" => "Emergency Care service.",
                    "status" => 1,
                    "name" => "Emergency Care",
                    "created_at" => $now,
                    "updated_at" => $now
                ],
                [
                    "id" => 6,
                    "price" => "75.00",
                    "description" => "Outdoor Checkup service.",
                    "status" => 0,
                    "name" => "Outdoor Checkup",
                    "created_at" => $now,
                    "updated_at" => $now
                ]
            ]

        );
    }
}
