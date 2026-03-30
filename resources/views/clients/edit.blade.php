@extends('layouts.app')

@section('title', 'Modifier le client')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">Modifier le client</h1>
                <a href="{{ route('clients.show', $client) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('clients.update', $client) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                                       id="nom" name="nom" value="{{ old('nom', $client->nom) }}" required>
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="prenom" class="form-label">Prénom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('prenom') is-invalid @enderror" 
                                       id="prenom" name="prenom" value="{{ old('prenom', $client->prenom) }}" required>
                                @error('prenom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date_naissance" class="form-label">Date de naissance <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('date_naissance') is-invalid @enderror" 
                                       id="date_naissance" name="date_naissance" value="{{ old('date_naissance', $client->date_naissance->format('Y-m-d')) }}" required>
                                @error('date_naissance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="cin" class="form-label">CIN <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('cin') is-invalid @enderror" 
                                       id="cin" name="cin" value="{{ old('cin', $client->cin) }}" required>
                                @error('cin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="adresse" class="form-label">Adresse</label>
                            <textarea class="form-control @error('adresse') is-invalid @enderror" 
                                      id="adresse" name="adresse" rows="2">{{ old('adresse', $client->adresse) }}</textarea>
                            @error('adresse')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telephone" class="form-label">Téléphone</label>
                                <input type="tel" class="form-control @error('telephone') is-invalid @enderror" 
                                       id="telephone" name="telephone" value="{{ old('telephone', $client->telephone) }}">
                                @error('telephone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $client->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="situation_professionnelle" class="form-label">Situation professionnelle</label>
                                <select class="form-select @error('situation_professionnelle') is-invalid @enderror" 
                                        id="situation_professionnelle" name="situation_professionnelle">
                                    <option value="">Sélectionnez...</option>
                                    <option value="CDI" {{ old('situation_professionnelle', $client->situation_professionnelle) == 'CDI' ? 'selected' : '' }}>CDI</option>
                                    <option value="CDD" {{ old('situation_professionnelle', $client->situation_professionnelle) == 'CDD' ? 'selected' : '' }}>CDD</option>
                                    <option value="Indépendant" {{ old('situation_professionnelle', $client->situation_professionnelle) == 'Indépendant' ? 'selected' : '' }}>Indépendant</option>
                                    <option value="Retraité" {{ old('situation_professionnelle', $client->situation_professionnelle) == 'Retraité' ? 'selected' : '' }}>Retraité</option>
                                    <option value="Sans emploi" {{ old('situation_professionnelle', $client->situation_professionnelle) == 'Sans emploi' ? 'selected' : '' }}>Sans emploi</option>
                                </select>
                                @error('situation_professionnelle')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="revenus_mensuels" class="form-label">Revenus mensuels (DH)</label>
                                <input type="number" step="0.01" min="0" 
                                       class="form-control @error('revenus_mensuels') is-invalid @enderror" 
                                       id="revenus_mensuels" name="revenus_mensuels" value="{{ old('revenus_mensuels', $client->revenus_mensuels) }}">
                                @error('revenus_mensuels')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
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