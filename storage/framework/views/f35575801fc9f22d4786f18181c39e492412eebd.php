<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col">
            <h5 class="text-secondary"><?php echo e(__('Tasks /Gantt Chart')); ?></h5>
        </div>
        <div class="col text-end">
            <a href="/kanban" type="button" class="btn btn-info">

                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trello"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><rect x="7" y="7" width="3" height="9"></rect><rect x="14" y="7" width="3" height="5"></rect></svg>
                <?php echo e(__(' Kanban')); ?>

            </a>

            <a href="/admin/tasks/list" type="button" class="btn btn-secondary text-white">

                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-table"><path d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 1-2-2V9m0 0h18"></path></svg>
                <?php echo e(__(' Task Table ')); ?>

            </a>


        </div>
    </div>

    <div>
        <div class="card">
            <div class="card-body">
                <svg id="gantt">

                </svg>
            </div>

        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>


    <script>
        // jkanban init

        (function() {
            "use strict";
            var tasks = [
                    <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                {
                    id: "<?php echo e($task->id); ?>",
                    name: '<?php echo e($task->subject); ?>',
                    start: '<?php echo e($task->start_date); ?>',
                    end: '<?php echo e($task->due_date); ?>',


                    <?php if($task->status === 'done'): ?>
                    progress: 100,

                    <?php elseif($task->status === 'in_review'): ?>
                    progress: 60,
                    <?php elseif($task->status === 'in_progress'): ?>
                    progress: 40,
                    <?php elseif($task->status === 'todo'): ?>
                    progress: 0,
                    <?php endif; ?>


                    // dependencies: 'Task 2, Task 3'
                },

                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            ]

            var gantt = new Gantt('#gantt', tasks, {
                // on_click: function (task) {
                //     console.log(task);
                // },
                // on_date_change: function(task, start, end) {
                //     console.log(task, start, end);
                // },
                // on_progress_change: function(task, progress) {
                //     console.log(task, progress);
                // },
                // on_view_change: function(mode) {
                //     console.log(mode);
                // }
            });
            // gantt.change_view_mode('Week');

        })();
    </script>
        <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.primary', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/freylphj/suiteup.grsventures.ltd/resources/views/tasks/gantt.blade.php ENDPATH**/ ?>