@extends('layouts.primary')

@section('content')
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <!-- Centered Heading -->
            <div class="text-center mb-4">
                <h2 class="mb-1 text-gradient text-primary fw-bold">
                    <i class="fas fa-columns me-3"></i>{{ __('Sales Pipeline') }}
                </h2>
                <p class="text-muted mb-0 fs-6">{{ __('Visualize and manage your leads across the sales process') }}</p>
            </div>

            <!-- Action Buttons Row -->
            <div class="d-flex justify-content-between align-items-center">
                <!-- View Buttons (Left) -->
                <div class="d-flex gap-2">
                    <div class="btn-group" role="group" aria-label="View Types">
                        <a href="{{ route('admin.crm.contacts', array_merge(request()->query(), ['view_type' => 'list'])) }}"
                           type="button"
                           class="btn {{ request()->view_type === 'list' || !request()->view_type ? 'btn-outline-primary' : 'btn-gradient-primary text-white shadow-sm' }} rounded-pill px-4 py-2 me-2">
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
                            {{ __('List') }}
                        </a>

                        <a href="{{ route('admin.crm.contacts.kanban', request()->query()) }}"
                           type="button"
                           class="btn {{ request()->routeIs('crm.contacts.kanban') ? 'btn-gradient-primary text-white shadow-sm' : 'btn-outline-primary' }} rounded-pill px-4 py-2 me-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="feather feather-trello me-2">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <rect x="7" y="7" width="3" height="9"></rect>
                                <rect x="14" y="7" width="3" height="5"></rect>
                            </svg>
                            {{ __('Pipeline') }}
                        </a>
                    </div>
                </div>

                <!-- Action Buttons (Right) -->
                <div class="d-flex gap-2">
                    <div class="btn-group">
                        <button type="button" class="btn btn-gradient-success text-white dropdown-toggle rounded-pill px-4 py-2 shadow-sm" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-plus me-2"></i>{{ __('Add Actions') }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="#" onclick="showLeadModal()">
                                    <i class="fas fa-plus me-2 text-primary"></i>{{ __('Add Lead') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.crm.companies.create') }}">
                                    <i class="fas fa-building me-2 text-info"></i>{{ __('Add Company') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" onclick="showActivityModal()">
                                    <i class="fas fa-history me-2 text-warning"></i>{{ __('Log Activity') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" onclick="showReminderModal()">
                                    <i class="fas fa-bell me-2 text-danger"></i>{{ __('Set Reminder') }}
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-primary dropdown-toggle rounded-pill px-4 py-2 shadow-sm" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-filter me-2"></i>{{ __('Filters') }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-end p-3" style="min-width: 350px;">
                            <form method="GET" action="{{ route('admin.crm.contacts.kanban') }}" id="kanbanFilterForm">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">{{ __('Source') }}</label>
                                        <select class="form-select" name="source">
                                            <option value="">{{ __('All Sources') }}</option>
                                            @foreach($leadSources as $key => $sourceConfig)
                                                <option value="{{ $key }}" {{ $source === $key ? 'selected' : '' }}>
                                                    {{ $sourceConfig['label'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">{{ __('Company') }}</label>
                                        <select class="form-select" name="company_id">
                                            <option value="">{{ __('All Companies') }}</option>
                                            @foreach($companies as $company)
                                                <option value="{{ $company->id }}" {{ $companyId == $company->id ? 'selected' : '' }}>
                                                    {{ $company->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">{{ __('Assigned To') }}</label>
                                        <select class="form-select" name="assigned_to">
                                            <option value="">{{ __('All Users') }}</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" {{ $assignedTo == $user->id ? 'selected' : '' }}>
                                                    {{ $user->first_name }} {{ $user->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">{{ __('Search') }}</label>
                                        <input type="text" class="form-control" name="search" value="{{ $search }}" placeholder="{{ __('Search leads...') }}">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between gap-2">
                                    <button type="submit" class="btn btn-primary btn-sm">{{ __('Apply Filters') }}</button>
                                    <a href="{{ route('admin.crm.contacts.kanban') }}" class="btn btn-outline-secondary btn-sm">{{ __('Clear') }}</a>
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
        @foreach($pipelineStatuses as $status => $config)
            <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="avatar avatar-lg bg-{{ $config['class'] }} rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
                            <i class="fas fa-{{ $config['icon'] }} text-white" style="font-size: 1.5rem;"></i>
                        </div>
                        <h4 class="mb-1 text-dark fw-bold">{{ $leads->where('status', $status)->count() }}</h4>
                        <p class="text-muted mb-0">{{ $config['label'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Kanban Board -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-gradient-primary text-white">
            <div class="d-flex align-items-center">
                <div class="avatar avatar-sm bg-white bg-opacity-20 rounded-circle me-3">
                    <i class="fas fa-columns text-white"></i>
                </div>
                <div>
                    <h5 class="mb-0 text-white">{{ __('Sales Pipeline Board') }}</h5>
                    <small class="text-white-50">{{ __('Drag and drop leads to change their status') }}</small>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="kanban-container">
                <div class="kanban-board-wrapper">
                    <div id="crmKanban" class="kanban-board-container"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lead Modal -->
    <div class="modal fade" id="leadModal" tabindex="-1" aria-labelledby="leadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="leadModalLabel">{{ __('Add Lead') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="leadForm" method="POST" action="{{ route('admin.crm.contacts.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('First Name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="first_name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Last Name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="last_name" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Email') }}</label>
                                <input type="email" class="form-control" name="email">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Phone') }}</label>
                                <input type="text" class="form-control" name="phone">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Company') }}</label>
                                <select class="form-select" name="company_id">
                                    <option value="">{{ __('Select Company') }}</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Source') }} <span class="text-danger">*</span></label>
                                <select class="form-select" name="source" required>
                                    <option value="">{{ __('Select Source') }}</option>
                                    @foreach($leadSources as $key => $sourceConfig)
                                        <option value="{{ $key }}">{{ $sourceConfig['label'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Lead Value') }}</label>
                                <input type="number" class="form-control" name="lead_value" step="0.01" min="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Priority') }} <span class="text-danger">*</span></label>
                                <select class="form-select" name="priority" required>
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ $i === 3 ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Notes') }}</label>
                            <textarea class="form-control" name="notes" rows="3"></textarea>
                        </div>

                        <!-- Hidden fields -->
                        <input type="hidden" name="type" value="lead">
                        <input type="hidden" name="status" value="new">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary" id="leadSubmitBtn">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            {{ __('Save Lead') }}
                        </button>
                    </div>
                </form>
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
            content: "Drop leads here";
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

        /* Lead card styling */
        .lead-priority {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .lead-priority.low { background: #8392ab; }
        .lead-priority.medium { background: #17c1e8; }
        .lead-priority.high { background: #fbcf33; }
        .lead-priority.urgent { background: #ea0606; }

        .lead-value {
            font-weight: 600;
            color: #11998e;
        }

        /* Dropdown Menu Fixes */
        .dropdown-menu {
            z-index: 1050 !important;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
            border: 1px solid rgba(0, 0, 0, 0.15) !important;
            border-radius: 8px !important;
            min-width: 180px !important;
        }

        .dropdown-item {
            padding: 0.5rem 1rem !important;
            font-size: 0.875rem !important;
            transition: all 0.2s ease !important;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa !important;
            color: #495057 !important;
        }

        .dropdown-item.text-danger:hover {
            background-color: #f8d7da !important;
            color: #721c24 !important;
        }

        .dropdown-divider {
            margin: 0.5rem 0 !important;
            border-color: #dee2e6 !important;
        }

        /* Ensure dropdown button maintains proper z-index */
        .btn-group .btn {
            position: relative !important;
            z-index: 1040 !important;
        }

        .btn-group.show .btn {
            z-index: 1051 !important;
        }
    </style>
@endsection

@section('script')
<script>
let currentLeadId = null;

$(document).ready(function() {
    console.log('CRM Kanban loaded');

    // Initialize kanban board
    createCrmKanban();

    // Initialize form submission
    $('#leadForm').on('submit', function(e) {
        e.preventDefault();

        const submitBtn = $('#leadSubmitBtn');
        const spinner = submitBtn.find('.spinner-border');
        const originalText = submitBtn.text();

        // Show loading state
        submitBtn.prop('disabled', true);
        spinner.removeClass('d-none');
        submitBtn.html("<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span> Saving...");

        const formData = new FormData(this);
        const data = {};
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#leadModal').modal('hide');
                    showNotification('Lead created successfully!', 'success');
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
            },
            complete: function() {
                // Reset loading state
                submitBtn.prop('disabled', false);
                spinner.addClass('d-none');
                submitBtn.text(originalText);
            }
        });
    });
});

function createCrmKanban() {
    console.log('Creating CRM kanban board...');

    const statuses = @json($pipelineStatuses);
    const priorities = @json($priorities);
    const leads = @json($leads);

    console.log('CRM Kanban Data:', {
        statuses: statuses,
        priorities: priorities,
        leads: leads
    });

    const kanbanElement = document.getElementById("crmKanban");
    if (!kanbanElement) {
        console.error('CRM Kanban container not found');
        return;
    }

    let kanbanHtml = '';

    Object.keys(statuses).forEach(status => {
        const statusLeads = leads.filter(lead => lead.status === status);
        const statusConfig = statuses[status];

        let leadsHtml = '';
        statusLeads.forEach(lead => {
            let companyHtml = '';
            if (lead.company) {
                companyHtml = `<div class="badge bg-info text-white mb-2">
                    <i class="fas fa-building me-1"></i>${lead.company.name}
                </div>`;
            }

            let valueHtml = '';
            if (lead.lead_value) {
                valueHtml = `<div class="lead-value mb-2">${lead.lead_value}</div>`;
            }

            let priorityHtml = '';
            if (lead.priority) {
                const priorityClass = ['low', 'medium', 'high', 'urgent'][lead.priority - 1] || 'medium';
                priorityHtml = `<div class="lead-priority ${priorityClass}"></div>`;
            }

            leadsHtml += `
                <div class="kanban-item" draggable="true" data-lead-id="${lead.id}" data-lead-status="${lead.status}" onclick="viewLead(${lead.id})" style="cursor: pointer; position: relative;">
                    ${priorityHtml}
                    <div class="kanban-item-content">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="fw-bold mb-0 flex-grow-1 me-2">${lead.first_name} ${lead.last_name}</h6>
                        </div>
                        ${lead.email ? `<p class="text-sm text-muted mb-1">${lead.email}</p>` : ''}
                        ${lead.phone ? `<p class="text-sm text-muted mb-1">${lead.phone}</p>` : ''}
                        ${companyHtml}
                        ${valueHtml}
                        <div class="d-flex align-items-center justify-content-between">
                            <small class="text-muted">${lead.created_at}</small>
                        </div>
                    </div>
                </div>
            `;
        });

        // Add empty state if no leads
        if (statusLeads.length === 0) {
            leadsHtml = `
                <div class="text-center py-4">
                    <div class="text-muted" style="border: 2px dashed #e2e8f0; border-radius: 8px; padding: 30px; background: #f7fafc;">
                        <i class="fas fa-plus-circle mb-2" style="font-size: 2rem; color: #a0aec0;"></i>
                        <p class="mb-0" style="font-size: 13px;">No leads yet</p>
                        <button class="btn btn-sm btn-outline-primary mt-2" onclick="showLeadModal('${status}')">
                            <i class="fas fa-plus me-1"></i>Add Lead
                        </button>
                    </div>
                </div>
            `;
        }

        kanbanHtml += `
            <div class="kanban-board" style="min-width: 320px; max-width: 320px;">
                <div class="kanban-board-header">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-sm rounded-circle me-2 d-flex align-items-center justify-content-center" style="background: ${statusConfig.color};">
                                <i class="fas fa-${statusConfig.icon} text-white" style="font-size: 0.75rem;"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark">${statusConfig.label}</div>
                                <small class="text-muted">${statusLeads.length} leads</small>
                            </div>
                        </div>
                        <div class="badge text-white px-2 py-1" style="background: ${statusConfig.color};">
                            ${statusLeads.length}
                        </div>
                    </div>
                </div>
                <div class="kanban-drag" data-status="${status}" ondrop="dropLead(event)" ondragover="allowDrop(event)">
                    ${leadsHtml}
                </div>
            </div>
        `;
    });

    kanbanElement.innerHTML = kanbanHtml;

    // Initialize drag and drop functionality
    initializeDragAndDrop();

    console.log('CRM Kanban board created successfully');
}

function initializeDragAndDrop() {
    const kanbanItems = document.querySelectorAll('.kanban-item[draggable="true"]');

    kanbanItems.forEach(item => {
        item.addEventListener('dragstart', handleDragStart);
        item.addEventListener('dragend', handleDragEnd);
    });
}

function handleDragStart(e) {
    const leadId = e.target.dataset.leadId;
    const currentStatus = e.target.dataset.leadStatus;

    e.dataTransfer.setData('text/plain', leadId);
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

function dropLead(e) {
    e.preventDefault();

    const leadId = e.dataTransfer.getData('text/plain');
    const oldStatus = e.dataTransfer.getData('text/status');
    const newStatus = e.target.closest('.kanban-drag').dataset.status;

    if (oldStatus === newStatus) {
        return; // No change needed
    }

    // Update lead status via AJAX
    updateLeadStatus(leadId, newStatus);
}

function updateLeadStatus(leadId, newStatus) {
    // Show confirmation dialog
    Swal.fire({
        title: 'Are you sure?',
        text: 'Are you sure you want to update the lead status?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0d6efd',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, update it!',
        cancelButtonText: 'Cancel',
        customClass: {
            popup: 'swal-wide',
            title: 'swal-title-custom',
            htmlContainer: 'swal-text-custom'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading state
            const leadElement = document.querySelector(`[data-lead-id="${leadId}"]`);
            if (leadElement) {
                leadElement.style.opacity = '0.6';
                leadElement.style.pointerEvents = 'none';
            }

            $.ajax({
                url: '{{ route("admin.crm.contacts.update-status", ":id") }}'.replace(':id', leadId),
                method: 'PATCH',
                data: {
                    status: newStatus,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        showNotification('Lead status updated successfully!', 'success');
                        // Reload the kanban board to reflect changes
                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    } else {
                        showNotification('Error: ' + (response.message || 'Failed to update lead status'), 'error');
                        // Reset the lead position
                        location.reload();
                    }
                },
                error: function(xhr) {
                    console.error('Error updating lead status:', xhr);
                    showNotification('Error updating lead status. Please try again.', 'error');
                    // Reset the lead position
                    location.reload();
                },
                complete: function() {
                    // Reset loading state
                    if (leadElement) {
                        leadElement.style.opacity = '1';
                        leadElement.style.pointerEvents = 'auto';
                    }
                }
            });
        } else {
            // User cancelled, reset the lead position
            location.reload();
        }
    });
}

function viewLead(id) {
    // Redirect to lead details
    window.location.href = '{{ route("admin.crm.contacts.show", ":id") }}'.replace(':id', id);
}

function showLeadModal(status = 'new') {
    $('#leadForm')[0].reset();

    // Pre-select the status if provided
    if (status && $('select[name="status"]').length) {
        $('select[name="status"]').val(status);
    }

    // Pre-select lead type
    $('select[name="type"]').val('lead');

    $('#leadModalLabel').text('Add Lead');
    $('#leadModal').modal('show');
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
