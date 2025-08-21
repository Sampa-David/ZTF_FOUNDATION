<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Service;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('services', 'departments')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullName' => 'required|string|max:255',
            'fathersName' => 'required|string|max:255',
            'mothersName' => 'required|string|max:255',
            'dateOfBirth' => 'required|date',
            'placeOfBirth' => 'required|string|max:255',
            'idPassportNumber' => 'required|string|max:255',
            
            'fullAddress' => 'required|string',
            'phoneNumber' => 'required|string|max:20',
            'whatsappNumber' => 'nullable|string|max:20',
            'region' => 'required|string|max:255',
            'placeOfResidence' => 'required|string|max:255',
            'departmentOfOrigin' => 'required|string|max:255',
            'village' => 'nullable|string|max:255',
            'ethnicity' => 'nullable|string|max:255',
            'numberOfSiblings' => 'nullable|integer|min:0',
            'nextOfKinName' => 'nullable|string|max:255',
            'nextOfKinCity' => 'nullable|string|max:255',
            'nextOfKinContact' => 'nullable|string|max:20',
            'familyHeadName' => 'nullable|string|max:255',
            'familyHeadCity' => 'nullable|string|max:255',
            'familyHeadContact' => 'nullable|string|max:20',
            
            'conversionDate' => 'required|date',
            'baptismByImmersion' => 'required|in:Yes,No',
            'baptismInHolySpirit' => 'required|in:Yes,No',
            'homeChurch' => 'nullable|string|max:255',
            'center' => 'nullable|string|max:255',
            'discipleMakerName' => 'nullable|string|max:255',
            'discipleMakerContact' => 'nullable|string|max:20',
            'spiritualParentageName' => 'nullable|string|max:255',
            'spiritualParentageContact' => 'nullable|string|max:20',
            'spiritualParentageRelationship' => 'nullable|string',
            'testimony' => 'required|string',
            
            'maritalStatus' => 'required|in:Married,Single,Engaged',
            'spouseName' => 'nullable|string|max:255',
            'spouseContact' => 'nullable|string|max:20',
            'numberOfLegitimateChildren' => 'nullable|integer|min:0',
            'legitimateChildrenDetails' => 'nullable|string',
            'numberOfDependents' => 'nullable|integer|min:0',
            'dependentsDetails' => 'nullable|string',
            'siblingsDetails' => 'nullable|string',

            'educationFinancer' => 'nullable|string|max:255',
            'educationLevel' => 'required|string|max:255',
            'degreeObtained' => 'required|string|max:255',
            'activityBeforeHQ' => 'nullable|string',
            'hqEntryDate' => 'required|date',
            'hqDepartment' => 'required|string|max:255',
            'originCountryCity' => 'required|string|max:255',
            'departmentResponsibility' => 'required|string',
            'timeInDepartment' => 'required|string|max:255',
            'monthlyAllowance' => 'required|in:Yes,No',
            'allowanceSince' => 'required|date|before:today',
            'otherResponsibilities' => 'required|string',
            'departmentChanges' => 'nullable|string',
            'haveDisciples' => 'required|in:Yes,No',
            'numberOfDisciples' => 'required|integer|min:0',
            'degreesHeld' => 'nullable|string|max:255',
            'professionalTrainingReceived' => 'required|string|max:255',
            'professionalTrainingLocation' => 'required|string|max:255',
            'professionalTrainingDuration' => 'required|string|max:255',
            'onTheJobTraining' => 'required|in:Yes,No',
            'whyWorkAtHQ' => 'required|string',
            'briefTestimony' => 'required|string',

            'whoIntroducedToHQ' => 'required|string',
            'callOfGod' => 'required|in:Yes,No',
            'whatCallConsistsOf' => 'required|string',
            'familyAwareOfCall' => 'required|in:Yes,No',
            'familyReleasedForCall' => 'required|in:Yes,No',
            'emergencyContactDeath' => 'required|string|max:255',
            'burialLocation' => 'nullable|string|max:255',
            'familyAwareOfBurialLocation' => 'nullable|in:Yes,No',

            'yourPossessions' => 'required|string',
            'sourcesOfIncome' => 'required|string',
            'healthProblems' => 'required|string',
            'underTreatment' => 'required|in:Yes,No',
            'operationsDetails' => 'required|string',
            'specialDiet' => 'nullable|in:Yes,No',
            'commonFamilyIllnesses' => 'nullable|string',

            'problemsWithAnyone' => 'nullable|in:Yes,No',
            'reasonForProblems' => 'nullable|string',
            'beenToPrison' => 'nullable|in:Yes,No',
            'reasonForPrison' => 'nullable|string',
            
            'bulletin3File' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'medicalCertificateHopeClinicFile' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'diplomasFile.*' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'birthMarriageCertificatesFile.*' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'cniFile' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'familyCommitmentCallFile' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'familyBurialAgreementFile' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'gdprConsent' => 'required|accepted',
            'password' => 'required|string|min:6|max:12'
        ]);

        // Gestion des fichiers
        if ($request->hasFile('bulletin3File')) {
            $validated['bulletin3File'] = $request->file('bulletin3File')->store('documents');
        }
        if ($request->hasFile('medicalCertificateHopeClinicFile')) {
            $validated['medicalCertificateHopeClinicFile'] = $request->file('medicalCertificateHopeClinicFile')->store('documents');
        }
        if ($request->hasFile('cniFile')) {
            $validated['cniFile'] = $request->file('cniFile')->store('documents');
        }
        if ($request->hasFile('familyCommitmentCallFile')) {
            $validated['familyCommitmentCallFile'] = $request->file('familyCommitmentCallFile')->store('documents');
        }
        if ($request->hasFile('familyBurialAgreementFile')) {
            $validated['familyBurialAgreementFile'] = $request->file('familyBurialAgreementFile')->store('documents');
        }

        // Gestion des fichiers multiples
        if($request->hasFile('diplomasFile')){
            $diplomasPaths=[];
            foreach($request->file('diplomasFile') as  $file){
                $diplomasPaths[]=$file->store('documents');
            }
            $validated['diplomasFile']=json_encode($diplomasPaths);
        }

        if($request->hasFile('birthMarriageCertificatesFile')){
            $birthMarriageCertificatesPaths=[];
            foreach($request->file('birthMarriageCertificatesFile') as $file){
                $birthMarriageCertificatesPaths[]=$file->store('documents');
            }
            $validated['birthMarriageCertificatesFile']=json_encode($birthMarriageCertificatesPaths);
        }
        $validated['password']=Hash::make($validated['password']);
        $user=User::create($validated);
        return redirect()->route('users.index')->with('success','enregistre avec success');
    }
    
        

    /**
     * Affiche un utilisateur specifique
     */
    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    /**
     * Affiche le formulaire d'edition
     */
    public function edit(User $user)
    {
        $service=Service::all();
        return view('users.edit',compact('user','services'));
    }

    /**
     * Met a jour les informations d'un utilisateur specifique
     */
    public function update(Request $request, User $user)
    {
         $validated = $request->validate([
        
        'fullName' => 'required|string|max:255',
        'fathersName' => 'required|string|max:255',
        'mothersName' => 'required|string|max:255',
        'dateOfBirth' => 'required|date',
        'placeOfBirth' => 'required|string|max:255',
        'idPassportNumber' => 'required|string|max:255',

        
        'fullAddress' => 'required|string',
        'phoneNumber' => 'required|string|max:20',
        'whatsappNumber' => 'nullable|string|max:20',
        'region' => 'required|string|max:255',
        'placeOfResidence' => 'required|string|max:255',
        'departmentOfOrigin' => 'required|string|max:255',
        'village' => 'nullable|string|max:255',
        'ethnicity' => 'nullable|string|max:255',
        'numberOfSiblings' => 'nullable|integer|min:0',
        'nextOfKinName' => 'nullable|string|max:255',
        'nextOfKinCity' => 'nullable|string|max:255',
        'nextOfKinContact' => 'nullable|string|max:20',
        'familyHeadName' => 'nullable|string|max:255',
        'familyHeadCity' => 'nullable|string|max:255',
        'familyHeadContact' => 'nullable|string|max:20',

        
        'conversionDate' => 'required|date',
        'baptismByImmersion' => 'required|in:Yes,No',
        'baptismInHolySpirit' => 'required|in:Yes,No',
        'homeChurch' => 'nullable|string|max:255',
        'center' => 'nullable|string|max:255',
        'discipleMakerName' => 'nullable|string|max:255',
        'discipleMakerContact' => 'nullable|string|max:20',
        'spiritualParentageName' => 'nullable|string|max:255',
        'spiritualParentageContact' => 'nullable|string|max:20',
        'spiritualParentageRelationship' => 'nullable|string',
        'testimony' => 'required|string',

        
        'maritalStatus' => 'required|in:Married,Single,Engaged',
        'spouseName' => 'nullable|string|max:255',
        'spouseContact' => 'nullable|string|max:20',
        'numberOfLegitimateChildren' => 'nullable|integer|min:0',
        'legitimateChildrenDetails' => 'nullable|string',
        'numberOfDependents' => 'nullable|integer|min:0',
        'dependentsDetails' => 'nullable|string',
        'siblingsDetails' => 'nullable|string',


        'educationFinancer' => 'nullable|string|max:255',
        'educationLevel' => 'required|string|max:255',
        'degreeObtained' => 'required|string|max:255',
        'activityBeforeHQ' => 'nullable|string',
        'hqEntryDate' => 'required|date',
        'hqDepartment' => 'required|string|max:255',
        'originCountryCity' => 'required|string|max:255',
        'departmentResponsibility' => 'required|string',
        'timeInDepartment' => 'requiredstring|max:255',
        'monthlyAllowance' => 'requred|in:Yes,No',
        'allowanceSince' => 'required|date|before:today',
        'otherResponsibilities' => 'required|string',
        'departmentChanges' => 'nullable|string',
        'haveDisciples' => 'required|in:Yes,No',
        'numberOfDisciples' => 'required|integer|min:0',
        'degreesHeld' => 'nullable|string|max:255',
        'professionalTrainingReceived' => 'required|string|max:255',
        'professionalTrainingLocation' => 'required|string|max:255',
        'professionalTrainingDuration' => 'required|string|max:255',
        'onTheJobTraining' => 'required|in:Yes,No',
        'whyWorkAtHQ' => 'required|string',
        'briefTestimony' => 'required|string',

        'whoIntroducedToHQ' => 'required|string',
        'callOfGod' => 'required|in:Yes,No',
        'whatCallConsistsOf' => 'required|string',
        'familyAwareOfCall' => 'required|in:Yes,No',
        'familyReleasedForCall' => 'required|in:Yes,No',
        'emergencyContactDeath' => 'required|string|max:255',
        'burialLocation' => 'nullable|string|max:255',
        'familyAwareOfBurialLocation' => 'nullable|in:Yes,No',

        'yourPossessions' => 'required|string',
        'sourcesOfIncome' => 'required|string',
        'healthProblems' => 'required|string',
        'underTreatment' => 'required|in:Yes,No',
        'operationsDetails' => 'required|string',
        'specialDiet' => 'nullable|in:Yes,No',
        'commonFamilyIllnesses' => 'nullable|string',

        'problemsWithAnyone' => 'nullable|in:Yes,No',
        'reasonForProblems' => 'nullable|string',
        'beenToPrison' => 'nullable|in:Yes,No',
        'reasonForPrison' => 'nullable|string',

        
        'bulletin3File' => 'required|file|mimes:pdf,jpg,png|max:2048',
        'medicalCertificateHopeClinicFile' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        'diplomasFile.*' => 'required|file|mimes:pdf,jpg,png|max:2048',
        'birthMarriageCertificatesFile.*' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        'cniFile' => 'required|file|mimes:pdf,jpg,png|max:2048',
        'familyCommitmentCallFile' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        'familyBurialAgreementFile' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        'gdprConsent' => 'required|accepted',
        'password'=>'required|string|min:6|max:12'
    ]);

    if(!empty($validated['password'])){
        $validated['password']=Hash::make($validated['password']);
    }else{
        unset($validated['password']);
    }

    $user->update($validated);
    $sexe = $user->sexe == 'M' ? 'Mr' : 'Mme';
    return redirect()->route('users.index')->with('success', "$sexe {$user->name} {$user->surname} vos informations ont été mises à jour avec succès");
    }

    /**
     * Supprime un utilisateur specifique definitivement de la base de donnee
     */
    public function destroy(User $user)
    {
        $sexe = $user->sexe == 'M' ? 'Mr' : 'Mme';
        $user->delete();
        return redirect()->route('users.index')->with('success', "$sexe {$user->name} {$user->surname} supprimé avec succès");
    }
}
