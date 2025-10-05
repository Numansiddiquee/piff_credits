@extends('layouts.custom.client')
@section('client-css')

@endsection

@section('client-content')
   	<div id="kt_app_toolbar" class="app-toolbar pt-0 pb-2">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
            <!--begin::Toolbar wrapper-->
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
                        Items</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="#"
                       class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 fw-bold d-none"
                       data-bs-toggle="modal" data-bs-target="#kt_modal_view_users">Add Member</a>
                    <a href="#" class="btn btn-flex btn-primary h-40px fs-7 fw-bold">Create
                        Item</a>
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
                                <input class="form-check-input" type="checkbox" value="1" data-kt-check="true"
                                       data-kt-check-target=".widget-13-check">
                            </div>
                        </th>
                        <th class="min-w-150px text-gray-900">Name</th>
                        <th class="min-w-150px text-gray-900">Description</th>
                        <th class="min-w-150px text-gray-900">Rate</th>
                        <th class="min-w-150px text-gray-900">Usage Unit</th>
                        <th class="min-w-100px text-end text-gray-900">Action</th>
                    </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
	                    <!-- Dummy Item 1 -->
						<tr class="clickable_table_row" data-href="#">
						    <td>
						        <div class="form-check form-check-sm form-check-custom form-check-solid">
						            <input class="form-check-input widget-13-check" type="checkbox" value="1">
						        </div>
						    </td>
						    <td>
						        <span class="text-gray-600 fs-6">Laptop Pro</span>
						    </td>
						    <td>
						        <span class="text-gray-600 fs-6">High-performance laptop with 16GB RAM</span>
						    </td>
						    <td>
						        <span class="text-gray-600 fs-6">$ {{ number_format(999.99, 2) }}</span>
						    </td>
						    <td>
						        <span class="text-gray-600 fs-6">Unit</span>
						    </td>
						    <td class="text-end">
						        <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
						            <i class="ki-outline ki-pencil fs-2"></i>
						        </a>
						    </td>
						</tr>

						<!-- Dummy Item 2 -->
						<tr class="clickable_table_row" data-href="#">
						    <td>
						        <div class="form-check form-check-sm form-check-custom form-check-solid">
						            <input class="form-check-input widget-13-check" type="checkbox" value="2">
						        </div>
						    </td>
						    <td>
						        <span class="text-gray-600 fs-6">Wireless Mouse</span>
						    </td>
						    <td>
						        <span class="text-gray-600 fs-6">Ergonomic mouse with Bluetooth connectivity</span>
						    </td>
						    <td>
						        <span class="text-gray-600 fs-6">$ {{ number_format(49.99, 2) }}</span>
						    </td>
						    <td>
						        <span class="text-gray-600 fs-6">Piece</span>
						    </td>
						    <td class="text-end">
						        <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
						            <i class="ki-outline ki-pencil fs-2"></i>
						        </a>
						    </td>
						</tr>

						<!-- Dummy Item 3 -->
						<tr class="clickable_table_row" data-href="#">
						    <td>
						        <div class="form-check form-check-sm form-check-custom form-check-solid">
						            <input class="form-check-input widget-13-check" type="checkbox" value="3">
						        </div>
						    </td>
						    <td>
						        <span class="text-gray-600 fs-6">USB-C Cable</span>
						    </td>
						    <td>
						        <span class="text-gray-600 fs-6">Durable 1m USB-C charging cable</span>
						    </td>
						    <td>
						        <span class="text-gray-600 fs-6">$ {{ number_format(19.99, 2) }}</span>
						    </td>
						    <td>
						        <span class="text-gray-600 fs-6">Piece</span>
						    </td>
						    <td class="text-end">
						        <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
						            <i class="ki-outline ki-pencil fs-2"></i>
						        </a>
						    </td>
						</tr>
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

@section('client-js')
    
@endsection