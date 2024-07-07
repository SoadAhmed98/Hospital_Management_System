<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
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
                'id' => 1,
                'name' => 'Basic Plan',
                'Total_before_discount' => '450.00',
                'discount_value' => '10.00',
                'Total_after_discount' => '440.00',
                'tax_rate' => '14',
                'Total_with_tax' => '501.60',
                'notes' => 'mnbn',
            ],
            [
                'id' => 2,
                'name' => 'Advance Plan',
                'Total_before_discount' => '450.00',
                'discount_value' => '15.00',
                'Total_after_discount' => '435.00',
                'tax_rate' => '14',
                'Total_with_tax' => '495.90',
                'notes' => 'hhgg',
            ],
            [
                'id' => 3,
                'name' => 'Team Plan',
                'Total_before_discount' => '50.00',
                'discount_value' => '30.00',
                'Total_after_discount' => '20.00',
                'tax_rate' => '14',
                'Total_with_tax' => '22.80',
                'notes' => 'nmn,mn',
            ],
        ];

        foreach ($data as $group) {
            DB::table('groups')->insert($group);
        }
    }
}
