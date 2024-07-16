

<?php $__env->startPush('vite'); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/demande.js',]); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="container my-2">
    
    
    <div class="d-flex justify-content-center">

        <div class="card w-fit-content hidden " aria-hidden="true" id="form-conger">
            <div class="card-header py-0">
                <h6 class="d-flex justify-content-center py-2 my-0">
                    <?php echo e(__('Demander un Congé')); ?>

                </h6>
            </div>
            <div class="card-body">
                <div class="shadow p-2 border-black border rounded mb-2 text-center">
                    <span class=""><?php echo e(__("Solde Congé Actuelle:")); ?> </span>
                    <strong><?php echo e($currentUser->solde_conge . __(' Jours')); ?> </strong>
                </div>
                <form action="<?php echo e(route('demandesconge.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="form-floating mb-3">
                        <input required type="number" class="form-control" name="matricule" <?php if(true): echo 'readonly'; endif; ?>
                            placeholder="n" value="<?php echo e(auth()->user()->matricule); ?>" />
                        <label for="matricule">Matricule</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input value="<?php echo e($currentUser->nom); ?>" <?php if(true): echo 'readonly'; endif; ?> required type="text" class="form-control"
                            name="nom" placeholder="n" />
                        <label for="Nom">Nom</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input value="<?php echo e($currentUser->prénom); ?>" <?php if(true): echo 'readonly'; endif; ?> required type="text"
                            class="form-control" name="prénom" placeholder="n" />
                        <label for="Prénom">Prénom</label>
                    </div>
                    <div class="row">
                        <div class="col-6 form-floating pe-1 mb-3">
                            <input required value="<?php echo e(old('date_debut')); ?>" type="date" class="form-control"
                                name="date_debut" placeholder="dd/mm/yyyy" />
                            <label for="date-debut"> Date début</label>
                        </div>
                        <div class="col-6 form-floating ps-1 mb-3">
                            <input required value="<?php echo e(old('date_fin')); ?>" type="date" class="form-control" name="date_fin"
                                placeholder="dd/mm/yyyy" />
                            <label for=" date-fin"> Date fin</label>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="n" name="motif" required value="<?php echo e(old('motif')); ?>" />
                        <label for="motif">Motif</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="n" name="Autre" value="<?php echo e(old('Autre')); ?>" />
                        <label for="Autre"><?php echo e(__('Autre (Optionnel)')); ?></label>
                    </div>

                    <div class="float-end">
                        <input class="btn btn-success" <?php if(auth()->user()->solde_conge <= 0 || $currentUser->
                            hasDemandes()): ?> <?php if(true): echo 'disabled'; endif; ?> <?php endif; ?> type="submit" value="Confirmer" />
                            <input class="btn btn-danger " type="reset" id="annuler-form-conger" value="Annuler" />
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between my-3">
        <h2 class="">
            <b class="border-bottom border-black border-2 no-break"><em><?php echo e(__('Demandes Congé')); ?> </em></b>
        </h2>
        <button class="btn btn-warning" id="demander-conger">
            <i class="fa fa-plus me-2"></i> <?php echo e(__('Demander un Congé')); ?>

        </button>
    </div>

    

    <div class="overflow-x-scroll">

        <table id="demandes" class=" table table-striped">
            <thead>
                <tr>
                    <th class="no-break">N°</th>

                    <th class="no-break">Status</th>
                    <th class="no-break">Nom</th>
                    <th class="no-break">Prénom</th>
                    <th class="no-break">date début</th>
                    <th class="no-break">date Fin</th>
                    <!-- <th class="no-break">Solde congé (actuel)</th> -->
                    <th class="no-break">N.j décompter</th>
                    <th class="no-break">Motif</th>
                    
                        <th class="no-break">Actions</th>
                    
                    <th class="no-break">date creation</th>

                </tr>
            </thead>
            <tbody>
                <?php if($demandesConge): ?>
                <?php $__currentLoopData = $demandesConge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $demandeCg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                

                <tr>
                    <td><?php echo e($demandeCg->id); ?> </td>
                    
                    <td class="status"> 
                        <span class="d-inline-block pop-refus" tabindex="0" data-bs-toggle="popover"
                            data-bs-placement="top" data-bs-trigger="hover focus"
                            data-bs-content="<?php echo e($demandeCg->status . ($demandeCg->raison_refus ? (":\n" . $demandeCg->raison_refus) : '')); ?>">  
                            <?php if($demandeCg->status === 'Refusé'): ?>
                            
                            <i class="fa fa-circle-xmark status-red "></i>
                            <?php elseif($demandeCg->v_rh || $demandeCg->status == 'Valider'): ?>
                            <i class="fa fa-circle-check status-green"></i>
                            
                            <?php elseif($demandeCg->v_dir): ?>
                            <i class="fa fa-circle status-orange"></i>
                            <?php elseif($demandeCg->v_resp): ?>
                            <i class="fa fa-circle status-yellow"></i>
                            <?php else: ?>
                            <i class="fa fa-circle status-gray"></i>
                            <?php endif; ?>
                        </span>
                    </td>
                    <td><?php echo e($demandeCg->nom); ?></td>
                    <td><?php echo e($demandeCg->prénom); ?></td>
                    <td><?php echo e($demande->toDate($demandeCg->start_date)->format('d-M-Y')); ?></td>
                    <td><?php echo e($demande->toDate($demandeCg->end_date)->format('d-M-Y')); ?></td>
                    <td><?php echo e($demandeCg->nj_decompter); ?></td>
                    <td><?php echo e($demandeCg->motif); ?></td>
                    
                    <td class="d-flex justify-content-center text-nowrap">
                        <form action="<?php echo e(route('demandeconge.update', $demandeCg->id)); ?>" method="POST"
                            class="decision-form">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <?php if(!$currentUser->isOuvrier()): ?>
                        <?php if(
                                ($demande->dmOwnerOuv($demandeCg->d_id) && (
                                    ($currentUser->isResponsable() && $verifierDC->isAcceptedByResp($demandeCg->id)) ||
                                    ($currentUser->isDirecteur() && $verifierDC->isAcceptedByDir($demandeCg->id)) ||
                                    ($currentUser->isRH() && $verifierDC->isAcceptedByRH($demandeCg->id)) ||
                                    ($currentUser->isDirecteur() && !$verifierDC->isAcceptedByResp($demandeCg->id)) ||
                                    ($currentUser->isRH() && !$verifierDC->isAcceptedByDir($demandeCg->id)) ||
                                    ($verifierDC->isAcceptedByRH($demandeCg->id))
                                )) ||
                                ($demande->dmOwnerResp($demandeCg->d_id) && (
                                    ($currentUser->isResponsable()) ||
                                    ($currentUser->isDirecteur() && $verifierDC->isAcceptedByDir($demandeCg->id))
                                )) ||
                                ($demande->dmOwnerDir($demandeCg->d_id) && (
                                    ($currentUser->isDirecteur() && !$verifierDC->isAcceptedByRH($demandeCg->id))
                                )) ||
                                ($demande->dmOwnerrh($demandeCg->d_id) && (
                                    ($currentUser->isRH() && !$verifierDC->isAcceptedByDir($demandeCg->id))
                                )) ||
                                ($demande->areRefused($demandeCg->d_id) || $demande->areValidated($demandeCg->d_id))
                            ): ?>
                                <a class="btn btn-success accept-button disabled">
                                    <i class="fa fa-check"></i>
                                </a>
                            <?php else: ?>
                                <a class="btn btn-success accept-button">
                                    <i class="fa fa-check"></i>
                                </a>
                            <?php endif; ?>

                            <a class="btn btn-danger refus-button
                                <?php if($demande->areRefused($demandeCg->d_id) || $demande->areValidated($demandeCg->d_id) 
                                || $demande->dmOwnerResp($demandeCg->d_id) && $currentUser->isResponsable() 
                                || $demande->dmOwnerDir($demandeCg->d_id) && $currentUser->isDirecteur() 
                                || $demande->dmOwnerRH($demandeCg->d_id) && $currentUser->isRH()
                                || $verifierDC->isAcceptedByResp($demandeCg->id) && $currentUser->isResponsable()
                                || $verifierDC->isAcceptedByDir($demandeCg->id) && $currentUser->isDirecteur()
                                || $verifierDC->isAcceptedByRH($demandeCg->id) && $currentUser->isRH()
                                ): ?>
                                    disabled
                                <?php endif; ?>
                            ">
                                <i class="fa fa-xmark"></i>
                            </a> <?php endif; ?>
                            
                            <a href="<?php echo e(route('demandeConge.downloadConge', $demandeCg->id)); ?>" class="btn btn-primary <?php if(!$demande->areValidated($demandeCg->d_id) || $demande->areRefused($demandeCg->d_id)): ?> disabled  <?php endif; ?> "> 
                                <i class="fa fa-download"></i>
                            </a>
                        </form>
                        
                    </td>
                    
                    <td><?php echo e($demande->toDate($demandeCg->dcreated_at)->format('d-m-y h:m')); ?> </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="position-absolute shadow top-50 start-50 translate-middle hidden" id="refus-card">
        <div class="card width-fit-content">
            <div class="card-header text-center">
                <b>Raison de Refus</b>
                <button type="button" class="btn-close float-end text-reset" id="annuler-refus"
                    aria-label="Close"></button>
            </div>
            <div class="card-body p-2 pt-0">
                
                <label for="raison-refus"></label>
                <textarea name="" id="raison-refus" class="my-0" cols="30" rows="4" required></textarea>
                <button id="confirme-refus" class="btn btn-danger mx-auto mb-2 d-block"><i class="fa fa-xmark"></i>
                    Refuser</button>
            </div>
        </div>
    </div>
</section>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\pc\Desktop\somasteel_espace_employeV0.1\resources\views/demandes/index.blade.php ENDPATH**/ ?>