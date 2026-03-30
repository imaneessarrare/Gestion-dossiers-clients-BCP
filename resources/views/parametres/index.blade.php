@extends('layouts.app')

@section('title', 'Paramètres')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Paramètres</h1>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Configuration générale</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('parametres.update') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Nom de l'agence</label>
                            <input type="text" class="form-control" value="Agence Bancaire" readonly>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Devise</label>
                            <input type="text" class="form-control" value="Dirham (DH)" readonly>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Sauvegarder
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Actions système</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('parametres.verifier-impayes') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-sync-alt"></i> Vérifier les impayés
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection