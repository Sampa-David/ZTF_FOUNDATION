<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use App\Models\UserRegister;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validated=$request->validate([
            'fullName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required','confirmed', Rules\Password::min(4)],
            ]);

            $validated['password']=Hash::make($validated['password']);
            UserRegister::create($validated);

        // Gestion des fichiers (exemple, à adapter selon la logique métier)
        // foreach ([
        //     'bulletin3File', 'medicalCertificateHopeClinicFile', 'diplomasFile',
        //     'birthMarriageCertificatesFile', 'cniFile', 'familyCommitmentCallFile', 'familyBurialAgreementFile'
        // ] as $fileField) {
        //     if ($request->hasFile($fileField)) {
        //         $user->{$fileField} = $request->file($fileField)->store('documents');
        //     }
        // }
        // $user->save();

        event(new Registered(UserRegister::create($validated)));
            // Auth::login($user); // On ne connecte pas automatiquement
            return redirect(route('login'))->with('success', 'Compte créé avec succès ! Connectez-vous.');
    }
}