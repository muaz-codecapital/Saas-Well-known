<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        <?php echo e(__('Signup')); ?>-<?php echo e(config('app.name')); ?>

    </title>
    <?php if(!empty($super_settings['favicon'])): ?>

        <link rel="icon" type="image/png" href="<?php echo e(PUBLIC_DIR); ?>/uploads/<?php echo e($super_settings['favicon']); ?>">
    <?php endif; ?>
    <link id="pagestyle" href="<?php echo e(PUBLIC_DIR); ?>/css/app.css" rel="stylesheet"/>

    <?php if(!empty($super_settings['config_recaptcha_in_user_signup'])): ?>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <?php endif; ?>
</head>
<body class="g-sidenav-show  bg-gray-100">
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

<section class="min-vh-100">
    <div class="row my-6">
        <div class="col-md-7">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="text-center mx-auto">
                        <h1 class=" text-purple mb-4 mt-10"><?php echo e(__('“Play by the rules, but be ferocious.” ')); ?></h1>
                        <h6 class="text-lead text-success"><?php echo e(__('– Phil Knight')); ?></h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="container">
                <div class=" card z-index-0 mt-5">
                    <div class="card-header text-start pt-4">
                        <h4><?php echo e(__('SignUp')); ?></h4>
                    </div>
                    <div class="card-body">
                        <form role="form text-left" method="post" action="/signup">
                            <?php if(session()->has('status')): ?>
                                <div class="alert alert-success">
                                    <?php echo e(session('status')); ?>

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
                            <label><?php echo e(__('First Name')); ?></label>
                            <div class="mb-3">
                                <input name="first_name" class="form-control" type="text" placeholder="First name"
                                       aria-describedby="email-addon">
                            </div>
                            <label><?php echo e(__('Last Name')); ?></label>
                            <div class="mb-3">
                                <input type="text" name="last_name" class="form-control" placeholder="Last name"
                                       aria-describedby="email-addon">
                            </div>
                            <label><?php echo e(__('Email')); ?></label>
                            <div class="mb-3">
                                <input type="email" placeholder="Email" name="email" class="form-control"
                                       aria-label="Email" aria-describedby="email-addon">
                            </div>
                            <label><?php echo e(__('Choose Password')); ?></label>
                            <div class="mb-3">
                                <input type="password" name="password" class="form-control" placeholder="Password"
                                       aria-label="Password" aria-describedby="password-addon">
                            </div>
                                <p class="text-dark"><?php echo e(__('Choose Your Subscription Plan')); ?></p>
                                <input type="hidden" name="selected_plan" id="selected_plan">

                                <div class="row">
                                    <!-- StartUp Plan -->
                                    <div class="col-md-6 mb-4">
                                        <div class="card subscription-card" onclick="selectSubscriptionCard(this,1)">
                                            <div class="card-body position-relative p-3">
                                                <!-- Icon -->
                                                <div class="position-absolute top-0 end-0 m-3">
                                                    <div class="icon icon-shape bg-purple-light text-center p-2 rounded-circle">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                             class="text-purple feather feather-credit-card">
                                                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                                            <line x1="1" y1="10" x2="23" y2="10"></line>
                                                        </svg>
                                                    </div>
                                                </div>

                                                <!-- Content -->
                                                <div class="col-12">
                                                    <p class="text-sm mb-0 text-capitalize font-weight-bold"><?php echo e(__('Self Starter Plan')); ?></p>
                                                    <h5 class="font-weight-bolder mt-2">
                                                        <a href="#"><?php echo e(__('Self Starter Plan')); ?></a>
                                                    </h5>

                                                    <ul class="mt-3 ps-3 text-sm">
                                                        <li>Advance Planning</li>
                                                        <li>Execution Plan</li>
                                                        <li>Collaboration</li>
                                                        <li>Smart Reporting</li>
                                                        <li>Flexibility</li>
                                                    </ul>

                                                    <p class="mt-3 font-weight-bold">
                                                        <?php echo e(__('Monthly')); ?>: $24.99<br>
                                                        <?php echo e(__('Yearly')); ?>: $259.00 + VAT
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Enterprise Plan -->
                                    <div class="col-md-6 mb-4">
                                        <div class="card subscription-card" onclick="selectSubscriptionCard(this,2)">
                                            <div class="card-body position-relative p-3">
                                                <!-- Icon -->
                                                <div class="position-absolute top-0 end-0 m-3">
                                                    <div class="icon icon-shape bg-purple-light text-center p-2 rounded-circle">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                             class="text-purple feather feather-briefcase">
                                                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                                            <path d="M16 3H8v4h8V3z"></path>
                                                        </svg>
                                                    </div>
                                                </div>

                                                <!-- Content -->
                                                <div class="col-12">
                                                    <p class="text-sm mb-0 text-capitalize font-weight-bold"><?php echo e(__('Enterprise Plan')); ?></p>
                                                    <h5 class="mt-2">
                                                        <a href="#"><?php echo e(__('Enterprise Plan')); ?></a>
                                                    </h5>

                                                    <ul class="mt-3 ps-3 text-sm">
                                                        <li>Advanced analytics & reporting</li>
                                                        <li>Unlimited storage</li>
                                                        <li>24/7 priority support</li>
                                                        <li>Custom integrations</li>
                                                    </ul>

                                                    <p class="mt-3 font-weight-bold">
                                                        <?php echo e(__('Contact Us for pricing')); ?>

                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php if(!empty($super_settings['config_recaptcha_in_user_signup'])): ?>
                                    <div class="g-recaptcha" data-sitekey="<?php echo e($super_settings['recaptcha_api_key']); ?>">

                                    </div>
                                <?php endif; ?>
                            <?php echo csrf_field(); ?>
                            <div class="text-start">
                                <button type="submit" class="btn btn-info  my-4 mb-2"><?php echo e(__('Sign up')); ?></button>
                            </div>
                            <p class="text-sm mt-3 mb-0"><?php echo e(__('Already have an account?')); ?> <a href="/login"
                                                                                               class="text-dark font-weight-bolder"><?php echo e(__('Sign in')); ?></a>
                            </p>
                        </form>
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
<script>
    let selectedPlanName = '';

    function selectSubscriptionCard(card, planName) {
        document.querySelectorAll('.subscription-card').forEach(c => c.classList.remove('selected'));
        card.classList.add('selected');
        selectedPlanName = planName;
        document.getElementById('selected_plan').value = selectedPlanName;
    }

</script>

</body>

</html>
<?php /**PATH /home/freylphj/suiteup.grsventures.ltd/resources/views/auth/signup.blade.php ENDPATH**/ ?>