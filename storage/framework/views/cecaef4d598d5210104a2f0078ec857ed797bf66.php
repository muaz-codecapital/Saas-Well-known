<div class="col text-end">

    <a href="/admin/tasks/list" type="button" class="btn btn-danger text-white">

        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             class="feather feather-table">
            <path d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 1-2-2V9m0 0h18"></path>
        </svg>
        <?php echo e(__(' Task Table ')); ?>

    </a>

    <a href="/kanban" type="button" class="btn btn-info">

        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trello"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><rect x="7" y="7" width="3" height="9"></rect><rect x="14" y="7" width="3" height="5"></rect></svg>
        <?php echo e(__(' Kanban')); ?>

    </a>
    <a href="/gantt" type="button" class="btn btn-secondary text-white">

        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             class="feather feather-clock">
            <circle cx="12" cy="12" r="10"></circle>
            <polyline points="12 6 12 12 16 14"></polyline>
        </svg>
        <?php echo e(__(' Gantt Chart ')); ?>

    </a>


    <div class="btn-group">
        <button type="button" class="btn bg-dark-alt text-white dropdown-toggle" data-bs-toggle="dropdown"
                aria-expanded="false">
            <i class="fa fa-plus"></i> <?php echo e(__(' Add Actions')); ?>

        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li>
                <a class="dropdown-item" href="#" id="btn_add_new_category">
                    <i class="fa fa-plus me-2 text-dark"></i><?php echo e(__(' Add Task ')); ?>

                </a>
            </li>
            <li>
                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addStatusModal">
                    <i class="fa fa-plus me-2 text-success"></i><?php echo e(__(' Add Status ')); ?>

                </a>
            </li>
            <li>
                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addGroupModal">
                    <i class="fa fa-plus me-2 text-warning"></i><?php echo e(__(' Add WorkSpace ')); ?>

                </a>
            </li>
        </ul>
    </div>
</div><?php /**PATH /home/freylphj/suiteup.grsventures.ltd/resources/views/tasks/tabs/tabs.blade.php ENDPATH**/ ?>