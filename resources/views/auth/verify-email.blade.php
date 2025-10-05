@extends('layouts.custom.auth')

@section('auth-content')
<div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
    <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-500px">
        <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
            <img src="{{ asset('assets/images/auth-logo.png') }}" width="300px" class="mb-10">

            <!-- Heading -->
            <div class="text-center mb-11">
                <h1 class="text-gray-900 fw-bolder mb-3">Verify Your Email</h1>
                <p class="text-muted">
                    Thanks for signing up! Before getting started, please verify your email address 
                    by clicking on the link we just sent to you. If you didn’t receive the email, we’ll send you another.
                </p>
            </div>

            <!-- Success Message -->
            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success alert-dismissible fade show mb-6" role="alert">
                    A new verification link has been sent to your email address.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Actions -->
            <div class="d-flex justify-content-between align-items-center w-100">

                <!-- Resend Verification Email -->
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        Resend Verification Email
                    </button>
                </form>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-light-danger">
                        Log Out
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

@section('auth-js')
@endsection
