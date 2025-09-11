<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('dashboards.css')}}">
</head>
<body>
        <div class="actions-grid">
            <a href="{{route('departments.index')}}" class="action-card">
                <i class="fas fa-building"></i> <i class="fas fa-building"></i> <i class="fas fa-building"></i>
                <h3>Liste des Departements Enregistrés</h3>
            </a>
            <a href="{{route('departments.create')}}" class="action-card">
                <i class="fas fa-building"></i><i class="fas fa-plus"></i>

                <h3>Ajouter un Department</h3>
            </a>
            
            <a href="#" class="action-card">
                <i class="fas fa-building"></i><i class="fas fa-plus"></i>

                <h3>Assigner des utilisateur a un </h3>
            </a>
           
            <a href="#" class="action-card">
                <i class="fas fa-chart-line action-icon"></i>
                <h3>Statistiques</h3>
            </a>
        </div>
</body>
</html>