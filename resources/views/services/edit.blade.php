<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Service - ZTF Foundation</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f3f4f6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            width: 100%;
            max-width: 600px;
        }

        .alert {
            background-color: #fee2e2;
            border: 1px solid #fca5a5;
            border-radius: 6px;
            color: #dc2626;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .alert strong {
            display: block;
            margin-bottom: 0.5rem;
        }

        .header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .header h1 {
            color: #1f2937;
            font-size: 1.875rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .header p {
            color: #6b7280;
            font-size: 0.875rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            color: #374151;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        input, textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .buttons {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-cancel {
            background-color: white;
            color: #4b5563;
            border: 1px solid #d1d5db;
        }

        .btn-cancel:hover {
            background-color: #f9fafb;
            border-color: #9ca3af;
        }

        .btn-submit {
            background-color: #4f46e5;
            color: white;
            border: none;
        }

        .btn-submit:hover {
            background-color: #4338ca;
        }

        .error-list {
            background-color: #fee2e2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1.5rem;
        }

        .error-list ul {
            list-style-type: disc;
            margin-left: 1.5rem;
            margin-top: 0.5rem;
        }

        @media (max-width: 640px) {
            .container {
                padding: 1.5rem;
            }

            .buttons {
                flex-direction: column-reverse;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        @if (!Auth::user()->isAdmin2() && !Auth::user()->isSuperAdmin() && !Auth::user()->isAdmin1() && !(str_starts_with(Auth::user()->matricule, 'CM-HQ-') && str_ends_with(Auth::user()->matricule, '-CD')))
            <div class="alert">
                <strong>Accès non autorisé!</strong>
                <span>Seuls les chefs de département peuvent modifier des services.</span>
            </div>
        @else
            <div class="header">
                <h1>Modifier le service</h1>
                <p>Modifiez les informations ci-dessous pour mettre à jour le service</p>
            </div>

            @if ($errors->any())
                <div class="error-list">
                    <strong>Erreurs!</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('services.update', $service->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Nom du service*</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $service->name) }}" 
                        required 
                        placeholder="Entrez le nom du service"
                    >
                </div>

                <div class="form-group">
                    <label for="description">Description*</label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="4" 
                        required 
                        placeholder="Décrivez le rôle et les responsabilités du service"
                    >{{ old('description', $service->description) }}</textarea>
                </div>

                <div class="buttons">
                    <a href="{{ route('services.index') }}" class="btn btn-cancel">
                        Annuler
                    </a>
                    <button type="submit" class="btn btn-submit">
                        Mettre à jour le service
                    </button>
                </div>
            </form>
        @endif
    </div>
</body>
</html>