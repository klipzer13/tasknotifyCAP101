@extends('chairperson.genchair')
@section('title', 'Team Performance')

@section('content')
    <div class="dashboard-container">
        <!-- Header with Title and Actions -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 mb-1">Team Performance</h2>
                <p class="text-muted mb-0">Monitor and analyze your team's productivity and progress</p>
            </div>
            <div>
                <button class="btn btn-sm btn-outline-secondary me-2">
                    <i class="fas fa-download me-1"></i> Export
                </button>
                <button class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i> New Report
                </button>
            </div>
        </div>

        <!-- Performance Summary Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2 text-uppercase small fw-semibold">Total Members</h6>
                                <h3 class="mb-0 fw-bold" id="totalMembers">12</h3>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                                <i class="fas fa-users text-primary"></i>
                            </div>
                        </div>
                        <p class="text-success small mb-0 mt-2">
                            <i class="fas fa-arrow-up me-1"></i> 2 added this month
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2 text-uppercase small fw-semibold">Avg Completion</h6>
                                <h3 class="mb-0 fw-bold" id="avgCompletion">78%</h3>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                                <i class="fas fa-check-circle text-success"></i>
                            </div>
                        </div>
                        <p class="text-muted small mb-0 mt-2">
                            <span id="completionChange">+5%</span> from last month
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2 text-uppercase small fw-semibold">Top Performers</h6>
                                <h3 class="mb-0 fw-bold" id="topPerformersCount">5</h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                                <i class="fas fa-star text-warning"></i>
                            </div>
                        </div>
                        <p class="text-muted small mb-0 mt-2">
                            <span id="topPerformerChange">+2</span> from last month
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2 text-uppercase small fw-semibold">Tasks Completed</h6>
                                <h3 class="mb-0 fw-bold" id="totalCompleted">142</h3>
                            </div>
                            <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                                <i class="fas fa-tasks text-info"></i>
                            </div>
                        </div>
                        <p class="text-danger small mb-0 mt-2">
                            <i class="fas fa-arrow-down me-1"></i> 3% overdue rate
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters and Controls -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-wrap gap-2">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <span class="input-group-text bg-transparent"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" class="form-control border-start-0" id="searchInput" placeholder="Search team members...">
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-filter me-1"></i> Performance
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                                <li><a class="dropdown-item filter-option active" href="#" data-filter="all">All Members</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item filter-option" href="#" data-filter="top">Top Performers (80%+)</a></li>
                                <li><a class="dropdown-item filter-option" href="#" data-filter="average">Average (50-79%)</a></li>
                                <li><a class="dropdown-item filter-option" href="#" data-filter="low">Low Performers (<50%)</a></li>
                            </ul>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="sortDropdown"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-sort me-1"></i> Sort By
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                                <li><a class="dropdown-item sort-option active" href="#" data-sort="name-asc">Name (A-Z)</a></li>
                                <li><a class="dropdown-item sort-option" href="#" data-sort="name-desc">Name (Z-A)</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item sort-option" href="#" data-sort="score-desc">Performance (High-Low)</a></li>
                                <li><a class="dropdown-item sort-option" href="#" data-sort="score-asc">Performance (Low-High)</a></li>
                            </ul>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="departmentDropdown"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-building me-1"></i> Department
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="departmentDropdown">
                                <li><a class="dropdown-item department-option active" href="#" data-department="all">All Departments</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item department-option" href="#" data-department="marketing">Marketing</a></li>
                                <li><a class="dropdown-item department-option" href="#" data-department="development">Development</a></li>
                                <li><a class="dropdown-item department-option" href="#" data-department="design">Design</a></li>
                                <li><a class="dropdown-item department-option" href="#" data-department="sales">Sales</a></li>
                                <li><a class="dropdown-item department-option" href="#" data-department="hr">HR</a></li>
                                <li><a class="dropdown-item department-option" href="#" data-department="finance">Finance</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="text-muted small">
                        Showing <span id="showingCount">12</span> of 12 members
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3 fw-semibold text-uppercase small">Team Member</th>
                                <th class="py-3 fw-semibold text-uppercase small">Department</th>
                                <th class="text-center py-3 fw-semibold text-uppercase small">Completed</th>
                                <th class="text-center py-3 fw-semibold text-uppercase small">Overdue</th>
                                <th class="text-center py-3 fw-semibold text-uppercase small">Total</th>
                                <th class="pe-4 py-3 fw-semibold text-uppercase small">Completion Rate</th>
                                <th class="text-center py-3 fw-semibold text-uppercase small">Performance</th>
                                <th class="text-center py-3 fw-semibold text-uppercase small">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="teamMembersTable">
                           @foreach ($teamMembers as $member)
                           <tr class="member-row">
                               <td class="ps-4">
                                   <div class="d-flex align-items-center">
                                       <div class="position-relative">
                                           <img src="{{ asset('storage/profile/avatars/') }}/{{ $member->avatar }}" 
                                               alt="{{ $member->name }}" class="rounded-circle me-3" width="40" height="40">
                                           <span class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-2 border-white" 
                                                 style="width: 10px; height: 10px;"></span>
                                       </div>
                                       <div>
                                           <div class="fw-semibold">{{ $member->name }}</div>
                                           <div class="small text-muted">{{ $member->email }}</div>
                                       </div>
                                   </div>
                               </td>
                               <td>
                                   <span class="badge bg-light text-dark">{{ $member->department->name }}</span>
                               </td>
                               <td class="text-center">{{ $member->completed }}</td>
                               <td class="text-center">
                                   @if($member->overdue > 0)
                                       <span class="text-danger">{{ $member->overdue }}</span>
                                   @else
                                       {{ $member->overdue }}
                                   @endif
                               </td>
                               <td class="text-center">{{ $member->total }}</td>
                               <td class="pe-4">
                                   <div class="d-flex align-items-center">
                                       <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                           <div class="progress-bar {{ $member->performance_class }}" role="progressbar" 
                                               style="width: {{ $member->completion_rate }}%" 
                                               aria-valuenow="{{ $member->completion_rate }}" 
                                               aria-valuemin="0" 
                                               aria-valuemax="100"></div>
                                       </div>
                                       <span class="fw-semibold">{{ $member->completion_rate }}%</span>
                                   </div>
                               </td>
                               <td class="text-center">
                                   <span class="badge performance-badge {{ $member->performance_class }}">
                                       {{ $member->performance_label }}
                                   </span>
                               </td>
                               <td class="text-center">
                                   <div class="dropdown">
                                       <button class="btn btn-sm btn-link text-muted" type="button" 
                                               id="actionDropdown{{ $member->id }}" data-bs-toggle="dropdown">
                                           <i class="fas fa-ellipsis-v"></i>
                                       </button>
                                       <ul class="dropdown-menu" aria-labelledby="actionDropdown{{ $member->id }}">
                                           <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i>View Details</a></li>
                                           <li><a class="dropdown-item" href="#"><i class="fas fa-chart-line me-2"></i>Performance Report</a></li>
                                           <li><hr class="dropdown-divider"></li>
                                           <li><a class="dropdown-item" href="#"><i class="fas fa-envelope me-2"></i>Send Message</a></li>
                                       </ul>
                                   </div>
                               </td>
                           </tr>
                           @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted small">
                Showing <span id="paginationFrom">1</span>-<span id="paginationTo">12</span> of <span
                    id="paginationTotal">12</span> members
            </div>
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm" id="paginationControls">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <style>
        .dashboard-container {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-radius: 0.75rem;
        }

        .card-hover:hover {
            transform: translateY(-3px);
            transition: all 0.3s ease;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.09) !important;
        }

        .member-row {
            transition: all 0.2s ease;
        }

        .member-row:hover {
            background-color: #f8f9fa;
            transform: translateX(2px);
        }

        .progress {
            height: 6px;
            border-radius: 3px;
        }

        .progress-bar {
            border-radius: 3px;
        }

        .performance-badge {
            font-size: 0.75rem;
            padding: 0.35rem 0.65rem;
            border-radius: 0.35rem;
            font-weight: 500;
        }

        .high-performance {
            background-color: #e6f4ea;
            color: #137947;
        }

        .medium-performance {
            background-color: #fef7cd;
            color: #94610e;
        }

        .low-performance {
            background-color: #fce8e6;
            color: #c5221f;
        }

        .table th {
            border-top: none;
            font-weight: 600;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.09);
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #ced4da;
        }

        .input-group-text {
            border-right: none;
        }

        .input-group .form-control {
            border-left: none;
        }
    </style>

    <script>
        $(document).ready(function () {
            // Sample team member data
            const teamMembers = [
                {
                    id: 1,
                    name: "Sarah Johnson",
                    email: "sarah.johnson@example.com",
                    avatar: "profile1.png",
                    department: "Marketing",
                    completed_tasks: 18,
                    overdue_tasks: 2,
                    total_tasks: 20,
                    last_active: "2023-05-15"
                },
                {
                    id: 2,
                    name: "Michael Chen",
                    email: "michael.chen@example.com",
                    avatar: "profile2.png",
                    department: "Development",
                    completed_tasks: 15,
                    overdue_tasks: 1,
                    total_tasks: 16,
                    last_active: "2023-05-14"
                },
                {
                    id: 3,
                    name: "Emily Rodriguez",
                    email: "emily.rodriguez@example.com",
                    avatar: "profile3.png",
                    department: "Design",
                    completed_tasks: 12,
                    overdue_tasks: 3,
                    total_tasks: 15,
                    last_active: "2023-05-13"
                },
                {
                    id: 4,
                    name: "David Kim",
                    email: "david.kim@example.com",
                    avatar: "profile4.png",
                    department: "Sales",
                    completed_tasks: 22,
                    overdue_tasks: 0,
                    total_tasks: 22,
                    last_active: "2023-05-15"
                },
                {
                    id: 5,
                    name: "Jessica Williams",
                    email: "jessica.williams@example.com",
                    avatar: "profile5.png",
                    department: "Marketing",
                    completed_tasks: 14,
                    overdue_tasks: 4,
                    total_tasks: 18,
                    last_active: "2023-05-12"
                },
                {
                    id: 6,
                    name: "Robert Taylor",
                    email: "robert.taylor@example.com",
                    avatar: "profile6.png",
                    department: "Development",
                    completed_tasks: 10,
                    overdue_tasks: 5,
                    total_tasks: 15,
                    last_active: "2023-05-11"
                },
                {
                    id: 7,
                    name: "Jennifer Lee",
                    email: "jennifer.lee@example.com",
                    avatar: "profile7.png",
                    department: "HR",
                    completed_tasks: 19,
                    overdue_tasks: 1,
                    total_tasks: 20,
                    last_active: "2023-05-15"
                },
                {
                    id: 8,
                    name: "Daniel Brown",
                    email: "daniel.brown@example.com",
                    avatar: "profile8.png",
                    department: "Finance",
                    completed_tasks: 16,
                    overdue_tasks: 2,
                    total_tasks: 18,
                    last_active: "2023-05-14"
                },
                {
                    id: 9,
                    name: "Amanda Wilson",
                    email: "amanda.wilson@example.com",
                    avatar: "profile9.png",
                    department: "Design",
                    completed_tasks: 11,
                    overdue_tasks: 3,
                    total_tasks: 14,
                    last_active: "2023-05-13"
                },
                {
                    id: 10,
                    name: "Christopher Martinez",
                    email: "christopher.martinez@example.com",
                    avatar: "profile10.png",
                    department: "Development",
                    completed_tasks: 17,
                    overdue_tasks: 1,
                    total_tasks: 18,
                    last_active: "2023-05-15"
                },
                {
                    id: 11,
                    name: "Elizabeth Anderson",
                    email: "elizabeth.anderson@example.com",
                    avatar: "profile11.png",
                    department: "Marketing",
                    completed_tasks: 13,
                    overdue_tasks: 2,
                    total_tasks: 15,
                    last_active: "2023-05-12"
                },
                {
                    id: 12,
                    name: "Matthew Thomas",
                    email: "matthew.thomas@example.com",
                    avatar: "profile12.png",
                    department: "Sales",
                    completed_tasks: 20,
                    overdue_tasks: 0,
                    total_tasks: 20,
                    last_active: "2023-05-15"
                }
            ];

            // Render team members table
            function renderTeamMembers(members) {
                const $tableBody = $('#teamMembersTable');
                $tableBody.empty();

                members.forEach(member => {
                    const percentage = member.total_tasks > 0 ? Math.round((member.completed_tasks / member.total_tasks) * 100) : 0;
                    const progressClass = percentage >= 80 ? 'bg-success' : (percentage >= 50 ? 'bg-warning' : 'bg-danger');
                    const performanceLevel = percentage >= 80 ? 'High' : (percentage >= 50 ? 'Medium' : 'Low');
                    const performanceClass = percentage >= 80 ? 'high-performance' : (percentage >= 50 ? 'medium-performance' : 'low-performance');
                    const performanceScore = (percentage * 0.7) + (Math.min(member.total_tasks, 20) * 1.5);

                    const $row = $(`
                            <tr class="member-row" 
                                data-id="${member.id}"
                                data-name="${member.name.toLowerCase()}"
                                data-email="${member.email.toLowerCase()}"
                                data-department="${member.department.toLowerCase()}"
                                data-percentage="${percentage}"
                                data-performance="${performanceLevel.toLowerCase()}"
                                data-score="${performanceScore}"
                                data-tasks="${member.total_tasks}"
                                data-completed="${member.completed_tasks}"
                                data-overdue="${member.overdue_tasks}">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="position-relative">
                                            <img src="{{ asset('storage/profile/avatars/') }}/${member.avatar}" 
                                                alt="${member.name}" class="rounded-circle me-3" width="40" height="40">
                                            <span class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-2 border-white" 
                                                  style="width: 10px; height: 10px;"></span>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">${member.name}</div>
                                            <div class="small text-muted">${member.email}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">${member.department}</span>
                                </td>
                                <td class="text-center">${member.completed_tasks}</td>
                                <td class="text-center">
                                    ${member.overdue_tasks > 0 ? `<span class="text-danger">${member.overdue_tasks}</span>` : member.overdue_tasks}
                                </td>
                                <td class="text-center">${member.total_tasks}</td>
                                <td class="pe-4">
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                            <div class="progress-bar ${progressClass}" role="progressbar" 
                                                style="width: ${percentage}%" 
                                                aria-valuenow="${percentage}" 
                                                aria-valuemin="0" 
                                                aria-valuemax="100"></div>
                                        </div>
                                        <span class="fw-semibold">${percentage}%</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge performance-badge ${performanceClass}">${performanceLevel}</span>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-link text-muted" type="button" 
                                                id="actionDropdown${member.id}" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="actionDropdown${member.id}">
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i>View Details</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-chart-line me-2"></i>Performance Report</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-envelope me-2"></i>Send Message</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        `);

                    $tableBody.append($row);
                });

                updateTeamStats();
                updateShowingCount();
            }

            // Calculate and update team statistics
            function updateTeamStats() {
                let stats = {
                    totalTasks: 0,
                    completedTasks: 0,
                    overdueTasks: 0,
                    totalPercentage: 0,
                    memberCount: 0,
                    topPerformers: 0
                };

                $('.member-row').each(function () {
                    const tasks = parseInt($(this).data('tasks'));
                    if (!isNaN(tasks) && tasks > 0) {
                        stats.totalTasks += tasks;
                        stats.completedTasks += parseInt($(this).data('completed'));
                        stats.overdueTasks += parseInt($(this).data('overdue'));
                        const percentage = parseFloat($(this).data('percentage'));
                        stats.totalPercentage += percentage;
                        stats.memberCount++;

                        if (percentage >= 80) {
                            stats.topPerformers++;
                        }
                    }
                });

                const avgCompletion = stats.memberCount > 0 ? Math.round(stats.totalPercentage / stats.memberCount) : 0;
                $('#avgCompletion').text(avgCompletion + '%');
                $('#topPerformersCount').text(stats.topPerformers);
                $('#totalCompleted').text(stats.completedTasks);
                $('#totalMembers').text(stats.memberCount);
            }

            // Update showing count
            function updateShowingCount() {
                const visibleCount = $('.member-row:visible').length;
                $('#showingCount').text(visibleCount);
                $('#paginationTotal').text(visibleCount);
                $('#paginationFrom').text(1);
                $('#paginationTo').text(visibleCount);
            }

            // Search functionality
            $('#searchInput').on('keyup', function () {
                const searchText = $(this).val().toLowerCase();
                $('.member-row').each(function () {
                    const showRow = $(this).data('name').includes(searchText) ||
                        $(this).data('email').includes(searchText) ||
                        $(this).data('department').includes(searchText);
                    $(this).toggle(showRow);
                });
                updateShowingCount();
            });

            // Filter functionality
            $('.filter-option').click(function (e) {
                e.preventDefault();
                $('.filter-option').removeClass('active');
                $(this).addClass('active');

                const filter = $(this).data('filter');
                $('.member-row').each(function () {
                    const percentage = parseFloat($(this).data('percentage'));
                    let showRow = true;

                    if (filter === 'top') showRow = percentage >= 80;
                    else if (filter === 'average') showRow = percentage >= 50 && percentage < 80;
                    else if (filter === 'low') showRow = percentage < 50;

                    $(this).toggle(showRow);
                });
                updateShowingCount();
                updateTeamStats();
            });

            // Department filter functionality
            $('.department-option').click(function (e) {
                e.preventDefault();
                $('.department-option').removeClass('active');
                $(this).addClass('active');

                const department = $(this).data('department');
                $('.member-row').each(function () {
                    const memberDepartment = $(this).data('department');
                    let showRow = true;

                    if (department !== 'all') showRow = memberDepartment === department;

                    $(this).toggle(showRow);
                });
                updateShowingCount();
                updateTeamStats();
            });

            // Sort functionality
            $('.sort-option').click(function (e) {
                e.preventDefault();
                $('.sort-option').removeClass('active');
                $(this).addClass('active');

                const sortType = $(this).data('sort');
                let sortedMembers = [...teamMembers];

                switch (sortType) {
                    case 'name-asc':
                        sortedMembers.sort((a, b) => a.name.localeCompare(b.name));
                        break;
                    case 'name-desc':
                        sortedMembers.sort((a, b) => b.name.localeCompare(a.name));
                        break;
                    case 'score-desc':
                        sortedMembers.sort((a, b) => {
                            const scoreA = (a.completed_tasks / a.total_tasks * 70) + (Math.min(a.total_tasks, 20) * 1.5);
                            const scoreB = (b.completed_tasks / b.total_tasks * 70) + (Math.min(b.total_tasks, 20) * 1.5);
                            return scoreB - scoreA;
                        });
                        break;
                    case 'score-asc':
                        sortedMembers.sort((a, b) => {
                            const scoreA = (a.completed_tasks / a.total_tasks * 70) + (Math.min(a.total_tasks, 20) * 1.5);
                            const scoreB = (b.completed_tasks / b.total_tasks * 70) + (Math.min(b.total_tasks, 20) * 1.5);
                            return scoreA - scoreB;
                        });
                        break;
                }

                renderTeamMembers(sortedMembers);
            });

            // Initialize the page
            renderTeamMembers(teamMembers);
        });
    </script>
@endsection