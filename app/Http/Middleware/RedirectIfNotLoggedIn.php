<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotLoggedIn
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/'); // Redirect to home page or login page
        }

        return $next($request);
    }
}