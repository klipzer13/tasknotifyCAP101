@extends('genview')
@section('title', 'Dashboard')

@section('content')
    <style>
        /* Base Styles with Animation Variables */
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --secondary: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --dark: #1e293b;
            --gray: #64748b;
            --light-gray: #e2e8f0;
            --bg-color: #f8fafc;
            --animation-duration: 0.3s;
            --animation-easing: cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        body {
            background-color: var(--bg-color);
            font-size: 0.875rem;
        }

        .main-content {
            padding: 1rem;
            animation: fadeIn 0.5s var(--animation-easing);
        }

        /* Keyframe Animations */
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

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.03);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-5px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Stat Cards with Enhanced Effects */
        .stat-card {
            padding: 1rem;
            border-radius: 0.5rem;
            background: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: all var(--animation-duration) var(--animation-easing);
            height: 100%;
            position: relative;
            overflow: hidden;
            border-left: 3px solid var(--primary);
            animation: slideInRight 0.5s var(--animation-easing) both;
        }

        /* Individual animation delays for stat cards */
        .stat-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .stat-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .stat-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .stat-card:nth-child(4) {
            animation-delay: 0.4s;
        }

        .stat-card:nth-child(5) {
            animation-delay: 0.5s;
        }

        .stat-card:nth-child(6) {
            animation-delay: 0.6s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .stat-card i {
            font-size: 1.25rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
        }

        .stat-card:hover i {
            animation: float 2s ease-in-out infinite;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
            line-height: 1.2;
            transition: all 0.3s ease;
        }

        .stat-card:hover .stat-value {
            color: var(--primary);
        }

        .stat-label {
            color: var(--gray);
            font-size: 0.8125rem;
            margin-bottom: 0.25rem;
        }

        .stat-subtext {
            font-size: 0.6875rem;
            color: #94a3b8;
            margin-top: 0.25rem;
        }

        /* Card Styles with Hover Effects */
        .dashboard-card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: all var(--animation-duration) var(--animation-easing);
            height: 100%;
            background: white;
            margin-bottom: 1rem;
            position: relative;
            overflow: hidden;
        }

        .dashboard-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(67, 97, 238, 0.1) 0%, rgba(58, 12, 163, 0.05) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .dashboard-card:hover::before {
            opacity: 1;
        }

        .dashboard-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border-radius: 0.5rem 0.5rem 0 0 !important;
            padding: 0.75rem 1rem;
            border-bottom: none;
            position: relative;
            overflow: hidden;
        }

        .card-header::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0) 100%);
            transform: translateX(-100%);
        }

        .dashboard-card:hover .card-header::after {
            animation: shimmer 1.5s infinite;
        }

        @keyframes shimmer {
            100% {
                transform: translateX(100%);
            }
        }

        .card-header h5 {
            font-weight: 600;
            margin-bottom: 0;
            font-size: 1rem;
            position: relative;
            z-index: 1;
        }

        .card-header i {
            margin-right: 0.5rem;
            transition: transform 0.3s ease;
        }

        .dashboard-card:hover .card-header i {
            transform: rotate(10deg);
        }

        .card-body {
            padding: 1rem;
            position: relative;
            z-index: 1;
        }

        /* Top Performers Section with Enhanced Interactions */
        .top-performer {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            border-radius: 0.5rem;
            margin-bottom: 0.75rem;
            background: white;
            transition: all 0.3s ease;
            border: 1px solid var(--light-gray);
            position: relative;
            overflow: hidden;
        }

        .top-performer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 3px;
            height: 100%;
            background: var(--primary);
            transform: scaleY(0);
            transform-origin: bottom;
            transition: transform 0.3s ease;
        }

        .top-performer:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            transform: translateX(5px);
        }

        .top-performer:hover::before {
            transform: scaleY(1);
        }

        .performer-rank {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 0.75rem;
            flex-shrink: 0;
            font-size: 0.8125rem;
            transition: all 0.3s ease;
        }

        .top-performer:hover .performer-rank {
            transform: scale(1.1);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        .performer-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 1rem;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .top-performer:hover .performer-avatar {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .performance-meter {
            height: 6px;
            border-radius: 3px;
            background: var(--light-gray);
            overflow: hidden;
            margin: 0.5rem 0;
            position: relative;
        }

        .performance-meter::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, var(--primary) 0%, var(--primary-dark) 100%);
            transform: scaleX(0);
            transform-origin: left;
            animation: fillBar 1.5s var(--animation-easing) forwards;
        }

        @keyframes fillBar {
            to {
                transform: scaleX(var(--progress));
            }
        }

        /* Recent Activity with Timeline Effect */
        .credential-activity {
            display: flex;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--light-gray);
            position: relative;
            opacity: 0;
            animation: fadeIn 0.5s var(--animation-easing) forwards;
        }

        /* Animation delays for activity items */
        .credential-activity:nth-child(1) {
            animation-delay: 0.3s;
        }

        .credential-activity:nth-child(2) {
            animation-delay: 0.4s;
        }

        .credential-activity:nth-child(3) {
            animation-delay: 0.5s;
        }

        .credential-activity::before {
            content: '';
            position: absolute;
            left: 16px;
            top: 40px;
            bottom: -1px;
            width: 2px;
            background: var(--light-gray);
        }

        .credential-activity:last-child::before {
            display: none;
        }

        .credential-badge {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }

        .credential-activity:hover .credential-badge {
            transform: scale(1.1);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        /* Quick Actions with Hover Effects */
        .quick-action-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem;
            border-radius: 0.5rem;
            font-weight: 500;
            margin-bottom: 0.75rem;
            transition: all 0.3s ease;
            font-size: 0.875rem;
            position: relative;
            overflow: hidden;
        }

        .quick-action-btn::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0) 100%);
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .quick-action-btn:hover::after {
            transform: translateX(0);
        }

        .quick-action-btn i {
            margin-right: 0.5rem;
            font-size: 1rem;
            transition: transform 0.3s ease;
        }

        .quick-action-btn:hover i {
            transform: translateX(3px);
        }

        /* Notification Dropdown with Animation */
        .notification-dropdown {
            transform-origin: top right;
            animation: scaleIn 0.2s var(--animation-easing);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border: none;
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .notification-item {
            transition: all 0.2s ease;
        }

        .notification-item:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }

        .notification-item.unread {
            background-color: rgba(67, 97, 238, 0.03);
        }

        /* Chart Tooltip Animation */
        .chart-tooltip {
            opacity: 0;
            position: absolute;
            background: white;
            padding: 0.5rem;
            border-radius: 0.25rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            pointer-events: none;
            transition: all 0.2s ease;
            font-size: 0.75rem;
            z-index: 100;
        }

        /* Responsive Adjustments */
        @media (max-width: 767.98px) {
            .main-content {
                padding: 0.75rem;
            }

            .card-body {
                padding: 0.75rem;
            }

            .stat-card {
                padding: 0.75rem;
                animation: none !important;
            }

            .stat-value {
                font-size: 1.25rem;
            }

            .col-6 {
                padding-left: 0.25rem;
                padding-right: 0.25rem;
            }

            .row {
                margin-left: -0.25rem;
                margin-right: -0.25rem;
            }
        }
    </style>

    <!-- Spacer to move content down -->
    <div style="height: 24px;"></div>

    <!-- Dashboard Content -->
    <h4 class="mb-3">Performance Dashboard</h4> <!-- Statistics Cards - Single Row -->
    <div class="row g-2 mb-3">
        <div class="col-md-2 col-6">
            <div class="stat-card">
                <i class="fas fa-users"></i>
                <div class="stat-value" id="totalEmployeesCounter">0</div>
                <div class="stat-label">Total Employees</div>
                <div class="stat-subtext">As of {{ now()->format('M j, Y') }}</div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="stat-card">
                <i class="fas fa-user-plus"></i>
                <div class="stat-value" id="newEmployeesCounter">0</div>
                <div class="stat-label">New Employees</div>
                <div class="stat-subtext">This month</div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="stat-card">
                <i class="fas fa-tasks"></i>
                <div class="stat-value" id="totalTasksCounter">0</div>
                <div class="stat-label">Total Documents</div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="stat-card">
                <i class="fas fa-spinner"></i>
                <div class="stat-value" id="inProgressCounter">0</div>
                <div class="stat-label">In Review</div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="stat-card">
                <i class="fas fa-check-circle"></i>
                <div class="stat-value" id="completedCounter">0</div>
                <div class="stat-label">Approved</div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="stat-card">
                <i class="fas fa-calendar-alt"></i>
                <div class="stat-value" id="upcomingEventsCounter">0</div>
                <div class="stat-label">Upcoming Events</div>
                <div class="stat-subtext">This month</div>
            </div>
        </div>
    </div>

    <!-- Main Dashboard Section -->
    <div class="row g-2">
        <div class="col-lg-8">
            <div class="dashboard-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="fas fa-chart-line me-1"></i>Task Metrics</h5>
                    <div class="dropdown-wrapper" style="position: relative; display: inline-block;">
                        <select class="form-select form-select-sm border-0" id="timePeriodDropdown" style="
            width: 120px; 
            background: rgba(255,255,255,0.15); 
            color: #fff;
            appearance: none;
            padding-right: 30px;
            cursor: pointer;
          ">
                            <option style="color: #000;">Last 30 Days</option>
                            <option style="color: #000;">Last 7 Days</option>
                            <option style="color: #000;">Last 90 Days</option>
                        </select>
                        <span class="dropdown-icon" style="
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #fff;
          ">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="row g-1 mx-1 mb-2 mt-1">
                        <div class="col-md-6">
                            <select class="filter-control w-100" id="metricsDepartmentFilter"
                                style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                                <option value="all">All Departments</option>
                                <option value="marketing">IT</option>
                                <option value="development">Office Admin</option>
                                <option value="design">Business Admin</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select class="filter-control w-100" id="metricsStatusFilter"
                                style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                                <option value="all">All Statuses</option>
                                <option value="approved">Approved</option>
                                <option value="in-review">In Review</option>
                            </select>
                        </div>
                    </div>

                    <div class="chart-container position-relative" style="height: 250px; margin: 0 0.5rem;">
                        <canvas id="performanceChart"></canvas>

                        <!-- Hover Tooltip -->
                        <div class="chart-hover-tooltip"
                            style="display: none; position: absolute; background: rgba(30, 41, 59, 0.95); color: white; padding: 0.5rem 0.75rem; border-radius: 0.25rem; font-size: 0.75rem; pointer-events: none; z-index: 10; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                            <div class="tooltip-title font-weight-bold mb-1"></div>
                            <div class="tooltip-value"></div>
                            <div class="tooltip-change"></div>
                        </div>

                        <!-- Summary Badges - Compact Version -->
                        <div class="chart-summary-badges">
                            <div class="summary-badge" data-metric="approval-rate">
                                <div class="badge-value">92%</div>
                                <div class="badge-label">Approval</div>
                            </div>
                            <div class="summary-badge" data-metric="completion">
                                <div class="badge-value">90%</div>
                                <div class="badge-label">Completion</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            /* Summary Badges Styles */
            .chart-summary-badges {
                position: absolute;
                top: 0.5rem;
                right: 0.5rem;
                display: flex;
                gap: 0.25rem;
                z-index: 5;
            }

            .summary-badge {
                background: white;
                padding: 0.25rem 0.5rem;
                border-radius: 0.25rem;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                text-align: center;
                min-width: 50px;
                transition: all 0.2s ease;
                border: 1px solid rgba(0, 0, 0, 0.05);
            }

            .badge-value {
                font-weight: 600;
                font-size: 0.75rem;
                color: var(--primary);
                line-height: 1.2;
            }

            .badge-label {
                font-size: 0.55rem;
                color: var(--gray);
                text-transform: uppercase;
                letter-spacing: 0.3px;
                line-height: 1.2;
            }

            .summary-badge:hover {
                transform: translateY(-1px);
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }

            /* Chart Container Styles */
            .chart-container {
                transition: all 0.3s ease;
            }

            .chart-container:hover {
                transform: scale(1.005);
            }

            /* Tooltip Animation */
            .chart-hover-tooltip {
                opacity: 0;
                transform: translate(-50%, -120%) scale(0.95);
                transition: all 0.2s ease;
            }

            .chart-hover-tooltip.active {
                opacity: 1;
                transform: translate(-50%, -120%) scale(1);
                display: block;
            }
        </style>

        <script>
            function initCharts() {
                const performanceCtx = document.getElementById('performanceChart').getContext('2d');
                const tooltip = document.querySelector('.chart-hover-tooltip');

                performanceChart = new Chart(performanceCtx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                        datasets: [{
                            label: 'Approval Rate',
                            data: [65, 72, 80, 81, 85, 88, 92],
                            backgroundColor: 'rgba(67, 97, 238, 0.1)',
                            borderColor: '#4361ee',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#4361ee',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }, {
                            label: 'Completion',
                            data: [50, 65, 70, 78, 82, 85, 90],
                            backgroundColor: 'rgba(58, 12, 163, 0.1)',
                            borderColor: '#3a0ca3',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#3a0ca3',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    font: {
                                        size: 11
                                    },
                                    padding: 10,
                                    usePointStyle: true,
                                    boxWidth: 6
                                }
                            },
                            tooltip: {
                                enabled: false,
                                external: function (context) {
                                    const { chart, tooltip } = context;
                                    const tooltipEl = document.querySelector('.chart-hover-tooltip');

                                    if (tooltip.opacity === 0) {
                                        tooltipEl.classList.remove('active');
                                        return;
                                    }

                                    const title = tooltip.dataPoints[0].dataset.label;
                                    const value = tooltip.dataPoints[0].raw;
                                    const change = tooltip.dataPoints[0].dataIndex > 0 ?
                                        (value - tooltip.dataPoints[0].dataset.data[tooltip.dataPoints[0].dataIndex - 1]) : 0;

                                    tooltipEl.querySelector('.tooltip-title').textContent = title;
                                    tooltipEl.querySelector('.tooltip-value').textContent = `${value}%`;
                                    tooltipEl.querySelector('.tooltip-change').textContent =
                                        `${change >= 0 ? '+' : ''}${change}% ${change >= 0 ? '▲' : '▼'}`;
                                    tooltipEl.querySelector('.tooltip-change').style.color =
                                        change >= 0 ? '#10b981' : '#ef4444';

                                    const position = context.chart.canvas.getBoundingClientRect();
                                    tooltipEl.style.left = position.left + tooltip.caretX + 'px';
                                    tooltipEl.style.top = position.top + tooltip.caretY + 'px';
                                    tooltipEl.classList.add('active');
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100,
                                ticks: {
                                    callback: function (value) {
                                        return value + '%';
                                    },
                                    font: {
                                        size: 10
                                    }
                                },
                                grid: {
                                    color: 'rgba(226, 232, 240, 0.5)'
                                }
                            },
                            x: {
                                ticks: {
                                    font: {
                                        size: 10
                                    }
                                },
                                grid: {
                                    color: 'rgba(226, 232, 240, 0.5)'
                                }
                            }
                        }
                    }
                });

                // Add hover effect to summary badges
                document.querySelectorAll('.summary-badge').forEach(badge => {
                    badge.addEventListener('mouseenter', function () {
                        gsap.to(this, {
                            y: -2,
                            duration: 0.2,
                            ease: "power2.out"
                        });
                    });

                    badge.addEventListener('mouseleave', function () {
                        gsap.to(this, {
                            y: 0,
                            duration: 0.2,
                            ease: "power2.out"
                        });
                    });
                });
            }
        </script>
        <div class="col-lg-4">
            <div class="dashboard-card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="fas fa-trophy me-1"></i>Top Performers</h5>
                    <div class="dropdown-wrapper" style="position: relative; display: inline-block;">
                        <select class="form-select form-select-sm border-0" id="departmentFilter" style="
            width: 150px; 
            min-width: 120px; 
            background: rgba(255,255,255,0.15); 
            color: #fff;
            appearance: none;
            padding-right: 30px;
            cursor: pointer;
          ">
                            <option value="all" style="color: #000;">All</option>
                            <option value="marketing" style="color: #000;">IT</option>
                            <option value="development" style="color: #000;">Office Admin</option>
                        </select>
                        <span class="dropdown-icon" style="
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #fff;
          ">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="card-body" style="overflow-y: auto; max-height: 300px; padding: 0.5rem;">
                    <!-- Performer 1 -->
                    <div class="top-performer" data-department="marketing">
                        <div class="performer-rank" style="background-color: #FFD700;">1</div>
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Sarah Johnson"
                            class="performer-avatar">
                        <div class="performer-details" style="flex: 1; min-width: 0;">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6
                                    style="font-size: 0.875rem; font-weight: 600; margin-bottom: 0.1rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    Elisha Fernanzez</h6>
                                <span class="performance-percentage"
                                    style="color: #3b82f6; font-size: 0.75rem; font-weight: bold;">98%</span>
                            </div>
                            <div class="performer-department"
                                style="font-size: 0.7rem; color: #64748b; margin-bottom: 0.2rem;">IT Department</div>
                            <div class="performance-meter" style="--progress: 0.98; height: 4px; margin: 0.3rem 0;"></div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="performer-stat" style="font-size: 0.7rem; color: #64748b;">42 docs</span>
                                <div class="rating-stars" style="color: #FFD700; font-size: 0.7rem;">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span style="color: #000; font-weight: bold;">4.7</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Performer 2 -->
                    <div class="top-performer" data-department="development">
                        <div class="performer-rank" style="background-color: #FFD700;">2</div>
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Michael Chen"
                            class="performer-avatar">
                        <div class="performer-details" style="flex: 1; min-width: 0;">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6
                                    style="font-size: 0.875rem; font-weight: 600; margin-bottom: 0.1rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    Joshua Daroya</h6>
                                <span class="performance-percentage"
                                    style="color: #3b82f6; font-size: 0.75rem; font-weight: bold;">95%</span>
                            </div>
                            <div class="performer-department"
                                style="font-size: 0.7rem; color: #64748b; margin-bottom: 0.2rem;">Office Admin</div>
                            <div class="performance-meter" style="--progress: 0.95; height: 4px; margin: 0.3rem 0;"></div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="performer-stat" style="font-size: 0.7rem; color: #64748b;">38 docs</span>
                                <div class="rating-stars" style="color: #FFD700; font-size: 0.7rem;">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <span style="color: #000; font-weight: bold;">4.2</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Performer 3 -->
                    <div class="top-performer" data-department="design">
                        <div class="performer-rank" style="background-color: #FFD700;">3</div>
                        <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Emily Rodriguez"
                            class="performer-avatar">
                        <div class="performer-details" style="flex: 1; min-width: 0;">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6
                                    style="font-size: 0.875rem; font-weight: 600; margin-bottom: 0.1rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    Jommel Incipido</h6>
                                <span class="performance-percentage"
                                    style="color: #3b82f6; font-size: 0.75rem; font-weight: bold;">92%</span>
                            </div>
                            <div class="performer-department"
                                style="font-size: 0.7rem; color: #64748b; margin-bottom: 0.2rem;">Backend Developer</div>
                            <div class="performance-meter" style="--progress: 0.92; height: 4px; margin: 0.3rem 0;"></div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="performer-stat" style="font-size: 0.7rem; color: #64748b;">35 docs</span>
                                <div class="rating-stars" style="color: #FFD700; font-size: 0.7rem;">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <span style="color: #000; font-weight: bold;">4.1</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- View All Link -->
                    <div class="text-center mt-1">
                        <a href="#" class="text-primary" style="font-size: 0.75rem;">View Full Leaderboard <i
                                class="fas fa-chevron-right" style="font-size: 0.6rem;"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Section -->
    <div class="row g-2 mt-2">
        <!-- Document Status Section -->
        <div class="col-lg-6">
            <div class="dashboard-card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="fas fa-chart-pie me-1"></i>Document Status</h5>
                    <div class="dropdown-wrapper" style="position: relative; display: inline-block;">
                        <select class="form-select form-select-sm border-0" id="documentStatusFilter" style="
            width: 150px; 
            min-width: 120px; 
            background: rgba(255,255,255,0.15); 
            color: #fff;
            appearance: none;
            padding-right: 30px;
            cursor: pointer;
          ">
                            <option value="all" style="color: #000;">All Departments</option>
                            <option value="it" style="color: #000;">IT</option>
                            <option value="office" style="color: #000;">Office Admin</option>
                            <option value="business" style="color: #000;">Business Admin</option>
                        </select>
                        <span class="dropdown-icon" style="
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #fff;
          ">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container position-relative" style="height: 300px;">
                        <canvas id="documentStatusChart"></canvas>
                        <!-- Center text element -->
                        <div class="chart-center-text position-absolute top-50 start-50 translate-middle text-center">
                            <div class="fs-5 fw-bold">157</div>
                            <div class="text-muted small">Total Docs</div>
                        </div>
                    </div>

                    <!-- Custom legend with status details -->
                    <div class="chart-legend mt-3">
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="legend-color me-2"
                                        style="background-color: #10b981; width: 12px; height: 12px; border-radius: 3px;">
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted small">Approved</span>
                                            <span class="fw-bold small">109 (69.4%)</span>
                                        </div>
                                        <div class="progress mt-1" style="height: 4px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 69.4%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="legend-color me-2"
                                        style="background-color: #3b82f6; width: 12px; height: 12px; border-radius: 3px;">
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted small">In Review</span>
                                            <span class="fw-bold small">18 (11.5%)</span>
                                        </div>
                                        <div class="progress mt-1" style="height: 4px;">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 11.5%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="legend-color me-2"
                                        style="background-color: #64748b; width: 12px; height: 12px; border-radius: 3px;">
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted small">Pending</span>
                                            <span class="fw-bold small">25 (15.9%)</span>
                                        </div>
                                        <div class="progress mt-1" style="height: 4px;">
                                            <div class="progress-bar bg-secondary" role="progressbar" style="width: 15.9%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="legend-color me-2"
                                        style="background-color: #ef4444; width: 12px; height: 12px; border-radius: 3px;">
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted small">Rejected</span>
                                            <span class="fw-bold small">5 (3.2%)</span>
                                        </div>
                                        <div class="progress mt-1" style="height: 4px;">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 3.2%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Enhanced Document Status Chart
            function initDocumentStatusChart() {
                const documentStatusCtx = document.getElementById('documentStatusChart').getContext('2d');
                documentStatusChart = new Chart(documentStatusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Approved', 'In Review', 'Pending', 'Rejected'],
                        datasets: [{
                            data: [109, 18, 25, 5],
                            backgroundColor: [
                                '#10b981',
                                '#3b82f6',
                                '#64748b',
                                '#ef4444'
                            ],
                            borderWidth: 0,
                            hoverOffset: 15,
                            hoverBorderColor: '#fff',
                            hoverBorderWidth: 3
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            animateScale: true,
                            animateRotate: true,
                            duration: 1500
                        },
                        plugins: {
                            legend: {
                                display: false // We're using custom legend
                            },
                            tooltip: {
                                backgroundColor: 'rgba(30, 41, 59, 0.95)',
                                bodyFont: {
                                    size: 12
                                },
                                padding: 12,
                                usePointStyle: true,
                                callbacks: {
                                    label: function (context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = Math.round((value / total) * 100);
                                        return `${label}: ${value} documents (${percentage}%)`;
                                    }
                                }
                            },
                            // Add percentage labels to the chart itself
                            datalabels: {
                                display: false // We'll use custom labels with animation
                            }
                        },
                        cutout: '70%',
                        layout: {
                            padding: 10
                        }
                    }
                });

                // Animate the chart segments on load
                gsap.from(document.querySelectorAll('#documentStatusChart'), {
                    opacity: 0,
                    scale: 0.8,
                    duration: 1,
                    ease: "power2.out"
                });
            }

            // Update the chart when filter changes
            document.getElementById('documentStatusFilter').addEventListener('change', function () {
                // Simulate data change based on filter
                let newData;
                switch (this.value) {
                    case 'it':
                        newData = [45, 8, 10, 2];
                        break;
                    case 'office':
                        newData = [32, 5, 8, 1];
                        break;
                    case 'business':
                        newData = [32, 5, 7, 2];
                        break;
                    default:
                        newData = [109, 18, 25, 5];
                }

                // Animate the chart update
                gsap.to(documentStatusChart.data.datasets[0], {
                    data: newData,
                    duration: 1,
                    onUpdate: function () {
                        documentStatusChart.update();
                        updateLegendValues(newData);
                    }
                });

                // Update center total
                const total = newData.reduce((a, b) => a + b, 0);
                gsap.to(document.querySelector('.chart-center-text .fs-5'), {
                    innerText: total,
                    duration: 1,
                    snap: { innerText: 1 }
                });
            });

            // Helper function to update legend values
            function updateLegendValues(data) {
                const total = data.reduce((a, b) => a + b, 0);
                const percentages = data.map(value => Math.round((value / total) * 1000) / 10);

                document.querySelectorAll('.chart-legend .fw-bold').forEach((el, index) => {
                    el.textContent = `${data[index]} (${percentages[index]}%)`;
                });

                document.querySelectorAll('.chart-legend .progress-bar').forEach((el, index) => {
                    el.style.width = `${percentages[index]}%`;
                });
            }

            // Initialize the chart when DOM is loaded
            document.addEventListener('DOMContentLoaded', function () {
                initDocumentStatusChart();
            });
        </script>

        <style>
            /* Additional styles for the enhanced chart */
            .chart-center-text {
                pointer-events: none;
                z-index: 1;
                background: rgba(255, 255, 255, 0.9);
                border-radius: 50%;
                width: 100px;
                height: 100px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }

            .chart-legend .progress {
                background-color: #e2e8f0;
            }

            /* Animation for legend items */
            .chart-legend .d-flex {
                transition: all 0.3s ease;
                padding: 4px 8px;
                border-radius: 4px;
            }

            .chart-legend .d-flex:hover {
                background-color: rgba(226, 232, 240, 0.5);
                transform: translateX(2px);
            }
        </style>

        <!-- Recent Activity -->
        <div class="col-lg-6">
            <div class="dashboard-card h-100">
                <div class="card-header d-flex justify-content-between align-items-center border-bottom pb-2"
                    style="color: #fff; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);">
                    <h5 class="mb-0 fw-semibold" style="color: #fff;">
                        <i class="fas fa-history me-2 text-light"></i>Recent Approvals
                    </h5>
                    <div class="dropdown-wrapper" style="position: relative; display: inline-block;">
                        <select class="form-select form-select-sm border-0" id="credentialFilter" style="
            width: 120px; 
            background: rgba(255,255,255,0.15); 
            color: #fff;
            appearance: none;
            padding-right: 30px;
            cursor: pointer;
          ">
                            <option value="all" style="color: #000;">All</option>
                            <option value="marketing" style="color: #000;">IT</option>
                            <option value="development" style="color: #000;">Office Admin</option>
                        </select>
                        <span class="dropdown-icon" style="
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #fff;
          ">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="card-body p-0" style="overflow-y: auto; max-height: 300px;">
                    <!-- Activity List -->
                    <div class="list-group list-group-flush">
                        <!-- Activity 1 -->
                        <div class="list-group-item border-0 py-3 px-4" data-department="marketing">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <div class="bg-primary bg-opacity-10 p-2 rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 36px; height: 36px;">
                                        <i class="fas fa-file-alt text-primary fs-6"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fw-semibold mb-1">Annual Compliance Report</h6>
                                    <p class="text-muted small mb-2">Approved by Sarah Johnson</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span
                                            class="badge bg-success bg-opacity-10 text-success fs-11 fw-medium px-2 py-1">Approved</span>
                                        <span class="text-muted fs-11">IT • Today, 10:45 AM</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Activity 2 -->
                        <div class="list-group-item border-0 py-3 px-4" data-department="development">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <div class="bg-secondary bg-opacity-10 p-2 rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 36px; height: 36px;">
                                        <i class="fas fa-file-contract text-secondary fs-6"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fw-semibold mb-1">Client Service Agreement</h6>
                                    <p class="text-muted small mb-2">Approved by Michael Chen</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span
                                            class="badge bg-success bg-opacity-10 text-success fs-11 fw-medium px-2 py-1">Approved</span>
                                        <span class="text-muted fs-11">Office • Today, 9:30 AM</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Activity 3 -->
                        <div class="list-group-item border-0 py-3 px-4" data-department="design">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <div class="bg-info bg-opacity-10 p-2 rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 36px; height: 36px;">
                                        <i class="fas fa-file-invoice text-info fs-6"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fw-semibold mb-1">Q2 Financial Report</h6>
                                    <p class="text-muted small mb-2">Approved by David Wilson</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span
                                            class="badge bg-warning bg-opacity-10 text-warning fs-11 fw-medium px-2 py-1">In
                                            Review</span>
                                        <span class="text-muted fs-11">Finance • Yesterday, 4:15 PM</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="row g-2 mt-2">
        <div class="col-lg-8">
            <div class="dashboard-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="fas fa-tasks me-1"></i>Pending Reviews</h5>
                    <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-primary"
                        style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                        View All
                    </a>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-0 py-2" style="font-size: 0.8125rem;">
                        <i class="fas fa-info-circle me-2"></i> Documents pending review would appear here
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5><i class="fas fa-bolt me-1"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('tasks.create') }}" class="btn btn-primary quick-action-btn w-100">
                        <i class="fas fa-plus me-1"></i>Upload Document
                    </a>
                    <a href="{{ route('task.members') }}" class="btn btn-outline-primary quick-action-btn w-100">
                        <i class="fas fa-user-plus me-1"></i>Assign Reviewer
                    </a>
                    <button class="btn btn-outline-primary quick-action-btn w-100">
                        <i class="fas fa-file-export me-1"></i>Generate Report
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Include GSAP for advanced animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>

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

            // Animate the greeting change
            gsap.fromTo(greetingElement,
                { opacity: 0, y: -10 },
                { opacity: 1, y: 0, duration: 0.5 }
            );

            greetingElement.textContent = greeting;
        }

        // Enhanced counter animation with GSAP
        function animateCounters() {
            const counters = [
                { element: 'totalEmployeesCounter', target: 156, suffix: '' },
                { element: 'newEmployeesCounter', target: 8, suffix: '' },
                { element: 'totalTasksCounter', target: 127, suffix: '' },
                { element: 'inProgressCounter', target: 18, suffix: '' },
                { element: 'completedCounter', target: 109, suffix: '' },
                { element: 'upcomingEventsCounter', target: 5, suffix: '' }
            ];

            counters.forEach(counter => {
                const element = document.getElementById(counter.element);
                gsap.to({ val: 0 }, {
                    val: counter.target,
                    duration: 2,
                    ease: "power2.out",
                    onUpdate: function () {
                        element.textContent = Math.floor(this.targets()[0].val) + counter.suffix;
                    }
                });
            });
        }

        // Department filter functionality for Top Performers with animation
        function setupDepartmentFilter() {
            const filter = document.getElementById('departmentFilter');
            filter.addEventListener('change', function () {
                const selectedDept = this.value;
                const performers = document.querySelectorAll('.top-performer');

                gsap.to(performers, {
                    opacity: 0,
                    x: -20,
                    duration: 0.3,
                    onComplete: function () {
                        performers.forEach(performer => {
                            if (selectedDept === 'all' || performer.dataset.department === selectedDept) {
                                performer.style.display = 'flex';
                                gsap.to(performer, {
                                    opacity: 1,
                                    x: 0,
                                    duration: 0.3,
                                    delay: 0.1
                                });
                            } else {
                                performer.style.display = 'none';
                            }
                        });

                        // Re-rank the visible performers
                        const visiblePerformers = document.querySelectorAll('.top-performer[style="display: flex;"]');
                        visiblePerformers.forEach((performer, index) => {
                            const rankElement = performer.querySelector('.performer-rank');
                            gsap.to(rankElement, {
                                scale: 1.2,
                                duration: 0.2,
                                yoyo: true,
                                repeat: 1,
                                onComplete: function () {
                                    rankElement.textContent = index + 1;
                                }
                            });
                        });
                    }
                });
            });
        }

        // Initialize charts with animation effects
        let performanceChart, documentStatusChart;

        function initCharts() {
            // Performance Chart with tooltip animation
            const performanceCtx = document.getElementById('performanceChart').getContext('2d');
            performanceChart = new Chart(performanceCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                    datasets: [{
                        label: 'Approval Rate',
                        data: [65, 72, 80, 81, 85, 88, 92],
                        backgroundColor: 'rgba(67, 97, 238, 0.1)',
                        borderColor: '#4361ee',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#4361ee',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }, {
                        label: 'Completion',
                        data: [50, 65, 70, 78, 82, 85, 90],
                        backgroundColor: 'rgba(58, 12, 163, 0.1)',
                        borderColor: '#3a0ca3',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#3a0ca3',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1500,
                        easing: 'easeOutQuart'
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                font: {
                                    size: 11
                                },
                                usePointStyle: true,
                                padding: 20
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(30, 41, 59, 0.9)',
                            titleFont: {
                                size: 12
                            },
                            bodyFont: {
                                size: 11
                            },
                            padding: 10,
                            usePointStyle: true,
                            callbacks: {
                                label: function (context) {
                                    return context.dataset.label + ': ' + context.raw + '%';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                callback: function (value) {
                                    return value + '%';
                                },
                                font: {
                                    size: 10
                                }
                            },
                            grid: {
                                color: 'rgba(226, 232, 240, 0.5)'
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 10
                                }
                            },
                            grid: {
                                color: 'rgba(226, 232, 240, 0.5)'
                            }
                        }
                    }
                }
            });

            // Document Status Chart with animation
            const documentStatusCtx = document.getElementById('documentStatusChart').getContext('2d');
            documentStatusChart = new Chart(documentStatusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Approved', 'In Review', 'Pending', 'Rejected'],
                    datasets: [{
                        data: [109, 18, 25, 5],
                        backgroundColor: [
                            '#10b981',
                            '#3b82f6',
                            '#64748b',
                            '#ef4444'
                        ],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        animateScale: true,
                        animateRotate: true,
                        duration: 1500
                    },
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                font: {
                                    size: 11
                                },
                                boxWidth: 10,
                                padding: 10,
                                usePointStyle: true
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(30, 41, 59, 0.9)',
                            bodyFont: {
                                size: 11
                            },
                            padding: 10,
                            usePointStyle: true,
                            callbacks: {
                                label: function (context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    },
                    cutout: '75%'
                }
            });
        }

        // Add hover effects to quick action buttons
        function setupQuickActions() {
            const quickActions = document.querySelectorAll('.quick-action-btn');

            quickActions.forEach(button => {
                button.addEventListener('mouseenter', function () {
                    gsap.to(this, {
                        scale: 1.02,
                        duration: 0.2,
                        ease: "power2.out"
                    });
                });

                button.addEventListener('mouseleave', function () {
                    gsap.to(this, {
                        scale: 1,
                        duration: 0.2,
                        ease: "power2.out"
                    });
                });
            });
        }

        // Add ripple effect to buttons
        function setupRippleEffects() {
            document.addEventListener('click', function (e) {
                const target = e.target.closest('.btn, .stat-card, .dashboard-card, .quick-action-btn');
                if (!target) return;

                const rect = target.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                const ripple = document.createElement('span');
                ripple.className = 'ripple-effect';
                ripple.style.left = `${x}px`;
                ripple.style.top = `${y}px`;

                target.appendChild(ripple);

                gsap.fromTo(ripple,
                    { scale: 0, opacity: 0.3 },
                    {
                        scale: 10,
                        opacity: 0,
                        duration: 0.6,
                        ease: "power2.out",
                        onComplete: () => ripple.remove()
                    }
                );
            });
        }

        // Initialize everything when DOM is loaded
        document.addEventListener('DOMContentLoaded', function () {
            updateGreeting();
            animateCounters();
            setupDepartmentFilter();
            initCharts();
            setupQuickActions();
            setupRippleEffects();

            // Update greeting every minute in case page stays open for long
            setInterval(updateGreeting, 60000);

            // Add animation to notification badge
            const notificationBadge = document.querySelector('.notification-dropdown .badge');
            if (notificationBadge) {
                gsap.to(notificationBadge, {
                    scale: 1.2,
                    duration: 0.5,
                    repeat: -1,
                    yoyo: true,
                    ease: "power1.inOut"
                });
            }

            // Add pulse animation to important elements
            const importantElements = document.querySelectorAll('.stat-card, .dashboard-card');
            importantElements.forEach(el => {
                el.addEventListener('mouseenter', function () {
                    gsap.to(this, {
                        scale: 1.01,
                        duration: 0.3,
                        ease: "power2.out"
                    });
                });

                el.addEventListener('mouseleave', function () {
                    gsap.to(this, {
                        scale: 1,
                        duration: 0.3,
                        ease: "power2.out"
                    });
                });
            });
        });
    </script>

    <style>
        /* Ripple effect styles */
        .ripple-effect {
            position: absolute;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.7);
            transform: translate(-50%, -50%);
            pointer-events: none;
            width: 20px;
            height: 20px;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(226, 232, 240, 0.5);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(100, 116, 139, 0.5);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(100, 116, 139, 0.7);
        }
    </style>

@endsection