<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
    <div class="card-header cursor-pointer">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Profile Details</h3>
        </div>
        <a href="{{ route('client.company.profile.setting') }}" class="btn btn-sm btn-primary align-self-center">Edit Profile</a>
    </div>
    <div class="card-body p-9">
        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">Full Name</label>
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">{{ auth()->user()->name }}</span>
            </div>
        </div>
        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">Company</label>
            <div class="col-lg-8 fv-row">
                <span class="fw-semibold text-gray-800 fs-6">{{ auth()->user()->company_name }}</span>
            </div>
        </div>
        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">Contact Phone
                <span class="ms-1" data-bs-toggle="tooltip" title="Phone number must be active">
                    <i class="ki-outline ki-information fs-7"></i>
                </span>
            </label>
            <div class="col-lg-8 d-flex align-items-center">
                <span class="fw-bold fs-6 text-gray-800 me-2">{{ auth()->user()->phone_number }}</span>
                <span class="badge badge-success">Verified</span>
            </div>
        </div>
        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">Contact Email</label>
            <div class="col-lg-8">
                <a href="#" class="fw-semibold fs-6 text-gray-800 text-hover-primary">{{ auth()->user()->email }}</a>
            </div>
        </div>
        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">Country
                <span class="ms-1" data-bs-toggle="tooltip" title="Country of origination">
                    <i class="ki-outline ki-information fs-7"></i>
                </span>
            </label>
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">{{ auth()->user()->company->country ?? ''}}</span>
            </div>
        </div>
        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">State,City</label>
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">{{ auth()->user()->company->state ?? '' }}, {{ auth()->user()->company->city ?? '' }}</span>
            </div>
        </div>
    </div>
</div>