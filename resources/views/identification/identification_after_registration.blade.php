<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZTF Foundation Identification</title>
    <link rel="stylesheet" href="{{ asset('first_registration.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h2>Vérification d'identité</h2>
            <p>Veuillez entrer le code d'identification reçu par email</p>
        </div>

        <form action="{{ route('verify.identification') }}" method="POST">
            @csrf
            <div class="code-input-container">
                <input type="text" class="code-digit" maxlength="1" pattern="[0-9]" required autofocus>
                <input type="text" class="code-digit" maxlength="1" pattern="[0-9]" required>
                <input type="text" class="code-digit" maxlength="1" pattern="[0-9]" required>
                <input type="text" class="code-digit" maxlength="1" pattern="[0-9]" required>
                <input type="text" class="code-digit" maxlength="1" pattern="[0-9]" required>
                <input type="text" class="code-digit" maxlength="1" pattern="[0-9]" required>
                <input type="text" class="code-digit" maxlength="1" pattern="[0-9]" required>
                <input type="text" class="code-digit" maxlength="1" pattern="[0-9]" required>
                <input type="hidden" name="verification_code" id="verification_code">
            </div>

            <div class="timer">
                Expire dans : <span id="timer">02:00</span>
            </div>

            @if ($errors->any())
                <div class="error-message">
                    {{ $errors->first() }}
                </div>
            @endif

            <button type="submit" class="submit-button">Vérifier</button>
        </form>

        <div class="form-footer">
            <p>Vous n'avez pas reçu de code ?</p>
            <form action="{{route('resend.code')}}" method="POST">
                @csrf
                <button type="submit" class="resend-button">
                    <i class="fas fa-sync-alt"></i> Renvoyer le code
                </button>
            </form>
        </div>
    </div>

<style>
    .form-footer {
        text-align: center;
        margin-top: 25px;
        padding: 20px;
        border-top: 1px solid #eee;
    }

    .form-footer p {
        color: #666;
        margin-bottom: 15px;
        font-size: 0.95em;
    }

    .resend-button {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 25px;
        font-size: 0.95em;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .resend-button i {
        margin-right: 8px;
        font-size: 0.9em;
    }

    .resend-button:hover {
        background: linear-gradient(135deg, #2980b9 0%, #2573a7 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    .resend-button:active {
        transform: translateY(0);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    /* Animation pour l'icône lors du hover */
    .resend-button:hover i {
        animation: spin 1s ease-in-out;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion des inputs du code
        const codeInputs = document.querySelectorAll('.code-digit');
        const form = document.querySelector('form');

        codeInputs.forEach((input, index) => {
            // Déplacement automatique au champ suivant
            input.addEventListener('input', function(e) {
                if (input.value.length === input.maxLength) {
                    if (index < codeInputs.length - 1) {
                        codeInputs[index + 1].focus();
                    }
                }
            });

            // Gestion de la touche retour arrière
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && input.value.length === 0 && index > 0) {
                    codeInputs[index - 1].focus();
                }
            });
        });

        // Gestion du timer
        let timeLeft = 120; // 2 minutes en secondes
        const timerElement = document.getElementById('timer');

        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            if (timeLeft > 0) {
                timeLeft--;
                setTimeout(updateTimer, 1000);
            } else {
                timerElement.parentElement.textContent = 'Code expiré';
            }
        }

        updateTimer();

        // Soumission du formulaire
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            let code = '';
            codeInputs.forEach(input => {
                code += input.value;
            });
            document.getElementById('verification_code').value = code;
            this.submit();
        });
    });
</script>
</body>
</html>
