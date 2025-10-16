<?php $__env->startSection('content'); ?>


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="font-weight-bolder"><?php echo e(__('Business Model Canvas')); ?></h4>
                    <p><strong><?php echo e(__('Source: Harvard Business Review, Entreprenuers Handbook ')); ?></strong></p>
                    <hr>


                    <form method="post" action="/business-model-post">
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
                        <div class="row mt-4">
                            <div class="col align-self-center">
                                <div class="form-group">

                                    <label for="exampleFormControlTextarea1">
                                        <?php echo e(__('Key Partners')); ?>

                                    </label>
                                    <p class="form-text text-muted text-xs ms-1">
                                        <?php echo e(__('Who are our key partners?')); ?>


                                    </p>
                                    <p class="form-text text-muted text-xs ms-1">

                                        <?php echo e(__('Who are our key Suppliers?')); ?>


                                    </p>
                                    <p class="form-text text-muted text-xs ms-1">

                                        <?php echo e(__('Which key resources are we acquiring from our partners?')); ?>


                                    </p>

                                    <textarea class="form-control mt-4" rows="10" id="partners"
                                              name="partners"><?php if(!empty($model)): ?><?php echo e($model->partners); ?><?php endif; ?></textarea>
                                    <?php if(!empty($super_settings['openai_api_key'])): ?>
                                        <button class="btn btn-info mt-4" type="submit" id="generate_key_partners"><?php echo e(__('Generate with AI')); ?></button>
                                    <?php endif; ?>
                                    <button class="btn bg-success-light text-success shadow-none mt-4" type="submit"><?php echo e(__('Save')); ?></button>

                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col align-self-end">
                                <div class="col align-self-center">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">
                                            <?php echo e(__('Key Activities')); ?>

                                        </label>
                                        <p class="form-text text-muted text-xs ms-1">
                                            <?php echo e(__('What key activities do our value propositions require?')); ?>

                                        </p>
                                        <textarea class="form-control mt-4" rows="10" id="activities"
                                                  name="activities"><?php if(!empty($model)): ?><?php echo e($model->activities); ?><?php endif; ?></textarea>

                                        <?php if(!empty($super_settings['openai_api_key'])): ?>
                                            <button class="btn btn-info mt-4" type="submit" id="generate_key_activities"><?php echo e(__('Generate with AI')); ?></button>
                                        <?php endif; ?>
                                        <button class="btn bg-success-light text-success shadow-none mt-4" type="submit"><?php echo e(__('Save')); ?></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col align-self-center">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">
                                        <?php echo e(__('Key Resources')); ?>

                                    </label>
                                    <p class="form-text text-muted text-xs ms-1">
                                        <?php echo e(__('What key resources do our value propositions require?')); ?>

                                    </p>
                                    <textarea class="form-control mt-4" rows="10" id="resources"
                                              name="resources"><?php if(!empty($model)): ?><?php echo e($model->resources); ?><?php endif; ?></textarea>
                                    <?php if(!empty($super_settings['openai_api_key'])): ?>
                                        <button class="btn btn-info mt-4" type="submit" id="generate_key_resources"><?php echo e(__('Generate with AI')); ?></button>
                                    <?php endif; ?>
                                    <button class="btn bg-success-light text-success shadow-none mt-4" type="submit"><?php echo e(__('Save')); ?></button>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col align-self-center">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">
                                        <?php echo e(__('Value Propositions')); ?>

                                    </label>
                                    <p class="form-text text-muted text-xs ms-1">
                                        <?php echo e(__(' What value do we deliver to the customer ?')); ?>

                                    </p>
                                    <p class="form-text text-muted text-xs ms-1">
                                        <?php echo e(__('Which one of our customers problem are we helping to solve?')); ?>

                                    </p>
                                    <p class="form-text text-muted text-xs ms-1">
                                        <?php echo e(__('What bundle of products or services are we offering to each segment?')); ?>

                                    </p>
                                    <p class="form-text text-muted text-xs ms-1">
                                        <?php echo e(__('Which customer needs are we satisfying?')); ?>

                                    </p>
                                    <p class="form-text text-muted text-xs ms-1">
                                        <?php echo e(__('What is the minimum viable product?')); ?>

                                    </p>

                                    <textarea class="form-control" rows="10" id="value_propositions"
                                              name="value_propositions">
