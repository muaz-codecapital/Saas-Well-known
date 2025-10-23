@extends('layouts.primary')

@section('content')
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <!-- Centered Heading -->
            <div class="text-center mb-4">
                <h2 class="mb-1 text-gradient text-primary fw-bold">
                    <i class="fas fa-tachometer-alt me-3"></i>{{ __('CRM Dashboard') }}
                </h2>
                <p class="text-muted mb-0 fs-6">{{ __('Manage your sales pipeline and customer relationships') }}</p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="avatar avatar-lg bg-gradient-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
                        <i class="fas fa-building text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <h4 class="mb-1 text-dark fw-bold">{{ $stats['total_companies'] }}</h4>
                    <p class="text-muted mb-0">{{ __('Companies') }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="avatar avatar-lg bg-gradient-info rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
                        <i class="fas fa-users text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <h4 class="mb-1 text-dark fw-bold">{{ $stats['total_contacts'] }}</h4>
                    <p class="text-muted mb-0">{{ __('Contacts') }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="avatar avatar-lg bg-gradient-warning rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
                        <i class="fas fa-bullhorn text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <h4 class="mb-1 text-dark fw-bold">{{ $stats['total_leads'] }}</h4>
                    <p class="text-muted mb-0">{{ __('Leads') }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="avatar avatar-lg bg-gradient-success rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
                        <i class="fas fa-trophy text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <h4 class="mb-1 text-dark fw-bold">{{ $stats['won_deals'] }}</h4>
                    <p class="text-muted mb-0">{{ __('Won Deals') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pipeline Overview -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-primary text-white">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-sm bg-white bg-opacity-20 rounded-circle me-3">
                            <i class="fas fa-route text-white"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 text-white">{{ __('Sales Pipeline Overview') }}</h5>
                            <small class="text-white-50">{{ __('Current status of all leads in your pipeline') }}</small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            $pipelineStatuses = config('crm.pipeline_statuses');
                        @endphp
                        @foreach($pipelineStatuses as $status => $config)
                            <div class="col-md-2 col-sm-4 mb-3">
                                <div class="text-center">
                                    <div class="avatar avatar-md bg-{{ $config['class'] }} rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-{{ $config['icon'] }} text-white"></i>
                                    </div>
                                    <h6 class="mb-1">{{ $config['label'] }}</h6>
                                    <div class="badge bg-{{ $config['class'] }} text-white px-2 py-1">
                                        {{ $pipelineData[$status] ?? 0 }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities & Upcoming Reminders -->
    <div class="row">
        <!-- Recent Activities -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-gradient-info text-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-sm bg-white bg-opacity-20 rounded-circle me-3">
                                <i class="fas fa-history text-white"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 text-white">{{ __('Recent Activities') }}</h5>
                                <small class="text-white-50">{{ __('Latest interactions with leads and contacts') }}</small>
                            </div>
                        </div>
                        <a href="{{ route('admin.crm.activities') }}" class="btn btn-sm btn-white bg-opacity-20 text-white">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($recentActivities->count() > 0)
                        @foreach($recentActivities as $activity)
                            <div class="d-flex align-items-start mb-3 pb-3 border-bottom border-light">
                                <div class="avatar avatar-sm bg-{{ $activity->type_color }} rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-{{ $activity->type_icon }} text-white" style="font-size: 0.75rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <h6 class="mb-0 text-sm">{{ $activity->subject }}</h6>
                                        <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                    </div>
                                    @if($activity->contact)
                                        <p class="text-sm text-muted mb-1">
                                            <strong>{{ $activity->contact->full_name }}</strong>
                                            @if($activity->company)
                                                at {{ $activity->company->name }}
                                            @endif
                                        </p>
                                    @endif
                                    @if($activity->description)
                                        <p class="text-sm text-muted mb-0">{{ Str::limit($activity->description, 100) }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-history mb-2" style="font-size: 2rem; color: #a0aec0;"></i>
                                <p class="mb-0">No recent activities</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Upcoming Reminders -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-gradient-warning text-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-sm bg-white bg-opacity-20 rounded-circle me-3">
                                <i class="fas fa-bell text-white"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 text-white">{{ __('Upcoming Reminders') }}</h5>
                                <small class="text-white-50">{{ __('Tasks and follow-ups due soon') }}</small>
                            </div>
                        </div>
                        <a href="{{ route('admin.crm.reminders') }}" class="btn btn-sm btn-white bg-opacity-20 text-white">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($upcomingReminders->count() > 0)
                        @foreach($upcomingReminders as $reminder)
                            <div class="d-flex align-items-start mb-3 pb-3 border-bottom border-light">
                                <div class="avatar avatar-sm bg-{{ $reminder->priority_color }} rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-{{ $reminder->type_icon }} text-white" style="font-size: 0.75rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <h6 class="mb-0 text-sm">{{ $reminder->title }}</h6>
                                        <small class="text-muted">{{ $reminder->remind_at->format('M d, H:i') }}</small>
                                    </div>
                                    @if($reminder->contact)
                                        <p class="text-sm text-muted mb-1">
                                            <strong>{{ $reminder->contact->full_name }}</strong>
                                            @if($reminder->company)
                                                at {{ $reminder->company->name }}
                                            @endif
                                        </p>
                                    @endif
                                    @if($reminder->description)
                                        <p class="text-sm text-muted mb-0">{{ Str::limit($reminder->description, 100) }}</p>
                                    @endif
                                    <div class="mt-1">
                                        <span class="badge bg-{{ $reminder->priority_color }} text-white">{{ $reminder->priority_label }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-bell-slash mb-2" style="font-size: 2rem; color: #a0aec0;"></i>
                                <p class="mb-0">No upcoming reminders</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-success text-white">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-sm bg-white bg-opacity-20 rounded-circle me-3">
                            <i class="fas fa-plus text-white"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 text-white">{{ __('Quick Actions') }}</h5>
                            <small class="text-white-50">{{ __('Common tasks to get you started') }}</small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="{{ route('admin.crm.contacts.create') }}" class="btn btn-outline-primary w-100 py-3">
                                <i class="fas fa-user-plus mb-2" style="font-size: 1.5rem;"></i>
                                <div>{{ __('Add Contact/Lead') }}</div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="{{ route('admin.crm.companies.create') }}" class="btn btn-outline-info w-100 py-3">
                                <i class="fas fa-building mb-2" style="font-size: 1.5rem;"></i>
                                <div>{{ __('Add Company') }}</div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="{{ route('admin.crm.activities.create') }}" class="btn btn-outline-warning w-100 py-3">
                                <i class="fas fa-history mb-2" style="font-size: 1.5rem;"></i>
                                <div>{{ __('Log Activity') }}</div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="{{ route('admin.crm.contacts.kanban') }}" class="btn btn-outline-success w-100 py-3">
                                <i class="fas fa-columns mb-2" style="font-size: 1.5rem;"></i>
                                <div>{{ __('View Pipeline') }}</div>
                            </a>
                        </div>
                    </div>
                </div>
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
    </style>
@endsection

@section('script')
<script>
$(document).ready(function() {
    console.log('CRM Dashboard loaded');
});
</script>
@endsection
