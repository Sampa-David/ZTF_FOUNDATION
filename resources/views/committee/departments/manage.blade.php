<div class="departments-management">
    <div class="section-header">
        <h2>Gestion des Départements</h2>
        <button class="btn btn-primary" onclick="toggleDepartmentForm()">
            <i class="fas fa-plus"></i> Nouveau Département
        </button>
    </div>

    @include('committee.departments.create-modal')
    <!-- Modal pour assigner un chef de département -->
    <div id="assignHeadModal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Assigner un Chef de Département</h3>
                <button type="button" class="close-button" onclick="toggleAssignHeadModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="assignHeadForm" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="user_id">Sélectionner un employé</label>
                        <select name="user_id" id="user_id" class="form-control" required>
                            <option value="">Choisir un employé...</option>
                            @foreach($availableUsers ?? [] as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->matricule }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="toggleAssignHeadModal()">
                            <i class="fas fa-times"></i> Annuler
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check"></i> Confirmer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Liste des départements -->
    <div class="departments-grid">
        @foreach($departments ?? [] as $department)
            <div class="department-card">
                <div class="department-header">
                    <h3>{{ $department->name }}</h3>
                    <span class="department-code">{{ $department->code }}</span>
                </div>

                <div class="department-info">
                    <p>{{ $department->description }}</p>
                    
                    <div class="department-stats">
                        <div class="stat">
                            <i class="fas fa-users"></i>
                            <span>{{ $department->users_count ?? 0 }} employés</span>
                        </div>
                        <div class="stat">
                            <i class="fas fa-building"></i>
                            <span>{{ $department->services_count ?? 0 }} services</span>
                        </div>
                    </div>

                    <div class="head-info">
                        <h4>Chef de département</h4>
                        @if($department->head)
                            <div class="current-head">
                                <div class="head-details">
                                    <i class="fas fa-user-tie"></i>
                                    <span>{{ $department->head->name }}</span>
                                </div>
                                <div class="head-since">
                                    Depuis le {{ $department->head_assigned_at->format('d/m/Y') }}
                                </div>
                            </div>
                            <form action="{{ route('departments.head.remove', $department->id) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Êtes-vous sûr de vouloir retirer ce chef de département ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-user-minus"></i> Retirer
                                </button>
                            </form>
                        @else
                            <div class="no-head">
                                <p><i class="fas fa-exclamation-triangle"></i> Aucun chef assigné</p>
                                <button onclick="openAssignHeadModal('{{ $department->id }}')" 
                                        class="btn btn-primary btn-sm">
                                    <i class="fas fa-user-plus"></i> Assigner un chef
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="department-actions">
                    <a href="{{ route('departments.show', $department->id) }}" class="btn btn-info btn-sm">
                        <i class="fas fa-eye"></i> Détails
                    </a>
                    <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <form action="{{ route('departments.destroy', $department->id) }}" 
                          method="POST" 
                          class="d-inline"
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce département ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    /* Styles pour le modal */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal-content {
    background-color: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    width: 90%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
}

.modal-header {
    padding: 1.25rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(to right, #4299e1, #3182ce);
    border-radius: 12px 12px 0 0;
}

.modal-header h3 {
    color: white;
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0;
}

.close-button {
    background: none;
    border: none;
    color: white;
    font-size: 1.25rem;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 6px;
    transition: background-color 0.2s;
}

.close-button:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

.modal-body {
    padding: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    color: #2d3748;
    font-weight: 500;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 0.95rem;
    color: #2d3748;
    transition: border-color 0.2s;
}

.form-control:focus {
    outline: none;
    border-color: #4299e1;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.15);
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 2rem;
}

/* Styles pour les boutons */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.625rem 1rem;
    border-radius: 6px;
    font-weight: 500;
    font-size: 0.875rem;
    cursor: pointer;
    border: none;
    transition: all 0.2s ease;
    text-decoration: none;
    white-space: nowrap;
}
.departments-management {
    padding: 2rem;
    background-color: #f8fafc;
    min-height: 100vh;
    max-width: 1440px;
    margin: 0 auto;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: white;
    border-radius: 10px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.section-header h2 {
    font-size: 1.75rem;
    color: #1a202c;
    font-weight: 600;
    position: relative;
}

.section-header h2::after {
    content: '';
    position: absolute;
    bottom: -1rem;
    left: 0;
    width: 50px;
    height: 3px;
    background: #4299e1;
    border-radius: 2px;
}

.departments-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr); /* Fixé à 2 colonnes */
    gap: 2rem;
    padding: 1rem;
    width: 100%;
    max-width: 100%;
}

.department-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid #e2e8f0;
    display: flex;
    flex-direction: column;
    height: 100%;
    position: relative;
}

