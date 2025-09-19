<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> {{config('app.name')}} </title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboards.css') }}">
    <script src="{{ asset('dashboards.js') }}" defer></script>
</head>
<body>
    @if(Auth::user()->isAdmin2())
        @include('partials.welcome-message')
    @endif
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">ZTF FOUNDATION</div>
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-role">
                        @if(Auth::user()->isSuperAdmin())
                            <b>Super Administrateur</b>
                        @elseif(Auth::user()->isAdmin1())
                            <b>Administrateur</b>
                        @elseif(Auth::user()->isAdmin2())
                            <b>Chef de Département</b>
                        @else
                            <b>Utilisateur</b>
                        @endif
                    </div>
                    <div class="user-matricule">{{ Auth::user()->matricule }}</div>
                </div>
            </div>
            <nav>
                <ul class="nav-menu">
                    @if(Auth::user()->department && (Auth::user()->isAdmin2() || Auth::user()->department->head_id === Auth::user()->id))
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
                            <a href="#" class="nav-link" onclick="showSection('historydownloads')">
                                <i class="fas fa-chart-bar"></i>
                                Historique des<br>telechargements
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="showSection('profile')">
                            <i class="fas fa-user-circle"></i>
                            Mon Profil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('home')}}" class="nav-link">
                            <i class="fas fa-home"></i>
                            Voir le site
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
                @if( Auth::user()->department && (Auth::user()->isAdmin2() && Auth::user()->department->head_id === Auth::user()->id))
                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-card-title">Employés du Département</div>
                        <div class="stat-card-value">{{ $departmentUsers ?? '0' }}</div>
                        <div class="stat-card-info">
                            Dans votre département
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-title">Services</div>
                        <div class="stat-card-value">
                            @php
                                $servicesCount = 0;
                                $activeServicesCount = 0;
                                if (Auth::user()->department) {
                                    $servicesCount = Auth::user()->department->services()->count();
                                    $activeServicesCount = Auth::user()->department->services()->where('is_active', true)->count();
                                }
                            @endphp
                            {{ $servicesCount }}
                        </div>
                        <div class="stat-card-info">
                            <span class="active-services">
                                {{ $activeServicesCount }} actifs
                            </span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-title">Département</div>
                        <div class="stat-card-value">
                            {{ Auth::user()->department ? Auth::user()->department->name : 'N/A' }}
                        </div>
                        <div class="stat-card-info">
                            Code: {{ Auth::user()->department ? Auth::user()->department->code : 'N/A' }}
                        </div>
                    </div>
                </div>
                @else
                <div class="no-access-message" style="text-align: center; padding: 2rem; background: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <i class="fas fa-lock" style="font-size: 3rem; color: #718096; margin-bottom: 1rem;"></i>
                    <h2 style="color: #2d3748; margin-bottom: 0.5rem;">Accès Restreint</h2>
                    <p style="color: #718096;">Vous n'êtes pas actuellement chef de ce département. Seul votre profil est accessible.</p>
                </div>
                @endif
                <!-- Quick Actions -->
                <div class="actions-grid">
                    @if(Auth::user()->department && (Auth::user()->isAdmin2() || Auth::user()->isSuperAdmin() || Auth::user()->isAdmin1()))
                        <a href="{{route('departments.staff.create')}}" class="action-card">
                            <i class="fas fa-user-plus action-icon"></i>
                            <h3>Ajouter un employé</h3>
                            <p class="action-desc">Ajouter un nouvel employé au département</p>
                        </a>
                    
                        @if(Auth::user()->department)
                            <a href="{{route('departments.services.create', ['department' => Auth::user()->department->id])}}" class="action-card">
                                <i class="fas fa-folder-plus action-icon"></i>
                                <h3>Nouveau Service</h3>
                                <p class="action-desc">Créer un nouveau service dans le département</p>
                            </a>
                        @endif
                    @endif
                    
                    @if(Auth::user()->department)
                        <a href="{{ route('departments.services.index', ['department' => Auth::user()->department->id]) }}" class="action-card">
                            <i class="fas fa-sitemap action-icon"></i>
                            <h3>Gérer les Services</h3>
                            <p class="action-desc">Voir et gérer tous les services du département</p>
                        </a>
                    @endif

                    <a href="#" class="action-card" onclick="showSection('reports')">
                        <i class="fas fa-chart-line action-icon"></i>
                        <h3>Rapports des Services</h3>
                        <p class="action-desc">Statistiques et rapports détaillés</p>
                    </a>
                </div>
                
                <!-- Services Overview -->
                <div class="services-overview">
                    <div class="section-header">
                        <h2 class="section-title">Aperçu des Services</h2>
                        @if(Auth::user()->department)
                            <a href="{{ route('departments.services.index', ['department' => Auth::user()->department->id]) }}" class="btn btn-primary">
                                <i class="fas fa-external-link-alt"></i> Voir tous les services
                            </a>
                        @endif
                    </div>
                    
                    <div class="services-grid">
                        @if(Auth::user()->department)
                            @forelse(Auth::user()->department->services()->latest()->take(4)->get() as $service)
                                <div class="service-card">
                                    <div class="service-header">
                                        <h3>{{ $service->name }}</h3>
                                        <span class="service-status {{ $service->is_active ? 'active' : 'inactive' }}">
                                            {{ $service->is_active ? 'Actif' : 'Inactif' }}
                                        </span>
                                    </div>
                                    <p class="service-description">
                                        {{ Str::limit($service->description, 100) ?? 'Aucune description' }}
                                    </p>
                                    <div class="service-stats">
                                        <span><i class="fas fa-users"></i> {{ $service->users_count ?? 0 }} employés</span>
                                        @if(Auth::user()->department)
                                            <a href="{{ route('departments.services.show', ['department' => Auth::user()->department->id, 'service' => $service->id]) }}" 
                                               class="btn btn-sm btn-outline">
                                                Détails
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="no-services">
                                    <i class="fas fa-info-circle"></i>
                                    <p>Aucun service n'a encore été créé dans ce département.</p>
                                    @if(Auth::user()->isAdmin2())
                                        <a href="{{ route('departments.services.create', ['department' => Auth::user()->department->id]) }}" 
                                           class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Créer un service
                                        </a>
                                    @endif
                                </div>
                            @endforelse
                        @else
                            <div class="no-services">
                                <i class="fas fa-exclamation-triangle"></i>
                                <p>Vous n'êtes pas encore assigné à un département.</p>
                            </div>
                        @endif
                    </div>
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
                            @forelse($recentActivities ?? [] as $activity)
                                <tr>
                                    <td>{{ $activity->user->name ?? 'Non Renseigne'}}</td>
                                    <td>{{ $activity->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $activity->info_updated_at ? $activity->info_updated_at->format('d/m/Y') : 'N/A' }}</td>
                                    <td>{{ $activity->last_login_at ? $activity->last_login_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                    <td>{{ $activity->last_activity_at ? $activity->last_activity_at->diffForHumans() : 'N/A' }}</td>
                                    <td>
                                        <div class="status-dot {{ $activity->last_activity_at && $activity->last_activity_at->gt(now()->subMinutes(5)) ? 'bg-success' : 'bg-gray' }}"></div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Aucune activité récente</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    <style>
                        /* Styles existants */
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

                        /* Nouveaux styles pour les services */
                        .services-overview {
                            margin-top: 30px;
                        }

                        .section-header {
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            margin-bottom: 20px;
                        }

                        .services-grid {
                            display: grid;
                            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                            gap: 20px;
                            margin-top: 20px;
                        }

                        .service-card {
                            background: white;
                            border-radius: 10px;
                            padding: 20px;
                            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                        }

                        .service-header {
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            margin-bottom: 15px;
                        }

                        .service-header h3 {
                            margin: 0;
                            font-size: 18px;
                            color: #2d3748;
                        }

                        .service-status {
                            padding: 4px 8px;
                            border-radius: 4px;
                            font-size: 14px;
                        }

                        .service-status.active {
                            background: #c6f6d5;
                            color: #2f855a;
                        }

                        .service-status.inactive {
                            background: #fed7d7;
                            color: #c53030;
                        }

                        .service-description {
                            color: #4a5568;
                            margin-bottom: 15px;
                            font-size: 14px;
                        }

                        .service-stats {
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            margin-top: 15px;
                            color: #718096;
                            font-size: 14px;
                        }

                        .btn-sm {
                            padding: 4px 12px;
                            font-size: 14px;
                        }

                        .btn-outline {
                            border: 1px solid #4299e1;
                            color: #4299e1;
                            background: transparent;
                            transition: all 0.2s;
                        }

                        .btn-outline:hover {
                            background: #4299e1;
                            color: white;
                        }

                        .no-services {
                            grid-column: 1 / -1;
                            text-align: center;
                            padding: 40px;
                            background: white;
                            border-radius: 10px;
                            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                        }

                        .no-services i {
                            font-size: 48px;
                            color: #cbd5e0;
                            margin-bottom: 15px;
                        }

                        .active-services {
                            color: #10B981;
                            font-size: 14px;
                        }

                        .btn-primary {
                            background: #4299e1;
                            color: white;
                            padding: 8px 16px;
                            border-radius: 6px;
                            text-decoration: none;
                            display: inline-flex;
                            align-items: center;
                            gap: 8px;
                            transition: background-color 0.2s;
                        }

                        .btn-primary:hover {
                            background: #3182ce;
                        }
                    </style>
                </div>
            </section>
            @if(Auth::user()->department && (Auth::user()->isAdmin2() || Auth::user()->department->head_id === Auth::user()->id))
                <!-- Users Section -->
                <section id="section-users" style="display:none">
                    <div class="page-header">
                        <h1 class="page-title">Gestion des utilisateurs</h1>
                        <div class="breadcrumb">Tableau de bord / Gestion des utilisateurs</div>
                    </div>
                    <div>
                        @include('departments.staff.quickAction')
                    </div>
                </section>

                <!-- Services section -->
                <section id="section-services" style="display:none">
                    <div class="page-header">
                        <h1 class="page-title">Services</h1>
                        <div class="breadcrumb">Tableau de bord / Services</div>
                    </div>
                    <div>
                        @include('departments.services.quickAction')
                    </div>
                </section>

                <!-- Settings Section -->
                <section id="section-settings" style="display:none">
                    <div class="page-header">
                        <h1 class="page-title">Paramètres</h1>
                        <div class="breadcrumb">Tableau de bord / Paramètres</div>
                    </div>
                    @include('departments.partials.settings')
                </section>

                <!-- Reports Section -->
                <section id="section-reports" style="display:none">
                    <div class="page-header">
                        <h1 class="page-title">Rapports</h1>
                        <div class="breadcrumb">Tableau de bord / Rapports</div>
                    </div>
                    <div>
                        @include('departments.partials.pdf-download')
                    </div>
                </section>

                <!-- Downloads Section -->
                <section id="section-historydownloads" style="display:none">
                    <div class="page-header">
                        <h1 class="page-title">Historiques des telechargements</h1>
                        <div class="breadcrumb">Tableau de bord / Historique des telechargements</div>
                    </div>
                    <div>
                        <p>Contenu de l'historique ici</p>
                    </div>
                </section>
            @endif

            <!-- Profile Section - Always visible -->
            <section id="section-profile" style="display:none">
                <div class="page-header">
                    <h1 class="page-title">Mon Profil</h1>
                    <div class="breadcrumb">Tableau de bord / Mon Profil</div>
                </div>
                <div>
                    @include('users.partials.profile-content')
                </div>
            </section>
        </main>
        
    </div>
    
</body>
</html>
