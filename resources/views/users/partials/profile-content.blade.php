@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul style="margin: 0; padding-left: 1rem;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="profile-header">
    <div class="profile-avatar">
        <i class="fas fa-user"></i>
    </div>
    <div class="profile-info">
        <h1>{{ $user->name ?? 'Non renseigne pour le moment' }}</h1>
        <p><i class="fas fa-envelope"></i> {{ $user->email }}</p>
        <p><i class="fas fa-id-badge"></i> {{ $user->matricule }}</p>
    </div>
</div>

<div class="profile-sections">
    <div class="profile-section">
        <h2 class="section-title">Modifier le profil</h2>
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label class="form-label">Nom</label>
                <input type="text" name="name" class="form-input" value="{{ $user->name }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input" value="{{ $user->email }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Contact</label>
                <input type="text" name="phone" class="form-input" value="{{ $user->phone }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour le profil</button>
        </form>
    </div>

    <div class="profile-section">
        <h2 class="section-title">Changer le mot de passe</h2>
        <form action="{{ route('profile.password.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label class="form-label">Mot de passe actuel</label>
                <input type="password" name="current_password" class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label">Nouveau mot de passe</label>
                <input type="password" name="password" class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label">Confirmer le nouveau mot de passe</label>
                <input type="password" name="password_confirmation" class="form-input" required>
            </div>

            <button type="submit" class="btn btn-primary">Changer le mot de passe</button>
        </form>
    </div>
</div>

<style>
.profile-header {
    background: white;
    border-radius: 10px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 2rem;
}

.profile-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: #6c757d;
}

.profile-info h1 {
    font-size: 1.8rem;
    margin-bottom: 0.5rem;
    color: #2c3e50;
}

.profile-info p {
    color: #666;
    margin-bottom: 0.5rem;
}

.profile-sections {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.profile-section {
    background: white;
    border-radius: 10px;
    padding: 2rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.section-title {
    font-size: 1.2rem;
    color: #2c3e50;
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e9ecef;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
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

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 6px;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-primary {
    background-color: #3498db;
    color: white;
}

.btn-primary:hover {
    background-color: #2980b9;
}

.alert {
    padding: 1rem;
    border-radius: 6px;
    margin-bottom: 1rem;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.error-text {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}
</style>