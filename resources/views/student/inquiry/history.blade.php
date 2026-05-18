@extends('layouts.app')

@section('title', 'Inquiry History')

@section('content')
    <h1 class="mb-4">
        <i class="fas fa-history"></i> Inquiry History
    </h1>

    <div class="card">
        <div class="card-header section-card-header">
            <h5 class="mb-0">All Your Inquiries</h5>
        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Subject</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Messages</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($inquiries as $inquiry)
                        <tr>
                            <td>#{{ $inquiry->id }}</td>
                            <td>
                                <strong>{{ Str::limit($inquiry->subject, 50) }}</strong>
                            </td>
                            <td>{{ $inquiry->department->name }}</td>
                            <td>
                                <span class="badge status-{{ $inquiry->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $inquiry->status)) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $inquiry->messages->count() }}</span>
                            </td>
                            <td>
                                <small class="text-muted">{{ $inquiry->created_at->format('M d, Y') }}</small>
                            </td>
                            <td>
                                <a href="{{ route('student.inquiry.show', $inquiry) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-inbox"></i>
                                <p class="text-muted mb-0 mt-2">You haven't submitted any inquiries yet</p>
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
