<?php $__env->startSection('content'); ?>
        <div class="row">
            <div class="col-md-7 mx-auto text-center">
                <span class="badge bg-purple-light mb-3"><?php echo e(__('Pricing and Plans')); ?></span>
                <h3 class="text-dark"><?php echo e(__('Ready to get started with StartupKit?Awesome!')); ?></h3>
                <p class="text-secondary"><?php echo e(__('Choose the plan that best fit for you.')); ?></p>
            </div>
        </div>

        <?php if($workspace->subscribed): ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="card bg-purple-light">
                        <div class="card-body">
                            <h6 class="fw-bolder"><?php echo e(__('Billing')); ?></h6>
                            <?php if($plan): ?>
                                <h6><?php echo e(__('You are subscribed to the  ')); ?><span class="badge bg-indigo text-white"><?php echo e($plan->name); ?></span>
                                </h6>
                            <?php endif; ?>

                            <?php if(!empty($workspace->next_renewal_date)): ?>
                                <p><strong><?php echo e(__('Next renewal date')); ?>:</strong> <?php echo e(date('M d Y',strtotime($workspace->next_renewal_date))); ?></p>
                            <?php endif; ?>

                            <?php if($plan): ?>
                            <a href="/cancel-subscription?id=<?php echo e($plan->id); ?>" type="button"
                               class="btn btn-sm  bg-pink-light text-danger mt-3 "><?php echo e(__('Cancel Subscription')); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        <?php endif; ?>

        <div class="row mt-4">
            <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4  mb-4 ">
                    <div class="card ">
                        <div class="card-header text-center ">
                            <h4 class="text-purple  text mb-2"><?php echo e($plan->name); ?></h4>
                            <p><?php echo $plan->description; ?></p>
                            <span>
                            <h4 class="font-weight-bolder">
                                <?php echo e(formatCurrency($plan->price_monthly,getWorkspaceCurrency($super_settings))); ?>

                             /<span><small
                                        class=" text-sm text-warning"><?php echo e(__(' month')); ?></small></span>
                            </h4> </span>

                            <h4 class="mt-0">
                                <?php echo e(formatCurrency($plan->price_yearly,getWorkspaceCurrency($super_settings))); ?>

                                /<span><small
                                        class="text-sm text-warning"><?php echo e(__('year')); ?></small></span>
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
                            <?php if($workspace->plan_id == $plan->id): ?>
                                <span class="badge bg-indigo text-white text-center my-3"><?php echo e(__('Current Plan')); ?></span>
                            <?php else: ?>

                                <?php if($workspace->subscribed): ?>



                                <?php endif; ?>

                                <?php if($plan->price_monthly && $plan->price_monthly > 0): ?>

                                    <a href="/subscribe?id=<?php echo e($plan->id); ?>&term=monthly" type="button"
                                       class="btn btn-info btn-sm "><?php echo e(__('Pay Monthly')); ?>

                                    </a>

                                <?php endif; ?>
                                <?php if($plan->price_yearly && $plan->price_yearly > 0): ?>

                                    <a href="/subscribe?id=<?php echo e($plan->id); ?>&term=yearly" type="button"
                                       class="btn btn-success btn-sm "><?php echo e(__('Pay Yearly')); ?></a>
                                <?php endif; ?>

                                <?php if($plan->price_monthly && $plan->price_monthly == 0): ?>
                                    <a href="/subscribe?id=<?php echo e($plan->id); ?>&term=free_plan" type="button"
                                       class="btn btn-success btn-sm "><?php echo e(__('Choose free Plan')); ?></a>
                                <?php endif; ?>

                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.primary', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\well-known\resources\views/settings/billing.blade.php ENDPATH**/ ?>