<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HqStaffForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'fullName', 'fathersName', 'mothersName', 'dateOfBirth', 'placeOfBirth', 'idPassportNumber',
        'fullAddress', 'phoneNumber', 'whatsappNumber', 'region', 'placeOfResidence', 'departmentOfOrigin',
        'village', 'ethnicity', 'numberOfSiblings', 'nextOfKinName', 'nextOfKinCity', 'nextOfKinContact',
        'familyHeadName', 'familyHeadCity', 'familyHeadContact',
        'conversionDate', 'baptismByImmersion', 'baptismInHolySpirit', 'homeChurch', 'center',
        'discipleMakerName', 'discipleMakerContact', 'spiritualParentageName', 'spiritualParentageContact',
        'spiritualParentageRelationship', 'testimony',
        'maritalStatus', 'spouseName', 'spouseContact', 'numberOfLegitimateChildren', 'legitimateChildrenDetails',
        'numberOfDependents', 'dependentsDetails', 'siblingsDetails',
        'educationFinancer', 'educationLevel', 'degreeObtained', 'activityBeforeHQ', 'hqEntryDate',
        'hqDepartment', 'originCountryCity', 'departmentResponsibility',
        'whoIntroducedToHQ', 'callOfGod', 'whatCallConsistsOf', 'familyAwareOfCall', 'emergencyContactDeath',
        'burialLocation', 'yourPossessions', 'sourcesOfIncome', 'healthProblems', 'underTreatment',
        'operationsDetails', 'problemsWithAnyone', 'reasonForProblems', 'beenToPrison', 'reasonForPrison',
        'bulletin3_path', 'medical_certificate_path', 'diplomas_path', 'birth_marriage_certificates_path',
        'cni_path', 'family_commitment_path', 'family_burial_agreement_path'
    ];

    protected $casts = [
        'dateOfBirth' => 'date',
        'conversionDate' => 'date',
        'hqEntryDate' => 'date',
    ];
}