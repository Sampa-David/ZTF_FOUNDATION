<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Service;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Affiche le formulaire d'inscription final
     */
    public function showRegistrationForm()
    {
        
        return view('auth.register');
    }

    /**
     * Traite le formulaire d'inscription final
     */


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('services', 'departments')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    public function edit(){
        return view('profile.edit');
    }

    public function update(Request $request , User $user){
        $data=$request->validate([
             
            'matricule' => [
                'required',
                'string',
                'max:255',
                'regex:/^CM-HQ-[a-zA-Z]+-\d{3}$/'
            ],
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'matricule.regex' => "Le matricule doit être au format : CM-HQ-nomdepartement-numerosequentiel (ex: CM-HQ-IT-001)"
        
        ]);
        $user=Auth::user();

        $user->update($data);
        return redirect(route('dashboard'))->with('success','profile mis a jour ave succes');
    }
    /**
     * Supprime un utilisateur specifique definitivement de la base de donnee
     */
    public function destroy(User $user)
    {
        $sexe = $user->sexe == 'M' ? 'Mr' : 'Mme';
        $user->delete();
        return redirect()->route('users.index')->with('success', "$sexe {$user->name} {$user->surname} supprimé avec succès");
    }
}
