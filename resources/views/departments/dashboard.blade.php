<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Super Admin - ZTF Foundation</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #818cf8;
            --success-color: #22c55e;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #3b82f6;
            --dark-color: #1e293b;
            --light-color: #f8fafc;
            --sidebar-width: 250px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            color: var(--dark-color);
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background-color: white;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
            padding: 1.5rem;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-header {
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 1.5rem;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .user-info {
            text-align: center;
            margin-bottom: 1rem;
        }

        .user-name {
            font-weight: 600;
            color: var(--dark-color);
        }

        .user-role {
            font-size: 0.875rem;
            color: #64748b;
        }

        .nav-menu {
            list-style: none;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #64748b;
            text-decoration: none;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .nav-link:hover, .nav-link.active {
            background-color: #f8fafc;
            color: var(--primary-color);
        }

        .nav-link i {
            width: 1.5rem;
            margin-right: 0.75rem;
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 2rem;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .breadcrumb {
            color: #64748b;
            font-size: 0.875rem;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background-color: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .stat-card-title {
            color: #64748b;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        .stat-card-value {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.25rem;
        }

        .stat-card-change {
            display: flex;
            align-items: center;
            font-size: 0.875rem;
        }

        .stat-card-change.positive {
            color: var(--success-color);
        }

        .stat-card-change.negative {
            color: var(--danger-color);
        }

        /* Quick Actions */
        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .action-card {
            background-color: white;
            border-radius: 0.75rem;
            padding: 1.25rem;
            text-align: center;
            cursor: pointer;
            transition: transform 0.2s;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .action-card:hover {
            transform: translateY(-2px);
        }

        .action-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        /* Recent Activity Table */
        .activity-section {
            background-color: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .activity-table {
            width: 100%;
            border-collapse: collapse;
        }

        .activity-table th,
        .activity-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .activity-table th {
            font-weight: 600;
            color: #64748b;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-success {
            background-color: #dcfce7;
            color: var(--success-color);
        }

        .status-pending {
            background-color: #fef9c3;
            color: var(--warning-color);
        }

        .status-failed {
            background-color: #fee2e2;
            color: var(--danger-color);
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">ZTF Foundation</div>
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->name ?? ' Admin Grade 2 ' }}</div>
                    <div class="user-role">Chef de Department</div>
                </div>
            </div>

            <nav>
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="#" class="nav-link ">
                            <i class="fas fa-home"></i>
                            Tableau de bord
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-users"></i>
                            Gestion des utilisateurs
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-cog"></i>
                            Paramètres
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
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
            <div class="page-header">
                <h1 class="page-title">Tableau de bord</h1>
                <div class="breadcrumb">Accueil / Tableau de bord</div>
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
        </main>
    </div>

    <script>
        // Toggle mobile menu
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.createElement('button');
            menuButton.innerHTML = '<i class="fas fa-bars"></i>';
            menuButton.style.cssText = `
                position: fixed;
                top: 1rem;
                left: 1rem;
                z-index: 1000;
                display: none;
                padding: 0.5rem;
                background: white;
                border: none;
                border-radius: 0.5rem;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                cursor: pointer;
            `;

            document.body.appendChild(menuButton);

            menuButton.addEventListener('click', function() {
                document.querySelector('.sidebar').classList.toggle('active');
            });

            // Show/hide menu button based on screen size
            function checkScreenSize() {
                if (window.innerWidth <= 1024) {
                    menuButton.style.display = 'block';
                } else {
                    menuButton.style.display = 'none';
                    document.querySelector('.sidebar').classList.remove('active');
                }
            }

            window.addEventListener('resize', checkScreenSize);
            checkScreenSize();
        });
    </script>
</body>
</html>
