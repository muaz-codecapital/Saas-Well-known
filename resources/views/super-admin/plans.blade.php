@extends('layouts.super-admin-portal')
@section('content')

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h5 class="fw-bolder text-secondary">
                {{__('Subscription Plans Management')}}
            </h5>
            <p class="text-muted">{{__('Create, edit and manage your subscription plans with professional customization')}}</p>
        </div>
        <div class="col text-end">
            @if($plans->count() >= 2)
                <button type="button" class="btn btn-secondary" disabled title="{{__('Maximum of 2 plans allowed')}}">
                    <i class="fas fa-plus"></i> {{__('Create New Plan')}}
                </button>
            @else
                <a href="/subscription-plan" type="button" class="btn btn-info">
                    <i class="fas fa-plus"></i> {{__('Create New Plan')}}
                </a>
            @endif
        </div>
    </div>

    <!-- Plan Limit Warning -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-info" style="color: white !important">
                <i class="fas fa-info-circle me-2"></i>
                <strong>{{__('Note:')}}</strong> {{__('You can create a maximum of 2 subscription plans. One with pricing and one "Contact Us" plan.')}}
            </div>
        </div>
    </div>

    @if($plans->count() > 0)
    <div class="row">
        @foreach($plans as $plan)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 plan-card">
                        <!-- Plan Header -->
                        <div class="card-header position-relative" style="background: linear-gradient(135deg, {{$plan->color_scheme == 'purple' ? '#6f42c1' : ($plan->color_scheme == 'blue' ? '#007bff' : ($plan->color_scheme == 'green' ? '#28a745' : ($plan->color_scheme == 'orange' ? '#fd7e14' : '#dc3545')))}}, {{$plan->color_scheme == 'purple' ? '#8e44ad' : ($plan->color_scheme == 'blue' ? '#0056b3' : ($plan->color_scheme == 'green' ? '#1e7e34' : ($plan->color_scheme == 'orange' ? '#e55a00' : '#c82333')))}});">
                            @if($plan->badge_text)
                                <div class="position-absolute top-0 start-0 m-2">
                                    <span class="badge bg-light text-dark">{{$plan->badge_text}}</span>
                                </div>
                            @endif
                            
                            <div class="text-center text-white" style="margin-top: 40px !important;">
                                @if($plan->icon)
                                    <div class="mb-3">
                                        <i class="feather {{$plan->icon}} text-white" style="font-size: 2.5rem;"></i>
                    </div>
                                @endif
                                
                                <h4 class="text-white mb-2">{{$plan->name}}</h4>
                                
                                @if($plan->subtitle)
                                    <p class="text-white-50 mb-3">{{$plan->subtitle}}</p>
                                @endif
                                
                                {{-- <div class="pricing-section">
                                    <div class="d-flex justify-content-center align-items-baseline">
                                        <h2 class="text-white mb-0">${{number_format($plan->price_monthly, 2)}}</h2>
                                        <span class="text-white-50 ms-2">/month</span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-baseline">
                                        <h3 class="text-white mb-0">${{number_format($plan->price_yearly, 2)}}</h3>
                                        <span class="text-white-50 ms-2">/year</span>
                                    </div>
                                </div> --}}
                            </div>
                        </div>

                        <!-- Plan Body -->
                        <div class="card-body">
                            @if($plan->features && is_object($plan->features) && $plan->features->count() > 0)
                                <div class="features-section">
                                    <h6 class="text-dark mb-3">{{__('Key Features')}}</h6>
                                    @foreach($plan->features as $feature)
                                        <div class="d-flex align-items-start mb-2">
                                            @php
                                                $iconMap = [
                                                    'feather-brain' => 'fas fa-brain',
                                                    'feather-bar-chart-2' => 'fas fa-chart-bar',
                                                    'feather-users' => 'fas fa-users',
                                                    'feather-file-text' => 'fas fa-file-alt',
                                                    'feather-unlock' => 'fas fa-unlock',
                                                    'feather-check-circle' => 'fas fa-check-circle',
                                                    'feather-shield' => 'fas fa-shield-alt',
                                                    'feather-headphones' => 'fas fa-headphones',
                                                    'feather-settings' => 'fas fa-cog',
                                                    'feather-award' => 'fas fa-award',
                                                    'feather-rocket' => 'fas fa-rocket',
                                                    'feather-trending-up' => 'fas fa-trending-up',
                                                    'feather-dollar-sign' => 'fas fa-dollar-sign',
                                                    'feather-user' => 'fas fa-user'
                                                ];
                                                $iconClass = $iconMap[$feature->icon] ?? 'fas fa-check';
                                            @endphp
                                            <i class="{{$iconClass}} me-2 mt-1" style="font-size: 16px; flex-shrink: 0; color: #4f55da;" title="Icon: {{$feature->icon}}"></i>
                                            <div class="flex-grow-1">
                                                <span class="text-sm font-weight-bold">{{$feature->heading}}</span>
                                                @if($feature->description !== $feature->heading)
                                                    <div class="text-xs text-muted">{{$feature->description}}</div>
                                                @endif
                                    </div>
                                </div>
                            @endforeach
                                </div>
                            @endif

                            <!-- Plan Pricing -->
                            <div class="plan-pricing mt-3 pt-3 border-top">
                                @if($plan->cta_type === 'contact')
                                    <div class="text-center">
                                        <h6 class="mb-1 fw-bold" style="color: #4f55da;">{{__('Custom Pricing')}}</h6>
                                        <p class="text-sm text-muted mb-2">{{__('Contact us for pricing')}}</p>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <h6 class="mb-2 fw-bold" style="color: #4f55da;">{{__('Starting at')}}</h6>
                                        <div class="pricing-display">
                                            <div class="price-item mb-2">
                                                <span class="price-amount fw-bold" style="color: #4f55da;">${{number_format($plan->price_monthly, 2)}}</span>
                                                <span class="price-period text-muted">/{{__('month')}}</span>
                                            </div>
                                            <div class="price-item">
                                                <span class="price-amount fw-bold" style="color: #4f55da;">${{number_format($plan->price_yearly, 2)}}</span>
                                                <span class="price-period text-muted">/{{__('year')}}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Special Conditions -->
                            {{-- @if($plan->special_conditions || $plan->is_equity_based || $plan->requires_application)
                                <div class="special-conditions mt-3 p-3 bg-light rounded">
                                    @if($plan->is_equity_based)
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-handshake text-warning me-2"></i>
                                            <span class="text-sm fw-bold">{{__('Equity-Based')}}</span>
                                        </div>
                                    @endif
                                    
                                    @if($plan->requires_application)
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-clipboard-check text-info me-2"></i>
                                            <span class="text-sm">{{__('Application Required')}}</span>
                                        </div>
                                    @endif
                                    
                                    @if($plan->special_conditions)
                                        <p class="text-sm text-muted mb-0">{{$plan->special_conditions}}</p>
                                    @endif
                                </div>
                            @endif --}}
                        </div>

                        <!-- Plan Footer -->
                        <div class="card-footer bg-transparent border-top-0">
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="plan-actions">
                                    <a href="/subscription-plan?id={{$plan->id}}" class="btn btn-sm btn-edit me-2" title="{{__('Edit Plan')}}">
                                        <i class="fas fa-edit me-1"></i>
                                        {{__('Edit')}}
                                    </a>
                                    <a href="#" class="btn btn-sm btn-delete" title="{{__('Delete Plan')}}" onclick="confirmDelete({{$plan->id}}, '{{$plan->name}}')">
                                        <i class="fas fa-trash me-1"></i>
                                        {{__('Delete')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-credit-card text-muted" style="font-size: 4rem;"></i>
                        </div>
                        <h5 class="text-muted mb-3">{{__('No Subscription Plans Found')}}</h5>
                        <p class="text-muted mb-4">{{__('Create your first subscription plan to get started with professional plan management.')}}</p>
                        <a href="/subscription-plan" class="btn btn-info">
                            <i class="fas fa-plus"></i> {{__('Create Your First Plan')}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
    </div>

<style>
.plan-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    overflow: hidden;
}

.plan-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.pricing-section h2, .pricing-section h3 {
    font-weight: 700;
}

.features-section .fas.fa-check-circle {
    font-size: 0.875rem;
}

.plan-details .border-end {
    border-right: 1px solid #dee2e6 !important;
}

.special-conditions {
    border-left: 3px solid #6f42c1;
}

/* Custom Pricing Box */
.custom-pricing-box {
    background-color: #f8f9fa;
    border: 1px solid #e9ecef;
    border-left: 3px solid #6f42c1;
    border-radius: 6px;
    padding: 0.75rem;
    margin-top: 0.5rem;
}

/* Pricing Display */
.pricing-display {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.price-item {
    display: flex;
    align-items: baseline;
    gap: 0.25rem;
}

.price-amount {
    font-size: 1.25rem;
    font-weight: 700;
}

.price-period {
    font-size: 0.875rem;
}

/* Professional Button Styling */
.btn-edit {
    background-color: transparent;
    border: 1px solid #6f42c1;
    color: #6f42c1;
    border-radius: 6px;
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s ease-in-out;
    display: inline-flex;
    align-items: center;
    text-decoration: none;
}

.btn-edit:hover {
    background-color: #6f42c1;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(111, 66, 193, 0.3);
    text-decoration: none;
}

.btn-edit i {
    font-size: 0.875rem;
    margin-right: 0.25rem;
}

.btn-delete {
    background-color: transparent;
    border: 1px solid #dc3545;
    color: #dc3545;
    border-radius: 6px;
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s ease-in-out;
    display: inline-flex;
    align-items: center;
    text-decoration: none;
}

.btn-delete:hover {
    background-color: #dc3545;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);
    text-decoration: none;
}

.btn-delete i {
    font-size: 0.875rem;
    margin-right: 0.25rem;
}

@media (max-width: 768px) {
    .plan-card .card-header {
        padding: 1rem;
    }
    
    .plan-card .card-body {
        padding: 1rem;
    }
    
    .plan-actions {
        margin-top: 1rem;
        flex-direction: column;
        width: 100%;
    }
    
    .plan-actions .btn {
        width: 100%;
        margin-bottom: 0.5rem;
        margin-right: 0 !important;
    }
}
</style>

@endsection

@section('script')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(planId, planName) {
    Swal.fire({
        title: '{{__("Are you sure?")}}',
        text: `{{__("You are about to delete the plan")}} "${planName}". {{__("This action cannot be undone!")}}`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '{{__("Yes, delete it!")}}',
        cancelButtonText: '{{__("Cancel")}}',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: '{{__("Deleting...")}}',
                text: '{{__("Please wait while we delete the plan.")}}',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Redirect to delete URL
            window.location.href = `/delete/subscription-plan/${planId}`;
        }
    });
}
</script>
@endsection