<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Assigner Utilisateurs à un Département</title>
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1d4ed8;
            --primary-rgb: 37,99,235;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            margin: 0;
            padding: 2rem;
        }

        .container {
            max-width: 900px;
            margin: auto;
        }

        h1 {
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 2rem;
        }

        .form-container {
            background: white;
            padding: 2rem;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .form-select, .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            font-size: 0.875rem;
        }

        .form-select:focus, .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(var(--primary-rgb), 0.1);
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
            border-radius: 0.5rem;
            font-weight: 500;
            font-size: 0.875rem;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
        }

        .btn-secondary {
            background-color: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .btn-secondary:hover {
            background-color: #e2e8f0;
        }

        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Assigner des utilisateurs à un département</h1>

        <div class="form-container">
            <form action="{{ route('departments.assignUsers', $department->id) }}" method="POST">

                @csrf
                @method('PUT')

                <!-- Sélection du département -->
                <div class="form-group">
                    <label class="form-label" for="department">Département</label>
                    <input type="text" id="department" name="department" class="form-input" value="{{ $department->name }}" disabled>
                </div>

                <!-- Liste des utilisateurs -->
                <div class="form-group">
                    <label class="form-label" for="users">Sélectionner les utilisateurs</label>
                    <select id="users" name="users[]" class="form-select" multiple required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ in_array($user->id, $assignedUsers ?? []) ? 'selected' : '' }}>
                                {{ $user->matricule }} - {{ $user->email }}
                            </option>
                        @endforeach
                    </select>
                    <small style="color:#475569;font-size:0.75rem;">Maintenir CTRL (ou CMD sur Mac) pour sélectionner plusieurs utilisateurs.</small>
                </div>

                <!-- Boutons -->
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Assigner</button>
                    <a href="{{ route('departments.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
