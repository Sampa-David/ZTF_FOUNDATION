<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choisir votre département - ZTF Foundation</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --success-color: #2ecc71;
            --error-color: #e74c3c;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
            padding: 2rem;
        }

        .header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .header h1 {
            color: #2d3748;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .header p {
            color: #718096;
            font-size: 0.875rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #4a5568;
            font-weight: 500;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s;
            text-transform: uppercase;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.15);
        }

        .btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s;
        }

        .btn:hover {
            background: var(--secondary-color);
        }

        .error {
            color: var(--error-color);
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .success {
            color: var(--success-color);
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Bienvenue, Chef de Département</h1>
            <p>Veuillez  saisir le code du département dont vous êtes responsable</p>
        </div>

        @if(session('message'))
            <div class="success">
                {{ session('message') }}
            </div>
        @endif

        <form action="{{ route('departments.saveDepts') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="departement">Code du Département</label>
                <input 
                    type="text" 
                    id="departement" 
                    name="departement" 
                    class="form-input @error('departement') border-error @enderror"
                    required 
                    placeholder="Ex: ECSD"
                    value="{{ old('departement') }}"
                >
                @error('departement')
                    <div class="error">{{ $message }}</div>
                @enderror
                <small style="color: #718096; font-size: 0.75rem; margin-top: 0.25rem; display: block;">
                    Le code du département doit être en majuscules (sera automatiquement converti)
                </small>
            </div>

            <button type="submit" class="btn">
                Confirmer mon département
            </button>
        </form>
    </div>

    <script>
        // Auto-uppercase input
        document.getElementById('departement').addEventListener('input', function(e) {
            this.value = this.value.toUpperCase();
        });
    </script>
</body>
</html>