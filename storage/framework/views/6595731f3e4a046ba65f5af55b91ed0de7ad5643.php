<?php $__env->startSection('content'); ?>

    <div class=" row">
        <div class="col">
            <h5 class="mb-2 text-secondary fw-bolder">
                <?php echo e(__(' McKinsey 7-S Model')); ?>

            </h5>
        </div>
        <div class="col text-end">
            <a href="/new-mckinsey-model" type="button" class="btn btn-info">
                <?php echo e(__('New mckinsey 7-S Model')); ?>

            </a>
        </div>
    </div>


    <div>
        <div class="row">
            <?php $__currentLoopData = $models; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-md-6 col-12 mt-lg-0 mb-4">
                    <div class="card mb-3 mt-lg-0 mt-4">
                        <div class="card-body pb-0">
                            <div class="row align-items-center mb-3">
                                <div class="col-9">
                                    <h5 class=" fw-bolder text-dark text-primary">
                                        <a href="/view-mckinsey-model?id=<?php echo e($model->id); ?>"><?php echo e($model->company_name); ?></a>

                                    </h5>
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
                                                   href="/new-mckinsey-model?id=<?php echo e($model->id); ?>"><?php echo e(__('Edit')); ?></a></li>

                                            <li><a class="dropdown-item border-radius-md"
                                                   href="/view-mckinsey-model?id=<?php echo e($model->id); ?>"><?php echo e(__('See Details')); ?></a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item border-radius-md text-danger"
                                                   href="/delete/mckinsey/<?php echo e($model->id); ?>"><?php echo e(__('Delete')); ?></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <h5 class="text-secondary text-sm"><?php echo e((\App\Supports\DateSupport::parse($model->updated_at))->format(config('app.date_time_format'))); ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.primary', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/freylphj/suiteup.grsventures.ltd/resources/views/mckinsey/list.blade.php ENDPATH**/ ?>