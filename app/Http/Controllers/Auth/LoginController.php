<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\UserRegister;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public const HOME = '/dashboard';
   
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
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

        $user = UserRegister::where('email', $request->email)->first();

        if (!$user) {
            // Création automatique de l'utilisateur s'il n'existe pas
                $user = UserRegister::create([
                'matricule' => $request->matricule, // bien orthographié !
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        }

        if (Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->intended(\App\Providers\RouteServiceProvider::HOME)->with('success', 'Connexion réussie !');
        }

        return back()->withErrors([
            'email' => 'Identifiants invalides ou utilisateur non trouvé.'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
