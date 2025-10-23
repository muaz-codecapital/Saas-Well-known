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
                    <i class="fas fa-project-diagram me-3"></i>{{__('Task Management / Timeline')}}
                </h2>
                <p class="text-muted mb-0 fs-6">{{__('Visualize project timelines and track progress over time')}}</p>
            </div>

            <!-- Action Buttons Row -->
            <div class="d-flex justify-content-between align-items-center">
                <!-- View Buttons (Left) -->
                <div class="d-flex gap-2">
                    <div class="btn-group" role="group" aria-label="View Types">
                        <a href="{{ route('admin.tasks', array_merge(request()->query(), ['action' => 'list'])) }}"
                           type="button"
                           class="btn {{ !request()->get('action') || request()->get('action') === 'list' ? 'btn-gradient-primary text-white shadow-sm' : 'btn-outline-primary' }} rounded-pill px-4 py-2 me-2">
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
                        <button type="button" class="btn btn-gradient-primary text-white dropdown-toggle rounded-pill px-3 py-2 shadow-sm" data-bs-toggle="dropdown" aria-expanded="false">
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
                                    <i class="fas fa-plus me-2 text-success"></i>{{__('Add Status')}}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Timeline/Gantt Chart -->
    <div class="card shadow-sm border-0">
        <div class="card-body py-4">
            <div class="row">
                <div class="col-12">
                    <svg id="gantt" style="width: 100%; height: 600px;"></svg>
                </div>
            </div>
        </div>
    </div>

    @include('tasks.add-new')
    @include('tasks.add-status-model')
@endsection

@section('style')
<style>
    /* Professional Gantt Chart Styling */
    #gantt {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* Gantt chart container styling */
    .gantt-container {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    /* Custom scrollbar for gantt chart */
    #gantt::-webkit-scrollbar {
        height: 8px;
    }

    #gantt::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    #gantt::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 4px;
    }

    #gantt::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    /* Custom Gantt popup styling */
    .gantt-popup {
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        padding: 1rem;
        min-width: 200px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .gantt-popup-title {
        font-weight: 600;
        font-size: 1rem;
        color: #2d3748;
        margin-bottom: 0.5rem;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 0.5rem;
    }

    .gantt-popup-progress {
        color: #667eea;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .gantt-popup-dates {
        color: #718096;
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
    }

    .gantt-popup-assignee {
        color: #4a5568;
        font-size: 0.875rem;
    }

    /* Gantt chart grid lines styling */
    .gantt .grid-row {
        stroke: #e2e8f0;
        stroke-width: 1;
    }

    .gantt .grid-header {
        fill: #f7fafc;
        stroke: #e2e8f0;
        stroke-width: 1;
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

        /* Responsive adjustments */
        @media (max-width: 768px) {
        #gantt {
            height: 500px !important;
        }

        .card-body {
            padding: 1rem !important;
        }

        .gantt-popup {
            min-width: 180px;
            padding: 0.75rem;
        }
    }

    @media (max-width: 576px) {
        #gantt {
            height: 400px !important;
        }

        .text-gradient {
            font-size: 1.5rem !important;
        }

        .gantt-popup {
            min-width: 160px;
            padding: 0.5rem;
        }

        .gantt-popup-title {
            font-size: 0.9rem;
        }
    }
</style>
@endsection

@section('script')
    <script>
    $(document).ready(function() {
        // Initialize Gantt Chart
        (function() {
            "use strict";
            var tasks = [
                    @foreach($tasks as $task)
                {
                    id: "{{$task->id}}",
                    name: '{{$task->subject}}',
                    start: '{{$task->start_date}}',
                    end: '{{$task->due_date}}',
                    progress: @if($task->status === 'completed') 100 @elseif($task->status === 'in_review') 80 @elseif($task->status === 'in_progress') 50 @else 10 @endif,
                    dependencies: '',
                    assignee: '{{$task->assignee->first_name ?? 'Unassigned'}} {{$task->assignee->last_name ?? ''}}',
                    workspace_type: '{{$task->workspace_type ?? 'general'}}'
                },
                     @endforeach
            ];

            // Initialize Gantt Chart with professional styling
            var gantt = new Gantt('#gantt', tasks, {
                on_click: function (task) {
                    console.log('Task clicked:', task);
                    // You can add task detail modal or navigation here
                },
                on_date_change: function(task, start, end) {
                    console.log('Date changed:', task, start, end);
                    // You can add date update functionality here
                },
                on_progress_change: function(task, progress) {
                    console.log('Progress changed:', task, progress);
                    // You can add progress update functionality here
                },
                on_view_change: function(mode) {
                    console.log('View mode changed:', mode);
                },
                custom_popup_html: function(task) {
                    return `
                        <div class="gantt-popup">
                            <div class="gantt-popup-title">${task.name}</div>
                            <div class="gantt-popup-progress">Progress: ${task.progress}%</div>
                            <div class="gantt-popup-dates">${task.start} - ${task.end}</div>
                            <div class="gantt-popup-assignee">Assignee: ${task.assignee}</div>
                        </div>
                    `;
                }
            });

            // Set initial view mode to month for better timeline visualization
            gantt.change_view_mode('Month');

            console.log('Gantt chart initialized successfully');
        })();
    });
    </script>
        @endsection
