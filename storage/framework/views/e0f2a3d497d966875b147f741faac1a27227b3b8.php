<?php $__env->startSection('title', __('Not Found')); ?>
<?php $__env->startSection('code', '404'); ?>


<main class="main-content mt-0">
    <section class="my-10">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mx-auto text-center">
                    <h1 class="display-1 text-bolder text-primary text-gradient">Error 404</h1>
                    <h2><?php echo e(__('Whoops! Page not found')); ?></h2>
                    <p class="lead"><?php echo e(__('The page you requested could not be found')); ?></p>
                    <a href="/home" class="btn btn-dark btn-lg btn-rounded mt-4"><?php echo e(__('Go to Homepage')); ?></a>
                </div>

            </div>
        </div>
    </section>
</main>

<?php echo $__env->make('errors::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/freylphj/suiteup.grsventures.ltd/resources/views/errors/404.blade.php ENDPATH**/ ?>