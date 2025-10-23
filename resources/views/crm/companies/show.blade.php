@extends('layouts.primary')

@section('content')
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="mb-1 text-gradient text-primary fw-bold">
                        <i class="fas fa-building me-3"></i>{{ $company->name }}
                    </h2>
                    <p class="text-muted mb-0">{{ __('Company Details and Information') }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.crm.companies') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Companies') }}
                    </a>
                    <a href="{{ route('admin.crm.companies.edit', $company->id) }}" class="btn btn-outline-primary">
                        <i class="fas fa-edit me-2"></i>{{ __('Edit Company') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Company Information Card -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-primary text-white">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-sm bg-white bg-opacity-20 rounded-circle me-3">
                            <i class="fas fa-building text-white"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 text-white">{{ __('Company Information') }}</h5>
                            <small class="text-white-50">{{ __('Basic company details and contact information') }}</small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted">{{ __('Company Name') }}</label>
                            <div class="fw-bold">{{ $company->name }}</div>
                        </div>
                        @if($company->industry)
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted">{{ __('Industry') }}</label>
                            <div>
                                <span class="badge bg-primary">{{ $company->industry }}</span>
                            </div>
                        </div>
                        @endif
                        @if($company->company_size)
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted">{{ __('Company Size') }}</label>
                            <div>{{ $company->company_size }}</div>
                        </div>
                        @endif
                        @if($company->website)
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted">{{ __('Website') }}</label>
                            <div>
                                <a href="{{ $company->website }}" target="_blank" class="text-primary">
                                    {{ $company->website }} <i class="fas fa-external-link-alt ms-1"></i>
                                </a>
                            </div>
                        </div>
                        @endif
                        @if($company->email)
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted">{{ __('Email') }}</label>
                            <div>
                                <a href="mailto:{{ $company->email }}" class="text-primary">
                                    {{ $company->email }}
                                </a>
                            </div>
                        </div>
                        @endif
                        @if($company->phone)
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted">{{ __('Phone') }}</label>
                            <div>
                                <a href="tel:{{ $company->phone }}" class="text-primary">
                                    {{ $company->phone }}
                                </a>
                            </div>
                        </div>
                        @endif
                        @if($company->annual_revenue)
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted">{{ __('Annual Revenue') }}</label>
                            <div class="fw-bold text-success">${{ number_format($company->annual_revenue) }}</div>
                        </div>
                        @endif
                        @if($company->currency)
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted">{{ __('Currency') }}</label>
                            <div>{{ strtoupper($company->currency) }}</div>
                        </div>
                        @endif
                    </div>

                    @if($company->description)
                    <div class="mt-3">
                        <label class="form-label fw-semibold text-muted">{{ __('Description') }}</label>
                        <div class="text-muted">{{ $company->description }}</div>
                    </div>
                    @endif

                    @if($company->address || $company->city || $company->state || $company->country)
                    <div class="mt-3">
                        <label class="form-label fw-semibold text-muted">{{ __('Address') }}</label>
                        <div class="text-muted">
                            @if($company->address){{ $company->address }}<br>@endif
                            @if($company->city){{ $company->city }}, @endif
                            @if($company->state){{ $company->state }} @endif
                            @if($company->zip_code){{ $company->zip_code }}<br>@endif
                            @if($company->country){{ $company->country }}@endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Contacts Section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="mb-0">{{ __('Contacts') }} ({{ $contacts->count() }})</h5>
                            <small class="text-muted">{{ __('People associated with this company') }}</small>
                        </div>
                        <a href="{{ route('admin.crm.contacts.create') }}?company_id={{ $company->id }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus me-2"></i>{{ __('Add Contact') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($contacts->count() > 0)
                        <div class="row">
                            @foreach($contacts as $contact)
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center p-3 border rounded">
                                    <div class="avatar avatar-sm bg-gradient-primary text-white rounded-circle me-3">
                                        {{ strtoupper(substr($contact->first_name, 0, 1)) }}{{ strtoupper(substr($contact->last_name, 0, 1)) }}
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">
                                            <a href="{{ route('admin.crm.contacts.show', $contact->id) }}" class="text-decoration-none">
                                                {{ $contact->full_name }}
                                            </a>
                                        </h6>
                                        <small class="text-muted">
                                            @if($contact->job_title){{ $contact->job_title }}@endif
                                            @if($contact->email) • {{ $contact->email }}@endif
                                        </small>
                                        <div class="mt-1">
                                            <span class="badge bg-{{ $contact->type === 'lead' ? 'warning' : 'info' }}">
                                                {{ $contact->type_label }}
                                            </span>
                                            @if($contact->status)
                                            <span class="badge bg-{{ $contact->status_color }}">
                                                {{ $contact->status_label }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-users mb-3" style="font-size: 3rem; color: #a0aec0;"></i>
                            <h5 class="mb-1">{{ __('No contacts found') }}</h5>
                            <p class="text-muted mb-3">{{ __('Add contacts to start building relationships with this company.') }}</p>
                            <a href="{{ route('admin.crm.contacts.create') }}?company_id={{ $company->id }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>{{ __('Add First Contact') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Recent Activities -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="mb-0">{{ __('Recent Activities') }}</h5>
                            <small class="text-muted">{{ __('Latest interactions with this company') }}</small>
                        </div>
                        <a href="{{ route('admin.crm.activities.create') }}?company_id={{ $company->id }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($recentActivities->count() > 0)
                        @foreach($recentActivities as $activity)
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
                                <p class="text-muted mb-1" style="font-size: 0.875rem;">{{ Str::limit($activity->description, 100) }}</p>
                                @endif
                                <small class="text-muted">
                                    by {{ $activity->creator->name }}
                                    @if($activity->contact)
                                    • with {{ $activity->contact->full_name }}
                                    @endif
                                </small>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-history mb-2" style="font-size: 2rem; color: #a0aec0;"></i>
                            <p class="text-muted mb-0">{{ __('No activities yet') }}</p>
                            <small class="text-muted">{{ __('Start logging interactions with this company') }}</small>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Company Stats -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">{{ __('Company Statistics') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="fw-bold text-primary" style="font-size: 1.5rem;">{{ $contacts->count() }}</div>
                            <small class="text-muted">{{ __('Contacts') }}</small>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="fw-bold text-info" style="font-size: 1.5rem;">{{ $recentActivities->count() }}</div>
                            <small class="text-muted">{{ __('Activities') }}</small>
                        </div>
                        <div class="col-6">
                            <div class="fw-bold text-success" style="font-size: 1.5rem;">{{ $contacts->where('type', 'lead')->count() }}</div>
                            <small class="text-muted">{{ __('Leads') }}</small>
                        </div>
                        <div class="col-6">
                            <div class="fw-bold text-warning" style="font-size: 1.5rem;">{{ $contacts->where('type', 'contact')->count() }}</div>
                            <small class="text-muted">{{ __('Contacts') }}</small>
                        </div>
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
function editCompany(id) {
    // TODO: Implement edit company functionality
    console.log('Edit company:', id);
}

$(document).ready(function() {
    console.log('Company show page loaded');
});
</script>
@endsection
