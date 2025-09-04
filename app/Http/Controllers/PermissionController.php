<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions=Permission::all();
        $roles=Role::all();
        return redirect()->route('permission.index',compact('permissions','roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name',
            'description'
        ]);

        Permission::create([
            'name'=>$request->name,
            'description'=>$request->desription
        ]);

        return redirect()->route('permissions.index')->with('success','permission cree avec succes');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $permission=Permission::with('role')->findOrFail($id);
        return redirect()->route('permissions.show',compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $permission=Permission::findOrFail($id);
        return \redirect()->route('permissions.edit',compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name',
            'description'
        ]);
        $permissionData = Permission::findOrFail($id);
        $permissionData->update($request->all());
        return redirect()->route('permissions.index')->with('success','nouvelle permission ajoute avec succes');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permissionData=Permission::findOrFail($id);
        $permissionData->delete();
        return redirect()->route('permissions.index')->with('success','permission supprime avec succes');
    }
}
