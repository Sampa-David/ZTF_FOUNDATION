<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Utilisateur</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .form-container {
            max-width: 800px;
            margin: 20px auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
        }

        .form-header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e5e7eb;
        }

        .form-header h1 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #111827;
        }

        .form-section {
            margin-bottom: 30px;
        }

        .form-section h2 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 20px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 0.875rem;
            color: #111827;
            transition: all 0.2s;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-error {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 4px;
        }

        .switch-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 8px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #9ca3af;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #10b981;
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            border: none;
        }

        .btn-cancel {
            background: #f3f4f6;
            color: #374151;
        }

        .btn-submit {
            background: #3b82f6;
            color: white;
        }

        .btn-submit:hover {
            background: #2563eb;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="form-container">
        <div class="form-header">
            <h1>Créer un Nouvel Utilisateur</h1>
        </div>

        <form action="{{ route('committee.staff.store') }}" method="POST">
            @csrf

            <!-- Informations de base -->
            <div class="form-section">
                <h2>Informations Personnelles</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Nom Complet</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Adresse Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" required>
                        @error('password')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirmer le mot de passe</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
            </div>

            <!-- Affectation -->
            <div class="form-section">
                <h2>Affectation</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="department_id">Département</label>
                        <select id="department_id" name="department_id" class="form-select">
                            <option value="">Sélectionner un département</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="service_id">Service</label>
                        <select id="service_id" name="service_id" class="form-select">
                            <option value="">Sélectionner un service</option>
                            <!-- Les services seront chargés dynamiquement via JavaScript -->
                        </select>
                        @error('service_id')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role">Rôle</label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="">Sélectionner un rôle</option>
                            <option value="admin1" {{ old('role') == 'admin1' ? 'selected' : '' }}>Administrateur</option>
                            <option value="admin2" {{ old('role') == 'admin2' ? 'selected' : '' }}>Chef de Département</option>
                            <option value="chef_service" {{ old('role') == 'chef_service' ? 'selected' : '' }}>Chef de Service</option>
                            <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                        </select>
                        @error('role')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Paramètres du compte -->
            <div class="form-section">
                <h2>Paramètres du Compte</h2>
                <div class="form-group">
                    <label>Statut du compte</label>
                    <div class="switch-container">
                        <label class="switch">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <span class="slider"></span>
                        </label>
                        <span>Compte actif</span>
                    </div>
                    @error('is_active')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="action-buttons">
                <a href="{{ route('committee.staff.index') }}" class="btn btn-cancel">
                    <i class="fas fa-times"></i>
                    Annuler
                </a>
                <button type="submit" class="btn btn-submit">
                    <i class="fas fa-save"></i>
                    Créer l'utilisateur
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('department_id').addEventListener('change', function() {
            const departmentId = this.value;
            const serviceSelect = document.getElementById('service_id');
            serviceSelect.innerHTML = '<option value="">Sélectionner un service</option>';
            
            if (departmentId) {
                fetch(`/api/departments/${departmentId}/services`)
                    .then(response => response.json())
                    .then(services => {
                        services.forEach(service => {
                            const option = document.createElement('option');
                            option.value = service.id;
                            option.textContent = service.name;
                            serviceSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Erreur lors du chargement des services:', error));
            }
        });
    </script>
</body>
</html>