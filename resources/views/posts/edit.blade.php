@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <!-- Card Container with White Background -->
            <div class="card shadow-lg rounded-lg border-0">
                <div class="card-body">
                    <h2 class="text-center mb-4 text-primary font-weight-bold">Edit Your Post</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> Please fix the following issues:
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('posts.update', $post->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <!-- Title Field -->
                        <div class="form-group mb-4">
                            <label for="title" class="font-weight-bold text-muted">Post Title</label>
                            <input type="text" name="title" id="title" class="form-control form-control-lg rounded-3 shadow-sm"
                                   value="{{ old('title', $post->title) }}" required placeholder="Enter post title">
                            <div class="invalid-feedback"></div>
                        </div>

                        <!-- Body Field -->
                        <div class="form-group mb-4">
                            <label for="body" class="font-weight-bold text-muted">Post Content</label>
                            <textarea name="body" id="body" class="form-control form-control-lg rounded-3 shadow-sm"
                                      rows="8" required placeholder="Write your post content here...">{{ old('body', $post->body) }}</textarea>
                            <div class="invalid-feedback"></div>
                        </div>

                        <!-- Button Group -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 py-3 transition-all hover:scale-105">Update Post</button>
                            <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary btn-lg rounded-pill px-5 py-3 transition-all hover:scale-105">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    /* Background Color - White Background */
    body {
        background-color: #ffffff;
        font-family: 'Poppins', sans-serif;
    }

    /* Card Styling with smooth shadow and rounded edges */
    .card {
        border-radius: 15px;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 30px;
        background-color: #ffffff;
        border-radius: 15px;
    }

    /* Header Styling */
    h2 {
        font-size: 2.4rem;
        letter-spacing: 1.5px;
        color: #0288d1;
        font-weight: 600;
        margin-bottom: 30px;
    }

    /* Form Fields Styling */
    .form-group {
        position: relative;
        margin-bottom: 25px;
    }

    .form-control {
        font-size: 1.1rem;
        border-radius: 8px;
        padding: 15px 20px;
        background-color: #fafafa;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        border: 1px solid #ccc;
        transition: all 0.3s ease-in-out;
    }

    .form-control:focus {
        outline: none;
        border-color: #0288d1;
        box-shadow: 0 0 8px rgba(2, 136, 209, 0.5);
        background-color: #ffffff;
    }

    .form-control-lg {
        font-size: 1.125rem;
    }

    /* Invalid Feedback */
    .invalid-feedback {
        color: #e74c3c;
        font-size: 0.9rem;
        font-weight: 400;
    }

    /* Button Styles */
    .btn {
        font-weight: 600;
        font-size: 1.1rem;
        padding: 15px 35px;
        text-transform: uppercase;
        border-radius: 30px;
        letter-spacing: 1px;
        transition: all 0.3s ease-in-out;
    }

    .btn-primary {
        background-color: #0288d1;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0277bd;
        box-shadow: 0 6px 12px rgba(0, 136, 209, 0.3);
        transform: translateY(-3px);
    }

    .btn-outline-secondary {
        background: transparent;
        border: 2px solid #0288d1;
        color: #0288d1;
    }

    .btn-outline-secondary:hover {
        background: #0288d1;
        color: white;
        border-color: #0288d1;
    }

    /* Hover Effects for Buttons */
    .transition-all {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .hover\:scale-105:hover {
        transform: scale(1.05);
    }

    /* Align Inputs and Textarea */
    .form-group input,
    .form-group textarea {
        width: 100%;
    }

    /* Loading Spinner */
    .spinner-border {
        margin-left: 10px;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 20px;
        }

        .btn {
            font-size: 1rem;
            padding: 12px 25px;
        }
    }
</style>

<script>
    // Adding smooth animation for form submission or validation feedback
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
