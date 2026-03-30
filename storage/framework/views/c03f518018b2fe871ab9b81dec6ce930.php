

<?php $__env->startSection('title', 'Liste des clients'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">Gestion des clients</h1>
                <a href="<?php echo e(route('clients.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nouveau client
                </a>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center">
    
    <div>
        <!-- BOUTON EXPORT EXCEL -->
        <a href="<?php echo e(route('export.clients.excel')); ?>" class="btn btn-success me-2">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
        
    </div>
</div>

    <!-- Recherche -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="<?php echo e(route('clients.index')); ?>" class="row g-3">
                        <div class="col-md-10">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Rechercher par nom, prénom, CIN ou email..." 
                                   value="<?php echo e(request('search')); ?>">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-secondary w-100">
                                <i class="fas fa-search"></i> Rechercher
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des clients -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Nom & Prénom</th>
                                    <th>CIN</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>Comptes</th>
                                    <th>Impayés</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($client->id_client); ?></td>
                                    <td>
                                        <strong><?php echo e($client->nom); ?> <?php echo e($client->prenom); ?></strong>
                                    </td>
                                    <td><?php echo e($client->cin); ?></td>
                                    <td><?php echo e($client->email); ?></td>
                                    <td><?php echo e($client->telephone); ?></td>
                                    <td>
                                        <span class="badge bg-info"><?php echo e($client->comptes_count ?? 0); ?></span>
                                    </td>
                                    <td>
                                        <?php if(($client->impayes_count ?? 0) > 0): ?>
                                            <span class="badge bg-danger"><?php echo e($client->impayes_count); ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-success">0</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($client->statut == 'actif'): ?>
                                            <span class="badge bg-success">Actif</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Inactif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo e(route('clients.show', $client)); ?>" 
                                               class="btn btn-sm btn-info" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('clients.edit', $client)); ?>" 
                                               class="btn btn-sm btn-warning" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    title="Archiver"
                                                    onclick="if(confirm('Archiver ce client ?')) { document.getElementById('delete-form-<?php echo e($client->id_client); ?>').submit(); }">
                                                <i class="fas fa-archive"></i>
                                            </button>
                                            <form id="delete-form-<?php echo e($client->id_client); ?>" 
                                                  action="<?php echo e(route('clients.destroy', $client)); ?>" 
                                                  method="POST" style="display: none;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="9" class="text-center text-muted">
                                        Aucun client trouvé
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        <?php echo e($clients->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gestion-bancaire\resources\views/clients/index.blade.php ENDPATH**/ ?>