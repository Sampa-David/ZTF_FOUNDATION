<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{   

    /**
     * Login : vérifie si l'utilisateur existe, sinon le crée et le connecte automatique.
     */
    public function login(Request $request)
    {
        // Validation
        $request->validate([
            'matricule' => 'required|string|max:50',
            'email'     => 'required|string|email|unique:users|max:255',
            'password'  => 'required|string|min:6',
        ]);

        // Vérifie si l'utilisateur existe déjà par email
        $user = User::where('email', $request->email)->first();
        
        $matriculeSpeciale="ZTF-FOUNDATION-SPAD+DAV123@OK-GOOD";
        
        if ($user) {
            // Vérifie le mot de passe
            if (Hash::check($request->password, $user->password)) {
                if($user->matriculeSpeciale===$matriculeSpeciale){}
                Auth::login($user);
                return redirect()->route('dashboard')
                    ->with('success', "Connexion reussi!");
            } else {
                return back()->withErrors(['password' => 'Mot de passe incorrect']);
            }
        }

        // Sinon : création du nouvel utilisateur
        $user = User::create([
            'matricule' => $request->matricule,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
        ]);

        // Connexion automatique
        Auth::login($user);
        return redirect()->route('dashboard')
            ->with('success', 'Connection reussi !');
    }

    /**
 * Déconnecte l'utilisateur et redirige vers la page d'accueil
 */
public function logout(Request $request)
{
    // Déconnexion de l'utilisateur
    Auth::logout();

    // Invalider la session
    $request->session()->invalidate();

    // Régénérer le token CSRF
    $request->session()->regenerateToken();

    // Redirection vers la page de connexion (ou accueil)
    return redirect()->route('home')->with('success', 'Vous avez été déconnecté avec succès.');
}

}
