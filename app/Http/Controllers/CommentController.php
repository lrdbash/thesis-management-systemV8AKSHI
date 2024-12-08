<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'body' => 'required|string',
        ]);

        Comment::create([
            'body' => $request->body,
            'user_id' => Auth::id(),
            'post_id' => $post->id,
        ]);

        return redirect()->route('posts.show', $post->id)->with('success', 'Comment added successfully.');
    }

    public function edit(Comment $comment)
    {
        // Check if the authenticated user is the owner of the comment
        if (Auth::user()->id !== $comment->user_id) {
            return redirect()->route('posts.index')->with('error', 'You do not have permission to edit this comment.');
        }

        return view('posts.show', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'body' => 'required|string',
        ]);

        // Check if the authenticated user is the owner of the comment
        if (Auth::user()->id !== $comment->user_id) {
            return redirect()->route('posts.index')->with('error', 'You do not have permission to update this comment.');
        }

        $comment->update($request->all());

        return redirect()->route('posts.show', $comment->post_id)->with('success', 'Comment updated successfully.');
    }

    public function destroy(Comment $comment)
    {
        // Allow deletion if the user is the owner of the comment or an admin
        if (Auth::user()->id === $comment->user_id || Auth::user()->isAdmin()) {
            $comment->delete();
            return redirect()->route('posts.show', $comment->post_id)->with('success', 'Comment deleted successfully.');
        }

        return redirect()->route('posts.index')->with('error', 'Unauthorized action.');
    }
}
