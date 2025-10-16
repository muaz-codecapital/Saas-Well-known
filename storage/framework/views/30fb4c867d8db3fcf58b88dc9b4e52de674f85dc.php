<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col">
            <h5 class="text-secondary"><?php echo e(__('Tasks')); ?></h5>
        </div>
        <?php echo $__env->make('tasks.tabs.tabs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

    <div>
        <div class="card">
            <?php switch($view_type):

                case ('list'): ?>
                <?php echo $__env->make('tasks.tabs.list_view', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php break; ?>
            <?php endswitch; ?>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        $(function () {
            "use strict";
            $('#cloudonex_table').DataTable(
            );


            <?php if($view_type === 'list'): ?>

            flatpickr("#start_date", {

                enableTime: true,
                dateFormat: "Y-m-d H:i",
            });

            flatpickr("#due_date", {

                enableTime: true,
                dateFormat: "Y-m-d H:i",
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

            <?php endif; ?>
            <?php if($view_type === 'calendar'): ?>

            var todayDate = moment().startOf("day");
            var YM = todayDate.format("YYYY-MM");
            var YESTERDAY = todayDate.clone().subtract(1, "day").format("YYYY-MM-DD");
            var TODAY = todayDate.format("YYYY-MM-DD");
            var TOMORROW = todayDate.clone().add(1, "day").format("YYYY-MM-DD");

            var calendarEl = document.getElementById("tasks_calendar_view");
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: "prev,next today",
                    center: "title",
                    right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth"
                },

                height: 800,
                contentHeight: 780,
                aspectRatio: 3,  // see: https://fullcalendar.io/docs/aspectRatio

                nowIndicator: true,
                now: TODAY + "T09:25:00", // just for demo

                views: {
                    dayGridMonth: {buttonText: "month"},
                    timeGridWeek: {buttonText: "week"},
                    timeGridDay: {buttonText: "day"}
                },

                initialView: "dayGridMonth",
                initialDate: TODAY,

                editable: true,
                dayMaxEvents: true, // allow "more" link when too many events
                navLinks: true,
                events: [],

            });
            calendar.render();
            <?php endif; ?>
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.primary', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\well-known\resources\views/tasks/list.blade.php ENDPATH**/ ?>