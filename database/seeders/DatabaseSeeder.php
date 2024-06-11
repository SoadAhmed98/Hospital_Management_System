<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Doctor;
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

        // إنشاء 10 سجلات للأطباء
        Doctor::factory(10)->create();

        // إنشاء طبيب تجريبي
        Doctor::factory()->create([
            // 'name' => 'Test Doctor',
            'email' => 'testdoctor@example.com',
            'password' => bcrypt('password'), // تأكد من استخدام كلمة مرور مشفرة
            'phone' => '123-456-7890',
            'price' => 300,
            // 'section_id' => 1, // تعيين القسم المناسب
        ]);
    }
}
