<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserLoggedIn
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user session exists
        if (!$request->session()->has('user_id')) {
            return redirect('/login')->with('error', 'Please log in first.');
        }

        return $next($request);
    }
}
