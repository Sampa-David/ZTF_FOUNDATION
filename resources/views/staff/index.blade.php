<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Liste des Utilisateurs - ZTF Foundation</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboards.css') }}">
    <style>
        .users-table {
            width: 100%;
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-top: 1.5rem;
            overflow: hidden;
        }

        .users-table thead {
            background-color: #f8fafc;
        }

        .users-table th,
        .users-table td {
            padding: 1rem 1.5rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .users-table th {
            font-weight: 600;
            color: #64748b;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .users-table tbody tr:hover {
            background-color: #f8fafc;
        }

        .users-table td {
            color: #1e293b;
            font-size: 0.875rem;
        }

        .status-indicator {
            display: inline-block;
            width: 0.5rem;
            height: 0.5rem;
            border-radius: 50%;
            margin-right: 0.5rem;
        }

        .status-online {
            background-color: var(--success-color);
        }

        .table-container {
            overflow-x: auto;
            padding: 1rem;
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .search-box {
            display: flex;
            align-items: center;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            width: 300px;
        }

        .search-box input {
            border: none;
            outline: none;
            padding: 0.25rem;
            width: 100%;
            margin-left: 0.5rem;
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
        }

        .refresh-button:hover {
            background-color: var(--secondary-color);
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <main class="main-content" style="margin-left: 0;">
            <div class="page-header">
                <h1 class="page-title">Liste des Utilisateurs</h1>
                <div class="breadcrumb">Tableau de bord / Liste des Utilisateurs</div>
            </div>

            <div class="header-actions">
                <div style="display: flex; gap: 1rem;">
                    
                    <a href="{{ route('committee.dashboard') }}" class="refresh-button">
                        <i class="fas fa-arrow-left"></i>
                        Retour au Dashboard
                    </a>
                    <div class="search-box">
                        <i class="fas fa-search" style="color: #64748b;"></i>
                        <input type="text" placeholder="Rechercher un utilisateur..." id="searchInput">
                    </div>
                </div>
                <button class="refresh-button" onclick="refreshTable()">
                    <i class="fas fa-sync-alt"></i>
                    Actualiser
                </button>
            </div>

            <div class="table-container">
                <form method="POST" action="{{ route('users.update') }}">
                    @csrf
                    <table class="users-table">
                        <thead>
                            <tr>
                                <th>Sélectionner</th>
                                <th>Matricule</th>
                                <th>Email</th>
                                <th>Département</th>
                                <th>Rôle</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(\App\Models\User::all() as $user)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="selected_users[]" value="{{ $user->id }}">
                                    </td>
                                    <td>{{ $user->matricule }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->Departement->name ?? 'Non assigné' }}</td>
                                    <td>
                                        @foreach($user->roles as $role)
                                            <span class="status-badge status-success">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="#" title="Voir le profil" style="color: var(--primary-color); margin-right: 1rem;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" title="Modifier" style="color: var(--warning-color); margin-right: 1rem;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" 
                                           onclick="confirmDelete({{ $user->id }}, '{{ $user->matricule }}')" 
                                           title="Supprimer" 
                                           style="color: var(--danger-color); margin-right: 1rem;">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <a href="{{ route('user.download.pdf', $user->id) }}" 
                                           title="Télécharger le PDF" 
                                           style="color: var(--success-color);" 
                                           target="_blank">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 2rem;">
                                        <i class="fas fa-users" style="font-size: 2rem; color: #64748b; margin-bottom: 1rem;"></i>
                                        <p>Aucun utilisateur trouvé</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div style="margin-top: 1rem; text-align: right;">
                        <button type="submit" class="refresh-button">
                            <i class="fas fa-save"></i>
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Fonction de recherche
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const table = document.querySelector('.users-table');
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

        // Fonction pour actualiser le tableau
        function refreshTable() {
            const refreshIcon = document.querySelector('.refresh-button i');
            refreshIcon.style.transition = 'transform 1s';
            refreshIcon.style.transform = 'rotate(360deg)';
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        }

        // Fonction pour confirmer et exécuter la suppression
        function confirmDelete(userId, matricule) {
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: `Voulez-vous vraiment supprimer l'utilisateur ${matricule} ? Cette action est irréversible.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteUser(userId);
                }
            });
        }

        // Fonction pour effectuer la suppression via AJAX
        function deleteUser(userId) {
            fetch(`/user/${userId}/delete`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Succès !',
                        text: 'L\'utilisateur a été supprimé avec succès.',
                        icon: 'success'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Erreur',
                        text: data.message || 'Une erreur est survenue lors de la suppression.',
                        icon: 'error'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Erreur',
                    text: 'Une erreur est survenue lors de la suppression.',
                    icon: 'error'
                });
                console.error('Erreur:', error);
            });
        }
    </script>
</body>
</html>