<?php $__env->startSection('title','Privacy Policy'); ?>
<?php $__env->startSection('content'); ?>

    <section class="">
        <div class="bg-pink-light position-relative">
            <div class="pb-lg-9 pb-5 pt-7 postion-relative z-index-2">
                <div class="row mt-5">
                    <div class="col-md-8 mx-auto text-center mt-4">
                        <?php if(!empty($privacy)): ?>
                            <h2 class="text-dark">
                                <?php echo e($privacy->title); ?>

                            </h2>
                        <?php endif; ?>
                        <p class="text-muted">
                           <?php echo e(__('Updated')); ?>

                            <?php if(!empty($privacy)): ?>
                                <?php echo e($privacy->date); ?>

                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 position-relative">
        <div id="carousel-testimonials" class="carousel slide carousel-team">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-12 col-md-7 me-lg-auto position-relative">
                                <p class="mb-1">
                                    <?php if(!empty($privacy)): ?>
                                        <?php echo $privacy->description; ?>

                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/freylphj/suiteup.grsventures.ltd/resources/views/frontend/privacy.blade.php ENDPATH**/ ?>