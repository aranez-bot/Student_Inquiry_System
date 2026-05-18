@extends('layouts.app')

@section('title', 'Manage Inquiry')

@section('content')
    <h1 class="mb-4">
        <i class="fas fa-inbox"></i> Manage Inquiry
    </h1>

    <div class="card">
        <div class="card-header section-card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Inquiries</h5>
                <span class="badge bg-light text-dark">{{ $inquiries->total() }} Total</span>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Assigned To</th>
                        <th>Submitted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($inquiries as $inquiry)
                        <tr>
                            <td><strong>#{{ $inquiry->id }}</strong></td>
                            <td>
                                <strong>{{ $inquiry->student->name }}</strong><br>
                                <small class="text-muted">{{ $inquiry->student->email }}</small>
                            </td>
                            <td>
                                {{ Str::limit($inquiry->subject, 35) }}
                            </td>
                            <td>
                                <span class="badge status-{{ $inquiry->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $inquiry->status)) }}
                                </span>
                            </td>
                            <td>
                                @if ($inquiry->priority === 1)
                                    <span class="badge bg-light text-dark"><i class="fas fa-circle"></i> Normal</span>
                                @elseif ($inquiry->priority === 2)
                                    <span class="badge bg-warning"><i class="fas fa-arrow-up"></i> High</span>
                                @else
                                    <span class="badge bg-danger"><i class="fas fa-exclamation"></i> Urgent</span>
                                @endif
                            </td>
                            <td>
                                @if ($inquiry->assignedAdmin)
                                    <span class="badge bg-info">{{ $inquiry->assignedAdmin->name }}</span>
                                @else
                                    <span class="badge bg-secondary">Unassigned</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ $inquiry->created_at->format('M d, H:i') }}</small>
                            </td>
                            <td>
                                <a href="{{ route('admin.inquiry.show', $inquiry) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-reply"></i> Respond
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox"></i> No inquiries yet
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($inquiries->hasPages())
            <div class="card-footer">
                {{ $inquiries->links() }}
            </div>
        @endif
    </div>
@endsection
