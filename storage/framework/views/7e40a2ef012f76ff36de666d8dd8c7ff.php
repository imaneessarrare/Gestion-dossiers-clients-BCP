

<?php $__env->startSection('title', 'Nouveau crédit'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">Accorder un nouveau crédit</h1>
                <a href="<?php echo e(route('credits.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('credits.store')); ?>" id="creditForm">
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

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="montant" class="form-label">Montant (DH) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" min="1000" 
                                       class="form-control <?php $__errorArgs = ['montant'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="montant" name="montant" value="<?php echo e(old('montant')); ?>" required>
                                <?php $__errorArgs = ['montant'];
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

                            <div class="col-md-6 mb-3">
                                <label for="taux_interet" class="form-label">Taux d'intérêt (%) <span class="text-danger">*</span></label>
                                <input type="number" step="0.1" min="0" max="20" 
                                       class="form-control <?php $__errorArgs = ['taux_interet'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="taux_interet" name="taux_interet" value="<?php echo e(old('taux_interet', 5)); ?>" required>
                                <?php $__errorArgs = ['taux_interet'];
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
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="duree_mois" class="form-label">Durée (mois) <span class="text-danger">*</span></label>
                                <select name="duree_mois" id="duree_mois" class="form-select <?php $__errorArgs = ['duree_mois'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <option value="">Sélectionnez</option>
                                    <option value="6" <?php echo e(old('duree_mois') == 6 ? 'selected' : ''); ?>>6 mois</option>
                                    <option value="12" <?php echo e(old('duree_mois') == 12 ? 'selected' : ''); ?>>12 mois</option>
                                    <option value="24" <?php echo e(old('duree_mois') == 24 ? 'selected' : ''); ?>>24 mois</option>
                                    <option value="36" <?php echo e(old('duree_mois') == 36 ? 'selected' : ''); ?>>36 mois</option>
                                    <option value="48" <?php echo e(old('duree_mois') == 48 ? 'selected' : ''); ?>>48 mois</option>
                                    <option value="60" <?php echo e(old('duree_mois') == 60 ? 'selected' : ''); ?>>60 mois</option>
                                </select>
                                <?php $__errorArgs = ['duree_mois'];
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

                            <div class="col-md-6 mb-3">
                                <label for="date_debut" class="form-label">Date de début <span class="text-danger">*</span></label>
                                <input type="date" class="form-control <?php $__errorArgs = ['date_debut'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="date_debut" name="date_debut" value="<?php echo e(old('date_debut', date('Y-m-d'))); ?>" required>
                                <?php $__errorArgs = ['date_debut'];
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
                        </div>

                        <!-- Simulation -->
                        <div class="card bg-light mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Simulation</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <p class="mb-1">Mensualité</p>
                                        <h4 id="simulationMensualite">0,00 DH</h4>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-1">Total à rembourser</p>
                                        <h4 id="simulationTotal">0,00 DH</h4>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-1">Intérêts totaux</p>
                                        <h4 id="simulationInterets">0,00 DH</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Accorder le crédit
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
    const montantInput = document.getElementById('montant');
    const tauxInput = document.getElementById('taux_interet');
    const dureeSelect = document.getElementById('duree_mois');
    
    function calculerSimulation() {
        const montant = parseFloat(montantInput.value) || 0;
        const taux = parseFloat(tauxInput.value) || 0;
        const duree = parseInt(dureeSelect.value) || 0;
        
        if (montant > 0 && taux > 0 && duree > 0) {
            const tauxMensuel = taux / 100 / 12;
            const mensualite = montant * tauxMensuel * Math.pow(1 + tauxMensuel, duree) / (Math.pow(1 + tauxMensuel, duree) - 1);
            const total = mensualite * duree;
            const interets = total - montant;
            
            document.getElementById('simulationMensualite').textContent = mensualite.toFixed(2).replace('.', ',') + ' DH';
            document.getElementById('simulationTotal').textContent = total.toFixed(2).replace('.', ',') + ' DH';
            document.getElementById('simulationInterets').textContent = interets.toFixed(2).replace('.', ',') + ' DH';
        }
    }
    
    montantInput.addEventListener('input', calculerSimulation);
    tauxInput.addEventListener('input', calculerSimulation);
    dureeSelect.addEventListener('change', calculerSimulation);
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gestion-bancaire\resources\views/credits/create.blade.php ENDPATH**/ ?>