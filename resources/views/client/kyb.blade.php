@extends('layouts.custom.client')
@section('client-css') @endsection

@section('client-content')
<div id="kt_app_toolbar" class="app-toolbar pt-0 pb-2">
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">KYB Verification</h1>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <a href="{{ route('client.kyb.submit.documents') }}" class="btn btn-flex btn-primary h-40px fs-7 fw-bold">Submit KYB</a>
            </div>
        </div>
    </div>
</div>

<div class="card mb-5 mb-xl-8">
    <div class="card-body py-3">
        <!--begin::Table container-->
        <div class="table-responsive">
            <table class="table table-hover table-rounded gy-4 gs-4 align-middle">
                <!-- Table Head -->
                <thead>
                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-light">
                        <th class="w-25px">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" data-kt-check="true"
                                       data-kt-check-target=".document-check">
                            </div>
                        </th>
                        <th class="min-w-150px text-gray-900">Document</th>
                        <th class="min-w-150px text-gray-900">KYB ID</th>
                        <th class="min-w-150px text-gray-900">Status</th>
                        <th class="min-w-150px text-gray-900">Preview</th>
                        <th class="min-w-150px text-gray-900">Submitted</th>
                        <th class="min-w-150px text-gray-900">Reviewed</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody>
                    @forelse($documents as $doc)
                    <tr>
                        <td>
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input document-check" type="checkbox" value="{{ $doc->id }}">
                            </div>
                        </td>

                        <!-- Document Name / Icon -->
                        <td>
                            @php
                                $iconSvg = match($doc->type) {
                                    'id_card' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                      <rect x="3" y="4" width="18" height="16" rx="2" ry="2"/>
                                                      <line x1="3" y1="10" x2="21" y2="10"/>
                                                      <circle cx="9" cy="15" r="2"/>
                                                  </svg>',
                                    'passport' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                       <circle cx="12" cy="12" r="10"/>
                                                       <line x1="2" y1="12" x2="22" y2="12"/>
                                                       <line x1="12" y1="2" x2="12" y2="22"/>
                                                   </svg>',
                                    'driver_license' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                             <rect x="3" y="4" width="18" height="16" rx="2"/>
                                                             <line x1="7" y1="10" x2="17" y2="10"/>
                                                             <circle cx="8" cy="16" r="1"/>
                                                         </svg>',
                                    'selfie' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                     <circle cx="12" cy="8" r="4"/>
                                                     <path d="M6 20c0-3 3-5 6-5s6 2 6 5"/>
                                                 </svg>',
                                    default => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path d="M4 4h16v16H4z"/>
                                                </svg>',
                                };
                            @endphp

                            <span class="flex items-center">{!! $iconSvg !!}</span>


                            <span>{{ ucwords(str_replace('_', ' ', $doc->type)) }}</span>
                        </td>

                        <!-- Sub Type -->
                        <td>
                            <span>{{ $doc->sumsub_doc_id ?? '-' }}</span>
                        </td>

                        <!-- Status with badge -->
                        <td>
                            @php
                                $badgeClass = match($doc->status) {
                                    'pending' => 'badge badge-light-warning',
                                    'approved' => 'badge badge-light-success',
                                    'rejected' => 'badge badge-light-danger',
                                    default => 'badge badge-light-secondary',
                                };
                            @endphp
                            <span class="{{ $badgeClass }}">{{ ucfirst($doc->status) }}</span>
                        </td>

                        <!-- Image Preview -->
                        <td>
                            @if (in_array(pathinfo($doc->file_path, PATHINFO_EXTENSION), ['jpg','jpeg','png','gif']))
                                <img src="{{ asset($doc->file_path) }}" alt="doc" class="img-thumbnail" style="height:60px;">
                            @else
                                <i class="ki-outline ki-file fs-2 text-muted"></i>
                            @endif
                        </td>

                        <td>{{ $doc->verification->submitted_at->diffForHumans() }}</td>
                        <td>{{ $doc->verification->reviewed_at->diffForHumans() }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 fs-6">No documents submitted yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>


        </div>
        <!--end::Table container-->
    </div>
</div>





<div class="card mb-5 mb-xl-8 d-none">
    <div class="card-body py-3">
        <form action="#" method="POST" enctype="multipart/form-data" class="row g-5">
            @csrf
            <div class="col-md-6">
                <label class="form-label fw-semibold">Document Type</label>
                <select class="form-select form-select-solid" name="document_type">
                    <option value="passport">Passport</option>
                    <option value="nid">National ID</option>
                    <option value="license">Driving License</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Upload Document</label>
                <input type="file" class="form-control form-control-solid" name="document">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Selfie (Liveness)</label>
                <input type="file" class="form-control form-control-solid" name="selfie">
            </div>
            <div class="col-12">
                <button class="btn btn-primary">Submit for Verification</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('client-js') @endsection
