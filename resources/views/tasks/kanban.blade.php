@extends('layouts.primary')

@section('content')
    @php
        $taskStatuses = config('task.statuses');
    @endphp
    <div class="row">
        <div class="col">
            <h5 class="text-secondary">{{__('Tasks / kanban')}}</h5>
        </div>
        @include('tasks.tabs.tabs')

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


    @include('tasks.add-new')
    @include('tasks.add-status-model')
    @include('tasks.add-group')
@endsection



@section('script')

{{--    <script>--}}
{{--        const kanbanStatuses = @json(config('task.statuses'));--}}
{{--        // jkanban init--}}

{{--        (function () {--}}
{{--            if (document.getElementById("myKanban")) {--}}
{{--                var KanbanTest = new jKanban({--}}
{{--                    element: "#myKanban",--}}
{{--                    gutter: "1px",--}}
{{--                    widthBoard: "350px",--}}

{{--                    click: el => {--}}


{{--                        let myModal = new bootstrap.Modal(document.getElementById('kt_modal_1'), {--}}
{{--                            keyboard: false--}}
{{--                        });--}}

{{--                        let task_id = el.getAttribute("data-eid");--}}

{{--                        $.getJSON('{{route('admin.tasks',['action' => 'task.json'])}}?id=' + task_id, function (data) {--}}
{{--                            $('#input_name').val(data.subject);--}}

{{--                            $('#start_date').val(data.start_date);--}}

{{--                            flatpickr("#start_date", {--}}

{{--                                enableTime: true,--}}
{{--                                dateFormat: "Y-m-d H:i",--}}
{{--                            });--}}

{{--                            $('#due_date').val(data.due_date);--}}

{{--                            flatpickr("#due_date", {--}}

{{--                                enableTime: true,--}}
{{--                                dateFormat: "Y-m-d H:i",--}}
{{--                            });--}}

{{--                            $('#contact_id').val(data.contact_id);--}}
{{--                            $('#description').val(data.description);--}}
{{--                            $('#task_id').val(data.id);--}}
{{--                        });--}}

{{--                        myModal.show();--}}

{{--                    },--}}
{{--                    buttonClick: function (el, boardId) {--}}
{{--                        if (--}}
{{--                            document.querySelector("[data-id='" + boardId + "'] .itemform") ===--}}
{{--                            null--}}
{{--                        ) {--}}
{{--                            // create a form to enter element--}}
{{--                            var formItem = document.createElement("form");--}}
{{--                            formItem.setAttribute("class", "itemform");--}}
{{--                            formItem.innerHTML = `<div class="form-group">--}}
{{--          <textarea class="form-control" rows="2" autofocus></textarea>--}}
{{--          </div>--}}
{{--          <div class="form-group">--}}
{{--              <button type="submit" class="btn bg-gradient-success btn-sm pull-end">Add</button>--}}
{{--              <button type="button" id="kanban-cancel-item" class="btn bg-gradient-light btn-sm pull-end me-2">Cancel</button>--}}
{{--          </div>`;--}}

{{--                            KanbanTest.addForm(boardId, formItem);--}}
{{--                            formItem.addEventListener("submit", function (e) {--}}
{{--                                e.preventDefault();--}}
{{--                                var text = e.target[0].value;--}}
{{--                                let newTaskId =--}}
{{--                                    "_" + text.toLowerCase().replace(/ /g, "_") + boardId;--}}
{{--                                KanbanTest.addElement(boardId, {--}}
{{--                                    id: newTaskId,--}}
{{--                                    title: text,--}}
{{--                                    class: ["border-radius-md"]--}}
{{--                                });--}}
{{--                                formItem.parentNode.removeChild(formItem);--}}
{{--                            });--}}
{{--                            document.getElementById("kanban-cancel-item").onclick = function () {--}}
{{--                                formItem.parentNode.removeChild(formItem);--}}
{{--                            };--}}
{{--                        }--}}
{{--                    },--}}
{{--                    addItemButton: true,--}}
{{--                    boards: [{--}}
{{--                        id: "todo",--}}
{{--                        title: '<span class="text-dark">{{__('Todo')}}</span>',--}}
{{--                        item: [--}}
{{--                                @if(!empty($tasks['todo']))--}}
{{--                                @foreach($tasks['todo'] as $task)--}}

{{--                            {--}}
{{--                                id: "{{$task->id}}",--}}
{{--                                title: '<small>Due Date: </small><span class="badge badge-sm bg-pink-light text-danger fw-bolder mb-1">@if(!empty($task->due_date)){{(\App\Supports\DateSupport::parse($task->due_date))->format(config('app.date_format'))}}@endif</span><h6 class="text fw-bolder mt-2">{{$task->subject}}</h6><p class="text mt-2">{{$task->description}}</p><div class="d-flex"><div class="avatar avatart-sm rounded-circle">@if(isset($users[$task->contact_id]))@if(!empty($users[$task->contact_id]->photo))<a href="javascript:" class="avatar avatar-sm rounded-circle"><img src="{{PUBLIC_DIR}}/uploads/{{$users[$task->contact_id]->photo}}"></a>@else<div class="avatar  avatar-sm rounded-circle bg-indigo"><p class=" mt-3 text-white text-uppercase">{{$users[$task->contact_id]->first_name[0]}}{{$users[$task->contact_id]->last_name[0]}}</p> </div> @endif</div><div class="text-sm fw-bold mt-2 ms-2">{{$users[$task->contact_id]->first_name}} {{$users[$task->contact_id]->last_name}} </div>@endif</div></div>',--}}
{{--                                class: ["border-radius-md"]--}}
{{--                            },--}}

{{--                            @endforeach--}}
{{--                            @endif--}}


{{--                        ]--}}
{{--                    },--}}
{{--                        {--}}
{{--                            id: "in_progress",--}}
{{--                            title: '<span class="text-dark">{{__('In progress')}}</span>',--}}
{{--                            item: [--}}
{{--                                    @if(!empty($tasks['in_progress']))--}}
{{--                                    @foreach($tasks['in_progress'] as $task)--}}
{{--                                {--}}
{{--                                    id: "{{$task->id}}",--}}
{{--                                    title: '<small>Due Date: </small><span class="badge badge-sm bg-pink-light text-danger fw-bolder mb-1">@if(!empty($task->due_date)){{(\App\Supports\DateSupport::parse($task->due_date))->format(config('app.date_format'))}}@endif</span><h6 class="text fw-bolder mt-2">{{$task->subject}}</h6><p class="text mt-2">{{$task->description}}</p><div class="d-flex"><div class="avatar avatart-sm rounded-circle">@if(isset($users[$task->contact_id]))@if(!empty($users[$task->contact_id]->photo))<a href="javascript:" class="avatar avatar-sm rounded-circle"><img src="{{PUBLIC_DIR}}/uploads/{{$users[$task->contact_id]->photo}}"></a>@else<div class="avatar  avatar-sm rounded-circle bg-indigo"><p class=" mt-3 text-white text-uppercase">{{$users[$task->contact_id]->first_name[0]}}{{$users[$task->contact_id]->last_name[0]}}</p> </div> @endif</div><div class="text-sm fw-bold mt-2 ms-2">{{$users[$task->contact_id]->first_name}} {{$users[$task->contact_id]->last_name}} </div>@endif</div></div>',--}}
{{--                                    class: ["border-radius-md"]--}}
{{--                                },--}}
{{--                                @endforeach--}}
{{--                                @endif--}}

{{--                            ]--}}
{{--                        },--}}
{{--                        {--}}
{{--                            id: "in_review",--}}
{{--                            title: '<span class="text-dark">{{__('In review')}}</span>',--}}
{{--                            item: [--}}
{{--                                    @if(!empty($tasks['in_review']))--}}
{{--                                    @foreach($tasks['in_review'] as $task)--}}
{{--                                {--}}
{{--                                    id: "{{$task->id}}",--}}
{{--                                    title: '<small>Due Date: </small><span class="badge badge-sm bg-pink-light text-danger fw-bolder mb-1">@if(!empty($task->due_date)){{(\App\Supports\DateSupport::parse($task->due_date))->format(config('app.date_format'))}}@endif</span><h6 class="text fw-bolder mt-2">{{$task->subject}}</h6><p class="text mt-2">{{$task->description}}</p><div class="d-flex"><div class="avatar avatart-sm rounded-circle">@if(isset($users[$task->contact_id]))@if(!empty($users[$task->contact_id]->photo))<a href="javascript:" class="avatar avatar-sm rounded-circle"><img src="{{PUBLIC_DIR}}/uploads/{{$users[$task->contact_id]->photo}}"></a>@else<div class="avatar  avatar-sm rounded-circle bg-indigo"><p class=" mt-3 text-white text-uppercase">{{$users[$task->contact_id]->first_name[0]}}{{$users[$task->contact_id]->last_name[0]}}</p> </div> @endif</div><div class="text-sm fw-bold mt-2 ms-2">{{$users[$task->contact_id]->first_name}} {{$users[$task->contact_id]->last_name}} </div>@endif</div></div>',--}}
{{--                                    class: ["border-radius-md"]--}}
{{--                                },--}}
{{--                                @endforeach--}}
{{--                                @endif--}}

{{--                            ]--}}
{{--                        },--}}
{{--                        {--}}
{{--                            id: "done",--}}
{{--                            title: '<span class="text-dark">{{__('Done')}}</span>',--}}
{{--                            item: [--}}
{{--                                    @if(!empty($tasks['done']))--}}
{{--                                    @foreach($tasks['done'] as $task)--}}
{{--                                {--}}
{{--                                    id: "{{$task->id}}",--}}
{{--                                    title: '<small>Due Date: </small><span class="badge badge-sm bg-pink-light text-danger fw-bolder mb-1">@if(!empty($task->due_date)){{(\App\Supports\DateSupport::parse($task->due_date))->format(config('app.date_format'))}}@endif</span><h6 class="text fw-bolder mt-2">{{$task->subject}}</h6><p class="text mt-2">{{$task->description}}</p><div class="d-flex"><div class="avatar avatart-sm rounded-circle">@if(isset($users[$task->contact_id]))@if(!empty($users[$task->contact_id]->photo))<a href="javascript:" class="avatar avatar-sm rounded-circle"><img src="{{PUBLIC_DIR}}/uploads/{{$users[$task->contact_id]->photo}}"></a>@else<div class="avatar  avatar-sm rounded-circle bg-indigo"><p class=" mt-3 text-white text-uppercase">{{$users[$task->contact_id]->first_name[0]}}{{$users[$task->contact_id]->last_name[0]}}</p> </div> @endif</div><div class="text-sm fw-bold mt-2 ms-2">{{$users[$task->contact_id]->first_name}} {{$users[$task->contact_id]->last_name}} </div>@endif</div></div>',--}}
{{--                                    class: ["border-radius-md"]--}}
{{--                                },--}}
{{--                                @endforeach--}}
{{--                                @endif--}}

{{--                            ]--}}
{{--                        }--}}
{{--                    ],--}}

{{--                    dropEl: function (el, target, source, sibling) {--}}
{{--                        let id = el.getAttribute("data-eid");--}}

{{--                        let $target = $(target);--}}
{{--                        let closest_board_id = $target.closest(".kanban-board").attr("data-id");--}}

{{--                        $.post("/todo/set-status", {--}}
{{--                            _token: "{{csrf_token()}}",--}}
{{--                            id: id,--}}
{{--                            status: closest_board_id--}}
{{--                        }, function (data) {--}}
{{--                            console.log(data);--}}
{{--                        });--}}


{{--                    }--}}
{{--                });--}}

{{--                var addBoardDefault = document.getElementById("jkanban-add-new-board");--}}
{{--                addBoardDefault.addEventListener("click", function () {--}}

{{--                    let newBoardName = document.getElementById("jkanban-new-board-name")--}}
{{--                        .value;--}}
{{--                    let newBoardId = "_" + newBoardName.toLowerCase().replace(/ /g, "_");--}}
{{--                    KanbanTest.addBoards([{--}}
{{--                        id: newBoardId,--}}
{{--                        title: newBoardName,--}}
{{--                        item: []--}}
{{--                    }]);--}}
{{--                    document.querySelector('#new-board-modal').classList.remove('show');--}}
{{--                    document.querySelector('body').classList.remove('modal-open');--}}

{{--                    document.querySelector('.modal-backdrop').remove();--}}
{{--                });--}}

{{--                var updateTask = document.getElementById("jkanban-update-task");--}}
{{--                updateTask.addEventListener("click", function () {--}}
{{--                    let jkanbanInfoModalTaskId = document.querySelector(--}}
{{--                        "#jkanban-info-modal #jkanban-task-id"--}}
{{--                    );--}}
{{--                    let jkanbanInfoModalTaskTitle = document.querySelector(--}}
{{--                        "#jkanban-info-modal #jkanban-task-title"--}}
{{--                    );--}}
{{--                    let jkanbanInfoModalTaskAssignee = document.querySelector(--}}
{{--                        "#jkanban-info-modal #jkanban-task-assignee"--}}
{{--                    );--}}
{{--                    let jkanbanInfoModalTaskDescription = document.querySelector(--}}
{{--                        "#jkanban-info-modal #jkanban-task-description"--}}
{{--                    );--}}
{{--                    KanbanTest.replaceElement(jkanbanInfoModalTaskId.value, {--}}
{{--                        title: jkanbanInfoModalTaskTitle.value,--}}
{{--                        assignee: jkanbanInfoModalTaskAssignee.value,--}}
{{--                        description: jkanbanInfoModalTaskDescription.value--}}
{{--                    });--}}
{{--                    jkanbanInfoModalTaskId.value = jkanbanInfoModalTaskId.value;--}}
{{--                    jkanbanInfoModalTaskTitle.value = jkanbanInfoModalTaskTitle.value;--}}
{{--                    jkanbanInfoModalTaskAssignee.value = jkanbanInfoModalTaskAssignee.value;--}}
{{--                    jkanbanInfoModalTaskDescription.value = jkanbanInfoModalTaskDescription.value;--}}
{{--                    document.querySelector('#jkanban-info-modal').classList.remove('show');--}}
{{--                    document.querySelector('body').classList.remove('modal-open');--}}
{{--                    document.querySelector('.modal-backdrop').remove();--}}


{{--                });--}}
{{--            }--}}
{{--        })();--}}
{{--    </script>--}}


<script>
    (function () {
        if (!document.getElementById("myKanban")) return;

        const kanbanStatusesObj = @json(config('task.statuses')); // object from PHP
        const kanbanStatuses = Object.keys(kanbanStatusesObj);
        const tasksData = @json($tasks);
        const usersData = @json($users);

        var KanbanTest = new jKanban({
            element: "#myKanban",
            gutter: "1px",
            widthBoard: "350px",

            click: el => {
                let myModal = new bootstrap.Modal(document.getElementById('kt_modal_1'), { keyboard: false });
                let task_id = el.getAttribute("data-eid");

                $.getJSON('{{ route('admin.tasks', ['action' => 'task.json']) }}?id=' + task_id, function (data) {
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
                            userHtml = `<div class="avatar avatart-sm rounded-circle"><img src="{{PUBLIC_DIR}}/uploads/${user.photo}"></div>`;
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
                    _token: "{{ csrf_token() }}",
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
                $.post('{{route('admin.tasks.save',['action' => 'task'])}}', $form_main.serialize()).done(function () {
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
                $.getJSON('{{route('admin.tasks',['action' => 'task.json'])}}?id=' + $(this).data('id'), function (data) {
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
                $.post('{{route('admin.tasks.save', ['action' => 'change-status'])}}', {
                    id: $(this).data('id'),
                    status: $(this).data('status'),
                    _token: '{{csrf_token()}}',
                }).done(function () {
                    location.reload();
                });
            });


        });
    </script>
@endsection


