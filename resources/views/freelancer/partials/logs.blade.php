<div class="scroll-y mh-325px my-5 px-8">
    @forelse($logs as $log)
        <div class="d-flex flex-stack py-4">
            <div class="d-flex align-items-center">
                <div class="symbol symbol-35px me-4">
                    <span class="symbol-label bg-light-primary">
                        <i class="ki-outline ki-abstract-28 fs-2 text-primary"></i>
                    </span>
                </div>
                <div class="mb-0 me-2">
                    <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">
                        {{ $log->log_title ?? 'Untitled Log' }}
                    </a>
                    <div class="text-gray-500 fs-7">
                        {{ Str::limit($log->log_comment_text, 80) }}
                    </div>
                </div>
            </div>
            <span class="badge badge-light fs-8">{{ $log->created_at->diffForHumans() }}</span>
        </div>
    @empty
        <div class="text-center text-gray-500 py-5">
            No logs found.
        </div>
    @endforelse
</div>
<div class="py-3 text-center border-top">
    <a href="#" class="btn btn-color-gray-600 btn-active-color-primary">
        View All <i class="ki-outline ki-arrow-right fs-5"></i>
    </a>
</div>
