@extends('layouts.custom.freelancer')
@section('freelancer-css') @endsection

@section('freelancer-content')
<div id="kt_app_toolbar" class="app-toolbar pt-0 pb-2">
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Transaction History</h1>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <a href="#" class="btn btn-flex btn-primary h-40px fs-7 fw-bold">Export</a>
            </div>
        </div>
    </div>
</div>

<div class="card mb-5 mb-xl-8">
    <div class="card-body py-3">
        <div class="row g-3 mb-5">
            <div class="col-md-3">
                <select class="form-select form-select-solid">
                    <option value="">All Types</option>
                    <option>Deposits</option>
                    <option>Withdrawals</option>
                    <option>Payments</option>
                    <option>Fees</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" class="form-control form-control-solid" placeholder="From">
            </div>
            <div class="col-md-3">
                <input type="date" class="form-control form-control-solid" placeholder="To">
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary w-100">Filter</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-rounded gy-4 gs-4 align-middle">
                <thead>
                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-light">
                    <th>Reference</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th class="text-end">Amount</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>TXN-20250820-01</td>
                    <td>Payment</td>
                    <td><span class="badge badge-danger">Failed</span></td>
                    <td>20 Aug 2025</td>
                    <td class="text-end text-danger fw-bold">- $250.00</td>
                </tr>
                <tr>
                    <td>TXN-20250818-02</td>
                    <td>Deposit</td>
                    <td><span class="badge badge-success">Completed</span></td>
                    <td>18 Aug 2025</td>
                    <td class="text-end text-success fw-bold">+ $400.00</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('freelancer-js') @endsection
