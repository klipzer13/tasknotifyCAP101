@extends('genview')
@section('title', 'All Tasks')

@section('content')
    <style>
        :root {
            --primary-color: #4b6cb7;
            --secondary-color: #182848;
        }

        .task-filters {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .filter-header {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .filter-group {
            margin-bottom: 15px;
        }

        .filter-group label {
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
            display: block;
        }

        .task-count-badge {
            background-color: var(--primary-color);
            color: white;
            border-radius: 20px;
            padding: 3px 10px;
            font-size: 0.8rem;
            margin-left: 10px;
        }

        .task-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .task-table thead th {
            background-color: #f8f9fa;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #eee;
        }

        .task-table tbody td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        .task-table tbody tr:last-child td {
            border-bottom: none;
        }

        .task-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .priority-indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 8px;
        }

        .priority-indicator.high {
            background-color: #dc3545;
        }

        .priority-indicator.medium {
            background-color: #ffc107;
        }

        .priority-indicator.low {
            background-color: #28a745;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-badge.pending {
            background-color: #f8f9fa;
            color: #6c757d;
        }

        .status-badge.in-progress {
            background-color: #e7f6fd;
            color: #0d6efd;
        }

        .status-badge.completed {
            background-color: #e6f7ee;
            color: #198754;
        }

        .assignee-info {
            display: flex;
            align-items: center;
        }

        .assignee-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .pagination .page-link {
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .task-table {
                display: block;
                overflow-x: auto;
            }

            .task-filters {
                padding: 15px;
            }
        }
    </style>

    <style>
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

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4><i class="fas fa-tasks me-2"></i> All Tasks</h4>
        <a href="{{ route('assign.task') }}" class="btn"
            style="background: linear-gradient(to right, var(--primary-color), var(--secondary-color)); color: white;">
            <i class="fas fa-plus me-2"></i> New Task
        </a>
    </div>

    <!-- Task Filters -->
    <form action="{{ route('tasks.index') }}" method="GET">
        <div class="task-filters">
            <div class="filter-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Filters</h5>
                <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-outline-secondary">Reset Filters</a>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="filter-group">
                        <label>Status</label>
                        <select name="status_id" class="form-select">
                            <option value="">All Statuses</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}" {{ request('status_id') == $status->id ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="filter-group">
                        <label>Priority</label>
                        <select name="priority_id" class="form-select">
                            <option value="">All Priorities</option>
                            @foreach($priorities as $priority)
                                <option value="{{ $priority->id }}" {{ request('priority_id') == $priority->id ? 'selected' : '' }}>
                                    {{ $priority->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="filter-group">
                        <label>Assignee</label>
                        <select name="assignee" class="form-select">
                            <option value="">All Assignees</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('assignee') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="filter-group">
                        <label>Due Date</label>
                        <select name="due_date" class="form-select">
                            <option value="">All Dates</option>
                            <option value="today" {{ request('due_date') == 'today' ? 'selected' : '' }}>Today</option>
                            <option value="week" {{ request('due_date') == 'week' ? 'selected' : '' }}>This Week</option>
                            <option value="month" {{ request('due_date') == 'month' ? 'selected' : '' }}>This Month
                            </option>
                            <option value="overdue" {{ request('due_date') == 'overdue' ? 'selected' : '' }}>Overdue
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search tasks..."
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Tasks Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Tasks <span class="task-count-badge">{{ $tasks->total() }}</span></h5>
            <div class="d-flex">
                <form action="{{ route('tasks.index') }}" method="GET" class="me-3">
                    <div class="input-group" style="width: 250px;">
                        <input type="text" name="search" class="form-control" placeholder="Search tasks..."
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-outline-secondary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="task-table">
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th>Priority</th>
                            <th>Assigned by</th>
                            <th>Assignee(s)</th>
                            <th>Status</th>
                            <th>Due Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                                        <tr>
                                            <td>
                                                <strong>{{ $task->title }}</strong>
                                                <div class="text-muted small mt-1">{{ Str::limit($task->description, 50) }}</div>
                                            </td>
                                            <td>
                                                @php
                                                    $priorityClass = strtolower($task->priority->name);
                                                @endphp
                                                <span class="priority-indicator {{ $priorityClass }}"></span>
                                                {{ $task->priority->name }}
                                            </td>

                                            <td>
                                                <div class="assignee-info">
                                                    <img src="{{ $task->creator->avatar_url }}" class="assignee-avatar">
                                                    {{ $task->creator->name }}
                                                </div>
                                            </td>
                                            <td>
                                                @if($task->users->count() > 1)
                                                    @foreach($task->users->take(1) as $user)
                                                        <div class="assignee-info mb-2">
                                                            <img src="{{ $user->avatar_url }}" class="assignee-avatar">
                                                            {{ $user->name }}
                                                        </div>
                                                    @endforeach
                                                    <div>
                                                        <a href="#" class="text-primary" data-bs-toggle="modal"
                                                            data-bs-target="#viewMoreModal{{ $task->id }}">View More</a>
                                                    </div>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="viewMoreModal{{ $task->id }}" tabindex="-1"
                                                        aria-labelledby="viewMoreModalLabel{{ $task->id }}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="viewMoreModalLabel{{ $task->id }}">Assignees
                                                                    </h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <ul class="list-group">
                                                                        @foreach($task->users as $user)
                                                                            <li
                                                                                class="list-group-item d-flex align-items-center justify-content-between">
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="{{ $user->avatar_url }}" class="assignee-avatar me-2">
                                                                                    <span>{{ $user->name }}</span>
                                                                                </div>
                                                                                @php
                                                                                    $userStatus = $statuses->firstWhere('id', $user->pivot->status_id ?? null);
                                                                                    $userStatusName = $userStatus->name ?? 'Pending';
                                                                                    $userStatusClass = strtolower(str_replace(' ', '-', $userStatusName));
                                                                                @endphp
                                                                                <span
                                                                                    class="status-badge {{ $userStatusClass }}">{{ $userStatusName }}</span>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    @foreach($task->users as $user)
                                                        <div class="assignee-info mb-2">
                                                            <img src="{{ $user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random' }}"
                                                                class="assignee-avatar">
                                                            {{ $user->name }}
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $totalUsers = $task->users->count();
                                                    $completedCount = $task->users->filter(function ($user) {
                                                        return $user->pivot->status_id == 3; // Assuming '3' is the ID for 'Completed'
                                                    })->count();

                                                    $completedPercentage = $totalUsers > 0 ? round(($completedCount / $totalUsers) * 100) : 0;
                                                @endphp
                                                <span class="status-badge completed">Completed ({{ $completedPercentage }}%)</span>
                                            </td>
                                            <td>
                                                @if($task->due_date)
                                                    @if($task->due_date->isToday())
                                                        <span class="text-warning">Today</span>
                                                    @elseif($task->due_date->isPast())
                                                        <span class="text-danger">{{ $task->due_date->format('M d') }} (Overdue)</span>
                                                    @else
                                                        {{ $task->due_date->format('M d') }}
                                                    @endif
                                                @else
                                                    <span class="text-muted">Not set</span>
                                                @endif
                                            </td>
                                            <td>
                                                <!-- View Task Modal Trigger -->
                                                <button type="button" class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal"
                                                    data-bs-target="#viewTaskModal{{ $task->id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                <!-- View Task Modal -->
                                                <div class="modal fade" id="viewTaskModal{{ $task->id }}" tabindex="-1"
                                                    aria-labelledby="viewTaskModalLabel{{ $task->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="viewTaskModalLabel{{ $task->id }}">Task
                                                                    Details</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <h6><strong>Title:</strong></h6>
                                                                    <p>{{ $task->title }}</p>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <h6><strong>Description:</strong></h6>
                                                                    <p>{{ $task->description }}</p>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <h6><strong>Priority:</strong></h6>
                                                                    <span
                                                                        class="priority-indicator {{ strtolower($task->priority->name) }}"></span>
                                                                    {{ $task->priority->name }}
                                                                </div>
                                                                <div class="mb-3">
                                                                    <h6><strong>Created By:</strong></h6>
                                                                    <div class="assignee-info">
                                                                        <img src="{{ $task->creator->avatar_url }}" class="assignee-avatar">
                                                                        {{ $task->creator->name }}
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <h6><strong>Assignees and Status:</strong></h6>
                                                                    <ul class="list-group">
                                                                        @foreach($task->users as $user)
                                                                            <li
                                                                                class="list-group-item d-flex align-items-center justify-content-between">
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="{{ $user->avatar__url }}"
                                                                                        class="assignee-avatar me-2">
                                                                                    {{ $user->name }}
                                                                                </div>
                                                                                @php
                                                                                    $userStatus = $statuses->firstWhere('id', $user->pivot->status_id ?? null);
                                                                                    $userStatusName = $userStatus->name ?? 'Pending';
                                                                                    $userStatusClass = strtolower(str_replace(' ', '-', $userStatusName));
                                                                                @endphp
                                                                                <span
                                                                                    class="status-badge {{ $userStatusClass }}">{{ $userStatusName }}</span>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <h6><strong>Due Date:</strong></h6>
                                                                    @if($task->due_date)
                                                                        {{ $task->due_date->format('M d, Y') }}
                                                                    @else
                                                                        <span class="text-muted">Not set</span>
                                                                    @endif
                                                                </div>
                                                                @if($task->attachments->isNotEmpty())
                                                                    <div class="mb-3">
                                                                        <h6><strong>Attachments:</strong></h6>
                                                                        <ul class="list-group">
                                                                            @foreach($task->attachments as $attachment)
                                                                                <li class="list-group-item">
                                                                                    <a href="{{ route('download', $attachment->path) }}"
                                                                                        target="_blank" class="text-primary">
                                                                                        <i
                                                                                            class="fas fa-paperclip me-2"></i>{{ $attachment->filename }}
                                                                                    </a>
                                                                                    <span
                                                                                        class="float-end text-muted small">{{ $attachment->size }}</span>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                            </div>
                            <a href="" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-edit"></i>
                            </a>
                            </td>
                            </tr>
                        @empty
                <tr>
                    <td colspan="6" class="text-center py-4">No tasks found</td>
                </tr>
            @endforelse
            </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($tasks->hasPages())
            <nav class="mt-4 d-flex justify-content-center">
                <ul class="pagination pagination-lg">
                    {{ $tasks->withQueryString()->links('pagination::bootstrap-4') }}
                </ul>
            </nav>
            <style>
                .pagination .page-item.active .page-link {
                    background-color: var(--primary-color) !important;
                    border-color: var(--primary-color) !important;
                    color: white !important;
                }
            </style>
        @endif
    </div>
    </div>

    <script>
        // Make table rows clickable (except for actions)
        document.querySelectorAll('.task-table tbody tr').forEach(row => {
            row.addEventListener('click', (e) => {
                // Don't trigger if clicking on button or anchor
                if (e.target.tagName === 'BUTTON' || e.target.tagName === 'A' || e.target.closest('button') || e.target.closest('a')) {
                    return;
                }

                // Find the first view link in the row and click it
                const viewLink = row.querySelector('a[href*="/tasks/"]');
                if (viewLink) {
                    window.location = viewLink.href;
                }
            });
        });

        // Highlight row on hover
        document.querySelectorAll('.task-table tbody tr').forEach(row => {
            row.style.cursor = 'pointer';
            row.addEventListener('mouseenter', () => {
                row.style.backgroundColor = '#f8f9fa';
            });
            row.addEventListener('mouseleave', () => {
                row.style.backgroundColor = '';
            });
        });
    </script>

@endsection