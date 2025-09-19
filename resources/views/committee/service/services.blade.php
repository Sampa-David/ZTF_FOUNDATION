@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Services de l'Organisation</h1>
        <div class="flex flex-wrap gap-4 mb-6">
            <div class="stats-card bg-blue-500">
                <div class="stats-value">{{ $totalServices }}</div>
                <div class="stats-label">Services</div>
            </div>
            <div class="stats-card bg-green-500">
                <div class="stats-value">{{ $totalDepartments }}</div>
                <div class="stats-label">Départements</div>
            </div>
            <div class="stats-card bg-purple-500">
                <div class="stats-value">{{ $totalEmployees }}</div>
                <div class="stats-label">Employés</div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm">
        @forelse($services as $departmentName => $departmentServices)
            <div class="department-section mb-8">
                <div class="department-header bg-gray-100 px-6 py-4 border-b">
                    <h2 class="text-xl font-semibold text-gray-800">
                        <i class="fas fa-building mr-2"></i>
                        {{ $departmentName }}
                    </h2>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($departmentServices as $service)
                            <div class="service-card">
                                <div class="service-header">
                                    <i class="fas fa-sitemap service-icon"></i>
                                    <h3 class="service-title">{{ $service->name }}</h3>
                                </div>
                                
                                <div class="service-body">
                                    <div class="service-stat">
                                        <span class="stat-label">Employés :</span>
                                        <span class="stat-value">{{ $service->users->count() }}</span>
                                    </div>
                                    
                                    @if($service->users->isNotEmpty())
                                        <div class="service-employees">
                                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Liste des employés :</h4>
                                            <ul class="employee-list">
                                                @foreach($service->users as $employee)
                                                    <li class="employee-item">
                                                        <span class="employee-name">{{ $employee->name }}</span>
                                                        <span class="employee-role">{{ $employee->roles->first()->name ?? 'Non assigné' }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @else
                                        <p class="text-gray-500 text-sm mt-2">Aucun employé dans ce service</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-8">
                <div class="text-gray-400 text-lg">
                    <i class="fas fa-info-circle mr-2"></i>
                    Aucun service n'a été trouvé
                </div>
            </div>
        @endforelse
    </div>
</div>

<style>
    .stats-card {
        @apply rounded-lg p-4 text-white shadow-sm flex-1 min-w-[200px];
    }
    
    .stats-value {
        @apply text-3xl font-bold mb-1;
    }
    
    .stats-label {
        @apply text-sm opacity-90;
    }

    .service-card {
        @apply bg-white rounded-lg border border-gray-200 overflow-hidden transition-shadow hover:shadow-md;
    }

    .service-header {
        @apply p-4 border-b bg-gray-50 flex items-center gap-3;
    }

    .service-icon {
        @apply text-blue-500 text-xl;
    }

    .service-title {
        @apply text-lg font-semibold text-gray-800;
    }

    .service-body {
        @apply p-4;
    }

    .service-stat {
        @apply flex justify-between items-center mb-4 pb-2 border-b;
    }

    .stat-label {
        @apply text-gray-600;
    }

    .stat-value {
        @apply font-semibold text-gray-800;
    }

    .employee-list {
        @apply space-y-2;
    }

    .employee-item {
        @apply flex justify-between items-center py-1 px-2 rounded hover:bg-gray-50;
    }

    .employee-name {
        @apply text-sm text-gray-700;
    }

    .employee-role {
        @apply text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded;
    }
</style>
@endsection