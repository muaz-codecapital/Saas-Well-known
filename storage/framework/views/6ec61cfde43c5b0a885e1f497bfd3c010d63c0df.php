<?php $__env->startSection('title','Blog'); ?>
<?php $__env->startSection('content'); ?>
    <section class="py-7">
        <div class="container">
            <h2 class="text-center mb-2 mt-3"><?php echo e(__('Read our Blog')); ?></h2>
            <p class="text-center mb-5"><?php echo e(__('We post articles on business news, inspiring stories, best advice and guidelines on successful business planning.')); ?></p>

            <div class="container ms-3 mb-4">
                <div class="row mb-4" data-masonry='{"percentPosition": true }'>
                    <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-4 mb-3">
                            <div class="card card-plain border">
                                <div class="card-header p-0 mx-lg-3 mt-3 position-relative z-index-1">
                                    <a href="" class="d-block">
                                        <?php if(!empty($blog->cover_photo)): ?>
                                            <img src="<?php echo e(PUBLIC_DIR); ?>/uploads/<?php echo e($blog->cover_photo); ?>" class="img-fluid border-radius-md"> <?php else: ?>
                                            <img src="<?php echo e(PUBLIC_DIR); ?>/img/placeholder.jpeg" class="img-fluid border-radius-lg">
                                        <?php endif; ?>
                                    </a>
                                </div>
                                <div class="card-body pt-3">

                                    <p class="mb-1 pt-2 text-bold"><span class="badge bg-secondary"><?php echo e($blog->topic); ?></span></p>
                                    <h4 class="mb-3">
                                        <a href="/blog/<?php echo e($blog->slug); ?>" class="text-darker font-weight-bolder"><?php echo e($blog->title); ?>

                                        </a>
                                    </h4>
                                    <p class="card-text"> <?php echo substr($blog->notes,0,100); ?>

                                        <a href="/blog/<?php echo e($blog->slug); ?>" class="fw-bolder"><?php echo e(__('Read More')); ?></a>
                                        </p>

                                    <div class="author">

                                        <div class="stats">
                                            <p class="text-xs text-secondary mb-0"><?php echo e($blog->updated_at->diffForHumans()); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/freylphj/suiteup.grsventures.ltd/resources/views/frontend/blog.blade.php ENDPATH**/ ?>