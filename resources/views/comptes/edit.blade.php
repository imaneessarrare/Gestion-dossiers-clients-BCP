@extends('layouts.app')

@section('title', 'Modifier le compte')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">Modifier le compte</h1>
                <a href="{{ route('comptes.show', $compte) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('comptes.update', $compte) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Client</label>
                            <input type="text" class="form-control" 
                                   value="{{ $compte->client->nom }} {{ $compte->client->prenom }}" readonly disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Numéro de compte</label>
                            <input type="text" class="form-control" value="{{ $compte->numero_compte }}" readonly disabled>
                        </div>

                        <div class="mb-3">
                            <label for="type_compte" class="form-label">Type de compte</label>
                            <select name="type_compte" id="type_compte" class="form-select @error('type_compte') is-invalid @enderror">
                                <option value="courant" {{ $compte->type_compte == 'courant' ? 'selected' : '' }}>Compte courant</option>
                                <option value="epargne" {{ $compte->type_compte == 'epargne' ? 'selected' : '' }}>Compte épargne</option>
                                <option value="joint" {{ $compte->type_compte == 'joint' ? 'selected' : '' }}>Compte joint</option>
                            </select>
                            @error('type_compte')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="statut" class="form-label">Statut</label>
                            <select name="statut" id="statut" class="form-select @error('statut') is-invalid @enderror" required>
                                <option value="actif" {{ $compte->statut == 'actif' ? 'selected' : '' }}>Actif</option>
                                <option value="bloque" {{ $compte->statut == 'bloque' ? 'selected' : '' }}>Bloqué</option>
                                <option value="ferme" {{ $compte->statut == 'ferme' ? 'selected' : '' }}>Fermé</option>
                            </select>
                            @error('statut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Mettre à jour
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection