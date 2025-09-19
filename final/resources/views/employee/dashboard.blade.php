@extends('employee.genemp')
@section('tittle', 'Dashboard')
@section('content')
    <!-- Main Content -->
    <div class="main-content" id="mainContent">

        <!-- Top Navigation Bar -->
        <nav class="top-navbar navbar navbar-expand-lg navbar-light bg-white shadow-sm py-2 px-3 mb-3 sticky-top">
            <div class="container-fluid d-flex justify-content-between align-items-center p-0">
                <!-- Left side - Toggle button and Brand -->
                <div class="d-flex align-items-center">
                    <button class="sidebar-collapse-btn btn btn-link text-dark p-0 me-2 d-lg-none" id="sidebarToggle">
                        <i class="fas fa-bars fs-4"></i>
                    </button>
                    <span class="navbar-brand fw-bold text-primary fs-6" id="adminGreeting">Good </span>
                </div>

                <!-- Right side - Navigation -->
                <div class="d-flex align-items-center">
                    <!-- Notification -->
                    <div class="dropdown position-relative me-2">
                        <button class="btn btn-link text-dark p-0 position-relative" id="notificationDropdown" 
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell fs-5"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notificationBadge">3</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end notification-dropdown p-0 shadow border-0" style="width: 300px;">
                            <div class="d-flex justify-content-between align-items-center p-2 border-bottom bg-light">
                                <h6 class="m-0 fw-bold small">Notifications</h6>
                                <div>
                                    <span class="badge bg-primary rounded-pill me-1" id="notificationCount">3</span>
                                    <button class="btn btn-sm btn-link text-muted p-0 mark-all-read">
                                        <i class="fas fa-check-double small"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="notification-list" style="max-height: 300px; overflow-y: auto;">
                                <!-- Sample notifications -->
                                <a href="#" class="dropdown-item d-flex py-2 px-2 notification-item unread">
                                    <div class="flex-shrink-0 me-2">
                                        <div class="bg-primary bg-opacity-10 p-1 rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                            <i class="fas fa-user-check text-primary small"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h6 class="mb-0 fw-semibold small">New Task</h6>
                                            <small class="text-muted">2 min ago</small>
                                        </div>
                                        <p class="mb-0 text-muted small">Complete project report</p>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item d-flex py-2 px-2 notification-item">
                                    <div class="flex-shrink-0 me-2">
                                        <div class="bg-success bg-opacity-10 p-1 rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                            <i class="fas fa-calendar-check text-success small"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h6 class="mb-0 fw-semibold small">Meeting Reminder</h6>
                                            <small class="text-muted">1 hour ago</small>
                                        </div>
                                        <p class="mb-0 text-muted small">Team sync at 2:00 PM</p>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item d-flex py-2 px-2 notification-item">
                                    <div class="flex-shrink-0 me-2">
                                        <div class="bg-warning bg-opacity-10 p-1 rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                            <i class="fas fa-exclamation-triangle text-warning small"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h6 class="mb-0 fw-semibold small">Deadline Approaching</h6>
                                            <small class="text-muted">5 hours ago</small>
                                        </div>
                                        <p class="mb-0 text-muted small">Project submission due tomorrow</p>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2 border-top bg-light text-center">
                                <a href="#" class="small text-primary">View all notifications</a>
                            </div>
                        </div>
                    </div>

                    <!-- User Profile -->
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none" id="userDropdown" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ Auth::user()->avatar_url ?? asset('storage/profile/avatars/profile.png') }}"
                                alt="User Profile" class="rounded-circle me-1 border border-2 border-primary" width="32"
                                height="32">
                            <div class="d-none d-md-inline">
                                <div class="fw-bold text-dark small">{{ ucwords(strtolower(Auth::user()->name)) }}</div>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" style="width: 220px;">
                            <li><a class="dropdown-item d-flex align-items-center py-2 px-2 rounded" href="#"><i class="fas fa-user-circle me-2 text-muted"></i> Profile</a></li>
                            <li><a class="dropdown-item d-flex align-items-center py-2 px-2 rounded" href="#"><i class="fas fa-cog me-2 text-muted"></i> Settings</a></li>
                            <li><a class="dropdown-item d-flex align-items-center py-2 px-2 rounded" href="#"><i class="fas fa-moon me-2 text-muted"></i> Dark Mode</a></li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li><a class="dropdown-item d-flex align-items-center py-2 px-2 rounded" href="#"><i class="fas fa-sign-out-alt me-2 text-muted"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Stats Cards with Improved Design and Blue Left Border -->
        <div class="row mb-3 g-3 animate-on-load">
            <div class="col-md-3 col-6">
            <div class="card stat-card h-100 border-0 shadow-sm hover-scale position-relative" style="border-left: 5px solid var(--primary);">
                <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                    <span class="text-muted small d-flex align-items-center mb-1">
                        <i class="fas fa-tasks me-2"></i> Tasks
                    </span>
                    <h4 class="mb-0 fw-bold counter" data-target="5" style="min-width:2.5rem;">0</h4>
                    <small class="text-muted small">In Progress</small>
                    </div>
                    <div class="icon-wrapper bg-primary bg-opacity-10 p-2 rounded pulse-animation shadow-sm">
                    <i class="fas fa-tasks text-primary"></i>
                    </div>
                </div>
                <div class="progress mt-2" style="height: 4px;">
                    <div class="progress-bar bg-primary progress-animate" role="progressbar" style="width: 0%" data-width="65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="progress-number text-end small mt-1">
                    <span class="counter" data-target="65">0</span>%
                </div>
                </div>
                <div class="position-absolute top-0 end-0 m-2">
                <span class="badge bg-primary-subtle text-primary shadow-sm">Active</span>
                </div>
            </div>
            </div>
            <div class="col-md-3 col-6">
            <div class="card stat-card h-100 border-0 shadow-sm hover-scale position-relative" style="border-left: 5px solid #4361ee;">
                <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                    <span class="text-muted small d-flex align-items-center mb-1">
                        <i class="fas fa-check-circle me-2"></i> Completed
                    </span>
                    <h4 class="mb-0 fw-bold counter" data-target="12" style="min-width:2.5rem;">0</h4>
                    <small class="text-muted small">This Week</small>
                    </div>
                    <div class="icon-wrapper bg-success bg-opacity-10 p-2 rounded pulse-animation shadow-sm">
                    <i class="fas fa-check-circle text-success"></i>
                    </div>
                </div>
                <div class="progress mt-2" style="height: 4px;">
                    <div class="progress-bar bg-success progress-animate" role="progressbar" style="width: 0%" data-width="85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="progress-number text-end small mt-1">
                    <span class="counter" data-target="85">0</span>%
                </div>
                </div>
                <div class="position-absolute top-0 end-0 m-2">
                <span class="badge bg-success-subtle text-success shadow-sm">Done</span>
                </div>
            </div>
            </div>
            <div class="col-md-3 col-6">
            <div class="card stat-card h-100 border-0 shadow-sm hover-scale position-relative" style="border-left: 5px solid #4361ee;">
                <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                    <span class="text-muted small d-flex align-items-center mb-1">
                        <i class="fas fa-exclamation-triangle me-2"></i> Overdue
                    </span>
                    <h4 class="mb-0 fw-bold counter" data-target="3" style="min-width:2.5rem;">0</h4>
                    <small class="text-muted small">Need Attention</small>
                    </div>
                    <div class="icon-wrapper bg-danger bg-opacity-10 p-2 rounded pulse-animation shadow-sm">
                    <i class="fas fa-exclamation-triangle text-danger"></i>
                    </div>
                </div>
                <div class="progress mt-2" style="height: 4px;">
                    <div class="progress-bar bg-danger progress-animate" role="progressbar" style="width: 0%" data-width="30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="progress-number text-end small mt-1">
                    <span class="counter" data-target="30">0</span>%
                </div>
                </div>
                <div class="position-absolute top-0 end-0 m-2">
                <span class="badge bg-danger-subtle text-danger shadow-sm">Alert</span>
                </div>
            </div>
            </div>
            <div class="col-md-3 col-6">
            <div class="card stat-card h-100 border-0 shadow-sm hover-scale position-relative" style="border-left: 5px solid #4361ee;">
                <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                    <span class="text-muted small d-flex align-items-center mb-1">
                        <i class="fas fa-clock me-2"></i> Pending
                    </span>
                    <h4 class="mb-0 fw-bold counter" data-target="2" style="min-width:2.5rem;">0</h4>
                    <small class="text-muted small">Approvals</small>
                    </div>
                    <div class="icon-wrapper bg-warning bg-opacity-10 p-2 rounded pulse-animation shadow-sm">
                    <i class="fas fa-clock text-warning"></i>
                    </div>
                </div>
                <div class="progress mt-2" style="height: 4px;">
                    <div class="progress-bar bg-warning progress-animate" role="progressbar" style="width: 0%" data-width="30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="progress-number text-end small mt-1">
                    <span class="counter" data-target="30">0</span>%
                </div>
                </div>
                <div class="position-absolute top-0 end-0 m-2">
                <span class="badge bg-warning-subtle text-warning shadow-sm">Waiting</span>
                </div>
            </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="row g-3">
            <!-- Calendar Column -->
            <div class="col-lg-8">
                <div class="card h-100 border-0 shadow-lg hover-scale position-relative" style="z-index:2; box-shadow: 0 1.5rem 2.5rem rgba(78,115,223,0.25) !important;">
                    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-2 px-3">
                        <h6 class="mb-0 fw-bold d-flex align-items-center"><i class="fas fa-calendar-alt me-2"></i> Calendar Overview</h6>
                        <div class="d-flex">
                            <div class="btn-group btn-group-sm me-1" role="group">
                                <button type="button" class="btn btn-outline-secondary" id="prevPeriod">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="nextPeriod">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                            <div class="dropdown me-1">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                    id="calendarViewDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-calendar-alt me-1"></i> <span id="currentView">Week</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="calendarViewDropdown">
                                    <li><a class="dropdown-item view-option" href="#" data-view="day"><i class="fas fa-calendar-day me-2"></i>Day</a></li>
                                    <li><a class="dropdown-item view-option active" href="#" data-view="week"><i class="fas fa-calendar-week me-2"></i>Week</a></li>
                                    <li><a class="dropdown-item view-option" href="#" data-view="month"><i class="fas fa-calendar me-2"></i>Month</a></li>
                                    <li><a class="dropdown-item view-option" href="#" data-view="agenda"><i class="fas fa-list me-2"></i>Agenda</a></li>
                                </ul>
                            </div>
                            <!-- Calendar Filter Dropdown -->
                            <div class="dropdown me-1">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                    id="calendarFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-filter me-1"></i> Filter
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="calendarFilterDropdown">
                                    <li>
                                        <div class="dropdown-item">
                                            <div class="form-check">
                                                <input class="form-check-input calendar-filter" type="checkbox" value="meeting" id="filterMeetings" checked>
                                                <label class="form-check-label" for="filterMeetings">
                                                    <i class="fas fa-video me-2"></i> Meetings
                                                </label>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown-item">
                                            <div class="form-check">
                                                <input class="form-check-input calendar-filter" type="checkbox" value="task" id="filterTasks" checked>
                                                <label class="form-check-label" for="filterTasks">
                                                    <i class="fas fa-tasks me-2"></i> Tasks
                                                </label>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown-item">
                                            <div class="form-check">
                                                <input class="form-check-input calendar-filter" type="checkbox" value="event" id="filterEvents" checked>
                                                <label class="form-check-label" for="filterEvents">
                                                    <i class="fas fa-calendar-check me-2"></i> Events
                                                </label>
                                            </div>
                                        </div>
                                    </li>
                                    <li><hr class="dropdown-divider my-1"></li>
                                    <li>
                                        <div class="dropdown-item">
                                            <div class="form-check">
                                                <input class="form-check-input calendar-filter" type="checkbox" value="personal" id="filterPersonal" checked>
                                                <label class="form-check-label" for="filterPersonal">
                                                    <i class="fas fa-user me-2"></i> Personal
                                                </label>
                                            </div>
                                        </div>s
                                    </li>
                                    <li>
                                        <div class="dropdown-item">
                                            <div class="form-check">
                                                <input class="form-check-input calendar-filter" type="checkbox" value="work" id="filterWork" checked>
                                                <label class="form-check-label" for="filterWork">
                                                    <i class="fas fa-briefcase me-2"></i> Work
                                                </label>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <button class="btn btn-sm btn-primary" id="addEventBtn">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-2 d-flex flex-column">
                        <div class="calendar-container flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center mb-2 px-1">
                                <h6 class="m-0 fw-bold small" id="calendarPeriod">June 10-16, 2023</h6>
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-secondary active" data-view="workweek">Work Week</button>
                                    <button type="button" class="btn btn-outline-secondary" data-view="fullweek">Full Week</button>
                                </div>
                            </div>
                            
                            <!-- Week View (Default) -->
                            <div class="calendar-week-view" id="weekView">
                                <div class="calendar-week-header">
                                    <div class="calendar-day-header">Sun</div>
                                    <div class="calendar-day-header">Mon</div>
                                    <div class="calendar-day-header">Tue</div>
                                    <div class="calendar-day-header">Wed</div>
                                    <div class="calendar-day-header">Thu</div>
                                    <div class="calendar-day-header">Fri</div>
                                    <div class="calendar-day-header">Sat</div>
                                </div>
                                <div class="calendar-week-grid">
                                    <!-- Calendar cells will be populated by JavaScript -->
                                </div>
                            </div>
                            
                            <!-- Day View -->
                            <div class="calendar-day-view d-none" id="dayView">
                                <div class="calendar-day-header">
                                    <div class="calendar-day-title">Sunday, June 11, 2023</div>
                                </div>
                                <div class="calendar-day-timeline">
                                    <!-- Timeline will be populated by JavaScript -->
                                </div>
                            </div>
                            
                            <!-- Month View -->
                            <div class="calendar-month-view d-none" id="monthView">
                                <div class="calendar-month-grid">
                                    <!-- Month grid will be populated by JavaScript -->
                                </div>
                            </div>
                            
                            <!-- Agenda View -->
                            <div class="calendar-agenda-view d-none" id="agendaView">
                                <div class="agenda-list">
                                    <!-- Agenda items will be populated by JavaScript -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tasks Column -->
            <div class="col-lg-4">
                <!-- Today's Schedule -->
                <div class="card mb-3 border-0 shadow-sm position-relative" style="overflow:visible;">
                    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-2 px-3" style="background: linear-gradient(90deg, #e8f0fe 0%, #fff 100%); border-top-left-radius: .5rem; border-top-right-radius: .5rem;">
                        <div class="d-flex align-items-center">
                            <span class="bg-primary bg-opacity-10 p-2 rounded-circle me-2 d-flex align-items-center justify-content-center" style="width:32px;height:32px;">
                                <i class="fas fa-clock text-primary"></i>
                            </span>
                            <h6 class="mb-0 fw-bold text-primary d-flex align-items-center" style="font-size:1rem;">Today's Schedule</h6>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-link text-muted p-0" type="button"
                                id="scheduleFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="scheduleFilterDropdown">
                                <li><a class="dropdown-item small" href="#"><i class="fas fa-list me-2"></i>View All</a></li>
                                <li><a class="dropdown-item small" href="#"><i class="fas fa-sync-alt me-2"></i>Refresh</a></li>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li><a class="dropdown-item small" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body p-0" style="background: #f7f9fb;">
                        <div class="schedule-list" style="max-height: 200px; overflow-y: auto;">
                            <!-- Dynamic schedule items will be loaded here -->
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top py-2 px-3 d-flex justify-content-between align-items-center" style="border-bottom-left-radius: .5rem; border-bottom-right-radius: .5rem;">
                        <a href="#" class="small text-primary d-flex align-items-center">
                            <i class="fas fa-eye me-1"></i> View full schedule
                        </a>
                        <span class="badge bg-primary-subtle text-primary fw-normal" style="font-size:0.75rem;">
                            <i class="fas fa-calendar-day me-1"></i> {{ \Carbon\Carbon::now()->format('l, M d') }}
                        </span>
                    </div>
                    <!-- Decorative left border -->
                    <div style="position:absolute;left:0;top:12px;bottom:12px;width:5px;background:var(--primary);border-radius:8px;"></div>
                </div>
                
                <!-- Task Progress -->
                <div class="card mb-3 border-0 shadow-sm position-relative" style="overflow:visible;">
                    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-2 px-3" style="background: linear-gradient(90deg, #e8f0fe 0%, #fff 100%); border-top-left-radius: .5rem; border-top-right-radius: .5rem;">
                        <div class="d-flex align-items-center">
                            <span class="bg-primary bg-opacity-10 p-2 rounded-circle me-2 d-flex align-items-center justify-content-center" style="width:32px;height:32px;">
                                <i class="fas fa-tasks text-primary"></i>
                            </span>
                            <h6 class="mb-0 fw-bold text-primary d-flex align-items-center" style="font-size:1rem;">Task Progress</h6>
                        </div>
                        <button class="btn btn-sm btn-link text-primary p-0" id="addTaskBtn" title="Add Task">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <div class="card-body p-0" style="background: #f7f9fb;">
                        <div class="task-list" style="max-height: 200px; overflow-y: auto;">
                            <!-- Dynamic task items will be loaded here -->
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top py-2 px-3 d-flex justify-content-between align-items-center" style="border-bottom-left-radius: .5rem; border-bottom-right-radius: .5rem;">
                        <a href="#" class="small text-primary d-flex align-items-center">
                            <i class="fas fa-eye me-1"></i> View all tasks
                        </a>
                    </div>
                    <!-- Decorative left border -->
                    <div style="position:absolute;left:0;top:12px;bottom:12px;width:5px;background:var(--primary);border-radius:8px;"></div>
                </div>
                
                <!-- Overdue Tasks -->
                <div class="card border-0 shadow-sm position-relative" style="overflow:visible;">
                    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-2 px-3" style="background: linear-gradient(90deg, #ffeaea 0%, #fff 100%); border-top-left-radius: .5rem; border-top-right-radius: .5rem;">
                        <div class="d-flex align-items-center">
                            <span class="bg-danger bg-opacity-10 p-2 rounded-circle me-2 d-flex align-items-center justify-content-center" style="width:32px;height:32px;">
                                <i class="fas fa-exclamation-triangle text-danger"></i>
                            </span>
                            <h6 class="mb-0 fw-bold text-danger d-flex align-items-center" style="font-size:1rem;">Overdue Tasks</h6>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-link text-muted p-0" type="button"
                                id="overdueDropdown" data-bs-toggle="dropdown" aria-expanded="false" title="More">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="overdueDropdown">
                                <li><a class="dropdown-item small" href="#"><i class="fas fa-filter me-2"></i>Filter</a></li>
                                <li><a class="dropdown-item small" href="#"><i class="fas fa-sort me-2"></i>Sort</a></li>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li><a class="dropdown-item small" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body p-0" style="background: #f7f9fb;">
                        <div class="overdue-list" style="max-height: 200px; overflow-y: auto;">
                            <!-- Dynamic overdue items will be loaded here -->
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top py-2 px-3 d-flex justify-content-between align-items-center" style="border-bottom-left-radius: .5rem; border-bottom-right-radius: .5rem;">
                        <a href="#" class="small text-danger d-flex align-items-center">
                            <i class="fas fa-eye me-1"></i> View all overdue tasks
                        </a>
                    </div>
                    <!-- Decorative left border -->
                    <div style="position:absolute;left:0;top:12px;bottom:12px;width:5px;background:var(--danger);border-radius:8px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title d-flex align-items-center"><i class="fas fa-calendar-plus me-2"></i> Add New Event</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="eventForm">
                        <div class="mb-3">
                            <label for="eventTitle" class="form-label">Event Title</label>
                            <input type="text" class="form-control" id="eventTitle" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="startDate" class="form-label">Start Date</label>
                                <input type="datetime-local" class="form-control" id="startDate" required>
                            </div>
                            <div class="col-md-6">
                                <label for="endDate" class="form-label">End Date</label>
                                <input type="datetime-local" class="form-control" id="endDate" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="eventType" class="form-label">Event Type</label>
                            <select class="form-select" id="eventType">
                                <option value="meeting"><i class="fas fa-video me-2"></i> Meeting</option>
                                <option value="task"><i class="fas fa-tasks me-2"></i> Task</option>
                                <option value="event"><i class="fas fa-calendar-check me-2"></i> Event</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="eventDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="eventDescription" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveEvent"><i class="fas fa-save me-1"></i> Save Event</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Modal -->
    <div class="modal fade" id="taskModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title d-flex align-items-center"><i class="fas fa-plus-circle me-2"></i> Add New Task</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="taskForm">
                        <div class="mb-3">
                            <label for="taskTitle" class="form-label">Task Title</label>
                            <input type="text" class="form-control" id="taskTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="dueDate" class="form-label">Due Date</label>
                            <input type="datetime-local" class="form-control" id="dueDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="taskPriority" class="form-label">Priority</label>
                            <select class="form-select" id="taskPriority">
                                <option value="low"><i class="fas fa-arrow-down me-2"></i> Low</option>
                                <option value="medium" selected><i class="fas fa-equals me-2"></i> Medium</option>
                                <option value="high"><i class="fas fa-arrow-up me-2"></i> High</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="taskProgress" class="form-label">Progress</label>
                            <input type="range" class="form-range" id="taskProgress" min="0" max="100" step="5" value="0">
                            <div class="d-flex justify-content-between">
                                <small>0%</small>
                                <small>50%</small>
                                <small>100%</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="taskDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="taskDescription" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveTask"><i class="fas fa-save me-1"></i> Save Task</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Details Modal -->
    <div class="modal fade" id="eventDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="eventDetailsTitle">Event Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="eventDetailsContent">
                    <!-- Content will be dynamically loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger me-auto" id="deleteEventBtn"><i class="fas fa-trash me-1"></i> Delete</button>
                    <button type="button" class="btn btn-primary" id="editEventBtn"><i class="fas fa-edit me-1"></i> Edit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Toggle Script -->
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('mainContent').classList.toggle('active');
        });
    </script>

    <!-- Greeting Script -->
    <script>
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

        document.addEventListener('DOMContentLoaded', function () {
            updateGreeting();
            setInterval(updateGreeting, 60000);
        });
    </script>

    <!-- Counter Animation Script -->
    <script>
        function animateCounters() {
            const counters = document.querySelectorAll('.counter');
            const speed = 200; // The lower the faster
            
            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;
                const increment = target / speed;
                
                if (count < target) {
                    counter.innerText = Math.ceil(count + increment);
                    setTimeout(animateCounters, 1);
                } else {
                    counter.innerText = target;
                }
            });
        }
        
        // Progress bar animation
        function animateProgressBars() {
            const progressBars = document.querySelectorAll('.progress-animate');
            
            progressBars.forEach(bar => {
                const targetWidth = bar.getAttribute('data-width');
                bar.style.width = targetWidth;
            });
        }
        
        // Initialize animations when elements come into view
        function initAnimations() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCounters();
                        animateProgressBars();
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            
            document.querySelectorAll('.animate-on-load').forEach(section => {
                observer.observe(section);
            });
        }
        
        document.addEventListener('DOMContentLoaded', initAnimations);
    </script>

    <!-- Dynamic Data Loading Script -->
    <script>
        // Sample data for demonstration
        const scheduleData = [
            {
                id: 1,
                type: 'meeting',
                title: 'Team Meeting',
                time: '10:00 AM',
                description: 'Zoom call with the team',
                location: 'Conference Room A'
            },
            {
                id: 2,
                type: 'task',
                title: 'Project Deadline',
                time: '2:00 PM',
                description: 'Submit final report',
                location: ''
            },
            {
                id: 3,
                type: 'event',
                title: 'Client Call',
                time: '4:30 PM',
                description: 'Discuss requirements',
                location: 'Client Office'
            }
        ];

        const taskData = [
            {
                id: 1,
                title: 'Complete project report',
                progress: 25,
                due: 'Due today',
                completed: false
            },
            {
                id: 2,
                title: 'Review team submissions',
                progress: 100,
                due: 'Completed',
                completed: true
            },
            {
                id: 3,
                title: 'Prepare presentation',
                progress: 50,
                due: 'Due tomorrow',
                completed: false
            }
        ];

        const overdueData = [
            {
                id: 1,
                title: 'Project Deadline',
                daysOverdue: 2,
                description: 'Submit final deliverables',
                progress: 15
            },
            {
                id: 2,
                title: 'Client Report',
                daysOverdue: 1,
                description: 'Monthly performance report',
                progress: 45
            },
            {
                id: 3,
                title: 'Meeting Minutes',
                daysOverdue: 3,
                description: 'Send to all participants',
                progress: 5
            }
        ];

        // Load schedule data
        function loadScheduleData() {
            const scheduleList = document.querySelector('.schedule-list');
            scheduleList.innerHTML = '';
            
            scheduleData.forEach(item => {
                const iconClass = item.type === 'meeting' ? 'fa-video text-primary' : 
                                 item.type === 'task' ? 'fa-tasks text-warning' : 
                                 'fa-calendar-check text-success';
                
                const scheduleItem = document.createElement('div');
                scheduleItem.className = 'p-2 border-bottom d-flex align-items-center schedule-item';
                scheduleItem.innerHTML = `
                    <div class="flex-shrink-0 me-2">
                        <div class="bg-${item.type === 'meeting' ? 'primary' : item.type === 'task' ? 'warning' : 'success'}-light p-1 rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                            <i class="fas ${iconClass} small"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <h6 class="mb-0 fw-semibold small">${item.title}</h6>
                            <small class="text-muted">${item.time}</small>
                        </div>
                        <p class="mb-0 text-muted small">${item.description}</p>
                    </div>
                `;
                
                scheduleList.appendChild(scheduleItem);
            });
        }

        // Load task data
        function loadTaskData() {
            const taskList = document.querySelector('.task-list');
            taskList.innerHTML = '';
            
            taskData.forEach(item => {
                const progressColor = item.progress === 100 ? 'success' : 
                                    item.progress > 50 ? 'primary' : 'warning';
                
                const taskItem = document.createElement('div');
                taskItem.className = 'p-2 border-bottom d-flex align-items-center task-item';
                taskItem.innerHTML = `
                    <div class="form-check me-2">
                        <input class="form-check-input" type="checkbox" id="task${item.id}" ${item.completed ? 'checked' : ''}>
                    </div>
                    <div class="flex-grow-1">
                        <label class="form-check-label" for="task${item.id}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-semibold small">${item.title}</h6>
                                <span class="badge bg-${progressColor} rounded-pill small">${item.progress}%</span>
                            </div>
                            <small class="text-muted">${item.due}</small>
                            <div class="progress mt-1" style="height: 3px;">
                                <div class="progress-bar bg-${progressColor}" role="progressbar" style="width: ${item.progress}%;" aria-valuenow="${item.progress}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </label>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-link text-dark p-0" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li><a class="dropdown-item small" href="#"><i class="fas fa-edit me-2"></i>Edit</a></li>
                            <li><a class="dropdown-item small" href="#"><i class="fas fa-trash me-2"></i>Delete</a></li>
                        </ul>
                    </div>
                `;
                
                taskList.appendChild(taskItem);
            });
        }

        // Load overdue data
        function loadOverdueData() {
            const overdueList = document.querySelector('.overdue-list');
            overdueList.innerHTML = '';
            
            overdueData.forEach(item => {
                const overdueItem = document.createElement('div');
                overdueItem.className = 'p-2 border-bottom d-flex align-items-center overdue-item';
                overdueItem.innerHTML = `
                    <div class="flex-shrink-0 me-2">
                        <div class="bg-danger-light p-1 rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                            <i class="fas fa-exclamation text-danger small"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <h6 class="mb-0 fw-semibold small">${item.title}</h6>
                            <small class="text-danger">${item.daysOverdue} day${item.daysOverdue > 1 ? 's' : ''} overdue</small>
                        </div>
                        <p class="mb-0 text-muted small">${item.description}</p>
                        <div class="progress mt-1" style="height: 3px;">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: ${item.progress}%;" aria-valuenow="${item.progress}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                `;
                
                overdueList.appendChild(overdueItem);
            });
        }

        // Initialize data loading
        document.addEventListener('DOMContentLoaded', function() {
            loadScheduleData();
            loadTaskData();
            loadOverdueData();
        });
    </script>

    <!-- Modal Handling Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const eventModal = new bootstrap.Modal(document.getElementById('eventModal'));
            const taskModal = new bootstrap.Modal(document.getElementById('taskModal'));
            const eventDetailsModal = new bootstrap.Modal(document.getElementById('eventDetailsModal'));
            
            // Event modal handling
            document.getElementById('addEventBtn').addEventListener('click', function() {
                eventModal.show();
            });
            
            document.getElementById('saveEvent').addEventListener('click', function() {
                // In a real app, this would save to a database
                alert('Event saved successfully!');
                eventModal.hide();
            });
            
            // Task modal handling
            document.getElementById('addTaskBtn').addEventListener('click', function() {
                taskModal.show();
            });
            
            document.getElementById('saveTask').addEventListener('click', function() {
                // In a real app, this would save to a database
                alert('Task saved successfully!');
                taskModal.hide();
            });
            
            // Event details modal buttons
            document.getElementById('editEventBtn').addEventListener('click', function() {
                eventDetailsModal.hide();
                eventModal.show();
            });
            
            document.getElementById('deleteEventBtn').addEventListener('click', function() {
                if (confirm('Are you sure you want to delete this event?')) {
                    alert('Event deleted successfully!');
                    eventDetailsModal.hide();
                }
            });
        });
    </script>

    <!-- Enhanced Calendar Script with Filtering and Event Click -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize calendar with more features
            const today = new Date();
            let currentDate = new Date();
            let currentView = 'week';
            let workWeekView = true; // Show only Mon-Fri by default
            
            // Filter settings
            let activeFilters = {
                meeting: true,
                task: true,
                event: true,
                personal: true,
                work: true
            };
            
            // Sample events data
            const events = [
                {
                    id: 1,
                    type: 'meeting',
                    title: 'Team Standup',
                    start: new Date(new Date().setHours(9, 0, 0, 0)),
                    end: new Date(new Date().setHours(10, 0, 0, 0)),
                    description: 'Daily team standup meeting',
                    location: 'Conference Room A',
                    category: 'work'
                },
                {
                    id: 2,
                    type: 'task',
                    title: 'Project Deadline',
                    start: new Date(new Date().setHours(14, 0, 0, 0)),
                    end: new Date(new Date().setHours(15, 0, 0, 0)),
                    description: 'Submit final project deliverables',
                    location: '',
                    category: 'work'
                },
                {
                    id: 3,
                    type: 'event',
                    title: 'Birthday Party',
                    start: new Date(new Date().setDate(new Date().getDate() + 2)),
                    end: new Date(new Date().setDate(new Date().getDate() + 2)),
                    description: "Friend's birthday celebration",
                    location: 'Downtown Restaurant',
                    category: 'personal'
                },
                {
                    id: 4,
                    type: 'meeting',
                    title: 'Client Call',
                    start: new Date(new Date().setDate(new Date().getDate() + 1)),
                    end: new Date(new Date().setDate(new Date().getDate() + 1)),
                    description: 'Monthly client review meeting',
                    location: 'Client Office',
                    category: 'work'
                }
            ];
            
            // Set initial view
            updateCalendarView();
            
            // View option click handler
            document.querySelectorAll('.view-option').forEach(option => {
                option.addEventListener('click', function(e) {
                    e.preventDefault();
                    currentView = this.getAttribute('data-view');
                    document.getElementById('currentView').textContent = this.textContent.trim();
                    document.querySelectorAll('.view-option').forEach(opt => opt.classList.remove('active'));
                    this.classList.add('active');
                    updateCalendarView();
                });
            });
            
            // Week view toggle
            document.querySelectorAll('[data-view="workweek"], [data-view="fullweek"]').forEach(btn => {
                btn.addEventListener('click', function() {
                    workWeekView = this.getAttribute('data-view') === 'workweek';
                    document.querySelectorAll('[data-view="workweek"], [data-view="fullweek"]').forEach(b => 
                        b.classList.remove('active'));
                    this.classList.add('active');
                    if (currentView === 'week') updateWeekView();
                });
            });
            
            // Navigation buttons
            document.getElementById('prevPeriod').addEventListener('click', function() {
                navigateCalendar(-1);
            });
            
            document.getElementById('nextPeriod').addEventListener('click', function() {
                navigateCalendar(1);
            });
            
            // Filter change handler
            document.querySelectorAll('.calendar-filter').forEach(filter => {
                filter.addEventListener('change', function() {
                    activeFilters[this.value] = this.checked;
                    updateCalendarView();
                });
            });
            
            function navigateCalendar(direction) {
                if (currentView === 'day') {
                    currentDate.setDate(currentDate.getDate() + direction);
                } else if (currentView === 'week') {
                    currentDate.setDate(currentDate.getDate() + (direction * 7));
                } else if (currentView === 'month') {
                    currentDate.setMonth(currentDate.getMonth() + direction);
                }
                updateCalendarView();
            }
            
            function updateCalendarView() {
                // Hide all views first
                document.getElementById('dayView').classList.add('d-none');
                document.getElementById('weekView').classList.add('d-none');
                document.getElementById('monthView').classList.add('d-none');
                document.getElementById('agendaView').classList.add('d-none');
                
                // Show current view
                document.getElementById(currentView + 'View').classList.remove('d-none');
                
                // Update content based on view
                if (currentView === 'day') {
                    updateDayView();
                } else if (currentView === 'week') {
                    updateWeekView();
                } else if (currentView === 'month') {
                    updateMonthView();
                } else if (currentView === 'agenda') {
                    updateAgendaView();
                }
            }
            
            function updateDayView() {
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                const dateString = currentDate.toLocaleDateString('en-US', options);
                document.querySelector('.calendar-day-title').textContent = dateString;
                
                const timeline = document.querySelector('.calendar-day-timeline');
                timeline.innerHTML = '';
                
                // Generate time slots from 8AM to 8PM
                for (let hour = 8; hour < 20; hour++) {
                    const timeSlot = document.createElement('div');
                    timeSlot.className = 'calendar-time-slot';
                    
                    const timeLabel = document.createElement('div');
                    timeLabel.className = 'calendar-time-label';
                    timeLabel.textContent = `${hour}:00`;
                    
                    const timeContent = document.createElement('div');
                    timeContent.className = 'calendar-time-content';
                    
                    // Add events for this time slot
                    const hourStart = new Date(currentDate);
                    hourStart.setHours(hour, 0, 0, 0);
                    const hourEnd = new Date(currentDate);
                    hourEnd.setHours(hour + 1, 0, 0, 0);
                    
                    const filteredEvents = events.filter(event => {
                        return event.start >= hourStart && event.start < hourEnd && 
                               activeFilters[event.type] && activeFilters[event.category];
                    });
                    
                    filteredEvents.forEach(event => {
                        const eventElement = document.createElement('div');
                        eventElement.className = `calendar-event ${event.type}-event ${event.category}-event`;
                        eventElement.innerHTML = `
                            <div class="event-time">${formatTime(event.start)} - ${formatTime(event.end)}</div>
                            <div class="event-title">${event.title}</div>
                            ${event.location ? `<div class="event-location">${event.location}</div>` : ''}
                        `;
                        
                        // Make event clickable
                        eventElement.style.cursor = 'pointer';
                        eventElement.addEventListener('click', () => showEventDetails(event));
                        
                        timeContent.appendChild(eventElement);
                    });
                    
                    timeSlot.appendChild(timeLabel);
                    timeSlot.appendChild(timeContent);
                    timeline.appendChild(timeSlot);
                }
            }
            
            function updateWeekView() {
                // Calculate start of week (Sunday)
                const startOfWeek = new Date(currentDate);
                startOfWeek.setDate(currentDate.getDate() - currentDate.getDay());
                
                const endOfWeek = new Date(startOfWeek);
                endOfWeek.setDate(startOfWeek.getDate() + (workWeekView ? 4 : 6)); // Show 5 or 7 days
                
                // Update header
                const options = { month: 'long', day: 'numeric' };
                const startString = startOfWeek.toLocaleDateString('en-US', options);
                const endString = endOfWeek.toLocaleDateString('en-US', options);
                const year = startOfWeek.getFullYear();
                document.getElementById('calendarPeriod').textContent = 
                    workWeekView ? `${startString} - ${endString}, ${year}` : 
                                 `${startString} - ${endString}, ${year}`;
                
                // Generate week grid
                const weekGrid = document.querySelector('.calendar-week-grid');
                weekGrid.innerHTML = '';
                
                // Create day columns
                const daysToShow = workWeekView ? 5 : 7;
                for (let i = 0; i < daysToShow; i++) {
                    const day = new Date(startOfWeek);
                    day.setDate(startOfWeek.getDate() + (workWeekView ? i + 1 : i)); // Skip Sunday in work week
                    
                    const dayColumn = document.createElement('div');
                    dayColumn.className = 'calendar-day-column';
                    
                    // Add date indicator
                    const dateIndicator = document.createElement('div');
                    dateIndicator.className = 'calendar-date-indicator';
                    dateIndicator.textContent = day.getDate();
                    
                    // Make date clickable
                    dateIndicator.style.cursor = 'pointer';
                    dateIndicator.addEventListener('click', function() {
                        currentDate = new Date(day);
                        currentView = 'day';
                        updateCalendarView();
                    });
                    
                    // Highlight today
                    if (day.toDateString() === today.toDateString()) {
                        dateIndicator.classList.add('today');
                    }
                    
                    dayColumn.appendChild(dateIndicator);
                    
                    // Add events
                    const eventsContainer = document.createElement('div');
                    eventsContainer.className = 'calendar-day-events';
                    
                    // Get events for this day
                    const dayStart = new Date(day);
                    dayStart.setHours(0, 0, 0, 0);
                    const dayEnd = new Date(day);
                    dayEnd.setHours(23, 59, 59, 999);
                    
                    const filteredEvents = events.filter(event => {
                        return event.start >= dayStart && event.start <= dayEnd && 
                               activeFilters[event.type] && activeFilters[event.category];
                    });
                    
                    filteredEvents.forEach(event => {
                        const eventElement = document.createElement('div');
                        eventElement.className = `calendar-event ${event.type}-event ${event.category}-event`;
                        eventElement.innerHTML = `
                            <div class="event-time">${formatTime(event.start)}</div>
                            <div class="event-title">${event.title}</div>
                        `;
                        
                        // Make event clickable
                        eventElement.style.cursor = 'pointer';
                        eventElement.addEventListener('click', () => showEventDetails(event));
                        
                        eventsContainer.appendChild(eventElement);
                    });
                    
                    dayColumn.appendChild(eventsContainer);
                    weekGrid.appendChild(dayColumn);
                }
            }
            
            function updateMonthView() {
                const year = currentDate.getFullYear();
                const month = currentDate.getMonth();
                const firstDay = new Date(year, month, 1);
                const lastDay = new Date(year, month + 1, 0);
                
                // Update header
                const options = { month: 'long', year: 'numeric' };
                document.getElementById('calendarPeriod').textContent = currentDate.toLocaleDateString('en-US', options);
                
                // Generate month grid
                const monthGrid = document.querySelector('.calendar-month-grid');
                monthGrid.innerHTML = '';
                
                // Add day headers
                const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                days.forEach(day => {
                    const dayHeader = document.createElement('div');
                    dayHeader.className = 'calendar-month-day-header';
                    dayHeader.textContent = day;
                    monthGrid.appendChild(dayHeader);
                });
                
                // Calculate days from previous month to show
                const startingDay = firstDay.getDay();
                for (let i = 0; i < startingDay; i++) {
                    const prevMonthDay = new Date(year, month, -i);
                    const dayCell = createMonthDayCell(prevMonthDay, true);
                    monthGrid.appendChild(dayCell);
                }
                
                // Add days of current month
                for (let i = 1; i <= lastDay.getDate(); i++) {
                    const day = new Date(year, month, i);
                    const dayCell = createMonthDayCell(day, false);
                    monthGrid.appendChild(dayCell);
                }
                
                // Calculate days from next month to show (to fill the grid)
                const endingDay = lastDay.getDay();
                const daysToAdd = 6 - endingDay;
                for (let i = 1; i <= daysToAdd; i++) {
                    const nextMonthDay = new Date(year, month + 1, i);
                    const dayCell = createMonthDayCell(nextMonthDay, true);
                    monthGrid.appendChild(dayCell);
                }
            }
            
            function createMonthDayCell(date, isOtherMonth) {
                const dayCell = document.createElement('div');
                dayCell.className = 'calendar-month-day-cell';
                if (isOtherMonth) {
                    dayCell.classList.add('other-month');
                }
                if (date.toDateString() === today.toDateString()) {
                    dayCell.classList.add('today');
                }
                
                const dateNumber = document.createElement('div');
                dateNumber.className = 'calendar-month-date';
                dateNumber.textContent = date.getDate();
                
                // Make date clickable
                dateNumber.style.cursor = 'pointer';
                dateNumber.addEventListener('click', function() {
                    currentDate = new Date(date);
                    currentView = 'day';
                    updateCalendarView();
                });
                
                dayCell.appendChild(dateNumber);
                
                // Add events for this day
                if (!isOtherMonth) {
                    const eventsContainer = document.createElement('div');
                    eventsContainer.className = 'calendar-month-events';
                    
                    // Get events for this day
                    const dayStart = new Date(date);
                    dayStart.setHours(0, 0, 0, 0);
                    const dayEnd = new Date(date);
                    dayEnd.setHours(23, 59, 59, 999);
                    
                    const filteredEvents = events.filter(event => {
                        return event.start >= dayStart && event.start <= dayEnd && 
                               activeFilters[event.type] && activeFilters[event.category];
                    });
                    
                    filteredEvents.forEach(event => {
                        const eventElement = document.createElement('div');
                        eventElement.className = `calendar-month-event ${event.type}-event ${event.category}-event`;
                        eventElement.innerHTML = `
                            <div class="event-title">${event.title}</div>
                        `;
                        
                        // Make event clickable
                        eventElement.style.cursor = 'pointer';
                        eventElement.addEventListener('click', () => showEventDetails(event));
                        
                        eventsContainer.appendChild(eventElement);
                    });
                    
                    if (eventsContainer.children.length > 0) {
                        dayCell.appendChild(eventsContainer);
                    }
                }
                
                return dayCell;
            }
            
            function updateAgendaView() {
                const agendaList = document.querySelector('.agenda-list');
                agendaList.innerHTML = '';
                
                // Show events for the next 7 days
                const startDate = new Date();
                const endDate = new Date();
                endDate.setDate(startDate.getDate() + 7);
                
                // Group events by day
                const eventsByDay = {};
                const filteredEvents = events.filter(event => 
                    activeFilters[event.type] && activeFilters[event.category]
                );
                
                filteredEvents.forEach(event => {
                    const eventDate = event.start.toDateString();
                    if (!eventsByDay[eventDate]) {
                        eventsByDay[eventDate] = [];
                    }
                    eventsByDay[eventDate].push(event);
                });
                
                // Add events to agenda
                for (let day = new Date(startDate); day <= endDate; day.setDate(day.getDate() + 1)) {
                    const dayHeader = document.createElement('div');
                    dayHeader.className = 'agenda-day-header';
                    dayHeader.textContent = day.toLocaleDateString('en-US', { weekday: 'long', month: 'short', day: 'numeric' });
                    agendaList.appendChild(dayHeader);
                    
                    const dayEvents = eventsByDay[day.toDateString()] || [];
                    
                    if (dayEvents.length === 0) {
                        const noEvents = document.createElement('div');
                        noEvents.className = 'agenda-item';
                        noEvents.innerHTML = `
                            <div class="text-muted small">No events scheduled</div>
                        `;
                        agendaList.appendChild(noEvents);
                    } else {
                        dayEvents.forEach(event => {
                            const agendaItem = document.createElement('div');
                            agendaItem.className = `agenda-item ${event.type}-event ${event.category}-event`;
                            agendaItem.innerHTML = `
                                <div class="agenda-time">${formatTime(event.start)} - ${formatTime(event.end)}</div>
                                <div class="agenda-title">${event.title}</div>
                                ${event.description ? `<div class="agenda-description small text-muted">${event.description}</div>` : ''}
                                ${event.location ? `<div class="agenda-location small text-muted"><i class="fas fa-map-marker-alt me-1"></i>${event.location}</div>` : ''}
                            `;
                            
                            // Make event clickable
                            agendaItem.style.cursor = 'pointer';
                            agendaItem.addEventListener('click', () => showEventDetails(event));
                            
                            agendaList.appendChild(agendaItem);
                        });
                    }
                }
            }
            
            // Show event details in modal
            function showEventDetails(event) {
                const eventDetailsModal = new bootstrap.Modal(document.getElementById('eventDetailsModal'));
                
                // Set modal title
                document.getElementById('eventDetailsTitle').textContent = event.title;
                
                // Format date and time
                const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                const dateString = event.start.toLocaleDateString('en-US', dateOptions);
                const timeString = `${formatTime(event.start)} - ${formatTime(event.end)}`;
                
                // Determine icon based on event type
                let iconClass, iconColor;
                if (event.type === 'meeting') {
                    iconClass = 'fa-video';
                    iconColor = 'primary';
                } else if (event.type === 'task') {
                    iconClass = 'fa-tasks';
                    iconColor = 'warning';
                } else {
                    iconClass = 'fa-calendar-check';
                    iconColor = 'success';
                }
                
                // Set modal content
                document.getElementById('eventDetailsContent').innerHTML = `
                    <div class="d-flex align-items-start mb-3">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-${iconColor}-light p-2 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="fas ${iconClass} text-${iconColor}"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-1">${event.title}</h5>
                            <div class="text-muted mb-2">${dateString}</div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-clock text-muted me-2"></i>
                                <span>${timeString}</span>
                            </div>
                            ${event.location ? `
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-map-marker-alt text-muted me-2"></i>
                                <span>${event.location}</span>
                            </div>` : ''}
                        </div>
                    </div>
                    ${event.description ? `
                    <div class="mb-3">
                        <h6 class="fw-bold small">Description</h6>
                        <p class="mb-0">${event.description}</p>
                    </div>` : ''}
                    <div class="d-flex">
                        <span class="badge bg-${event.category === 'work' ? 'primary' : 'info'}-subtle text-${event.category === 'work' ? 'primary' : 'info'} me-2">
                            ${event.category === 'work' ? 'Work' : 'Personal'}
                        </span>
                        <span class="badge bg-${iconColor}-subtle text-${iconColor}">
                            ${event.type.charAt(0).toUpperCase() + event.type.slice(1)}
                        </span>
                    </div>
                `;
                
                eventDetailsModal.show();
            }
            
            // Helper function to format time
            function formatTime(date) {
                let hours = date.getHours();
                const minutes = date.getMinutes();
                const ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12;
                hours = hours ? hours : 12; // the hour '0' should be '12'
                const minutesStr = minutes < 10 ? '0' + minutes : minutes;
                return `${hours}:${minutesStr} ${ampm}`;
            }
            
            // Initialize with current week view
            updateWeekView();
        });
    </script>

    <!-- Professional CSS Styles -->
    <style>
        :root {
            --primary: #4e73df;
            --primary-light: rgba(78, 115, 223, 0.1);
            --primary-dark: #2e59d9;
            --secondary: #858796;
            --success: #1cc88a;
            --success-light: rgba(28, 200, 138, 0.1);
            --info: #36b9cc;
            --info-light: rgba(54, 185, 204, 0.1);
            --warning: #f6c23e;
            --warning-light: rgba(246, 194, 62, 0.1);
            --danger: #e74a3b;
            --danger-light: rgba(231, 74, 59, 0.1);
            --light: #f8f9fc;
            --dark: #5a5c69;
            --gray-100: #f8f9fa;
            --gray-200: #e9ecef;
            --gray-300: #dddfeb;
            --gray-400: #d1d3e2;
            --gray-500: #b7b9cc;
            --gray-600: #858796;
            --gray-700: #6e707e;
            --gray-800: #5a5c69;
            --gray-900: #3a3b45;
        }

        body {
            background-color: #f5f7fb;
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            font-size: 0.875rem;
            color: var(--gray-800);
        }

        /* Animation Classes */
        .animate-on-load {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.5s ease-out forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hover-scale {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hover-scale:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(78, 115, 223, 0.4);
            }
            70% {
                transform: scale(1.05);
                box-shadow: 0 0 0 10px rgba(78, 115, 223, 0);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(78, 115, 223, 0);
            }
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.05);
            transition: all 0.2s;
            overflow: hidden;
        }

        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.075);
        }

        .card-header {
            padding: 0.75rem 1rem;
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .card-footer {
            background-color: #fff;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            padding: 0.75rem 1rem;
        }

        /* Stat Cards */
        .stat-card {
            border-left: 3px solid transparent;
            transition: all 0.2s;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.075);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
            pointer-events: none;
        }

        .icon-wrapper {
            width: 36px;
            height: 36px;
            border-radius: 0.375rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        /* Progress bars */
        .progress {
            height: 4px;
            background-color: rgba(0, 0, 0, 0.05);
            border-radius: 2px;
        }

        .progress-animate {
            transition: width 1s ease-in-out;
        }

        .progress-number {
            font-size: 0.75rem;
            color: var(--gray-600);
        }

        /* Calendar Styles */
        .calendar-container {
            font-size: 0.85rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            min-height: 0;
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
            color: #23272f;
        }

        /* Week View */
        .calendar-week-view {
            display: flex;
            flex-direction: column;
            height: 400px;
            flex-grow: 1;
        }

        .calendar-week-header {
            display: flex;
            border-bottom: 1px solid #e3e6f0;
            font-weight: 500;
            background: #f7f9fb;
            color: #495057;
        }

        .calendar-day-header {
            flex: 1;
            text-align: center;
            padding: 0.5rem 0.25rem;
            color: #6c757d;
            font-size: 0.78rem;
            text-transform: uppercase;
            font-family: inherit;
        }

        .calendar-week-grid {
            display: flex;
            flex: 1;
            overflow: hidden;
        }

        .calendar-day-column {
            flex: 1;
            border-right: 1px solid #e3e6f0;
            overflow-y: auto;
            padding: 0.25rem;
            background-color: #fcfcfd;
        }

        .calendar-day-column:last-child {
            border-right: none;
        }

        .calendar-date-indicator {
            text-align: center;
            font-weight: 600;
            width: 26px;
            height: 26px;
            line-height: 26px;
            margin: 0 auto 0.25rem;
            border-radius: 50%;
            font-size: 0.78rem;
            transition: all 0.2s;
            color: #495057;
            font-family: inherit;
        }

        .calendar-date-indicator:hover {
            background-color: #e8f0fe;
            color: #2563eb;
        }

        .calendar-date-indicator.today {
            background-color: #2563eb;
            color: #fff;
        }

        .calendar-event {
            padding: 0.28rem 0.4rem;
            margin-bottom: 0.25rem;
            border-radius: 0.25rem;
            font-size: 0.72rem;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
            overflow: hidden;
            color: #23272f;
            background: #f4f6fa;
            font-family: inherit;
        }

        .calendar-event:hover {
            opacity: 0.95;
            transform: translateX(2px);
            background: #e8f0fe;
        }

        .calendar-event::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 3px;
            height: 100%;
        }

        .meeting-event {
            background-color: #e8f0fe;
            border-left: 2px solid #2563eb;
        }

        .task-event {
            background-color: #fffbe6;
            border-left: 2px solid #f6c23e;
        }

        .event-event {
            background-color: #e6f9f0;
            border-left: 2px solid #1cc88a;
        }

        .personal-event {
            background-color: #eaf6fb;
            border-left: 2px solid #36b9cc;
        }

        .work-event {
            background-color: #fbeaea;
            border-left: 2px solid #e74a3b;
        }

        .event-time {
            font-weight: 500;
            margin-bottom: 0.125rem;
            font-size: 0.68rem;
            color: #6c757d;
        }

        /* Day View */
        .calendar-day-view {
            height: 400px;
            overflow-y: auto;
            flex-grow: 1;
            background: #fcfcfd;
        }

        .calendar-day-header {
            padding: 0.5rem;
            border-bottom: 1px solid #e3e6f0;
            background-color: #f7f9fb;
            position: sticky;
            top: 0;
            z-index: 10;
            color: #23272f;
            font-family: inherit;
        }

        .calendar-day-title {
            font-weight: 600;
            font-size: 0.92rem;
            color: #23272f;
            font-family: inherit;
        }

        .calendar-day-timeline {
            padding: 0 0.5rem;
        }

        .calendar-time-slot {
            display: flex;
            min-height: 40px;
            border-bottom: 1px dashed #e3e6f0;
            padding: 0.25rem 0;
        }

        .calendar-time-label {
            width: 40px;
            font-weight: 500;
            color: #adb5bd;
            font-size: 0.68rem;
            padding-top: 0.125rem;
            font-family: inherit;
        }

        /* Month View */
        .calendar-month-view {
            min-height: 400px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            background: #fcfcfd;
        }

        .calendar-month-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.25rem;
            flex-grow: 1;
            min-height: 0;
        }

        .calendar-month-day-header {
            text-align: center;
            font-weight: 500;
            padding: 0.5rem 0.25rem;
            color: #6c757d;
            font-size: 0.72rem;
            text-transform: uppercase;
            background-color: #f7f9fb;
            font-family: inherit;
        }

        .calendar-month-day-cell {
            min-height: 80px;
            padding: 0.25rem;
            border-radius: 0.25rem;
            background-color: #f7f9fb;
            font-size: 0.78rem;
            transition: all 0.2s;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            color: #23272f;
            font-family: inherit;
        }

        .calendar-month-day-cell:hover {
            background-color: #e8f0fe;
        }

        .calendar-month-day-cell.today {
            background-color: #e8f0fe;
        }

        .calendar-month-day-cell.other-month {
            opacity: 0.5;
        }

        .calendar-month-date {
            font-weight: 600;
            margin-bottom: 0.125rem;
            text-align: right;
            color: #495057;
            font-family: inherit;
        }

        .calendar-month-events {
            display: flex;
            flex-direction: column;
            gap: 0.125rem;
            margin-top: auto;
            overflow-y: auto;
            max-height: 60px;
        }

        .calendar-month-event {
            padding: 0.125rem 0.25rem;
            border-radius: 0.125rem;
            font-size: 0.68rem;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            color: #23272f;
            font-family: inherit;
        }

        .calendar-month-event:hover {
            opacity: 0.95;
            transform: translateX(2px);
            background: #e8f0fe;
        }

        .calendar-month-event::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 2px;
            height: 100%;
        }

        /* Agenda View */
        .agenda-day-header {
            font-weight: 600;
            padding: 0.5rem;
            background-color: rgba(0, 0, 0, 0.02);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            margin-top: 0.5rem;
            font-size: 0.75rem;
            position: sticky;
            top: 0;
            background-color: white;
            z-index: 5;
        }

        .agenda-item {
            padding: 0.75rem;
            margin: 0.25rem 0;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .agenda-item:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .agenda-time {
            font-weight: 500;
            color: var(--secondary);
            font-size: 0.625rem;
        }

        /* Schedule and Task Lists */
        .schedule-list, .task-list, .overdue-list {
            max-height: 200px;
            overflow-y: auto;
        }

        .schedule-item, .task-item, .overdue-item {
            padding: 0.75rem;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .schedule-item:hover, .task-item:hover, .overdue-item:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }

        /* Form controls */
        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        /* Dropdown menus */
        .dropdown-menu {
            font-size: 0.8125rem;
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
        }

        .dropdown-item {
            padding: 0.375rem 1rem;
            border-radius: 0.25rem;
        }

        .dropdown-item:hover, .dropdown-item:focus {
            background-color: rgba(0, 0, 0, 0.03);
        }

        /* Buttons */
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            border-radius: 0.375rem;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        /* Notification dropdown */
        .notification-dropdown {
            width: 300px;
            border-radius: 0.5rem;
        }

        .notification-item {
            transition: all 0.2s;
        }

        .notification-item:hover {
            background-color: rgba(0, 0, 0, 0.03);
        }

        .notification-item.unread {
            background-color: rgba(78, 115, 223, 0.05);
        }

        /* Badges */
        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
        }

        /* Event Details Modal */
        .modal-content {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .modal-footer {
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        /* Subtle background colors for event types */
        .bg-primary-subtle {
            background-color: var(--primary-light);
        }

        .bg-success-subtle {
            background-color: var(--success-light);
        }

        .bg-warning-subtle {
            background-color: var(--warning-light);
        }

        .bg-info-subtle {
            background-color: var(--info-light);
        }

        .bg-danger-subtle {
            background-color: var(--danger-light);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .calendar-week-view, .calendar-day-view {
                height: 300px;
            }
            
            .calendar-month-view {
                min-height: 300px;
            }

            .stat-card h4 {
                font-size: 1.25rem;
            }
        }

        @media (max-width: 576px) {
            .calendar-week-header, .calendar-month-day-header {
                font-size: 0.625rem;
            }

            .calendar-month-day-cell {
                min-height: 60px;
                padding: 0.125rem;
            }

            .calendar-date-indicator {
                width: 20px;
                height: 20px;
                line-height: 20px;
                font-size: 0.625rem;
            }
            
            .stat-card {
                padding: 0.5rem;
            }
            
            .icon-wrapper {
                width: 30px;
                height: 30px;
            }
        }
    </style>
@endsection