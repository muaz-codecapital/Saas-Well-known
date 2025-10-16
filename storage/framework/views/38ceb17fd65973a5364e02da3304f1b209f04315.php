<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="font-weight-bolder"><?php echo e(__('Write Marketing Plan')); ?></h4>
                    <hr>
                    <form method="post" action="/save-marketing-plan">
                        <?php if($errors->any()): ?>
                            <div class="alert bg-pink-light text-danger">
                                <ul class="list-unstyled">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                            <div class="row">
                                <div class="col-md-6">
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
                                </div>
                                <div class="col-md-6">
                                    <div class="">

                                        <label for="exampleFormControlInput1" class="form-label"><?php echo e(__('Select Product')); ?></label>
                                        <select class="form-select form-select-solid fw-bolder" id="contact"
                                                aria-label="Floating label select example" name="product_id">
                                            <option value="0"><?php echo e(__('None')); ?></option>
                                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($product->id); ?>"
                                                        <?php if(!empty($model)): ?>
                                                        <?php if($model->product_id === $product->id): ?>
                                                        selected
                                                    <?php endif; ?>
                                                    <?php endif; ?>
                                                ><?php echo e($product->title); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col align-self-end">
                                <div class="col align-self-center">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">
                                            <?php echo e(__('Business Summary')); ?>

                                        </label>
                                        <p class="form-text text-muted text-xs ms-1">
                                            <?php echo e(__('Companny name and mission statement')); ?>


                                        </p>
                                        <textarea class="form-control mt-4" rows="10" id="summary"
                                                  name="summary"><?php if(!empty($model)): ?><?php echo e($model->summary); ?><?php endif; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        <div class="row mt-4">
                            <div class="col align-self-end">
                                <div class="col align-self-center">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">
                                            <?php echo e(__('Company Description')); ?>

                                        </label>
                                        <p class="form-text text-muted text-xs ms-1">
                                            <?php echo e(__('What does your company do? What challanges your company solve?')); ?>

                                        </p>
                                        <textarea class="form-control mt-4" rows="10" id="description"
                                                  name="description"><?php if(!empty($model)): ?><?php echo e($model->description); ?><?php endif; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col align-self-center">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">
                                        <?php echo e(__('Team')); ?>

                                    </label>
                                    <p class="form-text text-muted text-xs ms-1">
                                        <?php echo e(__('Who is involved in this journey? List who is enacting different stages of the plan.')); ?>

                                    </p>
                                    <textarea class="form-control mt-4" rows="10" id="team"
                                              name="team"><?php if(!empty($model)): ?><?php echo e($model->team); ?><?php endif; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col align-self-end">
                                <div class="col align-self-center">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">
                                            <?php echo e(__('Business Initiatives')); ?>

                                        </label>
                                        <p class="form-text text-muted text-xs ms-1">
                                            <?php echo e(__('Summary of your marketing goals and initiatives to achieve them. Who are your competitors?Include marketing strategies.')); ?>

                                        </p>
                                        <textarea class="form-control mt-4" rows="10" id="business_initiatives"
                                                  name="business_initiatives"><?php if(!empty($model)): ?><?php echo e($model->business_initiatives); ?><?php endif; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col align-self-center">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">
                                        <?php echo e(__('Target Market')); ?>

                                    </label>
                                    <p class="form-text text-muted text-xs ms-1">
                                        <?php echo e(__('Who are you targeting? Who makes up your target market? Who are your target buyer, personas, and ideal customers?')); ?>

                                    </p>
                                    <textarea class="form-control mt-4" rows="10" id="target_market"
                                              name="target_market"><?php if(!empty($model)): ?><?php echo e($model->target_market); ?><?php endif; ?></textarea>
                                </div>
                            </div>
                        </div>
                            <div>
                                <div class="row mt-4">
                                    <div class="col align-self-center">
                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">
                                                <?php echo e(__('Budget')); ?>

                                            </label>
                                            <p class="form-text text-muted text-xs ms-1">
                                                <?php echo e(__('An overview of the amount you will spend to reach your marketing goals.')); ?>

                                            </p>
                                            <textarea class="form-control mt-4" rows="10" id="budget"
                                                      name="budget">
                                                <?php if(!empty($model)): ?><?php echo e($model->budget); ?><?php endif; ?>
                                            </textarea>
                                        </div>
                                    </div>

                                    <div class="col align-self-center">
                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">
                                                <?php echo e(__('Marketing Channels')); ?>

                                            </label>
                                            <p class="form-text text-muted text-xs ms-1">
                                               <?php echo e(__('Which Channels and platforms you use to reach your audience and achieve your goals?')); ?>

                                            </p>
                                            <textarea class="form-control mt-4" rows="10" id="marketing"
                                                      name="marketing_channels">
                                                <?php if(!empty($model)): ?><?php echo e($model->marketing_channels); ?><?php endif; ?>
                                            </textarea>
                                        </div>
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
                selector: '#budget',
                plugins: 'lists,table',
                toolbar:'styleselect | forecolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image | code | undo redo|numlist bullist',
                lists_indent_on_tab: false,
                branding: false,
                menubar: false,
            });
            tinymce.init({
                selector: '#target_market',
                plugins: 'lists,table',
                toolbar:'styleselect | forecolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image | code | undo redo|numlist bullist',
                lists_indent_on_tab: false,
                branding: false,
                menubar: false,
            });
            tinymce.init({
                selector: '#marketing',
                plugins: 'lists,table',
                toolbar:'styleselect | forecolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image | code | undo redo|numlist bullist',
                lists_indent_on_tab: false,
                branding: false,
                menubar: false,
            });
            tinymce.init({
                selector: '#business_initiatives',
                plugins: 'lists,table',
                toolbar:'styleselect | forecolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image | code | undo redo|numlist bullist',
                lists_indent_on_tab: false,
                branding: false,
                menubar: false,
            });
            tinymce.init({
                selector: '#team',
                plugins: 'lists,table',
                toolbar:'styleselect | forecolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image | code | undo redo|numlist bullist',
                lists_indent_on_tab: false,
                branding: false,
                menubar: false,
            });
            tinymce.init({
                selector: '#description',
                plugins: 'lists,table',
                toolbar:'styleselect | forecolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image | code | undo redo|numlist bullist',
                lists_indent_on_tab: false,
                branding: false,
                menubar: false,
            });
            tinymce.init({
                selector: '#summary',
                plugins: 'lists,table',
                toolbar:'styleselect | forecolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image | code | undo redo|numlist bullist',
                lists_indent_on_tab: false,
                branding: false,
                menubar: false,
            });
        })();
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.primary', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\well-known\resources\views/marketing/add.blade.php ENDPATH**/ ?>