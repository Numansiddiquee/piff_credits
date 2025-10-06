@extends('layouts.custom.freelancer')
@section('freelancer-css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

    <style>
        .nav_menu_links {
            border-right: 1px solid #c5c5c5;
        }

        .nav_menu_links:hover {
            color: #1b84ff !important;
        }

        .pcs-itemtable-header {
            padding-bottom: 1.25rem !important;
            color: #ffffff !important;
            background-color: #3c3d3a !important;
        }

        #kt_app_content_container {
            padding-left: 15px !important;
            padding-right: 15px !important;
        }
    </style>
@endsection

@section('freelancer-content')
    <div id="kt_app_content_container" class="app-container container-fluid">
        <!--begin::Layout-->
        <div class="d-flex flex-column flex-xl-row">
            <div class="flex-column flex-lg-row-auto w-100 w-xl-300px mb-10 me-5">
                <div class="card mb-5 mb-xl-8">
                    <div class="card-header-lg p-4 bg-light">
                        <a href="#" class="btn btn-active-color-gray-900-100 btn-sm " data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                            All Quotes
                       </a>
                        <a href="{{route('freelancer.quote.new_quote')}}" class="btn btn-primary btn-sm float-end">
                            + New
                        </a>
                    </div>

                    <div class="card-body pt-3 p-5">
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
                            <input type="text" data-kt-customer-table-filter="search"
                                   class="form-control form-control-solid w-350px ps-12"
                                   placeholder="Search Items"/>
                        </div>
                        <!--begin::Card body-->
                        <div class="separator separator-solid my-3"></div>
                        <!--begin::Summary-->
                        @foreach($quotes as $quote)
                            @php
                                $statusClasses = [
                                    'Draft'       => 'badge badge-secondary',
                                    'Accepted'    => 'badge badge-success',
                                    'Rejected'    => 'badge badge-danger',
                                    'Not Answered'=> 'badge badge-warning',
                                ];

                                $statusClass = $statusClasses[$quote->status] ?? 'badge badge-light';
                            @endphp

                            <div class="d-flex justify-content-between rounded quote-div py-3 px-3 mb-3 @if($quote->id == $current_quote->id) activeDiv @endif"
                                id="quote-{{$quote->id}}"
                                onclick="loadQuote('{{$quote->id}}')" role="button"
                                style="box-shadow: 0px 7px 15px rgba(0, 0, 0, 0.1)">
                                <div class="d-flex flex-column fs-4 fw-bold text-gray-700">
                                    <b class="fw-bold">{{ $quote->client->name }}</b>
                                    <span
                                        class="text-muted fs-8 mt-1 mb-2">{{$quote->quote_number.' . '.date('Y-m-d',strtotime($quote->quote_date))}}</span>
                                    <span class="{{ $statusClass }}  w-auto"> {{ $quote->status }} </span>
                                </div>
                                <div class="fw-bold">${{number_format($quote->grand_total,2)}}</div>
                            </div>
                        @endforeach
                    </div>
                    <!--end::Card body-->
                </div>
            </div>
            <!--begin::Content-->
            <div class="flex-lg-row-fluid ms-0 card rounded" id="quote_detail">
                @include('freelancer.quote.ajax_views.details_render')
            </div>
        </div>
    </div>
    <!--end::Content container-->

@endsection

@section('freelancer-js')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="{{ asset('metronic/assets/js/custom/apps/inbox/compose_new.js') }}"></script>
    <script>
        $(document).ready(function () {
            $(document).on('click', '#add_comment', function () {
                let comment = $("#comment_text").val();
                let client_id = $("#client_id").val();
                let quote_id = $("#quote_id").val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Fetch CSRF token
                    },
                    url: '{{ route("freelancer.quote.add_comment") }}', // Replace with your route
                    method: 'POST',
                    data: {
                        'client_id': client_id,
                        'quote_id': quote_id,
                        'comment': comment
                    }, // Serialize form data
                    success: function (response) {
                        const contactComments = document.querySelector('#quote_comments');
                        contactComments.innerHTML = response.all_comments;
                        $('#comment_text').val('');
                        toastr.success('success', 'Comment Saved Successfully');
                    },
                    error: function (xhr, status, error) {
                        alert('An error occurred: ' + xhr.responseText);
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

        function loadQuote(quote_id) {
            $('#loader').show();
            $.ajax({
                url: "{{ route('freelancer.quote.render') }}",
                type: 'POST',
                data:
                    {
                        quote_id: quote_id,
                        _token: "{{ csrf_token() }}"
                    },
                success: function (result) {
                    $('#quote_detail').html(result.html);
                    $('.quote-div').removeClass('activeDiv');
                    $(`#quote-${quote_id}`).addClass('activeDiv');

                    KTMenu.createInstances();
                    KTDrawer.createInstances();
                    // KTSticky.createInstances();
                    $('.select2').select2();
                    $('#emailEditor').summernote({
                        height: 400
                    });

                    $('#emailEditorReminder').summernote({
                        height: 400
                    });

                    const currentUrl = window.location.href;
                    const newUrl = currentUrl.replace(/\/\d+$/, `/${quote_id}`);
                    history.pushState({id: quote_id}, '', newUrl);
                }, error: function () {
                    toastr.error('Failed to load invoice. Please try again.');
                },
                complete: function () {
                    $('#loader').hide();
                }
            });
        }
    </script>
    <script>
        $(document).ready(function () {
            let quote_id = $("#quote_id").val();
            loadAttachments(quote_id);

            $('#attachment_upload_form').on('submit', function (e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('freelancer.quote.attachments.upload') }}",
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (res) {
                        toastr.success('Attachments uploaded successfully');
                        $('#attachment_upload_form')[0].reset();
                        loadAttachments(quote_id);
                    },
                    error: function (err) {
                        toastr.error('Upload failed. Please try again.');
                    }
                });
            });

            function loadAttachments(quote_id) {
                let url = "{{ route('freelancer.quote.attachments.list', ['quote' => ':id']) }}";
                url = url.replace(':id', quote_id);

                $.get(url, function (data) {
                    $('#attachment_list').html(data.html);
                });
            }

        });
    </script>
    <script>
        $(document).ready(function() {
            $('#emailEditor').summernote({
                height: 400,
            });

            $('#emailEditorReminder').summernote({
                height: 400,
            });

            $('#kt_inbox_compose_form').submit(function(e) {
                var content = $('#emailEditor').summernote('code');
                $('#compose_body').val(content);
            });

            $(document).on('submit','#kt_inbox_reminder_compose_form',function() {
                var content = $('#emailEditorReminder').summernote('code');
                $('#compose_reminder_body').val(content);
            });

            $("#attachmentButton").click(function () {
                $("#attachmentInput").click();
            });

            $("#attachmentInput").change(function () {
                let fileList = $("#selectedAttachments");
                fileList.empty(); // Clear previous selections

                $.each(this.files, function (index, file) {
                    fileList.append(`<div>${file.name}</div>`);
                });
            });
        });
    </script>
@endsection
