<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du membre du comité</title>
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
            margin-bottom: 2rem;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .card-title {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin: 0;
        }

        .btn-group {
            display: flex;
            gap: 1rem;
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

        .btn-danger {
            background-color: var(--error-color);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
        }

        .btn-danger:hover {
            background-color: #b91c1c;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .info-section {
            margin-bottom: 2rem;
        }

        .info-title {
            font-size: 1.25rem;
            color: var(--secondary-color);
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .info-label {
            color: var(--secondary-color);
            font-weight: 500;
        }

        .info-value {
            color: #1f2937;
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
        }

        .badge-success {
            background-color: #dcfce7;
            color: var(--success-color);
        }

        .badge-warning {
            background-color: #fef9c3;
            color: #854d0e;
        }

        .badge-group {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.5rem;
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

        .delete-form {
            display: inline;
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

        <div class="card">
            <div class="card-header">
                <h1 class="card-title">{{ $member->name }}</h1>
                <div class="btn-group">
                    <a href="{{ route('committee.edit', $member) }}" class="btn btn-primary">
                        Modifier
                    </a>
                    <form action="{{ route('committee.destroy', $member) }}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" 
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce membre ?')">
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>

            <div class="info-grid">
                <div class="info-section">
                    <h2 class="info-title">Informations personnelles</h2>
                    <ul class="info-list">
                        <li class="info-item">
                            <span class="info-label">Matricule</span>
                            <span class="info-value">{{ $member->matricule }}</span>
                        </li>
                        <li class="info-item">
                            <span class="info-label">Email</span>
                            <span class="info-value">{{ $member->email }}</span>
                        </li>
                        <li class="info-item">
                            <span class="info-label">Département</span>
                            <span class="info-value">
                                {{ $member->department ? $member->department->name : 'Non assigné' }}
                            </span>
                        </li>
                    </ul>
                </div>

                <div class="info-section">
                    <h2 class="info-title">Rôles et Permissions</h2>
                    <div class="info-list">
                        <div class="info-item">
                            <span class="info-label">Rôles</span>
                            <div class="badge-group">
                                @foreach($member->roles as $role)
                                    <span class="badge badge-success">{{ $role->display_name }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Permissions</span>
                            <div class="badge-group">
                                @foreach($member->permissions as $permission)
                                    <span class="badge badge-warning">{{ $permission->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-section">
                    <h2 class="info-title">Activité</h2>
                    <ul class="info-list">
                        @foreach($activities as $key => $value)
                            <li class="info-item">
                                <span class="info-label">{{ ucfirst(str_replace('_', ' ', $key)) }}</span>
                                <span class="info-value">{{ $value }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="btn-group">
            <a href="{{ route('committee.index') }}" class="btn btn-primary">
                Retour à la liste
            </a>
        </div>
    </div>
</body>
</html>
