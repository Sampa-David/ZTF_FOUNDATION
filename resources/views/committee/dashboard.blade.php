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
    @if(Auth::user()->isAdmin1())
        @include('partials.welcome-message')
    @endif
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">ZTF FOUNDATION</div>
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->matricule ?? ' Admin Grade 1'}}</div>
                    <div class="user-role">
                        @if(Auth::user()->isSuperAdmin())
                            Super Administrateur
                        @elseif(Auth::user()->isAdmin1())
                            Administrateur
                        @elseif(Auth::user()->isAdmin2())
                            Chef de Département
                        @else
                            Utilisateur
                        @endif
                    </div>
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
                            <i class="fas fa-sitemap"></i>
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
                        <a href="#" class="nav-link" onclick="showSection('profile')">
                            <i class="fas fa-user-circle"></i>
                            Mon Profil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="showSection('pdf-history')">
                            <i class="fas fa-file-pdf"></i>
                            Historique PDF
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('home')}}" class="nav-link">
                            <i class="fas fa-home"></i>
                            Voir le site
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('committee.dashboard')}}" class="nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            Tableau de bord
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
                    <a href="{{ route('committee.services.list') }}" class="action-card">
                        <i class="fas fa-folder-plus action-icon"></i>
                        <h3>Liste des Services par Departements</h3>
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
                    @include('committee.departments.manage')
                </div>
            </section>
            <!-- Services section -->
            <section id="section-services" style="display:none">
                <div class="page-header">
                    <h1 class="page-title">Services</h1>
                    <div class="breadcrumb">Tableau de bord / Services</div>
                </div>
                <div>
                    @include('committee.services.quickAction')
                </div>
            </section>
            <!-- Settings Section -->
            <section id="section-settings" style="display:none">
                <div class="page-header">
                    <h1 class="page-title">Paramètres</h1>
                    <div class="breadcrumb">Tableau de bord / Paramètres</div>
                </div>
                <div>
                    @include('committee.partials.settings-content')
                </div>
            </section>
            <!-- Reports Section -->
            <section id="section-reports" style="display:none">
                <div class="page-header">
                    <h1 class="page-title">Rapports</h1>
                    <div class="breadcrumb">Tableau de bord / Rapports</div>
                </div>
                <div class="reports-container">
                    <h2 class="section-subtitle">Rapports Administratifs</h2>
                    <div class="reports-grid">
                        <div class="report-card">
                            <div class="report-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h3>Liste des Départements et Chefs</h3>
                            <p>Télécharger la liste complète des départements avec leurs chefs respectifs.</p>
                            <a href="{{ route('committee.pdf.departments-heads') }}" class="btn btn-primary" target="_blank">
                                <i class="fas fa-download"></i> Télécharger
                            </a>
                        </div>

                        <div class="report-card">
                            <div class="report-icon">
                                <i class="fas fa-sitemap"></i>
                            </div>
                            <h3>Départements, Chefs et Services</h3>
                            <p>Télécharger la liste des départements avec leurs chefs et services associés.</p>
                            <a href="{{ route('committee.pdf.departments-heads-services') }}" class="btn btn-primary" target="_blank">
                                <i class="fas fa-download"></i> Télécharger
                            </a>
                        </div>

                        <div class="report-card">
                            <div class="report-icon">
                                <i class="fas fa-user-friends"></i>
                            </div>
                            <h3>Liste Complète des Employés</h3>
                            <p>Télécharger la liste détaillée de tous les employés par département.</p>
                            <a href="{{ route('committee.pdf.departments-employees') }}" class="btn btn-primary" target="_blank">
                                <i class="fas fa-download"></i> Télécharger
                            </a>
                        </div>
                    </div>

                    <h2 class="section-subtitle">Historique des Rapports Départementaux</h2>
                    <div class="reports-history">
                        @foreach($departmentPdfs ?? [] as $pdf)
                            <div class="report-history-card">
                                <div class="report-info">
                                    <div class="report-icon">
                                        <i class="fas fa-file-pdf"></i>
                                    </div>
                                    <div class="report-details">
                                        <h4>{{ basename($pdf) }}</h4>
                                        <p>Généré le {{ \Carbon\Carbon::createFromTimestamp(Storage::lastModified('public/' . $pdf))->format('d/m/Y à H:i') }}</p>
                                    </div>
                                </div>
                                <div class="report-actions">
                                    <a href="{{ Storage::url($pdf) }}" class="btn btn-secondary" target="_blank">
                                        <i class="fas fa-download"></i> Télécharger
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <style>
                    .section-subtitle {
                        font-size: 1.5em;
                        color: #333;
                        margin: 30px 0 20px;
                        padding-bottom: 10px;
                        border-bottom: 2px solid #4a90e2;
                    }
                    .reports-history {
                        margin-top: 20px;
                        display: flex;
                        flex-direction: column;
                        gap: 15px;
                    }
                    .report-history-card {
                        background: white;
                        border-radius: 8px;
                        padding: 15px;
                        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                    }
                    .report-info {
                        display: flex;
                        align-items: center;
                        gap: 15px;
                    }
                    .report-details h4 {
                        margin: 0;
                        color: #333;
                    }
                    .report-details p {
                        margin: 5px 0 0;
                        color: #666;
                        font-size: 0.9em;
                    }
                    .btn-secondary {
                        background-color: #6c757d;
                        color: white;
                        padding: 8px 15px;
                        border-radius: 5px;
                        text-decoration: none;
                        display: inline-flex;
                        align-items: center;
                        gap: 8px;
                        font-size: 0.9em;
                    }
                    .btn-secondary:hover {
                        background-color: #5a6268;
                    }
                </style>

                <style>
                    .reports-container {
                        padding: 20px;
                    }
                    .reports-grid {
                        display: grid;
                        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                        gap: 20px;
                        margin-top: 20px;
                    }
                    .report-card {
                        background: white;
                        border-radius: 10px;
                        padding: 20px;
                        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                        text-align: center;
                        transition: transform 0.2s;
                    }
                    .report-card:hover {
                        transform: translateY(-5px);
                    }
                    .report-icon {
                        font-size: 2em;
                        color: #4a90e2;
                        margin-bottom: 15px;
                    }
                    .report-card h3 {
                        margin: 10px 0;
                        color: #333;
                    }
                    .report-card p {
                        color: #666;
                        margin-bottom: 20px;
                    }
                    .btn-primary {
                        background-color: #4a90e2;
                        color: white;
                        padding: 10px 20px;
                        border-radius: 5px;
                        text-decoration: none;
                        display: inline-flex;
                        align-items: center;
                        gap: 8px;
                        transition: background-color 0.2s;
                    }
                    .btn-primary:hover {
                        background-color: #357abd;
                    }
                </style>
            </section>
            <!-- Profile Section -->
            <section id="section-profile" style="display:none">
                <div class="page-header">
                    <h1 class="page-title">Mon Profil</h1>
                    <div class="breadcrumb">Tableau de bord / Mon Profil</div>
                </div>
                <div>
                    @include('users.partials.profile-content')
                </div>
            </section>

            <!-- PDF History Section -->
            <section id="section-pdf-history" style="display:none">
                <div class="page-header">
                    <h1 class="page-title">
                        <i class="fas fa-file-pdf"></i>
                        Historique des PDFs par département
                    </h1>
                    <div class="breadcrumb">Tableau de bord / Historique PDF</div>
                </div>

                <div class="pdf-history-container">
                    @foreach($departments as $department)
                        <div class="pdf-department-card">
                            <div class="pdf-department-header">
                                <h2>
                                    <i class="fas fa-building"></i>
                                    {{ $department->name }}
                                </h2>
                                <div class="department-info">
                                    <span><i class="fas fa-users"></i> {{ $department->users_count }} utilisateurs</span>
                                    <span><i class="fas fa-sitemap"></i> {{ $department->services_count }} services</span>
                                </div>
                            </div>

                            <div class="pdf-list">
                                @php
                                    $departmentPath = 'pdfs/departments/' . $department->id;
                                    $pdfs = Storage::disk('public')->exists($departmentPath)
                                        ? collect(Storage::disk('public')->files($departmentPath))
                                            ->filter(function($file) {
                                                return pathinfo($file, PATHINFO_EXTENSION) === 'pdf';
                                            })
                                            ->sortByDesc(function($file) {
                                                return Storage::disk('public')->lastModified($file);
                                            })
                                        : collect([]);
                                @endphp

                                @if($pdfs->count() > 0)
                                    <div class="pdf-grid">
                                        @foreach($pdfs as $pdf)
                                            <div class="pdf-item">
                                                <div class="pdf-icon">
                                                    <i class="fas fa-file-pdf"></i>
                                                </div>
                                                <div class="pdf-details">
                                                    <h4>{{ basename($pdf) }}</h4>
                                                    <p>
                                                        <i class="fas fa-calendar"></i>
                                                        {{ \Carbon\Carbon::createFromTimestamp(
                                                            Storage::disk('public')->lastModified($pdf)
                                                        )->format('d/m/Y H:i') }}
                                                    </p>
                                                </div>
                                                <div class="pdf-actions">
                                                    <a href="{{ Storage::disk('public')->url($pdf) }}" 
                                                       target="_blank"
                                                       class="pdf-btn pdf-view">
                                                        <i class="fas fa-eye"></i>
                                                        <span>Voir</span>
                                                    </a>
                                                    <a href="{{ Storage::disk('public')->url($pdf) }}" 
                                                       download
                                                       class="pdf-btn pdf-download">
                                                        <i class="fas fa-download"></i>
                                                        <span>Télécharger</span>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="no-pdf">
                                        <i class="fas fa-folder-open"></i>
                                        <p>Aucun PDF disponible pour ce département</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <style>
                    .pdf-history-container {
                        padding: 20px;
                        display: flex;
                        flex-direction: column;
                        gap: 2rem;
                    }

                    .pdf-department-card {
                        background: white;
                        border-radius: 10px;
                        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                        overflow: hidden;
                    }

                    .pdf-department-header {
                        padding: 1.5rem;
                        background: #f8fafc;
                        border-bottom: 1px solid #e2e8f0;
                    }

                    .pdf-department-header h2 {
                        display: flex;
                        align-items: center;
                        gap: 0.5rem;
                        margin: 0;
                        color: #2d3748;
                        font-size: 1.25rem;
                    }

                    .department-info {
                        margin-top: 0.5rem;
                        display: flex;
                        gap: 1rem;
                        color: #718096;
                        font-size: 0.875rem;
                    }

                    .department-info span {
                        display: flex;
                        align-items: center;
                        gap: 0.5rem;
                    }

                    .pdf-list {
                        padding: 1.5rem;
                    }

                    .pdf-grid {
                        display: grid;
                        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                        gap: 1rem;
                    }

                    .pdf-item {
                        background: #f8fafc;
                        border-radius: 8px;
                        padding: 1rem;
                        display: flex;
                        flex-direction: column;
                        gap: 1rem;
                        transition: transform 0.2s;
                    }

                    .pdf-item:hover {
                        transform: translateY(-2px);
                        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                    }

                    .pdf-icon {
                        font-size: 2rem;
                        color: #e53e3e;
                        text-align: center;
                    }

                    .pdf-details {
                        flex: 1;
                    }

                    .pdf-details h4 {
                        margin: 0;
                        color: #2d3748;
                        font-size: 1rem;
                        font-weight: 500;
                    }

                    .pdf-details p {
                        margin: 0.5rem 0 0;
                        color: #718096;
                        font-size: 0.875rem;
                        display: flex;
                        align-items: center;
                        gap: 0.5rem;
                    }

                    .pdf-actions {
                        display: flex;
                        gap: 0.5rem;
                    }

                    .pdf-btn {
                        flex: 1;
                        display: inline-flex;
                        align-items: center;
                        justify-content: center;
                        gap: 0.5rem;
                        padding: 0.5rem;
                        border-radius: 6px;
                        color: white;
                        text-decoration: none;
                        font-size: 0.875rem;
                        transition: transform 0.2s;
                    }

                    .pdf-view {
                        background-color: #4299e1;
                    }

                    .pdf-download {
                        background-color: #48bb78;
                    }

                    .pdf-btn:hover {
                        transform: translateY(-1px);
                        opacity: 0.9;
                    }

                    .no-pdf {
                        text-align: center;
                        padding: 3rem;
                        color: #718096;
                    }

                    .no-pdf i {
                        font-size: 3rem;
                        margin-bottom: 1rem;
                    }

                    .no-pdf p {
                        margin: 0;
                        font-size: 1.1rem;
                    }

                    @media (max-width: 768px) {
                        .pdf-grid {
                            grid-template-columns: 1fr;
                        }

                        .pdf-item {
                            flex-direction: column;
                            text-align: center;
                        }

                        .pdf-actions {
                            flex-direction: column;
                        }

                        .department-info {
                            flex-direction: column;
                            gap: 0.5rem;
                        }
                    }
                </style>
            </section>
        </main>
        
    </div>
    
</body>
</html>
