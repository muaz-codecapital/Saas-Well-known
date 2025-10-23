@extends('layouts.primary')

@section('content')
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="mb-1 text-gradient text-primary fw-bold">
                        <i class="fas fa-building me-3"></i>{{ __('Add Company') }}
                    </h2>
                    <p class="text-muted mb-0">{{ __('Create a new company in your CRM system') }}</p>
                </div>
                <a href="{{ route('admin.crm.companies') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Companies') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Company Form -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-primary text-white">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-sm bg-white bg-opacity-20 rounded-circle me-3">
                            <i class="fas fa-building text-white"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 text-white">{{ __('Company Information') }}</h5>
                            <small class="text-white-50">{{ __('Enter the details for the new company') }}</small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="companyForm" method="POST" action="{{ route('admin.crm.companies.store') }}">
                        @csrf

                        <!-- Basic Information -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Company Name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" required placeholder="Enter company name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Website') }}</label>
                                <input type="url" class="form-control" name="website" placeholder="https://example.com">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Industry') }}</label>
                                <select class="form-select" name="industry">
                                    <option value="">{{ __('Select Industry (Optional)') }}</option>
                                    @foreach(config('crm.industries') as $key => $industry)
                                        <option value="{{ $key }}">{{ $industry }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Company Size') }}</label>
                                <select class="form-select" name="company_size">
                                    <option value="">{{ __('Select Company Size (Optional)') }}</option>
                                    @foreach(config('crm.company_sizes') as $size)
                                        <option value="{{ $size }}">{{ $size }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Email Address') }}</label>
                                <input type="email" class="form-control" name="email" placeholder="contact@company.com">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Phone Number') }}</label>
                                <input type="text" class="form-control" name="phone" placeholder="+1 (555) 123-4567">
                            </div>
                        </div>

                        <!-- Financial Information -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Annual Revenue ($)') }}</label>
                                <input type="number" class="form-control" name="annual_revenue" step="0.01" min="0" placeholder="1000000.00">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Currency') }}</label>
                                <select class="form-select" name="currency">
                                    @foreach(config('crm.currencies') as $code => $currency)
                                        <option value="{{ $code }}" {{ $code === config('crm.default_currency') ? 'selected' : '' }}>
                                            {{ $currency['symbol'] }} {{ $currency['name'] }}
                                        </option>
                                    @endforeach
                                </select>
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

                        <!-- Description -->
                        <div class="mb-4">
                            <label class="form-label">{{ __('Description') }}</label>
                            <textarea class="form-control" name="description" rows="4" placeholder="Brief description of the company..."></textarea>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.crm.companies') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>{{ __('Cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary" id="companySubmitBtn">
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                {{ __('Save Company') }}
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
    </style>
@endsection

@section('script')
<script>
$(document).ready(function() {
    console.log('Company creation form loaded');

    // Initialize form submission
    $('#companyForm').on('submit', function(e) {
        e.preventDefault();

        const submitBtn = $('#companySubmitBtn');
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
                    showNotification('Company created successfully!', 'success');
                    setTimeout(() => {
                        window.location.href = '{{ route("admin.crm.companies") }}';
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
