<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col">
            <h5 class=" text-secondary fw-bolder">
                <?php echo e(__('Product Plan')); ?>

            </h5>
        </div>
        <div class="col text-end">
            <a href="/projects" type="button" class="btn btn-info text-white"><?php echo e(__('Product Plans  ')); ?></a>
        </div>
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <form action="/save-project" method="post">
                <?php if($errors->any()): ?>
                    <div class="alert bg-pink-light text-danger">
                        <ul class="list-unstyled">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <div class="col-lg-9 col-12 mx-auto">
                    <div class=" card-body">
                        <h3 class="mb-0"><?php echo e(__('New Product Idea')); ?></h3>
                        <p class="text-sm mb-0"><?php echo e(__('Create new product idea')); ?></p>
                        <hr class="horizontal dark my-3">
                        <label for="projectName" class="form-label"><?php echo e(__('Product Name')); ?></label><label class="text-danger">*</label>
                        <input type="text" value="<?php echo e($project->title ?? old('title') ?? ''); ?>"  name="title"
                               class="form-control" id="projectName">
                        <label class="mt-4 text-sm mb-0"><?php echo e(__('What Problem does this product solves?')); ?></label>
                        <p class="form-text  text-purple text-xs ms-1">
                            <?php echo e(__('Write a short pitch.Within 225 words')); ?>

                        </p>
                        <div class="form-group">
                            <textarea name="summary" class="form-control" rows="4" id="editor"><?php echo e($project->summary ?? old('summary') ?? ''); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">
                                <?php echo e(__('Status')); ?>

                            </label><span class="text-danger">*</span>
                            <select class="form-select" aria-label="Default select example" name="status">
                                <option value="Pending"
                                        <?php if(($project->status ?? null) === 'Pending'): ?> selected <?php endif; ?>><?php echo e(__('Pending')); ?></option>
                                <option value="Started"
                                        <?php if(($project->status ?? null) === 'Started'): ?> selected <?php endif; ?>><?php echo e(__('Started')); ?></option>
                                <option value="Finished"
                                        <?php if(($project->status ?? null) === 'Finished'): ?> selected <?php endif; ?>><?php echo e(__('Finished')); ?></option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <div>
                                <label for="exampleFormControlInput1" class="form-label"><?php echo e(__('Team Members')); ?></label><span class="text-danger">*</span>
                                <select class="form-control select2" multiple id="" name="members[]">
                                    <?php $__currentLoopData = $other_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $other_user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($other_user->id); ?>"
                                                <?php if($members): ?>

                                                <?php if(in_array($other_user->id,$members)): ?> selected <?php endif; ?>
                                            <?php endif; ?>
                                        ><?php echo e($other_user->first_name); ?> <?php echo e($other_user->last_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-6">
                                <label class="form-label"><?php echo e(__('Start Date')); ?></label>
                                <input class="form-control" name="start_date" id="start_date"
                                       <?php if(!empty($project)): ?>value="<?php echo e($project->start_date); ?>"
                                       <?php else: ?>
                                       value="<?php echo e(date('Y-m-d')); ?>"
                                    <?php endif; ?> >
                            </div>
                            <div class="col-6">
                                <label class="form-label"><?php echo e(__('End Date')); ?></label>
                                <input class="form-control" name="end_date" id="end_date" <?php if(!empty($project)): ?>
                                value="<?php echo e($project->end_date); ?>"
                                       <?php else: ?>
                                       value="<?php echo e(date('Y-m-d')); ?>"
                                    <?php endif; ?>>
                            </div>
                        </div>
                        <label class="mt-4 text-sm mb-0"><?php echo e(__('Product Description')); ?></label>
                        <p class="form-text text-purple text-xs ms-1">
                            <?php echo e(__('Write a well organised description of the product.')); ?>

                        </p>
                        <div class="form-group">
                            <textarea class="form-control" rows="10" id="description"
                                      name="description"><?php echo e($project->description ?? old('description') ?? ''); ?></textarea>
                        </div>
                        <?php echo csrf_field(); ?>
                        <?php if($project): ?>
                            <input type="hidden" name="id" value="<?php echo e($project->id); ?>">
                        <?php endif; ?>
                        <div class="d-flex  mt-4">
                            <button type="submit" name="button" class="btn btn-info m-0 ">
                                <?php echo e(__('Save')); ?>

                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

    <script>

        $(function () {
            "use strict";


            flatpickr("#start_date", {

                dateFormat: "Y-m-d",
            });

            flatpickr("#end_date", {

                dateFormat: "Y-m-d",
            });


            tinymce.init({
                selector: '#description',


                plugins: 'table,code',
                branding: false,


            });

        });


    </script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.primary', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\well-known\resources\views/projects/create-project.blade.php ENDPATH**/ ?>