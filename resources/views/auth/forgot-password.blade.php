@extends('layouts.custom.auth')

@section('auth-content')
<div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
    <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
        <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">

            <!-- Forgot Password Form -->
            <form class="form w-100" method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Heading -->
                <div class="text-center mb-11">
                    <h1 class="text-gray-900 fw-bolder mb-3">Forgot Password</h1>
                    <p class="text-muted">
                        Enter your email and we will send you a password reset link.
                    </p>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>

                <!-- Email -->
                <div class="fv-row mb-8">
                    <input type="email" placeholder="Email" name="email" id="email"
                           class="form-control bg-transparent @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" required autofocus />
                    @error('email')
                        <p class="mt-1 text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit -->
                <div class="d-grid mb-10">
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">Send Password Reset Link</span>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@section('auth-js')
@endsection
