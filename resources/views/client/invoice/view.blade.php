@extends('layouts.custom.client')
@section('client-css')
    <style>
        .pcs-itemtable-header {
            padding-bottom: 1.25rem !important;
            color: #ffffff !important;
            background-color: #3c3d3a !important;
        }

        .activeLink {
            cursor: pointer !important;
        }

        #kt_app_content_container {
            padding-left: 15px !important;
            padding-right: 15px !important;
        }
    </style>
@endsection

@section('client-content')
    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="d-flex flex-column flex-xl-row">
            <div class="flex-lg-row-fluid ms-5 card">
                <input type="text" class="d-none" id="invoice_id" value="{{$invoice->id}}">
                <input type="text" class="d-none" id="client_id" value="{{$invoice->client_id}}">

                <div class="card-header-lg p-4 ">
                    <div class="top-header d-flex justify-content-between align-items-center">
                        <h2 class="h2 header p-4 m-0">{{$invoice->invoice_number}}</h2>
                        <div class="d-flex align-items-center gap-2 gap-lg-3">
                            <button class="btn btn-sm btn-primary" id="comments_logs_drawer_toggle">
                                <i class="bi bi-chat-left-dots fs-6"></i>
                                Comments and Logs
                            </button>
                            <button class="btn btn-sm btn-primary" id="printInvoice">
                                <i class="bi bi-printer fs-6"></i>
                                Print
                            </button>
                        </div>
                    </div>
                </div>
                <div class="separator separator-solid my-3"></div>
                <div class="card-body m-2 p-0">
{{--                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-0 p-4 bg-light">--}}
{{--                        <li class="nav-item">--}}
{{--                            <a class="nav-link text-active-primary pb-2 mx-3 fs-6 active" data-bs-toggle="tab"--}}
{{--                               href="#kt_customer_view_overview_tab"><i class="bi bi-card-heading fs-6 mr-1"></i> Overview</a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="kt_customer_view_overview_tab" role="tabpanel">
                            @include('client.partials.invoice.overview')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('client-js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).on('click', '#printInvoice', function () {
            let printContent = document.getElementById('invoiceContent').innerHTML;
            let originalContent = document.body.innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;
            KTMenu.createInstances();
            KTDrawer.createInstances();
        });
    </script>

    <script>
        $(document).ready(function () {
            $(document).on('click', '#add_comment', function () {
                let comment = $("#comment_text").val();
                let client_id = $("#client_id").val();
                let invoice_id = $("#invoice_id").val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Fetch CSRF token
                    },
                    url: '{{ route("client.invoice.add_comment") }}', // Replace with your route
                    method: 'POST',
                    data: {
                        'client_id': client_id,
                        'invoice_id': invoice_id,
                        'comment': comment
                    }, // Serialize form data
                    success: function (response) {
                        const contactComments = document.querySelector('#invoice_comments');
                        contactComments.innerHTML = response.all_comments;
                        $('#comment_text').val('');
                        toast_msg('success', 'Saved', 'Comment Saved Successfully');
                    },
                    error: function (xhr, status, error) {
                        alert('An error occurred: ' + xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
