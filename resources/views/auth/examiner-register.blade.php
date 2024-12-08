@extends('layouts.app')

@section('content')
<div class="container-fluid examiner-registration d-flex justify-content-center align-items-start" style="height: 100vh; background-color: #f8f9fa;">
    <div class="card shadow-sm" style="max-width: 500px; width: 100%; padding: 30px; border-radius: 10px; margin-top: 50px;">
        <h1 class="text-center my-5">Examiner Registration</h1>

        <!-- Show validation errors (general errors) -->
        @if ($errors->any())
            <div class="alert alert-danger shadow-sm p-4 mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('examiner.register.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <!-- Name Field -->
                <label for="name" class="font-weight-semibold">Full Name</label>
                <input type="text" name="name" class="form-control shadow-sm" value="{{ old('name') }}" required>
                @error('name')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <!-- Email Field -->
                <label for="email" class="font-weight-semibold">Email Address</label>
                <input type="email" name="email" class="form-control shadow-sm" value="{{ old('email') }}" required>
                @error('email')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <!-- Password Field -->
                <label for="password" class="font-weight-semibold">Password</label>
                <input type="password" name="password" class="form-control shadow-sm" required>
                @error('password')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <!-- Password Confirmation Field -->
                <label for="password-confirm" class="font-weight-semibold">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control shadow-sm" required>
            </div>

            <div class="form-group">
                <!-- Contact Details Field -->
                <label for="contact_details" class="font-weight-semibold">Contact Details (Phone Number)</label>
                <input type="text" name="contact_details" class="form-control shadow-sm" value="{{ old('contact_details') }}" required>
                @error('contact_details')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <!-- CV Upload Field -->
                <label for="cv" class="font-weight-semibold">Upload CV (PDF only)</label>
                <input type="file" name="cv" class="form-control shadow-sm" required>
                @error('cv')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary btn-lg btn-block py-3 shadow-sm transition-all">Register</button>
        </form>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success shadow-sm mt-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Message -->
        @if(session('error'))
            <div class="alert alert-danger shadow-sm mt-4">
                {{ session('error') }}
            </div>
        @endif
    </div>
</div>
@endsection

@section('styles')
    <style>
        .examiner-registration {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
            background-color: #f8f9fa;
        }

        .examiner-registration .card {
    background-color: #fff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    width: 100%;
    max-width: 600px; /* Increased card size */
    padding: 30px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    margin: 0 auto; /* Center horizontally */
    margin-top: 80px; /* Push the card further down to avoid header overlap */
}

.examiner-registration .container-fluid {
    display: flex;
    justify-content: center; /* Center the card horizontally */
    align-items: flex-start; /* Align the card to the top, leaving space below */
    height: 100vh;
    padding: 0 10px; /* Ensure no horizontal overflow */
}



        .examiner-registration h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .examiner-registration .form-group {
            margin-bottom: 20px;
        }

        .examiner-registration .form-group label {
            font-size: 14px;
            color: #555;
            margin-bottom: 10px;
            display: block;
        }

        .examiner-registration .form-control {
            border-radius: 10px;
            padding: 10px;
            font-size: 14px;
            height: 35px;
            margin-bottom: 15px;
            box-shadow: none;
            width: 100%;
        }

        .examiner-registration .form-control:focus {
            border-color: #0293d3;
            box-shadow: 0 0 10px rgba(2, 147, 211, 0.6);
        }

        .examiner-registration .btn-primary {
            background-color: #6c757d;
            border-color: #6c757d;
            font-size: 16px;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease-in-out;
        }

        .examiner-registration .btn-primary:hover {
            background-color: #5a6268;
            border-color: #5a6268;
        }

        .examiner-registration .alert {
            border-radius: 8px;
            padding: 20px;
            font-size: 1rem;
        }

        .examiner-registration .text-danger {
            font-size: 0.9rem;
        }

        .examiner-registration .form-group {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .examiner-registration .form-control {
            width: 100%;
        }
    </style>
@endsection
