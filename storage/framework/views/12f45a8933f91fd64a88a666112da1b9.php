

<?php $__env->startSection('title', 'Détail de l\'impayé'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">Détail de l'impayé</h1>
                <div>
                    <a href="<?php echo e(route('impayes.index')); ?>" class="btn btn-secondary">
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
                                <a href="<?php echo e(route('clients.show', $impaye->client)); ?>">
                                    <strong><?php echo e($impaye->client->nom); ?> <?php echo e($impaye->client->prenom); ?></strong>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>CIN</th>
                            <td><?php echo e($impaye->client->cin); ?></td>
                        </tr>
                        <tr>
                            <th>Téléphone</th>
                            <td><?php echo e($impaye->client->telephone ?? 'Non renseigné'); ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?php echo e($impaye->client->email ?? 'Non renseigné'); ?></td>
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
                            <td><h4 class="text-danger"><?php echo e(number_format($impaye->montant, 2, ',', ' ')); ?> DH</h4></td>
                        </tr>
                        <tr>
                            <th>Date de l'impayé</th>
                            <td><?php echo e($impaye->date_impaye->format('d/m/Y')); ?></td>
                        </tr>
                        <tr>
                            <th>Jours de retard</th>
                            <td>
                                <span class="badge bg-danger p-2">
                                    <?php echo e($impaye->date_impaye->diffInDays(now())); ?> jours
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Statut</th>
                            <td>
                                <?php switch($impaye->statut):
                                    case ('nouveau'): ?>
                                        <span class="badge bg-danger p-2">Nouveau</span>
                                        <?php break; ?>
                                    <?php case ('en_relance'): ?>
                                        <span class="badge bg-warning p-2">En relance</span>
                                        <?php break; ?>
                                    <?php case ('contentieux'): ?>
                                        <span class="badge bg-dark p-2">Contentieux</span>
                                        <?php break; ?>
                                    <?php case ('resolu'): ?>
                                        <span class="badge bg-success p-2">Résolu</span>
                                        <?php break; ?>
                                <?php endswitch; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gestion-bancaire\resources\views/impayes/show.blade.php ENDPATH**/ ?>