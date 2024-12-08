<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
   // App\Http\Controllers\PostController.php

public function index()
{
    // Paginate posts with 10 items per page
    $posts = Post::latest()->paginate(10);

    return view('posts.index', compact('posts'));
}


    public function create()
    {
        //dd('Create method called');
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function destroy(Post $post)
    {
        // Check if the authenticated user is the owner of the post or an admin
        if (Auth::user()->id === $post->user_id || Auth::user()->isAdmin()) {
            $post->delete();
            return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
        }
    
        return redirect()->route('posts.index')->with('error', 'Unauthorized action.');
    }
    

    public function edit(Post $post)
{
    // Check if the authenticated user is the owner of the post
    if (Auth::user()->id !== $post->user_id) {
        return redirect()->route('posts.index')->with('error', 'You do not have permission to edit this post.');
    }

    return view('posts.edit', compact('post'));
}

    public function update(Request $request, Post $post)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        // Check if the authenticated user is the owner of the post
        if (Auth::user()->id !== $post->user_id) {
            return redirect()->route('posts.index')->with('error', 'You do not have permission to update this post.');
        }

        // Update the post
        $post->update($request->all());

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }
}
