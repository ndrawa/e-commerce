<?php

namespace App\Http\Middleware;

use Aacotroneo\Saml2\Saml2Auth;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return url('login');
        } else {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
    }
}
