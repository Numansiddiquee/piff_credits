<div class="card pt-5 p-0 mt-5">
    <!--begin::Timeline item-->
    @if(count($quote_comments_logs)>0)
        @foreach($quote_comments_logs as $comment)
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
