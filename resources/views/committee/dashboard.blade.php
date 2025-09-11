<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard  Admin - ZTF Foundation</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboards.css') }}">
    <script src="{{ asset('dashboards.js') }}" defer></script>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">ZTF FOUNDATION</div>
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->matricule ?? ' Admin Grade 1'}}</div>
                    <div class="user-role">Comite de Nehemie</div>
                </div>
            </div>
            <nav>
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="showSection('dashboard')">
                            <i class="fas fa-home"></i>
                            Tableau de bord
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="showSection('users')">
                            <i class="fas fa-users"></i>
                            Gestion des utilisateurs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="showSection('departments')">
                            <i class="fas fa-building"></i>
                            Départements
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="showSection('services')">
                            <i class="fas fa-building"></i>
                            Services
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="showSection('settings')">
                            <i class="fas fa-cog"></i>
                            Paramètres
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="showSection('reports')">
                            <i class="fas fa-chart-bar"></i>
                            Rapports
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="nav-link" style="cursor: pointer;">
                            @csrf
                            <i class="fas fa-sign-out-alt"></i>
                            <button type="submit" style="background: none; border: none; color: inherit; padding: 0; cursor: pointer;">
                                Déconnexion
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>
        <!-- Main Content -->
        <main class="main-content">
            <!-- Dashboard Section -->
            <section id="section-dashboard">
                <div class="page-header">
                    <h1 class="page-title">Tableau de bord</h1>
                    <div class="breadcrumb">Tableau de bord/Accueil</div>
                </div>
                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-card-title">Total Utilisateurs</div>
                        <div class="stat-card-value">{{ $totalUsers ?? '0' }}</div>
                        <div class="stat-card-change positive">
                            
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-title">Départements Actifs</div>
                        <div class="stat-card-value">{{ $totalDepts ?? '0' }}</div>
                        <div class="stat-card-change">
                            <i class="fas fa-check"></i> Tous opérationnels
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-title">Services Actifs</div>
                        <div class="stat-card-value">{{ $totalServices ?? '0' }}</div>
                        <div class="stat-card-change">
                            
                        </div>
                    </div>
                </div>
                <!-- Quick Actions -->
                <div class="actions-grid">
                    <a href="{{route('staff.create')}}" class="action-card">
                        <i class="fas fa-user-plus action-icon"></i>
                        <h3>Ajouter un utilisateur</h3>
                    </a>
                    <a href="{{route('departments.create')}}" class="action-card">
                        <i class="fas fa-folder-plus action-icon"></i>
                        <h3>Nouveau département</h3>
                    </a>
                    <a href="{{route('services.create')}}" class="action-card">
                        <i class="fas fa-folder-plus action-icon"></i>
                        <h3>Nouveau Service</h3>
                    </a>
                    <a href="#" class="action-card">
                        <i class="fas fa-chart-line action-icon"></i>
                        <h3>Statistiques</h3>
                    </a>
                </div>
                <!-- Recent Activity -->
                <div class="activity-section">
                    <div class="section-header">
                        <h2 class="section-title">Activités récentes</h2>
                        <a href="#" class="btn">Voir tout</a>
                    </div>
                    <table class="activity-table">
                        <thead>
                            <tr>
                                <th>Utilisateur</th>
                                <th>Inscription</th>
                                <th>Dernière MAJ</th>
                                <th>Dernière Connexion</th>
                                <th>Dernière Activité</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentActivities as $activity)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <span class="status-dot {{ $activity['is_online'] ? 'bg-success' : 'bg-gray' }}"></span>
                                        {{ $activity['user_name'] }}
                                    </div>
                                </td>
                                <td>{{ $activity['created_at'] }}</td>
                                <td>{{ $activity['last_update'] }}</td>
                                <td>{{ $activity['last_login'] }}</td>
                                <td>{{ $activity['last_seen'] }}</td>
                                <td>
                                    <span class="status-badge status-{{ $activity['status_class'] }}">
                                        {{ $activity['status'] }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    <i class="fas fa-info-circle"></i> Aucun utilisateur trouvé
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    <style>
                        .status-dot {
                            width: 8px;
                            height: 8px;
                            border-radius: 50%;
                        }
                        .bg-success {
                            background-color: #10B981;
                        }
                        .bg-gray {
                            background-color: #9CA3AF;
                        }
                        .activity-table {
                            width: 100%;
                            border-collapse: separate;
                            border-spacing: 0;
                        }
                        .activity-table th {
                            background-color: #F8FAFC;
                            padding: 12px;
                            font-weight: 600;
                            text-align: left;
                            color: #64748B;
                            font-size: 0.875rem;
                        }
                        .activity-table td {
                            padding: 12px;
                            border-top: 1px solid #E2E8F0;
                            font-size: 0.875rem;
                        }
                        .activity-table tr:hover {
                            background-color: #F8FAFC;
                        }
                    </style>
                </div>
            </section>
            <!-- Users Section -->
            <section id="section-users" style="display:none">
                <div class="page-header">
                    <h1 class="page-title">Gestion des utilisateurs</h1>
                    <div class="breadcrumb">Tableau de bord / Gestion des utilisateurs</div>
                </div>
                <div>
                    @include('committee.quickAction')
                </div>
            </section>
            <!-- Departments Section -->
            <section id="section-departments" style="display:none">
                <div class="page-header">
                    <h1 class="page-title">Départements</h1>
                    <div class="breadcrumb">Tableau de bord / Départements</div>
                </div>
                <div>
                    @include('departments.quickAction')
                </div>
            </section>
            <!-- Services section -->
            <section id="section-services" style="display:none">
                <div class="page-header">
                    <h1 class="page-title">Services</h1>
                    <div class="breadcrumb">Tableau de bord / Services</div>
                </div>
                <div>
                    @include('services.quickAction')
                </div>
            </section>
            <!-- Settings Section -->
            <section id="section-settings" style="display:none">
                <div class="page-header">
                    <h1 class="page-title">Paramètres</h1>
                    <div class="breadcrumb">Tableau de bord / Paramètres</div>
                </div>
                <div>
                    <p>Contenu des paramètres ici...</p>
                </div>
            </section>
            <!-- Reports Section -->
            <section id="section-reports" style="display:none">
                <div class="page-header">
                    <h1 class="page-title">Rapports</h1>
                    <div class="breadcrumb">Tableau de bord / Rapports</div>
                </div>
                <div>
                    <p>Contenu des rapports ici...</p>
                </div>
            </section>
        </main>
        
    </div>
    
</body>
</html>
