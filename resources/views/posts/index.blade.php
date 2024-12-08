@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="page-title">Discussion Forum</h1>

    <!-- Sticky "Create New Post" Button -->
    @if(Auth::check() && (Auth::user()->isStudent() || Auth::user()->isStaff() || Auth::user()->isAdmin()))
        <a href="{{ route('posts.create') }}" class="btn btn-primary create-post-btn fixed-btn" aria-label="Create a new post">Create New Post</a>
    @endif

    <hr>
    <div class="posts-container">
        @foreach ($posts as $post)
            <article class="card post-card mb-4">
                <header class="card-header post-card-header">
                    <h2 class="post-title">{{ $post->title }}</h2>
                    <div class="post-meta">
                        <span class="author">by {{ $post->user->name }}</span>
                        <span class="role-badge {{ $post->user->role }}">{{ ucfirst($post->user->role) }}</span> 
                        <span class="post-date">{{ $post->created_at->format('d M Y') }}</span>
                    </div>
                </header>
                <div class="card-body post-card-body">
                    <p>{{ \Illuminate\Support\Str::limit($post->body, 150) }}</p>
                    <a href="{{ route('posts.show', $post->id) }}" class="btn btn-secondary" aria-label="View post">View Post</a>

                    {{-- Edit button for the post owner --}}
                    @if(Auth::check() && Auth::user()->id === $post->user_id)
                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning" aria-label="Edit this post">Edit</a>
                    @endif

                    {{-- Delete button for post owners or admins --}}
                    @if(Auth::check() && (Auth::user()->id === $post->user_id || Auth::user()->isAdmin()))
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" aria-label="Delete this post">Delete</button>
                        </form>
                    @endif
                </div>
            </article>
        @endforeach
    </div>

    <!-- Pagination Links -->
    <div class="pagination-footer">
        {{ $posts->links('pagination::bootstrap-4') }} <!-- Use bootstrap-4 styled pagination for a cleaner look -->
    </div>
</div>

{{-- Enhanced CSS for Discussion Forum Page --}}
<style>
    /* General Container */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px;
    }

    /* Page Title */
    .page-title {
        font-size: 2.5rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 30px;
        text-align: center;
    }

    /* Sticky Create New Post Button */
    .fixed-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 100;
        animation: slideUp 0.3s ease-out;
    }

    /* Animation for button */
    @keyframes slideUp {
        from {
            transform: translateY(100%);
        }
        to {
            transform: translateY(0);
        }
    }

    /* Post Card */
    .post-card {
        border: 1px solid #ddd;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        background-color: #fff;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .post-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    }

    /* Post Card Header */
    .post-card-header {
        background-color: #f4f6f9;
        padding: 20px;
        font-size: 1.3rem;
        font-weight: bold;
        color: #333;
        border-bottom: 2px solid #ddd;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .post-title {
        color: #333;
        margin-right: 15px;
        font-size: 1.2rem;
    }

    .post-meta {
        font-size: 0.9rem;
        color: #777;
        text-align: right;
    }

    .author {
        font-style: italic;
    }

    .post-date {
        font-weight: bold; /* Changed for better visibility */
    }

    /* Post Content */
    .post-card-body {
        padding: 20px;
        font-size: 1rem;
        line-height: 1.6;
        color: #555;
    }

    .post-card-body p {
        margin-bottom: 20px;
    }

    /* Button Styles */
    .btn {
        border-radius: 25px; /* More rounded buttons */
        padding: 10px 20px; /* Consistent padding */
        font-size: 1rem; /* Consistent font size */
        font-weight: bold; /* More emphasis on buttons */
        transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s; /* Smooth transitions */
    }

    /* Create New Post Button */
    .btn-primary {
        background-color: #007bff; /* Bootstrap primary color */
        border-color: #007bff; 
        color: white; /* Ensuring text is visible on primary button */
        box-shadow: none; /* Remove shadow for primary button */
        border: none; /* Remove border for primary button */
    }

    .btn-primary:hover {
        background-color: #0056b3; /* Darker shade on hover */
        transform: none; 
        box-shadow: none; 
    }

    /* View Post, Edit, and Delete Buttons */
    .btn-secondary,
    .btn-warning,
    .btn-danger {
        color: white; /* Ensuring text is visible on secondary/warning/danger buttons */ 
    }

    .btn-secondary { 
        background-color: #6c757d; 
    }

    .btn-secondary:hover { 
        background-color: #5a6268; 
    }

    .btn-warning { 
        background-color: #ffc107; 
    }

    .btn-warning:hover { 
        background-color: #e0a800; 
    }

    .btn-danger { 
        background-color: #dc3545; 
    }

    .btn-danger:hover { 
        background-color: #c82333; 
    }

    /* Role Badge Styling */
    .role-badge {
        display: inline-block; 
        padding: 0.5em 0.75em; 
        border-radius: 0.25em; 
        font-size: 0.9rem; 
        background-color: #f1f1f1; 
        color: #555; 
    }

    .role-badge.student { background-color: #28a745; color: white;}
    .role-badge.staff { background-color: #ffc107; color: white;}
    .role-badge.admin { background-color: #dc3545; color: white;}

    /* Pagination Footer */
    .pagination-footer {
        margin-top: 40px;
        text-align: center;
    }

    /* Pagination Styling */
    .pagination {
        display: inline-flex; /* Aligns pagination links horizontally */
        justify-content: center; 
        margin-top: 20px; 
        padding: 10px 0;
        width: 100%;
    }

    .pagination a,
    .pagination .page-item .page-link {
        margin: 0.3em;
        padding: 5px 15px;
        border-radius: 5px;
        text-decoration: none;
        background-color: #f8f9fa;
        color: #333;
        font-size: 0.9rem;
        transition: background-color 0.3s, color 0.3s;
    }

    .pagination a:hover,
    .pagination .page-item .page-link:hover {
        background-color: #e9ecef;
        color: #007bff; /* Blue color for hover state */
    }

    .pagination .active .page-link {
        background-color: #007bff;
        color: white;
    }

    .pagination .disabled .page-link {
        background-color: #ccc;
        color: #aaa;
        cursor: not-allowed;
    }

    /* Fix the size of the arrow buttons */
    .pagination .page-link {
        padding: 5px 10px;
    }
</style>
@endsection
