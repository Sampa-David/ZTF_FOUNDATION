<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Départements - ZTF Foundation</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboards.css') }}">
    <style>
        .departments-table {
            width: 100%;
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-top: 1.5rem;
            overflow: hidden;
        }

        .departments-table thead {
            background-color: #f8fafc;
        }

        .departments-table th,
        .departments-table td {
            padding: 1rem 1.5rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .departments-table th {
            font-weight: 600;
            color: #64748b;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .departments-table tbody tr:hover {
            background-color: #f8fafc;
        }

        .departments-table td {
            color: #1e293b;
            font-size: 0.875rem;
        }

        .status-badge {
            display: inline-block;
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

        .action-buttons {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .btn-action {
            padding: 0.5rem;
            border-radius: 0.375rem;
            transition: background-color 0.2s;
        }

        .btn-action:hover {
            background-color: #f1f5f9;
        }

        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background-color: var(--primary-color);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: background-color 0.2s;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
        }

        .alert {
            margin: 1rem 0;
            padding: 1rem;
            border-radius: 0.5rem;
            position: relative;
            animation: slideIn 0.5s ease-out;
        }

        .alert-success {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success::before {
            content: '\f058';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 1.25rem;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-1rem);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-dismiss {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.25rem;
            transition: background-color 0.2s;
        }

        .alert-dismiss:hover {
            background-color: rgba(22, 101, 52, 0.1);
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <main class="main-content" style="margin-left: 0;">
            <div class="page-header">
                <h1 class="page-title">Liste des Départements</h1>
                <div class="breadcrumb">Tableau de bord / Départements</div>
            </div>

            <div class="header-actions">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Rechercher un département...">
                </div>
                @if(Auth::user()->isSuperAdmin())
                <a href="{{ route('dashboard') }}" class="btn-primary">
                    <i class="fas fa-plus"></i>
                    Retour au tableau de Bord
                </a>
                @elseif(Auth::user()->isAdmin1())
                <a href="{{ route('committee.dashboard') }}" class="btn-primary">
                    <i class="fas fa-plus"></i>
                    Retour au tableau de Bord
                </a>
                @endif
                <a href="{{ route('departments.create') }}" class="btn-primary">
                    <i class="fas fa-plus"></i>
                    Nouveau Département
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success" role="alert" id="successAlert">
                    <div class="flex-1">{{ session('success') }}</div>
                    <button type="button" class="alert-dismiss" onclick="this.parentElement.style.display='none'">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            <div class="table-container">
                <table class="departments-table">
                    <thead>
                        <tr>
                            <th>Nom du Département</th>
                            <th>Description</th>
                            <th>Chef de Département</th>
                            <th>Nombre d'Employés</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($depts as $dept)
                            <tr>
                                <td>{{ $dept->name }}</td>
                                <td>{{ Str::limit($dept->description, 50) }}</td>
                                <td>{{ $dept->headDepartment ? $dept->headDepartment->matricule : 'Non assigné' }}</td>
                                <td>{{ $dept->users->count() }}</td>
                                <td>
                                    <span class="status-badge {{ $dept->users->count() > 0 ? 'status-active' : 'status-inactive' }}">
                                        {{ $dept->users->count() > 0 ? 'Actif' : 'Inactif' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('departments.show', $dept->id) }}" class="btn-action" title="Voir les détails">
                                            <i class="fas fa-eye text-primary"></i>
                                        </a>
                                        <a href="{{ route('departments.edit', $dept->id) }}" class="btn-action" title="Modifier">
                                            <i class="fas fa-edit text-warning"></i>
                                        </a>
                                        <form action="{{ route('departments.destroy', $dept->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action" style="color: #dc2626; border: none; background: none; cursor: pointer;" 
                                                    onclick="return confirm('Attention ! Cette action supprimera le département et tous ses employés associés. Êtes-vous sûr de vouloir continuer ?')" 
                                                    title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-folder-open text-gray-400 text-3xl mb-3"></i>
                                    <p>Aucun département n'a été créé pour le moment.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        // Auto-hide success message after 5 seconds
        const successAlert = document.getElementById('successAlert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.opacity = '0';
                successAlert.style.transform = 'translateY(-1rem)';
                setTimeout(() => {
                    successAlert.style.display = 'none';
                }, 500);
            }, 5000);
        }

        // Fonction de recherche dans le tableau
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const table = document.querySelector('.departments-table');
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
