<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF; // alias de barryvdh/laravel-dompdf

class HqStaffFormController extends Controller
{
    public function telechargerPDF(Request $request)
    {
        // Récupération de TOUTES les données envoyées
        $data = $request->all();

        echo($data);
        
        // Charger la vue avec les données
        $pdf = PDF::loadView('formulaire.pdf', $data);

        // Télécharger le fichier
        return $pdf->download('formulaire_complet.pdf');
    }

    public function showBigForm()
    {
        return view('formulaire.create');
    }
}
