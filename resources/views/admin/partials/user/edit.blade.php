<div class="card mb-5 mb-xl-10">
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
        data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Profile Details</h3>
        </div>
    </div>
    <div id="kt_account_settings_profile_details" class="collapse show">
        <form action="{{ route('admin.user.update') }}" method="post" id="kt_account_profile_details_form"
            class="form" enctype="multipart/form-data" data-role="{{ $user->role }}">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <div class="card-body border-top p-9">

                <!-- Avatar -->
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Avatar</label>
                    <div class="col-lg-8">
                        <div class="image-input image-input-outline" data-kt-image-input="true"
                            style="background-image: url({{ asset('assets/media/svg/avatars/blank.svg') }})">
                            <div class="image-input-wrapper w-125px h-125px"
                                style="background-image: url({{ Storage::url($user->avatar) }})"></div>
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                <i class="ki-outline ki-pencil fs-7"></i>
                                <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                                <input type="hidden" name="avatar_remove" />
                            </label>
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                <i class="ki-outline ki-cross fs-2"></i>
                            </span>
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                <i class="ki-outline ki-cross fs-2"></i>
                            </span>
                        </div>
                        <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                    </div>
                </div>

                <!-- Company Logo (Client Only) -->
                @if($user->roles->first()->name === 'Client')
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Company Logo</label>
                        <div class="col-lg-8">
                            <div class="image-input image-input-outline" data-kt-image-input="true"
                                style="background-image: url({{ asset('assets/media/svg/files/blank-image.svg') }})">
                                <div class="image-input-wrapper w-125px h-125px"
                                    style="background-image: url({{ Storage::url($user->company->logo ?? '') }})"></div>
                                <label
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change logo">
                                    <i class="ki-outline ki-pencil fs-7"></i>
                                    <input type="file" name="company_logo" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="company_logo_remove" />
                                </label>
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                    title="Cancel logo">
                                    <i class="ki-outline ki-cross fs-2"></i>
                                </span>
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                    title="Remove logo">
                                    <i class="ki-outline ki-cross fs-2"></i>
                                </span>
                            </div>
                            <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                        </div>
                    </div>
                @endif

                <!-- Full Name -->
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Full Name</label>
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-6 fv-row">
                                @php
                                    $name = explode(' ', $user->name);
                                    $fname = $name[0] ?? '';
                                    $lname = $name[1] ?? '';
                                @endphp
                                <input type="text" name="fname"
                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                    placeholder="First name" value="{{ $fname }}" />
                            </div>
                            <div class="col-lg-6 fv-row">
                                <input type="text" name="lname" class="form-control form-control-lg form-control-solid"
                                    placeholder="Last name" value="{{ $lname }}" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Client-Specific Fields -->
                @if($user->roles->first()->name === 'Client')
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Company</label>
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="company"
                                class="form-control form-control-lg form-control-solid" placeholder="Company name"
                                value="{{ $user->company_name }}" />
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                            <span class="required">Country</span>
                        </label>
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="country"
                                class="form-control form-control-lg form-control-solid"
                                placeholder="Country" value="{{ $user->company->country ?? '' }}" />
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">State</label>
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="state" class="form-control form-control-lg form-control-solid"
                                placeholder="State" value="{{ $user->company->state ?? '' }}" />
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">City</label>
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="city" class="form-control form-control-lg form-control-solid"
                                placeholder="City" value="{{ $user->company->city ?? '' }}" />
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Zip Code</label>
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="zip" class="form-control form-control-lg form-control-solid"
                                placeholder="Zip Code" value="{{ $user->company->zip_code ?? '' }}" />
                        </div>
                    </div>
                @endif

                <!-- Phone -->
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">
                        <span class="required">Contact Phone</span>
                    </label>
                    <div class="col-lg-8 fv-row">
                        <input type="tel" name="phone" class="form-control form-control-lg form-control-solid"
                            placeholder="Phone number" value="{{ $user->phone }}" />
                    </div>
                </div>

            </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save
                    Changes</button>
            </div>
        </form>
    </div>
</div>
