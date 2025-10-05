@extends('layouts.custom.freelancer')

@section('freelancer-css')
<link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet" />
@endsection

@section('freelancer-content')

<!--begin::Toolbar-->
<div id="kt_app_toolbar" class="app-toolbar pt-0 pb-2">
    <div class="app-container container-fluid d-flex align-items-stretch">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title">
                <h1 class="fw-bold fs-3 m-0">Reports & Analytics</h1>
            </div>
        </div>
    </div>
</div>
<!--end::Toolbar-->

<!--begin::Filters-->
<div class="card mb-5">
    <div class="card-body">
        <form id="filtersForm" class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-bold">Date Range</label>
                <input type="text" class="form-control form-control-solid" id="report_date_range" placeholder="Select date range">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Client</label>
                <select id="client_filter" class="form-select form-select-solid">
                    <option value="">All Clients</option>
                    <option value="John Doe">John Doe</option>
                    <option value="Jane Smith">Jane Smith</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Status</label>
                <select id="status_filter" class="form-select form-select-solid">
                    <option value="">All</option>
                    <option value="Paid">Paid</option>
                    <option value="Pending">Pending</option>
                    <option value="Overdue">Overdue</option>
                </select>
            </div>
        </form>
    </div>
</div>
<!--end::Filters-->

<!--begin::Summary Cards-->
<div class="row g-5 g-xl-8 mb-5">
    <div class="col-md-6 col-xl-3">
        <div class="card shadow-sm">
            <div class="card-body d-flex flex-column text-center">
                <span class="text-muted fw-bold">Total Revenue</span>
                <div class="fs-2 fw-bolder text-primary">$45,200</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card shadow-sm">
            <div class="card-body d-flex flex-column text-center">
                <span class="text-muted fw-bold">Available Balance</span>
                <div class="fs-2 fw-bolder text-success">$8,750</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card shadow-sm">
            <div class="card-body d-flex flex-column text-center">
                <span class="text-muted fw-bold">Pending Invoices</span>
                <div class="fs-2 fw-bolder text-warning">12</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card shadow-sm">
            <div class="card-body d-flex flex-column text-center">
                <span class="text-muted fw-bold">Clients</span>
                <div class="fs-2 fw-bolder text-danger">48</div>
            </div>
        </div>
    </div>
</div>
<!--end::Summary Cards-->

<!--begin::Charts-->
<div class="row g-5 g-xl-8">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header"><h3 class="fw-bold">Earnings Over Time</h3></div>
            <div class="card-body"><canvas id="earnings_chart"></canvas></div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header"><h3 class="fw-bold">Invoice Status</h3></div>
            <div class="card-body"><canvas id="invoice_status_chart"></canvas></div>
        </div>
    </div>
</div>
<div class="row g-5 g-xl-8 mt-5">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header"><h3 class="fw-bold">Client Growth</h3></div>
            <div class="card-body"><canvas id="client_growth_chart"></canvas></div>
        </div>
    </div>
</div>
<!--end::Charts-->

<!--begin::Transactions Table-->
<div class="card mt-5">
    <div class="card-header">
        <h3 class="fw-bold">Transaction History</h3>
        <div class="card-toolbar">
            <button class="btn btn-sm btn-light-primary" id="exportBtn">Export</button>
        </div>
    </div>
    <div class="card-body">
        <table id="transactions_table" class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 nowrap w-100">
            <thead>
                <tr class="fw-bold text-muted">
                    <th>Date</th>
                    <th>Invoice #</th>
                    <th>Client</th>
                    <th>Status</th>
                    <th class="text-end">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>2025-08-01</td><td>INV-001</td><td>John Doe</td><td><span class="badge badge-light-success">Paid</span></td><td class="text-end">$500</td></tr>
                <tr><td>2025-07-20</td><td>INV-002</td><td>Jane Smith</td><td><span class="badge badge-light-danger">Overdue</span></td><td class="text-end">$750</td></tr>
                <tr><td>2025-08-15</td><td>INV-003</td><td>Alice Johnson</td><td><span class="badge badge-light-warning">Pending</span></td><td class="text-end">$300</td></tr>
            </tbody>
        </table>
    </div>
</div>
<!--end::Transactions Table-->

@endsection

@section('freelancer-js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    // Date Range Picker
    $('#report_date_range').daterangepicker();

    // Chart.js Global Defaults
    Chart.defaults.plugins.legend.position = 'bottom';
    Chart.defaults.plugins.tooltip.titleColor = '#000';
    Chart.defaults.plugins.tooltip.bodyColor = '#333';
    Chart.defaults.responsive = true;
    Chart.defaults.maintainAspectRatio = false;

    // Earnings Line Chart
    new Chart(document.getElementById('earnings_chart'), {
        type: 'line',
        data: {
            labels: ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug"],
            datasets: [{
                label: "Earnings ($)",
                data: [1200,1500,1800,2000,2400,2100,2600,3000],
                borderColor: "#0d6efd",
                backgroundColor: "rgba(13,110,253,0.1)",
                fill: true,
                tension: 0.4,
                pointBackgroundColor: "#0d6efd"
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // Invoice Status Doughnut
    new Chart(document.getElementById('invoice_status_chart'), {
        type: 'doughnut',
        data: { 
            labels: ["Paid","Pending","Overdue"], 
            datasets: [{ 
                data:[65,20,15], 
                backgroundColor:["#28a745","#ffc107","#dc3545"] 
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // Client Growth Bar
    new Chart(document.getElementById('client_growth_chart'), {
        type: 'bar',
        data: { 
            labels:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug"], 
            datasets:[{ 
                label:"Clients", 
                data:[5,10,15,20,25,30,40,48], 
                backgroundColor:"#6610f2" 
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // Responsive DataTable with Export
    $(document).ready(function () {
        let table = $('#transactions_table').DataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: ['csv', 'excel', 'pdf', 'print']
        });

        $('#exportBtn').on('click', function () {
            table.button('.buttons-excel').trigger();
        });

        // Filters
        $('#client_filter, #status_filter').on('change', function () {
            table.draw();
        });
    });
</script>
@endsection
