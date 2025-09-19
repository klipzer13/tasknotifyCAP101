@extends('chairperson.genchair')
@section('title', 'Dashboard')

@section('content')
    <style>
        body {
            font-size: 0.875rem;
            background-color: #f5f7fa;
        }
        
        .dashboard-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 15px;
            margin-bottom: 15px;
            border: none;
        }

        /* Improved Top Performers Section */
        .top-performers-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 15px;
        }

        .performer-card {
            display: flex;
            align-items: center;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 10px;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
            border-left: 3px solid #4361ee;
            position: relative;
            overflow: hidden;
        }

        .performer-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #f0f4ff;
        }

        .performer-rank {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background-color: #4361ee;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 12px;
            flex-shrink: 0;
            z-index: 2;
        }

        .performer-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 12px;
            object-fit: cover;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 2;
        }

        .performer-info {
            flex: 1;
            min-width: 0;
            z-index: 2;
        }

        .performer-name {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .performer-stats {
            display: flex;
            gap: 10px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-weight: 700;
            color: #4361ee;
            font-size: 0.9rem;
        }

        .stat-label {
            font-size: 0.65rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .performance-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 600;
            background-color: rgba(67, 97, 238, 0.1);
            color: #4361ee;
            margin-left: 8px;
            z-index: 2;
        }

        /* Progress Bar Styles */
        .performance-progress-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .performance-progress {
            height: 100%;
            background-color: rgba(67, 97, 238, 0.1);
            border-radius: 0 6px 6px 0;
            transform-origin: left;
            transform: scaleX(0);
            transition: transform 1.5s ease-out;
        }

        /* Improved Calendar Filter */
        .calendar-filter {
            display: flex;
            gap: 8px;
            margin-bottom: 12px;
            flex-wrap: wrap;
        }

        .calendar-filter-btn {
            padding: 4px 10px;
            font-size: 0.75rem;
            border-radius: 12px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            color: #495057;
            transition: all 0.2s;
        }

        .calendar-filter-btn:hover {
            background-color: #e9ecef;
        }

        .calendar-filter-btn.active {
            background-color: #4361ee;
            border-color: #4361ee;
            color: white;
        }

        /* Rest of your existing styles... */
        .stat-card {
            background-color: white;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
            padding: 12px;
            margin-bottom: 12px;
            border-left: 3px solid #4361ee;
            transition: transform 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
        }

        .stat-card .icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: rgba(67, 97, 238, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
            color: #4361ee;
            font-size: 1rem;
        }

        .stat-card h3 {
            font-weight: 700;
            margin-bottom: 2px;
            color: #2c3e50;
            font-size: 1.3rem;
        }

        .stat-card p {
            color: #7f8c8d;
            margin-bottom: 0;
            font-size: 0.75rem;
        }

        .section-header {
            margin-bottom: 15px;
            padding-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-header h4 {
            color: #4361ee;
            font-weight: 600;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            margin: 0;
        }

        .section-header h4 i {
            margin-right: 8px;
            color: #4361ee;
            font-size: 0.9rem;
        }

        .calendar-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 15px;
            height: 100%;
        }

        .fc {
            width: 100%;
            font-size: 0.8rem;
        }

        .fc .fc-toolbar-title {
            font-size: 0.95rem;
        }

        .fc .fc-button {
            padding: 3px 6px;
            font-size: 0.75rem;
            border-radius: 4px;
        }

        .fc .fc-daygrid-day-frame {
            min-height: 50px;
        }

        .fc .fc-daygrid-day-number {
            font-size: 0.7rem;
            padding: 2px;
        }

        .fc .fc-col-header-cell-cushion {
            font-size: 0.7rem;
            padding: 4px 2px;
        }

        .fc .fc-event {
            font-size: 0.65rem;
            padding: 1px 2px;
            margin-bottom: 1px;
        }

        .event-list {
            margin-top: 12px;
        }

        .event-item {
            padding: 8px;
            border-radius: 5px;
            margin-bottom: 6px;
            background-color: #f9fafb;
            border-left: 2px solid #4361ee;
            font-size: 0.8rem;
        }

        .event-item:hover {
            background-color: #f0f4ff;
        }

        .event-item .event-title {
            font-weight: 600;
            margin-bottom: 3px;
            color: #2c3e50;
        }

        .event-item .event-time,
        .event-item .event-location {
            font-size: 0.7rem;
            color: #6c757d;
            display: flex;
            align-items: center;
        }

        .event-item .event-time i,
        .event-item .event-location i {
            margin-right: 4px;
        }

        .analytics-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 12px;
            margin-bottom: 12px;
            height: 100%;
        }

        .analytics-header {
            margin-bottom: 10px;
        }

        .analytics-header h5 {
            font-weight: 600;
            font-size: 0.95rem;
            margin: 0;
            color: #2c3e50;
        }

        .chart-container {
            position: relative;
            height: 180px;
            width: 100%;
        }

        .main-content {
            padding: 10px;
        }

        .row {
            margin-left: -5px;
            margin-right: -5px;
        }

        [class*="col-"] {
            padding-left: 5px;
            padding-right: 5px;
        }

        .badge {
            font-size: 0.7rem;
            padding: 0.25em 0.4em;
            font-weight: 500;
            border-radius: 4px;
        }

        .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            border-radius: 4px;
        }

        .btn-sm {
            padding: 0.2rem 0.4rem;
            font-size: 0.7rem;
        }

        .top-navbar {
            padding: 5px 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .top-navbar .navbar-brand {
            font-size: 0.9rem;
        }

        .notification-toast {
            position: fixed;
            top: 15px;
            right: 15px;
            z-index: 1000;
            min-width: 250px;
            font-size: 0.85rem;
        }

        @media (max-width: 768px) {
            .stat-card h3 {
                font-size: 1.1rem;
            }
            
            .section-header h4 {
                font-size: 1rem;
            }
            
            .chart-container {
                height: 160px;
            }
        }
    </style>

   

        <!-- Stats Cards -->
        <div class="dashboard-container mb-2">
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <h3 id="totalTasks">24</h3>
                        <p>Total Tasks</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="icon">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <h3 id="overdueTasks">5</h3>
                        <p>Overdue</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h3 id="completedTasks">12</h3>
                        <p>Completed</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 id="teamMembersCount">8</h3>
                        <p>Team Members</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Row -->
        <div class="row">
            <!-- Analytics Column -->
            <div class="col-lg-8">
                <div class="dashboard-container">
                    <div class="section-header">
                        <h4><i class="fas fa-chart-line"></i> Performance</h4>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="biTimeRange" data-bs-toggle="dropdown">
                                This Month
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item active" href="#" data-range="month">This Month</a></li>
                                <li><a class="dropdown-item" href="#" data-range="week">This Week</a></li>
                                <li><a class="dropdown-item" href="#" data-range="quarter">This Quarter</a></li>
                                <li><a class="dropdown-item" href="#" data-range="year">This Year</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="analytics-card">
                                <div class="analytics-header">
                                    <h5>Completion Rate</h5>
                                    <span class="badge bg-light text-dark">Current</span>
                                </div>
                                <div class="chart-container">
                                    <canvas id="completionRateChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="analytics-card">
                                <div class="analytics-header">
                                    <h5>Performance Trend</h5>
                                    <span class="badge bg-light text-dark">6 Months</span>
                                </div>
                                <div class="chart-container">
                                    <canvas id="performanceTrendChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Improved Top Performers Section -->
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <div class="analytics-card">
                                <div class="section-header">
                                    <h5>Top Performers <span class="badge bg-primary">This Month</span></h5>
                                </div>
                                <div class="top-performers-container">
                                    <div class="performer-card">
                                        <div class="performance-progress-container">
                                            <div class="performance-progress" style="width: 95%"></div>
                                        </div>
                                        <div class="performer-rank">1</div>
                                        <img src="https://randomuser.me/api/portraits/women/44.jpg" class="performer-avatar">
                                        <div class="performer-info">
                                            <div class="performer-name">Sarah Johnson</div>
                                            <div class="performer-stats">
                                                <div class="stat-item">
                                                    <div class="stat-value">18</div>
                                                    <div class="stat-label">Tasks</div>
                                                </div>
                                                <div class="stat-item">
                                                    <div class="stat-value">92%</div>
                                                    <div class="stat-label">On Time</div>
                                                </div>
                                                <div class="stat-item">
                                                    <div class="stat-value">4.8</div>
                                                    <div class="stat-label">Quality</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="performance-badge">95%</div>
                                    </div>
                                    <div class="performer-card">
                                        <div class="performance-progress-container">
                                            <div class="performance-progress" style="width: 90%"></div>
                                        </div>
                                        <div class="performer-rank">2</div>
                                        <img src="https://randomuser.me/api/portraits/men/32.jpg" class="performer-avatar">
                                        <div class="performer-info">
                                            <div class="performer-name">Michael Chen</div>
                                            <div class="performer-stats">
                                                <div class="stat-item">
                                                    <div class="stat-value">15</div>
                                                    <div class="stat-label">Tasks</div>
                                                </div>
                                                <div class="stat-item">
                                                    <div class="stat-value">88%</div>
                                                    <div class="stat-label">On Time</div>
                                                </div>
                                                <div class="stat-item">
                                                    <div class="stat-value">4.7</div>
                                                    <div class="stat-label">Quality</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="performance-badge">90%</div>
                                    </div>
                                    <div class="performer-card">
                                        <div class="performance-progress-container">
                                            <div class="performance-progress" style="width: 89%"></div>
                                        </div>
                                        <div class="performer-rank">3</div>
                                        <img src="https://randomuser.me/api/portraits/women/68.jpg" class="performer-avatar">
                                        <div class="performer-info">
                                            <div class="performer-name">Emily Rodriguez</div>
                                            <div class="performer-stats">
                                                <div class="stat-item">
                                                    <div class="stat-value">12</div>
                                                    <div class="stat-label">Tasks</div>
                                                </div>
                                                <div class="stat-item">
                                                    <div class="stat-value">85%</div>
                                                    <div class="stat-label">On Time</div>
                                                </div>
                                                <div class="stat-item">
                                                    <div class="stat-value">4.9</div>
                                                    <div class="stat-label">Quality</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="performance-badge">89%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calendar Column -->
<div class="col-lg-4">
    <div class="calendar-container" style="height: 100%; display: flex; flex-direction: column;">
        <div class="section-header">
            <h4><i class="fas fa-calendar-alt"></i> Schedule</h4>
            <button class="btn btn-sm btn-primary" id="addEventBtn">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        
        <!-- Calendar Filter -->
        <div class="calendar-filter">
            <button class="calendar-filter-btn active" data-type="all">All</button>
            <button class="calendar-filter-btn" data-type="event">Events</button>
            <button class="calendar-filter-btn" data-type="task">Tasks</button>
            <button class="calendar-filter-btn" data-type="meeting">Meetings</button>
        </div>
        
        <!-- Fixed Calendar Height (inline) -->
        <div id="calendar" class="fc fc-media-screen fc-direction-ltr fc-theme-standard" style="flex: 1; min-height: 370px;"></div>
        
        <!-- Event List (with scroll if needed) -->
        <div class="event-list" style="overflow-y: auto; max-height: 200px;">
            <h5 class="mb-2">Today</h5>
            <div id="todaysEvents">
                <div class="event-item">
                    <div class="event-title">Team Standup</div>
                    <div class="event-time">
                        <i class="far fa-clock me-1"></i>
                        10:00 - 10:30 AM
                    </div>
                    <div class="event-location">
                        <i class="fas fa-map-marker-alt"></i> Conf Room A
                    </div>
                </div>
                <div class="event-item">
                    <div class="event-title">Client Meeting</div>
                    <div class="event-time">
                        <i class="far fa-clock me-1"></i>
                        2:00 - 3:30 PM
                    </div>
                    <div class="event-location">
                        <i class="fas fa-video"></i> Zoom
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        </div>

        <!-- Bottom Row -->
        <div class="row mt-2" style="font-size: 0.7rem;">
            <div class="col-md-6">
                <div class="dashboard-container p-2">
                    <div class="section-header mb-1" style="padding-bottom: 2px;">
                        <h6 class="m-0" style="font-size: 0.8rem;"><i class="fas fa-clock"></i> Approvals</h6>
                        <span class="badge bg-danger" style="font-size: 0.65rem;">3 Urgent</span>
                    </div>
                    <div id="pendingApprovals">
                        <div class="task-item d-flex align-items-center mb-1" style="font-size: 0.7rem; min-height: 32px;">
                            <div class="task-check me-2" style="font-size: 0.9rem;">
                                <i class="fas fa-file-invoice-dollar text-primary"></i>
                            </div>
                            <div class="task-info flex-grow-1">
                                <div style="font-weight: 500; font-size: 0.75rem;">Budget Approval
                                    <span class="priority-badge priority-high ms-1" style="font-size: 0.6rem;">High</span>
                                </div>
                                <div class="task-meta d-flex flex-wrap gap-1" style="font-size: 0.65rem;">
                                    <span><i class="fas fa-user"></i> Finance</span>
                                    <span><i class="fas fa-calendar-alt"></i> Due tomorrow</span>
                                    <span class="status-badge status-pending_approval">Pending</span>
                                </div>
                            </div>
                            <a href="#" class="btn btn-sm btn-outline-primary ms-2" style="font-size: 0.65rem; padding: 1px 6px;">Review</a>
                        </div>
                        <div class="task-item d-flex align-items-center mb-1" style="font-size: 0.7rem; min-height: 32px;">
                            <div class="task-check me-2" style="font-size: 0.9rem;">
                                <i class="fas fa-users text-primary"></i>
                            </div>
                            <div class="task-info flex-grow-1">
                                <div style="font-weight: 500; font-size: 0.75rem;">Hiring Request
                                    <span class="priority-badge priority-medium ms-1" style="font-size: 0.6rem;">Medium</span>
                                </div>
                                <div class="task-meta d-flex flex-wrap gap-1" style="font-size: 0.65rem;">
                                    <span><i class="fas fa-user"></i> HR</span>
                                    <span><i class="fas fa-calendar-alt"></i> Due in 3 days</span>
                                    <span class="status-badge status-pending">Pending</span>
                                </div>
                            </div>
                            <a href="#" class="btn btn-sm btn-outline-primary ms-2" style="font-size: 0.65rem; padding: 1px 6px;">Review</a>
                        </div>
                    </div>
                    <div class="text-center mt-1">
                        <a href="#" class="btn btn-link btn-sm" style="font-size: 0.65rem;">View All</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="dashboard-container p-2">
                    <div class="section-header mb-1" style="padding-bottom: 2px;">
                        <h6 class="m-0" style="font-size: 0.8rem;"><i class="fas fa-history"></i> Recent Activity</h6>
                        <span class="badge bg-light text-dark" style="font-size: 0.65rem;">7 Days</span>
                    </div>
                    <div id="recentActivity">
                        <div class="task-item d-flex align-items-center mb-1" style="font-size: 0.7rem; min-height: 32px;">
                            <div class="task-check me-2">
                                <img src="https://randomuser.me/api/portraits/men/22.jpg" class="assignee" style="width: 22px; height: 22px; border-radius: 50%;">
                            </div>
                            <div class="task-info flex-grow-1">
                                <div style="font-weight: 500; font-size: 0.75rem;">Alex updated "Project Proposal"</div>
                                <div class="task-meta d-flex flex-wrap gap-1" style="font-size: 0.65rem;">
                                    <span><i class="fas fa-clock"></i> 2h ago</span>
                                    <span class="status-badge status-in-progress">In Progress</span>
                                </div>
                            </div>
                        </div>
                        <div class="task-item d-flex align-items-center mb-1" style="font-size: 0.7rem; min-height: 32px;">
                            <div class="task-check me-2">
                                <img src="https://randomuser.me/api/portraits/women/65.jpg" class="assignee" style="width: 22px; height: 22px; border-radius: 50%;">
                            </div>
                            <div class="task-info flex-grow-1">
                                <div style="font-weight: 500; font-size: 0.75rem;">Jessica submitted "Marketing Plan"</div>
                                <div class="task-meta d-flex flex-wrap gap-1" style="font-size: 0.65rem;">
                                    <span><i class="fas fa-clock"></i> 5h ago</span>
                                    <span class="status-badge status-completed">Completed</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-1">
                        <a href="#" class="btn btn-link btn-sm" style="font-size: 0.65rem;">View All</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include libraries -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>

    <script>
        // Initialize compact charts
        function initCharts() {
            // Completion Rate Chart
            const completionRateCtx = document.getElementById('completionRateChart');
            if (completionRateCtx) {
                new Chart(completionRateCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Completed', 'In Progress', 'Overdue'],
                        datasets: [{
                            data: [12, 7, 5],
                            backgroundColor: ['#4CAF50', '#FFC107', '#F44336'],
                            borderWidth: 0,
                            borderRadius: 3
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 10,
                                    font: {
                                        size: 9
                                    },
                                    usePointStyle: true,
                                    pointStyle: 'circle'
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return `${context.label}: ${context.raw} (${Math.round(context.raw/24*100)}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Performance Trend Chart
            const performanceTrendCtx = document.getElementById('performanceTrendChart');
            if (performanceTrendCtx) {
                new Chart(performanceTrendCtx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                        datasets: [{
                            label: 'Task Completion',
                            data: [65, 59, 80, 81, 76, 85],
                            borderColor: '#4e73df',
                            backgroundColor: 'rgba(78, 115, 223, 0.05)',
                            tension: 0.3,
                            borderWidth: 2,
                            fill: true,
                            pointBackgroundColor: '#4e73df',
                            pointRadius: 3,
                            pointHoverRadius: 5
                        }, {
                            label: 'On-Time',
                            data: [70, 65, 75, 77, 80, 82],
                            borderColor: '#1cc88a',
                            backgroundColor: 'rgba(28, 200, 138, 0.05)',
                            tension: 0.3,
                            borderWidth: 2,
                            fill: true,
                            pointBackgroundColor: '#1cc88a',
                            pointRadius: 3,
                            pointHoverRadius: 5
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 10,
                                    font: {
                                        size: 9
                                    },
                                    usePointStyle: true,
                                    pointStyle: 'circle'
                                }
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100,
                                grid: {
                                    drawBorder: false
                                },
                                ticks: {
                                    callback: function(value) {
                                        return value + '%';
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        },
                        interaction: {
                            mode: 'nearest',
                            axis: 'x',
                            intersect: false
                        }
                    }
                });
            }
        }

        // Initialize calendar with filter functionality
        function initCalendar() {
            const calendarEl = document.getElementById('calendar');
            if (calendarEl) {
                // Sample events data with types
                const events = [
                    {
                        title: 'Planning Session',
                        start: new Date(new Date().setDate(new Date().getDate() + 2)),
                        color: '#4e73df',
                        extendedProps: {
                            description: 'Quarterly planning session',
                            type: 'meeting'
                        }
                    },
                    {
                        title: 'Product Launch',
                        start: new Date(new Date().setDate(new Date().getDate() + 5)),
                        color: '#1cc88a',
                        extendedProps: {
                            description: 'New product launch',
                            type: 'event'
                        }
                    },
                    {
                        title: 'Bug Fix Deadline',
                        start: new Date(new Date().setDate(new Date().getDate() + 3)),
                        color: '#f6c23e',
                        extendedProps: {
                            description: 'Critical bug fixes due',
                            type: 'task'
                        }
                    },
                    {
                        title: 'Client Demo',
                        start: new Date(new Date().setDate(new Date().getDate() + 7)),
                        color: '#e74a3b',
                        extendedProps: {
                            description: 'Demo for new client',
                            type: 'meeting'
                        }
                    }
                ];

                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next',
                        center: 'title',
                        right: ''
                    },
                    events: events,
                    dayMaxEventRows: 1,
                    height: 250,
                    eventClick: function(info) {
                        info.jsEvent.preventDefault();
                        
                        const modal = new bootstrap.Modal(document.getElementById('eventModal'));
                        const modalTitle = document.getElementById('eventModalTitle');
                        const modalBody = document.getElementById('eventModalBody');
                        
                        modalTitle.textContent = info.event.title;
                        modalBody.innerHTML = `
                            <p><strong>Date:</strong> ${info.event.start.toLocaleDateString()}</p>
                            <p><strong>Type:</strong> ${info.event.extendedProps.type.charAt(0).toUpperCase() + info.event.extendedProps.type.slice(1)}</p>
                            ${info.event.extendedProps.description ? 
                              `<p><strong>Description:</strong> ${info.event.extendedProps.description}</p>` : ''}
                        `;
                        
                        modal.show();
                    }
                });
                calendar.render();

                // Calendar filter functionality
                const filterButtons = document.querySelectorAll('.calendar-filter-btn');
                filterButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        // Remove active class from all buttons
                        filterButtons.forEach(btn => btn.classList.remove('active'));
                        
                        // Add active class to clicked button
                        this.classList.add('active');
                        
                        const filterType = this.getAttribute('data-type');
                        
                        if (filterType === 'all') {
                            // Show all events
                            calendar.getEvents().forEach(event => {
                                event.setProp('display', 'auto');
                            });
                        } else {
                            // Filter events by type
                            calendar.getEvents().forEach(event => {
                                if (event.extendedProps.type === filterType) {
                                    event.setProp('display', 'auto');
                                } else {
                                    event.setProp('display', 'none');
                                }
                            });
                        }
                    });
                });
            }
        }

        // Animate progress bars
        function animateProgressBars() {
            document.querySelectorAll('.performance-progress').forEach(progress => {
                // Get the width from the style attribute
                const width = progress.style.width;
                // Reset to 0 for animation
                progress.style.transform = 'scaleX(0)';
                // Trigger reflow
                progress.offsetHeight;
                // Animate to full width
                progress.style.transform = 'scaleX(1)';
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Update greeting based on time of day
            const hour = new Date().getHours();
            const greeting = hour < 12 ? 'Morning' : hour < 18 ? 'Afternoon' : 'Evening';
            document.getElementById('adminGreeting').textContent += greeting;

            // Initialize components
            initCalendar();
            initCharts();
            animateProgressBars();
            
            // Notification functionality
            const markAllReadBtn = document.querySelector('.mark-all-read');
            if (markAllReadBtn) {
                markAllReadBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    document.querySelectorAll('.notification-item.unread').forEach(item => {
                        item.classList.remove('unread');
                    });
                    document.getElementById('notificationBadge').textContent = '0';
                    document.getElementById('notificationCount').textContent = '0';
                });
            }

            // Time range filter functionality
            document.querySelectorAll('#biTimeRange .dropdown-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    const range = this.getAttribute('data-range');
                    const button = document.getElementById('biTimeRange');
                    
                    // Update button text
                    button.textContent = this.textContent;
                    
                    // Remove active class from all items
                    document.querySelectorAll('#biTimeRange .dropdown-item').forEach(i => {
                        i.classList.remove('active');
                    });
                    
                    // Add active class to clicked item
                    this.classList.add('active');
                    
                    // In a real app, this would trigger an AJAX call to update charts
                    console.log('Time range changed to:', range);
                });
            });

            // Add event button functionality
            document.getElementById('addEventBtn')?.addEventListener('click', function() {
                // In a real app, this would open a modal to add a new event
                alert('Add new event functionality would go here');
            });
        });
    </script>

    <!-- Event Modal (hidden by default) -->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalTitle">Event Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="eventModalBody">
                    <!-- Content will be dynamically inserted here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-primary">Edit Event</button>
                </div>
            </div>
        </div>
    </div>
@endsection