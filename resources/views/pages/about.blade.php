@extends('layouts.app')

@section('title', 'About Us')

@section('content')
    <h1 class="mb-4">
        <i class="fas fa-info-circle"></i> About Us
    </h1>

    <div class="card">
        <div class="card-body">
            <h5 class="mb-3">Student Inquiry System</h5>
            <p class="text-muted">
                The Student Inquiry System helps students submit inquiries to departments, track responses, and receive updates in one place.
            </p>
            <p class="text-muted mb-0">
                Department admins can manage inquiry status, reply to students, and monitor department activity.
            </p>
        </div>
    </div>
@endsection
