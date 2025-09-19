@extends('employee.genemp')
@section('title', 'My Tasks')

@section('content')
    <style>
        .tasks-container {
            background-color: white;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
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
        }

        .task-tabs .nav-link.active {
            color: var(--primary-color);
            background-color: rgba(67, 97, 238, 0.1);
            border-bottom: 3px solid var(--primary-color);
        }

        .task-card {
            border-radius: 12px;
            border: 1px solid #eee;
            margin-bottom: 15px;
            transition: all 0.3s;
        }

        .task-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .task-card-header {
            background-color: #f8f9fa;
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            border-radius: 12px 12px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .task-card-body {
            padding: 20px;
        }

        .task-title {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .task-meta {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            font-size: 0.85rem;
            color: #7f8c8d;
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
        }

        .priority-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 10px;
        }

        .priority-high {
            background-color: #ffebee;
            color: #ff6b6b;
        }

        .priority-medium {
            background-color: #fff8e1;
            color: #ffb74d;
        }

        .priority-low {
            background-color: #e8f5e9;
            color: #4caf50;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-pending {
            background-color: #e3f2fd;
            color: #1976d2;
        }

        .status-pending-approval {
            background-color: #e8f5e9;
            color: #ff9800;
        }

        .status-in-progress {
            background-color: #fff3e0;
            color: #fb8c00;
        }

        .status-completed {
            background-color: #e8f5e9;
            color: #4caf50;
        }

        .status-rejected {
            background-color: #ffebee;
            color: #f44336;
        }

        .status-overdue {
            background-color: #ffebee;
            color: #f44336;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
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

        .notification-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            min-width: 300px;
        }

        /* Improved Modal Styles */
        .task-modal .modal-dialog {
            max-width: 800px;
        }

        .task-modal .modal-header {
            background-color: var(--primary-color);
            color: white;
            border-bottom: none;
            padding: 1.5rem;
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
            border-radius: 8px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .task-modal .comment-section {
            max-height: 300px;
            overflow-y: auto;
            background-color: #f8f9fa;
            border-radius: 8px;
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
            transition: transform 0.2s;
        }

        .task-modal .attachment-thumbnail:hover {
            transform: scale(1.05);
        }

        .task-modal .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .task-modal .btn-submit {
            padding: 0.5rem 1.5rem;
            font-weight: 500;
        }

        .top-navbar {
            transition: all 0.3s ease;
        }

        .nav-link {
            transition: color 0.2s;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
        }

        .nav-link:hover {
            color: #0d6efd !important;
            background-color: rgba(13, 110, 253, 0.1);
        }

        .nav-link.active {
            color: #0d6efd !important;
            font-weight: 500;
        }

        .sidebar-collapse-btn:hover {
            transform: scale(1.1);
        }

        /* Notification dropdown styles */
        .notification-dropdown {
            width: 380px;
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .notification-item {
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .notification-item:hover {
            background-color: #f8f9fa;
        }

        .notification-item.unread {
            background-color: #f8faff;
            border-left-color: #0d6efd;
        }

        .notification-item .flex-shrink-0 {
            flex: 0 0 38px;
        }

        .notification-list {
            scrollbar-width: thin;
            scrollbar-color: #dee2e6 #f8f9fa;
        }

        .notification-list::-webkit-scrollbar {
            width: 6px;
        }

        .notification-list::-webkit-scrollbar-track {
            background: #f8f9fa;
        }

        .notification-list::-webkit-scrollbar-thumb {
            background-color: #dee2e6;
            border-radius: 3px;
        }

        .mark-all-read:hover {
            color: #0d6efd !important;
        }

        /* Mobile specific styles */
        @media (max-width: 575.98px) {
            .top-navbar {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }

            .navbar-brand {
                font-size: 1rem;
            }

            .border-start {
                border-left: none !important;
            }

            .notification-dropdown {
                width: 300px;
                margin-right: -50px;
            }
        }

        .required-doc-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .required-doc-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
        }

        #toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        .toast {
            background-color: #4361ee !important;
        }

        .toast.success {
            background-color: #28a745 !important;
        }

        .toast.error {
            background-color: #dc3545 !important;
        }

        /* Document status specific styles */
        .document-approved {
            border-left: 4px solid #28a745 !important;
        }

        .document-rejected {
            border-left: 4px solid #dc3545 !important;
        }

        .document-pending {
            border-left: 4px solid #ffc107 !important;
        }

        .document-status-badge {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
        }

        .rejection-reason {
            background-color: #f8d7da;
            border-left: 3px solid #dc3545;
            padding: 0.5rem;
            border-radius: 0.25rem;
            margin-top: 0.5rem;
        }
    </style>


    <div class="main-content" id="mainContent">
        <!-- Top Navigation -->
        <nav class="top-navbar navbar navbar-expand-lg navbar-light bg-white shadow-sm py-2 px-3 mb-4 sticky-top">
            <div class="container-fluid d-flex justify-content-between align-items-center p-0">
                <!-- Left side - Toggle button and Brand -->
                <div class="d-flex align-items-center">
                    <!-- Hamburger menu - only visible on mobile -->
                    <button class="sidebar-collapse-btn btn btn-link text-dark p-0 me-2 me-md-3 d-lg-none"
                        id="sidebarToggle">
                        <i class="fas fa-bars fs-4"></i>
                    </button>
                    <span class="navbar-brand fw-bold text-primary ms-1 ms-md-2" id="adminGreeting">Good Morning</span>
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
                                <div class="d-flex justify-content-between align-items-center p-3 border-bottom bg-light">
                                    <h6 class="m-0 fw-bold">Notifications</h6>
                                    <div>
                                        <span class="badge bg-primary rounded-pill me-2" id="notificationCount">3</span>
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
                                            <p class="mb-0 text-muted small">John Doe has registered as a new user.</p>
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
                                            <p class="mb-0 text-muted small">Server CPU usage is high (85%). Please check
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
                                        <a href="#" class="text-primary fw-semibold small">View All Notifications</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- User Profile -->
                        <div class="d-flex align-items-center ms-2 ms-lg-3 border-start ps-2 ps-lg-3">
                            <img src="{{ Auth::user()->avatar_url ?? asset('storage/profile/avatars/profile.png') }}"
                                alt="User Profile" class="rounded-circle me-2 border border-2 border-primary" width="40"
                                height="40">
                            <div class="d-none d-md-inline">
                                <div class="fw-bold text-dark">{{ ucwords(strtolower(Auth::user()->name)) }}</div>
                                <div class="small text-muted">Employee</div>
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
        <script>
            // Function to update greeting based on time of day
            function updateGreeting() {
                const greetingElement = document.getElementById('adminGreeting');
                const hour = new Date().getHours();
                let greeting;

                if (hour < 12) {
                    greeting = 'Good Morning';
                } else if (hour < 18) {
                    greeting = 'Good Afternoon';
                } else {
                    greeting = 'Good Evening';
                }

                greetingElement.textContent = `${greeting}`;
            }

            // Update greeting on page load and resize
            document.addEventListener('DOMContentLoaded', function () {
                updateGreeting();

                // Notification functionality
                const notificationDropdown = document.getElementById('notificationDropdown');
                const notificationBadge = document.getElementById('notificationBadge');
                const notificationCount = document.getElementById('notificationCount');
                const markAllReadBtn = document.querySelector('.mark-all-read');

                // Mark notifications as read when dropdown is shown
                notificationDropdown.addEventListener('shown.bs.dropdown', function () {
                    // Only mark as read if there are unread notifications
                    if (parseInt(notificationBadge.textContent) > 0) {
                        document.querySelectorAll('.notification-item.unread').forEach(item => {
                            item.classList.remove('unread');
                            item.style.borderLeftColor = 'transparent';
                            item.style.backgroundColor = '';
                        });

                        // Update badge count to 0
                        notificationBadge.textContent = '0';
                        notificationCount.textContent = '0';
                    }
                });

                // Mark all as read button
                markAllReadBtn.addEventListener('click', function (e) {
                    e.stopPropagation();

                    document.querySelectorAll('.notification-item.unread').forEach(item => {
                        item.classList.remove('unread');
                        item.style.borderLeftColor = 'transparent';
                        item.style.backgroundColor = '';
                    });

                    // Update badge count to 0
                    notificationBadge.textContent = '0';
                    notificationCount.textContent = '0';
                });

                // Sample function to add a new notification
                function addNotification(title, message, type = 'info', category = 'General') {
                    const icons = {
                        'info': 'fa-info-circle',
                        'warning': 'fa-exclamation-triangle',
                        'success': 'fa-check-circle',
                        'danger': 'fa-exclamation-circle',
                        'user': 'fa-user'
                    };

                    const colors = {
                        'info': 'primary',
                        'warning': 'warning',
                        'success': 'success',
                        'danger': 'danger',
                        'user': 'info'
                    };

                    const notificationList = document.querySelector('.notification-list');
                    const newNotification = document.createElement('a');
                    newNotification.href = '#';
                    newNotification.className = 'dropdown-item d-flex py-3 px-3 notification-item unread';
                    newNotification.innerHTML = `
                                        <div class="flex-shrink-0 me-3">
                                            <div class="bg-${colors[type]} bg-opacity-10 p-2 rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                                <i class="fas ${icons[type]} text-${colors[type]}"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start mb-1">
                                                <h6 class="mb-0 fw-semibold">${title}</h6>
                                                <small class="text-muted">just now</small>
                                            </div>
                                            <p class="mb-0 text-muted small">${message}</p>
                                            <div class="mt-2">
                                                <span class="badge bg-${colors[type]} bg-opacity-10 text-${colors[type]} small fw-normal">${category}</span>
                                            </div>
                                        </div>
                                    `;

                    // Insert at the top of the list (before the "View All" link)
                    const viewAllLink = notificationList.querySelector('.bg-light.border-top');
                    notificationList.insertBefore(newNotification, viewAllLink);

                    // Update badge count
                    const currentCount = parseInt(notificationBadge.textContent) || 0;
                    notificationBadge.textContent = currentCount + 1;
                    notificationCount.textContent = currentCount + 1;

                    // Add animation for new notification
                    newNotification.style.opacity = '0';
                    newNotification.style.transform = 'translateY(-10px)';
                    newNotification.style.transition = 'all 0.3s ease';

                    setTimeout(() => {
                        newNotification.style.opacity = '1';
                        newNotification.style.transform = 'translateY(0)';
                    }, 10);
                }

                // Example: Add a new notification after 5 seconds
                // setTimeout(() => {
                //     addNotification('System Update', 'A new system update is available for installation.', 'info', 'System');
                // }, 5000);
            });

            // Optional: Update greeting every minute in case page stays open for long
            setInterval(updateGreeting, 60000);
        </script>
        <!-- Tasks Content -->
        <div class="tasks-container">

            <div class="section-header">
                <h4><i class="fas fa-tasks"></i> My Tasks</h4>
                <div>
                    <select class="form-select form-select-sm me-2" id="sortSelect"
                        style="width: auto; display: inline-block;">
                        <option value="due_date">Sort by Due Date</option>
                        <option value="priority">Sort by Priority</option>
                        <option value="status">Sort by Status</option>
                    </select>
                    <button class="btn btn-sm btn-outline-primary" id="filterBtn">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                </div>
            </div>

            <ul class="nav nav-tabs task-tabs" id="taskTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-tasks-tab" data-bs-toggle="tab" data-bs-target="#all-tasks"
                        type="button" role="tab">
                        <i class="fas fa-list-check me-2"></i>
                        <span>All Tasks</span>
                        <span class="task-count-badge bg-primary-soft ms-2">{{ $tasks->count() }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="active-tasks-tab" data-bs-toggle="tab" data-bs-target="#active-tasks"
                        type="button" role="tab">
                        <i class="fas fa-clock me-2"></i>
                        <span>Current Task</span>
                        <span class="task-count-badge bg-primary-soft ms-2">
                            {{ $tasks->filter(function ($task) use ($statuses) {
        $userStatus = $task->users->firstWhere('id', Auth::id())->pivot->status_id;
        $status = $statuses->firstWhere('id', $userStatus);
        return in_array($status->name, ['pending', 'in_progress', 'rejected']);
    })->count() }}
                        </span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending-tasks"
                        type="button" role="tab">
                        <i class="fas fa-hourglass-half me-2"></i>
                        <span>Pending Approval</span>
                        <span class="task-count-badge bg-primary-soft ms-2">
                            {{ $tasks->filter(function ($task) use ($statuses) {
        $userStatus = $task->users->firstWhere('id', Auth::id())->pivot->status_id;
        $status = $statuses->firstWhere('id', $userStatus);
        return $status->name == 'pending_approval';
    })->count() }}
                        </span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed-tasks"
                        type="button" role="tab">
                        <i class="fas fa-check-circle me-2"></i>
                        <span>Completed</span>
                        <span class="task-count-badge bg-primary-soft ms-2">
                            {{ $tasks->filter(function ($task) use ($statuses) {
        $userStatus = $task->users->firstWhere('id', Auth::id())->pivot->status_id;
        $status = $statuses->firstWhere('id', $userStatus);
        return $status->name == 'completed';
    })->count() }}
                        </span>
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="taskTabsContent">
                <!-- All Tasks Tab -->
                <div class="tab-pane fade show active" id="all-tasks" role="tabpanel">
                    @if($tasks->count() > 0)
                        @foreach($tasks as $task)
                            @php
                                $userStatus = $task->users->firstWhere('id', Auth::id())->pivot->status_id;
                                $status = $statuses->firstWhere('id', $userStatus);
                            @endphp
                            <div class="task-card" data-task-id="{{ $task->id }}"
                                data-due-date="{{ $task->due_date->format('Y-m-d') }}"
                                data-priority="{{ $task->priority ? $task->priority->name : '' }}"
                                data-status="{{ $status->name }}">
                                <div class="task-card-header">
                                    <div>
                                        <span class="task-title">{{ $task->title }}</span>
                                        @if($task->priority)
                                            <span class="priority-badge priority-{{ strtolower($task->priority->name) }}">
                                                {{ $task->priority->name }} Priority
                                            </span>
                                        @endif
                                    </div>
                                    <span class="status-badge status-{{ str_replace(' ', '-', strtolower($status->name)) }}">
                                        {{ $status->name }}
                                    </span>
                                </div>
                                <div class="task-card-body">
                                    <div class="task-meta">
                                        <span><i class="fas fa-calendar-alt"></i> Due:
                                            {{ $task->due_date->format('M d, Y') }}</span>
                                        <span><i class="fas fa-user"></i> Assigned by: {{ $task->creator->name }}</span>
                                    </div>
                                    <p class="task-description">
                                        {{ $task->description }}
                                    </p>
                                    <div class="task-actions">
                                        <button class="btn btn-sm btn-outline-primary view-task-btn" data-task-id="{{ $task->id }}">
                                            <i class="fas fa-eye me-1"></i> View Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                            <h5>No Tasks Assigned</h5>
                            <p>You currently have no tasks assigned to you.</p>
                        </div>
                    @endif
                </div>

                <!-- Active Tasks Tab (pending, In Progress, rejected) -->
                <div class="tab-pane fade" id="active-tasks" role="tabpanel">
                    @php
                        $activeTasksExist = false;
                        foreach ($tasks as $task) {
                            $userStatus = $task->users->firstWhere('id', Auth::id())->pivot->status_id;
                            $status = $statuses->firstWhere('id', $userStatus);
                            if (in_array($status->name, ['pending', 'in_progress', 'rejected'])) {
                                $activeTasksExist = true;
                                break;
                            }
                        }
                    @endphp

                    @if($activeTasksExist)
                        @foreach($tasks as $task)
                            @php
                                $userStatus = $task->users->firstWhere('id', Auth::id())->pivot->status_id;
                                $status = $statuses->firstWhere('id', $userStatus);
                            @endphp
                            @if(in_array($status->name, ['pending', 'in_progress', 'rejected']))
                                <div class="task-card" data-task-id="{{ $task->id }}"
                                    data-due-date="{{ $task->due_date->format('Y-m-d') }}"
                                    data-priority="{{ $task->priority ? $task->priority->name : '' }}"
                                    data-status="{{ $status->name }}">
                                    <div class="task-card-header">
                                        <div>
                                            <span class="task-title">{{ $task->title }}</span>
                                            @if($task->priority)
                                                <span class="priority-badge priority-{{ strtolower($task->priority->name) }}">
                                                    {{ $task->priority->name }} Priority
                                                </span>
                                            @endif
                                        </div>
                                        <span class="status-badge status-{{ str_replace(' ', '-', strtolower($status->name)) }}">
                                            {{ $status->name }}
                                        </span>
                                    </div>
                                    <div class="task-card-body">
                                        <div class="task-meta">
                                            <span><i class="fas fa-calendar-alt"></i> Due:
                                                {{ $task->due_date->format('M d, Y') }}</span>
                                            <span><i class="fas fa-user"></i> Assigned by: {{ $task->creator->name }}</span>
                                        </div>
                                        <p class="task-description">
                                            {{ $task->description }}
                                        </p>
                                        <div class="task-actions">
                                            <button class="btn btn-sm btn-outline-primary view-task-btn" data-task-id="{{ $task->id }}">
                                                <i class="fas fa-eye me-1"></i> View Details
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="empty-state">
                            <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                            <h5>No Active Tasks</h5>
                            <p>You currently have no active tasks.</p>
                        </div>
                    @endif
                </div>

                <!-- Pending Approval Tasks Tab -->
                <div class="tab-pane fade" id="pending-tasks" role="tabpanel">
                    @php
                        $pendingTasksExist = false;
                        foreach ($tasks as $task) {
                            $userStatus = $task->users->firstWhere('id', Auth::id())->pivot->status_id;
                            $status = $statuses->firstWhere('id', $userStatus);
                            if ($status->name == 'pending_approval') {
                                $pendingTasksExist = true;
                                break;
                            }
                        }
                    @endphp

                    @if($pendingTasksExist)
                        @foreach($tasks as $task)
                            @php
                                $userStatus = $task->users->firstWhere('id', Auth::id())->pivot->status_id;
                                $status = $statuses->firstWhere('id', $userStatus);
                            @endphp
                            @if($status->name == 'pending_approval')
                                <div class="task-card" data-task-id="{{ $task->id }}"
                                    data-due-date="{{ $task->due_date->format('Y-m-d') }}"
                                    data-priority="{{ $task->priority ? $task->priority->name : '' }}"
                                    data-status="{{ $status->name }}">
                                    <div class="task-card-header">
                                        <div>
                                            <span class="task-title">{{ $task->title }}</span>
                                            @if($task->priority)
                                                <span class="priority-badge priority-{{ strtolower($task->priority->name) }}">
                                                    {{ $task->priority->name }} Priority
                                                </span>
                                            @endif
                                        </div>
                                        <span class="status-badge status-{{ str_replace(' ', '-', strtolower($status->name)) }}">
                                            {{ $status->name }}
                                        </span>
                                    </div>
                                    <div class="task-card-body">
                                        <div class="task-meta">
                                            <span><i class="fas fa-calendar-alt"></i> Due:
                                                {{ $task->due_date->format('M d, Y') }}</span>
                                            <span><i class="fas fa-user"></i> Assigned by: {{ $task->creator->name }}</span>
                                        </div>
                                        <p class="task-description">
                                            {{ $task->description }}
                                        </p>
                                        <div class="task-actions">
                                            <button class="btn btn-sm btn-outline-primary view-task-btn" data-task-id="{{ $task->id }}">
                                                <i class="fas fa-eye me-1"></i> View Details
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="empty-state">
                            <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                            <h5>No Pending Approval Tasks</h5>
                            <p>You don't have any tasks waiting for approval.</p>
                        </div>
                    @endif
                </div>

                <!-- Completed Tasks Tab -->
                <div class="tab-pane fade" id="completed-tasks" role="tabpanel">
                    @php
                        $completedTasksExist = false;
                        foreach ($tasks as $task) {
                            $userStatus = $task->users->firstWhere('id', Auth::id())->pivot->status_id;
                            $status = $statuses->firstWhere('id', $userStatus);
                            if ($status->name == 'completed') {
                                $completedTasksExist = true;
                                break;
                            }
                        }
                    @endphp

                    @if($completedTasksExist)
                        @foreach($tasks as $task)
                            @php
                                $userStatus = $task->users->firstWhere('id', Auth::id())->pivot->status_id;
                                $status = $statuses->firstWhere('id', $userStatus);
                            @endphp
                            @if($status->name == 'completed')
                                <div class="task-card" data-task-id="{{ $task->id }}"
                                    data-due-date="{{ $task->due_date->format('Y-m-d') }}"
                                    data-priority="{{ $task->priority ? $task->priority->name : '' }}"
                                    data-status="{{ $status->name }}">
                                    <div class="task-card-header">
                                        <div>
                                            <span class="task-title">{{ $task->title }}</span>
                                            @if($task->priority)
                                                <span class="priority-badge priority-{{ strtolower($task->priority->name) }}">
                                                    {{ $task->priority->name }} Priority
                                                </span>
                                            @endif
                                        </div>
                                        <span class="status-badge status-{{ str_replace(' ', '-', strtolower($status->name)) }}">
                                            {{ $status->name }}
                                        </span>
                                    </div>
                                    <div class="task-card-body">
                                        <div class="task-meta">
                                            <span><i class="fas fa-calendar-alt"></i> Due:
                                                {{ $task->due_date->format('M d, Y') }}</span>
                                            <span><i class="fas fa-user"></i> Assigned by: {{ $task->creator->name }}</span>
                                        </div>
                                        <p class="task-description">
                                            {{ $task->description }}
                                        </p>
                                        <div class="task-actions">
                                            <button class="btn btn-sm btn-outline-primary view-task-btn" data-task-id="{{ $task->id }}">
                                                <i class="fas fa-eye me-1"></i> View Details
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="empty-state">
                            <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                            <h5>No Completed Tasks</h5>
                            <p>You don't have any completed tasks yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Task View Modal -->
    <div class="modal fade task-modal" id="taskViewModal" tabindex="-1" aria-labelledby="taskViewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fs-5" id="taskViewModalLabel">Task Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="task-loading-indicator" class="text-center py-5">
                        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-3 text-muted">Loading task details...</p>
                    </div>

                    <div id="task-details-container" style="display: none;">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <h4 id="task-modal-title" class="fw-bold mb-2"></h4>
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <span id="task-modal-status" class="badge rounded-pill"></span>
                                    <span id="task-modal-priority" class="badge rounded-pill"></span>
                                    <span id="task-modal-due-date" class="text-muted small"></span>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <span class="text-muted small">Assigned by:</span>
                                    <span id="task-modal-creator" class="fw-semibold"></span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="text-muted small">Assigned on:</span>
                                    <span id="task-modal-created-at" class="fw-semibold"></span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3 text-uppercase small text-muted">Description</h6>
                            <div id="task-modal-description" class="p-3 bg-light rounded"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <h6 class="fw-semibold mb-3 text-uppercase small text-muted">Attachments</h6>
                                <div id="task-modal-attachments" class="d-flex flex-wrap gap-3">
                                    <div class="text-center py-3 w-100">
                                        <p class="text-muted">No attachments available</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <h6 class="fw-semibold mb-3 text-uppercase small text-muted">Comments</h6>
                                <div id="task-modal-comments" class="comment-section bg-light rounded p-3">
                                    <div class="text-center py-2">
                                        <p class="text-muted">No comments yet</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Required Documents Section -->
                        <div id="required-documents-container" class="mb-4" style="display: none;">
                            <h6 class="fw-semibold mb-3 text-uppercase small text-muted border-bottom pb-2">Required
                                Documents</h6>
                            <div id="required-documents-list" class="row"></div>
                        </div>

                        <div id="task-submission-form-container">
                            <form id="taskSubmissionForm" action="/tasks/submit" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="task_id" id="submission_task_id">

                                <button type="submit" class="btn btn-primary px-4 py-2" id="submitTaskBtn">
                                    <i class="fas fa-paper-plane me-2"></i> Submit Task
                                </button>
                            </form>
                        </div>
                    </div>

                    <div id="task-error-container" class="d-flex align-items-center p-3 bg-light rounded"
                        style="display: none;">
                        <i class="fas fa-exclamation-circle me-3 fs-4 text-danger"></i>
                        <div>
                            <p class="mb-1" id="task-error-message">Failed to load task details.</p>
                            <div class="mt-2">
                                <button id="task-error-retry" class="btn btn-sm btn-outline-primary">Retry</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Task view modal functionality
            const viewTaskButtons = document.querySelectorAll('.view-task-btn');
            const taskViewModal = new bootstrap.Modal(document.getElementById('taskViewModal'));

            viewTaskButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const taskId = this.getAttribute('data-task-id');
                    showTaskLoadingState();
                    loadTaskDetails(taskId);
                    document.getElementById('submission_task_id').value = taskId;
                    taskViewModal.show();
                });
            });

            // Retry button event listener
            document.getElementById('task-error-retry').addEventListener('click', function () {
                const taskId = document.getElementById('submission_task_id').value;
                showTaskLoadingState();
                loadTaskDetails(taskId);
            });

            // Form submission handling
            document.getElementById('taskSubmissionForm').addEventListener('submit', function (e) {
                e.preventDefault();
                submitTaskForm();
            });
        });

        function showTaskLoadingState() {
            document.getElementById('task-loading-indicator').style.display = 'block';
            document.getElementById('task-details-container').style.display = 'none';
            document.getElementById('task-error-container').style.display = 'none';
        }

        function showTaskDetails() {
            document.getElementById('task-loading-indicator').style.display = 'none';
            document.getElementById('task-details-container').style.display = 'block';
            document.getElementById('task-error-container').style.display = 'none';
        }

        function showTaskError(errorMessage) {
            document.getElementById('task-loading-indicator').style.display = 'none';
            document.getElementById('task-details-container').style.display = 'none';
            document.getElementById('task-error-container').style.display = 'flex';
            document.getElementById('task-error-message').textContent = errorMessage || 'Failed to load task details.';
        }

        function loadTaskDetails(taskId) {
            fetch(`/tasks/${taskId}/details`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data.success) {
                        throw new Error(data.message || 'Failed to load task details');
                    }

                    const task = data.data;

                    // Populate basic task info
                    document.getElementById('task-modal-title').textContent = task.title;
                    document.getElementById('task-modal-description').textContent = task.description;
                    document.getElementById('task-modal-status').textContent = task.status;
                    document.getElementById('task-modal-status').className = `badge rounded-pill ${getStatusClass(task.status)}`;

                    // Hide submission form if task is completed
                    const submissionForm = document.getElementById('task-submission-form-container');
                    if (task.status.toLowerCase() === 'completed') {
                        submissionForm.style.display = 'none';
                    } else {
                        submissionForm.style.display = 'block';
                    }

                    if (task.priority) {
                        document.getElementById('task-modal-priority').textContent = task.priority.name;
                        document.getElementById('task-modal-priority').className = `badge rounded-pill ${getPriorityClass(task.priority.name)}`;
                    } else {
                        document.getElementById('task-modal-priority').textContent = 'No Priority';
                        document.getElementById('task-modal-priority').className = 'badge rounded-pill bg-secondary';
                    }

                    document.getElementById('task-modal-due-date').textContent = `Due: ${task.due_date_formatted}`;
                    document.getElementById('task-modal-creator').textContent = task.creator.name;
                    document.getElementById('task-modal-created-at').textContent = task.created_at_formatted;

                    // Load attachments
                    const attachmentsContainer = document.getElementById('task-modal-attachments');
                    attachmentsContainer.innerHTML = '';
                    if (task.attachments && task.attachments.length > 0) {
                        task.attachments.forEach(attachment => {
                            const attachmentElement = document.createElement('div');
                            attachmentElement.className = 'mb-2';

                            if (attachment.mime_type && attachment.mime_type.startsWith('image/')) {
                                attachmentElement.innerHTML = `
                                            <a href="/storage/${attachment.url}" target="_blank" class="d-block">
                                                <img src="/storage/${attachment.url}" class="attachment-thumbnail" 
                                                     alt="${attachment.original_name}" title="${attachment.original_name}">
                                            </a>
                                            <small class="d-block text-muted text-truncate" style="max-width: 100px">${attachment.original_name}</small>
                                        `;
                            } else {
                                attachmentElement.innerHTML = `
                                            <a href="/storage/${attachment.url}" target="_blank" class="d-block text-center">
                                                <div class="attachment-thumbnail d-flex align-items-center justify-content-center bg-white">
                                                    <i class="fas fa-file-alt fa-2x text-secondary"></i>
                                                </div>
                                                <small class="d-block text-muted text-truncate" style="max-width: 100px">${attachment.original_name}</small>
                                            </a>
                                        `;
                            }

                            attachmentsContainer.appendChild(attachmentElement);
                        });
                    } else {
                        attachmentsContainer.innerHTML = '<p class="text-muted">No attachments</p>';
                    }

                    // Load comments
                    const commentsContainer = document.getElementById('task-modal-comments');
                    commentsContainer.innerHTML = '';
                    if (task.comments && task.comments.length > 0) {
                        task.comments.forEach(comment => {
                            const commentElement = document.createElement('div');
                            commentElement.className = 'comment-item';
                            commentElement.innerHTML = `
                                        <div class="d-flex align-items-center mb-2">
                                            <img src="${comment.user.avatar_url || '/storage/profile/avatars/profile.png'}" 
                                                 class="user-avatar" alt="${comment.user.name}">
                                            <div>
                                                <span class="comment-user">${comment.user.name}</span>
                                                <span class="comment-time">${comment.created_at}</span>
                                            </div>
                                        </div>
                                        <p class="ms-4 mb-0">${comment.content}</p>
                                    `;
                            commentsContainer.appendChild(commentElement);
                        });
                    } else {
                        commentsContainer.innerHTML = '<p class="text-muted">No comments yet</p>';
                    }

                    // Load required documents
                    const requiredDocsContainer = document.getElementById('required-documents-container');
                    const requiredDocsList = document.getElementById('required-documents-list');
                    requiredDocsList.innerHTML = '';

                    if (task.require_documents && task.required_documents && task.required_documents.length > 0) {
                        requiredDocsContainer.style.display = 'block';

                        task.required_documents.forEach((doc, index) => {
                            const docElement = document.createElement('div');
                            docElement.className = 'col-md-6 mb-3';

                            // Determine if document is already submitted
                            const isSubmitted = doc.is_submitted;
                            const submittedDoc = doc.submitted_document;

                            let statusBadge = '';
                            let fileInput = '';

                            if (isSubmitted && submittedDoc) {
                                // Document already submitted - show status
                                const statusClass = getDocumentStatusClass(submittedDoc.status);
                                statusBadge = `
                                            <div class="mb-2">
                                                <span class="badge ${statusClass} small">${submittedDoc.status.toUpperCase()}</span>
                                                ${submittedDoc.rejection_reason ? `
                                                    <div class="mt-1 small text-danger">
                                                        <strong>Reason:</strong> ${submittedDoc.rejection_reason}
                                                    </div>
                                                ` : ''}
                                            </div>
                                        `;

                                // Show download link instead of file input
                                fileInput = `
                                            <div class="mt-2">
                                                <a href="/storage/${submittedDoc.path}" target="_blank" class="btn btn-sm btn-outline-primary me-2">
                                                    <i class="fas fa-download me-1"></i> Download
                                                </a>
                                                ${submittedDoc.status === 'rejected' ? `
                                                    <button type="button" class="btn btn-sm btn-outline-warning reupload-btn" data-doc-id="${doc.id}">
                                                        <i class="fas fa-upload me-1"></i> Reupload
                                                    </button>
                                                    <div class="mt-2 reupload-container" id="reupload-container-${doc.id}" style="display: none;">
                                                        <input type="file" class="form-control form-control-sm" 
                                                               id="required_doc_${doc.id}" 
                                                               name="required_documents[${doc.id}]" 
                                                               ${doc.type === 'image' ? 'accept="image/*"' : ''}>
                                                    </div>
                                                ` : ''}
                                            </div>
                                        `;
                            } else {
                                // Document not submitted - show file input
                                fileInput = `
                                            <div class="mt-2">
                                                <label for="required_doc_${doc.id}" class="form-label small fw-semibold">Upload File</label>
                                                <input type="file" class="form-control form-control-sm" 
                                                       id="required_doc_${doc.id}" 
                                                       name="required_documents[${doc.id}]" 
                                                       ${doc.type === 'image' ? 'accept="image/*"' : ''}
                                                       required>
                                            </div>
                                        `;
                            }

                            docElement.innerHTML = `
                                        <div class="card h-100 border-0 shadow-sm required-doc-card">
                                            <div class="card-body">
                                                <h6 class="card-title fw-semibold d-flex align-items-center">
                                                    <i class="fas fa-file-alt me-2 text-primary"></i>
                                                    ${doc.name}
                                                </h6>
                                                <p class="card-text small text-muted mb-2">${doc.description || 'No description provided'}</p>
                                                <div class="mb-2">
                                                    <span class="badge bg-light text-dark small">${doc.type}</span>
                                                </div>
                                                ${statusBadge}
                                                ${fileInput}
                                            </div>
                                        </div>
                                    `;
                            requiredDocsList.appendChild(docElement);
                        });

                        // Add event listeners for reupload buttons
                        setTimeout(() => {
                            document.querySelectorAll('.reupload-btn').forEach(btn => {
                                btn.addEventListener('click', function () {
                                    const docId = this.getAttribute('data-doc-id');
                                    const container = document.getElementById(`reupload-container-${docId}`);
                                    container.style.display = container.style.display === 'none' ? 'block' : 'none';
                                });
                            });
                        }, 100);

                        // Add the required documents section before the submission form
                        document.getElementById('task-submission-form-container').parentNode.insertBefore(
                            requiredDocsContainer,
                            document.getElementById('task-submission-form-container')
                        );
                    } else {
                        requiredDocsContainer.style.display = 'none';
                    }

                    showTaskDetails();
                })
                .catch(error => {
                    console.error('Error loading task details:', error);
                    showTaskError(error.message || 'Failed to load task details. Please try again.');
                });
        }

        function getDocumentStatusClass(status) {
            const statusClasses = {
                'pending': 'bg-warning text-dark',
                'approved': 'bg-success',
                'rejected': 'bg-danger'
            };
            return statusClasses[status.toLowerCase()] || 'bg-secondary';
        }

        function submitTaskForm() {
            const form = document.getElementById('taskSubmissionForm');
            const formData = new FormData(form);
            const submitBtn = document.getElementById('submitTaskBtn');

            // Show loading state
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Submitting...';

            fetch('/tasks/submit', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        showToast('Task submitted successfully!', 'success');

                        // Close modal after a brief delay
                        setTimeout(() => {
                            const modal = bootstrap.Modal.getInstance(document.getElementById('taskViewModal'));
                            modal.hide();

                            // Reload page to reflect changes
                            location.reload();
                        }, 1500);
                    } else {
                        throw new Error(data.message || 'Failed to submit task');
                    }
                })
                .catch(error => {
                    console.error('Error submitting task:', error);
                    showToast(error.message || 'Failed to submit task. Please try again.', 'error');
                })
                .finally(() => {
                    // Restore button state
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                });
        }

        function showToast(message, type = 'info') {
            // Create toast element if it doesn't exist
            if (!document.getElementById('notificationToast')) {
                const toastContainer = document.createElement('div');
                toastContainer.innerHTML = `
                                    <div id="notificationToast" class="toast align-items-center text-white bg-${type}" role="alert" aria-live="assertive" aria-atomic="true">
                                        <div class="d-flex">
                                            <div class="toast-body">
                                                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} me-2"></i>
                                                <span id="toastMessage"></span>
                                            </div>
                                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                        </div>
                                    </div>
                                `;
                document.body.appendChild(toastContainer.firstElementChild);
            }

            // Set message and show toast
            document.getElementById('toastMessage').textContent = message;
            const toast = new bootstrap.Toast(document.getElementById('notificationToast'), {
                delay: 3000
            });
            toast.show();
        }

        function getStatusClass(status) {
            const statusClasses = {
                'pending': 'bg-info',
                'in_progress': 'bg-warning text-dark',
                'completed': 'bg-success',
                'overdue': 'bg-danger',
                'rejected': 'bg-danger',
                'pending_approval': 'bg-primary'
            };
            return statusClasses[status.toLowerCase()] || 'bg-secondary';
        }

        function getPriorityClass(priority) {
            const priorityClasses = {
                'high': 'bg-danger',
                'medium': 'bg-warning text-dark',
                'low': 'bg-success'
            };
            return priorityClasses[priority.toLowerCase()] || 'bg-secondary';
        }
    </script>
@endsection