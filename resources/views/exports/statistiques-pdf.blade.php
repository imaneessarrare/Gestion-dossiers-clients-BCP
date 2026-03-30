<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Statistiques globales</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #D2691E;
        }
        .header h1 {
            color: #2C1A0E;
            font-size: 24px;
            margin: 0 0 5px;
        }
        .header p {
            color: #666;
            font-size: 12px;
            margin: 0;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            background: #D2691E;
            color: white;
            padding: 8px 12px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background: #f8f9fa;
            color: #2C1A0E;
            font-weight: bold;
            padding: 10px;
            text-align: left;
            border-bottom: 2px solid #D2691E;
        }
        td {
            padding: 8px 10px;
            border-bottom: 1px solid #ddd;
        }
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        .kpi-card {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            border: 1px solid #e9ecef;
        }
        .kpi-label {
            color: #666;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        .kpi-value {
            color: #2C1A0E;
            font-size: 22px;
            font-weight: bold;
        }
        .kpi-unit {
            color: #D2691E;
            font-size: 12px;
            margin-left: 3px;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #999;
            font-size: 10px;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-success { background: #28a745; color: white; }
        .badge-warning { background: #ffc107; color: #333; }
        .badge-danger { background: #dc3545; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Statistiques globales</h1>
        <p>Généré le {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <!-- KPI Cards -->
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-label">Total clients</div>
            <div class="kpi-value">{{ number_format($stats['clients'] ?? 0, 0, ',', ' ') }}</div>
            <div class="kpi-label">Actifs: {{ number_format($stats['clients_actifs'] ?? 0, 0, ',', ' ') }}</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Total comptes</div>
            <div class="kpi-value">{{ number_format($stats['comptes'] ?? 0, 0, ',', ' ') }}</div>
            <div class="kpi-label">Actifs: {{ number_format($stats['comptes_actifs'] ?? 0, 0, ',', ' ') }}</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Total crédits</div>
            <div class="kpi-value">{{ number_format($stats['credits'] ?? 0, 0, ',', ' ') }}</div>
            <div class="kpi-label">En cours: {{ number_format($stats['credits_encours'] ?? 0, 0, ',', ' ') }}</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Total impayés</div>
            <div class="kpi-value">{{ number_format($stats['impayes'] ?? 0, 0, ',', ' ') }}</div>
            <div class="kpi-label">Montant: {{ number_format($stats['impayes_montant'] ?? 0, 2, ',', ' ') }} DH</div>
        </div>
    </div>

    <!-- Récapitulatif détaillé -->
    <div class="section">
        <div class="section-title">Récapitulatif détaillé</div>
        <table>
            <tr>
                <th width="60%">Indicateur</th>
                <th width="40%">Valeur</th>
            </tr>
            <tr>
                <td>Nombre total de clients</td>
                <td><strong>{{ number_format($stats['clients'] ?? 0, 0, ',', ' ') }}</strong></td>
            </tr>
            <tr>
                <td>Clients actifs</td>
                <td><span class="badge badge-success">{{ number_format($stats['clients_actifs'] ?? 0, 0, ',', ' ') }}</span></td>
            </tr>
            <tr>
                <td>Nombre total de comptes</td>
                <td><strong>{{ number_format($stats['comptes'] ?? 0, 0, ',', ' ') }}</strong></td>
            </tr>
            <tr>
                <td>Comptes actifs</td>
                <td><span class="badge badge-success">{{ number_format($stats['comptes_actifs'] ?? 0, 0, ',', ' ') }}</span></td>
            </tr>
            <tr>
                <td>Nombre total de crédits</td>
                <td><strong>{{ number_format($stats['credits'] ?? 0, 0, ',', ' ') }}</strong></td>
            </tr>
            <tr>
                <td>Crédits en cours</td>
                <td><span class="badge badge-warning">{{ number_format($stats['credits_encours'] ?? 0, 0, ',', ' ') }}</span></td>
            </tr>
            <tr>
                <td>Nombre total d'impayés</td>
                <td><strong>{{ number_format($stats['impayes'] ?? 0, 0, ',', ' ') }}</strong></td>
            </tr>
            <tr>
                <td>Montant total des impayés</td>
                <td><span class="badge badge-danger">{{ number_format($stats['impayes_montant'] ?? 0, 2, ',', ' ') }} DH</span></td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Document généré automatiquement - Système de Gestion Bancaire Professionnelle<br>
        {{ now()->format('d/m/Y H:i:s') }}
    </div>
</body>
</html>