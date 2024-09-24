<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Return the route to the login page instead of the view
        return $request->expectsJson() ? null : route('login.form'); // Assuming 'login' is the name of your login route
    }
}
