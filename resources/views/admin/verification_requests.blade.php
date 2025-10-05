@extends('layouts.custom.admin')

@section('admin-css')
@endsection

@section('admin-content')
<div id="kt_app_toolbar" class="app-toolbar pt-0 pb-2">
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
                    Verification Requests
                </h1>
            </div>
        </div>
    </div>
</div>

<div class="card mb-5 mb-xl-8">
    <div class="card-body py-3">
        <div class="table-responsive">
            <table class="table table-hover table-rounded gy-4 gs-4 align-middle">
                <thead>
                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-light">
                        <th class="w-25px">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target=".widget-13-check">
                            </div>
                        </th>
                        <th>User</th>
                        <th>Role</th>
                        <th>Verification Type</th>
                        <th>Documents</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $request)
                        <tr>
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input widget-13-check" type="checkbox" value="{{ $request->id }}">
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-45px me-3">
                                        <img src="{{ $request->user->avatar ? Storage::url($request->user->avatar) : asset('metronic/assets/media/avatars/300-2.jpg') }}" 
                                             alt="{{ $request->user->name }}">
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-gray-800">{{ $request->user->name }}</span>
                                        <span class="text-gray-500">{{ $request->user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-light-{{ $request->user->user_type == 'freelancer' ? 'primary' : 'success' }}">
                                    {{ ucfirst($request->user->user_type) }}
                                </span>
                            </td>
                            <td>{{ strtoupper($request->type) }}</td>
                            <td>
                                @php
                                    $docCount = $request->type === 'kyc'
                                        ? $request->kycDocuments->count()
                                        : $request->kybDocuments->count();
                                @endphp
                                {{ $docCount }} docs
                            </td>
                            <td>
                                @php
                                    $statusColors = [
                                        'pending'       => 'info',
                                        'verified'      => 'success',
                                        'rejected'      => 'danger',
                                        'manual_review' => 'warning',
                                    ];
                                @endphp
                                <span class="badge badge-light-{{ $statusColors[$request->status] ?? 'secondary' }}">
                                    {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                </span>
                            </td>
                            <td>{{ $request->submitted_at ? $request->submitted_at->format('M d, Y') : '—' }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.verification.show', $request->id) }}" 
                                   class="btn btn-sm btn-light btn-active-light-primary">
                                    Review
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
					        <td colspan="8" class="text-center text-muted py-5">
					            No verification requests found.
					        </td>
					    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('admin-js')
@endsection
