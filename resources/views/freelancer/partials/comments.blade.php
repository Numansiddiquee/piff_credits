<div class="scroll-y mh-325px my-5 px-8">
    @forelse($comments as $comment)
        <div class="d-flex flex-stack py-4">
            <div class="d-flex align-items-center me-2">
                <span class="w-70px badge badge-light-success me-4">
                    {{ strtoupper($comment->action_type) ?? 'MSG' }}
                </span>
                <a href="#" class="text-gray-800 text-hover-primary fw-semibold">
                    {{ $comment->log_title ?? 'New Comment' }}
                    <p>{{ $comment->log_comment_text }}</p>
                </a>
                
            </div>
            <span class="badge badge-light fs-8">{{ $comment->created_at->diffForHumans() }}</span>
        </div>
    @empty
        <div class="text-center text-gray-500 py-5">
            No comments yet.
        </div>
    @endforelse
</div>
<div class="py-3 text-center border-top">
    <a href="#" class="btn btn-color-gray-600 btn-active-color-primary">
        View All <i class="ki-outline ki-arrow-right fs-5"></i>
    </a>
</div>
