<?php $__env->startSection('content'); ?>
    <div class=" row">
        <div class="col">
            <h5 class="mb-2 text-secondary fw-bolder">
                <?php echo e(__('Business Plans')); ?>

            </h5>
        </div>
        <div class="col text-end">
            <a href="/write-business-plan" type="button" class="btn btn-info">
                <?php echo e(__('Write your Business Plan')); ?>

            </a>
        </div>
    </div>
    <div class="row " data-masonry='{"percentPosition": true }'>

        <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-gradient-dark">
                        <div class="text-end">
                            <div class="dropstart">
                                <a href="javascript:" class="text-secondary" id="dropdownMarketingCard"
                                   data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-lg-start px-2 py-3"
                                    aria-labelledby="dropdownMarketingCard">
                                    <li><a class="dropdown-item border-radius-md"
                                           href="/write-business-plan?id=<?php echo e($plan->id); ?>"><?php echo e(__('Edit')); ?></a></li>

                                    <li><a class="dropdown-item border-radius-md"
                                           href="/view-business-plan?id=<?php echo e($plan->id); ?>"><?php echo e(__('See Details')); ?></a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item border-radius-md text-danger"
                                           href="/delete/business-plan/<?php echo e($plan->id); ?>"><?php echo e(__('Delete')); ?></a></li>
                                </ul>
                            </div>
                        </div>

                        <?php if(!empty($plan->logo)): ?>
                            <img src="<?php echo e(PUBLIC_DIR); ?>/uploads/<?php echo e($plan->logo); ?>" class="w-30">
                        <?php endif; ?>



                        <h5 class="mt-3 text-white"> <?php if(!empty($plan->company_name)): ?>
                                <?php echo e($plan->company_name); ?>

                            <?php endif; ?>
                        </h5>

                        <h5 class="text-white fw-bolder mt-2 mb-2">
                            <?php echo e(__('Business Plan')); ?></h5>
                        <h6 class="text-success">
                            <?php if(!empty($plan->date)): ?>

                                <?php echo e((\App\Supports\DateSupport::parse($plan->date))->format(config('app.date_format'))); ?>


                            <?php endif; ?></h6>


                    </div>

                    <div class=" card-body ">
                        <div class="col-9">
                            <p class="text-muted text-sm"><?php echo e(__('Written by')); ?></p>
                            <h6><?php echo e($plan->name); ?></h6>
                            <h6 class="text-muted"><?php echo e($plan->email); ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.primary', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/freylphj/suiteup.grsventures.ltd/resources/views/plans/business-plans.blade.php ENDPATH**/ ?>