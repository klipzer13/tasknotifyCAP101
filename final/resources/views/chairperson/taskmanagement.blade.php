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

        .status-pending_approval {
            background-color: #f3e5f5;
            color: #9c27b0;
        }

        .status-rejected {
            background-color: #efebe9;
            color: #795548;
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

        .status-pending-approval {
            background-color: #f3e5f5;
            color: #9c27b0;
        }

        .status-approved {
            background-color: #e8f5e9;
            color: #4caf50;
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

        .bulk-actions {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .assignee-checkbox {
            margin-right: 10px;
        }

        .rejection-modal textarea {
            min-height: 120px;
        }

        /* Document status specific styles */
        .document-approved {
            border-left: 4px solid var(--success-color) !important;
        }

        .document-rejected {
            border-left: 4px solid var(--danger-color) !important;
        }

        .document-pending {
            border-left: 4px solid var(--warning-color) !important;
        }

        .document-status-badge {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
        }

        .rejection-reason {
            background-color: #f8d7da;
            border-left: 3px solid var(--danger-color);
            padding: 0.5rem;
            border-radius: 0.25rem;
            margin-top: 0.5rem;
        }

        .completion-progress {
            height: 8px;
            border-radius: 4px;
        }

        .comment-input-container {
            position: relative;
            margin-top: 15px;
        }

        .comment-submit-btn {
            position: absolute;
            right: 8px;
            bottom: 8px;
            border: none;
            background: transparent;
            color: var(--primary-color);
            transition: var(--transition);
        }

        .comment-submit-btn:hover {
            color: var(--primary-hover);
        }

        .submission-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border-top: 1px solid #dee2e6;
            background-color: #f8f9fa;
        }

        .document-status {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
        }

        .rejection-reason-box {
            background-color: #fff3f3;
            border-left: 3px solid #ff6b6b;
            padding: 0.75rem;
            border-radius: 0.25rem;
            margin-top: 0.5rem;
            font-size: 0.875rem;
        }

        .task-count-badge {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
            padding: 0.25em 0.5em;
            border-radius: 10px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* New styles for document approval */
        .document-card {
            border-radius: 8px;
            border: 1px solid #e9ecef;
            margin-bottom: 16px;
            transition: all 0.2s ease;
        }

        .document-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .document-card-header {
            padding: 12px 16px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            border-radius: 8px 8px 0 0;
        }

        .document-card-body {
            padding: 16px;
        }

        .document-actions {
            display: flex;
            gap: 8px;
            margin-top: 12px;
        }

        .document-preview {
            max-width: 100%;
            max-height: 200px;
            border-radius: 4px;
            margin-top: 8px;
        }

        .document-icon {
            font-size: 1.5rem;
            color: #6c757d;
        }

        .review-modal .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .review-modal .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            border-radius: 12px 12px 0 0;
            padding: 1rem 1.5rem;
        }

        .review-modal .modal-body {
            padding: 1.5rem;
        }

        .review-modal .modal-footer {
            border-top: 1px solid #e9ecef;
            padding: 1rem 1.5rem;
        }

        .document-review-item {
            padding: 12px;
            border-radius: 8px;
            background-color: #f8f9fa;
            margin-bottom: 12px;
        }

        .document-review-item:last-child {
            margin-bottom: 0;
        }

        .document-review-name {
            font-weight: 600;
            color: #2c3e50;
        }

        .document-review-status {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
        }

        .review-action-buttons {
            display: flex;
            gap: 8px;
            margin-top: 12px;
        }

        .document-progress-section {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .document-progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .document-progress-stats {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .document-progress-percentage {
            font-weight: 600;
            color: var(--primary-color);
        }

        .document-section {
            margin-bottom: 2rem;
        }

        .document-section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e9ecef;
        }

        .assignee-documents {
            margin-bottom: 1.5rem;
        }

        .assignee-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding: 0.75rem;
            background-color: #f8f9fa;
            border-radius: 8px;
        }

        .assignee-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 0.75rem;
        }

        .assignee-info {
            flex: 1;
        }

        .assignee-name {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .assignee-document-stats {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .document-item {
            padding: 1rem;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            margin-bottom: 1rem;
            background-color: #fff;
        }

        .document-item-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.75rem;
        }

        .document-name {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .document-description {
            color: #6c757d;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        .document-meta {
            display: flex;
            gap: 1rem;
            font-size: 0.875rem;
            color: #6c757d;
            margin-bottom: 0.75rem;
        }

        .document-submission-info {
            background-color: #f8f9fa;
            padding: 0.75rem;
            border-radius: 6px;
            margin-bottom: 0.75rem;
        }

        .document-submission-date {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .document-actions {
            display: flex;
            gap: 0.5rem;
        }

        .no-documents {
            text-align: center;
            padding: 2rem;
            color: #6c757d;
        }

        .no-documents i {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #adb5bd;
        }
    </style>

    <!-- Top Navigation -->

    <div class="task-management-container">
        <div class="section-header d-flex justify-content-between align-items-center">
            <h4><i class="fas fa-tasks"></i> Task Management</h4>
            <a href="{{ route('chairassign.task') }}" class="btn create-task-btn">
                <i class="fas fa-plus me-2" style="color: #fff; display: inline;"></i> <span
                    style="color: #fff; display: inline;">Create New Task</span>
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
                                <a href="#" class="btn btn-sm btn-outline-primary me-2 d-flex align-items-center view-task-btn"
                                    data-bs-toggle="modal" data-bs-target="#taskViewModal"
                                    data-assignee-id="{{ $assignee->id }}" data-task-id="{{ $task->id }}">
                                    <i class="fas fa-eye me-1"></i>
                                    <span>View Details</span>
                                </a>
                                <form action="{{ route('chairperson.tasks.delete', ['task' => $task->id]) }}" method="POST"
                                    class="d-inline delete-task-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger delete-task-btn"
                                        onclick="confirmDelete(this)">
                                        <i class="fas fa-trash-alt me-1"></i> Delete
                                    </button>
                                </form>
                            </div>
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
                    <!-- Bulk Actions -->
                    <div class="bulk-actions" id="bulkActionsContainer" style="display: none;">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="selectAllPending">
                            <label class="form-check-label" for="selectAllPending">
                                Select All
                            </label>
                        </div>
                        <span id="selectedCount" class="badge bg-primary">0 selected</span>
                        <button class="btn btn-sm btn-success" id="bulkApproveBtn">
                            <i class="fas fa-check-circle me-1"></i> Approve Selected
                        </button>
                        <button class="btn btn-sm btn-danger" id="bulkRejectBtn" data-bs-toggle="modal"
                            data-bs-target="#rejectionModal">
                            <i class="fas fa-times-circle me-1"></i> Reject Selected
                        </button>
                        <button class="btn btn-sm btn-outline-secondary" id="clearSelectionBtn">
                            <i class="fas fa-times me-1"></i> Clear
                        </button>
                    </div>

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
                                            <div class="d-flex align-items-center">
                                                <input type="checkbox" class="assignee-checkbox me-2"
                                                    data-task-id="{{ $assignment->task->id }}" data-assignee-id="{{ $assignee->id }}">
                                                <div>
                                                    <span class="task-title">{{ $assignment->task->title }}</span>
                                                    <span
                                                        class="priority-badge priority-{{ $assignment->task->priority->name ?? 'medium' }}">
                                                        {{ ucfirst($assignment->task->priority->name ?? 'Medium') }} Priority
                                                    </span>
                                                </div>
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
                                                <button class="btn btn-sm btn-outline-primary view-task-btn" data-bs-toggle="modal"
                                                    data-bs-target="#taskViewModal" data-assignee-id="{{ $assignee->id }}"
                                                    data-task-id="{{ $assignment->task->id }}">
                                                    <i class="fas fa-eye me-1"></i> View Details
                                                </button>

                                                <form
                                                    action="{{ route('chairperson.tasks.approve-assignee', ['task' => $assignment->task->id, 'user' => $assignee->id]) }}"
                                                    method="POST" class="d-inline me-2">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                                        <i class="fas fa-check me-1"></i> Approve
                    
                                                    </button>
                                                </form>
                                                <button class="btn btn-sm btn-outline-danger reject-btn"
                                                    data-task-id="{{ $assignment->task->id }}" data-assignee-id="{{ $assignee->id }}"
                                                    data-assignee-name="{{ $assignee->name }}"
                                                    data-task-title="{{ $assignment->task->title }}" data-bs-toggle="modal"
                                                    data-bs-target="#rejectionModal">
                                                    <i class="fas fa-times me-1"></i> Reject
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
                                                <button class="btn btn-sm btn-outline-primary view-task-btn" data-bs-toggle="modal"
                                                    data-bs-target="#taskViewModal" data-assignee-id="{{ $assignee->id }}"
                                                    data-task-id="{{ $assignment->task->id }}">
                                                    <i class="fas fa-eye me-1"></i> View Details
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
                                                <button class="btn btn-sm btn-outline-primary view-task-btn" data-bs-toggle="modal"
                                                    data-bs-target="#taskViewModal" data-assignee-id="{{ $assignee->id }}"
                                                    data-task-id="{{ $assignment->task->id }}">
                                                    <i class="fas fa-eye me-1"></i> View Details
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
                    <input type="hidden" id="submission_task_id" name="task_id" value="{{ $task->id }}">
                    <div id="task-loading-indicator" class="text-center py-5">
                        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-3 text-muted">Loading task details...</p>
                    </div>
                    <div id="task-error-container" class="d-none">
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <span id="task-error-message"></span>
                        </div>
                        <div class="text-center mt-3">
                            <button id="task-error-retry" class="btn btn-primary">
                                <i class="fas fa-refresh me-2"></i> Try Again
                            </button>
                        </div>
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

                        <!-- Task Completion Progress -->
                        <div class="document-progress-section mb-4" id="document-progress-container" style="display: none;">
                            <div class="document-progress-header">
                                <h6 class="mb-0">Document Completion Progress</h6>
                                <span class="document-progress-percentage" id="document-progress-percentage">0%</span>
                            </div>
                            <div class="document-progress-stats" id="document-progress-stats">0 of 0 documents approved
                            </div>
                            <div class="progress completion-progress mt-2">
                                <div id="document-progress-bar" class="progress-bar" role="progressbar" aria-valuenow="0"
                                    aria-valuemin="0" aria-valuemax="100"></div>
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

                                <!-- Comment Input -->
                                <div class="comment-input-container mt-3">
                                    <textarea id="comment-input" class="form-control" rows="2"
                                        placeholder="Add a comment..."></textarea>
                                    <button id="comment-submit-btn" class="comment-submit-btn">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Submitted Documents Section -->
                        <div class="document-section" id="submitted-documents-container" style="display: none;">
                            <h5 class="document-section-title">Submitted Documents</h5>
                            <div id="submitted-documents-list"></div>
                        </div>

                    </div>
                </div>

                <!-- Submission Footer with Approve/Reject and Close buttons -->
                <div class="submission-footer" id="submission-footer" style="display: none;">
                    <div class="completion-info" id="completion-info"></div>
                    <div>
                        <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger me-2" id="rejectTaskBtn" data-bs-toggle="modal"
                            data-bs-target="#rejectionModal">
                            <i class="fas fa-times-circle me-2"></i> Reject Task
                        </button>
                        <button type="button" class="btn btn-success" id="approveTaskBtn">
                            <i class="fas fa-check-circle me-2"></i> Approve Task
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rejection Modal -->
    <div class="modal fade review-modal" id="rejectionModal" tabindex="-1" aria-labelledby="rejectionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="rejectionModalLabel">Reject Task Submission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rejectionReason" class="form-label">Reason for Rejection</label>
                        <textarea class="form-control" id="rejectionReason" rows="4"
                            placeholder="Please provide the reason for rejecting this task submission..."></textarea>
                    </div>
                    <div id="rejectionDocumentsList" class="mt-3">
                        <!-- Documents will be listed here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmRejectionBtn">Confirm Rejection</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Document Rejection Modal -->
    <div class="modal fade review-modal" id="documentRejectionModal" tabindex="-1"
        aria-labelledby="documentRejectionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="documentRejectionModalLabel">Reject Document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="documentRejectionReason" class="form-label">Reason for Rejection</label>
                        <textarea class="form-control" id="documentRejectionReason" rows="4"
                            placeholder="Please provide the reason for rejecting this document..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDocumentRejectionBtn">Confirm Rejection</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const viewTaskButtons = document.querySelectorAll('.view-task-btn');
            const taskViewModal = new bootstrap.Modal(document.getElementById('taskViewModal'));

            viewTaskButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const taskId = this.getAttribute('data-task-id');
                    const assigneeId = this.getAttribute('data-assignee-id');
                    console.log('View Task Button Clicked - Task ID:', taskId, 'Assignee ID:', assigneeId);

                    // Store assignee ID for later use
                    document.getElementById('current_assignee_id').value = assigneeId;
                    document.getElementById('submission_task_id').value = taskId;

                    showTaskLoadingState();
                    loadTaskDetails(taskId, assigneeId);
                    taskViewModal.show();
                });
            });

            // Retry button event listener
            document.getElementById('task-error-retry').addEventListener('click', function () {
                const taskId = document.getElementById('submission_task_id').value;
                const assigneeId = document.getElementById('current_assignee_id').value;
                showTaskLoadingState();
                loadTaskDetails(taskId, assigneeId);
            });

            // Comment submit button
            document.getElementById('comment-submit-btn').addEventListener('click', function () {
                submitComment();
            });

            // Approve task button
            document.getElementById('approveTaskBtn').addEventListener('click', function () {
                approveTask();
            });

            // Reject task button
            document.getElementById('rejectTaskBtn').addEventListener('click', function () {
                prepareRejectionModal();
            });

            // Confirm rejection button
            document.getElementById('confirmRejectionBtn').addEventListener('click', function () {
                rejectTask();
            });

            // Document approval buttons
            document.addEventListener('click', function (e) {
                if (e.target.classList.contains('approve-document-btn')) {
                    const documentId = e.target.getAttribute('data-document-id');
                    approveDocument(documentId);
                }

                if (e.target.classList.contains('reject-document-btn')) {
                    const documentId = e.target.getAttribute('data-document-id');
                    const documentName = e.target.closest('.document-item').querySelector('.document-name').textContent;
                    openDocumentRejectionModal(documentId, documentName);
                }
            });

            // Confirm document rejection button
            document.getElementById('confirmDocumentRejectionBtn').addEventListener('click', function () {
                const documentId = document.getElementById('currentRejectDocumentId').value;
                const reason = document.getElementById('documentRejectionReason').value;
                rejectDocument(documentId, reason);
            });
        });

        // Helper function to safely handle submitted documents
        function getSubmittedDocuments(assignee) {
            if (!assignee) return [];

            const submittedDocs = assignee.submitted_documents;

            // Handle null/undefined
            if (submittedDocs === null || submittedDocs === undefined) {
                return [];
            }

            // If it's already an array, return it
            if (Array.isArray(submittedDocs)) {
                return submittedDocs;
            }

            // If it's an object, convert it to an array
            if (typeof submittedDocs === 'object') {
                try {
                    // Check if it's an object with numeric keys (like {1: {...}, 2: {...}})
                    if (Object.keys(submittedDocs).every(key => !isNaN(key))) {
                        return Object.values(submittedDocs);
                    } else {
                        // It might be a single document object
                        return [submittedDocs];
                    }
                } catch (e) {
                    console.error('Error converting submitted_documents to array:', e);
                    return [];
                }
            }

            // Fallback for any other data type
            return [];
        }

        function showTaskLoadingState() {
            document.getElementById('task-loading-indicator').style.display = 'block';
            document.getElementById('task-details-container').style.display = 'none';
            document.getElementById('task-error-container').style.display = 'none';
            document.getElementById('submission-footer').style.display = 'none';
        }

        function showTaskDetails() {
            document.getElementById('task-loading-indicator').style.display = 'none';
            document.getElementById('task-details-container').style.display = 'block';
            document.getElementById('task-error-container').style.display = 'none';

            // Show submission footer if task is pending approval
            const taskStatus = document.getElementById('task-modal-status').textContent.toLowerCase();
            if (taskStatus === 'pending_approval' || taskStatus === 'pending approval') {
                document.getElementById('submission-footer').style.display = 'flex';
            }
        }

        function showTaskError(errorMessage) {
            document.getElementById('task-loading-indicator').style.display = 'none';
            document.getElementById('task-details-container').style.display = 'none';
            document.getElementById('task-error-container').style.display = 'flex';
            document.getElementById('task-error-message').textContent = errorMessage || 'Failed to load task details.';
            document.getElementById('submission-footer').style.display = 'none';
        }

        function loadTaskDetails(taskId, assigneeId) {
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

                    // Find the specific assignee from the task data
                    const currentAssignee = task.assignees ?
                        task.assignees.find(a => a.id === parseInt(assigneeId)) : null;

                    if (!currentAssignee) {
                        console.warn('Assignee not found in task data');
                    }

                    // Populate basic task info (remains the same)
                    document.getElementById('task-modal-title').textContent = task.title;
                    document.getElementById('task-modal-description').textContent = task.description;

                    // Show status for specific assignee if available
                    if (currentAssignee && currentAssignee.pivot) {
                        const assigneeStatus = currentAssignee.pivot.status?.name || 'pending';
                        document.getElementById('task-modal-status').textContent = assigneeStatus;
                        document.getElementById('task-modal-status').className = `badge rounded-pill ${getStatusClass(assigneeStatus)}`;

                        // Show approval buttons only if this assignee's status is pending_approval
                        if (assigneeStatus === 'pending_approval' || assigneeStatus === 'pending approval') {
                            document.getElementById('submission-footer').style.display = 'flex';
                        } else {
                            document.getElementById('submission-footer').style.display = 'none';
                        }
                    } else {
                        document.getElementById('task-modal-status').textContent = task.overall_status || task.status;
                        document.getElementById('task-modal-status').className = `badge rounded-pill ${getStatusClass(task.overall_status || task.status)}`;
                    }

                    // Priority display
                    if (task.priority) {
                        document.getElementById('task-modal-priority').textContent = task.priority.name;
                        document.getElementById('task-modal-priority').className = `badge rounded-pill ${getPriorityClass(task.priority.name)}`;
                    }

                    document.getElementById('task-modal-due-date').textContent = `Due: ${task.due_date_formatted}`;
                    document.getElementById('task-modal-creator').textContent = task.creator.name;
                    document.getElementById('task-modal-created-at').textContent = task.created_at_formatted;

                    // Calculate document progress for ONLY the current assignee
                    if (task.require_documents && task.required_documents && task.required_documents.length > 0 && currentAssignee) {
                        let totalApproved = 0;
                        let totalDocuments = 0;

                        const submittedDocs = getSubmittedDocuments(currentAssignee);
                        submittedDocs.forEach(doc => {
                            totalDocuments++;
                            if (doc.status === 'approved') {
                                totalApproved++;
                            }
                        });

                        const completionPercentage = totalDocuments > 0 ?
                            Math.round((totalApproved / totalDocuments) * 100) : 0;

                        document.getElementById('document-progress-stats').textContent =
                            `${totalApproved} of ${totalDocuments} documents approved`;
                        document.getElementById('document-progress-percentage').textContent =
                            `${completionPercentage}%`;
                        document.getElementById('document-progress-bar').style.width =
                            `${completionPercentage}%`;
                        document.getElementById('document-progress-bar').className =
                            `progress-bar ${completionPercentage === 100 ? 'bg-success' : 'bg-primary'}`;

                        document.getElementById('document-progress-container').style.display =
                            totalDocuments > 0 ? 'block' : 'none';
                    } else {
                        document.getElementById('document-progress-container').style.display = 'none';
                    }

                    // Load submitted documents FOR ONLY THE CURRENT ASSIGNEE
                    const submittedDocsContainer = document.getElementById('submitted-documents-container');
                    const submittedDocsList = document.getElementById('submitted-documents-list');
                    submittedDocsList.innerHTML = '';

                    if (currentAssignee) {
                        const submittedDocs = getSubmittedDocuments(currentAssignee);

                        if (submittedDocs.length > 0) {
                            submittedDocsContainer.style.display = 'block';

                            // Create section for this specific assignee only
                            const assigneeSection = document.createElement('div');
                            assigneeSection.className = 'assignee-documents';
                            assigneeSection.setAttribute('data-assignee-id', currentAssignee.id);

                            assigneeSection.innerHTML = `
                                        <div class="assignee-header">
                                            <img src="${currentAssignee.avatar_url || '/storage/profile/avatars/profile.png'}" 
                                                 class="assignee-avatar" alt="${currentAssignee.name}">
                                            <div class="assignee-info">
                                                <div class="assignee-name">${currentAssignee.name}</div>
                                                <div class="assignee-document-stats">
                                                    ${submittedDocs.length} document(s) submitted
                                                </div>
                                            </div>
                                        </div>
                                    `;

                            const documentsList = document.createElement('div');
                            documentsList.className = 'documents-list';

                            submittedDocs.forEach(doc => {
                                if (!doc || typeof doc !== 'object') return;

                                const status = doc.status || 'pending';
                                const statusClass = getDocumentStatusClass(status);
                                const statusText = status.charAt(0).toUpperCase() + status.slice(1);
                                const documentName = doc.required_document_name || 'Unnamed Document';
                                const fileName = doc.filename || 'Unknown file';
                                const filePath = doc.file_path || doc.filename || '';
                                const submittedAt = doc.submitted_at || 'Unknown date';

                                const docElement = document.createElement('div');
                                docElement.className = 'document-item';
                                docElement.innerHTML = `
                                            <div class="document-item-header">
                                                <div>
                                                    <div class="document-name">${documentName}</div>
                                                    <div class="document-description">Submitted: ${submittedAt}</div>
                                                </div>
                                                <span class="badge ${statusClass}">${statusText}</span>
                                            </div>
                                            <div class="document-meta">
                                                <span><i class="fas fa-file"></i> ${fileName}</span>
                                            </div>
                                            ${filePath ? `
                                            <div class="document-submission-info">
                                                <a href="/storage/${filePath}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-download me-1"></i> View Document
                                                </a>
                                            </div>
                                            ` : ''}
                                            ${status === 'rejected' && doc.rejection_reason ? `
                                                <div class="rejection-reason-box">
                                                    <strong>Rejection Reason:</strong> ${doc.rejection_reason}
                                                </div>
                                            ` : ''}
                                            <div class="document-actions">
                                                ${status === 'pending' ? `
                                                    <button class="btn btn-sm btn-success approve-document-btn" 
                                                            data-document-id="${doc.id}" 
                                                            data-assignee-id="${currentAssignee.id}">
                                                        <i class="fas fa-check me-1"></i> Approve
                                                    </button>
                                                    <button class="btn btn-sm btn-danger reject-document-btn" 
                                                            data-document-id="${doc.id}"
                                                            data-assignee-id="${currentAssignee.id}">
                                                        <i class="fas fa-times me-1"></i> Reject
                                                    </button>
                                                ` : ''}
                                                ${status === 'approved' ? `
                                                    <span class="text-success"><i class="fas fa-check-circle me-1"></i> Approved</span>
                                                ` : ''}
                                                ${status === 'rejected' ? `
                                                    <span class="text-danger"><i class="fas fa-times-circle me-1"></i> Rejected</span>
                                                ` : ''}
                                            </div>
                                        `;
                                documentsList.appendChild(docElement);
                            });

                            assigneeSection.appendChild(documentsList);
                            submittedDocsList.appendChild(assigneeSection);
                        } else {
                            submittedDocsContainer.innerHTML = `
                                        <div class="no-documents">
                                            <i class="fas fa-folder-open"></i>
                                            <p>No documents submitted by ${currentAssignee.name} yet</p>
                                        </div>
                                    `;
                            submittedDocsContainer.style.display = 'block';
                        }
                    } else {
                        submittedDocsContainer.style.display = 'none';
                    }

                    // Load attachments (unchanged)
                    const attachmentsContainer = document.getElementById('task-modal-attachments');
                    attachmentsContainer.innerHTML = '';
                    if (task.attachments && task.attachments.length > 0) {
                        task.attachments.forEach(attachment => {
                            const attachmentElement = document.createElement('div');
                            attachmentElement.className = 'mb-2';

                            if (attachment.mime_type && attachment.mime_type.startsWith('image/')) {
                                attachmentElement.innerHTML = `
                                            <a href="${attachment.url}" target="_blank" class="d-block">
                                                <img src="${attachment.url}" class="attachment-thumbnail" 
                                                     alt="${attachment.original_name}" title="${attachment.original_name}">
                                            </a>
                                            <small class="d-block text-muted text-truncate" style="max-width: 100px">${attachment.original_name}</small>
                                        `;
                            } else {
                                attachmentElement.innerHTML = `
                                            <a href="${attachment.url}" target="_blank" class="d-block text-center">
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

                    // Load comments (unchanged)
                    const commentsContainer = document.getElementById('task-modal-comments');
                    commentsContainer.innerHTML = '';
                    if (task.comments && task.comments.length > 0) {
                        const sortedComments = [...task.comments].sort((a, b) =>
                            new Date(b.created_at) - new Date(a.created_at)
                        );

                        sortedComments.forEach(comment => {
                            const commentElement = document.createElement('div');
                            commentElement.className = 'comment-item';

                            const isOwnComment = comment.user.id === {{ Auth::id() }};

                            commentElement.innerHTML = `
                                        <div class="comment-bubble ${isOwnComment ? 'own' : 'other'}">
                                            <div class="d-flex align-items-center mb-2">
                                                <img src="${comment.user.avatar_url || '/storage/profile/avatars/profile.png'}" 
                                                     class="user-avatar" alt="${comment.user.name}" width="32" height="32">
                                                <div class="ms-2">
                                                    <span class="comment-user">${comment.user.name}</span>
                                                    <span class="comment-time ms-2">${comment.created_at}</span>
                                                </div>
                                            </div>
                                            <p class="mb-0">${comment.content}</p>
                                        </div>
                                    `;
                            commentsContainer.appendChild(commentElement);
                        });
                    } else {
                        commentsContainer.innerHTML = '<p class="text-muted">No comments yet</p>';
                    }

                    showTaskDetails();
                })
                .catch(error => {
                    console.error('Error loading task details:', error);
                    showTaskError(error.message || 'Failed to load task details. Please try again.');
                });
        }

        function submitComment() {
            const commentText = document.getElementById('comment-input').value.trim();
            const taskId = document.getElementById('submission_task_id').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            if (!commentText) {
                showToast('Please enter a comment', 'error');
                return;
            }

            if (!taskId) {
                showToast('Unable to determine task ID. Please reopen the task details.', 'error');
                return;
            }

            if (!csrfToken) {
                showToast('Security token missing. Please refresh the page.', 'error');
                return;
            }

            // Show loading state on button
            const submitBtn = document.getElementById('comment-submit-btn');
            const originalHtml = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            submitBtn.disabled = true;

            fetch("{{ route('chair.tasks.comment') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    task_id: taskId,
                    comment: commentText
                })
            })
                .then(response => {
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json().then(data => {
                            return { data, response };
                        });
                    } else {
                        return response.text().then(text => {
                            throw new Error('Server returned non-JSON response');
                        });
                    }
                })
                .then(({ data, response }) => {
                    if (response.ok && data.success) {
                        document.getElementById('comment-input').value = '';
                        loadTaskDetails(taskId); // Reload task details to show new comment
                        showToast('Comment added successfully', 'success');
                    } else {
                        throw new Error(data.message || `Server error: ${response.status}`);
                    }
                })
                .catch(error => {
                    console.error('Error submitting comment:', error);
                    showToast(error.message || 'Failed to add comment. Please try again.', 'error');
                })
                .finally(() => {
                    // Restore button state
                    submitBtn.innerHTML = originalHtml;
                    submitBtn.disabled = false;
                });
        }

        function approveTask() {
            const taskId = document.getElementById('submission_task_id').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            if (!taskId) {
                showToast('Unable to determine task ID. Please reopen the task details.', 'error');
                return;
            }

            if (!csrfToken) {
                showToast('Security token missing. Please refresh the page.', 'error');
                return;
            }

            // Show loading state on button
            const approveBtn = document.getElementById('approveTaskBtn');
            const originalHtml = approveBtn.innerHTML;
            approveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Approving...';
            approveBtn.disabled = true;

            fetch("{{ route('chairperson.tasks.approve') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    task_id: taskId
                })
            })
                .then(response => {
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json().then(data => {
                            return { data, response };
                        });
                    } else {
                        return response.text().then(text => {
                            throw new Error('Server returned non-JSON response');
                        });
                    }
                })
                .then(({ data, response }) => {
                    if (response.ok && data.success) {
                        showToast('Task approved successfully!', 'success');

                        // Close modal after a brief delay
                        setTimeout(() => {
                            const modal = bootstrap.Modal.getInstance(document.getElementById('taskViewModal'));
                            if (modal) {
                                modal.hide();
                            }
                            location.reload(); // Reload page to reflect changes
                        }, 1500);
                    } else {
                        throw new Error(data.message || `Server error: ${response.status}`);
                    }
                })
                .catch(error => {
                    console.error('Error approving task:', error);
                    showToast(error.message || 'Failed to approve task. Please try again.', 'error');
                })
                .finally(() => {
                    // Restore button state
                    approveBtn.disabled = false;
                    approveBtn.innerHTML = originalHtml;
                });
        }

        function prepareRejectionModal() {
            const taskId = document.getElementById('submission_task_id').value;

            // Clear previous content
            document.getElementById('rejectionReason').value = '';
            document.getElementById('rejectionDocumentsList').innerHTML = '';

            // Fetch task details to list documents in rejection modal
            fetch(`/tasks/${taskId}/details`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const task = data.data;

                        if (task.require_documents && task.required_documents && task.required_documents.length > 0) {
                            let documentsHTML = '<h6 class="mb-2">Documents to be rejected:</h6>';

                            task.required_documents.forEach(doc => {
                                documentsHTML += `
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" value="${doc.id}" id="rejectDoc${doc.id}" checked>
                                                        <label class="form-check-label" for="rejectDoc${doc.id}">
                                                            ${doc.name}
                                                        </label>
                                                    </div>
                                                `;
                            });

                            document.getElementById('rejectionDocumentsList').innerHTML = documentsHTML;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error loading task details for rejection:', error);
                });
        }

        function rejectTask() {
            const taskId = document.getElementById('submission_task_id').value;
            const rejectionReason = document.getElementById('rejectionReason').value;
            console.log('Rejection Reason:', rejectionReason, 'Task ID:', taskId);
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            if (!rejectionReason) {
                showToast('Please provide a reason for rejection', 'error');
                return;
            }

            if (!taskId) {
                showToast('Unable to determine task ID. Please reopen the task details.', 'error');
                return;
            }

            if (!csrfToken) {
                showToast('Security token missing. Please refresh the page.', 'error');
                return;
            }

            // Get selected documents to reject
            const documentCheckboxes = document.querySelectorAll('#rejectionDocumentsList input[type="checkbox"]:checked');
            const documentIds = Array.from(documentCheckboxes).map(cb => cb.value);

            // Show loading state on button
            const rejectBtn = document.getElementById('confirmRejectionBtn');
            const originalHtml = rejectBtn.innerHTML;
            rejectBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Rejecting...';
            rejectBtn.disabled = true;


            fetch("{{ route('chairperson.tasks.reject') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    task_id: taskId,
                    reason: rejectionReason,
                    document_ids: documentIds
                })
            })
                .then(response => {
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json().then(data => {
                            return { data, response };
                        });
                    } else {
                        return response.text().then(text => {
                            throw new Error('Server returned non-JJSON response');
                        });
                    }
                })
                .then(({ data, response }) => {
                    if (response.ok && data.success) {
                        showToast('Task rejected successfully!', 'success');

                        // Close modals after a brief delay
                        setTimeout(() => {
                            const rejectionModal = bootstrap.Modal.getInstance(document.getElementById('rejectionModal'));
                            if (rejectionModal) {
                                rejectionModal.hide();
                            }

                            const taskModal = bootstrap.Modal.getInstance(document.getElementById('taskViewModal'));
                            if (taskModal) {
                                taskModal.hide();
                            }

                            location.reload(); // Reload page to reflect changes
                        }, 1500);
                    } else {
                        throw new Error(data.message || `Server error: ${response.status}`);
                    }
                })
                .catch(error => {
                    console.error('Error rejecting task:', error);
                    showToast(error.message || 'Failed to reject task. Please try again.', 'error');
                })
                .finally(() => {
                    // Restore button state
                    rejectBtn.disabled = false;
                    rejectBtn.innerHTML = originalHtml;
                });
        }

        function approveDocument(documentId) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            if (!csrfToken) {
                showToast('Security token missing. Please refresh the page.', 'error');
                return;
            }

            // Show loading state on button
            const approveBtn = document.querySelector(`.approve-document-btn[data-document-id="${documentId}"]`);
            const originalHtml = approveBtn.innerHTML;
            approveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            approveBtn.disabled = true;

            fetch("{{ route('chairperson.documents.approve') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    document_id: documentId
                })
            })
                .then(response => {
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json().then(data => {
                            return { data, response };
                        });
                    } else {
                        return response.text().then(text => {
                            throw new Error('Server returned non-JSON response');
                        });
                    }
                })
                .then(({ data, response }) => {
                    if (response.ok && data.success) {
                        showToast('Document approved successfully!', 'success');

                        // Reload task details to reflect changes
                        const taskId = document.getElementById('submission_task_id').value;
                        loadTaskDetails(taskId);
                    } else {
                        throw new Error(data.message || `Server error: ${response.status}`);
                    }
                })
                .catch(error => {
                    console.error('Error approving document:', error);
                    showToast(error.message || 'Failed to approve document. Please try again.', 'error');
                })
                .finally(() => {
                    // Restore button state
                    approveBtn.disabled = false;
                    approveBtn.innerHTML = originalHtml;
                });
        }

        function openDocumentRejectionModal(documentId, documentName) {
            // Store the current document ID being rejected
            document.getElementById('currentRejectDocumentId').value = documentId;

            // Update modal title with document name
            document.getElementById('documentRejectionModalLabel').textContent = `Reject Document: ${documentName}`;

            // Clear previous rejection reason
            document.getElementById('documentRejectionReason').value = '';

            // Show the modal
            const rejectionModal = new bootstrap.Modal(document.getElementById('documentRejectionModal'));
            rejectionModal.show();
        }

        function rejectDocument(documentId, reason) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            if (!reason) {
                showToast('Please provide a reason for rejection', 'error');
                return;
            }

            if (!csrfToken) {
                showToast('Security token missing. Please refresh the page.', 'error');
                return;
            }

            // Show loading state on button
            const rejectBtn = document.getElementById('confirmDocumentRejectionBtn');
            const originalHtml = rejectBtn.innerHTML;
            rejectBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Rejecting...';
            rejectBtn.disabled = true;

            fetch("{{ route('chairperson.documents.reject') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    document_id: documentId,
                    reason: reason
                })
            })
                .then(response => {
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json().then(data => {
                            return { data, response };
                        });
                    } else {
                        return response.text().then(text => {
                            throw new Error('Server returned non-JSON response');
                        });
                    }
                })
                .then(({ data, response }) => {
                    if (response.ok && data.success) {
                        showToast('Document rejected successfully!', 'success');

                        // Close modal
                        const rejectionModal = bootstrap.Modal.getInstance(document.getElementById('documentRejectionModal'));
                        if (rejectionModal) {
                            rejectionModal.hide();
                        }

                        // Reload task details to reflect changes
                        const taskId = document.getElementById('submission_task_id').value;
                        loadTaskDetails(taskId);
                    } else {
                        throw new Error(data.message || `Server error: ${response.status}`);
                    }
                })
                .catch(error => {
                    console.error('Error rejecting document:', error);
                    showToast(error.message || 'Failed to reject document. Please try again.', 'error');
                })
                .finally(() => {
                    // Restore button state
                    rejectBtn.disabled = false;
                    rejectBtn.innerHTML = originalHtml;
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

        function showToast(message, type = 'info') {
            // Create toast element if it doesn't exist
            if (!document.getElementById('notificationToast')) {
                const toastContainer = document.createElement('div');
                toastContainer.innerHTML = `
                                    <div id="notificationToast" class="toast align-items-center text-white bg-${type}" role="alert" aria-live="assertive" aria-atomic="true">
                                        <div class="d-flex">
                                            <div class="toast-body">
                                                <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'} me-2"></i>
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
            return statusClasses[status] || 'bg-secondary';
        }

        function getPriorityClass(priority) {
            const priorityClasses = {
                'high': 'bg-danger',
                'medium': 'bg-warning text-dark',
                'low': 'bg-success'
            };
            return priorityClasses[priority] || 'bg-secondary';
        }
    </script>

    <!-- Hidden input to store current document ID for rejection -->
    <input type="hidden" id="currentRejectDocumentId" value="">
    <!-- Add this near your other hidden input -->
    <input type="hidden" id="current_assignee_id" value="">
@endsection