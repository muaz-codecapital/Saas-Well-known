@extends('layouts.primary')

@section('content')
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="mb-1 text-gradient text-primary fw-bold">
                        <i class="fas fa-user me-3"></i>{{ $contact->full_name }}
                    </h2>
                    <p class="text-muted mb-0">{{ __('Contact Details and Information') }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.crm.contacts') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Contacts') }}
                    </a>
                    <button type="button" class="btn btn-outline-primary" onclick="editContact({{ $contact->id }})">
                        <i class="fas fa-edit me-2"></i>{{ __('Edit Contact') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Contact Information Card -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-primary text-white">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-sm bg-white bg-opacity-20 rounded-circle me-3">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 text-white">{{ __('Contact Information') }}</h5>
                            <small class="text-white-50">{{ __('Personal details and contact information') }}</small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted">{{ __('Full Name') }}</label>
                            <div class="fw-bold">{{ $contact->full_name }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted">{{ __('Type') }}</label>
                            <div>
                                <span class="badge bg-{{ $contact->type === 'lead' ? 'warning' : 'info' }}">
                                    {{ $contact->type_label }}
                                </span>
                            </div>
                        </div>
                        @if($contact->email)
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted">{{ __('Email') }}</label>
                            <div>
                                <a href="mailto:{{ $contact->email }}" class="text-primary">
                                    {{ $contact->email }}
                                </a>
                            </div>
                        </div>
                        @endif
                        @if($contact->phone)
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted">{{ __('Phone') }}</label>
                            <div>
                                <a href="tel:{{ $contact->phone }}" class="text-primary">
                                    {{ $contact->phone }}
                                </a>
                            </div>
                        </div>
                        @endif
                        @if($contact->mobile)
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted">{{ __('Mobile') }}</label>
                            <div>
                                <a href="tel:{{ $contact->mobile }}" class="text-primary">
                                    {{ $contact->mobile }}
                                </a>
                            </div>
                        </div>
                        @endif
                        @if($contact->company)
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted">{{ __('Company') }}</label>
                            <div>
                                <a href="{{ route('admin.crm.companies.show', $contact->company->id) }}" class="text-primary">
                                    {{ $contact->company->name }}
                                </a>
                            </div>
                        </div>
                        @endif
                        @if($contact->job_title)
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted">{{ __('Job Title') }}</label>
                            <div>{{ $contact->job_title }}</div>
                        </div>
                        @endif
                        @if($contact->department)
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted">{{ __('Department') }}</label>
                            <div>{{ $contact->department }}</div>
                        </div>
                        @endif
                        @if($contact->status)
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted">{{ __('Status') }}</label>
                            <div>
                                <span class="badge bg-{{ $contact->status_color }}">
                                    {{ $contact->status_label }}
                                </span>
                            </div>
                        </div>
                        @endif
                        @if($contact->source)
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted">{{ __('Source') }}</label>
                            <div>
                                <span class="badge bg-secondary">{{ $contact->source_label }}</span>
                            </div>
                        </div>
                        @endif
                        @if($contact->priority)
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted">{{ __('Priority') }}</label>
                            <div>
                                <span class="badge bg-{{ $contact->priority_color }}">
                                    {{ $contact->priority_label }}
                                </span>
                            </div>
                        </div>
                        @endif
                        @if($contact->lead_value)
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted">{{ __('Lead Value') }}</label>
                            <div class="fw-bold text-success">${{ number_format($contact->lead_value) }}</div>
                        </div>
                        @endif
                        @if($contact->expected_close_date)
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted">{{ __('Expected Close Date') }}</label>
                            <div>{{ $contact->expected_close_date->format('M d, Y') }}</div>
                        </div>
                        @endif
                    </div>

                    @if($contact->notes)
                    <div class="mt-3">
                        <label class="form-label fw-semibold text-muted">{{ __('Notes') }}</label>
                        <div class="text-muted">{{ $contact->notes }}</div>
                    </div>
                    @endif

                    @if($contact->address || $contact->city || $contact->state || $contact->country)
                    <div class="mt-3">
                        <label class="form-label fw-semibold text-muted">{{ __('Address') }}</label>
                        <div class="text-muted">
                            @if($contact->address){{ $contact->address }}<br>@endif
                            @if($contact->city){{ $contact->city }}, @endif
                            @if($contact->state){{ $contact->state }} @endif
                            @if($contact->zip_code){{ $contact->zip_code }}<br>@endif
                            @if($contact->country){{ $contact->country }}@endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Activities Section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="mb-0">{{ __('Activities') }}</h5>
                            <small class="text-muted">{{ __('All interactions with this contact') }}</small>
                        </div>
                        <a href="{{ route('admin.crm.activities.create') }}?contact_id={{ $contact->id }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus me-2"></i>{{ __('Log Activity') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($contact->activities && $contact->activities->count() > 0)
                        @foreach($contact->activities as $activity)
                        <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                            <div class="avatar avatar-sm bg-{{ $activity->type_color }} rounded-circle me-3 d-flex align-items-center justify-content-center">
                                <i class="fas fa-{{ $activity->type_icon }} text-white" style="font-size: 0.75rem;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <h6 class="mb-0 text-sm">{{ $activity->subject }}</h6>
                                    <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                </div>
                                @if($activity->description)
                                <p class="text-muted mb-1" style="font-size: 0.875rem;">{{ $activity->description }}</p>
                                @endif
                                <small class="text-muted">
                                    by {{ $activity->creator->name }}
                                    @if($activity->scheduled_at)
                                    • Scheduled: {{ $activity->scheduled_at->format('M d, Y H:i') }}
                                    @endif
                                </small>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-history mb-3" style="font-size: 3rem; color: #a0aec0;"></i>
                            <h5 class="mb-1">{{ __('No activities found') }}</h5>
                            <p class="text-muted mb-3">{{ __('Start logging interactions with this contact.') }}</p>
                            <a href="{{ route('admin.crm.activities.create') }}?contact_id={{ $contact->id }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>{{ __('Log First Activity') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Contact Stats -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">{{ __('Contact Statistics') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="fw-bold text-primary" style="font-size: 1.5rem;">{{ $contact->activities ? $contact->activities->count() : 0 }}</div>
                            <small class="text-muted">{{ __('Activities') }}</small>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="fw-bold text-info" style="font-size: 1.5rem;">{{ $contact->reminders ? $contact->reminders->count() : 0 }}</div>
                            <small class="text-muted">{{ __('Reminders') }}</small>
                        </div>
                        <div class="col-6">
                            <div class="fw-bold text-success" style="font-size: 1.5rem;">{{ $contact->tasks ? $contact->tasks->count() : 0 }}</div>
                            <small class="text-muted">{{ __('Tasks') }}</small>
                        </div>
                        <div class="col-6">
                            <div class="fw-bold text-warning" style="font-size: 1.5rem;">{{ $contact->created_at->diffInDays() }}</div>
                            <small class="text-muted">{{ __('Days Active') }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">{{ __('Quick Actions') }}</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.crm.activities.create') }}?contact_id={{ $contact->id }}" class="btn btn-outline-primary">
                            <i class="fas fa-history me-2"></i>{{ __('Log Activity') }}
                        </a>
                        <a href="{{ route('admin.crm.reminders.create') }}?contact_id={{ $contact->id }}" class="btn btn-outline-warning">
                            <i class="fas fa-bell me-2"></i>{{ __('Set Reminder') }}
                        </a>
                        @if($contact->company)
                        <a href="{{ route('admin.crm.companies.show', $contact->company->id) }}" class="btn btn-outline-info">
                            <i class="fas fa-building me-2"></i>{{ __('View Company') }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important; }
        .text-primary { color: #667eea !important; }
        .text-success { color: #11998e !important; }
        .text-info { color: #17c1e8 !important; }
        .text-warning { color: #fbcf33 !important; }
    </style>
@endsection

@section('script')
<script>
function editContact(id) {
    // TODO: Implement edit contact functionality
    console.log('Edit contact:', id);
}

$(document).ready(function() {
    console.log('Contact show page loaded');
});
</script>
@endsection
