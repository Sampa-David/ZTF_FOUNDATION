<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title> {{config('app.name')}} </title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

  <style>
    :root {
      --primary: #4f46e5;
      --primary-dark: #3730a3;
      --danger: #ef4444;
      --success: #16a34a;
      --warning: #f59e0b;
      --secondary: #64748b;

      --bg: #f9fafb;
      --white: #ffffff;
      --text: #111827;
      --text-light: #6b7280;
      --border: #e5e7eb;

      --radius: .875rem;
      --shadow-sm: 0 1px 3px rgba(0,0,0,0.08);
      --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
      --shadow-lg: 0 10px 15px rgba(0,0,0,0.12);
    }

    * { margin:0; padding:0; box-sizing:border-box; }
    body {
      font-family:'Inter',sans-serif;
      background:var(--bg);
      color:var(--text);
      -webkit-font-smoothing:antialiased;
      line-height:1.6;
    }

    .container {
      max-width:1200px;
      margin:0 auto;
      padding:2rem 1rem;
    }

    /* HEADER */
    .page-header {
      background: linear-gradient(135deg,var(--primary),var(--primary-dark));
      border-radius: var(--radius);
      padding:2rem;
      color:white;
      box-shadow:var(--shadow-md);
      margin-bottom:2rem;
    }
    .page-header h1 { font-size:1.75rem;font-weight:700;margin-bottom:.5rem; }
    .breadcrumb { font-size:.9rem;opacity:.9; }
    .breadcrumb a { color:white;text-decoration:none; }
    .breadcrumb a:hover { text-decoration:underline; }

    /* PROFILE */
    .profile {
      display:flex;align-items:center;gap:2rem;
      background:var(--white);
      border-radius:var(--radius);
      padding:2rem;
      box-shadow:var(--shadow-md);
      margin-bottom:2rem;
      transition:.3s ease;
    }
    .profile:hover { transform:translateY(-3px); }
    .avatar {
      width:110px;height:110px;border-radius:50%;
      background:linear-gradient(135deg,var(--primary),var(--primary-dark));
      display:flex;align-items:center;justify-content:center;
      color:white;font-size:2.5rem;flex-shrink:0;
      box-shadow:var(--shadow-sm);
    }
    .profile-info { flex:1; }
    .profile-info h2 { font-size:1.25rem;font-weight:600;margin-bottom:.5rem; }
    .profile-meta { display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:.75rem; }
    .profile-meta div { display:flex;align-items:center;gap:.5rem;color:var(--text-light);font-size:.9rem; }
    .profile-meta i { color:var(--primary); }

    /* GRID */
    .grid { display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:1.5rem; }

    /* CARDS */
    .card {
      background:var(--white);
      border-radius:var(--radius);
      box-shadow:var(--shadow-md);
      padding:1.5rem;
      transition:.3s ease;
      display:flex;flex-direction:column;gap:.75rem;
    }
    .card:hover { transform:translateY(-3px); }
    .card-header { display:flex;justify-content:space-between;align-items:center;padding-bottom:.75rem;margin-bottom:.75rem;border-bottom:1px solid var(--border); }
    .card-header h3 { font-size:1rem;font-weight:600;display:flex;align-items:center;gap:.5rem; }
    .badge { font-size:.75rem;padding:.25rem .75rem;border-radius:999px;font-weight:500; }
    .badge-success { background:#dcfce7;color:#166534; }
    .badge-warning { background:#fef3c7;color:#92400e; }

    /* ACTIVITY */
    .activity { list-style:none;padding:0;margin:0; }
    .activity li { display:flex;align-items:center;gap:.75rem;padding:.75rem 0;border-bottom:1px solid var(--border); }
    .activity li:last-child { border-bottom:none; }
    .activity-icon { width:34px;height:34px;border-radius:50%;background:var(--bg);display:flex;align-items:center;justify-content:center;color:var(--primary);font-size:.9rem; }
    .activity-content h4 { font-size:.9rem;font-weight:500; }
    .activity-content p { font-size:.8rem;color:var(--text-light); }

    /* ACTIONS */
    .actions { display:flex;gap:1rem;flex-wrap:wrap;margin-top:2rem; }
    .btn {
      display:inline-flex;align-items:center;gap:.5rem;
      padding:.75rem 1.25rem;border:none;border-radius:.75rem;
      font-weight:600;font-size:.9rem;cursor:pointer;
      transition:.3s ease;text-decoration:none;
    }
    .btn-primary { background:var(--primary);color:white; }
    .btn-primary:hover { background:var(--primary-dark); }
    .btn-danger { background:var(--danger);color:white; }
    .btn-danger:hover { background:#dc2626; }

    /* RESPONSIVE */
    @media(max-width:768px){
      .profile { flex-direction:column;text-align:center; }
      .avatar { margin-bottom:1rem; }
      .actions { flex-direction:column; }
      .btn { width:100%;justify-content:center; }
    }
  </style>
</head>
<body>
  @include('partials.welcome-message')
  <div class="container">
    <!-- HEADER -->
    <div class="page-header">
      <h1>Mon Espace Personnel</h1>
      <div class="breadcrumb">
        <a href="{{ route('staff.dashboard') }}">Accueil</a> / Espace Personnel
      </div>
    </div>

    <!-- PROFILE -->
    <div class="profile">
      <div class="avatar"><i class="fas fa-user"></i></div>
      <div class="profile-info">
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:.5rem;">
          <h2>{{ Auth::user()->matricule }}</h2>
          <a href="{{ route('profile.edit') }}" class="btn btn-primary"><i class="fas fa-user-edit"></i> Modifier mon profil</a>
        </div>
        <div class="profile-meta">
          <div><i class="fas fa-envelope"></i>{{ Auth::user()->email }}</div>
          <div><i class="fas fa-building"></i>{{ Auth::user()->Departement->name ?? 'Non assigné' }}</div>
          <div><i class="fas fa-user-tie"></i>{{ Auth::user()->roles->isNotEmpty() ? Auth::user()->roles->first()->display_name : 'Non défini' }}</div>
        </div>
      </div>
    </div>

    <!-- GRID -->
    <div class="grid">
      <!-- DEPARTEMENT -->
      <div class="card">
        <div class="card-header">
          <h3><i class="fas fa-building"></i> Mon Département</h3>
          <span class="badge badge-success">Actif</span>
        </div>
        @if(Auth::user()->Departement)
          <p><strong>Nom :</strong> {{ Auth::user()->Departement->name }}</p>
          <p><strong>Chef :</strong> {{ Auth::user()->Departement->headDepartment->matricule ?? 'Non assigné' }}</p>
          <p><strong>Description :</strong> {{ Str::limit(Auth::user()->Departement->description,150) }}</p>
        @else
          <p class="text-gray-500">Vous n'êtes pas encore assigné à un département.</p>
        @endif
      </div>

      <!-- COMPTE -->
      <div class="card">
        <div class="card-header">
          <h3><i class="fas fa-user-shield"></i> État du Compte</h3>
        </div>
        <p><i class="fas fa-clock"></i> Dernière connexion : {{ Auth::user()->last_login_at ? Auth::user()->last_login_at->format('d/m/Y H:i') : 'Jamais' }}</p>
        <p><i class="fas fa-calendar-check"></i> Compte créé le : {{ Auth::user()->created_at->format('d/m/Y H:i:s') }}</p>
        <p><i class="fas fa-shield-alt"></i> Statut : 
          <span class="badge badge-success">{{Auth::user() ? 'Authentifié' : 'Non Authentifié'}}</span>
        </p>
      </div>
    </div>

    <!-- ACTIVITÉS -->
    <div class="card" style="max-width:500px;margin:2rem auto;">
      <div class="card-header">
        <h3><i class="fas fa-history"></i> Activités Récentes</h3>
      </div>
      <ul class="activity">
        <li>
          <div class="activity-icon"><i class="fas fa-sign-in-alt"></i></div>
          <div class="activity-content">
            <h4>Dernière connexion</h4>
            <p>{{ Auth::user()->last_login_at ? Auth::user()->last_login_at->diffForHumans() : 'Jamais' }}</p>
          </div>
        </li>
        <li>
          <div class="activity-icon"><i class="fas fa-user-edit"></i></div>
          <div class="activity-content">
            <h4>Dernière mise à jour du profil</h4>
            <p>{{ Auth::user()->info_updated_at ? Auth::user()->info_updated_at->diffForHumans() : 'Aucune mise à jour' }}</p>
          </div>
        </li>
      </ul>
    </div>

    <!-- ACTIONS -->
    <div class="actions">
      <a href="{{ route('home') }}" class="btn btn-primary"><i class="fas fa-home"></i> Voir le site</a>
      <a href="{{ route('staff.dashboard') }}" class="btn btn-primary"><i class="fas fa-tachometer-alt"></i> Tableau de bord</a>
      <form method="POST" action="{{ route('logout') }}" style="display: inline;">
        @csrf
        <button type="submit" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> Déconnexion</button>
      </form>
    </div>
  </div>
</body>
</html>
