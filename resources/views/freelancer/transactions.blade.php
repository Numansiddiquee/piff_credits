@extends('layouts.custom.freelancer')
@section('freelancer-css') @endsection

@section('freelancer-content')
<!-- Toolbar -->
<div id="kt_app_toolbar" class="app-toolbar pt-0 pb-2">
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Transactions</h1>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <!-- Deposit and Withdraw Buttons -->
                <a href="#" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 fw-bold">
                    Deposit Funds
                </a>
                <a href="#" class="btn btn-flex btn-primary h-40px fs-7 fw-bold">
                    Withdraw Funds
                </a>
            </div>
        </div>
    </div>
</div>
<!-- End Toolbar -->

<!-- Balance Summary Card -->
<div class="card mb-5 mb-xl-8">
    <div class="card-body py-5">
        <div class="row g-5">
            <div class="col-md-4">
                <div class="border rounded p-6 text-center">
                    <div class="fs-7 text-gray-500">Available Balance</div>
                    <div class="fs-2hx fw-bold text-success mt-2">
                        {{ number_format(auth()->user()->balance ?? 1250.75, 2) }} PIF
                    </div>
                </div>
            </div>
            <div class="col-md-8 d-flex align-items-center">
                <p class="fs-6 text-gray-600">
                    Manage your wallet here: deposit funds, withdraw earnings, and view all your payment activities in one place.
                </p>
            </div>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-hover table-rounded gy-4 gs-4 align-middle">
                <thead>
                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-light">
                        <th>ID</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-end">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#1001</td>
                        <td><span class="badge badge-light-success">Deposit</span></td>
                        <td><span class="badge badge-success">Completed</span></td>
                        <td>29 Aug 2025</td>
                        <td class="text-end fw-bold text-success">+ $1,000.00</td>
                    </tr>
                    <tr>
                        <td>#1002</td>
                        <td><span class="badge badge-light-danger">Withdrawal</span></td>
                        <td><span class="badge badge-warning">Pending</span></td>
                        <td>27 Aug 2025</td>
                        <td class="text-end fw-bold text-danger">- $500.00</td>
                    </tr>
                    <tr>
                        <td>#1003</td>
                        <td><span class="badge badge-light-primary">Payment</span></td>
                        <td><span class="badge badge-success">Completed</span></td>
                        <td>25 Aug 2025</td>
                        <td class="text-end fw-bold text-success">+ $250.00</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- End Transactions Table -->
@endsection

@section('freelancer-js') @endsection
