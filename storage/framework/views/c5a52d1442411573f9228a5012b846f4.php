

<?php $__env->startSection('title', 'Échéances du crédit'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">Échéances du crédit</h1>
                <div>
                    <a href="<?php echo e(route('credits.show', $credit)); ?>" class="btn btn-info">
                        <i class="fas fa-eye"></i> Voir le crédit
                    </a>
                    <a href="<?php echo e(route('credits.index')); ?>" class="btn btn-secondary">
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
                            <p class="fw-bold"><?php echo e($credit->client->nom); ?> <?php echo e($credit->client->prenom); ?></p>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted">Montant</small>
                            <p class="fw-bold"><?php echo e(number_format($credit->montant, 2, ',', ' ')); ?> DH</p>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted">Mensualité</small>
                            <p class="fw-bold"><?php echo e(number_format($credit->calculerMensualite(), 2, ',', ' ')); ?> DH</p>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted">Restant dû</small>
                            <p class="fw-bold text-primary"><?php echo e(number_format($credit->montant_restant, 2, ',', ' ')); ?> DH</p>
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
                                <?php $__currentLoopData = $echeances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $echeance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="<?php echo e($echeance->estEnRetard() ? 'table-danger' : ''); ?>">
                                    <td><?php echo e($index + 1); ?></td>
                                    <td><?php echo e($echeance->date_echeance->format('d/m/Y')); ?></td>
                                    <td><?php echo e(number_format($echeance->montant, 2, ',', ' ')); ?> DH</td>
                                    <td>
                                        <?php if($echeance->statut_paiement == 'paye'): ?>
                                            <span class="badge bg-success">Payée</span>
                                        <?php elseif($echeance->statut_paiement == 'impaye'): ?>
                                            <span class="badge bg-danger">Impayée</span>
                                        <?php elseif($echeance->estEnRetard()): ?>
                                            <span class="badge bg-danger">En retard</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">En attente</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($echeance->date_paiement ? $echeance->date_paiement->format('d/m/Y') : '-'); ?></td>
                                    <td>
                                        <?php if($echeance->statut_paiement != 'paye'): ?>
                                            <form action="<?php echo e(route('credits.echeance.paiement', $echeance)); ?>" 
                                                  method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-sm btn-success" 
                                                        onclick="return confirm('Marquer cette échéance comme payée ?')">
                                                    <i class="fas fa-check"></i> Marquer payée
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gestion-bancaire\resources\views/credits/echeances.blade.php ENDPATH**/ ?>