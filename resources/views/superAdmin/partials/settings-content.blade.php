<div class="settings-container">
    <!-- Paramètres du site -->
    <div class="settings-section">
        <h2 class="settings-title">
            <i class="fas fa-globe"></i>
            Paramètres du site
        </h2>
        <div class="settings-content">
            <form action="{{ route('settings.site.update') }}" method="POST" class="settings-form">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Nom du site</label>
                    <input type="text" name="site_name" value="{{ config('app.name') }}" class="form-input">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="site_description" class="form-input" rows="3">{{ config('app.description') }}</textarea>
                </div>
                <div class="form-group">
                    <label>Email de contact</label>
                    <input type="email" name="contact_email" value="{{ config('mail.from.address') }}" class="form-input">
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
            </form>
        </div>
    </div>

    <!-- Paramètres de sécurité -->
    <div class="settings-section">
        <h2 class="settings-title">
            <i class="fas fa-shield-alt"></i>
            Paramètres de sécurité
        </h2>
        <div class="settings-content">
            <form action="{{ route('settings.security.update') }}" method="POST" class="settings-form">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="toggle-label">
                        <input type="checkbox" name="two_factor_auth" class="toggle-input">
                        <span class="toggle-slider"></span>
                        Authentification à deux facteurs
                    </label>
                </div>
                <div class="form-group">
                    <label class="toggle-label">
                        <input type="checkbox" name="force_password_change" class="toggle-input">
                        <span class="toggle-slider"></span>
                        Forcer le changement de mot de passe après 90 jours
                    </label>
                </div>
                <div class="form-group">
                    <label>Durée de session (minutes)</label>
                    <input type="number" name="session_lifetime" value="120" class="form-input" min="1">
                </div>
                <button type="submit" class="btn btn-primary">Mettre à jour la sécurité</button>
            </form>
        </div>
    </div>

    <!-- Paramètres de notification -->
    <div class="settings-section">
        <h2 class="settings-title">
            <i class="fas fa-bell"></i>
            Paramètres de notification
        </h2>
        <div class="settings-content">
            <form action="{{ route('settings.notifications.update') }}" method="POST" class="settings-form">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="toggle-label">
                        <input type="checkbox" name="email_notifications" class="toggle-input">
                        <span class="toggle-slider"></span>
                        Notifications par email
                    </label>
                </div>
                <div class="form-group">
                    <label class="toggle-label">
                        <input type="checkbox" name="activity_notifications" class="toggle-input">
                        <span class="toggle-slider"></span>
                        Notifications d'activité
                    </label>
                </div>
                <div class="form-group">
                    <label class="toggle-label">
                        <input type="checkbox" name="security_notifications" class="toggle-input">
                        <span class="toggle-slider"></span>
                        Alertes de sécurité
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer les préférences</button>
            </form>
        </div>
    </div>

    <!-- Paramètres de sauvegarde -->
    <div class="settings-section">
        <h2 class="settings-title">
            <i class="fas fa-database"></i>
            Sauvegarde et maintenance
        </h2>
        <div class="settings-content">
            <div class="backup-actions">
                <button class="btn btn-secondary" onclick="triggerBackup()">
                    <i class="fas fa-download"></i>
                    Créer une sauvegarde
                </button>
                <button class="btn btn-secondary" onclick="clearCache()">
                    <i class="fas fa-broom"></i>
                    Nettoyer le cache
                </button>
                <button class="btn btn-danger" onclick="confirmMaintenance()">
                    <i class="fas fa-tools"></i>
                    Mode maintenance
                </button>
            </div>
            <div class="backup-list">
                <h3>Sauvegardes récentes</h3>
                <table class="backup-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Taille</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Liste des sauvegardes -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.settings-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    padding: 1rem;
}

.settings-section {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    overflow: hidden;
}

.settings-title {
    background: #f8f9fa;
    padding: 1rem;
    margin: 0;
    font-size: 1.2rem;
    color: #2c3e50;
    border-bottom: 1px solid #e9ecef;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.settings-content {
    padding: 1.5rem;
}

.settings-form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.form-group {
    margin-bottom: 1rem;
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
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 1rem;
    transition: border-color 0.2s;
}

.form-input:focus {
    outline: none;
    border-color: #3498db;
}

.toggle-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
}

.toggle-input {
    display: none;
}

.toggle-slider {
    width: 48px;
    height: 24px;
    background-color: #e74c3c;  /* Rouge pour l'état inactif */
    border-radius: 12px;
    position: relative;
    transition: 0.3s;
    cursor: pointer;
}

.toggle-slider:before {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background-color: #e74c3c;
    top: 2px;
    left: 2px;
    transition: 0.3s;
}

.toggle-input:checked + .toggle-slider::before {
    background-color: #2ecc71;  /* Vert pour l'état actif */
}

.toggle-input:checked + .toggle-slider:before {
    transform: translateX(24px);
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 6px;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-primary {
    background-color: #3498db;
    color: white;
}

.btn-primary:hover {
    background-color: #2980b9;
}

.btn-secondary {
    background-color: #f8f9fa;
    color: #2c3e50;
    border: 1px solid #e9ecef;
}

.btn-secondary:hover {
    background-color: #e9ecef;
}

.btn-danger {
    background-color: #e74c3c;
    color: white;
}

.btn-danger:hover {
    background-color: #c0392b;
}

.backup-actions {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.backup-table {
    width: 100%;
    border-collapse: collapse;
}

.backup-table th,
.backup-table td {
    padding: 0.75rem;
    text-align: left;
    border-bottom: 1px solid #e9ecef;
}

.backup-table th {
    font-weight: 600;
    color: #4a5568;
    background-color: #f8f9fa;
}

@media (max-width: 768px) {
    .settings-container {
        grid-template-columns: 1fr;
    }

    .backup-actions {
        flex-direction: column;
    }

    .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
// Gestion des toggles
document.addEventListener('DOMContentLoaded', function() {
    const toggleInputs = document.querySelectorAll('.toggle-input');
    
    // Initialiser l'état des toggles au chargement
    toggleInputs.forEach(input => {
        const slider = input.nextElementSibling;
        slider.style.backgroundColor = input.checked ? '#2ecc71' : '#e74c3c';
    });

    // Gérer les changements d'état
    toggleInputs.forEach(input => {
        input.addEventListener('change', function() {
            const slider = this.nextElementSibling;
            if (this.checked) {
                slider.style.backgroundColor = '#2ecc71';  // Vert pour actif
            } else {
                slider.style.backgroundColor = '#e74c3c';  // Rouge pour inactif
            }
        });
    });
});

function triggerBackup() {
    if(confirm('Voulez-vous créer une nouvelle sauvegarde ?')) {
        // Logique de sauvegarde
        alert('Sauvegarde en cours...');
    }
}

function clearCache() {
    if(confirm('Voulez-vous nettoyer le cache du système ?')) {
        // Logique de nettoyage du cache
        alert('Nettoyage du cache en cours...');
    }
}

function confirmMaintenance() {
    if(confirm('Voulez-vous activer le mode maintenance ? Le site sera inaccessible aux utilisateurs.')) {
        // Logique de mode maintenance
        alert('Activation du mode maintenance...');
    }
}
</script>