<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Créer une permission</title>
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
            max-width: 800px;
            margin: auto;
        }

        h1 {
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .form-container {
            max-width: 800px;
            margin: 2rem auto;
            background: white;
            padding: 2rem;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 500;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            transition: border-color 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(var(--primary-rgb), 0.1);
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .checkbox-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: #f9fafb;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            border: 1px solid #e2e8f0;
        }

        .btn-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
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

        .btn-secondary {
            background-color: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .btn-secondary:hover {
            background-color: #e2e8f0;
        }

        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }
  </style>
</head>
<body>
  <div class="container">
    <h1>Créer une nouvelle permission</h1>

    <div class="form-container">
      <form action="{{ route('permissions.store') }}" method="POST">
        @csrf

        <!-- Nom -->
        <div class="form-group">
          <label class="form-label" for="name">Nom (identifiant technique)</label>
          <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required>
          @error('name')
            <p class="error-message">{{ $message }}</p>
          @enderror
        </div>

        <!-- Nom d'affichage -->
        <div class="form-group">
          <label class="form-label" for="display_name">Nom d'affichage</label>
          <input type="text" id="display_name" name="display_name" class="form-input" value="{{ old('display_name') }}" required>
          @error('display_name')
            <p class="error-message">{{ $message }}</p>
          @enderror
        </div>

        <!-- Description -->
        <div class="form-group">
          <label class="form-label" for="description">Description</label>
          <textarea id="description" name="description" class="form-input form-textarea" required>{{ old('description') }}</textarea>
          @error('description')
            <p class="error-message">{{ $message }}</p>
          @enderror
        </div>

        <!-- Associer à des rôles -->
        <div class="form-group">
          <label class="form-label">Associer à des rôles</label>
          <div class="checkbox-list">
            @foreach($roles as $role)
              <label class="checkbox-item">
                <input type="checkbox" name="roles[]" value="{{ $role->id }}">
                {{ $role->display_name ?? $role->nom }}
              </label>
            @endforeach
          </div>
        </div>

        <!-- Boutons -->
        <div class="btn-group">
          <button type="submit" class="btn btn-primary">Créer</button>
          <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
