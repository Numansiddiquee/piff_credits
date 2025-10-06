@extends('layouts.custom.freelancer')
@section('freelancer-css') @endsection

@section('freelancer-content')
<div id="kt_app_toolbar" class="app-toolbar pt-0 pb-2">
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Connection with Clients</h1>
                <p class="text-muted text-sm">
                    You can only view clients in this section if you have sent them a quote or an invoice.
                </p>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <a href="{{ route('freelancer.client.create_client') }}" class="btn btn-flex btn-primary h-40px fs-7 fw-bold">Add Client</a>
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
                        <th>Client</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Invoices</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($connections as $connection)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-35px me-3">
                                        <img src="{{ Storage::url($connection->client->avatar) }}" alt="">
                                    </div>
                                    <span class="fw-semibold">{{ $connection->client->name ?? '-'}}</span>
                                </div>
                            </td>
                            <td>{{ $connection->client->email ?? '-' }} </td>
                            <td>
                                <span class="badge 
                                    {{ $connection->status === 'active' ? 'badge-success' : ($connection->status === 'pending' ? 'badge-warning' : 'badge-danger') }}">
                                    {{ ucfirst($connection->status) }}
                                </span>

                            </td>
                            <td>{{ $connection->invoices_count ?? 0 }}</td>
                            <td class="text-end"><a href="#" class="btn btn-sm btn-light">View</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center;">No Records Found!</td>
                        </tr>

                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('freelancer-js') @endsection
