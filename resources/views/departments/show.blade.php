<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $department->name }} - Détails du département</title>
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #475569;
            --success-color: #16a34a;
            --light-gray: #f1f5f9;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #1e293b;
            background-color: #f8fafc;
            margin: 0;
            padding: 2rem;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .department-header {
            background-color: white;
            padding: 2rem;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .department-title {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .department-info {
            color: var(--secondary-color);
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
        }

        .department-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary-color);
        }

        .stat-label {
            color: var(--secondary-color);
            font-size: 0.9rem;
        }

        .services-section {
            margin-top: 2rem;
        }

        .service-card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .service-header {
            background-color: var(--light-gray);
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .service-name {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .service-stats {
            font-size: 0.9rem;
            color: var(--secondary-color);
        }

        .employees-list {
            padding: 1rem 1.5rem;
        }

        .employee-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--light-gray);
        }

        .employee-item:last-child {
            border-bottom: none;
        }

        .employee-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .employee-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--light-gray);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: var(--primary-color);
        }

        .employee-details h4 {
            margin: 0;
            color: var(--secondary-color);
        }

        .employee-details p {
            margin: 0;
            font-size: 0.9rem;
            color: #64748b;
        }

        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-online {
            background-color: #dcfce7;
            color: var(--success-color);
        }

        .no-employees {
            text-align: center;
            padding: 2rem;
            color: var(--secondary-color);
        }

        .actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
        }

        .btn-secondary {
            background-color: white;
            color: var(--secondary-color);
            border: 1px solid #e2e8f0;
        }

        .btn-secondary:hover {
            background-color: #f8fafc;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="department-header">
            <h1 class="department-title">{{ $department->name }}</h1>
            <div class="department-info">
                <p>{{ $department->description }}</p>
            </div>

            <div class="department-stats">
                <div class="stat-card">
                    <div class="stat-number">{{ $department->services->count() }}</div>
                    <div class="stat-label">Services</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $department->users->count() }}</div>
                    <div class="stat-label">Employés</div>
                </div>
                @if($department->skills->count() > 0)
                <div class="stat-card">
                    <div class="stat-number">{{ $department->skills->count() }}</div>
                    <div class="stat-label">Compétences requises</div>
                </div>
                @endif
            </div>

            <div class="actions">
                <a href="{{ route('departments.edit', $department) }}" class="btn btn-primary">Modifier le département</a>
                <a href="{{ route('departments.index') }}" class="btn btn-secondary">Retour à la liste</a>
            </div>
        </div>

        <div class="services-section">
            <h2>Services du département</h2>
            @foreach($department->services as $service)
                <div class="service-card">
                    <div class="service-header">
                        <span class="service-name">{{ $service->name }}</span>
                        <span class="service-stats">
                            {{ $service->users->count() }} employé(s)
                        </span>
                    </div>
                    <div class="employees-list">
                        @if($service->users->count() > 0)
                            @foreach($service->users as $employee)
                                <div class="employee-item">
                                    <div class="employee-info">
                                        <div class="employee-avatar">
                                            {{ strtoupper(substr($employee->name ?? $employee->email, 0, 2)) }}
                                        </div>
                                        <div class="employee-details">
                                            <h4>{{ $employee->name ?? 'N/A' }}</h4>
                                            <p>{{ $employee->email }}</p>
                                        </div>
                                    </div>
                                    <div class="employee-status">
                                        @if($employee->is_online)
                                            <span class="badge badge-online">En ligne</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="no-employees">
                                Aucun employé dans ce service
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

            @if($department->services->count() === 0)
                <div class="no-employees">
                    Aucun service dans ce département
                </div>
            @endif
        </div>
    </div>
</body>
</html>
