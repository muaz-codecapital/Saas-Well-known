<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link id="pagestyle" href="<?php echo e(PUBLIC_DIR); ?>/css/app.css" rel="stylesheet"/>
</head>
<body class="bg-pink-light">
<?php if(($super_settings['landingpage'] ?? null) === 'Default'): ?>
    <nav class="navbar navbar-expand-lg top-0 z-index-3 w-100 shadow-blur  bg-gray-100 fixed-top ">
        <div class="container mt-1">

            <a class="navbar-brand text-dark bg-transparent fw-bolder" href="/" rel="tooltip" title="" data-placement="bottom">
                <?php if(!empty($super_settings['logo'])): ?>
                    <img src="<?php echo e(PUBLIC_DIR); ?>/uploads/<?php echo e($super_settings['logo']); ?>" class="navbar-brand-img h-100" style="max-height: <?php echo e($super_settings['frontend_logo_max_height'] ?? '30'); ?>px;" alt="...">
                <?php else: ?>
                    <span class=" font-weight-bold"><?php echo e(config('app.name')); ?></span>
                <?php endif; ?>
            </a>

            <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon mt-2">
<span class="navbar-toggler-bar bar1"></span>
<span class="navbar-toggler-bar bar2"></span>
<span class="navbar-toggler-bar bar3"></span>
</span>
            </button>

            <div class="collapse  navbar-collapse w-100 pt-3 pb-2 py-lg-0 ms-lg-12 " id="navigation">
                <ul class="navbar-nav bg-transparent navbar-nav-hover w-100">

                    <li class="nav-item float-end ms-5 ms-lg-auto">
                        <a  href="/" class="fw-bolder h6 ps-2 d-flex justify-content-between cursor-pointer align-items-center">
                            <?php echo e(__('Home')); ?>


                        </a>
                    </li>

                    <li class="nav-item float-end ms-5 ms-lg-auto">
                        <a class=" fw-bolder h6 ps-2 d-flex justify-content-between cursor-pointer align-items-center me-2" href="/pricing" target="_blank">
                            <?php echo e(__('Pricing')); ?>


                        </a>
                    </li>
                    <li class="nav-item float-end ms-5 ms-lg-auto">
                        <a class=" fw-bolder h6 ps-2 d-flex justify-content-between cursor-pointer align-items-center me-2" href="/blog" target="_blank">
                            <?php echo e(__('Blog')); ?>


                        </a>
                    </li>
                    <li class="nav-item float-end ms-5 ms-lg-auto">
                        <a class="fw-bolder h6 ps-2 d-flex justify-content-between cursor-pointer align-items-center me-5" href="/login" target="_blank">

                            <?php echo e(__('Login')); ?>


                        </a>
                    </li>

                    <li class="nav-item my-auto ms-3 ms-lg-0">
                        <a href="/signup" class="btn bg-dark text-white mb-0 me-1 mt-2 mt-md-0"><?php echo e(__('Sign Up for free')); ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<?php endif; ?>

<main class="main-content main-content-bg mt-0">
    <section class="min-vh-75">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-7 mx-auto">
                    <div class="card z-index-0 mt-sm-12 mt-9 mb-4">
                        <div class="card-header text-center pt-4 pb-1">
                            <h4 class="font-weight-bolder mb-1">
                                <?php echo e(__('Reset password')); ?>

                            </h4>
                            <p class="mb-0">
                                <?php echo e(__(' You will receive an e-mail in maximum 60 seconds')); ?>

                            </p>
                        </div>
                        <div class="card-body">
                            <form role="form " action="/save-reset-password" method="post">
                                <?php if($errors->any()): ?>
                                    <div class="alert alert-danger">
                                        <ul class="list-unstyled">
                                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li><?php echo e($error); ?></li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                                <div class="mb-3">
                                    <input type="email" name="email" class="form-control" aria-label="Email">
                                </div>
                                <?php echo csrf_field(); ?>
                                <div class="text-center">
                                    <button type="submit"
                                            class="btn bg-gradient-dark btn-lg w-100 my-4 mb-2"><?php echo e(__('Send')); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
</body>
</html>
<?php /**PATH /home/freylphj/suiteup.grsventures.ltd/resources/views/auth/forgot-password.blade.php ENDPATH**/ ?>