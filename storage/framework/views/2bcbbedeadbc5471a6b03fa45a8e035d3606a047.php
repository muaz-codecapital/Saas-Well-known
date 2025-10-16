<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="font-weight-bolder"> <?php echo e(__(' McKinsey\'s 7-S Model')); ?></h4>
                    <p><?php echo e(__('The McKinsey 7-S Model is a change framework based on a company’s organizational design. It aims to depict how change leaders can effectively manage organizational change by strategizing around the interactions of seven key elements: structure, strategy, system, shared values, skill, style, and staff.
')); ?></p>
                    <hr>
                    <form method="post" action="/save-mckinsey-model">
                        <?php if($errors->any()): ?>
                            <div class="alert bg-pink-light text-danger">
                                <ul class="list-unstyled">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">
                                <?php echo e(__('Business/Company Name')); ?>

                            </label><label class="text-danger">*</label>
                            <input class="form-control" name="company_name" id="company_name"

                                   <?php if(!empty($model)): ?>
                                   value="<?php echo e($model->company_name); ?>"
                                <?php endif; ?>
                            >

                        </div>
                        <div class="row mt-4">
                            <div class="col align-self-end">
                                <div class="col align-self-center">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">
                                            <?php echo e(__('Structure')); ?>

                                        </label>
                                        <p class="form-text text-muted text-xs ms-1">
                                            <?php echo e(__('Structure is the way in which a company is organized – chain of command and accountability relationships that form its organizational chart.')); ?>


                                        </p>
                                        <textarea class="form-control mt-4" rows="10" id="structure"
                                                  name="structure"><?php if(!empty($model)): ?><?php echo e($model->structure); ?><?php endif; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col align-self-center">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">
                                        <?php echo e(__('Strategy')); ?>

                                    </label>
                                    <p class="form-text text-muted text-xs ms-1">
                                        <?php echo e(__('Strategy refers to a well-curated business plan that allows the company to formulate a plan of action to achieve a sustainable competitive advantage, reinforced by the company’s mission and values.')); ?>


                                    </p>
                                    <textarea class="form-control mt-4" rows="10" id="strategy"
                                              name="strategy"><?php if(!empty($model)): ?><?php echo e($model->strategy); ?><?php endif; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col align-self-end">
                                <div class="col align-self-center">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">
                                            <?php echo e(__('System')); ?>

                                        </label>
                                        <p class="form-text text-muted text-xs ms-1">
                                            <?php echo e(__('Systems entail the business and technical infrastructure of the company that establishes workflows and the chain of decision-making.')); ?>

                                        </p>
                                        <textarea class="form-control mt-4" rows="10" id="system"
                                                  name="system"><?php if(!empty($model)): ?><?php echo e($model->system); ?><?php endif; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col align-self-center">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">
                                        <?php echo e(__('Style')); ?>

                                    </label>
                                    <p class="form-text text-muted text-xs ms-1">
                                        <?php echo e(__('The attitude of senior employees in a company establishes a code of conduct through their ways of interactions and symbolic decision-making, which forms the management style of its leaders.')); ?>

                                    </p>
                                    <textarea class="form-control mt-4" rows="10" id="style"
                                              name="style"><?php if(!empty($model)): ?><?php echo e($model->style); ?><?php endif; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">

                            <div class="col align-self-center">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">
                                        <?php echo e(__('Staff')); ?>

                                    </label>
                                    <p class="form-text text-muted text-xs ms-1">
                                        <?php echo e(__('Staff involves talent management and all human resources related to company decisions, such as training, recruiting, and rewards systems')); ?>

                                    </p>
                                    <textarea class="form-control mt-4" rows="10" id="staff"
                                              name="staff"><?php if(!empty($model)): ?><?php echo e($model->staff); ?><?php endif; ?></textarea>
                                </div>
                            </div>
                            <div class="col align-self-end">
                                <div class="col align-self-center">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">
                                            <?php echo e(__('Skill')); ?>

                                        </label>
                                        <p class="form-text text-muted text-xs ms-1">
                                            <?php echo e(__('Skills form the capabilities and competencies of a company that enables its employees to achieve its objectives.')); ?>

                                        </p>
                                        <textarea class="form-control mt-4" rows="10" id="skill"
                                                  name="skill"><?php if(!empty($model)): ?><?php echo e($model->skill); ?><?php endif; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="row mt-4">

                                <div class="col-md-12 align-self-center">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">
                                            <?php echo e(__('Shared Values')); ?>

                                        </label>
                                        <p class="form-text text-muted text-xs ms-1">
                                            <?php echo e(__('The mission, objectives, and values form the foundation of every organization and play an important role in aligning all key elements to maintain an effective organizational design.')); ?>

                                        </p>
                                        <textarea class="form-control mt-4" rows="10" id="shared"
                                                  name="shared_values"><?php if(!empty($model)): ?><?php echo e($model->shared_values); ?><?php endif; ?></textarea>
                                    </div>
                                </div>

                            </div>

                        <?php if($model): ?>
                            <input type="hidden" name="id" value="<?php echo e($model->id); ?>">
                        <?php endif; ?>
                        <?php echo csrf_field(); ?>
                        <button class="btn btn-info mt-4" type="submit"><?php echo e(__('Save')); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script>

        (function(){
            "use strict";
            tinymce.init({
                selector: '#structure',
                plugins: 'lists,table',
                toolbar: 'numlist bullist',
                lists_indent_on_tab: false,
                branding: false,
            });
            tinymce.init({
                selector: '#strategy',
                plugins: 'lists,table',
                toolbar: 'numlist bullist',
                lists_indent_on_tab: false,
                branding: false,
            });
            tinymce.init({
                selector: '#system',
                plugins: 'lists,table',
                toolbar: 'numlist bullist',
                lists_indent_on_tab: false,
                branding: false,
            });
            tinymce.init({
                selector: '#skill',
                plugins: 'lists,table',
                toolbar: 'numlist bullist',
                lists_indent_on_tab: false,
                branding: false,
            });
            tinymce.init({
                selector: '#staff',
                plugins: 'lists,table',
                toolbar: 'numlist bullist',
                lists_indent_on_tab: false,
                branding: false,
            });
            tinymce.init({
                selector: '#style',
                plugins: 'lists,table',
                toolbar: 'numlist bullist',
                lists_indent_on_tab: false,
                branding: false,
            });
            tinymce.init({
                selector: '#shared',
                plugins: 'lists,table',
                toolbar: 'numlist bullist',
                lists_indent_on_tab: false,
                branding: false,
            });
        })();
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.primary', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/freylphj/suiteup.grsventures.ltd/resources/views/mckinsey/new.blade.php ENDPATH**/ ?>