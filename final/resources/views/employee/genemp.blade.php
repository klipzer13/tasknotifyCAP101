<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Other meta tags -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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

        /* Task Container Styles */
        .tasks-container {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 30px;
            margin-bottom: 30px;
            border: none;
        }

        .section-header {
            margin-bottom: 25px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-header h4 {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
        }

        .section-header h4 i {
            margin-right: 10px;
        }

        /* Task Tabs */
        .task-tabs {
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 20px;
        }

        .task-tabs .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 600;
            padding: 12px 20px;
            border-radius: 8px 8px 0 0;
            margin-right: 5px;
            transition: var(--transition);
        }

        .task-tabs .nav-link:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }

        .task-tabs .nav-link.active {
            color: var(--primary-color);
            background-color: rgba(67, 97, 238, 0.1);
            border-bottom: 3px solid var(--primary-color);
        }

        /* Task Cards */
        .task-card {
            border-radius: var(--border-radius);
            border: 1px solid #eee;
            margin-bottom: 15px;
            transition: var(--transition);
            background-color: white;
        }

        .task-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--box-shadow);
        }

        .task-card-header {
            background-color: #f8f9fa;
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .task-card-body {
            padding: 20px;
        }

        .task-title {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 5px;
        }

        .task-meta {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            font-size: 0.85rem;
            color: #7f8c8d;
            flex-wrap: wrap;
        }

        .task-meta span {
            margin-right: 15px;
            display: flex;
            align-items: center;
        }

        .task-meta i {
            margin-right: 5px;
            font-size: 0.9rem;
        }

        .task-description {
            color: #495057;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .task-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 15px;
            gap: 10px;
        }

        /* Priority and Status Badges */
        .priority-badge,
        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 10px;
        }

        .priority-high {
            background-color: rgba(247, 37, 133, 0.1);
            color: var(--danger-color);
        }

        .priority-medium {
            background-color: rgba(248, 150, 30, 0.1);
            color: var(--warning-color);
        }

        .priority-low {
            background-color: rgba(76, 201, 240, 0.1);
            color: var(--success-color);
        }

        .status-pending {
            background-color: rgba(108, 117, 125, 0.1);
            color: #6c757d;
        }

        .status-pending-approval {
            background-color: rgba(255, 152, 0, 0.1);
            color: #ff9800;
        }

        .status-in-progress {
            background-color: rgba(23, 162, 184, 0.1);
            color: #17a2b8;
        }

        .status-completed {
            background-color: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .status-rejected,
        .status-overdue {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }

        .empty-state i {
            font-size: 3rem;
            color: #dee2e6;
            margin-bottom: 15px;
        }

        .empty-state h5 {
            color: #6c757d;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #adb5bd;
            max-width: 400px;
            margin: 0 auto;
        }

        /* Notification Toast */
        .notification-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            min-width: 300px;
        }

        /* Modal Styles */
        .task-modal .modal-dialog {
            max-width: 800px;
        }

        .task-modal .modal-content {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: var(--box-shadow);
        }

        .task-modal .modal-header {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            border-bottom: none;
            padding: 1.5rem;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
        }

        .task-modal .modal-title {
            font-weight: 600;
        }

        .task-modal .modal-body {
            padding: 2rem;
        }

        .task-modal .modal-footer {
            border-top: none;
            background-color: #f8f9fa;
            padding: 1rem 2rem;
            border-radius: 0 0 var(--border-radius) var(--border-radius);
        }

        .task-modal .badge {
            font-size: 0.75rem;
            font-weight: 500;
            padding: 0.35em 0.65em;
        }

        .task-modal .section-title {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6c757d;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .task-modal .description-box {
            background-color: #f8f9fa;
            border-radius: var(--border-radius);
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .task-modal .comment-section {
            max-height: 300px;
            overflow-y: auto;
            background-color: #f8f9fa;
            border-radius: var(--border-radius);
            padding: 1rem;
        }

        .task-modal .comment-item {
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 1rem;
            margin-bottom: 1rem;
        }

        .task-modal .comment-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .task-modal .comment-user {
            font-weight: 600;
            color: #212529;
        }

        .task-modal .comment-time {
            font-size: 0.75rem;
            color: #6c757d;
        }

        .task-modal .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 0.75rem;
        }

        .task-modal .attachment-thumbnail {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 10px;
            margin-bottom: 10px;
            border: 1px solid #dee2e6;
            transition: var(--transition);
        }

        .task-modal .attachment-thumbnail:hover {
            transform: scale(1.05);
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

            .section-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .task-tabs .nav-link {
                padding: 8px 12px;
                font-size: 0.85rem;
            }

            .task-meta span {
                margin-right: 8px;
                margin-bottom: 5px;
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
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="/image/logofulltask.png" alt="TaskNotify Logo" class="sidebar-logo"
                style="max-width: 100%; height: auto; display: block;">
        </div>

        <ul class="sidebar-menu">
            <li class="{{ request()->routeIs('employee.dashboard') ? 'active' : '' }}">
                <a href="{{ route('employee.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
            </li>
            <li class="{{ request()->routeIs('employee.calendar') ? 'active' : '' }}">
                <a href="{{ route('employee.calendar') }}"><i class="fas fa-calendar"></i> Task Calendar</a>
            </li>
            <li class="{{ request()->routeIs('employee.tasks') ? 'active' : '' }}">
                <a href="{{ route('employee.tasks') }}"><i class="fas fa-tasks"></i> My Tasks</a>
            </li>
            <li class="{{ request()->routeIs('employee.setting') ? 'active' : '' }}">
                <a href="{{ route('employee.setting') }}"><i class="fas fa-cog"></i> Setting</a>
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

    @yield('content')

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <!-- jQuery (needed for FullCalendar) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            document.querySelector('.sidebar').classList.toggle('active');
            document.querySelector('.main-content').classList.toggle('active');
        });
    </script>
</body>

</html>