<?php
namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkScheduleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('work_schedules')->delete();
        
        $workSchedules = [
            ['day' => 'Saturday', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['day' => 'Sunday', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['day' => 'Monday', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['day' => 'Tuesday', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['day' => 'Wednesday', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['day' => 'Thursday', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['day' => 'Friday', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        DB::table('work_schedules')->insert($workSchedules);
    }
}
