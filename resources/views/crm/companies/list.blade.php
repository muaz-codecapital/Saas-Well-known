@extends('layouts.primary')

@section('content')
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <!-- Centered Heading -->
            <div class="text-center mb-4">
                <h2 class="mb-1 text-gradient text-primary fw-bold">
                    <i class="fas fa-building me-3"></i>{{ __('Companies') }}
                </h2>
                <p class="text-muted mb-0 fs-6">{{ __('Manage your company database and relationships') }}</p>
            </div>

            <!-- Action Buttons Row -->
            <div class="d-flex justify-content-between align-items-center">
                <!-- View Buttons (Left) -->
                <div class="d-flex gap-2">
                    <!-- No view toggle for companies - just list view -->
                </div>

                <!-- Action Buttons (Right) -->
                <div class="d-flex gap-2">
                    <div class="btn-group">
                        <button type="button" class="btn btn-gradient-success text-white dropdown-toggle rounded-pill px-4 py-2 shadow-sm" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-plus me-2"></i>{{ __('Add Actions') }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.crm.companies.create') }}">
                                    <i class="fas fa-plus me-2 text-primary"></i>{{ __('Add Company') }}
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
                        <div class="dropdown-menu dropdown-menu-end p-3" style="min-width: 300px;">
                            <form method="GET" action="{{ route('admin.crm.companies') }}" id="companyFilterForm">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">{{ __('Industry') }}</label>
                                        <select class="form-select" name="industry">
                                            <option value="">{{ __('All Industries') }}</option>
                                            @foreach(config('crm.industries') as $key => $industry)
                                                <option value="{{ $key }}" {{ $industry === $key ? 'selected' : '' }}>
                                                    {{ $industry }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">{{ __('Search') }}</label>
                                        <input type="text" class="form-control" name="search" value="{{ $search }}" placeholder="{{ __('Search companies...') }}">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between gap-2">
                                    <button type="submit" class="btn btn-primary btn-sm">{{ __('Apply Filters') }}</button>
                                    <a href="{{ route('admin.crm.companies') }}" class="btn btn-outline-secondary btn-sm">{{ __('Clear') }}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Companies Cards Grid -->
    <div class="row">
        @forelse($companies as $company)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-3">
                            <div class="avatar avatar-lg bg-gradient-primary rounded-circle me-3 d-flex align-items-center justify-content-center">
                                <i class="fas fa-building text-white" style="font-size: 1.5rem;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-1">{{ $company->name }}</h5>
                                @if($company->industry)
                                    <span class="badge bg-info text-white">{{ $company->industry }}</span>
                                @endif
                            </div>
                        </div>

                        @if($company->description)
                            <p class="text-muted mb-3">{{ Str::limit($company->description, 100) }}</p>
                        @endif

                        <div class="row mb-3">
                            @if($company->website)
                                <div class="col-12 mb-2">
                                    <small class="text-muted">{{ __('Website:') }}</small>
                                    <div><a href="{{ $company->website }}" target="_blank" class="text-primary">{{ $company->website }}</a></div>
                                </div>
                            @endif
                            @if($company->email)
                                <div class="col-12 mb-2">
                                    <small class="text-muted">{{ __('Email:') }}</small>
                                    <div><a href="mailto:{{ $company->email }}" class="text-primary">{{ $company->email }}</a></div>
                                </div>
                            @endif
                            @if($company->phone)
                                <div class="col-12 mb-2">
                                    <small class="text-muted">{{ __('Phone:') }}</small>
                                    <div><a href="tel:{{ $company->phone }}" class="text-primary">{{ $company->phone }}</a></div>
                                </div>
                            @endif
                            @if($company->annual_revenue)
                                <div class="col-12 mb-2">
                                    <small class="text-muted">{{ __('Annual Revenue:') }}</small>
                                    <div class="fw-bold text-success">${{ number_format($company->annual_revenue) }}</div>
                                </div>
                            @endif
                        </div>

                        <div class="d-flex align-items-center justify-content-between mt-3">
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.crm.companies.show', $company->id) }}" 
                                   class="btn btn-sm btn-outline-primary action-btn" 
                                   style="border-color: #667eea; color: #667eea;">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.crm.companies.edit', $company->id) }}" 
                                   class="btn btn-sm btn-outline-info action-btn" 
                                   style="border-color: #17c1e8; color: #17c1e8;">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-sm btn-outline-warning action-btn" 
                                        style="border-color: #fbcf33; color: #fbcf33;"
                                        onclick="viewContacts({{ $company->id }})">
                                    <i class="fas fa-users"></i>
                                </button>
                            </div>
                            <div class="btn-group" role="group">
                                <button type="button" 
                                        class="btn btn-sm btn-outline-secondary dropdown-toggle action-btn" 
                                        style="border-color: #8392ab; color: #8392ab;"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="addContactToCompany({{ $company->id }})">
                                            <i class="fas fa-user-plus me-2"></i>{{ __('Add Contact') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="logActivity({{ $company->id }})">
                                            <i class="fas fa-history me-2"></i>{{ __('Log Activity') }}
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="#" onclick="deleteCompany({{ $company->id }})">
                                            <i class="fas fa-trash me-2"></i>{{ __('Delete') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="text-muted">
                            <i class="fas fa-building mb-3" style="font-size: 3rem; color: #a0aec0;"></i>
                            <h5 class="mb-1">{{ __('No companies found') }}</h5>
                            <p class="mb-3">{{ __('Start building your company database by adding your first company.') }}</p>
                            <a href="{{ route('admin.crm.companies.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>{{ __('Add First Company') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($companies->hasPages())
        <div class="d-flex justify-content-center">
            {{ $companies->links() }}
        </div>
    @endif

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

        /* Action Button Styles */
        .action-btn {
            width: 40px !important;
            height: 40px !important;
            border-radius: 8px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            transition: all 0.3s ease !important;
            border-width: 2px !important;
            font-size: 14px !important;
        }

        .action-btn:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
        }

        .action-btn.btn-outline-primary:hover {
            background-color: #667eea !important;
            color: white !important;
        }

        .action-btn.btn-outline-info:hover {
            background-color: #17c1e8 !important;
            color: white !important;
        }

        .action-btn.btn-outline-warning:hover {
            background-color: #fbcf33 !important;
            color: white !important;
        }

        .action-btn.btn-outline-secondary:hover {
            background-color: #8392ab !important;
            color: white !important;
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
        .btn-group .action-btn {
            position: relative !important;
            z-index: 1040 !important;
        }

        .btn-group.show .action-btn {
            z-index: 1051 !important;
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
    </style>
@endsection

@section('script')
<script>
$(document).ready(function() {
    console.log('Companies list loaded');
});

function editCompany(id) {
    // Redirect to company edit page or show modal
    window.location.href = '{{ route("admin.crm.companies.show", ":id") }}'.replace(':id', id);
}

function viewContacts(companyId) {
    // Redirect to company contacts view
    window.location.href = '{{ route("admin.crm.companies.show", ":id") }}'.replace(':id', companyId);
}

function addContactToCompany(companyId) {
    // Redirect to contact creation with company pre-selected
    window.location.href = '{{ route("admin.crm.contacts.create") }}?company_id=' + companyId;
}

function logActivity(companyId) {
    // Redirect to activity creation with company pre-selected
    window.location.href = '{{ route("admin.crm.activities.create") }}?company_id=' + companyId;
}

function deleteCompany(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'Are you sure you want to delete this company? This action cannot be undone.',
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
                url: '{{ route("admin.crm.companies.delete", ":id") }}'.replace(':id', id),
                method: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        showNotification('Company deleted successfully!', 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        showNotification('Error: ' + (response.message || 'Failed to delete company'), 'error');
                    }
                },
                error: function(xhr) {
                    console.error('Error deleting company:', xhr);
                    showNotification('Error deleting company. Please try again.', 'error');
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
