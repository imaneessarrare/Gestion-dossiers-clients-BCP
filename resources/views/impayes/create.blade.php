@extends('layouts.app')

@section('title', 'Nouvel impayé')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">Créer un nouvel impayé</h1>
                <a href="{{ route('impayes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('impayes.store') }}">
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

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="montant" class="form-label">Montant (DH) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" min="0.01" 
                                       class="form-control @error('montant') is-invalid @enderror" 
                                       id="montant" name="montant" value="{{ old('montant') }}" required>
                                @error('montant')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="date_impaye" class="form-label">Date de l'impayé <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('date_impaye') is-invalid @enderror" 
                                       id="date_impaye" name="date_impaye" value="{{ old('date_impaye', date('Y-m-d')) }}" required>
                                @error('date_impaye')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="id_credit" class="form-label">Crédit associé (optionnel)</label>
                            <select name="id_credit" id="id_credit" class="form-select @error('id_credit') is-invalid @enderror">
                                <option value="">Sélectionnez un crédit (optionnel)</option>
                                @foreach($clients as $client)
                                    @foreach($client->credits as $credit)
                                        <option value="{{ $credit->id_credit }}" {{ old('id_credit') == $credit->id_credit ? 'selected' : '' }}>
                                            {{ $client->nom }} {{ $client->prenom }} - Crédit {{ number_format($credit->montant, 2) }} DH
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                            @error('id_credit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes / Observations</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-exclamation-triangle"></i> Enregistrer l'impayé
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection