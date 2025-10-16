<?php $__env->startSection('content'); ?>
    <div class=" row">
        <div class="col">
            <h5 class="text-secondary fw-bolder">
                <?php echo e(__('Business Models')); ?>

            </h5>
        </div>
        <div class="col text-end">
            <a href="/design-business-model" type="button" class="btn btn-info " data-bs-toggle="modal" data-bs-target="#exampleModal"><?php echo e(__('Design Business Model')); ?></a>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mx-auto">

            <form >
                <div class="row  mb-3 mt-4">
                    <div class="col-md-6">
                        <label class="form-label  visually-hidden" for="searchJobCareers"><?php echo e(__('Search')); ?></label>

                        <!-- Form -->

                        <div class="input-group input-group-merge mb-3">

                            <input type="text" name="company_name" class="form-control form-control-lg" id="searchJobCareers" placeholder="Search business model" aria-label="Search business model">

                        </div>
                        <!-- End Form -->
                    </div>

                    <!-- End Col -->


                    <!-- End Col -->

                    <div class="col-md-3">

                        <!-- Select -->
                        <select class="form-select form-select-lg mb-3" name="product_id" id="model" aria-label="">
                            <option value="0"><?php echo e(__('Product')); ?></option>
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
                        <!-- End Select -->
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-block bg-purple-light text-purple shadow-none
                        btn-lg btn-rounded me-3">
                            <i class="fas fa-search me-2"></i>
                            <?php echo e(__('Search')); ?></button>
                        <!-- End Select -->
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->
            </form>
        </div>
        <div class="col-12">
            <div class="row">
                <?php $__currentLoopData = $models; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-4 col-md-6 col-12 mt-lg-0 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row ">
                                    <div class="col-md-9">
                                        <h5 class="text-dark fw-bolder"><?php echo e($model->company_name); ?></h5>

                                        <p class="text-sm"><?php echo e(__('Related Product')); ?>:<span class="text-dark fw-bolder"> <?php if(!empty($products[$model->product_id])): ?>
                                                    <?php if(isset($products[$model->product_id])): ?>
                                                        <?php echo e($products[$model->product_id]->title); ?>

                                                    <?php endif; ?>
                                                <?php endif; ?></span></p>
                                        <p class="text-sm"><?php echo e(__('Designed By')); ?>:<span class="text-purple fw-bolder"> <?php if(isset($users[$model->admin_id])): ?>
                                                    <?php echo e($users[$model->admin_id]->first_name); ?> <?php echo e($users[$model->admin_id]->last_name); ?>

                                                <?php endif; ?></span></p>
                                        <p class="text-sm"><?php echo e(__('Created At')); ?>:
                                            <span class="badge bg-info"> <?php echo e((\App\Supports\DateSupport::parse($model->updated_at))->format(config('app.date_format'))); ?></span></p>
                                    </div>
                                    <div class="col-3 text-end">
                                        <div class="dropstart">
                                            <a href="javascript:" class="text-secondary" id="dropdownMarketingCard"
                                               data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-lg-start px-2 py-3"
                                                aria-labelledby="dropdownMarketingCard">
                                                <li><a class="dropdown-item border-radius-md"
                                                       href="/design-business-model?id=<?php echo e($model->id); ?>"><?php echo e(__('Edit')); ?></a>
                                                </li>
                                                <li><a class="dropdown-item border-radius-md"
                                                       href="/view-business-model?id=<?php echo e($model->id); ?>"><?php echo e(__('See Details')); ?></a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li><a class="dropdown-item border-radius-md text-danger"
                                                       href="/delete/business-model/<?php echo e($model->id); ?>"><?php echo e(__('Delete')); ?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>


    <!-- Button trigger modal -->




    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"><?php echo e(__('Business Model Canvas')); ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">
                                    <?php echo e(__('Business/Company Name')); ?>

                                </label><label class="text-danger">*</label>
                                <input class="form-control" name="company_name" id="company_name">
                            </div>

                        </div>
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





                        <?php echo csrf_field(); ?>
                        <button class="btn btn-info mt-4" type="submit"><?php echo e(__('Save')); ?></button>
                            <button type="button" class="btn btn-secondary mt-4" data-bs-dismiss="modal">Close</button>
                    </form>
                </div>




            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.primary', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/freylphj/suiteup.grsventures.ltd/resources/views/business-model/business-models.blade.php ENDPATH**/ ?>