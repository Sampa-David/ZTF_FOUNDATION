<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HqStaffFormController extends Controller
{
    /**
     * Affiche le formulaire principal
     */
    public function showBigForm()
    {
        return view('formulaire.create');
    }

    /**
     * Télécharge le PDF du formulaire
     */
    public function telechargerPDF(Request $request)
    {
        try {
            // Validation des données minimales requises
            $request->validate([
                'fullName' => 'required|string|max:255',
                'phoneNumber' => 'required|string|max:20',
                'dateOfBirth' => 'required|date',
            ]);

            // Préparer les données pour le PDF
            $formData = $this->prepareFormData($request);
            
            // Générer un nom de fichier unique
            $filename = $this->generateFilename($formData['fullName']);

            // Générer le PDF
            $pdf = $this->generatePDF($formData);

            // Enregistrer une copie du PDF (optionnel)
            $this->savePDFCopy($pdf, $filename);

            Log::info('PDF généré avec succès', ['filename' => $filename]);

            // Retourner le PDF pour téléchargement
            return $pdf->download($filename);

        } catch (Exception $e) {
            Log::error('Erreur lors de la génération du PDF', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la génération du PDF. Veuillez réessayer.');
        }
    }

    /**
     * Prépare les données du formulaire avec des valeurs par défaut
     */
    private function prepareFormData(Request $request): array
    {
        $defaultData = [
            // Section 1: Informations personnelles
            'fullName' => '', 'fathersName' => '', 'mothersName' => '',
            'dateOfBirth' => '', 'placeOfBirth' => '', 'idPassportNumber' => '',
            
            // Section 2: Contact et localisation
            'fullAddress' => '', 'phoneNumber' => '', 'whatsappNumber' => '',
            'region' => '', 'placeOfResidence' => '', 'departmentOfOrigin' => '',
            'village' => '', 'ethnicity' => '', 'numberOfSiblings' => '',
            
            // Section 3: Contact d'urgence
            'nextOfKinName' => '', 'nextOfKinCity' => '', 'nextOfKinContact' => '',
            'familyHeadName' => '', 'familyHeadCity' => '', 'familyHeadContact' => '',
            
            // Section 4: Vie spirituelle
            'conversionDate' => '', 'baptismByImmersion' => 'Non renseigné',
            'baptismInHolySpirit' => 'Non renseigné', 'homeChurch' => '',
            'center' => '', 'discipleMakerName' => '', 'discipleMakerContact' => '',
            'spiritualParentageName' => '', 'spiritualParentageContact' => '',
            'spiritualParentageRelationship' => '', 'testimony' => '',
            
            // Section 5: Vie familiale
            'maritalStatus' => '', 'spouseName' => '', 'spouseContact' => '',
            'numberOfLegitimateChildren' => '', 'legitimateChildrenDetails' => '',
            'numberOfDependents' => '', 'dependentsDetails' => '',
            'siblingsDetails' => '',
            
            // Section 6: Vie professionnelle
            'educationFinancer' => '', 'educationLevel' => '', 'degreeObtained' => '',
            'activityBeforeHQ' => '', 'hqEntryDate' => '', 'hqDepartment' => '',
            'originCountryCity' => '', 'departmentResponsibility' => '',
            
            // Section 7: Commissionnement
            'whoIntroducedToHQ' => '', 'callOfGod' => 'Non renseigné',
            'whatCallConsistsOf' => '', 'familyAwareOfCall' => 'Non renseigné',
            'emergencyContactDeath' => '', 'burialLocation' => '',
            
            // Section 8: Santé et possessions
            'yourPossessions' => '', 'sourcesOfIncome' => '',
            'healthProblems' => '', 'underTreatment' => 'Non renseigné',
            'operationsDetails' => '',
            
            // Section 9: Historique judiciaire
            'problemsWithAnyone' => 'Non renseigné', 'reasonForProblems' => '',
            'beenToPrison' => 'Non renseigné', 'reasonForPrison' => ''
        ];

        return array_merge($defaultData, $request->all());
    }

    /**
     * Génère un nom de fichier unique pour le PDF
     */
    private function generateFilename(string $fullName): string
    {
        $sanitizedName = Str::slug($fullName);
        $date = now()->format('Y-m-d_His');
        return "formulaire_inscription_ZTF_{$sanitizedName}_{$date}.pdf";
    }

    /**
     * Génère le PDF avec les configurations appropriées
     */
    private function generatePDF(array $formData)
    {
        return Pdf::loadView('formulaire.pdf', $formData, [], [
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'DejaVu Sans',
            'enable_php' => false,
            'enable_javascript' => true,
            'enable_remote' => true,
            'log_output_file' => storage_path('logs/pdf.log'),
            'font_path' => base_path('storage/fonts/'),
            'font_cache' => storage_path('fonts/'),
            'temp_dir' => sys_get_temp_dir(),
        ])->setPaper('A4', 'portrait');
    }

    /**
     * Sauvegarde une copie du PDF généré
     */
    private function savePDFCopy($pdf, string $filename): void
    {
        try {
            Storage::disk('local')->put("pdfs/{$filename}", $pdf->output());
            Log::info('Copie du PDF sauvegardée', ['filename' => $filename]);
        } catch (Exception $e) {
            Log::warning("Impossible de sauvegarder une copie du PDF", [
                'error' => $e->getMessage()
            ]);
            // On continue même si la sauvegarde échoue
        }
    }
}