<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Fetch users with 'student' or 'staff' role
        $users = User::whereIn('role', ['student', 'staff'])->get();

        // Create sample posts with random users
        foreach ($users as $user) {
            Post::create([
                'title' => 'Thesis Discussion: ' . $user->name,
                'body' => 'This is a discussion post related to thesis work by ' . $user->name . '. Let’s talk about various thesis topics and issues we face in the process.',
                'user_id' => $user->id,  // associate post with the user
            ]);
        }
    }
}
