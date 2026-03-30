@extends('layouts.app')

@section('title', 'Liste des crédits')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">Gestion des crédits</h1>
                <a href="{{ route('credits.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nouveau crédit
                </a>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center">
    
    <div>
        <!-- BOUTON EXPORT EXCEL -->
        <a href="{{ route('export.credits.excel') }}" class="btn btn-success me-2">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
        
    </div>
</div>

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6>Encours total</h6>
                    <h3>{{ number_format($stats['total_encours'], 2, ',', ' ') }} DH</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6>Crédits en cours</h6>
                    <h3>{{ $stats['nombre_encours'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6>En retard</h6>
                    <h3>{{ $stats['en_retard'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6>Taux moyen</h6>
                    <h3>{{ number_format($stats['taux_moyen'] ?? 0, 2) }}%</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('credits.index') }}" class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Rechercher par client..." 
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4">
                            <select name="statut" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="en_cours" {{ request('statut') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                                <option value="rembourse" {{ request('statut') == 'rembourse' ? 'selected' : '' }}>Remboursé</option>
                                <option value="en_retard" {{ request('statut') == 'en_retard' ? 'selected' : '' }}>En retard</option>
                                <option value="rejete" {{ request('statut') == 'rejete' ? 'selected' : '' }}>Rejeté</option>
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

    <!-- Liste des crédits -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Client</th>
                                    <th>Montant</th>
                                    <th>Taux</th>
                                    <th>Durée</th>
                                    <th>Mensualité</th>
                                    <th>Date début</th>
                                    <th>Date fin</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($credits as $credit)
                                <tr>
                                    <td>{{ $credit->id_credit }}</td>
                                    <td>
                                        <a href="{{ route('clients.show', $credit->client) }}">
                                            {{ $credit->client->nom }} {{ $credit->client->prenom }}
                                        </a>
                                    </td>
                                    <td>{{ number_format($credit->montant, 2, ',', ' ') }} DH</td>
                                    <td>{{ $credit->taux_interet }}%</td>
                                    <td>{{ $credit->duree_mois }} mois</td>
                                    <td>{{ number_format($credit->calculerMensualite(), 2, ',', ' ') }} DH</td>
                                    <td>{{ $credit->date_debut->format('d/m/Y') }}</td>
                                    <td>{{ $credit->date_fin->format('d/m/Y') }}</td>
                                    <td>
                                        @switch($credit->statut)
                                            @case('en_cours')
                                                <span class="badge bg-success">En cours</span>
                                                @break
                                            @case('rembourse')
                                                <span class="badge bg-info">Remboursé</span>
                                                @break
                                            @case('en_retard')
                                                <span class="badge bg-danger">En retard</span>
                                                @break
                                            @case('rejete')
                                                <span class="badge bg-secondary">Rejeté</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('credits.show', $credit) }}" 
                                               class="btn btn-sm btn-info" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('credits.echeances', $credit) }}" 
                                               class="btn btn-sm btn-primary" title="Échéances">
                                                <i class="fas fa-calendar"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted">
                                        Aucun crédit trouvé
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $credits->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection