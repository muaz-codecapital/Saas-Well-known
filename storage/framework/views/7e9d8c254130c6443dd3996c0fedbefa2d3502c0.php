
<?php $__env->startSection('content'); ?>
    <div class=" row mb-2">
        <div class="col">
            <h5 class=" text-secondary fw-bolder">
                <?php echo e(__('Workspaces')); ?>

            </h5>
        </div>
        <div class="col text-end">
            <a class="btn btn-info me-2" href="/create-workspace"><i class="fas fa-plus"></i>&nbsp;&nbsp;
                <?php echo e(__('Create Workspace')); ?>

            </a>
            <a class="btn btn-success" href="/create-workspace-user"><i class="fas fa-user-plus"></i>&nbsp;&nbsp;
                <?php echo e(__('Create Workspace & User')); ?>

            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card card-body mb-4">

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0" id="cloudonex_table">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        <?php echo e(__('Workspace Name')); ?></th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        <?php echo e(__('Created_at')); ?></th>
                                    <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        <?php echo e(__('Plan')); ?></th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        <?php echo e(__('Status')); ?></th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        <?php echo e(__('Account Status')); ?></th>

                                    <th class=" text-uppercase text-secondary text-xxs opacity-7"><?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $workspaces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workspace): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"><?php echo e($workspace->name); ?> </h6>
                                                    <p class="text-xs text-secondary mb-0"></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                <?php echo e(\App\Supports\DateSupport::parse($workspace->created_at)->format(config('app.date_time_format'))); ?>

                                            </p>

                                        </td>
                                        <td class="text-xs text-purple text-uppercase font-weight-bold mb-0">
                                            <?php if($workspace->id !== $user->workspace_id): ?>
                                                <?php if(isset($plans[$workspace->plan_id])): ?>
                                                    <?php echo e($plans[$workspace->plan_id]->name); ?>

                                                <?php endif; ?>
                                            <?php else: ?>
                                                <p class="text-xs font-weight-bold mb-0"><?php echo e(__('super admin')); ?></p>
                                            <?php endif; ?>

                                        </td>
                                        <td class="align-middle text-sm">
                                            <?php if($workspace->id !== $user->workspace_id): ?>
                                                <?php if($workspace->subscribed): ?>
                                                    <span
                                                        class="badge badge-sm bg-success-light text-success"><?php echo e(__('Subscribed')); ?></span>
                                                <?php else: ?>
                                                    <span
                                                        class="badge badge-sm bg-pink-light text-danger"><?php echo e(__('Not Subscribed')); ?></span>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                        </td>
                                        <td class="align-middle text-sm">
                                            <?php if($workspace->id !== $user->workspace_id): ?>
                                                <?php if($workspace->active): ?>
                                                    <span
                                                        class="badge badge-sm bg-gradient-success"><?php echo e(__('Active')); ?></span>
                                                <?php else: ?>
                                                    <span class="badge badge-sm bg-warning"><?php echo e(__('Suspended')); ?></span>
                                                <?php endif; ?>
                                            <?php endif; ?>


                                        </td>
                                        <td class="align-middle">
                                            <?php if($workspace->id !== $user->workspace_id): ?>
                                                <a class="btn btn-link text-dark px-3 mb-0"
                                                    href="/view-workspace?id=<?php echo e($workspace->id); ?>"><i
                                                        class="text-dark fas fa-eye me-2"></i><?php echo e(__('View')); ?>

                                                </a>
                                            <?php endif; ?>
                                            <?php if($workspace->id !== $user->workspace_id): ?>
                                                <a class="btn btn-link text-dark px-3 mb-0"
                                                    href="/edit-workspace?id=<?php echo e($workspace->id); ?>"><i
                                                        class=" text-dark fas fa-pencil-alt me-2"></i><?php echo e(__('Edit')); ?></a>
                                            <?php endif; ?>

                                            <?php if($workspace->id !== $user->workspace_id): ?>
                                                <a class="btn btn-link text-danger text-gradient px-3 mb-0"
                                                    href="/delete-workspace/<?php echo e($workspace->id); ?>"><i
                                                        class="far fa-trash-alt me-2"></i><?php echo e(__('Delete')); ?></a>
                                            <?php endif; ?>
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
        $(document).ready(function() {
            $('#cloudonex_table').DataTable();

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.super-admin-portal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/freylphj/suiteup.grsventures.ltd/resources/views/super-admin/workspaces.blade.php ENDPATH**/ ?>