<?php

namespace Database\Seeders;

use Carbon\Carbon;

use App\Models\Department;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Department::factory()->count(10)->create();
        $now = Carbon::now();
        DB::table('departments')->delete();
        DB::table('departments')->insert([
            [
                "id" => 1,
                "name" => "Urology",
                "description" => "The Urology Department specializes in the urinary tracts of males and females and the male reproductive system. It offers comprehensive care for a variety of urological conditions including kidney stones, bladder problems, and prostate issues. Our team employs advanced diagnostic and treatment techniques, including minimally invasive surgeries. We aim to provide compassionate, patient-centered care tailored to individual needs. Services also include urodynamics and cancer screening.",
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                "id" => 2,
                "name" => "Neurology",
                "description" => "The Neurology Department is dedicated to diagnosing and treating disorders of the brain, spinal cord, and nerves. Our specialists handle conditions such as epilepsy, Parkinson's disease, and multiple sclerosis. We offer state-of-the-art diagnostic services including MRI and EEG, and advanced treatments like neurorehabilitation. Our goal is to improve the quality of life for patients through innovative and comprehensive care. We also provide support for managing chronic neurological diseases.",
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                "id" => 3,
                "name" => "Gastrology",
                "description" => "The Gastrology Department focuses on the health of the digestive system or the gastrointestinal (GI) tract. We diagnose and treat conditions like GERD, irritable bowel syndrome, and Crohn's disease. Our services include endoscopic procedures, nutritional guidance, and specialized GI testing. Our team is committed to offering personalized care and advanced treatment options. We aim to improve digestive health and quality of life for our patients through preventative care and expert treatment.",
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                "id" => 4,
                "name" => "Cardiology",
                "description" => "The Cardiology Department provides comprehensive care for heart and vascular conditions. We offer diagnostic services such as EKG, echocardiograms, and stress tests, and treatments for conditions like hypertension, coronary artery disease, and heart failure. Our team of cardiologists is skilled in both non-invasive and invasive procedures, including cardiac catheterization. We strive to deliver high-quality, patient-centered care to improve cardiovascular health. Preventative care and patient education are also key components of our services.",
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                "id" => 5,
                "name" => "Eye Care",
                "description" => "The Eye Care Department is dedicated to providing exceptional eye care for a wide range of conditions. Our services include routine eye exams, treatment for glaucoma, cataracts, and macular degeneration. We offer advanced diagnostic tools and surgical options for various eye disorders. Our team focuses on preserving and improving vision through comprehensive and personalized care. We also provide specialized care for diabetic eye diseases and pediatric ophthalmology.",
                'created_at' => $now,
                'updated_at' => $now,
                ]
        ]);
    }
}
