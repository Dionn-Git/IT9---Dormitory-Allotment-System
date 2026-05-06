<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check if user has the required role
        if (Auth::user()->role !== $role) {

            // Redirect to correct dashboard instead of showing 403
            if (Auth::user()->role === 'landlord') {
                return redirect()->route('employee.dashboard');
            }

            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}