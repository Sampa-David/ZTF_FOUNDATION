<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentAccessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        
        // Vérifier si l'utilisateur est un chef de département
        if ($user && $user->isAdmin2()) {
            // Si on accède à un service spécifique
            if ($request->route('service')) {
                $service = $request->route('service');
                // Vérifier si le service appartient au département du chef
                if ($service->department_id !== $user->department_id) {
                    abort(403, 'Accès non autorisé à ce service');
                }
            }
            
            // Si on accède à un employé spécifique
            if ($request->route('user')) {
                $employee = $request->route('user');
                // Vérifier si l'employé appartient au département du chef
                if ($employee->department_id !== $user->department_id) {
                    abort(403, 'Accès non autorisé à cet employé');
                }
            }
        }

        return $next($request);
    }
}