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
        
        if (!$user) {
            return redirect()->route('login');
        }

        // Vérifier si l'utilisateur a le bon format de matricule
        $isHeadByMatricule = str_starts_with($user->matricule, 'CM-HQ-') && str_ends_with($user->matricule, '-CD');
        
        // Vérifier si l'utilisateur est un chef de département (soit par rôle, soit par matricule)
        if ($user->isAdmin2() || $isHeadByMatricule) {
            // Si c'est une création de service
            if ($request->routeIs('services.create') || ($request->routeIs('services.store') && $request->isMethod('post'))) {
                if ($isHeadByMatricule) {
                    // Les utilisateurs avec le bon matricule peuvent toujours créer des services
                    return $next($request);
                }
            }

            // Accès au tableau de bord et aux vues générales toujours autorisé pour les chefs
            if ($request->routeIs('department.dashboard', 'department.overview')) {
                return $next($request);
            }

            // Si on accède à un service spécifique
            if ($request->route('service')) {
                $service = $request->route('service');
                // Vérifier si le service appartient au département du chef
                if ($service->department_id !== $user->department_id) {
                    abort(403, 'Accès non autorisé à ce service. Vous ne pouvez accéder qu\'aux services de votre département.');
                }
            }
            
            // Si on accède à un employé spécifique
            if ($request->route('user')) {
                $employee = $request->route('user');
                // Vérifier si l'employé appartient au département du chef
                if ($employee->department_id !== $user->department_id) {
                    abort(403, 'Accès non autorisé à cet employé. Vous ne pouvez accéder qu\'aux employés de votre département.');
                }
            }

            // Vérification supplémentaire pour les actions de modification
            if ($request->isMethod('post') || $request->isMethod('put') || $request->isMethod('delete')) {
                // Si l'utilisateur a le bon format de matricule, on l'autorise
                if ($isHeadByMatricule) {
                    return $next($request);
                }
                
                // Sinon, on vérifie les autres conditions
                if (!$user->department_id) {
                    abort(403, 'Vous devez être assigné à un département pour effectuer cette action.');
                }
                if (!$user->isAdmin2()) {
                    abort(403, 'Cette action nécessite des droits de chef de département.');
                }
            }
        } else {
            abort(403, 'Accès réservé aux chefs de département (Admin2 ou matricule CM-HQ-{CODE}-CD).');
        }

        return $next($request);
    }
}