

<?php $__env->startSection('title', 'Moyens de paiement'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">Gestion des moyens de paiement</h1>
                <a href="<?php echo e(route('moyens-paiement.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nouveau moyen de paiement
                </a>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6>Total</h6>
                    <h3><?php echo e($stats['total']); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6>Cartes</h6>
                    <h3><?php echo e($stats['cartes']); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6>Chéquiers</h6>
                    <h3><?php echo e($stats['chequiers']); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6>Virements</h6>
                    <h3><?php echo e($stats['virements']); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6>Actifs</h6>
                    <h3><?php echo e($stats['actifs']); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h6>Expirés</h6>
                    <h3><?php echo e($stats['expires']); ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="<?php echo e(route('moyens-paiement.index')); ?>" class="row g-3">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Rechercher par n° ou client..." 
                                   value="<?php echo e(request('search')); ?>">
                        </div>
                        <div class="col-md-3">
                            <select name="type" class="form-select">
                                <option value="">Tous les types</option>
                                <option value="carte" <?php echo e(request('type') == 'carte' ? 'selected' : ''); ?>>Carte bancaire</option>
                                <option value="chequier" <?php echo e(request('type') == 'chequier' ? 'selected' : ''); ?>>Chéquier</option>
                                <option value="virement_permanent" <?php echo e(request('type') == 'virement_permanent' ? 'selected' : ''); ?>>Virement permanent</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="statut" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="actif" <?php echo e(request('statut') == 'actif' ? 'selected' : ''); ?>>Actif</option>
                                <option value="bloque" <?php echo e(request('statut') == 'bloque' ? 'selected' : ''); ?>>Bloqué</option>
                                <option value="expire" <?php echo e(request('statut') == 'expire' ? 'selected' : ''); ?>>Expiré</option>
                                <option value="en_attente" <?php echo e(request('statut') == 'en_attente' ? 'selected' : ''); ?>>En attente</option>
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

    <!-- Liste des moyens de paiement -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Numéro</th>
                                    <th>Client</th>
                                    <th>Date émission</th>
                                    <th>Date expiration</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $moyens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $moyen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <?php switch($moyen->type_moyen):
                                            case ('carte'): ?>
                                                <i class="fas fa-credit-card text-primary"></i> Carte
                                                <?php break; ?>
                                            <?php case ('chequier'): ?>
                                                <i class="fas fa-book text-success"></i> Chéquier
                                                <?php break; ?>
                                            <?php case ('virement_permanent'): ?>
                                                <i class="fas fa-exchange-alt text-info"></i> Virement permanent
                                                <?php break; ?>
                                        <?php endswitch; ?>
                                    </td>
                                    <td><strong><?php echo e($moyen->numero); ?></strong></td>
                                    <td>
                                        <a href="<?php echo e(route('clients.show', $moyen->client)); ?>">
                                            <?php echo e($moyen->client->nom); ?> <?php echo e($moyen->client->prenom); ?>

                                        </a>
                                    </td>
                                    <td><?php echo e($moyen->date_emission ? $moyen->date_emission->format('d/m/Y') : '-'); ?></td>
                                    <td><?php echo e($moyen->date_expiration ? $moyen->date_expiration->format('d/m/Y') : '-'); ?></td>
                                    <td>
                                        <?php switch($moyen->statut):
                                            case ('actif'): ?>
                                                <span class="badge bg-success">Actif</span>
                                                <?php break; ?>
                                            <?php case ('bloque'): ?>
                                                <span class="badge bg-danger">Bloqué</span>
                                                <?php break; ?>
                                            <?php case ('expire'): ?>
                                                <span class="badge bg-secondary">Expiré</span>
                                                <?php break; ?>
                                            <?php case ('en_attente'): ?>
                                                <span class="badge bg-warning">En attente</span>
                                                <?php break; ?>
                                        <?php endswitch; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo e(route('moyens-paiement.show', $moyen)); ?>" 
                                               class="btn btn-sm btn-info" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <?php if($moyen->statut == 'actif'): ?>
                                                <form action="<?php echo e(route('moyens-paiement.bloquer', $moyen)); ?>" 
                                                      method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('Bloquer ce moyen de paiement ?')"
                                                            title="Bloquer">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                </form>
                                            <?php elseif($moyen->statut == 'bloque'): ?>
                                                <form action="<?php echo e(route('moyens-paiement.activer', $moyen)); ?>" 
                                                      method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="btn btn-sm btn-success" 
                                                            onclick="return confirm('Activer ce moyen de paiement ?')"
                                                            title="Activer">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        Aucun moyen de paiement trouvé
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        <?php echo e($moyens->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gestion-bancaire\resources\views/moyens-paiement/index.blade.php ENDPATH**/ ?>