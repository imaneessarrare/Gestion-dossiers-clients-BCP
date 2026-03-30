@extends('layouts.app')

@section('title', 'Échéances du crédit')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">Échéances du crédit</h1>
                <div>
                    <a href="{{ route('credits.show', $credit) }}" class="btn btn-info">
                        <i class="fas fa-eye"></i> Voir le crédit
                    </a>
                    <a href="{{ route('credits.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Informations du crédit -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <small class="text-muted">Client</small>
                            <p class="fw-bold">{{ $credit->client->nom }} {{ $credit->client->prenom }}</p>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted">Montant</small>
                            <p class="fw-bold">{{ number_format($credit->montant, 2, ',', ' ') }} DH</p>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted">Mensualité</small>
                            <p class="fw-bold">{{ number_format($credit->calculerMensualite(), 2, ',', ' ') }} DH</p>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted">Restant dû</small>
                            <p class="fw-bold text-primary">{{ number_format($credit->montant_restant, 2, ',', ' ') }} DH</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des échéances -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Tableau d'amortissement</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Date échéance</th>
                                    <th>Montant</th>
                                    <th>Statut</th>
                                    <th>Date paiement</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($echeances as $index => $echeance)
                                <tr class="{{ $echeance->estEnRetard() ? 'table-danger' : '' }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $echeance->date_echeance->format('d/m/Y') }}</td>
                                    <td>{{ number_format($echeance->montant, 2, ',', ' ') }} DH</td>
                                    <td>
                                        @if($echeance->statut_paiement == 'paye')
                                            <span class="badge bg-success">Payée</span>
                                        @elseif($echeance->statut_paiement == 'impaye')
                                            <span class="badge bg-danger">Impayée</span>
                                        @elseif($echeance->estEnRetard())
                                            <span class="badge bg-danger">En retard</span>
                                        @else
                                            <span class="badge bg-warning">En attente</span>
                                        @endif
                                    </td>
                                    <td>{{ $echeance->date_paiement ? $echeance->date_paiement->format('d/m/Y') : '-' }}</td>
                                    <td>
                                        @if($echeance->statut_paiement != 'paye')
                                            <form action="{{ route('credits.echeance.paiement', $echeance) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" 
                                                        onclick="return confirm('Marquer cette échéance comme payée ?')">
                                                    <i class="fas fa-check"></i> Marquer payée
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection