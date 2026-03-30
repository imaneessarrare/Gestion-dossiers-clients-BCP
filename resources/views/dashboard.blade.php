@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">Tableau de bord</h1>
            </div>
            <p class="text-muted">Bienvenue, {{ auth()->user()->nom }}</p>
        </div>
    </div>
<div class="d-flex justify-content-between align-items-center">
    <h1 class="h3">Tableau de bord</h1>
    <div class="btn-group">
        <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown">
            <i class="fas fa-file-excel"></i> Export Excel
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('export.clients.excel') }}">Clients</a></li>
            <li><a class="dropdown-item" href="{{ route('export.comptes.excel') }}">Comptes</a></li>
            <li><a class="dropdown-item" href="{{ route('export.credits.excel') }}">Crédits</a></li>
            <li><a class="dropdown-item" href="{{ route('export.impayes.excel') }}">Impayés</a></li>
        </ul>
        
        <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown">
            <i class="fas fa-file-pdf"></i> Export PDF
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('export.statistiques.pdf') }}">Statistiques globales</a></li>
        </ul>
    </div>
</div>
    <!-- Alertes -->
    @if(isset($alertes) && ($alertes['echeances_proches'] > 0 || $alertes['impayes_nouveaux'] > 0))
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-exclamation-triangle me-2"></i> Alertes :</strong>
                <ul class="mb-0 mt-2">
                    @if($alertes['echeances_proches'] > 0)
                        <li>{{ $alertes['echeances_proches'] }} échéance(s) dans les 7 prochains jours</li>
                    @endif
                    @if($alertes['impayes_nouveaux'] > 0)
                        <li>{{ $alertes['impayes_nouveaux'] }} nouvel(s) impayé(s) à traiter</li>
                    @endif
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    </div>
    @endif

    <!-- Cartes KPI -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Clients actifs</h6>
                            <h2 class="mb-0">{{ $stats['clients_actifs'] ?? 0 }}</h2>
                            <small>Total: {{ $stats['clients_total'] ?? 0 }}</small>
                        </div>
                        <i class="fas fa-users fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Comptes actifs</h6>
                            <h2 class="mb-0">{{ $stats['comptes_actifs'] ?? 0 }}</h2>
                            <small>Total: {{ $stats['comptes_total'] ?? 0 }}</small>
                        </div>
                        <i class="fas fa-credit-card fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Crédits en cours</h6>
                            <h2 class="mb-0">{{ $stats['credits_encours'] ?? 0 }}</h2>
                            <small>Total: {{ $stats['credits_total'] ?? 0 }}</small>
                        </div>
                        <i class="fas fa-hand-holding-usd fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card bg-danger text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Impayés</h6>
                            <h2 class="mb-0">{{ number_format($stats['impayes_total'] ?? 0, 0, ',', ' ') }} DH</h2>
                            <small>{{ $stats['impayes_nouveaux'] ?? 0 }} nouveaux</small>
                        </div>
                        <i class="fas fa-exclamation-triangle fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques - VERSION STATIQUE (pas de re-rendu) -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Évolution des nouveaux clients (30 jours)</h5>
                </div>
                <div class="card-body">
                    <div style="height: 300px; overflow: hidden;">
                        <canvas id="clientsEvolutionChart" style="width:100%; height:100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Répartition des comptes</h5>
                </div>
                <div class="card-body">
                    <div style="height: 250px; overflow: hidden;">
                        <canvas id="comptesPieChart" style="width:100%; height:100%;"></canvas>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-circle text-primary"></i> Courant</span>
                            <span class="badge bg-primary">{{ $repartitionComptes['courant'] ?? 0 }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-circle text-success"></i> Épargne</span>
                            <span class="badge bg-success">{{ $repartitionComptes['epargne'] ?? 0 }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-circle text-warning"></i> Joint</span>
                            <span class="badge bg-warning">{{ $repartitionComptes['joint'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Deuxième ligne - VERSION STATIQUE (tableaux simples) -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Crédits par statut</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="p-2 border rounded">
                                <span class="badge bg-primary mb-2">En cours</span>
                                <h3>{{ $creditsParStatut['en_cours'] ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 border rounded">
                                <span class="badge bg-danger mb-2">En retard</span>
                                <h3>{{ $creditsParStatut['en_retard'] ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 border rounded">
                                <span class="badge bg-success mb-2">Remboursés</span>
                                <h3>{{ $creditsParStatut['rembourse'] ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Impayés par statut</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="p-2 border rounded">
                                <span class="badge bg-danger mb-2">Nouveaux</span>
                                <h3>{{ $impayesParStatut['nouveau'] ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 border rounded">
                                <span class="badge bg-warning mb-2">En relance</span>
                                <h3>{{ $impayesParStatut['en_relance'] ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 border rounded">
                                <span class="badge bg-secondary mb-2">Contentieux</span>
                                <h3>{{ $impayesParStatut['contentieux'] ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Moyens de paiement</h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <h1 class="display-4">{{ $stats['moyens_paiement'] ?? 0 }}</h1>
                        <p class="text-muted">Total enregistrés</p>
                        <a href="{{ route('moyens-paiement.index') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-credit-card"></i> Gérer
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Clients à risque et dernières opérations -->
    <div class="row">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-title mb-0">Clients à risque</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($clientsRisques ?? [] as $client)
                            <a href="{{ route('clients.show', $client) }}" class="list-group-item list-group-item-action">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $client->nom }} {{ $client->prenom }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $client->impayes_count }} impayé(s)</small>
                                    </div>
                                    <span class="badge bg-danger">
                                        {{ number_format($client->impayes->sum('montant'), 0, ',', ' ') }} DH
                                    </span>
                                </div>
                            </a>
                        @empty
                            <div class="list-group-item text-center text-muted">
                                Aucun client à risque
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Dernières opérations</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Client</th>
                                    <th>Type</th>
                                    <th>Montant</th>
                                    <th>Libellé</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dernieresOperations ?? [] as $op)
                                <tr>
                                    <td>{{ $op->date_operation->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($op->compte && $op->compte->client)
                                            <a href="{{ route('clients.show', $op->compte->client) }}">
                                                {{ $op->compte->client->nom }} {{ $op->compte->client->prenom }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @switch($op->type_operation)
                                            @case('depot')
                                                <span class="badge bg-success">Dépôt</span>
                                                @break
                                            @case('retrait')
                                                <span class="badge bg-danger">Retrait</span>
                                                @break
                                            @case('virement')
                                                <span class="badge bg-info">Virement</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">{{ $op->type_operation }}</span>
                                        @endswitch
                                    </td>
                                    <td class="{{ in_array($op->type_operation, ['depot', 'virement']) ? 'text-success' : 'text-danger' }}">
                                        {{ number_format($op->montant, 2, ',', ' ') }} DH
                                    </td>
                                    <td>{{ $op->libelle ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        Aucune opération récente
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Exécuter UNE SEULE fois après le chargement complet
(function() {
    // S'assurer que le DOM est complètement chargé
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCharts);
    } else {
        initCharts();
    }
    
    function initCharts() {
        // Graphique d'évolution des clients
        const clientsCanvas = document.getElementById('clientsEvolutionChart');
        if (clientsCanvas) {
            const clientsCtx = clientsCanvas.getContext('2d');
            const clientsData = @json($clientsEvolution ?? []);
            
            new Chart(clientsCtx, {
                type: 'line',
                data: {
                    labels: clientsData.map(item => {
                        const date = new Date(item.date);
                        return date.toLocaleDateString('fr-FR', { day: '2-digit', month: '2-digit' });
                    }),
                    datasets: [{
                        label: 'Nouveaux clients',
                        data: clientsData.map(item => item.total),
                        borderColor: '#D2691E',
                        backgroundColor: 'rgba(210, 105, 30, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#D2691E',
                        pointRadius: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    animation: false, // Désactiver les animations
                    plugins: { 
                        legend: { display: false },
                        tooltip: { enabled: true }
                    },
                    scales: { 
                        y: { 
                            beginAtZero: true, 
                            ticks: { stepSize: 1 },
                            grid: { display: true }
                        },
                        x: { 
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        // Graphique circulaire des comptes
        const comptesCanvas = document.getElementById('comptesPieChart');
        if (comptesCanvas) {
            const comptesCtx = comptesCanvas.getContext('2d');
            
            new Chart(comptesCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Courant', 'Épargne', 'Joint'],
                    datasets: [{
                        data: [
                            {{ $repartitionComptes['courant'] ?? 0 }},
                            {{ $repartitionComptes['epargne'] ?? 0 }},
                            {{ $repartitionComptes['joint'] ?? 0 }}
                        ],
                        backgroundColor: ['#0d6efd', '#198754', '#ffc107'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    animation: false, // Désactiver les animations
                    plugins: { 
                        legend: { display: false },
                        tooltip: { enabled: true }
                    },
                    cutout: '65%'
                }
            });
        }
    }
})();
</script>
@endpush