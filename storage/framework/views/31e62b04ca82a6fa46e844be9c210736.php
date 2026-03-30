

<?php $__env->startSection('title', 'Modifier le compte'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">Modifier le compte</h1>
                <a href="<?php echo e(route('comptes.show', $compte)); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('comptes.update', $compte)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="mb-3">
                            <label class="form-label">Client</label>
                            <input type="text" class="form-control" 
                                   value="<?php echo e($compte->client->nom); ?> <?php echo e($compte->client->prenom); ?>" readonly disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Numéro de compte</label>
                            <input type="text" class="form-control" value="<?php echo e($compte->numero_compte); ?>" readonly disabled>
                        </div>

                        <div class="mb-3">
                            <label for="type_compte" class="form-label">Type de compte</label>
                            <select name="type_compte" id="type_compte" class="form-select <?php $__errorArgs = ['type_compte'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="courant" <?php echo e($compte->type_compte == 'courant' ? 'selected' : ''); ?>>Compte courant</option>
                                <option value="epargne" <?php echo e($compte->type_compte == 'epargne' ? 'selected' : ''); ?>>Compte épargne</option>
                                <option value="joint" <?php echo e($compte->type_compte == 'joint' ? 'selected' : ''); ?>>Compte joint</option>
                            </select>
                            <?php $__errorArgs = ['type_compte'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label for="statut" class="form-label">Statut</label>
                            <select name="statut" id="statut" class="form-select <?php $__errorArgs = ['statut'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="actif" <?php echo e($compte->statut == 'actif' ? 'selected' : ''); ?>>Actif</option>
                                <option value="bloque" <?php echo e($compte->statut == 'bloque' ? 'selected' : ''); ?>>Bloqué</option>
                                <option value="ferme" <?php echo e($compte->statut == 'ferme' ? 'selected' : ''); ?>>Fermé</option>
                            </select>
                            <?php $__errorArgs = ['statut'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Mettre à jour
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gestion-bancaire\resources\views/comptes/edit.blade.php ENDPATH**/ ?>