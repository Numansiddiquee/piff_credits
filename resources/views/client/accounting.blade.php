@extends('layouts.custom.client')
@section('client-css') @endsection

@section('client-content')
<div id="kt_app_toolbar" class="app-toolbar pt-0 pb-2">
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Accounting</h1>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <a href="#" class="btn btn-flex btn-primary h-40px fs-7 fw-bold">Export</a>
            </div>
        </div>
    </div>
</div>

<div class="card mb-5 mb-xl-8">
    <div class="card-body py-3">
        <div class="table-responsive">
            <table class="table table-hover table-rounded gy-4 gs-4 align-middle">
                <thead>
                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-light">
                    <th>Category</th>
                    <th class="text-end">Income</th>
                    <th class="text-end">Expenses</th>
                    <th class="text-end">Net</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Web Development</td>
                    <td class="text-end">$4,500.00</td>
                    <td class="text-end">$300.00</td>
                    <td class="text-end fw-bold">$4,200.00</td>
                </tr>
                <tr>
                    <td>Design</td>
                    <td class="text-end">$1,800.00</td>
                    <td class="text-end">$150.00</td>
                    <td class="text-end fw-bold">$1,650.00</td>
                </tr>
                <tr class="border-top">
                    <td class="fw-bold">Total</td>
                    <td class="text-end fw-bold">$6,300.00</td>
                    <td class="text-end fw-bold">$450.00</td>
                    <td class="text-end fw-bold">$5,850.00</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('client-js') @endsection
