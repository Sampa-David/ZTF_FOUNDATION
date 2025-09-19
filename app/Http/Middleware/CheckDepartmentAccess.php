<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckDepartmentAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $department = $request->route('department');
        $user = Auth::user();

        // Vérifie si l'utilisateur appartient au département
        if (!$user || ($user->department_id != $department->id && !$user->isSuperAdmin() && !$user->isAdmin1())) {
            abort(403, 'Vous n\'avez pas accès à ce département.');
        }

        return $next($request);
    }
}