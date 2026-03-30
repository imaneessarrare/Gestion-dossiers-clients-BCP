

<?php $__env->startSection('title', 'Liste des crédits'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">Gestion des crédits</h1>
                <a href="<?php echo e(route('credits.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nouveau crédit
                </a>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center">
    
    <div>
        <!-- BOUTON EXPORT EXCEL -->
        <a href="<?php echo e(route('export.credits.excel')); ?>" class="btn btn-success me-2">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
        
    </div>
</div>

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6>Encours total</h6>
                    <h3><?php echo e(number_format($stats['total_encours'], 2, ',', ' ')); ?> DH</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6>Crédits en cours</h6>
                    <h3><?php echo e($stats['nombre_encours']); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6>En retard</h6>
                    <h3><?php echo e($stats['en_retard']); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6>Taux moyen</h6>
                    <h3><?php echo e(number_format($stats['taux_moyen'] ?? 0, 2)); ?>%</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="<?php echo e(route('credits.index')); ?>" class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Rechercher par client..." 
                                   value="<?php echo e(request('search')); ?>">
                        </div>
                        <div class="col-md-4">
                            <select name="statut" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="en_cours" <?php echo e(request('statut') == 'en_cours' ? 'selected' : ''); ?>>En cours</option>
                                <option value="rembourse" <?php echo e(request('statut') == 'rembourse' ? 'selected' : ''); ?>>Remboursé</option>
                                <option value="en_retard" <?php echo e(request('statut') == 'en_retard' ? 'selected' : ''); ?>>En retard</option>
                                <option value="rejete" <?php echo e(request('statut') == 'rejete' ? 'selected' : ''); ?>>Rejeté</option>
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

    <!-- Liste des crédits -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Client</th>
                                    <th>Montant</th>
                                    <th>Taux</th>
                                    <th>Durée</th>
                                    <th>Mensualité</th>
                                    <th>Date début</th>
                                    <th>Date fin</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $credits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $credit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($credit->id_credit); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('clients.show', $credit->client)); ?>">
                                            <?php echo e($credit->client->nom); ?> <?php echo e($credit->client->prenom); ?>

                                        </a>
                                    </td>
                                    <td><?php echo e(number_format($credit->montant, 2, ',', ' ')); ?> DH</td>
                                    <td><?php echo e($credit->taux_interet); ?>%</td>
                                    <td><?php echo e($credit->duree_mois); ?> mois</td>
                                    <td><?php echo e(number_format($credit->calculerMensualite(), 2, ',', ' ')); ?> DH</td>
                                    <td><?php echo e($credit->date_debut->format('d/m/Y')); ?></td>
                                    <td><?php echo e($credit->date_fin->format('d/m/Y')); ?></td>
                                    <td>
                                        <?php switch($credit->statut):
                                            case ('en_cours'): ?>
                                                <span class="badge bg-success">En cours</span>
                                                <?php break; ?>
                                            <?php case ('rembourse'): ?>
                                                <span class="badge bg-info">Remboursé</span>
                                                <?php break; ?>
                                            <?php case ('en_retard'): ?>
                                                <span class="badge bg-danger">En retard</span>
                                                <?php break; ?>
                                            <?php case ('rejete'): ?>
                                                <span class="badge bg-secondary">Rejeté</span>
                                                <?php break; ?>
                                        <?php endswitch; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo e(route('credits.show', $credit)); ?>" 
                                               class="btn btn-sm btn-info" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('credits.echeances', $credit)); ?>" 
                                               class="btn btn-sm btn-primary" title="Échéances">
                                                <i class="fas fa-calendar"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="10" class="text-center text-muted">
                                        Aucun crédit trouvé
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        <?php echo e($credits->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gestion-bancaire\resources\views/credits/index.blade.php ENDPATH**/ ?>