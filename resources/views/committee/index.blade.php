<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Membres du Comité</title>
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #475569;
            --success-color: #16a34a;
            --warning-color: #ca8a04;
            --danger-color: #dc2626;
            --light-gray: #f1f5f9;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            background-color: #f8fafc;
            margin: 0;
            padding: 2rem;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            margin-bottom: 2rem;
        }

        .header-title {
            font-size: 1.875rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .header-subtitle {
            color: var(--secondary-color);
            font-size: 1rem;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--secondary-color);
            font-size: 0.875rem;
        }

        .card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .card-header {
            padding: 1.5rem;
            background-color: var(--light-gray);
            border-bottom: 1px solid #e2e8f0;
        }

        .card-title {
            font-size: 1.25rem;
            color: var(--primary-color);
            margin: 0;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            background-color: var(--light-gray);
            color: var(--secondary-color);
            font-weight: 600;
        }

        tr:hover {
            background-color: #f8fafc;
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-online {
            background-color: #dcfce7;
            color: var(--success-color);
        }

        .badge-offline {
            background-color: #fee2e2;
            color: var(--danger-color);
        }

        .actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
        }

        .btn-secondary {
            background-color: var(--light-gray);
            color: var(--secondary-color);
        }

        .btn-secondary:hover {
            background-color: #e2e8f0;
        }

        .search-box {
            margin-bottom: 1.5rem;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            font-size: 0.875rem;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--secondary-color);
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--light-gray);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="header-title">Membres du Comité</h1>
            <p class="header-subtitle">Liste des utilisateurs avec le matricule CM-HQ-NEH</p>
        </div>

        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-value">{{ $totalMembers ?? 0 }}</div>
                <div class="stat-label">Membres au total</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $activeMembers ?? 0 }}</div>
                <div class="stat-label">Membres actifs</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $onlineMembers ?? 0 }}</div>
                <div class="stat-label">Membres en ligne</div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Liste des membres</h2>
            </div>

            <div class="search-box">
                <input type="text" class="search-input" placeholder="Rechercher un membre..." id="searchInput" onkeyup="searchTable()">
            </div>

            <div class="table-container">
                <table id="membersTable">
                    <thead>
                        <tr>
                            <th>Membre</th>
                            <th>Email</th>
                            <th>Dernière connexion</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members ?? [] as $member)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <div class="avatar">
                                            {{ strtoupper(substr($member->name ?? $member->email, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div style="font-weight: 500;">{{ $member->name ?? 'N/A' }}</div>
                                            <div style="font-size: 0.875rem; color: var(--secondary-color);">
                                                {{ $member->matricule }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $member->email }}</td>
                                <td>
                                    {{ $member->last_login_at ? \Carbon\Carbon::parse($member->last_login_at)->diffForHumans() : 'Jamais' }}
                                </td>
                                <td>
                                    @if($member->is_online)
                                        <span class="badge badge-online">En ligne</span>
                                    @else
                                        <span class="badge badge-offline">Hors ligne</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('users.show', $member->id) }}" class="btn btn-secondary">
                                            Voir détails
                                        </a>
                                        @if(auth()->user()->can('edit_users'))
                                            <a href="{{ route('users.edit', $member->id) }}" class="btn btn-primary">
                                                Modifier
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        Aucun membre du comité trouvé
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
    function searchTable() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const table = document.getElementById('membersTable');
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) { // Start from 1 to skip header
            const cells = rows[i].getElementsByTagName('td');
            let found = false;

            for (let j = 0; j < cells.length; j++) {
                const cell = cells[j];
                if (cell) {
                    const text = cell.textContent || cell.innerText;
                    if (text.toLowerCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }
            }

            rows[i].style.display = found ? '' : 'none';
        }
    }
    </script>
</body>
</html>
