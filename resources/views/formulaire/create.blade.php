<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>HQ Staff Registration - ZTF Foundation</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<style>
body {
    font-family: 'Inter', sans-serif;
    background-color: #f0f4f8;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
    padding: 2rem;
    background-image: url('https://placehold.co/1920x1080/e0e7ff/6366f1?text=ZTF+Foundation+Background');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
}

.container {
    background-color: rgba(255, 255, 255, 0.95);
    padding: 2.5rem;
    border-radius: 1rem;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    max-width: 900px;
    width: 100%;
}

.form-section-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1e40af; /* bleu foncé */
    margin-bottom: 1rem;
}

.input {
    width: 100%;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    padding: 0.5rem 1rem;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 2px rgba(59,130,246,0.2);
}

.form-step { display: none; }
.form-step.active { display: block; }

.progress-step {
    width: 2rem;
    height: 2rem;
    border-radius: 9999px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: white;
    background-color: #cbd5e1; /* gris clair */
}

.progress-step.active-step { background-color: #4f46e5; } /* bleu */
.progress-step.completed-step { background-color: #22c55e; } /* vert */

.progress-line {
    flex-grow: 1;
    height: 0.25rem;
    margin: 0 0.25rem;
    background-color: #e5e7eb;
}

.progress-line.completed-line { background-color: #22c55e; }

.radio-group label { display: inline-flex; align-items: center; margin-right: 1rem; cursor: pointer; }
.radio-group input[type="radio"] { margin-right: 0.5rem; }
</style>
</head>
<body>

<div class="text-center mb-8">
    <h1 class="text-4xl font-extrabold text-gray-900 mb-2">ZACHARIAS TANNEE FOMUN FOUNDATION</h1>
    <h2 class="text-2xl font-bold text-indigo-700">HEADQUARTERS STAFF INFORMATION FORM</h2>
</div>

<div class="container">
    <p class="text-gray-600 text-center mb-8">Please fill in the information to register.</p>

    <!-- Progress bar -->
    <div class="flex items-center justify-between mb-8 text-xs sm:text-sm">
        <div class="flex items-center"><div class="progress-step active-step">1</div><div class="progress-line"></div></div>
        <div class="flex items-center"><div class="progress-step">2</div><div class="progress-line"></div></div>
        <div class="flex items-center"><div class="progress-step">3</div><div class="progress-line"></div></div>
        <div class="flex items-center"><div class="progress-step">4</div><div class="progress-line"></div></div>
        <div class="flex items-center"><div class="progress-step">5</div><div class="progress-line"></div></div>
        <div class="flex items-center"><div class="progress-step">6</div><div class="progress-line"></div></div>
        <div class="flex items-center"><div class="progress-step">7</div><div class="progress-line"></div></div>
        <div class="flex items-center"><div class="progress-step">8</div><div class="progress-line"></div></div>
        <div class="flex items-center"><div class="progress-step">9</div></div>
    </div>

    <!-- Formulaire multi-étapes -->
    <form id="registrationForm" class="space-y-8" method="POST" action="{{ route('download.pdf') }}" target="_blank" enctype="multipart/form-data">
        @csrf

        <!-- Step 1: Personal Information -->
        <div class="form-step active">
            <h2 class="form-section-title">1. Personal Information (Identity)</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="fullName" placeholder="Full Name" class="input" required>
                <input type="text" name="fathersName" placeholder="Son/Daughter of" class="input">
                <input type="text" name="mothersName" placeholder="And of" class="input">
                <input type="date" name="dateOfBirth" placeholder="Date of Birth" class="input" required>
                <input type="text" name="placeOfBirth" placeholder="Place of Birth" class="input">
                <input type="text" name="idPassportNumber" placeholder="ID Card / Passport No." class="input">
            </div>
        </div>

        <!-- Step 2: Contact & Location -->
        <div class="form-step">
            <h2 class="form-section-title">2. Contact Details & Location</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <textarea name="fullAddress" placeholder="Full Address" class="input"></textarea>
                <input type="tel" name="phoneNumber" placeholder="Phone No." class="input" required>
                <input type="tel" name="whatsappNumber" placeholder="Whatsapp" class="input">
                <input type="text" name="region" placeholder="Region" class="input">
                <input type="text" name="placeOfResidence" placeholder="Place of Residence" class="input">
                <input type="text" name="departmentOfOrigin" placeholder="Department of origin" class="input">
                <input type="text" name="village" placeholder="Village" class="input">
                <input type="text" name="ethnicity" placeholder="Ethnicity" class="input">
                <input type="number" name="numberOfSiblings" placeholder="Number of Siblings" class="input" min="0">
                <input type="text" name="nextOfKinName" placeholder="Next of Kin Name" class="input">
                <input type="text" name="nextOfKinCity" placeholder="Next of Kin City" class="input">
                <input type="tel" name="nextOfKinContact" placeholder="Next of Kin Contact" class="input">
                <input type="text" name="familyHeadName" placeholder="Head of Family Name" class="input">
                <input type="text" name="familyHeadCity" placeholder="Head of Family City" class="input">
                <input type="tel" name="familyHeadContact" placeholder="Head of Family Contact" class="input">
            </div>
        </div>

        <!-- Step 3: Spiritual Life -->
        <div class="form-step">
            <h2 class="form-section-title">3. Spiritual Life</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="date" name="conversionDate" placeholder="Date of Conversion" class="input">
                <div class="radio-group flex items-center col-span-2">
                    <p class="mr-4">Baptism by immersion:</p>
                    <label><input type="radio" name="baptismByImmersion" value="Yes"> Yes</label>
                    <label><input type="radio" name="baptismByImmersion" value="No"> No</label>
                </div>
                <div class="radio-group flex items-center col-span-2">
                    <p class="mr-4">Baptism in the Holy Spirit:</p>
                    <label><input type="radio" name="baptismInHolySpirit" value="Yes"> Yes</label>
                    <label><input type="radio" name="baptismInHolySpirit" value="No"> No</label>
                </div>
                <input type="text" name="homeChurch" placeholder="Your Home Church" class="input">
                <input type="text" name="center" placeholder="Your Center" class="input">
                <input type="text" name="discipleMakerName" placeholder="Disciple Maker" class="input">
                <input type="tel" name="discipleMakerContact" placeholder="Disciple Maker Contact" class="input">
                <input type="text" name="spiritualParentageName" placeholder="Spiritual Parentage" class="input">
                <input type="tel" name="spiritualParentageContact" placeholder="Spiritual Parentage Contact" class="input">
                <textarea name="spiritualParentageRelationship" placeholder="Relationship with spiritual parent" class="input col-span-2"></textarea>
                <textarea name="testimony" placeholder="Your Testimony" class="input col-span-2"></textarea>
            </div>
        </div>

        <!-- Step 4: Family Life -->
        <div class="form-step">
            <h2 class="form-section-title">4. Family Life</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <select name="maritalStatus" class="input" required>
                    <option value="">Marital Status</option>
                    <option value="Married">Married</option>
                    <option value="Single">Single</option>
                    <option value="Engaged">Engaged</option>
                </select>
                <input type="text" name="spouseName" placeholder="If married, spouse's name" class="input">
                <input type="tel" name="spouseContact" placeholder="Spouse's Contact" class="input">
                <input type="number" name="numberOfLegitimateChildren" placeholder="Number of Legitimate Children" class="input">
                <textarea name="legitimateChildrenDetails" placeholder="Details of legitimate children" class="input col-span-2"></textarea>
                <input type="number" name="numberOfDependents" placeholder="Number of Dependents" class="input">
                <textarea name="dependentsDetails" placeholder="Details of dependents" class="input col-span-2"></textarea>
                <textarea name="siblingsDetails" placeholder="Details of siblings" class="input col-span-2"></textarea>
            </div>
        </div>

        <!-- Step 5: Professional Life -->
        <div class="form-step">
            <h2 class="form-section-title">5. Professional Life</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="educationFinancer" placeholder="Who financed your studies?" class="input">
                <input type="text" name="educationLevel" placeholder="Education level?" class="input">
                <input type="text" name="degreeObtained" placeholder="Degree obtained" class="input">
                <textarea name="activityBeforeHQ" placeholder="Activity before HQ" class="input col-span-2"></textarea>
                <input type="date" name="hqEntryDate" placeholder="Date of entry into HQ" class="input">
                <input type="text" name="hqDepartment" placeholder="Department at HQ" class="input">
                <input type="text" name="originCountryCity" placeholder="Origin (country, city)" class="input col-span-2">
                <textarea name="departmentResponsibility" placeholder="Department responsibility" class="input col-span-2"></textarea>
            </div>
        </div>

        <!-- Step 6: Commissioning -->
        <div class="form-step">
            <h2 class="form-section-title">6. Commissioning</h2>
            <div class="grid grid-cols-1 gap-4">
                <textarea name="whoIntroducedToHQ" placeholder="Who introduced you to HQ?" class="input"></textarea>
                <div class="radio-group flex items-center">
                    <p class="mr-4">Have you received the call of God?</p>
                    <label><input type="radio" name="callOfGod" value="Yes"> Yes</label>
                    <label><input type="radio" name="callOfGod" value="No"> No</label>
                </div>
                <textarea name="whatCallConsistsOf" placeholder="If yes, what does it consist of?" class="input"></textarea>
                <div class="radio-group flex items-center">
                    <p class="mr-4">Is your family aware?</p>
                    <label><input type="radio" name="familyAwareOfCall" value="Yes"> Yes</label>
                    <label><input type="radio" name="familyAwareOfCall" value="No"> No</label>
                </div>
                <input type="text" name="emergencyContactDeath" placeholder="Emergency Contact" class="input">
                <input type="text" name="burialLocation" placeholder="Burial Location" class="input">
            </div>
        </div>

        <!-- Step 7: Possessions & Health History -->
        <div class="form-step">
            <h2 class="form-section-title">7. Possessions & Health History</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <textarea name="yourPossessions" placeholder="Your Possessions" class="input"></textarea>
                <textarea name="sourcesOfIncome" placeholder="Sources of Income" class="input"></textarea>
                <textarea name="healthProblems" placeholder="Health Problems" class="input"></textarea>
                <div class="radio-group flex items-center">
                    <p class="mr-4">Undergoing Treatment?</p>
                    <label><input type="radio" name="underTreatment" value="Yes"> Yes</label>
                    <label><input type="radio" name="underTreatment" value="No"> No</label>
                </div>
                <textarea name="operationsDetails" placeholder="Surgery details" class="input"></textarea>
            </div>
        </div>

        <!-- Step 8: Judicial History -->
        <div class="form-step">
            <h2 class="form-section-title">8. Judicial History</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="radio-group flex items-center">
                    <p class="mr-4">Problems with anyone?</p>
                    <label><input type="radio" name="problemsWithAnyone" value="Yes"> Yes</label>
                    <label><input type="radio" name="problemsWithAnyone" value="No"> No</label>
                </div>
                <textarea name="reasonForProblems" placeholder="Reason for Problems" class="input"></textarea>
                <div class="radio-group flex items-center">
                    <p class="mr-4">Been to prison?</p>
                    <label><input type="radio" name="beenToPrison" value="Yes"> Yes</label>
                    <label><input type="radio" name="beenToPrison" value="No"> No</label>
                </div>
                <textarea name="reasonForPrison" placeholder="Reason for Prison" class="input"></textarea>
            </div>
        </div>

        <!-- Step 9: Documents -->
        <div class="form-step">
            <h2 class="form-section-title">9. Documents to Provide (Photocopy)</h2>
            <div class="grid grid-cols-1 gap-4">
                <label>Criminal Record <input type="file" name="bulletin3File" class="input"></label>
                <label>Medical Certificate <input type="file" name="medicalCertificateHopeClinicFile" class="input"></label>
                <label>Diplomas <input type="file" name="diplomasFile" multiple class="input"></label>
                <label>Birth/Marriage Certificates <input type="file" name="birthMarriageCertificatesFile" multiple class="input"></label>
                <label>National ID <input type="file" name="cniFile" class="input"></label>
                <label>Family Commitment <input type="file" name="familyCommitmentCallFile" class="input"></label>
                <label>Family Agreement <input type="file" name="familyBurialAgreementFile" class="input"></label>
            </div>
            <div class="mt-6">
                <label><input type="checkbox" name="gdprConsent" class="mr-2"> I accept GDPR terms.</label>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between mt-8">
            <button type="button" id="prevBtn" class="bg-gray-300 text-gray-800 px-6 py-2 rounded hover:bg-gray-400 transition">Previous</button>
            <button type="button" id="nextBtn" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">Next</button>
            <button type="submit" id="submitBtn" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition" style="display:none;">Download PDF</button>
        </div>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const formSteps = document.querySelectorAll(".form-step");
    const nextBtn = document.getElementById("nextBtn");
    const prevBtn = document.getElementById("prevBtn");
    const submitBtn = document.getElementById("submitBtn");
    let currentStep = 0;

    function showStep(step) {
        formSteps.forEach((s, index) => { s.classList.toggle("active", index===step); });
        prevBtn.style.display = step===0 ? "none" : "inline-block";
        nextBtn.style.display = step===formSteps.length-1 ? "none" : "inline-block";
        submitBtn.style.display = step===formSteps.length-1 ? "inline-block" : "none";

        // Progress bar
        document.querySelectorAll(".progress-step").forEach((indicator, index) => {
            indicator.classList.toggle("active-step", index===step);
            indicator.classList.toggle("completed-step", index<step);
        });
        document.querySelectorAll(".progress-line").forEach((line, index) => {
            line.classList.toggle("completed-line", index<step);
        });
    }

    nextBtn.addEventListener("click", () => {
        if (currentStep < formSteps.length-1) currentStep++;
        showStep(currentStep);
    });
    prevBtn.addEventListener("click", () => {
        if (currentStep > 0) currentStep--;
        showStep(currentStep);
    });

    showStep(currentStep);
});
</script>

</body>
</html>
