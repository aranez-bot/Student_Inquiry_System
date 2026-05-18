@extends('layouts.app')

@section('title', 'System Analytics')

@section('content')
    <h1 class="mb-4">
        <i class="fas fa-chart-bar"></i> System Analytics
    </h1>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header section-card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-pie-chart"></i> Inquiries by Status
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach ($byStatus as $status => $count)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    @if ($status === 'pending')
                                        <i class="fas fa-hourglass-half"></i>
                                    @elseif ($status === 'in_progress')
                                        <i class="fas fa-spinner"></i>
                                    @elseif ($status === 'resolved')
                                        <i class="fas fa-check-circle"></i>
                                    @else
                                        <i class="fas fa-times-circle"></i>
                                    @endif
                                    <strong>{{ ucfirst(str_replace('_', ' ', $status)) }}</strong>
                                </div>
                                <span class="badge bg-primary">{{ $count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header section-card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-bar-chart"></i> Inquiries by Department
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach ($byDepartment as $dept => $count)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-building"></i>
                                    <strong>{{ $dept }}</strong>
                                </div>
                                <span class="badge bg-info">{{ $count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header section-card-header">
            <h5 class="mb-0">
                <i class="fas fa-table"></i> Summary Statistics
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th>Metric</th>
                        <th>Value</th>
                    </tr>
                    <tr>
                        <td>Total Inquiries</td>
                        <td><strong>{{ array_sum($byStatus->toArray()) }}</strong></td>
                    </tr>
                    <tr>
                        <td>Average Resolution Rate</td>
                        <td>
                            @php
                                $total = array_sum($byStatus->toArray());
                                $resolved = $byStatus['resolved'] ?? 0;
                                $rate = $total > 0 ? round(($resolved / $total) * 100, 2) : 0;
                            @endphp
                            <strong>{{ $rate }}%</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>Total Departments</td>
                        <td><strong>{{ count($byDepartment) }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
