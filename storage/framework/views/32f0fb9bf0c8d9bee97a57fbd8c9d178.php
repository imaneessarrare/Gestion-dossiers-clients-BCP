

<?php $__env->startSection('title', 'Détail du client'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">Fiche client</h1>
                <div>
                    <a href="<?php echo e(route('clients.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                    <a href="<?php echo e(route('clients.edit', $client)); ?>" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                </div>
            </div>
        </div>
    </div>
<div class="d-flex justify-content-between align-items-center">
    
    <div>
        <!-- BOUTON EXPORT PDF -->
        <a href="<?php echo e(route('export.client.pdf', $client)); ?>" class="btn btn-danger me-2">
            <i class="fas fa-file-pdf"></i> Exporter PDF
        </a>
        <a href="<?php echo e(route('clients.edit', $client)); ?>" class="btn btn-warning">
            <i class="fas fa-edit"></i> Modifier
        </a>
    </div>
</div>
    <!-- Informations client -->
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informations personnelles</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Nom complet</th>
                            <td><strong><?php echo e($client->nom); ?> <?php echo e($client->prenom); ?></strong></td>
                        </tr>
                        <tr>
                            <th>Date de naissance</th>
                            <td><?php echo e($client->date_naissance->format('d/m/Y')); ?></td>
                        </tr>
                        <tr>
                            <th>CIN</th>
                            <td><?php echo e($client->cin); ?></td>
                        </tr>
                        <tr>
                            <th>Adresse</th>
                            <td><?php echo e($client->adresse ?? 'Non renseignée'); ?></td>
                        </tr>
                        <tr>
                            <th>Téléphone</th>
                            <td><?php echo e($client->telephone ?? 'Non renseigné'); ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?php echo e($client->email ?? 'Non renseigné'); ?></td>
                        </tr>
                        <tr>
                            <th>Situation professionnelle</th>
                            <td><?php echo e($client->situation_professionnelle ?? 'Non renseignée'); ?></td>
                        </tr>
                        <tr>
                            <th>Revenus mensuels</th>
                            <td><?php echo e($client->revenus_mensuels ? number_format($client->revenus_mensuels, 2, ',', ' ') . ' DH' : 'Non renseigné'); ?></td>
                        </tr>
                        <tr>
                            <th>Statut</th>
                            <td>
                                <?php if($client->statut == 'actif'): ?>
                                    <span class="badge bg-success">Actif</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inactif</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Résumé financier</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="p-3 border rounded">
                                <h6>Comptes</h6>
                                <h3><?php echo e($client->comptes->count()); ?></h3>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="p-3 border rounded">
                                <h6>Crédits</h6>
                                <h3><?php echo e($client->credits->count()); ?></h3>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 border rounded">
                                <h6>Impayés</h6>
                                <h3 class="text-danger"><?php echo e($client->impayes->count()); ?></h3>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 border rounded">
                                <h6>Solde total</h6>
                                <h3 class="<?php echo e($client->comptes->sum('solde') >= 0 ? 'text-success' : 'text-danger'); ?>">
                                    <?php echo e(number_format($client->comptes->sum('solde'), 2, ',', ' ')); ?> DH
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Onglets -->
    <div class="row">
        <div class="col-12">
            <ul class="nav nav-tabs" id="clientTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="comptes-tab" data-bs-toggle="tab" data-bs-target="#comptes" type="button" role="tab">
                        Comptes (<?php echo e($client->comptes->count()); ?>)
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="credits-tab" data-bs-toggle="tab" data-bs-target="#credits" type="button" role="tab">
                        Crédits (<?php echo e($client->credits->count()); ?>)
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="impayes-tab" data-bs-toggle="tab" data-bs-target="#impayes" type="button" role="tab">
                        Impayés (<?php echo e($client->impayes->count()); ?>)
                    </button>
                </li>
            </ul>
            
            <div class="tab-content p-3 border border-top-0 rounded-bottom" id="clientTabsContent">
                <!-- Comptes -->
                <div class="tab-pane fade show active" id="comptes" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>N° Compte</th>
                                    <th>Type</th>
                                    <th>Solde</th>
                                    <th>Date ouverture</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $client->comptes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $compte): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($compte->numero_compte); ?></td>
                                    <td><?php echo e(ucfirst($compte->type_compte)); ?></td>
                                    <td class="<?php echo e($compte->solde >= 0 ? 'text-success' : 'text-danger'); ?>">
                                        <?php echo e(number_format($compte->solde, 2, ',', ' ')); ?> DH
                                    </td>
                                    <td><?php echo e($compte->date_ouverture->format('d/m/Y')); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo e($compte->statut == 'actif' ? 'success' : ($compte->statut == 'bloque' ? 'warning' : 'danger')); ?>">
                                            <?php echo e(ucfirst($compte->statut)); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('comptes.show', $compte)); ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center">Aucun compte</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Crédits -->
                <div class="tab-pane fade" id="credits" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Montant</th>
                                    <th>Taux</th>
                                    <th>Durée</th>
                                    <th>Date début</th>
                                    <th>Date fin</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $client->credits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $credit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e(number_format($credit->montant, 2, ',', ' ')); ?> €</td>
                                    <td><?php echo e($credit->taux_interet); ?>%</td>
                                    <td><?php echo e($credit->duree_mois); ?> mois</td>
                                    <td><?php echo e($credit->date_debut->format('d/m/Y')); ?></td>
                                    <td><?php echo e($credit->date_fin->format('d/m/Y')); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo e($credit->statut == 'en_cours' ? 'success' : ($credit->statut == 'en_retard' ? 'danger' : 'secondary')); ?>">
                                            <?php echo e($credit->statut); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('credits.show', $credit)); ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="text-center">Aucun crédit</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Impayés -->
                <div class="tab-pane fade" id="impayes" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Montant</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $client->impayes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $impaye): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="text-danger"><?php echo e(number_format($impaye->montant, 2, ',', ' ')); ?> DH</td>
                                    <td><?php echo e($impaye->date_impaye->format('d/m/Y')); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo e($impaye->statut == 'nouveau' ? 'danger' : ($impaye->statut == 'en_relance' ? 'warning' : 'success')); ?>">
                                            <?php echo e($impaye->statut); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e($impaye->notes ?? '-'); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="text-center">Aucun impayé</td>
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gestion-bancaire\resources\views/clients/show.blade.php ENDPATH**/ ?>