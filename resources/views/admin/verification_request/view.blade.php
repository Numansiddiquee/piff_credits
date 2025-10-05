@extends('layouts.custom.admin')
@section('admin-css')
@endsection

@section('admin-content')
<div id="kt_app_content_container" class="app-container container-fluid">
    <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">
            <div class="d-flex flex-wrap flex-sm-nowrap">
                <!-- Avatar -->
                <div class="me-7 mb-4">
                    <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                        <img src="{{ isset($user->avatar) ? Storage::url($user->avatar) : asset('metronic/assets/media/avatars/300-2.jpg') }}" alt="image" />
                        <div class="position-absolute translate-middle bottom-0 start-100 mb-6 
                            {{ isset($req->status) &&  $req->status === 'verified' ? 'bg-success' : 'bg-warning' }} 
                            rounded-circle border border-4 border-body h-20px w-20px"></div>
                    </div>
                </div>

                <!-- User Info -->
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center mb-2">
                                <span class="text-gray-900 fs-2 fw-bold me-2">{{ $user->name ?? ''}}</span>
                                @if($req->status === 'verified')
                                    <i class="ki-outline ki-verify fs-1 text-primary"></i>
                                @endif
                            </div>
                            <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                <span class="d-flex align-items-center text-gray-500 text-capitalize me-5 mb-2">
                                    <i class="ki-outline ki-profile-circle fs-4 me-1"></i>
                                    {{ ucfirst($user->user_type) }}
                                </span>
                                <span class="d-flex align-items-center text-gray-500 me-5 mb-2">
                                    <i class="ki-outline ki-sms fs-4 me-1"></i>{{ $user->email ?? ''}}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                <li class="nav-item mt-2">
                    <a class="nav-link active ms-0 me-10 py-5">Verification Details</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Documents Section -->
    <div class="card mb-5">
        <div class="card-header">
            <h3 class="card-title">Uploaded Documents</h3>
        </div>
        <div class="card-body">
	        <table class="table table-hover table-rounded gy-4 gs-4 align-middle">
	            <thead>
	                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-light">
	                    <th class="min-w-150px text-gray-900">Document</th>
                        <th class="min-w-150px text-gray-900">KYC ID</th>
                        <th class="min-w-150px text-gray-900">Status</th>
                        <th class="min-w-150px text-gray-900">Preview</th>
                        <th class="min-w-150px text-gray-900">Submitted</th>
                        <th class="min-w-150px text-gray-900">Reviewed</th>
	                </tr>
	            </thead>
	            <tbody>
	                @forelse($documents as $doc)
                    <tr>
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
    </div>
</div>
@endsection

@section('admin-js')
<script>
    // Optional JS enhancements (toastr notifications after approve/reject)
</script>
@endsection
