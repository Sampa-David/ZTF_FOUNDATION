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
                <a href="{{ route('departments.create') }}" class="btn-primary">
                    <i class="fas fa-plus"></i>
                    Nouveau Département
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
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
