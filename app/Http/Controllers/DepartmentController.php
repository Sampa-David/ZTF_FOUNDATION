<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    //Tableau de bord
    public function dashboard(){
        
        $totalUsers=User::count();
        $totalServices=Service::count();

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
                    'created_ats' => $user->created_at->format('d/m/Y H:i'),
                    'last_update' => $user->info_updated_at ? $user->info_updated_at->format('d/m/Y H:i') : 'Jamais',
                    'last_login' => $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Jamais',
                    'last_seen' => $user->last_activity_at ? $user->last_activity_at->diffForHumans() : 'Jamais',
                    'is_online' => $isOnline,
                    'status' => $isOnline ? 'En ligne' : 'Hors ligne',
                    'status_class' => $isOnline ? 'success' : 'warning'
                ];
            });

        // Statistiques des départements
        

        return view('departments.dashboard', compact(
            'totalUsers',
            'totalServices',
            'userGrowth',
            'recentActivities',
            
        ));
    }
    /**
     * Affiche tout les departements
     */
    
    public function index()
    {
        $depts = Department::with(['services', 'users', 'headDepartment'])->get();
        return view('departments.index', compact('depts'));
    }
    public function indexDepts()
    {
        $allDepts = Department::all();
        return view('departments.indexDepts', compact('allDepts'));
    }

    public function showChooseDept()
    {
        return view('departments.choose');
    }

    /**
     * Affiche le formulaire de création d'un nouveau département.
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Enregistre un nouveau département dans la base de données.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'head_id' => 'required|exists:users,id'
        ]);

        $department = Department::create($validated);
        $head=User::findOrFail($validated['head_id']);
    return redirect()->route('departments.index')->with('success', "Département '{$department->name}' créé avec succès");
    }

    /**
     * Affiche les détails d'un département spécifique.
     */
    public function show(Department $department)
    {
        $department->load(['services.users', 'users', 'skills']);
        return view('departments.show', compact('department'));
    }

    /**
     * Affiche le formulaire de modification d'un département spécifique.
     */
    public function edit(Department $department)
    {
        $users = User::all();
        $department->load(['services.users', 'skills', 'headDepartment']);
        return view('departments.edit', compact('department', 'users'));
    }

    /**
     * Met à jour un département spécifique.
     */
    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'head_id' => 'required|exists:users,id',
            'skills' => 'array|nullable'
        ]);

        // Commencer une transaction
        \DB::beginTransaction();
        try {
            // Mettre à jour les informations de base du département
            $department->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'head_id' => $validated['head_id']
            ]);

            // Mettre à jour les compétences si fournies
            if (isset($validated['skills'])) {
                // Supprimer les anciennes compétences
                $department->skills()->delete();
                
                // Ajouter les nouvelles compétences
                foreach ($validated['skills'] as $skillName) {
                    $department->skills()->create([
                        'name' => $skillName
                    ]);
                }
            }

            \DB::commit();
            return redirect()->route('departments.show', $department)
                ->with('success', "Le département '{$department->name}' a été mis à jour avec succès");
        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->with('error', "Une erreur est survenue lors de la mise à jour du département")
                ->withInput();
        }
    }

    /**
     * Suppression définitive du département, de ses services et de ses employés associés
     */
    public function destroy(Department $department)
    {
        try {
            // Récupérer les informations avant la suppression
            $deptName = $department->name;
            $servicesCount = $department->services()->count();
            $employeesCount = $department->users()->count();
            
            // Commencer une transaction pour assurer l'intégrité des données
            \DB::beginTransaction();
            
            // 1. Supprimer d'abord les compétences du département
            $department->skills()->delete();

            // 2. Pour chaque service du département
            foreach($department->services as $service) {
                // 2.1 Mettre à null le service_id des employés
                $service->users()->update(['service_id' => null]);
                // 2.2 Supprimer le service
                $service->delete();
            }

            // 3. Mettre à null le department_id des employés avant de les supprimer
            $department->users()->update(['department_id' => null]);
            
            // 4. Supprimer les employés qui n'ont plus de département
            User::whereNull('department_id')->delete();
            
            // 5. Finalement, supprimer le département
            $department->delete();
            
            // Si tout va bien, valider la transaction
            \DB::commit();
            
            $message = "Le département '{$deptName}' a été supprimé avec succès, incluant {$servicesCount} service(s) et {$employeesCount} employé(s)";
            return redirect()->route('departments.index')->with('success', $message);
            
        } catch (\Exception $e) {
            // En cas d'erreur, annuler la transaction
            \DB::rollBack();
            
            \Log::error('Erreur lors de la suppression du département: ' . $e->getMessage());
            
            return redirect()->route('departments.index')
                           ->with('error', "Une erreur est survenue lors de la suppression du département '{$department->name}'. 
                                          Veuillez contacter l'administrateur système.");
        }
    }
}
