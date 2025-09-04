<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\User;

class DepartmentController extends Controller
{
    /**
     * Affiche tout les departements
     */
    public function index()
    {
        $depts = Department::with(['services', 'users', 'headDepartment'])->get();
        return view('departments.index', compact('depts'));
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
    public function show(Department $dept)
    {
        $dept=Department::with('services')->findOrFail($dept->id);
        return view('departments.show',compact('dept'));
    }

    /**
     * Affiche le formulaire de modification d'un département spécifique.
     */
    public function edit(Department $dept)
    {
        return view('departments.edit', compact('dept'));
    }

    /**
     * Met à jour un département spécifique.
     */
    public function update(Request $request, Department $dept)
    {
        //
        $validated=$request->validate([
            'name'=>'required|string|max:255',
            'description'=>'required|string',
            'head_id'=>'required|exists:users,id'
        ]);
        $dept->update($validated);
    return redirect()->route('admin.departments.index')->with('success',"Departement '{$dept->name}' mis a jour avec succes");
    }

    /**
     * Suppression definitive du département et de ses employés associés
     */
    public function destroy(Department $dept)
    {
        try {
            // Récupérer le nom avant la suppression
            $deptName = $dept->name;
            
            // Commencer une transaction pour assurer l'intégrité des données
            \DB::beginTransaction();
            
            // Supprimer d'abord les employés associés
            $employeesCount = $dept->users()->count();
            $dept->users()->delete();
            
            // Ensuite supprimer le département
            $dept->delete();
            
            // Si tout va bien, valider la transaction
            \DB::commit();
            
            $message = "Département '{$deptName}' et ses {$employeesCount} employé(s) ont été supprimés avec succès";
            return redirect()->route('departments.index')->with('success', $message);
            
        } catch (\Exception $e) {
            // En cas d'erreur, annuler la transaction
            \DB::rollBack();
            
            return redirect()->route('departments.index')
                           ->with('error', "Une erreur est survenue lors de la suppression du département '{$dept->name}'");
        }
    }
}
