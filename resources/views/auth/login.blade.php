@extends('layouts.custom.auth')
@section('auth-content')
    <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
        <!--begin::Content-->
        <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
            <!--begin::Wrapper-->
            <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
                <!--begin::Form-->
                <form class="form w-100" action="{{ route('login') }}" method="POST" novalidate="novalidate"  id="kt_sign_up_form">
                    @csrf
                    <!--begin::Heading-->
                    <div class="text-center mb-11">
                        <img src="{{ asset('assets/images/auth-logo.png') }}" width="300px" class="mb-10">
                        <!--begin::Title-->
                        <h1 class="text-gray-900 fw-bolder mb-3">Sign In</h1>

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <!--end::Title-->
                        <!--begin::Subtitle-->
                        <div class="text-gray-500 fw-semibold fs-6">Your Social Campaigns</div>
                        <!--end::Subtitle=-->
                    </div>
                    <div class="col-md-12 mb-3">
                        <!--begin::Google link=-->
                        <a href="{{ route('google.login') }}" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                        <img alt="Logo" src="{{ asset('metronic/assets/media/svg/brand-logos/google-icon.svg')}}" class="h-15px me-3" />Sign with with Google</a>
                        <!--end::Google link=-->
                    </div>
                    <!--begin::Separator-->
                    <div class="separator separator-content my-14">
                        <span class="w-125px text-gray-500 fw-semibold fs-7">Or with email</span>
                    </div>
                    <!--end::Separator-->
                    <!--begin::Input group=-->
                    <div class="fv-row mb-8">
                        <input type="text" placeholder="Email" name="email" id="email" autocomplete="off" class="form-control bg-transparent" required=""/>
                        <p id="emailError" style="color: red"></p>
                        <x-input-error :messages="$errors->get('email')" class="mt-1" style="color:red;list-style: none;padding-left: 0px;" />
                        <!--end::Email-->
                    </div>
                    <!--end::Input group=-->
                    <div class="fv-row mb-3">
                        <!--begin::Password-->
                        <input type="password" placeholder="Password" name="password" id="password" autocomplete="off" class="form-control bg-transparent" required=""/>
                        <p id="passwordError" style="color: red"></p>
                        <x-input-error :messages="$errors->get('password')" class="mt-1" style="color:red;list-style: none;padding-left: 0px;" />
                        <!--end::Password-->
                    </div>
                    <div class="fv-row mb-3">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                        </label>
                    </div>
                    <!--end::Input group=-->
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                        <div></div>
                        <!--begin::Link-->
                        <a href="{{ route('password.request') }}" class="link-primary">Forgot Password ?</a>
                        <!--end::Link-->
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Submit button-->
                    <div class="d-grid mb-10">
                        <button type="submit" class="btn btn-primary">
                            <!--begin::Indicator label-->
                            <span class="indicator-label">Sign In</span>
                            <!--end::Indicator label-->
                            <!--begin::Indicator progress-->
                            <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            <!--end::Indicator progress-->
                        </button>
                    </div>
                    <!--end::Submit button-->
                    <!--begin::Sign up-->
                    <div class="text-gray-500 text-center fw-semibold fs-6">Not a Member yet?
                        <a href="{{ route('register') }}" class="link-primary">Sign up</a></div>
                    <!--end::Sign up-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Wrapper-->
            <!--begin::Footer-->
            <div class="d-flex flex-stack">
                <!--begin::Languages-->
                <div class="me-10">
                    <!--begin::Toggle-->
                    <button class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                        <img data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3" src="{{ asset('metronic/assets/media/flags/united-states.svg')}}" alt="" />
                        <span data-kt-element="current-lang-name" class="me-1">English</span>
                        <i class="ki-outline ki-down fs-5 text-muted rotate-180 m-0"></i>
                    </button>
                    <!--end::Toggle-->
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4 fs-7" data-kt-menu="true" id="kt_auth_lang_menu">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="English">
                                        <span class="symbol symbol-20px me-4">
                                            <img data-kt-element="lang-flag" class="rounded-1" src="{{ asset('metronic/assets/media/flags/united-states.svg')}}" alt="" />
                                        </span>
                                <span data-kt-element="lang-name">English</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="Spanish">
                                        <span class="symbol symbol-20px me-4">
                                            <img data-kt-element="lang-flag" class="rounded-1" src="{{ asset('metronic/assets/media/flags/spain.svg')}}" alt="" />
                                        </span>
                                <span data-kt-element="lang-name">Spanish</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="German">
                                        <span class="symbol symbol-20px me-4">
                                            <img data-kt-element="lang-flag" class="rounded-1" src="{{ asset('metronic/assets/media/flags/germany.svg')}}" alt="" />
                                        </span>
                                <span data-kt-element="lang-name">German</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="Japanese">
                                        <span class="symbol symbol-20px me-4">
                                            <img data-kt-element="lang-flag" class="rounded-1" src="{{ asset('metronic/assets/media/flags/japan.svg')}}" alt="" />
                                        </span>
                                <span data-kt-element="lang-name">Japanese</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="French">
                                        <span class="symbol symbol-20px me-4">
                                            <img data-kt-element="lang-flag" class="rounded-1" src="{{ asset('metronic/assets/media/flags/france.svg')}}" alt="" />
                                        </span>
                                <span data-kt-element="lang-name">French</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                </div>
                <!--end::Languages-->
            </div>
            <!--end::Footer-->
        </div>
        <!--end::Content-->
    </div>
@endsection
@section('auth-js')

@endsection