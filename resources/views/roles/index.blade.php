<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion des rôles</title>
  <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1d4ed8;
            --primary-rgb: 37,99,235;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            margin: 0;
            padding: 2rem;
        }

        .container {
            max-width: 1000px;
            margin: auto;
        }

        h1 {
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
        }

        .table-container {
            background: white;
            padding: 1.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-top: 1rem;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }

        th, td {
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            background-color: #f1f5f9;
            font-weight: 600;
            color: #475569;
        }

        tr:hover td {
            background-color: #f9fafb;
        }

        .actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-secondary {
            background-color: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .btn-secondary:hover {
            background-color: #e2e8f0;
        }

        .btn-danger {
            background-color: #dc2626;
            color: white;
            border: none;
        }

        .btn-danger:hover {
            background-color: #b91c1c;
        }
  </style>
</head>
<body>
  <div class="container">
    <h1>Liste des rôles</h1>

    <a href="{{ route('roles.create') }}" class="btn btn-primary">+ Nouveau rôle</a>
    <a href="{{ route('dashboard') }}" class="btn btn-primary">Retour au dashboard</a>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Nom</th>
            <th>Display Name</th>
            <th>Grade</th>
            <th>Description</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($roles as $role)
          <tr>
            <td>{{ $role->name }}</td>
            <td>{{ $role->display_name }}</td>
            <td>{{ $role->grade }}</td>
            <td>{{ $role->description }}</td>
            <td class="actions">
              <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-secondary">Modifier</a>
              <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Supprimer ce rôle ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Supprimer</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5">Aucun rôle trouvé.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
