document.addEventListener("DOMContentLoaded", function() {
    const formSteps = document.querySelectorAll(".form-step");
    const nextBtn = document.getElementById("nextBtn");
    const prevBtn = document.getElementById("prevBtn");
    const submitBtn = document.getElementById("submitBtn");
    let currentStep = 0;

    function validateStep(step) {
        const currentStepElement = formSteps[step];
        const requiredInputs = currentStepElement.querySelectorAll('input[required], textarea[required], select[required]');
        const radioGroups = new Set();
        
        // Vérifier tous les champs requis
        for (const input of requiredInputs) {
            // Pour les boutons radio
            if (input.type === 'radio') {
                radioGroups.add(input.name);
                continue;
            }
            
            // Pour les fichiers
            if (input.type === 'file') {
                if (!input.files || input.files.length === 0) {
                    showError(input, "Ce fichier est requis");
                    return false;
                }
                continue;
            }
            
            // Pour les autres types de champs
            if (!input.value.trim()) {
                showError(input, "Ce champ est requis");
                return false;
            }
        }

        // Vérifier les groupes de boutons radio
        for (const groupName of radioGroups) {
            const radioButtons = currentStepElement.querySelectorAll(`input[type="radio"][name="${groupName}"]`);
            const isChecked = Array.from(radioButtons).some(radio => radio.checked);
            if (!isChecked) {
                showError(radioButtons[0], "Une option doit être sélectionnée");
                return false;
            }
        }

        return true;
    }

    function showError(element, message) {
        // Supprimer les messages d'erreur existants
        const existingError = element.parentElement.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }

        // Créer et afficher le nouveau message d'erreur
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.style.color = 'red';
        errorDiv.style.fontSize = '0.8rem';
        errorDiv.style.marginTop = '4px';
        errorDiv.textContent = message;
        
        if (element.parentElement.tagName.toLowerCase() === 'label') {
            element.parentElement.appendChild(errorDiv);
        } else {
            element.parentElement.insertBefore(errorDiv, element.nextSibling);
        }
        
        // Faire défiler jusqu'au premier champ avec erreur
        element.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function clearErrors() {
        const errorMessages = document.querySelectorAll('.error-message');
        errorMessages.forEach(error => error.remove());
    }

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
        clearErrors(); // Nettoyer les erreurs précédentes
        if (validateStep(currentStep)) {
            if (currentStep < formSteps.length-1) {
                currentStep++;
                showStep(currentStep);
            }
        }
    });

    prevBtn.addEventListener("click", () => {
        clearErrors(); // Nettoyer les erreurs précédentes
        if (currentStep > 0) {
            currentStep--;
            showStep(currentStep);
        }
    });

    // Valider le formulaire avant la soumission
    submitBtn.addEventListener("click", (e) => {
        e.preventDefault();
        clearErrors();
        if (validateStep(currentStep)) {
            document.getElementById("registrationForm").submit();
        }
    });

    showStep(currentStep);
});