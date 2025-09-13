<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;



class LoginController extends Controller
{
    


    /**
     * Login : vérifie si l'utilisateur existe, sinon le crée et le connecte automatiquement
     */
    public function login(Request $request)
    {
        // Validation de base
        $request->validate([
            'matricule' => 'required|string|max:50|unique:users',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:6'
        ]);

        // Si le matricule commence par STF, on le génère automatiquement
        if (strtoupper(substr($request->matricule, 0, 3)) === 'STF') {
            $request->merge(['matricule' => $this->generateMatriculeStaff()]);
        }

        // Vérifie si l'utilisateur existe
        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser) {
            // Vérifie le mot de passe
            if (!Hash::check($request->password, $existingUser->password)) {
                return back()->withErrors(['password' => 'Mot de passe incorrect'])
                             ->withInput($request->except('password'));
            }

            Auth::login($existingUser);

            // Redirection automatique selon le matricule
            return $this->redirectByMatricule($existingUser->matricule);
        }

        // Création d'un nouvel utilisateur avec gestion du matricule
        
            $matricule = $request->matricule;
            
            // Si c'est un matricule STF, on utilise la génération automatique
            if (strtoupper(substr($matricule, 0, 3)) === 'STF') {
                $matricule = $this->generateMatriculeStaff();
            }

            $user = User::create([
                'matricule' => $matricule,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'email_verified_at' => now(),
                'registered_at' => now(),
                'last_login_at' => now(),
                'last_activity_at' => now(),
                'last_seen_at' => now(),
                'is_online' => true,
            ]);

            // Vérifier si le matricule correspond au format des chefs de département (CM-HQ-*-CD)
            if (preg_match('/^CM-HQ-.*-CD$/i', $user->matricule)) {
                $admin2Role = Role::where('name', 'admin-2')->first();
                
                if ($admin2Role) {
                    $user->assignRole($admin2Role);
                    Log::info('Role Admin2 assigned to department head with matricule: ' . $user->matricule);
                } else {
                    Log::error('Admin2 role not found in database');
                }
            }
        
        if (strtoupper($user->matricule) === 'CM-HQ-CD') {
            Auth::login($user);
            return redirect()->route('departments.choose')->with('message', 'Veuillez choisir votre département');
        }

        if (strtoupper($user->matricule) === 'CM-HQ-NEH') {
            Auth::login($user); // Connexion avant la redirection
            return redirect()->route('committee.dashboard')->with('success', 'Connexion reussi');
        }

        if(strtoupper($user->matricule)==='CM-HQ-SPAD'){
            Auth::login($user);
            return \redirect()->route('twoFactorAuth')->with('success','Bienvenu Administrateur en chef,veuillez vous faire authentifier svp !');
        }

        Auth::login($user);

        return $this->redirectByMatricule($user->matricule);
    }

    /**
     * Redirection selon le type de matricule
     */
    public function redirectByMatricule($matricule)
    {
        $matricule = strtoupper($matricule);

        if (str_starts_with($matricule, 'STF')) {
            return redirect()->route('staff.dashboard');
        }

        // Cas par défaut
        return redirect()->route('home');
    }

    /**
     * Génération d'un matricule Staff (STF0001, STF0002, ...)
     */
    public function generateMatriculeStaff()
    {
        // Récupère le dernier user dont le matricule commence par STF (ordre id décroissant)
    $lastUser = User::where('matricule', 'LIKE', 'STF%')
                    ->orderBy('id', 'desc')
                    ->first();

    // Valeur par défaut si aucun matricule existant
    $lastNumber = 0;

    if ($lastUser && !empty($lastUser->matricule)) {
        // Normaliser (enlever espaces et mettre en majuscule)
        $mat = strtoupper(trim($lastUser->matricule));

        // Extraire la partie numérique à la fin (ex: "STF0007" -> "0007")
        if (preg_match('/(\d+)$/', $mat, $matches)) {
            $lastNumber = intval($matches[1]); // transforme "0007" -> 7
        } else {
            // Si on ne trouve pas de nombre, essayer substr en dernier recours
            $maybe = substr($mat, 3);
            $lastNumber = is_numeric($maybe) ? intval($maybe) : 0;
        }
    }

    $newNumber = $lastNumber + 1;

    // Format : STF + numéro sur 4 chiffres (ex : STF0001)
    return 'STF' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Génération d'un matricule Chef de département
     * Format : CM-HQ-{DEPT_CODE}-CD
     */
    public function generateMatriculeHeadDepts($deptCode)
    {
        return 'CM-HQ-' . strtoupper($deptCode) . '-CD';
    }

    /**
     * Sauvegarde le département choisi par le chef
     */
    public function saveDepts(Request $request)
    {
        $request->validate([
            'departement' => 'required|string'
        ]);

        $deptCode = strtoupper(trim($request->departement));
        $user = Auth::user();
        $user->matricule = $this->generateMatriculeHeadDepts($deptCode);
        
        // Attribuer le rôle Admin2 lors de la mise à jour du matricule
        $admin2Role = Role::where('name', 'admin-2')->first();
        if ($admin2Role && !$user->hasRole('admin-2')) {
            $user->assignRole($admin2Role);
            Log::info('Role Admin2 assigned to department head during department selection. Matricule: ' . $user->matricule);
        }
        
        $user->save();

        return redirect()->route('departments.dashboard')->with('success', 'Connexion réussie');
    }

    /**
     * Déconnexion
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Vous avez été déconnecté avec succès.');
    }



}
            
   