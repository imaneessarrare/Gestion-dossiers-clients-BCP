<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relevé de compte</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #2C1A0E; }
        .info { margin-bottom: 20px; padding: 10px; background: #f9f9f9; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #D2691E; color: white; padding: 10px; }
        td { padding: 8px; border-bottom: 1px solid #ddd; }
        .depot { color: green; }
        .retrait { color: red; }
        .footer { margin-top: 30px; text-align: center; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Relevé de compte</h1>
        <p>{{ $compte->numero_compte }} - {{ $compte->client->nom }} {{ $compte->client->prenom }}</p>
        <p>Période : {{ $mois }}/{{ $annee }}</p>
    </div>

    <div class="info">
        <p><strong>Solde au {{ now()->format('d/m/Y') }} :</strong> {{ number_format($compte->solde, 2) }} DH</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Libellé</th>
                <th>Montant</th>
            </tr>
        </thead>
        <tbody>
            @foreach($operations as $op)
            <tr>
                <td>{{ $op->date_operation->format('d/m/Y H:i') }}</td>
                <td>{{ $op->type_operation }}</td>
                <td>{{ $op->libelle ?? '-' }}</td>
                <td class="{{ in_array($op->type_operation, ['depot', 'virement']) ? 'depot' : 'retrait' }}">
                    {{ number_format($op->montant, 2) }} DH
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Document généré automatiquement - Gestion Bancaire Professionnelle
    </div>
</body>
</html>