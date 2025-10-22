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
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Invoices</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="#" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 fw-bold d-none" data-bs-toggle="modal" data-bs-target="#kt_modal_view_users">Add Member</a>
                    <a href="#" class="btn btn-flex btn-primary h-40px fs-7 fw-bold d-none" >Create Invoice</a>
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
                        <th class="min-w-150px">Freelancer Name</th>
                        <th class="min-w-150px">Invoice Date</th>
                        <th class="min-w-120px">Due Date</th>
                        <th class="min-w-120px">Status</th>
                        <th class="min-w-100px text-end">Amount</th>
                        <th class="min-w-100px text-end">Balance Due</th>
                    </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                    @forelse ($invoices as $invoice)
                        <tr class="clickable_table_row" data-href="{{ route('admin.invoice.view',$invoice->id) }}">
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
                                <span class="text-gray-600 fs-6">{{ $invoice->freelancer->name ?? '-' }}</span>
                            </td>

                            <td>
                                <span class="text-gray-600 fs-6">{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}</span>
                            </td>
                            
                            <td>
                                <span class="text-gray-600 fs-6">{{ $invoice->due_date->format('d M, Y') }}</span>
                            </td>
                            <td>
                                @php
                                    if($invoice->status == 'Paid'){
                                        $status = 'Paid';
                                    }else{
                                        $dueDate = \Carbon\Carbon::parse($invoice->due_date);
                                        $today = \Carbon\Carbon::today();
                                        $status = '';
                                        $overdueDays = 0;
                                        $paid  =  'no';
                                        if ($dueDate->isPast() && $paid == 'no') {
                                            $status = 'Overdue';
                                            $overdueDays = $dueDate->diffInDays($today);
                                        } elseif ($dueDate->diffInDays($today) <= 6 && $paid == 'no') {
                                            $status = 'Due Soon';
                                        } elseif($paid == 'no'){
                                            $status = 'Unpaid';
                                        }else{
                                            $status = 'Paid';
                                        }
                                    }
                                @endphp
                                <span class="badge @if($status == 'Overdue') badge-danger @elseif($status == 'Due Soon' || $status == 'Unpaid' ) badge-warning  @else badge-success @endif">
                                    {{ $status ==  "Overdue" ? $status.' by '.$overdueDays.'Days' : $status}}
                                </span>
                            </td>
                            <td class="text-gray-600 fs-6 text-end">
                                ${{ number_format($invoice->total, 2) }}
                            </td>
                            <td class="text-gray-600 fs-6 text-end">
                                ${{ number_format($invoice->due, 2) }}
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

@section('admin-js')
    
@endsection