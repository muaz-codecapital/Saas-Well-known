@extends('layouts.primary')

@section('content')
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <!-- Centered Heading -->
            <div class="text-center mb-4">
                <h2 class="mb-1 text-gradient text-primary fw-bold">
                    <i class="fas fa-address-book me-3"></i>{{ __('Contacts & Leads') }}
                </h2>
                <p class="text-muted mb-0 fs-6">{{ __('Manage your customer relationships and sales pipeline') }}</p>
            </div>

            <!-- Action Buttons Row -->
            <div class="d-flex justify-content-between align-items-center">
                <!-- View Buttons (Left) -->
                <div class="d-flex gap-2">
                    <div class="btn-group" role="group" aria-label="View Types">
                        <a href="{{ route('admin.crm.contacts', array_merge(request()->query(), ['view_type' => 'list'])) }}"
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
                                <a class="dropdown-item" href="#" onclick="showContactModal()">
                                    <i class="fas fa-user-plus me-2 text-primary"></i>{{ __('Add Contact/Lead') }}
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
                        <div class="dropdown-menu dropdown-menu-end p-3" style="min-width: 400px;">
                            <form method="GET" action="{{ route('admin.crm.contacts') }}" id="contactFilterForm">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">{{ __('Type') }}</label>
                                        <select class="form-select" name="type">
                                            <option value="">{{ __('All Types') }}</option>
                                            <option value="contact" {{ $type === 'contact' ? 'selected' : '' }}>{{ __('Contacts Only') }}</option>
                                            <option value="lead" {{ $type === 'lead' ? 'selected' : '' }}>{{ __('Leads Only') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">{{ __('Status') }}</label>
                                        <select class="form-select" name="status">
                                            <option value="">{{ __('All Statuses') }}</option>
                                            @foreach($pipelineStatuses as $key => $statusConfig)
                                                <option value="{{ $key }}" {{ $status === $key ? 'selected' : '' }}>
                                                    {{ $statusConfig['label'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
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
                                        <input type="text" class="form-control" name="search" value="{{ $search }}" placeholder="{{ __('Search contacts...') }}">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between gap-2">
                                    <button type="submit" class="btn btn-primary btn-sm">{{ __('Apply Filters') }}</button>
                                    <a href="{{ route('admin.crm.contacts') }}" class="btn btn-outline-secondary btn-sm">{{ __('Clear') }}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contacts Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-gradient-primary text-white">
            <div class="d-flex align-items-center">
                <div class="avatar avatar-sm bg-white bg-opacity-20 rounded-circle me-3">
                    <i class="fas fa-address-book text-white"></i>
                </div>
                <div>
                    <h5 class="mb-0 text-white">{{ __('Contacts & Leads') }}</h5>
                    <small class="text-white-50">{{ __('Manage your customer database and sales pipeline') }}</small>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 py-3 px-4">{{ __('Contact') }}</th>
                            <th class="border-0 py-3 px-4">{{ __('Company') }}</th>
                            <th class="border-0 py-3 px-4">{{ __('Type') }}</th>
                            <th class="border-0 py-3 px-4">{{ __('Status') }}</th>
                            <th class="border-0 py-3 px-4">{{ __('Source') }}</th>
                            <th class="border-0 py-3 px-4">{{ __('Priority') }}</th>
                            <th class="border-0 py-3 px-4">{{ __('Assigned To') }}</th>
                            <th class="border-0 py-3 px-4">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contacts as $contact)
                            <tr>
                                <td class="py-3 px-4">
                                    <div class="d-flex align-items-center">
                                        @if($contact->assignedUser && $contact->assignedUser->photo)
                                            <img src="{{PUBLIC_DIR}}/uploads/{{$contact->assignedUser->photo}}" class="avatar avatar-sm rounded-circle me-3" alt="">
                                        @else
                                            <div class="avatar avatar-sm bg-gradient-primary rounded-circle me-3 d-flex align-items-center justify-content-center">
                                                <span class="text-white text-xs fw-bold">{{ substr($contact->first_name, 0, 1) }}{{ substr($contact->last_name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-0">{{ $contact->full_name }}</h6>
                                            <small class="text-muted">{{ $contact->email ?: $contact->phone }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    @if($contact->company)
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-xs bg-info rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                <i class="fas fa-building text-white" style="font-size: 0.6rem;"></i>
                                            </div>
                                            <span>{{ $contact->company->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <span class="badge bg-{{ $contact->type === 'lead' ? 'warning' : 'info' }} text-white">
                                        {{ $contact->type_label }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="badge bg-{{ $contact->status_color }} text-white">
                                        <i class="fas fa-{{ $contact->status_icon }} me-1"></i>
                                        {{ $contact->status_label }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    @if($contact->source)
                                        <span class="badge bg-secondary text-white">
                                            <i class="fas fa-{{ $leadSources[$contact->source]['icon'] ?? 'question-circle' }} me-1"></i>
                                            {{ $contact->source_label }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    @if($contact->priority)
                                        <span class="badge bg-{{ $contact->priority_color }} text-white">
                                            {{ $contact->priority_label }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    @if($contact->assignedUser)
                                        <div class="d-flex align-items-center">
                                            @if($contact->assignedUser->photo)
                                                <img src="{{PUBLIC_DIR}}/uploads/{{$contact->assignedUser->photo}}" class="avatar avatar-xs rounded-circle me-2" alt="">
                                            @else
                                                <div class="avatar avatar-xs bg-gradient-secondary rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                    <span class="text-white text-xs">{{ substr($contact->assignedUser->first_name, 0, 1) }}{{ substr($contact->assignedUser->last_name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                            <span>{{ $contact->assignedUser->first_name }} {{ $contact->assignedUser->last_name }}</span>
                                        </div>
                                    @else
                                        <span class="text-muted">Unassigned</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.crm.contacts.show', $contact->id) }}" class="btn btn-sm btn-outline-primary" title="{{ __('View') }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-info" onclick="editContact({{ $contact->id }})" title="{{ __('Edit') }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-warning" onclick="logActivity({{ $contact->id }})" title="{{ __('Log Activity') }}">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="setReminder({{ $contact->id }})">
                                                        <i class="fas fa-bell me-2"></i>{{ __('Set Reminder') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="updateStatus({{ $contact->id }}, 'won')">
                                                        <i class="fas fa-trophy me-2 text-success"></i>{{ __('Mark as Won') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="updateStatus({{ $contact->id }}, 'lost')">
                                                        <i class="fas fa-times me-2 text-danger"></i>{{ __('Mark as Lost') }}
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a class="dropdown-item text-danger" href="#" onclick="deleteContact({{ $contact->id }})">
                                                        <i class="fas fa-trash me-2"></i>{{ __('Delete') }}
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-address-book mb-3" style="font-size: 3rem; color: #a0aec0;"></i>
                                        <h5 class="mb-1">{{ __('No contacts found') }}</h5>
                                        <p class="mb-3">{{ __('Start building your customer database by adding contacts and leads.') }}</p>
                                        <a href="#" onclick="showContactModal()" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>{{ __('Add First Contact') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($contacts->hasPages())
                <div class="card-footer bg-white border-top-0">
                    {{ $contacts->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Contact Modal -->
    <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactModalLabel">{{ __('Add Contact/Lead') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="contactForm" method="POST" action="{{ route('admin.crm.contacts.store') }}">
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
                                <label class="form-label">{{ __('Type') }} <span class="text-danger">*</span></label>
                                <select class="form-select" name="type" required>
                                    <option value="contact">{{ __('Contact') }}</option>
                                    <option value="lead">{{ __('Lead') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Status') }} <span class="text-danger">*</span></label>
                                <select class="form-select" name="status" required>
                                    @foreach($pipelineStatuses as $key => $statusConfig)
                                        <option value="{{ $key }}">{{ $statusConfig['label'] }}</option>
                                    @endforeach
                                </select>
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary" id="contactSubmitBtn">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            {{ __('Save Contact') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
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
let currentContactId = null;

$(document).ready(function() {
    console.log('Contacts list loaded');

    // Initialize form submission
    $('#contactForm').on('submit', function(e) {
        e.preventDefault();

        const submitBtn = $('#contactSubmitBtn');
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
                    $('#contactModal').modal('hide');
                    showNotification('Contact created successfully!', 'success');
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

function showContactModal() {
    $('#contactForm')[0].reset();
    currentContactId = null;
    $('#contactModalLabel').text('Add Contact/Lead');
    $('#contactModal').modal('show');
}

function editContact(id) {
    // Show loading
    const editBtn = event.target.closest('button');
    const originalText = editBtn.innerHTML;
    editBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    editBtn.disabled = true;

    $.ajax({
        url: '{{ route("admin.crm.contacts.get", ":id") }}'.replace(':id', id),
        method: 'GET',
        success: function(response) {
            if (response.success) {
                const contact = response.contact;

                // Fill form
                $('#contactForm [name="first_name"]').val(contact.first_name);
                $('#contactForm [name="last_name"]').val(contact.last_name);
                $('#contactForm [name="email"]').val(contact.email);
                $('#contactForm [name="phone"]').val(contact.phone);
                $('#contactForm [name="mobile"]').val(contact.mobile);
                $('#contactForm [name="company_id"]').val(contact.company_id);
                $('#contactForm [name="job_title"]').val(contact.job_title);
                $('#contactForm [name="department"]').val(contact.department);
                $('#contactForm [name="type"]').val(contact.type);
                $('#contactForm [name="status"]').val(contact.status);
                $('#contactForm [name="source"]').val(contact.source);
                $('#contactForm [name="priority"]').val(contact.priority);
                $('#contactForm [name="assigned_to"]').val(contact.assigned_to);
                $('#contactForm [name="notes"]').val(contact.notes);
                $('#contactForm [name="address"]').val(contact.address);
                $('#contactForm [name="city"]').val(contact.city);
                $('#contactForm [name="state"]').val(contact.state);
                $('#contactForm [name="country"]').val(contact.country);
                $('#contactForm [name="zip_code"]').val(contact.zip_code);

                currentContactId = id;
                $('#contactModalLabel').text('Edit Contact/Lead');
                $('#contactModal').modal('show');
            } else {
                showNotification('Error: ' + response.message, 'error');
            }
        },
        error: function() {
            showNotification('Error loading contact data', 'error');
        },
        complete: function() {
            // Reset button
            editBtn.innerHTML = originalText;
            editBtn.disabled = false;
        }
    });
}

function updateStatus(id, status) {
    Swal.fire({
        title: 'Are you sure?',
        text: `Are you sure you want to update the status to "${status}"?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0d6efd',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, update it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading on the button
            const button = event.target.closest('button');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            button.disabled = true;

            $.ajax({
                url: '{{ route("admin.crm.contacts.update-status", ":id") }}'.replace(':id', id),
                method: 'PATCH',
                data: {
                    status: status,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        showNotification('Contact status updated successfully!', 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        showNotification('Error: ' + (response.message || 'Failed to update status'), 'error');
                    }
                },
                error: function(xhr) {
                    console.error('Error updating status:', xhr);
                    showNotification('Error updating status. Please try again.', 'error');
                },
                complete: function() {
                    // Reset button
                    button.innerHTML = originalText;
                    button.disabled = false;
                }
            });
        }
    });
}

function deleteContact(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'Are you sure you want to delete this contact? This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading on the button
            const button = event.target.closest('button');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            button.disabled = true;

            $.ajax({
                url: '{{ route("admin.crm.contacts.delete", ":id") }}'.replace(':id', id),
                method: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        showNotification('Contact deleted successfully!', 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        showNotification('Error: ' + (response.message || 'Failed to delete contact'), 'error');
                    }
                },
                error: function(xhr) {
                    console.error('Error deleting contact:', xhr);
                    showNotification('Error deleting contact. Please try again.', 'error');
                },
                complete: function() {
                    // Reset button
                    button.innerHTML = originalText;
                    button.disabled = false;
                }
            });
        }
    });
}

function logActivity(contactId) {
    // Redirect to activity creation with contact pre-selected
    window.location.href = '{{ route("admin.crm.activities.create") }}?contact_id=' + contactId;
}

function setReminder(contactId) {
    // Redirect to reminder creation with contact pre-selected
    window.location.href = '{{ route("admin.crm.reminders.create") }}?contact_id=' + contactId;
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
