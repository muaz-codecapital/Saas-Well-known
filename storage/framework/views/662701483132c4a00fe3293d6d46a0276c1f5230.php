<?php $__env->startSection('content'); ?>
    <div class=" row">
        <div class="col">
            <h5 class="text-secondary fw-bolder">
                <?php echo e(__('Calendar')); ?>

            </h5>
        </div>
        <div class="col text-end">
            <div class="col-12 ms-auto">
                <button type="button" class="btn btn-info" id="addEvent">
                    <?php echo e(__('Add Event')); ?>

                </button>
                <button type="button" class="btn btn-google text-white" id="addEvent">
                    <i class="fab fa-google me-2"></i> <?php echo e(__('Sync')); ?>

                </button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3">
            <div class="row">
                <div class="col-xl-12 col-md-6 mt-xl-0 mt-4">

                    <div class="card">

                        <div class="card-header p-3 pb-0">
                            <h6 class="mb-0">
                                <?php echo e(__('Events')); ?>


                            </h6>
                        </div>
                        <div class="card-body border-radius-lg p-3">

                            <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <div class="d-flex mt-4">
                                    <div>
                                        <div
                                            class="icon icon-shape bg-purple-light shadow text-center border-radius-md shadow-none">

                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-clock text-purple mt-2 ">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <polyline points="12 6 12 12 16 14"></polyline>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <div class="numbers">
                                            <h6 class="mb-1 text-dark text-sm"><?php echo e($event->title); ?></h6>
                                            <span
                                                class="text-sm">
                                                <?php echo e((\App\Supports\DateSupport::parse($event->start_date))->format(config('app.date_time_format'))); ?>

                                                </span>
                                            <a class="btn btn-link text-dark px-3 mb-0"
                                               href="/delete/event/<?php echo e($event->id); ?>"><i
                                                    class="fas fa-trash text-dark me-2"
                                                    aria-hidden="true"></i><?php echo e(__('Delete')); ?></a>
                                        </div>


                                    </div>
                                </div>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-xl-9">
            <div class="card card-calendar">
                <div class="card-body p-3">
                    <div class="calendar" data-bs-toggle="calendar" id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('Add Event')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body  p-3">
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script>
        $(function () {
            "use strict";

            let $addEvent = $('#addEvent');

            $addEvent.on('click', function (event) {
                event.preventDefault();

                let create_event_form = Fancybox.show([
                    {
                        src: "/calendar/event",
                        type: "ajax",
                    },
                ]);

                create_event_form.on('done', function () {
                    flatpickr("#start_date", {

                        enableTime: true,
                        dateFormat: "Y-m-d H:i",
                    });

                    flatpickr("#end_date", {

                        enableTime: true,
                        dateFormat: "Y-m-d H:i",
                    });


                });

            });


        });
    </script>
    <script>
        (function(){
            "use strict";

            var calendar = new FullCalendar.Calendar(document.getElementById("calendar"), {
                contentHeight: 'auto',
                initialView: "dayGridMonth",
                headerToolbar: {
                    start: 'title', // will normally be on the left. if RTL, will be on the right
                    center: '',
                    end: 'today prev,next' // will normally be on the right. if RTL, will be on the left
                },
                selectable: true,
                editable: true,
                initialDate: '<?php echo e(date('Y-m-d')); ?>',
                events: [

                        <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                    {
                        id: '<?php echo e($event->id); ?>',
                        title: '<?php echo e($event->title); ?>',
                        start: '<?php echo e($event->start_date); ?>',
                        end: '<?php echo e($event->end_date); ?>',

                        className: 'bg-purple-light',


                    },
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                ],
                views: {
                    month: {
                        titleFormat: {
                            month: "long",
                            year: "numeric"
                        }
                    },
                    agendaWeek: {
                        titleFormat: {
                            month: "long",
                            year: "numeric",
                            day: "numeric"
                        }
                    },
                    agendaDay: {
                        titleFormat: {
                            month: "short",
                            year: "numeric",
                            day: "numeric"
                        }
                    }
                },
                eventClick: function (info) {

                    let create_event_form = Fancybox.show([
                        {
                            src: "/calendar/event?id=" + info.event.id,
                            type: "ajax",
                        },
                    ]);

                    create_event_form.on('done', function () {
                        flatpickr("#start_date", {

                            enableTime: true,
                            dateFormat: "Y-m-d H:i",
                        });

                        flatpickr("#end_date", {

                            enableTime: true,
                            dateFormat: "Y-m-d H:i",
                        });


                    });
                },
                dateClick: function (info) {
                    let create_event_form = Fancybox.show([
                        {
                            src: "/calendar/event?date=" + info.dateStr,
                            type: "ajax",
                        },
                    ]);

                    create_event_form.on('done', function () {
                        flatpickr("#start_date", {

                            enableTime: true,
                            dateFormat: "Y-m-d H:i",
                        });

                        flatpickr("#end_date", {

                            enableTime: true,
                            dateFormat: "Y-m-d H:i",
                        });


                    });
                },
            });

            calendar.render();

            var ctx1 = document.getElementById("chart-line-1").getContext("2d");

            var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

            gradientStroke1.addColorStop(1, 'rgba(255,255,255,0.3)');
            gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
            gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

            new Chart(ctx1, {
                type: "line",
                data: {
                    labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    datasets: [{
                        label: "Visitors",
                        tension: 0.5,

                        pointRadius: 0,
                        borderColor: "#fff",
                        borderWidth: 2,
                        backgroundColor: "#4F55DA",
                        data: [50, 45, 60, 60, 80, 65, 90, 80, 100],
                        maxBarThickness: 6,
                        fill: true
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: false,
                                drawTicks: false,
                            },
                            ticks: {
                                display: false
                            }
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: false,
                                drawTicks: false,
                            },
                            ticks: {
                                display: false
                            }
                        },
                    },
                },
            });
        })();

    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.primary', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/freylphj/suiteup.grsventures.ltd/resources/views/plans/calendar.blade.php ENDPATH**/ ?>