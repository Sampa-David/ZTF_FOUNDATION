<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class HqStaffFormController extends Controller
{
    
    public function DownloadPdf(Request $request){
        $fullName = $request->input('fullName');
        echo $fullName;
        $pdf = PDF::loadView('formulaire.pdf', ['fullName' => $fullName]);
        return $pdf->download('formulaire.pdf');
    }
    public function showBigForm(){
        return view('formulaire.create');
    }
}
