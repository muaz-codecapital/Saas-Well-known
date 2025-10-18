<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>
        {{config('app.name')}}
    </title>
    @if(!empty($super_settings['favicon']))

        <link rel="icon" type="image/png" href="{{PUBLIC_DIR}}/uploads/{{$super_settings['favicon']}}">
    @endif
    <link id="pagestyle" href="{{PUBLIC_DIR}}/css/app.css" rel="stylesheet"/>

<style>
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
    .input-group-text {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-right: none;
        color: #4f55da;
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
    .input-group .form-control::placeholder {
        color: #6c757d;
        opacity: 1;
    }
    .text-purple { color: #4f55da !important; }
</style>

    @if(!empty($super_settings['config_recaptcha_in_admin_login']))
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
</head>
<body class="g-sidenav-show  bg-dark">
<section>
    <div class="page-header section-height-75">
        <div class="container ">
            <div class="row">
                <div class="col-md-5 d-flex flex-column mx-auto">
                    <div class="card card-body mt-7">
                        <div class="card-header pb-0 text-left bg-transparent">
                            <h3 class="font-weight-bolder text-purple">
                                {{__(' Howdy, Super Admin')}}

                            </h3>
                            <p class="mb-0">
                                {{__('Enter your email and password')}}

                            </p>
                        </div>
                        <div class="card-body">
                            <form role="form text-left" method="post" action="/super-admin/auth">

                                @if (session()->has('status'))
                                    <div class="alert alert-success">
                                        {{session('status')}}
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="list-unstyled">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <label>{{__('Email')}}</label>
                                <div class="mb-3 input-group">
                                    <span class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail text-purple">
                                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                            <polyline points="22,6 12,13 2,6"></polyline>
                                        </svg>
                                    </span>
                                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{old('email')}}" aria-label="Email">
                                </div>
                                <label>{{__('Password')}}</label>
                                <div class="mb-3 input-group">
                                    <span class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock text-purple">
                                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                            <circle cx="12" cy="16" r="1"></circle>
                                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                        </svg>
                                    </span>
                                    <input type="password" name="password" class="form-control" placeholder="Password" aria-label="Password">
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="rememberMe" checked="">
                                    <label class="form-check-label" for="rememberMe">
                                        {{__('Remember me')}}</label>
                                </div>
                                    @if(!empty($super_settings['config_recaptcha_in_admin_login']))
                                        <div class="g-recaptcha" data-sitekey="{{$super_settings['recaptcha_api_key']}}">

                                        </div>
                                    @endif
                                <div class="text-center">
                                    @csrf
                                    <button type="submit"
                                            class="btn btn-info w-100 mt-4 mb-0">{{__('Sign in')}}</button>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-center pt-0 px-lg-2 px-1">
                            <p class="mb-4 text-sm mx-auto">
                                {{__('Forgot Password?')}}
                                <a href="/forgot-password"
                                   class="text-purple font-weight-bold">{{__('Reset Password')}}</a>
                            </p>
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
</body>
</html>
