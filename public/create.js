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