<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Fetch all posts
        $posts = Post::all();

        // Fetch all users for commenting
        $users = User::whereIn('role', ['student', 'staff'])->get();

        // Create comments for each post
        foreach ($posts as $post) {
            foreach ($users as $user) {
                Comment::create([
                    'body' => 'This is a comment on the post "' . $post->title . '" by ' . $user->name . '. I think the thesis on this topic is very important!',
                    'post_id' => $post->id,
                    'user_id' => $user->id,  // associate comment with the user
                ]);
            }
        }
    }
}
