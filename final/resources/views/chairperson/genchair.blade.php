<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --success-color: #4cc9f0;
            --warning-color: #f8961e;
            --danger-color: #f72585;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --border-radius: 12px;
            --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        body {
            background-color: #f8f9fa;
            overflow-x: hidden;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Sidebar Styles */
        :root {
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 80px;
            --sidebar-header-height: 80px;
            --sidebar-item-spacing: 8px;
            --sidebar-icon-size: 1.25rem;
        }

        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
            color: white;
            transition: var(--transition);
            z-index: 1000;
            box-shadow: var(--box-shadow);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .sidebar-header {
            height: var(--sidebar-header-height);
            padding: 0 25px;
            background-color: rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            justify-content: flex-start;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }

        .sidebar-header h3 {
            margin: 0;
            font-weight: 600;
            color: white;
            font-size: 1.25rem;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .sidebar-menu {
            padding: 20px 12px;
            list-style: none;
            flex-grow: 1;
        }

        .sidebar-menu li {
            position: relative;
            margin-bottom: var(--sidebar-item-spacing);
            border-radius: var(--border-radius);
            overflow: hidden;
            transition: var(--transition);
        }

        .sidebar-menu li a {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 14px 18px;
            font-weight: 500;
            transition: var(--transition);
            font-size: 0.95rem;
            letter-spacing: 0.3px;
        }

        .sidebar-menu li i {
            font-size: var(--sidebar-icon-size);
            margin-right: 16px;
            width: 24px;
            text-align: center;
            transition: var(--transition);
            opacity: 0.9;
        }

        .sidebar-menu li:hover {
            background-color: rgba(255, 255, 255, 0.08);
            transform: translateX(4px);
        }

        .sidebar-menu li:hover a {
            color: white;
        }

        .sidebar-menu li.active {
            background-color: rgba(255, 255, 255, 0.15);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }

        .sidebar-menu li.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background-color: var(--success-color);
            border-radius: 0 var(--border-radius) var(--border-radius) 0;
        }

        .sidebar-menu li.active a {
            color: white;
            font-weight: 600;
        }

        .sidebar-menu li.active i {
            opacity: 1;
            transform: scale(1.05);
        }

        /* Scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }
        }

        /* Collapsed State */
        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar.collapsed .sidebar-header {
            justify-content: center;
            padding: 0;
        }

        .sidebar.collapsed .sidebar-header h3,
        .sidebar.collapsed .sidebar-menu li a span {
            display: none;
        }

        .sidebar.collapsed .sidebar-menu li a {
            justify-content: center;
            padding: 14px 0;
        }

        .sidebar.collapsed .sidebar-menu li i {
            margin-right: 0;
            font-size: 1.4rem;
        }

        .sidebar.collapsed .sidebar-menu li:hover {
            transform: translateY(-3px) scale(1.05);
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.6);
        }

        /* Main Content Styles */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: all 0.3s;
        }

        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 20px;
        }

        .card-header {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
            padding: 15px 20px;
            font-weight: 600;
        }

        .stat-card {
            text-align: center;
            padding: 20px;
        }

        .stat-card i {
            font-size: 2rem;
            margin-bottom: 10px;
            color: var(--primary-color);
        }

        .stat-card .stat-value {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .stat-card .stat-label {
            color: #6c757d;
        }

        /* Task Styles */
        .task-item {
            padding: 15px;
            border-left: 4px solid var(--primary-color);
            margin-bottom: 10px;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .task-item.high-priority {
            border-left-color: var(--danger-color);
        }

        .task-item.medium-priority {
            border-left-color: var(--warning-color);
        }

        .task-item.low-priority {
            border-left-color: var(--success-color);
        }

        .task-meta {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .task-actions {
            margin-top: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Top Navigation */
        .top-nav {
            background-color: white;
            padding: 15px 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 999;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
        }

        .user-profile {
            display: flex;
            align-items: center;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        /* Notification Badge */
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--danger-color);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
        }

        /* Task Status Badges */
        .badge-pending {
            background-color: #6c757d;
            color: white;
        }

        .badge-in-progress {
            background-color: #17a2b8;
            color: white;
        }

        .badge-completed {
            background-color: #28a745;
            color: white;
        }

        /* Members Table Styles */
        .members-container {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 25px;
        }

        .members-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .members-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .members-table thead th {
            background-color: #f8f9fa;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #eee;
        }

        .members-table tbody td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        .members-table tbody tr:last-child td {
            border-bottom: none;
        }

        .members-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .member-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }

        .member-info {
            display: flex;
            align-items: center;
        }

        .status-active {
            color: #28a745;
            background-color: #e6f7ee;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }

        .status-inactive {
            color: #dc3545;
            background-color: #ffebee;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }

        .action-btn {
            padding: 5px 10px;
            border-radius: 5px;
            margin-right: 5px;
            transition: var(--transition);
        }

        .action-btn.edit {
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
        }

        .action-btn.delete {
            color: var(--danger-color);
            border: 1px solid var(--danger-color);
        }

        .action-btn.view {
            color: #6c757d;
            border: 1px solid #6c757d;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .add-member-btn {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 10px 25px;
            font-weight: 600;
            color: white;
            transition: var(--transition);
            border-radius: var(--border-radius);
        }

        .add-member-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .search-member {
            position: relative;
            width: 300px;
        }

        .search-member input {
            padding-left: 35px;
            border-radius: var(--border-radius);
        }

        .search-member i {
            position: absolute;
            left: 12px;
            top: 10px;
            color: #6c757d;
        }

        /* Modal Styles */
        .modal-content {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: var(--box-shadow);
        }

        .modal-header {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
        }

        .modal-footer {
            border-top: 1px solid #eee;
        }

        /* View Modal Styles */
        .member-avatar-lg {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #fff;
            box-shadow: 0 0.15rem 0.5rem rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }

        .member-detail-row {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .member-detail-row:last-child {
            border-bottom: none;
        }

        .member-detail-label {
            font-weight: 600;
            color: #6c757d;
            min-width: 150px;
            display: inline-block;
        }

        .member-detail-value {
            color: #495057;
        }

        /* Calendar Styles */
        #taskCalendar {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 20px;
        }

        .fc-event {
            cursor: pointer;
            border-radius: 4px;
            font-size: 0.85rem;
            padding: 2px 5px;
            transition: var(--transition);
        }

        .fc-event:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .fc-event-high-priority {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
        }

        .fc-event-medium-priority {
            background-color: var(--warning-color);
            border-color: var(--warning-color);
            color: #000;
        }

        .fc-event-low-priority {
            background-color: var(--success-color);
            border-color: var(--success-color);
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .sidebar {
                left: -280px;
            }

            .sidebar.active {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .main-content.active {
                margin-left: var(--sidebar-width);
            }

            .sidebar-collapse-btn {
                display: block !important;
            }

            .members-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .search-member {
                width: 100%;
                margin-top: 15px;
            }

            .members-table {
                display: block;
                overflow-x: auto;
            }

            .member-avatar-lg {
                width: 80px;
                height: 80px;
            }
        }

        .sidebar-collapse-btn {
            display: none;
            background: none;
            border: none;
            color: var(--primary-color);
            font-size: 1.5rem;
        }
    </style>
</head>

<body>
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: @json(session(key: 'success')),
                    confirmButtonColor: '#4361ee'
                });
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: @json(session(key: 'error')),
                    confirmButtonColor: '#f72585'
                });
            });
        </script>
    @endif

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <body>
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <img src="/image/logofulltask.png" alt="TaskNotify Logo" class="sidebar-logo"
                    style="max-width: 100%; height: auto; display: block;">
            </div>

            <ul class="sidebar-menu">
                <li class="{{ request()->routeIs('chairperson.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('chairperson.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
                </li>
                <li class="{{ request()->routeIs('chairperson.tasks') ? 'active' : '' }}">
                    <a href="{{ route('chairperson.tasks') }}"><i class="fas fa-tasks"></i> Tasks</a>
                </li>
                <li class="{{ request()->routeIs('chairassign.task') ? 'active' : '' }}">
                    <a href="{{ route('chairassign.task') }}"><i class="fas fa-tasks"></i> Assign Tasks</a>
                </li>
                <li class="{{ request()->routeIs('team.performance') ? 'active' : '' }}">
                    <a href="{{ route('team.performance') }}"><i class="fas fa-users"></i> Team</a>
                </li>
                <li class="{{ request()->routeIs('task.document.chairperson') ? 'active' : '' }}">
                    <a href="{{ route('task.document.chairperson') }}"><i class="fas fa-file-alt"></i> Documents</a>
                </li>
                <li class="{{ request()->routeIs('chairperson.setting') ? 'active' : '' }}">
                    <a href="{{ route('chairperson.setting') }}"><i class="fas fa-cog"></i> Setting</a>
                </li>
                <li>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="text-white text-decoration-none">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                    <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
        <div class="main-content" id="mainContent">
            <nav class="top-navbar navbar navbar-expand-lg navbar-light bg-white shadow-sm py-2 px-3 mb-4 sticky-top">
                <div class="container-fluid d-flex justify-content-between align-items-center p-0">
                    <!-- Left side - Toggle button and Brand -->
                    <div class="d-flex align-items-center">
                        <!-- Hamburger menu - only visible on mobile -->
                        <button class="sidebar-collapse-btn btn btn-link text-dark p-0 me-2 me-md-3 d-lg-none"
                            id="sidebarToggle">
                            <i class="fas fa-bars fs-4"></i>
                        </button>
                        <span class="navbar-brand fw-bold text-primary ms-1 ms-md-2" id="adminGreeting">Good
                            Morning</span>
                    </div>

                    <!-- Right side - Navigation and User Info -->
                    <div class="d-flex align-items-center">
                        <!-- Notification and User Profile -->
                        <div class="d-flex align-items-center ms-2 ms-lg-0">
                            <!-- Notification -->
                            <div class="dropdown position-relative me-2 me-lg-3">
                                <button class="btn btn-link text-dark p-0 position-relative dropdown-toggle"
                                    id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                                    aria-label="Notifications">
                                    <i class="fas fa-bell fs-5"></i>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                        id="notificationBadge">
                                        3
                                        <span class="visually-hidden">unread notifications</span>
                                    </span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end notification-dropdown p-0"
                                    aria-labelledby="notificationDropdown">
                                    <div
                                        class="d-flex justify-content-between align-items-center p-3 border-bottom bg-light">
                                        <h6 class="m-0 fw-bold">Notifications</h6>
                                        <div>
                                            <span class="badge bg-primary rounded-pill me-2"
                                                id="notificationCount">3</span>
                                            <button class="btn btn-sm btn-link text-muted p-0 mark-all-read"
                                                title="Mark all as read">
                                                <i class="fas fa-check-double"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="notification-list" style="max-height: 400px; overflow-y: auto;">
                                        <!-- Sample notification items -->
                                        <a href="#" class="dropdown-item d-flex py-3 px-3 notification-item unread">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="bg-primary bg-opacity-10 p-2 rounded-circle d-flex align-items-center justify-content-center"
                                                    style="width: 38px; height: 38px;">
                                                    <i class="fas fa-user-check text-primary"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-start mb-1">
                                                    <h6 class="mb-0 fw-semibold">New User Registered</h6>
                                                    <small class="text-muted">2 min ago</small>
                                                </div>
                                                <p class="mb-0 text-muted small">John Doe has registered as a new user.
                                                </p>
                                                <div class="mt-2">
                                                    <span
                                                        class="badge bg-primary bg-opacity-10 text-primary small fw-normal">Users</span>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="dropdown-item d-flex py-3 px-3 notification-item unread">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="bg-warning bg-opacity-10 p-2 rounded-circle d-flex align-items-center justify-content-center"
                                                    style="width: 38px; height: 38px;">
                                                    <i class="fas fa-exclamation-triangle text-warning"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-start mb-1">
                                                    <h6 class="mb-0 fw-semibold">Server Warning</h6>
                                                    <small class="text-muted">1 hour ago</small>
                                                </div>
                                                <p class="mb-0 text-muted small">Server CPU usage is high (85%). Please
                                                    check
                                                    immediately.</p>
                                                <div class="mt-2">
                                                    <span
                                                        class="badge bg-warning bg-opacity-10 text-warning small fw-normal">System</span>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="dropdown-item d-flex py-3 px-3 notification-item">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="bg-success bg-opacity-10 p-2 rounded-circle d-flex align-items-center justify-content-center"
                                                    style="width: 38px; height: 38px;">
                                                    <i class="fas fa-check-circle text-success"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-start mb-1">
                                                    <h6 class="mb-0 fw-semibold">Task Completed</h6>
                                                    <small class="text-muted">3 hours ago</small>
                                                </div>
                                                <p class="mb-0 text-muted small">Your scheduled backup was completed
                                                    successfully.</p>
                                                <div class="mt-2">
                                                    <span
                                                        class="badge bg-success bg-opacity-10 text-success small fw-normal">Backup</span>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="text-center py-3 bg-light border-top">
                                            <a href="#" class="text-primary fw-semibold small">View All
                                                Notifications</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- User Profile -->
                            <div class="d-flex align-items-center ms-2 ms-lg-3 border-start ps-2 ps-lg-3">
                                <img src="{{ Auth::user()->avatar_url ?? asset('storage/profile/avatars/profile.png') }}"
                                    alt="User Profile" class="rounded-circle me-2 border border-2 border-primary"
                                    width="40" height="40">
                                <div class="d-none d-md-inline">
                                    <div class="fw-bold text-dark">{{ ucwords(strtolower(Auth::user()->name)) }}</div>
                                    <div class="small text-muted">{{ Auth::user()->role->name }}</div>
                                </div>
                                <!-- Show only name on small screens -->
                                <div class="d-inline d-md-none">
                                    <div class="fw-bold text-dark">
                                        {{ explode(' ', ucwords(strtolower(Auth::user()->name)))[0] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            @yield('content')
        </div>



        <!-- Bootstrap 5 JS Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

        <script>
            // Toggle sidebar on mobile
            document.getElementById('sidebarToggle').addEventListener('click', function () {
                document.querySelector('.sidebar').classList.toggle('active');
                document.querySelector('.main-content').classList.toggle('active');
            });
        </script>
    </body>

</html>