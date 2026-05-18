@extends('layouts.app')

@section('title', 'Admin Notifications')

@section('content')
    <h1 class="mb-4">
        <i class="fas fa-bell"></i> Notifications
    </h1>

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
                    </div>
                    @if ($notification->inquiry)
                        <div class="mt-2">
                            <a href="{{ route('superadmin.inquiry.show', $notification->inquiry) }}" class="btn btn-sm btn-light">
                                View Inquiry <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="fas fa-bell" style="font-size: 3rem; color: #d1d5db;"></i>
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
@endsection
