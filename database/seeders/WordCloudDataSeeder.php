<?php

namespace Database\Seeders;

use App\Models\WordCloudData;
use Illuminate\Database\Seeder;

class WordCloudDataSeeder extends Seeder
{
    public function run()
    {
        $words = [
            ['word' => 'Thesis', 'value' => 100],
            ['word' => 'Program', 'value' => 80],
            ['word' => 'Student', 'value' => 60],
            ['word' => 'Examiners', 'value' => 50],
            ['word' => 'Academic', 'value' => 40],
            ['word' => 'Research', 'value' => 90],
            ['word' => 'Dissertation', 'value' => 75],
            ['word' => 'Graduation', 'value' => 85],
            ['word' => 'Professor', 'value' => 70],
            ['word' => 'University', 'value' => 95],
            ['word' => 'Scholarship', 'value' => 65],
            ['word' => 'Lecture', 'value' => 55],
            ['word' => 'Curriculum', 'value' => 60],
            ['word' => 'Seminar', 'value' => 50],
            ['word' => 'Publication', 'value' => 45],
            ['word' => 'Mentorship', 'value' => 40],
            ['word' => 'Academic Integrity', 'value' => 35],
            ['word' => 'Peer Review', 'value' => 50],
            ['word' => 'Assessment', 'value' => 60],
            ['word' => 'Examination', 'value' => 55],
        ];

        // Insert words into the database
        foreach ($words as $word) {
            WordCloudData::create($word);
        }
    }
}

