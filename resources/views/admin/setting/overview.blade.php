@extends('layouts.custom.admin')
@section('admin-css')

@endsection

@section('admin-content')
    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="card mb-5 mb-xl-10">
            <div class="card-body pt-9 pb-0">
                <div class="d-flex flex-wrap flex-sm-nowrap">
                    <div class="me-7 mb-4">
                        <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                            <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="image" />
                            <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                            <div class="d-flex flex-column">
                                <div class="d-flex align-items-center mb-2">
                                    <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ auth()->user()->name }}</a>
                                    <a href="#">
                                        <i class="ki-outline ki-verify fs-1 text-primary"></i>
                                    </a>
                                </div>
                                <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                    <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary text-capitalize me-5 mb-2">
                                        <i class="ki-outline ki-profile-circle fs-4 me-1"></i>
                                        @php
                                            $role = auth()->user()->roles->first(); // Fetch the first role object
                                        @endphp
                                        {{ $role->name ?? 'Unassigned' }}
                                    </a>
                                    <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                        <i class="ki-outline ki-geolocation fs-4 me-1"></i> {{ auth()->user()->company->state ?? ''}}, {{ auth()->user()->company->city ?? ''}}</a>
                                    <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary mb-2">
                                        <i class="ki-outline ki-sms fs-4 me-1"></i> {{ auth()->user()->email }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap flex-stack">
                            <div class="d-flex flex-column flex-grow-1 pe-8">
                                <div class="d-flex flex-wrap">
                                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline ki-arrow-up fs-3 text-success me-2"></i>
                                            <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="{{ auth()->user()->invoices ? auth()->user()->invoices->sum('total') : 0 }}" data-kt-countup-prefix="$">0</div>
                                        </div>
                                        <div class="fw-semibold fs-6 text-gray-500">Clients</div>
                                    </div>
                                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline ki-arrow-down fs-3 text-danger me-2"></i>
                                            <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="{{ auth()->user()->quotes ? auth()->user()->quotes->count() : 0 }}">0</div>
                                        </div>
                                        <div class="fw-semibold fs-6 text-gray-500">Freelancers</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ Route::is('admin.company.profile.view') ? 'active' : '' }}" href="{{ route('admin.company.profile.view') }}">Overview</a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ Route::is('admin.company.profile.setting') ? 'active' : '' }}" href="{{ route('admin.company.profile.setting') }}">Settings</a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ Route::is('admin.company.profile.platform.setting') ? 'active' : '' }}" href="{{ route('admin.company.profile.platform.setting') }}">Platform Setting</a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ Route::is('admin.company.profile.security') ? 'active' : '' }}" href="{{ route('admin.company.profile.security') }}">Security</a>
                    </li>
                    
                    <!-- <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ Route::is('admin.company.profile.payment.method') ? 'active' : '' }}" href="{{ route('admin.company.profile.payment.method') }}">Payment Method</a>
                    </li> -->
                </ul>
            </div>
        </div>
        @if($action == 'view')
            @include('admin.partials.setting.view')
        @elseif($action == 'setting')
            @include('admin.partials.setting.edit')
        @elseif($action == 'security')
            @include('admin.partials.setting.security')
        @elseif($action == 'general')
            @include('admin.partials.setting.general')
        @else
            @include('admin.partials.setting.payment_method')
        @endif
    </div>
@endsection

@section('admin-js')
    <script>
        $(document).ready(function () {
            $('#kt_account_profile_details_form').on('submit', function (e) {
                e.preventDefault(); // Prevent default form submission
                let isValid = true;

                // Clear previous errors
                $('.error-message').remove();

                // Required fields and validations
                const fields = [
                    { name: 'fname', message: 'First name is required.' },
                    { name: 'lname', message: 'Last name is required.' },
                    { name: 'company', message: 'Company is required.' },
                    { name: 'phone', message: 'Phone is required.'},
                    { name: 'country', message: 'Country is required.' },
                    { name: 'state', message: 'State is required.' },
                    { name: 'city', message: 'City is required.' },
                    { name: 'zip', message: 'Zip Code is required.' },
                ];

                // Loop through fields for validation
                fields.forEach(field => {
                    const $input = $(`input[name="${field.name}"]`);
                    const value = $input.val().trim();

                    if (!value) {
                        isValid = false;
                        showError($input, field.message);
                    } else if (field.regex && !field.regex.test(value)) {
                        isValid = false;
                        showError($input, field.invalidMessage);
                    }
                });

                if (isValid) $(this).off('submit').submit(); // Submit form if valid
            });

            // Show error message
            function showError($input, message) {
                $input.closest('.fv-row').append(`<div class="error-message text-danger mt-2">${message}</div>`);
            }
        });
    </script>

@endsection