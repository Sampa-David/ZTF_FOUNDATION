<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Departement;
use App\Models\UserRegister;
use App\Models\Committee;

class SuperAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {       
            $departments = Departement::with('Department_Skills')->get();
            $StaffCounts=[];
            foreach($departments as $department){
                $StaffCounts[$department->id]=UserRegister::where('role','users')->where('department_id',$department->id)->count();
            }
            return view('departments.index', [
            'departments' => $departments,
            'Staff_Count' => $StaffCounts,
            'committee' => UserRegister::where('role', 'comite')->first(),
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

    Departement::create($data);
    return redirect()->route('departments.index')->with('success', 'Département créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    $department = Departement::with('Department_Skills')->findOrFail($id);
    return view('departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    $dept_skills = Departement::findOrFail($id);
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
        
    $department = Departement::findOrFail($id);
    $department->update($data);
    return redirect()->route('departments.index')->with('success', 'Département mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    $department = Departement::findOrFail($id);

    $personnelCount=UserRegister::where('department_id',$department->id)->where('role','users')->count();
    UserRegister::where('department_id',$department->id)->where('role','users')->delete();
    $DepartmentName=$department->name;
    $department->delete();
    return redirect()->route('departments.index')->with('success', "Département {$DepartmentName} avec  supprimé avec succès");
    }

    /**
     * Display a listing of committees
     */
    public function committeeIndex()
    {
        $committee = UserRegister::where('role', 'comite')->get();
        $department = Departement::with('users')->get();
        $StaffIndex = UserRegister::with('departments')->get();

        return view('committee.index', compact('committee', 'department', 'StaffIndex'));
    }

    /**
     * Store a newly created committee
     */
    public function storeCommittee(Request $request)
    {
        $committeeData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:5250',      
        ]);

        Committee::create($committeeData);
        return redirect()->route('committee.index')->with('success', 'Comité créé avec succès');
    }

    /**
     * Update the specified committee
     */
    public function updateCommittee(Request $request, string $id)
    {
        $committeeData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:5250',      
        ]);
        
        $comite = Committee::findOrFail($id);
        $comite->update($committeeData);

        return redirect()->route('committee.index')->with('success', "Comité de {$comite->name} mis à jour avec succès");
    }

    /**
     * Display the specified committee
     */
    public function showCommittee(string $id)
    {
        $committee = Committee::findOrFail($id);
        return view('committee.show', compact('committee'));
    }

    /**
     * Show the form for editing the specified committee
     */
    public function editCommittee(string $id)
    {
        $committee = Committee::findOrFail($id);
        return view('committee.edit', compact('committee'));
    }

    /**
     * Remove the specified committee
     */
    public function destroyCommittee(string $id){
        $comite=Committee::findOrFail($id);
        $comite->delete();
        return redirect()->route('committee.index')->with('success',"comite de {$comite->name} supprime avec succes");
    }


    public function listAllUser(){
        $users=UserRegister::with('departments','committee')->get();
        return view('superAdmin.listAllUser',compact('users'));
    }
}
