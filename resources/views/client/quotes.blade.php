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
                        <th class="min-w-120px text-gray-900">Freelancer Name</th>
                        <th class="min-w-120px text-gray-900">Date</th>
                        <th class="min-w-120px text-gray-900">Quote Status</th>
                        <th class="min-w-120px text-gray-900">Total</th>
                    </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                    	@if(count($quotes) > 0)
                            @foreach($quotes as $quote)
                                <tr class="clickable_table_row" data-href="{{ route('client.quote.view',$quote->id) }}">
                                    <td>
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input widget-13-check" type="checkbox" value="1">
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-gray-600 fs-6">{{ $quote->quote_number }}</span>
                                    </td>
                                    <td>
                                        <span class="text-gray-600 d-block mb-1 fs-6">{{ $quote->reference }}</span>
                                    </td>
                                    <td>
                                        <span class="text-gray-600 d-block mb-1 fs-6">{{ $quote->freelancer->name }}</span>
                                    </td>
                                    <td>
                                        <span class="text-gray-600 d-block mb-1 fs-6">{{ \Carbon\Carbon::parse($quote->quote_date)->format('d M, Y') }}</span>
                                    </td>
                                    <td class="text-gray-600 fs-6">
                                        @php
                                            $status = $quote->status;
                                            $badges = [
                                                'Draft' => 'badge-light-secondary',
                                                'Accepted' => 'badge-light-success',
                                                'Declined' => 'badge-light-danger',
                                                'Converted To Invoice' => 'badge-light-primary',
                                            ];
                                            $badgeClass = $badges[$status] ?? 'badge-light-info';
                                        @endphp

                                        <span class="badge fw-semibold {{ $badgeClass }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                    </td>
                                    <td class="text-gray-600 fs-6">{{ "$ ".$quote->grand_total }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center">No Quotes Found</td>
                            </tr>
                        @endif
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