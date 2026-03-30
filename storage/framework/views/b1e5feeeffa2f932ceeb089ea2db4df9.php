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
        <p><?php echo e($compte->numero_compte); ?> - <?php echo e($compte->client->nom); ?> <?php echo e($compte->client->prenom); ?></p>
        <p>Période : <?php echo e($mois); ?>/<?php echo e($annee); ?></p>
    </div>

    <div class="info">
        <p><strong>Solde au <?php echo e(now()->format('d/m/Y')); ?> :</strong> <?php echo e(number_format($compte->solde, 2)); ?> DH</p>
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
            <?php $__currentLoopData = $operations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $op): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($op->date_operation->format('d/m/Y H:i')); ?></td>
                <td><?php echo e($op->type_operation); ?></td>
                <td><?php echo e($op->libelle ?? '-'); ?></td>
                <td class="<?php echo e(in_array($op->type_operation, ['depot', 'virement']) ? 'depot' : 'retrait'); ?>">
                    <?php echo e(number_format($op->montant, 2)); ?> DH
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <div class="footer">
        Document généré automatiquement - Gestion Bancaire Professionnelle
    </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\gestion-bancaire\resources\views/exports/releve-pdf.blade.php ENDPATH**/ ?>