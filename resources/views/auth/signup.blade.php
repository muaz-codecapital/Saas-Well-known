<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        {{__('Signup')}}-{{config('app.name')}}
    </title>
    @if(!empty($super_settings['favicon']))

        <link rel="icon" type="image/png" href="{{PUBLIC_DIR}}/uploads/{{$super_settings['favicon']}}">
    @endif
    <link id="pagestyle" href="{{PUBLIC_DIR}}/css/app.css" rel="stylesheet"/>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .subscription-card { cursor: pointer; transition: box-shadow .2s, transform .2s, border-color .2s; border: 1px solid rgba(0,0,0,.075); }
        .subscription-card:hover { box-shadow: 0 0.75rem 1.5rem rgba(0,0,0,.08); transform: translateY(-2px); }
        .subscription-card.selected { border-color: #4f55da; box-shadow: 0 0 0 .2rem rgba(111,66,193,.15); }
        @media (max-width: 767.98px) {
            .subscription-card .card-body { padding: 1rem; }
        }
        
        /* Enhanced styling to match static design */
        .subscription-card { 
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,.1);
        }
        
        /* Badge styling to match static design */
        .subscription-card .badge {
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.5rem 0.75rem;
            background-color: #f8f9fa !important;
            color: #000 !important;
            border: 1px solid #e9ecef;
        }
        
        /* Icon styling to match static design */
        .subscription-card .icon-shape {
            width: 48px;
            height: 48px;
            background-color: #e9d5ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        .subscription-card .icon-shape i {
            color: #4f55da !important;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            margin: 0;
            padding: 0;
        }
        
        /* Feature icon styling */
        .subscription-card .feature-icon {
            color: #4f55da;
            font-size: 16px;
        }
        
        /* Plan name styling */
        .subscription-card .plan-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }
        
        /* Feature styling */
        .subscription-card .feature-item {
            margin-bottom: 0.75rem;
        }
        
        .subscription-card .feature-title {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.25rem;
        }
        
        .subscription-card .feature-description {
            color: #718096;
            font-size: 0.875rem;
            line-height: 1.4;
        }
        
        /* Reduce spacing between features and pricing */
        .subscription-card .card-footer {
            margin-top: 0.5rem !important;
            padding-top: 1rem !important;
        }
        
        /* Professional dropdown styling with proper alignment */
        .form-control {
            background-color: white !important;
            border: 1px solid #e9ecef;
            border-radius: 0.375rem;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            line-height: 1.5;
            color: #495057;
            text-indent: 0;
        }
        
        /* Use global focus styles (same as login) */
        
        select.form-control {
            background-color: white !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
            appearance: none;
        }
        
        select.form-control option {
            background-color: white;
            color: #495057;
            padding: 0.75rem 1rem;
            text-align: left;
        }
        
        .input-group-text {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-right: none;
            color: #4f55da;
            /* color: #6f42c1; */
            min-width: 45px;
            justify-content: center;
            display: flex;
            align-items: center;
        }
        
        .input-group .form-control {
            border-left: none;
            padding-left: 8px !important;
        }
        
        .input-group:focus-within .input-group-text {
            border-color: #4f55da;
            background-color: #f8f9fa;
        }
        
        /* Ensure proper text alignment in input groups */
        .input-group .form-control::placeholder {
            color: #6c757d;
            opacity: 1;
        }
        
        /* Fix cursor positioning */
        .input-group .form-control {
            text-indent: 0;
            padding-left: 1rem;
        }
        
        /* Consistent color scheme */
        .bg-light-info {
            background-color: rgba(111, 66, 193, 0.1) !important;
        }
        
        .card-header h6 {
            color: #4f55da !important;
        }

        .btn-outline-primary{
            color: #4f55da !important;
            border-color: #4f55da !important;   
        }
        
        /* Subscription card styling consistency */
        .subscription-card .icon-shape {
            background-color: rgba(111, 66, 193, 0.1) !important;
        }
        
        .subscription-card .feather {
            color: #4f55da !important;
        }
        
        /* Duration selection styling */
        .duration-selection {
            display: none;
            margin-top: 1rem;
            padding: 1rem;
            background-color: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }
        
        .duration-selection.show {
            display: block;
        }
        
        .duration-option {
            margin-bottom: 0.5rem;
        }
        
        .duration-option input[type="radio"] {
            margin-right: 0.5rem;
        }
        
        .duration-option label {
            font-weight: 500;
            cursor: pointer;
        }
        
        /* Loading spinner */
        .btn-loading {
            position: relative;
        }
        
        .btn-loading .spinner {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 0.5rem;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Inline validation error styling */
        .form-control.is-invalid {
            border-color: #dc3545;
        }
        
        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875rem;
            color: #dc3545;
        }
        
        .valid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875rem;
            color: #28a745;
        }
    </style>

    @if(!empty($super_settings['config_recaptcha_in_user_signup']))
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
</head>
<body class="g-sidenav-show  bg-gray-100">
{{-- @if(($super_settings['landingpage'] ?? null) === 'Default')
    <nav class="navbar navbar-expand-lg top-0 z-index-3 w-100 shadow-blur  bg-gray-100 fixed-top ">
        <div class="container mt-1">

            <a class="navbar-brand text-dark bg-transparent fw-bolder" href="/" rel="tooltip" title="" data-placement="bottom">
                @if(!empty($super_settings['logo']))
                    <img src="{{PUBLIC_DIR}}/uploads/{{$super_settings['logo']}}" class="navbar-brand-img h-100" style="max-height: {{$super_settings['frontend_logo_max_height'] ?? '30'}}px;" alt="...">
                @else
                    <span class=" font-weight-bold">{{config('app.name')}}</span>
                @endif
            </a>

            <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon mt-2">
            <span class="navbar-toggler-bar bar1"></span>
            <span class="navbar-toggler-bar bar2"></span>
            <span class="navbar-toggler-bar bar3"></span>
            </span>
            </button>

            <div class="collapse  navbar-collapse w-100 pt-3 pb-2 py-lg-0 ms-lg-12 " id="navigation">
                <ul class="navbar-nav bg-transparent navbar-nav-hover w-100">

                    <li class="nav-item float-end ms-5 ms-lg-auto">
                        <a  href="/" class="fw-bolder h6 ps-2 d-flex justify-content-between cursor-pointer align-items-center">
                            {{__('Home')}}

                        </a>
                    </li>

                    <li class="nav-item float-end ms-5 ms-lg-auto">
                        <a class=" fw-bolder h6 ps-2 d-flex justify-content-between cursor-pointer align-items-center me-2" href="/pricing" target="_blank">
                            {{__('Pricing')}}

                        </a>
                    </li>
                    <li class="nav-item float-end ms-5 ms-lg-auto">
                        <a class=" fw-bolder h6 ps-2 d-flex justify-content-between cursor-pointer align-items-center me-2" href="/blog" target="_blank">
                            {{__('Blog')}}

                        </a>
                    </li>
                    <li class="nav-item float-end ms-5 ms-lg-auto">
                        <a class="fw-bolder h6 ps-2 d-flex justify-content-between cursor-pointer align-items-center me-5" href="/login" target="_blank">

                            {{__('Login')}}

                        </a>
                    </li>

                    <li class="nav-item my-auto ms-3 ms-lg-0">
                        <a href="/signup" class="btn bg-dark text-white mb-0 me-1 mt-2 mt-md-0">{{__('Sign Up for free')}}</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
@endif --}}

