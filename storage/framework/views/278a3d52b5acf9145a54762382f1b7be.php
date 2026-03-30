

<?php $__env->startSection('title', 'Liste des comptes'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">Gestion des comptes bancaires</h1>
                <a href="<?php echo e(route('comptes.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nouveau compte
                </a>
            </div>
        </div>
    </div>
<div class="d-flex justify-content-between align-items-center">
    
    <div>
        <!-- BOUTON EXPORT EXCEL -->
        <a href="<?php echo e(route('export.comptes.excel')); ?>" class="btn btn-success me-2">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
        
    </div>
</div>
    <!-- Filtres -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="<?php echo e(route('comptes.index')); ?>" class="row g-3">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Rechercher par n° compte ou client..." 
                                   value="<?php echo e(request('search')); ?>">
                        </div>
                        <div class="col-md-3">
                            <select name="type" class="form-select">
                                <option value="">Tous les types</option>
                                <option value="courant" <?php echo e(request('type') == 'courant' ? 'selected' : ''); ?>>Courant</option>
                                <option value="epargne" <?php echo e(request('type') == 'epargne' ? 'selected' : ''); ?>>Épargne</option>
                                <option value="joint" <?php echo e(request('type') == 'joint' ? 'selected' : ''); ?>>Joint</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="statut" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="actif" <?php echo e(request('statut') == 'actif' ? 'selected' : ''); ?>>Actif</option>
                                <option value="bloque" <?php echo e(request('statut') == 'bloque' ? 'selected' : ''); ?>>Bloqué</option>
                                <option value="ferme" <?php echo e(request('statut') == 'ferme' ? 'selected' : ''); ?>>Fermé</option>
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

    <!-- Liste des comptes -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>N° Compte</th>
                                    <th>Client</th>
                                    <th>Type</th>
                                    <th>Solde</th>
                                    <th>Date ouverture</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $comptes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $compte): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <strong><?php echo e($compte->numero_compte); ?></strong>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('clients.show', $compte->client)); ?>">
                                            <?php echo e($compte->client->nom); ?> <?php echo e($compte->client->prenom); ?>

                                        </a>
                                    </td>
                                    <td>
                                        <?php switch($compte->type_compte):
                                            case ('courant'): ?>
                                                <span class="badge bg-info">Courant</span>
                                                <?php break; ?>
                                            <?php case ('epargne'): ?>
                                                <span class="badge bg-success">Épargne</span>
                                                <?php break; ?>
                                            <?php case ('joint'): ?>
                                                <span class="badge bg-warning">Joint</span>
                                                <?php break; ?>
                                        <?php endswitch; ?>
                                    </td>
                                    <td class="<?php echo e($compte->solde >= 0 ? 'text-success' : 'text-danger'); ?>">
                                        <?php echo e(number_format($compte->solde, 2, ',', ' ')); ?> DH
                                    </td>
                                    <td><?php echo e($compte->date_ouverture->format('d/m/Y')); ?></td>
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
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo e(route('comptes.show', $compte)); ?>" 
                                               class="btn btn-sm btn-info" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('comptes.edit', $compte)); ?>" 
                                               class="btn btn-sm btn-warning" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?php echo e(route('comptes.operations', $compte)); ?>" 
                                               class="btn btn-sm btn-primary" title="Opérations">
                                                <i class="fas fa-history"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        Aucun compte trouvé
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        <?php echo e($comptes->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gestion-bancaire\resources\views/comptes/index.blade.php ENDPATH**/ ?>