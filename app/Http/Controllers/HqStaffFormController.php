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
        
    }
}