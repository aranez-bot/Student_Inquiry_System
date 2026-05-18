@extends('layouts.app')

@section('content')
<div class="auth-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-11 col-xl-10">
                <div class="auth-panel">
                    <div class="row g-0">
                        <div class="col-lg-5 d-none d-lg-block">
                            <div class="auth-intro">
                                <div>
                                    <h1>Create your account</h1>
                                    <p>Students and department heads get a focused place to submit, route, and resolve academic inquiries.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="auth-form">
                                <div class="mb-4">
                                    <h4 class="mb-1">Register</h4>
                                    <p class="text-muted mb-0">Enter your account details to get started.</p>
                                </div>

                                <form method="POST" action="{{ route('register') }}">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="user_identifier" class="form-label">User ID</label>
                                            <input id="user_identifier" type="text" class="form-control @error('user_identifier') is-invalid @enderror" name="user_identifier" value="{{ old('user_identifier') }}" placeholder="Student/Admin ID" required>
                                            @error('user_identifier')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="user_type" class="form-label">Type of User</label>
                                            <select id="user_type" name="user_type" class="form-select @error('user_type') is-invalid @enderror" required>
                                                <option value="super_admin" @selected(old('user_type') === 'super_admin')>Admin</option>
                                                <option value="student" @selected(old('user_type', 'student') === 'student')>Student</option>
                                                <option value="department_admin" @selected(old('user_type') === 'department_admin')>Department Head</option>
                                            </select>
                                            @error('user_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3" id="department-field">
                                            <label for="department_id" class="form-label">Department</label>
                                            <select id="department_id" name="department_id" class="form-select @error('department_id') is-invalid @enderror">
                                                <option value="">Choose department</option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}" @selected(old('department_id') == $department->id)>
                                                        {{ $department->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('department_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-user-plus"></i> Register
                                    </button>
                                </form>

                                <div class="text-center mt-4">
                                    <small class="text-muted">Already have an account? <a href="{{ route('login') }}">Login</a></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        const userTypeSelect = document.getElementById('user_type');
        const departmentField = document.getElementById('department-field');
        const departmentSelect = document.getElementById('department_id');

        function toggleDepartmentField() {
            const needsDepartment = userTypeSelect.value === 'department_admin';
            departmentField.style.display = needsDepartment ? 'block' : 'none';
            departmentSelect.required = needsDepartment;
        }

        userTypeSelect.addEventListener('change', toggleDepartmentField);
        toggleDepartmentField();
    </script>
@endpush
