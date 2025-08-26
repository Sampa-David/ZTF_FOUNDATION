<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>ZTF Foundation</h1>
    <div class="section">
        <h2>Test PDF</h2>
        <p><strong>Full Name:</strong> {{ $fullName }}</p>
    </div>
    <div class="section">
        <h2>2. Contact details & Location</h2>
        <p><strong>Full Address:</strong>{{$fullAddress}}</p>
        <p><strong>Phone:</strong> {{ $phoneNumber }}</p>
        <p><strong>Whatsapp:</strong> {{ $whatsappNumber }}</p>
        <p><strong>Region:</strong> {{ $region }}</p>
        <p><strong>Place of Residence:</strong> {{ $placeOfResidence  }}</p>
        <p><strong>Department of Origin:</strong> {{ $departmentOfOrigin  }}</p>
        <p><strong>Village:</strong> {{ $village  }}</p>
        <p><strong>Ethnicity:</strong> {{ $ethnicity  }}</p>
        <p><strong>Number of Siblings:</strong> {{ $numberOfSiblings  }}</p>
        <p><strong>Next of Kin Name:</strong> {{ $nextOfKinName  }}</p>
        <p><strong>Next of Kin City:</strong> {{ $nextOfKinCity  }}</p>
        <p><strong>Next of Kin Contact:</strong> {{ $nextOfKinContact  }}</p>
        <p><strong>Family Head Name:</strong> {{ $familyHeadName }}</p>
        <p><strong>Family Head City:</strong> {{ $familyHeadCity  }}</p>
        <p><strong>Family Head Contact:</strong> {{ $familyHeadContact }}</p>
    </div>
    <div class="section">
        <h2>3. Spiritual Life</h2>
        <p><strong>Conversion Date:</strong>{{$conversionDate}}</p>
        <p><strong>Baptism by Immersion:</strong> {{ $baptismByImmersion  }}</p>
        <p><strong>Baptism in Holy Spirit:</strong> {{ $baptismInHolySpirit  }}</p>
        <p><strong>Home Church:</strong> {{ $homeChurch  }}</p>
        <p><strong>Center:</strong> {{ $center  }}</p>
        <p><strong>Disciple Maker:</strong> {{ $discipleMakerName  }} And ({{ $discipleMakerContact  }})</p>
        <p><strong>Spiritual Parentage:</strong> {{ $spiritualParentageName  }} And ({{ $spiritualParentageContact  }})</p>
        <p><strong>Relationship with Parent:</strong> {{ $spiritualParentageRelationship  }}</p>
        <p><strong>Testimony:</strong> {{ $testimony  }}</p>
    </div>


    <div class="section">
        <h2>4. Family Life</h2>
        <p><strong>Marital Status:</strong>{{$maritalStatus}}</p>
        <p><strong>Spouse Name:</strong> {{ $spouseName  }}</p>
        <p><strong>Spouse Contact:</strong> {{ $spouseContact }}</p>
        <p><strong>Number of Legitimate Children:</strong> {{ $numberOfLegitimateChildren  }}</p>
        <p><strong>Legitimate Children Details:</strong> {{ $legitimateChildrenDetails   }}</p>
        <p><strong>Number of Dependents:</strong> {{ $numberOfDependents   }}</p>
        <p><strong>Dependents Details:</strong> {{ $dependentsDetails  }}</p>
        <p><strong>Siblings Details:</strong> {{ $siblingsDetails  }}</p>
    </div>


    <div class="section">
        <h2>5. Professional Life</h2>
        <p><strong>Education Financer:</strong> {{ $educationFinancer }}</p>
        <p><strong>Education Level:</strong> {{ $educationLevel }}</p>
        <p><strong>Degree Obtained:</strong> {{ $degreeObtained }}</p>
        <p><strong>Activity Before HQ:</strong> {{ $activityBeforeHQ }}</p>
        <p><strong>Entry Date HQ:</strong> {{ $hqEntryDate }}</p>
        <p><strong>HQ Department:</strong> {{ $hqDepartment  }}</p>
        <p><strong>Origin Country/City:</strong> {{ $originCountryCity }}</p>
        <p><strong>Department Responsibility:</strong> {{ $departmentResponsibility  }}</p>
        <p><strong>Time in Department:</strong> {{ $timeInDepartment }}</p>
        <p><strong>Monthly Allowance:</strong> {{ $monthlyAllowance }} since {{ $allowanceSince  }}</p>
        <p><strong>Other Responsibilities:</strong> {{ $otherResponsibilities }}</p>
        <p><strong>Department Changes:</strong> {{ $departmentChanges  }}</p>
        <p><strong>Have Disciples ?:</strong> {{ $haveDisciples }} with ({{ $numberOfDisciples  }})</p>
        <p><strong>Degrees Held:</strong> {{ $degreesHeld }}</p>
        <p><strong>Professional Training:</strong> {{ $professionalTrainingReceived }} at {{ $professionalTrainingLocation  }} and ({{ $professionalTrainingDuration  }})</p>
        <p><strong>On the Job Training:</strong> {{ $onTheJobTraining  }}</p>
        <p><strong>Why Work at HQ:</strong> {{ $whyWorkAtHQ  }}</p>
        <p><strong>Brief Testimony:</strong> {{ $briefTestimony  }}</p>
    </div>

    
    <div class="section">
        <h2>6. Commissioning</h2>
        <p><strong>Introduced by:</strong> {{ $whoIntroducedToHQ }}</p>
        <p><strong>Call of God ?:</strong> {{ $callOfGod }}</p>
        <p><strong>What Call Consists Of:</strong> {{ $whatCallConsistsOf  }}</p>
        <p><strong>Family Aware ?:</strong> {{ $familyAwareOfCall }}</p>
        <p><strong>Family Released?:</strong> {{ $familyReleasedForCall  }}</p>
        <p><strong>Emergency Contact (Death):</strong> {{ $emergencyContactDeath  }}</p>
        <p><strong>Burial Location:</strong> {{ $burialLocation }}</p>
        <p><strong>Family Aware (Burial):</strong> {{ $familyAwareOfBurialLocation }}</p>
    </div>

    
    <div class="section">
        <h2>7. Possessions & Health History</h2>
        <p><strong>Possessions:</strong> {{ $yourPossessions }}</p>
        <p><strong>Sources of Income:</strong> {{ $sourcesOfIncome  }}</p>
        <p><strong>Health Problems:</strong> {{ $healthProblems }}</p>
        <p><strong>Under Treatment ?:</strong> {{ $underTreatment  }}</p>
        <p><strong>Operations Details:</strong> {{ $operationsDetails  }}</p>
        <p><strong>Special Diet ?:</strong> {{ $specialDiet  }}</p>
        <p><strong>Common Family Illnesses:</strong> {{ $commonFamilyIllnesses  }}</p>
    </div>

    
    <div class="section">
        <h2>8. Judicial History</h2>
        <p><strong>Problems with Anyone ?:</strong> {{ $problemsWithAnyone  }}</p>
        <p><strong>Reason:</strong> {{ $reasonForProblems  }}</p>
        <p><strong>Been to Prison ?:</strong> {{ $beenToPrison  }}</p>
        <p><strong>Reason for Prison:</strong> {{ $reasonForPrison  }}</p>
    </div>

    
    <div class="section">
        <h2>9. Documents to Provide</h2>
        <p>⚠️ Les fichiers uploadés (ex: PDF, images) ne peuvent pas être affichés directement dans ce PDF </p>
        <p><strong>Criminal Record Extract:</strong> {{ $bulletin3File }}</p>
        <p><strong>Medical Certificate:</strong> {{ $medicalCertificateHopeClinicFile }}</p>
        <p><strong>Diplomas:</strong> {{ $diplomasFile  }}</p>
        <p><strong>Birth & Marriage Certificates:</strong> {{ $birthMarriageCertificatesFile }}</p>
        <p><strong>National ID:</strong> {{ $cniFile  }}</p>
        <p><strong>Family Commitment (Call):</strong> {{ $familyCommitmentCallFile  }}</p>
        <p><strong>Family Agreement (Burial):</strong> {{ $familyBurialAgreementFile  }}</p>
    </div>
</body>
</html>