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
                    <div class="user-name">{{ Auth::user()->name ?? ' Admin Grade 1' }}</div>
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
                            <i class="fas fa-arrow-up"></i> +5% cette semaine
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
                            <i class="fas fa-check"></i> 100% actifs
                        </div>
                    </div>
                </div>
                <!-- Quick Actions -->
                <div class="actions-grid">
                    <a href="#" class="action-card">
                        <i class="fas fa-user-plus action-icon"></i>
                        <h3>Ajouter un utilisateur</h3>
                    </a>
                    <a href="#" class="action-card">
                        <i class="fas fa-folder-plus action-icon"></i>
                        <h3>Nouveau département</h3>
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
                                <th>Action</th>
                                <th>Date</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentActivities ?? [] as $activity)
                            <tr>
                                <td>{{ $activity->user_name ?? 'John Doe' }}</td>
                                <td>{{ $activity->action ?? 'Connexion au système' }}</td>
                                <td>{{ $activity->created_at ?? 'Il y a 5 minutes' }}</td>
                                <td>
                                    <span class="status-badge status-success">
                                        {{ $activity->status ?? 'Succès' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td>John Doe</td>
                                <td>Connexion au système</td>
                                <td>Il y a 5 minutes</td>
                                <td><span class="status-badge status-success">Succès</span></td>
                            </tr>
                            <tr>
                                <td>Jane Smith</td>
                                <td>Création d'un nouveau département</td>
                                <td>Il y a 30 minutes</td>
                                <td><span class="status-badge status-success">Succès</span></td>
                            </tr>
                            <tr>
                                <td>Mike Johnson</td>
                                <td>Mise à jour des permissions</td>
                                <td>Il y a 1 heure</td>
                                <td><span class="status-badge status-pending">En cours</span></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
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
