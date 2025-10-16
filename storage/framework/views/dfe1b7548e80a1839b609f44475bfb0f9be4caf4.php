<div class="card-body mt-4 table-responsive  pt-0">
    <!--begin::Table-->
    <table class="table align-items-center mb-0" id="cloudonex_table">
        <!--begin::Table head-->
        <thead>
        <!--begin::Table row-->
        <tr>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"><?php echo e(__('Subject/Task')); ?></th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"><?php echo e(__('Assigned To')); ?></th>

            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"><?php echo e(__('Start Date')); ?></th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"><?php echo e(__('Due Date')); ?></th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"><?php echo e(__('Status')); ?>

            </th>
            <?php if(is_null($group)): ?>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"><?php echo e(__('Workspace Name')); ?>

            </th>
            <?php endif; ?>
            <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end "><?php echo e(__('Actions')); ?></th>
        </tr>
        </thead>

        <tbody>
        <!--begin::Table row-->

        <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <tr>
                <td class="">
                    <h6 class="text-sm font-weight-bold mb-0"><?php echo e($task->subject); ?> </h6>
                </td>


                <td class=" text-sm fw-bolder mb-0">

                    <div class="d-flex">
                        <div class="avatar avatart-sm rounded-circle">
                            <?php if(isset($users[$task->contact_id])): ?>
                                <?php if(!empty($users[$task->contact_id]->photo)): ?>
                                    <a href="javascript:" class="avatar avatar-sm rounded-circle"
                                       data-bs-toggle="tooltip" data-bs-placement="bottom"  title="<?php echo e($users[$task->contact_id]->first_name); ?>">
                                        <img src="<?php echo e(PUBLIC_DIR); ?>/uploads/<?php echo e($users[$task->contact_id]->photo); ?>">
                                    </a>

                                <?php else: ?>
                                    <div class="avatar  avatar-sm rounded-circle bg-indigo"><p class=" mt-3 text-white text-uppercase"><?php echo e($users[$task->contact_id]->first_name[0]); ?><?php echo e($users[$task->contact_id]->last_name[0]); ?></p>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <div class="text-sm fw-bold mt-2 ms-1 ">
                            <?php if(isset($users[$task->contact_id])): ?>
                                <?php echo e($users[$task->contact_id]->first_name); ?> <?php echo e($users[$task->contact_id]->last_name); ?>


                            <?php endif; ?>
                        </div>
                    </div>



                </td>


                <td>
                    <p class="text-xs font-weight-bold text-dark mb-0">
                        <?php if(!empty($task->start_date)): ?>
                            <?php echo e((\App\Supports\DateSupport::parse($task->start_date))->format(config('app.date_time_format'))); ?>


                        <?php endif; ?>
                    </p>
                </td>
                <td>
                    <p class="text-xs font-weight-bold text-dark mb-0">
                        <?php if(!empty($task->due_date)): ?>
                            <?php echo e($task->due_date->format(config('app.date_time_format'))); ?>

                        <?php endif; ?>
                    </p>

                </td>
                <?php
                    $taskStatuses = config('task.statuses'); // fetch statuses from config
                    $currentStatus = $task->status ?? 'todo';
                ?>
                <td class="position-relative">
                    <div class="dropdown mt-2">
                        <button class="text-xs btn btn-sm <?php echo e($taskStatuses[$currentStatus]['class']); ?> dropdown-toggle"
                                type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo e(__($taskStatuses[$currentStatus]['label'])); ?>

                        </button>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton"  style="z-index: 1050;">
                            <?php $__currentLoopData = $taskStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statusKey => $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <a class="dropdown-item change_task_status"
                                       data-id="<?php echo e($task->id); ?>"
                                       data-status="<?php echo e($statusKey); ?>" href="#">
                                        <?php echo e(__('Mark as')); ?> <?php echo e(__($status['label'])); ?>

                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </td>
                <?php if(is_null($group)): ?>
                <td>
                    <?php if($task->group && !is_null($task->group)): ?>
                    <span class="btn btn-sm btn-primary">
                        <?php echo e(Str::title($task->group)); ?>

                    </span>
                    <?php endif; ?>
                </td>
                <?php endif; ?>
                <!--begin::Joined-->
                <!--begin::Action=-->
                <td class="text-end">

                    <!--begin::Menu-->
                    <div class="menu-item px-3">
                        <a href="#" class="btn btn-link text-dark px-3 mb-0 category_edit"
                           data-id="<?php echo e($task->id); ?>"><?php echo e(__('Edit')); ?></a>
                        <a href="/delete/task/<?php echo e($task->id); ?>" class="btn btn-link text-danger px-3 mb-0"
                           data-kt-users-table-filter="delete_row"><?php echo e(__('Delete')); ?></a>
                    </div>
                    <!--end::Menu-->
                </td>
                <!--end::Action=-->
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </tbody>
        <!--end::Table body-->
    </table>
    <!--end::Table-->

    <?php echo $__env->make('tasks.add-new', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('tasks.add-status-model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('tasks.add-group', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>


<?php /**PATH C:\laragon\www\well-known\resources\views/tasks/tabs/list_view.blade.php ENDPATH**/ ?>