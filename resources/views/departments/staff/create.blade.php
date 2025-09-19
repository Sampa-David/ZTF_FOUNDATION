<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un employé - {{ auth()->user()->department->name ?? 'Département' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboards.css') }}">
    <style>
        .form-container {
            max-width: 800px;
            margin: 2rem auto;
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 2rem;
        }

        .form-title {
            color: #1e293b;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .form-section {
            margin-bottom: 2rem;
        }

        .form-section-title {
            color: #64748b;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            color: #1e293b;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .required::after {
            content: '*';
            color: #dc2626;
            margin-left: 0.25rem;
        }

        .form-input {
            width: 100%;
            padding: 0.625rem 0.875rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            transition: border-color 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-select {
            width: 100%;
            padding: 0.625rem 2.5rem 0.625rem 0.875rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        .error-message {
            color: #dc2626;
            font-size: 0.75rem;
            margin-top: 0.375rem;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            padding: 0.625rem 1.25rem;
            border-radius: 0.375rem;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-primary {
            background-color: #3b82f6;
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: #2563eb;
        }

        .btn-secondary {
            background-color: #e5e7eb;
            color: #4b5563;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #d1d5db;
        }

        .form-helper {
            color: #6b7280;
            font-size: 0.75rem;
            margin-top: 0.375rem;
        }

        .radio-group {
            display: flex;
            gap: 1.5rem;
            margin-top: 0.5rem;
        }

        .radio-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            color: #1e293b;
            font-size: 0.875rem;
        }

        .radio-input {
            width: 1rem;
            height: 1rem;
            cursor: pointer;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 2rem;
            padding: 1rem;
        }

        .breadcrumb a {
            color: #3b82f6;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .breadcrumb-separator {
            color: #d1d5db;
        }

        .alert {
            border-radius: 0.375rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .alert-danger {
            background-color: #fee2e2;
            border: 1px solid #fecaca;
            color: #dc2626;
            margin-bottom: 2rem;
        }

        .alert-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .alert-message {
            margin-bottom: 1rem;
        }

        .error-details {
            background-color: rgba(0, 0, 0, 0.05);
            padding: 1rem;
            border-radius: 0.375rem;
            margin-top: 1rem;
        }

        .error-details h4 {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .error-list {
            list-style-type: disc;
            margin-left: 1.25rem;
            font-size: 0.9rem;
        }

        .error-list li {
            margin-bottom: 0.25rem;
        }

        .error-list strong {
            font-weight: 600;
        }

        body {
            background-color: #f1f5f9;
            font-family: 'Inter', sans-serif;
            line-height: 1.5;
        }

        .main-content {
            min-height: 100vh;
            padding: 1rem;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <main class="main-content">
            <div class="breadcrumb">
                <a href="{{ route('departments.dashboard') }}">
                    <i class="fas fa-home"></i>
                    Tableau de bord
                </a>
                <span class="breadcrumb-separator">/</span>
                <a href="{{ route('departments.staff.index') }}">
                    <i class="fas fa-users"></i>
                    Employés
                </a>
                <span class="breadcrumb-separator">/</span>
                <span>
                    <i class="fas fa-user-plus"></i>
                    Ajouter un employé
                </span>
            </div>

            <div class="form-container">
                <h1 class="form-title">
                    <i class="fas fa-user-plus"></i>
                    Ajouter un nouvel employé
                </h1>

                @if(session('error'))
                    <div class="alert alert-danger">
                        <h3 class="alert-title">
                            <i class="fas fa-exclamation-circle"></i>
                            Une erreur est survenue
                        </h3>
                        <p class="alert-message">{{ session('error') }}</p>
                        
                        @if(session('error_details') && app()->environment('local', 'development'))
                            <div class="error-details">
                                <h4>Détails de l'erreur :</h4>
                                <ul class="error-list">
                                    <li><strong>Type :</strong> {{ session('error_details')['type'] ?? 'Inconnu' }}</li>
                                    <li><strong>Fichier :</strong> {{ session('error_details')['file'] ?? 'Inconnu' }}</li>
                                    <li><strong>Ligne :</strong> {{ session('error_details')['line'] ?? 'Inconnue' }}</li>
                                    <li><strong>Message :</strong> {{ session('error_details')['message'] ?? 'Aucun message' }}</li>
                                </ul>
                            </div>
                        @endif
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <h3 class="alert-title">
                            <i class="fas fa-exclamation-triangle"></i>
                            Erreurs de validation
                        </h3>
                        <ul class="error-list">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('departments.staff.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-section">
                        <h2 class="form-section-title">
                            <i class="fas fa-info-circle"></i>
                            Informations de base
                        </h2>
                        <div class="form-grid">
                            <!-- Nom -->
                            <div class="form-group">
                                <label for="name" class="form-label required">Nom complet</label>
                                <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label for="email" class="form-label required">Adresse email</label>
                                <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Matricule -->
                            <div class="form-group">
                                <label for="matricule" class="form-label">Matricule</label>
                                <input type="text" id="matricule" class="form-input" value="STFxxxx" disabled>
                                <div class="form-helper">Le matricule sera généré automatiquement lors de la création (format: STF0001)</div>
                            </div>

                            <!-- Service -->
                            <div class="form-group">
                                <label for="service_id" class="form-label required">Service</label>
                                <select id="service_id" name="service_id" class="form-select" required>
                                    <option value="">Sélectionnez un service</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('service_id')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2 class="form-section-title">
                            <i class="fas fa-lock"></i>
                            Mot de passe
                        </h2>
                        <div class="form-grid">
                            <!-- Mot de passe -->
                            <div class="form-group">
                                <label for="password" class="form-label required">Mot de passe temporaire</label>
                                <input type="password" id="password" name="password" class="form-input" required>
                                <div class="form-helper">L'employé devra changer son mot de passe à sa première connexion</div>
                                @error('password')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirmation du mot de passe -->
                            <div class="form-group">
                                <label for="password_confirmation" class="form-label required">Confirmez le mot de passe</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
                                @error('password_confirmation')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2 class="form-section-title">
                            <i class="fas fa-toggle-on"></i>
                            Statut du compte
                        </h2>
                        <div class="form-group">
                            <div class="radio-group">
                                <label class="radio-label">
                                    <input type="radio" name="is_active" value="1" class="radio-input" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                    <i class="fas fa-check-circle text-green-500"></i>
                                    Actif
                                </label>
                                <label class="radio-label">
                                    <input type="radio" name="is_active" value="0" class="radio-input" {{ old('is_active') == '0' ? 'checked' : '' }}>
                                    <i class="fas fa-times-circle text-red-500"></i>
                                    Inactif
                                </label>
                            </div>
                            @error('is_active')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('departments.staff.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i>
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Ajouter l'employé
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('input, select');

            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    validateField(this);
                });
            });

            form.addEventListener('submit', function(e) {
                let isValid = true;
                inputs.forEach(input => {
                    if (!validateField(input)) {
                        isValid = false;
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                }
            });

            function validateField(input) {
                const errorDiv = input.nextElementSibling;
                let isValid = true;

                if (errorDiv && errorDiv.classList.contains('error-message')) {
                    errorDiv.remove();
                }

                if (input.required && !input.value) {
                    showError(input, 'Ce champ est requis');
                    isValid = false;
                } else if (input.type === 'email' && input.value) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(input.value)) {
                        showError(input, 'Adresse email invalide');
                        isValid = false;
                    }
                } else if (input.id === 'password' && input.value) {
                    if (input.value.length < 8) {
                        showError(input, 'Le mot de passe doit contenir au moins 8 caractères');
                        isValid = false;
                    }
                } else if (input.id === 'password_confirmation' && input.value) {
                    const password = document.getElementById('password');
                    if (input.value !== password.value) {
                        showError(input, 'Les mots de passe ne correspondent pas');
                        isValid = false;
                    }
                }

                if (isValid) {
                    input.classList.remove('border-red-500');
                    input.classList.add('border-green-500');
                } else {
                    input.classList.remove('border-green-500');
                    input.classList.add('border-red-500');
                }

                return isValid;
            }

            function showError(input, message) {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error-message';
                errorDiv.textContent = message;
                input.parentNode.insertBefore(errorDiv, input.nextSibling);
            }
        });
    </script>
</body>
</html>