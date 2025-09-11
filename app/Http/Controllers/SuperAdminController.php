<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Service;
use App\Models\Committee;
use App\Models\Department;
use App\Models\Permission;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    /**
     * Affiche le tableau de bord du super administrateur
     */
    public function dashboard()
    {
        // Statistiques générales
        $totalUsers = User::count();
        $totalDepts = Department::count();
        $totalCom = Committee::count();
        $totalServices = Service::count();
        
        // Statistiques des rôles et permissions
        $nbreRole = Role::count();
        $nbrePermission = Permission::count();
        
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
            ->take(10)
            ->get()
            ->map(function($user) {
                $isOnline = $user->last_activity_at ? \Carbon\Carbon::parse($user->last_activity_at)->gt(now()->subMinutes(15)) : false;
                
                return [
                    'user_name' => $user->matricule,
                    'registered_date' => $user->created_at->format('d/m/Y H:i'),
                    'last_update' => $user->info_updated_at ? $user->info_updated_at->format('d/m/Y H:i') : 'Jamais',
                    'last_login' => $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Jamais',
                    'last_seen' => $user->last_activity_at ? $user->last_activity_at->diffForHumans() : 'Jamais',
                    'is_online' => $isOnline,
                    'status' => $isOnline ? 'En ligne' : 'Hors ligne',
                    'status_class' => $isOnline ? 'success' : 'warning'
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

        return view('superAdmin.dashboard', compact(
            'totalUsers',
            'totalDepts',
            'totalCom',
            'totalServices',
            'nbreRole',
            'nbrePermission',
            'userGrowth',
            'recentActivities',
            'departmentsWithStats'
        ));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {       
            $departments = Department::with('Department_Skills')->get();
            $StaffCounts=[];
            foreach($departments as $department){
                $StaffCounts[$department->id]=User::where('role','users')->where('department_id',$department->id)->count();
            }
            return view('departments.index', [
            'departments' => $departments,
            'Staff_Count' => $StaffCounts,
            'committee' => User::where('role', 'comite')->first(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'required|string|max:5250',
            'head_id'=>'required|string',
        ]);

    Department::create($data);
    return redirect()->route('admin.departments.index')->with('success', 'Département créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    $department = Department::with('Department_Skills')->findOrFail($id);
    return view('departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    $dept_skills = Department::findOrFail($id);
    return view('departments.edit', compact('dept_skills'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'required|string|max:5250',
            'head_id'=>'required|string',
        ]);
        
    $department = Department::findOrFail($id);
    $department->update($data);
    return redirect()->route('admin.departments.index')->with('success', 'Département mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    $department = Department::findOrFail($id);

    $personnelCount=User::where('department_id',$department->id)->where('role','users')->count();
    User::where('department_id',$department->id)->where('role','users')->delete();
    $DepartmentName=$department->name;
    $department->delete();
    return redirect()->route('admin.departments.index')->with('success', "Département {$DepartmentName} avec  supprimé avec succès");
    }

    /**
     * Display a listing of committees
     */
    

    public function listAllUser(){
        $users=User::with('departments','committee')->get();
        return view('superAdmin.listAllUser',compact('users'));
    }

    public function assignUsers(Request $request, Department $department) {
    $validated = $request->validate([
        'users' => 'required|array',
        'users.*' => 'exists:users,id',
    ]);

    $department->users()->sync($validated['users']); // relation many-to-many
    return redirect()->route('departments.index')->with('success', 'Utilisateurs assignés avec succès !');
}

public function assign(Department $department) {
    $users = User::all(); 
    $assignedUsers = $department->users->pluck('id')->toArray();
    return view('departments.indexAddStaff', compact('department', 'users', 'assignedUsers'));
}

public function indexAddStaff(){
    $departments=Department::all();
    return view('departments.quickAction',compact('departments'));
}

}
