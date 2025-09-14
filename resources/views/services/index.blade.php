<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Services - ZTF Foundation</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #f3f4f6;
            color: #1f2937;
        }

        .page-header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .header-title {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            letter-spacing: 2px;
            text-align: center;
            text-transform: uppercase;
            background: linear-gradient(to right, #ffffff, #f0f0f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: titleGlow 2s ease-in-out infinite alternate;
        }

        @keyframes titleGlow {
            from {
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            }
            to {
                text-shadow: 0 0 8px rgba(255, 255, 255, 0.5);
            }
        }

        .header-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 600px;
            line-height: 1.5;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1rem;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .breadcrumb i {
            font-size: 0.8rem;
        }

        .breadcrumb a {
            color: white;
            text-decoration: none;
            transition: opacity 0.2s;
        }

        .breadcrumb a:hover {
            opacity: 0.8;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #111827;
        }

        .btn-add {
            display: inline-flex;
            align-items: center;
            background-color: #ffffff;
            border: 2px solid #3b82f6;
            color: #3b82f6;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(59, 130, 246, 0.1);
        }

        .btn-add:hover {
            background-color: #3b82f6;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(59, 130, 246, 0.2);
        }

        .btn-add-circle {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            background-color: #3b82f6;
            border-radius: 50%;
            margin-right: 8px;
            color: white;
            font-size: 0.8rem;
            transition: all 0.3s ease;
        }

        .btn-add:hover .btn-add-circle {
            background-color: white;
            color: #3b82f6;
        }

        .btn-add-text {
            margin-left: 4px;
            transition: all 0.3s ease;
        }

        .alert {
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: #d1fae5;
            border: 1px solid #34d399;
            color: #065f46;
        }

        .alert-error {
            background-color: #fee2e2;
            border: 1px solid #f87171;
            color: #dc2626;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        th, td {
            padding: 0.75rem 1rem;
            text-align: left;
        }

        th {
            background-color: #f8fafc;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            color: #4b5563;
            border-bottom: 2px solid #e5e7eb;
        }

        td {
            border-bottom: 1px solid #e5e7eb;
        }

        tr:hover {
            background-color: #f9fafb;
        }

        .actions {
            display: flex;
            gap: 1rem;
        }

        .btn-action {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }

        .btn-edit {
            color: #4f46e5;
        }

        .btn-delete {
            color: #dc2626;
        }

        .btn-view {
            color: #2563eb;
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #6b7280;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 1rem;
            }

            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        }
    </style>
</head>
<body>
    <!-- En-tête de la page -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="header-title">ZTF FOUNDATION</h1>
            <p class="header-subtitle"> Liste des Services et du Personnel</p>
            <div class="breadcrumb">
                <a href="{{ route('departments.dashboard') }}">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
                <i class="fas fa-chevron-right"></i>
                <span>Services</span>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center">
                <div class="w-2 h-12 bg-blue-600 rounded-lg mr-4"></div>
                <h1 class="text-2xl font-bold text-gray-800">Liste des Services</h1>
            </div>
            @if(Auth::user()->isAdmin2() || Auth::user()->isSuperAdmin() || Auth::user()->isAdmin1()|| (str_starts_with(Auth::user()->matricule, 'CM-HQ-') && str_ends_with(Auth::user()->matricule, '-CD')))
                <a href="{{ route('services.create') }}" class="btn-add group">
                    <span class="btn-add-circle">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="btn-add-text">Nouveau Service</span>
                </a>
            @endif
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Nom du Service
                        </th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Description
                        </th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Manager
                        </th>
                        @if(!Auth::user()->isAdmin2())
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Département
                        </th>
                        @endif
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($services as $service)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $service->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ Str::limit($service->description, 100) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $manager = $service->users()
                                        ->where('matricule', 'LIKE', 'MGR-%')
                                        ->first();
                                @endphp
                                {{ $manager ? $manager->name : 'Non assigné' }}
                            </td>
                            @if(!Auth::user()->isAdmin2())
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $service->department->name ?? 'N/A' }}
                            </td>
                            @endif
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    @if(Auth::user()->isAdmin2() && Auth::user()->department_id === $service->department_id)
                                        <a href="{{ route('services.edit', $service->id) }}" 
                                           class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('services.show', $service->id) }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                Aucun service trouvé
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .container {
        max-width: 1200px;
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    th, td {
        text-align: left;
        padding: 12px;
        border-bottom: 1px solid #e2e8f0;
    }

    th {
        background-color: #f8fafc;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
    }

    tr:hover {
        background-color: #f8fafc;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-primary {
        background-color: #3b82f6;
        color: white;
    }

    .btn-primary:hover {
        background-color: #2563eb;
    }

    .action-icon {
        width: 1.25rem;
        height: 1.25rem;
        cursor: pointer;
    }

    .action-icon:hover {
        opacity: 0.75;
    }

    .alert {
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 0.375rem;
    }

    .alert-success {
        background-color: #d1fae5;
        border-color: #34d399;
        color: #065f46;
    }

    .alert-danger {
        background-color: #fee2e2;
        border-color: #f87171;
        color: #dc2626;
    }
</style>
    @if(session('error'))
        <div id="error-toast" class="error-toast" role="alert">
            <div class="error-toast-icon">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <span class="error-toast-message">{{ session('error') }}</span>
        </div>
    @endif

    <style>
        .error-toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background-color: #fff;
            color: #dc2626;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 50;
            border-left: 4px solid #dc2626;
            animation: slideIn 0.3s ease-out forwards;
        }

        .error-toast-icon {
            font-size: 1.25rem;
            color: #dc2626;
        }

        .error-toast-message {
            font-weight: 500;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    </style>

    <script>
        // Animation pour le message d'erreur
        document.addEventListener('DOMContentLoaded', function() {
            const errorToast = document.getElementById('error-toast');
            if (errorToast) {
                setTimeout(() => {
                    errorToast.style.animation = 'slideOut 0.3s ease-out forwards';
                    setTimeout(() => {
                        errorToast.remove();
                    }, 300);
                }, 5000);
            }
        });
    </script>
</body>
</html>
