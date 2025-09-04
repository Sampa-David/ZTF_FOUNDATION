<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs - ZTF Foundation</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* ... Copie le CSS du dashboard sans modification ... */
        :root { --primary-color: #4f46e5; --secondary-color: #818cf8; --success-color: #22c55e; --danger-color: #ef4444; --warning-color: #f59e0b; --info-color: #3b82f6; --dark-color: #1e293b; --light-color: #f8fafc; --sidebar-width: 250px; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background-color: #f1f5f9; color: var(--dark-color); }
        .dashboard-container { display: flex; min-height: 100vh; }
        .sidebar { width: var(--sidebar-width); background-color: white; box-shadow: 4px 0 10px rgba(0,0,0,0.1); padding: 1.5rem; position: fixed; height: 100vh; overflow-y: auto; }
        .sidebar-header { padding-bottom: 1.5rem; border-bottom: 1px solid #e2e8f0; margin-bottom: 1.5rem; }
        .logo { font-size: 1.5rem; font-weight: 700; color: var(--primary-color); text-align: center; margin-bottom: 0.5rem; }
        .user-info { text-align: center; margin-bottom: 1rem; }
        .user-name { font-weight: 600; color: var(--dark-color); }
        .user-role { font-size: 0.875rem; color: #64748b; }
        .nav-menu { list-style: none; }
        .nav-item { margin-bottom: 0.5rem; }
        .nav-link { display: flex; align-items: center; padding: 0.75rem 1rem; color: #64748b; text-decoration: none; border-radius: 0.5rem; transition: all 0.3s ease; }
        .nav-link:hover, .nav-link.active { background-color: #f8fafc; color: var(--primary-color); }
        .nav-link i { width: 1.5rem; margin-right: 0.75rem; }
        .main-content { flex: 1; margin-left: var(--sidebar-width); padding: 2rem; }
        .page-header { margin-bottom: 2rem; }
        .page-title { font-size: 1.875rem; font-weight: 700; color: var(--dark-color); margin-bottom: 0.5rem; }
        .breadcrumb { color: #64748b; font-size: 0.875rem; }
        /* ... Le reste du CSS du dashboard ... */
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">ZTF Foundation</div>
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->name ?? 'Admin Grade 1' }}</div>
                    <div class="user-role">Comite de Nehemie</div>
                </div>
            </div>
            <nav>
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="{{route('dashboard')}}" class="nav-link">
                            <i class="fas fa-home"></i>
                            Tableau de bord
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('index')}}" class="nav-link active">
                            <i class="fas fa-users"></i>
                            Gestion des utilisateurs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-user-shield"></i>
                            Rôles et permissions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-building"></i>
                            Départements
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
                <h1 class="page-title">Gestion des utilisateurs</h1>
                <div class="breadcrumb">Tableau de bord / Gestion des utilisateurs</div>
            </div>
            <!-- Ici tu mets le contenu spécifique à la gestion des utilisateurs -->
            <div>
                <p>Contenu de gestion des utilisateurs ici...</p>
            </div>
        </main>
    </div>
    <script>
        // ... Script du dashboard ...
    </script>
</body>
</html>
