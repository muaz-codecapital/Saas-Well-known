@extends('layouts.primary')

@section('content')
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <!-- Centered Heading -->
            <div class="text-center mb-4">
                <h2 class="mb-1 text-gradient text-primary fw-bold">
                    <i class="fas fa-history me-3"></i>{{ __('Activities') }}
                </h2>
                <p class="text-muted mb-0 fs-6">{{ __('Track all interactions and activities with your leads and contacts') }}</p>
            </div>

            <!-- Action Buttons Row -->
            <div class="d-flex justify-content-between align-items-center">
                <!-- View Buttons (Left) -->
                <div class="d-flex gap-2">
                    <!-- No view toggle for activities - just list view -->
                </div>

                <!-- Action Buttons (Right) -->
                <div class="d-flex gap-2">
                    <div class="btn-group">
                        <button type="button" class="btn btn-gradient-success text-white dropdown-toggle rounded-pill px-4 py-2 shadow-sm" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-plus me-2"></i>{{ __('Add Actions') }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.crm.activities.create') }}">
                                    <i class="fas fa-plus me-2 text-primary"></i>{{ __('Log Activity') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" onclick="showContactModal()">
                                    <i class="fas fa-user-plus me-2 text-info"></i>{{ __('Add Contact') }}
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-primary dropdown-toggle rounded-pill px-4 py-2 shadow-sm" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-filter me-2"></i>{{ __('Filters') }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-end p-3" style="min-width: 350px;">
                            <form method="GET" action="{{ route('admin.crm.activities') }}" id="activityFilterForm">
                                <div class="row">
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
                                        <label class="form-label fw-semibold">{{ __('Status') }}</label>
                                        <select class="form-select" name="status">
                                            <option value="">{{ __('All Statuses') }}</option>
                                            <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                                            <option value="scheduled" {{ $status === 'scheduled' ? 'selected' : '' }}>{{ __('Scheduled') }}</option>
                                            <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                                            <option value="no_show" {{ $status === 'no_show' ? 'selected' : '' }}>{{ __('No Show') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">{{ __('Contact') }}</label>
                                        <select class="form-select" name="contact_id">
                                            <option value="">{{ __('All Contacts') }}</option>
                                            @foreach($contacts as $contact)
                                                <option value="{{ $contact->id }}" {{ $contactId == $contact->id ? 'selected' : '' }}>
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
                                                <option value="{{ $company->id }}" {{ $companyId == $company->id ? 'selected' : '' }}>
                                                    {{ $company->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between gap-2">
                                    <button type="submit" class="btn btn-primary btn-sm">{{ __('Apply Filters') }}</button>
                                    <a href="{{ route('admin.crm.activities') }}" class="btn btn-outline-secondary btn-sm">{{ __('Clear') }}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activities Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-gradient-primary text-white">
            <div class="d-flex align-items-center">
                <div class="avatar avatar-sm bg-white bg-opacity-20 rounded-circle me-3">
                    <i class="fas fa-history text-white"></i>
                </div>
                <div>
                    <h5 class="mb-0 text-white">{{ __('Activity Log') }}</h5>
                    <small class="text-white-50">{{ __('All interactions and activities with your contacts') }}</small>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 py-3 px-4">{{ __('Activity') }}</th>
                            <th class="border-0 py-3 px-4">{{ __('Contact') }}</th>
                            <th class="border-0 py-3 px-4">{{ __('Company') }}</th>
                            <th class="border-0 py-3 px-4">{{ __('Type') }}</th>
                            <th class="border-0 py-3 px-4">{{ __('Status') }}</th>
                            <th class="border-0 py-3 px-4">{{ __('Date') }}</th>
                            <th class="border-0 py-3 px-4">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities as $activity)
                            <tr>
                                <td class="py-3 px-4">
                                    <div>
                                        <h6 class="mb-1">{{ $activity->subject }}</h6>
                                        @if($activity->description)
                                            <p class="text-muted mb-1">{{ Str::limit($activity->description, 100) }}</p>
                                        @endif
                                        @if($activity->duration_minutes)
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>{{ $activity->duration_label }}
                                            </small>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    @if($activity->contact)
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm bg-gradient-info rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                <span class="text-white text-xs">{{ substr($activity->contact->first_name, 0, 1) }}{{ substr($activity->contact->last_name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <div class="fw-medium">{{ $activity->contact->full_name }}</div>
                                                <small class="text-muted">{{ $activity->contact->email }}</small>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    @if($activity->company)
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-xs bg-gradient-primary rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                <i class="fas fa-building text-white" style="font-size: 0.6rem;"></i>
                                            </div>
                                            <span>{{ $activity->company->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <span class="badge bg-{{ $activity->type_color }} text-white">
                                        <i class="fas fa-{{ $activity->type_icon }} me-1"></i>
                                        {{ $activity->type_label }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="badge bg-{{ $activity->status === 'completed' ? 'success' : ($activity->status === 'scheduled' ? 'info' : 'secondary') }} text-white">
                                        {{ $activity->status_label }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <div>
                                        <div class="fw-medium">{{ $activity->created_at->format('M d, Y') }}</div>
                                        <small class="text-muted">{{ $activity->created_at->format('H:i') }}</small>
                                        @if($activity->scheduled_at && $activity->scheduled_at != $activity->created_at)
                                            <div>
                                                <small class="text-info">
                                                    <i class="fas fa-calendar me-1"></i>{{ $activity->scheduled_at->format('M d, H:i') }}
                                                </small>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewActivity({{ $activity->id }})" title="{{ __('View Details') }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-info" onclick="editActivity({{ $activity->id }})" title="{{ __('Edit') }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        @if($activity->contact)
                                            <button type="button" class="btn btn-sm btn-outline-warning" onclick="viewContact({{ $activity->contact->id }})" title="{{ __('View Contact') }}">
                                                <i class="fas fa-user"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-history mb-3" style="font-size: 3rem; color: #a0aec0;"></i>
                                        <h5 class="mb-1">{{ __('No activities found') }}</h5>
                                        <p class="mb-3">{{ __('Start logging your interactions by adding activities for your contacts.') }}</p>
                                        <a href="{{ route('admin.crm.activities.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>{{ __('Log First Activity') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($activities->hasPages())
                <div class="card-footer bg-white border-top-0">
                    {{ $activities->links() }}
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
    console.log('Activities list loaded');
});

function viewActivity(id) {
    // Redirect to activity details or show modal
    console.log('Viewing activity:', id);
    // For now, just show a simple alert
    alert('Activity details view not implemented yet. Activity ID: ' + id);
}

function editActivity(id) {
    // Redirect to activity edit or show modal
    console.log('Editing activity:', id);
    // For now, just show a simple alert
    alert('Activity edit view not implemented yet. Activity ID: ' + id);
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
