<div class="card mb-5 mb-xl-10">
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_settings_details" aria-expanded="true" aria-controls="kt_account_settings_details">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Platform Settings</h3>
        </div>
    </div>
    <div id="kt_account_settings_details" class="collapse show">
        <form action="{{ route('admin.company.profile.platform.setting.update') }}" method="post" id="kt_account_settings_form" class="form" enctype="multipart/form-data">
            @csrf
            <div class="card-body border-top p-9">
                <!-- Platform Name -->
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Platform Name</label>
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="platform_name" class="form-control form-control-lg form-control-solid" placeholder="Platform Name" value="{{ setting('platform_name', 'My Platform') }}" required />
                    </div>
                </div>

                <!-- Platform Logo -->
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Platform Logo</label>
                    <div class="col-lg-8">
                        <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url({{ asset('assets/media/svg/files/blank-image.svg') }})">
                            <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{ Storage::url(setting('platform_logo')) }})"></div>
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change logo">
                                <i class="ki-outline ki-pencil fs-7"></i>
                                <input type="file" name="platform_logo" accept=".png, .jpg, .jpeg" />
                                <input type="hidden" name="platform_logo_remove" />
                            </label>
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel logo">
                                <i class="ki-outline ki-cross fs-2"></i>
                            </span>
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove logo">
                                <i class="ki-outline ki-cross fs-2"></i>
                            </span>
                        </div>
                        <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                    </div>
                </div>

                <!-- Platform Favicon -->
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Platform Favicon</label>
                    <div class="col-lg-8">
                        <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url({{ asset('assets/media/svg/files/blank-image.svg') }})">
                            <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{ Storage::url(setting('platform_favicon')) }})"></div>
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change favicon">
                                <i class="ki-outline ki-pencil fs-7"></i>
                                <input type="file" name="platform_favicon" accept=".png, .jpg, .jpeg, .ico" />
                                <input type="hidden" name="platform_favicon_remove" />
                            </label>
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel favicon">
                                <i class="ki-outline ki-cross fs-2"></i>
                            </span>
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove favicon">
                                <i class="ki-outline ki-cross fs-2"></i>
                            </span>
                        </div>
                        <div class="form-text">Allowed file types: png, jpg, jpeg, ico.</div>
                    </div>
                </div>

                <!-- Support Email -->
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Support Email</label>
                    <div class="col-lg-8 fv-row">
                        <input type="email" name="support_email" class="form-control form-control-lg form-control-solid" placeholder="Support Email" value="{{ setting('support_email', 'support@example.com') }}" required />
                    </div>
                </div>

                <!-- Support Contact Info -->
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Support Contact Info</label>
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="support_contact_info" class="form-control form-control-lg form-control-solid" placeholder="Support Contact Info" value="{{ setting('support_contact_info') }}" />
                    </div>
                </div>

                <!-- Default Language -->
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Default Language</label>
                    <div class="col-lg-8 fv-row">
                        <select name="default_language" class="form-select form-select-lg form-select-solid" required>
                            <option value="en" {{ setting('default_language', 'en') == 'en' ? 'selected' : '' }}>English</option>
                            <option value="es" {{ setting('default_language', 'en') == 'es' ? 'selected' : '' }}>Spanish</option>
                            <option value="fr" {{ setting('default_language', 'en') == 'fr' ? 'selected' : '' }}>French</option>
                            <!-- Add more languages as needed -->
                        </select>
                    </div>
                </div>

                <!-- Default Timezone -->
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Default Timezone</label>
                    <div class="col-lg-8 fv-row">
                        <select name="default_timezone" class="form-select form-select-lg form-select-solid" required>
                            <option value="UTC" {{ setting('default_timezone', 'UTC') == 'UTC' ? 'selected' : '' }}>UTC</option>
                            <option value="America/New_York" {{ setting('default_timezone', 'UTC') == 'America/New_York' ? 'selected' : '' }}>America/New_York</option>
                            <option value="Asia/Karachi" {{ setting('default_timezone', 'UTC') == 'Asia/Karachi' ? 'selected' : '' }}>Asia/Karachi</option>
                            <!-- Add more timezones as needed -->
                        </select>
                    </div>
                </div>

                <!-- Maintenance Mode -->
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Maintenance Mode</label>
                    <div class="col-lg-8 fv-row">
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" name="maintenance_mode" value="1" {{ setting('maintenance_mode', '0') == '1' ? 'checked' : '' }} />
                            <label class="form-check-label">Enable Maintenance Mode</label>
                        </div>
                    </div>
                </div>

                <!-- Commission Rate -->
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Commission Rate (%)</label>
                    <div class="col-lg-8 fv-row">
                        <input type="number" name="commission_rate" class="form-control form-control-lg form-control-solid" placeholder="Commission Rate" value="{{ setting('commission_rate', '5') }}" min="0" max="100" step="0.1" required />
                    </div>
                </div>

                <!-- Default Currency -->
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Default Currency</label>
                    <div class="col-lg-8 fv-row">
                        <select name="default_currency" class="form-select form-select-lg form-select-solid" required>
                            <option value="USD" {{ setting('default_currency', 'USD') == 'USD' ? 'selected' : '' }}>USD</option>
                            <option value="AED" {{ setting('default_currency', 'USD') == 'AED' ? 'selected' : '' }}>AED</option>
                            <option value="PKR" {{ setting('default_currency', 'USD') == 'PKR' ? 'selected' : '' }}>PKR</option>
                            <!-- Add more currencies as needed -->
                        </select>
                    </div>
                </div>

                <!-- Minimum Withdrawal Amount -->
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Minimum Withdrawal Amount</label>
                    <div class="col-lg-8 fv-row">
                        <input type="number" name="minimum_withdrawal_amount" class="form-control form-control-lg form-control-solid" placeholder="Minimum Withdrawal Amount" value="{{ setting('minimum_withdrawal_amount', '10') }}" min="0" step="0.01" required />
                    </div>
                </div>

                <!-- Withdrawal Processing Time -->
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Withdrawal Processing Time (days)</label>
                    <div class="col-lg-8 fv-row">
                        <input type="number" name="withdrawal_processing_time" class="form-control form-control-lg form-control-solid" placeholder="Withdrawal Processing Time" value="{{ setting('withdrawal_processing_time', '3') }}" min="0" required />
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="submit" class="btn btn-primary" id="kt_account_settings_submit">Save Changes</button>
            </div>
        </form>
    </div>
</div>