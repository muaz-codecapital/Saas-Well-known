<?php $__env->startSection('content'); ?>
    <div class="row mb-2">
        <div class="col">
            <h5 class=" text-secondary fw-bolder">
                <?php echo e(__('Subscription Plan List')); ?>

            </h5>
            <p class="text-muted"><?php echo e(__('Create, edit or delete the plans')); ?></p>
        </div>
        <div class="col text-end">
            <a href="/subscription-plan" type="button" class="btn btn-info"><?php echo e(__('Create Plan')); ?></a>
        </div>
    </div>

    <div class="row">
        <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4  mb-4 ">
                <div class="card ">
                    <div class="card-header text-center ">
                        <h5 class="text-purple opacity-8 text mb-2"><?php echo e($plan->name); ?></h5>
                        <p><?php echo $plan->description; ?></p>
                        <span>
                            <h4 class="font-weight-bolder">
                           <?php echo e(formatCurrency($plan->price_monthly,getWorkspaceCurrency($settings))); ?> /<span><small
                                        class=" text-sm text-warning text-uppercase"><?php echo e(__(' month')); ?></small></span>
                            </h4>
                        </span>
                        <h4 class="mt-0">
                            <?php echo e(formatCurrency($plan->price_yearly,getWorkspaceCurrency($settings))); ?> /<span><small
                                    class="text-sm  text-uppercase text-warning"><?php echo e(__(' year')); ?></small></span>
                        </h4>
                    </div>
                    <div class="card-body mx-auto pt-0">

                        <?php if($plan->features): ?>
                            <?php $__currentLoopData = json_decode($plan->features); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <div class="justify-content-start d-flex px-2 py-1">
                                    <div>
                                        <i class="icon icon-shape text-center icon-xs rounded-circle fas fa-check bg-purple-light text-purple text-sm"></i>
                                    </div>
                                    <div class="ps-2">
                                        <span class="text-sm"><?php echo e($feature); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

                    </div>
                    <div class="card-footer text-center pt-0">
                        <a href="/subscription-plan?id=<?php echo e($plan->id); ?>" type="button"
                           class="btn btn-info mt-3 btn-md "><?php echo e(__('Edit')); ?></a>
                        <a href="/delete/subscription-plan/<?php echo e($plan->id); ?>" type="button"
                           class="btn btn-warning btn-md mt-3"><?php echo e(__('Delete')); ?></a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.super-admin-portal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/freylphj/suiteup.grsventures.ltd/resources/views/super-admin/plans.blade.php ENDPATH**/ ?>