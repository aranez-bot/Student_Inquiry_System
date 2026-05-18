@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
    <h1 class="mb-4">
        <i class="fas fa-bell"></i> Notifications
    </h1>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header section-card-header">
                    <h5 class="mb-0">Your Notifications</h5>
                </div>
                <div class="card-body">
                    @forelse ($notifications as $notification)
                        <div class="notification-item @if (!$notification->isRead()) unread @endif">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">
                                        @if ($notification->type === 'inquiry_new')
                                            <i class="fas fa-plus-circle"></i>
                                        @elseif ($notification->type === 'message_new')
                                            <i class="fas fa-comment"></i>
                                        @elseif ($notification->type === 'status_changed')
                                            <i class="fas fa-sync-alt"></i>
                                        @else
                                            <i class="fas fa-info-circle"></i>
                                        @endif
                                        {{ $notification->title }}
                                    </h6>
                                    <p class="mb-1 text-muted">{{ $notification->message }}</p>
                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i> {{ $notification->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                @if (!$notification->isRead())
                                    <form action="{{ route('notification.mark-read', $notification) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-primary" title="Mark as read">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                            @if ($notification->inquiry)
                                <div class="mt-2">
                                    <a href="{{ route('student.inquiry.show', $notification->inquiry) }}" class="btn btn-sm btn-light">
                                        View Inquiry <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fas fa-inbox" style="font-size: 3rem; color: #d1d5db;"></i>
                            <p class="text-muted mt-3">No notifications yet</p>
                        </div>
                    @endforelse
                </div>
                @if ($notifications->hasPages())
                    <div class="card-footer">
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>
        </div>

        <div class="col-md-4">
            <div class="card" style="border-left: 4px solid var(--primary-color);">
                <div class="card-header section-card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-filter"></i> Notification Types
                    </h6>
                </div>
                <div class="card-body small">
                    <p class="mb-2">
                        <i class="fas fa-plus-circle"></i> <strong>New Inquiry:</strong> When you successfully create an inquiry
                    </p>
                    <p class="mb-2">
                        <i class="fas fa-comment"></i> <strong>New Message:</strong> When a department replies to your inquiry
                    </p>
                    <p class="mb-0">
                        <i class="fas fa-sync-alt"></i> <strong>Status Changed:</strong> When your inquiry status is updated
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
