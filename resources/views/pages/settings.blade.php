@extends('layouts.app')

@section('title', 'Settings')

@section('content')
    <h1 class="mb-4">
        <i class="fas fa-cog"></i> Settings
    </h1>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-edit"></i> Edit Profile
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('settings.profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ old('address', auth()->user()->address) }}">
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">About</label>
                            <textarea class="form-control" id="bio" name="bio" rows="4">{{ old('bio', auth()->user()->bio) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Profile
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-image"></i> Change Profile Picture
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        @if (auth()->user()->profile_photo_path)
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="{{ auth()->user()->name }}" class="settings-photo-preview">
                        @else
                            <div class="settings-photo-placeholder">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                        <div class="text-muted small">JPG, PNG, or WebP up to 2 MB.</div>
                    </div>

                    <form method="POST" action="{{ route('settings.photo.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <input type="file" class="form-control" name="profile_photo" accept="image/png,image/jpeg,image/webp" required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload"></i> Upload Picture
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-envelope"></i> Update Email
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('settings.email.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Email
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-phone"></i> Update Contact Number
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('settings.phone.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="phone" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}">
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Contact
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-lock"></i> Change Password
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('settings.password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-key"></i> Change Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .settings-photo-preview,
        .settings-photo-placeholder {
            width: 84px;
            height: 84px;
            border-radius: 50%;
            border: 3px solid #e0e7ff;
            flex: 0 0 auto;
        }

        .settings-photo-preview {
            object-fit: cover;
        }

        .settings-photo-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #eef2ff;
            color: var(--primary-color);
            font-size: 2rem;
        }
    </style>
@endpush
