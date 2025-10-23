@extends('layouts.primary')

@section('content')
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <!-- Centered Heading -->
            <div class="text-center mb-4">
                <h2 class="mb-1 text-gradient text-primary fw-bold">
                    <i class="fas fa-tasks me-3"></i>{{__('Task Management')}}
                </h2>
                <p class="text-muted mb-0 fs-6">{{__('Organize and track your team\'s work efficiently')}}</p>
            </div>
            
            <!-- Action Buttons Row -->
            <div class="d-flex justify-content-between align-items-center">
                <!-- View Buttons (Left) -->
                <div class="d-flex gap-2">
                    <div class="btn-group" role="group" aria-label="View Types">
                        <a href="javascript:void(0)"
                           onclick="switchView('list')"
                           type="button"
                           class="btn {{ request()->view_type === 'list' || !request()->view_type ? 'btn-gradient-primary text-white shadow-sm' : 'btn-outline-primary' }} rounded-pill px-4 py-2 me-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="feather feather-list me-2">
                                <line x1="8" y1="6" x2="21" y2="6"></line>
                                <line x1="8" y1="12" x2="21" y2="12"></line>
                                <line x1="8" y1="18" x2="21" y2="18"></line>
                                <line x1="3" y1="6" x2="3.01" y2="6"></line>
                                <line x1="3" y1="12" x2="3.01" y2="12"></line>
                                <line x1="3" y1="18" x2="3.01" y2="18"></line>
                            </svg>
                            {{__('List')}}
                        </a>

                        <a href="{{ url('/kanban') . '?' . http_build_query(array_merge(request()->query(), ['action' => 'kanban'])) }}"
                           type="button"
                           class="btn {{ request()->routeIs('kanban') || request()->get('action') === 'kanban' ? 'btn-gradient-primary text-white shadow-sm' : 'btn-outline-primary' }} rounded-pill px-4 py-2 me-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="feather feather-trello me-2">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <rect x="7" y="7" width="3" height="9"></rect>
                                <rect x="14" y="7" width="3" height="5"></rect>
                            </svg>
                            {{__('Kanban')}}
                        </a>

                    </div>
                </div>
                
                <!-- Action Buttons (Right) -->
                <div class="d-flex gap-2">
                    <div class="btn-group">
                        <button type="button" class="btn btn-gradient-success text-white dropdown-toggle rounded-pill px-4 py-2 shadow-sm" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-plus me-2"></i>{{__('Add Actions')}}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="#" id="btn_add_new_category">
                                    <i class="fas fa-plus me-2 text-primary"></i>{{__('Add Task')}}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addStatusModal">
                                    <i class="fas fa-flag me-2 text-success"></i>{{__('Add Status')}}
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-primary dropdown-toggle rounded-pill px-4 py-2 shadow-sm" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-filter me-2"></i>{{__('Filters')}}
                        </button>
                        <div class="dropdown-menu dropdown-menu-end p-3" style="min-width: 350px;">
                            <form method="GET" action="{{ route('admin.tasks', ['action' => 'list']) }}" id="filterForm">
    <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-sm fw-bold">{{__('Workspace Type')}}</label>
                                        <select class="form-select form-select-sm" name="workspace_type">
                                            <option value="">{{__('All Types')}}</option>
                                            @foreach($workspaceTypes as $key => $type)
                                                <option value="{{ $key }}" {{ request('workspace_type') == $key ? 'selected' : '' }}>
                                                    {{ $type['label'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-sm fw-bold">{{__('Status')}}</label>
                                        <select class="form-select form-select-sm" name="status">
                                            <option value="">{{__('All Statuses')}}</option>
                                            @foreach($taskStatuses as $key => $status)
                                                <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                                    {{ $status['label'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-sm fw-bold">{{__('Priority')}}</label>
                                        <select class="form-select form-select-sm" name="priority">
                                            <option value="">{{__('All Priorities')}}</option>
                                            @foreach($taskPriorities as $key => $priority)
                                                <option value="{{ $key }}" {{ request('priority') == $key ? 'selected' : '' }}>
                                                    {{ $priority['label'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="clearFilters()">
                                        <i class="fas fa-times me-1"></i>{{__('Clear')}}
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fas fa-search me-1"></i>{{__('Apply Filters')}}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card shadow-sm">
            @switch($view_type)
                @case('list')
                @include('tasks.tabs.list_view')
                @break
            @endswitch
    </div>

@endsection

@section('script')
    <script>
        $(function () {
            "use strict";
            $('#cloudonex_table').DataTable(
            );


            @if($view_type === 'list')

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


            // Quick status change
            $(document).on('click', '.quick-status-change', function (event) {
                event.preventDefault();
                let taskId = $(this).data('task-id');
                let status = $(this).data('status');
                let $button = $(`.quick-status-btn[data-task-id="${taskId}"]`);
                
                // Show loading state
                $button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Updating...');
                
                $.post('{{ route('tasks.quickUpdateStatus') }}', {
                    _token: '{{ csrf_token() }}',
                    task_id: taskId,
                    status: status
                }).done(function (response) {
                    if (response.success) {
                        showNotification('success', 'Task status updated successfully');
                        setTimeout(() => location.reload(), 500);
                    } else {
                        showNotification('error', response.message || 'Failed to update task status');
                        $button.prop('disabled', false);
                    }
                }).fail(function () {
                    showNotification('error', 'Failed to update task status');
                    $button.prop('disabled', false);
                });
            });

            // Legacy status change (for backward compatibility)
            $('.change_task_status').on('click', function () {
                $.post('{{route('admin.tasks.save', ['action' => 'change-status'])}}', {
                    id: $(this).data('id'),
                    status: $(this).data('status'),
                    _token: '{{csrf_token()}}',
                }).done(function () {
                    showNotification('success', 'Task status updated');
                    setTimeout(() => location.reload(), 1000);
                });
            });

            @endif
            @if($view_type === 'calendar')

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
            @endif
        });

        // Clear filters function
        function clearFilters() {
            const form = document.getElementById('filterForm');
            const selects = form.querySelectorAll('select');
            selects.forEach(select => select.value = '');
            form.submit();
        }

        // Simple dropdown initialization
        $(document).ready(function() {
            // Handle status change clicks
            $('.quick-status-change').on('click', function(e) {
                e.preventDefault();
                const taskId = $(this).data('task-id');
                const status = $(this).data('status');

                // Show loading state
                const $button = $(`.quick-status-btn[data-task-id="${taskId}"]`);
                const $dropdown = $button.closest('.dropdown');
                const originalText = $button.html();

                $button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Updating...');

                // Make the API call
                $.post('{{ route('tasks.quickUpdateStatus') }}', {
                    _token: '{{ csrf_token() }}',
                    task_id: taskId,
                    status: status
                }).done(function(response) {
                    if (response.success) {
                        showNotification('success', 'Task status updated successfully');

                        // Close dropdown smoothly
                        $dropdown.find('.dropdown-menu').removeClass('show').fadeOut(150, function() {
                            // Reload page after dropdown closes
                            setTimeout(() => location.reload(), 200);
                        });
                    } else {
                        showNotification('error', response.message || 'Failed to update task status');
                        $button.prop('disabled', false).html(originalText);
                    }
                }).fail(function() {
                    showNotification('error', 'Failed to update task status');
                    $button.prop('disabled', false).html(originalText);
                });
            });
        });


        // Function to close actions dropdown smoothly
        function closeActionsDropdown(element) {
            const $dropdown = $(element).closest('.dropdown');
            $dropdown.find('.dropdown-menu').removeClass('show').fadeOut(150);
        }

        // Delete confirmation with SweetAlert2
        function confirmDelete(taskId, taskSubject) {
            // Close the dropdown first
            if (event && event.target) {
                closeActionsDropdown(event.target);
            }

            Swal.fire({
                title: '{{__("Are you sure?")}}',
                text: '{{__("You won\'t be able to recover this task!")}}',
                html: '<div class="text-center"><strong>' + taskSubject + '</strong><br><small class="text-muted">{{__("This action cannot be undone.")}}</small></div>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '{{__("Yes, delete it!")}}',
                cancelButtonText: '{{__("Cancel")}}',
                customClass: {
                    popup: 'swal-wide',
                    title: 'swal-title-custom',
                    htmlContainer: 'swal-text-custom'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: '{{__("Deleting...")}}',
                        text: '{{__("Please wait while we delete the task.")}}',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Make the delete request
                    $.post('/delete/task/' + taskId, {
                        _token: '{{ csrf_token() }}'
                    }).done(function(response) {
                        if (response.success || response.status === 'success') {
                            Swal.fire({
                                title: '{{__("Deleted!")}}',
                                text: '{{__("The task has been deleted successfully.")}}',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: '{{__("Error!")}}',
                                text: response.message || '{{__("Failed to delete the task.")}}',
                                icon: 'error'
                            });
                        }
                    }).fail(function() {
                        Swal.fire({
                            title: '{{__("Error!")}}',
                            text: '{{__("Failed to delete the task. Please try again.")}}',
                            icon: 'error'
                        });
                    });
                }
            });
        }

        // Notification function
        function showNotification(type, message) {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} alert-dismissible fade show position-fixed`;
            notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            notification.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 3000);
        }
    </script>

    <style>
        /* Tasks Module Color Scheme Consistency */
        .task-row:hover {
            background-color: rgba(203, 12, 159, 0.05);
            transition: background-color 0.2s ease;
        }
        
        .quick-status-btn {
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        
        .quick-status-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .badge-sm {
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 6px;
        }
        
        .progress-xs {
            height: 4px;
            border-radius: 2px;
        }
        
        .avatar-xs {
            width: 24px;
            height: 24px;
            font-size: 0.6rem;
        }
        
        /* Product Planning Style Button Gradients */
        .btn-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            border: none !important;
            color: white !important;
        }

        .btn-gradient-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%) !important;
            border: none !important;
            color: white !important;
        }

        .btn-gradient-primary:hover,
        .btn-gradient-success:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        
        /* Override any conflicting styles */
        .btn-group .btn:not(.btn-gradient-primary):not(.btn-gradient-success) {
            background: transparent !important;
            border: 2px solid #667eea !important;
            color: #667eea !important;
        }
        
        .btn-group .btn:not(.btn-gradient-primary):not(.btn-gradient-success):hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            border-color: transparent !important;
            color: white !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        
        /* Status-specific colors */
        .bg-gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important; }
        .bg-gradient-secondary { background: linear-gradient(135deg, #8392ab 0%, #a8b8d8 100%) !important; }
        .bg-gradient-success { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%) !important; }
        .bg-gradient-warning { background: linear-gradient(135deg, #fbcf33 0%, #fdd835 100%) !important; }
        .bg-gradient-danger { background: linear-gradient(135deg, #ea0606 0%, #ff5722 100%) !important; }
        .bg-gradient-info { background: linear-gradient(135deg, #17c1e8 0%, #4fc3f7 100%) !important; }
        
        /* Text colors */
        .text-primary { color: #667eea !important; }
        .text-secondary { color: #8392ab !important; }
        .text-success { color: #11998e !important; }
        .text-warning { color: #fbcf33 !important; }
        .text-danger { color: #ea0606 !important; }
        .text-info { color: #17c1e8 !important; }
        
        /* Button hover effects */
        .btn-outline-primary:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            border-color: transparent !important;
            color: white !important;
        }
        
        /* Ensure proper button states */
        .btn-group .btn.btn-outline-primary {
            background: transparent !important;
            border: 2px solid #667eea !important;
            color: #667eea !important;
        }
        
        .btn-group .btn.btn-outline-primary:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            border-color: transparent !important;
            color: white !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        
        /* Card enhancements */
        .card {
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }
        
        /* Stats cards */
        .icon-shape {
            border-radius: 12px;
        }
        
        /* Table enhancements */
        .table thead th {
            border-bottom: 2px solid rgba(0, 0, 0, 0.1);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .table tbody tr {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        /* Dropdown enhancements */
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            border-radius: 12px;
        }

        .dropdown-item {
            border-radius: 8px;
            margin: 2px 8px;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background: linear-gradient(310deg, #7928CA 0%, #FF0080 100%) !important;
            color: white !important;
            transform: translateX(4px);
        }

        /* Special hover effect for delete button */
        .dropdown-item.text-danger:hover {
            background: linear-gradient(135deg, #ea0606 0%, #ff5722 100%) !important;
            color: white !important;
            transform: translateX(4px);
        }

        /* Ensure delete icon also changes color on hover */
        .dropdown-item.text-danger:hover i {
            color: white !important;
        }

        /* Override soft-ui-dashboard dropdown styles */
        .dropdown-item:focus {
            background: linear-gradient(310deg, #7928CA 0%, #FF0080 100%) !important;
            color: white !important;
        }

        /* Fix for blocked status icon visibility */
        .dropdown-item i.fas {
            opacity: 1 !important;
            visibility: visible !important;
            display: inline-block !important;
        }

        /* Ensure all status icons are properly displayed */
        .quick-status-change i {
            display: inline-block !important;
            width: 16px !important;
            text-align: center !important;
            vertical-align: middle !important;
            font-size: 14px !important;
        }


        /* Professional Workspace Filter Styling */
        .workspace-filter-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid rgba(0, 0, 0, 0.06);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .filter-label {
            font-size: 1.1rem;
            color: #495057;
        }

        .filter-indicator {
            background: rgba(255, 255, 255, 0.8);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .workspace-tabs-container {
            margin-top: 0.5rem;
        }

        .workspace-tabs-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: flex-start;
            align-items: stretch;
        }

        .workspace-tab {
            flex: 0 0 auto;
            min-width: 140px;
            text-decoration: none !important;
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
            border: 2px solid transparent;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .workspace-tab:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
            border-color: rgba(102, 126, 234, 0.3);
            text-decoration: none !important;
        }

        .workspace-tab.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
            transform: translateY(-1px);
        }

        .workspace-tab.active .tab-content {
            color: white !important;
        }

        .workspace-tab.active .tab-count {
            background: rgba(255, 255, 255, 0.2);
            color: white !important;
        }

        .tab-content {
            padding: 1rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            color: #495057;
        }

        .tab-icon {
            font-size: 1.5rem;
            margin-bottom: 0.25rem;
            transition: all 0.3s ease;
        }

        .workspace-tab:hover .tab-icon {
            transform: scale(1.1);
        }

        .tab-label {
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.25rem;
        }

        .tab-count {
            background: #e9ecef;
            color: #6c757d;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            min-width: 2rem;
            text-align: center;
        }

        .workspace-tab.active .tab-count {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .workspace-tabs-wrapper {
                gap: 0.75rem;
            }

            .workspace-tab {
                min-width: 120px;
            }

            .tab-content {
                padding: 0.75rem;
            }

            .filter-label {
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .workspace-filter-section {
                padding: 1rem;
            }

            .workspace-tabs-wrapper {
                justify-content: center;
                gap: 0.5rem;
            }

            .workspace-tab {
                min-width: 100px;
                flex: 1 1 auto;
                max-width: 120px;
            }

            .d-flex.align-items-center.mb-3 {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .filter-indicator {
                margin-left: 0 !important;
            }
        }

        /* Simple fix for dropdown positioning in table-responsive */
        .table-responsive .dropdown-menu {
            z-index: 9999 !important;
            position: absolute !important;
        }

        .table-responsive .dropdown-menu.dropdown-menu-end {
            right: 0 !important;
            left: auto !important;
        }

        /* Ensure dropdowns don't get clipped */
        .table-responsive {
            overflow-x: visible !important;
        }

        /* Ensure dropdown toggle arrows show properly */
        .dropdown-toggle::after {
            display: inline-block !important;
            margin-left: 0.255em !important;
            vertical-align: 0.255em !important;
            content: "" !important;
            border-top: 0.3em solid !important;
            border-right: 0.3em solid transparent !important;
            border-bottom: 0 !important;
            border-left: 0.3em solid transparent !important;
        }

        /* SweetAlert2 Custom Styling */
        .swal-wide {
            width: 400px !important;
        }

        .swal-title-custom {
            font-size: 1.25rem !important;
            font-weight: 600 !important;
        }

        .swal-text-custom {
            font-size: 1rem !important;
            line-height: 1.5 !important;
        }

        .swal2-popup .swal2-title {
            color: #495057 !important;
        }

        .swal2-popup .swal2-html-container {
            color: #6c757d !important;
        }
        
        .bg-white-50 {
            background-color: rgba(255, 255, 255, 0.5) !important;
        }

        /* Comprehensive modal stability fix - disable all animations and transforms when modal is open */
        body.modal-open {
            cursor: auto !important;
            overflow: hidden !important;
        }

        body.modal-open *:hover {
            transform: none !important;
            transition: none !important;
            animation: none !important;
            box-shadow: none !important;
        }

        body.modal-open .btn:hover,
        body.modal-open .card:hover,
        body.modal-open .dropdown-item:hover,
        body.modal-open .quick-status-btn:hover {
            transform: none !important;
            box-shadow: none !important;
            transition: none !important;
        }

        /* Preserve button backgrounds in modals */
        body.modal-open .modal .btn:hover {
            background: inherit !important;
            opacity: 0.8 !important;
        }

        body.modal-open .modal .btn-primary:hover {
            background-color: #667eea !important;
        }

        body.modal-open .modal .btn-success:hover {
            background-color: #11998e !important;
        }

        body.modal-open .modal .btn-info:hover {
            background-color: #17c1e8 !important;
        }

        body.modal-open .modal .btn-warning:hover {
            background-color: #fbcf33 !important;
        }

        body.modal-open .modal .btn-danger:hover {
            background-color: #ea0606 !important;
        }

        body.modal-open .modal .btn-secondary:hover {
            background-color: #6c757d !important;
        }

        body.modal-open .bg-gradient-primary,
        body.modal-open .bg-gradient-success,
        body.modal-open .text-gradient {
            animation: none !important;
            transition: none !important;
        }

        /* Ensure modal has highest z-index */
        .modal {
            z-index: 9999 !important;
        }

        .modal-backdrop {
            z-index: 9998 !important;
            background-color: rgba(0, 0, 0, 0.5) !important;
        }

        /* Disable text cursor blinking when modal is open */
        body.modal-open * {
            caret-color: transparent !important;
        }

        body.modal-open input:focus,
        body.modal-open textarea:focus {
            caret-color: auto !important;
        }

        /* Prevent any layout shifts */
        body.modal-open {
            position: fixed !important;
            width: 100% !important;
            height: 100% !important;
        }
    </style>
@endsection

@section('script')
<script>


// Ensure jQuery is available before using it
if (typeof jQuery !== 'undefined' && jQuery) {
    $(document).ready(function() {
        // Comprehensive modal stability fix
        $('.modal').on('show.bs.modal', function() {
            // Disable all animations and transitions globally
            $('*').css({
                'animation': 'none !important',
                'transition': 'none !important',
                'transform': 'none !important'
            });

            // Fix body position to prevent layout shifts
            $('body').css({
                'position': 'fixed',
                'width': '100%',
                'height': '100%',
                'overflow': 'hidden'
            });

            // Disable hover effects on all elements
            $('*').off('mouseenter mouseleave hover');

            console.log('Modal opened - animations disabled');
        });

        $('.modal').on('shown.bs.modal', function() {
            // Ensure modal is properly positioned
            $(this).css('z-index', '9999');
            $('.modal-backdrop').css('z-index', '9998');

            // Disable any remaining animations
            $(this).find('*').css({
                'animation': 'none !important',
                'transition': 'none !important',
                'transform': 'none !important'
            });
        });

        $('.modal').on('hide.bs.modal', function() {
            // Re-enable animations when modal closes
            $('*').css({
                'animation': '',
                'transition': '',
                'transform': ''
            });

            // Restore body position
            $('body').css({
                'position': '',
                'width': '',
                'height': '',
                'overflow': ''
            });

            console.log('Modal closed - animations restored');
        });

        console.log('Modal stability scripts loaded');
    });
} else {
    console.error('jQuery not loaded');
}
    </script>
@endsection
