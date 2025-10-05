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
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Invoices</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="#" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 fw-bold d-none" data-bs-toggle="modal" data-bs-target="#kt_modal_view_users">Add Member</a>
                    <a href="#" class="btn btn-flex btn-primary h-40px fs-7 fw-bold" >Create Invoice</a>
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
                                <input class="form-check-input" type="checkbox" value="1" data-kt-check="true" data-kt-check-target=".widget-13-check">
                            </div>
                        </th>
                        <th class="min-w-150px">Invoice #</th>
                        <th class="min-w-150px">Order #</th>
                        <th class="min-w-150px">Customer Name</th>
                        <th class="min-w-120px">Status</th>
                        <th class="min-w-150px">Invoice Date</th>
                        <th class="min-w-150px">Due Date</th>
                        <th class="min-w-100px text-end">Amount</th>
                        <th class="min-w-100px text-end">Balance Due</th>
                        <th class="min-w-100px text-end">Action</th>
                    </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
	                    <!-- Dummy Invoice 1: Paid -->
						<tr class="clickable_table_row" data-href="#">
						    <td>
						        <div class="form-check form-check-sm form-check-custom form-check-solid">
						            <input class="form-check-input widget-13-check" type="checkbox" value="1">
						        </div>
						    </td>
						    <td>
						        <span class="text-gray-600 fs-6">INV-001</span>
						    </td>
						    <td>
						        <span class="text-gray-600 fs-6">ORD-001</span>
						    </td>
						    <td>
						        <span class="text-gray-600 fs-6">John Doe</span>
						    </td>
						    <td>
						        <span class="text-gray-600 fs-6">Paid</span>
						    </td>
						    <td>
						        <span class="text-gray-600 fs-6">{{ \Carbon\Carbon::parse('2025-08-01')->format('d M Y') }}</span>
						    </td>
						    <td>
						        @php
						            $status = 'Paid';
						        @endphp
						        <span class="badge badge-success">
						            {{ $status }}
						        </span>
						    </td>
						    <td class="text-gray-600 fs-6 text-end">
						        ${{ number_format(500.00, 2) }}
						    </td>
						    <td class="text-gray-600 fs-6 text-end">
						        ${{ number_format(0.00, 2) }}
						    </td>
						    <td class="text-gray-600 fs-6 text-end">
						        <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
						            <i class="ki-outline ki-pencil fs-2"></i>
						        </a>
						    </td>
						</tr>

						<!-- Dummy Invoice 2: Overdue -->
						<tr class="clickable_table_row" data-href="#">
						    <td>
						        <div class="form-check form-check-sm form-check-custom form-check-solid">
						            <input class="form-check-input widget-13-check" type="checkbox" value="2">
						        </div>
						    </td>
						    <td>
						        <span class="text-gray-600 fs-6">INV-002</span>
						    </td>
						    <td>
						        <span class="text-gray-600 fs-6">ORD-002</span>
						    </td>
						    <td>
						        <span class="text-gray-600 fs-6">Jane Smith</span>
						    </td>
						    <td>
						        <span class="text-gray-600 fs-6">Unpaid</span>
						    </td>
						    <td>
						        <span class="text-gray-600 fs-6">{{ \Carbon\Carbon::parse('2025-07-15')->format('d M Y') }}</span>
						    </td>
						    <td>
						        @php
						            $dueDate = \Carbon\Carbon::parse('2025-07-20');
						            $today = \Carbon\Carbon::today();
						            $status = '';
						            $overdueDays = 0;
						            $paid = 'no';
						            if ($dueDate->isPast() && $paid == 'no') {
						                $status = 'Overdue';
						                $overdueDays = $dueDate->diffInDays($today);
						            } elseif ($dueDate->diffInDays($today) <= 6 && $paid == 'no') {
						                $status = 'Due Soon';
						            } elseif ($paid == 'no') {
						                $status = 'Unpaid';
						            } else {
						                $status = 'Paid';
						            }
						        @endphp
						        <span class="badge badge-danger">
						            {{ $status == "Overdue" ? $status . ' by ' . $overdueDays . ' Days' : $status }}
						        </span>
						    </td>
						    <td class="text-gray-600 fs-6 text-end">
						        ${{ number_format(750.50, 2) }}
						    </td>
						    <td class="text-gray-600 fs-6 text-end">
						        ${{ number_format(750.50, 2) }}
						    </td>
						    <td class="text-gray-600 fs-6 text-end">
						        <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
						            <i class="ki-outline ki-pencil fs-2"></i>
						        </a>
						    </td>
						</tr>

						<!-- Dummy Invoice 3: Due Soon -->
						<tr class="clickable_table_row" data-href="#">
						    <td>
						        <div class="form-check form-check-sm form-check-custom form-check-solid">
						            <input class="form-check-input widget-13-check" type="checkbox" value="3">
						        </div>
						    </td>
						    <td>
						        <span class="text-gray-600 fs-6">INV-003</span>
						    </td>
						    <td>
						        <span class="text-gray-600 fs-6">N/A</span>
						    </td>
						    <td>
						        <span class="text-gray-600 fs-6">Alice Johnson</span>
						    </td>
						    <td>
						        <span class="text-gray-600 fs-6">Unpaid</span>
						    </td>
						    <td>
						        <span class="text-gray-600 fs-6">{{ \Carbon\Carbon::parse('2025-08-25')->format('d M Y') }}</span>
						    </td>
						    <td>
						        @php
						            $dueDate = \Carbon\Carbon::parse('2025-09-01');
						            $today = \Carbon\Carbon::today();
						            $status = '';
						            $overdueDays = 0;
						            $paid = 'no';
						            if ($dueDate->isPast() && $paid == 'no') {
						                $status = 'Overdue';
						                $overdueDays = $dueDate->diffInDays($today);
						            } elseif ($dueDate->diffInDays($today) <= 6 && $paid == 'no') {
						                $status = 'Due Soon';
						            } elseif ($paid == 'no') {
						                $status = 'Unpaid';
						            } else {
						                $status = 'Paid';
						            }
						        @endphp
						        <span class="badge badge-warning">
						            {{ $status == "Overdue" ? $status . ' by ' . $overdueDays . ' Days' : $status }}
						        </span>
						    </td>
						    <td class="text-gray-600 fs-6 text-end">
						        ${{ number_format(300.00, 2) }}
						    </td>
						    <td class="text-gray-600 fs-6 text-end">
						        ${{ number_format(300.00, 2) }}
						    </td>
						    <td class="text-gray-600 fs-6 text-end">
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