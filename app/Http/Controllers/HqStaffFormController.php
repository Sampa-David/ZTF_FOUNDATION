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
     * Télécharge le PDF d'un utilisateur spécifique
     */
    public function downloadUserPDF($id)
    {
        try {
            // Récupérer les données du formulaire pour l'utilisateur spécifique
            $staffForm = \App\Models\HqStaffForm::where('user_id', $id)->firstOrFail();

            // Génération du PDF
            $pdf = PDF::loadView('formulaire.pdf', $staffForm->toArray())
                ->setPaper('a4', 'portrait')
                ->setOptions([
                    'defaultFont' => 'DejaVu Sans',
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'isFontSubsettingEnabled' => true,
                    'dpi' => 300,
                    'defaultPaperSize' => 'a4',
                    'margin_left' => 20,
                    'margin_right' => 20,
                    'margin_top' => 20,
                    'margin_bottom' => 20,
                    'enable_php' => false,
                    'enable_javascript' => true,
                ]);

            // Téléchargement du PDF
            return $pdf->download('staff_form_' . $id . '_' . now()->format('Y-m-d_His') . '.pdf');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Le formulaire de cet utilisateur n\'a pas été trouvé.');
        } catch (Exception $e) {
            Log::error('Erreur lors de la génération du PDF: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la génération du PDF.');
        }
    }

    /**
     * Télécharge le PDF du formulaire
     */
    public function telechargerPDF(Request $request)
    {
        try {
            // Validation des données
            $validated = $request->validate([
                // Section 1 : Personal Information
                'fullName' => 'required|string|max:255',
                'fathersName' => 'nullable|string|max:255',
                'mothersName' => 'nullable|string|max:255',
                'dateOfBirth' => 'required|date',
                'placeOfBirth' => 'required|string|max:255',
                'idPassportNumber' => 'nullable|string|max:50',

                // Section 2 : Contact & Location
                'fullAddress' => 'required|string|max:500',
                'phoneNumber' => 'required|string|max:20',
                'whatsappNumber' => 'nullable|string|max:20',
                'region' => 'required|string|max:100',
                'placeOfResidence' => 'required|string|max:255',
                'departmentOfOrigin' => 'required|string|max:255',
                'village' => 'nullable|string|max:255',
                'ethnicity' => 'nullable|string|max:100',
                'numberOfSiblings' => 'nullable|integer|min:0',
                'nextOfKinName' => 'required|string|max:255',
                'nextOfKinCity' => 'required|string|max:255',
                'nextOfKinContact' => 'required|string|max:20',
                'familyHeadName' => 'required|string|max:255',
                'familyHeadCity' => 'required|string|max:255',
                'familyHeadContact' => 'required|string|max:20',

                // Section 3 : Spiritual Life
                'conversionDate' => 'required|date',
                'baptismByImmersion' => 'required|in:Yes,No',
                'baptismInHolySpirit' => 'required|in:Yes,No',
                'homeChurch' => 'required|string|max:255',
                'center' => 'required|string|max:255',
                'discipleMakerName' => 'required|string|max:255',
                'discipleMakerContact' => 'required|string|max:20',
                'spiritualParentageName' => 'required|string|max:255',
                'spiritualParentageContact' => 'required|string|max:20',
                'spiritualParentageRelationship' => 'required|string|max:500',
                'testimony' => 'required|string|max:1000',

                // Section 4 : Family Life
                'maritalStatus' => 'required|in:Married,Single,Engaged',
                'spouseName' => 'nullable|required_if:maritalStatus,Married|string|max:255',
                'spouseContact' => 'nullable|required_if:maritalStatus,Married|string|max:20',
                'numberOfLegitimateChildren' => 'nullable|integer|min:0',
                'legitimateChildrenDetails' => 'nullable|required_if:numberOfLegitimateChildren,>,0|string|max:1000',
                'numberOfDependents' => 'nullable|integer|min:0',
                'dependentsDetails' => 'nullable|required_if:numberOfDependents,>,0|string|max:1000',
                'siblingsDetails' => 'nullable|string|max:1000',

                // Section 5 : Professional Life
                'educationFinancer' => 'required|string|max:255',
                'educationLevel' => 'required|string|max:255',
                'degreeObtained' => 'nullable|string|max:255',
                'activityBeforeHQ' => 'required|string|max:500',
                'hqEntryDate' => 'required|date',
                'hqDepartment' => 'required|string|max:255',
                'originCountryCity' => 'required|string|max:255',
                'departmentResponsibility' => 'required|string|max:500',

                // Section 6 : Commissioning
                'whoIntroducedToHQ' => 'required|string|max:500',
                'callOfGod' => 'required|in:Yes,No',
                'whatCallConsistsOf' => 'nullable|required_if:callOfGod,Yes|string|max:1000',
                'familyAwareOfCall' => 'required|in:Yes,No',
                'emergencyContactDeath' => 'required|string|max:500',
                'burialLocation' => 'required|string|max:500',

                // Section 7 : Possessions & Health
                'yourPossessions' => 'nullable|string|max:1000',
                'sourcesOfIncome' => 'required|string|max:500',
                'healthProblems' => 'nullable|string|max:1000',
                'underTreatment' => 'required|in:Yes,No',
                'operationsDetails' => 'nullable|string|max:1000',

                // Section 8 : Judicial History
                'problemsWithAnyone' => 'required|in:Yes,No',
                'reasonForProblems' => 'nullable|required_if:problemsWithAnyone,Yes|string|max:1000',
                'beenToPrison' => 'required|in:Yes,No',
                'reasonForPrison' => 'nullable|required_if:beenToPrison,Yes|string|max:1000',

                // Section 9 : Documents
                'bulletin3File' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'medicalCertificateHopeClinicFile' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'diplomasFile' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'birthMarriageCertificatesFile' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'cniFile' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'familyCommitmentCallFile' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'familyBurialAgreementFile' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',

                // Consentement RGPD
                'gdprConsent' => 'required|accepted'
            ]);

            // Gestion des fichiers uploadés
            $paths = [];
            $fileFields = [
                'bulletin3File' => 'bulletin3_path',
                'medicalCertificateHopeClinicFile' => 'medical_certificate_path',
                'diplomasFile' => 'diplomas_path',
                'birthMarriageCertificatesFile' => 'birth_marriage_certificates_path',
                'cniFile' => 'cni_path',
                'familyCommitmentCallFile' => 'family_commitment_path',
                'familyBurialAgreementFile' => 'family_burial_agreement_path'
            ];

            foreach ($fileFields as $requestField => $dbField) {
                if ($request->hasFile($requestField)) {
                    $file = $request->file($requestField);
                    $path = $file->store('staff_documents', 'public');
                    $paths[$dbField] = Storage::url($path);
                }
            }

            // Fusion des données validées avec les chemins des fichiers
            $formData = array_merge($request->all(), $paths);

            // Sauvegarde en base de données
            $staffForm = \App\Models\HqStaffForm::create($formData);

            // Génération du PDF
            $pdf = PDF::loadView('formulaire.pdf', $formData)
                ->setPaper('a4', 'portrait')
                ->setOptions([
                    'defaultFont' => 'DejaVu Sans',
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'isFontSubsettingEnabled' => true,
                    'dpi' => 300,
                    'defaultPaperSize' => 'a4',
                    'margin_left' => 20,
                    'margin_right' => 20,
                    'margin_top' => 20,
                    'margin_bottom' => 20,
                    'enable_php' => false,
                    'enable_javascript' => true,
                ]);

            // Stockage du PDF
            $filename = 'staff_form_' . $staffForm->id . '_' . now()->format('Y-m-d_His') . '.pdf';
            Storage::put('public/pdfs/staff_forms/' . $filename, $pdf->output());

            // Téléchargement du PDF
            return $pdf->download($filename);

        } catch (Exception $e) {
            Log::error('Erreur lors de la génération du PDF: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la génération du PDF. Veuillez réessayer.');
        }
    }
}