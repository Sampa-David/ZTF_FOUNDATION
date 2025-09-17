<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    //Tableau de bord
    public function dashboard()
    {
        $user = Auth::user();
        
        if ($user->isAdmin2()) {
            // Pour les chefs de département, montrer uniquement leurs données
            $departmentUsers = User::where('department_id', $user->department_id)->count();
            $departmentServices = Service::where('department_id', $user->department_id)->count();
            $recentActivities = User::where('department_id', $user->department_id)
                                   ->orderBy('last_activity_at', 'desc')
                                   ->limit(10)
                                   ->get();

            // Message de bienvenue spécifique pour les chefs de département authentifiés
            if (!session('success') && !session('message')) {
                // Vérifie si l'utilisateur a un département assigné
                if ($user->department_id) {
                    session()->flash('success', sprintf(
                        'Bienvenue dans votre espace Chef du Département %s%s',
                        $user->department->name ?? '',
                        $user->name ? ", {$user->name}" : ''
                    ));
                }
            }
        } else {
            // Pour les super admins et admin1, montrer toutes les données
            $departmentUsers = User::count();
            $departmentServices = Service::count();
            $recentActivities = User::orderBy('last_activity_at', 'desc')
                                   ->limit(10)
                                   ->get();
        }
        
        return view('departments.dashboard', compact('departmentUsers', 'departmentServices', 'recentActivities','user'));
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
            'code' => 'required|string|min:2|max:10|unique:departments'
        ]);

        $department = Department::create($validated);
        
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
    /**
     * Affiche la liste des employés du département du chef connecté
     */
    public function staffIndex()
    {
        $user = Auth::user();
        
        // Vérifier si l'utilisateur est chef de département
        if (!$user->isAdmin2() || !$user->department_id) {
            return redirect()->route('departments.dashboard')
                ->with('error', 'Accès non autorisé.');
        }

        // Récupérer les employés du département avec leurs services
        $employees = User::with(['service'])
            ->where('department_id', $user->department_id)
            ->where('id', '!=', $user->id) // Exclure le chef lui-même
            ->orderBy('last_activity_at', 'desc')
            ->get();

        return view('departments.staff.index', compact('employees'));
    }

    /**
     * Affiche le formulaire de création d'un nouvel employé
     */
    public function staffCreate()
    {
        $user = Auth::user();
        
        // Vérifier si l'utilisateur est chef de département
        if (!$user->isAdmin2() || !$user->department_id) {
            return redirect()->route('departments.dashboard')
                ->with('error', 'Accès non autorisé.');
        }

        // Récupérer uniquement les services du département du chef
        $services = Service::where('department_id', $user->department_id)->get();

        return view('departments.staff.create', compact('services'));
    }

    /**
     * Enregistre un nouvel employé dans la base de données
     */
    public function staffStore(Request $request)
    {
        $user = Auth::user();
        
        // Vérifier si l'utilisateur est chef de département
        if (!$user->isAdmin2() || !$user->department_id) {
            return redirect()->route('departments.dashboard')
                ->with('error', 'Accès non autorisé.');
        }

        // Valider les données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'service_id' => [
                'required',
                'exists:services,id',
                function ($attribute, $value, $fail) use ($user) {
                    $service = Service::find($value);
                    if ($service->department_id !== $user->department_id) {
                        $fail('Le service sélectionné n\'appartient pas à votre département.');
                    }
                },
            ],
            'is_active' => 'required|boolean'
        ]);

        try {
            DB::beginTransaction();

            // Créer l'utilisateur
            $employee = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'service_id' => $validated['service_id'],
                'department_id' => $user->department_id,
                'is_active' => $validated['is_active'],
                'registered_at' => now()
            ]);

            
            return redirect()->route('departments.staff.index')
                ->with('success', "L'employé {$employee->name} a été créé avec succès.");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la création d\'un employé: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Une erreur est survenue lors de la création de l\'employé. Veuillez réessayer.');
        }
    }

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

    /**
     * Met à jour les paramètres généraux du département
     */
    public function updateSettings(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin2() || !$user->department_id) {
            return redirect()->route('departments.dashboard')
                ->with('error', 'Accès non autorisé.');
        }

        $validated = $request->validate([
            'description' => 'required|string|max:1000',
        ]);

        try {
            $department = Department::findOrFail($user->department_id);
            $department->update([
                'description' => $validated['description']
            ]);

            return back()->with('success', 'Les paramètres du département ont été mis à jour avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour des paramètres du département: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour des paramètres.');
        }
    }

    /**
     * Met à jour les paramètres de notification du département
     */
    public function updateNotifications(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin2() || !$user->department_id) {
            return redirect()->route('departments.dashboard')
                ->with('error', 'Accès non autorisé.');
        }

        $validated = $request->validate([
            'email_notifications' => 'required|boolean',
            'report_frequency' => 'required|in:daily,weekly,monthly'
        ]);

        try {
            $department = Department::findOrFail($user->department_id);
            $department->update([
                'email_notifications' => $validated['email_notifications'],
                'report_frequency' => $validated['report_frequency']
            ]);

            return back()->with('success', 'Les préférences de notification ont été mises à jour avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour des notifications: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour des préférences de notification.');
        }
    }

    /**
     * Met à jour les paramètres de sécurité du département
     */
    public function updateSecurity(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin2() || !$user->department_id) {
            return redirect()->route('departments.dashboard')
                ->with('error', 'Accès non autorisé.');
        }

        $validated = $request->validate([
            'two_factor' => 'required|boolean',
            'session_timeout' => 'required|integer|min:15|max:120'
        ]);

        try {
            $department = Department::findOrFail($user->department_id);
            $department->update([
                'two_factor_enabled' => $validated['two_factor'],
                'session_timeout' => $validated['session_timeout']
            ]);

            return back()->with('success', 'Les paramètres de sécurité ont été mis à jour avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour des paramètres de sécurité: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour des paramètres de sécurité.');
        }
    }

    /**
     * Met à jour les paramètres d'apparence du département
     */
    public function updateAppearance(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin2() || !$user->department_id) {
            return redirect()->route('departments.dashboard')
                ->with('error', 'Accès non autorisé.');
        }

        $validated = $request->validate([
            'theme' => 'required|in:light,dark,system',
            'language' => 'required|in:fr,en'
        ]);

        try {
            $department = Department::findOrFail($user->department_id);
            $department->update([
                'theme' => $validated['theme'],
                'language' => $validated['language']
            ]);

            return back()->with('success', 'Les paramètres d\'apparence ont été mis à jour avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour des paramètres d\'apparence: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour des paramètres d\'apparence.');
        }
    }
}
