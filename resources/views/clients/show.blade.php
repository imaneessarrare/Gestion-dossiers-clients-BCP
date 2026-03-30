@extends('layouts.app')

@section('title', 'Détail du client')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">Fiche client</h1>
                <div>
                    <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                    <a href="{{ route('clients.edit', $client) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                </div>
            </div>
        </div>
    </div>
<div class="d-flex justify-content-between align-items-center">
    
    <div>
        <!-- BOUTON EXPORT PDF -->
        <a href="{{ route('export.client.pdf', $client) }}" class="btn btn-danger me-2">
            <i class="fas fa-file-pdf"></i> Exporter PDF
        </a>
        <a href="{{ route('clients.edit', $client) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Modifier
        </a>
    </div>
</div>
    <!-- Informations client -->
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informations personnelles</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Nom complet</th>
                            <td><strong>{{ $client->nom }} {{ $client->prenom }}</strong></td>
                        </tr>
                        <tr>
                            <th>Date de naissance</th>
                            <td>{{ $client->date_naissance->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>CIN</th>
                            <td>{{ $client->cin }}</td>
                        </tr>
                        <tr>
                            <th>Adresse</th>
                            <td>{{ $client->adresse ?? 'Non renseignée' }}</td>
                        </tr>
                        <tr>
                            <th>Téléphone</th>
                            <td>{{ $client->telephone ?? 'Non renseigné' }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $client->email ?? 'Non renseigné' }}</td>
                        </tr>
                        <tr>
                            <th>Situation professionnelle</th>
                            <td>{{ $client->situation_professionnelle ?? 'Non renseignée' }}</td>
                        </tr>
                        <tr>
                            <th>Revenus mensuels</th>
                            <td>{{ $client->revenus_mensuels ? number_format($client->revenus_mensuels, 2, ',', ' ') . ' DH' : 'Non renseigné' }}</td>
                        </tr>
                        <tr>
                            <th>Statut</th>
                            <td>
                                @if($client->statut == 'actif')
                                    <span class="badge bg-success">Actif</span>
                                @else
                                    <span class="badge bg-secondary">Inactif</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Résumé financier</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="p-3 border rounded">
                                <h6>Comptes</h6>
                                <h3>{{ $client->comptes->count() }}</h3>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="p-3 border rounded">
                                <h6>Crédits</h6>
                                <h3>{{ $client->credits->count() }}</h3>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 border rounded">
                                <h6>Impayés</h6>
                                <h3 class="text-danger">{{ $client->impayes->count() }}</h3>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 border rounded">
                                <h6>Solde total</h6>
                                <h3 class="{{ $client->comptes->sum('solde') >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ number_format($client->comptes->sum('solde'), 2, ',', ' ') }} DH
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Onglets -->
    <div class="row">
        <div class="col-12">
            <ul class="nav nav-tabs" id="clientTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="comptes-tab" data-bs-toggle="tab" data-bs-target="#comptes" type="button" role="tab">
                        Comptes ({{ $client->comptes->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="credits-tab" data-bs-toggle="tab" data-bs-target="#credits" type="button" role="tab">
                        Crédits ({{ $client->credits->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="impayes-tab" data-bs-toggle="tab" data-bs-target="#impayes" type="button" role="tab">
                        Impayés ({{ $client->impayes->count() }})
                    </button>
                </li>
            </ul>
            
            <div class="tab-content p-3 border border-top-0 rounded-bottom" id="clientTabsContent">
                <!-- Comptes -->
                <div class="tab-pane fade show active" id="comptes" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>N° Compte</th>
                                    <th>Type</th>
                                    <th>Solde</th>
                                    <th>Date ouverture</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($client->comptes as $compte)
                                <tr>
                                    <td>{{ $compte->numero_compte }}</td>
                                    <td>{{ ucfirst($compte->type_compte) }}</td>
                                    <td class="{{ $compte->solde >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ number_format($compte->solde, 2, ',', ' ') }} DH
                                    </td>
                                    <td>{{ $compte->date_ouverture->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $compte->statut == 'actif' ? 'success' : ($compte->statut == 'bloque' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($compte->statut) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('comptes.show', $compte) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Aucun compte</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Crédits -->
                <div class="tab-pane fade" id="credits" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Montant</th>
                                    <th>Taux</th>
                                    <th>Durée</th>
                                    <th>Date début</th>
                                    <th>Date fin</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($client->credits as $credit)
                                <tr>
                                    <td>{{ number_format($credit->montant, 2, ',', ' ') }} €</td>
                                    <td>{{ $credit->taux_interet }}%</td>
                                    <td>{{ $credit->duree_mois }} mois</td>
                                    <td>{{ $credit->date_debut->format('d/m/Y') }}</td>
                                    <td>{{ $credit->date_fin->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $credit->statut == 'en_cours' ? 'success' : ($credit->statut == 'en_retard' ? 'danger' : 'secondary') }}">
                                            {{ $credit->statut }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('credits.show', $credit) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Aucun crédit</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Impayés -->
                <div class="tab-pane fade" id="impayes" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Montant</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($client->impayes as $impaye)
                                <tr>
                                    <td class="text-danger">{{ number_format($impaye->montant, 2, ',', ' ') }} DH</td>
                                    <td>{{ $impaye->date_impaye->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $impaye->statut == 'nouveau' ? 'danger' : ($impaye->statut == 'en_relance' ? 'warning' : 'success') }}">
                                            {{ $impaye->statut }}
                                        </span>
                                    </td>
                                    <td>{{ $impaye->notes ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Aucun impayé</td>
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