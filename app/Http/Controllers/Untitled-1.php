<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all()->groupBy('group');
        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        $groups = [
            'users' => 'Gestion des utilisateurs',
            'roles' => 'Gestion des rôles',
            'permissions' => 'Gestion des permissions',
            'departments' => 'Gestion des départements',
            'services' => 'Gestion des services',
            'documents' => 'Gestion des documents',
            'settings' => 'Paramètres système'
        ];
        
        return view('permissions.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions',
            'description' => 'nullable|string',
            'group' => 'required|string',
            'level' => 'required|integer|min:1|max:10',
        ]);

        $validated['guard_name'] = 'web';
        
        Permission::create($validated);

        return redirect()->route('permissions.index')
            ->with('success', 'Permission créée avec succès.');
    }

    public function show(Permission $permission)
    {
        return view('permissions.show', compact('permission'));
    }

    public function edit(Permission $permission)
    {
        $groups = [
            'users' => 'Gestion des utilisateurs',
            'roles' => 'Gestion des rôles',
            'permissions' => 'Gestion des permissions',
            'departments' => 'Gestion des départements',
            'services' => 'Gestion des services',
            'documents' => 'Gestion des documents',
            'settings' => 'Paramètres système'
        ];
        
        return view('permissions.edit', compact('permission', 'groups'));
    }

    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'group' => 'required|string',
            'level' => 'required|integer|min:1|max:10',
            'is_active' => 'boolean'
        ]);

        $permission->update($validated);

        return redirect()->route('permissions.index')
            ->with('success', 'Permission mise à jour avec succès.');
    }

    public function destroy(Permission $permission)
    {
        try {
            $permission->delete();
            return redirect()->route('permissions.index')
                ->with('success', 'Permission supprimée avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('permissions.index')
                ->with('error', 'Impossible de supprimer cette permission car elle est utilisée.');
        }
    }
}
