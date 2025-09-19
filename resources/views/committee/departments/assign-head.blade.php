<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigner un Chef de Département</title>
    <link href="{{ asset('dashboards.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .assign-head-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .form-header {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e2e8f0;
        }

        .form-header h2 {
            color: #2d3748;
            font-size: 1.5rem;
            margin: 0;
        }

        .department-info {
            background: #f8fafc;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .department-info p {
            margin: 5px 0;
            color: #4a5568;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #4a5568;
            font-weight: 500;
        }

        .form-select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 1rem;
            color: #2d3748;
            background-color: white;
        }

        .form-select:focus {
            outline: none;
            border-color: #4299e1;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
        }

        .user-option {
            padding: 8px;
            border-bottom: 1px solid #e2e8f0;
        }

        .user-option:last-child {
            border-bottom: none;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: opacity 0.2s;
        }

        .btn-primary {
            background: #4299e1;
            color: white;
        }

        .btn-secondary {
            background: #718096;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .alert {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .alert-info {
            background-color: #ebf8ff;
            border: 1px solid #4299e1;
            color: #2b6cb0;
        }
    </style>
</head>
<body>
    <div class="assign-head-container">
        <div class="form-header">
            <h2>Assigner un Chef de Département</h2>
        </div>

        <div class="department-info">
            <p><strong>Département :</strong> {{ $department->name }}</p>
            <p><strong>Code :</strong> {{ $department->code }}</p>
        </div>

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

        @if($eligibleUsers->isEmpty())
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                Aucun utilisateur éligible trouvé. Les chefs de département doivent avoir un matricule au format CM-HQ-CODE-CD.
            </div>
        @else
            <form action="{{ route('departments.head.assign', $department->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="user_id">Sélectionner un Chef de Département</label>
                    <select name="user_id" id="user_id" class="form-select" required>
                        <option value="">-- Choisir un utilisateur --</option>
                        @foreach($eligibleUsers as $user)
                            <option value="{{ $user->id }}" class="user-option">
                                {{ $user->name }} ({{ $user->matricule }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Assigner
                    </button>
                    <a href="{{ route('committee.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                </div>
            </form>
        @endif
    </div>
</body>
</html>