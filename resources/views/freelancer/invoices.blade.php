@extends('layouts.custom.freelancer')
@section('freelancer-css')

@endsection

@section('freelancer-content')
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
                    <a href="{{ route('freelancer.invoice.create') }}" class="btn btn-flex btn-primary h-40px fs-7 fw-bold" >Create Invoice</a>
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
                        <th class="min-w-150px">Client Name</th>
                        <th class="min-w-120px">Due Date</th>
                        <th class="min-w-150px">Invoice Date</th>
                        <th class="min-w-150px">Status</th>
                        <th class="min-w-100px text-end">Amount</th>
                        <th class="min-w-100px text-end">Balance Due</th>
                        <th class="min-w-100px text-end">Action</th>
                    </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
	                    @forelse ($invoices as $invoice)
	                        <tr class="clickable_table_row" data-href="{{ route('freelancer.invoice.show',$invoice->id) }}">
	                            <td>
	                                <div class="form-check form-check-sm form-check-custom form-check-solid">
	                                    <input class="form-check-input widget-13-check" type="checkbox" value="{{ $invoice->id }}">
	                                </div>
	                            </td>
	                            <td>
	                                <span class="text-gray-600 fs-6">{{ $invoice->invoice_number }}</span>
	                            </td>
	                            <td>
	                                <span class="text-gray-600 fs-6">{{ $invoice->client->name ?? '-'}}</span>
	                            </td>

	                            <td>
	                                <span class="text-gray-600 fs-6">{{ $invoice->due_date->format('d M, Y') }}</span>
	                            </td>
	                            <td>
	                                <span class="text-gray-600 fs-6">{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M, Y') }}</span>
	                            </td>
	                            <td> 
	                                @php
									   
									    $due = \Carbon\Carbon::parse($invoice->due_date);
									    $today = \Carbon\Carbon::today();
									    $status = ucfirst(strtolower($invoice->status));
									    $overdueDays = 0;

									    if (!in_array($status, ['Paid', 'Written off'])) {
									        if ($due->isPast()) {
									            $status = 'Overdue';
									            $overdueDays = $due->diffInDays($today);
									        } elseif ($due->diffInDays($today) <= 6) {
									            $status = 'Due Soon';
									        } else {
									            $status = 'Unpaid';
									        }
									    }
									@endphp

									<span class="badge 
									    {{ $status === 'Overdue' ? 'badge-danger' : 
									       ($status === 'Due Soon' || $status === 'Unpaid' ? 'badge-warning' : 
									       ($status === 'Written off' ? 'badge-secondary' : 'badge-success')) }}">
									    {{ $status === 'Overdue' ? "$status by $overdueDays days" : $status }}
									</span>
	                            </td>
	                            <td class="text-gray-600 fs-6 text-end">
	                                ${{ number_format($invoice->total, 2) }}
	                            </td>
	                            <td class="text-gray-600 fs-6 text-end">
	                                ${{ number_format($invoice->due, 2) }}
	                            </td>
	                            <td class="text-gray-600 fs-6 text-end">
	                                <a href="{{ in_array(strtolower($invoice->status), ['draft', 'sent']) ? route('freelancer.invoice.edit', $invoice->id) : '#' }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
	                                    <i class="ki-outline ki-pencil fs-2"></i>
	                                </a>
	                            </td>
	                        </tr>
	                    @empty
	                        <tr>
	                            <td colspan="10" class="text-center">
	                                No Records Found!
	                            </td>
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

@section('freelancer-js')
    
@endsection