<?php if(!empty($model)): ?><?php echo e($model->value_propositions); ?><?php endif; ?></textarea>
                                    <?php if(!empty($super_settings['openai_api_key'])): ?>
                                        <button class="btn btn-info mt-4" type="submit" id="generate_value_propositions"><?php echo e(__('Generate with AI')); ?></button>
                                    <?php endif; ?>
                                    <button class="btn bg-success-light text-success shadow-none mt-4" type="submit"><?php echo e(__('Save')); ?></button>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col align-self-end">
                                <div class="col align-self-center">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">
                                            <?php echo e(__('Customer Relationships')); ?>

                                        </label>
                                        <p class="form-text text-muted text-xs ms-1">
                                            <?php echo e(__(' How do we get, keep and grow customers?')); ?>

                                        </p>
                                        <p class="form-text text-muted text-xs ms-1">
                                            <?php echo e(__(' Which cuustomer relationships have we established ?')); ?>

                                        </p>
                                        <p class="form-text text-muted text-xs ms-1">
                                            <?php echo e(__(' How are they integrated with the rest of our business model?')); ?>

                                        </p>
                                        <p class="form-text text-muted text-xs ms-1">
                                            <?php echo e(__('How costly are they?')); ?>


                                        </p>

                                        <textarea class="form-control mt-4" rows="10" id="customer_relationships" name="customer_relationships"><?php if(!empty($model)): ?><?php echo e($model->customer_relationships); ?><?php endif; ?></textarea>

                                        <?php if(!empty($super_settings['openai_api_key'])): ?>
                                            <button class="btn btn-info mt-4" type="submit" id="generate_customer_relationships"><?php echo e(__('Generate with AI')); ?></button>
                                        <?php endif; ?>
                                        <button class="btn bg-success-light text-success shadow-none mt-4" type="submit"><?php echo e(__('Save')); ?></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col align-self-center">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">
                                        <?php echo e(__('Channels')); ?>

                                    </label>
                                    <p class="form-text text-muted text-xs ms-1">
                                        <?php echo e(__('  Through which channels do our customer segments wants to be reached?')); ?>

                                    </p>
                                    <p class="form-text text-muted text-xs ms-1">
                                        <?php echo e(__('How do other companies reach them now?')); ?>

                                    </p>
                                    <p class="form-text text-muted text-xs ms-1">
                                        <?php echo e(__('Which ones work best?')); ?>

                                    </p>
                                    <p class="form-text text-muted text-xs ms-1">
                                        <?php echo e(__('Which ones are most cost-efficient?')); ?>

                                    </p>
                                    <p class="form-text text-muted text-xs ms-1">
                                        <?php echo e(__('How are we integrating them with customer routines?')); ?>

                                    </p>
                                    <textarea class="form-control mt-4" rows="10" id="channels" name="channels"><?php if(!empty($model)): ?><?php echo e($model->channels); ?><?php endif; ?></textarea>
                                    <?php if(!empty($super_settings['openai_api_key'])): ?>
                                        <button class="btn btn-info mt-4" type="submit" id="generate_channels"><?php echo e(__('Generate with AI')); ?></button>
                                    <?php endif; ?>
                                    <button class="btn bg-success-light text-success shadow-none mt-4" type="submit"><?php echo e(__('Save')); ?></button>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col align-self-center">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">
                                        <?php echo e(__('Customer Segments')); ?>

                                    </label>
                                    <p class="form-text text-muted text-xs ms-1">
                                        <?php echo e(__('For whom are we creating value?')); ?>


                                    </p>
                                    <p class="form-text text-muted text-xs ms-1">
                                        <?php echo e(__('Who are our most important customers?')); ?>


                                    </p>
                                    <p class="form-text text-muted text-xs ms-1">
                                        <?php echo e(__('What are the customer archetypes?')); ?>

                                    </p>
                                    <textarea class="form-control" rows="10" id="customer_segments" name="customer_segments">
