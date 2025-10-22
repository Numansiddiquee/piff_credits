<div id="comments_logs_drawer" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="chat" data-kt-drawer-activate="true"
     data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'300px', 'md': '500px'}"
     data-kt-drawer-direction="end" data-kt-drawer-toggle="#comments_logs_drawer_toggle"
     data-kt-drawer-close="#comments_logs_drawer_close">
    <!--begin::Messenger-->
    <div class="card w-100 border-0 rounded-0" id="comments_logs_drawer_messenger">
        <!--begin::Card header-->
        <div class="card-header pe-5" id="comments_logs_drawer_messenger_header">
            <!--begin::Title-->
            <div class="card-title">
                <!--begin::User-->
                <div class="d-flex justify-content-center flex-column me-3">
                    <div href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 mb-2 lh-1">Comments and Logs</div>
                </div>
                <!--end::User-->
            </div>
            <!--end::Title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <div class="btn btn-sm btn-icon btn-active-color-primary" id="comments_logs_drawer_close">
                    <i class="ki-outline ki-cross-square fs-2"></i>
                </div>
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body p-2" id="comments_logs_drawer_messenger_body">
            <!--begin::Messages-->
            <div class="scroll-y me-n5 pe-5" data-kt-element="messages" data-kt-scroll="true"
                 data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                 data-kt-scroll-dependencies="#comments_logs_drawer_messenger_header, #comments_logs_drawer_messenger_footer"
                 data-kt-scroll-wrappers="#comments_logs_drawer_messenger_body" data-kt-scroll-offset="0px">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Add a Comment</label>
                                    <textarea class="form-control form-control-sm form shadow-sm mt-2" id="comment_text"
                                              rows="4"></textarea>
                                    <button class="btn btn-sm btn-primary mt-4" id="add_comment">Add Comment</button>
                                </div>
                                <div class="separator separator-solid my-4"></div>
                                <h4 class="h4">All Comments</h4>
                                <div class="timeline timeline-border-dashed" id="invoice_comments">
                                    <div class="card pt-5 p-0 mt-5">
                                        <!--begin::Timeline item-->
                                        @if(count($invoice_comments_logs)>0)
                                            @foreach($invoice_comments_logs as $comment)
                                                <div class="timeline-item">
                                                    <div style="min-width: 100px; margin-top: 10px;text-align: right;">
                                                        <div
                                                                class="date">{{date('Y-m-d'),strtotime($comment->created_at)}}</div>
                                                        <div
                                                                class="time">{{date('H:i a',strtotime($comment->created_at))}}</div>
                                                    </div>
                                                    <div class="timeline-icon">
                                                        <i class="ki-outline ki-message-text-2 fs-2 text-gray-500"></i>
                                                    </div>
                                                    <div class="timeline-line"
                                                         style="border-left-color: #1b84ff; border-left-style: solid!important;left:99px;"></div>
                                                    <div class="timeline-content card p-4 shadow-sm">
                                                        <div class="card-body p-2">
                                                            <b class="mt-3">{{ $comment->log_title }}</b>
                                                            <div class="mb-5 fw-light fs-5">{{ $comment->log_comment_text }}</div>
                                                            <b class="mt-3">by {{ $comment->performer->name ?? $comment->performer->first_name ?? 'Unknown Performer' }}</b>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-center">No Comments Found !</p>
                                        @endif
                                    </div>
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

