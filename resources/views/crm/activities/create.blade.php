@extends('layouts.primary')

@section('content')
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="mb-1 text-gradient text-primary fw-bold">
                        <i class="fas fa-plus me-3"></i>{{ __('Log Activity') }}
                    </h2>
                    <p class="text-muted mb-0">{{ __('Record an interaction or activity with a contact or company') }}</p>
                </div>
                <a href="{{ route('admin.crm.activities') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Activities') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Activity Form -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-primary text-white">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-sm bg-white bg-opacity-20 rounded-circle me-3">
                            <i class="fas fa-history text-white"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 text-white">{{ __('Activity Details') }}</h5>
                            <small class="text-white-50">{{ __('Log a new activity or interaction') }}</small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="activityForm" method="POST" action="{{ route('admin.crm.activities.store') }}">
                        @csrf

                        <!-- Contact Selection -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Contact') }} <span class="text-danger">*</span></label>
                                <select class="form-select" name="contact_id" id="contactSelect" required>
                                    <option value="">{{ __('Select Contact') }}</option>
                                    @foreach($contacts as $contact)
                                        <option value="{{ $contact->id }}" {{ $contactId == $contact->id ? 'selected' : '' }}>
                                            {{ $contact->full_name }} ({{ $contact->type_label }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Company') }}</label>
                                <select class="form-select" name="company_id" id="companySelect">
                                    <option value="">{{ __('Select Company (Auto-filled)')}}</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Activity Type and Details -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Activity Type') }} <span class="text-danger">*</span></label>
                                <select class="form-select" name="type" id="activityTypeSelect" required>
                                    @foreach($activityTypes as $key => $typeConfig)
                                        <option value="{{ $key }}">{{ $typeConfig['label'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Status') }} <span class="text-danger">*</span></label>
                                <select class="form-select" name="status" required>
                                    <option value="completed" selected>{{ __('Completed') }}</option>
                                    <option value="scheduled">{{ __('Scheduled') }}</option>
                                    <option value="cancelled">{{ __('Cancelled') }}</option>
                                    <option value="no_show">{{ __('No Show') }}</option>
                                </select>
                            </div>
                        </div>

                        <!-- Subject and Description -->
                        <div class="row mb-4">
                            <div class="col-12 mb-3">
                                <label class="form-label">{{ __('Subject') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="subject" required placeholder="Brief description of the activity">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12 mb-3">
                                <label class="form-label">{{ __('Description') }}</label>
                                <textarea class="form-control" name="description" rows="3" placeholder="Detailed description of what happened..."></textarea>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12 mb-3">
                                <label class="form-label">{{ __('Notes') }}</label>
                                <textarea class="form-control" name="notes" rows="3" placeholder="Additional notes or follow-up items..."></textarea>
                            </div>
                        </div>

                        <!-- Meeting/Call specific fields -->
                        <div class="row mb-4 meeting-fields" style="display: none;">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Duration (minutes)') }}</label>
                                <input type="number" class="form-control" name="duration_minutes" min="1" placeholder="30">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Location') }}</label>
                                <input type="text" class="form-control" name="location" placeholder="Meeting room, Zoom, etc.">
                            </div>
                        </div>

                        <!-- Scheduled Date/Time -->
                        <div class="row mb-4 scheduled-fields" style="display: none;">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Scheduled Date & Time') }}</label>
                                <input type="datetime-local" class="form-control" name="scheduled_at">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Completed Date & Time') }}</label>
                                <input type="datetime-local" class="form-control" name="completed_at">
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.crm.activities') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>{{ __('Cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary" id="activitySubmitBtn">
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                {{ __('Log Activity') }}
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
    console.log('Activity creation form loaded');

    // Auto-fill company when contact is selected
    $('#contactSelect').on('change', function() {
        const contactId = $(this).val();
        if (contactId) {
            // Find the selected contact and get its company
            const selectedOption = $(this).find('option:selected');
            const contactText = selectedOption.text();
            // For now, we'll leave company selection manual
            // In a real implementation, you'd make an AJAX call to get contact details
        }
    });

    // Show/hide fields based on activity type
    $('#activityTypeSelect').on('change', function() {
        const type = $(this).val();
        const meetingTypes = ['meeting', 'call', 'demo'];
        const scheduledTypes = ['scheduled'];

        if (meetingTypes.includes(type)) {
            $('.meeting-fields').show();
        } else {
            $('.meeting-fields').hide();
        }
    });

    // Show/hide scheduled fields based on status
    $('select[name="status"]').on('change', function() {
        const status = $(this).val();
        if (status === 'scheduled') {
            $('.scheduled-fields').show();
        } else {
            $('.scheduled-fields').hide();
        }
    });

    // Initialize form submission
    $('#activityForm').on('submit', function(e) {
        e.preventDefault();

        const submitBtn = $('#activitySubmitBtn');
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
                    showNotification('Activity logged successfully!', 'success');
                    setTimeout(() => {
                        window.location.href = '{{ route("admin.crm.activities") }}';
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
