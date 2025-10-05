<div id="attachment_drawer" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="chat" data-kt-drawer-activate="true"
     data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'300px', 'md': '500px'}"
     data-kt-drawer-direction="end" data-kt-drawer-toggle="#attachment_drawer_toggle"
     data-kt-drawer-close="#attachment_drawer_drawer_close">
    <!--begin::Messenger-->
    <div class="card w-100 border-0 rounded-0" id="attachment_drawer_messenger">
        <!--begin::Card header-->
        <div class="card-header pe-5" id="attachment_drawer_messenger_header">
            <!--begin::Title-->
            <div class="card-title">
                <!--begin::User-->
                <div class="d-flex justify-content-center flex-column me-3">
                    <div href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 mb-2 lh-1">Invoice Attachments</div>
                </div>
                <!--end::User-->
            </div>
            <!--end::Title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <div class="btn btn-sm btn-icon btn-active-color-primary" id="attachment_drawer_toggle">
                    <i class="ki-outline ki-cross-square fs-2"></i>
                </div>
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body p-2" id="attachment_drawer_messenger_body">
            <!--begin::Messages-->
            <div class="scroll-y me-n5 pe-5" data-kt-element="messages" data-kt-scroll="true"
                 data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                 data-kt-scroll-dependencies="#attachment_drawer_messenger_header, #attachment_drawer_messenger_footer"
                 data-kt-scroll-wrappers="#attachment_drawer_messenger_body" data-kt-scroll-offset="0px">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form id="attachment_upload_form" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                                    <label class="form-label mt-4">Upload Attachment</label>
                                    <input type="file" name="attachment[]" class="form-control form-control-sm" multiple required>
                                    <button type="submit" class="btn btn-sm btn-secondary mt-2">Upload</button>
                                </form>
                                <div class="separator separator-solid my-4"></div>
                                <h4 class="h4">Attachments</h4>
                                <div id="attachment_list" class="mt-5">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!--end::Message(template for in)-->
        </div>
        <!--end::Messages-->
    </div>
</div>
<!--end::Messenger-->
</div>

