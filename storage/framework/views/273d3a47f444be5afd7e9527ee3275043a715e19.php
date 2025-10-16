<?php $__env->startSection('content'); ?>

    <div class=" row">
        <div class="col">
            <h5 class=" text-secondary fw-bolder">
                <?php echo e(__('Product Ideas')); ?>

            </h5>
        </div>
        <div class="col text-end">
            <a href="/create-project" type="button" class="btn btn-info text-white"><?php echo e(__('Plan Product ')); ?></a>
        </div>
    </div>
    <div class="card ">
        <div class=" card-body table-responsive">
            <table class="table align-items-center mb-0" id="cloudonex_table">
                <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"><?php echo e(__('Product Name')); ?></th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"><?php echo e(__('Members')); ?></th>

                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"><?php echo e(__('Due Date')); ?></th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"><?php echo e(__('Status')); ?></th>

                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"><?php echo e(__('Action')); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <div class="d-flex px-2">
                                <div class="avatar avatar-md me-3 bg-purple-light  border-radius-md p-2">
                                    <h5 class="mt-2 text-purple"><?php echo e($project->title['0']); ?></h5>
                                </div>

                                <div class="my-auto">
                                    <h6 class="text-sm mb-0 ms-1"><?php echo e($project->title); ?></h6>
                                </div>
                            </div>
                        </td>
                        <td class="">

                            <div class="avatar-group d-flex mt-2">
                                <?php if($project->members): ?>
                                    <?php $__currentLoopData = json_decode($project->members); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(isset($users[$member])): ?>

                                            <?php if(!empty($users[$member]->photo)): ?>
                                                <a href="javascript:" class="avatar avatar-sm rounded-circle"
                                                   data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                   title="<?php echo e($users[$member]->first_name); ?>">
                                                    <img src="<?php echo e(PUBLIC_DIR); ?>/uploads/<?php echo e($users[$member]->photo); ?>"
                                                         alt="team1">
                                                </a>

                                            <?php else: ?>
                                                <div class="avatar avatar-sm  rounded-circle bg-success-light">
                                                    <p class="mt-3 text-success text-uppercase"><span><?php echo e($users[$member]->first_name[0]); ?><?php echo e($users[$member]->last_name[0]); ?></span>
                                                    </p>
                                                </div>

                                            <?php endif; ?>

                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                <?php endif; ?>


                            </div>
                        </td>

                        <td>
                            <p class="text-xs font-weight-bold mb-0">

                                <?php if(!empty($project->end_date)): ?>
                                    <?php echo e((\App\Supports\DateSupport::parse($project->end_date))->format(config('app.date_format'))); ?>


                                <?php endif; ?>
                            </p>
                        </td>

                        <td>
                            <span class="badge badge-dot me-4">
                            <i class="bg-info"></i>
                            <span class="badge bg-purple-light font-weight-bold"><?php echo e($project->status); ?></span>
                            </span>
                        </td>
                        <td>
                            <div>
                                <div class="dropstart">
                                    <a href="javascript:" class="text-secondary" id="dropdownMarketingCard"
                                       data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-lg-start px-2 py-3"
                                        aria-labelledby="dropdownMarketingCard">
                                        <li><a class="dropdown-item border-radius-md"
                                               href="/create-project?id=<?php echo e($project->id); ?>"><?php echo e(__('Edit')); ?></a></li>

                                        <li><a class="dropdown-item border-radius-md"
                                               href="/view-project?id=<?php echo e($project->id); ?>"><?php echo e(__('See Details')); ?></a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a class="dropdown-item border-radius-md text-danger"
                                               href="/delete/project/<?php echo e($project->id); ?>"><?php echo e(__('Delete')); ?>

                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
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

<?php echo $__env->make('layouts.primary', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/freylphj/suiteup.grsventures.ltd/resources/views/projects/projects.blade.php ENDPATH**/ ?>