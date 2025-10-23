@extends('layouts.primary')

@section('content')
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <!-- Centered Heading -->
            <div class="text-center mb-4">
                <h2 class="mb-1 text-gradient text-primary fw-bold">
                    <i class="fas fa-columns me-3"></i>{{__('Product Planning / Kanban')}}
                </h2>
                <p class="text-muted mb-0 fs-6">{{__('Visualize and manage your product development workflow')}}</p>
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
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="avatar avatar-lg bg-gradient-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
                        <i class="fas fa-lightbulb text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <h4 class="mb-1 text-dark fw-bold">{{ $items->flatten()->where('status', 'idea')->count() }}</h4>
                    <p class="text-muted mb-0">{{__('Ideas')}}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="avatar avatar-lg bg-gradient-warning rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
                        <i class="fas fa-code text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <h4 class="mb-1 text-dark fw-bold">{{ $items->flatten()->where('status', 'in_development')->count() }}</h4>
                    <p class="text-muted mb-0">{{__('In Development')}}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="avatar avatar-lg bg-gradient-secondary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
                        <i class="fas fa-vial text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <h4 class="mb-1 text-dark fw-bold">{{ $items->flatten()->where('status', 'testing')->count() }}</h4>
                    <p class="text-muted mb-0">{{__('Testing')}}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="avatar avatar-lg bg-gradient-success rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
                        <i class="fas fa-check-circle text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <h4 class="mb-1 text-dark fw-bold">{{ $items->flatten()->where('status', 'released')->count() }}</h4>
                    <p class="text-muted mb-0">{{__('Released')}}</p>
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
                    <h5 class="mb-0 text-white">{{__('Kanban Board')}}</h5>
                    <small class="text-white-50">{{__('Drag and drop items to change status')}}</small>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="kanban-container">
                <div class="kanban-board-wrapper">
                    <div id="productPlanningKanban" class="kanban-board-container"></div>
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

        /* jKanban Board Styling */
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
            font-style: italic;
            padding: 40px 20px;
            border: 2px dashed #e2e8f0;
            border-radius: 8px;
            margin: 10px;
            background: #f7fafc;
            font-size: 13px;
        }

        .empty-column::before {
            content: "No items yet";
            display: block;
            text-align: center;
            color: #a0aec0;
            font-style: italic;
            padding: 40px 20px;
            border: 2px dashed #e2e8f0;
            border-radius: 8px;
            margin: 10px;
            background: #f7fafc;
            font-size: 13px;
        }

        /* Progress Bar Styling */
        .progress {
            height: 6px;
            border-radius: 3px;
            background: #e2e8f0;
            overflow: hidden;
        }

        .progress-bar {
            border-radius: 3px;
            transition: width 0.3s ease;
        }

        /* Badge Styling */
        .badge {
            font-size: 11px;
            font-weight: 500;
            padding: 4px 8px;
            border-radius: 6px;
        }

        /* Avatar Styling */
        .avatar {
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-sm {
            width: 28px;
            height: 28px;
            font-size: 11px;
        }

        /* Add Item Button */
        .kanban-title-button {
            background: #667eea;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .kanban-title-button:hover {
            background: #5a67d8;
            transform: translateY(-1px);
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

        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%) !important;
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #fcb045 0%, #fd1d1d 100%) !important;
        }

        .bg-gradient-info {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        }

        .bg-gradient-indigo {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        }

        .text-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
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

        .border-2 {
            border-width: 2px !important;
        }

        .bg-white-50 {
            background-color: rgba(255, 255, 255, 0.5) !important;
        }

        /* jKanban specific styles */
        .kanban-item {
            background: white !important;
        }

        .kanban-item:hover {
            background: #f8f9fa !important;
        }
    </style>

    <!-- Item Detail Modal -->
    <div class="modal fade" id="itemDetailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="itemDetailTitle">{{__('Item Details')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="itemDetailContent">
                    <!-- Content will be loaded dynamically -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                    <button type="button" class="btn btn-primary" onclick="editCurrentItem()" id="editItemBtn">
                        <i class="fa fa-edit"></i> {{__('Edit')}}
                    </button>
                </div>
            </div>
        </div>
    </div>

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
@endsection

@section('head')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jkanban@1.3.2/dist/jkanban.min.css">
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/jkanban@1.3.2/dist/jkanban.min.js"></script>
<script>
let currentItemId = null;
let tagify = null;
let kanban = null;

