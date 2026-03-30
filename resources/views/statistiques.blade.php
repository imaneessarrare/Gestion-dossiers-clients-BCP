@extends('layouts.app')

@section('title', 'Statistiques')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3">Tableau de bord statistiques</h1>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center">
    <h1 class="h3">Statistiques</h1>
    <div>
        <!-- BOUTON EXPORT STATISTIQUES PDF -->
        <a href="{{ route('export.statistiques.pdf') }}" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Exporter PDF
        </a>
    </div>
</div>

    <!-- Filtre de période -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('statistiques') }}" class="row g-3">
                        <div class="col-md-10">
                            <label for="periode" class="form-label">Période (jours)</label>
                            <select name="periode" id="periode" class="form-select">
                                <option value="7" {{ $periode == 7 ? 'selected' : '' }}>7 derniers jours</option>
                                <option value="30" {{ $periode == 30 ? 'selected' : '' }}>30 derniers jours</option>
                                <option value="90" {{ $periode == 90 ? 'selected' : '' }}>90 derniers jours</option>
                                <option value="365" {{ $periode == 365 ? 'selected' : '' }}>365 derniers jours</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-sync-alt"></i> Actualiser
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Évolution des crédits</h5>
                </div>
                <div class="card-body">
                    <canvas id="creditsChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Nouveaux clients</h5>
                </div>
                <div class="card-body">
                    <canvas id="clientsChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Opérations bancaires</h5>
                </div>
                <div class="card-body">
                    <canvas id="operationsChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau récapitulatif -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Récapitulatif des opérations</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Dépôts</th>
                                    <th>Retraits</th>
                                    <th>Virements</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stats['operations'] as $date => $operations)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</td>
                                    <td class="text-success">
                                        {{ number_format($operations->where('type_operation', 'depot')->sum('montant_total') ?? 0, 2, ',', ' ') }} DH
                                    </td>
                                    <td class="text-danger">
                                        {{ number_format($operations->where('type_operation', 'retrait')->sum('montant_total') ?? 0, 2, ',', ' ') }} DH
                                    </td>
                                    <td class="text-info">
                                        {{ number_format($operations->where('type_operation', 'virement')->sum('montant_total') ?? 0, 2, ',', ' ') }} DH
                                    </td>
                                    <td>
                                        <strong>{{ number_format($operations->sum('montant_total'), 2, ',', ' ') }} DH</strong>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Graphique des crédits
    const creditsCtx = document.getElementById('creditsChart').getContext('2d');
    const creditsData = @json($stats['credits']);
    
    new Chart(creditsCtx, {
        type: 'line',
        data: {
            labels: creditsData.map(item => item.date),
            datasets: [{
                label: 'Nombre de crédits',
                data: creditsData.map(item => item.nombre),
                borderColor: '#D2691E',
                backgroundColor: 'rgba(210, 105, 30, 0.1)',
                tension: 0.4,
                fill: true,
                yAxisID: 'y'
            }, {
                label: 'Montant total (DH)',
                data: creditsData.map(item => item.montant_total),
                borderColor: '#2C1A0E',
                backgroundColor: 'rgba(44, 26, 14, 0.1)',
                tension: 0.4,
                fill: true,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Nombre de crédits'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Montant (DH)'
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
                },
            }
        }
    });

    // Graphique des clients
    const clientsCtx = document.getElementById('clientsChart').getContext('2d');
    const clientsData = @json($stats['clients']);
    
    new Chart(clientsCtx, {
        type: 'bar',
        data: {
            labels: clientsData.map(item => item.date),
            datasets: [{
                label: 'Nouveaux clients',
                data: clientsData.map(item => item.nouveaux),
                backgroundColor: '#D2691E',
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Graphique des opérations
    const operationsCtx = document.getElementById('operationsChart').getContext('2d');
    const operationsData = @json($stats['operations']);
    
    // Préparer les données pour le graphique
    const dates = Object.keys(operationsData);
    const depots = dates.map(date => operationsData[date].where('type_operation', 'depot').sum('montant_total') ?? 0);
    const retraits = dates.map(date => operationsData[date].where('type_operation', 'retrait').sum('montant_total') ?? 0);
    const virements = dates.map(date => operationsData[date].where('type_operation', 'virement').sum('montant_total') ?? 0);
    
    new Chart(operationsCtx, {
        type: 'bar',
        data: {
            labels: dates,
            datasets: [
                {
                    label: 'Dépôts',
                    data: depots,
                    backgroundColor: '#28a745',
                    borderRadius: 5
                },
                {
                    label: 'Retraits',
                    data: retraits,
                    backgroundColor: '#dc3545',
                    borderRadius: 5
                },
                {
                    label: 'Virements',
                    data: virements,
                    backgroundColor: '#17a2b8',
                    borderRadius: 5
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Montant (DH)'
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection