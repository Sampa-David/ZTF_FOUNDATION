<div class="settings-card">
    <h3>
        <i class="fas fa-file-pdf"></i>
        Rapports du Département
    </h3>
    <div class="settings-form">
        <div class="form-group">
            <label class="form-label">Rapport du département</label>
            <p class="text-muted" style="margin-bottom: 1rem;">
                Téléchargez  la liste des services et des ouvriers .
            </p>
            <div style="display: flex; gap: 1rem;">
                <a href="{{ route('departments.pdf.generate') }}" class="btn-save" style="text-decoration: none;">
                    <i class="fas fa-download"></i>
                    Télécharger la liste en PDF
                </a>
                <a href="{{ route('departments.pdf.history') }}" class="btn-save" style="background-color: #64748b; text-decoration: none;">
                    <i class="fas fa-history"></i>
                    Historique des rapports
                </a>
            </div>
        </div>
    </div>
</div>