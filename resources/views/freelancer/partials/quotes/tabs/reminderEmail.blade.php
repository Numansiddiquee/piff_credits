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
            <form action="{{ route('freelancer.quote.send.email') }}" id="kt_inbox_reminder_compose_form" method="post" enctype="multipart/form-data">
                @csrf
                <div class="d-block">
                    <div class="d-flex align-items-center border-bottom px-8 min-h-50px">
                        <div class="text-gray-900 fw-bold w-75px">To:</div>
                        <select class="form-select form-control-transparent border-0 select2" name="to_email[]" data-control="select2" data-placeholder="Recipient email" data-allow-clear="true" multiple="multiple">
                            <option></option>
                            <option value="{{ $current_quote->client->email }}" selected>{{ $current_quote->client->first_name }} {{ $current_quote->client->last_name }} ({{ $current_quote->client->email }})</option>
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

                    <!-- Subject -->
                    <div class="border-bottom px-8">
                        <input class="form-control form-control-transparent border-0" name="subject" placeholder="Subject" value="Quote - {{$current_quote->quote_number}} reminder from {{ auth()->user()->name }}"/>
                    </div>
                    <div class="px-8 round-5 border">
                        <div class="text-gray-900 fw-bold w-75px mt-3">Email Body</div>
                        <input type="hidden" name="body" id="compose_reminder_body">
                        <input type="hidden" name="model_type" value="App\Models\Quote">
                        <input type="hidden" name="model_id" value="{{ $id }}">
                        <input type="hidden" name="source" value="Reminder Email">
                        <!-- Editable Invoice -->
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
                                                        <h3 style="font-family: Arial, sans-serif; font-size: 24px; color: #333;">Quote Reminder</h3>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 20px; font-family: Arial, sans-serif; font-size: 14px; color: #555; text-align: left;">
                                                        <p>Dear {{ $current_quote->client->fname }},</p>
                                                        <p>We hope you're doing well. This is a friendly reminder regarding your quote. Please review the details below and let us know your decision:</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center; padding-bottom: 20px;">
                                                        <h2 style="font-family: Arial, sans-serif; font-size: 22px; color: #333; font-weight: bold;">
                                                            Quote #{{ $current_quote->quote_number }}
                                                        </h2>
                                                        <p style="font-family: Arial, sans-serif; font-size: 14px; color: #555;">
                                                            Issued on: {{ $current_quote->created_at->format('d M, Y') ?? 'N/A' }}
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 20px; font-family: Arial, sans-serif; font-size: 14px; color: #555; text-align: left; background-color: #f8f9fa; border: 1px solid #e0e0e0; border-radius: 8px;">
                                                        <p><b>Expiry Date:</b> {{ date('d M, Y',strtotime($current_quote->expiry_date)) ?? 'N/A' }}</p>
                                                        <p><b>Quote Amount:</b> ${{ number_format($current_quote->grand_total,2) }}</p>
                                                        <p><b>Status:</b> {{ ucfirst($current_quote->status) }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 20px; font-family: Arial, sans-serif; font-size: 14px; color: #555; text-align: left;">
                                                        <p>To proceed with this quote, please click the button below:</p>
                                                        <p style="text-align: center; margin: 20px 0;">
                                                            @php
                                                                $hash = \Crypt::encryptString($current_quote->id);
                                                            @endphp
                                                            @if($current_quote->status !== 'Declined')
                                                                <a href="{{ route('quotes.accept',$hash) }}" style="text-decoration: none; background-color: #4dcf59; border: 1px solid #49bd54; color: #fff; padding: 10px 20px; display: inline-block; border-radius: 4px; margin-right: 10px;">
                                                                    ACCEPT QUOTE
                                                                </a>
                                                                <a href="{{ route('quotes.reject',$hash) }}" style="text-decoration: none; background-color: #f44336; border: 1px solid #e53935; color: #fff; padding: 10px 20px; display: inline-block; border-radius: 4px;">
                                                                    REJECT QUOTE
                                                                </a>
                                                            @endif
                                                        </p>
                                                        <p>If you have any questions or need further assistance, feel free to contact us.</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 20px; font-family: Arial, sans-serif; font-size: 14px; color: #555; text-align: left;">
                                                        <p>We value your business and look forward to your response.</p>
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
                    <div class="dropzone dropzone-queue px-8 py-4" id="kt_inbox_reply_attachments" data-kt-inbox-form="dropzone">
                        <div data-kt-inbox-form="dropzone" class="form-container">
                            <div class="dropzone-items"></div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-stack flex-wrap gap-2 py-5 ps-8 pe-5 border-top">
                    <div class="d-flex align-items-center me-3">
                        <div class="btn-group me-4">
                            <button type="{{ $current_quote->status == 'Declined' ? 'button' : 'submit' }}" class="btn btn-primary fs-bold px-6 {{ $current_quote->status == 'Declined' ? 'cursor-not-allowed' : '' }}" data-kt-inbox-form="send">Send</button>
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
