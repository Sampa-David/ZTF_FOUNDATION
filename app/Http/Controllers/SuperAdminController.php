<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('departments.index',[
            'departments' => Departement::with('Department_Skills')->get(),
            'staffCount'=> UserRegister::where('role','personnel')->count(),
            'committee'=>UserRegister::where('role','comite')->first(),
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
        
        return redirect(route('department.index'))->with('success','Departement cree avec succes');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $department=Department::with('Department_Skills')->findOrFail($id);
        return view('departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dept_skills=Department::findOrFail($id);
        return view('departments.edit',compact('dept_skills'));
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
        
       $department=Department::findOrFail($id);
       $department->update($data);
        return \redirect(route('departments.index'))->with('success','Departement mis a jouor avec succes');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
    }
}
