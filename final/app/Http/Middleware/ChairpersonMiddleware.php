<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class ChairpersonMiddleware
{
    /**
     * Handle an incoming request.
     */
    // app/Http/Middleware/ChairpersonMiddleware.php
    // app/Http/Middleware/ChairpersonMiddleware.php
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Authentication required.',
                    'redirect' => route('login')
                ], 401);
            }
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Allow chairpersons (role_id = 2) to access everything
        $isChairperson = $user->role_id === 2;

        if (!$isChairperson) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Chairperson role required.'
                ], 403);
            }
            abort(403, 'Access denied. Chairperson role required.');
        }

        return $next($request);
    }
}
