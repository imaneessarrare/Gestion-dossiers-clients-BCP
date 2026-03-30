

<?php $__env->startSection('title', 'Nouveau moyen de paiement'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">Ajouter un moyen de paiement</h1>
                <a href="<?php echo e(route('moyens-paiement.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('moyens-paiement.store')); ?>" id="moyenForm">
                        <?php echo csrf_field(); ?>

                        <div class="mb-3">
                            <label for="id_client" class="form-label">Client <span class="text-danger">*</span></label>
                            <select name="id_client" id="id_client" class="form-select <?php $__errorArgs = ['id_client'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">Sélectionnez un client</option>
                                <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($client->id_client); ?>" <?php echo e(old('id_client') == $client->id_client ? 'selected' : ''); ?>>
                                        <?php echo e($client->nom); ?> <?php echo e($client->prenom); ?> - <?php echo e($client->cin); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['id_client'];
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
                            <label for="type_moyen" class="form-label">Type de moyen <span class="text-danger">*</span></label>
                            <select name="type_moyen" id="type_moyen" class="form-select <?php $__errorArgs = ['type_moyen'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">Sélectionnez un type</option>
                                <option value="carte" <?php echo e(old('type_moyen') == 'carte' ? 'selected' : ''); ?>>Carte bancaire</option>
                                <option value="chequier" <?php echo e(old('type_moyen') == 'chequier' ? 'selected' : ''); ?>>Chéquier</option>
                                <option value="virement_permanent" <?php echo e(old('type_moyen') == 'virement_permanent' ? 'selected' : ''); ?>>Virement permanent</option>
                            </select>
                            <?php $__errorArgs = ['type_moyen'];
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

                        <div class="mb-3" id="numeroField">
                            <label for="numero" class="form-label">Numéro de carte</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['numero'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="numero" name="numero" value="<?php echo e(old('numero')); ?>"
                                   placeholder="1234 5678 9012 3456">
                            <?php $__errorArgs = ['numero'];
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

                        <div class="mb-3" id="expirationField">
                            <label for="date_expiration" class="form-label">Date d'expiration</label>
                            <input type="month" class="form-control <?php $__errorArgs = ['date_expiration'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="date_expiration" name="date_expiration" value="<?php echo e(old('date_expiration')); ?>">
                            <?php $__errorArgs = ['date_expiration'];
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
                            <i class="fas fa-save"></i> Ajouter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type_moyen');
    const numeroField = document.getElementById('numeroField');
    const expirationField = document.getElementById('expirationField');
    
    function toggleFields() {
        const type = typeSelect.value;
        
        if (type === 'carte') {
            numeroField.style.display = 'block';
            expirationField.style.display = 'block';
            document.getElementById('numero').required = true;
            document.getElementById('date_expiration').required = true;
        } else {
            numeroField.style.display = 'none';
            expirationField.style.display = 'none';
            document.getElementById('numero').required = false;
            document.getElementById('date_expiration').required = false;
        }
    }
    
    typeSelect.addEventListener('change', toggleFields);
    toggleFields(); // Initial call
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gestion-bancaire\resources\views/moyens-paiement/create.blade.php ENDPATH**/ ?>