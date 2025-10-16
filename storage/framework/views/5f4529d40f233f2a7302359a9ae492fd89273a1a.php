<?php $__env->startSection('content'); ?>

    <div class="page-header card min-height-250 "<?php if(!empty($user->cover_photo)): ?>
         style="background-image: url('<?php echo e(PUBLIC_DIR); ?>/uploads/<?php echo e($user->cover_photo); ?>'); background-position-y: 50%;"
        <?php endif; ?>>
        <span class="mask bg-gradient-dark opacity-6"></span>
    </div>
    <div class="mx-4 mt-n5 overflow-hidden">
        <div class="row gx-4">
            <div class="col-auto">
                <div class="avatar rounded-circle avatar-xxl position-relative border-avatar">
                    <?php if(empty($user->photo)): ?>
                        <img src="<?php echo e(PUBLIC_DIR); ?>/img/user-avatar-placeholder.png"
                             class="w-100 border-radius-lg shadow-sm">
                    <?php else: ?>
                        <img src="<?php echo e(PUBLIC_DIR); ?>/uploads/<?php echo e($user->photo); ?>" class="w-100 border-radius-lg shadow-sm">
                    <?php endif; ?>

                </div>
            </div>
            <div class="col-auto my-auto">
                <div class="h-100">
                    <h5 class="mb-1 mt-5">
                        <?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?>

                    </h5>
                    <p class="mb-0  text-sm">
                        <?php echo e($user->email); ?>

                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                <div class="nav-wrapper position-relative end-0">
                    <ul class="nav nav-pills nav-fill p-1 bg-transparent" role="tablist">
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row  mb-5">
        <div class="col-md-4">
            <div class="card mt-4">

                <div class="card-body">

                    <h5 class="fw-bolder mb-4"><?php echo e(__('Basic Info')); ?></h5>

                    <ul class="list-group">
                        <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong
                                class="text-dark"><?php echo e(__('Full Name:')); ?></strong>
                            <?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?>

                        </li>
                        <li class="list-group-item border-0 ps-0 text-sm"><strong
                                class="text-dark"><?php echo e(__('Phone Number:')); ?></strong>
                            <?php echo e($user->phone_number); ?>

                        </li>
                        <li class="list-group-item border-0 ps-0 text-sm"><strong
                                class="text-dark"><?php echo e(__('Email:')); ?></strong> <?php echo e($user->email); ?></li>
                        <li class="list-group-item border-0 ps-0 text-sm"><strong
                                class="text-dark"><?php echo e(__('Account Created:')); ?></strong> <?php echo e((\App\Supports\DateSupport::parse($user->created_at))->format(config('app.date_time_format'))); ?>

                        </li>
                    </ul>
                    <a class="btn btn-info btn-sm mb-0 mt-3" href="/user-edit/<?php echo e($user->id); ?>"><?php echo e(__('Edit')); ?></a>

                </div>
            </div>
        </div>

        <div class="col-md-8 mt-lg-0 mt-4">
            <form enctype="multipart/form-data" action="/profile" method="post">

                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul class="list-unstyled">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <div class="card mt-4" id="basic-info">

                    <div class="card-header">
                        <h5><?php echo e(__('Details')); ?></h5>
                    </div>

                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label"><?php echo e(__('First Name')); ?></label>
                                <div class="input-group">
                                    <input id="firstName" name="first_name"
                                           <?php if(!empty($user)): ?> value="<?php echo e($user->first_name); ?>" <?php endif; ?> class="form-control"
                                           type="text" placeholder="Alec" required="required">
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label"><?php echo e(__('Last Name')); ?></label>
                                <div class="input-group">
                                    <input id="lastName" name="last_name"
                                           <?php if(!empty($user)): ?> value="<?php echo e($user->last_name); ?>" <?php endif; ?> class="form-control"
                                           type="text" required="required">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <label class="form-label mt-4"><?php echo e(__('Email/Username')); ?></label>
                                <div class="input-group">
                                    <input id="email" name="email" <?php if(!empty($user)): ?> value="<?php echo e($user->email); ?>"
                                           <?php endif; ?> class="form-control" type="email">
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label mt-4"><?php echo e(__('Phone Number')); ?></label>
                                <div class="input-group">
                                    <input id="phone" name="phone_number"
                                           <?php if(!empty($user)): ?> value="<?php echo e($user->phone_number); ?>"
                                           <?php endif; ?> class="form-control" type="number">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 align-self-center">
                                <label class="form-label  mt-4"><?php echo e(__('Language')); ?></label>
                                <select class="form-control select2" name="language" id="choices-language">

                                    <?php $__currentLoopData = $available_languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key); ?>"
                                                <?php if($user->language===$key): ?> selected <?php endif; ?> ><?php echo e($value); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-6 align-self-center">
                                <div>
                                    <label for="photo_file" class="form-label mt-4"><?php echo e(__('Upload photo')); ?></label>
                                    <input class="form-control" name="photo" type="file" id="logo_file">
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <label for="timezone"><?php echo e(__('Timezone')); ?></label>
                            <select class="form-control select2" id="timezone" name="timezone">
                                <option value=""><?php echo e(__('Select')); ?></option>
                                <?php $__currentLoopData = \App\Supports\UtilSupport::timezoneList(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>" <?php if($user->timezone===$key): ?> selected <?php endif; ?> ><?php echo e($value); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                            </select>
                        </div>


                        <div class="align-self-center">
                            <div>
                                <label for="cover_photo" class="form-label mt-3"><?php echo e(__('Upload Cover Photo')); ?></label>
                                <input class="form-control" name="cover_photo" type="file" id="cover_photo_file">
                            </div>
                        </div>
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-info btn-sm float-left mt-4 mb-0">
                            <?php echo e(__('Update info')); ?>

                        </button>
                    </div>
                </div>
            </form>

            <!-- Card Change Password -->
            <div class="card mt-4" id="password">
                <div class="card-header">
                    <h5><?php echo e(__('Change Password')); ?></h5>
                </div>
                <form action="/user-change-password" method="post">
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul class="list-unstyled">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <div class="card-body pt-0">
                        <label class="form-label"><?php echo e(__('Current password')); ?></label>
                        <div class="form-group">
                            <input class="form-control" name="password" type="password">
                        </div>
                        <label class="form-label"><?php echo e(__('New password')); ?></label>
                        <div class="form-group">
                            <input class="form-control" name="new_password" type="password">
                        </div>
                        <label class="form-label"><?php echo e(__('Confirm new password')); ?></label>
                        <div class="form-group">
                            <input class="form-control" name="new_password_confirmation">
                        </div>

                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-info btn-sm float-left  mb-0">
                            <?php echo e(__(' Update password')); ?>

                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.'.($layout ?? 'primary'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/freylphj/suiteup.grsventures.ltd/resources/views/profile/profile.blade.php ENDPATH**/ ?>