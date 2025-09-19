@once
    <style>
        .settings-container {
            padding: 2rem;
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-top: 1rem;
        }

        .settings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .settings-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }

        .settings-card:hover {
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transform: translateY(-2px);
        }

        .settings-card h3 {
            color: #1e293b;
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .settings-form {
            margin-top: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            color: #475569;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.625rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-select {
            width: 100%;
            padding: 0.625rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            background-color: white;
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #cbd5e1;
            transition: .4s;
            border-radius: 24px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .toggle-slider {
            background-color: #3b82f6;
        }

        input:checked + .toggle-slider:before {
            transform: translateX(26px);
        }

        .btn-save {
            background-color: #3b82f6;
            color: white;
            padding: 0.625rem 1.25rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-save:hover {
            background-color: #2563eb;
        }

        .settings-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 0.375rem;
        }

        .alert-success {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
    </style>
@endonce

<div class="settings-container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <div class="settings-grid">
        @include('departments.partials.pdf-download')
        
        <!-- Paramètres du Département -->
        <div class="settings-card">
            <h3>
                <i class="fas fa-building"></i>
                Informations du Département
            </h3>
            <form class="settings-form" action="{{ route('departments.update.settings') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nom du département</label>
                    <input type="text" class="form-input" value="{{ $department->name ?? 'Non assigné' }}" readonly>
                </div>
                <div class="form-group">
                    <label class="form-label">Code du département</label>
                    <input type="text" class="form-input" value="{{ $department->code ?? 'Non assigné' }}" readonly>
                </div>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea class="form-input" rows="3" name="description">{{ $department->description ?? '' }}</textarea>
                </div>
                @if(!$department)
                    <div class="alert alert-warning">
                        Vous n'êtes pas encore assigné à un département. Contactez un administrateur.
                    </div>
                @endif
                <button type="submit" class="btn-save">Enregistrer les modifications</button>
            </form>
        </div>

        <!-- Paramètres de Notification -->
        <div class="settings-card">
            <h3>
                <i class="fas fa-bell"></i>
                Notifications
            </h3>
            <form class="settings-form" action="{{ route('departments.update.notifications') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Notifications par email</label>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <label class="toggle-switch">
                            <input type="checkbox" name="email_notifications" checked>
                            <span class="toggle-slider"></span>
                        </label>
                        <span>Activé</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Fréquence des rapports</label>
                    <select class="form-select" name="report_frequency">
                        <option value="daily">Quotidien</option>
                        <option value="weekly">Hebdomadaire</option>
                        <option value="monthly">Mensuel</option>
                    </select>
                </div>
                <button type="submit" class="btn-save">Enregistrer les préférences</button>
            </form>
        </div>

        <!-- Paramètres de Sécurité -->
        <div class="settings-card">
            <h3>
                <i class="fas fa-shield-alt"></i>
                Sécurité
            </h3>
            <form class="settings-form" action="{{ route('departments.update.security') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Authentification à deux facteurs</label>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <label class="toggle-switch">
                            <input type="checkbox" name="two_factor">
                            <span class="toggle-slider"></span>
                        </label>
                        <span>Désactivé</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Session timeout (minutes)</label>
                    <input type="number" class="form-input" name="session_timeout" value="30" min="15" max="120">
                </div>
                <button type="submit" class="btn-save">Mettre à jour la sécurité</button>
            </form>
        </div>

        <!-- Paramètres d'Apparence -->
        <div class="settings-card">
            <h3>
                <i class="fas fa-paint-brush"></i>
                Apparence
            </h3>
            <form class="settings-form" action="{{ route('departments.update.appearance') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Thème</label>
                    <select class="form-select" name="theme">
                        <option value="light">Clair</option>
                        <option value="dark">Sombre</option>
                        <option value="system">Système</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Langue</label>
                    <select class="form-select" name="language">
                        <option value="fr">Français</option>
                        <option value="en">English</option>
                    </select>
                </div>
                <button type="submit" class="btn-save">Appliquer</button>
            </form>
        </div>
    </div>
</div>