<?php $__env->startSection('content'); ?>
    <?php
        $taskStatuses = config('task.statuses');
    ?>
    <div class="row">
        <div class="col">
            <h5 class="text-secondary"><?php echo e(__('Tasks / kanban')); ?></h5>
        </div>
        <?php echo $__env->make('tasks.tabs.tabs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>

    <div class="">
        <div class="d-flex m-3">
            <div class="ms-auto d-flex">

                <div class="ps-4">

                </div>
            </div>
        </div>
        <div class="mt-3 kanban-container">
            <div class="py-2 min-vh-100 d-inline-flex" style="overflow-x: auto">
                <div id="myKanban"></div>
            </div>
        </div>
        <div class="modal fade" id="new-board-modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="h5 modal-title">Choose your new Board Name</h5>
                        <button type="button" class="btn close pe-1" data-dismiss="modal" data-target="#new-board-modal"
                                aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="pt-4 modal-body">
                        <div class="mb-4 input-group">
<span class="input-group-text">
<i class="far fa-edit"></i>
</span>
                            <input class="form-control" placeholder="Board Name" type="text"
                                   id="jkanban-new-board-name"/>
                        </div>
                        <div class="text-end">
                            <button class="m-1 btn btn-primary" id="jkanban-add-new-board" data-toggle="modal"
                                    data-target="#new-board-modal">
                                Save changes
                            </button>
                            <button class="m-1 btn btn-secondary" data-dismiss="modal" data-target="#new-board-modal">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hidden opacity-50 fixed inset-0 z-40 bg-black" id="new-board-modal-backdrop"></div>
        <div class="modal fade" id="jkanban-info-modal" style="display: none" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="h5 modal-title">Task details</h5>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="pt-4 modal-body">
                        <input id="jkanban-task-id" class="d-none"/>
                        <div class="mb-4 input-group">
<span class="input-group-text">
<i class="far fa-edit"></i>
</span>
                            <input class="form-control" placeholder="Task Title" type="text" id="jkanban-task-title"/>
                        </div>
                        <div class="mb-4 input-group">
<span class="input-group-text">
<i class="fas fa-user"></i>
</span>
                            <input class="form-control" placeholder="Task Assignee" type="text"
                                   id="jkanban-task-assignee"/>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" placeholder="Task Description" id="jkanban-task-description"
                                      rows="4"></textarea>
                        </div>
                        <div class="alert alert-success d-none">Changes saved!</div>
                        <div class="text-end">
                            <button class="m-1 btn btn-primary" id="jkanban-update-task" data-toggle="modal"
                                    data-target="#jkanban-info-modal">
                                Save changes
                            </button>
                            <button class="m-1 btn btn-secondary" data-dismiss="modal"
                                    data-target="#jkanban-info-modal">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hidden opacity-50 fixed inset-0 z-40 bg-black" id="jkanban-info-modal-backdrop"></div>

    </div>


    <?php echo $__env->make('tasks.add-new', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('tasks.add-status-model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('tasks.add-group', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('script'); ?>





























































































































































































































<script>
    (function () {
        if (!document.getElementById("myKanban")) return;

        const kanbanStatusesObj = <?php echo json_encode(config('task.statuses'), 15, 512) ?>; // object from PHP
        const kanbanStatuses = Object.keys(kanbanStatusesObj);
        const tasksData = <?php echo json_encode($tasks, 15, 512) ?>;
        const usersData = <?php echo json_encode($users, 15, 512) ?>;

        var KanbanTest = new jKanban({
            element: "#myKanban",
            gutter: "1px",
            widthBoard: "350px",

            click: el => {
                let myModal = new bootstrap.Modal(document.getElementById('kt_modal_1'), { keyboard: false });
                let task_id = el.getAttribute("data-eid");

                $.getJSON('<?php echo e(route('admin.tasks', ['action' => 'task.json'])); ?>?id=' + task_id, function (data) {
                    $('#input_name').val(data.subject);
                    $('#start_date').val(data.start_date);
                    flatpickr("#start_date", { enableTime: true, dateFormat: "Y-m-d H:i" });

                    $('#due_date').val(data.due_date);
                    flatpickr("#due_date", { enableTime: true, dateFormat: "Y-m-d H:i" });

                    $('#contact_id').val(data.contact_id);
                    $('#description').val(data.description);
                    $('#task_id').val(data.id);
                });

                myModal.show();
            },

            buttonClick: function (el, boardId) {
                if (document.querySelector("[data-id='" + boardId + "'] .itemform") === null) {
                    var formItem = document.createElement("form");
                    formItem.setAttribute("class", "itemform");
                    formItem.innerHTML = `
                    <div class="form-group">
                        <textarea class="form-control" rows="2" autofocus></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn bg-gradient-success btn-sm pull-end">Add</button>
                        <button type="button" id="kanban-cancel-item" class="btn bg-gradient-light btn-sm pull-end me-2">Cancel</button>
                    </div>`;
                    KanbanTest.addForm(boardId, formItem);

                    formItem.addEventListener("submit", function (e) {
                        e.preventDefault();
                        var text = e.target[0].value;
                        let newTaskId = "_" + text.toLowerCase().replace(/ /g, "_") + boardId;
                        KanbanTest.addElement(boardId, { id: newTaskId, title: text, class: ["border-radius-md"] });
                        formItem.parentNode.removeChild(formItem);
                    });

                    document.getElementById("kanban-cancel-item").onclick = function () {
                        formItem.parentNode.removeChild(formItem);
                    };
                }
            },

            addItemButton: true,

            boards: kanbanStatuses.map(status => ({
                id: status,
                title: `<span class="text-dark">${status.replace('_',' ')}</span>`,
                item: tasksData[status] ? tasksData[status].map(task => {
                    let user = usersData[task.contact_id] ?? null;
                    let userHtml = '';
                    if (user) {
                        if (user.photo) {
                            userHtml = `<div class="avatar avatart-sm rounded-circle"><img src="<?php echo e(PUBLIC_DIR); ?>/uploads/${user.photo}"></div>`;
                        } else {
                            userHtml = `<div class="avatar avatar-sm rounded-circle bg-indigo"><p class="mt-3 text-white text-uppercase">${user.first_name[0]}${user.last_name[0]}</p></div>`;
                        }
                        userHtml += `<div class="text-sm fw-bold mt-2 ms-2">${user.first_name} ${user.last_name}</div>`;
                    }

                    return {
                        id: task.id,
                        title: `<small>Due Date: </small><span class="badge badge-sm bg-pink-light text-danger fw-bolder mb-1">${task.due_date ? task.due_date : ''}</span>
                            <h6 class="text fw-bolder mt-2">${task.subject}</h6>
                            <p class="text mt-2">${task.description}</p>
                            <div class="d-flex">${userHtml}</div>`,
                        class: ["border-radius-md"]
                    };
                }) : []
            })),

            dropEl: function (el, target, source, sibling) {
                let id = el.getAttribute("data-eid");
                let closest_board_id = $(target).closest(".kanban-board").attr("data-id");

                $.post("/todo/set-status", {
                    _token: "<?php echo e(csrf_token()); ?>",
                    id: id,
                    status: closest_board_id
                }, function (data) {
                    console.log(data);
                });
            }
        });

        // Add new board modal
        document.getElementById("jkanban-add-new-board").addEventListener("click", function () {
            let newBoardName = document.getElementById("jkanban-new-board-name").value;
            let newBoardId = "_" + newBoardName.toLowerCase().replace(/ /g, "_");
            KanbanTest.addBoards([{ id: newBoardId, title: newBoardName, item: [] }]);

            document.querySelector('#new-board-modal').classList.remove('show');
            document.querySelector('body').classList.remove('modal-open');
            document.querySelector('.modal-backdrop').remove();
        });

    })();
</script>

    <script>
        $(function () {
            "use strict";


            flatpickr("#start_date", {

                enableTime: true,
                dateFormat: "Y-m-d H:i",
            });

            flatpickr("#due_date", {

                enableTime: true,
                dateFormat: "Y-m-d H:i",
            });
            $(document).ready(function () {
                $('#cloudonex_table').DataTable(
                );

            });


            let $btn_submit = $('#btn_submit');
            let $form_main = $('#form_main');
            let $sp_result_div = $('#sp_result_div');

            $form_main.on('submit', function (event) {
                event.preventDefault();
                $btn_submit.prop('disabled', true);
                $.post('<?php echo e(route('admin.tasks.save',['action' => 'task'])); ?>', $form_main.serialize()).done(function () {
                    location.reload();
                }).fail(function (data) {
                    let obj = $.parseJSON(data.responseText);
                    $btn_submit.prop('disabled', false);
                    let html = '';
                    $.each(obj.errors, function (key, value) {
                        html += '<div class="alert bg-pink-light text-danger">' + value + '</div>'
                    });

                    $sp_result_div.html(html);

                });

            });

            let myModal = new bootstrap.Modal(document.getElementById('kt_modal_1'), {
                keyboard: false
            });


            $('.category_edit').on('click', function (event) {
                event.preventDefault();
                $.getJSON('<?php echo e(route('admin.tasks',['action' => 'task.json'])); ?>?id=' + $(this).data('id'), function (data) {
                    $('#input_name').val(data.subject);

                    $('#start_date').val(data.start_date);

                    flatpickr("#start_date", {

                        enableTime: true,
                        dateFormat: "Y-m-d H:i",
                    });

                    $('#due_date').val(data.due_date);

                    flatpickr("#due_date", {

                        enableTime: true,
                        dateFormat: "Y-m-d H:i",
                    });

                    $('#contact_id').val(data.contact_id);
                    $('#description').val(data.description);
                    $('#task_id').val(data.id);
                });

                myModal.show();

            });

            $('#btn_add_new_category').on('click', function () {
                $('#input_name').val('');
                $('#task_id').val('');
                $('#start_date').val('');
                $('#due_date').val('');
                $('#contact_id').val('');
                $('#description').val('');

                myModal.show();
            });


            $('.change_task_status').on('click', function () {
                $.post('<?php echo e(route('admin.tasks.save', ['action' => 'change-status'])); ?>', {
                    id: $(this).data('id'),
                    status: $(this).data('status'),
                    _token: '<?php echo e(csrf_token()); ?>',
                }).done(function () {
                    location.reload();
                });
            });


        });
    </script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.primary', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/freylphj/suiteup.grsventures.ltd/resources/views/tasks/kanban.blade.php ENDPATH**/ ?>