<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        if (! Auth::check()) {
            return redirect()->route('home');
        }

        $userRole = optional(Auth::user()->role)->value ?? Auth::user()->role;

        if (empty($roles) || ! in_array($userRole, $roles, true)) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
