<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class HqStaffFormController extends Controller
{
    public function telechargerPDF(Request $request)
    {
        try {
            // Log the start of PDF generation
            Log::info('Début de la génération du PDF');
            
            // Récupérer toutes les données du formulaire
            $formData = $request->all();
            Log::info('Données du formulaire récupérées', ['data_keys' => array_keys($formData)]);
            
            // Générer un nom de fichier simple
            $filename = 'formulaire_inscription_ZTF.pdf';
            
            // Préparer le PDF avec les options optimales
            $pdf = PDF::loadView('formulaire.pdf', $formData);
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'enable_php' => false,
                'isRemoteEnabled' => false,
                'defaultFont' => 'dejavu serif',
                'dpi' => 120,
                'defaultMediaType' => 'print'
            ]);

            // Générer et retourner le PDF en téléchargement
            Log::info('Génération du PDF terminée, début du téléchargement');
            return $pdf->download($filename);

        } catch (\Exception $e) {
            // Log l'erreur
            Log::error('Erreur lors de la génération du PDF', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            // Retourner à la page précédente avec un message d'erreur
            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la génération du PDF. Veuillez réessayer.');
    }

    
        }
    

    public function showBigForm()
    {
        return view('formulaire.create');
    }
}
