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
    <style>
        .subscription-card { cursor: pointer; transition: box-shadow .2s, transform .2s, border-color .2s; border: 1px solid rgba(0,0,0,.075); }
        .subscription-card:hover { box-shadow: 0 0.75rem 1.5rem rgba(0,0,0,.08); transform: translateY(-2px); }
        .subscription-card.selected { border-color: #6f42c1; box-shadow: 0 0 0 .2rem rgba(111,66,193,.15); }
        @media (max-width: 767.98px) {
            .subscription-card .card-body { padding: 1rem; }
        }
        
        /* Professional dropdown styling with proper alignment */
        .form-control {
            background-color: white !important;
            border: 1px solid #e9ecef;
            border-radius: 0.375rem;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            line-height: 1.5;
            color: #495057;
            text-indent: 0;
        }
        
        .form-control:focus {
            border-color: #6f42c1;
            box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.25);
            background-color: white !important;
        }
        
        select.form-control {
            background-color: white !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
            appearance: none;
        }
        
        select.form-control option {
            background-color: white;
            color: #495057;
            padding: 0.75rem 1rem;
            text-align: left;
        }
        
        .input-group-text {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-right: none;
            color: #6f42c1;
            min-width: 45px;
            justify-content: center;
            display: flex;
            align-items: center;
        }
        
        .input-group .form-control {
            border-left: none;
            padding-left: 1rem;
        }
        
        .input-group:focus-within .input-group-text {
            border-color: #6f42c1;
            background-color: #f8f9fa;
        }
        
        /* Ensure proper text alignment in input groups */
        .input-group .form-control::placeholder {
            color: #6c757d;
            opacity: 1;
        }
        
        /* Fix cursor positioning */
        .input-group .form-control {
            text-indent: 0;
            padding-left: 1rem;
        }
        
        /* Consistent color scheme */
        .text-primary {
            color: #6f42c1 !important;
        }
        
        .bg-light-info {
            background-color: rgba(111, 66, 193, 0.1) !important;
        }
        
        .card-header h6 {
            color: #6f42c1 !important;
        }
        
        /* Subscription card styling consistency */
        .subscription-card .icon-shape {
            background-color: rgba(111, 66, 193, 0.1) !important;
        }
        
        .subscription-card .feather {
            color: #6f42c1 !important;
        }
    </style>

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