<section>
    <div class="page-header section-height-75">
        <div class="container ">
                <div class="row justify-content-center">
                <!--
                <div class="col-md-7 d-none d-md-flex flex-column justify-content-center">
                    <h1 class="text-purple mb-3 mt-4">{{__('“Play by the rules, but be ferocious.” ')}}</h1>
                        <h6 class="text-lead text-success">{{__('– Phil Knight')}}</h6>
                </div>
                -->
                <div class="col-sm-12 col-md-10 col-lg-9 col-xl-8 d-flex flex-column mx-auto">
                    <div class="card card-info mt-8">
                        <div class="card-header pb-0 text-center ">
                            <h3 class="font-weight-bolder text-purple">{{__('Sign Up')}}</h3>
                            <p class="mb-0">{{__('Create your account')}}</p>
                    </div>
                    <div class="card-body">
                        <form role="form text-left" method="post" action="/signup">
                            @if (session()->has('status'))
                                <div class="alert alert-success">
                                    {{session('status')}}
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="alert bg-pink-light text-danger">
                                    <ul class="list-unstyled">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <!-- General Information Section -->
                            <div class="mb-4">
                                <label>{{__('I am a')}} *</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-rocket text-purple">
                                            <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"></path>
                                            <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"></path>
                                            <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                            <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                        </svg>
                                    </span>
                                    <select name="user_type" class="form-control @error('user_type') is-invalid @enderror" required>
                                        <option value="">{{__('Select your role')}}</option>
                                        <option value="founder" {{old('user_type') == 'founder' ? 'selected' : ''}}>{{__('Founder')}}</option>
                                        <option value="co-founder" {{old('user_type') == 'co-founder' ? 'selected' : ''}}>{{__('Co-Founder')}}</option>
                                        <option value="entrepreneur" {{old('user_type') == 'entrepreneur' ? 'selected' : ''}}>{{__('Entrepreneur')}}</option>
                                        <option value="investor" {{old('user_type') == 'investor' ? 'selected' : ''}}>{{__('Investor')}}</option>
                                    </select>
                                    @error('user_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>{{__('First Name')}} *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user text-purple">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="12" cy="7" r="4"></circle>
                                            </svg>
                                        </span>
                                        <input name="first_name" class="form-control @error('first_name') is-invalid @enderror" type="text" placeholder="{{__('First name')}}" value="{{old('first_name')}}" autocomplete="given-name" required>
                                        @error('first_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>{{__('Surname')}} *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user text-purple">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="12" cy="7" r="4"></circle>
                                            </svg>
                                        </span>
                                        <input name="surname" class="form-control @error('surname') is-invalid @enderror" type="text" placeholder="{{__('Surname')}}" value="{{old('surname')}}" autocomplete="family-name" required>
                                        @error('surname')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label>{{__('Email')}} *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail text-purple">
                                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                                <polyline points="22,6 12,13 2,6"></polyline>
                                            </svg>
                                        </span>
                                        <input type="email" placeholder="{{__('your.email@company.com')}}" name="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" autocomplete="email" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <!-- Startup Information Section -->
                            <div class="card bg-light-info mb-4">
                                <div class="card-header bg-transparent border-0">
                                    <h6 class="mb-0 text-purple">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-rocket me-2">
                                            <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"></path>
                                            <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"></path>
                                            <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                            <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                        </svg>
                                        {{__('Startup Information')}}
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label>{{__('Company/Startup Name')}} *</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-building text-purple">
                                                        <path d="M3 21h18"></path>
                                                        <path d="M5 21V7l8-4v18"></path>
                                                        <path d="M19 21V11l-6-4"></path>
                                                    </svg>
                                                </span>
                                                <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" placeholder="{{__('Your startup name')}}" value="{{old('company_name')}}" autocomplete="organization" required>
                                                @error('company_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label>{{__('Industry/Sector')}} *</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-briefcase text-purple">
                                                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                                        <path d="M16 3H8v4h8V3z"></path>
                                                    </svg>
                                                </span>
                                                <select name="industry" class="form-control @error('industry') is-invalid @enderror" style="background-color: white;" required>
                                                    <option value="">{{__('Select industry')}}</option>
                                                    <option value="technology" {{old('industry') == 'technology' ? 'selected' : ''}}>{{__('Technology')}}</option>
                                                    <option value="fintech" {{old('industry') == 'fintech' ? 'selected' : ''}}>{{__('Fintech')}}</option>
                                                    <option value="healthcare" {{old('industry') == 'healthcare' ? 'selected' : ''}}>{{__('Healthcare')}}</option>
                                                    <option value="ecommerce" {{old('industry') == 'ecommerce' ? 'selected' : ''}}>{{__('E-commerce')}}</option>
                                                    <option value="education" {{old('industry') == 'education' ? 'selected' : ''}}>{{__('Education')}}</option>
                                                    <option value="saas" {{old('industry') == 'saas' ? 'selected' : ''}}>{{__('SaaS')}}</option>
                                                    <option value="manufacturing" {{old('industry') == 'manufacturing' ? 'selected' : ''}}>{{__('Manufacturing')}}</option>
                                                    <option value="retail" {{old('industry') == 'retail' ? 'selected' : ''}}>{{__('Retail')}}</option>
                                                    <option value="other" {{old('industry') == 'other' ? 'selected' : ''}}>{{__('Other')}}</option>
                                                </select>
                                                @error('industry')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label>{{__('Current Stage')}} *</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up text-purple">
                                                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                                        <polyline points="17 6 23 6 23 12"></polyline>
                                                    </svg>
                                                </span>
                                                <select name="current_stage" class="form-control @error('current_stage') is-invalid @enderror" style="background-color: white;" required>
                                                    <option value="">{{__('Select stage')}}</option>
                                                    <option value="idea" {{old('current_stage') == 'idea' ? 'selected' : ''}}>{{__('Idea Stage')}}</option>
                                                    <option value="mvp" {{old('current_stage') == 'mvp' ? 'selected' : ''}}>{{__('MVP Development')}}</option>
                                                    <option value="beta" {{old('current_stage') == 'beta' ? 'selected' : ''}}>{{__('Beta Testing')}}</option>
                                                    <option value="launched" {{old('current_stage') == 'launched' ? 'selected' : ''}}>{{__('Launched')}}</option>
                                                    <option value="scaling" {{old('current_stage') == 'scaling' ? 'selected' : ''}}>{{__('Scaling')}}</option>
                                                    <option value="established" {{old('current_stage') == 'established' ? 'selected' : ''}}>{{__('Established')}}</option>
                                                </select>
                                                @error('current_stage')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label>{{__('Team Size')}} *</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users text-purple">
                                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                                        <circle cx="9" cy="7" r="4"></circle>
                                                        <path d="m22 21-2-2"></path>
                                                        <path d="m16 16 2 2"></path>
                                                    </svg>
                                                </span>
                                                <select name="team_size" class="form-control @error('team_size') is-invalid @enderror" style="background-color: white;" required>
                                                    <option value="">{{__('Select team size')}}</option>
                                                    <option value="1" {{old('team_size') == '1' ? 'selected' : ''}}>{{__('Just me (Solo founder)')}}</option>
                                                    <option value="2-5" {{old('team_size') == '2-5' ? 'selected' : ''}}>{{__('2-5 people')}}</option>
                                                    <option value="6-10" {{old('team_size') == '6-10' ? 'selected' : ''}}>{{__('6-10 people')}}</option>
                                                    <option value="11-25" {{old('team_size') == '11-25' ? 'selected' : ''}}>{{__('11-25 people')}}</option>
                                                    <option value="26-50" {{old('team_size') == '26-50' ? 'selected' : ''}}>{{__('26-50 people')}}</option>
                                                    <option value="50+" {{old('team_size') == '50+' ? 'selected' : ''}}>{{__('50+ people')}}</option>
                                                </select>
                                                @error('team_size')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div class="mb-4">
                                <label>{{__('Choose Password')}}</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock text-purple">
                                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                            <circle cx="12" cy="16" r="1"></circle>
                                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                        </svg>
                                    </span>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" autocomplete="new-password" aria-label="Password" aria-describedby="password-addon" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                                <p class="text-purple mt-4 mb-3 text-center" style="font-size: 20px; font-weight: bolder !important;">{{ __('Choose Your Subscription Plan') }}</p>
                                <input type="hidden" name="selected_plan" id="selected_plan">
                                <input type="hidden" name="selected_duration" id="selected_duration">
                                <div class="row">
                                    @if($plans && $plans->count() > 0)
                                        @foreach($plans as $index => $plan)
                                    <div class="col-lg-6 mb-4">
                                                <div class="card subscription-card h-100" onclick="selectSubscriptionCard(this,{{$plan->id}})" tabindex="0" role="button" aria-pressed="false">
                                            <div class="card-body position-relative pt-4 ps-4 pe-4" style="padding-bottom: 0px !important;">
                                                    <!-- Badge at top-left -->
                                                    @if($plan->badge_text)
                                                        <div class="position-absolute top-0 start-0 m-3" style="z-index: 10;">
                                                            <span class="badge">{{$plan->badge_text}}</span>
                                                    </div>
                                                    @endif
                                                    
                                                    <!-- Icon at top-right -->
                                                    <div class="position-absolute top-0 end-0 m-3">
                                                        <div class="icon icon-shape text-center p-2 rounded-circle">
                                                            @if($plan->icon)
                                                                @php
                                                                    $mainIconMap = [
                                                                        'feather-rocket' => 'fas fa-rocket',
                                                                        'feather-users' => 'fas fa-users',
                                                                        'feather-credit-card' => 'fas fa-credit-card',
                                                                        'feather-briefcase' => 'fas fa-briefcase',
                                                                        'feather-star' => 'fas fa-star'
                                                                    ];
                                                                    $mainIconClass = $mainIconMap[$plan->icon] ?? 'fas fa-rocket';
                                                                @endphp
                                                                <i class="{{$mainIconClass}}" style="font-size: 1.5rem;"></i>
                                                            @else
                                                                <i class="fas fa-credit-card" style="font-size: 1.5rem;"></i>
                                                            @endif
                                                    </div>
                                                    </div>

                                                    <!-- Plan content with proper spacing -->
                                                    <div class="col-12" style="margin-top: 50px;">
                                                        <h5 class="plan-title">{{$plan->name}}</h5>
                                                            @if($plan->subtitle)
                                                                <p class="text-sm text-muted mb-3">{{$plan->subtitle}}</p>
                                                            @endif
                                                            
                                                            @if($plan->features && is_object($plan->features) && $plan->features->count() > 0)
                                                                @foreach($plan->features as $feature)
                                                    <div class="feature-item">
                                                                        <div class="d-flex align-items-start">
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
                                                                            <i class="{{$iconClass}} feature-icon me-2 mt-1" style="font-size: 16px; flex-shrink: 0;" title="Icon: {{$feature->icon}}"></i>
                                                                            <div class="flex-grow-1">
                                                                                <h6 class="feature-title">{{$feature->heading}}</h6>
                                                                                @if($feature->description !== $feature->heading)
                                                                                    <p class="feature-description">{{$feature->description}}</p>
                                                                                @endif
                                        </div>
                                    </div>
                                                    </div>
                                                                @endforeach
                                                            @endif
                                                </div>
                                                    </div>

                                                    <div class="card-footer bg-transparent border-top-0 pt-0" style="padding-top: 0px !important;">
                                                        @if($plan->cta_type === 'contact')
                                                            <div class="text-center">
                                                                <div class="mt-4 pt-3 border-top mb-2">
                                                                    <span class="font-weight-bolder" style="color: #4f55da;">{{__('Custom Pricing')}}</span>
                                                                </div>
                                                                @if($plan->special_conditions)
                                                    <div class="mb-3">
                                                                        <span class="text-sm text-muted">{{$plan->special_conditions}}</span>
                                                    </div>
                                                                @endif
                                                                <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="event.stopPropagation(); selectContactPlan({{$plan->id}})">
                                                                    {{$plan->cta_text ?: __('Contact Us')}}
                                                                </button>
                                                    </div>
                                                        @elseif($plan->is_equity_based)
                                                            <div class="text-center">
                                                                <div class="mb-2">
                                                                    <span class="font-weight-bolder text-dark">{{__('Equity-Based')}}</span>
                                                    </div>
                                                                @if($plan->special_conditions)
                                                    <div class="mb-3">
                                                                        <span class="text-sm text-muted">{{$plan->special_conditions}}</span>
                                                    </div>
                                                                @endif
                                                                @if($plan->requires_application)
                                                                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="event.stopPropagation(); alert('Application form coming soon!')">
                                                                        {{$plan->cta_text ?: __('APPLY FOR THIS TIER')}}
                                                                    </button>
                                                                @endif
                                                    </div>
                                                        @else
                                                    <div class="mt-4 pt-3 border-top">
                                                        <p class="font-weight-bold mb-1">
                                                                    <span style="color: #4f55da;">{{__('Monthly')}}:</span> ${{number_format($plan->price_monthly, 2)}}<br>
                                                                    <span style="color: #4f55da;">{{__('Yearly')}}:</span> ${{number_format($plan->price_yearly, 2)}} + VAT
                                                        </p>
                                                        
                                                        <!-- Duration Selection -->
                                                        <div class="duration-selection" id="duration-selection-{{$plan->id}}">
                                                            <h6 class="mb-2" style="color: #4f55da;">{{__('Select Duration:')}}</h6>
                                                            <div class="duration-option">
                                                                <input type="radio" name="duration_{{$plan->id}}" value="monthly" id="monthly_{{$plan->id}}" onchange="updateDuration('monthly', {{$plan->id}})">
                                                                <label for="monthly_{{$plan->id}}">{{__('Monthly')}} - ${{number_format($plan->price_monthly, 2)}}</label>
                                                            </div>
                                                            <div class="duration-option">
                                                                <input type="radio" name="duration_{{$plan->id}}" value="yearly" id="yearly_{{$plan->id}}" onchange="updateDuration('yearly', {{$plan->id}})">
                                                                <label for="yearly_{{$plan->id}}">{{__('Yearly')}} - ${{number_format($plan->price_yearly, 2)}} + VAT</label>
                                                            </div>
                                                        </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                                <div class="col-12">
                                            <div class="alert alert-info text-center">
                                                <h5>{{__('No Subscription Plans Available')}}</h5>
                                                <p>{{__('Please contact the administrator to set up subscription plans.')}}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @if(!empty($super_settings['config_recaptcha_in_user_signup']))
                                    <div class="g-recaptcha" data-sitekey="{{$super_settings['recaptcha_api_key']}}"></div>
                                @endif
                            @csrf
                                <div class="text-center">
                                    <button type="submit" class="btn btn-info w-100 mt-4 mb-0" id="submit-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-rocket me-2" id="submit-icon">
                                            <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"></path>
                                            <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"></path>
                                            <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                            <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                        </svg>
                                        <span id="submit-text">{{__('Submit Startup Application')}}</span>
                                    </button>
                                </div>
                        </form>
                        </div>
                        <div class="card-footer text-center pt-0 px-lg-2 px-1">
                            <p class="text-sm mt-3 mb-0">{{__('Already have an account?')}} <a href="/login" class="text-purple font-weight-bolder">{{__('Sign in')}}</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>

    (function(){
        "use strict";
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    })();
</script>
<script>
    let selectedPlanName = '';
    let selectedDuration = '';
    let isContactPlan = false;

    function selectSubscriptionCard(card, planId) {
        // Hide all duration selections first
        document.querySelectorAll('.duration-selection').forEach(d => {
            d.classList.remove('show');
        });

        document.querySelectorAll('.subscription-card').forEach(c => {
            c.classList.remove('selected');
            c.setAttribute('aria-pressed', 'false');
        });
        
        card.classList.add('selected');
        card.setAttribute('aria-pressed', 'true');
        selectedPlanName = planId;
        document.getElementById('selected_plan').value = selectedPlanName;

        // Check if this is a contact plan
        const contactButton = card.querySelector('button[onclick*="selectContactPlan"]');
        isContactPlan = !!contactButton;

        // Show duration selection for non-contact plans
        if (!isContactPlan) {
            const durationSelection = document.getElementById('duration-selection-' + planId);
            if (durationSelection) {
                durationSelection.classList.add('show');
            }
        }

        // Reset duration selection
        selectedDuration = '';
        document.getElementById('selected_duration').value = '';
    }

    function updateDuration(duration, planId) {
        selectedDuration = duration;
        document.getElementById('selected_duration').value = duration;
    }

    function selectContactPlan(planId) {
        // Store the selected contact plan
        selectedPlanName = planId;
        document.getElementById('selected_plan').value = selectedPlanName;
        isContactPlan = true;
        
        // Show SweetAlert confirmation
        Swal.fire({
            title: 'Custom Package Selected',
            text: 'You have selected the custom package. You will be redirected to our contact page once you complete your registration to discuss your specific requirements.',
            icon: 'info',
            confirmButtonText: 'Continue Registration',
            confirmButtonColor: '#4f55da',
            showCancelButton: true,
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (!result.isConfirmed) {
                // Reset selection if cancelled
                selectedPlanName = '';
                document.getElementById('selected_plan').value = '';
                document.querySelectorAll('.subscription-card').forEach(c => {
                    c.classList.remove('selected');
                    c.setAttribute('aria-pressed', 'false');
                });
            }
        });
    }

    // Form submission with validation and loading states
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const submitBtn = document.getElementById('submit-btn');
        const submitText = document.getElementById('submit-text');
        const submitIcon = document.getElementById('submit-icon');

        // Check for backend validation errors on page load
        @if($errors->any())
            Swal.fire({
                title: 'Validation Errors',
                html: `
                    <div class="text-left">
                        @foreach($errors->all() as $error)
                            <div class="mb-2">• {{ $error }}</div>
                        @endforeach
                    </div>
                `,
                icon: 'error',
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'OK',
                timer: 5000,
                timerProgressBar: true
            });
        @endif

        // Check for success messages
        @if(session('success'))
            Swal.fire({
                title: 'Success!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonColor: '#28a745',
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Clear previous validation states
            document.querySelectorAll('.form-control').forEach(input => {
                input.classList.remove('is-invalid', 'is-valid');
            });
            document.querySelectorAll('.invalid-feedback').forEach(feedback => {
                feedback.style.display = 'none';
            });

            // Validate plan selection
            if (!selectedPlanName) {
                Swal.fire({
                    title: 'Plan Selection Required',
                    text: 'Please select a subscription plan to continue.',
                    icon: 'warning',
                    confirmButtonColor: '#4f55da'
                });
                return;
            }

            // Validate duration for non-contact plans
            if (!isContactPlan && !selectedDuration) {
                Swal.fire({
                    title: 'Duration Selection Required',
                    text: 'Please select a billing duration (Monthly or Yearly) for your chosen plan.',
                    icon: 'warning',
                    confirmButtonColor: '#4f55da'
                });
                return;
            }

            // Basic frontend validation
            const requiredFields = [
                {name: 'user_type', label: 'Role'},
                {name: 'first_name', label: 'First Name'},
                {name: 'surname', label: 'Surname'},
                {name: 'email', label: 'Email'},
                {name: 'company_name', label: 'Company Name'},
                {name: 'industry', label: 'Industry'},
                {name: 'current_stage', label: 'Current Stage'},
                {name: 'team_size', label: 'Team Size'},
                {name: 'password', label: 'Password'}
            ];
            
            let hasErrors = false;
            let errorMessages = [];

            requiredFields.forEach(field => {
                const input = form.querySelector(`[name="${field.name}"]`);
                if (!input || !input.value.trim()) {
                    hasErrors = true;
                    errorMessages.push(field.label);
                    if (input) {
                        input.classList.add('is-invalid');
                    }
                } else {
                    if (input) {
                        input.classList.add('is-valid');
                    }
                }
            });

            // Email validation
            const emailInput = form.querySelector('[name="email"]');
            if (emailInput && emailInput.value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(emailInput.value)) {
                    hasErrors = true;
                    emailInput.classList.add('is-invalid');
                    if (!errorMessages.includes('Email')) {
                        errorMessages.push('Email');
                    }
                }
            }

            // Password validation
            const passwordInput = form.querySelector('[name="password"]');
            if (passwordInput && passwordInput.value && passwordInput.value.length < 8) {
                hasErrors = true;
                passwordInput.classList.add('is-invalid');
                if (!errorMessages.includes('Password')) {
                    errorMessages.push('Password');
                }
            }

            if (hasErrors) {
                Swal.fire({
                    title: 'Please Fix the Following Issues',
                    html: `
                        <div class="text-left">
                            ${errorMessages.map(msg => `<div class="mb-1">• ${msg} is required or invalid</div>`).join('')}
                        </div>
                    `,
                    icon: 'warning',
                    confirmButtonColor: '#4f55da'
                });
                return;
            }

            // Show loading state
            submitBtn.disabled = true;
            submitBtn.classList.add('btn-loading');
            submitIcon.style.display = 'none';
            submitText.innerHTML = '<span class="spinner"></span>Processing...';

            // Show processing message
            Swal.fire({
                title: 'Processing Registration',
                text: isContactPlan ? 
                    'Creating your account and preparing to redirect you to our contact page...' : 
                    'Validating your information and preparing for payment...',
                icon: 'info',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });

            // Submit form after delay
            setTimeout(() => {
                form.submit();
            }, 2000);
        });
    });

    // Keyboard support for selecting cards
    document.addEventListener('keydown', function (e) {
        if ((e.key === 'Enter' || e.key === ' ') && e.target && e.target.classList && e.target.classList.contains('subscription-card')) {
            e.preventDefault();
            const card = e.target;
            const onclickAttr = card.getAttribute('onclick');
            if (onclickAttr) {
                const planIdMatch = onclickAttr.match(/selectSubscriptionCard\(this,(\d+)\)/);
                if (planIdMatch) {
                    const planId = planIdMatch[1];
                    selectSubscriptionCard(card, planId);
                }
            }
        }
    });

</script>

<!-- Font Awesome icons are loaded via CSS, no JavaScript needed -->

</body>

</html>
