<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <h3><?php echo e(__('Write your Business plan')); ?></h3>
        </div>
        <div class="card-body multisteps-form">
            <form action="/business-plan-post" class="multisteps-form__form mb-8" enctype="multipart/form-data" method="post">
                <?php if($errors->any()): ?>
                    <div class="alert bg-pink-light text-danger">
                        <ul class="list-unstyled">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error => $error_message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error_message); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="example-text-input" class="form-control-label"><?php echo e(__('Business Name')); ?></label><label class="text-danger">*</label>
                    <input class="form-control" type="text" name="company_name"
                        value="<?php echo e($plan->company_name ?? old('company_name') ?? ''); ?>">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-search-input" class="form-control-label"><?php echo e(__('Your Name')); ?></label><label class="text-danger">*</label>
                            <input class="form-control" name="name" type="text"
                                   value="<?php echo e($plan->name ?? old('name') ?? ''); ?>">
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-search-input" class="form-control-label"><?php echo e(__('Date')); ?></label>
                            <input class="form-control" name="date" id="date" <?php if(!empty($plan)): ?>
                            value="<?php echo e($plan->date); ?>"
                                   <?php else: ?>
                                   value="<?php echo e(date('Y-m-d')); ?>"
                                <?php endif; ?> >
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-email-input" class="form-control-label"><?php echo e(__('Email')); ?></label>
                            <input class="form-control" type="email" name="email"
                                   <?php if(!empty($plan)): ?>value="<?php echo e($plan->email); ?>"<?php endif; ?>>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-tel-input" class="form-control-label"><?php echo e(__('Phone')); ?></label>
                            <input class="form-control" type="tel" name="phone"
                                   <?php if(!empty($plan)): ?>value="<?php echo e($plan->phone); ?>"<?php endif; ?>>
                        </div>
                    </div>
                </div>
                    <div class="form-group">
                        <label for="logo_file" class="form-label mt-4"><?php echo e(__('Upload Logo')); ?></label>
                        <input class="form-control" name="logo" type="file" id="logo_file">
                    </div>
                <div class="form-group">
                    <label for="example-url-input" class="form-control-label"><?php echo e(__('Website')); ?></label>
                    <input class="form-control" name="website"
                           <?php if(!empty($plan)): ?>value="<?php echo e($plan->website); ?>"<?php endif; ?>>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">
                        <?php echo e(__('Executive Summary')); ?>


                    </label>
                    <p class="form-text text-muted text-xs ms-1">
                        <?php echo e(__('A snapshot of your business')); ?>

                    </p>
                    <textarea class="form-control" name="ex_summary" id="ex_summary"
                              rows="10"><?php if(!empty($plan)): ?><?php echo e($plan->ex_summary); ?><?php endif; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">
                        <?php echo e(__('Company description')); ?>


                    </label>
                    <p class="form-text text-muted text-xs ms-1">
                        <?php echo e(__('Describe what you do')); ?>

                    </p>
                    <textarea class="form-control" name="description" id="com_description"
                              rows="10"><?php if(!empty($plan)): ?><?php echo e($plan->description); ?><?php endif; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">
                        <?php echo e(__('Market Analysis')); ?>


                    </label>
                    <p class="form-text text-muted text-xs ms-1">
                        <?php echo e(__('Rsesearch on your industry, market and competitors')); ?>

                    </p>
                    <textarea class="form-control" name="m_analysis" id="market_analysis"
                              rows="10"><?php if(!empty($plan)): ?><?php echo e($plan->m_analysis); ?><?php endif; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">
                        <?php echo e(__('Organization & Management')); ?>


                    </label>
                    <p class="form-text text-muted text-xs ms-1">
                        <?php echo e(__('Your business and management structure')); ?>

                    </p>
                    <textarea class="form-control" name="management" id="organization"
                              rows="10"><?php if(!empty($plan)): ?><?php echo e($plan->management); ?><?php endif; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">
                        <?php echo e(__('Service or product')); ?>


                    </label>
                    <p class="form-text text-muted text-xs ms-1">
                        <?php echo e(__('The products or services you’re offering')); ?>

                    </p>
                    <textarea class="form-control" name="product" id="service_product"
                              rows="10"><?php if(!empty($plan)): ?><?php echo e($plan->product); ?><?php endif; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">
                        <?php echo e(__('Marketing and sales')); ?>


                    </label>
                    <p class="form-text text-muted text-xs ms-1">
                        <?php echo e(__('How you’ll market your business and your sales strategy')); ?>

                    </p>
                    <textarea class="form-control" name="marketing" id="marketing_sale"
                              rows="10"><?php if(!empty($plan)): ?><?php echo e($plan->marketing); ?><?php endif; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">
                        <?php echo e(__('Budget')); ?>


                    </label>
                    <p class="form-text text-muted text-xs ms-1">
                        <?php echo e(__('Budget of your company for next 2 years with source of the moneys')); ?>

                    </p>
                    <textarea class="form-control" name="budget" id="budget"
                              rows="10"><?php if(!empty($plan)): ?><?php echo e($plan->budget); ?><?php endif; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">
                        <?php echo e(__('Investment/Funding request')); ?>


                    </label>
                    <p class="form-text text-muted text-xs ms-1">
                        <?php echo e(__('How much money you’ll need for next 3 to 5 years')); ?>

                    </p>
                    <textarea class="form-control" name="investment" id="investment"
                              rows="10"><?php if(!empty($plan)): ?><?php echo e($plan->investment); ?><?php endif; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">
                        <?php echo e(__('Financial projections')); ?>


                    </label>
                    <p class="form-text text-muted text-xs ms-1">
                        <?php echo e(__('Supply information like balance sheets')); ?>

                    </p>
                    <textarea class="form-control" name="finance" id="financial_projections"
                              rows="10"><?php if(!empty($plan)): ?><?php echo e($plan->finance); ?><?php endif; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">
                        <?php echo e(__('Appendix')); ?>


                    </label>
                    <p class="form-text text-muted text-xs ms-1">
                        <?php echo e(__('An optional section that includes résumés and permits')); ?>

                    </p>
                    <textarea class="form-control" name="appendix" id="appendix"
                              rows="10"><?php if(!empty($plan)): ?><?php echo e($plan->appendix); ?><?php endif; ?></textarea>
                </div>
                    <div class="form-group mb-4">
                        <label for="logo_file" class="form-label mt-3 "><?php echo e(__('Upload file')); ?></label>
                        <p class="form-text text-muted text-xs ms-1">
                            <?php echo e(__('Upload résumés and permits')); ?>

                        </p>
                        <input class="form-control" name="file" type="file" id="logo_file">
                    </div>

                <?php echo csrf_field(); ?>
                <?php if($plan): ?>
                    <input type="hidden" name="id" value="<?php echo e($plan->id); ?>">
                <?php endif; ?>
                <button type="submit" class="btn bg-gradient-dark"><?php echo e(__('Save')); ?></button>

            </form>
        </div>
    </div>

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
                selector: '#ex_summary',

                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                branding: false,

            });
            tinymce.init({
                selector: '#com_description',

                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                branding: false,

            });
            tinymce.init({
                selector: '#market_analysis',

                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',

                    'insertdatetime media table paste code  wordcount'
                ],
                toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                branding: false,


            });
            tinymce.init({
                selector: '#organization',

                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',

                    'insertdatetime media table paste code  wordcount'
                ],
                toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                branding: false,


            });
            tinymce.init({
                selector: '#service_product',

                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',

                    'insertdatetime media table paste code  wordcount'
                ],
                toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                branding: false,


            });
            tinymce.init({
                selector: '#marketing_sale',

                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',

                    'insertdatetime media table paste code  wordcount'
                ],
                toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                branding: false,


            });
            tinymce.init({
                selector: '#budget',

                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',

                    'insertdatetime media table paste code  wordcount'
                ],
                toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                branding: false,


            });
            tinymce.init({
                selector: '#investment',

                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',

                    'insertdatetime media table paste code  wordcount'
                ],
                toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                branding: false,


            });
            tinymce.init({
                selector: '#financial_projections',

                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',

                    'insertdatetime media table paste code  wordcount'
                ],
                toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                branding: false,
            });
            tinymce.init({
                selector: '#appendix',
                plugins: 'lists,table',
                toolbar: 'numlist bullist',
                lists_indent_on_tab: false,
                branding: false,

            });
        })();
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.primary', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/freylphj/suiteup.grsventures.ltd/resources/views/plans/write-business-plan.blade.php ENDPATH**/ ?>