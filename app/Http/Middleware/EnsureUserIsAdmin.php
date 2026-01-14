<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Ensure User Is Admin Middleware
 * Following Single Responsibility Principle - only handles admin authorization check
 * Following Open/Closed Principle - can be extended without modification
 */
class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request
     * Checks if the authenticated user is an admin
     * 
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!$request->user()) {
            abort(403, 'You must be logged in to access this page.');
        }

        // Check if user is an admin
        if (!$request->user()->isAdmin()) {
            abort(403, 'Unauthorized access. Admin privileges required.');
        }

        return $next($request);
    }
}
