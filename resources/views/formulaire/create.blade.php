<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HQ Staff Registration - ZTF Foundation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* General styles for the page body */
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
        /* Styles for the main form container */
        .container {
            background-color: rgba(255, 255, 255, 0.95); /* White with 95% opacity */
            padding: 2.5rem;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 100%;
        }
        /* Style for form section titles */
        .form-section-title {
            @apply text-xl font-semibold text-blue-700 mb-4;
        }
        /* Style for form input fields (input, select, textarea) */
        .input {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .input:focus {
            border-color: #93c5fd;
            box-shadow: 0 0 0 2px rgba(59,130,246,0.2);
        }
        /* Hides form steps by default */
        .form-step {
            display: none;
        }
        /* Displays the active step */
        .form-step.active {
            display: block;
        }
        /* Style for progress indicator */
        .progress-step {
            @apply w-8 h-8 rounded-full flex items-center justify-center text-white font-bold text-sm;
            background-color: #cbd5e1;
        }
        .progress-step.active-step {
            background-color: #4f46e5;
        }
        .progress-step.completed-step {
            background-color: #22c55e;
        }
        .progress-line {
            @apply flex-grow h-1 bg-gray-300 mx-2;
        }
        .progress-line.completed-line {
            background-color: #22c55e;
        }
        /* Styles for radio button groups */
        .radio-group label {
            display: inline-flex;
            align-items: center;
            margin-right: 1rem;
            cursor: pointer;
        }
        .radio-group input[type="radio"] {
            margin-right: 0.5rem;
        }
        .radio-group p {
            margin-right: 0.5rem; /* Space between text and radios */
        }
    </style>
</head>
<body>
    <div class="text-center mb-8">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-2">ZACHARIAS TANNEE FOMUN FOUNDATION</h1>
        <h2 class="text-2xl font-bold text-indigo-700">HEADQUARTERS STAFF INFORMATION FORM</h2>
    </div>

    <div class="container">
        <p class="text-gray-600 text-center mb-8">Please fill in the information to register.</p>

        <div class="flex items-center justify-between mb-8 text-xs sm:text-sm">
            <div class="flex items-center">
                <div id="step-indicator-1" class="progress-step active-step">1</div>
                <div id="line-1" class="progress-line"></div>
            </div>
            <div class="flex items-center">
                <div id="step-indicator-2" class="progress-step">2</div>
                <div id="line-2" class="progress-line"></div>
            </div>
            <div class="flex items-center">
                <div id="step-indicator-3" class="progress-step">3</div>
                <div id="line-3" class="progress-line"></div>
            </div>
            <div class="flex items-center">
                <div id="step-indicator-4" class="progress-step">4</div>
                <div id="line-4" class="progress-line"></div>
            </div>
            <div class="flex items-center">
                <div id="step-indicator-5" class="progress-step">5</div>
                <div id="line-5" class="progress-line"></div>
            </div>
            <div class="flex items-center">
                <div id="step-indicator-6" class="progress-step">6</div>
                <div id="line-6" class="progress-line"></div>
            </div>
            <div class="flex items-center">
                <div id="step-indicator-7" class="progress-step">7</div>
                <div id="line-7" class="progress-line"></div>
            </div>
            <div class="flex items-center">
                <div id="step-indicator-8" class="progress-step">8</div>
                <div id="line-8" class="progress-line"></div>
            </div>
            <div class="flex items-center">
                <div id="step-indicator-9" class="progress-step">9</div>
            </div>
        </div>

        <form id="registrationForm" class="space-y-8" action="{{route('telechargerPdf')}}" method="POST">

            @csrf
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

            <div class="form-step">
                <h2 class="form-section-title">2. Contact Details & Location</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <textarea name="fullAddress" placeholder="Full Address" class="input"></textarea>
                    <input type="tel" name="phoneNumber" placeholder="Phone No." class="input" required>
                    <input type="tel" name="whatsappNumber" placeholder="Whatsapp" class="input">
                    <input type="text" name="region" placeholder="Region" class="input">
                    <input type="text" name="placeOfResidence" placeholder="Place of Residence" class="input">
                    <input type="text" name="departmentOfOrigin" placeholder="Department (of origin)" class="input">
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
                    <textarea name="spiritualParentageRelationship" placeholder="What is your relationship with this parent?" class="input col-span-2"></textarea>
                    <textarea name="testimony" placeholder="Your Testimony" class="input col-span-2"></textarea>
                </div>
            </div>

            <div class="form-step">
                <h2 class="form-section-title">4. Family Life</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <select name="maritalStatus" class="input" title="Marital Status" required>
                        <option value="">Marital Status</option>
                        <option value="Married">Married</option>
                        <option value="Single">Single</option>
                        <option value="Engaged">Engaged</option>
                    </select>
                    <input type="text" name="spouseName" placeholder="If married, to whom?" class="input">
                    <input type="tel" name="spouseContact" placeholder="Spouse's Contact" class="input">
                    <input type="number" name="numberOfLegitimateChildren" placeholder="Number of Legitimate Children" class="input" min="0">
                    <textarea name="legitimateChildrenDetails" placeholder="Names, Birth Years, Activities of Legitimate Children (one per line)" class="input col-span-2"></textarea>
                    <input type="number" name="numberOfDependents" placeholder="Number of Children or Dependents" class="input" min="0">
                    <textarea name="dependentsDetails" placeholder="Names, Birth Years, Activity, Relationship of Dependents (one per line)" class="input col-span-2"></textarea>
                    <textarea name="siblingsDetails" placeholder="Names, Birth Years, Activity, Contact of Siblings (one per line)" class="input col-span-2"></textarea>
                </div>
            </div>

            <div class="form-step">
                <h2 class="form-section-title">5. Professional Life</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="educationFinancer" placeholder="Who financed your studies?" class="input">
                    <input type="text" name="educationLevel" placeholder="What is your education level?" class="input">
                    <input type="text" name="degreeObtained" placeholder="Degree obtained" class="input">
                    <textarea name="activityBeforeHQ" placeholder="What did you do before joining the Headquarters?" class="input col-span-2"></textarea>
                    <input type="date" name="hqEntryDate" placeholder="Date of entry into HQ" class="input" required>
                    <select id="departementQG" name="hqDepartment" required class="input" title="Department at HQ">
                        <option value="">Which Department at HQ?</option>
                        </select>
                    <input type="text" name="originCountryCity" placeholder="Where are you from (country of origin, city, etc.)?" class="input col-span-2">
                    <textarea name="departmentResponsibility" placeholder="Your responsibility in the department" class="input col-span-2"></textarea>
                    <input type="text" name="timeInDepartment" placeholder="How long have you been working in the Department?" class="input">
                    <div class="radio-group flex items-center">
                        <p class="mr-4">Do you receive a monthly allowance?</p>
                        <label><input type="radio" name="monthlyAllowance" value="Yes"> Yes</label>
                        <label><input type="radio" name="monthlyAllowance" value="No"> No</label>
                    </div>
                    <input type="date" name="allowanceSince" placeholder="Since when (allowance)?" class="input">
                    <textarea name="otherResponsibilities" placeholder="What other responsibilities do you assume in your Department? And at HQ?" class="input col-span-2"></textarea>
                    <textarea name="departmentChanges" placeholder="What changes would you like to see in your Department to improve it?" class="input col-span-2"></textarea>
                    <div class="radio-group flex items-center">
                        <p class="mr-4">Do you have disciples?</p>
                        <label><input type="radio" name="haveDisciples" value="Yes"> Yes</label>
                        <label><input type="radio" name="haveDisciples" value="No"> No</label>
                    </div>
                    <input type="number" name="numberOfDisciples" placeholder="How many disciples?" class="input" min="0">
                    <input type="text" name="degreesHeld" placeholder="What degrees do you hold?" class="input">
                    <input type="text" name="professionalTrainingReceived" placeholder="What professional training have you received?" class="input">
                    <input type="text" name="professionalTrainingLocation" placeholder="Where (professional training)?" class="input">
                    <input type="text" name="professionalTrainingDuration" placeholder="For how long (professional training)?" class="input">
                    <div class="radio-group flex items-center">
                        <p class="mr-4">Did you only receive on-the-job training here at the headquarters?</p>
                        <label><input type="radio" name="onTheJobTraining" value="Yes"> Yes</label>
                        <label><input type="radio" name="onTheJobTraining" value="No"> No</label>
                    </div>
                    <textarea name="whyWorkAtHQ" placeholder="Why do you work here at the headquarters?" class="input col-span-2"></textarea>
                    <textarea name="briefTestimony" placeholder="Write your testimony briefly" class="input col-span-2"></textarea>
                </div>
            </div>

            <div class="form-step">
                <h2 class="form-section-title">6. Commissioning</h2>
                <div class="grid grid-cols-1 gap-4">
                    <textarea name="whoIntroducedToHQ" placeholder="Who introduced you to HQ?" class="input"></textarea>
                    <div class="radio-group flex items-center">
                        <p class="mr-4">Have you received the call of God in your life?</p>
                        <label><input type="radio" name="callOfGod" value="Yes"> Yes</label>
                        <label><input type="radio" name="callOfGod" value="No"> No</label>
                    </div>
                    <textarea name="whatCallConsistsOf" placeholder="If yes, what does it consist of?" class="input"></textarea>
                    <div class="radio-group flex items-center">
                        <p class="mr-4">Is your family aware of it?</p>
                        <label><input type="radio" name="familyAwareOfCall" value="Yes"> Yes</label>
                        <label><input type="radio" name="familyAwareOfCall" value="No"> No</label>
                    </div>
                    <div class="radio-group flex items-center">
                        <p class="mr-4">Did your family release you?</p>
                        <label><input type="radio" name="familyReleasedForCall" value="Yes"> Yes</label>
                        <label><input type="radio" name="familyReleasedForCall" value="No"> No</label>
                    </div>
                    <input type="text" name="emergencyContactDeath" placeholder="Person to contact in case of death" class="input">
                    <input type="text" name="burialLocation" placeholder="Where will you be buried?" class="input">
                    <div class="radio-group flex items-center">
                        <p class="mr-4">Is your family aware (burial location)?</p>
                        <label><input type="radio" name="familyAwareOfBurialLocation" value="Yes"> Yes</label>
                        <label><input type="radio" name="familyAwareOfBurialLocation" value="No"> No</label>
                    </div>
                </div>
            </div>

            <div class="form-step">
                <h2 class="form-section-title">7. Possessions & Health History</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <textarea name="yourPossessions" placeholder="Your Possessions" class="input"></textarea>
                    <textarea name="sourcesOfIncome" placeholder="Your Sources of Income" class="input"></textarea>
                    <textarea name="healthProblems" placeholder="Your Health Problems" class="input"></textarea>
                    <div class="radio-group flex items-center">
                        <p class="mr-4">Are you undergoing treatment?</p>
                        <label><input type="radio" name="underTreatment" value="Yes"> Yes</label>
                        <label><input type="radio" name="underTreatment" value="No"> No</label>
                    </div>
                    <textarea name="operationsDetails" placeholder="Have you had surgery? If yes, what for and how many times?" class="input"></textarea>
                    <div class="radio-group flex items-center">
                        <p class="mr-4">Are you on a special diet?</p>
                        <label><input type="radio" name="specialDiet" value="Yes"> Yes</label>
                        <label><input type="radio" name="specialDiet" value="No"> No</label>
                    </div>
                    <textarea name="commonFamilyIllnesses" placeholder="Common illnesses in your family" class="input"></textarea>
                </div>
            </div>

            <div class="form-step">
                <h2 class="form-section-title">8. Judicial History</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="radio-group flex items-center">
                        <p class="mr-4">Do you have problems with anyone?</p>
                        <label><input type="radio" name="problemsWithAnyone" value="Yes"> Yes</label>
                        <label><input type="radio" name="problemsWithAnyone" value="No"> No</label>
                    </div>
                    <textarea name="reasonForProblems" placeholder="For what reason?" class="input"></textarea>
                    <div class="radio-group flex items-center">
                        <p class="mr-4">Have you been to prison?</p>
                        <label><input type="radio" name="beenToPrison" value="Yes"> Yes</label>
                        <label><input type="radio" name="beenToPrison" value="No"> No</label>
                    </div>
                    <textarea name="reasonForPrison" placeholder="For what reason?" class="input"></textarea>
                </div>
            </div>

            <div class="form-step">
                <h2 class="form-section-title">9. Documents to Provide (Photocopy)</h2>
                <p class="text-sm text-gray-500 mb-4">Please upload the required documents. (Upload simulation)</p>
                <div class="grid grid-cols-1 gap-4">
                    <label class="block text-sm font-medium text-gray-700">Criminal Record Extract (Bulletin n°3) <input type="file" name="bulletin3File" accept=".pdf,.jpg,.png" class="input"></label>
                    <label class="block text-sm font-medium text-gray-700">Medical Certificate from Hope Clinic <input type="file" name="medicalCertificateHopeClinicFile" accept=".pdf,.jpg,.png" class="input"></label>
                    <label class="block text-sm font-medium text-gray-700">Diplomas <input type="file" name="diplomasFile" accept=".pdf,.jpg,.png" multiple class="input"></label>
                    <label class="block text-sm font-medium text-gray-700">Birth and Marriage Certificates <input type="file" name="birthMarriageCertificatesFile" accept=".pdf,.jpg,.png" multiple class="input"></label>
                    <label class="block text-sm font-medium text-gray-700">National ID Card <input type="file" name="cniFile" accept=".pdf,.jpg,.png" class="input"></label>
                    <label class="block text-sm font-medium text-gray-700">Family Member Commitment (if call agreed) <input type="file" name="familyCommitmentCallFile" accept=".pdf,.jpg,.png" class="input"></label>
                    <label class="block text-sm font-medium text-gray-700">Family Agreement (burial location) <input type="file" name="familyBurialAgreementFile" accept=".pdf,.jpg,.png" class="input"></label>
                </div>
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700">
                        <input type="checkbox" name="gdprConsent" required class="mr-2"> I accept the terms of processing my personal data in accordance with GDPR.
                    </label>
                </div>
            </div>

            <div class="flex justify-between mt-8">
                <button type="button" id="prevBtn" class="bg-gray-300 text-gray-800 px-6 py-2 rounded hover:bg-gray-400 transition" style="display: none;">Previous</button>
                <button type="button" id="nextBtn" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">Next</button>
                <button type="submit" id="submitBtn" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition" style="display: none;">Telecharger la version Pdf</button>
            </div>
        </form>

        <div id="responseMessage" class="mt-4 p-3 rounded-md hidden text-center"></div>
        <a href="staff.php" class="block text-center mt-6 text-blue-500 hover:underline">Back to Home</a>
    </div>
    <script>
    

    // Simulated Department Data (MOCK DATA)
        const mockDepartments = [
            { id: '1', name: 'Administration' }, { id: '2', name: 'Finance' },
            { id: '3', name: 'Human Resources' }, { id: '4', name: 'Communication' },
            { id: '5', name: 'Projects & Development' }, { id: '6', name: 'Logistics' },
            { id: '7', name: 'IT' }, { id: '8', name: 'Legal' },
            { id: '9', name: 'Partnerships' }, { id: '10', name: 'Education' },
            { id: '11', name: 'Health' }, { id: '12', name: 'Environment' },
            { id: '13', name: 'Research' }, { id: '14', name: 'Training' },
            { id: '15', name: 'Public Relations' }, { id: '16', name: 'Digital Marketing' },
            { id: '17', name: 'Accounting' }, { id: '18', name: 'Internal Audit' },
            { id: '19', name: 'Procurement' }, { id: '20', name: 'Maintenance' },
            { id: '21', name: 'Security' }, { id: '22', name: 'Quality' },
            { id: '23', name: 'Innovation' }, { id: '24', name: 'Sustainable Development' },
            { id: '25', name: 'Volunteering' }, { id: '26', name: 'Evaluation & Monitoring' },
            { id: '27', name: 'Fundraising' }, { id: '28', name: 'International Affairs' },
            { id: '29', name: 'Technical Support' }, { id: '30', name: 'General Services' }
        ];

        // Variables for form step management
        let currentStep = 0; // The index of the currently displayed step (starts at 0)
        const formSteps = document.querySelectorAll('.form-step'); // All form step sections
        const prevBtn = document.getElementById('prevBtn'); // "Previous" button
        const nextBtn = document.getElementById('nextBtn'); // "Next" button
        const submitBtn = document.getElementById('submitBtn'); // Final "Submit" button
        const registrationForm = document.getElementById('registrationForm'); // The entire form
        const responseMessage = document.getElementById('responseMessage'); // Message display area
        const departmentSelect = document.getElementById('departementQG'); // Department dropdown list (renamed for this form)
        const stepIndicators = document.querySelectorAll('.progress-step'); // Progress indicator circles
        const progressLines = document.querySelectorAll('.progress-line'); // Progress lines

        // Function to display a specific form step
        function showStep(stepIndex) {
            // Hide all steps
            formSteps.forEach((step, index) => {
                step.classList.remove('active');
            });
            // Display the desired step
            formSteps[stepIndex].classList.add('active');

            // Update visibility of navigation buttons
            prevBtn.style.display = (stepIndex === 0) ? 'none' : 'inline-block'; // Hide "Previous" on the first step
            nextBtn.style.display = (stepIndex === formSteps.length - 1) ? 'none' : 'inline-block'; // Hide "Next" on the last step
            submitBtn.style.display = (stepIndex === formSteps.length - 1) ? 'inline-block' : 'none'; // Display "Submit" on the last step

            // Update visual progress indicator
            updateProgressIndicators(stepIndex);
        }

        // Function to validate fields of the current step before proceeding to the next
        function validateCurrentStep() {
            const currentActiveStep = document.querySelector('.form-step.active');
            // Select all required fields EXCEPT 'hidden' type inputs
            const inputs = currentActiveStep.querySelectorAll('input[required]:not([type="hidden"]), select[required], textarea[required]');
            let allValid = true;

            inputs.forEach(input => {
                // For radio groups, ensure at least one is selected if required
                if (input.type === 'radio' && input.name && input.required) {
                    const radioGroup = document.querySelectorAll(`input[name="${input.name}"]`);
                    const isChecked = Array.from(radioGroup).some(radio => radio.checked);
                    if (!isChecked) {
                        allValid = false;
                        // Optional: Add visual styling to indicate error
                        // radioGroup[0].closest('.radio-group').style.border = '1px solid red';
                    } else {
                        // radioGroup[0].closest('.radio-group').style.border = 'none';
                    }
                } else if (!input.checkValidity()) { // checkValidity() is a built-in HTML5 validation method
                    allValid = false;
                    input.classList.add('border-red-500'); // Add Tailwind class for error
                } else {
                    input.classList.remove('border-red-500'); // Remove error class if valid
                }
            });
            return allValid;
        }

        // Function to update the visual progress indicators
        function updateProgressIndicators(stepIndex) {
            stepIndicators.forEach((indicator, index) => {
                indicator.classList.remove('active-step', 'completed-step');
                if (index < stepIndex) {
                    indicator.classList.add('completed-step');
                } else if (index === stepIndex) {
                    indicator.classList.add('active-step');
                }
            });

            progressLines.forEach((line, index) => {
                line.classList.remove('completed-line');
                if (index < stepIndex) {
                    line.classList.add('completed-line');
                }
            });
        }


        // Initialize form on page load
        document.addEventListener('DOMContentLoaded', () => {
            showStep(currentStep); // Display the first step
            populateDepartmentsFromMock(); // Populate the department dropdown
        });

// Function to fetch departments from PHP (if you decide to make it dynamic)
async function fetchDepartments() {
    try {
        const response = await fetch('api/get_departments.php'); // Your PHP endpoint for departments
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const departments = await response.json();
        // Clear existing options, keeping the placeholder
        departmentSelect.innerHTML = '<option value="">Which Department at HQ?</option>';
        departments.forEach(dept => {
            const option = document.createElement('option');
            option.value = dept.id; // Assuming PHP returns id
            option.textContent = dept.name; // Assuming PHP returns name
            departmentSelect.appendChild(option);
        });
    } catch (error) {
        console.error('Error fetching departments:', error);
        // Fallback to mockDepartments if fetching fails
        populateDepartmentsFromMock();
    }
}

// Function to populate departments from mock data (your existing function, possibly renamed)
function populateDepartmentsFromMock() {
    departmentSelect.innerHTML = '<option value="">Which Department at HQ?</option>';
    mockDepartments.forEach(dept => {
        const option = document.createElement('option');
        option.value = dept.id;
        option.textContent = dept.name;
        departmentSelect.appendChild(option);
    });
}


// Modified Event listener for form submission
registrationForm.addEventListener('submit', async (e) => {
    e.preventDefault(); // Prevent default form submission

    if (!validateCurrentStep()) {
        displayMessage('Please fill in all required fields before submitting.', 'error');
        return;
    }

    // Collect form data
    const formData = new FormData(registrationForm);
    const data = {};

    // Process all fields, including file inputs
    for (let [key, value] of formData.entries()) {
        // Handle boolean values for radio buttons more explicitly if needed
        if (value === 'Yes') {
            data[key] = true;
        } else if (value === 'No') {
            data[key] = false;
        } else {
            data[key] = value;
        }
    }

    console.log('Form data to send:', data);

    try {
        // Send data to PHP endpoint
        const response = await fetch('api/submit_registration.php', { // Your PHP endpoint for submission
            method: 'POST',
            body: JSON.stringify(data), // Send as JSON
            headers: {
                'Content-Type': 'application/json'
            }
        });

        const result = await response.json(); // Assuming PHP returns JSON response

        if (result.success) {
            displayMessage(result.message || 'Registration successful! Thank you.', 'success');
            registrationForm.reset(); // Clear the form
            showStep(0); // Go back to the first step
        } else {
            displayMessage(result.message || 'An error occurred during registration. Please try again.', 'error');
        }

    } catch (error) {
        console.error('Submission error:', error);
        displayMessage('A network error occurred. Please check your connection and try again.', 'error');
    }
});

// Initialize form on page load
document.addEventListener('DOMContentLoaded', () => {
    showStep(currentStep); // Display the first step
    // Decide whether to fetch dynamically or use mock data
    // fetchDepartments(); // Uncomment this line if you implement get_departments.php
    populateDepartmentsFromMock(); // Keep this if you're using static mock data
});


    </script>
   </body>
</html>
