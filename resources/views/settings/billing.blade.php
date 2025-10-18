@extends('layouts.primary')

@section('head')
<style>
.plan-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    overflow: visible;
    margin-top: 15px;
}

.plan-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.plan-card.active {
    border: 2px solid #4f55da;
    box-shadow: 0 0.5rem 1rem rgba(79, 85, 218, 0.2);
}

.plan-card .card-header {
    min-height: 180px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px 12px 0 0;
}

.pricing-section h2, .pricing-section h3 {
    font-weight: 700;
}

.features-section .fas {
    font-size: 0.875rem;
}

.plan-details .border-end {
    border-right: 1px solid #dee2e6 !important;
}

/* Professional Button Styling */
.btn-subscribe {
    background-color: #4f55da;
    border: 1px solid #4f55da;
    color: white;
    border-radius: 6px;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s ease-in-out;
    display: inline-flex;
    align-items: center;
    text-decoration: none;
}

.btn-subscribe:hover {
    background-color: #3d44c7;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(79, 85, 218, 0.3);
    text-decoration: none;
}

.btn-contact {
    background-color: #28a745;
    border: 1px solid #28a745;
    color: white;
    border-radius: 6px;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s ease-in-out;
    display: inline-flex;
    align-items: center;
    text-decoration: none;
}

.btn-contact:hover {
    background-color: #218838;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(40, 167, 69, 0.3);
    text-decoration: none;
}

.btn-disabled {
    background-color: #6c757d;
    border: 1px solid #6c757d;
    color: white;
    border-radius: 6px;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: not-allowed;
    opacity: 0.6;
}

/* Cancel Subscription Button Styling */
.btn-outline-danger {
    border: 1px solid #dc3545;
    color: #dc3545;
    background-color: transparent;
    border-radius: 6px;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s ease-in-out;
    display: inline-flex;
    align-items: center;
    text-decoration: none;
}

.btn-outline-danger:hover {
    background-color: #dc3545;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);
    text-decoration: none;
}

.btn-outline-danger i {
    font-size: 0.875rem;
    margin-right: 0.5rem;
}

