<?php $__env->startSection('content'); ?>
    <div class=" row">
        <div class="col">
            <h5 class="text-secondary fw-bolder">
                <?php echo e(__('One Page Marketing Plan')); ?>

            </h5>
        </div>
        <div class="col text-end">
            <a href="/write-marketing-plan" type="button" class="btn btn-info "><?php echo e(__('Create Marketing Plan')); ?></a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="row">
                <?php $__currentLoopData = $models; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-4 col-md-6 col-12 mt-lg-0 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row ">
                                    <div class="col-md-9">
                                        <h5 class="text-dark fw-bolder"><?php echo e($model->company_name); ?></h5>


                                        <p class="text-sm"><?php echo e(__('Related Product')); ?>:<span class="text-dark fw-bolder"> <?php if(!empty($products[$model->product_id])): ?>
                                                    <?php if(isset($products[$model->product_id])): ?>
                                                        <?php echo e($products[$model->product_id]->title); ?>

                                                    <?php endif; ?>
                                                <?php endif; ?></span></p>

                                        <p class="text-sm"><?php echo e(__('Created At')); ?>:
                                            <span class="badge bg-secondary"><?php echo e((\App\Supports\DateSupport::parse($model->created_at))->format(config('app.date_format'))); ?></span></p>

                                    </div>
                                    <div class="col-3 text-end">
                                        <div class="dropstart">
                                            <a href="javascript:" class="text-secondary" id="dropdownMarketingCard"
                                               data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-lg-start px-2 py-3"
                                                aria-labelledby="dropdownMarketingCard">
                                                <li><a class="dropdown-item border-radius-md"
                                                       href="/write-marketing-plan?id=<?php echo e($model->id); ?>"><?php echo e(__('Edit')); ?></a>
                                                </li>
                                                <li><a class="dropdown-item border-radius-md"
                                                       href="/view-marketing-plan?id=<?php echo e($model->id); ?>"><?php echo e(__('See Details')); ?></a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li><a class="dropdown-item border-radius-md text-danger"
                                                       href="/delete/marketing-plan/<?php echo e($model->id); ?>"><?php echo e(__('Delete')); ?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.primary', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\well-known\resources\views/marketing/list.blade.php ENDPATH**/ ?>