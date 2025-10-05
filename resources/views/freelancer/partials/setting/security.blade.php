<div class="card mb-5 mb-xl-10">
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Change Password</h3>
        </div>
    </div>
    <div id="kt_account_settings_signin_method" class="collapse show">
        <div class="card-body border-top p-9">
            <div class="d-flex flex-wrap align-items-center mb-10">
                <div id="kt_signin_password_edit" class="flex-row-fluid">
                    <form id="kt_signin_change_password" method="POST" action="{{ route('freelancer.profile.password.change') }}" class="form" novalidate="novalidate">
                        @csrf
                        <div class="row mb-1">
                            <div class="col-lg-4">
                                <div class="fv-row mb-0">
                                    <label for="currentpassword" class="form-label fs-6 fw-bold mb-3">Current Password</label>
                                    <input type="password" class="form-control form-control-lg form-control-solid" name="currentpassword" id="currentpassword" required />
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="fv-row mb-0">
                                    <label for="newpassword" class="form-label fs-6 fw-bold mb-3">New Password</label>
                                    <input type="password" class="form-control form-control-lg form-control-solid" name="newpassword" id="newpassword" required />
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="fv-row mb-0">
                                    <label for="confirmpassword" class="form-label fs-6 fw-bold mb-3">Confirm New Password</label>
                                    <input type="password" class="form-control form-control-lg form-control-solid" name="confirmpassword" id="confirmpassword" required />
                                </div>
                            </div>
                        </div>
                        <div class="form-text mb-5">Password must be at least 8 characters and contain symbols</div>
                        <div class="form-text text-danger mb-5">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="d-flex">
                            <button id="kt_password_submit" type="submit" class="btn btn-primary me-2 px-6">Update Password</button>
                            <button id="kt_password_cancel" type="reset" class="btn btn-color-gray-500 btn-active-light-primary px-6">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>