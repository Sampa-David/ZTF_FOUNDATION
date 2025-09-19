<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs - Comité</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .user-list-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin: 20px;
            padding: 20px;
        }

        .filters-section {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            padding: 15px;
            background: #f8fafc;
            border-radius: 6px;
        }

        .search-box {
            flex: 1;
        }

        .filter-box {
            min-width: 200px;
        }

        .user-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .user-table th {
            background: #f8fafc;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border-bottom: 2px solid #e5e7eb;
        }

        .user-table td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
        }

        .user-table tr:hover {
            background: #f9fafb;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-active {
            background: #dcfce7;
            color: #166534;
        }

        .status-inactive {
            background: #fee2e2;
            color: #991b1b;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-view {
            background: #dbeafe;
            color: #1e40af;
        }

        .btn-edit {
            background: #fef3c7;
            color: #92400e;
        }

        .btn-delete {
            background: #fee2e2;
            color: #991b1b;
        }

        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 8px;
        }

        .page-link {
            padding: 8px 12px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            color: #374151;
            text-decoration: none;
        }

        .page-link.active {
            background: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }

        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .btn-add {
            background: #3b82f6;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-add:hover {
            background: #2563eb;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="user-list-container">
        <!-- En-tête -->
        <div class="header-actions">
            <h1 class="text-2xl font-bold text-gray-800">Gestion des Utilisateurs</h1>
            <a href="{{ route('committee.staff.create') }}" class="btn-add">
                <i class="fas fa-plus"></i>
                Ajouter un utilisateur
            </a>
        </div>

        <!-- Section des filtres -->
        <div class="filters-section">
            <div class="search-box">
                <input type="text" 
                       placeholder="Rechercher un utilisateur..." 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="filter-box">
                <select class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Tous les statuts</option>
                    <option value="active">Actif</option>
                    <option value="inactive">Inactif</option>
                </select>
            </div>
            <div class="filter-box">
                <select class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Tous les rôles</option>
                    <option value="admin">Administrateur</option>
                    <option value="staff">Staff</option>
                    <option value="chef_service">Chef de Service</option>
                </select>
            </div>
        </div>

        <!-- Tableau des utilisateurs -->
        <table class="user-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Statut</th>
                    <th>Dernière Connexion</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->isAdmin1())
                                Administrateur
                            @elseif($user->isAdmin2())
                                Chef de Département
                            @elseif($user->isChefService())
                                Chef de Service
                            @else
                                Staff
                            @endif
                        </td>
                        <td>
                            <span class="status-badge {{ $user->is_active ? 'status-active' : 'status-inactive' }}">
                                {{ $user->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td>{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Jamais' }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('committee.staff.show', $user->id) }}" class="btn btn-view">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('committee.staff.edit', $user->id) }}" class="btn btn-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('committee.staff.destroy', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            Aucun utilisateur trouvé
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="pagination">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</body>
</html>