@extends('layouts.app')

@section('title', 'Détail du crédit')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">Détail du crédit</h1>
                <div>
                    <a href="{{ route('credits.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                    <a href="{{ route('credits.echeances', $credit) }}" class="btn btn-primary">
                        <i class="fas fa-calendar"></i> Voir les échéances
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center">
    <h1 class="h3">Détail du crédit</h1>
    <div>
        <!-- BOUTON EXPORT ÉCHÉANCES PDF -->
        <a href="{{ route('export.echeances.pdf', $credit) }}" class="btn btn-danger me-2">
            <i class="fas fa-file-pdf"></i> Échéances PDF
        </a>
        <a href="{{ route('credits.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

    <!-- Informations client -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Client</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <p class="mb-1"><strong>Nom complet</strong></p>
                            <p>{{ $credit->client->nom }} {{ $credit->client->prenom }}</p>
                        </div>
                        <div class="col-md-3">
                            <p class="mb-1"><strong>CIN</strong></p>
                            <p>{{ $credit->client->cin }}</p>
                        </div>
                        <div class="col-md-3">
                            <p class="mb-1"><strong>Téléphone</strong></p>
                            <p>{{ $credit->client->telephone ?? 'Non renseigné' }}</p>
                        </div>
                        <div class="col-md-3">
                            <p class="mb-1"><strong>Email</strong></p>
                            <p>{{ $credit->client->email ?? 'Non renseigné' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Informations du crédit -->
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Détails du crédit</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>Montant</th>
                            <td><strong>{{ number_format($credit->montant, 2, ',', ' ') }} DH</strong></td>
                        </tr>
                        <tr>
                            <th>Taux d'intérêt</th>
                            <td>{{ $credit->taux_interet }}%</td>
                        </tr>
                        <tr>
                            <th>Durée</th>
                            <td>{{ $credit->duree_mois }} mois</td>
                        </tr>
                        <tr>
                            <th>Mensualité</th>
                            <td>{{ number_format($credit->calculerMensualite(), 2, ',', ' ') }} DH</td>
                        </tr>
                        <tr>
                            <th>Date de début</th>
                            <td>{{ $credit->date_debut->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>Date de fin</th>
                            <td>{{ $credit->date_fin->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>Statut</th>
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
                                <h6>Montant restant</h6>
                                <h3 class="text-primary">{{ number_format($credit->montant_restant, 2, ',', ' ') }} DH</h3>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="p-3 border rounded">
                                <h6>Échéances payées</h6>
                                <h3 class="text-success">{{ $credit->echeances->where('statut_paiement', 'paye')->count() }}/{{ $credit->echeances->count() }}</h3>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-3 border rounded">
                                <h6>Prochaine échéance</h6>
                                @if($credit->prochaine_echeance)
                                    <h4>{{ $credit->prochaine_echeance->date_echeance->format('d/m/Y') }}</h4>
                                    <p>{{ number_format($credit->prochaine_echeance->montant, 2, ',', ' ') }} DH</p>
                                @else
                                    <p>Aucune échéance à venir</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dernières échéances -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Dernières échéances</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date échéance</th>
                                    <th>Montant</th>
                                    <th>Statut</th>
                                    <th>Date paiement</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($credit->echeances->sortByDesc('date_echeance')->take(5) as $echeance)
                                <tr>
                                    <td>{{ $echeance->date_echeance->format('d/m/Y') }}</td>
                                    <td>{{ number_format($echeance->montant, 2, ',', ' ') }} DH</td>
                                    <td>
                                        @if($echeance->statut_paiement == 'paye')
                                            <span class="badge bg-success">Payée</span>
                                        @elseif($echeance->statut_paiement == 'impaye')
                                            <span class="badge bg-danger">Impayée</span>
                                        @else
                                            <span class="badge bg-warning">En attente</span>
                                        @endif
                                    </td>
                                    <td>{{ $echeance->date_paiement ? $echeance->date_paiement->format('d/m/Y') : '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Aucune échéance</td>
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