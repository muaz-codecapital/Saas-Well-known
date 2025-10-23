@extends('layouts.primary')

@section('content')
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="mb-1 text-gradient text-primary fw-bold">
                        <i class="fas fa-bell me-3"></i>{{ __('Set Reminder') }}
                    </h2>
                    <p class="text-muted mb-0">{{ __('Create a follow-up reminder or scheduled activity') }}</p>
                </div>
                <a href="{{ route('admin.crm.reminders') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Reminders') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Reminder Form -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-primary text-white">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-sm bg-white bg-opacity-20 rounded-circle me-3">
                            <i class="fas fa-bell text-white"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 text-white">{{ __('Reminder Details') }}</h5>
                            <small class="text-white-50">{{ __('Set up a follow-up or scheduled activity reminder') }}</small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="reminderForm" method="POST" action="{{ route('admin.crm.reminders.store') }}">
                        @csrf

                        <!-- Related Contact/Company -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Contact') }}</label>
                                <select class="form-select" name="contact_id" id="contactSelect">
                                    <option value="">{{ __('Select Contact (Optional)')}}</option>
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
                                    <option value="">{{ __('Select Company (Optional)')}}</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ $companyId == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Reminder Details -->
                        <div class="row mb-4">
                            <div class="col-12 mb-3">
                                <label class="form-label">{{ __('Reminder Title') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="title" required placeholder="e.g. Follow up on proposal">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12 mb-3">
                                <label class="form-label">{{ __('Description') }}</label>
                                <textarea class="form-control" name="description" rows="3" placeholder="Details about what needs to be done..."></textarea>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Reminder Type') }} <span class="text-danger">*</span></label>
                                <select class="form-select" name="type" required>
                                    @foreach($activityTypes as $key => $typeConfig)
                                        <option value="{{ $key }}">{{ $typeConfig['label'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Priority') }} <span class="text-danger">*</span></label>
                                <select class="form-select" name="priority" required>
                                    @foreach($priorities as $key => $priorityConfig)
                                        <option value="{{ $key }}" {{ $key === 'medium' ? 'selected' : '' }}>
                                            {{ $priorityConfig['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Due Date and Assignment -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Due Date & Time') }} <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control" name="remind_at" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Assign To') }}</label>
                                <select class="form-select" name="assigned_to">
                                    <option value="">{{ __('Select User (Optional)')}}</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ $user->id == auth()->id() ? 'selected' : '' }}>
                                            {{ $user->first_name }} {{ $user->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Recurring Options -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_recurring" id="isRecurring" value="1">
                                    <label class="form-check-label" for="isRecurring">
                                        {{ __('Recurring Reminder') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4 recurring-options" style="display: none;">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Repeat Every') }}</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="recurrence_interval" min="1" value="1">
                                    <select class="form-select" name="recurrence_type">
                                        <option value="daily">{{ __('Day(s)') }}</option>
                                        <option value="weekly">{{ __('Week(s)') }}</option>
                                        <option value="monthly">{{ __('Month(s)') }}</option>
                                        <option value="yearly">{{ __('Year(s)') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.crm.reminders') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>{{ __('Cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary" id="reminderSubmitBtn">
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                {{ __('Set Reminder') }}
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

        .recurring-options {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }
    </style>
@endsection

@section('script')
<script>
$(document).ready(function() {
    console.log('Reminder creation form loaded');

    // Handle recurring checkbox
    $('#isRecurring').on('change', function() {
        if ($(this).is(':checked')) {
            $('.recurring-options').show();
        } else {
            $('.recurring-options').hide();
        }
    });

    // Set default date to tomorrow
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    tomorrow.setHours(9, 0, 0, 0); // 9 AM tomorrow

    const formattedDate = tomorrow.toISOString().slice(0, 16);
    $('input[name="remind_at"]').val(formattedDate);

    // Initialize form submission
    $('#reminderForm').on('submit', function(e) {
        e.preventDefault();

        const submitBtn = $('#reminderSubmitBtn');
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
                    showNotification('Reminder set successfully!', 'success');
                    setTimeout(() => {
                        window.location.href = '{{ route("admin.crm.reminders") }}';
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
