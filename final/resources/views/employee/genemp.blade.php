<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('tittle')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4b6cb7;
            --secondary-color: #182848;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
            color: white;
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .sidebar-menu {
            padding: 0;
            list-style: none;
        }

        .sidebar-menu li {
            padding: 10px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s;
        }

        .sidebar-menu li:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar-menu li a {
            color: white;
            text-decoration: none;
            display: block;
        }

        .sidebar-menu li i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s;
        }

        /* Top Navigation */
        .top-nav {
            background-color: white;
            padding: 15px 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        /* Dashboard Cards */
        .dashboard-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
        }

        /* Task Calendar */
        #taskCalendar {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .fc-event {
            cursor: pointer;
            border-radius: 4px;
            font-size: 0.85rem;
            padding: 2px 5px;
        }

        .fc-event-high-priority {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .fc-event-medium-priority {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #000;
        }

        .fc-event-low-priority {
            background-color: #28a745;
            border-color: #28a745;
        }

        /* Task Modal */
        .task-modal .modal-header {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
        }

        .priority-badge {
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .priority-high {
            background-color: #ffebee;
            color: #d32f2f;
        }

        .priority-medium {
            background-color: #fff8e1;
            color: #ffa000;
        }

        .priority-low {
            background-color: #e8f5e9;
            color: #388e3c;
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .sidebar {
                left: -250px;
            }

            .sidebar.active {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .main-content.active {
                margin-left: 250px;
            }
        }

        :root {
            --primary-color: #4b6cb7;
            --secondary-color: #182848;
            --accent-color: #6c5ce7;
            --light-bg: #f8f9fa;
            --dark-text: #2d3436;
            --success-color: #00b894;
            --warning-color: #fdcb6e;
            --danger-color: #d63031;
        }

        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--dark-text);
        }

        /* Glassmorphism Effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.18);
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            transition: all 0.3s;
            z-index: 1000;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 25px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header h4 {
            font-weight: 600;
            margin-bottom: 0;
        }

        .sidebar-menu {
            padding: 0;
            list-style: none;
        }

        .sidebar-menu li {
            padding: 12px 25px;
            transition: all 0.3s;
        }

        .sidebar-menu li:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar-menu li.active {
            background-color: rgba(255, 255, 255, 0.2);
            border-left: 4px solid white;
        }

        .sidebar-menu li a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .sidebar-menu li i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: 280px;
            padding: 30px;
            transition: all 0.3s;
            min-height: 100vh;
        }

        /* Top Navigation */
        .top-nav {
            background-color: white;
            padding: 18px 30px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 999;
            border-radius: 12px;
            margin-bottom: 30px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            background: rgba(75, 108, 183, 0.1);
            padding: 8px 15px;
            border-radius: 50px;
            transition: all 0.3s;
        }

        .user-profile:hover {
            background: rgba(75, 108, 183, 0.2);
        }

        .user-profile img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
            border: 2px solid rgba(255, 255, 255, 0.5);
        }

        .user-profile span {
            font-weight: 500;
        }

        /* Task List Styles */
        .task-card {
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            overflow: hidden;
        }

        .task-card:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
        }

        .task-card.high-priority:before {
            background-color: var(--danger-color);
        }

        .task-card.medium-priority:before {
            background-color: var(--warning-color);
        }

        .task-card.low-priority:before {
            background-color: var(--success-color);
        }

        .task-card.completed {
            opacity: 0.7;
        }

        .task-card.completed .task-title {
            text-decoration: line-through;
        }

        .task-card.completed .task-badge {
            background-color: var(--success-color) !important;
            color: white !important;
        }

        .task-title {
            font-weight: 600;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }

        .task-meta {
            font-size: 0.85rem;
            color: #6c757d;
            margin-bottom: 10px;
        }

        .task-description {
            color: #555;
            margin-bottom: 15px;
        }

        .task-badge {
            padding: 4px 10px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }

        .task-actions {
            display: flex;
            gap: 10px;
        }

        .task-actions .btn {
            padding: 5px 12px;
            font-size: 0.85rem;
            border-radius: 8px;
        }

        /* Progress Bar */
        .task-progress {
            height: 6px;
            border-radius: 3px;
            background-color: #e9ecef;
            margin-bottom: 15px;
            overflow: hidden;
        }

        .task-progress-bar {
            height: 100%;
            transition: width 0.6s ease;
        }

        /* Filter Controls */
        .filter-controls {
            background-color: white;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .empty-state i {
            font-size: 3rem;
            color: #adb5bd;
            margin-bottom: 15px;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-color);
        }

        /* Responsive Adjustments */
        @media (max-width: 1200px) {
            .sidebar {
                width: 240px;
            }

            .main-content {
                margin-left: 240px;
            }
        }

        @media (max-width: 992px) {
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
                margin-left: 280px;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 20px;
            }

            .top-nav {
                padding: 15px;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h4><i class="fas fa-tasks me-2"></i>TaskNotify</h4>
        </div>
        <ul class="sidebar-menu">
            <li>
                <a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            </li>
            <li >
                <a href="#"><i class="fas fa-calendar"></i> Task Calendar</a>
            </li>
            <li class="active">
                <a href="#"><i class="fas fa-tasks"></i> My Tasks</a>
            </li>
            <li>
                <a href="#"><i class="fas fa-clock"></i> Time Tracking</a>
            </li>
            <li>
                <a href="#"><i class="fas fa-file-alt"></i> Reports</a>
            </li>
            <li>
                <a href="#"><i class="fas fa-cog"></i> Settings</a>
            </li>
            <li>
                <a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
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


</body>

</html>