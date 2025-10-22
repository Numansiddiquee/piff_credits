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
                        Items
                    </h1>
                    <p class="text-sm text-muted mb-0 mt-0">Items You’ve Been Invoiced For</p>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
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
                        <th class="min-w-150px text-gray-900">Rate (USD)</th>
                        <th class="min-w-150px text-gray-900">Times Used</th>
                        <th class="min-w-150px text-gray-900">Total Quantity</th>
                        <th class="min-w-100px text-end text-gray-900">Total Spent ($)</th>
                    </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                    	@forelse($items as $index => $item)
	                        <tr>
	                            <td>
							        <div class="form-check form-check-sm form-check-custom form-check-solid">
							            <input class="form-check-input widget-13-check" type="checkbox" value="{{ $item->id }}">
							        </div>
							    </td>
	                            <td>{{ $item->item_name }}</td>
	                            <td>{{ $item->description ?? '-' }}</td>
	                            <td>${{ number_format($item->price, 2) }}</td>
	                            <td><b class="text-bold">{{ $item->usage_count }}</b></td>
	                            <td>{{ $item->total_quantity }}</td>
	                            <td class="text-end">${{ number_format($item->total_spent, 2) }}</td>
	                        </tr>
	                    @empty
	                    	<tr>
	                            <td colspan="6" class="text-center">No item used for the invoice yet!</td>
	                        </tr>
	                    @endforelse
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