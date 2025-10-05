<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
    <div class="card-header cursor-pointer">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Profile Details</h3>
        </div>
        <a href="{{ route('admin.user.edit',$user->id) }}" class="btn btn-sm btn-primary align-self-center">
            Edit Profile
        </a>
    </div>

    <div class="card-body p-9">
        <!-- Full Name -->
        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">Full Name</label>
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">{{ $user->name }}</span>
            </div>
        </div>

        <!-- Role -->
        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">Role</label>
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">
                    {{ $user->roles->first()->name ?? 'Unassigned' }}
                </span>
            </div>
        </div>

        <!-- Show these only if role is Client -->
        @if($user->roles->first()->name === 'Client')
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Company</label>
                <div class="col-lg-8 fv-row">
                    <span class="fw-semibold text-gray-800 fs-6">{{ $user->company_name ?? '—' }}</span>
                </div>
            </div>

            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Country</label>
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $user->company->country ?? '—' }}</span>
                </div>
            </div>

            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">State, City</label>
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">
                        {{ $user->company->state ?? '—' }}, {{ $user->company->city ?? '—' }}
                    </span>
                </div>
            </div>
        @endif

        <!-- Phone -->
        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">Contact Phone</label>
            <div class="col-lg-8 d-flex align-items-center">
                @if($user->phone)
                    <span class="fw-bold fs-6 text-gray-800 me-2">{{ $user->phone ?? '—' }}</span>
                    @if($user->phone)
                        <span class="badge badge-success">Verified</span>
                    @else
                        <span class="badge badge-warning">Not Verified</span>
                    @endif
                @else
                -
                @endif
            </div>
        </div>

        <!-- Email -->
        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">Contact Email</label>
            <div class="col-lg-8">
                <a href="mailto:{{ $user->email }}" class="fw-semibold fs-6 text-gray-800 text-hover-primary">
                    {{ $user->email }}
                </a>
            </div>
        </div>

        <!-- Verification Status -->
        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">Verification Status</label>
            <div class="col-lg-8">
                @php
                    $status = optional($user->latestVerification)->status ?? 'unverified';
                    $badgeColors = [
                        'unverified' => 'secondary',
                        'pending' => 'info',
                        'verified' => 'success',
                        'rejected' => 'danger'
                    ];
                @endphp
                <span class="badge badge-light-{{ $badgeColors[$status] ?? 'secondary' }}">
                    {{ ucfirst($status) }}
                </span>
            </div>
        </div>
        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">Verification Docs</label>
            <div class="col-lg-8">
                @if($user->verificationDocuments && $user->verificationDocuments->count())
                    <ul class="list-unstyled">
                        @foreach($user->verificationDocuments as $doc)
                            <li>
                                <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="text-primary">
                                    {{ ucfirst($doc->type) }} ({{ strtoupper($doc->status) }})
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <span class="text-muted">No documents uploaded yet.</span>
                @endif
            </div>
        </div>
    </div>
</div>
