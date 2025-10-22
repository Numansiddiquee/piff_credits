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
                <input type="text" class="d-none" value="{{ $current_quote->user_id }}" id="freelancer_id">
                <input type="text" class="d-none" value="{{ $current_quote->id }}" id="quote_id">

                <div class="card-header-lg p-4 ">
                    <div class="top-header d-flex justify-content-between align-items-center">
                        <h2 class="h2 header p-4  m-0">{{ $current_quote->quote_number }}</h2>
                        <div class="d-flex d-flex align-items-center gap-2 gap-lg-3">
                            @if($current_quote->status == 'Converted To Invoice')
                                <div class="alert alert-secondary text-body d-flex align-items-center m-5" role="alert">
                                    <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
                                    <div>
                                        <strong>Notice:</strong> This quote has been <strong>Converted To Invoice</strong> by {{ $current_quote->client->name ?? 'the client' }}.
                                        No further actions or changes can be made.<br>
                                    </div>
                                </div>
                            @else
                                @if($current_quote->status != 'Accepted')
                                    <a href="#" class="btn btn-sm btn-primary p-3" id="accpetQuote">
                                        <i class="bi bi-check-circle fs-6 p-0"></i>
                                        Accept
                                    </a>
                                @endif
                                @if($current_quote->status != 'Declined' && $current_quote->status != 'Accepted')
                                    <a href="#" class="btn btn-sm btn-light p-3" id="declineQuote">
                                        <i class="bi bi-x-circle fs-6 p-0"></i>
                                        Decline
                                    </a>
                                @endif
                            @endif
                            <button class="btn btn-sm btn-primary" id="comments_logs_drawer_toggle">
                                <i class="bi bi-chat-left-dots fs-6"></i>
                                Comments and Logs
                            </button>
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

@section('client-js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $(document).on('click', '#accpetQuote', function (e) {
                e.preventDefault();
                let quoteId = $("#quote_id").val();

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to accept this quote?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Accept it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        updateQuoteStatus(quoteId, 'Accepted');
                    }
                });
            });

            $(document).on('click', '#declineQuote', function (e) {
                e.preventDefault();
                let quoteId = $("#quote_id").val();

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to decline this quote?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, Decline it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        updateQuoteStatus(quoteId, 'Declined');
                    }
                });
            });

            function updateQuoteStatus(quoteId, status) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ route("client.quote.update_status") }}',
                    method: 'POST',
                    data: {
                        'quote_id': quoteId,
                        'status': status
                    },
                    success: function (response) {
                        Swal.fire(
                            'Updated!',
                            `The quote has been ${status}.`,
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    },
                    error: function (xhr, status, error) {
                        Swal.fire(
                            'Error!',
                            'An error occurred while updating the quote status.',
                            'error'
                        );
                    }
                });
            }
        });
    </script>
    <script>
        $(document).ready(function () {
            $(document).on('click', '#add_comment', function () {
                let comment = $("#comment_text").val();
                let freelancer_id = $("#freelancer_id").val();
                let quote_id = $("#quote_id").val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ route("client.quote.add_comment") }}',
                    method: 'POST',
                    data: {
                        'freelancer_id': freelancer_id,
                        'quote_id': quote_id,
                        'comment': comment
                    },
                    success: function (response) {
                        const contactComments = document.querySelector('#quote_comments');
                        contactComments.innerHTML = response.all_comments;
                        $('#comment_text').val('');
                        toastr.success('success', 'Comment Saved Successfully');
                    },
                    error: function (xhr, status, error) {
                        toastr.error('error','An error occurred: ' + xhr.responseText);
                    }
                });
            });

            $(document).on('click', '#printQuote', function () {
                let printContent = document.getElementById('quoteContent').innerHTML;
                let originalContent = document.body.innerHTML;
                document.body.innerHTML = printContent;
                window.print();
                document.body.innerHTML = originalContent;
                KTMenu.createInstances();
                KTDrawer.createInstances();
            });
        });
    </script>
@endsection
