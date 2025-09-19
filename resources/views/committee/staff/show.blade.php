<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'Utilisateur - {{ $user->name }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .user-details-container {
            max-width: 800px;
            margin: 20px auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e5e7eb;
        }

        .user-profile {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .profile-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #6b7280;
        }

        .profile-info h1 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #111827;
        }

        .profile-info p {
            color: #6b7280;
            margin-top: 4px;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-active {
            background: #dcfce7;
            color: #166534;
        }

        .status-inactive {
            background: #fee2e2;
            color: #991b1b;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-card {
            background: #f8fafc;
            padding: 15px;
            border-radius: 6px;
        }

        .info-card h3 {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .info-card p {
            font-size: 1rem;
            color: #111827;
            font-weight: 500;
        }

        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
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
        }

        .btn-back {
            background: #f3f4f6;
            color: #374151;
        }

        .btn-edit {
            background: #fef3c7;
            color: #92400e;
        }

        .btn-delete {
            background: #fee2e2;
            color: #991b1b;
        }

        .activity-section {
            margin-top: 30px;
        }

        .activity-header {
            font-size: 1.25rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 15px;
        }

        .activity-list {
            border: 1px solid #e5e7eb;
            border-radius: 6px;
        }

        .activity-item {
            padding: 12px 15px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-info {
            color: #6b7280;
            font-size: 0.875rem;
        }

        .activity-date {
            color: #9ca3af;
            font-size: 0.875rem;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="user-details-container">
        <!-- En-tête avec informations de base -->
        <div class="header">
            <div class="user-profile">
                <div class="profile-image">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="profile-info">
                    <h1>{{ $user->name }}</h1>
                    <p>{{ $user->email }}</p>
                    <span class="status-badge {{ $user->is_active ? 'status-active' : 'status-inactive' }}">
                        {{ $user->is_active ? 'Actif' : 'Inactif' }}
                    </span>
                </div>
            </div>
            <div class="action-buttons">
                <a href="{{ route('committee.staff.index') }}" class="btn btn-back">
                    <i class="fas fa-arrow-left"></i>
                    Retour
                </a>
                <a href="{{ route('committee.staff.edit', $user->id) }}" class="btn btn-edit">
                    <i class="fas fa-edit"></i>
                    Modifier
                </a>
                <form action="{{ route('committee.staff.destroy', $user->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                        <i class="fas fa-trash"></i>
                        Supprimer
                    </button>
                </form>
            </div>
        </div>

        <!-- Grille d'informations -->
        <div class="info-grid">
            <div class="info-card">
                <h3>Matricule</h3>
                <p>{{ $user->matricule ?? 'Non assigné' }}</p>
            </div>
            <div class="info-card">
                <h3>Rôle</h3>
                <p>
                    @if($user->isAdmin1())
                        Administrateur
                    @elseif($user->isAdmin2())
                        Chef de Département
                    @elseif($user->isChefService())
                        Chef de Service
                    @else
                        Staff
                    @endif
                </p>
            </div>
            <div class="info-card">
                <h3>Département</h3>
                <p>{{ $user->department->name ?? 'Non assigné' }}</p>
            </div>
            <div class="info-card">
                <h3>Service</h3>
                <p>{{ $user->service->name ?? 'Non assigné' }}</p>
            </div>
            <div class="info-card">
                <h3>Date d'inscription</h3>
                <p>{{ $user->created_at->format('d/m/Y') }}</p>
            </div>
            <div class="info-card">
                <h3>Dernière connexion</h3>
                <p>{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Jamais' }}</p>
            </div>
        </div>

        <!-- Section des activités récentes -->
        <div class="activity-section">
            <h2 class="activity-header">Activités récentes</h2>
            <div class="activity-list">
                @forelse($activities ?? [] as $activity)
                    <div class="activity-item">
                        <span class="activity-info">{{ $activity->description }}</span>
                        <span class="activity-date">{{ $activity->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <div class="activity-item">
                        <span class="activity-info">Aucune activité récente</span>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</body>
</html>