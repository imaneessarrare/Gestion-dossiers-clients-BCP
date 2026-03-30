@extends('layouts.app')

@section('title', 'Gestion des impayés')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center">
    <h1 class="h3">Gestion des impayés</h1>
    <a href="{{ route('impayes.create') }}" class="btn btn-danger">
        <i class="fas fa-plus"></i> Nouvel impayé
    </a>
</div>
<div class="d-flex justify-content-between align-items-center">
    
    <div>
        <!-- BOUTON EXPORT EXCEL -->
        <a href="{{ route('export.impayes.excel') }}" class="btn btn-success">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
    </div>
</div>
    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h6>Total impayés</h6>
                    <h3>{{ number_format($stats['total'] ?? 0, 2, ',', ' ') }} DH</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6>Nombre d'impayés</h6>
                    <h3>{{ $stats['nombre'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6>Montant moyen</h6>
                    <h3>{{ number_format($stats['moyenne'] ?? 0, 2, ',', ' ') }} DH</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-secondary text-white">
                <div class="card-body">
                    <h6>Répartition</h6>
                    @foreach($stats['par_statut'] ?? [] as $statut => $count)
                        <span class="badge bg-light text-dark me-1">{{ $statut }}: {{ $count }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('impayes.index') }}" class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Rechercher par client..." 
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4">
                            <select name="statut" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="nouveau" {{ request('statut') == 'nouveau' ? 'selected' : '' }}>Nouveau</option>
                                <option value="en_relance" {{ request('statut') == 'en_relance' ? 'selected' : '' }}>En relance</option>
                                <option value="contentieux" {{ request('statut') == 'contentieux' ? 'selected' : '' }}>Contentieux</option>
                                <option value="resolu" {{ request('statut') == 'resolu' ? 'selected' : '' }}>Résolu</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-secondary w-100">
                                <i class="fas fa-filter"></i> Filtrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des impayés -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Liste des impayés</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Client</th>
                                    <th>Montant</th>
                                    <th>Date impayé</th>
                                    <th>Jours de retard</th>
                                    <th>Statut</th>
                                    <th>Crédit lié</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($impayes ?? [] as $impaye)
                                <tr>
                                    <td>{{ $impaye->id_impaye }}</td>
                                    <td>
                                        <a href="{{ route('clients.show', $impaye->client) }}">
                                            {{ $impaye->client->nom }} {{ $impaye->client->prenom }}
                                        </a>
                                    </td>
                                    <td class="text-danger">
                                        <strong>{{ number_format($impaye->montant, 2, ',', ' ') }} DH</strong>
                                    </td>
                                    <td>{{ $impaye->date_impaye->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-danger">
                                            {{ $impaye->date_impaye->diffInDays(now()) }} jours
                                        </span>
                                    </td>
                                    <td>
                                        @switch($impaye->statut)
                                            @case('nouveau')
                                                <span class="badge bg-danger">Nouveau</span>
                                                @break
                                            @case('en_relance')
                                                <span class="badge bg-warning">En relance</span>
                                                @break
                                            @case('contentieux')
                                                <span class="badge bg-dark">Contentieux</span>
                                                @break
                                            @case('resolu')
                                                <span class="badge bg-success">Résolu</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        @if($impaye->credit)
                                            <a href="{{ route('credits.show', $impaye->credit) }}">
                                                Crédit #{{ $impaye->credit->id_credit }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('impayes.show', $impaye) }}" 
                                               class="btn btn-sm btn-info" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Aucun impayé trouvé
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $impayes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection