<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        // Ensure the user is authenticated and has the correct role
        if (!Auth::check() || Auth::user()->role !== $role) {
            // Redirect unauthorized users to the home page
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        // Allow the request to proceed
        return $next($request);
    }
}
