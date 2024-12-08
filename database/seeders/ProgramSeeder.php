<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    public function run()
    {
        $programs = [
            ['name' => 'MSc MFRA', 'students_count' => 50, 'enrolled_students' => 45, 'thesis_topics' => 10, 'approved_theses' => 8, 'disapproved_theses' => 2, 'examiner_duration_0_2' => 5, 'examiner_duration_2_5' => 7, 'examiner_duration_5_10' => 3, 'examiner_duration_10_plus' => 0, 'average_response_time' => 40],
            ['name' => 'MSc Biomathematics', 'students_count' => 60, 'enrolled_students' => 55, 'thesis_topics' => 15, 'approved_theses' => 12, 'disapproved_theses' => 3, 'examiner_duration_0_2' => 4, 'examiner_duration_2_5' => 9, 'examiner_duration_5_10' => 5, 'examiner_duration_10_plus' => 2, 'average_response_time' => 50],
            ['name' => 'MAPE', 'students_count' => 40, 'enrolled_students' => 35, 'thesis_topics' => 8, 'approved_theses' => 6, 'disapproved_theses' => 2, 'examiner_duration_0_2' => 3, 'examiner_duration_2_5' => 6, 'examiner_duration_5_10' => 2, 'examiner_duration_10_plus' => 1, 'average_response_time' => 42],
            ['name' => 'MEM', 'students_count' => 45, 'enrolled_students' => 40, 'thesis_topics' => 10, 'approved_theses' => 7, 'disapproved_theses' => 3, 'examiner_duration_0_2' => 4, 'examiner_duration_2_5' => 5, 'examiner_duration_5_10' => 3, 'examiner_duration_10_plus' => 1, 'average_response_time' => 48],
            ['name' => 'LLM', 'students_count' => 55, 'enrolled_students' => 50, 'thesis_topics' => 12, 'approved_theses' => 9, 'disapproved_theses' => 3, 'examiner_duration_0_2' => 6, 'examiner_duration_2_5' => 7, 'examiner_duration_5_10' => 2, 'examiner_duration_10_plus' => 1, 'average_response_time' => 55],
            ['name' => 'MSc ISS', 'students_count' => 50, 'enrolled_students' => 48, 'thesis_topics' => 11, 'approved_theses' => 8, 'disapproved_theses' => 3, 'examiner_duration_0_2' => 5, 'examiner_duration_2_5' => 7, 'examiner_duration_5_10' => 3, 'examiner_duration_10_plus' => 0, 'average_response_time' => 44],
            ['name' => 'MMA', 'students_count' => 60, 'enrolled_students' => 55, 'thesis_topics' => 14, 'approved_theses' => 10, 'disapproved_theses' => 4, 'examiner_duration_0_2' => 7, 'examiner_duration_2_5' => 6, 'examiner_duration_5_10' => 4, 'examiner_duration_10_plus' => 1, 'average_response_time' => 50],
            ['name' => 'MPPM', 'students_count' => 45, 'enrolled_students' => 43, 'thesis_topics' => 9, 'approved_theses' => 6, 'disapproved_theses' => 3, 'examiner_duration_0_2' => 4, 'examiner_duration_2_5' => 6, 'examiner_duration_5_10' => 2, 'examiner_duration_10_plus' => 1, 'average_response_time' => 47],
            ['name' => 'MDF', 'students_count' => 50, 'enrolled_students' => 47, 'thesis_topics' => 10, 'approved_theses' => 8, 'disapproved_theses' => 2, 'examiner_duration_0_2' => 5, 'examiner_duration_2_5' => 7, 'examiner_duration_5_10' => 3, 'examiner_duration_10_plus' => 0, 'average_response_time' => 46],
            ['name' => 'MBA-HCM', 'students_count' => 70, 'enrolled_students' => 65, 'thesis_topics' => 16, 'approved_theses' => 12, 'disapproved_theses' => 4, 'examiner_duration_0_2' => 8, 'examiner_duration_2_5' => 10, 'examiner_duration_5_10' => 5, 'examiner_duration_10_plus' => 2, 'average_response_time' => 60],
            ['name' => 'MBA Executives', 'students_count' => 60, 'enrolled_students' => 58, 'thesis_topics' => 13, 'approved_theses' => 11, 'disapproved_theses' => 2, 'examiner_duration_0_2' => 6, 'examiner_duration_2_5' => 8, 'examiner_duration_5_10' => 3, 'examiner_duration_10_plus' => 1, 'average_response_time' => 52],
            ['name' => 'MHBM', 'students_count' => 55, 'enrolled_students' => 50, 'thesis_topics' => 12, 'approved_theses' => 9, 'disapproved_theses' => 3, 'examiner_duration_0_2' => 6, 'examiner_duration_2_5' => 7, 'examiner_duration_5_10' => 4, 'examiner_duration_10_plus' => 1, 'average_response_time' => 58],
            ['name' => 'MSc DSA', 'students_count' => 65, 'enrolled_students' => 60, 'thesis_topics' => 14, 'approved_theses' => 11, 'disapproved_theses' => 3, 'examiner_duration_0_2' => 7, 'examiner_duration_2_5' => 9, 'examiner_duration_5_10' => 4, 'examiner_duration_10_plus' => 1, 'average_response_time' => 56],
            ['name' => 'MSc SET', 'students_count' => 45, 'enrolled_students' => 40, 'thesis_topics' => 9, 'approved_theses' => 7, 'disapproved_theses' => 2, 'examiner_duration_0_2' => 5, 'examiner_duration_2_5' => 6, 'examiner_duration_5_10' => 3, 'examiner_duration_10_plus' => 1, 'average_response_time' => 50],
            ['name' => 'MDIS', 'students_count' => 60, 'enrolled_students' => 58, 'thesis_topics' => 13, 'approved_theses' => 10, 'disapproved_theses' => 3, 'examiner_duration_0_2' => 6, 'examiner_duration_2_5' => 8, 'examiner_duration_5_10' => 4, 'examiner_duration_10_plus' => 2, 'average_response_time' => 62],
            ['name' => 'MSc Spectrum Management', 'students_count' => 50, 'enrolled_students' => 48, 'thesis_topics' => 11, 'approved_theses' => 8, 'disapproved_theses' => 3, 'examiner_duration_0_2' => 5, 'examiner_duration_2_5' => 6, 'examiner_duration_5_10' => 3, 'examiner_duration_10_plus' => 1, 'average_response_time' => 49],
            ['name' => 'MCOM', 'students_count' => 55, 'enrolled_students' => 52, 'thesis_topics' => 12, 'approved_theses' => 9, 'disapproved_theses' => 3, 'examiner_duration_0_2' => 6, 'examiner_duration_2_5' => 8, 'examiner_duration_5_10' => 4, 'examiner_duration_10_plus' => 1, 'average_response_time' => 55],
            ['name' => 'MAIR', 'students_count' => 50, 'enrolled_students' => 45, 'thesis_topics' => 10, 'approved_theses' => 8, 'disapproved_theses' => 2, 'examiner_duration_0_2' => 5, 'examiner_duration_2_5' => 7, 'examiner_duration_5_10' => 3, 'examiner_duration_10_plus' => 0, 'average_response_time' => 48],
            ['name' => 'MSc Computing', 'students_count' => 60, 'enrolled_students' => 58, 'thesis_topics' => 13, 'approved_theses' => 10, 'disapproved_theses' => 3, 'examiner_duration_0_2' => 6, 'examiner_duration_2_5' => 8, 'examiner_duration_5_10' => 4, 'examiner_duration_10_plus' => 1, 'average_response_time' => 54],
            ['name' => 'MSc IT', 'students_count' => 55, 'enrolled_students' => 50, 'thesis_topics' => 12, 'approved_theses' => 9, 'disapproved_theses' => 3, 'examiner_duration_0_2' => 6, 'examiner_duration_2_5' => 7, 'examiner_duration_5_10' => 4, 'examiner_duration_10_plus' => 1, 'average_response_time' => 51],
            ['name' => 'MSc SS', 'students_count' => 40, 'enrolled_students' => 35, 'thesis_topics' => 8, 'approved_theses' => 6, 'disapproved_theses' => 2, 'examiner_duration_0_2' => 4, 'examiner_duration_2_5' => 6, 'examiner_duration_5_10' => 3, 'examiner_duration_10_plus' => 0, 'average_response_time' => 45],
        ];

        // Insert the programs into the database
        foreach ($programs as $program) {
            Program::create($program);
        }
    }
}


