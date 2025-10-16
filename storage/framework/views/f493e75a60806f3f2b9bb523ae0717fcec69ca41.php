<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>
        <?php echo e(config('app.name')); ?>

    </title>
    <?php if(!empty($super_settings['favicon'])): ?>

        <link rel="icon" type="image/png" href="<?php echo e(PUBLIC_DIR); ?>/uploads/<?php echo e($super_settings['favicon']); ?>">
    <?php endif; ?>
    <link id="pagestyle" href="<?php echo e(PUBLIC_DIR); ?>/css/app.css" rel="stylesheet"/>
    <?php if(!empty($super_settings['config_recaptcha_in_admin_login'])): ?>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <?php endif; ?>
</head>
<body class="g-sidenav-show  bg-dark">
<section>
    <div class="page-header section-height-75">
        <div class="container ">
            <div class="text-center mt-6">
                    <a class="navbar-brand text-center m-0" href="/">
                        <?php if(!empty($super_settings['logo'])): ?>
                            <img src="<?php echo e(PUBLIC_DIR); ?>/uploads/<?php echo e($super_settings['logo']); ?>"
                                class="navbar-brand-img h-100"
                                style="max-height: <?php echo e($super_settings['frontend_logo_max_height'] ?? '80'); ?>px; width: auto;"
                                alt="...">
                        <?php else: ?>
                            <span class="ms-1 font-weight-bold"> <?php echo e(config('app.name')); ?></span>
                        <?php endif; ?>
                    </a>
                </div>
            <div class="row">
                <div class="col-md-5 d-flex flex-column mx-auto">
                    <div class="card card-body mt-7">
                        <div class="card-header pb-0 text-left bg-transparent">
                            <h3 class="font-weight-bolder text-purple">
                                <?php echo e(__(' Howdy, Super Admin')); ?>


                            </h3>
                            <p class="mb-0">
                                <?php echo e(__('Enter your email and password')); ?>


                            </p>
                        </div>
                        <div class="card-body">
                            <form role="form text-left" method="post" action="/super-admin/auth">

                                <?php if(session()->has('status')): ?>
                                    <div class="alert alert-success">
                                        <?php echo e(session('status')); ?>

                                    </div>
                                <?php endif; ?>

                                <?php if($errors->any()): ?>
                                    <div class="alert alert-danger">
                                        <ul class="list-unstyled">
                                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li><?php echo e($error); ?></li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                                <label><?php echo e(__('Email')); ?></label>
                                <div class="mb-3">
                                    <input type="email" name="email" class="form-control" placeholder="Email"
                                           aria-label="Email" aria-describedby="email-addon">
                                </div>
                                <label><?php echo e(__('Password')); ?></label>
                                <div class="mb-3">
                                    <input type="password" name="password" class="form-control" placeholder="Password"
                                           aria-label="Password" aria-describedby="password-addon">
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="rememberMe" checked="">
                                    <label class="form-check-label" for="rememberMe">
                                        <?php echo e(__('Remember me')); ?></label>
                                </div>
                                    <?php if(!empty($super_settings['config_recaptcha_in_admin_login'])): ?>
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
<?php /**PATH /home/freylphj/suiteup.grsventures.ltd/resources/views/auth/super-admin-login.blade.php ENDPATH**/ ?>