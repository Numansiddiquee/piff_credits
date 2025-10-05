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
                       class="btn btn-flex btn-primary h-40px fs-7 fw-bold d-none">New Quote</a>
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Toolbar wrapper-->
        </div>
        <!--end::Toolbar container-->
    </div>




    <div class="card mb-5 mb-xl-8">
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
                        <th class="min-w-120px text-gray-900">Client Name</th>
                        <th class="min-w-120px text-gray-900">Freelancer Name</th>
                        <th class="min-w-120px text-gray-900">Date</th>
                        <th class="min-w-120px text-gray-900">Quote Status</th>
                        <th class="min-w-120px text-gray-900">Total</th>
                        <th class="min-w-100px text-end text-gray-900">Actions</th>
                    </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                        @forelse($quotes as $quote)
                            <tr class="clickable_table_row" data-href="{{ route('admin.quote.view_quote',$quote->id) }}">
                                <td>
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input widget-13-check" type="checkbox" value="1">
                                    </div>
                                </td>
                                <td>
                                    <span
                                       class="text-gray-600 fs-6">{{$quote->quote_id}}</span>
                                </td>
                                <td>
                                    <span
                                       class="text-gray-600 d-block mb-1 fs-6">{{$quote->reference}}</span>
                                </td>
                                <td>
                                    <span class="text-gray-600 d-block mb-1 fs-6">{{$quote->customer->first_name.' '. $quote->customer->last_name}}</span>
                                </td>
                                <td>
                                    <span class="text-gray-600 d-block mb-1 fs-6">{{$quote->freelancer->first_name.' '. $quote->freelancer->last_name}}</span>
                                </td>
                                <td>
                                    <span class="text-gray-600 d-block mb-1 fs-6">{{ $quote->quote_date }}</span>
                                </td>
                                <td class="text-gray-600 fs-6">{{ $quote->status }}</td>
                                <td class="text-gray-600 fs-6">{{ "$ ".$quote->grand_total }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.quote.edit_quote',$quote->id) }}"
                                       class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                        <i class="ki-outline ki-pencil fs-2"></i>
                                    </a>
                                </td>
                            </tr>
                        
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No Quotes Found</td>
                            </tr>
                        @endforelse
                    </tbody>
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