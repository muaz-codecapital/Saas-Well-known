<?php $__env->startSection('content'); ?>


    <div class=" row">
        <div class="col">
            <h5 class=" text-secondary fw-bolder">
                <?php echo e(__('Ideation Canvas List')); ?>

            </h5>
        </div>
        <div class="col text-end">
            <a href="/brainstorming" type="button" class="btn btn-info text-white"><?php echo e(__('Create Canvas')); ?></a>
        </div>
    </div>

        <div class="row mt-1">
            <?php $__currentLoopData = $canvases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $canvas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="card">
                        <div class="overflow-hidden position-relative border-radius-lg bg-cover p-3"

                             <?php if(file_exists(public_path() . '/uploads/brainstorming/'.$canvas->uuid.'.png')): ?>
                             style="background-image: url('<?php echo e(PUBLIC_DIR); ?>/uploads/brainstorming/<?php echo e($canvas->uuid); ?>.png')"
 <?php endif; ?>
 >
                            <span class="mask bg-purple-light opacity-6"></span>
                            <div class="card-body position-relative ">

                                <div class="d-flex mt-7">
                                    <a href="/brainstorming?id=<?php echo e($canvas->id); ?>" class="btn btn-info btn-round p-2 mb-0" type="button" >
                                        <?php echo e(__('Edit Canvas')); ?>

                                    </a>
                                    <a href="/delete/canvas/<?php echo e($canvas->id); ?>" class="btn btn-round btn-outline-dark p-2  ms-2 mb-0" type="button" >
                                        <?php echo e(__('Delete')); ?>

                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mt-1">
                        <?php if(!empty($users[$canvas->admin_id]->photo)): ?>
                            <a href="javascript:" class=" avatar avatar-sm rounded-circle ">
                                <img alt="" class="p-1" src="<?php echo e(PUBLIC_DIR); ?>/uploads/<?php echo e($users[$canvas->admin_id]->photo); ?>">
                            </a>
                        <?php else: ?>
                            <div class="avatar avatar-sm  rounded-circle bg-warning-light  p-2">
                                <h6 class="text-dark mt-1"><?php echo e($users[$canvas->admin_id]->first_name[0]); ?><?php echo e($users[$canvas->admin_id]->last_name[0]); ?></h6>
                            </div>
                        <?php endif; ?>

                        <div class="mx-3">
                            <a href="javascript:;" class="text-dark font-weight-600 text-sm">
                                <?php if(isset($users[$canvas->admin_id])): ?>
                                    <?php echo e($users[$canvas->admin_id]->first_name); ?>  <?php echo e($users[$canvas->admin_id]->last_name); ?>

                                <?php endif; ?>
                            </a>
                            <small class="d-block text-muted"><?php echo e(__('Created at')); ?> <?php echo e((\App\Supports\DateSupport::parse($canvas->created_at))->format(config('app.date_format'))); ?></small>
                        </div>
                    </div>


                    <h5 class="mb-0 mt-1"><?php echo e($canvas->title); ?></h5>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.primary', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/freylphj/suiteup.grsventures.ltd/resources/views/plans/brainstorm-list.blade.php ENDPATH**/ ?>