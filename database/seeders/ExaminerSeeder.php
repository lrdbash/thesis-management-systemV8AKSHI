<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Examiner;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class ExaminerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 10 examiners
        for ($i = 1; $i <= 10; $i++) {
            Examiner::create([
                'name' => "Examiner {$i}",  // Sample name
                'contact_details' => "123-456-789{$i}", // Sample contact
                'email' => "examiner{$i}@example.com", // Sample email
                'cv_path' => 'public/cv/sample_cv.pdf', // Path to a sample CV (You should upload a real sample to storage/app/public/cv)
                'registered_at' => Carbon::now(), // Registration date is now
                'registration_expires_at' => Carbon::now()->addYears(4), // Expires in 4 years
                'created_at' => Carbon::now(), // Creation timestamp
                'updated_at' => Carbon::now(), // Update timestamp
                'role' => 'examiner', // Role is set to examiner
                'password' => Hash::make('password'), // Hash the password
            ]);
        }
    }
}
