<div class="card mb-5 mb-xl-10">
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_payment_method">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Stripe Payment Method</h3>
        </div>
    </div>
    <div id="kt_account_payment_method" class="collapse show">
        <div class="card-body border-top p-9">
            <div class="d-flex flex-wrap align-items-center mb-10">
                <div id="kt_payment_method_edit" class="flex-row-fluid">
                    <form id="kt_payment_method_form" method="POST" action="{{ route('admin.company.profile.payment.credentials') }}" class="form" novalidate="novalidate">
                        @csrf
                        <input type="hidden" name="provider" value="stripe">
                        <div class="row mb-1">
                            <div class="col-lg-6">
                                <div class="fv-row mb-0">
                                    <label for="stripe_mode" class="form-label fs-6 fw-bold mb-3">Mode</label>
                                    <select class="form-control form-control-lg form-control-solid" name="mode" id="stripe_mode" required>
                                        <option value="sandbox">Sandbox</option>
                                        <option value="live">Live</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="fv-row mb-0">
                                    <label for="stripe_public_key" class="form-label fs-6 fw-bold mb-3">Stripe Public Key</label>
                                    <input type="text" class="form-control form-control-lg form-control-solid" name="public_key" id="stripe_public_key" value="{{ auth()->user()->paymentMethod->public_key ?? '' }}" required />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="fv-row mb-0">
                                    <label for="stripe_secret_key" class="form-label fs-6 fw-bold mb-3">Stripe Secret Key</label>
                                    <input type="text" class="form-control form-control-lg form-control-solid" name="secret_key" id="stripe_secret_key" value="{{ auth()->user()->paymentMethod->secret_key ?? '' }}" required />
                                </div>
                            </div>
                        </div>
                        <div class="form-text mb-5">Enter your Stripe API credentials to enable payments.</div>
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
                            <button id="kt_payment_submit" type="submit" class="btn btn-primary me-2 px-6">Save Credentials</button>
                            <button id="kt_payment_cancel" type="reset" class="btn btn-color-gray-500 btn-active-light-primary px-6">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
