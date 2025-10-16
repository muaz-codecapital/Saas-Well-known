<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-4">
        <form enctype="multipart/form-data" action="/save-note" method="post">
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
                <h3 class="mb-0"><?php echo e(__('Write Note')); ?></h3>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label"><?php echo e(__('Title')); ?></label><label class="text-danger">*</label>
                    <input type="text" name="title"  value="<?php echo e($note->title ?? old('title') ?? ''); ?>" class="form-control" id="title">
                </div>
                <div class="mb-2">
                    <label for="exampleFormControlInput1" class="form-label"> <?php echo e(__('Topic/Subject')); ?></label><label class="text-danger">*</label>
                    <input type="text" name="topic" value="<?php echo e($note->topic ?? old('topic') ?? ''); ?>"class="form-control" id="topic">
                </div>
                <div class="mb-2">
                    <label for="tags" class="form-label"><?php echo e(__('Tags')); ?></label>
                    <input
                            type="text"
                            name="tags"
                            value="<?php echo e(isset($note->tags) ? implode(',', json_decode($note->tags, true) ?? []) : old('tags')); ?>"
                            class="form-control"
                            id="tags"
                    >
                </div>

                <div class="align-self-center mb-3">
                    <div>
                        <label for="cover_photo" class="form-label mt-4"><?php echo e(__('Upload Cover Photo')); ?></label>
                        <input class="form-control" name="cover_photo" type="file" id="cover_photo_file">
                    </div>
                </div>
                <div class="mb-3 align-self-center">
                    <label for="workspace" class="form-label"><?php echo e(__('Select Workspace')); ?></label>
                    <select name="workspace" id="workspace" class="form-control">
                        <option value="" disabled selected><?php echo e(__('Choose a Workspace')); ?></option>
                        <?php $__currentLoopData = config('groups.groups'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($group); ?>"><?php echo e(ucfirst($group)); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label"><?php echo e(__('Write Notes')); ?></label>
                    <textarea class="form-control" name="notes" id="notes"
                              rows="5"><?php if(!empty($note)): ?><?php echo $note->notes; ?><?php endif; ?></textarea>
                </div>
                <div class="align-self-center mb-3">
                    <div>
                        <label for="reference_file" class="form-label mt-4"><?php echo e(__('Upload Refrence File')); ?></label>
                        <input class="form-control" name="reference_file" type="file" id="reference_file">
                    </div>
                </div>
                <?php echo csrf_field(); ?>
                <?php if($note): ?>
                    <input type="hidden" name="id" value="<?php echo e($note->id); ?>">
                <?php endif; ?>
                <button class="btn btn-info" type="submit"><?php echo e(__('Save')); ?></button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        (function () {
            "use strict";
            tinymce.init({
                selector: '#notes',
                plugins: [
                    'insertdatetime media table paste code help wordcount'
                ],
                min_height: 500,
                max_height: 800,
                convert_newlines_to_brs: false,
                statusbar: false,
                relative_urls: false,
                remove_script_host: false,
                language: 'en',
                branding: false,
            });
        })();
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var input = document.querySelector('#tags');
            new Tagify(input, {
                whitelist: [
                    "idea",
                    "validation",
                    "in development",
                    "testing",
                    "released",
                    "archived",
                    "feature",
                    "bug fix",
                    "ui/ux",
                    "backend",
                    "api",
                    "integration",
                    "performance",
                    "milestone 1",
                    "milestone 2",
                    "v1.0",
                    "v2.0",
                    "research",
                    "planning",
                    "deployment",
                    "documentation"
                ],
                dropdown: {
                    maxItems: 10,
                    enabled: 0,
                    closeOnSelect: false
                }
            });
        });
    </script>

<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.primary', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/freylphj/suiteup.grsventures.ltd/resources/views/actions/add-note.blade.php ENDPATH**/ ?>