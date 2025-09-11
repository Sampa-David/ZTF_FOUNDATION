<!DOCTYPE html>
@php
    // Débogage des variables
    if (isset($activeUsers)) {
        dd($activeUsers);
    } else {
        dd('$activeUsers n\'est pas défini');
    }
@endphp
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques - ZTF Foundation</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboards.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .stat-card h3 {
            color: #64748b;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        .stat-card .value {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.25rem;
        }

        .stat-card .subtitle {
            font-size: 0.875rem;
            color: #64748b;
        }

        .stat-card .trend {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
        }

        .trend.up {
            color: #16a34a;
        }

        .trend.down {
            color: #dc2626;
        }

        .chart-container {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
        }

        .chart-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        @media (max-width: 1024px) {
            .chart-grid {
                grid-template-columns: 1fr;
            }
        }

        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .date-filter {
            display: flex;
            gap: 1rem;
            align-items: center;
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
            text-decoration: none;
        }

        .refresh-button:hover {
            background-color: var(--secondary-color);
        }

        select, input[type="date"] {
            padding: 0.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            outline: none;
        }
    </style>
</head>
<body>
    
    <div class="dashboard-container">
        <main class="main-content" style="margin-left: 0;">
            <div class="page-header">
                <h1 class="page-title">Statistiques d'Utilisation</h1>
                <div class="breadcrumb">Tableau de bord / Statistiques</div>
            </div>

            <div class="header-actions">
                <div class="date-filter">
                    <a href="{{ route('dashboard') }}" class="refresh-button">
                        <i class="fas fa-arrow-left"></i>
                        Retour au Dashboard
                    </a>
                    <input type="date" id="startDate" onchange="updateStats()">
                    <input type="date" id="endDate" onchange="updateStats()">
                    <select id="timeRange" onchange="updateDateRange()">
                        <option value="week">7 derniers jours</option>
                        <option value="month">30 derniers jours</option>
                        <option value="year">12 derniers mois</option>
                    </select>
                </div>
                <button class="refresh-button" onclick="refreshStats()">
                    <i class="fas fa-sync-alt"></i>
                    Actualiser
                </button>
            </div>

            <!-- Statistiques des utilisateurs actifs -->
            <div class="stats-section">
                <h2 class="section-title">Utilisateurs Actuellement Actifs</h2>
                <div class="active-users-grid">
                    @forelse($activeUsers as $user)
                        <div class="user-card {{ $user['is_online'] ? 'online' : '' }}">
                            <div class="user-info">
                                <div class="user-name">{{ $user['name'] }}</div>
                                <div class="user-meta">
                                    <span class="department">{{ $user['department'] }}</span>
                                    <span class="status-dot"></span>
                                    <span class="session-time">Session: {{ $user['session_duration'] }}</span>
                                </div>
                            </div>
                            <div class="connection-time">
                                Connecté depuis {{ $user['last_login'] }}
                            </div>
                        </div>
                    @empty
                        <div class="no-data">Aucun utilisateur actif actuellement</div>
                    @endforelse
                </div>
            </div>

            <!-- Connexions d'aujourd'hui -->
            <div class="stats-section">
                <h2 class="section-title">Connexions Aujourd'hui</h2>
                <div class="connections-grid">
                    @forelse($todayLogins as $login)
                        <div class="connection-card {{ $login['is_still_active'] ? 'still-active' : '' }}">
                            <div class="user-info">
                                <div class="user-name">{{ $login['name'] }}</div>
                                <div class="user-meta">
                                    <span class="department">{{ $login['department'] }}</span>
                                </div>
                            </div>
                            <div class="login-time">
                                Connexion à {{ $login['login_time'] }}
                            </div>
                        </div>
                    @empty
                        <div class="no-data">Aucune connexion aujourd'hui</div>
                    @endforelse
                </div>
            </div>

            <!-- Temps moyen de session -->
            <div class="stats-section">
                <h2 class="section-title">Temps Moyen de Session par Utilisateur</h2>
                <div class="global-average">
                    Moyenne globale : <span class="highlight">{{ $avgSessionTime['global_average'] }}</span>
                </div>
                <div class="sessions-grid">
                    @forelse($avgSessionTime['sessions'] as $session)
                        <div class="session-card">
                            <div class="user-info">
                                <div class="user-name">{{ $session['name'] }}</div>
                                <div class="user-meta">
                                    <span class="department">{{ $session['department'] }}</span>
                                </div>
                            </div>
                            <div class="average-time">
                                {{ $session['average_time'] }}
                            </div>
                        </div>
                    @empty
                        <div class="no-data">Aucune donnée de session disponible</div>
                    @endforelse
                </div>
            </div>

            <!-- Statistiques globales -->
            <div class="stats-container">
                <div class="stat-card">
                    <h3>Total Utilisateurs</h3>
                    <div class="value">{{ $totalRegistrations ?? 0 }}</div>
                    @if(isset($departmentName))
                        <div class="subtitle">Dans {{ $departmentName }}</div>
                    @endif
                </div>
            </div>

            <div class="chart-grid">
                <div class="chart-container">
                    <h3>Connexions par Jour</h3>
                    <canvas id="loginChart"></canvas>
                </div>
                <div class="chart-container">
                    <h3>Utilisateurs par Département</h3>
                    <canvas id="departmentChart"></canvas>
                </div>
                <div class="chart-container">
                    <h3>Activité par Heure</h3>
                    <canvas id="hourlyActivityChart"></canvas>
                </div>
                <div class="chart-container">
                    <h3>Distribution des Rôles</h3>
                    <canvas id="roleDistributionChart"></canvas>
                </div>
            </div>
        </main>
    </div>

    <script>
        let charts = {
            loginChart: null,
            departmentChart: null,
            roleChart: null,
            serviceChart: null
        };

        // Initialisation des graphiques
        function initCharts(data) {
            // Détruire les graphiques existants si nécessaire
            Object.values(charts).forEach(chart => {
                if (chart) chart.destroy();
            });

            // Graphique des connexions
            charts.loginChart = new Chart(document.getElementById('loginChart'), {
                type: 'line',
                data: {
                    labels: data.userActivity.dates,
                    datasets: [{
                        label: 'Connexions',
                        data: data.userActivity.counts,
                        borderColor: 'rgb(59, 130, 246)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    }
                }
            });

            // Graphique des départements
            charts.departmentChart = new Chart(document.getElementById('departmentChart'), {
                type: 'doughnut',
                data: {
                    labels: data.departmentData.names,
                    datasets: [{
                        data: data.departmentData.counts,
                        backgroundColor: [
                            'rgb(59, 130, 246)',
                            'rgb(16, 185, 129)',
                            'rgb(239, 68, 68)',
                            'rgb(245, 158, 11)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right'
                        }
                    }
                }
            });

            // Graphique de distribution des rôles
            charts.roleChart = new Chart(document.getElementById('roleDistributionChart'), {
                type: 'pie',
                data: {
                    labels: data.roleData.names,
                    datasets: [{
                        data: data.roleData.counts,
                        backgroundColor: [
                            'rgb(59, 130, 246)',
                            'rgb(16, 185, 129)',
                            'rgb(239, 68, 68)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right'
                        }
                    }
                }
            });

            // Graphique des services
            charts.serviceChart = new Chart(document.getElementById('hourlyActivityChart'), {
                type: 'bar',
                data: {
                    labels: data.serviceData.names,
                    datasets: [{
                        label: 'Membres',
                        data: data.serviceData.counts,
                        backgroundColor: 'rgb(59, 130, 246)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }

        // Mise à jour de la plage de dates
        function updateDateRange() {
            const range = document.getElementById('timeRange').value;
            const endDate = new Date();
            const startDate = new Date();

            switch(range) {
                case 'week':
                    startDate.setDate(startDate.getDate() - 7);
                    break;
                case 'month':
                    startDate.setDate(startDate.getDate() - 30);
                    break;
                case 'year':
                    startDate.setDate(startDate.getDate() - 365);
                    break;
            }

            document.getElementById('startDate').value = startDate.toISOString().split('T')[0];
            document.getElementById('endDate').value = endDate.toISOString().split('T')[0];
            updateStats();
        }

        // Mise à jour des statistiques
        function updateStats() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;

            // Appel AJAX pour récupérer les nouvelles données
            fetch(`/api/staff/statistics?start=${startDate}&end=${endDate}`)
                .then(response => response.json())
                .then(data => {
                    // Mise à jour des valeurs des cartes
                    document.querySelector('.stat-card:nth-child(1) .value').textContent = data.activeUsers;
                    document.querySelector('.stat-card:nth-child(2) .value').textContent = data.todayLogins;
                    document.querySelector('.stat-card:nth-child(3) .value').textContent = data.avgSessionTime;
                    document.querySelector('.stat-card:nth-child(4) .value').textContent = data.totalRegistrations;

                    // Réinitialisation des graphiques avec les nouvelles données
                    initCharts(data);
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération des statistiques:', error);
                });
        }

        // Fonction pour actualiser les statistiques
        function refreshStats() {
            const refreshIcon = document.querySelector('.refresh-button i');
            refreshIcon.style.transition = 'transform 1s';
            refreshIcon.style.transform = 'rotate(360deg)';
            updateStats();
            setTimeout(() => {
                refreshIcon.style.transform = 'rotate(0)';
            }, 1000);
        }

        // Données initiales des graphiques
        const initialChartData = @json($chartData ?? null) || {
            'departmentData': {'names': [], 'counts': []},
            'roleData': {'names': [], 'counts': []},
            'serviceData': {'names': [], 'counts': []},
            'userActivity': {'dates': [], 'counts': []}
        };

        // Initialisation
        document.addEventListener('DOMContentLoaded', () => {
            initCharts(initialChartData);
            updateDateRange();
        });
    </script>
</body>
</html>
