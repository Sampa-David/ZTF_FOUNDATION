<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un membre du comité</title>
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #475569;
            --success-color: #16a34a;
            --error-color: #dc2626;
            --background-color: #f8fafc;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            background-color: var(--background-color);
            margin: 0;
            padding: 2rem;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 2rem;
        }

        .card-header {
            margin-bottom: 2rem;
        }

        .card-title {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .card-subtitle {
            color: var(--secondary-color);
            font-size: 0.875rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 500;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        }

        .error-message {
            color: var(--error-color);
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .roles-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .role-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
        }

        .btn-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
        }

        .btn-secondary {
            background-color: white;
            color: var(--secondary-color);
            border: 1px solid #e2e8f0;
        }

        .btn-secondary:hover {
            background-color: #f8fafc;
        }

        .alert {
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: var(--success-color);
        }

        .alert-error {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: var(--error-color);
        }
    </style>
</head>
<body>
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Créer un nouveau membre du comité</h1>
                <p class="card-subtitle">Remplissez les informations pour créer un nouveau membre</p>
            </div>

            <form action="{{ route('committee.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="name">Nom complet</label>
                    <input type="text" id="name" name="name" class="form-input" 
                           value="{{ old('name') }}" required>
                    @error('name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Adresse email</label>
                    <input type="email" id="email" name="email" class="form-input" 
                           value="{{ old('email') }}" required>
                    @error('email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" class="form-input" required>
                    @error('password')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirmer le mot de passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" 
                           class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="department_id">Département (optionnel)</label>
                    <select id="department_id" name="department_id" class="form-input">
                        <option value="">Sélectionner un département</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" 
                                {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('department_id')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Rôles</label>
                    <div class="roles-list">
                        @foreach($roles as $role)
                            <label class="role-item">
                                <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                    {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}>
                                {{ $role->display_name }}
                            </label>
                        @endforeach
                    </div>
                    @error('roles')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Créer le membre</button>
                    <a href="{{ route('committee.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
