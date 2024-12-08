

@section('content')
<div class="container " style="max-width: 400px; margin-top: -5px;">
    <div class="card shadow-lg" id="login-card">
        <div class="card-header text-center" style="background-color: #f8f9fa; border-bottom: none;">
            <h4 style="margin-bottom: 0;text-align: center">{{ __('Login') }}</h4>
        </div>

        <div class="card-body" style="padding: 20px 30px;">
            <form method="POST" action="{{ route('login') }}" id="login-form">
                @csrf

                <div class="form-group">
                    <label for="email" class="col-form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="col-form-label">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>

                <div class="form-group mb-0 mt-3">
                    <button type="submit" class="btn btn-primary w-100" style="background-color: #6c757d; border-color: #6c757d;">
                        {{ __('Login') }}
                    </button>
                </div>

                <div class="form-group mt-3 text-center">
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@include('layouts.app')
<style>
    /* General styles */
    .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px;
        }
        .login {
        display: flex;
        justify-content: center;  /* Horizontally center the content */
        height: auto;  /* Removed the 100vh height to reduce the white space */
    }
    #login-card {
        border-radius: 8px;
        border: none;
        background-color: white;
    }

    .card-header {
        background-color: #f8f9fa;
        border-bottom: none;
    }

    .card-body {
        padding: 20px 30px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    #login-form .form-group {
        width: 100%;
        margin-bottom: 15px; /* Reduced space between fields */
    }

    #login-form .form-group label {
        font-size: 14px;
        color: #555;
    }

    #login-form .form-control {
        width: 100%;
        border-radius: 5px;
        box-shadow: none;
        height: 35px; /* Reduced height of input fields */
        padding: 10px;
    }

    .form-check-label {
        font-size: 14px;
    }

    .btn-primary {
        background-color: #6c757d;
        border-color: #6c757d;
        font-size: 16px;
        padding: 12px; /* Reduced padding for the button */
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #5a6268;
        border-color: #5a6268;
    }

    .btn-link {
        font-size: 14px;
        color: #6c757d;
    }

    .btn-link:hover {
        text-decoration: underline;
    }
</style>