.department-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.department-header {
    padding: 1.25rem;
    background: linear-gradient(to right, #4299e1, #3182ce);
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.department-header h3 {
    margin: 0;
    font-size: 1.25rem;
    color: white;
    font-weight: 600;
}

.department-code {
    padding: 0.5rem 1rem;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    font-size: 0.875rem;
    color: white;
    font-weight: 500;
    backdrop-filter: blur(4px);
}

.department-info {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.department-info p {
    color: #4a5568;
    line-height: 1.6;
    font-size: 0.95rem;
    margin: 0;
}

.department-stats {
    display: flex;
    justify-content: space-between;
    padding: 1rem 1.5rem;
    background: #f7fafc;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    margin: 0.5rem 0;
}

.stat {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #2d3748;
    font-size: 0.95rem;
}

.stat i {
    padding: 0.5rem;
    background: #ebf8ff;
    border-radius: 8px;
    color: #3182ce;
}

.head-info {
    padding: 1.25rem;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    margin-top: auto;
}

.head-info h4 {
    font-size: 1rem;
    color: #2d3748;
    margin-bottom: 1rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.current-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem;
    background: #f8fafc;
    border-radius: 6px;
    margin: 0.5rem 0;
}

.head-details {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #2d3748;
}

.head-details i {
    color: #3182ce;
}

.head-since {
    font-size: 0.875rem;
    color: #718096;
    padding: 0.25rem 0.75rem;
    background: #edf2f7;
    border-radius: 15px;
}

.no-head {
    background: #fff5f5;
    border-radius: 8px;
    padding: 1.5rem;
    text-align: center;
    border: 1px dashed #fc8181;
}

.no-head p {
    color: #c53030;
    margin-bottom: 1rem;
    font-weight: 500;
}

.no-head p i {
    margin-right: 0.5rem;
}

.department-actions {
    padding: 1rem;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.75rem;
    margin-top: auto;
}

/* Boutons améliorés */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.625rem 1rem;
    border-radius: 6px;
    font-weight: 500;
    font-size: 0.875rem;
    cursor: pointer;
    border: none;
    transition: all 0.2s ease;
    text-decoration: none;
    white-space: nowrap;
}

.btn-sm {
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
}

.btn i {
    font-size: 0.95rem;
}

.btn-primary {
    background: linear-gradient(to right, #4299e1, #3182ce);
    color: white;
}

.btn-info {
    background: linear-gradient(to right, #4299e1, #3182ce);
    color: white;
}

.btn-warning {
    background: linear-gradient(to right, #ecc94b, #d69e2e);
    color: #744210;
}

.btn-danger {
    background: linear-gradient(to right, #f56565, #e53e3e);
    color: white;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.btn:active {
    transform: translateY(0);
}

/* Responsive design amélioré */
/* Responsive Design */
@media (max-width: 1200px) {
    .departments-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }
}

@media (max-width: 992px) {
    .departments-management {
        padding: 1.5rem;
    }
    
    .departments-grid {
        grid-template-columns: 1fr;
        max-width: 700px;
        margin: 0 auto;
    }
}

@media (max-width: 768px) {
    .departments-management {
        padding: 1rem;
    }

    .section-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
        padding: 1rem;
    }

    .department-card {
        margin: 0 auto;
        width: 100%;
        max-width: 500px;
    }

    .department-stats {
        flex-direction: column;
        gap: 0.75rem;
    }

    .stat {
        justify-content: center;
    }

    .current-head {
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 0.75rem;
    }

    .head-since {
        width: 100%;
        text-align: center;
    }

    .department-actions {
        grid-template-columns: 1fr;
    }

    .btn {
        width: 100%;
        padding: 0.75rem;
    }
}

@media (max-width: 480px) {
    .departments-management {
        padding: 0.5rem;
    }

    .department-header {
        flex-direction: column;
        gap: 0.5rem;
        text-align: center;
    }

    .department-code {
        width: 100%;
        text-align: center;
    }
}
</style>

<script>
function toggleDepartmentForm() {
    const modal = document.getElementById('departmentFormModal');
    if (modal) {
        const currentDisplay = window.getComputedStyle(modal).display;
        if (currentDisplay === 'none') {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden'; // Empêcher le défilement
        } else {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto'; // Rétablir le défilement
        }
    }
}

// Fermer le modal si on clique en dehors
// Gestion des modals
document.addEventListener('DOMContentLoaded', function() {
    // Gestion du modal département
    const departmentModal = document.getElementById('departmentFormModal');
    if (departmentModal) {
        departmentModal.addEventListener('click', function(event) {
            if (event.target === departmentModal) {
                toggleDepartmentForm();
            }
        });
    }

    // Gestion du modal chef de département
    const headModal = document.getElementById('assignHeadModal');
    if (headModal) {
        headModal.addEventListener('click', function(event) {
            if (event.target === headModal) {
                toggleAssignHeadModal();
            }
        });

        const form = document.getElementById('assignHeadForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const departmentId = form.getAttribute('data-department-id');
                const formAction = `${window.location.origin}/departments/${departmentId}/head/assign`;
                form.action = formAction;
                form.submit();
            });
        }
    }

    // Gestion de la touche Echap pour tous les modals
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            if (departmentModal && window.getComputedStyle(departmentModal).display !== 'none') {
                toggleDepartmentForm();
            }
            if (headModal && window.getComputedStyle(headModal).display !== 'none') {
                toggleAssignHeadModal();
            }
        }
    });
});

// Fonction pour ouvrir le modal d'assignation de chef
function openAssignHeadModal(departmentId) {
    const modal = document.getElementById('assignHeadModal');
    const form = document.getElementById('assignHeadForm');
    if (modal && form) {
        form.setAttribute('data-department-id', departmentId);
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

// Fonction pour fermer le modal d'assignation de chef
function toggleAssignHeadModal() {
    const modal = document.getElementById('assignHeadModal');
    if (modal) {
        const currentDisplay = window.getComputedStyle(modal).display;
        if (currentDisplay === 'none') {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        } else {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    }
}
</script>