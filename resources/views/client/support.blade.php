@extends('layouts.custom.client')
@section('client-css') @endsection

@section('client-content')
<div id="kt_app_toolbar" class="app-toolbar pt-0 pb-2">
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Support</h1>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <a href="#" class="btn btn-flex btn-primary h-40px fs-7 fw-bold">Create Ticket</a>
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
                    <th>ID</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Last Reply</th>
                    <th class="text-end">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>#001</td>
                    <td>Payment not received</td>
                    <td><span class="badge badge-warning">Open</span></td>
                    <td>28 Aug 2025</td>
                    <td class="text-end">
                        <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                            <i class="ki-outline ki-pencil fs-2"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>#002</td>
                    <td>Account verification</td>
                    <td><span class="badge badge-success">Resolved</span></td>
                    <td>27 Aug 2025</td>
                    <td class="text-end">
                        <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                            <i class="ki-outline ki-pencil fs-2"></i>
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('client-js') @endsection
