@extends('layouts.primary')

@section('content')
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="mb-1 text-gradient text-primary fw-bold">
                        <i class="fas fa-user-plus me-3"></i>{{ __('Add Contact/Lead') }}
                    </h2>
                    <p class="text-muted mb-0">{{ __('Create a new contact or lead in your CRM system') }}</p>
                </div>
                <a href="{{ route('admin.crm.contacts') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Contacts') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Contact Form -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-primary text-white">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-sm bg-white bg-opacity-20 rounded-circle me-3">
                            <i class="fas fa-user-plus text-white"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 text-white">{{ __('Contact Information') }}</h5>
                            <small class="text-white-50">{{ __('Enter the details for the new contact or lead') }}</small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="contactForm" method="POST" action="{{ route('admin.crm.contacts.store') }}">
                        @csrf

                        <!-- Contact Type Selection -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label fw-semibold">{{ __('Contact Type') }} <span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="type" id="contactType" value="contact" checked>
                                            <label class="form-check-label" for="contactType">
                                                <i class="fas fa-user me-2 text-info"></i>
                                                <strong>Contact</strong>
                                                <br><small class="text-muted">Existing customer or business relationship</small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="type" id="leadType" value="lead">
                                            <label class="form-check-label" for="leadType">
                                                <i class="fas fa-bullhorn me-2 text-warning"></i>
                                                <strong>Lead</strong>
                                                <br><small class="text-muted">Potential customer or sales opportunity</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Basic Information -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('First Name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="first_name" required placeholder="Enter first name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Last Name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="last_name" required placeholder="Enter last name">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Email Address') }}</label>
                                <input type="email" class="form-control" name="email" placeholder="contact@example.com">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Phone Number') }}</label>
                                <input type="text" class="form-control" name="phone" placeholder="+1 (555) 123-4567">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Mobile Number') }}</label>
                                <input type="text" class="form-control" name="mobile" placeholder="+1 (555) 987-6543">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Company') }}</label>
                                <select class="form-select" name="company_id">
                                    <option value="">{{ __('Select Company (Optional)') }}</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Job Information (for contacts) -->
                        <div class="row mb-4 job-info-section">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Job Title') }}</label>
                                <input type="text" class="form-control" name="job_title" placeholder="e.g. Marketing Manager">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Department') }}</label>
                                <input type="text" class="form-control" name="department" placeholder="e.g. Marketing, Sales">
                            </div>
                        </div>

                        <!-- Lead Information (for leads) -->
                        <div class="row mb-4 lead-info-section" style="display: none;">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Lead Source') }} <span class="text-danger">*</span></label>
                                <select class="form-select" name="source" required>
                                    <option value="">{{ __('Select Source') }}</option>
                                    @foreach($leadSources as $key => $sourceConfig)
                                        <option value="{{ $key }}">{{ $sourceConfig['label'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Lead Value ($)') }}</label>
                                <input type="number" class="form-control" name="lead_value" step="0.01" min="0" placeholder="10000.00">
                            </div>
                        </div>

                        <div class="row mb-4 lead-info-section" style="display: none;">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Status') }} <span class="text-danger">*</span></label>
                                <select class="form-select" name="status" required>
                                    @foreach($pipelineStatuses as $key => $statusConfig)
                                        <option value="{{ $key }}" {{ $key === 'new' ? 'selected' : '' }}>
                                            {{ $statusConfig['label'] }}
                                        </option>
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

                        <div class="row mb-4 lead-info-section" style="display: none;">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Expected Close Date') }}</label>
                                <input type="date" class="form-control" name="expected_close_date">
                            </div>
                        </div>

                        <!-- Address Information -->
                        <div class="row mb-4">
                            <div class="col-12 mb-3">
                                <label class="form-label">{{ __('Address') }}</label>
                                <input type="text" class="form-control" name="address" placeholder="Street address">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">{{ __('City') }}</label>
                                <input type="text" class="form-control" name="city" placeholder="City">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">{{ __('State/Province') }}</label>
                                <input type="text" class="form-control" name="state" placeholder="State">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">{{ __('Country') }}</label>
                                <input type="text" class="form-control" name="country" placeholder="Country">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('ZIP/Postal Code') }}</label>
                                <input type="text" class="form-control" name="zip_code" placeholder="12345">
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-4">
                            <label class="form-label">{{ __('Notes') }}</label>
                            <textarea class="form-control" name="notes" rows="4" placeholder="Additional notes about this contact..."></textarea>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.crm.contacts') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>{{ __('Cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary" id="contactSubmitBtn">
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                {{ __('Save Contact') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important; }
        .text-primary { color: #667eea !important; }

        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }

        .form-check-label strong {
            color: #495057;
        }
    </style>
@endsection

@section('script')
<script>
$(document).ready(function() {
    console.log('Contact creation form loaded');

    // Handle contact type toggle
    $('input[name="type"]').on('change', function() {
        const type = $(this).val();
        if (type === 'lead') {
            $('.job-info-section').hide();
            $('.lead-info-section').show();
        } else {
            $('.job-info-section').show();
            $('.lead-info-section').hide();
        }
    });

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
                    showNotification('Contact created successfully!', 'success');
                    setTimeout(() => {
                        window.location.href = '{{ route("admin.crm.contacts") }}';
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
