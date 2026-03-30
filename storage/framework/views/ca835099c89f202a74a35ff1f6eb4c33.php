

<?php $__env->startSection('title', 'Gestion des impayés'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center">
    <h1 class="h3">Gestion des impayés</h1>
    <a href="<?php echo e(route('impayes.create')); ?>" class="btn btn-danger">
        <i class="fas fa-plus"></i> Nouvel impayé
    </a>
</div>
<div class="d-flex justify-content-between align-items-center">
    
    <div>
        <!-- BOUTON EXPORT EXCEL -->
        <a href="<?php echo e(route('export.impayes.excel')); ?>" class="btn btn-success">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
    </div>
</div>
    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h6>Total impayés</h6>
                    <h3><?php echo e(number_format($stats['total'] ?? 0, 2, ',', ' ')); ?> DH</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6>Nombre d'impayés</h6>
                    <h3><?php echo e($stats['nombre'] ?? 0); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6>Montant moyen</h6>
                    <h3><?php echo e(number_format($stats['moyenne'] ?? 0, 2, ',', ' ')); ?> DH</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-secondary text-white">
                <div class="card-body">
                    <h6>Répartition</h6>
                    <?php $__currentLoopData = $stats['par_statut'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statut => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="badge bg-light text-dark me-1"><?php echo e($statut); ?>: <?php echo e($count); ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="<?php echo e(route('impayes.index')); ?>" class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Rechercher par client..." 
                                   value="<?php echo e(request('search')); ?>">
                        </div>
                        <div class="col-md-4">
                            <select name="statut" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="nouveau" <?php echo e(request('statut') == 'nouveau' ? 'selected' : ''); ?>>Nouveau</option>
                                <option value="en_relance" <?php echo e(request('statut') == 'en_relance' ? 'selected' : ''); ?>>En relance</option>
                                <option value="contentieux" <?php echo e(request('statut') == 'contentieux' ? 'selected' : ''); ?>>Contentieux</option>
                                <option value="resolu" <?php echo e(request('statut') == 'resolu' ? 'selected' : ''); ?>>Résolu</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-secondary w-100">
                                <i class="fas fa-filter"></i> Filtrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des impayés -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Liste des impayés</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Client</th>
                                    <th>Montant</th>
                                    <th>Date impayé</th>
                                    <th>Jours de retard</th>
                                    <th>Statut</th>
                                    <th>Crédit lié</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $impayes ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $impaye): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($impaye->id_impaye); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('clients.show', $impaye->client)); ?>">
                                            <?php echo e($impaye->client->nom); ?> <?php echo e($impaye->client->prenom); ?>

                                        </a>
                                    </td>
                                    <td class="text-danger">
                                        <strong><?php echo e(number_format($impaye->montant, 2, ',', ' ')); ?> DH</strong>
                                    </td>
                                    <td><?php echo e($impaye->date_impaye->format('d/m/Y')); ?></td>
                                    <td>
                                        <span class="badge bg-danger">
                                            <?php echo e($impaye->date_impaye->diffInDays(now())); ?> jours
                                        </span>
                                    </td>
                                    <td>
                                        <?php switch($impaye->statut):
                                            case ('nouveau'): ?>
                                                <span class="badge bg-danger">Nouveau</span>
                                                <?php break; ?>
                                            <?php case ('en_relance'): ?>
                                                <span class="badge bg-warning">En relance</span>
                                                <?php break; ?>
                                            <?php case ('contentieux'): ?>
                                                <span class="badge bg-dark">Contentieux</span>
                                                <?php break; ?>
                                            <?php case ('resolu'): ?>
                                                <span class="badge bg-success">Résolu</span>
                                                <?php break; ?>
                                        <?php endswitch; ?>
                                    </td>
                                    <td>
                                        <?php if($impaye->credit): ?>
                                            <a href="<?php echo e(route('credits.show', $impaye->credit)); ?>">
                                                Crédit #<?php echo e($impaye->credit->id_credit); ?>

                                            </a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo e(route('impayes.show', $impaye)); ?>" 
                                               class="btn btn-sm btn-info" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Aucun impayé trouvé
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        <?php echo e($impayes->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gestion-bancaire\resources\views/impayes/index.blade.php ENDPATH**/ ?>