<?php if(!empty($model)): ?><?php echo e($model->customer_segments); ?><?php endif; ?></textarea>
                                    <?php if(!empty($super_settings['openai_api_key'])): ?>
                                        <button class="btn btn-info mt-4" type="submit" id="generate_customer_segments"><?php echo e(__('Generate with AI')); ?></button>
                                    <?php endif; ?>
                                    <button class="btn bg-success-light text-success shadow-none mt-4" type="submit"><?php echo e(__('Save')); ?></button>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col align-self-end">
                                <div class="col align-self-center">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">
                                            <?php echo e(__('Cost Structure')); ?>

                                        </label>
                                        <p class="form-text text-muted text-xs ms-1">
                                            <?php echo e(__('What are the most important costs inherent to our business model?')); ?>

                                        </p>
                                        <p class="form-text text-muted text-xs ms-1">
                                            <?php echo e(__('Which key resources are most expensive?')); ?>


                                        </p>
                                        <p class="form-text text-muted text-xs ms-1">
                                            <?php echo e(__('Which key activities are most expensive?')); ?>


                                        </p>


                                        <textarea class="form-control" rows="10" id="cost_structure"
                                                  name="cost_structure">
<?php if(!empty($model)): ?><?php echo e($model->cost_structure); ?><?php endif; ?></textarea>
                                        <?php if(!empty($super_settings['openai_api_key'])): ?>
                                            <button class="btn btn-info mt-4" type="submit" id="generate_cost_structure"><?php echo e(__('Generate with AI')); ?></button>
                                        <?php endif; ?>
                                        <button class="btn bg-success-light text-success shadow-none mt-4" type="submit"><?php echo e(__('Save')); ?></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col align-self-center">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">
                                        <?php echo e(__('Revenue Stream')); ?>

                                    </label>
                                    <p class="form-text text-muted text-xs ms-1">
                                        <?php echo e(__('For what value are our customers willing to pay?')); ?>

                                    </p>
                                    <p class="form-text text-muted text-xs ms-1">
                                        <?php echo e(__('For what do they currently pay?')); ?>

                                    </p>
                                    <p class="form-text text-muted text-xs ms-1">
                                        <?php echo e(__('What is the revenue model?')); ?>

                                    </p>
                                    <p class="form-text text-muted text-xs ms-1">
                                        <?php echo e(__('What are the pricing tactics?')); ?>

                                    </p>
                                    <textarea class="form-control" rows="10" id="revenue_stream" name="revenue_stream"><?php if(!empty($model)): ?><?php echo e($model->revenue_stream); ?><?php endif; ?></textarea>
                                    <?php if(!empty($super_settings['openai_api_key'])): ?>
                                        <button class="btn btn-info mt-4" type="submit" id="generate_revenue_stream"><?php echo e(__('Generate with AI')); ?></button>
                                    <?php endif; ?>
                                    <button class="btn bg-success-light text-success shadow-none mt-4" type="submit"><?php echo e(__('Save')); ?></button>
                                </div>
                            </div>
                        </div>
                        <?php if($model): ?>
                            <input type="hidden" name="id" value="<?php echo e($model->id); ?>">
                        <?php endif; ?>
                        <?php echo csrf_field(); ?>
                       <button class="btn btn-dark shadow-none mt-4" type="submit"><?php echo e(__('Save')); ?></button>
                      <a href="/business-models" class="btn btn-secondary mt-4" type="submit"><?php echo e(__('Go Back to list')); ?></a>
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
            flatpickr("#date", {

                dateFormat: "Y-m-d",
            });
            tinymce.init({
                selector: '#partners',

                plugins: 'lists,table',
                toolbar:'styleselect | forecolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image | code | undo redo|numlist bullist',
                lists_indent_on_tab: false,
                branding: false,
                menubar: false,
                content_langs: [

                    { title: 'French', code: 'fr' },

                ]
            });
            tinymce.init({
                selector: '#activities',
                plugins: 'lists,table',
                toolbar:'styleselect | forecolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image | code | undo redo|numlist bullist',
                lists_indent_on_tab: false,
                branding: false,
                menubar: false,
            });
            tinymce.init({
                selector: '#resources',

                plugins: 'lists,table',
                toolbar:'styleselect | forecolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image | code | undo redo|numlist bullist',
                lists_indent_on_tab: false,
                branding: false,
                menubar: false,
            });
            tinymce.init({
                selector: '#customer_relationships',
                plugins: 'lists,table',
                toolbar:'styleselect | forecolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image | code | undo redo|numlist bullist',
                lists_indent_on_tab: false,
                branding: false,
                menubar: false,
            });
            tinymce.init({
                selector: '#cost_structure',

                plugins: 'lists,table',
                toolbar:'styleselect | forecolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image | code | undo redo|numlist bullist',
                lists_indent_on_tab: false,
                branding: false,
                menubar: false,
            });
            tinymce.init({
                selector: '#customer_segments',

                plugins: 'lists,table',
                toolbar:'styleselect | forecolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image | code | undo redo|numlist bullist',
                lists_indent_on_tab: false,
                branding: false,
                menubar: false,
            });
            tinymce.init({
                selector: '#channels',

                plugins: 'lists,table',
                toolbar:'styleselect | forecolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image | code | undo redo|numlist bullist',
                lists_indent_on_tab: false,
                branding: false,
                menubar: false,
            });
            tinymce.init({
                selector: '#value_propositions',

                plugins: 'lists,table',
                toolbar:'styleselect | forecolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image | code | undo redo|numlist bullist',
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


            <?php if(!empty($super_settings['openai_api_key'])): ?>

            let generate_key_partners = document.getElementById('generate_key_partners');
            let key_partners = document.getElementById('key_partners');

            generate_key_partners.addEventListener('click',function (e) {
                e.preventDefault();

                generate_key_partners.disabled = true;
                generate_key_partners.innerHTML = '<i class="fa fa-spinner fa-spin"></i> <?php echo e(__('Generating')); ?>';

                axios.post('/ai',{
                    _token:'<?php echo e(csrf_token()); ?>',
                    company_name:'<?php echo e($model->company_name ?? ''); ?>',
                    action: 'key_partners',
                }).then(function (response) {
                    tinymce.get("partners").setContent(response.data.message);

                    generate_key_partners.disabled = false;
                    generate_key_partners.innerHTML = '<?php echo e(__('Generate')); ?>';

                }).catch(function (error) {
                    console.log(error);
                });
            });

            let generate_key_activities = document.getElementById('generate_key_activities');
            let key_activities = document.getElementById('key_activities');

            generate_key_activities.addEventListener('click',function (e) {
                e.preventDefault();

                generate_key_activities.disabled = true;
                generate_key_activities.innerHTML = '<i class="fa fa-spinner fa-spin"></i> <?php echo e(__('Generating')); ?>';

                axios.post('/ai',{
                    _token:'<?php echo e(csrf_token()); ?>',
                    company_name:'<?php echo e($model->company_name ?? ''); ?>',
                    action: 'key_activities',
                }).then(function (response) {
                    tinymce.get("activities").setContent(response.data.message);

                    generate_key_activities.disabled = false;
                    generate_key_activities.innerHTML = '<?php echo e(__('Generate')); ?>';

                }).catch(function (error) {
                    console.log(error);
                });
            });

            let generate_key_resources = document.getElementById('generate_key_resources');
            let key_resources = document.getElementById('key_resources');

            generate_key_resources.addEventListener('click',function (e) {
                e.preventDefault();

                generate_key_resources.disabled = true;
                generate_key_resources.innerHTML = '<i class="fa fa-spinner fa-spin"></i> <?php echo e(__('Generating')); ?>';

                axios.post('/ai',{
                    _token:'<?php echo e(csrf_token()); ?>',
                    company_name:'<?php echo e($model->company_name ?? ''); ?>',
                    action: 'key_resources',
                }).then(function (response) {
                    tinymce.get("resources").setContent(response.data.message);

                    generate_key_resources.disabled = false;
                    generate_key_resources.innerHTML = '<?php echo e(__('Generate')); ?>';

                }).catch(function (error) {
                    console.log(error);
                });
            });


            let generate_value_propositions = document.getElementById('generate_value_propositions');
            let value_propositions = document.getElementById('value_propositions');

            generate_value_propositions.addEventListener('click',function (e) {
                e.preventDefault();

                generate_value_propositions.disabled = true;
                generate_value_propositions.innerHTML = '<i class="fa fa-spinner fa-spin"></i> <?php echo e(__('Generating')); ?>';

                axios.post('/ai',{
                    _token:'<?php echo e(csrf_token()); ?>',
                    company_name:'<?php echo e($model->company_name ?? ''); ?>',
                    action: 'value_propositions',
                }).then(function (response) {
                    tinymce.get("value_propositions").setContent(response.data.message);

                    generate_value_propositions.disabled = false;
                    generate_value_propositions.innerHTML = '<?php echo e(__('Generate')); ?>';

                }).catch(function (error) {
                    console.log(error);
                });
            });

            let generate_customer_relationships = document.getElementById('generate_customer_relationships');
            let customer_relationships = document.getElementById('customer_relationships');

            generate_customer_relationships.addEventListener('click',function (e) {
                e.preventDefault();

                generate_customer_relationships.disabled = true;
                generate_customer_relationships.innerHTML = '<i class="fa fa-spinner fa-spin"></i> <?php echo e(__('Generating')); ?>';

                axios.post('/ai',{
                    _token:'<?php echo e(csrf_token()); ?>',
                    company_name:'<?php echo e($model->company_name ?? ''); ?>',
                    action: 'customer_relationships',
                }).then(function (response) {
                    tinymce.get("customer_relationships").setContent(response.data.message);

                    generate_customer_relationships.disabled = false;
                    generate_customer_relationships.innerHTML = '<?php echo e(__('Generate')); ?>';

                }).catch(function (error) {
                    console.log(error);
                });
            });

            let generate_channels = document.getElementById('generate_channels');
            let channels = document.getElementById('channels');

            generate_channels.addEventListener('click',function (e) {
                e.preventDefault();

                generate_channels.disabled = true;
                generate_channels.innerHTML = '<i class="fa fa-spinner fa-spin"></i> <?php echo e(__('Generating')); ?>';

                axios.post('/ai',{
                    _token:'<?php echo e(csrf_token()); ?>',
                    company_name:'<?php echo e($model->company_name ?? ''); ?>',
                    action: 'channels',
                }).then(function (response) {
                    tinymce.get("channels").setContent(response.data.message);

                    generate_channels.disabled = false;
                    generate_channels.innerHTML = '<?php echo e(__('Generate')); ?>';

                }).catch(function (error) {
                    console.log(error);
                });
            });

            let generate_customer_segments = document.getElementById('generate_customer_segments');
            let customer_segments = document.getElementById('customer_segments');

            generate_customer_segments.addEventListener('click',function (e) {
                e.preventDefault();

                generate_customer_segments.disabled = true;
                generate_customer_segments.innerHTML = '<i class="fa fa-spinner fa-spin"></i> <?php echo e(__('Generating')); ?>';

                axios.post('/ai',{
                    _token:'<?php echo e(csrf_token()); ?>',
                    company_name:'<?php echo e($model->company_name ?? ''); ?>',
                    action: 'customer_segments',
                }).then(function (response) {
                    tinymce.get("customer_segments").setContent(response.data.message);

                    generate_customer_segments.disabled = false;
                    generate_customer_segments.innerHTML = '<?php echo e(__('Generate')); ?>';

                }).catch(function (error) {
                    console.log(error);
                });
            });

            let generate_cost_structure = document.getElementById('generate_cost_structure');
            let cost_structure = document.getElementById('cost_structure');

            generate_cost_structure.addEventListener('click',function (e) {
                e.preventDefault();

                generate_cost_structure.disabled = true;
                generate_cost_structure.innerHTML = '<i class="fa fa-spinner fa-spin"></i> <?php echo e(__('Generating')); ?>';

                axios.post('/ai',{
                    _token:'<?php echo e(csrf_token()); ?>',
                    company_name:'<?php echo e($model->company_name ?? ''); ?>',
                    action: 'cost_structure',
                }).then(function (response) {
                    tinymce.get("cost_structure").setContent(response.data.message);

                    generate_cost_structure.disabled = false;
                    generate_cost_structure.innerHTML = '<?php echo e(__('Generate')); ?>';

                }).catch(function (error) {
                    console.log(error);
                });
            });

            let generate_revenue_stream = document.getElementById('generate_revenue_stream');
            let revenue_stream = document.getElementById('revenue_stream');

            generate_revenue_stream.addEventListener('click',function (e) {
                e.preventDefault();

                generate_revenue_stream.disabled = true;
                generate_revenue_stream.innerHTML = '<i class="fa fa-spinner fa-spin"></i> <?php echo e(__('Generating')); ?>';

                axios.post('/ai',{
                    _token:'<?php echo e(csrf_token()); ?>',
                    company_name:'<?php echo e($model->company_name ?? ''); ?>',
                    action: 'revenue_stream',
                }).then(function (response) {
                    tinymce.get("revenue_stream").setContent(response.data.message);

                    generate_revenue_stream.disabled = false;
                    generate_revenue_stream.innerHTML = '<?php echo e(__('Generate')); ?>';

                }).catch(function (error) {
                    console.log(error);
                });
            });



            <?php endif; ?>

        })();
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.primary', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/freylphj/suiteup.grsventures.ltd/resources/views/business-model/design-business-model.blade.php ENDPATH**/ ?>