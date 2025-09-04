<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Role - ZTF Foundation</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboards.css') }}">
    <style>
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
            min-height: 150px;
            resize: vertical;
        }

        .form-select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23475569'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1rem;
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

        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <main class="main-content" style="margin-left: 0;">
            <div class="page-header">
                <h1 class="page-title">Créer un Nouveau Role</h1>
                <div class="breadcrumb">
                    <a href="{{ route('roles.index') }}" class="text-blue-600">Roles</a> / Créer
                </div>
            </div>

            <div class="form-container">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="#" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-label">Nom du Role<span class="text-red-500">*</span></label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               class="form-input @error('name') border-red-500 @enderror" 
                               value="{{ old('name') }}" 
                               required 
                               placeholder="Entrez le nom du role">
                        @error('name')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name" class="form-label">Grade du Role<span class="text-red-500">*</span></label>
                        <input type="number" 
                               id="grade" 
                               name="grade" 
                               class="form-input @error('grade') border-red-500 @enderror" 
                               value="{{ old('grade') }}" 
                               required 
                               placeholder="Entrez le grade du role">
                        @error('grade')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    
                    <div class="form-group">
                        <label for="description" class="form-label">Description <span class="text-red-500">*</span></label>
                        <textarea id="description" 
                                  name="description" 
                                  class="form-input form-textarea @error('description') border-red-500 @enderror" 
                                  required 
                                  placeholder="Décrivez les responsabilités qui seront porte par ce role">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="btn-group">
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Retour
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Créer le Role
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        // Ajout de la validation côté client
        document.querySelector('form').addEventListener('submit', function(e) {
            let isValid = true;
            const name = document.getElementById('name');
            const description = document.getElementById('display_name');
            const head_id = document.getElementById('description');

            // Validation du nom
            if (!name.value.trim()) {
                isValid = false;
                name.classList.add('border-red-500');
            } else {
                name.classList.remove('border-red-500');
            }

            // Validation de la description
            if (!description.value.trim()) {
                isValid = false;
                description.classList.add('border-red-500');
            } else {
                description.classList.remove('border-red-500');
            }

            if (!display_name.value.trim()) {
                isValid = false;
                display_name.classList.add('border-red-500');
            } else {
                display_name.classList.remove('border-red-500');
            }
        });
    </script>
</body>
</html>