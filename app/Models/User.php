<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table = 'users';
    protected $fillable = [
        'email',
        'password',
        'fullName',
        'fathersName',
        'mothersName',
        'dateOfBirth',
        'placeOfBirth',
        'idPassportNumber',
        'fullAddress',
        'phoneNumber',
        'whatsappNumber',
        'region',
        'placeOfResidence',
        'departmentOfOrigin',
        'village',
        'ethnicity',
        'numberOfSiblings',
        'nextOfKinName',
        'nextOfKinCity',
        'nextOfKinContact',
        'familyHeadName',
        'familyHeadCity',
        'familyHeadContact',
        'conversionDate',
        'baptismByImmersion',
        'baptismInHolySpirit',
        'homeChurch',
        'center',
        'discipleMakerName',
        'discipleMakerContact',
        'spiritualParentageName',
        'spiritualParentageContact',
        'spiritualParentageRelationship',
        'testimony',
        'maritalStatus',
        'spouseName',
        'spouseContact',
        'numberOfLegitimateChildren',
        'legitimateChildrenDetails',
        'numberOfDependents',
        'dependentsDetails',
        'siblingsDetails',
        'educationFinancer',
        'educationLevel',
        'degreeObtained',
        'activityBeforeHQ',
        'hqEntryDate',
        'hqDepartment',
        'originCountryCity',
        'departmentResponsibility',
        'timeInDepartment',
        'monthlyAllowance',
        'allowanceSince',
        'otherResponsibilities',
        'departmentChanges',
        'haveDisciples',
        'numberOfDisciples',
        'degreesHeld',
        'professionalTrainingReceived',
        'professionalTrainingLocation',
        'professionalTrainingDuration',
        'onTheJobTraining',
        'whyWorkAtHQ',
        'briefTestimony',
        'whoIntroducedToHQ',
        'callOfGod',
        'whatCallConsistsOf',
        'familyAwareOfCall',
        'familyReleasedForCall',
        'emergencyContactDeath',
        'burialLocation',
        'familyAwareOfBurialLocation',
        'yourPossessions',
        'sourcesOfIncome',
        'healthProblems',
        'underTreatment',
        'operationsDetails',
        'specialDiet',
        'commonFamilyIllnesses',
        'problemsWithAnyone',
        'reasonForProblems',
        'beenToPrison',
        'reasonForPrison',
        'bulletin3File',
        'medicalCertificateHopeClinicFile',
        'diplomasFile',
        'birthMarriageCertificatesFile',
        'cniFile',
        'familyCommitmentCallFile',
        'familyBurialAgreementFile',
        'gdprConsent'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'dateOfBirth' => 'date',
            'conversionDate' => 'date',
            'hqEntryDate' => 'date',
            'allowanceSince' => 'date',
            'password' => 'hashed',
            'gdprConsent' => 'boolean',
            'numberOfSiblings' => 'integer',
            'numberOfLegitimateChildren' => 'integer',
            'numberOfDependents' => 'integer',
            'numberOfDisciples' => 'integer',
            'diplomasFile' => 'array',
            'birthMarriageCertificatesFile' => 'array'
        ];
    }

    public function departments(){
        return $this->belongsTo(Departement::class);
    }

    public function service(){
        return $this->belongsTo(Service::class);
    }

    public function headDepartment(){
        return $this->hasMany(Departement::class,'head_id');
    }

}