.active-badge {
    background: linear-gradient(135deg, #ffc107, #ff8c00);
    color: #000;
    font-weight: 600;
    animation: pulse 2s infinite;
    border: 2px solid #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    font-size: 0.875rem;
    white-space: nowrap;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

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
    color: #4f55da;
}

.price-period {
    font-size: 0.875rem;
    color: #6c757d;
}

/* Ensure equal height cards */
.row .col-lg-6 {
    display: flex;
}

.plan-card {
    width: 100%;
}

/* Badge positioning improvements */
.plan-card.active .card-header {
    position: relative;
}

@media (max-width: 768px) {
    .plan-card .card-header {
        padding: 1rem;
        min-height: 160px;
    }
    
    .plan-card .card-body {
        padding: 1rem;
    }
    
    .active-badge {
        font-size: 0.75rem;
        padding: 0.5rem 1rem;
    }
}
</style>
@endsection

@section('content')
        @if(!$workspace)
        <div class="row">
                <div class="col-md-8 mx-auto text-center">
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        {{__('Workspace not found. Please contact support.')}}
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-md-8 mx-auto text-center">
                    @if(session('warning'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ session('warning') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <span class="badge bg-info mb-3 px-3 py-2">{{__('Pricing and Plans')}}</span>
                    <h3 class="text-dark fw-bold">{{__('Ready to get started with StartupKit?')}}</h3>
                    <p class="text-muted">{{__('Choose the plan that best fits your needs.')}}</p>
                </div>
            </div>

        @if($workspace && \App\Models\Workspace::hasActiveSubscription($workspace))
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-credit-card text-primary me-2" style="font-size: 1.5rem;"></i>
                                <h5 class="fw-bold mb-0 text-dark">{{__('Billing Information')}}</h5>
                            </div>
                            
                            @if($plan)
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center mb-3">
                                            <span class="text-muted me-2">{{__('Current Plan:')}}</span>
                                            <span class="badge bg-primary text-white px-3 py-2 fw-bold">{{$plan->name}}</span>
                                        </div>

                            @if(!empty($workspace->next_renewal_date))
                                            <div class="d-flex align-items-center">
                                                <span class="text-muted me-2">{{__('Next renewal:')}}</span>
                                                <span class="fw-bold text-dark">{{date('M d, Y',strtotime($workspace->next_renewal_date))}}</span>
                                            </div>
                            @endif
                                    </div>

                                    <div class="col-md-6 text-md-end">
                            @if($plan)
                                            <button type="button" 
                                                    class="btn btn-outline-danger btn-sm"
                                                    onclick="confirmCancelSubscription({{$plan->id}}, '{{$plan->name}}')">
                                                <i class="fas fa-times me-2" style="font-size: 0.875rem;"></i>{{__('Cancel Subscription')}}
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row mt-4">
            @foreach($plans as $planItem)
                <div class="col-lg-6 col-md-6 mb-4 d-flex">
                    <div class="card h-100 plan-card {{ $workspace && \App\Models\Workspace::hasActiveSubscription($workspace) && $workspace->plan_id == $planItem->id ? 'active' : '' }}">
                        <!-- Plan Header -->
                        <div class="card-header position-relative" style="background: linear-gradient(135deg, {{$planItem->color_scheme == 'purple' ? '#6f42c1' : ($planItem->color_scheme == 'blue' ? '#007bff' : ($planItem->color_scheme == 'green' ? '#28a745' : ($planItem->color_scheme == 'orange' ? '#fd7e14' : '#dc3545')))}}, {{$planItem->color_scheme == 'purple' ? '#8e44ad' : ($planItem->color_scheme == 'blue' ? '#0056b3' : ($planItem->color_scheme == 'green' ? '#1e7e34' : ($planItem->color_scheme == 'orange' ? '#e55a00' : '#c82333')))}}); padding-top: 2rem; padding-bottom: 2rem;">
                            @if($workspace && \App\Models\Workspace::hasActiveSubscription($workspace) && $workspace->plan_id == $planItem->id)
                                <div class="position-absolute" style="top: -10px; left: 50%; transform: translateX(-50%); z-index: 10;">
                                    <span class="badge active-badge px-3 py-2 shadow-sm">
                                        <i class="fas fa-crown me-1"></i>{{__('Active Plan')}}
                                    </span>
                                </div>
                            @endif
                            
                            <div class="text-center text-white">
                                @if($planItem->icon)
                                    <div class="mb-3">
                                        <i class="feather {{$planItem->icon}} text-white" style="font-size: 2.5rem;"></i>
                                    </div>
                                @endif
                                
                                <h4 class="text-white mb-2 fw-bold">{{$planItem->name}}</h4>
                                
                                @if($planItem->subtitle)
                                    <p class="text-white-50 mb-3">{{$planItem->subtitle}}</p>
                                @elseif($planItem->description)
                                    <p class="text-white-50 mb-3">{!! $planItem->description !!}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Plan Body -->
                        <div class="card-body">
                            @if($planItem->features && is_object($planItem->features) && $planItem->features->count() > 0)
                                <div class="features-section">
                                    <h6 class="text-dark mb-3 fw-bold">{{__('Key Features')}}</h6>
                                    @foreach($planItem->features as $feature)
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
                                                @if($feature->description && $feature->description !== $feature->heading)
                                                    <div class="text-xs text-muted">{{$feature->description}}</div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @elseif($planItem->feature_categories && is_array($planItem->feature_categories))
                                <div class="features-section">
                                    <h6 class="text-dark mb-3 fw-bold">{{__('Key Features')}}</h6>
                                    @foreach($planItem->feature_categories as $category)
                                        @if(is_array($category) && isset($category['features']))
                                            @foreach($category['features'] as $feature)
                                                <div class="d-flex align-items-start mb-2">
                                                    <i class="fas fa-check me-2 mt-1" style="font-size: 16px; flex-shrink: 0; color: #4f55da;"></i>
                                                    <div class="flex-grow-1">
                                                        <span class="text-sm font-weight-bold">{{$feature}}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </div>
                            @endif

                            <!-- Plan Pricing -->
                            <div class="plan-pricing mt-3 pt-3 border-top">
                                @if($planItem->cta_type === 'contact')
                                    <div class="text-center">
                                        <h6 class="mb-1 fw-bold" style="color: #4f55da;">{{__('Custom Pricing')}}</h6>
                                        <p class="text-sm text-muted mb-2">{{__('Contact us for pricing')}}</p>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <h6 class="mb-2 fw-bold" style="color: #4f55da;">{{__('Starting at')}}</h6>
                                        <div class="pricing-display">
                                            @if($planItem->price_monthly > 0)
                                                <div class="price-item mb-2">
                                                    <span class="price-amount">{{formatCurrency($planItem->price_monthly,getWorkspaceCurrency($super_settings))}}</span>
                                                    <span class="price-period">/{{__('month')}}</span>
                                                </div>
                                            @endif
                                            @if($planItem->price_yearly > 0)
                                                <div class="price-item">
                                                    <span class="price-amount">{{formatCurrency($planItem->price_yearly,getWorkspaceCurrency($super_settings))}}</span>
                                                    <span class="price-period">/{{__('year')}}</span>
                                                </div>
                                            @endif
                                            @if($planItem->price_monthly == 0 && $planItem->price_yearly == 0)
                                                <div class="price-item">
                                                    <span class="price-amount" style="color: #28a745;">{{__('Free')}}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                            @endif
                            </div>
                        </div>

                        <!-- Plan Footer -->
                        <div class="card-footer bg-transparent border-top-0 text-center">
                            @if($workspace && \App\Models\Workspace::hasActiveSubscription($workspace) && $workspace->plan_id == $planItem->id)
                                <div class="mb-3">
                                    <span class="badge bg-success text-white px-3 py-2">
                                        <i class="fas fa-check-circle me-1"></i>{{__('Current Plan')}}
                                    </span>
                                </div>
                                
                                @if($planItem->cta_type == 'contact')
                                    <button class="btn btn-disabled" disabled>
                                        <i class="fas fa-phone me-1"></i>{{__('Contact Us')}}
                                    </button>
                                @else
                                    <button class="btn btn-disabled" disabled>
                                        <i class="fas fa-ban me-1"></i>{{__('Subscribe')}}
                                    </button>
                                @endif
                            @else
                                @if($planItem->cta_type == 'contact')
                                    <a href="https://grsventures.ltd/contact" class="btn btn-contact" target="_blank">
                                        <i class="fas fa-phone me-1"></i>{{__('Contact Us')}}
                                    </a>
                                @elseif($planItem->price_monthly > 0 || $planItem->price_yearly > 0)
                                    <div class="d-flex gap-2 justify-content-center">
                                        @if($planItem->price_monthly > 0)
                                            <a href="/subscribe?id={{$planItem->id}}&term=monthly" class="btn btn-subscribe">
                                                <i class="fas fa-calendar-alt me-1"></i>{{__('Monthly')}}
                                            </a>
                                @endif
                                        @if($planItem->price_yearly > 0)
                                            <a href="/subscribe?id={{$planItem->id}}&term=yearly" class="btn btn-subscribe">
                                                <i class="fas fa-calendar me-1"></i>{{__('Yearly')}}
                                            </a>
                                @endif
                                    </div>
                                @elseif($planItem->price_monthly == 0 && $planItem->price_yearly == 0)
                                    <a href="/subscribe?id={{$planItem->id}}&term=free_plan" class="btn btn-contact">
                                        <i class="fas fa-gift me-1"></i>{{__('Choose Free Plan')}}
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @endif
@endsection

@section('script')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmCancelSubscription(planId, planName) {
    Swal.fire({
        title: '{{__("Cancel Subscription")}}',
        html: `
            <div class="text-start">
                <p class="mb-3">{{__("Are you sure you want to cancel your subscription?")}}</p>
                <div class="alert alert-warning" style="color: #252f40 !important;">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>{{__("Warning:")}}</strong> {{__("This action will cancel your current plan and you may lose access to premium features.")}}
                </div>
                <p class="text-muted mb-0"><strong>{{__("Plan:")}}</strong> ${planName}</p>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-times me-1"></i>{{__("Yes, Cancel Subscription")}}',
        cancelButtonText: '<i class="fas fa-arrow-left me-1"></i>{{__("Keep Subscription")}}',
        reverseButtons: true,
        focusCancel: true,
        customClass: {
            popup: 'swal2-popup-custom',
            title: 'swal2-title-custom',
            content: 'swal2-content-custom'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: '{{__("Processing...")}}',
                text: '{{__("Please wait while we cancel your subscription.")}}',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Redirect to cancel URL
            window.location.href = `/cancel-subscription?id=${planId}`;
        }
    });
}
</script>

<style>
.swal2-popup-custom {
    border-radius: 12px !important;
}

.swal2-title-custom {
    color: #dc3545 !important;
    font-weight: 600 !important;
}

.swal2-content-custom {
    text-align: left !important;
}

.swal2-actions .swal2-confirm {
    border-radius: 6px !important;
    font-weight: 500 !important;
}

.swal2-actions .swal2-cancel {
    border-radius: 6px !important;
    font-weight: 500 !important;
}
</style>
@endsection

