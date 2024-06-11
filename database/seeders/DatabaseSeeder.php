<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Department;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // // إنشاء 10 سجلات للمستخدمين
        // User::factory(10)->create();

        // // إنشاء مستخدم تجريبي
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Department::factory()->count(5)->create();

        // إنشاء 10 سجلات للأطباء
        Doctor::factory(10)->create();

       
    }
}
