<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ZTF Foundation - PDF</title>
<style>
    @page {
        size: A4;
        margin: 2cm;
    }
    
    body {
        font-family: DejaVu Sans, Arial, Helvetica, sans-serif;
        margin: 0;
        color: #1f2937;
        font-size: 11pt;
        line-height: 1.4;
        background-color: white;
        width: 100%;
    }

    header {
        text-align: center;
        margin-bottom: 20px;
        padding-top: 20px;
        border-bottom: 2px solid #3b82f6;
        padding-bottom: 15px;
    }

    header h1 {
        font-size: 18pt;
        font-weight: bold;
        color: #1e3a8a;
        text-transform: uppercase;
        margin: 0 0 5px 0;
    }

    header h2 {
        font-size: 14pt;
        color: #475569;
        margin: 0;
    }

    .section {
        background: white;
        border: none;
        border-radius: 0;
        padding: 10px 0;
        margin-bottom: 15px;
        page-break-inside: avoid;
    }

    .section h2 {
        font-size: 12pt;
        font-weight: 600;
        color: #111827;
        border-bottom: 1px solid #3b82f6;
        padding-bottom: 3px;
        margin-bottom: 10px;
    }

    .info-grid {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    p {
        margin: 2px 0;
        page-break-inside: avoid;
        line-height: 1.2;
    }

    strong {
        font-weight: 600;
        color: #374151;
        margin-right: 5px;
    }

    p span {
        color: #000;
    }

    .full-width {
        width: 100%;
    }

    /* Gestion des sauts de page */
    .page-break {
        page-break-before: always;
    }

    /* Optimisations pour l'impression */
    @media print {
        body {
            print-color-adjust: exact;
            -webkit-print-color-adjust: exact;
        }
        
        .section {
            break-inside: avoid;
        }
        
        p {
            orphans: 3;
            widows: 3;
        }
    }
</style>
</head>
<body>

<header>
    <h1>Zacharias Tannee Fomun Foundation</h1>
    <h2>Headquarters Staff Registration</h2>
</header>

<!-- Section 1 : Personal Information -->
<div class="section">
    <h2>1. Personal Information (Identity)</h2>
    <div class="info-grid">
        <p><strong>Full Name:</strong> {{ $fullName ?? ''}}</p>
        <p><strong>Father's Name:</strong> {{ $fathersName ?? '' }}</p>
        <p><strong>Mother's Name:</strong> {{ $mothersName ?? ''}}</p>
        <p><strong>Date Of Birth:</strong> {{ $dateOfBirth ?? ''}}</p>
        <p><strong>Place Of Birth:</strong> {{ $placeOfBirth ?? ''}}</p>
        <p><strong>Passport / ID Number:</strong> {{ $idPassportNumber ?? '' }}</p>
    </div>
</div>

<!-- Section 2 : Contact & Location -->
<div class="section">
    <h2>2. Contact Details & Location</h2>
    <div class="info-grid">
        <p class="full-width"><strong>Full Address:</strong> {{ $fullAddress ?? '' }}</p>
        <p><strong>Phone Number:</strong> {{ $phoneNumber ?? ''}}</p>
        <p><strong>Whatsapp Number:</strong> {{ $whatsappNumber ?? '' }}</p>
        <p><strong>Region:</strong> {{ $region  ?? ''}}</p>
        <p><strong>Place of Residence:</strong> {{ $placeOfResidence ?? '' }}</p>
        <p><strong>Department of Origin:</strong> {{ $departmentOfOrigin ?? '' }}</p>
        <p><strong>Village Name:</strong> {{ $village ?? ''}}</p>
        <p><strong>Ethnicity:</strong> {{ $ethnicity ?? '' }}</p>
        <p><strong>Number Of Siblings:</strong> {{ $numberOfSiblings ?? '' }}</p>
        <p><strong>Next Of Kin Name:</strong> {{ $nextOfKinName ?? ''}}</p>
        <p><strong>Next Of Kin City:</strong> {{ $nextOfKinCity  ?? ''}}</p>
        <p><strong>Next Of Kin Contact:</strong> {{ $nextOfKinContact ?? '' }}</p>
        <p><strong>Family Head Name:</strong> {{ $familyHeadName ?? ''}}</p>
        <p><strong>Family Head City:</strong> {{ $familyHeadCity ?? ''}}</p>
        <p><strong>Family Head Contact:</strong> {{ $familyHeadContact ?? ''}}</p>
    </div>
</div>

<!-- Section 3 : Spiritual Life -->
<div class="section page-break">
    <h2>3. Spiritual Life</h2>
    <div class="info-grid">
        <p><strong>Conversion Date:</strong> {{ $conversionDate ?? ''}}</p>
        <p><strong>Baptism By Immersion:</strong> {{$baptismByImmersion ?? ''}}</p>
        <p><strong>Baptism In Holy Spirit:</strong> {{$baptismInHolySpirit ?? ''}}</p>
        <p class="full-width"><strong>Home Church:</strong> {{ $homeChurch ?? '' }}</p>
        <p><strong>Center:</strong> {{ $center  ?? ''}}</p>
        <p><strong>Disciple Maker Name:</strong> {{ $discipleMakerName ?? ''}}</p>
        <p><strong>Disciple Maker Contact:</strong> {{ $discipleMakerContact ?? ''}}</p>
        <p><strong>Spiritual Parentage Name:</strong> {{ $spiritualParentageName ?? '' }}</p>
        <p><strong>Spiritual Parentage Contact:</strong> {{ $spiritualParentageContact ?? '' }}</p>
        <p class="full-width"><strong>Relationship with Spiritual Parent:</strong> {{ $spiritualParentageRelationship ?? '' }}</p>
        <p class="full-width"><strong>Testimony:</strong> {{ $testimony ?? ''}}</p>
    </div>
</div>

<!-- Section 5 : Family Life -->
<div class="section">
    <h2>4. Family Life</h2>
    <div class="info-grid">
        <p><strong>Marital Status:</strong> {{ $maritalStatus ?? ''}}</p>
        <p><strong>Spouse Name:</strong> {{ $spouseName ?? ''}}</p>
        <p><strong>Spouse Contact:</strong> {{ $spouseContact ??'' }}</p>
        <p><strong>Number Of Legitimate Children:</strong> {{ $numberOfLegitimateChildren ?? '' }}</p>
        <p class="full-width"><strong>Legitimate Children Details:</strong> {{ $legitimateChildrenDetails ?? '' }}</p>
        <p><strong>Number Of Dependents:</strong> {{ $numberOfDependents ?? '' }}</p>
        <p class="full-width"><strong>Dependents Details:</strong> {{ $dependentsDetails ?? '' }}</p>
        <p class="full-width"><strong>Siblings Details:</strong> {{ $siblingsDetails ?? '' }}</p>
    </div>
</div>

<!-- Section 6 : Professional Life -->
<div class="section page-break">
    <h2>5. Professional Life</h2>
    <div class="info-grid">
        <p><strong>Education Financer:</strong> {{ $educationFinancer ?? '' }}</p>
        <p><strong>Education Level:</strong> {{ $educationLevel ?? ''}}</p>
        <p><strong>Degree Obtained:</strong> {{ $degreeObtained ?? ''}}</p>
        <p class="full-width"><strong>Activity Before HQ:</strong> {{ $activityBeforeHQ ?? ''}}</p>
        <p><strong>HQ Entry Date:</strong> {{ $hqEntryDate ?? '' }}</p>
        <p><strong>HQ Department:</strong> {{ $hqDepartment ?? ''}}</p>
        <p class="full-width"><strong>Origin Country City:</strong> {{$originCountryCity ?? ''}}</p>
        <p class="full-width"><strong>Department Responsibility:</strong> {{ $departmentResponsibility ?? ''}}</p> 
    </div>
</div>

<!-- Section 6 : Commissioning -->
<div class="section">
    <h2>6. Commissioning</h2>
    <div class="info-grid">
        <p class="full-width"><strong>Introduced to HQ by:</strong> {{ $whoIntroducedToHQ ?? ''}}</p>
        <p><strong>Have you received the Call Of God:</strong> {{$callOfGod ?? ''}}</p>
        <p class="full-width"><strong>Call Details:</strong> {{ $whatCallConsistsOf ?? ''}}</p>
        <p><strong>Is Your family Aware?:</strong> {{$familyAwareOfCall ?? 'non renseigne'}}</p>
        <p class="full-width"><strong>Emergency Contact:</strong> {{$emergencyContactDeath ?? ''}}</p>
        <p class="full-width"><strong>Burial Location:</strong> {{$burialLocation ?? ''}}</p>
    </div>
</div>

<!-- Section 7 : Possessions & Health -->
<div class="section page-break">
    <h2>7. Possessions & Health History</h2>
    <div class="info-grid">
        <p class="full-width"><strong>Possessions:</strong> {{ $yourPossessions ?? ''}}</p>
        <p class="full-width"><strong>Sources Of Income:</strong> {{ $sourcesOfIncome ?? ''}}</p>
        <p class="full-width"><strong>Health Problems:</strong> {{ $healthProblems ?? ''}}</p>
        <p><strong>Undergoing Treatment?:</strong> {{$underTreatment ?? 'non renseigne'}}</p>
        <p><strong>Surgery Details:</strong> {{$operationsDetails ?? ''}}</p>
    </div>
</div>

<!-- Section 8 : Judicial History -->
<div class="section">
    <h2>8. Judicial History</h2>
    <div class="info-grid">
        <p><strong>Problems with anyone?:</strong> {{$problemsWithAnyone ?? 'non renseigne'}}</p>
        <p class="full-width"><strong>Reason For Problems:</strong> {{ $reasonForProblems ?? ''}}</p>
        <p><strong>Been To Prison?:</strong> {{$beenToPrison ?? 'non renseigne'}}</p>
        <p class="full-width"><strong>Reason For Prison:</strong> {{ $reasonForPrison  ?? ''}}</p>
    </div>
</div>

</body>
</html>