$(document).ready(function() {
    console.log('Document ready - initializing Kanban board...');
    
    // Initialize tagify for tags input
    const tagsInput = document.getElementById('tagsInput');
    if (tagsInput) {
        tagify = new Tagify(tagsInput);
    }

    // Always create the kanban board
    createProfessionalKanban();

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

function createProfessionalKanban() {
    console.log('Creating professional kanban board...');
    
    const statuses = @json(config('product_planning.statuses'));
    const priorities = @json(config('product_planning.priorities'));
    const items = @json($items);
    const users = @json($users);
    
    console.log('Kanban Data:', {
        statuses: statuses,
        priorities: priorities,
        items: items,
        users: users
    });
    
    const kanbanElement = document.getElementById("productPlanningKanban");
    if (!kanbanElement) {
        console.error('Kanban container not found');
        return;
    }
    
    let kanbanHtml = '';
    
    Object.keys(statuses).forEach(status => {
        const statusItems = items[status] || [];
        const statusConfig = statuses[status];
        
        let itemsHtml = '';
        statusItems.forEach(item => {
            let userHtml = '';
            if (item.assigned_to && users[item.assigned_to]) {
                const user = users[item.assigned_to];
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
            if (item.progress > 0) {
                progressHtml = `
                    <div class="progress mt-2 mb-1" style="height: 4px;">
                        <div class="progress-bar bg-${item.progress >= 100 ? 'success' : (item.progress >= 50 ? 'primary' : 'warning')}"
                             style="width: ${item.progress}%"></div>
                    </div>
                    <small class="text-muted">${item.progress}% complete</small>`;
            }
            
            let dueDateHtml = '';
            if (item.due_date) {
                const dueDate = new Date(item.due_date);
                const isOverdue = dueDate < new Date() && item.status !== 'released';
                const formattedDate = dueDate.toLocaleDateString();
                dueDateHtml = `<div class="badge bg-${isOverdue ? 'danger' : 'info'} text-white mb-2">
                    <i class="fas fa-calendar me-1"></i>${formattedDate}
                </div>`;
            }
            
            itemsHtml += `
                <div class="kanban-item mb-3" draggable="true" data-item-id="${item.id}" data-item-status="${item.status}" onclick="viewItem(${item.id})" style="cursor: pointer;">
                    <div class="kanban-item-content">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="fw-bold mb-0 flex-grow-1 me-2">${item.title}</h6>
                            <div class="badge bg-${priorities[item.priority]['class']} text-white px-2 py-1">
                                ${item.priority_label}
                            </div>
                        </div>
                        ${item.description ? `<p class="text-sm text-muted mb-2">${item.description.length > 80 ? item.description.substring(0, 80) + '...' : item.description}</p>` : ''}
                        ${dueDateHtml}
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            ${item.product ? `<small class="badge bg-info text-white me-1"><i class="fas fa-box me-1"></i>${item.product.name}</small>` : ''}
                            ${item.department ? `<small class="badge bg-warning text-white"><i class="fas fa-building me-1"></i>${item.department.name}</small>` : ''}
                        </div>
                        ${item.tags ? `<div class="mb-2">${item.tags.map(tag => `<span class="badge bg-light text-dark border me-1">${tag}</span>`).join('')}</div>` : ''}
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                ${userHtml}
                            </div>
                            ${progressHtml}
                        </div>
                    </div>
                </div>
            `;
        });
        
        // Add empty state if no items
        if (statusItems.length === 0) {
            itemsHtml = `
                <div class="text-center py-4">
                    <div class="text-muted" style="border: 2px dashed #e2e8f0; border-radius: 8px; padding: 30px; background: #f7fafc;">
                        <i class="fas fa-plus-circle mb-2" style="font-size: 2rem; color: #a0aec0;"></i>
                        <p class="mb-0" style="font-size: 13px;">No items yet</p>
                        <button class="btn btn-sm btn-outline-primary mt-2" onclick="createItemInColumn('${status}')">
                            <i class="fas fa-plus me-1"></i>Add Item
                        </button>
                    </div>
                </div>
            `;
        }
        
        const iconMap = {
            'idea': 'lightbulb',
            'validation': 'search',
            'in_development': 'code',
            'testing': 'vial',
            'released': 'check-circle',
            'archived': 'archive'
        };
        
        kanbanHtml += `
            <div class="kanban-board" style="min-width: 320px; max-width: 320px;">
                <div class="kanban-board-header">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-sm bg-gradient-primary rounded-circle me-2 d-flex align-items-center justify-content-center">
                                <i class="fas fa-${iconMap[status]} text-white" style="font-size: 0.75rem;"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark">${statusConfig.label}</div>
                                <small class="text-muted">${statusItems.length} items</small>
                            </div>
                        </div>
                        <div class="badge bg-gradient-primary text-white px-2 py-1">
                            ${statusItems.length}
                        </div>
                    </div>
                </div>
                <div class="kanban-drag" data-status="${status}" ondrop="dropItem(event)" ondragover="allowDrop(event)">
                    ${itemsHtml}
                </div>
            </div>
        `;
    });
    
    kanbanElement.innerHTML = kanbanHtml;
    
    // Initialize drag and drop functionality
    setTimeout(() => {
        initializeProductPlanningDragAndDrop();
    }, 100);

    console.log('Professional kanban board created successfully with', Object.keys(statuses).length, 'columns');
}

// Drag and Drop Functions for Product Planning
function initializeProductPlanningDragAndDrop() {
    const kanbanItems = document.querySelectorAll('.kanban-item[draggable="true"]');

    console.log('Found', kanbanItems.length, 'draggable items');

    if (kanbanItems.length === 0) {
        console.log('No draggable items found, retrying in 500ms...');
        setTimeout(initializeProductPlanningDragAndDrop, 500);
        return;
    }

    kanbanItems.forEach(item => {
        item.addEventListener('dragstart', handleProductPlanningDragStart);
        item.addEventListener('dragend', handleProductPlanningDragEnd);
    });

    console.log('Drag and drop initialized successfully');
}

function handleProductPlanningDragStart(e) {
    const itemId = e.target.dataset.itemId;
    const currentStatus = e.target.dataset.itemStatus;
    
    e.dataTransfer.setData('text/plain', itemId);
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

function handleProductPlanningDragEnd(e) {
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

function dropItem(e) {
    e.preventDefault();

    const itemId = e.dataTransfer.getData('text/plain');
    const oldStatus = e.dataTransfer.getData('text/status');
    const newStatus = e.target.closest('.kanban-drag').dataset.status;

    console.log('dropItem called with:', { itemId, oldStatus, newStatus });

    if (oldStatus === newStatus) {
        console.log('No change needed - same status');
        return; // No change needed
    }

    console.log('Calling updateItemStatus...');
    // Update item status via AJAX
    updateItemStatus(itemId, newStatus);
}

function updateItemStatus(itemId, newStatus) {
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
            const itemElement = document.querySelector(`[data-item-id="${itemId}"]`);
            if (itemElement) {
                itemElement.style.opacity = '0.6';
                itemElement.style.pointerEvents = 'none';
            }

            console.log('Making AJAX request to:', `/admin/product-planning/${itemId}/status`);

    $.ajax({
                url: `/admin/product-planning/${itemId}/status`,
        method: 'PATCH',
                data: {
                    status: newStatus,
                    _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
                    console.log('AJAX Success Response:', response);
                    if (response.success) {
                        console.log('Success! Showing notification and reloading...');
                        showNotification('Item status updated successfully!', 'success');
                        // Reload the kanban board to reflect changes
                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    } else {
                        console.log('Response indicates failure:', response);
                        showNotification('Error: ' + (response.message || 'Failed to update item status'), 'error');
                        // Reset the item position
                        location.reload();
                    }
                },
                error: function(xhr) {
                    console.error('AJAX Error Response:', xhr);
                    console.error('Error status:', xhr.status);
                    console.error('Error responseText:', xhr.responseText);
                    showNotification('Error updating item status. Please try again.', 'error');
                    // Reset the item position
                    location.reload();
                },
                complete: function() {
                    // Reset loading state
                    if (itemElement) {
                        itemElement.style.opacity = '1';
                        itemElement.style.pointerEvents = 'auto';
                    }
                }
            });
        } else {
            // User cancelled, reset the item position
            location.reload();
        }
    });
}

function createItemInColumn(status) {
    // Set the status in the form and show the modal
    currentItemId = null;
    $('#modalTitle').text('{{__("Add Product Planning Item")}}');
    $('#itemForm')[0].reset();
    if (tagify) tagify.removeAllTags();
    
    // Pre-select the status
    $('select[name="status"]').val(status);
    
    $('#itemModal').modal('show');
}

function viewItem(id) {
    // Handle item view
    console.log('Viewing item:', id);
    // You can implement a modal or redirect to item details
}

function createItemInColumn(status) {
    currentItemId = null;
    $('#modalTitle').text('{{__("Add Product Planning Item")}}');
    $('select[name="status"]').val(status);
    $('#itemForm')[0].reset();
    if (tagify) tagify.removeAllTags();
    $('#itemModal').modal('show');
}

// function updateItemStatus(id, status) {
//     $.ajax({
//         url: `/admin/product-planning/${id}/status`,
//         method: 'PATCH',
//         data: { status: status },
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         success: function(response) {
//             if (!response.success) {
//                 alert('Error: ' + (response.message || 'Something went wrong'));
//                 location.reload(); // Reload to fix UI state
//             }
//         },
//         error: function() {
//             alert('Error updating status');
//             location.reload(); // Reload to fix UI state
//         }
//     });
// }

function editCurrentItem() {
    $('#itemDetailModal').modal('hide');
    // The edit functionality would need to be implemented to get the current item ID
    // For now, this is a placeholder
}

function showCreateModal() {
    currentItemId = null;
    $('#modalTitle').text('{{__("Add Product Planning Item")}}');
    $('select[name="status"]').val('idea');
    $('#itemForm')[0].reset();
    if (tagify) tagify.removeAllTags();
    $('#itemModal').modal('show');
}

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
