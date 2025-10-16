<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
    <?php echo e(__('Login')); ?>-<?php echo e(config('app.name')); ?>

</title>
<?php if(!empty($super_settings['favicon'])): ?>

<link rel="icon" type="image/png" href="<?php echo e(PUBLIC_DIR); ?>/uploads/<?php echo e($super_settings['favicon']); ?>">
<?php endif; ?>
<link id="pagestyle" href="<?php echo e(PUBLIC_DIR); ?>/css/app.css" rel="stylesheet"/>

<?php if(!empty($super_settings['config_recaptcha_in_user_login'])): ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php endif; ?>

</head>
<body class="g-sidenav-show">

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

<section>
<div class="page-header  section-height-75">
<div class="container ">
    <div class="row">
        <div class="col-md-5 d-flex flex-column mx-auto">
            <div class="card card-info mt-8">
                <div class="card-header pb-0 text-center ">

                    <h3 class="font-weight-bolder text-purple">
                        <?php echo e(__('Login')); ?>


                    </h3>
                    <p class="mb-0">
                        <?php echo e(__('Enter your email and password to login')); ?>


                    </p>
                </div>
                <div class="card-body">
                    <form role="form text-left" method="post" action="/login">

                        <?php if(session()->has('status')): ?>
                            <div class="alert alert-success">
                                <?php echo e(session('status')); ?>

                            </div>
                        <?php endif; ?>
                            <?php if(session()->has('error')): ?>
                                <div class="alert alert-danger">
                                    <?php echo e(session('error')); ?>

                                </div>
                            <?php endif; ?>

                        <?php if($errors->any()): ?>
                            <div class="alert bg-pink-light text-danger">
                                <ul class="list-unstyled">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <label><?php echo e(__('Email')); ?></label>
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo e(old('email')); ?>"
                                   aria-label="Email" aria-describedby="email-addon">
                        </div>
                        <label><?php echo e(__('Password')); ?></label>
                        <div class="mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Password"
                                   aria-label="Password" aria-describedby="password-addon">
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" name="remember" type="checkbox" id="rememberMe"
                                   checked="">
                            <label class="form-check-label" for="rememberMe">
                                <?php echo e(__('Remember me')); ?></label>
                        </div>
                            <?php if(!empty($super_settings['config_recaptcha_in_user_login'])): ?>
                                <div class="g-recaptcha" data-sitekey="<?php echo e($super_settings['recaptcha_api_key']); ?>">

                                </div>
                            <?php endif; ?>

                        <div class="text-center">
                            <?php echo csrf_field(); ?>
                            <button type="submit"
                                    class="btn btn-info w-100 mt-4 mb-0"><?php echo e(__('Sign in')); ?></button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                    <p class="mb-4 text-sm mx-auto">
                        <?php echo e(__('Forgot Password?')); ?>

                        <a href="/forgot-password"
                           class="text-purple font-weight-bold"><?php echo e(__('Reset Password')); ?></a>
                    </p>
                    <p class="text-sm mt-3 mb-0"><?php echo e(__('Do not have an account?')); ?> <a href="/signup"
                                                                                       class="text-dark font-weight-bolder"><?php echo e(__('Register')); ?></a>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
</section>

<script>
(function(){
"use strict";

var win = navigator.platform.indexOf('Win') > -1;
if (win && document.querySelector('#sidenav-scrollbar')) {
    var options = {
        damping: '0.5'
    }
    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
}
})();

</script>


</body>

</html>
<?php /**PATH /home/freylphj/suiteup.grsventures.ltd/resources/views/auth/login.blade.php ENDPATH**/ ?>