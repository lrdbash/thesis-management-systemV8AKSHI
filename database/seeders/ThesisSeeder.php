<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Thesis;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ThesisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Generate 10 dummy theses
        for ($i = 1; $i <= 10; $i++) {
            Thesis::create([
                'title' => 'Research on Topic ' . $i,  // Generate a thesis title
                'author' => 'Author ' . $i,  // Generate author names
                'approved' => rand(0, 1) == 1,  // Randomly set the approval status
            ]);
        }
    }
}
