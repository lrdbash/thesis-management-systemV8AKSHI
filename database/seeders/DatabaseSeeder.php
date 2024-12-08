<?php

namespace Database\Seeders;

use App\Models\Intake;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed users
        $this->call([
            UserSeeder::class,
            ExaminerSeeder::class,
            PostSeeder::class,
            CommentSeeder::class,
        ]);

        // Seed intakes with chapters as JSON
        $intake1 = Intake::create([
            'name' => '2024 Intake - SBS',
            'chapters' => json_encode([
                ['name' => 'Chapter 1', 'deadline' => '2024-01-15'],
                ['name' => 'Chapter 2', 'deadline' => '2024-02-15'],
            ]),
            'final_submission_deadline' => '2024-04-15',
            'presentation_date' => '2024-05-15',
            'status' => 'open',
        ]);

        $intake2 = Intake::create([
            'name' => '2025 Intake - SIMMS',
            'chapters' => json_encode([
                ['name' => 'Chapter 1', 'deadline' => '2025-01-15'],
                ['name' => 'Chapter 2', 'deadline' => '2025-02-15'],
                ['name' => 'Chapter 3', 'deadline' => '2025-03-15'],
            ]),
            'final_submission_deadline' => '2025-04-15',
            'presentation_date' => '2025-05-15',
            'status' => 'open',
        ]);

        $intake3 = Intake::create([
            'name' => '2025 Intake - SCES',
            'chapters' => json_encode([
                ['name' => 'Chapter 1', 'deadline' => '2025-01-15'],
                ['name' => 'Chapter 2', 'deadline' => '2025-02-15'],
                ['name' => 'Chapter 3', 'deadline' => '2025-03-15'],
                ['name' => 'Chapter 4', 'deadline' => '2025-04-15'],
                ['name' => 'Chapter 5', 'deadline' => '2025-05-15'],
            ]),
            'final_submission_deadline' => '2025-06-15',
            'presentation_date' => '2025-07-15',
            'status' => 'open',
        ]);

        // Seed users and assign intakes (keeping random names but changing email domain to @strathmore.edu)
        User::factory()->count(5)->create([
            'role' => 'student',
        ])->each(function ($user) use ($intake3) {
            $user->update([
                'email' => strtolower(str_replace(' ', '_', $user->name)) . '@strathmore.edu',
            ]);
            $user->intakes()->attach($intake3->id);
        });

        User::factory()->count(5)->create([
            'role' => 'student',
        ])->each(function ($user) use ($intake2) {
            $user->update([
                'email' => strtolower(str_replace(' ', '_', $user->name)) . '@strathmore.edu',
            ]);
            $user->intakes()->attach($intake2->id);
        });

        User::factory()->count(5)->create([
            'role' => 'student',
        ])->each(function ($user) use ($intake1) {
            $user->update([
                'email' => strtolower(str_replace(' ', '_', $user->name)) . '@strathmore.edu',
            ]);
            $user->intakes()->attach($intake1->id);
        });

        // Seed forum posts and comments
        $this->call([
            PostSeeder::class,
            CommentSeeder::class,
        ]);
    }
}
