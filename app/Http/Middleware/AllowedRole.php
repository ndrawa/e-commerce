<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AllowedRole
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
        $isAllowed = false;
        foreach($roles as $role){
            if ($request->user()->hasRole($role)) {
                $isAllowed = true;
            }
        }
        if($isAllowed) return $next($request);
        return redirect()->route('dashboard.index');
    }
}
