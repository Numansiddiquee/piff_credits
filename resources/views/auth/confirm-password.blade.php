@extends('layouts.custom.auth')

@section('auth-content')
<div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
    <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-500px">
        <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">

            <!-- Heading -->
            <div class="text-center mb-11">
                <h1 class="text-gray-900 fw-bolder mb-3">Confirm Password</h1>
                <p class="text-muted">
                    This is a secure area of the application. Please confirm your password before continuing.
                </p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('password.confirm') }}" class="w-100">
                @csrf

                <!-- Password -->
                <div class="fv-row mb-8">
                    <input type="password" name="password" id="password" 
                        placeholder="Password"
                        class="form-control bg-transparent" 
                        required autocomplete="current-password" />
                    <p class="mt-1 text-danger">{{ $errors->first('password') }}</p>
                </div>

                <!-- Submit -->
                <div class="d-grid mb-10">
                    <button type="submit" class="btn btn-primary">
                        Confirm
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@section('auth-js')
@endsection
