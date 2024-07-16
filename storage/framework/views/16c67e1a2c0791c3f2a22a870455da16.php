<?php $__env->startPush('vite'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/login.js'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div id="background" style="background: linear-gradient(rgba(15,23,43, .7), rgba(15,23,43, .8)), url(<?php echo e(asset('images/somasteel.jpg')); ?>) center center/cover;">
        
    <form method="POST" action="<?php echo e(route('login')); ?>">
        <?php echo csrf_field(); ?>

        <div class="login-card pt-0">
            <a class="login"><?php echo e(__("S'identifier")); ?> </a>

            <div class="inputBox">
                <input id="matricule" type="text" class="<?php $__errorArgs = ['matricule'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="matricule" value="<?php echo e(old('matricule')); ?>" <?php if(true): echo 'required'; endif; ?> autocomplete="matricule" autofocus>
                <span class="user px-2"><?php echo e(__('Matricule')); ?> </span>
                <?php $__errorArgs = ['matricule'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert">
                        <strong><?php echo e(__('Matricule ou Mot the pass incorrect!')); ?></strong>
                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                
            </div>

            <div class="inputBox">
                <input id="password" type="password" class="<?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required autocomplete="current-password">
                <!-- <button><i class="fa "></i></button> -->
                <span class="mdp px-2"><?php echo e(__('Mot de pass')); ?> </span>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert">
                        <strong><?php echo e('Matricule ou Mot the pass incorrect!'); ?></strong>
                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <input type="checkbox" hidden id="see-password" placeholder="">
                <label for="see-password" id="see-password-label" class="fa fa-eye-slash pt-3"></label>
            </div>
            <div>
                <input class="form-check-input" type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                <label class="form-check-label black-checkbox-label" for="remember">
                    <?php echo e(__('Souvenir de Moi')); ?>

                </label>

                <?php if(Route::has('password.request')): ?>
                    <a href="<?php echo e(route('password.request')); ?>" class="location-link d-block my-2"><?php echo e(__('Mot de passe oublié?')); ?> </a>
                <?php endif; ?>
            </div>
            <button type="submit" class="enter mb-3"><?php echo e(__('Entrer')); ?> </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
    
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\pc\Desktop\somasteel_espace_employeV0.1\resources\views/auth/login.blade.php ENDPATH**/ ?>