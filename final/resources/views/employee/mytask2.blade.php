@extends('genview')
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
    </style>

    <div class="main-content">
        @if(session('success'))
            <div class="notification-toast alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session(key: 'success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="top-nav d-flex justify-content-between align-items-center mb-4">
            <button class="sidebar-collapse-btn" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <div class="d-flex align-items-center">
                <div class="position-relative me-3">
                    <i class="fas fa-bell fs-5"></i>
                    <span class="notification-badge">3</span>
                </div>
                <div class="user-profile">
                    <img src="{{ Auth::user()->avatar_url ?? asset('storage/profile/avatars/profile.png') }}" alt="User Profile" class="rounded-circle"
                        width="40">
                    <span>{{ ucwords(strtolower(Auth::user()->name)) }}</span>
                </div>
            </div>
        </div>

        <!-- Tasks Content -->
        <div class="tasks-container">
            <div class="section-header">
                <h4><i class="fas fa-tasks"></i> My Tasks</h4>
                <div>
                    <select class="form-select form-select-sm me-2" style="width: auto; display: inline-block;">
                        <option>Sort by Due Date</option>
                        <option>Sort by Priority</option>
                        <option>Sort by Status</option>
                    </select>
                    <button class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                </div>
            </div>

            <ul class="nav nav-tabs task-tabs" id="taskTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-tasks-tab" data-bs-toggle="tab" data-bs-target="#all-tasks" type="button" role="tab">
                        All Tasks
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="in-progress-tab" data-bs-toggle="tab" data-bs-target="#in-progress-tasks" type="button" role="tab">
                        In Progress
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed-tasks" type="button" role="tab">
                        Completed
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="overdue-tab" data-bs-toggle="tab" data-bs-target="#overdue-tasks" type="button" role="tab">
                        Overdue
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="taskTabsContent">
                <!-- All Tasks Tab -->
                <div class="tab-pane fade show active" id="all-tasks" role="tabpanel">
                    <div class="task-card">
                        <div class="task-card-header">
                            <div>
                                <span class="task-title">Annual Report Preparation</span>
                                <span class="priority-badge priority-high">High Priority</span>
                            </div>
                            <span class="status-badge status-in-progress">In Progress</span>
                        </div>
                        <div class="task-card-body">
                            <div class="task-meta">
                                <span><i class="fas fa-calendar-alt"></i> Due: Today</span>
                                <span><i class="fas fa-user"></i> Assigned by: Sarah Johnson</span>
                            </div>
                            <p class="task-description">
                                Prepare the annual financial report for board review. Include all Q4 figures and year-over-year comparisons.
                            </p>
                            <div class="task-actions">
                                <button class="btn btn-sm btn-outline-primary me-2">
                                    <i class="fas fa-eye me-1"></i> View Details
                                </button>
                                <button class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-check me-1"></i> Mark Complete
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="task-card">
                        <div class="task-card-header">
                            <div>
                                <span class="task-title">Website Redesign</span>
                                <span class="priority-badge priority-medium">Medium Priority</span>
                            </div>
                            <span class="status-badge status-pending">Pending Review</span>
                        </div>
                        <div class="task-card-body">
                            <div class="task-meta">
                                <span><i class="fas fa-calendar-alt"></i> Due: May 20, 2023</span>
                                <span><i class="fas fa-user"></i> Assigned by: Michael Chen</span>
                            </div>
                            <p class="task-description">
                                Complete the redesign of the company website with new branding guidelines. Homepage and product pages need updating.
                            </p>
                            <div class="task-actions">
                                <button class="btn btn-sm btn-outline-primary me-2">
                                    <i class="fas fa-eye me-1"></i> View Details
                                </button>
                                <button class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-edit me-1"></i> Update Status
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="task-card">
                        <div class="task-card-header">
                            <div>
                                <span class="task-title">IT Infrastructure Upgrade</span>
                                <span class="priority-badge priority-low">Low Priority</span>
                            </div>
                            <span class="status-badge status-completed">Completed</span>
                        </div>
                        <div class="task-card-body">
                            <div class="task-meta">
                                <span><i class="fas fa-calendar-alt"></i> Due: April 30, 2023</span>
                                <span><i class="fas fa-user"></i> Assigned by: Robert Kim</span>
                            </div>
                            <p class="task-description">
                                Upgrade server infrastructure and migrate to cloud-based solutions. Complete documentation of the process.
                            </p>
                            <div class="task-actions">
                                <button class="btn btn-sm btn-outline-primary me-2">
                                    <i class="fas fa-eye me-1"></i> View Details
                                </button>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-file-export me-1"></i> Export Report
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- In Progress Tab -->
                <div class="tab-pane fade" id="in-progress-tasks" role="tabpanel">
                    <!-- Content would be loaded dynamically -->
                    <div class="task-card">
                        <div class="task-card-header">
                            <div>
                                <span class="task-title">Annual Report Preparation</span>
                                <span class="priority-badge priority-high">High Priority</span>
                            </div>
                            <span class="status-badge status-in-progress">In Progress</span>
                        </div>
                        <div class="task-card-body">
                            <div class="task-meta">
                                <span><i class="fas fa-calendar-alt"></i> Due: Today</span>
                                <span><i class="fas fa-user"></i> Assigned by: Sarah Johnson</span>
                            </div>
                            <p class="task-description">
                                Prepare the annual financial report for board review. Include all Q4 figures and year-over-year comparisons.
                            </p>
                            <div class="task-actions">
                                <button class="btn btn-sm btn-outline-primary me-2">
                                    <i class="fas fa-eye me-1"></i> View Details
                                </button>
                                <button class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-check me-1"></i> Mark Complete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Completed Tab -->
                <div class="tab-pane fade" id="completed-tasks" role="tabpanel">
                    <!-- Content would be loaded dynamically -->
                    <div class="task-card">
                        <div class="task-card-header">
                            <div>
                                <span class="task-title">IT Infrastructure Upgrade</span>
                                <span class="priority-badge priority-low">Low Priority</span>
                            </div>
                            <span class="status-badge status-completed">Completed</span>
                        </div>
                        <div class="task-card-body">
                            <div class="task-meta">
                                <span><i class="fas fa-calendar-alt"></i> Due: April 30, 2023</span>
                                <span><i class="fas fa-user"></i> Assigned by: Robert Kim</span>
                            </div>
                            <p class="task-description">
                                Upgrade server infrastructure and migrate to cloud-based solutions. Complete documentation of the process.
                            </p>
                            <div class="task-actions">
                                <button class="btn btn-sm btn-outline-primary me-2">
                                    <i class="fas fa-eye me-1"></i> View Details
                                </button>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-file-export me-1"></i> Export Report
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Overdue Tab -->
                <div class="tab-pane fade" id="overdue-tasks" role="tabpanel">
                    <!-- Content would be loaded dynamically -->
                    <div class="empty-state">
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <h5>No Overdue Tasks</h5>
                        <p>You currently have no tasks that are overdue. Keep up the good work!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-hide notification after 5 seconds
        document.addEventListener('DOMContentLoaded', function () {
            const notification = document.querySelector('.notification-toast');
            if (notification) {
                setTimeout(() => {
                    notification.classList.remove('show');
                    notification.classList.add('hide');
                }, 5000);
            }
        });
    </script>
@endsection