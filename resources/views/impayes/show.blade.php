@extends('layouts.app')

@section('title', 'Détail de l\'impayé')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">Détail de l'impayé</h1>
                <div>
                    <a href="{{ route('impayes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Informations client -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informations client</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Nom complet</th>
                            <td>
                                <a href="{{ route('clients.show', $impaye->client) }}">
                                    <strong>{{ $impaye->client->nom }} {{ $impaye->client->prenom }}</strong>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>CIN</th>
                            <td>{{ $impaye->client->cin }}</td>
                        </tr>
                        <tr>
                            <th>Téléphone</th>
                            <td>{{ $impaye->client->telephone ?? 'Non renseigné' }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $impaye->client->email ?? 'Non renseigné' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
 <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Détails de l'impayé</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Montant</th>
                            <td><h4 class="text-danger">{{ number_format($impaye->montant, 2, ',', ' ') }} DH</h4></td>
                        </tr>
                        <tr>
                            <th>Date de l'impayé</th>
                            <td>{{ $impaye->date_impaye->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>Jours de retard</th>
                            <td>
                                <span class="badge bg-danger p-2">
                                    {{ $impaye->date_impaye->diffInDays(now()) }} jours
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Statut</th>
                            <td>
                                @switch($impaye->statut)
                                    @case('nouveau')
                                        <span class="badge bg-danger p-2">Nouveau</span>
                                        @break
                                    @case('en_relance')
                                        <span class="badge bg-warning p-2">En relance</span>
                                        @break
                                    @case('contentieux')
                                        <span class="badge bg-dark p-2">Contentieux</span>
                                        @break
                                    @case('resolu')
                                        <span class="badge bg-success p-2">Résolu</span>
                                        @break
                                @endswitch
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection