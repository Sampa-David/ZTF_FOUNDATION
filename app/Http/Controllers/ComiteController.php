<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Committee;
use App\Models\Department;
use Illuminate\Http\Request;

class ComiteController extends Controller
{
    public function dashboard()
    {
        return view('comite.dashboard');
    }

    public function committeeIndex()
    {
        $committee = User::where('role', 'comite')->get();
        $department = Department::with('users')->get();
        $StaffIndex = User::with('departments')->get();

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

}
