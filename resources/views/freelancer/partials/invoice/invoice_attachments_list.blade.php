@if($attachments->count())
    <ul class="list-group">
        @foreach($attachments as $attachment)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-start">
                    {{-- File Type Icon --}}
                    <i class="bi me-2 fs-1 mt-2 text-primary
                        @if(in_array($attachment->file_type, ['jpg','jpeg','png','gif','webp'])) bi-file-image
                        @elseif(in_array($attachment->file_type, ['pdf'])) bi-file-earmark-pdf
                        @elseif(in_array($attachment->file_type, ['doc','docx'])) bi-file-earmark-word
                        @elseif(in_array($attachment->file_type, ['xls','xlsx'])) bi-file-earmark-excel
                        @elseif(in_array($attachment->file_type, ['zip','rar'])) bi-file-earmark-zip
                        @else bi-file-earmark
                        @endif
                    "></i>

                    {{-- File Name and Uploader --}}
                    <div class="d-flex flex-column">
                        <a href="{{ asset('storage/' . $attachment->file_path) }}"
                           target="_blank"
                           title="{{ $attachment->file_name }}"
                           class="fw-semibold text-dark">
                            {{ \Illuminate\Support\Str::limit($attachment->file_name, 30) }}
                        </a>
                        <small class="text-muted">Uploaded by: {{ $attachment->uploader->name ?? 'N/A' }}</small>
                    </div>
                </div>

                {{-- File Type Badge --}}
                <span class="badge bg-secondary">{{ strtoupper($attachment->file_type) }}</span>
            </li>
        @endforeach
    </ul>
@else
    <p class="text-muted">No attachments uploaded yet.</p>
@endif
