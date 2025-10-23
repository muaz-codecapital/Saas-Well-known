@extends('layouts.primary')

@section('content')
    @php
        $taskStatuses = config('task.statuses');
    @endphp
    
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <!-- Centered Heading -->
            <div class="text-center mb-4">
                <h2 class="mb-1 text-gradient text-primary fw-bold">
                    <i class="fas fa-columns me-3"></i>{{__('Task Management / Kanban')}}
                </h2>
                <p class="text-muted mb-0 fs-6">{{__('Visualize and manage your team\'s workflow')}}</p>
        </div>
            
            <!-- Action Buttons Row -->
            <div class="d-flex justify-content-between align-items-center">
                <!-- View Buttons (Left) -->
                <div class="d-flex gap-2">
                    <div class="btn-group" role="group" aria-label="View Types">
                        <a href="{{ route('admin.tasks', array_merge(request()->query(), ['action' => 'list', 'view_type' => 'list'])) }}"
                           type="button"
                           class="btn {{ request()->view_type === 'list' || (!request()->view_type && !request()->get('action')) || request()->get('action') === 'list' ? 'btn-gradient-primary text-white shadow-sm' : 'btn-outline-primary' }} rounded-pill px-4 py-2 me-2">
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

                        <a href="{{ url('/kanban') . '?' . http_build_query(request()->query()) }}"
                           type="button"
                           class="btn {{ request()->routeIs('kanban') || request()->is('kanban') ? 'btn-gradient-primary text-white shadow-sm' : 'btn-outline-primary' }} rounded-pill px-4 py-2 me-2">
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
                                <a class="dropdown-item" href="#" onclick="createTaskInColumn('to_do')">
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
                            <form method="GET" action="{{ url('/kanban') }}" id="kanbanFilterForm">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">{{__('Workspace Type')}}</label>
                                        <select class="form-select" name="workspace_type">
                                            <option value="">{{__('All Workspaces')}}</option>
                                            @foreach(config('task.workspace_types') as $key => $workspace)
                                                <option value="{{ $key }}" {{ request()->workspace_type === $key ? 'selected' : '' }}>
                                                    {{ $workspace['label'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">{{__('Priority')}}</label>
                                        <select class="form-select" name="priority">
                                            <option value="">{{__('All Priorities')}}</option>
                                            @foreach(config('task.priorities') as $key => $priority)
                                                <option value="{{ $key }}" {{ request()->priority === $key ? 'selected' : '' }}>
                                                    {{ $priority['label'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">{{__('Assigned To')}}</label>
                                        <select class="form-select" name="assigned_to">
                                            <option value="">{{__('All Users')}}</option>
                                            @foreach($users ?? [] as $user)
                                                <option value="{{ $user->id }}" {{ (request()->assigned_to == $user->id) ? 'selected' : '' }}>
                                                    {{ $user->first_name }} {{ $user->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">{{__('Search')}}</label>
                                        <input type="text" class="form-control" name="search" value="{{ request()->search }}" placeholder="{{__('Search tasks...')}}">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between gap-2">
                                    <button type="submit" class="btn btn-primary btn-sm">{{__('Apply Filters')}}</button>
                                    <a href="{{ url('/kanban') }}" class="btn btn-outline-secondary btn-sm">{{__('Clear')}}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="avatar avatar-lg bg-gradient-secondary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
                        <i class="fas fa-circle text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <h4 class="mb-1 text-dark fw-bold">{{ $tasks->where('status', 'to_do')->count() }}</h4>
                    <p class="text-muted mb-0">{{__('To Do')}}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="avatar avatar-lg bg-gradient-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
                        <i class="fas fa-play-circle text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <h4 class="mb-1 text-dark fw-bold">{{ $tasks->where('status', 'in_progress')->count() }}</h4>
                    <p class="text-muted mb-0">{{__('In Progress')}}</p>
                </div>
                        </div>
                        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="avatar avatar-lg bg-gradient-warning rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
                        <i class="fas fa-eye text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <h4 class="mb-1 text-dark fw-bold">{{ $tasks->where('status', 'in_review')->count() }}</h4>
                    <p class="text-muted mb-0">{{__('In Review')}}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="avatar avatar-lg bg-gradient-success rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
                        <i class="fas fa-check-circle text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <h4 class="mb-1 text-dark fw-bold">{{ $tasks->where('status', 'completed')->count() }}</h4>
                    <p class="text-muted mb-0">{{__('Completed')}}</p>
                </div>
            </div>
        </div>
                        </div>


    <!-- Kanban Board -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-gradient-primary text-white">
            <div class="d-flex align-items-center">
                <div class="avatar avatar-sm bg-white bg-opacity-20 rounded-circle me-3">
                    <i class="fas fa-columns text-white"></i>
                        </div>
                <div>
                    <h5 class="mb-0 text-white">{{__('Task Kanban Board')}}</h5>
                    <small class="text-white-50">{{__('Drag and drop tasks to change status')}}</small>
                        </div>
                        </div>
                    </div>
        <div class="card-body p-0">
            <div class="kanban-container">
                <div class="kanban-board-wrapper">
                    <div id="taskKanban" class="kanban-board-container"></div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .kanban-container {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 600px;
            padding: 0;
        }

        /* Professional Workspace Filter Styling */
        .workspace-filter-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid rgba(0, 0, 0, 0.06);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 1rem;
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

        .kanban-board-wrapper {
            padding: 20px;
            overflow-x: auto;
            min-height: 600px;
        }

        .kanban-board-container {
            display: flex;
            gap: 20px;
            min-height: 560px;
            padding-bottom: 20px;
        }

        /* Kanban Board Styling */
        .kanban-board {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            min-width: 320px;
            max-width: 320px;
            min-height: 500px;
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }

        .kanban-board:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .kanban-board-header {
            padding: 16px 20px;
            border-bottom: 2px solid #f1f3f4;
            font-weight: 600;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 12px 12px 0 0;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .kanban-drag {
            min-height: 400px;
            padding: 10px;
            background: #fafbfc;
            border-radius: 0 0 12px 12px;
        }

        .kanban-item {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            margin-bottom: 12px;
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
            cursor: pointer;
        }

        .kanban-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
            border-color: #667eea;
        }

        /* Drag and Drop Styles */
        .kanban-item.dragging {
            opacity: 0.5;
            transform: rotate(5deg);
            z-index: 1000;
        }

        .kanban-drag {
            min-height: 100px;
            transition: all 0.3s ease;
        }

        .kanban-drag.drop-zone-active {
            background: rgba(0, 123, 255, 0.1);
            border: 2px dashed #007bff;
            border-radius: 8px;
        }

        .kanban-item[draggable="true"] {
            cursor: grab;
        }

        .kanban-item[draggable="true"]:active {
            cursor: grabbing;
        }

        .kanban-item-content {
            padding: 16px;
        }

        .kanban-item-content h6 {
            font-size: 14px;
            font-weight: 600;
            color: #2d3748;
            line-height: 1.4;
            margin-bottom: 8px;
        }

        .kanban-item-content p {
            font-size: 13px;
            color: #718096;
            line-height: 1.4;
            margin-bottom: 12px;
        }

        /* Empty State Styling */
        .kanban-drag:empty::before {
            content: "Drop items here";
            display: block;
            text-align: center;
            color: #a0aec0;
            padding: 40px 20px;
            font-style: italic;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .kanban-board-wrapper {
                padding: 10px;
            }
            
            .kanban-board {
                min-width: 280px;
                max-width: 280px;
            }
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

        .bg-gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important; }
        .bg-gradient-secondary { background: linear-gradient(135deg, #8392ab 0%, #a8b8d8 100%) !important; }
        .bg-gradient-success { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%) !important; }
        .bg-gradient-warning { background: linear-gradient(135deg, #fbcf33 0%, #fdd835 100%) !important; }
        .bg-gradient-danger { background: linear-gradient(135deg, #ea0606 0%, #ff5722 100%) !important; }
        .bg-gradient-info { background: linear-gradient(135deg, #17c1e8 0%, #4fc3f7 100%) !important; }
        
        .text-primary { color: #667eea !important; }
        .text-secondary { color: #8392ab !important; }
        .text-success { color: #11998e !important; }
        .text-warning { color: #fbcf33 !important; }
        .text-danger { color: #ea0606 !important; }
        .text-info { color: #17c1e8 !important; }

        /* Modal button hover fixes */
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
    </style>

    @include('tasks.add-new')
    @include('tasks.add-status-model')

@endsection

@section('script')
<script>
let currentTaskId = null;


$(document).ready(function() {
    console.log('Document ready - initializing Task Kanban board...');
    
    // Always create the kanban board
    createProfessionalTaskKanban();
    
    // Handle form submission
    $('#form_main').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const data = {};
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }
        
        // Add workspace_id and admin_id
        data.workspace_id = '{{ auth()->user()->workspace_id ?? "" }}';
        data.admin_id = '{{ auth()->id() ?? "" }}';
        
        $.ajax({
            url: '{{ route("admin.tasks.save", ["action" => "save"]) }}',
            method: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#kt_modal_1').modal('hide');
                    showNotification('Task created successfully!', 'success');
                    // Reload the page to show the new task
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showNotification('Error: ' + (response.message || 'Something went wrong'), 'error');
                }
            },
            error: function(xhr) {
                let errors = '';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    Object.values(xhr.responseJSON.errors).forEach(error => {
                        errors += error.join(', ') + '\n';
                    });
                        } else {
                    errors = 'Something went wrong';
                }
                showNotification('Error: ' + errors, 'error');
            }
        });
    });
});

function createProfessionalTaskKanban() {
    console.log('Creating professional task kanban board...');
    
    const statuses = @json(config('task.statuses'));
    const priorities = @json(config('task.priorities'));
    const workspaceTypes = @json(config('task.workspace_types'));
    const tasks = @json($tasks);
    const users = @json($users);
    
    console.log('Task Kanban Data:', {
        statuses: statuses,
        priorities: priorities,
        workspaceTypes: workspaceTypes,
        tasks: tasks,
        users: users
    });
    
    const kanbanElement = document.getElementById("taskKanban");
    if (!kanbanElement) {
        console.error('Task Kanban container not found');
        return;
    }
    
    let kanbanHtml = '';
    
    Object.keys(statuses).forEach(status => {
        const statusTasks = tasks.filter(task => task.status === status);
        const statusConfig = statuses[status];
        
        let tasksHtml = '';
        statusTasks.forEach(task => {
            let userHtml = '';
            if (task.assignee_id && users[task.assignee_id]) {
                const user = users[task.assignee_id];
                if (user.photo) {
                    userHtml = `<img src="{{PUBLIC_DIR}}/uploads/${user.photo}" class="avatar avatar-sm rounded-circle me-2" alt="">`;
                } else {
                    userHtml = `<div class="avatar avatar-sm bg-gradient-primary rounded-circle me-2 d-flex align-items-center justify-content-center">
                        <span class="text-white text-xs fw-bold">${user.first_name[0]}${user.last_name[0]}</span>
                    </div>`;
                }
                userHtml += `<span class="text-sm">${user.first_name} ${user.last_name}</span>`;
            }
            
            let progressHtml = '';
            if (task.progress > 0) {
                progressHtml = `
                    <div class="progress mt-2 mb-1" style="height: 4px;">
                        <div class="progress-bar bg-${task.progress >= 100 ? 'success' : (task.progress >= 50 ? 'primary' : 'warning')}"
                             style="width: ${task.progress}%"></div>
                    </div>
                    <small class="text-muted">${task.progress}% complete</small>`;
            }
            
            let dueDateHtml = '';
            if (task.due_date) {
                const dueDate = new Date(task.due_date);
                const isOverdue = dueDate < new Date() && task.status !== 'completed';
                const formattedDate = dueDate.toLocaleDateString();
                dueDateHtml = `<div class="badge bg-${isOverdue ? 'danger' : 'info'} text-white mb-2">
                    <i class="fas fa-calendar me-1"></i>${formattedDate}
                </div>`;
            }
            
            let workspaceHtml = '';
            if (task.workspace_type && workspaceTypes[task.workspace_type]) {
                const workspace = workspaceTypes[task.workspace_type];
                workspaceHtml = `<small class="badge bg-info text-white me-1">
                    <i class="ni ni-${workspace.icon} me-1"></i>${workspace.label}
                </small>`;
            }
            
            tasksHtml += `
                <div class="kanban-item mb-3" draggable="true" data-task-id="${task.id}" data-task-status="${task.status}" onclick="viewTask(${task.id})" style="cursor: pointer;">
                    <div class="kanban-item-content">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="fw-bold mb-0 flex-grow-1 me-2">${task.subject}</h6>
                            <div class="badge bg-${priorities[task.priority] ? priorities[task.priority]['class'] : 'secondary'} text-white px-2 py-1">
                                ${priorities[task.priority] ? priorities[task.priority]['label'] : 'Medium'}
                            </div>
                        </div>
                        ${task.description ? `<p class="text-sm text-muted mb-2">${task.description.length > 80 ? task.description.substring(0, 80) + '...' : task.description}</p>` : ''}
                        ${dueDateHtml}
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            ${workspaceHtml}
                            ${task.tags && task.tags.length > 0 ? `<small class="badge bg-warning text-white"><i class="fas fa-tags me-1"></i>${task.tags.length} tags</small>` : ''}
                        </div>
                        ${task.tags && task.tags.length > 0 ? `<div class="mb-2">${task.tags.map(tag => `<span class="badge bg-light text-dark border me-1">${tag}</span>`).join('')}</div>` : ''}
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                ${userHtml || '<span class="text-muted text-sm">Unassigned</span>'}
                            </div>
                            ${progressHtml}
                        </div>
                    </div>
                </div>
            `;
        });
        
        // Add empty state if no tasks
        if (statusTasks.length === 0) {
            tasksHtml = `
                <div class="text-center py-4">
                    <div class="text-muted" style="border: 2px dashed #e2e8f0; border-radius: 8px; padding: 30px; background: #f7fafc;">
                        <i class="fas fa-plus-circle mb-2" style="font-size: 2rem; color: #a0aec0;"></i>
                        <p class="mb-0" style="font-size: 13px;">No tasks yet</p>
                        <button class="btn btn-sm btn-outline-primary mt-2" onclick="createTaskInColumn('${status}')">
                            <i class="fas fa-plus me-1"></i>Add Task
                        </button>
                    </div>
                </div>
            `;
        }
        
        // Use icons from config instead of hardcoded mapping
        const getStatusIcon = (status) => {
            return statuses[status] ? statuses[status].icon : 'circle';
        };
        
        kanbanHtml += `
            <div class="kanban-board" style="min-width: 320px; max-width: 320px;">
                <div class="kanban-board-header">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-sm rounded-circle me-2 d-flex align-items-center justify-content-center" style="background: ${statusConfig.color};">
                                <i class="fas fa-${getStatusIcon(status)} text-white" style="font-size: 0.75rem;"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark">${statusConfig.label}</div>
                                <small class="text-muted">${statusTasks.length} tasks</small>
                            </div>
                        </div>
                        <div class="badge text-white px-2 py-1" style="background: ${statusConfig.color};">
                            ${statusTasks.length}
                        </div>
                    </div>
                </div>
                <div class="kanban-drag" data-status="${status}" ondrop="dropTask(event)" ondragover="allowDrop(event)">
                    ${tasksHtml}
                </div>
            </div>
        `;
    });
    
    kanbanElement.innerHTML = kanbanHtml;
    
    // Initialize drag and drop functionality
    initializeDragAndDrop();
    
    console.log('Task Kanban board created successfully');
}

// Drag and Drop Functions
function initializeDragAndDrop() {
    const kanbanItems = document.querySelectorAll('.kanban-item[draggable="true"]');
    
    kanbanItems.forEach(item => {
        item.addEventListener('dragstart', handleDragStart);
        item.addEventListener('dragend', handleDragEnd);
    });
}

function handleDragStart(e) {
    const taskId = e.target.dataset.taskId;
    const currentStatus = e.target.dataset.taskStatus;
    
    e.dataTransfer.setData('text/plain', taskId);
    e.dataTransfer.setData('text/status', currentStatus);
    e.target.style.opacity = '0.5';
    
    // Add visual feedback
    e.target.classList.add('dragging');
    
    // Add drop zone highlighting
    const dropZones = document.querySelectorAll('.kanban-drag');
    dropZones.forEach(zone => {
        if (zone.dataset.status !== currentStatus) {
            zone.classList.add('drop-zone-active');
        }
    });
}

function handleDragEnd(e) {
    e.target.style.opacity = '1';
    e.target.classList.remove('dragging');
    
    // Remove drop zone highlighting
    const dropZones = document.querySelectorAll('.kanban-drag');
    dropZones.forEach(zone => {
        zone.classList.remove('drop-zone-active');
    });
}

function allowDrop(e) {
    e.preventDefault();
}

function dropTask(e) {
    e.preventDefault();
    
    const taskId = e.dataTransfer.getData('text/plain');
    const oldStatus = e.dataTransfer.getData('text/status');
    const newStatus = e.target.closest('.kanban-drag').dataset.status;
    
    if (oldStatus === newStatus) {
        return; // No change needed
    }
    
    // Update task status via AJAX
    updateTaskStatus(taskId, newStatus);
}

function updateTaskStatus(taskId, newStatus) {
    // Show confirmation dialog
    Swal.fire({
        title: '{{__("Are you sure?")}}',
        text: '{{__("Are you sure you want to update the status?")}}',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0d6efd',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '{{__("Yes, update it!")}}',
        cancelButtonText: '{{__("Cancel")}}',
        customClass: {
            popup: 'swal-wide',
            title: 'swal-title-custom',
            htmlContainer: 'swal-text-custom'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading state
            const taskElement = document.querySelector(`[data-task-id="${taskId}"]`);
            if (taskElement) {
                taskElement.style.opacity = '0.6';
                taskElement.style.pointerEvents = 'none';
            }
            
            $.ajax({
                url: `/admin/tasks/${taskId}/status`,
                method: 'PATCH',
                data: {
                    status: newStatus,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        showNotification('Task status updated successfully!', 'success');
                        // Reload the kanban board to reflect changes
                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    } else {
                        showNotification('Error: ' + (response.message || 'Failed to update task status'), 'error');
                        // Reset the task position
                        location.reload();
                    }
                },
                error: function(xhr) {
                    console.error('Error updating task status:', xhr);
                    showNotification('Error updating task status. Please try again.', 'error');
                    // Reset the task position
                    location.reload();
                },
                complete: function() {
                    // Reset loading state
                    if (taskElement) {
                        taskElement.style.opacity = '1';
                        taskElement.style.pointerEvents = 'auto';
                    }
                }
            });
        } else {
            // User cancelled, reset the task position
            location.reload();
        }
    });
}

function viewTask(id) {
    // Handle task view
    console.log('Viewing task:', id);
    // You can implement a modal or redirect to task details
}

function createTaskInColumn(status) {
    // Handle creating task in specific column
    console.log('Creating task in column:', status);
    
    // Reset the form
    $('#form_main')[0].reset();
    
    // Pre-select the status if there's a status field
    if ($('select[name="status"]').length) {
        $('select[name="status"]').val(status);
    }
    
    // Show the modal
    $('#kt_modal_1').modal('show');
}

// Clear filters function
function clearKanbanFilters() {
    window.location.href = '{{ url("/kanban") }}';
}

// Show notification function
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 3000);
}
    </script>
@endsection