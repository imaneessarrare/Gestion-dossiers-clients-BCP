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
        <p>Généré le <?php echo e(now()->format('d/m/Y H:i')); ?></p>
    </div>

    <div class="section">
        <div class="section-title">Informations personnelles</div>
        <table>
            <tr><th width="30%">Nom complet</th><td><?php echo e($client->nom); ?> <?php echo e($client->prenom); ?></td></tr>
            <tr><th>Date naissance</th><td><?php echo e($client->date_naissance->format('d/m/Y')); ?></td></tr>
            <tr><th>CIN</th><td><?php echo e($client->cin); ?></td></tr>
            <tr><th>Adresse</th><td><?php echo e($client->adresse ?? 'Non renseignée'); ?></td></tr>
            <tr><th>Téléphone</th><td><?php echo e($client->telephone ?? 'Non renseigné'); ?></td></tr>
            <tr><th>Email</th><td><?php echo e($client->email ?? 'Non renseigné'); ?></td></tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Comptes bancaires</div>
        <table>
            <thead>
                <tr><th>N° Compte</th><th>Type</th><th>Solde (DH)</th><th>Date ouverture</th></tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $client->comptes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $compte): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($compte->numero_compte); ?></td>
                    <td><?php echo e($compte->type_compte); ?></td>
                    <td><?php echo e(number_format($compte->solde, 2)); ?></td>
                    <td><?php echo e($compte->date_ouverture->format('d/m/Y')); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <div class="footer">
        Document généré automatiquement - Gestion Bancaire Professionnelle
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\gestion-bancaire\resources\views/exports/client-pdf.blade.php ENDPATH**/ ?>