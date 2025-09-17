<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Employés - {{ auth()->user()->department->name ?? 'Département' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboards.css') }}">
    <style>
        .staff-table {
            width: 100%;
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-top: 1.5rem;
            overflow: hidden;
        }

        .staff-table thead {
            background-color: #f8fafc;
        }

        .staff-table th,
        .staff-table td {
            padding: 1rem 1.5rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .staff-table th {
            font-weight: 600;
            color: #64748b;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .staff-table tbody tr:hover {
            background-color: #f8fafc;
        }

        .staff-table td {
            color: #1e293b;
            font-size: 0.875rem;
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

        .search-box {
            display: flex;
            align-items: center;
            background-color: white;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            width: 100%;
            max-width: 24rem;
        }

        .search-box i {
            color: #94a3b8;
            margin-right: 0.5rem;
        }

        .search-box input {
            border: none;
            outline: none;
            width: 100%;
            font-size: 0.875rem;
        }

        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .service-tag {
            display: inline-flex;
            align-items: center;
            background-color: #e0f2fe;
            color: #0369a1;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .service-tag i {
            margin-right: 0.375rem;
            font-size: 0.875rem;
        }

        .online-status {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
        }

        .status-dot {
            width: 0.5rem;
            height: 0.5rem;
            border-radius: 50%;
        }

        .dot-online {
            background-color: #22c55e;
        }

        .dot-offline {
            background-color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <main class="main-content" style="margin-left: 0;">
            <div class="page-header">
                <h1 class="page-title">Liste des Employés - {{ auth()->user()->department->name ?? 'Département' }}</h1>
                <div class="breadcrumb">
                    <a href="{{ route('departments.dashboard') }}" class="text-blue-600">Tableau de bord</a> / Employés
                </div>
            </div>

            <div class="header-actions">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Rechercher un employé...">
                </div>
                <a href="{{ route('departments.staff.create') }}" class="btn-primary">
                    <i class="fas fa-user-plus"></i>
                    Ajouter un Employé
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-container">
                <table class="staff-table">
                    <thead>
                        <tr>
                            <th>Matricule</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Service</th>
                            <th>Statut</th>
                            <th>Dernière Activité</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employee)
                            <tr>
                                <td>{{ $employee->matricule }}</td>
                                <td>{{ $employee->name ?? 'Non renseigné' }}</td>
                                <td>{{ $employee->email }}</td>
                                <td>
                                    @if($employee->service)
                                        <span class="service-tag">
                                            <i class="fas fa-sitemap"></i>
                                            {{ $employee->service->name }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">Non assigné</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="online-status">
                                        <span class="status-dot {{ $employee->is_online ? 'dot-online' : 'dot-offline' }}"></span>
                                        {{ $employee->is_online ? 'En ligne' : 'Hors ligne' }}
                                    </div>
                                </td>
                                <td>{{ $employee->last_activity_at ? $employee->last_activity_at->diffForHumans() : 'Jamais' }}</td>
                                <td>
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('staff.show', $employee->id) }}" class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('staff.edit', $employee->id) }}" class="text-yellow-600 hover:text-yellow-800">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('staff.destroy', $employee->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" 
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet employé ?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="flex flex-col items-center justify-center space-y-2">
                                        <i class="fas fa-users text-gray-400 text-4xl"></i>
                                        <p class="text-gray-500">Aucun employé trouvé dans ce département</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        // Fonction de recherche dans le tableau
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const table = document.querySelector('.staff-table');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const cells = row.getElementsByTagName('td');
                let found = false;

                for (let j = 0; j < cells.length; j++) {
                    const cell = cells[j];
                    if (cell.textContent.toLowerCase().indexOf(searchText) > -1) {
                        found = true;
                        break;
                    }
                }

                row.style.display = found ? '' : 'none';
            }
        });
    </script>
</body>
</html>