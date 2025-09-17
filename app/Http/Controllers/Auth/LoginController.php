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
        // Validation de base sans vérification d'unicité
        $request->validate([
            'matricule' => 'required|string|max:50',
            'email'     => 'required|string|email|max:255',
            'password'  => 'required|string|min:6'
        ]);

        // Vérifie si l'utilisateur existe par email ou matricule
        $existingUser = User::where('email', $request->email)
                           ->orWhere('matricule', $request->matricule)
                           ->first();

        // Si le matricule commence par STF et l'utilisateur n'existe pas, on le génère automatiquement
        if (!$existingUser && strtoupper(substr($request->matricule, 0, 3)) === 'STF') {
            $request->merge(['matricule' => $this->generateMatriculeStaff()]);
        }

        if ($existingUser) {
            // Si l'utilisateur existe, vérifie le mot de passe
            if (!Hash::check($request->password, $existingUser->password)) {
                return back()->withErrors(['password' => 'Mot de passe incorrect'])
                             ->withInput($request->except('password'));
            }

            // Si le matricule et l'email ne correspondent pas au même utilisateur
            if ($existingUser->email !== $request->email && $existingUser->matricule !== $request->matricule) {
                return back()->withErrors(['email' => 'Le matricule et l\'email ne correspondent pas au même compte'])
                             ->withInput($request->except('password'));
            }

            // Met à jour les timestamps de connexion
            $existingUser->update([
                'last_login_at' => now(),
                'last_activity_at' => now(),
                'last_seen_at' => now(),
                'is_online' => true,
            ]);

            Auth::login($existingUser);
            return $this->redirectByMatricule($existingUser->matricule);
        }

        // Vérifie si le matricule ou l'email est déjà utilisé
        $userWithMatricule = User::where('matricule', $request->matricule)->first();
        $userWithEmail = User::where('email', $request->email)->first();

        if ($userWithMatricule || $userWithEmail) {
            $errors = [];
            if ($userWithMatricule) {
                $errors['matricule'] = 'Ce matricule est déjà utilisé';
            }
            if ($userWithEmail) {
                $errors['email'] = 'Cet email est déjà utilisé';
            }
            return back()->withErrors($errors)->withInput($request->except('password'));
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

            if(preg_match('/^CM-HQ-.*-CD$/i',$user->matricule)){
                if(preg_match('/^CM-HQ-(.*)-CD$/i',$user->matricule,$matches)){
                    $deptCode=$matches[1] ?? null ;
                }

                if($deptCode){
                    $existingHead = User::where('matricule', 'LIKE', "CM-HQ-{$deptCode}-CD")
                                    ->where('id', '!=', $user->id)
                                    ->first();
                
                    if($existingHead){
                        $user->delete();
                        return redirect()->back()->withErrors([
                            'matricule' => "Désolé ! Le code {$deptCode} est déjà attribué"
                        ])->withInput($request->except(['matricule', 'password']));
                    }
                }

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

        $user = Auth::user();
        $name = $user->name ?? '';
        
        if (str_starts_with($matricule, 'STF')) {
            return redirect()->route('staff.dashboard')
                ->with('success', "Bienvenue dans votre espace Staff" . ($name ? ", {$name}" : ""));
        }

        // Vérifie si c'est un chef de département avec un code de département
        if (preg_match('/^CM-HQ-(.*)-CD$/i', $matricule)) {
            return redirect()->route('departments.dashboard')
                ->with('success', "Bienvenue dans votre espace Chef de Département" . ($name ? ", {$name}" : ""));
        }

        // Pour les nouveaux chefs de département sans code
        if (strtoupper($matricule) === 'CM-HQ-CD') {
            return redirect()->route('departments.choose')
                ->with('message', "Bienvenue Chef de Département" . ($name ? ", {$name}" : "") . ". Veuillez choisir votre département");
        }

        if (strtoupper($matricule) === 'CM-HQ-NEH') {
            return redirect()->route('committee.dashboard')
                ->with('success', "Bienvenue dans votre espace cher Membre du Comité de Nehemie" . ($name ? ", {$name}" : ""));
        }

        // Gestion du super administrateur
        if(str_starts_with(strtoupper($matricule), 'CM-HQ-SPAD')){
            $user = Auth::user();
            // Si le matricule est juste CM-HQ-SPAD (première connexion), générer le matricule complet
            if($matricule === 'CM-HQ-SPAD') {
                $user->matricule = $this->generateMatriculeSPAD();
                $user->save();
            }
            // Redirection vers l'authentification à deux facteurs
            return redirect()->route('twoFactorAuth')
                ->with('success', "Veuillez vous authentifier pour accéder à votre espace Super Administrateur.");
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
     * Génération d'un matricule Super Admin (CM-HQ-SPAD-001, CM-HQ-SPAD-002, ...)
     * @return string
     */
    public function generateMatriculeSPAD()
    {
        // Récupère le dernier super admin
        $lastSpad = User::where('matricule', 'LIKE', 'CM-HQ-SPAD-%')
                       ->orderBy('id', 'desc')
                       ->first();

        // Valeur par défaut si aucun super admin n'existe
        $lastNumber = 0;

        if ($lastSpad && !empty($lastSpad->matricule)) {
            // Extrait le numéro de la fin du matricule
            if (preg_match('/(\d+)$/', $lastSpad->matricule, $matches)) {
                $lastNumber = intval($matches[1]);
            }
        }

        $newNumber = $lastNumber + 1;

        // Format : CM-HQ-SPAD-XXX où XXX est un numéro sur 3 chiffres
        return 'CM-HQ-SPAD-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
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

        $existingHead = User::where('matricule', 'LIKE', "CM-HQ-{$deptCode}-CD")
                            ->where('id', '!=', Auth::id())
                            ->first();
        if($existingHead){
            return redirect()->back()->withErrors([
                'departement' => "Desole le departement {$deptCode} est deja enregistre.veuillez en choisir un autre"
            ]);
        }
        $user = Auth::user();
        $user->matricule = $this->generateMatriculeHeadDepts($deptCode);
        
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
            
   