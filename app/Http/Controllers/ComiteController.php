<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Service;
use App\Models\Committee;
use App\Models\Department;
use App\Models\Permission;
use Illuminate\Http\Request;

class ComiteController extends Controller
{
    public function dashboard()
    {
        \Log::info('ComiteController@dashboard called');
        \Log::info('User: ' . auth()->user()->matricule);

        $totalDepts=Department::count();
        $totalUsers=User::count();
        $totalServices=Service::count();

        //Nombre de Role et Permission
        $nbreRole=Role::count();
        $nbrePermission=Permission::count();
        // Calcul des tendances
        $lastWeekUsers = User::where('created_at', '>=', now()->subWeek())->count();
        $previousWeekUsers = User::whereBetween('created_at', [
            now()->subWeeks(2),
            now()->subWeek()
        ])->count();
        
        $userGrowth = $previousWeekUsers > 0 
            ? round((($lastWeekUsers - $previousWeekUsers) / $previousWeekUsers) * 100)
            : 0;
            
        // Activités récentes
        $recentActivities = User::with(['Departement', 'roles'])
            ->orderBy('last_activity_at', 'desc')
            ->get()
            ->map(function($user) {
                $isOnline = $user->last_activity_at ? \Carbon\Carbon::parse($user->last_activity_at)->gt(now()->subMinutes(15)) : false;
                
                return [
                    'user_name' => $user->matricule,
                    'created_at' => $user->created_at->format('d/m/Y H:i:s'),
                    'last_update' => $user->info_updated_at ? $user->info_updated_at->format('d/m/Y H:i') : 'Jamais',
                    'last_login' => $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Jamais',
                    'last_seen' => $user->last_activity_at ? $user->last_activity_at->diffForHumans() : 'Jamais',
                    'is_online' => $isOnline,
                    'status' => $isOnline ? 'En ligne' : 'Hors ligne',
                    'status_class' => $isOnline ? 'success' : 'warning',
                ];
            });

        // Statistiques des départements
        $departmentsWithStats = Department::withCount('users')
            ->get()
            ->map(function($dept) {
                return [
                    'name' => $dept->name,
                    'users_count' => $dept->users_count,
                    'status' => $dept->users_count > 0 ? 'Actif' : 'Inactif'
                ];
            });

        $user = auth()->user();

        return view('committee.dashboard', compact(
            'totalUsers',
            'totalDepts',
            'totalServices',
            'nbreRole',
            'nbrePermission',
            'userGrowth',
            'recentActivities',
            'departmentsWithStats',
            'user'
        ));
    }

    
    public function index()
    {
        $members = User::where('matricule', 'CM-HQ-NEH')
            ->withCount(['roles', 'permissions'])
            ->get();

        $totalMembers = $members->count();
        $activeMembers = $members->filter(function($member) {
            return $member->last_activity_at && 
                   \Carbon\Carbon::parse($member->last_activity_at)->gt(now()->subDays(30));
        })->count();
        $onlineMembers = $members->filter(function($member) {
            return $member->is_online;
        })->count();

        return view('committee.index', compact(
            'members',
            'totalMembers',
            'activeMembers',
            'onlineMembers'
        ));
    }

    /**
     * Affiche le formulaire de création d'un nouveau membre du comité
     */
    public function create()
    {
        // Récupérer les rôles disponibles pour le comité
        $roles = Role::where('grade', 1)->get();

        // Récupérer les départements disponibles
        $departments = Department::all();

        return view('committee.create', compact('roles', 'departments'));
    }

    /**
     * Enregistre un nouveau membre du comité
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'department_id' => 'nullable|exists:departments,id',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id'
        ]);

        // Créer le nouvel utilisateur avec le matricule du comité
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'matricule' => 'CM-HQ-NEH',
            'department_id' => $validated['department_id'],
            'email_verified_at' => now(),
            'registered_at' => now(),
            'last_login_at' => now(),
            'last_activity_at' => now(),
            'last_seen_at' => now(),
            'is_online' => true
        ]);

        // Assigner les rôles sélectionnés
        if (!empty($validated['roles'])) {
            $user->roles()->attach($validated['roles']);
        }

        return redirect()->route('committee.index')
            ->with('success', 'Le nouveau membre du comité a été créé avec succès.');
    }

    /**
     * Affiche les détails d'un membre du comité
     */
    public function show(User $member)
    {
        // Vérifier que l'utilisateur est bien un membre du comité
        if ($member->matricule !== 'CM-HQ-NEH') {
            abort(404);
        }

        // Charger les relations nécessaires
        $member->load(['roles', 'permissions', 'department']);

        // Récupérer l'historique des activités
        $activities = [
            'last_login' => $member->last_login_at ? $member->last_login_at->format('d/m/Y H:i') : 'Jamais',
            'last_seen' => $member->last_activity_at ? $member->last_activity_at->diffForHumans() : 'Jamais',
            'registered_at' => $member->registered_at->format('d/m/Y'),
            'email_verified' => $member->email_verified_at ? 'Oui' : 'Non'
        ];

        return view('committee.show', compact('member', 'activities'));
    }

    /**
     * Affiche le formulaire d'édition d'un membre du comité
     */
    public function edit(User $member)
    {
        // Vérifier que l'utilisateur est bien un membre du comité
        if ($member->matricule !== 'CM-HQ-NEH') {
            abort(404);
        }

        // Récupérer les rôles et départements disponibles
        $roles = Role::where('grade', 1)->get();
        $departments = Department::all();

        // Récupérer les IDs des rôles actuels
        $currentRoles = $member->roles->pluck('id')->toArray();

        return view('committee.edit', compact('member', 'roles', 'departments', 'currentRoles'));
    }

    /**
     * Met à jour les informations d'un membre du comité
     */
    public function update(Request $request, User $member)
    {
        // Vérifier que l'utilisateur est bien un membre du comité
        if ($member->matricule !== 'CM-HQ-NEH') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $member->id,
            'password' => 'nullable|string|min:8|confirmed',
            'department_id' => 'nullable|exists:departments,id',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id'
        ]);

        // Mettre à jour les informations de base
        $member->name = $validated['name'];
        $member->email = $validated['email'];
        $member->department_id = $validated['department_id'];
        
        // Mettre à jour le mot de passe si fourni
        if (!empty($validated['password'])) {
            $member->password = bcrypt($validated['password']);
        }

        $member->save();

        // Mettre à jour les rôles
        $member->roles()->sync($validated['roles']);

        return redirect()->route('committee.show', $member)
            ->with('success', 'Les informations du membre ont été mises à jour avec succès.');
    }

    /**
     * Supprime un membre du comité
     */
    public function destroy(User $member)
    {
        // Vérifier que l'utilisateur est bien un membre du comité
        if ($member->matricule !== 'CM-HQ-NEH') {
            abort(404);
        }

        // Détacher tous les rôles avant la suppression
        $member->roles()->detach();
        
        // Supprimer le membre
        $member->delete();

        return redirect()->route('committee.index')
            ->with('success', 'Le membre du comité a été supprimé avec succès.');
    }}
