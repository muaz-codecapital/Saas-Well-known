<?php $__env->startSection('content'); ?>
    <div class="card bg-purple-light mb-3 mt-4">
        <div class="card-header bg-purple-light pb-0 p-3">
            <div class="row">
                <div class="col-md-8 ">
                    <h6 ><?php echo e(__('Investors')); ?> </h6>

                </div>
                <div class="col-md-4 text-right">

                    <a class="btn bg-gradient-dark" href="/add-investor"><i class="fas fa-plus"></i>&nbsp;&nbsp;
                        <?php echo e(__(' Add New Investor')); ?>

                    </a>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card card-body mb-4">
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0" id="cloudonex_table">
                            <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7"><?php echo e(__('Name')); ?></th>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2"><?php echo e(__('Email')); ?></th>
                                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7"><?php echo e(__('Phone')); ?></th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                            <tbody>
                            <?php $__currentLoopData = $investors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $investor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <div
                                                    class="avatar avatar-md bg-purple-light  border-radius-md p-2 ">
                                                    <h6 class="text-success text-purple"><?php echo e($investor->first_name['0']); ?><?php echo e($investor->last_name['0']); ?></h6>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center px-3">
                                                <h6 class="mb-0"><?php echo e($investor->first_name); ?> <?php echo e($investor->last_name); ?></h6>
                                                <p class="text-sm text-secondary mb-0"><?php echo e($investor->email); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class=" font-weight-bold mb-0"><?php echo e($investor->email); ?></p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span
                                            class="text-secondary font-weight-bold"><?php echo e($investor->phone_number); ?></span>
                                    </td>
                                    <td class="align-middle text-right">
                                        <div class="ms-auto">
                                            <a class="btn btn-link text-success text-gradient px-3 mb-0"
                                               href="/view-investor?id=<?php echo e($investor->id); ?>"><i
                                                    class="far fa-file-alt me-2"></i><?php echo e(__('View')); ?></a>
                                            <a class="btn btn-link text-dark px-3 mb-0"
                                               href="/add-investor?id=<?php echo e($investor->id); ?>"><i
                                                    class="fas fa-pencil-alt text-dark me-2"
                                                    aria-hidden="true"></i><?php echo e(__('Edit')); ?></a>

                                            <a class="btn btn-link text-danger text-gradient px-3 mb-0"
                                               href="/delete/investor/<?php echo e($investor->id); ?>"><i
                                                    class="far fa-trash-alt me-2"></i><?php echo e(__('Delete')); ?></a>



                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script>
        "use strict";
        $(document).ready(function () {
            $('#cloudonex_table').DataTable(
            );

        });
    </script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.primary', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/freylphj/suiteup.grsventures.ltd/resources/views/investors/list.blade.php ENDPATH**/ ?>