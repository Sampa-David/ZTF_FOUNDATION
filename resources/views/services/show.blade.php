<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Service - ZTF Foundation</title>
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
            max-width: 800px;
        }

        .header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .header h1 {
            color: #1f2937;
            font-size: 1.875rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .info-section {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background-color: #f8fafc;
            border-radius: 0.5rem;
        }

        .info-group {
            margin-bottom: 1.5rem;
        }

        .info-group:last-child {
            margin-bottom: 0;
        }

        .info-label {
            color: #4b5563;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
        }

        .info-value {
            color: #1f2937;
            font-size: 1rem;
            line-height: 1.5;
        }

        .buttons {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 2px solid #e5e7eb;
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

        .btn-back {
            background-color: #6b7280;
            color: white;
            border: none;
        }

        .btn-back:hover {
            background-color: #4b5563;
        }

        .btn-edit {
            background-color: #4f46e5;
            color: white;
            border: none;
        }

        .btn-edit:hover {
            background-color: #4338ca;
        }

        .timestamp {
            color: #6b7280;
            font-size: 0.875rem;
            text-align: right;
            margin-top: 1rem;
        }

        @media (max-width: 640px) {
            .container {
                padding: 1.5rem;
            }

            .buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $service->name }}</h1>
        </div>

        <div class="info-section">
            <div class="info-group">
                <div class="info-label">Description</div>
                <div class="info-value">{{ $service->description }}</div>
            </div>

            <div class="info-group">
                <div class="info-label">Créé le</div>
                <div class="info-value">{{ $service->created_at->format('d/m/Y à H:i') }}</div>
            </div>

            <div class="info-group">
                <div class="info-label">Dernière modification</div>
                <div class="info-value">{{ $service->updated_at->format('d/m/Y à H:i') }}</div>
            </div>
        </div>

        <div class="info-section">
            <div class="info-group">
                <div class="info-label">Membres du service</div>
                <div class="info-value">
                    @if($service->users->count() > 0)
                        <ul style="list-style-type: none; padding: 0;">
                            @foreach($service->users as $user)
                                <li style="margin-bottom: 0.5rem; padding: 0.5rem; background-color: #fff; border-radius: 0.25rem;">
                                    {{ $user->matricule }} - {{ $user->name }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>Aucun membre assigné à ce service.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="buttons">
            <a href="{{ route('services.index') }}" class="btn btn-back">
                Retour à la liste
            </a>
            @if(Auth::user()->isAdmin2() || Auth::user()->isSuperAdmin() || Auth::user()->isAdmin1() || (str_starts_with(Auth::user()->matricule, 'CM-HQ-') && str_ends_with(Auth::user()->matricule, '-CD')))
                <a href="{{ route('services.edit', $service->id) }}" class="btn btn-edit">
                    Modifier le service
                </a>
            @endif
        </div>
    </div>
</body>
</html>
