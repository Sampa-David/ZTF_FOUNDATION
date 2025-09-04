<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\StaffPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HqStaffFormController extends Controller
{
    public function DownloadPdf(Request $request)
    {
        try {
            // Log de début
            \Log::info('Début de la génération du PDF');
            
            // Récupérer toutes les données du formulaire
            $staffData = $request->except(['_token', '_method']);
            
            // Log des données reçues
            \Log::info('Données du formulaire reçues', ['data' => array_keys($staffData)]);
            
            // Gérer les valeurs booléennes des radios
            $radioFields = [
                'baptismByImmersion',
                'baptismInHolySpirit',
                'callOfGod',
                'familyAwareOfCall',
                'underTreatment',
                'problemsWithAnyone',
                'beenToPrison'
            ];
            
            foreach ($radioFields as $field) {
                if (!isset($staffData[$field])) {
                    $staffData[$field] = 'Non renseigné';
                }
            }

            // Vérifier que le dossier pdfs existe dans le storage public
            if (!Storage::disk('public')->exists('pdfs')) {
                Storage::disk('public')->makeDirectory('pdfs');
                \Log::info('Dossier pdfs créé');
            }

            // Charger la vue PDF avec les données
            try {
                \Log::info('Génération du PDF avec la vue');
                $pdf = PDF::loadView('formulaire.pdf', $staffData);
                \Log::info('PDF généré avec succès');
            } catch (\Exception $e) {
                \Log::error('Erreur lors de la génération du PDF: ' . $e->getMessage());
                return back()->with('error', 'Erreur lors de la génération du PDF. Veuillez réessayer.');
            }

            // Générer un nom unique pour le fichier
            $filename = 'Staff_Registration_Form_' . date('Y-m-d_H-i-s') . '.pdf';
            $path = 'pdfs/' . $filename;

            // Sauvegarder le PDF dans le stockage public
            try {
                \Log::info('Sauvegarde du PDF dans ' . $path);
                Storage::disk('public')->put($path, $pdf->output());
                \Log::info('PDF sauvegardé avec succès');

                // Vérifier que le fichier existe
                if (!Storage::disk('public')->exists($path)) {
                    throw new \Exception('Le fichier n\'a pas été créé');
                }

                // Enregistrer les informations dans la base de données
                $staffPdf = StaffPdf::create([
                    'user_id' => auth()->check() ? auth()->id() : null,
                    'filename' => $filename,
                    'path' => $path
                ]);
                \Log::info('Enregistrement en base de données réussi');
            } catch (\Exception $e) {
                \Log::error('Erreur lors de la sauvegarde: ' . $e->getMessage());
                return back()->with('error', 'Erreur lors de la sauvegarde du PDF. Veuillez réessayer.');
            }

            // Nettoyer le buffer de sortie
            while (ob_get_level()) {
                ob_end_clean();
            }

            \Log::info('Envoi du PDF au navigateur');
            
            // Retourner le PDF pour téléchargement
            return response()->streamDownload(
                function() use ($pdf) {
                    echo $pdf->output();
                },
                $filename,
                [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="' . $filename . '"'
                ]
            );

        } catch (\Exception $e) {
            // Log l'erreur et retourner un message d'erreur
            \Log::error('Erreur lors de la génération du PDF: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la génération du PDF. Veuillez réessayer.');
        }
    }

    public function pdfList()
    {
        $pdfs = StaffPdf::all();
        return view('formulaire.pdfList', compact('pdfs'));
    }

    public function DownloadPdfFormDb($id)
    {
        try {
            $pdf = StaffPdf::findOrFail($id);

            if (!Storage::disk('public')->exists($pdf->path)) {
                abort(404, 'Fichier non trouvé');
            }

            return Storage::disk('public')->download($pdf->path, $pdf->filename);
        } catch (\Exception $e) {
            \Log::error('Erreur lors du téléchargement du PDF: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors du téléchargement du PDF.');
        }
    }

    public function showBigForm()
    {
        return view('formulaire.create');
    }
}
