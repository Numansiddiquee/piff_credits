@extends('layouts.custom.admin')
@section('admin-css')

@endsection

@section('admin-content')
   	<div id="kt_app_toolbar" class="app-toolbar pt-0 pb-2">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
            <!--begin::Toolbar wrapper-->
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Users</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="#" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 fw-bold d-none" data-bs-toggle="modal" data-bs-target="#kt_modal_view_users">Add Member</a>
                    <a href="{{ route('admin.user.create') }}" class="btn btn-flex btn-primary h-40px fs-7 fw-bold" >Create User</a>
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Toolbar wrapper-->
        </div>
        <!--end::Toolbar container-->
    </div>




    <div class="card mb-5 mb-xl-8">
        <!--begin::Header-->
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-3">
            <!--begin::Table container-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table table-hover table-rounded gy-4 gs-4 align-middle">
				    <!--begin::Table head-->
				    <thead>
				        <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-light">
				            <th class="w-25px">
				                <div class="form-check form-check-sm form-check-custom form-check-solid">
				                    <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target=".widget-13-check">
				                </div>
				            </th>
				            <th>User</th>
				            <th>Role</th>
				            <th>Email</th>
				            <th>Verification Status</th>
				            <th>Joined</th>
				        </tr>
				    </thead>
				    <!--end::Table head-->

				    <!--begin::Table body-->
				    <tbody>
				        @foreach($users as $user)
				            <tr class="clickable_table_row" data-href="{{ route('admin.user.view', $user->id) }}">
				                <!-- Checkbox -->
				                <td>
				                    <div class="form-check form-check-sm form-check-custom form-check-solid">
				                        <input class="form-check-input widget-13-check" type="checkbox" value="{{ $user->id }}">
				                    </div>
				                </td>
				                <td>
				                    <div class="d-flex align-items-center">
				                        <div class="symbol symbol-45px me-3">
				                            <img src="{{ $user->avatar ? Storage::url($user->avatar) : asset('metronic/assets/media/avatars/300-2.jpg') }}" alt="{{ $user->name }}">
				                        </div>
				                        <div class="d-flex flex-column">
				                            <span class="fw-bold text-gray-800">{{ $user->name }}</span>
				                            <span class="text-gray-500">{{ $user->email }}</span>
				                        </div>
				                    </div>
				                </td>
				                <td>
				                    <span class="badge badge-light-{{ $user->user_type == 'freelancer' ? 'primary' : 'success' }}">
				                        {{ $user->user_type ? ucfirst($user->user_type) : 'Super Admin' }}
				                    </span>
				                </td>
				                <td>{{ $user->email }}</td>
				                <td>
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
				                </td>
				                <td>{{ $user->created_at->format('M d, Y') }}</td>
				            </tr>
				        @endforeach
				    </tbody>
				    <!--end::Table body-->
				</table>


                <!--end::Table-->
            </div>
            <!--end::Table container-->
        </div>
        <!--begin::Body-->
    </div>
@endsection

@section('admin-js')
    
@endsection