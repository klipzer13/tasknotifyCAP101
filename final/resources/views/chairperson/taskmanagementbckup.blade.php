@extends('chairperson.genchair')
@section('title', 'Task Management')

@section('content')
    <style>
        .task-management-container {
            background-color: white;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            padding: 30px;
            margin-bottom: 30px;
            border: none;
        }

        .task-management-container {
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
        }

        .task-assignees {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .assignee {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            margin-right: 5px;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

        .status-in-progress {
            background-color: #fff3e0;
            color: #fb8c00;
        }

        .status-completed {
            background-color: #e8f5e9;
            color: #4caf50;
        }

        .status-overdue {
            background-color: #ffebee;
            color: #f44336;
        }

        .status-pending-approval {
            background-color: #f3e5f5;
            color: #9c27b0;
        }

        .status-rejected {
            background-color: #efebe9;
            color: #795548;
        }

        .attachment-thumbnail {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 10px;
            margin-bottom: 10px;
            border: 1px solid #eee;
            cursor: pointer;
            transition: all 0.3s;
        }

        .attachment-thumbnail:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .comment-box {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f8f9fa;
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .comment-user {
            display: flex;
            align-items: center;
            font-weight: 600;
            color: #2c3e50;
        }

        .comment-user img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .comment-time {
            font-size: 0.8rem;
            color: #7f8c8d;
        }

        .comment-text {
            color: #495057;
            line-height: 1.5;
        }

        .create-task-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 12px 24px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
            border-radius: 10px;
            font-size: 1rem;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.25);
            margin-bottom: 20px;
        }

        .create-task-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(67, 97, 238, 0.3);
        }

        .notification-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            min-width: 300px;
        }

        .task-detail-modal .modal-header {
            border-bottom: 1px solid #eee;
            padding: 20px;
        }

        .task-detail-modal .modal-body {
            padding: 25px;
        }

        .task-detail-modal .modal-footer {
            border-top: 1px solid #eee;
            padding: 15px 25px;
        }

        .task-status-select {
            width: 200px;
            display: inline-block;
            margin-right: 10px;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
        }

        .empty-state i {
            font-size: 3rem;
            color: #adb5bd;
            margin-bottom: 20px;
        }

        .empty-state h5 {
            color: #495057;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #6c757d;
        }

        .assignee-section {
            margin-bottom: 30px;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }

        .assignee-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }

        .assignee-tasks-count {
            margin-left: auto;
            font-weight: bold;
            color: var(--primary-color);
        }

        .assignee-section {
            margin-bottom: 30px;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }

        .assignee-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }

        .assignee-tasks-count {
            margin-left: auto;
            font-weight: bold;
            color: var(--primary-color);
        }

        /* Add these to your existing style section */
        .status-pending-approval {
            background-color: #f3e5f5;
            color: #9c27b0;
        }

        .status-approved {
            background-color: #e8f5e9;
            color: #4caf50;
        }

        .status-rejected {
            background-color: #efebe9;
            color: #795548;
        }

        .attachment-thumbnail {
            width: 100px;
            height: 100px;
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border: 1px solid #eee;
            cursor: pointer;
            transition: all 0.2s;
        }

        .attachment-thumbnail:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .attachment-thumbnail img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .comment-section {
            max-height: 300px;
            overflow-y: auto;
        }

        .comment {
            padding: 10px;
            border-radius: 8px;
        }

        .comment:hover {
            background-color: rgba(0, 0, 0, 0.03);
        }

        .toast {
            margin-bottom: 10px;
        }
    </style>

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

    <div class="task-management-container">
        <div class="section-header d-flex justify-content-between align-items-center">
            <h4><i class="fas fa-tasks"></i> Task Management</h4>
            <a href="{{ route('chairassign.task') }}" class="btn create-task-btn">
                <i class="fas fa-plus me-2"></i> Create New Task
            </a>
        </div>

        <!-- Assignee Filter -->
        <div class="mb-4">
            <label for="assigneeFilter" class="form-label">Filter by Assignee:</label>
            <select class="form-select" id="assigneeFilter">
                <option value="all">All Assignees</option>
                @foreach($assignees as $assignee)
                    <option value="{{ $assignee->id }}">{{ $assignee->name }}</option>
                @endforeach
            </select>
        </div>

        <ul class="nav nav-tabs task-tabs" id="taskTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="all-tasks-tab" data-bs-toggle="tab" data-bs-target="#all-tasks"
                    type="button" role="tab">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-list-check me-2"></i>
                        <span>All Tasks</span>
                        <span class="task-count-badge bg-primary-soft ms-2">{{ $tasks->count() }}</span>
                    </div>
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link" id="in-progress-tab" data-bs-toggle="tab" data-bs-target="#in-progress-tasks"
                    type="button" role="tab">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-spinner me-2"></i>
                        <span>In Progress</span>
                        <span
                            class="task-count-badge bg-info-soft ms-2">{{ $inProgressTasks->sum(fn($user) => $user->taskAssignments->where('status.name', 'pending')->count()) }}</span>
                    </div>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending-tasks" type="button"
                    role="tab">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-clock me-2"></i>
                        <span>Pending Approval</span>
                        <span
                            class="task-count-badge bg-warning-soft ms-2">{{ $pendingApprovals->sum(fn($assignee) => $assignee->taskAssignments->where('status.name', 'pending_approval')->count()) }}</span>
                        @php

                        @endphp
                    </div>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed-tasks"
                    type="button" role="tab">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle me-2"></i>
                        <span>Completed</span>
                        <span
                            class="task-count-badge bg-success-soft ms-2">{{ $completedTasks->sum(fn($assignee) => $assignee->taskAssignments->where('status.name', 'completed')->count()) }}</span>
                    </div>
                </button>
            </li>
        </ul>

        <div class="tab-content" id="taskTabsContent">
            <!-- All Tasks Tab -->
            <div class="tab-pane fade show active" id="all-tasks" role="tabpanel">
                @forelse($tasks as $task)
                    <div class="task-card">
                        <div class="task-card-header">
                            <div class="d-flex justify-content-between align-items-center w-100">
                                <!-- Title and Priority Section -->
                                <div class="d-flex align-items-center gap-2">
                                    <h5 class="task-title m-0 font-weight-semi-bold text-dark">
                                        {{ $task->title }}
                                    </h5>
                                    <span
                                        class="badge priority-badge priority-{{ $task->priority->name ?? 'medium' }} px-2 py-1">
                                        {{ ucfirst($task->priority->name ?? 'Medium') }}
                                    </span>
                                </div>

                                <!-- Status Section -->
                                @if($task->assignees->count() > 1)
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light dropdown-toggle d-flex align-items-center" type="button"
                                            id="assigneeStatusDropdown{{ $task->id }}" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <span class="me-1">Team Status</span>
                                            <i class="bi bi-people-fill small"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm"
                                            aria-labelledby="assigneeStatusDropdown{{ $task->id }}"
                                            style="max-height: 300px; overflow-y: auto;">
                                            @foreach($task->assignees as $assignee)
                                                <li>
                                                    <a class="dropdown-item d-flex justify-content-between align-items-center py-2">
                                                        <span class="text-truncate"
                                                            style="max-width: 120px;">{{ $assignee->name }}</span>
                                                        <span
                                                            class="badge status-badge status-{{ str_replace(' ', '-', strtolower($assignee->pivot->status->name ?? 'pending')) }} ms-2">
                                                            {{ $assignee->pivot->status->name ?? 'Pending' }}
                                                        </span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <span
                                        class="badge status-badge status-{{ str_replace(' ', '-', strtolower($task->current_status->name ?? 'pending')) }} px-3 py-1">
                                        {{ $task->current_status->name ?? 'Pending' }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <style>
                            /* Base Styles */
                            .task-card-header {
                                padding: 0.75rem 1rem;
                                border-bottom: 1px solid #f0f0f0;
                            }

                            .task-title {
                                font-size: 1.05rem;
                                color: #2d3748;
                                max-width: 200px;
                                white-space: nowrap;
                                overflow: hidden;
                                text-overflow: ellipsis;
                            }

                            /* Badge Styles */
                            .badge {
                                font-size: 0.75rem;
                                font-weight: 500;
                                letter-spacing: 0.5px;
                                text-transform: uppercase;
                                border-radius: 4px;
                            }

                            /* Priority Badges */
                            .priority-badge {
                                border: 1px solid transparent;
                            }

                            .priority-high {
                                background-color: #fff0f0;
                                border-color: #feb2b2;
                                color: #e53e3e;
                            }

                            .priority-medium {
                                background-color: #ebf8ff;
                                border-color: #90cdf4;
                                color: #3182ce;
                            }

                            .priority-low {
                                background-color: #f0fff4;
                                border-color: #9ae6b4;
                                color: #38a169;
                            }

                            /* Status Badges */
                            .status-badge {
                                border: 1px solid transparent;
                            }

                            .status-pending {
                                background-color: #fafaf9;
                                border-color: #e7e5e4;
                                color: #78716c;
                            }

                            .status-in-progress {
                                background-color: #eff6ff;
                                border-color: #bfdbfe;
                                color: #1d4ed8;
                            }

                            .status-completed {
                                background-color: #f0fdf4;
                                border-color: #bbf7d0;
                                color: #15803d;
                            }

                            /* Dropdown Styles */
                            .dropdown-menu {
                                min-width: 220px;
                                border: 1px solid #e2e8f0;
                            }

                            .dropdown-item {
                                font-size: 0.85rem;
                            }
                        </style>
                        <div class="task-card-body">
                            <div class="task-meta">
                                <span><i class="fas fa-calendar-alt"></i> Due:
                                    {{ $task->due_date->format('M d, Y') }}</span>
                                <span><i class="fas fa-user"></i> Assigned to:
                                    @foreach($task->assignees as $assignee)
                                        {{ $assignee->name }}@if(!$loop->last), @endif
                                    @endforeach
                                </span>

                            </div>
                            <p class="task-description">
                                {{ Str::limit($task->description, 200) }}
                            </p>
                            <div class="task-actions">
                                <a href="#" class="btn btn-sm btn-outline-primary me-2" data-task-id="{{ $task->id }}">
                                    <i class="fas fa-eye me-1"></i> View Details
                                </a>
                                <form action="{{ route('chairperson.tasks.delete', ['task' => $task->id]) }}" method="POST"
                                    class="d-inline delete-task-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger delete-task-btn">
                                        <i class="fas fa-trash-alt me-1"></i> Delete
                                    </button>
                                </form>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const deleteButtons = document.querySelectorAll('.delete-task-btn');
                                    deleteButtons.forEach(button => {
                                        button.addEventListener('click', function () {
                                            if (confirm('Are you sure you want to delete this task?')) {
                                                this.closest('.delete-task-form').submit();
                                            }
                                        });
                                    });
                                });
                            </script>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-tasks"></i>
                        <h5>No tasks found</h5>
                        <p>There are currently no tasks assigned to you or your team.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pending Approval Tab -->
            <div class="tab-pane fade" id="pending-tasks" role="tabpanel">
                @if($pendingApprovals->count() > 0)
                    @foreach($pendingApprovals as $assignee)
                        @if($assignee->taskAssignments->count() > 0)
                            <div class="assignee-section" data-assignee="{{ $assignee->id }}">
                                <div class="assignee-header">
                                    <img src="{{ $assignee->avatar_url ?? asset('storage/profile/avatars/profile.png') }}"
                                        class="assignee me-3" alt="{{ $assignee->name }}" width="40" height="40">
                                    <h5 class="mb-0">{{ $assignee->name }}</h5>
                                    <span class="assignee-tasks-count">{{ $assignee->taskAssignments->count() }} tasks</span>
                                </div>

                                @foreach($assignee->taskAssignments as $assignment)
                                    <div class="task-card mb-3">
                                        <div class="task-card-header">
                                            <div>
                                                <span class="task-title">{{ $assignment->task->title }}</span>
                                                <span class="priority-badge priority-{{ $assignment->task->priority->name ?? 'medium' }}">
                                                    {{ ucfirst($assignment->task->priority->name ?? 'Medium') }} Priority
                                                </span>
                                            </div>
                                            <span class="status-badge status-pending-approval">
                                                Pending Approval
                                            </span>
                                        </div>
                                        <div class="task-card-body">
                                            <div class="task-meta">
                                                <span><i class="fas fa-calendar-alt"></i> Due:
                                                    {{ $assignment->task->due_date->format('M d, Y') }}</span>
                                                <span><i class="fas fa-building"></i>
                                                    {{ $assignment->task->department ?? 'General' }}</span>
                                            </div>
                                            <p class="task-description">
                                                {{ Str::limit($assignment->task->description, 200) }}
                                            </p>
                                            <div class="task-actions">
                                                <a href="#" class="btn btn-sm btn-outline-primary me-2"
                                                    data-task-id="{{ $assignment->task->id }}">
                                                    <i class="fas fa-eye me-1"></i> View Details
                                                </a>
                                                <form
                                                    action="{{ route('chairperson.tasks.approve-assignee', ['task' => $assignment->task->id, 'user' => $assignee->id]) }}"
                                                    method="POST" class="d-inline me-2">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                                        <i class="fas fa-check me-1"></i> Approve
                                                    </button>
                                                </form>
                                                <form
                                                    action="{{ route('chairperson.tasks.reject-assignee', ['task' => $assignment->task->id, 'user' => $assignee->id]) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-times me-1"></i> Reject
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="fas fa-clock"></i>
                        <h5>No tasks pending approval</h5>
                        <p>There are currently no tasks awaiting your approval.</p>
                    </div>
                @endif
            </div>

            <!-- In Progress Tab -->
            <div class="tab-pane fade" id="in-progress-tasks" role="tabpanel">
                @if($inProgressTasks->count() > 0)
                    @foreach($inProgressTasks as $user)
                        @if($user->taskAssignments->count() > 0)
                            <div class="assignee-section" data-assignee="{{ $user->id }}">
                                <div class="assignee-header">
                                    <img src="{{ $user->avatar_url ?? asset('storage/profile/avatars/profile.png') }}"
                                        class="assignee me-3" alt="{{ $user->name }}" width="40" height="40">
                                    <h5 class="mb-0">{{ $user->name }}</h5>
                                    <span class="assignee-tasks-count">{{ $user->taskAssignments->count() }} tasks</span>
                                </div>

                                @foreach($user->taskAssignments as $assignment)
                                    <div class="task-card mb-3">
                                        <div class="task-card-header">
                                            <div>
                                                <span class="task-title">{{ $assignment->task->title }}</span>
                                                <span class="priority-badge priority-{{ $assignment->task->priority->name ?? 'medium' }}">
                                                    {{ ucfirst($assignment->task->priority->name ?? 'Medium') }} Priority
                                                </span>
                                            </div>
                                            <span
                                                class="status-badge status-{{ str_replace(' ', '-', strtolower($assignment->status->name ?? 'in-progress')) }}">
                                                {{ $assignment->status->name ?? 'In Progress' }}
                                            </span>
                                        </div>
                                        <div class="task-card-body">
                                            <div class="task-meta">
                                                <span><i class="fas fa-calendar-alt"></i> Due:
                                                    {{ $assignment->task->due_date->format('M d, Y') }}</span>
                                                <span><i class="fas fa-building"></i>
                                                    {{ $assignment->task->department ?? 'General' }}</span>
                                            </div>
                                            <p class="task-description">
                                                {{ Str::limit($assignment->task->description, 200) }}
                                            </p>
                                            <div class="task-actions">

                                                <a href="#" class="btn btn-sm btn-outline-primary me-2"
                                                    data-task-id="{{ $assignment->task->id }}">
                                                    <i class="fas fa-eye me-1"></i> View Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="fas fa-spinner"></i>
                        <h5>No tasks in progress</h5>
                        <p>There are currently no tasks being worked on by your team.</p>
                    </div>
                @endif
            </div>

            <!-- Completed Tab -->
            <div class="tab-pane fade" id="completed-tasks" role="tabpanel">
                @if($completedTasks->count() > 0)
                    @foreach($completedTasks as $assignee)
                        @if($assignee->taskAssignments->where('status.name', 'completed')->count() > 0)
                            <div class="assignee-section" data-assignee="{{ $assignee->id }}">
                                <div class="assignee-header">
                                    <img src="{{ $assignee->avatar_url ?? asset('storage/profile/avatars/profile.png') }}"
                                        class="assignee me-3" alt="{{ $assignee->name }}" width="40" height="40">
                                    <h5 class="mb-0">{{ $assignee->name }}</h5>
                                    <span class="assignee-tasks-count">
                                        {{ $assignee->taskAssignments->where('status.name', 'completed')->count() }} tasks
                                    </span>
                                </div>

                                @foreach($assignee->taskAssignments->where('status.name', 'completed') as $assignment)
                                    <div class="task-card mb-3">
                                        <div class="task-card-header">
                                            <div>
                                                <span class="task-title">{{ $assignment->task->title }}</span>
                                                <span class="priority-badge priority-{{ $assignment->task->priority->name ?? 'medium' }}">
                                                    {{ ucfirst($assignment->task->priority->name ?? 'Medium') }} Priority
                                                </span>
                                            </div>
                                            <span class="status-badge status-completed">
                                                Completed
                                            </span>
                                        </div>
                                        <div class="task-card-body">
                                            <div class="task-meta">
                                                <span><i class="fas fa-calendar-alt"></i> Due:
                                                    {{ $assignment->task->due_date->format('M d, Y') }}</span>
                                                <span><i class="fas fa-building"></i>
                                                    {{ $assignment->task->department ?? 'General' }}</span>
                                            </div>
                                            <p class="task-description">
                                                {{ Str::limit($assignment->task->description, 200) }}
                                            </p>
                                            <div class="task-actions">
                                                <a href="#" class="btn btn-sm btn-outline-primary me-2"
                                                    data-task-id="{{ $assignment->task->id }}">
                                                    <i class="fas fa-eye me-1"></i> View Details
                                                </a>
                                                <button class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-file-export me-1"></i> Export Report
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="fas fa-check-circle"></i>
                        <h5>No completed tasks</h5>
                        <p>There are currently no completed tasks in your team.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>
    <!-- Task View Modal -->
    <div class="modal fade task-detail-modal" id="taskViewModal" tabindex="-1" aria-labelledby="taskViewModalLabel"
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
                                <h6 class="fw-semibold mb-3 text-uppercase small text-muted">Assigned To</h6>
                                <div id="task-modal-assignees" class="d-flex flex-wrap gap-2">
                                    <!-- Assignees will be populated here -->
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <h6 class="fw-semibold mb-3 text-uppercase small text-muted">Attachments</h6>
                                <div id="task-modal-attachments" class="d-flex flex-wrap gap-3">
                                    <div class="text-center py-3 w-100">
                                        <p class="text-muted">No attachments available</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-4">
                                <h6 class="fw-semibold mb-3 text-uppercase small text-muted">Comments</h6>
                                <div id="task-modal-comments" class="comment-section bg-light rounded p-3">
                                    <div class="text-center py-2">
                                        <p class="text-muted">No comments yet</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="task-error-container" class="d-none">
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="approveTaskBtn" style="display: none;">
                        <i class="fas fa-check me-2"></i> Approve Task
                    </button>
                    <button type="button" class="btn btn-outline-danger" id="rejectTaskBtn" style="display: none;">
                        <i class="fas fa-times me-2"></i> Reject Task
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Auto-hide notification
            const notification = document.querySelector('.notification-toast');
            if (notification) {
                setTimeout(() => {
                    notification.classList.remove('show');
                    notification.classList.add('hide');
                }, 5000);
            }

            // Tab persistence
            if (localStorage.getItem('lastActiveTab')) {
                const lastActiveTab = localStorage.getItem('lastActiveTab');
                const tabTrigger = document.querySelector(`#${lastActiveTab}-tab`);
                if (tabTrigger) {
                    new bootstrap.Tab(tabTrigger).show();
                }
            }

            // Save active tab when changed
            const tabTriggers = document.querySelectorAll('[data-bs-toggle="tab"]');
            tabTriggers.forEach(tabTrigger => {
                tabTrigger.addEventListener('click', function () {
                    localStorage.setItem('lastActiveTab', this.id);
                });
            });

            // Assignee filter functionality
            const assigneeFilter = document.getElementById('assigneeFilter');
            if (assigneeFilter) {
                assigneeFilter.addEventListener('change', function () {
                    const assigneeId = this.value;
                    const assigneeSections = document.querySelectorAll('.assignee-section');

                    assigneeSections.forEach(section => {
                        if (assigneeId === 'all' || section.dataset.assignee === assigneeId) {
                            section.style.display = 'block';
                        } else {
                            section.style.display = 'none';
                        }
                    });
                });
            }
            const taskViewModal = new bootstrap.Modal(document.getElementById('taskViewModal'));
            const taskDetailsContainer = document.getElementById('task-details-container');
            const taskLoadingIndicator = document.getElementById('task-loading-indicator');
            const taskErrorContainer = document.getElementById('task-error-container');

            // Event delegation for view details buttons
            document.addEventListener('click', function (e) {
                if (e.target.closest('[data-task-id]')) {
                    e.preventDefault();
                    const taskId = e.target.closest('[data-task-id]').getAttribute('data-task-id');
                    showTaskDetails(taskId);
                }
            });

            function showTaskDetails(taskId) {
                // Reset modal state
                taskDetailsContainer.style.display = 'none';
                taskErrorContainer.style.display = 'none';
                taskLoadingIndicator.style.display = 'block';

                // Hide action buttons initially
                document.getElementById('approveTaskBtn').style.display = 'none';
                document.getElementById('rejectTaskBtn').style.display = 'none';

                // Fetch task details
                fetch(`/chairperson/tasks/${taskId}/details`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to fetch task details');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            populateTaskModal(data.data);
                            taskLoadingIndicator.style.display = 'none';
                            taskDetailsContainer.style.display = 'block';

                            // Show approve/reject buttons if task is pending approval
                            if (data.data.status === 'pending_approval') {
                                document.getElementById('approveTaskBtn').style.display = 'inline-block';
                                document.getElementById('rejectTaskBtn').style.display = 'inline-block';

                                // Set up approve button
                                document.getElementById('approveTaskBtn').onclick = function () {
                                    approveTask(taskId);
                                };

                                // Set up reject button
                                document.getElementById('rejectTaskBtn').onclick = function () {
                                    rejectTask(taskId);
                                };
                            }
                        } else {
                            throw new Error(data.message || 'Failed to load task details');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        taskLoadingIndicator.style.display = 'none';
                        taskErrorContainer.style.display = 'flex';
                        document.getElementById('task-error-message').textContent = error.message;
                    })
                    .finally(() => {
                        taskViewModal.show();
                    });
            }

            function populateTaskModal(taskData) {
                // Basic task info
                document.getElementById('task-modal-title').textContent = taskData.title;
                document.getElementById('task-modal-description').textContent = taskData.description;
                document.getElementById('task-modal-due-date').textContent = `Due: ${taskData.due_date_formatted}`;
                document.getElementById('task-modal-creator').textContent = taskData.creator.name;
                document.getElementById('task-modal-created-at').textContent = taskData.created_at_formatted;

                // Status badge  
                const statusBadge = document.getElementById('task-modal-status');
                statusBadge.textContent = taskData.status.replace(/_/g, ' ');
                statusBadge.className = 'badge rounded-pill ';
                statusBadge.classList.add(`status-${taskData.status.toLowerCase().replace(/\s+/g, '-')}`);

                // Priority badge
                const priorityBadge = document.getElementById('task-modal-priority');
                priorityBadge.textContent = `${taskData.priority.name} Priority`;
                priorityBadge.className = 'badge rounded-pill ';
                priorityBadge.classList.add(`priority-${taskData.priority.name.toLowerCase()}`);

                // Assignees
                const assigneesContainer = document.getElementById('task-modal-assignees');
                assigneesContainer.innerHTML = '';
                if (taskData.assignees && taskData.assignees.length > 0) {
                    taskData.assignees.forEach(assignee => {
                        const assigneeBadge = document.createElement('div');
                        assigneeBadge.className = 'badge bg-light text-dark d-flex align-items-center';
                        assigneeBadge.innerHTML = `
                                                                                <img src="${assignee.avatar_url}" class="rounded-circle me-2" width="20" height="20">
                                                                                ${assignee.name}
                                                                            `;
                        assigneesContainer.appendChild(assigneeBadge);
                    });
                } else {
                    assigneesContainer.innerHTML = '<p class="text-muted">No assignees</p>';
                }

                // Attachments
                const attachmentsContainer = document.getElementById('task-modal-attachments');
                attachmentsContainer.innerHTML = '';
                if (taskData.attachments && taskData.attachments.length > 0) {
                    taskData.attachments.forEach(attachment => {
                        const attachmentElement = document.createElement('div');
                        attachmentElement.className = 'attachment-thumbnail';
                        const fileUrl = attachment.url.startsWith('http')
                            ? attachment.url
                            : attachment.url.startsWith('storage/')
                                ? `/${attachment.url}`
                                : `/storage/${attachment.url}`;

                        if (attachment.mime_type.startsWith('image/')) {
                            attachmentElement.innerHTML = `

                                                                                    <img src="${fileUrl}" alt="${attachment.original_name}" 
                                                                                         class="img-fluid rounded" data-bs-toggle="tooltip" 
                                                                                         title="${attachment.original_name}">
                                                                                `;
                        } else {
                            const fileIcon = getFileIcon(attachment.mime_type);
                            attachmentElement.innerHTML = `
                                                                                    <div class="d-flex flex-column align-items-center justify-content-center h-100">
                                                                                        <i class="${fileIcon} fa-2x mb-2"></i>
                                                                                        <small class="text-truncate" style="max-width: 70px">${attachment.original_name}</small>
                                                                                    </div>
                                                                                `;
                        }

                        attachmentElement.onclick = () => window.open(fileUrl, '_blank');
                        attachmentsContainer.appendChild(attachmentElement);
                    });
                } else {
                    attachmentsContainer.innerHTML = '<div class="text-center py-3 w-100"><p class="text-muted">No attachments available</p></div>';
                }

                // Comments
                const commentsContainer = document.getElementById('task-modal-comments');
                commentsContainer.innerHTML = '';
                if (taskData.comments && taskData.comments.length > 0) {
                    taskData.comments.forEach(comment => {
                        const commentElement = document.createElement('div');
                        commentElement.className = 'comment mb-3 pb-3 border-bottom';
                        commentElement.innerHTML = `
                                                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <img src="${comment.user.avatar_url}" class="rounded-circle me-2" width="32" height="32">
                                                                                        <strong>${comment.user.name}</strong>
                                                                                    </div>
                                                                                    <small class="text-muted">${comment.created_at}</small>
                                                                                </div>
                                                                                <div class="ps-4 ms-4">
                                                                                    <p class="mb-0">${comment.content}</p>
                                                                                </div>
                                                                            `;
                        commentsContainer.appendChild(commentElement);
                    });
                } else {
                    commentsContainer.innerHTML = '<div class="text-center py-2"><p class="text-muted">No comments yet</p></div>';
                }
            }

            function getFileIcon(mimeType) {
                if (mimeType.startsWith('image/')) return 'fas fa-image';
                if (mimeType.startsWith('video/')) return 'fas fa-video';
                if (mimeType.startsWith('audio/')) return 'fas fa-music';
                if (mimeType === 'application/pdf') return 'fas fa-file-pdf';
                if (mimeType === 'application/msword' || mimeType === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')
                    return 'fas fa-file-word';
                if (mimeType === 'application/vnd.ms-excel' || mimeType === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                    return 'fas fa-file-excel';
                if (mimeType === 'application/vnd.ms-powerpoint' || mimeType === 'application/vnd.openxmlformats-officedocument.presentationml.presentation')
                    return 'fas fa-file-powerpoint';
                if (mimeType === 'application/zip' || mimeType === 'application/x-rar-compressed')
                    return 'fas fa-file-archive';
                return 'fas fa-file';
            }

            function approveTask(taskId) {
                fetch(`/chairperson/tasks/${taskId}/approve`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast('success', 'Task approved successfully');
                            taskViewModal.hide();
                            window.location.reload();
                        } else {
                            showToast('error', data.message || 'Failed to approve task');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('error', 'An error occurred while approving the task');
                    });
            }

            function rejectTask(taskId) {
                fetch(`/chairperson/tasks/${taskId}/reject`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast('success', 'Task rejected successfully');
                            taskViewModal.hide();
                            window.location.reload();
                        } else {
                            showToast('error', data.message || 'Failed to reject task');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('error', 'An error occurred while rejecting the task');
                    });
            }

            function showToast(type, message) {
                const toast = document.createElement('div');
                toast.className = `toast align-items-center text-white bg-${type} border-0 show`;
                toast.setAttribute('role', 'alert');
                toast.setAttribute('aria-live', 'assertive');
                toast.setAttribute('aria-atomic', 'true');
                toast.innerHTML = `
                                                                        <div class="d-flex">
                                                                            <div class="toast-body">
                                                                                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} me-2"></i>
                                                                                ${message}
                                                                            </div>
                                                                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                                                        </div>
                                                                    `;

                const toastContainer = document.querySelector('.notification-toast-container');
                if (!toastContainer) {
                    const container = document.createElement('div');
                    container.className = 'position-fixed top-0 end-0 p-3 notification-toast-container';
                    container.style.zIndex = '1100';
                    document.body.appendChild(container);
                    container.appendChild(toast);
                } else {
                    toastContainer.appendChild(toast);
                }

                setTimeout(() => {
                    toast.classList.remove('show');
                    setTimeout(() => toast.remove(), 150);
                }, 5000);
            }
        });
    </script>
@endsection