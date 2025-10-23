@extends('layouts.primary')

@section('content')
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <!-- Centered Heading -->
            <div class="text-center mb-4">
                <h2 class="mb-1 text-gradient text-primary fw-bold">
                    <i class="fas fa-bell me-3"></i>{{ __('Reminders') }}
                </h2>
                <p class="text-muted mb-0 fs-6">{{ __('Manage your follow-ups and scheduled activities') }}</p>
            </div>

            <!-- Action Buttons Row -->
            <div class="d-flex justify-content-between align-items-center">
                <!-- View Buttons (Left) -->
                <div class="d-flex gap-2">
                    <!-- No view toggle for reminders - just list view -->
                </div>

                <!-- Action Buttons (Right) -->
                <div class="d-flex gap-2">
                    <div class="btn-group">
                        <button type="button" class="btn btn-gradient-success text-white dropdown-toggle rounded-pill px-4 py-2 shadow-sm" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-plus me-2"></i>{{ __('Add Actions') }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.crm.reminders.create') }}">
                                    <i class="fas fa-plus me-2 text-primary"></i>{{ __('Set Reminder') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" onclick="showContactModal()">
                                    <i class="fas fa-user-plus me-2 text-info"></i>{{ __('Add Contact') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.crm.activities.create') }}">
                                    <i class="fas fa-history me-2 text-warning"></i>{{ __('Log Activity') }}
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-primary dropdown-toggle rounded-pill px-4 py-2 shadow-sm" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-filter me-2"></i>{{ __('Filters') }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-end p-3" style="min-width: 350px;">
                            <form method="GET" action="{{ route('admin.crm.reminders') }}" id="reminderFilterForm">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">{{ __('Status') }}</label>
                                        <select class="form-select" name="status">
                                            <option value="">{{ __('All Statuses') }}</option>
                                            <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                            <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                                            <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                                            <option value="overdue" {{ $status === 'overdue' ? 'selected' : '' }}>{{ __('Overdue') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">{{ __('Type') }}</label>
                                        <select class="form-select" name="type">
                                            <option value="">{{ __('All Types') }}</option>
                                            @foreach($activityTypes as $key => $typeConfig)
                                                <option value="{{ $key }}" {{ $type === $key ? 'selected' : '' }}>
                                                    {{ $typeConfig['label'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">{{ __('Contact') }}</label>
                                        <select class="form-select" name="contact_id">
                                            <option value="">{{ __('All Contacts') }}</option>
                                            @foreach($contacts as $contact)
                                                <option value="{{ $contact->id }}" {{ request('contact_id') == $contact->id ? 'selected' : '' }}>
                                                    {{ $contact->full_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">{{ __('Company') }}</label>
                                        <select class="form-select" name="company_id">
                                            <option value="">{{ __('All Companies') }}</option>
                                            @foreach($companies as $company)
                                                <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
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
                                </div>
                                <div class="d-flex justify-content-between gap-2">
                                    <button type="submit" class="btn btn-primary btn-sm">{{ __('Apply Filters') }}</button>
                                    <a href="{{ route('admin.crm.reminders') }}" class="btn btn-outline-secondary btn-sm">{{ __('Clear') }}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="avatar avatar-lg bg-gradient-info rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
                        <i class="fas fa-clock text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <h4 class="mb-1 text-dark fw-bold">{{ $reminders->where('status', 'pending')->count() }}</h4>
                    <p class="text-muted mb-0">{{ __('Pending') }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="avatar avatar-lg bg-gradient-success rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
                        <i class="fas fa-check-circle text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <h4 class="mb-1 text-dark fw-bold">{{ $reminders->where('status', 'completed')->count() }}</h4>
                    <p class="text-muted mb-0">{{ __('Completed') }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="avatar avatar-lg bg-gradient-warning rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
                        <i class="fas fa-calendar-day text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <h4 class="mb-1 text-dark fw-bold">{{ $reminders->where('status', 'pending')->where('remind_at', '>=', now())->count() }}</h4>
                    <p class="text-muted mb-0">{{ __('Upcoming Today') }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="avatar avatar-lg bg-gradient-danger rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
                        <i class="fas fa-exclamation-triangle text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <h4 class="mb-1 text-dark fw-bold">{{ $reminders->where('status', 'pending')->where('remind_at', '<', now())->count() }}</h4>
                    <p class="text-muted mb-0">{{ __('Overdue') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Reminders Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-gradient-primary text-white">
            <div class="d-flex align-items-center">
                <div class="avatar avatar-sm bg-white bg-opacity-20 rounded-circle me-3">
                    <i class="fas fa-bell text-white"></i>
                </div>
                <div>
                    <h5 class="mb-0 text-white">{{ __('Reminders & Follow-ups') }}</h5>
                    <small class="text-white-50">{{ __('Scheduled activities and follow-up tasks') }}</small>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 py-3 px-4">{{ __('Reminder') }}</th>
                            <th class="border-0 py-3 px-4">{{ __('Contact') }}</th>
                            <th class="border-0 py-3 px-4">{{ __('Company') }}</th>
                            <th class="border-0 py-3 px-4">{{ __('Type') }}</th>
                            <th class="border-0 py-3 px-4">{{ __('Priority') }}</th>
                            <th class="border-0 py-3 px-4">{{ __('Due Date') }}</th>
                            <th class="border-0 py-3 px-4">{{ __('Status') }}</th>
                            <th class="border-0 py-3 px-4">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reminders as $reminder)
                            <tr class="{{ $reminder->isOverdue() ? 'table-warning' : '' }}">
                                <td class="py-3 px-4">
                                    <div>
                                        <h6 class="mb-1">{{ $reminder->title }}</h6>
                                        @if($reminder->description)
                                            <p class="text-muted mb-1">{{ Str::limit($reminder->description, 100) }}</p>
                                        @endif
                                        @if($reminder->is_recurring)
                                            <small class="text-info">
                                                <i class="fas fa-sync-alt me-1"></i>{{ $reminder->recurrence_label }}
                                            </small>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    @if($reminder->contact)
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm bg-gradient-info rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                <span class="text-white text-xs">{{ substr($reminder->contact->first_name, 0, 1) }}{{ substr($reminder->contact->last_name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <div class="fw-medium">{{ $reminder->contact->full_name }}</div>
                                                <small class="text-muted">{{ $reminder->contact->email }}</small>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    @if($reminder->company)
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-xs bg-gradient-primary rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                <i class="fas fa-building text-white" style="font-size: 0.6rem;"></i>
                                            </div>
                                            <span>{{ $reminder->company->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <span class="badge bg-{{ $reminder->type_color }} text-white">
                                        <i class="fas fa-{{ $reminder->type_icon }} me-1"></i>
                                        {{ $reminder->type_label }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="badge bg-{{ $reminder->priority_color }} text-white">
                                        {{ $reminder->priority_label }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <div>
                                        <div class="fw-medium">{{ $reminder->remind_at->format('M d, Y') }}</div>
                                        <small class="text-muted">{{ $reminder->remind_at->format('H:i') }}</small>
                                        @if($reminder->isOverdue())
                                            <div>
                                                <small class="text-danger">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>Overdue
                                                </small>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="badge bg-{{ $reminder->status_color }} text-white">
                                        {{ $reminder->status_label }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="btn-group" role="group">
                                        @if($reminder->status === 'pending')
                                            <button type="button" class="btn btn-sm btn-outline-success" onclick="completeReminder({{ $reminder->id }})" title="{{ __('Mark Complete') }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-warning" onclick="cancelReminder({{ $reminder->id }})" title="{{ __('Cancel') }}">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                        <button type="button" class="btn btn-sm btn-outline-info" onclick="editReminder({{ $reminder->id }})" title="{{ __('Edit') }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        @if($reminder->contact)
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewContact({{ $reminder->contact->id }})" title="{{ __('View Contact') }}">
                                                <i class="fas fa-user"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-bell-slash mb-3" style="font-size: 3rem; color: #a0aec0;"></i>
                                        <h5 class="mb-1">{{ __('No reminders found') }}</h5>
                                        <p class="mb-3">{{ __('Set up reminders to stay on top of your follow-ups and activities.') }}</p>
                                        <a href="{{ route('admin.crm.reminders.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>{{ __('Set First Reminder') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($reminders->hasPages())
                <div class="card-footer bg-white border-top-0">
                    {{ $reminders->links() }}
                </div>
            @endif
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

        .table-warning {
            background-color: rgba(255, 193, 7, 0.1) !important;
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
$(document).ready(function() {
    console.log('Reminders list loaded');
});

function completeReminder(id) {
    Swal.fire({
        title: 'Complete Reminder?',
        text: 'Mark this reminder as completed?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, complete it!',
        cancelButtonText: 'Cancel',
        input: 'textarea',
        inputPlaceholder: 'Add completion notes (optional)...',
        inputAttributes: {
            'aria-label': 'Completion notes'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const completionNotes = result.value || '';

            // Show loading on the button
            const button = event.target.closest('button');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            button.disabled = true;

            $.ajax({
                url: '{{ route("admin.crm.reminders.update-status", ":id") }}'.replace(':id', id),
                method: 'PATCH',
                data: {
                    status: 'completed',
                    completion_notes: completionNotes,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        showNotification('Reminder completed successfully!', 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        showNotification('Error: ' + (response.message || 'Failed to complete reminder'), 'error');
                    }
                },
                error: function(xhr) {
                    console.error('Error completing reminder:', xhr);
                    showNotification('Error completing reminder. Please try again.', 'error');
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

function cancelReminder(id) {
    Swal.fire({
        title: 'Cancel Reminder?',
        text: 'Are you sure you want to cancel this reminder?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, cancel it!',
        cancelButtonText: 'Keep it'
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading on the button
            const button = event.target.closest('button');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            button.disabled = true;

            $.ajax({
                url: '{{ route("admin.crm.reminders.update-status", ":id") }}'.replace(':id', id),
                method: 'PATCH',
                data: {
                    status: 'cancelled',
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        showNotification('Reminder cancelled successfully!', 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        showNotification('Error: ' + (response.message || 'Failed to cancel reminder'), 'error');
                    }
                },
                error: function(xhr) {
                    console.error('Error cancelling reminder:', xhr);
                    showNotification('Error cancelling reminder. Please try again.', 'error');
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

function editReminder(id) {
    // Redirect to reminder edit or show modal
    console.log('Editing reminder:', id);
    // For now, just show a simple alert
    alert('Reminder edit view not implemented yet. Reminder ID: ' + id);
}

function viewContact(contactId) {
    // Redirect to contact details
    window.location.href = '{{ route("admin.crm.contacts.show", ":id") }}'.replace(':id', contactId);
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
