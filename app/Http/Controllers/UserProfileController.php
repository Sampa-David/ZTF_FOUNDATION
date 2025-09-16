<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function show(){
        $user=Auth::user();
        return view('users.show',compact('user'));
    }

    public function UpdateProfile(Request $request){
        $user=Auth::user();

        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:30|unique:users'.$user->id
        ]);

        $user->update($request->only(['name','email']));
        return redirect()->back()->with('success','Profil mis a jour avec succes');
    }

    public function updatePassword(Request $request){
        $user=Auth::user();

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed'
        ]);

        if(!Hash::check($request->current_password,$request->password)){
            return redirect()->back()->withErrors([
                'message' => 'Mot de passe incorrect'
            ])->withInput($request->except('password'));
        }
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->back()->with('success','Mot de passe mis a jour avec succes');

    }
}
