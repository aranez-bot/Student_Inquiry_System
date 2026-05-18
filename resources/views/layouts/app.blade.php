<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Inquiry System')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary-color: #14b8a6;
            --accent-color: #f97316;
            --danger-color: #dc2626;
            --success-color: #059669;
            --warning-color: #d97706;
            --dark-color: #172033;
            --muted-color: #64748b;
            --border-color: #dbe3ef;
            --light-color: #f7f9fc;
            --surface-color: #ffffff;
            --shadow-sm: 0 1px 2px rgba(15, 23, 42, 0.06);
            --shadow-md: 0 10px 30px rgba(15, 23, 42, 0.08);
            --shadow-lg: 0 20px 45px rgba(15, 23, 42, 0.12);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Instrument Sans', 'Segoe UI', system-ui, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.10), transparent 28rem),
                linear-gradient(180deg, #f8fbff 0%, #eef3f8 100%);
            color: #334155;
            min-height: 100vh;
        }

        a {
            color: var(--primary-color);
            text-decoration: none;
        }

        a:hover {
            color: var(--primary-dark);
        }

        .navbar {
            background: rgba(255, 255, 255, 0.92);
            border-bottom: 1px solid rgba(219, 227, 239, 0.9);
            box-shadow: var(--shadow-sm);
            backdrop-filter: blur(16px);
            padding: 0.85rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--dark-color) !important;
            letter-spacing: 0;
        }

        .navbar-brand i {
            color: var(--primary-color);
        }

        .navbar .nav-link {
            color: #475569 !important;
            font-weight: 600;
        }

        .navbar .nav-link:hover,
        .navbar .nav-link:focus {
            color: var(--primary-color) !important;
        }

        #sidebarToggle {
            width: 2.4rem;
            height: 2.4rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: #334155;
            background: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .nav-profile-photo {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 0.35rem;
            border: 2px solid rgba(255,255,255,0.65);
        }

        .app-shell {
            display: flex;
            min-height: calc(100vh - 66px);
        }

        .sidebar {
            background: rgba(255, 255, 255, 0.96);
            border-right: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            min-height: calc(100vh - 66px);
            padding: 1rem 0.75rem;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            position: sticky;
            left: 0;
            top: 66px;
            width: 272px;
            z-index: 999;
            flex: 0 0 272px;
            overflow-y: auto;
            align-self: flex-start;
        }

        body.sidebar-collapsed .sidebar {
            width: 0;
            flex-basis: 0;
            overflow: hidden;
            transform: translateX(-100%);
        }

        .sidebar .nav-link {
            color: #526173;
            padding: 0.82rem 0.95rem;
            border-radius: 8px;
            border-left: 0;
            transition: all 0.2s ease;
            font-weight: 600;
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #eaf2ff;
            color: var(--primary-color);
        }

        .sidebar .nav-link.active {
            box-shadow: inset 3px 0 0 var(--primary-color);
        }

        .sidebar .nav-link i {
            margin-right: 0.75rem;
            width: 20px;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 998;
            transition: all 0.3s ease;
        }

        .sidebar-overlay.show {
            display: block;
        }

        .main-content-wrapper {
            flex: 1 1 auto;
            min-width: 0;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .profile-dropdown {
            min-width: 280px;
            padding: 0;
        }

        .profile-dropdown-header {
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
            text-align: center;
        }

        .profile-dropdown-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .profile-dropdown-photo,
        .profile-dropdown-placeholder {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            margin: 0 auto 0.75rem;
            border: 3px solid #e0e7ff;
        }

        .profile-dropdown-photo {
            display: block;
            object-fit: cover;
        }

        .profile-dropdown-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #eef2ff;
            color: var(--primary-color);
            font-size: 2rem;
        }

        .profile-dropdown-name {
            font-weight: 700;
            color: var(--dark-color);
            overflow-wrap: anywhere;
        }

        .profile-dropdown-detail {
            color: #6b7280;
            font-size: 0.9rem;
            overflow-wrap: anywhere;
        }

        .main-content {
            padding: 2rem;
            max-width: 1440px;
            margin: 0 auto;
            width: 100%;
        }

        .main-content h1 {
            color: var(--dark-color);
            font-size: clamp(1.5rem, 2vw, 2rem);
            font-weight: 700;
            letter-spacing: 0;
        }

        .main-content h1 i {
            color: var(--primary-color);
            margin-right: 0.35rem;
        }

        .card {
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            transition: box-shadow 0.2s ease, transform 0.2s ease;
            border-radius: 8px;
            overflow: hidden;
            background: var(--surface-color);
        }

        .card:hover {
            box-shadow: var(--shadow-md);
        }

        .card-header {
            background: #ffffff;
            border-bottom: 1px solid var(--border-color);
            font-weight: 700;
            color: var(--dark-color);
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
            padding: 0.62rem 1.1rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.24);
            color: white;
        }

        .btn-secondary {
            border: 1px solid var(--border-color);
            background: #ffffff;
            color: #475569;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-secondary:hover {
            background: #f1f5f9;
            color: var(--dark-color);
            border-color: #cbd5e1;
        }

        .badge {
            padding: 0.42rem 0.72rem;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.78rem;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-in_progress {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .status-resolved {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-closed {
            background-color: #f3f4f6;
            color: #4b5563;
        }

        .department-card {
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }

        .department-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.15);
        }

        .department-card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1.5rem;
            text-align: center;
        }

        .notification-item {
            padding: 1rem;
            border-left: 4px solid var(--primary-color);
            background-color: #f0f9ff;
            border-radius: 4px;
            margin-bottom: 0.75rem;
            transition: all 0.3s ease;
        }

        .notification-item:hover {
            background-color: #e0f2fe;
        }

        .notification-item.unread {
            background-color: #fef3c7;
            border-left-color: var(--warning-color);
        }

        .message-item {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 8px;
            max-width: 80%;
        }

        .message-item.sent {
            background-color: #dbeafe;
            margin-left: auto;
            border-bottom-right-radius: 0;
        }

        .message-item.received {
            background-color: #f3f4f6;
            border-bottom-left-radius: 0;
        }

        .table {
            background: white;
            vertical-align: middle;
        }

        .table thead {
            background-color: #f8fafc;
            border-bottom: 1px solid var(--border-color);
        }

        .table thead th {
            font-weight: 700;
            color: var(--dark-color);
            border: none;
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0;
            white-space: nowrap;
        }

        .table tbody td {
            border-color: #edf2f7;
            color: #475569;
            padding: 0.95rem 0.75rem;
        }

        .table tbody tr:hover {
            background: #f8fbff;
        }

        .alert {
            border: none;
            border-radius: 8px;
            padding: 1rem 1.5rem;
        }

        .alert-success {
            background-color: #dcfce7;
            color: #166534;
        }

        .alert-error, .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .form-control, .form-select {
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            color: #263244;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .stat-card {
            background: white;
            padding: 1.25rem;
            border-radius: 8px;
            text-align: left;
            border: 1px solid var(--border-color);
            border-left: 4px solid var(--primary-color);
            box-shadow: var(--shadow-sm);
            height: 100%;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .stat-card h3 {
            font-size: 2.1rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0.65rem 0 0.1rem;
        }

        .stat-card p {
            color: var(--muted-color);
            font-weight: 600;
            margin-bottom: 0;
        }

        .stat-card i {
            width: 2.8rem;
            height: 2.8rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: #eff6ff;
        }

        .auth-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 2rem 0;
            background:
                linear-gradient(135deg, rgba(37, 99, 235, 0.10), rgba(20, 184, 166, 0.08)),
                #f8fbff;
        }

        .auth-panel {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }

        .auth-intro {
            height: 100%;
            padding: 2rem;
            color: white;
            background:
                linear-gradient(135deg, rgba(23, 32, 51, 0.92), rgba(37, 99, 235, 0.88)),
                url('https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1200&q=80') center/cover;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }

        .auth-intro h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .auth-intro p {
            color: rgba(255, 255, 255, 0.82);
            margin-bottom: 0;
        }

        .auth-form {
            padding: 2rem;
        }

        .auth-form h4 {
            font-weight: 700;
            color: var(--dark-color);
        }

        .section-card-header {
            background: white !important;
            color: var(--dark-color) !important;
            border-bottom: 1px solid var(--border-color);
        }

        .section-card-header i {
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .app-shell {
                display: block;
            }

            .sidebar {
                position: fixed;
                top: 0;
                width: 280px;
                flex-basis: 280px;
                min-height: 100vh;
                height: 100vh;
                padding-top: 80px;
                transform: translateX(-100%);
                overflow-y: auto;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            body:not(.sidebar-collapsed) .sidebar {
                transform: translateX(-100%);
            }

            body.sidebar-collapsed .sidebar {
                width: 280px;
                flex-basis: 280px;
                overflow-y: auto;
            }

            body.sidebar-mobile-open .sidebar {
                transform: translateX(0);
            }

            .main-content {
                padding: 1rem;
            }

            .auth-intro {
                min-height: 220px;
            }

            .message-item {
                max-width: 100%;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    @if (auth()->check())
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <button class="btn btn-sm btn-light me-2" id="sidebarToggle" type="button" aria-label="Toggle sidebar" aria-controls="appSidebar" aria-expanded="true">
                    <i class="fas fa-bars"></i>
                </button>
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    <i class="fas fa-comments"></i> Inquiry System
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        @if (!auth()->user()->isSuperAdmin())
                            <li class="nav-item">
                                @php
                                    $notificationRoute = auth()->user()->isStudent()
                                        ? 'student.notifications'
                                        : (auth()->user()->isDepartmentAdmin() ? 'admin.notifications' : null);
                                @endphp
                                <a class="nav-link" href="{{ $notificationRoute ? route($notificationRoute) : '#' }}">
                                    <i class="fas fa-bell"></i>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                @if (auth()->user()->profile_photo_path)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="{{ auth()->user()->name }}" class="nav-profile-photo">
                                @else
                                    <i class="fas fa-user-circle"></i>
                                @endif
                                {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end profile-dropdown" aria-labelledby="userDropdown">
                                <li>
                                    <div class="profile-dropdown-header">
                                        <div class="profile-dropdown-title">My Profile</div>
                                        @if (auth()->user()->profile_photo_path)
                                            <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="{{ auth()->user()->name }}" class="profile-dropdown-photo">
                                        @else
                                            <div class="profile-dropdown-placeholder">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        @endif
                                        <div class="profile-dropdown-name">{{ auth()->user()->name }}</div>
                                        @if (auth()->user()->user_identifier)
                                            <div class="profile-dropdown-detail">ID: {{ auth()->user()->user_identifier }}</div>
                                        @endif
                                        <div class="profile-dropdown-detail">{{ auth()->user()->email }}</div>
                                        <div class="profile-dropdown-detail">{{ ucfirst(str_replace('_', ' ', auth()->user()->user_type)) }}</div>
                                        @if (auth()->user()->phone)
                                            <div class="profile-dropdown-detail">
                                                <i class="fas fa-phone"></i> {{ auth()->user()->phone }}
                                            </div>
                                        @endif
                                    </div>
                                </li>
                                <li><hr class="dropdown-divider mt-0"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <div class="app-shell">
            <aside class="sidebar" id="appSidebar">
                        @if (auth()->user()->isStudent())
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link @if (Route::currentRouteName() == 'student.dashboard') active @endif" href="{{ route('student.dashboard') }}">
                                        <i class="fas fa-chart-line"></i> Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if (Route::currentRouteName() == 'student.inquiry.create') active @endif" href="{{ route('student.inquiry.create') }}">
                                        <i class="fas fa-plus-circle"></i> New Inquiry
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if (Route::currentRouteName() == 'student.inquiry.history') active @endif" href="{{ route('student.inquiry.history') }}">
                                        <i class="fas fa-history"></i> Inquiry History
                                    </a>
                                </li>
                                @include('layouts.partials.sidebar-help-links')
                            </ul>
                        @elseif (auth()->user()->isDepartmentAdmin())
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link @if (Route::currentRouteName() == 'admin.dashboard') active @endif" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-chart-line"></i> Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if (request()->routeIs('admin.inquiry.*')) active @endif" href="{{ route('admin.inquiry.inbox') }}">
                                        <i class="fas fa-inbox"></i> Manage Inquiry
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if (Route::currentRouteName() == 'admin.statistics') active @endif" href="{{ route('admin.statistics') }}">
                                        <i class="fas fa-chart-bar"></i> Statistics
                                    </a>
                                </li>
                                @include('layouts.partials.sidebar-help-links')
                            </ul>
                        @elseif (auth()->user()->isSuperAdmin())
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link @if (Route::currentRouteName() == 'superadmin.dashboard') active @endif" href="{{ route('superadmin.dashboard') }}">
                                        <i class="fas fa-chart-line"></i> Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if (Route::currentRouteName() == 'superadmin.departments.index') active @endif" href="{{ route('superadmin.departments.index') }}">
                                        <i class="fas fa-building"></i> Departments
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if (Route::currentRouteName() == 'superadmin.users.index') active @endif" href="{{ route('superadmin.users.index') }}">
                                        <i class="fas fa-users"></i> Users
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if (Route::currentRouteName() == 'superadmin.analytics') active @endif" href="{{ route('superadmin.analytics') }}">
                                        <i class="fas fa-chart-bar"></i> Analytics
                                    </a>
                                </li>
                                @include('layouts.partials.sidebar-help-links')
                            </ul>
                        @endif
            </aside>

            <div class="main-content-wrapper">
                <div class="main-content">
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <h4 class="alert-heading">Error!</h4>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    @else
        @yield('content')
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('appSidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const mobileBreakpoint = 768;
            
            if (sidebarToggle && sidebar) {
                const isMobile = () => window.innerWidth <= mobileBreakpoint;
                const setExpanded = (expanded) => {
                    sidebarToggle.setAttribute('aria-expanded', expanded ? 'true' : 'false');
                };
                const closeMobileSidebar = () => {
                    document.body.classList.remove('sidebar-mobile-open');
                    sidebar.classList.remove('show');
                    sidebarOverlay?.classList.remove('show');
                    setExpanded(false);
                };

                setExpanded(!isMobile() && !document.body.classList.contains('sidebar-collapsed'));

                sidebarToggle.addEventListener('click', function() {
                    if (isMobile()) {
                        document.body.classList.remove('sidebar-collapsed');
                        const isOpen = document.body.classList.toggle('sidebar-mobile-open');
                        sidebar.classList.toggle('show', isOpen);
                        sidebarOverlay?.classList.toggle('show', isOpen);
                        setExpanded(isOpen);
                        return;
                    }

                    const isCollapsed = document.body.classList.toggle('sidebar-collapsed');
                    setExpanded(!isCollapsed);
                });
                
                // Close sidebar when a link is clicked
                sidebar.querySelectorAll('.nav-link').forEach(link => {
                    link.addEventListener('click', function() {
                        if (isMobile()) {
                            closeMobileSidebar();
                        }
                    });
                });

                sidebarOverlay?.addEventListener('click', closeMobileSidebar);
                
                // Handle window resize
                window.addEventListener('resize', function() {
                    if (!isMobile()) {
                        closeMobileSidebar();
                        setExpanded(!document.body.classList.contains('sidebar-collapsed'));
                    }
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
