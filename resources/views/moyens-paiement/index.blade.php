@extends('layouts.app')

@section('title', 'Moyens de paiement')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">Gestion des moyens de paiement</h1>
                <a href="{{ route('moyens-paiement.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nouveau moyen de paiement
                </a>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6>Total</h6>
                    <h3>{{ $stats['total'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6>Cartes</h6>
                    <h3>{{ $stats['cartes'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6>Chéquiers</h6>
                    <h3>{{ $stats['chequiers'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6>Virements</h6>
                    <h3>{{ $stats['virements'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6>Actifs</h6>
                    <h3>{{ $stats['actifs'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h6>Expirés</h6>
                    <h3>{{ $stats['expires'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('moyens-paiement.index') }}" class="row g-3">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Rechercher par n° ou client..." 
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="type" class="form-select">
                                <option value="">Tous les types</option>
                                <option value="carte" {{ request('type') == 'carte' ? 'selected' : '' }}>Carte bancaire</option>
                                <option value="chequier" {{ request('type') == 'chequier' ? 'selected' : '' }}>Chéquier</option>
                                <option value="virement_permanent" {{ request('type') == 'virement_permanent' ? 'selected' : '' }}>Virement permanent</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="statut" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="actif" {{ request('statut') == 'actif' ? 'selected' : '' }}>Actif</option>
                                <option value="bloque" {{ request('statut') == 'bloque' ? 'selected' : '' }}>Bloqué</option>
                                <option value="expire" {{ request('statut') == 'expire' ? 'selected' : '' }}>Expiré</option>
                                <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
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

    <!-- Liste des moyens de paiement -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Numéro</th>
                                    <th>Client</th>
                                    <th>Date émission</th>
                                    <th>Date expiration</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($moyens as $moyen)
                                <tr>
                                    <td>
                                        @switch($moyen->type_moyen)
                                            @case('carte')
                                                <i class="fas fa-credit-card text-primary"></i> Carte
                                                @break
                                            @case('chequier')
                                                <i class="fas fa-book text-success"></i> Chéquier
                                                @break
                                            @case('virement_permanent')
                                                <i class="fas fa-exchange-alt text-info"></i> Virement permanent
                                                @break
                                        @endswitch
                                    </td>
                                    <td><strong>{{ $moyen->numero }}</strong></td>
                                    <td>
                                        <a href="{{ route('clients.show', $moyen->client) }}">
                                            {{ $moyen->client->nom }} {{ $moyen->client->prenom }}
                                        </a>
                                    </td>
                                    <td>{{ $moyen->date_emission ? $moyen->date_emission->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $moyen->date_expiration ? $moyen->date_expiration->format('d/m/Y') : '-' }}</td>
                                    <td>
                                        @switch($moyen->statut)
                                            @case('actif')
                                                <span class="badge bg-success">Actif</span>
                                                @break
                                            @case('bloque')
                                                <span class="badge bg-danger">Bloqué</span>
                                                @break
                                            @case('expire')
                                                <span class="badge bg-secondary">Expiré</span>
                                                @break
                                            @case('en_attente')
                                                <span class="badge bg-warning">En attente</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('moyens-paiement.show', $moyen) }}" 
                                               class="btn btn-sm btn-info" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($moyen->statut == 'actif')
                                                <form action="{{ route('moyens-paiement.bloquer', $moyen) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('Bloquer ce moyen de paiement ?')"
                                                            title="Bloquer">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                </form>
                                            @elseif($moyen->statut == 'bloque')
                                                <form action="{{ route('moyens-paiement.activer', $moyen) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" 
                                                            onclick="return confirm('Activer ce moyen de paiement ?')"
                                                            title="Activer">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        Aucun moyen de paiement trouvé
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $moyens->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection