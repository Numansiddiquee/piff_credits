@extends('layouts.custom.auth')
@section('auth-content')
    <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
	    <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
	        <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
	            <form class="form w-100" action="{{ route('verify.2fa.post') }}" method="POST" novalidate id="kt_2fa_form">
                    @csrf
                    <!--begin::Heading-->
                    <div class="text-center mb-8">
                        <img src="{{ asset('assets/images/auth-logo.png') }}" width="300px" class="mb-10">
                        <h1 class="text-gray-900 fw-bolder mb-3">Two-Factor Authentication</h1>
                        <!--end::Title-->
                        <!--begin::Subtitle-->
                        <div class="text-gray-500 fw-semibold fs-6">Enter the 6-digit code sent to your email</div>
                        <!--end::Subtitle-->
                    </div>
                    <!--end::Heading-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-6">
                        <label for="code" class="form-label fw-medium text-gray-700">Verification Code</label>
                        <input 
                            type="text" 
                            placeholder="Enter 6-digit code" 
                            name="two_factor_code" 
                            id="code" 
                            autocomplete="one-time-code" 
                            class="form-control bg-transparent" 
                            maxlength="6" 
                            pattern="[0-9]{6}" 
                            required 
                            aria-describedby="codeError"
                        >
                        <div class="form-text text-gray-500 fs-7">Enter the 6-digit code received in your email.</div>
                        <p class="mt-2 text-danger fs-7" />{{ $errors->first('two_factor_code') }}</p>
                        <p id="codeError" class="text-danger fs-7 mt-2" style="display: none;"></p>
                    </div>
                    <!--end::Input group-->

                    <!--begin::Submit button-->
                    <div class="d-grid mb-8">
                        <button type="submit" class="btn btn-primary fw-semibold py-3" id="kt_2fa_submit">
                            <span class="indicator-label">Verify</span>
                            <span class="indicator-progress">
                                Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                    <!--end::Submit button-->

                    <!--begin::Resend link-->
                    <div class="text-center text-gray-500 fw-semibold fs-7">
                        Didn't receive the code? 
                        <a href="{{ route('resend.2fa') }}" class="link-primary fw-semibold">Resend Code</a>
                    </div>
                    <!--end::Resend link-->
                </form>
	        </div>
	    </div>
	</div>
@endsection
@section('auth-js')
<script>
    // Client-side validation for Bootstrap/Metronic
    (function () {
        'use strict';
        const form = document.getElementById('kt_2fa_form');
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    })();
</script>
@endsection