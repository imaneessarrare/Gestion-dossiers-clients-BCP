@extends('layouts.app')

@section('title', 'Opérations du compte')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">Historique des opérations</h1>
                <div>
                    <a href="{{ route('comptes.show', $compte) }}" class="btn btn-info">
                        <i class="fas fa-eye"></i> Voir le compte
                    </a>
                    <a href="{{ route('comptes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Informations du compte -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <small class="text-muted">Numéro de compte</small>
                            <p class="fw-bold">{{ $compte->numero_compte }}</p>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted">Client</small>
                            <p class="fw-bold">
                                <a href="{{ route('clients.show', $compte->client) }}">
                                    {{ $compte->client->nom }} {{ $compte->client->prenom }}
                                </a>
                            </p>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted">Solde actuel</small>
                            <p class="fw-bold {{ $compte->solde >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ number_format($compte->solde, 2, ',', ' ') }} DH
                            </p>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted">Type de compte</small>
                            <p class="fw-bold">
                                @switch($compte->type_compte)
                                    @case('courant')
                                        Compte courant
                                        @break
                                    @case('epargne')
                                        Compte épargne
                                        @break
                                    @case('joint')
                                        Compte joint
                                        @break
                                @endswitch
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('comptes.operations', $compte) }}" class="row g-3">
                        <div class="col-md-3">
                            <label for="date_debut" class="form-label">Date début</label>
                            <input type="date" class="form-control" id="date_debut" name="date_debut" 
                                   value="{{ request('date_debut') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="date_fin" class="form-label">Date fin</label>
                            <input type="date" class="form-control" id="date_fin" name="date_fin" 
                                   value="{{ request('date_fin') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="type" class="form-label">Type d'opération</label>
                            <select name="type" id="type" class="form-select">
                                <option value="">Tous</option>
                                <option value="depot" {{ request('type') == 'depot' ? 'selected' : '' }}>Dépôt</option>
                                <option value="retrait" {{ request('type') == 'retrait' ? 'selected' : '' }}>Retrait</option>
                                <option value="virement" {{ request('type') == 'virement' ? 'selected' : '' }}>Virement</option>
                                <option value="prelevement" {{ request('type') == 'prelevement' ? 'selected' : '' }}>Prélèvement</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter"></i> Filtrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des opérations -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Liste des opérations</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Montant</th>
                                    <th>Libellé</th>
                                    <th>Compte destinataire</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($operations as $operation)
                                <tr>
                                    <td>{{ $operation->date_operation->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @switch($operation->type_operation)
                                            @case('depot')
                                                <span class="badge bg-success">Dépôt</span>
                                                @break
                                            @case('retrait')
                                                <span class="badge bg-danger">Retrait</span>
                                                @break
                                            @case('virement')
                                                <span class="badge bg-info">Virement</span>
                                                @break
                                            @case('prelevement')
                                                <span class="badge bg-warning">Prélèvement</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">{{ $operation->type_operation }}</span>
                                        @endswitch
                                    </td>
                                    <td class="{{ in_array($operation->type_operation, ['depot']) ? 'text-success' : 'text-danger' }}">
                                        <strong>{{ number_format($operation->montant, 2, ',', ' ') }} DH</strong>
                                    </td>
                                    <td>{{ $operation->libelle ?? '-' }}</td>
                                    <td>
                                        @if($operation->compteDestinataire)
                                            <a href="{{ route('comptes.show', $operation->compteDestinataire) }}">
                                                {{ $operation->compteDestinataire->numero_compte }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Aucune opération trouvée
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