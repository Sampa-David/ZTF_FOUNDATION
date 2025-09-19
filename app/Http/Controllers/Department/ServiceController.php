<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the services for the department.
     */
    public function index(Department $department)
    {
        $services = $department->services()->withCount('users')->get();
        return view('departments.services.index', compact('services', 'department'));
    }

    /**
     * Show the form for creating a new service.
     */
    public function create(Department $department)
    {
        return view('departments.services.create', compact('department'));
    }

    /**
     * Store a newly created service in storage.
     */
    public function store(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'is_active' => 'boolean',
        ]);

        $service = $department->services()->create($validated);

        return redirect()
            ->route('departments.services.show', [$department->id, $service->id])
            ->with('success', 'Service créé avec succès.');
    }

    /**
     * Display the specified service.
     */
    public function show(Department $department, Service $service)
    {
        $service->load(['users' => function ($query) {
            $query->select('users.id', 'name', 'email', 'position', 'created_at');
        }]);
        
        return view('departments.services.show', compact('department', 'service'));
    }

    /**
     * Show the form for editing the specified service.
     */
    public function edit(Department $department, Service $service)
    {
        return view('departments.services.edit', compact('department', 'service'));
    }

    /**
     * Update the specified service in storage.
     */
    public function update(Request $request, Department $department, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'is_active' => 'boolean',
        ]);

        $service->update($validated);

        return redirect()
            ->route('departments.services.show', [$department->id, $service->id])
            ->with('success', 'Service mis à jour avec succès.');
    }

    /**
     * Remove the specified service from storage.
     */
    public function destroy(Department $department, Service $service)
    {
        $service->delete();

        return redirect()
            ->route('departments.services.index', $department->id)
            ->with('success', 'Service supprimé avec succès.');
    }
}