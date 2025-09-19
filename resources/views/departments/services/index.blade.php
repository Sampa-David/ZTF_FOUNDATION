<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services du Département - {{ $department->name }}</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4299e1;
            --warning-color: #ecc94b;
            --danger-color: #f56565;
            --success-color: #48bb78;
            --text-primary: #2d3748;
            --text-secondary: #718096;
            --border-color: #e2e8f0;
            --bg-secondary: #f8fafc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--text-primary);
            background-color: #f7fafc;
        }

        .navbar {
            background-color: white;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .services-container {
            padding: 2rem 0;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--border-color);
        }

        .header-content h1 {
            font-size: 1.875rem;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .breadcrumb {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .breadcrumb a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .service-card {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.2s;
        }

        .service-card:hover {
            transform: translateY(-2px);
        }

        .service-header {
            padding: 1rem;
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .service-status {
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .active {
            background-color: #c6f6d5;
            color: #2f855a;
        }

        .inactive {
            background-color: #fed7d7;
            color: #c53030;
        }

        .service-body {
            padding: 1rem;
        }

        .service-description {
            color: var(--text-secondary);
            margin-bottom: 1rem;
        }

        .service-stats {
            display: flex;
            gap: 1rem;
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        .stat {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .service-actions {
            padding: 1rem;
            background: var(--bg-secondary);
            border-top: 1px solid var(--border-color);
            display: flex;
            gap: 0.5rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: opacity 0.2s;
            text-decoration: none;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-warning {
            background-color: var(--warning-color);
            color: #744210;
        }

        .btn-danger {
            background-color: var(--danger-color);
            color: white;
        }

        .btn-info {
            background-color: var(--primary-color);
            color: white;
        }

        .no-services {
            grid-column: 1 / -1;
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .no-services i {
            font-size: 3rem;
            color: var(--text-secondary);
            margin-bottom: 1rem;
        }

        .no-services h2 {
            margin-bottom: 0.5rem;
        }

        .no-services p {
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .service-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .services-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="{{ route('departments.dashboard') }}" style="color: var(--primary-color); text-decoration: none; font-weight: 500;">
                <i class="fas fa-arrow-left"></i> Retour au tableau de bord
            </a>
        </div>
    </nav>

    <div class="container">
        <div class="services-container">
            <div class="page-header">
                <div class="header-content">
                    <h1>Services du Département</h1>
                    <nav class="breadcrumb">
                        <a href="{{ route('departments.dashboard') }}">Tableau de bord</a> /
                        <span>Services</span>
                    </nav>
                </div>
                <div class="header-actions">
                    <a href="{{ route('departments.services.create', ['department' => $department->id]) }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nouveau Service
                    </a>
                </div>
            </div>

            <div class="services-grid">
                @forelse($services as $service)
                    <div class="service-card">
                        <div class="service-header">
                            <h2>{{ $service->name }}</h2>
                            <span class="service-status {{ $service->is_active ? 'active' : 'inactive' }}">
                                {{ $service->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </div>
                        
                        <div class="service-body">
                            <p class="service-description">
                                {{ $service->description ?? 'Aucune description disponible' }}
                            </p>
                            
                            <div class="service-stats">
                                <div class="stat">
                                    <i class="fas fa-users"></i>
                                    <span>{{ $service->users_count ?? 0 }} employés</span>
                                </div>
                                <div class="stat">
                                    <i class="fas fa-calendar"></i>
                                    <span>Créé le {{ $service->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="service-actions">
                            <a href="{{ route('departments.services.show', ['department' => $department->id, 'service' => $service->id]) }}" class="btn btn-info">
                                <i class="fas fa-eye"></i> Détails
                            </a>
                            <a href="{{ route('departments.services.edit', ['department' => $department->id, 'service' => $service->id]) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <button class="btn btn-danger" onclick="confirmDeleteService({{ $department->id }}, {{ $service->id }})">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="no-services">
                        <i class="fas fa-folder-open"></i>
                        <h2>Aucun service trouvé</h2>
                        <p>Votre département n'a pas encore de services. Commencez par en créer un!</p>
                        <a href="{{ route('departments.services.create', ['department' => $department->id]) }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Créer un service
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
    function confirmDeleteService(departmentId, serviceId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer ce service ?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/departments/${departmentId}/services/${serviceId}`;
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Ajouter un effet de hover sur les cartes
    document.querySelectorAll('.service-card').forEach(card => {
        card.addEventListener('mouseover', () => {
            card.style.transform = 'translateY(-2px)';
            card.style.boxShadow = '0 4px 6px rgba(0,0,0,0.1)';
        });

        card.addEventListener('mouseout', () => {
            card.style.transform = 'translateY(0)';
            card.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
        });
    });
    </script>
</body>
</html>