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
                        Quotes</h1>
                    <!--end::Title-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="#"
                       class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 fw-bold d-none"
                       data-bs-toggle="modal" data-bs-target="#kt_modal_view_users">Add Member</a>
                    <a href="#"
                       class="btn btn-flex btn-primary h-40px fs-7 fw-bold">New Quote</a>
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Toolbar wrapper-->
        </div>
        <!--end::Toolbar container-->
    </div>




    <div class="card mb-5 mb-xl-8">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5 d-none">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">Recent Orders</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Over 500 orders</span>
            </h3>
            <div class="card-toolbar">
                <!--begin::Menu-->
                <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary"
                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                    <i class="ki-outline ki-category fs-6"></i>
                </button>
                <!--begin::Menu 2-->
                <div
                    class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                    data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">Quick Actions</div>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu separator-->
                    <div class="separator mb-3 opacity-75"></div>
                    <!--end::Menu separator-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3">New Ticket</a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3">New Customer</a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
                        <!--begin::Menu item-->
                        <a href="#" class="menu-link px-3">
                            <span class="menu-title">New Group</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <!--end::Menu item-->
                        <!--begin::Menu sub-->
                        <div class="menu-sub menu-sub-dropdown w-175px py-4">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3">Admin Group</a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3">Staff Group</a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3">Member Group</a>
                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu sub-->
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3">New Contact</a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu separator-->
                    <div class="separator mt-3 opacity-75"></div>
                    <!--end::Menu separator-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <div class="menu-content px-3 py-3">
                            <a class="btn btn-primary btn-sm px-4" href="#">Generate Reports</a>
                        </div>
                    </div>
                    <!--end::Menu item-->
                </div>
                <!--end::Menu 2-->
                <!--end::Menu-->
            </div>
        </div>
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
                        <th class="min-w-150px text-gray-900">Quote Number</th>
                        <th class="min-w-140px text-gray-900">Reference</th>
                        <th class="min-w-120px text-gray-900">Customer Name</th>
                        <th class="min-w-120px text-gray-900">Date</th>
                        <th class="min-w-120px text-gray-900">Quote Status</th>
                        <th class="min-w-120px text-gray-900">Total</th>
                        <th class="min-w-100px text-end text-gray-900">Actions</th>
                    </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                    	<!-- Dummy Quote 1 -->
						<tr class="clickable_table_row" data-href="#">
						    <td>
						        <div class="form-check form-check-sm form-check-custom form-check-solid">
						            <input class="form-check-input widget-13-check" type="checkbox" value="1">
						        </div>
						    </td>
						    <td>
						        <span class="text-gray-600 fs-6">QTE-001</span>
						    </td>
						    <td>
						        <span class="text-gray-600 d-block mb-1 fs-6">REF-001</span>
						    </td>
						    <td>
						        <span class="text-gray-600 d-block mb-1 fs-6">John Doe</span>
						    </td>
						    <td>
						        <span class="text-gray-600 d-block mb-1 fs-6">{{ \Carbon\Carbon::parse('2025-08-01')->format('d M Y') }}</span>
						    </td>
						    <td class="text-gray-600 fs-6">Accepted</td>
						    <td class="text-gray-600 fs-6">$ {{ number_format(1200.00, 2) }}</td>
						    <td class="text-end">
						        <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
						            <i class="ki-outline ki-pencil fs-2"></i>
						        </a>
						    </td>
						</tr>

						<!-- Dummy Quote 2 -->
						<tr class="clickable_table_row" data-href="#">
						    <td>
						        <div class="form-check form-check-sm form-check-custom form-check-solid">
						            <input class="form-check-input widget-13-check" type="checkbox" value="2">
						        </div>
						    </td>
						    <td>
						        <span class="text-gray-600 fs-6">QTE-002</span>
						    </td>
						    <td>
						        <span class="text-gray-600 d-block mb-1 fs-6">REF-002</span>
						    </td>
						    <td>
						        <span class="text-gray-600 d-block mb-1 fs-6">Jane Smith</span>
						    </td>
						    <td>
						        <span class="text-gray-600 d-block mb-1 fs-6">{{ \Carbon\Carbon::parse('2025-08-15')->format('d M Y') }}</span>
						    </td>
						    <td class="text-gray-600 fs-6">Pending</td>
						    <td class="text-gray-600 fs-6">$ {{ number_format(850.75, 2) }}</td>
						    <td class="text-end">
						        <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
						            <i class="ki-outline ki-pencil fs-2"></i>
						        </a>
						    </td>
						</tr>

						<!-- Dummy Quote 3 -->
						<tr class="clickable_table_row" data-href="#">
						    <td>
						        <div class="form-check form-check-sm form-check-custom form-check-solid">
						            <input class="form-check-input widget-13-check" type="checkbox" value="3">
						        </div>
						    </td>
						    <td>
						        <span class="text-gray-600 fs-6">QTE-003</span>
						    </td>
						    <td>
						        <span class="text-gray-600 d-block mb-1 fs-6">REF-003</span>
						    </td>
						    <td>
						        <span class="text-gray-600 d-block mb-1 fs-6">Alice Johnson</span>
						    </td>
						    <td>
						        <span class="text-gray-600 d-block mb-1 fs-6">{{ \Carbon\Carbon::parse('2025-08-25')->format('d M Y') }}</span>
						    </td>
						    <td class="text-gray-600 fs-6">Draft</td>
						    <td class="text-gray-600 fs-6">$ {{ number_format(450.00, 2) }}</td>
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