<section>
    <div class="page-header section-height-75">
        <div class="container ">
                <div class="row justify-content-center">
                <!--
                <div class="col-md-7 d-none d-md-flex flex-column justify-content-center">
                    <h1 class="text-purple mb-3 mt-4"><?php echo e(__('“Play by the rules, but be ferocious.” ')); ?></h1>
                        <h6 class="text-lead text-success"><?php echo e(__('– Phil Knight')); ?></h6>
                </div>
                -->
                <div class="col-sm-12 col-md-10 col-lg-9 col-xl-8 d-flex flex-column mx-auto">
                    <div class="card card-info mt-8">
                        <div class="card-header pb-0 text-center ">
                            <h3 class="font-weight-bolder text-purple"><?php echo e(__('Sign Up')); ?></h3>
                            <p class="mb-0"><?php echo e(__('Create your account')); ?></p>
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
                            <!-- General Information Section -->
                            <div class="mb-4">
                                <label><?php echo e(__('I am a')); ?> *</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-rocket text-primary">
                                            <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"></path>
                                            <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"></path>
                                            <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                            <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                        </svg>
                                    </span>
                                    <select name="user_type" class="form-control" required>
                                        <option value=""><?php echo e(__('Select your role')); ?></option>
                                        <option value="founder" <?php echo e(old('user_type') == 'founder' ? 'selected' : ''); ?>><?php echo e(__('Founder')); ?></option>
                                        <option value="co-founder" <?php echo e(old('user_type') == 'co-founder' ? 'selected' : ''); ?>><?php echo e(__('Co-Founder')); ?></option>
                                        <option value="entrepreneur" <?php echo e(old('user_type') == 'entrepreneur' ? 'selected' : ''); ?>><?php echo e(__('Entrepreneur')); ?></option>
                                        <option value="investor" <?php echo e(old('user_type') == 'investor' ? 'selected' : ''); ?>><?php echo e(__('Investor')); ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label><?php echo e(__('Name')); ?> *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user text-primary">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="12" cy="7" r="4"></circle>
                                            </svg>
                                        </span>
                                        <input name="name" class="form-control" type="text" placeholder="<?php echo e(__('Your name')); ?>" value="<?php echo e(old('name')); ?>" autocomplete="name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label><?php echo e(__('Email')); ?> *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail text-primary">
                                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                                <polyline points="22,6 12,13 2,6"></polyline>
                                            </svg>
                                        </span>
                                        <input type="email" placeholder="<?php echo e(__('your.email@company.com')); ?>" name="email" class="form-control" value="<?php echo e(old('email')); ?>" autocomplete="email" required>
                                    </div>
                                </div>
                            </div>


                            <!-- Startup Information Section -->
                            <div class="card bg-light-info mb-4">
                                <div class="card-header bg-transparent border-0">
                                    <h6 class="mb-0 text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-rocket me-2">
                                            <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"></path>
                                            <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"></path>
                                            <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                            <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                        </svg>
                                        <?php echo e(__('Startup Information')); ?>

                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label><?php echo e(__('Company/Startup Name')); ?> *</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-building text-primary">
                                                        <path d="M3 21h18"></path>
                                                        <path d="M5 21V7l8-4v18"></path>
                                                        <path d="M19 21V11l-6-4"></path>
                                                    </svg>
                                                </span>
                                                <input type="text" name="company_name" class="form-control" placeholder="<?php echo e(__('Your startup name')); ?>" value="<?php echo e(old('company_name')); ?>" autocomplete="organization" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label><?php echo e(__('Industry/Sector')); ?> *</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-briefcase text-primary">
                                                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                                        <path d="M16 3H8v4h8V3z"></path>
                                                    </svg>
                                                </span>
                                                <select name="industry" class="form-control" style="background-color: white;" required>
                                                    <option value=""><?php echo e(__('Select industry')); ?></option>
                                                    <option value="technology" <?php echo e(old('industry') == 'technology' ? 'selected' : ''); ?>><?php echo e(__('Technology')); ?></option>
                                                    <option value="fintech" <?php echo e(old('industry') == 'fintech' ? 'selected' : ''); ?>><?php echo e(__('Fintech')); ?></option>
                                                    <option value="healthcare" <?php echo e(old('industry') == 'healthcare' ? 'selected' : ''); ?>><?php echo e(__('Healthcare')); ?></option>
                                                    <option value="ecommerce" <?php echo e(old('industry') == 'ecommerce' ? 'selected' : ''); ?>><?php echo e(__('E-commerce')); ?></option>
                                                    <option value="education" <?php echo e(old('industry') == 'education' ? 'selected' : ''); ?>><?php echo e(__('Education')); ?></option>
                                                    <option value="saas" <?php echo e(old('industry') == 'saas' ? 'selected' : ''); ?>><?php echo e(__('SaaS')); ?></option>
                                                    <option value="manufacturing" <?php echo e(old('industry') == 'manufacturing' ? 'selected' : ''); ?>><?php echo e(__('Manufacturing')); ?></option>
                                                    <option value="retail" <?php echo e(old('industry') == 'retail' ? 'selected' : ''); ?>><?php echo e(__('Retail')); ?></option>
                                                    <option value="other" <?php echo e(old('industry') == 'other' ? 'selected' : ''); ?>><?php echo e(__('Other')); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label><?php echo e(__('Current Stage')); ?> *</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up text-primary">
                                                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                                        <polyline points="17 6 23 6 23 12"></polyline>
                                                    </svg>
                                                </span>
                                                <select name="current_stage" class="form-control" style="background-color: white;" required>
                                                    <option value=""><?php echo e(__('Select stage')); ?></option>
                                                    <option value="idea" <?php echo e(old('current_stage') == 'idea' ? 'selected' : ''); ?>><?php echo e(__('Idea Stage')); ?></option>
                                                    <option value="mvp" <?php echo e(old('current_stage') == 'mvp' ? 'selected' : ''); ?>><?php echo e(__('MVP Development')); ?></option>
                                                    <option value="beta" <?php echo e(old('current_stage') == 'beta' ? 'selected' : ''); ?>><?php echo e(__('Beta Testing')); ?></option>
                                                    <option value="launched" <?php echo e(old('current_stage') == 'launched' ? 'selected' : ''); ?>><?php echo e(__('Launched')); ?></option>
                                                    <option value="scaling" <?php echo e(old('current_stage') == 'scaling' ? 'selected' : ''); ?>><?php echo e(__('Scaling')); ?></option>
                                                    <option value="established" <?php echo e(old('current_stage') == 'established' ? 'selected' : ''); ?>><?php echo e(__('Established')); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label><?php echo e(__('Team Size')); ?> *</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users text-primary">
                                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                                        <circle cx="9" cy="7" r="4"></circle>
                                                        <path d="m22 21-2-2"></path>
                                                        <path d="m16 16 2 2"></path>
                                                    </svg>
                                                </span>
                                                <select name="team_size" class="form-control" style="background-color: white;" required>
                                                    <option value=""><?php echo e(__('Select team size')); ?></option>
                                                    <option value="1" <?php echo e(old('team_size') == '1' ? 'selected' : ''); ?>><?php echo e(__('Just me (Solo founder)')); ?></option>
                                                    <option value="2-5" <?php echo e(old('team_size') == '2-5' ? 'selected' : ''); ?>><?php echo e(__('2-5 people')); ?></option>
                                                    <option value="6-10" <?php echo e(old('team_size') == '6-10' ? 'selected' : ''); ?>><?php echo e(__('6-10 people')); ?></option>
                                                    <option value="11-25" <?php echo e(old('team_size') == '11-25' ? 'selected' : ''); ?>><?php echo e(__('11-25 people')); ?></option>
                                                    <option value="26-50" <?php echo e(old('team_size') == '26-50' ? 'selected' : ''); ?>><?php echo e(__('26-50 people')); ?></option>
                                                    <option value="50+" <?php echo e(old('team_size') == '50+' ? 'selected' : ''); ?>><?php echo e(__('50+ people')); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div class="mb-4">
                                <label><?php echo e(__('Choose Password')); ?></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock text-primary">
                                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                            <circle cx="12" cy="16" r="1"></circle>
                                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                        </svg>
                                    </span>
                                    <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="new-password" aria-label="Password" aria-describedby="password-addon">
                                </div>
                            </div>
                                <p class="text-dark mt-4 mb-3 text-center"><?php echo e(__('Choose Your Subscription Plan')); ?></p>
                                <input type="hidden" name="selected_plan" id="selected_plan">
                                <div class="row">
                                    <div class="col-lg-6 mb-4">
                                        <div class="card subscription-card h-100" onclick="selectSubscriptionCard(this,1)" tabindex="0" role="button" aria-pressed="false">
                                            <div class="card-body position-relative p-4">
                                                <div class="position-absolute top-0 end-0 m-3">
                                                    <div class="icon icon-shape bg-gradient-primary text-center p-2 rounded-circle">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white feather feather-credit-card">
                                                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                                            <line x1="1" y1="10" x2="23" y2="10"></line>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <p class="text-sm mb-0 text-capitalize font-weight-bold text-primary"><?php echo e(__('SuiteUp')); ?></p>
                                                    <h5 class="font-weight-bolder mt-2 text-dark"><?php echo e(__('Self-Starter Plan')); ?></h5>
                                                    <p class="text-sm text-muted mb-3"><?php echo e(__('For founders who want autonomy, but with professional tools to plan and grow.')); ?></p>
                                                    
                                                    <div class="mb-3">
                                                        <h6 class="text-dark mb-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-brain text-primary me-2">
                                                                <path d="M9.5 2A2.5 2.5 0 0 1 12 4.5v15a2.5 2.5 0 0 1-4.96.44 2.5 2.5 0 0 1-2.96-3.08 3 3 0 0 1-.34-6.58 2.5 2.5 0 0 1 1.32-4.24 2.5 2.5 0 0 1 1.98-3A2.5 2.5 0 0 1 9.5 2Z"></path>
                                                            </svg>
                                                            <?php echo e(__('Advanced Planning')); ?>

                                                        </h6>
                                                        <p class="text-sm text-muted ms-4"><?php echo e(__('Business Model Canvas, Financial Forecasts, SWOT, Roadmap, McKinsey 7S')); ?></p>
                                                    </div>

                                                    <div class="mb-3">
                                                        <h6 class="text-dark mb-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2 text-primary me-2">
                                                                <line x1="18" y1="20" x2="18" y2="10"></line>
                                                                <line x1="12" y1="20" x2="12" y2="4"></line>
                                                                <line x1="6" y1="20" x2="6" y2="14"></line>
                                                            </svg>
                                                            <?php echo e(__('Execution Tools')); ?>

                                                        </h6>
                                                        <p class="text-sm text-muted ms-4"><?php echo e(__('Kanban board with advanced options, project & task management, CRM for leads/customers')); ?></p>
                                                    </div>

                                                    <div class="mb-3">
                                                        <h6 class="text-dark mb-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users text-primary me-2">
                                                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                                                <circle cx="9" cy="7" r="4"></circle>
                                                                <path d="m22 21-2-2"></path>
                                                                <path d="m16 16 2 2"></path>
                                                            </svg>
                                                            <?php echo e(__('Collaboration')); ?>

                                                        </h6>
                                                        <p class="text-sm text-muted ms-4"><?php echo e(__('Workspace for up to 10 users, Google Calendar integration')); ?></p>
                                                    </div>

                                                    <div class="mb-3">
                                                        <h6 class="text-dark mb-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text text-primary me-2">
                                                                <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path>
                                                                <polyline points="14,2 14,8 20,8"></polyline>
                                                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                                                <polyline points="10,9 9,9 8,9"></polyline>
                                                            </svg>
                                                            <?php echo e(__('Smart Reporting')); ?>

                                                        </h6>
                                                        <p class="text-sm text-muted ms-4"><?php echo e(__('Customizable sections, PDF generator for business plans')); ?></p>
                                                    </div>

                                                    <div class="mb-3">
                                                        <h6 class="text-dark mb-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-unlock text-primary me-2">
                                                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                                                <circle cx="12" cy="16" r="1"></circle>
                                                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                                            </svg>
                                                            <?php echo e(__('Flexibility')); ?>

                                                        </h6>
                                                        <p class="text-sm text-muted ms-4"><?php echo e(__('Cancel anytime')); ?></p>
                                                    </div>

                                                    <div class="mt-4 pt-3 border-top">
                                                        <p class="font-weight-bold mb-1">
                                                            <span class="text-primary"><?php echo e(__('Monthly')); ?>:</span> $24.99<br>
                                                            <span class="text-primary"><?php echo e(__('Yearly')); ?>:</span> $259.99 + VAT
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-4">
                                        <div class="card subscription-card h-100" onclick="selectSubscriptionCard(this,2)" tabindex="0" role="button" aria-pressed="false">
                                            <div class="card-body position-relative p-4">
                                                <div class="position-absolute top-0 end-0 m-3">
                                                    <div class="icon icon-shape bg-gradient-success text-center p-2 rounded-circle">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white feather feather-briefcase">
                                                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                                            <path d="M16 3H8v4h8V3z"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <p class="text-sm mb-0 text-capitalize font-weight-bold text-success"><?php echo e(__('Incubation Track')); ?></p>
                                                    <h5 class="font-weight-bolder mt-2 text-dark"><?php echo e(__('Co-Founder Partnership')); ?></h5>
                                                    <p class="text-sm text-muted mb-3"><?php echo e(__('For founders who want more than tools: a partner working side by side to validate, build, and scale their startup.')); ?></p>
                                                    
                                                    <div class="mb-3">
                                                        <h6 class="text-dark mb-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-success me-2">
                                                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                                                <polyline points="22,4 12,14.01 9,11.01"></polyline>
                                                            </svg>
                                                            <?php echo e(__('Full SuiteUp Access')); ?>

                                                        </h6>
                                                        <p class="text-sm text-muted ms-4"><?php echo e(__('All features from the Self-Starter plan')); ?></p>
                                                    </div>

                                                    <div class="mb-3">
                                                        <h6 class="text-dark mb-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-success me-2">
                                                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                                                <polyline points="22,4 12,14.01 9,11.01"></polyline>
                                                            </svg>
                                                            <?php echo e(__('Full PerosnalysisPro Access')); ?>

                                                        </h6>
                                                        <p class="text-sm text-muted ms-4"><?php echo e(__('All features to analyze the market with Psychographic data')); ?></p>
                                                    </div>

                                                    <div class="mb-3">
                                                        <h6 class="text-dark mb-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-rocket text-warning me-2">
                                                                <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"></path>
                                                                <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"></path>
                                                                <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                                                <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                                            </svg>
                                                            <?php echo e(__('MVP Development')); ?>

                                                        </h6>
                                                        <p class="text-sm text-muted ms-4"><?php echo e(__('Validation, build, and technical support')); ?></p>
                                                    </div>

                                                    <div class="mb-3">
                                                        <h6 class="text-dark mb-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up text-info me-2">
                                                                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                                                <polyline points="17 6 23 6 23 12"></polyline>
                                                            </svg>
                                                            <?php echo e(__('Go-to-Market Strategy')); ?>

                                                        </h6>
                                                        <p class="text-sm text-muted ms-4"><?php echo e(__('Growth hacking, positioning, and market entry')); ?></p>
                                                    </div>

                                                    <div class="mb-3">
                                                        <h6 class="text-dark mb-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign text-success me-2">
                                                                <line x1="12" y1="1" x2="12" y2="23"></line>
                                                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                                            </svg>
                                                            <?php echo e(__('Fundraising Readiness')); ?>

                                                        </h6>
                                                        <p class="text-sm text-muted ms-4"><?php echo e(__('Pitch deck review, valuation insights, investor network access')); ?></p>
                                                    </div>

                                                    <div class="mb-3">
                                                        <h6 class="text-dark mb-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user text-primary me-2">
                                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                                <circle cx="12" cy="7" r="4"></circle>
                                                            </svg>
                                                            <?php echo e(__('1:1 Mentorship')); ?>

                                                        </h6>
                                                        <p class="text-sm text-muted ms-4"><?php echo e(__('Direct mentoring from GRS Ventures team')); ?></p>
                                                    </div>

                                                    <div class="mt-4 pt-3 border-top">
                                                        <p class="font-weight-bold mb-1">
                                                            <span class="text-success"><?php echo e(__('Equity-Based')); ?></span><br>
                                                            <span class="text-sm text-muted"><?php echo e(__('Application and selection required')); ?></span>
                                                        </p>
                                                        <button type="button" class="btn btn-outline-success btn-sm mt-2" onclick="event.stopPropagation(); alert('Application form coming soon!')">
                                                            <?php echo e(__('APPLY FOR THIS TIER')); ?>

                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php if(!empty($super_settings['config_recaptcha_in_user_signup'])): ?>
                                    <div class="g-recaptcha" data-sitekey="<?php echo e($super_settings['recaptcha_api_key']); ?>"></div>
                                <?php endif; ?>
                            <?php echo csrf_field(); ?>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-info w-100 mt-4 mb-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-rocket me-2">
                                            <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"></path>
                                            <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"></path>
                                            <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                            <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                        </svg>
                                        <?php echo e(__('Submit Startup Application')); ?>

                                    </button>
                                </div>
                        </form>
                        </div>
                        <div class="card-footer text-center pt-0 px-lg-2 px-1">
                            <p class="text-sm mt-3 mb-0"><?php echo e(__('Already have an account?')); ?> <a href="/login" class="text-dark font-weight-bolder"><?php echo e(__('Sign in')); ?></a></p>
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
<script>
    let selectedPlanName = '';

    function selectSubscriptionCard(card, planName) {
        document.querySelectorAll('.subscription-card').forEach(c => {
            c.classList.remove('selected');
            c.setAttribute('aria-pressed', 'false');
        });
        card.classList.add('selected');
        card.setAttribute('aria-pressed', 'true');
        selectedPlanName = planName;
        document.getElementById('selected_plan').value = selectedPlanName;
    }

    // Keyboard support for selecting cards
    document.addEventListener('keydown', function (e) {
        if ((e.key === 'Enter' || e.key === ' ') && e.target && e.target.classList && e.target.classList.contains('subscription-card')) {
            e.preventDefault();
            const card = e.target;
            const plan = card.getAttribute('onclick') && card.getAttribute('onclick').includes(',2)') ? 2 : 1;
            selectSubscriptionCard(card, plan);
        }
    });

</script>

</body>

</html>
<?php /**PATH C:\laragon\www\well-known\resources\views/auth/signup.blade.php ENDPATH**/ ?>