@extends('layouts.custom.auth')

@section('auth-content')
<div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
    <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
        <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
           <img src="{{ asset('assets/images/auth-logo.png') }}" width="300px" class="mb-10">

            <!-- Reset Password Form -->
            <form class="form w-100" action="{{ route('password.store') }}" method="POST" id="kt_sign_up_form" novalidate>
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="text-center mb-11">
                    <h1 class="text-gray-900 fw-bolder mb-3">Reset Password</h1>
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>

                <!-- Email -->
                <div class="fv-row mb-8">
                    <input type="email" placeholder="Email" name="email" id="email" value="{{ old('email', $request->email) }}" class="form-control bg-transparent" required />
                    @error('email')
                        <p class="mt-1 text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="fv-row mb-3">
                    <input type="password" placeholder="Password" name="password" id="password" class="form-control bg-transparent" required />
                    @error('password')
                        <p class="mt-1 text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="fv-row mb-3">
                    <input type="password" placeholder="Confirm Password" name="password_confirmation" id="password_confirmation" class="form-control bg-transparent" required />
                    @error('password_confirmation')
                        <p class="mt-1 text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit -->
                <div class="d-grid mb-10">
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">Reset Password</span>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@section('auth-js')
@endsection

