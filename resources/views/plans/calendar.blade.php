@extends('layouts.primary')
@section('content')
    <div class=" row">
        <div class="col">
            <h5 class="text-secondary fw-bolder">
                {{__('Calendar')}}
            </h5>
        </div>
        <div class="col text-end">
            <div class="col-12 ms-auto">
                <button type="button" class="btn btn-info" id="addEvent">
                    {{__('Add Event')}}
                </button>

                @php
                    $isAuthenticated = auth()->check();
                    $googleAccount = $isAuthenticated ? auth()->user()->googleAccount : null;
                    $isConnected = $googleAccount && $googleAccount->is_connected;
                @endphp

                @if($isAuthenticated && $isConnected)
                    <button type="button" class="btn btn-success" id="syncGoogleCalendar">
                        <i class="fab fa-google me-2"></i> {{ __('Sync Now') }}
                </button>
                    <a href="{{ route('google.disconnect') }}" class="btn btn-danger" onclick="return confirm('{{ __('Are you sure you want to disconnect Google Calendar?') }}')" style="background-color: #dc3545; border-color: #dc3545;">
                        <i class="fas fa-unlink me-2"></i> {{ __('Disconnect') }}
                    </a>
                @elseif($isAuthenticated)
                    <a href="{{ route('google.redirect') }}" class="btn" style="background-color: #4285f4; border-color: #4285f4; color: white;">
                        <i class="fab fa-google me-2"></i> {{ __('Connect Google Calendar') }}
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn" style="background-color: #6c757d; border-color: #6c757d; color: white;">
                        <i class="fas fa-sign-in-alt me-2"></i> {{ __('Login to Connect') }}
                    </a>
                @endif
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
                                {{__('Events')}}

                            </h6>
                        </div>
                        <div class="card-body border-radius-lg p-3">

                            @foreach($events as $event)

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
                                            <h6 class="mb-1 text-dark text-sm">{{$event->title}}</h6>
                                            <span
                                                class="text-sm">
                                                {{(\App\Supports\DateSupport::parse($event->start_date))->format(config('app.date_time_format'))}}
                                                </span>
                                            <a class="btn btn-link text-dark px-3 mb-0"
                                               href="/delete/event/{{$event->id}}"><i
                                                    class="fas fa-trash text-dark me-2"
                                                    aria-hidden="true"></i>{{__('Delete')}}</a>
                                        </div>


                                    </div>
                                </div>

                            @endforeach


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
                    <h5 class="modal-title" id="exampleModalLabel">{{__('Add Event')}}</h5>
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
@endsection
@section('script')
    <script>
        $(function () {
            "use strict";
            
            // SweetAlert2 is now available globally

            let $addEvent = $('#addEvent');
            let $syncGoogleCalendar = $('#syncGoogleCalendar');

            $addEvent.on('click', function (event) {
                event.preventDefault();

                // Load event form via AJAX and show in modal
                $.ajax({
                    url: "/calendar/event?date=" + new Date().toISOString().split('T')[0],
                    method: 'GET',
                    success: function(response) {
                        // Create modal if it doesn't exist
                        if (!$('#eventModal').length) {
                            $('body').append(`
                                <div id="eventModal" style="position: fixed; inset: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; display: none; align-items: center; justify-content: center; padding: 20px;">
                                    <div style="background: #fff; padding: 20px; border-radius: 8px; width: 100%; max-width: 720px; max-height: 90vh; overflow-y: auto; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                                            <h5 style="margin: 0;">{{ __('Add/Edit Event') }}</h5>
                                            <button type="button" id="closeEventModal" style="background: none; border: none; font-size: 24px; line-height: 1; cursor: pointer;">&times;</button>
                                        </div>
                                        <div id="eventModalBody">
                                            <!-- Form will be loaded here -->
                                        </div>
                                    </div>
                                </div>
                            `);
                        }

                        // Insert the form content and show modal
                        $('#eventModalBody').html(response);
                        $('#eventModal').css('display','flex');
                        $('body').css('overflow','hidden');

                        // Initialize flatpickr
                    flatpickr("#start_date", {
                        enableTime: true,
                        dateFormat: "Y-m-d H:i",
                    });

                    flatpickr("#end_date", {
                        enableTime: true,
                        dateFormat: "Y-m-d H:i",
                    });

                        // Close on backdrop click (outside content)
                        $('#eventModal').off('click').on('click', function(e){
                            if (e.target === this) {
                                $(this).hide();
                                $('body').css('overflow','');
                            }
                        });

                        // Handle Esc key to close
                        $(document).on('keydown.eventModalEsc', function(e){
                            if (e.key === 'Escape') {
                                $('#eventModal').hide();
                                $('body').css('overflow','');
                                $(document).off('keydown.eventModalEsc');
                            }
                        });

                        // Client-side validation helper
                        function validateEventForm($form){
                            const startVal = $form.find('#start_date').val();
                            const endVal = $form.find('#end_date').val();
                            if(!startVal || !endVal){
                                return '{{ __("Start and End date are required.") }}';
                            }
                            const start = new Date(startVal.replace(' ', 'T'));
                            const end = new Date(endVal.replace(' ', 'T'));
                            if(isNaN(start.getTime()) || isNaN(end.getTime())){
                                return '{{ __("Invalid date/time format.") }}';
                            }
                            if(end <= start){
                                return '{{ __("End date & time must be greater than Start date & time.") }}';
                            }
                            return null;
                        }

                        // Handle form submission (AJAX)
                        $('#eventModal').on('submit', '#form_main', function(e) {
                            e.preventDefault();
                            const $form = $(this);
                            const $submitBtn = $form.find('button[type="submit"]');

                            // Client-side validation
                            const validationError = validateEventForm($form);
                            if (validationError) {
                                Swal.fire({ icon: 'warning', title: '{{ __("Validation Error") }}', text: validationError });
                                return;
                            }

                            // Disable button and show spinner
                            const originalBtnHtml = $submitBtn.html();
                            $submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>{{ __("Saving...") }}');

                            $.ajax({
                                url: $form.attr('action'),
                                method: 'POST',
                                data: $form.serialize(),
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: '{{ __("Success!") }}',
                                        text: response && response.message ? response.message : '{{ __("Event saved successfully!") }}',
                                        showConfirmButton: true,
                                        confirmButtonText: '{{ __("OK") }}',
                                        timer: 2000,
                                        timerProgressBar: true
                                    }).then(() => {
                                        $('#eventModal').hide();
                                        $('body').css('overflow','');
                                        location.reload();
                                    });
                                },
                                error: function(xhr) {
                                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                                        let errors = xhr.responseJSON.errors;
                                        let errorHtml = '<div class="alert alert-danger"><ul class="list-unstyled">';
                                        for (let field in errors) {
                                            errorHtml += '<li>' + errors[field].join(', ') + '</li>';
                                        }
                                        errorHtml += '</ul></div>';
                                        $('#sp_result_div').html(errorHtml);
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: '{{ __("Error") }}',
                                            text: '{{ __("Failed to save event. Please try again.") }}',
                                            confirmButtonText: '{{ __("OK") }}'
                                        });
                                    }
                                },
                                complete: function(){
                                    $submitBtn.prop('disabled', false).html(originalBtnHtml);
                                }
                            });
                        });

                        // Handle close button
                        $('#closeEventModal').on('click', function() {
                            $('#eventModal').hide();
                            $('body').css('overflow','');
                        });

                        // Close modal when clicking outside
                        $('#eventModal').on('click', function(e) {
                            if (e.target === this) {
                                $(this).hide();
                            }
                        });

                        // Show the modal
                        $('#eventModal').show();
                    },
                    error: function(xhr) {
                        console.error('Failed to load event form:', xhr);
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __("Error") }}',
                            text: '{{ __("Failed to load event form. Please try again.") }}',
                            confirmButtonText: '{{ __("OK") }}'
                        });
                    }
                });
            });

            // Google Calendar Sync functionality
            $syncGoogleCalendar.on('click', function (event) {
                event.preventDefault();

                // Show loading state
                $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>{{ __("Syncing...") }}');

                // Show loading SweetAlert
                Swal.fire({
                    title: '{{ __("Syncing Calendar") }}',
                    text: '{{ __("Please wait while we sync your Google Calendar...") }}',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Make AJAX request to sync Google Calendar
                $.ajax({
                    url: '{{ route("google.sync") }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Close loading alert
                        Swal.close();
                        
                        if (response.success) {
                            // Show success message with SweetAlert
                            Swal.fire({
                                icon: 'success',
                                title: '{{ __("Success!") }}',
                                text: response.message,
                                showConfirmButton: true,
                                confirmButtonText: '{{ __("OK") }}',
                                timer: 3000,
                                timerProgressBar: true
                            }).then(() => {
                                // Refresh the page after user clicks OK or timer expires
                                location.reload();
                            });
                        } else {
                            // Show error message with SweetAlert
                            Swal.fire({
                                icon: 'error',
                                title: '{{ __("Sync Failed") }}',
                                text: response.message || '{{ __("Sync failed. Please try again.") }}',
                                confirmButtonText: '{{ __("OK") }}'
                            });
                        }
                    },
                    error: function(xhr) {
                        // Close loading alert
                        Swal.close();
                        
                        let message = '{{ __("Sync failed. Please try again.") }}';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        // Show error message with SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __("Sync Failed") }}',
                            text: message,
                            confirmButtonText: '{{ __("OK") }}'
                        });
                    },
                    complete: function() {
                        // Reset button state
                        $syncGoogleCalendar.prop('disabled', false).html('<i class="fab fa-google me-2"></i>{{ __("Sync Now") }}');
                    }
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
                initialDate: '{{date('Y-m-d')}}',
                events: [

                        @foreach($events as $event)
                    {
                        id: '{{$event->id}}',
                        title: '{{$event->title}}',
                        @if($event->all_day)
                        start: '{{ \Carbon\Carbon::parse($event->start_date)->format('Y-m-d') }}',
                        end: '{{ \Carbon\Carbon::parse($event->end_date)->addDay()->format('Y-m-d') }}',
                        allDay: true,
                        @else
                        start: '{{$event->start_date}}',
                        end: '{{$event->end_date}}',
                        allDay: false,
                        @endif
                        className: 'bg-purple-light',
                    },
                    @endforeach

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

@endsection
