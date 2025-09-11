<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class TwoFAController extends Controller
{
    //generer le code ,le sauvegarder en session de laravel puis l'envoyer par email

    public function sendCode(Request $request)
    {
        // Vérifie si l'email est dans la session
        $email = Session::get('auth_email');
        if (!$email) {
            return response()->json([
                'message' => 'Session expirée ou invalide'
            ], 401);
        }

        // Générer un code à 12 chiffres
        $code = str_pad(random_int(0, 999999999999), 12, '0', STR_PAD_LEFT);

        // Stockage en session
        Session::put('2fa_code', [
            'code' => $code,
            'email' => $request->email,
            'expires_at' => now()->addSeconds(30)
        ]);

        // Envoi du code par email
        try {
            Mail::raw("Votre code d'identification ZTF Foundation : $code", function($message) use ($email) {
                $message->to($email)
                       ->subject("Code d'authentification ZTF Foundation");
            });

            return response()->json([
                'message' => "Un code d'identification a été envoyé à {$request->email}"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Erreur lors de l'envoi du code"
            ], 500);
        }
    }

    //Permet de verifier la saisi de l'utilisateur
    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:12'
        ]);

        $twoFaData = Session::get('2fa_code');

        if (!$twoFaData || now()->isAfter($twoFaData['expires_at'])) {
            return response()->json([
                'message' => 'Le code a expiré'
            ], 400);
        }

        if ($request->code !== $twoFaData['code']) {
            return response()->json([
                'message' => 'Code incorrect'
            ], 400);
        }

        // Authentification réussie
        Session::put('verified', true);
        
        // Nettoyage des données temporaires
        Session::forget('2fa_code');

        return response()->json([
            'message' => 'Authentification réussie',
            'redirect' => route('')
        ]);
    }
}
