<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Personnel - ZTF Foundation</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboards.css') }}">
    <style>
        .profile-header {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-bottom: 2rem;
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
            flex-shrink: 0;
        }

        .profile-info {
            flex: 1;
        }

        .profile-name {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .profile-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            color: #64748b;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .info-card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 1.5rem;
        }

        .info-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .info-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-success {
            background-color: #dcfce7;
            color: #166534;
        }

        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
        }

        .activity-list {
            list-style: none;
            padding: 0;
        }

        .activity-item {
            display: flex;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .activity-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .activity-icon {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            background-color: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            flex-shrink: 0;
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 500;
            color: #1e293b;
            margin-bottom: 0.25rem;
        }

        .activity-time {
            font-size: 0.875rem;
            color: #64748b;
        }
        .users-table {
            width: 100%;
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-top: 1.5rem;
            overflow: hidden;
        }

        .users-table thead {
            background-color: #f8fafc;
        }

        .users-table th,
        .users-table td {
            padding: 1rem 1.5rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .users-table th {
            font-weight: 600;
            color: #64748b;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .users-table tbody tr:hover {
            background-color: #f8fafc;
        }

        .users-table td {
            color: #1e293b;
            font-size: 0.875rem;
        }

        .status-indicator {
            display: inline-block;
            width: 0.5rem;
            height: 0.5rem;
            border-radius: 50%;
            margin-right: 0.5rem;
        }

        .status-online {
            background-color: var(--success-color);
        }

        .table-container {
            overflow-x: auto;
            padding: 1rem;
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .search-box {
            display: flex;
            align-items: center;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            width: 300px;
        }

        .search-box input {
            border: none;
            outline: none;
            padding: 0.25rem;
            width: 100%;
            margin-left: 0.5rem;
        }

        .refresh-button {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .refresh-button:hover {
            background-color: var(--secondary-color);
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <main class="main-content" style="margin-left: 0;">
            <div class="page-header">
                <h1 class="page-title">Mon Espace Personnel</h1>
                <div class="breadcrumb">
                    <a href="{{ route('dashboard') }}" class="text-blue-600">Accueil</a> / Espace Personnel
                </div>
            </div>

            <!-- En-tête du profil -->
            <div class="profile-header">
                <div class="profile-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="profile-info">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <div class="profile-name">{{ Auth::user()->matricule }}</div>
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary" style="font-size: 0.875rem;">
                            <i class="fas fa-user-edit"></i>
                            Modifier mon profil
                        </a>
                    </div>
                    <div class="profile-details">
                        <div class="detail-item">
                            <i class="fas fa-envelope"></i>
                            <span>{{ Auth::user()->email }}</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-building"></i>
                            <span>{{ Auth::user()->Departement->name ?? 'Non assigné' }}</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-user-tie"></i>
                            <span>{{ Auth::user()->role->first()->name ?? 'Non défini' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="info-grid">
                <!-- Informations du Département -->
                <div class="info-card">
                    <div class="info-header">
                        <h2 class="info-title">
                            <i class="fas fa-building text-blue-600"></i>
                            Mon Département
                        </h2>
                        <span class="badge badge-success">Actif</span>
                    </div>
                    @if(Auth::user()->Departement)
                        <div class="department-info">
                            <p class="mb-2"><strong>Nom:</strong> {{ Auth::user()->Departement->name }}</p>
                            <p class="mb-2"><strong>Chef:</strong> {{ Auth::user()->Departement->headDepartment->matricule ?? 'Non assigné' }}</p>
                            <p><strong>Description:</strong> {{ Str::limit(Auth::user()->Departement->description, 150) }}</p>
                        </div>
                    @else
                        <p class="text-gray-500">Vous n'êtes pas encore assigné à un département.</p>
                    @endif
                </div>

                <!-- État du Compte -->
                <div class="info-card">
                    <div class="info-header">
                        <h2 class="info-title">
                            <i class="fas fa-user-shield text-green-600"></i>
                            État du Compte
                        </h2>
                    </div>
                    <div class="account-status">
                        <div class="detail-item mb-3">
                            <i class="fas fa-clock"></i>
                            <span>Dernière connexion: {{ Auth::user()->last_login_at ? Auth::user()->last_login_at->format('d/m/Y H:i') : 'Jamais' }}</span>
                        </div>
                        <div class="detail-item mb-3">
                            <i class="fas fa-calendar-check"></i>
                            <span>Compte créé le: {{ Auth::user()->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-shield-alt"></i>
                            <span>Statut: <span class="badge badge-success">Vérifié</span></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activités Récentes -->
            <div class="info-card">
                <div class="info-header">
                    <h2 class="info-title">
                        <i class="fas fa-history text-purple-600"></i>
                        Activités Récentes
                    </h2>
                </div>
                <ul class="activity-list">
                    <li class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-sign-in-alt"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Dernière connexion</div>
                            <div class="activity-time">{{ Auth::user()->last_login_at ? Auth::user()->last_login_at->diffForHumans() : 'Jamais' }}</div>
                        </div>
                    </li>
                    <li class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Dernière mise à jour du profil</div>
                            <div class="activity-time">{{ Auth::user()->info_updated_at ? Auth::user()->info_updated_at->diffForHumans() : 'Aucune mise à jour' }}</div>
                        </div>
                    </li>
                </ul>
            </div>

            <div style="display: flex; gap: 1rem;text-decoration:none">
                    <a href="{{ route('home') }}" class="refresh-button">
                        <i class="fas fa-arrow-left"></i>
                        Retour a l'Accueil
                    </a>
            </div>
            
            </form>
        </main>
    </div>
</body>
</html>
