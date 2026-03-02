@if ($messages->count() == 0)
    <p class="text-center text-muted mt-5">
        💬 Start the conversation
    </p>
@else
    @foreach ($messages as $msg)
        <div class="mb-2 {{ $msg->from_id == $fromId ? 'text-end' : 'text-start' }}">
            <div class="chat-bubble {{ $msg->from_id == $fromId ? 'me' : 'other' }}">

                <span class="chat-text">
                    {{ $msg->body }}
                </span>

                <div class="chat-meta">
                    {{ \Carbon\Carbon::parse($msg->created_at)->format('h:i A') }}

                    @if ($msg->from_id == $fromId)
                        <span class="tick">✓</span>
                    @endif
                </div>

            </div>
        </div>
    @endforeach
@endif
