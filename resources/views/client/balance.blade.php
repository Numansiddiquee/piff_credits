@extends('layouts.custom.freelancer')
@section('freelancer-css') @endsection

@section('freelancer-content')
<div id="kt_app_toolbar" class="app-toolbar pt-0 pb-2">
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Balance</h1>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <a href="#" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 fw-bold">Deposit</a>
                <a href="#" class="btn btn-flex btn-primary h-40px fs-7 fw-bold">Withdraw</a>
            </div>
        </div>
    </div>
</div>

<div class="card mb-5 mb-xl-8">
    <div class="card-body py-3">
        <div class="row g-5">
            <div class="col-md-4">
                <div class="border rounded p-6 text-center">
                    <div class="fs-7 text-gray-500">Available Balance</div>
                    <div class="fs-2hx fw-bold text-success mt-2">${{ number_format(auth()->user()->balance ?? 1250.75, 2) }}</div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table table-hover table-rounded gy-4 gs-4 align-middle">
                        <thead>
                        <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-light">
                            <th>Type</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-end">Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Deposit</td>
                            <td><span class="badge badge-success">Completed</span></td>
                            <td>29 Aug 2025</td>
                            <td class="text-end text-success fw-bold">+ $500.00</td>
                        </tr>
                        <tr>
                            <td>Withdrawal</td>
                            <td><span class="badge badge-warning">Pending</span></td>
                            <td>27 Aug 2025</td>
                            <td class="text-end text-danger fw-bold">- $200.00</td>
                        </tr>
                        <tr>
                            <td>Service Fee</td>
                            <td><span class="badge badge-light">Charged</span></td>
                            <td>26 Aug 2025</td>
                            <td class="text-end text-danger fw-bold">- $5.00</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('freelancer-js') @endsection
