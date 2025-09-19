@extends('genview')
@section('title', 'Departments')

@section('content')
    <style>
        /* Binder-style container */
        .binder-container {
            background: #f5f7fa;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            position: relative;
            margin-bottom: 40px;
        }

        /* Binder spine effect */
        .binder-container::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 30px;
            background: linear-gradient(90deg, #2c3e50 0%, #34495e 100%);
            border-right: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        /* Binder rings */
        .binder-rings {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .binder-ring {
            width: 12px;
            height: 30px;
            background: linear-gradient(90deg, #95a5a6 0%, #bdc3c7 100%);
            border-radius: 6px;
            box-shadow: inset 2px 0 3px rgba(0, 0, 0, 0.2);
        }

        /* Department tabs */
        .department-tabs {
            display: flex;
            background: #ecf0f1;
            border-bottom: 1px solid #d6dbdf;
            padding-left: 40px;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .department-tabs::-webkit-scrollbar {
            display: none;
        }

        .department-tab {
            padding: 15px 25px;
            cursor: pointer;
            position: relative;
            font-weight: 600;
            color: #7f8c8d;
            transition: all 0.3s ease;
            white-space: nowrap;
            border-right: 1px solid #d6dbdf;
        }

        .department-tab:first-child {
            border-left: 1px solid #d6dbdf;
        }

        .department-tab:hover {
            background: #dfe6e9;
            color: #2c3e50;
        }

        .department-tab.active {
            background: #fff;
            color: #2c3e50;
            border-top: 3px solid #3498db;
        }

        .department-tab.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 1px;
            background: #fff;
        }

        /* Department content */
        .department-content {
            padding: 25px 30px 30px 50px;
            background: #fff;
            min-height: 400px;
            animation: fadeIn 0.4s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Department header */
        .department-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #ecf0f1;
        }

        .department-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .department-title i {
            margin-right: 12px;
            color: #3498db;
            font-size: 1.8rem;
        }

        .department-meta {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .member-count {
            background-color: #e3f2fd;
            color: #1976d2;
            border-radius: 20px;
            padding: 6px 15px;
            font-size: 0.9rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .member-count i {
            font-size: 0.9rem;
        }

        .manager-info {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.95rem;
            color: #34495e;
            background: #f8f9fa;
            padding: 6px 15px;
            border-radius: 20px;
            border: 1px solid #e9ecef;
        }

        .manager-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e2e8f0;
        }

        /* Search box */
        .search-container {
            position: relative;
            width: 300px;
            margin-bottom: 20px;
        }

        .search-input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background-color: #f8fafc;
        }

        .search-input:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
            background-color: #fff;
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #7f8c8d;
        }

        /* Member table styles */
        .member-list-view {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .member-list-view thead th {
            text-align: left;
            padding: 12px 20px;
            font-weight: 600;
            color: #7f8c8d;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #ecf0f1;
            background-color: #f8f9fa;
            position: sticky;
            top: 0;
        }

        .member-list-view tbody tr {
            transition: all 0.2s ease;
        }

        .member-list-view tbody tr:hover {
            background-color: #f8fafc;
            transform: translateX(2px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .member-list-view td {
            padding: 15px 20px;
            vertical-align: middle;
            border-bottom: 1px solid #ecf0f1;
        }

        .member-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .member-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .member-list-view tbody tr:hover .member-avatar {
            transform: scale(1.05);
            border-color: #3498db;
        }

        .member-name {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 2px;
        }

        .member-role {
            font-weight: 500;
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        .member-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            padding: 5px 10px;
            border-radius: 12px;
            background-color: #f0f2f5;
        }

        .status-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .status-active {
            background-color: #2ecc71;
            box-shadow: 0 0 6px rgba(46, 204, 113, 0.5);
        }

        .status-inactive {
            background-color: #e74c3c;
            box-shadow: 0 0 6px rgba(231, 76, 60, 0.3);
        }

        .status-away {
            background-color: #f39c12;
            box-shadow: 0 0 6px rgba(243, 156, 18, 0.4);
        }

        .member-email {
            color: #7f8c8d;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .member-list-view tbody tr:hover .member-email {
            color: #3498db;
        }

        .member-phone {
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        .member-actions {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            color: #7f8c8d;
            border: 1px solid #e2e8f0;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .action-btn i {
            font-size: 1rem;
        }

        .action-btn.view {
            color: #3498db;
            background: #e3f2fd;
            border-color: #bbdefb;
        }

        .action-btn.view:hover {
            background: #bbdefb;
        }

        .action-btn.message {
            color: #9b59b6;
            background: #f3e5f5;
            border-color: #e1bee7;
        }

        .action-btn.message:hover {
            background: #e1bee7;
        }

        .action-btn.edit {
            color: #27ae60;
            background: #e8f5e9;
            border-color: #c8e6c9;
        }

        .action-btn.edit:hover {
            background: #c8e6c9;
        }

        .action-btn.delete {
            color: #e74c3c;
            background: #ffebee;
            border-color: #ffcdd2;
        }

        .action-btn.delete:hover {
            background: #ffcdd2;
        }

        /* No members placeholder */
        .no-members {
            text-align: center;
            padding: 60px 20px;
            color: #bdc3c7;
            font-size: 1rem;
        }

        .no-members i {
            font-size: 3rem;
            margin-bottom: 20px;
            display: block;
            color: #ecf0f1;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .department-meta {
                flex-direction: column;
                gap: 10px;
                align-items: flex-end;
            }
        }

        @media (max-width: 768px) {
            .binder-container::before {
                width: 20px;
            }

            .binder-rings {
                left: 10px;
            }

            .department-tabs {
                padding-left: 30px;
            }

            .department-content {
                padding: 20px 20px 20px 40px;
            }

            .department-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .department-meta {
                flex-direction: row;
                align-items: center;
                width: 100%;
                justify-content: space-between;
            }

            .search-container {
                width: 100%;
            }

            .member-list-view thead {
                display: none;
            }

            .member-list-view tbody tr {
                display: block;
                padding: 15px 10px;
                border-bottom: 1px solid #ecf0f1;
            }

            .member-list-view td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 8px 10px;
                border: none;
            }

            .member-list-view td:before {
                content: attr(data-label);
                font-weight: 600;
                color: #7f8c8d;
                font-size: 0.8rem;
                margin-right: 15px;
            }

            .member-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }

            .member-actions {
                opacity: 1;
                justify-content: flex-end;
                width: 100%;
            }
        }

        /* Animation for tab switching */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .department-pane {
            animation: slideIn 0.3s ease-out;
        }

        /* Custom checkbox styling */
        .user-select-checkbox {
            position: relative;
            padding-left: 35px;
            margin-bottom: 12px;
            cursor: pointer;
            font-size: 16px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .user-select-checkbox input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #eee;
            border-radius: 5px;
        }

        .user-select-checkbox:hover input~.checkmark {
            background-color: #ccc;
        }

        .user-select-checkbox input:checked~.checkmark {
            background-color: #2196F3;
        }

        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        .user-select-checkbox input:checked~.checkmark:after {
            display: block;
        }

        .user-select-checkbox .checkmark:after {
            left: 9px;
            top: 5px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
        }

        /* User selection list */
        .user-selection-list {
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            margin-top: 10px;
        }

        .user-selection-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #f1f1f1;
            transition: background-color 0.2s;
        }

        .user-selection-item:last-child {
            border-bottom: none;
        }

        .user-selection-item:hover {
            background-color: #f8f9fa;
        }

        .user-selection-info {
            margin-left: 15px;
        }

        .user-selection-name {
            font-weight: 600;
            color: #2c3e50;
        }

        .user-selection-role {
            font-size: 0.85rem;
            color: #7f8c8d;
        }
    </style>

    <!-- Departments Content -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Department Management</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDepartmentModal">
            <i class="fas fa-plus me-2"></i>Add Department
        </button>
    </div>

    <!-- Binder-style Departments Container -->
    <div class="binder-container">
        <!-- Binder rings -->
        <div class="binder-rings">
            <div class="binder-ring"></div>
            <div class="binder-ring"></div>
            <div class="binder-ring"></div>
        </div>

        <!-- Department Tabs -->
        <div class="department-tabs">
            @foreach($departments as $index => $department)
                <div class="department-tab {{ $index === 0 ? 'active' : '' }}"
                    onclick="showDepartment('{{ $department->id }}')">
                    <i class="fas fa-building me-2"></i>{{ $department->description ?? $department->name }}
                </div>
            @endforeach
        </div>

        <!-- Department Content Panes -->
        <div class="department-content">
            @foreach($departments as $index => $department)
                <div id="department-{{ $department->id }}" class="department-pane"
                    style="{{ $index === 0 ? '' : 'display: none;' }}">
                    <div class="department-header">
                        <h2 class="department-title">
                            <i class="fas fa-building"></i>{{ $department->name }} Department
                        </h2>
                        <div class="department-meta">
                            <span class="member-count">
                                <i class="fas fa-users"></i> {{ $department->users_count }} Members
                            </span>
                            <div class="manager-info">
                                @if($department->head)
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($department->head->name) }}&background=random"
                                        alt="{{ $department->head->name }}" class="manager-avatar">
                                    <span>{{ $department->head->name }} (Head)</span>
                                @else
                                    <i class="fas fa-user-slash"></i>
                                    <span>No manager assigned</span>
                                @endif
                            </div>
                            <div class="department-actions">
                                <button class="btn btn-sm btn-outline-primary" onclick="editDepartment({{ $department->id }})">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </button>
                                <form action="{{ route('admin.departments.destroy', $department->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Are you sure you want to delete this department?')">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    @if($department->description)
                        <div class="department-description mb-4">
                            <p class="text-muted">{{ $department->description }}</p>
                        </div>
                    @endif

                    <div class="search-container">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="search-input" placeholder="Search {{ $department->name }} team..."
                            id="search-{{ $department->id }}"
                            oninput="searchMembers('search-{{ $department->id }}', 'members-{{ $department->id }}')">
                    </div>

                    @if($department->users_count > 0)
                        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                            <table class="member-list-view">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Role</th>
                                        <th>Email</th>
                                        <th>Tasks</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="members-{{ $department->id }}">
                                    @foreach($department->users as $user)
                                        <tr>
                                            <td data-label="Name">
                                                <div class="member-info">
                                                    <img src="{{ asset($user->avatar ?? 'default.png') }}"
                                                        alt="{{ $user->name }}" class="member-avatar">
                                                    <div>
                                                        <div class="member-name">{{ $user->name }}</div>
                                                        <div class="member-role">{{ $user->role->name ?? 'No Role' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td data-label="Role" class="member-role">
                                                {{ $user->role->name ?? 'No Role' }}
                                                @if($user->role_id == 2)
                                                    <span class="badge bg-primary ms-1">Head</span>
                                                @endif
                                            </td>
                                            <td data-label="Email" class="member-email">
                                                {{ $user->email }}
                                            </td>
                                            <td data-label="Tasks">
                                                <span class="badge bg-info">{{ $user->tasks_count }}</span>
                                            </td>
                                            <td data-label="Actions">
                                                <div class="member-actions">
                                                    <button class="action-btn view" title="View Profile"
                                                        onclick="viewMember(event, {{ $user->id }})">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="action-btn message" title="Send Message"
                                                        onclick="messageMember(event, {{ $user->id }})">
                                                        <i class="fas fa-envelope"></i>
                                                    </button>
                                                    <button class="action-btn edit" title="Edit"
                                                        onclick="editMember(event, {{ $user->id }})">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="no-members">
                            <i class="fas fa-user-friends"></i>
                            <p>No members have been added to this department yet.</p>
                            <button class="btn btn-primary" onclick="editDepartment({{ $department->id }})">
                                <i class="fas fa-user-plus me-2"></i>Add Members
                            </button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Add Department Modal -->
    <div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold" id="addDepartmentModalLabel">Create New Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.departments.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <!-- Department Info Section -->
                        <div class="mb-4">
                            <div class="mb-3">
                                <label for="departmentName" class="form-label fw-medium">Department Codde <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="departmentName" name="name"
                                    placeholder="e.g., IT" required value="{{ old('name') }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="departmentDescription" class="form-label fw-medium">Deparment Name</label>
                            <textarea class="form-control" id="departmentDescription" name="description" rows="2"
                                placeholder="Information Technology">{{ old('description') }}</textarea>
                        </div>

                        <!-- Manager Selection Section -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 fw-medium">Department Management</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="head_id" class="form-label fw-medium">Department Head <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="head_id" name="head_id" required>
                                        <option value="">Select Department Head</option>
                                        @foreach($allUsers as $user)
                                            <option value="{{ $user->id }}" {{ old('head_id') == $user->id ? 'selected' : '' }}>
                                                &#x1F464; {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Members Selection Section -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 fw-medium">Department Members</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Select Members</label>
                                    <div class="user-selection-list">
                                        @foreach($allUsers as $user)
                                            <div class="user-selection-item">
                                                <label class="user-select-checkbox">
                                                    <input type="checkbox" name="members[]" value="{{ $user->id }}">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <img src="{{ asset( ($user->avatar ?? 'default.png')) }}"
                                                    alt="{{ $user->name }}" class="member-avatar"
                                                    style="width: 40px; height: 40px;">
                                                <div class="user-selection-info">
                                                    <div class="user-selection-name">{{ $user->name }}</div>
                                                    <div class="user-selection-role">{{ $user->department->description ?? 'No Role' }}</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-plus-circle me-2"></i>Create Department
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Department Modal -->
    <div class="modal fade" id="editDepartmentModal" tabindex="-1" aria-labelledby="editDepartmentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold" id="editDepartmentModalLabel">Edit Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editDepartmentForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <!-- Department Info Section -->
                        <div class="mb-4">
                            <div class="mb-3">
                                <label for="editDepartmentName" class="form-label fw-medium">Department Code <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="editDepartmentName" name="name" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="editDepartmentDescription" class="form-label fw-medium">Deparment Name</label>
                            <textarea class="form-control" id="editDepartmentDescription" name="description"
                                rows="2"></textarea>
                        </div>

                        <!-- Manager Selection Section -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 fw-medium">Department Management</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="editHeadId" class="form-label fw-medium">Department Head <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="editHeadId" name="head_id" required>
                                        <option value="">Select Department Head</option>
                                        @foreach($allUsers as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}
                                                ({{ $user->role->name ?? 'No Role' }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Members Selection Section -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 fw-medium">Department Members</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Select Members</label>
                                    <div class="user-selection-list" id="editMembersList">
                                        @foreach($allUsers as $user)
                                            <div class="user-selection-item">
                                                <label class="user-select-checkbox">
                                                    <input type="checkbox" name="members[]" value="{{ $user->id }}">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random"
                                                    alt="{{ $user->name }}" class="member-avatar"
                                                    style="width: 40px; height: 40px;">
                                                <div class="user-selection-info">
                                                    <div class="user-selection-name">{{ $user->name }}</div>
                                                    <div class="user-selection-role">{{ $user->role->name ?? 'No Role' }}</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save me-2"></i>Update Department
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Function to show selected department
        function showDepartment(departmentId) {
            // Hide all department panes
            document.querySelectorAll('.department-pane').forEach(pane => {
                pane.style.display = 'none';
            });

            // Remove active class from all tabs
            document.querySelectorAll('.department-tab').forEach(tab => {
                tab.classList.remove('active');
            });

            // Show selected department pane
            document.getElementById(`department-${departmentId}`).style.display = 'block';

            // Add active class to clicked tab
            event.currentTarget.classList.add('active');
        }

        // Function to search members within a department
        function searchMembers(inputId, tableBodyId) {
            const searchTerm = document.getElementById(inputId).value.toLowerCase();
            const rows = document.querySelectorAll(`#${tableBodyId} tr`);

            rows.forEach(row => {
                const name = row.querySelector('.member-name').textContent.toLowerCase();
                const role = row.querySelector('.member-role').textContent.toLowerCase();
                const email = row.querySelector('.member-email').textContent.toLowerCase();

                if (name.includes(searchTerm) || role.includes(searchTerm) || email.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }


        // Function to edit department
        function editDepartment(departmentId) {
            // Fetch department data
            fetch(`{{ route('admin.departments.edit', '') }}/${departmentId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(department => {
                    // Populate the edit form
                    document.getElementById('editDepartmentName').value = department.name;
                    document.getElementById('editDepartmentDescription').value = department.description || '';

                    // Set the head
                    document.getElementById('editHeadId').value = department.head ? department.head.id : '';

                    // Set the form action
                    document.getElementById('editDepartmentForm').action = `/admin/departments/${departmentId}`;

                    // Check the members checkboxes
                    const checkboxes = document.querySelectorAll('#editMembersList input[type="checkbox"]');
                    checkboxes.forEach(checkbox => {
                        // Check if this user is in the department
                        checkbox.checked = department.users.some(user => user.id === parseInt(checkbox.value));
                    });

                    // Show the modal
                    const editModal = new bootstrap.Modal(document.getElementById('editDepartmentModal'));
                    editModal.show();
                })
                .catch(error => {
                    console.error('Error fetching department data:', error);
                    alert('Error loading department data. Please try again.');
                });
        }

        // Function to view member profile
        function viewMember(event, userId) {
            event.stopPropagation();
            alert(`Viewing profile of user ID: ${userId}`);
        }

        // Function to message member
        function messageMember(event, userId) {
            event.stopPropagation();
            alert(`Opening message window for user ID: ${userId}`);
        }

        // Function to edit member
        function editMember(event, userId) {
            event.stopPropagation();
            alert(`Editing user ID: ${userId}`);
        }

        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', function () {
            // Add event listener to department tabs for keyboard navigation
            const departmentTabs = document.querySelectorAll('.department-tab');
            departmentTabs.forEach(tab => {
                tab.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        this.click();
                    }
                });
            });
        });
    </script>
@endsection