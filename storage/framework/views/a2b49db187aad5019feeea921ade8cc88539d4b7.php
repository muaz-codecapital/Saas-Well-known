<?php $__env->startSection('content'); ?>

    <form method="post" action="/save-startup-canvas">

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h4 class="font-weight-bolder"><?php echo e(__('Startup Model Canvas')); ?></h4>
                </div>
                <div class="col text-end ">
                    <button class="btn btn-info  text-end" type="submit"><?php echo e(__('Save')); ?></button>
                </div>

            </div>

            <p><strong><?php echo e(__('One Page Business Plan')); ?></strong></p>
            <p><?php echo e(__('The Lean Startup Canvas is a version of the Business Model Canvas and it is specially designed for StartUps and Entrepreneurs. The Lean Canvas focuses on addressing broad customer problems, solutions, key metrics, competitive advantages and delivering them to customer segments through a unique value proposition.
')); ?></p>
            <hr>

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
                                            <?php if(!empty($investor)): ?>
                                            <?php if($investor->product_id === $product->id): ?>
                                            selected
                                        <?php endif; ?>
                                        <?php endif; ?>
                                    ><?php echo e($product->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">

                    <!-- Canvas -->
                    <table class="border-0 ">
                        <!-- Upper part -->

                        <tr>
                            <td style= "padding:10px" colspan="2" rowspan="2">
                                <h6><?php echo e(__('Problems')); ?></h6>
                                <textarea  class="bg-purple-light" name="problems" cols="35" rows="30" id="problems"><?php if(!empty($model)): ?><?php echo $model->problems; ?><?php endif; ?></textarea>


                            </td>
                            <td style= "padding:10px" colspan="2">
                                <h6><?php echo e(__('Solutions')); ?></h6>
                                <textarea name="solutions" cols="35" rows="15"  id="solutions"><?php if(!empty($model)): ?><?php echo $model->solutions; ?><?php endif; ?>
                                            </textarea>
                            </td>
                            <td style= "padding:10px" colspan="2" rowspan="2">
                                <h6><?php echo e(__('Unique Value Proposition')); ?></h6>

                                <textarea name="value_propositions" cols="25" rows="30" id="value"><?php if(!empty($model)): ?><?php echo $model->value_propositions; ?><?php endif; ?></textarea>
                            </td>
                            <td style= "padding:10px" colspan="2">
                                <h6><?php echo e(__('Unfair Advantage')); ?></h6>
                                <textarea name="unfair_advantage" cols="35" rows="15" id="advantage"><?php if(!empty($model)): ?><?php echo $model->unfair_advantage; ?><?php endif; ?></textarea>
                            </td>
                            <td style= "padding:10px" colspan="2" rowspan="2">
                                <h6><?php echo e(__('Customer Segments')); ?></h6>

                                <textarea name="customer_segments" cols="35" rows="30" id="customer_segments"><?php if(!empty($model)): ?><?php echo $model->customer_segments; ?><?php endif; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td style= "padding:10px" colspan="2">
                                <h6><?php echo e(__('Key Metrics')); ?></h6>

                                <textarea name="key_matrices" cols="35" rows="15" style="background-color:#C1F5D3; border-color:#C1F5D3; padding:10px" id="metrics"><?php if(!empty($model)): ?><?php echo $model->key_matrices; ?><?php endif; ?></textarea>
                            </td>
                            <td style= "padding:10px" colspan="2">
                                <h6><?php echo e(__('Channels')); ?></h6>

                                <textarea name="channels" cols="35" rows="15" id="channels"><?php if(!empty($model)): ?><?php echo $model->channels; ?><?php endif; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td style= "padding:10px" colspan="5">
                                <h6><?php echo e(__('Cost Structure')); ?></h6>

                                <textarea name="cost_structure" cols="75" rows="15" id="cost_structure"><?php if(!empty($model)): ?><?php echo $model->cost_structure; ?><?php endif; ?></textarea>
                            </td>
                            <td style= "padding:10px" colspan="5">
                                <h6><?php echo e(__('Revenue Streams')); ?></h6>

                                <textarea name="revenue_stream" cols="75" rows="15" style=" padding:10px" id="revenue_stream"><?php if(!empty($model)): ?><?php echo $model->revenue_stream; ?><?php endif; ?></textarea>
                            </td>
                        </tr>
                    </table>
                    <!-- /Canvas -->
                </div>

                <?php if($model): ?>
                    <input type="hidden" name="id" value="<?php echo e($model->id); ?>">
                    <input type="hidden" name="admin_id" value="<?php echo e($model->admin_id); ?>">
                <?php endif; ?>
                <?php echo csrf_field(); ?>
                <button class="btn btn-info mt-4" type="submit"><?php echo e(__('Save')); ?></button>

        </div>
    </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script>
        $(function () {
            "use strict";
            flatpickr("#date", {

                dateFormat: "Y-m-d",
            });

        });

    </script>
    <script>

        (function(){
            "use strict";



            tinymce.init({
                selector: '#problems',

                plugins: 'lists,table',
                toolbar: 'styleselect | forecolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image | code | undo redo|numlist bullist',

                lists_indent_on_tab: false,

                branding: false,
                menubar: false,

            });
            tinymce.init({
                selector: '#solutions',

                plugins: 'lists,table',
                toolbar: 'styleselect | forecolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image | code | undo redo|numlist bullist',
                lists_indent_on_tab: false,
                branding: false,
                menubar: false,
            });
            tinymce.init({
                selector: '#value',

                plugins: 'lists,table',
                toolbar: 'styleselect | forecolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image | code | undo redo|numlist bullist',
                lists_indent_on_tab: false,
                branding: false,
                menubar: false,
            });
            tinymce.init({
                selector: '#advantage',

                plugins: 'lists,table',
                toolbar: 'styleselect | forecolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image | code | undo redo|numlist bullist',
                lists_indent_on_tab: false,
                branding: false,
                menubar: false,
            });
            tinymce.init({
                selector: '#metrics',

                plugins: 'lists,table',
                toolbar: 'styleselect | forecolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image | code | undo redo|numlist bullist',
                lists_indent_on_tab: false,
                branding: false,
                menubar: false,
            });
            tinymce.init({
                selector: '#cost_structure',

                plugins: 'lists,table',
                toolbar: 'styleselect | forecolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image | code | undo redo|numlist bullist',
                lists_indent_on_tab: false,
                branding: false,
                menubar: false,
            });
            tinymce.init({
                selector: '#customer_segments',

                plugins: 'lists,table',
                toolbar: 'styleselect | forecolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image | code | undo redo|numlist bullist',
                lists_indent_on_tab: false,
                branding: false,
                menubar: false,
            });
            tinymce.init({
                selector: '#channels',

                plugins: 'lists,table',
                toolbar: 'styleselect | forecolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image | code | undo redo|numlist bullist',
                lists_indent_on_tab: false,
                branding: false,
                menubar: false,
            });
            tinymce.init({
                selector: '#value_propositions',

                plugins: 'lists,table',
                toolbar: 'styleselect | forecolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image | code | undo redo|numlist bullist',
                lists_indent_on_tab: false,
                branding: false,
                menubar: false,
            });
            tinymce.init({
                selector: '#revenue_stream',

                plugins: 'lists,table',
                toolbar:'styleselect | forecolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image | code | undo redo|numlist bullist',
                lists_indent_on_tab: false,
                branding: false,
                menubar: false,
            });
        })();
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.primary', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/freylphj/suiteup.grsventures.ltd/resources/views/startup-canvas/design-business-model.blade.php ENDPATH**/ ?>