<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'employé - {{ $staff->name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboards.css') }}">
    <style>
        .employee-details {
            max-width: 800px;
            margin: 2rem auto;
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 2rem;
        }

        .employee-header {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .employee-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #64748b;
        }

        .employee-title h1 {
            margin: 0;
            color: #1e293b;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .employee-subtitle {
            color: #64748b;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .info-section {
            margin-bottom: 2rem;
        }

        .info-section-title {
            color: #64748b;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .info-item {
            margin-bottom: 1rem;
        }

        .info-label {
            color: #64748b;
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
        }

        .info-value {
            color: #1e293b;
            font-weight: 500;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-active {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-inactive {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: #3b82f6;
            color: white;
        }

        .btn-primary:hover {
            background-color: #2563eb;
        }

        .btn-secondary {
            background-color: #e5e7eb;
            color: #4b5563;
        }

        .btn-secondary:hover {
            background-color: #d1d5db;
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
                    <i class="fas fa-user"></i>
                    {{ $staff->name }}
                </span>
            </div>

            <div class="employee-details">
                <div class="employee-header">
                    <div class="employee-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="employee-title">
                        <h1>{{ $staff->name }}</h1>
                        <div class="employee-subtitle">{{ $staff->matricule }}</div>
                    </div>
                </div>

                <div class="info-section">
                    <h2 class="info-section-title">
                        <i class="fas fa-info-circle"></i>
                        Informations générales
                    </h2>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Email</div>
                            <div class="info-value">{{ $staff->email }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Service</div>
                            <div class="info-value">{{ $staff->service->name }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Département</div>
                            <div class="info-value">{{ $staff->department->name }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Statut</div>
                            <div class="info-value">
                                <span class="status-badge {{ $staff->is_active ? 'status-active' : 'status-inactive' }}">
                                    <i class="fas fa-{{ $staff->is_active ? 'check' : 'times' }}-circle"></i>
                                    {{ $staff->is_active ? 'Actif' : 'Inactif' }}
                                </span>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Date d'inscription</div>
                            <div class="info-value">{{ $staff->registered_at ? \Carbon\Carbon::parse($staff->registered_at)->format('d/m/Y H:i') : 'Non défini' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Dernière activité</div>
                            <div class="info-value">
                                {{ $staff->last_activity_at ? \Carbon\Carbon::parse($staff->last_activity_at)->diffForHumans() : 'Jamais' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="action-buttons">
                    <a href="{{ route('departments.staff.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Retour à la liste
                    </a>
                    <a href="{{ route('staff.edit', $staff) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i>
                        Modifier
                    </a>
                    <form action="{{ route('staff.destroy', $staff) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet employé ? Cette action est irréversible.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i>
                            Supprimer
                        </button>
                    </form>
                </div>

                <style>
                    .inline {
                        display: inline;
                    }
                    .btn-danger {
                        background-color: #dc2626;
                        color: white;
                        border: none;
                    }
                    .btn-danger:hover {
                        background-color: #b91c1c;
                    }
                </style>
            </div>
        </main>
    </div>
</body>
</html>