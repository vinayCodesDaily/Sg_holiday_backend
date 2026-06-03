<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request and verify the user's role authorization level.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Ensure the user is logged in
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access. Please log in.'
            ], 401);
        }

        $userRole = auth()->user()->role_id;

        // 2. Map names to your 4 specific database IDs
        $roleMapping = [
            'super_admin' => 1,
            'admin'       => 2,
            'manager'     => 3,
            'staff'       => 4,
        ];

        // 3. Check if the user's role ID matches any of the allowed roles passed in the route
        foreach ($roles as $role) {
            if (isset($roleMapping[$role]) && $userRole === $roleMapping[$role]) {
                return $next($request);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Access Denied. Your account role does not have permission for this action.'
        ], 403);
    }
}
