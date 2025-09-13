<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZTF Foundation - Authentification 2FA</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --success-color: #2ecc71;
            --error-color: #e74c3c;
            --background-color: #f5f7fa;
            --title-color: #2c3e50;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--background-color) 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
            padding: 2rem;
        }

        .auth-title {
            text-align: center;
            color: var(--title-color);
            font-size: 1.75rem;
            margin-bottom: 2rem;
            font-weight: 700;
            position: relative;
            padding-bottom: 1rem;
        }

        .auth-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: var(--primary-color);
            border-radius: 2px;
        }

        .steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
            position: relative;
        }

        .steps::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 2px;
            background: #e2e8f0;
            z-index: 1;
        }

        .step {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: white;
            border: 2px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #718096;
            position: relative;
            z-index: 2;
        }

        .step.active {
            border-color: var(--primary-color);
            color: var(--primary-color);
            background: white;
        }

        .step.completed {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
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
            color: #4a5568;
            font-weight: 500;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.15);
        }

        .btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s;
        }

        .btn:hover {
            background: var(--secondary-color);
        }

        .timer {
            text-align: center;
            margin: 1rem 0;
            font-size: 1.2rem;
            color: var(--error-color);
            font-weight: 600;
        }

        .success-message {
            text-align: center;
            color: var(--success-color);
            font-size: 1.5rem;
            margin: 2rem 0;
        }

        .error {
            color: var(--error-color);
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        #countdown {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="auth-title">Authentification à Deux Facteurs (2FA)</h1>
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
                    <input type="email" id="email" name="email" class="form-input" value="{{old('email')}}" required>
                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn">Envoyer le code</button>
            </form>
        </div>

        <!-- Étape 2: Code Verification -->
        <div class="form-stage" id="stage2">
            <div class="timer">
                Code expire dans : <span id="countdown">30</span>s
            </div>
            <form id="verificationForm" action="{{ route('verifyCode') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="code">Code de vérification</label>
                    <input type="text" id="code" name="code" class="form-input" required pattern="\d{12}" maxlength="12">
                    @error('code')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn">Vérifier</button>
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

    <script src="{{ asset('js/2fa.js') }}"></script>
</body>
</html>
