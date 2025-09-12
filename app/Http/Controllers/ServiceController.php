<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Department;
use Illuminate\Http\Request;

class ServiceController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isSuperAdmin() || $user->isAdmin1()) {
            // Les administrateurs voient tous les services
            $services = Service::with('department')->get();
        } elseif ($user->isAdmin2()) {
            // Les chefs de département ne voient que les services de leur département
            $services = Service::where('department_id', $user->department_id)
                             ->with('department')
                             ->get();
        } else {
            // Les autres utilisateurs ne voient que leur propre service
            $services = Service::where('id', $user->service_id)
                             ->with('department')
                             ->get();
        }
        
        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        
        if (!$user->isAdmin2() && !$user->isSuperAdmin() && !$user->isAdmin1()) {
            return redirect()->route('services.index')
                ->with('error', 'Vous n\'avez pas les permissions nécessaires pour créer un service.');
        }

        if ($user->isAdmin2()) {
            // Chef de département - montrer uniquement son département
            $departments = Department::where('id', $user->department_id)->get();
        } else {
            // Super admin et Admin1 - montrer tous les départements
            $departments = Department::all();
        }

        return view('services.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:services',
            'description' => 'required|string|max:255',
            'manager_matricule' => 'required|exists:users,matricule'
        ]);

        // Déterminer le department_id selon le rôle de l'utilisateur
        if ($user->isAdmin2()) {
            // Pour les chefs de département, utiliser leur département
            $validated['department_id'] = $user->department_id;
        } else if ($user->isSuperAdmin() || $user->isAdmin1()) {
            // Pour les admins, valider le département choisi
            $validated['department_id'] = $request->validate([
                'department_id' => 'required|exists:departments,id'
            ])['department_id'];
        } else {
            return back()->with('error', 'Vous n\'avez pas les permissions nécessaires.');
        }

        // Créer le service
        $service = Service::create($validated);

        // Mettre à jour l'utilisateur désigné comme manager
        User::where('matricule', $validated['manager_matricule'])
            ->update([
                'service_id' => $service->id,
                'department_id' => $validated['department_id']
            ]);

        return redirect()->route('services.index')
            ->with('success', 'Service créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service=Service::findOrFail($id);
        return view('services.show',compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $service=Service::findOrFail($id);
        return view('services.edit',compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dataService=$request->validate([
            'name'=>'required|string|max:20|unique:services',
            'description'=>'required|string|max:255'
        ]);

        $service=Service::findOrFail($id);
        $service->update($dataService);
        return redirect()->route('services.index')->with('success',"Service {$service->name} mis a jour avec succes");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
