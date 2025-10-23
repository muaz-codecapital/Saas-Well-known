<div class="card-body pt-0">
    <!-- Enhanced Stats Cards -->
    <div class="row mb-4">
        @php
            $statusCounts = $tasks->groupBy('status')->map->count();
            $totalTasks = $tasks->count();
            $completedTasks = $tasks->where('status', 'completed')->count();
            $inProgressTasks = $tasks->where('status', 'in_progress')->count();
            $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
        @endphp
        
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">{{__('Total Tasks')}}</p>
                                <h5 class="font-weight-bolder mb-0">{{ $totalTasks }}</h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="fas fa-tasks text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">{{__('In Progress')}}</p>
                                <h5 class="font-weight-bolder mb-0">{{ $inProgressTasks }}</h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                <i class="fas fa-play-circle text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">{{__('Completed')}}</p>
                                <h5 class="font-weight-bolder mb-0">{{ $completedTasks }}</h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                <i class="fas fa-check-circle text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">{{__('Completion Rate')}}</p>
                                <h5 class="font-weight-bolder mb-0">{{ $completionRate }}%</h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                <i class="fas fa-chart-pie text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--begin::Table-->
    <div class="table-responsive" style="overflow-x: visible !important;">
    <table class="table align-items-center mb-0" id="cloudonex_table">
        <!--begin::Table head-->
            <thead class="thead-light">
        <!--begin::Table row-->
        <tr>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">{{__('Task Details')}}</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">{{__('Assigned To')}}</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">{{__('Priority')}}</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">{{__('Dates')}}</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">{{__('Status')}}</th>
                @if(is_null($workspace_type))
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">{{__('Workspace')}}</th>
            @endif
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">{{__('Progress')}}</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-end">{{__('Actions')}}</th>
        </tr>
        </thead>

        <tbody>
        <!--begin::Table row-->

        @foreach( $tasks as  $task)
            <tr class="task-row" data-task-id="{{ $task->id }}">
                <!-- Task Details -->
                <td class="ps-3">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-{{ $task->status_icon }} text-{{ $task->status_color }} fs-5"></i>
                                    </div>
                        <div>
                            <h6 class="text-sm font-weight-bold mb-1">{{ $task->subject }}</h6>
                            @if($task->description)
                                <p class="text-xs text-muted mb-0">{{ Str::limit($task->description, 60) }}</p>
                            @endif
                            @if($task->tags && count($task->tags) > 0)
                                <div class="mt-1">
                                    @foreach(array_slice($task->tags, 0, 3) as $tag)
                                        <span class="badge badge-sm bg-gradient-secondary me-1">{{ $tag }}</span>
                                    @endforeach
                                    @if(count($task->tags) > 3)
                                        <span class="badge badge-sm bg-light text-dark">+{{ count($task->tags) - 3 }}</span>
                            @endif
                        </div>
                            @endif
                        </div>
                    </div>
                </td>

                <!-- Assigned To -->
                <td>
                    <div class="d-flex align-items-center">
                        @php
                            $assignedUser = $task->assignee ?? $task->contact;
                        @endphp
                        @if($assignedUser)
                            <div class="avatar avatar-sm rounded-circle me-2">
                                @if(!empty($assignedUser->photo))
                                    <img src="{{PUBLIC_DIR}}/uploads/{{$assignedUser->photo}}" alt="{{ $assignedUser->first_name }}" class="rounded-circle">
                                @else
                                    <div class="avatar avatar-sm rounded-circle bg-gradient-{{ $task->status_color }} d-flex align-items-center justify-content-center">
                                        <span class="text-white text-xs font-weight-bold">
                                            {{ strtoupper(substr($assignedUser->first_name, 0, 1)) }}{{ strtoupper(substr($assignedUser->last_name, 0, 1)) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <p class="text-xs font-weight-bold mb-0">{{ $assignedUser->first_name }} {{ $assignedUser->last_name }}</p>
                                <p class="text-xs text-muted mb-0">{{ $assignedUser->email }}</p>
                            </div>
                        @else
                            <span class="text-xs text-muted">{{__('Unassigned')}}</span>
                        @endif
                    </div>
                </td>

                <!-- Priority -->
                <td>
                    <span class="badge badge-sm bg-gradient-{{ $task->priority_color }}">
                        {{ $task->priority_label }}
                    </span>
                </td>

                <!-- Dates -->
                <td>
                    <div class="d-flex flex-column">
                        @if($task->start_date)
                            <p class="text-xs font-weight-bold mb-1">
                                <i class="fas fa-play text-info me-1"></i>
                                {{ $task->start_date->format('M d, Y') }}
                            </p>
                        @endif
                        @if($task->due_date)
                            <p class="text-xs font-weight-bold mb-0 {{ $task->due_date->isPast() && $task->status !== 'completed' ? 'text-danger' : 'text-dark' }}">
                                <i class="fas fa-flag text-warning me-1"></i>
                                {{ $task->due_date->format('M d, Y') }}
                                @if($task->due_date->isPast() && $task->status !== 'completed')
                                    <i class="fas fa-exclamation-triangle text-danger ms-1" title="Overdue"></i>
                        @endif
                    </p>
                        @endif
                    </div>
                </td>

                <!-- Status with Quick Actions -->
                <td class="position-relative">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-gradient-{{ $task->status_color }} dropdown-toggle quick-status-btn"
                                type="button"
                                data-bs-toggle="dropdown"
                                data-bs-auto-close="outside"
                                aria-expanded="false"
                                data-task-id="{{ $task->id }}">
                            <i class="fas fa-{{ $task->status_icon }} me-1"></i>
                            {{ $task->status_label }}
                        </button>
                        <ul class="dropdown-menu shadow-sm dropdown-menu-end">
                            @foreach($taskStatuses as $statusKey => $status)
                                @if($statusKey !== $task->status)
                                    <li>
                                        <a class="dropdown-item quick-status-change d-flex align-items-center"
                                           href="#"
                                           data-task-id="{{ $task->id }}"
                                           data-status="{{ $statusKey }}">
                                            <i class="fas fa-{{ $status['icon'] }} text-{{ $status['class'] }} me-2"></i>
                                            {{ $status['label'] }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </td>

                <!-- Workspace Type -->
                @if(is_null($workspace_type))
                <td>
                    @if($task->workspace_type)
                        <div class="d-flex align-items-center">
                            <i class="ni ni-{{ config('task.workspace_types.' . $task->workspace_type . '.icon', 'folder-17') }} me-2"
                               style="color: {{ config('task.workspace_types.' . $task->workspace_type . '.color', '#6c757d') }}"></i>
                            <span class="text-xs font-weight-bold">{{ $task->workspace_type_label }}</span>
                        </div>
                    @elseif($task->group)
                        <span class="badge badge-sm bg-gradient-info">
                        {{ Str::title($task->group) }}
                    </span>
                    @else
                        <span class="text-xs text-muted">{{__('No workspace')}}</span>
                    @endif
                </td>
                @endif

                <!-- Progress -->
                <td>
                    <div class="d-flex align-items-center">
                        <div class="progress progress-sm w-75 me-2">
                            <div class="progress-bar bg-gradient-{{ $task->status_color }}" 
                                 role="progressbar" 
                                 style="width: {{ $task->progress ?? 0 }}%" 
                                 aria-valuenow="{{ $task->progress ?? 0 }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100"></div>
                        </div>
                        <span class="text-xs font-weight-bold">{{ $task->progress ?? 0 }}%</span>
                    </div>
                </td>

                <!-- Actions -->
                <td class="text-end">
                    <div class="dropdown">
                        <button class="btn btn-link text-secondary mb-0 p-2"
                                type="button"
                                data-bs-toggle="dropdown"
                                data-bs-auto-close="outside"
                                aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li>
                                <a class="dropdown-item category_edit d-flex align-items-center"
                                   href="#"
                                   data-id="{{ $task->id }}"
                                   onclick="closeActionsDropdown(this); return false;">
                                    <i class="fas fa-edit text-info me-2"></i>
                                    {{__('Edit Task')}}
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center text-danger"
                                   href="#"
                                   onclick="confirmDelete({{ $task->id }}, '{{ addslashes($task->subject) }}'); return false;">
                                    <i class="fas fa-trash text-danger me-2"></i>
                                    {{__('Delete')}}
                                </a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        @endforeach

        </tbody>
        <!--end::Table body-->
    </table>
    <!--end::Table-->

    </div>

    @include('tasks.add-new')
    @include('tasks.add-status-model')
</div>


