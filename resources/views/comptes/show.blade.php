@extends('layouts.app')

@section('title', 'Détail du compte')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">Détail du compte</h1>
                <div>
                    <a href="{{ route('comptes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                    <a href="{{ route('comptes.edit', $compte) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                </div>
            </div>
        </div>
    </div>
<div class="d-flex justify-content-between align-items-center">
    
    <div>
        <!-- BOUTON EXPORT RELEVÉ PDF -->
        <a href="{{ route('export.releve.pdf', $compte) }}" class="btn btn-danger me-2">
            <i class="fas fa-file-pdf"></i> Relevé PDF
        </a>
    
    </div>
</div>
    <!-- Informations du compte -->
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informations générales</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Numéro de compte</th>
                            <td><strong>{{ $compte->numero_compte }}</strong></td>
                        </tr>
                        <tr>
                            <th>Client</th>
                            <td>
                                <a href="{{ route('clients.show', $compte->client) }}">
                                    {{ $compte->client->nom }} {{ $compte->client->prenom }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>Type de compte</th>
                            <td>
                                @switch($compte->type_compte)
                                    @case('courant') Compte courant @break
                                    @case('epargne') Compte épargne @break
                                    @case('joint') Compte joint @break
                                @endswitch
                            </td>
                        </tr>
                        <tr>
                            <th>Date d'ouverture</th>
                            <td>{{ $compte->date_ouverture->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>Statut</th>
                            <td>
                                @switch($compte->statut)
                                    @case('actif')
                                        <span class="badge bg-success">Actif</span>
                                        @break
                                    @case('bloque')
                                        <span class="badge bg-warning">Bloqué</span>
                                        @break
                                    @case('ferme')
                                        <span class="badge bg-danger">Fermé</span>
                                        @break
                                @endswitch
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Solde</h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <h2 class="{{ $compte->solde >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ number_format($compte->solde, 2, ',', ' ') }} DH
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dernières opérations -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Dernières opérations</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Montant</th>
                                    <th>Libellé</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($compte->operations()->latest()->limit(10)->get() as $operation)
                                <tr>
                                    <td>{{ $operation->date_operation->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $operation->type_operation == 'retrait' ? 'danger' : 'success' }}">
                                            {{ ucfirst($operation->type_operation) }}
                                        </span>
                                    </td>
                                    <td class="{{ $operation->type_operation == 'retrait' ? 'text-danger' : 'text-success' }}">
                                        {{ number_format($operation->montant, 2, ',', ' ') }} DH
                                    </td>
                                    <td>{{ $operation->libelle ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        Aucune opération
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection