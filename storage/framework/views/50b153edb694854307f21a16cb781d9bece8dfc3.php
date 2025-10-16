<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php if(!empty($super_settings['favicon'])): ?>

        <link rel="icon" type="image/png" href="<?php echo e(PUBLIC_DIR); ?>/uploads/<?php echo e($super_settings['favicon']); ?>">
    <?php endif; ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>


    <title>
            <?php echo e(config('app.name')); ?>

    </title>

    <link id="pagestyle" href="<?php echo e(PUBLIC_DIR); ?>/css/app.css?v=1128" rel="stylesheet"/>



    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/frappe-gantt@0.5.0/dist/frappe-gantt.css" />

    <?php echo $__env->yieldContent('head'); ?>



</head>

<body class="g-sidenav-show  bg-gray-100" id="clx_body">
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0  fixed-left " id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute right-0 top-0 d-none d-xl-none"
           aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand text-center m-0" href="<?php echo e(config('app.url')); ?>/dashboard">
            <?php if(!empty($super_settings['logo'])): ?>
                <img src="<?php echo e(PUBLIC_DIR); ?>/uploads/<?php echo e($super_settings['logo']); ?>" class="navbar-brand-img h-100" alt="...">
            <?php else: ?>
                <span class="ms-1 font-weight-bold"> <?php echo e(config('app.name')); ?></span>
            <?php endif; ?>
        </a>
    </div>
    <div class=" text-center">
        <?php if(!empty($user->photo)): ?>
            <a href="javascript:" class="avatar avatar-md rounded-circle border border-secondary">
                <img alt="" class="p-1" src="<?php echo e(PUBLIC_DIR); ?>/uploads/<?php echo e($user->photo); ?>">
            </a>
        <?php else: ?>
            <div class="avatar avatar-md  rounded-circle bg-purple-light  border-radius-md p-2">
                <h6 class="text-purple text-uppercase mt-1"><?php echo e($user->first_name[0]); ?><?php echo e($user->last_name[0]); ?></h6>
            </div>


        <?php endif; ?>
        <a href="/profile" class=" nav-link text-body font-weight-bold px-0">
            <span
                class="d-sm-inline d-none "><?php if(!empty($user)): ?> <?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?><?php endif; ?></span>
        </a>

    </div>
    <hr class="horizontal dark mt-0">

    <div class="collapse navbar-collapse  w-auto  d-print-none " id="sidenav-collapse-main">

        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link <?php if(($selected_navigation ?? '') === 'dashboard'): ?> active <?php endif; ?>" href="/dashboard">

                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-home">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    <span class="nav-link-text ms-3"><?php echo e(__('Dashboard')); ?></span>
                </a>


            </li>
            <li class="nav-item mt-3 mb-2">
                <h6 class="ps-4 ms-2 text-uppercase text-muted text-xs opacity-6"><?php echo e(__('Product Planning')); ?> </h6>
            </li>

            <?php if(empty($modules) || in_array('projects',$modules)): ?>
                <li class="nav-item ">
                    <a class="nav-link <?php if(($selected_navigation ?? '') === 'projects'): ?> active <?php endif; ?> "
                       href="/projects">

                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-grid">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                        </svg>
                        <span class="nav-link-text ms-3"><?php echo e(__('Product Planning')); ?></span>
                    </a>
                </li>

            <?php endif; ?>
            <?php if(empty($modules) || in_array('to_dos',$modules)): ?>
                <li class="nav-item">
                    <div class="d-flex align-items-center justify-content-between nav-link
                    <?php if(($selected_navigation ?? '') === 'todos'): ?> active <?php endif; ?>">

                        <!-- Main link (navigates to /tasks) -->
                        <a href="<?php echo e(route('admin.tasks', ['action' => 'list'])); ?>"
                           class="d-flex align-items-center text-decoration-none text-reset flex-grow-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="feather feather-check-circle">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            <span class="nav-link-text ms-3"><?php echo e(__('Tasks')); ?></span>
                        </a>

                        <!-- Arrow toggle (controls collapse only) -->
                        <a href="#tasksGroups" data-bs-toggle="collapse" aria-expanded="false" class="text-reset">
                            <i class="fa fa-chevron-down small"></i>
                        </a>
                    </div>
                    <ul class="collapse nav flex-column ms-4 <?php if(($selected_navigation ?? '') === 'todos'): ?> show <?php endif; ?>"
                        id="tasksGroups">
                        <?php $__currentLoopData = config('groups.groups'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupKey => $groupLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="nav-item">
                                <a class="nav-link <?php if(request()->get('group') === $groupKey): ?> active <?php endif; ?>"
                                   href="<?php echo e(route('admin.tasks', ['action' => 'list', 'group' => $groupKey])); ?>">
                                    <?php echo e($groupLabel); ?>

                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </li>
            <?php endif; ?>




        <?php if(empty($modules) || in_array('calendar',$modules)): ?>

                <li class="nav-item">
                    <a class="nav-link <?php if(($selected_navigation ?? '') === 'calendar'): ?> active <?php endif; ?>" href="/calendar">

                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-calendar">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <span class="nav-link-text ms-3"><?php echo e(__('Calendar')); ?></span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if(empty($modules) || in_array('brainstorm',$modules)): ?>
                <li class="nav-item">
                    <a class="nav-link <?php if(($selected_navigation ?? '') === 'brainstorm'): ?> active <?php endif; ?>" href="/brainstorming-list">

                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="20" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-edit-2">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                        </svg>
                        <span class="nav-link-text ms-3"><?php echo e(__('Ideation Canvas')); ?></span>
                    </a>
                </li>

            <?php endif; ?>

            <li class="nav-item mt-3 mb-2">
                <h6 class="ps-4 ms-2 text-uppercase text-muted text-xs opacity-6"><?php echo e(__('Contacts')); ?> </h6>
            </li>

            <?php if(empty($modules) || in_array('investors',$modules)): ?>

                <li class="nav-item ">
                    <a class="nav-link <?php if(($selected_navigation ?? '') === 'investors'): ?> active <?php endif; ?> " href="/investors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>
                        <span class="nav-link-text text-end ms-3 "><?php echo e(__('Investors')); ?></span>
                    </a>
                </li>
            <?php endif; ?>


            <li class="nav-item mt-3 mb-2">
                <h6 class="ps-4 ms-2 text-uppercase text-muted text-xs opacity-6"><?php echo e(__('Business Models')); ?> </h6>
            </li>



            <?php if(empty($modules) || in_array('business_model',$modules)): ?>

                <li class="nav-item ">
                    <a class="nav-link <?php if(($selected_navigation ?? '') === 'business-models'): ?> active <?php endif; ?> "
                       href="/business-models">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-briefcase">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                        </svg>
                        <span class="nav-link-text text-end ms-3 "><?php echo e(__('Business Models')); ?></span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if(empty($modules) || in_array('business_model',$modules)): ?>


                <li class="nav-item ">
                    <a class="nav-link <?php if(($selected_navigation ?? '') === 'startup-canvas'): ?> active <?php endif; ?> "
                       href="/startup-canvases">

                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-server"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg>
                        <span class="nav-link-text text-end ms-3 "><?php echo e(__('Startup Canvas')); ?></span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if(empty($modules) || in_array('mckinsey',$modules)): ?>
                <li class="nav-item">
                    <a class="nav-link  <?php if(($selected_navigation ?? '') === 'mckinsey'): ?> active <?php endif; ?>" href="/mckinsey-models">


                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        <span class="nav-link-text ms-3"><?php echo e(__('McKinsey 7-S Model')); ?></span>
                    </a>
                </li>

            <?php endif; ?>

            <?php if(empty($modules) || in_array('porter',$modules)): ?>
                <li class="nav-item">
                    <a class="nav-link  <?php if(($selected_navigation ?? '') === 'porter'): ?> active <?php endif; ?>" href="/porter-models">

                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-life-buoy"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="4"></circle><line x1="4.93" y1="4.93" x2="9.17" y2="9.17"></line><line x1="14.83" y1="14.83" x2="19.07" y2="19.07"></line><line x1="14.83" y1="9.17" x2="19.07" y2="4.93"></line><line x1="14.83" y1="9.17" x2="18.36" y2="5.64"></line><line x1="4.93" y1="19.07" x2="9.17" y2="14.83"></line></svg>
                        <span class="nav-link-text ms-3"><?php echo e(__('Porter\'s 5-F Model')); ?></span>
                    </a>
                </li>

            <?php endif; ?>


            <li class="nav-item mt-3 mb-2">
                <h6 class="ps-4 ms-2 text-uppercase text-muted text-xs opacity-6"><?php echo e(__('Strategies & Analysis')); ?> </h6>
            </li>
            <?php if(empty($modules) || in_array('swot',$modules)): ?>
                <li class="nav-item">
                    <a class="nav-link  <?php if(($selected_navigation ?? '') === 'swot'): ?> active <?php endif; ?>" href="/swot-list">

                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-disc">
                            <circle cx="12" cy="12" r="10"></circle>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <span class="nav-link-text ms-3"><?php echo e(__('SWOT Analysis')); ?></span>
                    </a>
                </li>

            <?php endif; ?>
            <?php if(empty($modules) || in_array('pest',$modules)): ?>
                <li class="nav-item">
                    <a class="nav-link  <?php if(($selected_navigation ?? '') === 'pest'): ?> active <?php endif; ?>" href="/pest-list">

                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                        <span class="nav-link-text ms-3"><?php echo e(__('PEST Analysis')); ?></span>
                    </a>
                </li>

            <?php endif; ?>
            <?php if(empty($modules) || in_array('pestle',$modules)): ?>
                <li class="nav-item">
                    <a class="nav-link  <?php if(($selected_navigation ?? '') === 'pestel'): ?> active <?php endif; ?>" href="/pestle-list">


                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-columns"><path d="M12 3h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-7m0-18H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h7m0-18v18"></path></svg>
                        <span class="nav-link-text ms-3"><?php echo e(__('PESTLE Analysis')); ?></span>
                    </a>
                </li>

            <?php endif; ?>



            <?php if(empty($modules) || in_array('business_plan',$modules)): ?>

                <li class="nav-item ">
                    <a class="nav-link <?php if(($selected_navigation ?? '') === 'business-plans'): ?> active <?php endif; ?> "
                       href="/business-plans">

                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-edit">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                        <span class="nav-link-text  ms-3"><?php echo e(__('Business Plans')); ?></span>
                    </a>
                </li>

            <?php endif; ?>
            <?php if(empty($modules) || in_array('marketing_plan',$modules)): ?>

                <li class="nav-item ">
                    <a class="nav-link <?php if(($selected_navigation ?? '') === 'marketing-plans'): ?> active <?php endif; ?> " href="/marketing-plans">

                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                        <span class="nav-link-text ms-3"><?php echo e(__('Marketing Plans')); ?></span>
                    </a>
                </li>

            <?php endif; ?>

            <?php if(empty($modules) || in_array('notes',$modules)): ?>
                <li class="nav-item mt-3 mb-2">
                    <h6 class="ps-4 ms-2 text-uppercase text-muted text-xs opacity-6"><?php echo e(__('Knowledgebase')); ?></h6>
                </li>
                <li class="nav-item ">
                    <a class="nav-link <?php if(($selected_navigation ?? '') === 'notes'): ?> active <?php endif; ?> " href="/notes">

                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book-open"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                        <span class="nav-link-text ms-3"><?php echo e(__('Note Book')); ?></span>
                    </a>
                </li>
            <?php endif; ?>












            <?php if(empty($modules) || in_array('documents',$modules)): ?>

                <li class="nav-item">
                    <a class="nav-link <?php if(($selected_navigation ?? '') === 'documents'): ?> active <?php endif; ?>"
                       href="/documents">

                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-file">
                            <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                            <polyline points="13 2 13 9 20 9"></polyline>
                        </svg>
                        <span class="nav-link-text ms-3"><?php echo e(__('Documents')); ?></span>
                    </a>
                </li>
            <?php endif; ?>
            <li class="nav-item mt-3 mb-2">
                <h6 class="ps-4 ms-2 text-uppercase text-muted text-xs opacity-6"><?php echo e(__('Account pages')); ?> </h6>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php if(($selected_navigation ?? '') === 'profile'): ?> active <?php endif; ?> " href="/profile">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-user">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span class="nav-link-text ms-3"><?php echo e(__('Profile')); ?></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if(($selected_navigation ?? '') === 'team'): ?> active <?php endif; ?> " href="/staff">

                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-database">
                        <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                        <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                        <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
                    </svg>
                    <span class="nav-link-text ms-3"><?php echo e(__('Users')); ?></span>
                </a>
            </li>

            <li class="nav-item mt-3 mb-2">
                <h6 class="ps-4 ms-2 text-uppercase text-muted text-xs opacity-6"><?php echo e(__('Settings')); ?>  </h6>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if(($selected_navigation ?? '') === 'billing'): ?> active <?php endif; ?>  " href="/billing">

                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-shopping-cart">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    <span class="nav-link-text ms-3"><?php echo e(__('My Plan')); ?></span>
                </a>
            </li>
            <li class="nav-item mb-4">
                <a class="nav-link <?php if(($selected_navigation ?? '') === 'settings'): ?> active <?php endif; ?>  " href="/settings">

                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-command">
                        <path
                            d="M18 3a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3 3 3 0 0 0 3-3 3 3 0 0 0-3-3H6a3 3 0 0 0-3 3 3 3 0 0 0 3 3 3 3 0 0 0 3-3V6a3 3 0 0 0-3-3 3 3 0 0 0-3 3 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 3 3 0 0 0-3-3z"></path>
                    </svg>
                    <span class="nav-link-text ms-3"><?php echo e(__('Settings')); ?></span>
                </a>
            </li>

            <li class="mb-4 ms-5">
                <a class="btn btn-warning " type="button" href="/logout">
                    <span class=""><?php echo e(__('Logout')); ?></span>
                </a>
            </li>
        </ul>
    </div>

</aside>


<main class="main-content mt-1 border-radius-lg ">
    <!-- Navbar -->

    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl d-print-none" navbar-scroll="true" >
        <div class="container-fluid py-1 px-3 d-print-none">

            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                </div>
                <ul class=" justify-content-end">
                    <li class="nav-item d-xl-none pe-2 ps-3 d-flex align-items-center">
                        <a href="javascript:" class="nav-link text-body p-0" id="iconNavbarSidenav">
                            <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item dropdown pe-2 d-flex align-items-center">
                        <a href="" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown"
                           aria-expanded="false">
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                            aria-labelledby="dropdownMenuButton">
                            <li class="mb-2">
                                <a class="dropdown-item border-radius-md" href="/profile">
                                    <div class="d-flex py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="text-sm font-weight-normal mb-1">
                                                <span class="font-weight-bold"><?php echo e(__('My Profile')); ?></span>
                                            </h6>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item border-radius-md" href="/logout">
                                    <div class="d-flex py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="text-sm font-weight-bolder mb-1">
                                                <?php echo e(__('Logout')); ?>

                                            </h6>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- End Navbar -->
    <div class="container-fluid ">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
</main>
<!--   Core JS Files   -->
<script src="<?php echo e(PUBLIC_DIR); ?>/js/app.js?v=99"></script>
<script src="<?php echo e(PUBLIC_DIR); ?>/lib/tinymce/tinymce.min.js?v=58"></script>
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
<script src="https://cdn.jsdelivr.net/combine/npm/snapsvg@0.5.1,npm/frappe-gantt@0.5.0/dist/frappe-gantt.min.js"></script>

<?php echo $__env->yieldContent('script'); ?>

</body>

</html>

<?php /**PATH C:\laragon\www\well-known\resources\views/layouts/primary.blade.php ENDPATH**/ ?>