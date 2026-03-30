@extends('layouts.app')

@section('title', 'Nouveau compte')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">Créer un nouveau compte</h1>
                <a href="{{ route('comptes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('comptes.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="id_client" class="form-label">Client</label>
                            <select name="id_client" id="id_client" class="form-select @error('id_client') is-invalid @enderror" required>
                                <option value="">Sélectionnez un client</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id_client }}" {{ old('id_client') == $client->id_client ? 'selected' : '' }}>
                                        {{ $client->nom }} {{ $client->prenom }} - {{ $client->email }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_client')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="type_compte" class="form-label">Type de compte</label>
                            <select name="type_compte" id="type_compte" class="form-select @error('type_compte') is-invalid @enderror" required>
                                <option value="">Sélectionnez un type</option>
                                <option value="courant" {{ old('type_compte') == 'courant' ? 'selected' : '' }}>Compte courant</option>
                                <option value="epargne" {{ old('type_compte') == 'epargne' ? 'selected' : '' }}>Compte épargne</option>
                                <option value="joint" {{ old('type_compte') == 'joint' ? 'selected' : '' }}>Compte joint</option>
                            </select>
                            @error('type_compte')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="solde_initial" class="form-label">Solde initial (DH)</label>
                            <input type="number" step="0.01" min="0" 
                                   class="form-control @error('solde_initial') is-invalid @enderror" 
                                   id="solde_initial" name="solde_initial" 
                                   value="{{ old('solde_initial', 0) }}" required>
                            @error('solde_initial')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="date_ouverture" class="form-label">Date d'ouverture</label>
                            <input type="date" class="form-control @error('date_ouverture') is-invalid @enderror" 
                                   id="date_ouverture" name="date_ouverture" 
                                   value="{{ old('date_ouverture', date('Y-m-d')) }}" required>
                            @error('date_ouverture')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Créer le compte
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection