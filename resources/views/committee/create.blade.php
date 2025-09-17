<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création d'un Comité | ZTF Foundation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #475569;
            --success-color: #16a34a;
            --danger-color: #dc2626;
            --background-color: #f0f4f8;
            --card-background: #ffffff;
            --border-color: #e2e8f0;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --shadow-color: rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            background-color: var(--background-color);
            color: var(--text-primary);
            min-height: 100vh;
            padding-top: 80px;
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

        .navbar {
            background: var(--card-background);
            box-shadow: 0 2px 4px var(--shadow-color);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 1rem;
        }

        .navbar-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            color: var(--primary-color);
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
        }

        .navbar-back {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            color: var(--text-secondary);
            font-weight: 500;
            transition: color 0.3s;
        }

        .navbar-back:hover {
            color: var(--primary-color);
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
            display: grid;
            grid-template-columns: 3fr 1fr;
            gap: 2rem;
        }

        .committee-card {
            background: var(--card-background);
            border-radius: 1rem;
            box-shadow: 0 4px 6px var(--shadow-color);
            padding: 2rem;
        }

        .committee-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--border-color);
        }

        .committee-title {
            color: var(--primary-color);
            font-size: 1.875rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .committee-subtitle {
            color: var(--text-secondary);
            font-size: 1rem;
        }

        .committee-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .form-help {
            display: block;
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--border-color);
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s;
            background: white;
            color: var(--text-primary);
        }

        .form-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            outline: none;
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .help-sidebar {
            background: var(--card-background);
            border-radius: 1rem;
            box-shadow: 0 4px 6px var(--shadow-color);
            padding: 1.5rem;
            position: sticky;
            top: 100px;
            height: fit-content;
        }

        .help-content h3 {
            color: var(--primary-color);
            font-size: 1.25rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .help-list {
            list-style: none;
            padding: 0;
        }

        .help-list li {
            margin-bottom: 1rem;
            padding-left: 1.5rem;
            position: relative;
        }

        .help-list li:before {
            content: "•";
            color: var(--primary-color);
            position: absolute;
            left: 0;
        }

        .help-list strong {
            color: var(--text-primary);
            display: block;
            margin-bottom: 0.25rem;
        }

        .error-message {
            color: var(--danger-color);
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .role-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
        }

        .button-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            justify-content: flex-end;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            white-space: nowrap;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);
        }

        .btn-secondary {
            background-color: white;
            color: var(--text-secondary);
            border: 2px solid var(--border-color);
        }

        .btn-secondary:hover {
            background-color: #f8fafc;
            border-color: var(--text-secondary);
            color: var(--text-primary);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
            }

            .help-sidebar {
                display: none;
            }

            .committee-card {
                padding: 1.5rem;
            }

            .button-group {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .committee-title {
                font-size: 1.5rem;
            }
        }

        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            animation: slideIn 0.3s ease-out;
            transition: opacity 0.5s ease-out;
        }

        .alert-success {
            background-color: #ecfdf5;
            border: 2px solid #a7f3d0;
            color: var(--success-color);
        }

        .alert-error {
            background-color: #fef2f2;
            border: 2px solid #fecaca;
            color: var(--danger-color);
        }

        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        .committee-create-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .committee-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .committee-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .committee-title {
            color: #2563eb;
            font-size: 1.875rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .committee-subtitle {
            color: #64748b;
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.5rem;
            font-size: 0.935rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            outline: none;
        }

        .form-select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            background-color: white;
            cursor: pointer;
        }

        .roles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .role-item {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .role-item:hover {
            border-color: #2563eb;
            background-color: #f8fafc;
        }

        .role-checkbox {
            margin-right: 0.75rem;
        }

        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background-color: #f0fdf4;
            border: 2px solid #bbf7d0;
            color: #16a34a;
        }

        .alert-error {
            background-color: #fef2f2;
            border: 2px solid #fecaca;
            color: #dc2626;
        }

        .button-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            justify-content: flex-end;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.935rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #2563eb;
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background-color: white;
            color: #475569;
            border: 2px solid #e2e8f0;
        }

        .btn-secondary:hover {
            background-color: #f8fafc;
            border-color: #cbd5e1;
        }

        /* Responsive Design */
        @media (max-width: 640px) {
            .committee-card {
                padding: 1.5rem;
            }

            .committee-title {
                font-size: 1.5rem;
            }

            .button-group {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>

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

        <div class="committee-card">
            <div class="committee-header">
                <h1 class="committee-title">
                    <i class="fas fa-users-gear"></i>
                    Créer un Nouveau Comité
                </h1>
                <p class="committee-subtitle">Remplissez le formulaire ci-dessous pour créer un nouveau comité</p>
            </div>

            <form action="{{ route('committee.store') }}" method="POST" class="committee-form">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="name">
                        <i class="fas fa-signature"></i>
                        Nom du Comité*
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           class="form-input" 
                           value="{{ old('name') }}" 
                           required 
                           placeholder="Entrez le nom du comité"
                           maxlength="255">
                    <small class="form-help">Le nom doit être unique et descriptif</small>
                    @error('name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">
                        <i class="fas fa-align-left"></i>
                        Description du Comité*
                    </label>
                    <textarea id="description" 
                              name="description" 
                              class="form-input form-textarea" 
                              required 
                              rows="4" 
                              placeholder="Décrivez le rôle et les responsabilités de ce comité">{{ old('description') }}</textarea>
                    <small class="form-help">Donnez une description détaillée du comité et de ses objectifs</small>
                    @error('description')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="button-group">
                    <a href="{{ route('committee.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Créer le membre</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
