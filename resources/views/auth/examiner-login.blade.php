

@section('content')
<!-- Center the content horizontally with reduced vertical white space -->
<div class="container d-flex justify-content-center page-login">
    <div class="card shadow-lg" id="login-card" style="max-width: 400px; width: 100%; margin-top: 50px; margin-bottom: 50px;">
        <div class="card-header text-center" style="background-color: #f8f9fa; border-bottom: none;">
            <h4 style="margin-bottom: 0; font-size: 18px; text-align: center;">Examiner Login</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('examiner.login') }}" id="login-form">
                @csrf

                <div class="form-group">
                    <label for="email" class="col-form-label" style="font-size: 14px;">Email Address</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="col-form-label" style="font-size: 14px;">Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-0 mt-4 text-center">
                    <button type="submit" class="btn btn-primary" style="background-color: #014a7f; border-color: #014a7f; padding: 12px; font-size: 16px; transition: background-color 0.3s, transform 0.3s;">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@include('layouts.app')

<style>
    /* Scoped styles for the login page only */
    /* General styles */
    .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px;
        }
    .page-login {
        display: flex;
        justify-content: center;  /* Horizontally center the content */
        height: auto;  /* Removed the 100vh height to reduce the white space */
    }

    .page-login #login-card {
        border-radius: 8px;
        border: none;
        background-color: white;
    }

    .page-login .card-header {
        background-color: #f8f9fa;
        border-bottom: none;
    }

    .page-login .card-body {
        padding: 20px 30px;
        display: flex;
        flex-direction: column;
        align-items: center; /* Horizontally center the content */
        justify-content: center; /* Vertically center the content */
    }

    .page-login #login-form .form-group {
        width: 100%;
        margin-bottom: 15px; /* Space between form fields */
    }

    .page-login #login-form .form-group label {
        font-size: 14px;
        color: #555;
    }

    .page-login #login-form .form-control {
        width: 100%;
        border-radius: 5px;
        box-shadow: none;
        height: 35px;
        padding: 10px;
    }

    /* Center the button horizontally */
    .page-login .form-group.mb-0.mt-4.text-center {
        display: flex;
        justify-content: center;
    }

    .page-login .btn-primary {
        background-color: #014a7f;
        border-color: #014a7f;
        font-size: 16px;
        padding: 12px;
        border-radius: 5px;
        transition: background-color 0.3s, transform 0.3s;
    }

    .page-login .btn-primary:hover {
        background-color: #013b62;
        border-color: #013b62;
        transform: scale(1.05); /* Button scale effect on hover */
    }

    .page-login .btn-link {
        font-size: 14px;
        color: #6c757d;
    }

    .page-login .btn-link:hover {
        text-decoration: underline;
    }

    /* Navigation Bar - To ensure it remains unaffected */
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
        background-color: #014a7f;  /* Strathmore's Blue */
    }

    .navbar a {
        color: white;
        font-size: 16px;
    }
</style>
