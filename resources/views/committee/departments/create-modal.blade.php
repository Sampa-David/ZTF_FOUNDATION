<!-- Formulaire de création de département -->
<div id="departmentFormModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Nouveau Département</h2>
            <span class="close" onclick="toggleDepartmentForm()">&times;</span>
        </div>
        <form action="{{ route('departments.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nom du département</label>
                <input type="text" id="name" name="name" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="code">Code du département</label>
                <input type="text" id="code" name="code" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-input" rows="3"></textarea>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="toggleDepartmentForm()">Annuler</button>
                <button type="submit" class="btn btn-primary">Créer le département</button>
            </div>
        </form>
    </div>
</div>

<style>
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    z-index: 1000;
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: white;
    padding: 20px;
    border-radius: 8px;
    width: 90%;
    max-width: 500px;
    position: relative;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.close {
    font-size: 24px;
    cursor: pointer;
    color: #666;
}

.close:hover {
    color: #000;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    color: #4a5568;
    font-weight: 500;
}

.form-input {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 1rem;
}

.form-input:focus {
    outline: none;
    border-color: #4299e1;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 20px;
}

.btn-secondary {
    background: #718096;
    color: white;
}
</style>

<script>
function toggleDepartmentForm() {
    const modal = document.getElementById('departmentFormModal');
    if (modal.style.display === 'none') {
        modal.style.display = 'flex';
        // Empêcher le défilement du body
        document.body.style.overflow = 'hidden';
    } else {
        modal.style.display = 'none';
        // Rétablir le défilement du body
        document.body.style.overflow = 'auto';
    }
}

// Fermer le modal si on clique en dehors
window.onclick = function(event) {
    const modal = document.getElementById('departmentFormModal');
    if (event.target === modal) {
        toggleDepartmentForm();
    }
}
</script>