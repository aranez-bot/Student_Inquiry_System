@extends('layouts.app')

@section('title', 'Inquiry: ' . $inquiry->subject)

@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('student.inquiry.history') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to History
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header section-card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-file"></i> {{ $inquiry->subject }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Status:</strong></p>
                            <span class="badge status-{{ $inquiry->status }}">
                                {{ ucfirst(str_replace('_', ' ', $inquiry->status)) }}
                            </span>
                        </div>
                        <div class="col-md-6 text-end">
                            <p class="mb-1"><strong>Submitted:</strong></p>
                            <small class="text-muted">{{ $inquiry->created_at->format('M d, Y H:i') }}</small>
                        </div>
                    </div>
                    <hr>
                    <h6>Your Inquiry:</h6>
                    <p class="text-muted">{{ $inquiry->description }}</p>
                    @if ($inquiry->resolution_notes)
                        <hr>
                        <h6>Resolution Notes:</h6>
                        <p class="text-muted">{{ $inquiry->resolution_notes }}</p>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header section-card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-comments"></i> Conversation
                    </h5>
                </div>
                <div class="card-body" style="max-height: 500px; overflow-y: auto; background-color: #f9fafb;">
                    @forelse ($messages as $message)
                        <div class="message-item @if ($message->user_id === auth()->id()) sent @else received @endif">
                            <strong>{{ $message->user->name }}</strong>
                            <small class="text-muted d-block mb-2">
                                {{ $message->created_at->diffForHumans() }}
                                @if ($message->isRead())
                                    <i class="fas fa-check-double" style="color: var(--secondary-color);"></i>
                                @endif
                            </small>
                            <p class="mb-0">{{ $message->message }}</p>
                            @if ($message->attachment_path)
                                <small class="mt-2 d-block">
                                    <i class="fas fa-paperclip"></i>
                                    <a href="{{ route('message.download', $message) }}">Download attachment</a>
                                </small>
                            @endif
                        </div>
                    @empty
                        <p class="text-center text-muted py-4">
                            <i class="fas fa-comments"></i> No messages yet. Send the first message!
                        </p>
                    @endforelse
                </div>
                <div class="card-footer" style="background-color: white;">
                    <form action="{{ route('message.store', $inquiry) }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="message" class="form-control" placeholder="Type your message..." required>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Send
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card" style="border-left: 4px solid var(--primary-color);">
                <div class="card-header section-card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle"></i> Inquiry Details
                    </h6>
                </div>
                <div class="card-body small">
                    <p class="mb-2">
                        <strong>Department:</strong><br>
                        {{ $inquiry->department->name }}
                    </p>
                    <p class="mb-2">
                        <strong>Department Email:</strong><br>
                        {{ $inquiry->department->email }}
                    </p>
                    @if ($inquiry->assignedAdmin)
                        <p class="mb-2">
                            <strong>Assigned Admin:</strong><br>
                            {{ $inquiry->assignedAdmin->name }}
                        </p>
                    @endif
                    <hr>
                    <p class="mb-0">
                        <strong>Unread Messages:</strong><br>
                        {{ $unreadMessages }}
                    </p>
                </div>
            </div>

            <div class="card mt-3" style="border-left: 4px solid var(--success-color);">
                <div class="card-header section-card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-clock"></i> Timeline
                    </h6>
                </div>
                <div class="card-body small">
                    <p class="mb-1">
                        <strong>Created:</strong><br>
                        <small class="text-muted">{{ $inquiry->created_at->format('M d, Y H:i') }}</small>
                    </p>
                    @if ($inquiry->resolved_at)
                        <p class="mb-1">
                            <strong>Resolved:</strong><br>
                            <small class="text-muted">{{ $inquiry->resolved_at->format('M d, Y H:i') }}</small>
                        </p>
                    @endif
                    @if ($inquiry->closed_at)
                        <p class="mb-0">
                            <strong>Closed:</strong><br>
                            <small class="text-muted">{{ $inquiry->closed_at->format('M d, Y H:i') }}</small>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Auto-scroll to bottom of messages
        const messagesDiv = document.querySelector('[style*="max-height"]');
        if (messagesDiv) {
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }

        // Auto-refresh messages every 5 seconds
        setInterval(() => {
            const inquiryId = {{ $inquiry->id }};
            fetch(`/inquiry/${inquiryId}/messages`)
                .then(response => response.json())
                .then(data => {
                    // Update messages display
                    console.log('Messages updated:', data);
                });
        }, 5000);
    </script>
@endpush
