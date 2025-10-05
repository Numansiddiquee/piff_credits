<input type="text" class="d-none" id="invoice_id" value="{{$invoice->id}}">
<input type="text" class="d-none" id="client_id" value="{{$invoice->client_id}}">
<input type="text" class="d-none" id="attachments_route" value="{{ url('api/freelancer/invoices/upload-file/email') }}">

<div class="card-header-lg p-4 ">
    <div class="top-header d-flex justify-content-between align-items-center">
        <h2 class="h2 header p-4 m-0">{{$invoice->invoice_number}}</h2>
        <div class="d-flex align-items-center gap-2 gap-lg-3">
            <a href="{{ route('freelancer.invoice.edit',$invoice->id)}}" class="btn btn-light btn-sm">Edit</a>
            <button class="btn btn-sm btn-light p-3" id="attachment_drawer_toggle">
                <i class="bi bi-paperclip p-0"></i>
            </button>
            <button class="btn btn-sm btn-primary" id="comments_logs_drawer_toggle">
                <i class="bi bi-chat-left-dots fs-6"></i>
                Comments and Logs
            </button>
            <a href="#" class="btn btn-sm btn-light pe-2" data-kt-menu-trigger="click"
               data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">More
                <i class="ki-outline ki-down fs-5 me-0"></i></a>
            <div
                class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 w-250px fs-6"
                data-kt-menu="true">
                <div class="menu-item px-5">
                    <div class="menu-content text-muted pb-2 px-5 fs-7 text-uppercase">Invoice</div>
                </div>
                <div class="menu-item px-5">
                    <a href="javascript:void(0);" data-id="{{ $invoice->id }}" id="updateCloneID"
                       class="menu-link px-5 text-uppercase fs-6">Clone</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="separator separator-solid my-3"></div>
<div class="card-body m-2 p-0">
    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-0 p-4 bg-light">
        <li class="nav-item">
            <a class="nav-link text-active-primary pb-2 mx-3 fs-6 active" data-bs-toggle="tab"
               href="#kt_customer_view_overview_tab"><i class="bi bi-card-heading fs-6 mr-1"></i> Overview</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-active-primary fs-6 mx-3 pb-2" data-bs-toggle="tab"
               href="#kt_customer_view_overview_events_and_logs_tab"><i class="bi bi-envelope fs-6 mr-1"></i> Send Email</a>
        </li>
        <li class="nav-item activeLink">
            <a class="nav-link text-active-primary fs-6 mx-3 pb-2" data-kt-menu-trigger="click"
               data-kt-menu-attach="parent"
               data-kt-menu-placement="bottom-end"><i class="bi bi-bell fs-6 mr-1"></i> Reminders
                <i class="ki-outline ki-down fs-6 me-0"></i>
            </a>
            <div
                class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 w-250px fs-6"
                data-kt-menu="true">
                <div class="menu-item px-5">
                    <a data-bs-toggle="tab" href="#kt_reminder_email"
                       class="menu-link px-5 gap-4 fs-6 text-uppercase"><i
                            class="bi bi-envelope fs-6 mr-1"></i> Send Email</a>
                </div>
                <div class="menu-item px-5">
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#stopReminder"
                       class="menu-link gap-4 px-5 fs-6 text-uppercase"><i
                            class="bi bi-bell fs-6 mr-1"></i> {{ $invoice->send_reminder == 1 ? 'Stop' : 'Start' }}
                        Reminders</a>
                </div>
                <div class="menu-item px-5">
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#expectedPaymentDate"
                       class="menu-link gap-4 px-5 fs-6 text-uppercase"><i class="bi bi-calendar-date fs-6 mr-1"></i>
                        Expected Payment Date</a>
                </div>
            </div>
        </li>
        <li class="nav-item activeLink">
            <a class="nav-link text-active-primary fs-6 mx-3 pb-2" data-kt-menu-trigger="click"
               data-kt-menu-attach="parent"
               data-kt-menu-placement="bottom-end"> <i class="bi bi-file-pdf fs-6 mr-1"></i> Print/PDF
                <i class="ki-outline ki-down fs-6 me-0"></i>
            </a>
            <div
                class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 w-250px fs-6"
                data-kt-menu="true">
                <div class="menu-item px-5">
                    <a href="{{ route('freelancer.invoice.generatePDF', $invoice->id) }}"
                       class="menu-link px-5 text-uppercase fs-6 gap-4"><i class="bi bi-file-pdf fs-6 mr-1"></i> PDF</a>
                </div>
                <div class="menu-item px-5">
                    <a href="#" class="menu-link px-5 text-uppercase gap-4 fs-6" id="printInvoice"><i
                            class="bi bi-printer fs-6 mr-1"></i> Print</a>
                </div>
            </div>
        </li>
        <li class="nav-item activeLink">
            <a class="nav-link text-active-primary fs-6 mx-3 pb-2" data-kt-menu-trigger="click"
               data-kt-menu-attach="parent"
               data-kt-menu-placement="bottom-end"> <i class="bi bi-file-pdf fs-6 mr-1"></i> Record Payment
                <i class="ki-outline ki-down fs-6 me-0"></i>
            </a>
            <div
                class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 w-250px fs-6"
                data-kt-menu="true">
                <div class="menu-item px-5">
                    <a href="{{ route('freelancer.payments_received.create',$invoice->client->id) }}" class="menu-link px-5 fs-6 text-uppercase gap-4"><i
                            class="bi bi-file-pdf fs-6 mr-1"></i>
                        Record Payment</a>
                </div>
                <div class="menu-item px-5">
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#writeOff"
                       class="menu-link px-5 text-uppercase fs-6 gap-4"><i class="bi bi-printer fs-6 mr-1"></i> Write
                        Off</a>
                </div>
            </div>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="kt_customer_view_overview_tab" role="tabpanel">
            @include('freelancer.partials.invoice.tabs.overview')
        </div>
        <!--end:::Tab pane-->
        <!--begin:::Tab pane-->
        <div class="tab-pane fade" id="kt_customer_view_overview_events_and_logs_tab" role="tabpanel">
            @include('freelancer.partials.invoice.tabs.email')
        </div>
        <div class="tab-pane fade" id="kt_reminder_email" role="tabpanel">
            @include('freelancer.partials.invoice.tabs.reminderEmail')
        </div>
    </div>
</div>
@include('freelancer.partials.invoice.expectedPaymentDate')
@include('freelancer.partials.invoice.stopReminder')
@include('freelancer.partials.invoice.writeOff')
@include('freelancer.partials.invoice.comments_drawer')
@include('freelancer.partials.invoice.attachment_drawer')

