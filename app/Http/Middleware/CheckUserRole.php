<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, $roles)) {
            \Log::info('Access Denied for User: ' . Auth::user()->name);
            return redirect('/'); // Redirect to home page or another appropriate page
        }

        return $next($request);
    }
}
