<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'group_id' => 1, // Basic Plan
                'service_id' => 2, // Cardiology Checkup
                'quantity' => '3.00',
            ],
            [
                'group_id' => 1, // Basic Plan
                'service_id' => 1, // General Consultation
                'quantity' => '2.00',
            ],
            [
                'group_id' => 1, // Basic Plan
                'service_id' => 3, // Pediatric Checkup
                'quantity' => '1.00',
            ],
            [
                'group_id' => 2, // Advance Plan
                'service_id' => 2, // Cardiology Checkup
                'quantity' => '4.00',
            ],
            [
                'group_id' => 2, // Advance Plan
                'service_id' => 4, // Dermatology Consultation
                'quantity' => '2.00',
            ],
            [
                'group_id' => 2, // Advance Plan
                'service_id' => 5, // Neurology Consultation
                'quantity' => '1.00',
            ],
            [
                'group_id' => 3, // Team Plan
                'service_id' => 1, // General Consultation
                'quantity' => '1.00',
            ],
            [
                'group_id' => 3, // Team Plan
                'service_id' => 5, // Neurology Consultation
                'quantity' => '1.00',
            ],
            [
                'group_id' => 3, // Team Plan
                'service_id' => 6, // Radiology Checkup
                'quantity' => '1.00',
            ],
        ];

        foreach ($data as $pivot) {
            DB::table('service_group')->insert($pivot);
        }
    }
}
