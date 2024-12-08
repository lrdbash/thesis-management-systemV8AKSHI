@extends('layouts.app')

@section('content')
<div class="container my-5">
    <!-- Post Content -->
    <div class="post-container p-5 bg-white shadow-lg rounded-lg position-relative overflow-hidden">
        <div class="background-accent"></div>
        <h1 class="display-6 mb-4 text-center text-dark font-weight-bold">{{ $post->title }}</h1>
        <p class="text-muted">{{ $post->body }}</p>
        <p class="text-muted">
            Posted by: {{ $post->user->name }} 
            <span class="role-badge {{ $post->user->role }}">{{ ucfirst($post->user->role) }}</span>
        </p>
    </div>
    <hr>

    <!-- Comments Section -->
    <h3 class="my-4">Comments</h3>
    @foreach ($post->comments as $comment)
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <div class="comment-body">
                    {{ $comment->body }} 
                    - <small class="text-muted">by {{ $comment->user->name }} 
                    <span class="role-badge {{ $comment->user->role }}">{{ ucfirst($comment->user->role) }}</span></small>
                </div>

                {{-- Buttons for comment owner and admins --}}
                @if(Auth::check())
                    @if(Auth::user()->id === $comment->user_id || Auth::user()->isAdmin())
                        <!-- Edit Button -->
                        <button class="btn btn-warning btn-sm" onclick="toggleEditForm({{ $comment->id }})">Edit</button>

                        <!-- Delete Button -->
                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>

                        {{-- Edit form (initially hidden) --}}
                        <div id="edit-form-{{ $comment->id }}" style="display:none;">
                            <form action="{{ route('comments.update', $comment->id) }}" method="POST" style="margin-top: 10px;">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <textarea name="body" class="form-control" rows="3" required>{{ old('body', $comment->body) }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Comment</button>
                                <button type="button" class="btn btn-secondary" onclick="toggleEditForm({{ $comment->id }})">Cancel</button>
                            </form>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    @endforeach

    @if(Auth::check() && (Auth::user()->isStudent() || Auth::user()->isStaff() || Auth::user()->isAdmin()))
        <!-- Comment Form -->
        <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mt-4">
            @csrf
            <div class="form-group">
                <textarea name="body" class="form-control" rows="4" style="width: 100%;" required placeholder="Add a comment..."></textarea>
            </div>
            <button type="submit" class="btn btn-accent btn-lg mx-auto d-block">Post Comment</button>
        </form>
    @endif
</div>

<script>
function toggleEditForm(commentId) {
    const editForm = document.getElementById('edit-form-' + commentId);
    if (editForm.style.display === "none" || editForm.style.display === "") {
        editForm.style.display = "block"; // Show the edit form
    } else {
        editForm.style.display = "none"; // Hide the edit form
    }
}
</script>
@endsection

<style>
    /* Main Container */
    .container {
        max-width: 800px;
    }

    /* Post Container Styling */
    .post-container {
        background: #fdfdfd;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.15);
        position: relative;
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .post-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
    }

    /* Background Accent */
    .background-accent {
        position: absolute;
        top: -50px;
        left: -50px;
        width: 300px;
        height: 300px;
        background: linear-gradient(135deg, #0293d3, #c02420);
        border-radius: 50%;
        opacity: 0.1;
        z-index: -1;
        animation: pulse 10s infinite alternate ease-in-out;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        100% {
            transform: scale(1.2);
        }
    }

    /* Typography */
    .display-6 {
        font-size: 2.25rem;
        color: #333;
        font-weight: bold;
        letter-spacing: 0.03em;
    }

    /* Comment Section Styling */
    .comment-body {
        font-size: 1rem;
        color: #555;
    }

    .role-badge {
        background-color: #0293d3;
        color: #fff;
        border-radius: 15px;
        padding: 5px 10px;
        font-size: 0.9rem;
    }

    /* Button Styling */
    .btn-accent {
        background-color: #0293d3;
        color: #fff;
        font-weight: bold;
        border-radius: 25px;
        transition: all 0.3s ease;
        width: 100%;
        max-width: 200px;
    }

    .btn-accent:hover {
        background-color: #027bb5;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(2, 147, 211, 0.3);
    }

    /* Publish Button */
    .publish-btn {
        font-size: 1.25rem;
        padding: 15px 30px;
    }

    /* Edit Button */
    .btn-warning {
        background-color: #f0ad4e;
        color: white;
        border-radius: 20px;
    }

    .btn-warning:hover {
        background-color: #ec971f;
    }

    /* Delete Button */
    .btn-danger {
        background-color: #d9534f;
        color: white;
        border-radius: 20px;
    }

    .btn-danger:hover {
        background-color: #c9302c;
    }

    /* Mobile Responsiveness */
    @media (max-width: 576px) {
        .display-6 {
            font-size: 1.75rem;
        }

        .form-control-lg {
            padding: 14px;
            font-size: 0.9rem;
        }

        .publish-btn {
            font-size: 1.1rem;
            padding: 12px 25px;
        }
    }
</style>
