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
        $services=Service::with('departments')->get();
        return view('services.index',compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments=Department::all();
        return view('services.create',compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:20|unique:services',
            'description'=>'required|string|max:255'
        ]);

        Service::create([
            'name'=>$request->name,
            'description'=>$request->description
        ]);

        return redirect()->route('services.index')->with('success','Service ajote avec succes');
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
