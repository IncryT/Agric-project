<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Check if user is logged in
        if (!Auth::check()) {
            return redirect('login');
        }

        // 2. Check if the logged-in user's role matches the required role
        if (Auth::user()->role !== $role) {
            // If a farmer tries to access admin pages, show a 403 Forbidden error
            abort(403, 'Unauthorized access. You do not have the correct permissions.');
        }

        // 3. If everything is good, let them pass to the requested page
        return $next($request);
    }
}