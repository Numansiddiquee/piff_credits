@extends('layouts.custom.freelancer')
@section('freelancer-css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

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

@section('freelancer-content')
    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="d-flex flex-column flex-xl-row">
            <div class="flex-column flex-lg-row-auto w-100 w-xl-300px mb-10">
                <div class="card mb-5 mb-xl-8">
                    <div class="card-header-lg p-4 bg-light">
                        <a href="#" class="btn btn-active-color-gray-900-100 btn-sm " data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">    All Invoices
                        </a>
                        <a href="{{ route('freelancer.invoice.create') }}" class="btn btn-primary btn-sm float-end">
                            + New
                        </a>
                    </div>
                    <div class="card-body pt-3 p-5">
                        <!--begin::Summary-->

                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
                            <input type="text" data-kt-customer-table-filter="search"
                                   class="form-control form-control-solid w-350px ps-12" placeholder="Search Items"/>
                        </div>

                        <div class="separator separator-solid my-3"></div>
                        @foreach($invoices as $inv)
                            @php
                                $due = \Carbon\Carbon::parse($inv->due_date);
                                $today = \Carbon\Carbon::today();
                                $status = ucfirst(strtolower($inv->status));
                                $overdueDays = 0;

                                if (!in_array($status, ['Paid', 'Written off'])) {
                                    if ($due->isPast()) {
                                        $status = 'Overdue';
                                        $overdueDays = $due->diffInDays($today);
                                    } elseif ($due->diffInDays($today) <= 6) {
                                        $status = 'Due Soon';
                                    } else {
                                        $status = 'Unpaid';
                                    }
                                }
                            @endphp
                            <div
                                class="d-flex justify-content-between rounded py-3 px-3 mb-3 invoice-div {{ $inv->id == $id ? 'activeDiv' : '' }}"
                                id="invoice-{{ $inv->id }}" onclick="loadIncoice('{{ $inv->id }}')"
                                style="box-shadow: 0px 7px 15px rgba(0, 0, 0, 0.1);cursor: pointer">
                                <div class="d-flex flex-column fs-4 fw-bold text-gray-700">
                                    <b class="fw-bold">{{$inv->client->name}}</b>
                                    <span
                                        class="text-muted fs-8 mt-1 mb-2">{{$inv->invoice_number}} &middot; {{$inv->created_at->format('d M,Y')}}</span>
                                    <span class="badge 
                                        {{ $status === 'Overdue' ? 'badge-danger' : 
                                           ($status === 'Due Soon' || $status === 'Unpaid' ? 'badge-warning' : 
                                           ($status === 'Written off' ? 'badge-secondary' : 'badge-success')) }}">
                                        {{ $status === 'Overdue' ? "$status by $overdueDays days" : $status }}
                                    </span>
                                </div>
                                <div class="fw-bold">${{number_format($inv->total,2)}}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="flex-lg-row-fluid ms-5 card" id="invoiceDetail">
                @include('freelancer.invoice.render')

            </div>
        </div>
    </div>
@endsection

@section('freelancer-js')
    {{--    <script src="{{ asset('assets/js/custom/apps/customers/view/invoices.js') }}"></script>--}}
        <script src="{{ asset('metronic/assets/js/custom/apps/inbox/compose_new.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

    <script>
        $(document).ready(function () {
            @if($errors->any())
                @foreach ($errors->all() as $error)
                    toastr.error("{{ $error }}", "Validation Error");
                @endforeach
            @endif

            @if(session('success'))
                toastr.success("{{ session('success') }}", "Success");
            @endif

            @if(session('error'))
                toastr.error("{{ session('error') }}", "Error");
            @endif
        });
    </script>
    <script>
        function loadIncoice(id) {
            $('#loader').show();

            $.ajax({
                url: "{{ route('freelancer.invoice.render') }}",
                type: 'POST',
                data:
                    {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                success: function (result) {
                    $('#invoiceDetail').html(result.html);
                    $('.invoice-div').removeClass('activeDiv');
                    $(`#invoice-${id}`).addClass('activeDiv');

                    var hrefEdit = `{{ route('freelancer.invoice.edit', ':id') }}`.replace(':id', id);

                    $('#updateEditID').attr('href', hrefEdit);
                    $('#updateCloneID').attr('data-id', id);

                    KTMenu.createInstances();
                    KTDrawer.createInstances();
                    KTSticky.createInstances();
                    $('.select2').select2();
                    $('#emailEditor').summernote({
                        height: 400
                    });

                    $('#emailEditorReminder').summernote({
                        height: 400
                    });

                    const currentUrl = window.location.href;
                    const newUrl = currentUrl.replace(/\/\d+$/, `/${id}`);
                    history.pushState({id: id}, '', newUrl);
                }, error: function () {
                    toastr.error('Failed to load invoice. Please try again.');
                },
                complete: function () {
                    $('#loader').hide();
                }
            });
        }

        $(document).ready(function () {
            function toggleVisibility(buttonSelector, targetSelector) {
                $(document).on('click', buttonSelector, function () {
                    const target = $(this).data('target');
                    $(`.${target}`).toggleClass('d-none d-flex');
                });
            }

            // Initialize with existing elements
            toggleVisibility('.emailCc_button', 'emailCc');
            toggleVisibility('.emailBcc_button', 'emailBcc');
        });

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

            $('#kt_inbox_reminder_compose_form').submit(function() {
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

        document.getElementById('updateCloneID').addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const hrefClone = `{{ route('freelancer.invoice.clone', ':id') }}`.replace(':id', id);

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to clone this invoice?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, clone it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to the dynamically generated URL
                    window.location.href = hrefClone;
                }
            });
        });

        $(document).on('click', '#stopReminderConsent', function () {
            let invoiceId = $(this).data('invoice-id');
            $.ajax({
                url: "{{ route('freelancer.invoice.stopReminder') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    invoice_id: invoiceId
                },
                success: function (response) {
                    if (response.success) {
                        toastr.success('Reminder successfully stopped!');
                        $('#stopReminder').modal('hide');
                        location.reload();
                    } else {
                        toastr.error('Failed to stop reminder.');
                    }
                },
                error: function (xhr) {
                    toastr.error('An error occurred. Please try again.');
                    console.error(xhr.responseText);
                }
            });
        });

        $(document).on('click', '#expectedDateConsent', function () {
            let invoiceId = $(this).data('invoice-id');
            let dueDate = $('#invoiceDate').val();
            let reason = $('#reason').val();

            // Validation
            if (!dueDate) {
                toastr.error('error','Please select a valid date.');
                return;
            }
            if (!reason) {
                toastr.error('error','Please enter a reason.');
                return;
            }

            $.ajax({
                url: "{{ route('freelancer.invoice.updateDueDetails') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    invoice_id: invoiceId,
                    due_date: dueDate,
                    payment_delay_note: reason
                },
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message); // Using dynamic message from backend
                        $('#expectedPaymentDate').modal('hide');
                        location.reload();  // Reload page to see changes
                    } else {
                        toastr.error(response.message || 'Failed to update the invoice.');
                    }
                },
                error: function (xhr) {
                    toastr.error( xhr.responseJSON?.error || 'An error occurred. Please try again.');
                }
            });
        });

        $(document).on('click', '#printInvoice', function () {
            let printContent = document.getElementById('invoiceContent').innerHTML;
            let originalContent = document.body.innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;
            KTMenu.createInstances();
            KTDrawer.createInstances();
        });

        $(document).on('click', '#writeOffConsent', function () {
            const invoiceId = $(this).data('invoice-id');
            const writeOffDate = $('#writeoff_date').val();
            const writeOffReason = $('#writeoff_reason').val();

            if (!writeOffDate || !writeOffReason.trim()) {
                toastr.error('Please provide both the write-off date and reason.');
                return;
            }

            const $btn = $(this);
            $btn.prop('disabled', true).text('Processing...');

            $.ajax({
                url: "{{ route('freelancer.invoice.writeOff') }}",
                method: 'POST',
                data: {
                    invoice_id: invoiceId,
                    writeoff_date: writeOffDate,
                    reason: writeOffReason,
                    _token: "{{ csrf_token() }}",
                },
                success: function (response) {
                    toastr.success(response.message);

                    $('#writeOff').modal('hide');

                    // Example: Change invoice status in UI
                    $('#invoice-status')
                        .text('Written Off')
                        .removeClass('badge-success badge-warning')
                        .addClass('badge-danger');

                    // Or refresh the page after 1s
                    setTimeout(() => location.reload(), 1000);
                },
                error: function (xhr) {
                    const message = xhr.responseJSON?.error || 'Failed to save write-off. Please try again.';
                    toastr.error(message);
                },
                complete: function () {
                    // ✅ Re-enable button
                    $btn.prop('disabled', false).text('Confirm Write-Off');
                }
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $(document).on('click', '#add_comment', function () {
                let comment = $("#comment_text").val();
                let client_id = $("#client_id").val();
                let invoice_id = $("#invoice_id").val();
                console.log(client_id);
                console.log(comment);
                console.log(invoice_id);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Fetch CSRF token
                    },
                    url: '{{ route("freelancer.invoice.add_comment") }}', // Replace with your route
                    method: 'POST',
                    data: {
                        'client_id': client_id,
                        'invoice_id': invoice_id,
                        'comment': comment
                    }, // Serialize form data
                    success: function (response) {
                        console.log("customer data", response)
                        const contactComments = document.querySelector('#invoice_comments');
                        contactComments.innerHTML = response.all_comments;
                        $('#comment_text').val('');
                        toastr.success('success','Comment Saved Successfully');
                    },
                    error: function (xhr, status, error) {
                        alert('An error occurred: ' + xhr.responseText);
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            let invoice_id = $("#invoice_id").val();
            loadAttachments(invoice_id);

            $('#attachment_upload_form').on('submit', function (e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: '{{ route('freelancer.invoice.attachments.upload') }}',
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (res) {
                        toastr.success('Attachments uploaded successfully');
                        $('#attachment_upload_form')[0].reset();
                        loadAttachments(invoice_id);
                    },
                    error: function (err) {
                        toastr.error('Upload failed. Please try again.');
                    }
                });
            });

            function loadAttachments(invoice_id) {
                let url = "{{ route('freelancer.invoice.attachments.list', ['invoice' => ':id']) }}";
                url = url.replace(':id', invoice_id);

                $.get(url, function (data) {
                    $('#attachment_list').html(data.html);
                });
            }

        });
    </script>

@endsection
