<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZTF Foundation - Authentification 2FA</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --secondary-color: #818cf8;
            --success-color: #22c55e;
            --error-color: #ef4444;
            --background-color: #f8fafc;
            --title-color: #1e293b;
            --text-color: #475569;
            --border-color: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: var(--text-color);
        }

        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            width: 100%;
            max-width: 500px;
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        }

        .auth-title {
            text-align: center;
            color: var(--title-color);
            font-size: 1.75rem;
            margin-bottom: 2.5rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .auth-title span {
            display: block;
            font-size: 1rem;
            color: var(--text-color);
            font-weight: 400;
            margin-top: 0.5rem;
        }

        .steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3rem;
            position: relative;
            padding: 0 2rem;
        }

        .steps::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--border-color);
            z-index: 1;
        }

        .step {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            border: 2px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--text-color);
            position: relative;
            z-index: 2;
            transition: all 0.3s ease;
        }

        .step.active {
            border-color: var(--primary-color);
            color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .step.completed {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .step.completed::after {
            content: '✓';
            font-size: 1.2rem;
        }

        .form-stage {
            display: none;
        }

        .form-stage.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--title-color);
            font-weight: 500;
            font-size: 0.875rem;
        }

        .form-input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid var(--border-color);
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            color: var(--title-color);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .form-input::placeholder {
            color: #94a3b8;
        }

        #code {
            letter-spacing: 0.25em;
            font-family: monospace;
            text-align: center;
            font-size: 1.25rem;
        }

        .btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 1rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn:active {
            transform: translateY(1px);
        }

        .timer {
            text-align: center;
            margin: 1.5rem 0;
            padding: 1rem;
            background: #fff5f5;
            border-radius: 10px;
            color: var(--error-color);
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .timer i {
            animation: pulse 1s infinite;
        }

        .success-message {
            text-align: center;
            color: var(--success-color);
            padding: 2rem 0;
        }

        .success-message i {
            font-size: 4rem;
            margin-bottom: 1rem;
            animation: bounceIn 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .success-message p {
            margin: 0.5rem 0;
            font-size: 1.25rem;
            font-weight: 500;
        }

        .success-message p:last-child {
            font-size: 1rem;
            color: var(--text-color);
            margin-top: 1rem;
        }

        .error {
            color: var(--error-color);
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .error i {
            font-size: 1rem;
        }

        #countdown {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="auth-title">
            Authentification à Deux Facteurs
            <span>Sécurisez votre connexion</span>
        </h1>
        <div class="steps">
            <div class="step active" data-step="1">1</div>
            <div class="step" data-step="2">2</div>
            <div class="step" data-step="3">3</div>
        </div>

        <!-- Étape 1: Email Form -->
        <div class="form-stage active" id="stage1">
            <form id="emailForm" action="{{ route('sendCode') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Adresse Email</label>
                    <input type="email" id="email" name="email" class="form-input" 
                           value="{{old('email')}}" required 
                           placeholder="exemple@ztffoundation.com">
                    @error('email')
                        <div class="error">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn">
                    <i class="fas fa-paper-plane"></i>
                    Envoyer le code
                </button>
            </form>
        </div>

        <!-- Étape 2: Code Verification -->
        <div class="form-stage" id="stage2">
            <div class="timer">
                <i class="fas fa-clock"></i>
                Code expire dans : <span id="countdown">30</span>s
            </div>
            <form id="verificationForm" action="{{ route('verifyCode') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="code">Code de vérification</label>
                    <input type="text" id="code" name="code" class="form-input" 
                           required pattern="\d{12}" maxlength="12"
                           placeholder="000000000000">
                    @error('code')
                        <div class="error">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn">
                    <i class="fas fa-shield-alt"></i>
                    Vérifier
                </button>
            </form>
        </div>

        <!-- Étape 3: Success Message -->
        <div class="form-stage" id="stage3">
            <div class="success-message">
                <i class="fas fa-check-circle"></i>
                <p>Authentification réussie!</p>
                <p>Redirection en cours...</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion des étapes
            const steps = document.querySelectorAll('.step');
            const stages = document.querySelectorAll('.form-stage');
            let currentStep = 1;
            
            // Fonction pour gérer les formulaires avec Ajax
            function handleForm(formId, url, nextStep) {
                const form = document.getElementById(formId);
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(form);
                    const button = form.querySelector('button[type="submit"]');
                    button.classList.add('loading');

                    fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (data.testCode) {
                                // Auto-remplir le code pour le test
                                document.getElementById('code').value = data.testCode;
                            }
                            if (data.redirect) {
                                window.location.href = data.redirect;
                            } else {
                                updateSteps(nextStep);
                            }
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Une erreur est survenue');
                    })
                    .finally(() => {
                        button.classList.remove('loading');
                    });
                });
            }

            function updateSteps(step) {
                steps.forEach(s => {
                    const stepNum = parseInt(s.dataset.step);
                    if (stepNum < step) {
                        s.classList.add('completed');
                        s.classList.remove('active');
                    } else if (stepNum === step) {
                        s.classList.add('active');
                        s.classList.remove('completed');
                    } else {
                        s.classList.remove('active', 'completed');
                    }
                });

                stages.forEach((stage, index) => {
                    if (index + 1 === step) {
                        stage.classList.add('active');
                    } else {
                        stage.classList.remove('active');
                    }
                });
            }

            // Animation du bouton lors du clic
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    this.classList.add('loading');
                    setTimeout(() => {
                        this.classList.remove('loading');
                    }, 2000);
                });
            });

            // Formatage automatique du code de vérification
            const codeInput = document.getElementById('code');
            if (codeInput) {
                codeInput.addEventListener('input', function() {
                    this.value = this.value.replace(/\D/g, '').slice(0, 12);
                });
            }

            // Timer
            let countdown;
            function startTimer(duration) {
                const countdownDisplay = document.getElementById('countdown');
                let timer = duration;

                countdown = setInterval(() => {
                    countdownDisplay.textContent = timer;
                    
                    if (--timer < 0) {
                        clearInterval(countdown);
                        alert('Le code a expiré. Veuillez demander un nouveau code.');
                        updateSteps(1);
                    }
                }, 1000);
            }

            // Démarrer le timer quand l'étape 2 est active
            if (document.getElementById('stage2').classList.contains('active')) {
                startTimer(30);
            }

            // Initialiser les gestionnaires de formulaire
            handleForm('emailForm', '{{ route("sendCode") }}', 2);
            handleForm('verificationForm', '{{ route("verifyCode") }}', 3);

            // Nettoyage lors de la destruction
            return () => {
                if (countdown) clearInterval(countdown);
            };
        });
    </script>
</body>
</html>
