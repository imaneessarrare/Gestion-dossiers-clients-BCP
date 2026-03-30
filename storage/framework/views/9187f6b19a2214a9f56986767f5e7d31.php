

<?php $__env->startSection('title', 'Détail du compte'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">Détail du compte</h1>
                <div>
                    <a href="<?php echo e(route('comptes.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                    <a href="<?php echo e(route('comptes.edit', $compte)); ?>" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                </div>
            </div>
        </div>
    </div>
<div class="d-flex justify-content-between align-items-center">
    
    <div>
        <!-- BOUTON EXPORT RELEVÉ PDF -->
        <a href="<?php echo e(route('export.releve.pdf', $compte)); ?>" class="btn btn-danger me-2">
            <i class="fas fa-file-pdf"></i> Relevé PDF
        </a>
    
    </div>
</div>
    <!-- Informations du compte -->
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informations générales</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Numéro de compte</th>
                            <td><strong><?php echo e($compte->numero_compte); ?></strong></td>
                        </tr>
                        <tr>
                            <th>Client</th>
                            <td>
                                <a href="<?php echo e(route('clients.show', $compte->client)); ?>">
                                    <?php echo e($compte->client->nom); ?> <?php echo e($compte->client->prenom); ?>

                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>Type de compte</th>
                            <td>
                                <?php switch($compte->type_compte):
                                    case ('courant'): ?> Compte courant <?php break; ?>
                                    <?php case ('epargne'): ?> Compte épargne <?php break; ?>
                                    <?php case ('joint'): ?> Compte joint <?php break; ?>
                                <?php endswitch; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Date d'ouverture</th>
                            <td><?php echo e($compte->date_ouverture->format('d/m/Y')); ?></td>
                        </tr>
                        <tr>
                            <th>Statut</th>
                            <td>
                                <?php switch($compte->statut):
                                    case ('actif'): ?>
                                        <span class="badge bg-success">Actif</span>
                                        <?php break; ?>
                                    <?php case ('bloque'): ?>
                                        <span class="badge bg-warning">Bloqué</span>
                                        <?php break; ?>
                                    <?php case ('ferme'): ?>
                                        <span class="badge bg-danger">Fermé</span>
                                        <?php break; ?>
                                <?php endswitch; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Solde</h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <h2 class="<?php echo e($compte->solde >= 0 ? 'text-success' : 'text-danger'); ?>">
                            <?php echo e(number_format($compte->solde, 2, ',', ' ')); ?> DH
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dernières opérations -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Dernières opérations</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Montant</th>
                                    <th>Libellé</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $compte->operations()->latest()->limit(10)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $operation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($operation->date_operation->format('d/m/Y H:i')); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo e($operation->type_operation == 'retrait' ? 'danger' : 'success'); ?>">
                                            <?php echo e(ucfirst($operation->type_operation)); ?>

                                        </span>
                                    </td>
                                    <td class="<?php echo e($operation->type_operation == 'retrait' ? 'text-danger' : 'text-success'); ?>">
                                        <?php echo e(number_format($operation->montant, 2, ',', ' ')); ?> DH
                                    </td>
                                    <td><?php echo e($operation->libelle ?? '-'); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        Aucune opération
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gestion-bancaire\resources\views/comptes/show.blade.php ENDPATH**/ ?>