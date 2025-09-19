@extends('layouts.app')

@section('content')
<div class="edit-service-container">
    <div class="page-header">
        <div class="header-content">
            <h1>Modifier le service</h1>
            <nav class="breadcrumb">
                <a href="{{ route('departments.dashboard') }}">Tableau de bord</a> /
                <a href="{{ route('departments.services.index', ['department' => $department->id]) }}">Services</a> /
                <span>Modifier {{ $service->name }}</span>
            </nav>
        </div>
    </div>

    <div class="form-card">
        <form action="{{ route('departments.services.update', $service->id) }}" method="POST" class="service-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nom du service <span class="required">*</span></label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $service->name) }}" 
                       required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description du service</label>
                <textarea id="description" 
                          name="description" 
                          class="form-control @error('description') is-invalid @enderror"
                          rows="4">{{ old('description', $service->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="location">Localisation</label>
                <input type="text" 
                       id="location" 
                       name="location" 
                       class="form-control @error('location') is-invalid @enderror"
                       value="{{ old('location', $service->location) }}">
                @error('location')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone">Téléphone</label>
                <input type="tel" 
                       id="phone" 
                       name="phone" 
                       class="form-control @error('phone') is-invalid @enderror"
                       value="{{ old('phone', $service->phone) }}">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email du service</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $service->email) }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-check">
                <input type="checkbox" 
                       id="is_active" 
                       name="is_active" 
                       class="form-check-input"
                       value="1" 
                       {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Service actif</label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Enregistrer les modifications
                </button>
                <a href="{{ route('departments.services.show', $service->id) }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Annuler
                </a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    .edit-service-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    .page-header {
        margin-bottom: 30px;
    }

    .page-header h1 {
        margin: 0;
        font-size: 24px;
        color: #2d3748;
    }

    .breadcrumb {
        margin-top: 5px;
        font-size: 14px;
        color: #718096;
    }

    .breadcrumb a {
        color: #4299e1;
        text-decoration: none;
    }

    .breadcrumb a:hover {
        text-decoration: underline;
    }

    .form-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        padding: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #4a5568;
        font-weight: 500;
    }

    .required {
        color: #e53e3e;
    }

    .form-control {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        font-size: 14px;
        transition: border-color 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: #4299e1;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
    }

    .is-invalid {
        border-color: #e53e3e;
    }

    .invalid-feedback {
        color: #e53e3e;
        font-size: 12px;
        margin-top: 4px;
    }

    .form-check {
        margin: 20px 0;
    }

    .form-check-input {
        margin-right: 8px;
    }

    .form-check-label {
        color: #4a5568;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 30px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 14px;
        cursor: pointer;
        border: none;
        transition: background-color 0.2s;
    }

    .btn-primary {
        background: #4299e1;
        color: white;
    }

    .btn-primary:hover {
        background: #3182ce;
    }

    .btn-secondary {
        background: #edf2f7;
        color: #4a5568;
    }

    .btn-secondary:hover {
        background: #e2e8f0;
    }

    @media (max-width: 768px) {
        .edit-service-container {
            padding: 10px;
        }

        .form-card {
            padding: 20px;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush
@endsection