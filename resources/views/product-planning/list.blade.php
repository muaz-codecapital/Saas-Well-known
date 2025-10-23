@extends('layouts.primary')

@section('content')
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <!-- Centered Heading -->
            <div class="text-center mb-4">
                <h2 class="mb-1 text-gradient text-primary fw-bold">
                    <i class="fas fa-project-diagram me-3"></i>{{__('Product Planning')}}
                </h2>
                <p class="text-muted mb-0 fs-6">{{__('Manage and track your product development initiatives')}}</p>
            </div>
            
            <!-- Action Buttons Row -->
            <div class="d-flex justify-content-between align-items-center">
                <!-- View Buttons (Left) -->
                <div class="d-flex gap-2">
                    <div class="btn-group" role="group" aria-label="View Types">
                        <a href="{{ route('admin.product-planning.list', array_merge(request()->query(), ['view_type' => 'list'])) }}"
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

                        <a href="{{ route('admin.product-planning.kanban', request()->query()) }}"
                           type="button"
                           class="btn {{ request()->routeIs('admin.product-planning.kanban') ? 'btn-gradient-primary text-white shadow-sm' : 'btn-outline-primary' }} rounded-pill px-4 py-2 me-2">
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
                                <a class="dropdown-item" href="#" onclick="showCreateModal()">
                                    <i class="fas fa-plus me-2 text-primary"></i>{{__('Add Item')}}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addProductModal">
                                    <i class="fas fa-box me-2 text-info"></i>{{__('Add Product')}}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addDepartmentModal">
                                    <i class="fas fa-building me-2 text-warning"></i>{{__('Add Department')}}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addMilestoneModal">
                                    <i class="fas fa-flag me-2 text-success"></i>{{__('Add Milestone')}}
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-primary dropdown-toggle rounded-pill px-4 py-2 shadow-sm" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-filter me-2"></i>{{__('Filters')}}
                        </button>
                        <div class="dropdown-menu dropdown-menu-end p-3" style="min-width: 350px;">
                            <form method="GET" action="{{ route('admin.product-planning.list') }}" id="filterForm">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">{{__('Status')}}</label>
                                        <select class="form-select" name="status">
                                            <option value="">{{__('All Statuses')}}</option>
                                            @foreach(config('product_planning.statuses') as $key => $status)
                                                <option value="{{ $key }}" {{ request()->status === $key ? 'selected' : '' }}>
                                                    {{ $status['label'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">{{__('Priority')}}</label>
                                        <select class="form-select" name="priority">
                                            <option value="">{{__('All Priorities')}}</option>
                                            @foreach(config('product_planning.priorities') as $key => $priority)
                                                <option value="{{ $key }}" {{ request()->priority === $key ? 'selected' : '' }}>
                                                    {{ $priority['label'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">{{__('Product')}}</label>
                                        <select class="form-select" name="product_id">
                                            <option value="">{{__('All Products')}}</option>
                                            @foreach($products ?? [] as $product)
                                                <option value="{{ $product->id }}" {{ (request()->product_id == $product->id) ? 'selected' : '' }}>
                                                    {{ $product->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">{{__('Department')}}</label>
                                        <select class="form-select" name="department_id">
                                            <option value="">{{__('All Departments')}}</option>
                                            @foreach($departments ?? [] as $department)
                                                <option value="{{ $department->id }}" {{ (request()->department_id == $department->id) ? 'selected' : '' }}>
                                                    {{ $department->name }}
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
                                        <input type="text" class="form-control" name="search" value="{{ request()->search }}" placeholder="{{__('Search items...')}}">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between gap-2">
                                    <button type="submit" class="btn btn-primary btn-sm">{{__('Apply Filters')}}</button>
                                    <a href="{{ route('admin.product-planning.list') }}" class="btn btn-outline-secondary btn-sm">{{__('Clear')}}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <div class="avatar avatar-lg bg-gradient-primary rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fas fa-clipboard-list text-white" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <h3 class="text-gradient text-primary mb-1">{{ $items->total() }}</h3>
                    <p class="text-muted mb-0">{{__('Total Items')}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <div class="avatar avatar-lg bg-gradient-success rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fas fa-check-circle text-white" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <h3 class="text-gradient text-success mb-1">{{ $items->where('status', 'released')->count() }}</h3>
                    <p class="text-muted mb-0">{{__('Released')}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <div class="avatar avatar-lg bg-gradient-warning rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fas fa-clock text-white" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <h3 class="text-gradient text-warning mb-1">{{ $items->where('status', 'in_development')->count() }}</h3>
                    <p class="text-muted mb-0">{{__('In Progress')}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <div class="avatar avatar-lg bg-gradient-info rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fas fa-users text-white" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <h3 class="text-gradient text-info mb-1">{{ $items->whereNotNull('assigned_to')->count() }}</h3>
                    <p class="text-muted mb-0">{{__('Assigned')}}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-gradient-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm bg-white bg-opacity-20 rounded-circle me-3">
                        <i class="fas fa-list text-white"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 text-white">{{__('Product Planning Items')}}</h5>
                        <small class="text-white-50">{{__('Manage your product development pipeline')}}</small>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="dropdown">
                        <button class="btn btn-white btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-sort me-1"></i>{{__('Sort By')}}: {{ config('product_planning.sort_options')[request()->sort_by ?? 'created_at'] ?? 'Date Created' }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @foreach(config('product_planning.sort_options') as $key => $label)
                                <li>
                                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="{{ request()->fullUrlWithQuery(array_merge(request()->query(), ['sort_by' => $key, 'sort_order' => ((request()->sort_by === $key && request()->sort_order === 'asc') ? 'desc' : 'asc')])) }}">
                                        {{ $label }}
                                        @if(request()->sort_by === $key)
                                            <div>
                                                <i class="fa fa-check text-primary me-1"></i>
                                                @if(request()->sort_order === 'desc')
                                                    <i class="fa fa-sort-down text-muted"></i>
                                                @else
                                                    <i class="fa fa-sort-up text-muted"></i>
                                                @endif
                                            </div>
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </div>

        <div class="card-body p-0">
            @if($items->count() > 0)
                <!-- Modern Card-based Layout -->
                <div class="p-4">
                    @foreach($items as $item)
                        <div class="card border-0 shadow-sm mb-4 hover-lift">
                            <div class="card-body p-4">
                                <div class="row align-items-center">
                                    <!-- Title and Description -->
                                    <div class="col-lg-4 col-md-6 mb-3 mb-md-0">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-grow-1">
                                                <h5 class="mb-2 fw-bold text-dark">{{ $item->title }}</h5>
                                                @if($item->description)
                                                    <p class="text-muted mb-2 small">{{ Str::limit($item->description, 80) }}</p>
                                                @endif
                                                @if($item->tags)
                                                    <div class="d-flex flex-wrap gap-1">
                                                        @foreach($item->tags as $tag)
                                                            <span class="badge bg-light text-dark border px-2 py-1 small">{{ $tag }}</span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Status and Priority -->
                                    <div class="col-lg-2 col-md-3 mb-3 mb-md-0">
                                        <div class="d-flex flex-column gap-2">
                                            <span class="badge bg-{{ $item->status_color }}-light text-{{ $item->status_color }} px-3 py-2 fw-semibold">
                                                {{ $item->status_label }}
                                            </span>
                                            <span class="badge bg-{{ config('product_planning.priorities')[$item->priority]['class'] }}-light text-{{ config('product_planning.priorities')[$item->priority]['class'] }} px-3 py-2 fw-semibold">
                                                {{ $item->priority_label }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Product and Department -->
                                    <div class="col-lg-2 col-md-3 mb-3 mb-md-0">
                                        <div class="d-flex flex-column gap-2">
                                            @if($item->product)
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-box text-info me-2"></i>
                                                    <span class="text-dark fw-medium">{{ $item->product->name }}</span>
                                                </div>
                                            @else
                                                <span class="text-muted">No Product</span>
                                            @endif
                                            @if($item->department)
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-building text-warning me-2"></i>
                                                    <span class="text-dark fw-medium">{{ $item->department->name }}</span>
                                                </div>
                                            @else
                                                <span class="text-muted">No Department</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Assigned User -->
                                    <div class="col-lg-2 col-md-6 mb-3 mb-md-0">
                                        @if($item->assignedUser)
                                            <div class="d-flex align-items-center">
                                                @if($item->assignedUser->photo)
                                                    <img src="{{ PUBLIC_DIR }}/uploads/{{ $item->assignedUser->photo }}" class="avatar avatar-md rounded-circle me-3 border-2 border-white shadow-sm" alt="">
                                                @else
                                                    <div class="avatar avatar-md rounded-circle bg-gradient-primary me-3 border-2 border-white shadow-sm d-flex align-items-center justify-content-center">
                                                        <span class="text-white fw-bold">{{ substr($item->assignedUser->first_name, 0, 1) }}{{ substr($item->assignedUser->last_name, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-semibold text-dark">{{ $item->assignedUser->first_name }} {{ $item->assignedUser->last_name }}</div>
                                                    <small class="text-muted">Assigned</small>
                                                </div>
                                            </div>
                                        @else
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-md rounded-circle bg-light me-3 border-2 border-white shadow-sm d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-user-plus text-muted"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-semibold text-muted">{{__('Unassigned')}}</div>
                                                    <small class="text-muted">No one assigned</small>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Due Date and Progress -->
                                    <div class="col-lg-2 col-md-6 mb-3 mb-md-0">
                                        <div class="d-flex flex-column gap-2">
                                            @if($item->due_date)
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-calendar-alt {{ $item->due_date->isPast() && $item->status !== 'released' ? 'text-danger' : 'text-primary' }} me-2"></i>
                                                    <div>
                                                        <div class="fw-semibold {{ $item->due_date->isPast() && $item->status !== 'released' ? 'text-danger' : 'text-dark' }}">
                                                            {{ $item->due_date->format('M d, Y') }}
                                                        </div>
                                                        @if($item->due_date->isPast() && $item->status !== 'released')
                                                            <small class="text-danger">{{__('Overdue')}}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-calendar-alt text-muted me-2"></i>
                                                    <span class="text-muted">No due date</span>
                                                </div>
                                            @endif
                                            
                                            <!-- Progress Circle -->
                                            <div class="d-flex align-items-center">
                                                <div class="progress-circle me-3">
                                                    <svg class="progress-ring" width="40" height="40">
                                                        <circle class="progress-ring-circle" stroke="#e9ecef" stroke-width="3" fill="transparent" r="16" cx="20" cy="20"/>
                                                        <circle class="progress-ring-circle" stroke="{{ $item->progress >= 100 ? '#28a745' : ($item->progress >= 50 ? '#007bff' : '#ffc107') }}" stroke-width="3" fill="transparent" r="16" cx="20" cy="20" style="stroke-dasharray: {{ 2 * 3.14159 * 16 }}; stroke-dashoffset: {{ 2 * 3.14159 * 16 * (1 - $item->progress / 100) }};"/>
                                                    </svg>
                                                    <div class="progress-text">{{ $item->progress }}%</div>
                                                </div>
                                                <div>
                                                    <div class="fw-semibold text-dark">{{ $item->progress }}%</div>
                                                    <small class="text-muted">Complete</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons Row -->
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="button" class="btn btn-outline-primary btn-lg px-4 py-2" onclick="editItem({{ $item->id }})" title="{{__('Edit')}}">
                                                <i class="fas fa-edit me-2"></i>{{__('Edit')}}
                                            </button>
                                            <button type="button" class="btn btn-outline-info btn-lg px-4 py-2" onclick="viewItem({{ $item->id }})" title="{{__('View')}}">
                                                <i class="fas fa-eye me-2"></i>{{__('View')}}
                                            </button>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-secondary btn-lg px-4 py-2 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v me-2"></i>{{__('More')}}
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end shadow">
                                                    <li><h6 class="dropdown-header">{{__('Change Status')}}</h6></li>
                                                    <li><a class="dropdown-item" href="#" onclick="updateStatus({{ $item->id }}, 'idea')"><i class="fas fa-lightbulb me-2 text-info"></i>{{__('Mark as Idea')}}</a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="updateStatus({{ $item->id }}, 'validation')"><i class="fas fa-search me-2 text-warning"></i>{{__('Mark as Validation')}}</a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="updateStatus({{ $item->id }}, 'in_development')"><i class="fas fa-code me-2 text-primary"></i>{{__('Mark as In Development')}}</a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="updateStatus({{ $item->id }}, 'testing')"><i class="fas fa-vial me-2 text-secondary"></i>{{__('Mark as Testing')}}</a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="updateStatus({{ $item->id }}, 'released')"><i class="fas fa-check-circle me-2 text-success"></i>{{__('Mark as Released')}}</a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="updateStatus({{ $item->id }}, 'archived')"><i class="fas fa-archive me-2 text-dark"></i>{{__('Mark as Archived')}}</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#" onclick="deleteItem({{ $item->id }})"><i class="fas fa-trash me-2"></i>{{__('Delete')}}</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center p-4">
                    {{ $items->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="avatar avatar-xl bg-gradient-primary rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center">
                        <i class="fas fa-clipboard-list text-white" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="text-muted fw-bold">{{__('No Items Found')}}</h4>
                    <p class="text-muted mb-4">{{__('Start by creating your first product planning item.')}}</p>
                    <button class="btn btn-gradient-primary text-white px-4 py-2 rounded-pill shadow-sm" onclick="showCreateModal()">
                        <i class="fas fa-plus me-2"></i>{{__('Create First Item')}}
                    </button>
                </div>
            @endif
        </div>
    </div>

    <style>
        .progress-circle {
            position: relative;
            display: inline-block;
        }

        .progress-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 0.75rem;
            font-weight: bold;
            color: #6c757d;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

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

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        }

        .avatar {
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-xs {
            width: 1.5rem;
            height: 1.5rem;
            font-size: 0.75rem;
        }

        .avatar-sm {
            width: 2rem;
            height: 2rem;
            font-size: 0.875rem;
        }

        .avatar-md {
            width: 2.5rem;
            height: 2.5rem;
            font-size: 1rem;
        }

        .avatar-lg {
            width: 3rem;
            height: 3rem;
            font-size: 1.125rem;
        }

        .avatar-xl {
            width: 4rem;
            height: 4rem;
            font-size: 1.5rem;
        }

        .progress-ring {
            transform: rotate(-90deg);
        }

        .progress-ring-circle {
            transition: stroke-dashoffset 0.35s;
            transform-origin: 50% 50%;
        }

        .swal-wide {
            width: 600px !important;
        }

        .swal-wide .swal2-html-container {
            text-align: left !important;
        }

        .swal-wide-professional {
            width: 800px !important;
            max-width: 90vw !important;
        }

        .swal-wide-professional .swal2-html-container {
            text-align: left !important;
            padding: 0 !important;
        }

        .swal-wide-professional .swal2-popup {
            padding: 2rem !important;
        }

        .progress-circle {
            position: relative;
            display: inline-block;
        }

        .progress-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 0.75rem;
            font-weight: bold;
            color: #333;
        }

        .progress-ring {
            transform: rotate(-90deg);
        }

        .progress-ring-circle {
            transition: stroke-dashoffset 0.35s;
            transform-origin: 50% 50%;
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #fcb045 0%, #fd1d1d 100%);
        }

        .bg-gradient-info {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .bg-gradient-indigo {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .text-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .avatar {
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-sm {
            width: 2rem;
            height: 2rem;
            font-size: 0.75rem;
        }

        .avatar-lg {
            width: 4rem;
            height: 4rem;
            font-size: 1.5rem;
        }

        .avatar-xl {
            width: 6rem;
            height: 6rem;
            font-size: 2.5rem;
        }

        .border-3 {
            border-width: 3px !important;
        }

        .bg-opacity-20 {
            background-color: rgba(255, 255, 255, 0.2) !important;
        }

        .bg-white-50 {
            background-color: rgba(255, 255, 255, 0.5) !important;
        }
    </style>

    <!-- Create/Edit Modal -->
    <div class="modal fade" id="itemModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">{{__('Add Product Planning Item')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="itemForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{__('Title')}} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="title" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{__('Status')}} <span class="text-danger">*</span></label>
                                <select class="form-select" name="status" required>
                                    @foreach(config('product_planning.statuses') as $key => $status)
                                        <option value="{{ $key }}">{{ $status['label'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{__('Priority')}} <span class="text-danger">*</span></label>
                                <select class="form-select" name="priority" required>
                                    @foreach(config('product_planning.priorities') as $key => $priority)
                                        <option value="{{ $key }}">{{ $priority['label'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{__('Product')}}</label>
                                <select class="form-select" name="product_id">
                                    <option value="">{{__('Select Product')}}</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{__('Department')}}</label>
                                <select class="form-select" name="department_id">
                                    <option value="">{{__('Select Department')}}</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{__('Assigned To')}}</label>
                                <select class="form-select" name="assigned_to">
                                    <option value="">{{__('Select User')}}</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{__('Start Date')}}</label>
                                <input type="date" class="form-control" name="start_date">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{__('Due Date')}}</label>
                                <input type="date" class="form-control" name="due_date">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{__('Estimated Hours')}}</label>
                                <input type="number" class="form-control" name="estimated_hours" min="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{__('Progress')}} (%)</label>
                                <input type="number" class="form-control" name="progress" min="0" max="100" value="0">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{__('Description')}}</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{__('Tags')}}</label>
                            <input type="text" class="form-control" name="tags" id="tagsInput" placeholder="{{__('Add tags...')}}">
                            <small class="form-text text-muted">{{__('Press Enter to add tags')}}</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Cancel')}}</button>
                        <button type="submit" class="btn btn-primary" id="saveBtn">
                            <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                            {{__('Save')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">{{__('Add New Product')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addProductForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">{{__('Product Name')}} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{__('Description')}}</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{__('Version')}}</label>
                            <input type="text" class="form-control" name="version" placeholder="e.g., 1.0.0">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Cancel')}}</button>
                        <button type="submit" class="btn btn-primary" id="addProductBtn">
                            <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                            {{__('Save Product')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Department Modal -->
    <div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDepartmentModalLabel">{{__('Add New Department')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addDepartmentForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">{{__('Department Name')}} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{__('Description')}}</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{__('Manager')}}</label>
                            <select class="form-select" name="manager_id">
                                <option value="">{{__('Select Manager')}}</option>
                                @foreach($users ?? [] as $user)
                                    <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Cancel')}}</button>
                        <button type="submit" class="btn btn-primary" id="addDepartmentBtn">
                            <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                            {{__('Save Department')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Milestone Modal -->
    <div class="modal fade" id="addMilestoneModal" tabindex="-1" aria-labelledby="addMilestoneModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMilestoneModalLabel">{{__('Add New Milestone')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addMilestoneForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">{{__('Product')}} <span class="text-danger">*</span></label>
                            <select class="form-select" name="product_id" required>
                                <option value="">{{__('Select Product')}}</option>
                                @foreach($products ?? [] as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{__('Milestone Title')}} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{__('Description')}}</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{__('Start Date')}}</label>
                                <input type="date" class="form-control" name="start_date">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{__('Due Date')}}</label>
                                <input type="date" class="form-control" name="due_date">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Cancel')}}</button>
                        <button type="submit" class="btn btn-primary" id="addMilestoneBtn">
                            <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                            {{__('Save Milestone')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
let currentItemId = null;
let tagify = null;

$(document).ready(function() {
    // Initialize tagify for tags input
    const tagsInput = document.getElementById('tagsInput');
    if (tagsInput) {
        tagify = new Tagify(tagsInput);
    }

    $('#itemForm').on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const data = {};
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }

        // Add tags if tagify is initialized
        if (tagify) {
            data.tags = tagify.value.map(tag => tag.value);
        }

        const isEdit = currentItemId !== null;
        const url = isEdit ? `/admin/product-planning/${currentItemId}` : '/admin/product-planning';
        const method = isEdit ? 'PUT' : 'POST';

        $('#saveBtn').prop('disabled', true);
        $('#saveBtn .spinner-border').removeClass('d-none');

        $.ajax({
            url: url,
            method: method,
            data: data,
            headers: {
                'X-HTTP-Method-Override': method,
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#itemModal').modal('hide');
                    location.reload();
                } else {
                    alert('Error: ' + (response.message || 'Something went wrong'));
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
                alert('Error: ' + errors);
            },
            complete: function() {
                $('#saveBtn').prop('disabled', false);
                $('#saveBtn .spinner-border').addClass('d-none');
            }
        });
    });
});

function showCreateModal() {
    currentItemId = null;
    $('#modalTitle').text('{{__("Add Product Planning Item")}}');
    $('#itemForm')[0].reset();
    if (tagify) tagify.removeAllTags();
    $('#itemModal').modal('show');
}

function editItem(id) {
    $.get(`/admin/product-planning/${id}/json`)
        .done(function(data) {
            currentItemId = id;
            $('#modalTitle').text('{{__("Edit Product Planning Item")}}');
            $('input[name="title"]').val(data.title);
            $('select[name="status"]').val(data.status);
            $('select[name="priority"]').val(data.priority);
            $('select[name="product_id"]').val(data.product_id);
            $('select[name="department_id"]').val(data.department_id);
            $('select[name="assigned_to"]').val(data.assigned_to);
            $('input[name="start_date"]').val(data.start_date ? data.start_date.split(' ')[0] : '');
            $('input[name="due_date"]').val(data.due_date ? data.due_date.split(' ')[0] : '');
            $('input[name="estimated_hours"]').val(data.estimated_hours);
            $('input[name="progress"]').val(data.progress);
            $('textarea[name="description"]').val(data.description);

            if (tagify && data.tags) {
                tagify.removeAllTags();
                tagify.addTags(data.tags);
            }

            $('#itemModal').modal('show');
        })
        .fail(function() {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Error loading item data'
            });
        });
}

function viewItem(id) {
    $.get(`/admin/product-planning/${id}/json`)
        .done(function(data) {
            let userHtml = '';
            if (data.assigned_user) {
                const user = data.assigned_user;
                if (user.photo) {
                    userHtml = `<div class="d-flex align-items-center">
                        <img src="{{PUBLIC_DIR}}/uploads/${user.photo}" class="avatar avatar-md rounded-circle me-3 border-2 border-white shadow-sm" alt="">
                        <div>
                            <div class="fw-semibold text-dark">${user.first_name} ${user.last_name}</div>
                            <small class="text-muted">Assigned User</small>
                        </div>
                    </div>`;
                } else {
                    userHtml = `<div class="d-flex align-items-center">
                        <div class="avatar avatar-md rounded-circle bg-gradient-primary me-3 border-2 border-white shadow-sm d-flex align-items-center justify-content-center">
                            <span class="text-white fw-bold">${user.first_name[0]}${user.last_name[0]}</span>
                        </div>
                        <div>
                            <div class="fw-semibold text-dark">${user.first_name} ${user.last_name}</div>
                            <small class="text-muted">Assigned User</small>
                        </div>
                    </div>`;
                }
            } else {
                userHtml = `<div class="d-flex align-items-center">
                    <div class="avatar avatar-md rounded-circle bg-light me-3 border-2 border-white shadow-sm d-flex align-items-center justify-content-center">
                        <i class="fas fa-user-plus text-muted"></i>
                    </div>
                    <div>
                        <div class="fw-semibold text-muted">{{__('Unassigned')}}</div>
                        <small class="text-muted">No one assigned</small>
                    </div>
                </div>`;
            }

            let progressHtml = '';
            if (data.progress !== undefined) {
                progressHtml = `
                    <div class="d-flex align-items-center">
                        <div class="progress-circle me-3">
                            <svg class="progress-ring" width="50" height="50">
                                <circle class="progress-ring-circle" stroke="#e9ecef" stroke-width="4" fill="transparent" r="20" cx="25" cy="25"/>
                                <circle class="progress-ring-circle" stroke="${data.progress >= 100 ? '#28a745' : (data.progress >= 50 ? '#007bff' : '#ffc107')}" stroke-width="4" fill="transparent" r="20" cx="25" cy="25" style="stroke-dasharray: ${2 * 3.14159 * 20}; stroke-dashoffset: ${2 * 3.14159 * 20 * (1 - data.progress / 100)};"/>
                            </svg>
                            <div class="progress-text">${data.progress}%</div>
                        </div>
                        <div>
                            <div class="fw-bold text-dark fs-5">${data.progress}%</div>
                            <small class="text-muted">Complete</small>
                        </div>
                    </div>
                `;
            }

            let tagsHtml = '';
            if (data.tags && data.tags.length > 0) {
                tagsHtml = `
                    <div class="mb-3">
                        <h6 class="fw-semibold text-dark mb-2">{{__('Tags')}}</h6>
                        <div class="d-flex flex-wrap gap-2">
                            ${data.tags.map(tag => `<span class="badge bg-light text-dark border px-3 py-2">${tag}</span>`).join('')}
                        </div>
                    </div>
                `;
            }

            let content = `
                <div class="container-fluid">
                    <!-- Header Section -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="flex-grow-1">
                                    <h3 class="fw-bold text-dark mb-2">${data.title}</h3>
                                    <p class="text-muted mb-0">${data.description || 'No description provided'}</p>
                                </div>
                                <div class="d-flex flex-column gap-2">
                                    <span class="badge bg-${data.status_color}-light text-${data.status_color} px-3 py-2 fw-semibold">
                                        ${data.status_label}
                                    </span>
                                    <span class="badge bg-${data.priority_color}-light text-${data.priority_color} px-3 py-2 fw-semibold">
                                        ${data.priority_label}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="fw-semibold text-dark mb-3">{{__('Project Information')}}</h6>
                                <div class="card border-0 bg-light">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-box text-info me-2"></i>
                                                    <div>
                                                        <small class="text-muted d-block">{{__('Product')}}</small>
                                                        <span class="fw-semibold text-dark">${data.product ? data.product.name : '{{__("Not assigned")}}'}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-building text-warning me-2"></i>
                                                    <div>
                                                        <small class="text-muted d-block">{{__('Department')}}</small>
                                                        <span class="fw-semibold text-dark">${data.department ? data.department.name : '{{__("Not assigned")}}'}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="fw-semibold text-dark mb-3">{{__('Assigned User')}}</h6>
                                <div class="card border-0 bg-light">
                                    <div class="card-body p-3">
                                        ${userHtml}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="fw-semibold text-dark mb-3">{{__('Timeline')}}</h6>
                                <div class="card border-0 bg-light">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-play text-success me-2"></i>
                                                    <div>
                                                        <small class="text-muted d-block">{{__('Start Date')}}</small>
                                                        <span class="fw-semibold text-dark">${data.start_date ? data.start_date.split(' ')[0] : '{{__("Not set")}}'}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-flag text-danger me-2"></i>
                                                    <div>
                                                        <small class="text-muted d-block">{{__('Due Date')}}</small>
                                                        <span class="fw-semibold text-dark">${data.due_date ? data.due_date.split(' ')[0] : '{{__("Not set")}}'}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="fw-semibold text-dark mb-3">{{__('Progress')}}</h6>
                                <div class="card border-0 bg-light">
                                    <div class="card-body p-3">
                                        ${progressHtml}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tags Section -->
                    ${tagsHtml}

                    <!-- Additional Information -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card border-0 bg-light">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-clock text-primary me-2"></i>
                                                <div>
                                                    <small class="text-muted d-block">{{__('Estimated Hours')}}</small>
                                                    <span class="fw-semibold text-dark">${data.estimated_hours || '{{__("Not set")}}'}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-user text-info me-2"></i>
                                                <div>
                                                    <small class="text-muted d-block">{{__('Created By')}}</small>
                                                    <span class="fw-semibold text-dark">${data.creator ? data.creator.first_name + ' ' + data.creator.last_name : '{{__("Unknown")}}'}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-calendar text-warning me-2"></i>
                                                <div>
                                                    <small class="text-muted d-block">{{__('Created At')}}</small>
                                                    <span class="fw-semibold text-dark">${data.created_at ? data.created_at.split(' ')[0] : '{{__("Unknown")}}'}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            Swal.fire({
                title: '{{__("Item Details")}}',
                html: content,
                width: '800px',
                showCloseButton: true,
                showConfirmButton: false,
                customClass: {
                    popup: 'swal-wide-professional'
                }
            });
        })
        .fail(function() {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Error loading item data'
            });
        });
}

function updateStatus(id, status) {
    Swal.fire({
        title: '{{__("Are you sure?")}}',
        text: '{{__("Are you sure you want to update the status?")}}',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0d6efd',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '{{__("Yes, update it!")}}',
        cancelButtonText: '{{__("Cancel")}}',
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading state
            Swal.fire({
                title: '{{__("Updating...")}}',
                text: '{{__("Please wait while we update the status.")}}',
                allowEscapeKey: false,
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: `/admin/product-planning/${id}/status`,
                method: 'PATCH',
                data: { status: status },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: '{{__("Success!")}}',
                            text: '{{__("Status updated successfully.")}}',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: '{{__("Error!")}}',
                            text: response.message || '{{__("Failed to update the status.")}}',
                            icon: 'error'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: '{{__("Error!")}}',
                        text: '{{__("Failed to update the status. Please try again.")}}',
                        icon: 'error'
                    });
                }
            });
        }
    });
}

function deleteItem(id) {
    Swal.fire({
        title: '{{__("Are you sure?")}}',
        text: '{{__("You will not be able to recover this item after deleting!")}}',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '{{__("Yes, delete it!")}}',
        cancelButtonText: '{{__("Cancel")}}',
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading state
            Swal.fire({
                title: '{{__("Deleting...")}}',
                text: '{{__("Please wait while we delete the item.")}}',
                allowEscapeKey: false,
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: `/admin/product-planning/${id}`,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: '{{__("Success!")}}',
                            text: '{{__("The item has been deleted successfully.")}}',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: '{{__("Error!")}}',
                            text: response.message || '{{__("Failed to delete the item.")}}',
                            icon: 'error'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: '{{__("Error!")}}',
                        text: '{{__("Failed to delete the item. Please try again.")}}',
                        icon: 'error'
                    });
                }
            });
        }
    });
}


function showCreateModal() {
    currentItemId = null;
    $('#modalTitle').text('{{__("Add Product Planning Item")}}');
    $('#itemForm')[0].reset();
    if (tagify) tagify.removeAllTags();
    $('#itemModal').modal('show');
}

// Add Product Form Handler
$('#addProductForm').on('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = {};
    for (let [key, value] of formData.entries()) {
        data[key] = value;
    }
    
    $('#addProductBtn').prop('disabled', true);
    $('#addProductBtn .spinner-border').removeClass('d-none');
    
    $.ajax({
        url: '/admin/product-planning/products',
        method: 'POST',
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message || 'Product created successfully',
                    timer: 2000,
                    showConfirmButton: false
                });
                $('#addProductModal').modal('hide');
                location.reload();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: response.message || 'Something went wrong'
                });
            }
        },
        error: function(xhr) {
            let errors = '';
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                Object.values(xhr.responseJSON.errors).forEach(error => {
                    errors += error.join(', ') + '\n';
                });
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error!',
                    text: errors
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Something went wrong'
                });
            }
        },
        complete: function() {
            $('#addProductBtn').prop('disabled', false);
            $('#addProductBtn .spinner-border').addClass('d-none');
        }
    });
});

// Add Department Form Handler
$('#addDepartmentForm').on('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = {};
    for (let [key, value] of formData.entries()) {
        data[key] = value;
    }
    
    $('#addDepartmentBtn').prop('disabled', true);
    $('#addDepartmentBtn .spinner-border').removeClass('d-none');
    
    $.ajax({
        url: '/admin/product-planning/departments',
        method: 'POST',
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message || 'Department created successfully',
                    timer: 2000,
                    showConfirmButton: false
                });
                $('#addDepartmentModal').modal('hide');
                location.reload();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: response.message || 'Something went wrong'
                });
            }
        },
        error: function(xhr) {
            let errors = '';
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                Object.values(xhr.responseJSON.errors).forEach(error => {
                    errors += error.join(', ') + '\n';
                });
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error!',
                    text: errors
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Something went wrong'
                });
            }
        },
        complete: function() {
            $('#addDepartmentBtn').prop('disabled', false);
            $('#addDepartmentBtn .spinner-border').addClass('d-none');
        }
    });
});

// Add Milestone Form Handler
$('#addMilestoneForm').on('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = {};
    for (let [key, value] of formData.entries()) {
        data[key] = value;
    }
    
    $('#addMilestoneBtn').prop('disabled', true);
    $('#addMilestoneBtn .spinner-border').removeClass('d-none');
    
    $.ajax({
        url: '/admin/product-planning/product-milestones',
        method: 'POST',
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message || 'Milestone created successfully',
                    timer: 2000,
                    showConfirmButton: false
                });
                $('#addMilestoneModal').modal('hide');
                location.reload();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: response.message || 'Something went wrong'
                });
            }
        },
        error: function(xhr) {
            let errors = '';
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                Object.values(xhr.responseJSON.errors).forEach(error => {
                    errors += error.join(', ') + '\n';
                });
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error!',
                    text: errors
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Something went wrong'
                });
            }
        },
        complete: function() {
            $('#addMilestoneBtn').prop('disabled', false);
            $('#addMilestoneBtn .spinner-border').addClass('d-none');
        }
    });
});
</script>
@endsection
