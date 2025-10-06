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
            <form action="{{ route('freelancer.invoice.send.email') }}" id="kt_inbox_reminder_compose_form" method="post" enctype="multipart/form-data">
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
                        {{--                        <input type="text" class="form-control form-control-transparent border-0" name="cc_email" placeholder="Cc email" />--}}
                        <select class="form-select form-control-transparent border-0 select2" name="cc_email[]" data-control="select2" data-placeholder="Recipient email" data-allow-clear="true" multiple="multiple">
                            <option></option>
                            
                        </select>
                    </div>

                    <div class="d-none align-items-center border-bottom px-8 min-h-50px emailBcc">
                        <div class="text-gray-900 fw-bold w-75px">Bcc:</div>
                        {{--                        <input type="text" class="form-control form-control-transparent border-0" name="bcc_email" placeholder="Bcc email" />--}}
                        <select class="form-select form-control-transparent border-0 select2" name="bcc_email[]" data-control="select2" data-placeholder="Recipient email" data-allow-clear="true" multiple="multiple">
                            <option></option>
                        </select>
                    </div>

                    <!-- Subject -->
                    <div class="border-bottom px-8">
                        <input class="form-control form-control-transparent border-0" name="subject" placeholder="Subject" value="Invoice - {{$invoice->invoice_number}} reminder from {{ auth()->user()->name }}"/>
                    </div>
                    <div class="px-8 round-5 border">
                        <div class="text-gray-900 fw-bold w-75px mt-3">Email Body</div>
                        <input type="hidden" name="body" id="compose_reminder_body">
                        <input type="hidden" name="model_type" value="App\Models\Invoice">
                        <input type="hidden" name="model_id" value="{{ $id }}">
                        <input type="hidden" name="source" value="Reminder Email">
                        <!-- Editable Invoice -->
{{--                        <div id="invoiceReminderContent" class="invoice-container editable" contenteditable="true">--}}
                        <textarea id="emailEditorReminder">
                            <div style="background: #fbfbfb; padding: 20px;">
                                <table style="width: 100%; border-spacing: 0; padding: 0;">
                                    <!-- Outer Table -->
                                    <tr>
                                        <td style="text-align: center; padding-bottom: 20px;">
                                            <table style="width: 600px; margin: 0 auto; border-spacing: 0; padding: 0; background: #ffffff; border: 1px solid #ccc; border-radius: 8px;">
                                                <!-- Inner Content Table -->
                                                <tr>
                                                    <td style="text-align: center; padding: 20px;">
                                                        <h3 style="font-family: Arial, sans-serif; font-size: 24px; color: #333;">Payment Reminder</h3>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 20px; font-family: Arial, sans-serif; font-size: 14px; color: #555; text-align: left;">
                                                        <p>Dear {{ $invoice->client->name }},</p>
                                                        <p>We hope this email finds you well. This is a friendly reminder that your payment is due for the following invoice:</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center; padding-bottom: 20px;">
                                                        <h2 style="font-family: Arial, sans-serif; font-size: 22px; color: #333; font-weight: bold;">
                                                            Invoice #{{ $invoice->invoice_number }}
                                                        </h2>
                                                        <p style="font-family: Arial, sans-serif; font-size: 14px; color: #555;">
                                                            Dated: {{ $invoice->created_at->format('d M, Y') ?? 'N/A' }}
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 20px; font-family: Arial, sans-serif; font-size: 14px; color: #555; text-align: left; background-color: #f8f9fa; border: 1px solid #e0e0e0; border-radius: 8px;">
                                                        <p><b>Due Date:</b> {{ $invoice->due_date->format('d M, Y') ?? 'N/A' }}</p>
                                                        <p><b>Amount Due:</b> ${{ number_format($invoice->due_amount == null ? $invoice->total : $invoice->due_amount,2) }}</p>
                                                        <p><b>Status:</b> {{ $invoice->status == 'Paid' ? 'Paid' : 'Pending' }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 20px; font-family: Arial, sans-serif; font-size: 14px; color: #555; text-align: left;">
                                                        <p>To ensure a smooth process, please make your payment before the due date. You can conveniently make the payment online by clicking the link below:</p>
                                                        <p style="text-align: center; margin: 20px 0;">
                                                            @php
                                                                $hash = \Crypt::encryptString($invoice->id);
                                                            @endphp
                                                            <a href="#" style="text-decoration: none; background-color: #4dcf59; border: 1px solid #49bd54; color: #fff; padding: 10px 20px; display: inline-block;">
                                                                VIEW INVOICE
                                                            </a>
                                                        </p>
                                                        <p>If you have already paid, please disregard this email, and we appreciate your prompt payment.</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 20px; font-family: Arial, sans-serif; font-size: 14px; color: #555; text-align: left;">
                                                        <p>We value your business and are here to help with any questions or concerns you may have. Feel free to contact us anytime for assistance.</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 20px; padding-bottom: 30px; padding-left: 20px; font-family: Arial, sans-serif; font-size: 14px; color: #555; text-align: left;">
                                                        <p>Regards,</p>
                                                        <p>{{ auth()->user()->name }}<br>{{ auth()->user()->company_name }}</p>
                                                        <p><i>This email was sent from an unmonitored mailbox. Please do not reply to this email.</i></p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </textarea>
                    </div>
                    <div class="dropzone dropzone-queue px-8 py-4" id="kt_inbox_reply_attachments_reminder" data-kt-inbox-form="dropzone">
                        <div data-kt-inbox-form="dropzone-reminder" class="form-container">
                            <div class="dropzone-items-reminder"></div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-stack flex-wrap gap-2 py-5 ps-8 pe-5 border-top">
                    <div class="d-flex align-items-center me-3">
                        <div class="btn-group me-4">
                            <button type="submit" class="btn btn-primary fs-bold px-6" data-kt-inbox-form="send">Send</button>
                        </div>
                        <span class="btn btn-icon btn-sm btn-clean btn-active-light-primary me-2" id="kt_inbox_reply_attachments_select_reminder" data-kt-inbox-form="dropzone_upload_reminder">
                            <i class="ki-outline ki-paper-clip fs-2 m-0"></i>
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>