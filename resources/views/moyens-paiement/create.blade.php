@extends('layouts.app')

@section('title', 'Nouveau moyen de paiement')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">Ajouter un moyen de paiement</h1>
                <a href="{{ route('moyens-paiement.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('moyens-paiement.store') }}" id="moyenForm">
                        @csrf

                        <div class="mb-3">
                            <label for="id_client" class="form-label">Client <span class="text-danger">*</span></label>
                            <select name="id_client" id="id_client" class="form-select @error('id_client') is-invalid @enderror" required>
                                <option value="">Sélectionnez un client</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id_client }}" {{ old('id_client') == $client->id_client ? 'selected' : '' }}>
                                        {{ $client->nom }} {{ $client->prenom }} - {{ $client->cin }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_client')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="type_moyen" class="form-label">Type de moyen <span class="text-danger">*</span></label>
                            <select name="type_moyen" id="type_moyen" class="form-select @error('type_moyen') is-invalid @enderror" required>
                                <option value="">Sélectionnez un type</option>
                                <option value="carte" {{ old('type_moyen') == 'carte' ? 'selected' : '' }}>Carte bancaire</option>
                                <option value="chequier" {{ old('type_moyen') == 'chequier' ? 'selected' : '' }}>Chéquier</option>
                                <option value="virement_permanent" {{ old('type_moyen') == 'virement_permanent' ? 'selected' : '' }}>Virement permanent</option>
                            </select>
                            @error('type_moyen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3" id="numeroField">
                            <label for="numero" class="form-label">Numéro de carte</label>
                            <input type="text" class="form-control @error('numero') is-invalid @enderror" 
                                   id="numero" name="numero" value="{{ old('numero') }}"
                                   placeholder="1234 5678 9012 3456">
                            @error('numero')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3" id="expirationField">
                            <label for="date_expiration" class="form-label">Date d'expiration</label>
                            <input type="month" class="form-control @error('date_expiration') is-invalid @enderror" 
                                   id="date_expiration" name="date_expiration" value="{{ old('date_expiration') }}">
                            @error('date_expiration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Ajouter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type_moyen');
    const numeroField = document.getElementById('numeroField');
    const expirationField = document.getElementById('expirationField');
    
    function toggleFields() {
        const type = typeSelect.value;
        
        if (type === 'carte') {
            numeroField.style.display = 'block';
            expirationField.style.display = 'block';
            document.getElementById('numero').required = true;
            document.getElementById('date_expiration').required = true;
        } else {
            numeroField.style.display = 'none';
            expirationField.style.display = 'none';
            document.getElementById('numero').required = false;
            document.getElementById('date_expiration').required = false;
        }
    }
    
    typeSelect.addEventListener('change', toggleFields);
    toggleFields(); // Initial call
});
</script>
@endpush
@endsection