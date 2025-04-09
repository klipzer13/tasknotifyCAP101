<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChairpersonMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // // Check if the user is logged in and has the 'chairperson' role
        // if (Auth::check() && Auth::user()->hasRole('chairperson')) {
        //     return $next($request);
        // }

        // // Redirect back with an error if unauthorized
        // return redirect('/')->with('error', 'You are not authorized to access this area.');
    }
}
