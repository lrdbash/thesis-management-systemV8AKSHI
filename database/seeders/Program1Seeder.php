<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program1;

class Program1Seeder extends Seeder
{
    public function run()
    {
        Program1::create([
            'name' => 'MSc MFRA',
            'enrolled_students' => 400,
            'passed_students' => 380,
            'failed_students' => 20
        ]);

        Program1::create([
            'name' => 'MSc Biomathematics',
            'enrolled_students' => 350,
            'passed_students' => 330,
            'failed_students' => 20
        ]);

        Program1::create([
            'name' => 'MAPE',
            'enrolled_students' => 200,
            'passed_students' => 180,
            'failed_students' => 20
        ]);

        Program1::create([
            'name' => 'MEM',
            'enrolled_students' => 450,
            'passed_students' => 430,
            'failed_students' => 20
        ]);

        Program1::create([
            'name' => 'LLM',
            'enrolled_students' => 300,
            'passed_students' => 280,
            'failed_students' => 20
        ]);

        Program1::create([
            'name' => 'MSc ISS',
            'enrolled_students' => 500,
            'passed_students' => 490,
            'failed_students' => 10
        ]);

        Program1::create([
            'name' => 'MMA',
            'enrolled_students' => 320,
            'passed_students' => 310,
            'failed_students' => 10
        ]);

        Program1::create([
            'name' => 'MPPM',
            'enrolled_students' => 380,
            'passed_students' => 370,
            'failed_students' => 10
        ]);

        Program1::create([
            'name' => 'MDF',
            'enrolled_students' => 250,
            'passed_students' => 240,
            'failed_students' => 10
        ]);

        Program1::create([
            'name' => 'MBA-HCM',
            'enrolled_students' => 400,
            'passed_students' => 390,
            'failed_students' => 10
        ]);

        Program1::create([
            'name' => 'MBA Executives',
            'enrolled_students' => 350,
            'passed_students' => 340,
            'failed_students' => 10
        ]);

        Program1::create([
            'name' => 'MHBM',
            'enrolled_students' => 300,
            'passed_students' => 290,
            'failed_students' => 10
        ]);

        Program1::create([
            'name' => 'MSc DSA',
            'enrolled_students' => 450,
            'passed_students' => 440,
            'failed_students' => 10
        ]);

        Program1::create([
            'name' => 'MSc SET',
            'enrolled_students' => 500,
            'passed_students' => 480,
            'failed_students' => 20
        ]);

        Program1::create([
            'name' => 'MDIS',
            'enrolled_students' => 350,
            'passed_students' => 330,
            'failed_students' => 20
        ]);

        Program1::create([
            'name' => 'MSc Spectrum Management',
            'enrolled_students' => 400,
            'passed_students' => 380,
            'failed_students' => 20
        ]);

        Program1::create([
            'name' => 'MCOM',
            'enrolled_students' => 450,
            'passed_students' => 440,
            'failed_students' => 10
        ]);

        Program1::create([
            'name' => 'MAIR',
            'enrolled_students' => 300,
            'passed_students' => 290,
            'failed_students' => 10
        ]);

        Program1::create([
            'name' => 'MSc Computing',
            'enrolled_students' => 500,
            'passed_students' => 480,
            'failed_students' => 20
        ]);

        Program1::create([
            'name' => 'MSc IT',
            'enrolled_students' => 550,
            'passed_students' => 530,
            'failed_students' => 20
        ]);

        Program1::create([
            'name' => 'MSc SS',
            'enrolled_students' => 400,
            'passed_students' => 390,
            'failed_students' => 10
        ]);
    }
}
