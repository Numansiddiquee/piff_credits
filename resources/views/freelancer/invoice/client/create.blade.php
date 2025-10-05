@extends('layouts.custom.freelancer')
@section('freelancer-css')
@endsection

@section('freelancer-content')
<!--begin::Toolbar-->
<div id="kt_app_toolbar" class="app-toolbar pt-6 pb-2">
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
                    Create Client</h1>
            </div>
        </div>
    </div>
</div>
<!--end::Toolbar-->

<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-fluid">
        <form id="user-form" action="{{ route('freelancer.invoice.store_client') }}" method="POST" enctype="multipart/form-data" class="form d-flex flex-column flex-lg-row">
            @csrf

            <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                <!--begin::User Details-->
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Client Details</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <!-- First Name -->
                        <div class="mb-10 fv-row">
                            <label class="required form-label text-danger">First Name</label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}"
                                class="form-control form-control-sm mb-2 @error('first_name') is-invalid @enderror"
                                placeholder="First Name" required />
                            @error('first_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Last Name -->
                        <div class="mb-10 fv-row">
                            <label class="required form-label text-danger">Last Name</label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}"
                                class="form-control form-control-sm mb-2 @error('last_name') is-invalid @enderror"
                                placeholder="Last Name" required />
                            @error('last_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-10 fv-row">
                            <label class="required form-label text-danger">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="form-control form-control-sm mb-2 @error('email') is-invalid @enderror"
                                placeholder="Email" required />
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        
                        <!-- Phone Number -->
                        <div class="mb-10 fv-row">
                            <label class="required form-label text-danger">Phone Number</label>
                            <input type="text" name="phone_number" value="{{ old('phone_number') }}"
                                class="form-control form-control-sm mb-2 @error('phone_number') is-invalid @enderror"
                                placeholder="Phone Number" required />
                            @error('phone_number') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-10 fv-row">
                            <label class="required form-label text-danger">Password</label>
                            <input type="password" name="password"
                                class="form-control form-control-sm mb-2 @error('password') is-invalid @enderror"
                                placeholder="Password" required minlength="6" />
                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Role -->
                        <div class="mb-10 fv-row">
                            <label class="form-label text-danger required">Role</label>
                            <select name="role" id="role-select"
                                class="form-select form-select-sm @error('role') is-invalid @enderror" required>
                                <option value="Client" {{ old('role') == 'Client' ? 'selected' : '' }}>
                                    Client
                                </option>
                            </select>
                            @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Company Info -->
                        <div id="company-section">
                            <div class="text-center mb-11">
                                <h1 class="text-gray-900 fw-bolder mb-3">Company Information</h1>
                                <div class="text-gray-500 fw-semibold fs-6">Tell us about your client's company</div>
                            </div>

                            <div class="fv-row mb-8">
                                <input type="text" placeholder="Company Name" name="company" value="{{ old('company') }}"
                                    class="form-control bg-transparent @error('company') is-invalid @enderror" />
                                @error('company') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="fv-row mb-8">
                                <input type="text" placeholder="Country" name="country" value="{{ old('country') }}"
                                    class="form-control bg-transparent @error('country') is-invalid @enderror" />
                                @error('country') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="fv-row mb-8">
                                <input type="text" placeholder="State" name="state" value="{{ old('state') }}"
                                    class="form-control bg-transparent @error('state') is-invalid @enderror" />
                                @error('state') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="fv-row mb-8">
                                <input type="text" placeholder="City" name="city" value="{{ old('city') }}"
                                    class="form-control bg-transparent @error('city') is-invalid @enderror" />
                                @error('city') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="fv-row mb-8">
                                <input type="text" placeholder="Zip Code" name="zip" value="{{ old('zip') }}"
                                    class="form-control bg-transparent @error('zip') is-invalid @enderror" />
                                @error('zip') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.users') }}" class="btn btn-light me-5">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">Save Changes</span>
                        <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </div>

            <!-- Profile Picture -->
            <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 ms-lg-10">
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title"><h2>Profile Image</h2></div>
                    </div>
                    <div class="card-body text-center pt-0">
                        <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3" data-kt-image-input="true">
                            <div class="image-input-wrapper w-150px h-150px"></div>
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change">
                                <i class="ki-outline ki-pencil fs-7"></i>
                                <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                            </label>
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel">
                                <i class="ki-outline ki-cross fs-2"></i>
                            </span>
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove">
                                <i class="ki-outline ki-cross fs-2"></i>
                            </span>
                        </div>
                        @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                        <div class="text-muted fs-7">Only *.png, *.jpg and *.jpeg image files are accepted</div>
                    </div>
                </div>

                <!-- Company Logo -->
                <div class="card card-flush py-4" id="company-logo-card">
                    <div class="card-header">
                        <div class="card-title"><h2>Company Logo</h2></div>
                    </div>
                    <div class="card-body text-center pt-0">
                        <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3" data-kt-image-input="true">
                            <div class="image-input-wrapper w-150px h-150px"></div>
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change">
                                <i class="ki-outline ki-pencil fs-7"></i>
                                <input type="file" name="company_logo" accept=".png, .jpg, .jpeg" />
                            </label>
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel">
                                <i class="ki-outline ki-cross fs-2"></i>
                            </span>
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove">
                                <i class="ki-outline ki-cross fs-2"></i>
                            </span>
                        </div>
                        @error('company_logo') <span class="text-danger">{{ $message }}</span> @enderror
                        <div class="text-muted fs-7">Only *.png, *.jpg and *.jpeg image files are accepted</div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('freelancer-js')

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const roleSelect = document.getElementById("role-select");
        const additionalSteps = document.querySelectorAll(".additionalSteps");
        const form = document.getElementById("user-form");

        // Toggle additional fields based on role
        roleSelect.addEventListener("change", function () {
            if (this.value.toLowerCase() === "client") {
                additionalSteps.forEach(step => step.classList.remove("d-none"));
            } else {
                additionalSteps.forEach(step => step.classList.add("d-none"));
            }
        });

        // Frontend validation
        form.addEventListener("submit", function (event) {
            let isValid = true;

            form.querySelectorAll("input[required], select[required]").forEach(field => {
                const errorMessage = field.parentElement.querySelector(".error-message");
                if (!field.value.trim()) {
                    isValid = false;
                    if (errorMessage) errorMessage.textContent = "This field is required.";
                } else if (field.name === "email" && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(field.value)) {
                    isValid = false;
                    if (errorMessage) errorMessage.textContent = "Enter a valid email address.";
                } else if (field.name === "password" && field.value.length < 6) {
                    isValid = false;
                    if (errorMessage) errorMessage.textContent = "Password must be at least 6 characters.";
                } else {
                    if (errorMessage) errorMessage.textContent = "";
                }
            });

            if (!isValid) {
                event.preventDefault();
            }
        });
    });
</script>
@endsection
