@extends('layouts.app')

@section('content')
<div class="container my-5">
    <!-- Post Creation Card -->
    <div class="post-container p-5 bg-white shadow-lg rounded-lg position-relative overflow-hidden">
        <div class="background-accent"></div>
        <h1 class="display-6 mb-4 text-center text-dark font-weight-bold">
            Share Your Ideas
        </h1>
        
        <!-- Create Post Form -->
        <form action="{{ route('posts.store') }}" method="POST" class="needs-validation" novalidate>
            @csrf
            <!-- Title Field -->
            <div class="form-group mb-4">
                <label for="title" class="font-weight-bold text-muted">Title</label>
                <input type="text" name="title" id="title" class="form-control form-control-lg rounded-pill shadow-sm" placeholder="Enter your post title..." required>
                <div class="invalid-feedback">.</div>
            </div>
            
            <!-- Body Field -->
            <div class="form-group mb-4">
                <label for="body" class="font-weight-bold text-muted">Content</label>
                <textarea name="body" id="body" class="form-control form-control-lg shadow-sm" rows="8" placeholder="Write your content here..." required></textarea>
                <div class="invalid-feedback"></div>
            </div>
            
            <!-- Submit Button -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-accent btn-lg px-5 py-3 shadow rounded-pill publish-btn">
                    Publish Post
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

<style>
    /* Main Container */
    .container {
        max-width: 700px;
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

    /* Form Fields */
    .form-control-lg {
        padding: 18px 20px;
        font-size: 1rem;
        border-radius: 12px;
        transition: box-shadow 0.3s, transform 0.2s;
        width: 100%; /* Ensures full width */
    }

    /* Field Focus Effect */
    .form-control-lg:focus {
        box-shadow: 0 0 8px rgba(2, 147, 211, 0.4);
        outline: none;
        background-color: #fff;
    }

    /* Button Styling */
    .btn-accent {
        background-color: #014a7f;
        color: #fff;
        font-weight: bold;
        border-radius: 25px;
        transition: all 0.3s ease;
        width: 100%; /* Ensures full width button */
        max-width: 200px; /* Limits button width for better appearance */
    }

    .btn-accent:hover {
        background-color: #027bb5;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(2, 147, 211, 0.3);
    }

    /* Button Size Increase */
    .publish-btn {
        font-size: 1.25rem; /* Larger font size */
        padding: 15px 30px; /* Increase button padding */
    }

    /* Validation Feedback */
    .invalid-feedback {
       color: #c02420;
       font-size: 0.85rem;
       font-weight: 500;
    }

    /* Placeholder Styling */
    ::placeholder {
       color: #6c757d;
       opacity: 0.8;
       font-style: italic;
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
            font-size: 1.1rem; /* Adjust button size for small screens */
            padding: 12px 25px;
        }
    }
</style>

<script>
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

       // Add event listeners for removing validation messages as user types
       var titleField = document.getElementById('title');
       var bodyField = document.getElementById('body');

       titleField.addEventListener('input', function() {
           var titleFeedback = this.nextElementSibling; // Access the next sibling (invalid-feedback)
           if (this.value.trim() !== '') {
               this.classList.remove('is-invalid');
               titleFeedback.style.display = 'none'; // Hide error message
           }
       });

       bodyField.addEventListener('input', function() {
           var bodyFeedback = this.nextElementSibling; // Access the next sibling (invalid-feedback)
           if (this.value.trim() !== '') {
               this.classList.remove('is-invalid');
               bodyFeedback.style.display = 'none'; // Hide error message
           }
       });
    })();
</script>
