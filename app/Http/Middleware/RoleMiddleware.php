<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userRole = Auth::user()->role;

        // print_r($userRole);

        if ($userRole === 'admin') {
            return $next($request);
        }

        if ($userRole === 'employee' && $userRole === 'employee' && $request->isMethod('put')) {
            return $next($request);
        }

        return response()->json(['error' => 'Forbidden'], 403);
    }

}
