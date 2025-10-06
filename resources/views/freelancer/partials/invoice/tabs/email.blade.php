<div class="card pt-4 mb-6 mb-xl-9">
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between py-3">
            <h2 class="card-title m-0">Compose Message</h2>
            <!--begin::Toggle-->
            <a href="#" class="btn btn-sm btn-icon btn-color-primary btn-light btn-active-light-primary d-lg-none" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top" title="Toggle inbox menu" id="kt_inbox_aside_toggle">
                <i class="ki-outline ki-burger-menu-2 fs-3 m-0"></i>
            </a>
            <!--end::Toggle-->
        </div>
        <div class="card-body p-0">
            <!--begin::Form-->
            <form action="{{ route('freelancer.invoice.send.email') }}" id="kt_inbox_compose_form" method="post" enctype="multipart/form-data">
                @csrf
                <div class="d-block">
                    <div class="d-flex align-items-center border-bottom px-8 min-h-50px">
                        <div class="text-gray-900 fw-bold w-75px">To:</div>
{{--                        <input type="text" class="form-control form-control-transparent border-0" name="to_email" placeholder="Recipient email" />--}}
                        <select class="form-select form-control-transparent border-0 select2" name="to_email[]" data-control="select2" data-placeholder="Recipient email" data-allow-clear="true" multiple="multiple">
                            <option></option>
                            <option value="{{ $invoice->client->email }}" selected>{{ $invoice->client->name }} ({{ $invoice->client->email }})</option>
                            
                        </select>
                        <div class="ms-auto w-75px text-end">
                            <span class="text-muted cursor-pointer text-hover-primary me-2 emailCc_button" data-target="emailCc">Cc</span>
                            <span class="text-muted cursor-pointer text-hover-primary emailBcc_button" data-target="emailBcc">Bcc</span>
                        </div>
                    </div>

                    <div class="d-none align-items-center border-bottom px-8 min-h-50px emailCc">
                        <div class="text-gray-900 fw-bold w-75px">Cc:</div>
                        <select class="form-select form-control-transparent border-0 select2" name="cc_email[]" data-control="select2" data-placeholder="Recipient email" data-allow-clear="true" multiple="multiple">
                            <option></option>
                            
                        </select>
                    </div>

                    <div class="d-none align-items-center border-bottom px-8 min-h-50px emailBcc">
                        <div class="text-gray-900 fw-bold w-75px">Bcc:</div>
                        <select class="form-select form-control-transparent border-0 select2" name="bcc_email[]" data-control="select2" data-placeholder="Recipient email" data-allow-clear="true" multiple="multiple">
                            <option></option>
                            
                        </select>
                    </div>

                    <div class="border-bottom px-8">
                        <input class="form-control form-control-transparent border-0" name="subject" placeholder="Subject" value="Invoice - {{$invoice->invoice_number}} from {{ auth()->user()->name }}"/>
                    </div>
                    <div class="px-8 round-5 border">
                        <div class="text-gray-900 fw-bold w-75px mt-3 mb-2">Email Body</div>
                        <input type="hidden" name="body" id="compose_body" value="">
                        <input type="hidden" name="model_type" value="App\Models\Invoice">
                        <input type="hidden" name="model_id" value="{{ $id }}">
                        <input type="hidden" name="source" value="Main Email">
                        <textarea id="emailEditor">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: #fbfbfb;">
                                <tr>
                                    <td align="center">
                                        <table width="600" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td style="padding: 2% 3%; text-align: left;">
                                                    <!-- Add your logo or header content here -->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="background: #4190f2; padding: 3%; text-align: center;">
                                                    <span style="color: #fff; font-size: 20px; font-weight: 500;">
                                                        Invoice #{{ $invoice->invoice_number }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 30px 3%; color: #555; line-height: 1.7;">
                                                    Dear {{ $invoice->client->name }}, <br><br>
                                                    Thank you for your business. Your invoice can be viewed, printed, and downloaded as a PDF from the link below. You can also choose to pay it online.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 3%; background: #fefff1; border: 1px solid #e8deb5; color: #333;">
                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                        <tr>
                                                            <td style="text-align: center; border-bottom: 1px solid #e8deb5; padding: 0 0 3%;">
                                                                <h4 style="margin: 0;">INVOICE AMOUNT</h4>
                                                                <h2 style="color: #D61916; margin: 10px 0;">$ {{ number_format($invoice->total, 2) }}</h2>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding: 3%;">
                                                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                    <tr>
                                                                        <td style="width: 50%; padding: 5px;">Invoice No:</td>
                                                                        <td style="width: 50%; padding: 5px;"><b>{{ $invoice->invoice_number }}</b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 50%; padding: 5px;">Invoice Date:</td>
                                                                        <td style="width: 50%; padding: 5px;"><b>{{ $invoice->created_at->format('d M, Y') ?? 'N/A' }}</b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 50%; padding: 5px;">Due Date:</td>
                                                                        <td style="width: 50%; padding: 5px;"><b>{{ $invoice->due_date->format('d M, Y') ?? 'N/A' }}</b></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: center; padding: 25px 0;">
                                                                @php
                                                                    $hash = \Crypt::encryptString($invoice->id);
                                                                @endphp
                                                                <a href="#" style="text-decoration: none; background-color: #4dcf59; border: 1px solid #49bd54; color: #fff; padding: 10px 20px; display: inline-block;">
                                                                    VIEW/PAY INVOICE
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 30px 3%; line-height: 1.6;">
                                                    Regards, <br>
                                                    <span style="color: #8c8c8c; font-weight: 400;">{{ auth()->user()->name }}</span><br>
                                                    <span style="color: #b1b1b1;">{{ auth()->user()->company_name }}</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </textarea>
                    </div>
                    <div class="dropzone dropzone-queue px-8 py-4" id="kt_inbox_reply_attachments" data-kt-inbox-form="dropzone">
                        <div data-kt-inbox-form="dropzone" class="form-container">
                            <div class="dropzone-items"></div>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-stack flex-wrap gap-2 py-5 ps-8 pe-5 border-top">
                    <div class="d-flex align-items-center me-3">
                        <div class="btn-group me-4">
                            <button type="submit" class="btn btn-primary fs-bold px-6" data-kt-inbox-form="send">Send</button>
                        </div>
                        <span class="btn btn-icon btn-sm btn-clean btn-active-light-primary me-2" id="kt_inbox_reply_attachments_select" data-kt-inbox-form="dropzone_upload">
                            <i class="ki-outline ki-paper-clip fs-2 m-0"></i>
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>