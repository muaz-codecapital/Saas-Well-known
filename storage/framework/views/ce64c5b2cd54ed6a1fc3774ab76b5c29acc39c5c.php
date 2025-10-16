<?php $__env->startSection('content'); ?>
    <div class=" row">
        <div class="col">
            <h5 class="mb-2 text-secondary fw-bolder">
                <?php echo e(__('Notes')); ?>

            </h5>
        </div>
        <div class="col text-end">
            <a href="/add-note" type="button" class="btn btn-info"><?php echo e(__('Take New Note')); ?></a>
        </div>
    </div>
    <div class="row" data-masonry='{"percentPosition": true }'>
        <?php $__currentLoopData = $notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <?php if(!empty($note->cover_photo)): ?>
                        <img src="<?php echo e(PUBLIC_DIR); ?>/uploads/<?php echo e($note->cover_photo); ?>" class="card-img-top" alt="...">
                    <?php endif; ?>

                    <div class="card-body">
                        <p class="mb-1 pt-2 text-bold"><?php echo e($note->topic); ?></p>
                        <h5 class="card-title"><?php echo e($note->title); ?></h5>
                        <p class="card-text"> <?php echo substr($note->notes,0,400); ?> </p>
                        <a class="text-body text-sm font-weight-bold mb-0 icon-move-right mt-auto"
                           href="/view-note?id=<?php echo e($note->id); ?>">
                            <?php echo e(__('Read More')); ?>

                            <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.primary', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/freylphj/suiteup.grsventures.ltd/resources/views/actions/notes.blade.php ENDPATH**/ ?>