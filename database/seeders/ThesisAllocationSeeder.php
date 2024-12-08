<?php

namespace Database\Seeders;

use App\Models\ThesisAllocation;
use Illuminate\Database\Seeder;

class ThesisAllocationSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['label' => 'Thesis Allocation', 'parent' => '', 'value' => 300],
            ['label' => '2023', 'parent' => 'Thesis Allocation', 'value' => 150],
            ['label' => '2024', 'parent' => 'Thesis Allocation', 'value' => 150],

            ['label' => 'Dr. Jane Anderson', 'parent' => '2023', 'value' => 30],
            ['label' => 'Prof. Michael Roberts', 'parent' => '2023', 'value' => 25],
            ['label' => 'Dr. Sarah Patel', 'parent' => '2023', 'value' => 20],
            ['label' => 'Prof. David Chen', 'parent' => '2023', 'value' => 25],
            ['label' => 'Dr. Emily Smith', 'parent' => '2023', 'value' => 20],

            ['label' => 'Dr. John O\'Reilly', 'parent' => '2024', 'value' => 35],
            ['label' => 'Prof. Linda Garza', 'parent' => '2024', 'value' => 30],
            ['label' => 'Dr. James Thompson', 'parent' => '2024', 'value' => 25],
            ['label' => 'Prof. Aisha Mahmoud', 'parent' => '2024', 'value' => 20],
            ['label' => 'Dr. Rajesh Kapoor', 'parent' => '2024', 'value' => 20],

            ['label' => 'EProf. Sandra Lee', 'parent' => '2023', 'value' => 15],
            ['label' => 'Dr. William Brown', 'parent' => '2023', 'value' => 18],
            ['label' => 'Prof. Hannah Wilson', 'parent' => '2023', 'value' => 20],
            ['label' => 'Dr. Carlos Martinez', 'parent' => '2023', 'value' => 22],
            ['label' => 'Prof. Laura Turner', 'parent' => '2023', 'value' => 20],

            ['label' => 'Dr. Alexander Nguyen', 'parent' => '2024', 'value' => 25],
            ['label' => 'Prof. Deborah Clark', 'parent' => '2024', 'value' => 18],
            ['label' => 'Dr. Olivia Perez', 'parent' => '2024', 'value' => 15],
            ['label' => 'Prof. Samuel Edwards', 'parent' => '2024', 'value' => 22],
            ['label' => 'Dr. Fatima Khan', 'parent' => '2024', 'value' => 20],
        ];

        foreach ($data as $entry) {
            ThesisAllocation::create($entry);
        }
    }
}

