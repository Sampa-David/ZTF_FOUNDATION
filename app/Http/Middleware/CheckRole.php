<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $roleName, int $grade=null): Response
    {
        if(Auth::check() && Auth::user()->hasRole($roleName,$grade)){
            return $next($request);
        }
        
        abort(403,'Access denied');
        
    }
}
