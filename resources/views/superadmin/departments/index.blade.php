@extends('layouts.app')

@section('title', 'Manage Departments')

@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('superadmin.departments.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Create New Department
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header section-card-header">
            <h5 class="mb-0">
                <i class="fas fa-building"></i> All Departments
            </h5>
        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Admins</th>
                        <th>Inquiries</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($departments as $dept)
                        <tr>
                            <td><strong>#{{ $dept->id }}</strong></td>
                            <td><strong>{{ $dept->name }}</strong></td>
                            <td>{{ $dept->email }}</td>
                            <td>{{ $dept->phone ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-info">{{ $dept->admins->count() }}</span>
                            </td>
                            <td>
                                <span class="badge bg-warning">{{ $dept->inquiries->count() }}</span>
                            </td>
                            <td>
                                @if ($dept->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('superadmin.departments.edit', $dept) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('superadmin.departments.delete', $dept) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this department? Departments with inquiries should be deactivated instead.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox"></i> No departments
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($departments->hasPages())
            <div class="card-footer">
                {{ $departments->links() }}
            </div>
        @endif
    </div>
@endsection
