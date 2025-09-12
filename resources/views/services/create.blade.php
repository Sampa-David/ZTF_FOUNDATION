@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
        @if (!Auth::user()->isAdmin2() && !Auth::user()->isSuperAdmin() && !Auth::user()->isAdmin1())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Accès non autorisé!</strong>
                <span class="block sm:inline">Seuls les chefs de département peuvent créer des services.</span>
            </div>
        @else
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Créer un nouveau service</h2>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <strong class="font-bold">Erreurs!</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('services.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Nom du service -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nom du service</label>
                    <input type="text" name="name" id="name" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                           value="{{ old('name') }}" required>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3" 
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                              required>{{ old('description') }}</textarea>
                </div>

                <!-- Manager du service -->
                <div>
                    <label for="manager_matricule" class="block text-sm font-medium text-gray-700">Matricule du Manager</label>
                    <input type="text" name="manager_matricule" id="manager_matricule" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                           value="{{ old('manager_matricule') }}" required
                           placeholder="Entrez le matricule du manager">
                    <p class="mt-1 text-sm text-gray-500">
                        Le manager sera automatiquement assigné à ce service.
                    </p>
                </div>

                @if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin1())
                    <!-- Sélection du département (uniquement pour super admin et admin1) -->
                    <div>
                        <label for="department_id" class="block text-sm font-medium text-gray-700">Département</label>
                        <select name="department_id" id="department_id" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" 
                                        {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <!-- Pour les chefs de département, on affiche juste leur département -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Département</label>
                        <div class="mt-1 p-2 bg-gray-100 rounded-md">
                            {{ Auth::user()->department->name ?? 'Non assigné' }}
                        </div>
                    </div>
                @endif

                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('services.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Annuler
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Créer le service
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>

<style>
    .container {
        max-width: 1200px;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }

    label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    input[type="text"],
    textarea,
    select {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
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
        background-color: #4f46e5;
        color: white;
    }

    .btn-primary:hover {
        background-color: #4338ca;
    }

    .error-message {
        color: #dc2626;
        margin-top: 0.25rem;
        font-size: 0.875rem;
    }

    .alert {
        padding: 1rem;
        border-radius: 0.375rem;
        margin-bottom: 1rem;
    }

    .alert-danger {
        background-color: #fee2e2;
        border-color: #fecaca;
        color: #dc2626;
    }
</style>
@endsection
