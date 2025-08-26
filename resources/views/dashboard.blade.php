

<x-app-layout>
	<style>
		body {
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
			background: linear-gradient(135deg, #4f46e5, #3b82f6);
			margin: 0;
			padding: 0;
		}
		.dashboard-container {
			display: flex;
			align-items: center;
			justify-content: center;
			min-height: 100vh;
		}
		.dashboard-card {
			background: #fff;
			padding: 2.5rem 3rem 2rem 3rem;
			border-radius: 22px;
			box-shadow: 0 8px 32px rgba(0,0,0,0.18);
			width: 100%;
			max-width: 540px;
			position: relative;
		}
		.dashboard-header {
			display: flex;
			align-items: center;
			gap: 1.2rem;
			margin-bottom: 1.5rem;
		}
		.avatar {
			width: 70px;
			height: 70px;
			border-radius: 50%;
			background: linear-gradient(135deg, #4f46e5 60%, #3b82f6 100%);
			display: flex;
			align-items: center;
			justify-content: center;
			color: #fff;
			font-size: 2.2rem;
			font-weight: bold;
			box-shadow: 0 2px 8px rgba(79,70,229,0.13);
		}
		.header-info h1 {
			font-size: 1.5rem;
			font-weight: bold;
			color: #4f46e5;
			margin: 0 0 0.2rem 0;
		}
		.header-info p {
			color: #6b7280;
			margin: 0;
			font-size: 1rem;
		}
		.user-summary {
			background: #f3f4f6;
			border-radius: 10px;
			padding: 1.2rem 1rem;
			margin-bottom: 1.5rem;
			box-shadow: 0 2px 8px rgba(79,70,229,0.07);
		}
		.user-summary p {
			margin: 0.2rem 0;
			color: #374151;
			font-size: 1rem;
		}
		.dashboard-actions {
			display: flex;
			flex-wrap: wrap;
			gap: 1rem;
			justify-content: center;
			margin-bottom: 1.2rem;
		}
		.dashboard-btn {
			background: linear-gradient(90deg, #4f46e5 60%, #3b82f6 100%);
			color: #fff;
			border: none;
			border-radius: 10px;
			padding: 0.8rem 1.5rem;
			font-size: 1rem;
			font-weight: 600;
			cursor: pointer;
			transition: background 0.3s ease, transform 0.2s;
			text-decoration: none;
			display: inline-block;
			box-shadow: 0 2px 8px rgba(79,70,229,0.09);
		}
		.dashboard-btn:hover {
			background: linear-gradient(90deg, #4338ca 60%, #2563eb 100%);
			transform: translateY(-2px) scale(1.04);
		}
		.logout-link {
			color: #ef4444;
			margin-top: 1.5rem;
			display: block;
			text-align: center;
			font-size: 1rem;
			text-decoration: none;
			font-weight: 500;
			background: none;
			border: none;
			cursor: pointer;
			transition: color 0.2s;
		}
		.logout-link:hover {
			text-decoration: underline;
			color: #b91c1c;
		}
	</style>

	<div class="dashboard-container">
		<div class="dashboard-card">
			<div class="dashboard-header">
				<div class="avatar">
					{{ strtoupper(substr(Auth::user()->name ?? Auth::user()->email ?? 'U', 0, 1)) }}
				</div>
				<div class="header-info">
					<h1>Bienvenue, {{ Auth::user()->name ?? Auth::user()->email ?? 'Utilisateur' }}</h1>
					<p>Votre espace personnel ZTF Foundation</p>
				</div>
			</div>

			<div class="user-summary">
				<p><strong>Matricule :</strong> {{ Auth::user()->matricule ?? '-' }}</p>
				<p><strong>Email :</strong> {{ Auth::user()->email ?? '-' }}</p>
				<p><strong>Date d'inscription :</strong> {{ Auth::user()->created_at ? Auth::user()->created_at->format('d/m/Y') : '-' }}</p>
			</div>

			<div class="dashboard-actions">
				<a href="{{route('profile.edit')}}" class="dashboard-btn">Voir mon profil</a>
				<a href="#" class="dashboard-btn">Mes services</a>
				<a href="#" class="dashboard-btn">Paramètres</a>
			</div>

			<form method="POST" action="{{ route('logout') }}">
				@csrf
				<button type="submit" class="logout-link">Se déconnecter</button>
			</form>
		</div>
	</div>
</x-app-layout>
