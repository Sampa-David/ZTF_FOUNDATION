<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le département - {{ $department->name }}</title>
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #475569;
            --danger-color: #dc2626;
            --success-color: #16a34a;
            --light-gray: #f1f5f9;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #1e293b;
            background-color: #f8fafc;
            margin: 0;
            padding: 2rem;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .card-header {
            margin-bottom: 2rem;
        }

        .card-title {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--secondary-color);
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .error-message {
            color: var(--danger-color);
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
            border: 1px solid transparent;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
        }

        .btn-secondary {
            background-color: white;
            color: var(--secondary-color);
            border-color: #e2e8f0;
        }

        .btn-secondary:hover {
            background-color: #f8fafc;
        }

        .btn-danger {
            background-color: var(--danger-color);
            color: white;
        }

        .btn-danger:hover {
            background-color: #b91c1c;
        }

        .alert {
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: var(--success-color);
        }

        .alert-danger {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: var(--danger-color);
        }

        .skills-section {
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
        }

        .skills-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .skill-item {
            background: var(--light-gray);
            padding: 0.75rem;
            border-radius: 0.375rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .skill-name {
            font-weight: 500;
        }

        .remove-skill {
            color: var(--danger-color);
            cursor: pointer;
            font-size: 1.25rem;
            line-height: 1;
        }

        .add-skill {
            margin-top: 1rem;
        }

        .input-group {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .input-group .form-input {
            flex: 1;
        }
    </style>
</head>
<body>
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Modifier le département : {{ $department->name }}</h1>
                <p class="text-secondary">Modifiez les informations du département et ses services associés</p>
            </div>

            <form action="{{ route('departments.update', $department) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label" for="name">Nom du département</label>
                    <input type="text" id="name" name="name" class="form-input" 
                           value="{{ old('name', $department->name) }}" required>
                    @error('name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Description</label>
                    <textarea id="description" name="description" class="form-input form-textarea" 
                              required>{{ old('description', $department->description) }}</textarea>
                    @error('description')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="head_id">Chef de département</label>
                    <select id="head_id" name="head_id" class="form-input" required>
                        <option value="">Sélectionner un chef de département</option>
                        @foreach($users ?? [] as $user)
                            <option value="{{ $user->id }}" 
                                {{ old('head_id', $department->head_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name ?? $user->email }}
                            </option>
                        @endforeach
                    </select>
                    @error('head_id')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="skills-section">
                    <h3>Compétences requises</h3>
                    <div class="skills-list">
                        @foreach($department->skills as $skill)
                            <div class="skill-item">
                                <span class="skill-name">{{ $skill->name }}</span>
                                <button type="button" class="remove-skill" 
                                        onclick="removeSkill(this)" data-skill-id="{{ $skill->id }}">&times;</button>
                            </div>
                        @endforeach
                    </div>

                    <div class="add-skill">
                        <h4>Ajouter une compétence</h4>
                        <div class="input-group">
                            <input type="text" class="form-input" id="newSkillName" 
                                   placeholder="Nom de la compétence">
                            <button type="button" class="btn btn-primary" onclick="addSkill()">Ajouter</button>
                        </div>
                    </div>
                </div>

                <div class="actions">
                    <div>
                        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                        <a href="{{ route('departments.show', $department) }}" class="btn btn-secondary">Annuler</a>
                    </div>
                    
                    <form action="{{ route('departments.destroy', $department) }}" 
                          method="POST" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce département ?');"
                          style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer le département</button>
                    </form>
                </div>
            </form>
        </div>

        <div class="card">
            <h2>Services associés</h2>
            <div class="services-list">
                @forelse($department->services as $service)
                    <div class="service-item">
                        <div class="service-info">
                            <h4>{{ $service->name }}</h4>
                            <p>{{ $service->users->count() }} employé(s)</p>
                        </div>
                        <div class="service-actions">
                            <a href="{{ route('services.edit', $service) }}" class="btn btn-secondary">Modifier</a>
                        </div>
                    </div>
                @empty
                    <p>Aucun service associé à ce département</p>
                @endforelse
            </div>
            <div class="actions" style="margin-top: 1rem;">
                <a href="{{ route('services.create', ['department_id' => $department->id]) }}" 
                   class="btn btn-primary">Ajouter un service</a>
            </div>
        </div>
    </div>

    <script>
        function addSkill() {
            const skillName = document.getElementById('newSkillName').value.trim();
            if (!skillName) return;

            const skillsList = document.querySelector('.skills-list');
            const skillItem = document.createElement('div');
            skillItem.className = 'skill-item';
            skillItem.innerHTML = `
                <span class="skill-name">${skillName}</span>
                <input type="hidden" name="skills[]" value="${skillName}">
                <button type="button" class="remove-skill" onclick="removeSkill(this)">&times;</button>
            `;
            
            skillsList.appendChild(skillItem);
            document.getElementById('newSkillName').value = '';
        }

        function removeSkill(button) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette compétence ?')) {
                button.closest('.skill-item').remove();
            }
        }
    </script>
</body>
</html>
