@extends('layouts.app')

@section('title', 'Create New Inquiry')

@section('content')
    <h1 class="mb-4">
        <i class="fas fa-plus-circle"></i> Create New Inquiry
    </h1>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header section-card-header">
                    <h5 class="mb-0">Submit Your Inquiry</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('student.inquiry.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="department" class="form-label">
                                <i class="fas fa-building"></i> Select Department
                            </label>
                            <select class="form-select @error('department_id') is-invalid @enderror" id="department" name="department_id" required>
                                <option value="">-- Choose Department --</option>
                                @foreach ($departments as $dept)
                                    <option value="{{ $dept->id }}" @if (old('department_id') == $dept->id) selected @endif>
                                        {{ $dept->name }} ({{ $dept->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">
                                <i class="fas fa-heading"></i> Subject
                            </label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" placeholder="e.g., Request for Transcript of Records" value="{{ old('subject') }}" required>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">
                                <i class="fas fa-align-left"></i> Detailed Description
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="6" placeholder="Please provide details about your inquiry..." required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('student.dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Submit Inquiry
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
                        <i class="fas fa-lightbulb"></i> Tips for Your Inquiry
                    </h6>
                </div>
                <div class="card-body small">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <strong>Be specific:</strong> Provide clear details about your concern
                        </li>
                        <li class="mb-2">
                            <strong>Include relevant info:</strong> Reference IDs, dates, or names when applicable
                        </li>
                        <li class="mb-2">
                            <strong>Polite tone:</strong> Maintain professionalism in your message
                        </li>
                        <li class="mb-2">
                            <strong>Expected response:</strong> Typically within 24-48 hours
                        </li>
                        <li>
                            <strong>Follow up:</strong> Check your notifications for department responses
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card mt-3" style="border-left: 4px solid var(--success-color);">
                <div class="card-header section-card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-question-circle"></i> Need Help?
                    </h6>
                </div>
                <div class="card-body small">
                    <p class="mb-0">
                        Can't find the right department? Contact the main office or check the FAQ section for common questions.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
