@extends('layouts.super-admin-portal')

@section('head')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')

    <div class="container-fluid py-4">
        <div class="row">
        <div class="col-lg-12 col-12 mx-auto">
                <div class="card card-body">
                <div class="row mb-4">
                    <div class="col">
                        <h6 class="mb-0">{{__('Create New Subscription Plan')}}</h6>
                        <p class="text-sm mb-0">{{__('Design professional subscription plans with custom branding and features')}}</p>
                    </div>
                </div>

                <form id="planForm" data-action="/save-subscription-plan">
                        @if ($errors->any())
                            <div class="alert bg-pink-light text-danger">
                                <ul class="list-unstyled">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <hr class="horizontal dark my-3">

                    <!-- Plan Basic Information -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="planName" class="form-label">{{__('Plan Name')}} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" value="{{$plan->name ?? old('name') ?? ''}}" id="planName" placeholder="e.g., Self-Starter Plan">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="planType" class="form-label">{{__('Plan Type')}}</label>
                                <select class="form-control" name="plan_type" id="planType">
                                    @foreach($available_plan_types as $key => $value)
                                        <option value="{{$key}}" @if(($plan->plan_type ?? old('plan_type')) == $key) selected @endif>{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Plan Branding -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="icon" class="form-label">{{__('Icon')}}</label>
                                <select class="form-control" name="icon" id="icon">
                                    <option value="">{{__('Select Icon')}}</option>
                                    @foreach($available_icons as $key => $value)
                                        <option value="{{$key}}" @if(($plan->icon ?? old('icon')) == $key) selected @endif>{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                        <div class="mb-3">
                                <label for="badgeText" class="form-label">{{__('Badge Text')}}</label>
                                <input type="text" class="form-control" name="badge_text" value="{{$plan->badge_text ?? old('badge_text') ?? ''}}" id="badgeText" placeholder="e.g., Incubation Track">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="badgeColor" class="form-label">{{__('Badge Color')}}</label>
                                <select class="form-control" name="badge_color" id="badgeColor">
                                    @foreach($available_color_schemes as $key => $value)
                                        <option value="{{$key}}" @if(($plan->badge_color ?? old('badge_color') ?? 'purple') == $key) selected @endif>{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                            </div>

                    <!-- Plan Description -->
                    <div class="mb-3">
                        <label for="subtitle" class="form-label">{{__('Plan Subtitle/Description')}}</label>
                        <textarea class="form-control" name="subtitle" id="subtitle" rows="2" placeholder="Brief description of what this plan offers">{{$plan->subtitle ?? old('subtitle') ?? ''}}</textarea>
                    </div>

                    <!-- Pricing Section -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h6 class="mb-0">{{__('Pricing Configuration')}}</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="priceMonthly" class="form-label">{{__('Monthly Price')}} <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" step="0.01" class="form-control" name="price_monthly" value="{{$plan->price_monthly ?? old('price_monthly') ?? ''}}" id="priceMonthly" placeholder="24.99">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="priceYearly" class="form-label">{{__('Yearly Price')}} <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" step="0.01" class="form-control" name="price_yearly" value="{{$plan->price_yearly ?? old('price_yearly') ?? ''}}" id="priceYearly" placeholder="259.99">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="maximumAllowedUsers" class="form-label">{{__('Maximum Allowed Users')}} <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-users"></i></span>
                                            <input type="number" min="1" class="form-control" name="maximum_allowed_users" value="{{$plan->maximum_allowed_users ?? old('maximum_allowed_users') ?? '1'}}" id="maximumAllowedUsers" placeholder="5">
                                        </div>
                                        <div class="form-text">{{__('Maximum number of users allowed for this plan')}}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="planType" class="form-label">{{__('Plan Type')}}</label>
                                        <select class="form-control" name="plan_type" id="planType">
                                            <option value="standard" @if(($plan->plan_type ?? old('plan_type') ?? 'standard') == 'standard') selected @endif>{{__('Standard')}}</option>
                                            <option value="premium" @if(($plan->plan_type ?? old('plan_type')) == 'premium') selected @endif>{{__('Premium')}}</option>
                                            <option value="enterprise" @if(($plan->plan_type ?? old('plan_type')) == 'enterprise') selected @endif>{{__('Enterprise')}}</option>
                                            <option value="incubation" @if(($plan->plan_type ?? old('plan_type')) == 'incubation') selected @endif>{{__('Incubation Track')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                            </div>

                    <!-- Sort Order -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                <label for="sortOrder" class="form-label">{{__('Sort Order')}}</label>
                                <input type="number" class="form-control" name="sort_order" value="{{$plan->sort_order ?? old('sort_order') ?? 0}}" id="sortOrder" placeholder="0" min="0">
                                <small class="text-muted">{{__('Lower numbers appear first. Default is 0.')}}</small>
                                        </div>
                                    </div>
                                </div>

                    <!-- Plan Features -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h6 class="mb-0">{{__('Plan Features')}}</h6>
                            <p class="text-sm mb-0">{{__('Add features with icons and descriptions that will be displayed on the plan card')}}</p>
                        </div>
                        <div class="card-body">
                            <div id="div_features">
                                @if($plan && $plan->features && is_object($plan->features) && $plan->features->count() > 0)
                                    @foreach($plan->features as $feature)
                                        <div class="row feature_row mb-3 p-3 border rounded">
                                            <div class="col-md-3">
                                                <label class="form-label">{{__('Icon')}}</label>
                                                <select class="form-control feature-icon" name="feature_icons[]">
                                                    <option value="feather-brain" @if($feature->icon == 'feather-brain') selected @endif>{{__('Brain (Planning)')}}</option>
                                                    <option value="feather-bar-chart-2" @if($feature->icon == 'feather-bar-chart-2') selected @endif>{{__('Chart (Execution)')}}</option>
                                                    <option value="feather-users" @if($feature->icon == 'feather-users') selected @endif>{{__('Users (Collaboration)')}}</option>
                                                    <option value="feather-file-text" @if($feature->icon == 'feather-file-text') selected @endif>{{__('Document (Reporting)')}}</option>
                                                    <option value="feather-unlock" @if($feature->icon == 'feather-unlock') selected @endif>{{__('Unlock (Flexibility)')}}</option>
                                                    <option value="feather-check-circle" @if($feature->icon == 'feather-check-circle') selected @endif>{{__('Check (Access)')}}</option>
                                                    <option value="feather-rocket" @if($feature->icon == 'feather-rocket') selected @endif>{{__('Rocket (Development)')}}</option>
                                                    <option value="feather-trending-up" @if($feature->icon == 'feather-trending-up') selected @endif>{{__('Trending (Strategy)')}}</option>
                                                    <option value="feather-dollar-sign" @if($feature->icon == 'feather-dollar-sign') selected @endif>{{__('Dollar (Fundraising)')}}</option>
                                                    <option value="feather-user" @if($feature->icon == 'feather-user') selected @endif>{{__('User (Mentorship)')}}</option>
                                                    <option value="feather-shield" @if($feature->icon == 'feather-shield') selected @endif>{{__('Shield (Security)')}}</option>
                                                    <option value="feather-headphones" @if($feature->icon == 'feather-headphones') selected @endif>{{__('Headphones (Support)')}}</option>
                                                    <option value="feather-settings" @if($feature->icon == 'feather-settings') selected @endif>{{__('Settings (Integration)')}}</option>
                                                    <option value="feather-award" @if($feature->icon == 'feather-award') selected @endif>{{__('Award (Training)')}}</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">{{__('Feature Heading')}}</label>
                                                <input type="text" class="form-control feature-heading" name="feature_headings[]" 
                                                       value="{{$feature->heading}}" 
                                                       placeholder="e.g., Advanced Planning">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">{{__('Actions')}}</label>
                                                <div>
                                                    <button type="button" class="btn btn-sm btn-danger btn_remove_feature">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <label class="form-label">{{__('Feature Description')}}</label>
                                                <input type="text" class="form-control feature-description" name="features[]" 
                                                       value="{{$feature->description}}" 
                                                       placeholder="e.g., Business Model Canvas, Financial Forecasts, SWOT, Roadmap, McKinsey 7S">
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                <div class="row feature_row mb-3 p-3 border rounded">
                                    <div class="col-md-3">
                                        <label class="form-label">{{__('Icon')}}</label>
                                        <select class="form-control feature-icon" name="feature_icons[]">
                                            <option value="feather-brain">{{__('Brain (Planning)')}}</option>
                                            <option value="feather-bar-chart-2">{{__('Chart (Execution)')}}</option>
                                            <option value="feather-users">{{__('Users (Collaboration)')}}</option>
                                            <option value="feather-file-text">{{__('Document (Reporting)')}}</option>
                                            <option value="feather-unlock">{{__('Unlock (Flexibility)')}}</option>
                                            <option value="feather-check-circle">{{__('Check (Access)')}}</option>
                                            <option value="feather-rocket">{{__('Rocket (Development)')}}</option>
                                            <option value="feather-trending-up">{{__('Trending (Strategy)')}}</option>
                                            <option value="feather-dollar-sign">{{__('Dollar (Fundraising)')}}</option>
                                            <option value="feather-user">{{__('User (Mentorship)')}}</option>
                                            <option value="feather-shield">{{__('Shield (Security)')}}</option>
                                            <option value="feather-headphones">{{__('Headphones (Support)')}}</option>
                                            <option value="feather-settings">{{__('Settings (Integration)')}}</option>
                                            <option value="feather-award">{{__('Award (Training)')}}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{__('Feature Heading')}}</label>
                                        <input type="text" class="form-control feature-heading" name="feature_headings[]" placeholder="e.g., Advanced Planning">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">{{__('Actions')}}</label>
                                        <div>
                                            <button type="button" class="btn btn-sm btn-danger btn_remove_feature">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <label class="form-label">{{__('Feature Description')}}</label>
                                        <input type="text" class="form-control feature-description" name="features[]" placeholder="e.g., Business Model Canvas, Financial Forecasts, SWOT, Roadmap, McKinsey 7S">
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-success" id="btn_add_feature">
                                <i class="fas fa-plus"></i> {{__('Add Feature')}}
                            </button>
                        </div>
                    </div>

                    {{-- Call to Action Configuration - Commented out for now
                    <div class="card mt-4">
                        <div class="card-header">
                            <h6 class="mb-0">{{__('Call to Action Configuration')}}</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="ctaText" class="form-label">{{__('Button Text')}}</label>
                                        <input type="text" class="form-control" name="cta_text" value="{{$plan->cta_text ?? old('cta_text') ?? 'Get Started'}}" id="ctaText" placeholder="Get Started">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="ctaType" class="form-label">{{__('Button Type')}}</label>
                                        <select class="form-control" name="cta_type" id="ctaType">
                                            @foreach($available_cta_types as $key => $value)
                                                <option value="{{$key}}" @if(($plan->cta_type ?? old('cta_type') ?? 'button') == $key) selected @endif>{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="ctaUrl" class="form-label">{{__('Custom URL')}}</label>
                                        <input type="url" class="form-control" name="cta_url" value="{{$plan->cta_url ?? old('cta_url') ?? ''}}" id="ctaUrl" placeholder="https://example.com/apply">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    --}}

                    {{-- Special Configuration - Commented out for now
                    <div class="card mt-4">
                        <div class="card-header">
                            <h6 class="mb-0">{{__('Special Configuration')}}</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="is_equity_based" id="isEquityBased" @if($plan->is_equity_based ?? old('is_equity_based')) checked @endif>
                                        <label class="form-check-label" for="isEquityBased">
                                            {{__('Equity-Based Plan')}}
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="requires_application" id="requiresApplication" @if($plan->requires_application ?? old('requires_application')) checked @endif>
                                        <label class="form-check-label" for="requiresApplication">
                                            {{__('Requires Application')}}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="specialConditions" class="form-label">{{__('Special Conditions')}}</label>
                                        <textarea class="form-control" name="special_conditions" id="specialConditions" rows="3" placeholder="Any special conditions or requirements">{{$plan->special_conditions ?? old('special_conditions') ?? ''}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    --}}

                    {{-- Technical Configuration - Commented out for now
                    <div class="card mt-4">
                        <div class="card-header">
                            <h6 class="mb-0">{{__('Technical Configuration')}}</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="maxUsers" class="form-label">{{__('Maximum Users')}} <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="maximum_allowed_users" value="{{$plan->maximum_allowed_users ?? old('maximum_allowed_users') ?? ''}}" id="maxUsers" placeholder="10">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="maxFileSize" class="form-label">{{__('Max File Upload Size')}} (KB)</label>
                                        <input type="number" class="form-control" name="max_file_upload_size" value="{{$plan->max_file_upload_size ?? old('max_file_upload_size') ?? ''}}" id="maxFileSize" placeholder="10240">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="fileSpaceLimit" class="form-label">{{__('File Space Limit')}} (MB)</label>
                                        <input type="number" class="form-control" name="file_space_limit" value="{{$plan->file_space_limit ?? old('file_space_limit') ?? ''}}" id="fileSpaceLimit" placeholder="1000">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sortOrder" class="form-label">{{__('Sort Order')}}</label>
                                        <input type="number" class="form-control" name="sort_order" value="{{$plan->sort_order ?? old('sort_order') ?? 0}}" id="sortOrder" placeholder="0">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="colorScheme" class="form-label">{{__('Color Scheme')}}</label>
                                        <select class="form-control" name="color_scheme" id="colorScheme">
                                            @foreach($available_color_schemes as $key => $value)
                                                <option value="{{$key}}" @if(($plan->color_scheme ?? old('color_scheme') ?? 'purple') == $key) selected @endif>{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    --}}

                    {{-- Payment Gateway Configuration - Commented out for now
                    <div class="card mt-4">
                        <div class="card-header">
                            <h6 class="mb-0">{{__('Payment Gateway Configuration')}}</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="paypalPlanId" class="form-label">{{__('PayPal Plan ID')}}</label>
                                        <input type="text" class="form-control" name="paypal_plan_id" value="{{$plan->paypal_plan_id ?? old('paypal_plan_id') ?? ''}}" id="paypalPlanId" placeholder="P-XXXXXXXX">
                                    </div>
                                </div>
                                @if(\App\Models\PaymentGateway::hasPayStack())
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="paystackMonthlyPlanId" class="form-label">{{__('PayStack Monthly Plan ID')}}</label>
                                        <input type="text" class="form-control" name="paystack_monthly_plan_id" value="{{$plan->paystack_monthly_plan_id ?? old('paystack_monthly_plan_id') ?? ''}}" id="paystackMonthlyPlanId" placeholder="PLN_XXXXXXXX">
                                    </div>
                                </div>
                                @endif
                            </div>
                            @if(\App\Models\PaymentGateway::hasPayStack())
                            <div class="row">
                                <div class="col-md-6">
                        <div class="mb-3">
                                        <label for="paystackYearlyPlanId" class="form-label">{{__('PayStack Yearly Plan ID')}}</label>
                                        <input type="text" class="form-control" name="paystack_yearly_plan_id" value="{{$plan->paystack_yearly_plan_id ?? old('paystack_yearly_plan_id') ?? ''}}" id="paystackYearlyPlanId" placeholder="PLN_XXXXXXXX">
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    --}}

                    <!-- Modules Configuration -->
                    {{-- <div class="card mt-4">
                        <div class="card-header">
                            <h6 class="mb-0">{{__('Available Modules')}}</h6>
                            <p class="text-sm mb-0">{{__('Select which modules are available in this plan')}}</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($available_modules as $key => $value)
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="{{$key}}" value="1" id="module_{{$key}}" @if(!empty($plan_modules) && in_array($key,$plan_modules)) checked @endif>
                                            <label class="form-check-label" for="module_{{$key}}">
                                                {{$value}}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div> --}}

                    {{-- Plan Description (Rich Text) - Commented out for now
                    <div class="card mt-4">
                        <div class="card-header">
                            <h6 class="mb-0">{{__('Detailed Description')}}</h6>
                            <p class="text-sm mb-0">{{__('Rich text description for the plan (optional)')}}</p>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <textarea class="form-control" rows="10" id="description" name="description">@if(!empty($plan)){{$plan->description}}@endif</textarea>
                            </div>
                        </div>
                    </div>
                    --}}

                        @csrf
                        @if($plan)
                            <input type="hidden" name="id" value="{{$plan->id}}">
                        @endif

                    <div class="d-flex justify-content-between mt-4">
                        <a href="/subscription-plans" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> {{__('Back to Plans')}}
                        </a>
                        <button type="submit" class="btn btn-info" id="savePlanBtn">
                            <i class="fas fa-save"></i> {{__('Save Plan')}}
                        </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(function () {
            "use strict";
        
        // Initialize TinyMCE for description
            tinymce.init({
                selector: '#description',
            plugins: 'table,code,lists,link,image',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image | code',
            height: 300,
        });

        // Feature management
            let $btn_add_feature = $('#btn_add_feature');
            let $div_features = $('#div_features');

            $btn_add_feature.on('click', function (event) {
                event.preventDefault();
            $div_features.append(`
                <div class="row feature_row mb-3 p-3 border rounded">
                    <div class="col-md-3">
                        <label class="form-label">{{__('Icon')}}</label>
                        <select class="form-control feature-icon" name="feature_icons[]">
                            <option value="feather-brain">{{__('Brain (Planning)')}}</option>
                            <option value="feather-bar-chart-2">{{__('Chart (Execution)')}}</option>
                            <option value="feather-users">{{__('Users (Collaboration)')}}</option>
                            <option value="feather-file-text">{{__('Document (Reporting)')}}</option>
                            <option value="feather-unlock">{{__('Unlock (Flexibility)')}}</option>
                            <option value="feather-check-circle">{{__('Check (Access)')}}</option>
                            <option value="feather-rocket">{{__('Rocket (Development)')}}</option>
                            <option value="feather-trending-up">{{__('Trending (Strategy)')}}</option>
                            <option value="feather-dollar-sign">{{__('Dollar (Fundraising)')}}</option>
                            <option value="feather-user">{{__('User (Mentorship)')}}</option>
                            <option value="feather-shield">{{__('Shield (Security)')}}</option>
                            <option value="feather-headphones">{{__('Headphones (Support)')}}</option>
                            <option value="feather-settings">{{__('Settings (Integration)')}}</option>
                            <option value="feather-award">{{__('Award (Training)')}}</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{__('Feature Heading')}}</label>
                        <input type="text" class="form-control feature-heading" name="feature_headings[]" placeholder="e.g., Advanced Planning">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{__('Actions')}}</label>
                        <div>
                            <button type="button" class="btn btn-sm btn-danger btn_remove_feature">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <label class="form-label">{{__('Feature Description')}}</label>
                        <input type="text" class="form-control feature-description" name="features[]" placeholder="e.g., Business Model Canvas, Financial Forecasts, SWOT, Roadmap, McKinsey 7S">
                    </div>
                </div>
            `);
        });

        $(document).on('click', '.btn_remove_feature', function (event) {
                event.preventDefault();
                $(this).closest('.feature_row').remove();
            });

        // AJAX Form Submission with Professional Loading States
        $('#planForm').on('submit', function(e) {
            e.preventDefault();
            
            let isValid = true;
            let errorMessages = [];
            
            // Check required fields
            if (!$('#planName').val().trim()) {
                errorMessages.push('Plan name is required');
                isValid = false;
            }
            
            if (!$('#priceMonthly').val()) {
                errorMessages.push('Monthly price is required');
                isValid = false;
            }
            
            if (!$('#priceYearly').val()) {
                errorMessages.push('Yearly price is required');
                isValid = false;
            }
            
            if (!isValid) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: errorMessages.join('<br>'),
                    confirmButtonColor: '#6f42c1'
                });
                return;
            }
            
            // Show loading state
            const saveBtn = $('#savePlanBtn');
            const originalText = saveBtn.html();
            const originalDisabled = saveBtn.prop('disabled');
            
            saveBtn.prop('disabled', true).html(`
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                {{__('Saving...')}}
            `);
            
            // Prepare form data
            const formData = new FormData(this);
            
            // Send AJAX request
            $.ajax({
                url: $(this).data('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': window.csrf_token
                },
                success: function(response) {
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: '{{__('Success!')}}',
                        text: '{{__('Plan saved successfully!')}}',
                        confirmButtonColor: '#6f42c1',
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: true
                    }).then((result) => {
                        // Redirect after message is shown
                        window.location.href = '/subscription-plans';
                    });
                },
                error: function(xhr) {
                    let errorMessage = '{{__('An error occurred while saving the plan.')}}';
                    
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        const errorList = Object.values(errors).flat().join('<br>');
                        errorMessage = errorList;
                    }
                    
                    // Show error message
                    Swal.fire({
                        icon: 'error',
                        title: '{{__('Error!')}}',
                        html: errorMessage,
                        confirmButtonColor: '#dc3545'
                    });
                },
                complete: function() {
                    // Restore button state
                    saveBtn.prop('disabled', originalDisabled).html(originalText);
                }
            });
            });
        });
    </script>
@endsection
