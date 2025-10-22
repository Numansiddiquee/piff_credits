@extends('layouts.custom.admin')
@section('admin-css')
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

@section('admin-content')
    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="d-flex flex-column flex-xl-row">
            <div class="flex-lg-row-fluid ms-5 card">
                <input type="text" class="d-none" value="{{ $current_quote->client_id }}" id="client_id">
                <input type="text" class="d-none" value="{{ $current_quote->id }}" id="quote_id">

                <div class="card-header-lg p-4 ">
                    <div class="top-header d-flex justify-content-between align-items-center">
                        <h2 class="h2 header p-4  m-0">{{ $current_quote->quote_number }}</h2>
                        <div class="d-flex d-flex align-items-center gap-2 gap-lg-3">
                            <button class="btn btn-sm btn-light" id="printQuote">
                                <i class="bi bi bi-printer fs-6"></i>
                                Print
                            </button>
                        </div>
                    </div>
                </div>
                <div class="separator separator-solid my-3"></div>
                <div class="card-body m-2 p-0">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="kt_customer_view_overview_tab" role="tabpanel">
                            @include('client.partials.quote.overview')
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection

@section('admin-js')
    
    <script>
            $(document).on('click', '#printQuote', function () {
                let printContent = document.getElementById('quoteContent').innerHTML;
                let originalContent = document.body.innerHTML;
                document.body.innerHTML = printContent;
                window.print();
                document.body.innerHTML = originalContent;
                KTMenu.createInstances();
                KTDrawer.createInstances();
            });
    </script>
@endsection
