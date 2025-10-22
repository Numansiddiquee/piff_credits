<div class="scroll-y mh-325px my-5 px-8">
    @forelse($notifications as $notification)
        <div class="d-flex flex-stack py-4">
            <div class="d-flex align-items-center">
                <div class="symbol symbol-35px me-4">
                    @php
                        $types = [
                            'freelancer_comment' => ['icon' => 'ki-message-square', 'bg' => 'bg-light-success', 'text' => 'text-success'],
                            'invoice_due_updated' => ['icon' => 'ki-calendar', 'bg' => 'bg-light-warning', 'text' => 'text-warning'],
                            'invoice_attachment' => ['icon' => 'ki-paperclip', 'bg' => 'bg-light-info', 'text' => 'text-info'],
                            'invoice_created' => ['icon' => 'ki-file-plus', 'bg' => 'bg-light-primary', 'text' => 'text-primary'],
                            'invoice_paid' => ['icon' => 'ki-check-circle', 'bg' => 'bg-light-success', 'text' => 'text-success'],
                            'invoice_writeoff' => ['icon' => 'ki-cancel', 'bg' => 'bg-light-danger', 'text' => 'text-danger'], // changed
                        ];
                        $type = $types[$notification->type] ?? ['icon' => 'ki-bell', 'bg' => 'bg-light-primary', 'text' => 'text-primary'];
                    @endphp
                    <span class="symbol-label {{ $type['bg'] }}">
                        <i class="ki-outline {{ $type['icon'] }} fs-2 {{ $type['text'] }}"></i>
                    </span>
                </div>
                <div class="mb-0 me-2">
                    <a href="{{ $notification->url ?? '#' }}" class="fs-6 text-gray-800 text-hover-primary fw-bold">
                        {{ $notification->title }}
                    </a>
                    <div class="text-gray-500 fs-7">{{ $notification->message }}</div>
                </div>
            </div>
            <span class="badge badge-light fs-8">{{ $notification->created_at->diffForHumans() }}</span>
        </div>
    @empty
        <div class="text-center text-gray-500 py-5">
            No notifications yet.
        </div>
    @endforelse
</div>
