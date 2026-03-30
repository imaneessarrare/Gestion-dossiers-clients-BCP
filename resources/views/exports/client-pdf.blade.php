<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fiche Client</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #2C1A0E; }
        .section { margin-bottom: 20px; }
        .section-title { background: #D2691E; color: white; padding: 8px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f2f2f2; }
        .footer { margin-top: 30px; text-align: center; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Fiche Client</h1>
        <p>Généré le {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="section">
        <div class="section-title">Informations personnelles</div>
        <table>
            <tr><th width="30%">Nom complet</th><td>{{ $client->nom }} {{ $client->prenom }}</td></tr>
            <tr><th>Date naissance</th><td>{{ $client->date_naissance->format('d/m/Y') }}</td></tr>
            <tr><th>CIN</th><td>{{ $client->cin }}</td></tr>
            <tr><th>Adresse</th><td>{{ $client->adresse ?? 'Non renseignée' }}</td></tr>
            <tr><th>Téléphone</th><td>{{ $client->telephone ?? 'Non renseigné' }}</td></tr>
            <tr><th>Email</th><td>{{ $client->email ?? 'Non renseigné' }}</td></tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Comptes bancaires</div>
        <table>
            <thead>
                <tr><th>N° Compte</th><th>Type</th><th>Solde (DH)</th><th>Date ouverture</th></tr>
            </thead>
            <tbody>
                @foreach($client->comptes as $compte)
                <tr>
                    <td>{{ $compte->numero_compte }}</td>
                    <td>{{ $compte->type_compte }}</td>
                    <td>{{ number_format($compte->solde, 2) }}</td>
                    <td>{{ $compte->date_ouverture->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        Document généré automatiquement - Gestion Bancaire Professionnelle
    </div>
</body>
</html>
