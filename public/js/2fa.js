// Variables globales
let currentStage = 1;
let timer;

// Fonction pour mettre à jour l'apparence des étapes
function updateSteps(step) {
    document.querySelectorAll('.step').forEach(s => {
        const stepNumber = parseInt(s.dataset.step);
        if (stepNumber < step) {
            s.classList.add('completed');
            s.classList.remove('active');
        } else if (stepNumber === step) {
            s.classList.add('active');
            s.classList.remove('completed');
        } else {
            s.classList.remove('active', 'completed');
        }
    });
}

// Fonction pour afficher une étape spécifique
function showStage(stage) {
    // Cache toutes les étapes
    document.querySelectorAll('.form-stage').forEach(s => {
        s.style.opacity = '0';
        setTimeout(() => {
            s.classList.remove('active');
        }, 300);
    });

    // Affiche l'étape demandée
    setTimeout(() => {
        const nextStage = document.getElementById(`stage${stage}`);
        nextStage.classList.add('active');
        setTimeout(() => {
            nextStage.style.opacity = '1';
        }, 50);
    }, 300);

    // Met à jour le numéro d'étape actuel
    currentStage = stage;
    
    // Met à jour l'apparence des étapes
    updateSteps(stage);

    // Si on est à l'étape 2, démarre le timer
    if (stage === 2) {
        startTimer(30);
    }
}

// Fonction pour gérer le compte à rebours
function startTimer(duration) {
    let timeLeft = duration;
    const countdownEl = document.getElementById('countdown');
    
    clearInterval(timer);
    timer = setInterval(() => {
        countdownEl.textContent = timeLeft;
        if (--timeLeft < 0) {
            clearInterval(timer);
            showStage(1);
            alert('Le code a expiré. Veuillez recommencer.');
        }
    }, 1000);
}

// Écouteurs d'événements pour les formulaires
document.addEventListener('DOMContentLoaded', () => {
    // Gestionnaire pour le formulaire d'email
    document.getElementById('emailForm').addEventListener('submit', (e) => {
        e.preventDefault();
        showStage(2);
    });

    // Gestionnaire pour le formulaire de vérification
    document.getElementById('verificationForm').addEventListener('submit', (e) => {
        e.preventDefault();
        showStage(3);
        
        // Redirection après 2 secondes
        setTimeout(() => {
            window.location.href = '/superAdmin/dashboard';
        }, 2000);
    });

    // Initialisation : affiche la première étape
    showStage(1);
});

// Fonction pour mettre à jour les étapes visuellement
function updateSteps(step) {
    document.querySelectorAll('.step').forEach(s => {
        const stepNumber = parseInt(s.dataset.step);
        if (stepNumber < step) {
            s.classList.add('completed');
            s.classList.remove('active');
        } else if (stepNumber === step) {
            s.classList.add('active');
            s.classList.remove('completed');
        } else {
            s.classList.remove('active', 'completed');
        }
    });
}

// Fonction pour afficher une étape spécifique
function showStage(stage) {
    // Animation de sortie pour l'étape actuelle
    const currentStageEl = document.querySelector('.form-stage.active');
    if (currentStageEl) {
        currentStageEl.style.opacity = '0';
        currentStageEl.style.transform = 'translateY(-20px)';
    }

    // Après l'animation de sortie, on change d'étape
    setTimeout(() => {
        document.querySelectorAll('.form-stage').forEach(s => {
            s.classList.remove('active');
            s.style.opacity = '0';
            s.style.transform = 'translateY(20px)';
        });

        const nextStage = document.getElementById(`stage${stage}`);
        nextStage.classList.add('active');

        // Animation d'entrée pour la nouvelle étape
        setTimeout(() => {
            nextStage.style.opacity = '1';
            nextStage.style.transform = 'translateY(0)';
        }, 50);

        currentStage = stage;
        updateSteps(stage);

        // Démarrer le timer si on est à l'étape 2
        if (stage === 2) {
            startTimer(30);
        }
    }, 300);
}

// Fonction pour le compte à rebours
function startTimer(duration) {
    let timeLeft = duration;
    const countdownEl = document.getElementById('countdown');
    
    clearInterval(timer);
    timer = setInterval(() => {
        countdownEl.textContent = timeLeft;
        if (--timeLeft < 0) {
            clearInterval(timer);
            showStage(1);
            alert('Le code a expiré. Veuillez recommencer.');
        }
    }, 1000);
}

// Gestionnaire pour le formulaire d'email
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('emailForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Envoi en cours...';

        try {
            const response = await fetch(this.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    email: document.getElementById('email').value
                })
            });

            if (response.ok) {
                showStage(2);
                startTimer(30);
            } else {
                const data = await response.json();
                alert(data.message || 'Une erreur est survenue');
            }
        } catch (error) {
            alert('Une erreur est survenue lors de l\'envoi du code');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Envoyer le code';
        }
    });

    // Gestionnaire pour le formulaire de vérification
    document.getElementById('verificationForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Vérification...';

        try {
            const response = await fetch(this.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    code: document.getElementById('code').value
                })
            });

            const data = await response.json();

            if (response.ok) {
                clearInterval(timer);
                showStage(3);
                
                // Redirection après succès avec animation
                const successMessage = document.querySelector('.success-message');
                successMessage.style.opacity = '1';
                setTimeout(() => {
                    window.location.href = data.redirect || staffDashboardRoute; // staffDashboardRoute devrait être défini dans votre vue
                }, 2000);
            } else {
                alert(data.message || 'Code incorrect');
            }
        } catch (error) {
            alert('Une erreur est survenue lors de la vérification');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Vérifier';
        }
    });

    // Initialiser la première étape
    showStage(1);
});
