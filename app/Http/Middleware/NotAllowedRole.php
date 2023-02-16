<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NotAllowedRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if(!$request->user()) {
            return redirect()->route('home');
        }
        $isNotAllowed = false;
        foreach($roles as $role){
            if ($request->user()->hasRole($role)) {
                $isNotAllowed = true;
            }
        }
        if($isNotAllowed) return redirect()->route('home');
        return $next($request);
    }
}
