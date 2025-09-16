<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques des Départements - ZTF Foundation</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f4f6f8;
        color: #333;
        line-height: 1.6;
    }

    .navbar {
        background-color: #fff;
        padding: 1rem 2rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .nav-brand {
        font-size: 1.5rem;
        font-weight: 600;
        color: #2c3e50;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-shrink: 0;
    }

    .nav-brand img {
        height: 40px;
        width: auto;
        object-fit: contain;
        border-radius: 4px;
        transition: transform 0.3s ease;
    }

    .nav-brand img:hover {
        transform: scale(1.05);
    }

    .nav-brand span {
        white-space: nowrap;
    }

    .nav-menu {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .nav-link {
        color: #666;
        text-decoration: none;
        margin-left: 1.5rem;
        font-weight: 500;
    }

    .nav-link:hover {
        color: #3498db;
    }

    .stats-container {
        width: 95%;
        margin: 20px auto;
        padding: 20px;
    }

    .page-title {
        font-size: 24px;
        color: #333;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .stat-card.blue {
        background-color: #E3F2FD;
    }

    .stat-card.green {
        background-color: #E8F5E9;
    }

    .stat-card.yellow {
        background-color: #FFF8E1;
    }

    .stat-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .stat-value {
        font-size: 24px;
        font-weight: bold;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    .data-table th {
        background: #f8f9fa;
        padding: 12px;
        text-align: left;
        font-size: 12px;
        text-transform: uppercase;
        color: #666;
        font-weight: 600;
    }

    .data-table td {
        padding: 12px;
        border-top: 1px solid #eee;
        color: #333;
        font-size: 14px;
    }

    .data-table tr:hover {
        background-color: #f5f5f5;
    }

    .dept-name {
        font-weight: 600;
    }

    .dept-description {
        font-size: 13px;
        color: #666;
    }

    .action-button {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 14px;
        margin-right: 10px;
    }

    .btn-remove {
        background: none;
        border: none;
        color: #dc3545;
        cursor: pointer;
    }

    .btn-remove:hover {
        color: #c82333;
    }

    .btn-details {
        color: #6366f1;
    }

    .btn-assign {
        color: #0d6efd;
    }

    .empty-message {
        text-align: center;
        padding: 20px;
        color: #666;
    }
</style>

    <header class="navbar">
        <a href="/" class="nav-brand">
            <img src="{{ asset('images/CMFI Logo.png') }}" alt="CMCI Logo" title="ZTF Foundation">
            <span>ZTF Foundation</span>
        </a>
        <div class="nav-menu">
            <a href="{{ route('dashboard') }}" class="nav-link">
                <i class="fas fa-chart-line"></i>
                Tableau de bord
            </a>
            <a href="{{ route('departments.index') }}" class="nav-link">
                <i class="fas fa-sitemap"></i>
                Départements
            </a>
            <a href="#" class="nav-link">
                <i class="fas fa-user"></i>
                Mon Profil
            </a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="nav-link" style="background: none; border: none; cursor: pointer;">
                    <i class="fas fa-sign-out-alt"></i>
                    Déconnexion
                </button>
            </form>
        </div>
    </header>

    <div class="stats-container">
    <h1 class="page-title">Statistiques des Départements et leurs Chefs</h1>

    <div class="stats-cards">
        <div class="stat-card blue">
            <div class="stat-title">Total Départements</div>
            <div class="stat-value">{{ $departments->count() }}</div>
        </div>
        <div class="stat-card green">
            <div class="stat-title">Départements avec Chef</div>
            <div class="stat-value">{{ $departments->whereNotNull('head_id')->count() }}</div>
        </div>
        <div class="stat-card yellow">
            <div class="stat-title">Départements sans Chef</div>
            <div class="stat-value">{{ $departments->whereNull('head_id')->count() }}</div>
        </div>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Département</th>
                <th>Chef</th>
                <th>Matricule</th>
                <th>Date d'assignation</th>
                <th>Nombre d'employés</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($departments as $dept)
                <tr>
                    <td>
                        <div class="dept-name">{{ $dept->name }}</div>
                        <div class="dept-description">{{ Str::limit($dept->description, 50) }}</div>
                    </td>
                    <td>{{ optional($dept->head)->name ?? 'Non assigné' }}</td>
                    <td>{{ optional($dept->head)->matricule ?? '-' }}</td>
                    <td>
                        @if($dept->head_assigned_at)
                            {{ $dept->head_assigned_at->format('d/m/Y') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $dept->users_count ?? 0 }} employés</td>
                    <td>
                        @if($dept->head_id)
                            <form action="{{ route('departments.remove.head', $dept->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-button btn-remove">
                                    Retirer
                                </button>
                            </form>
                            <a href="#" class="action-button btn-details">Détails</a>
                        @else
                            <a href="{{ route('departments.assign.head.form') }}" 
                               class="action-button btn-assign">
                                Assigner un chef
                            </a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="empty-message">
                        Aucun département trouvé
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</div>

    <script>
        // Pour la confirmation de suppression
        document.querySelectorAll('.btn-remove').forEach(button => {
            button.addEventListener('click', function(e) {
                if (!confirm('Êtes-vous sûr de vouloir retirer ce chef de département ?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>