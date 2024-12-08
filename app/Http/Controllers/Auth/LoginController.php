<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/posts';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect users after login.
     *
     * @return string
     */
    protected function redirectTo()
    {
        // Redirect based on user roles
        if (auth()->user()->isAdmin()) {
            return '/posts';
        } elseif (auth()->guard('examiner')->check()) {
            return '/examiner/dashboard';
        } else {
            // Redirect all other users to the discussion forum
            return route('posts.index');
        }
    }
    
}
