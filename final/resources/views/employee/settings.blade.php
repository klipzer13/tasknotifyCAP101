@extends('employee.genemp')
@section('title', 'Profile Settings')

@section('content')
    <style>
        .settings-container {
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

        .settings-tabs {
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 20px;
        }

        .settings-tabs .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 600;
            padding: 12px 20px;
            border-radius: 8px 8px 0 0;
            margin-right: 5px;
        }

        .settings-tabs .nav-link.active {
            color: var(--primary-color);
            background-color: rgba(67, 97, 238, 0.1);
            border-bottom: 3px solid var(--primary-color);
        }

        .profile-card {
            border-radius: 12px;
            border: 1px solid #eee;
            padding: 25px;
            margin-bottom: 25px;
            background-color: white;
        }

        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 25px;
            border: 3px solid white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .profile-info h3 {
            margin-bottom: 5px;
            color: #2c3e50;
        }

        .profile-info p {
            color: #7f8c8d;
            margin-bottom: 0;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
            display: block;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.15);
        }

        .btn-save {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
            border-radius: 10px;
            font-size: 1rem;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.25);
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(67, 97, 238, 0.3);
        }

        .avatar-upload {
            position: relative;
            display: inline-block;
            margin-top: 15px;
        }

        .avatar-upload .btn {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--primary-color);
            color: white;
            border: 2px solid white;
        }

        .avatar-upload input {
            display: none;
        }

        .notification-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-label {
            font-weight: 500;
            color: #495057;
        }

        .notification-description {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: var(--primary-color);
        }

        input:checked+.slider:before {
            transform: translateX(26px);
        }

        .security-alert {
            background-color: #fff8e1;
            border-left: 4px solid #ffc107;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .password-strength {
            height: 5px;
            background-color: #e9ecef;
            border-radius: 3px;
            margin-top: 10px;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: width 0.3s ease;
        }

        .password-requirements {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 5px;
        }

        .password-requirements ul {
            padding-left: 20px;
            margin-bottom: 0;
        }

        .password-requirements li {
            margin-bottom: 3px;
        }

        .password-requirements .valid {
            color: #28a745;
        }

        .password-requirements .invalid {
            color: #6c757d;
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
                                    {{ explode(' ', ucwords(strtolower(Auth::user()->name)))[0] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

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
        <!-- Settings/Profile Content -->
        <div class="settings-container">
            <div class="section-header">
                <h4><i class="fas fa-user-cog"></i> Profile Settings</h4>
            </div>

            <ul class="nav nav-tabs settings-tabs" id="settingsTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                        type="button" role="tab">
                        <i class="fas fa-user me-1"></i> Profile
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button"
                        role="tab">
                        <i class="fas fa-lock me-1"></i> Security
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="notifications-tab" data-bs-toggle="tab" data-bs-target="#notifications"
                        type="button" role="tab">
                        <i class="fas fa-bell me-1"></i> Notifications
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="settingsTabsContent">
                <!-- Profile Tab -->
                <div class="tab-pane fade show active" id="profile" role="tabpanel">
                    
                    <div class="profile-card">
                        <div class="profile-header">
                            <div class="avatar-upload">
                                <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('storage/profile/avatars/profile.png') }}"
                                    class="profile-avatar" alt="Profile Avatar" id="avatarPreview">
                                <label class="btn" for="avatarInput">
                                    <i class="fas fa-camera"></i>
                                    <input type="file" id="avatarInput" accept="image/*" style="display: none;">
                                </label>
                            </div>
                            <div class="profile-info">
                                <h3>{{ Auth::user()->name }}</h3>
                                <p>Chairperson</p>
                                <p><i class="fas fa-envelope me-2"></i> {{ Auth::user()->email }}</p>
                                <p><i class="fas fa-user me-2"></i> {{ Auth::user()->username }}</p>
                            </div>
                        </div>

                        <form action="{{ route('employee.profile.update') }}" method="POST" enctype="multipart/form-data"
                            id="profileForm">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ Auth::user()->name }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username"
                                        value="{{ Auth::user()->username }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ Auth::user()->email }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone"
                                        value="{{ Auth::user()->phone }}">
                                </div>
                            </div>

                            <!-- <div class="mb-3">
                                    <label for="department_id" class="form-label">Department</label>
                                    <select class="form-select" id="department_id" name="department_id">
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ Auth::user()->department_id == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div> -->

                            <div class="mb-3">
                                <label for="avatar" class="form-label">Profile Picture</label>
                                <input type="file" class="form-control" id="avatar" name="avatar">
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-save">
                                    <i class="fas fa-save me-2"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Security Tab -->
                <div class="tab-pane fade" id="security" role="tabpanel">
                    <div class="profile-card">
                        <div class="security-alert">
                            <i class="fas fa-shield-alt me-2"></i>
                            <strong>Security Alert:</strong> Last password change was
                            {{ Auth::user()->updated_at->diffForHumans() }}. Consider updating your password regularly.
                        </div>

                        <h5 class="mb-4">Change Password</h5>
                        <form action="{{ route('employee.profile.password') }}" method="POST" id="passwordForm">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password"
                                    placeholder="Enter current password">
                                @error('current_password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Enter new password">
                                <div class="password-strength">
                                    <div class="password-strength-bar" id="passwordStrengthBar"></div>
                                </div>
                                <div class="password-requirements">
                                    <p>Password must contain:</p>
                                    <ul>
                                        <li class="invalid" id="lengthReq">At least 8 characters</li>
                                        <li class="invalid" id="uppercaseReq">One uppercase letter</li>
                                        <li class="invalid" id="lowercaseReq">One lowercase letter</li>
                                        <li class="invalid" id="numberReq">One number</li>
                                        <li class="invalid" id="specialReq">One special character</li>
                                    </ul>
                                </div>
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" placeholder="Confirm new password">
                                <div class="invalid-feedback" id="passwordMatchError" style="display: none;">
                                    Passwords do not match
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-save">
                                    <i class="fas fa-key me-2"></i> Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Notifications Tab -->
                <div class="tab-pane fade" id="notifications" role="tabpanel">
                    <div class="profile-card">
                        <h5 class="mb-4">Notification Preferences</h5>

                        <form action="{{ route('employee.profile.notifications') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <h6 class="mb-3">Task Notifications</h6>
                                <div class="notification-item">
                                    <div>
                                        <div class="notification-label">New Task Assignments</div>
                                        <div class="notification-description">When you're assigned to a new task</div>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" name="notifications[task_assigned]" value="1" {{ Auth::user()->notification_preferences['task_assigned'] ?? true ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </div>

                                <div class="notification-item">
                                    <div>
                                        <div class="notification-label">Task Updates</div>
                                        <div class="notification-description">When tasks you're assigned to are updated
                                        </div>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" name="notifications[task_updated]" value="1" {{ Auth::user()->notification_preferences['task_updated'] ?? true ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="mb-3">Reminder Preferences</h6>
                                <div class="notification-item">
                                    <div>
                                        <div class="notification-label">Due Date Reminders</div>
                                        <div class="notification-description">Remind me before tasks are due</div>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" name="notifications[due_date_reminder]" value="1" {{ Auth::user()->notification_preferences['due_date_reminder'] ?? true ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="mb-3">Notification Methods</h6>
                                <div class="notification-item">
                                    <div>
                                        <div class="notification-label">Email Notifications</div>
                                        <div class="notification-description">Receive notifications via email</div>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" name="notification_methods[email]" value="1" {{ Auth::user()->notification_methods['email'] ?? true ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </div>

                                <div class="notification-item">
                                    <div>
                                        <div class="notification-label">SMS Notifications</div>
                                        <div class="notification-description">Receive notifications via sms</div>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" name="notification_methods[push]" value="1" {{ Auth::user()->notification_methods['push'] ?? true ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </div>

                                <!-- <div class="notification-item">
                                    <div>
                                        <div class="notification-label">In-App Notifications</div>
                                        <div class="notification-description">Show notifications within the application
                                        </div>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" name="notification_methods[in_app]" value="1" {{ Auth::user()->notification_methods['in_app'] ?? true ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </div> -->
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-save">
                                    <i class="fas fa-save me-2"></i> Save Preferences
                                </button>
                            </div>
                        </form>
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

            // Avatar upload preview
            const avatarInput = document.getElementById('avatarInput');
            const avatarPreview = document.getElementById('avatarPreview');

            if (avatarInput) {
                avatarInput.addEventListener('change', function (e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (event) {
                            avatarPreview.src = event.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            // Password strength checker
            const newPassword = document.getElementById('password');
            if (newPassword) {
                newPassword.addEventListener('input', function () {
                    const password = this.value;
                    const strengthBar = document.getElementById('passwordStrengthBar');
                    let strength = 0;

                    // Check password requirements
                    const hasLength = password.length >= 8;
                    const hasUppercase = /[A-Z]/.test(password);
                    const hasLowercase = /[a-z]/.test(password);
                    const hasNumber = /[0-9]/.test(password);
                    const hasSpecial = /[^A-Za-z0-9]/.test(password);

                    // Update requirement indicators
                    document.getElementById('lengthReq').className = hasLength ? 'valid' : 'invalid';
                    document.getElementById('uppercaseReq').className = hasUppercase ? 'valid' : 'invalid';
                    document.getElementById('lowercaseReq').className = hasLowercase ? 'valid' : 'invalid';
                    document.getElementById('numberReq').className = hasNumber ? 'valid' : 'invalid';
                    document.getElementById('specialReq').className = hasSpecial ? 'valid' : 'invalid';

                    // Calculate strength
                    if (hasLength) strength += 20;
                    if (hasUppercase) strength += 20;
                    if (hasLowercase) strength += 20;
                    if (hasNumber) strength += 20;
                    if (hasSpecial) strength += 20;

                    // Update strength bar
                    strengthBar.style.width = strength + '%';

                    // Update color based on strength
                    if (strength < 40) {
                        strengthBar.style.backgroundColor = '#dc3545';
                    } else if (strength < 80) {
                        strengthBar.style.backgroundColor = '#ffc107';
                    } else {
                        strengthBar.style.backgroundColor = '#28a745';
                    }
                });
            }

            // Password match checker
            const confirmPassword = document.getElementById('password_confirmation');
            if (confirmPassword) {
                confirmPassword.addEventListener('input', function () {
                    const passwordMatchError = document.getElementById('passwordMatchError');
                    if (this.value !== newPassword.value) {
                        passwordMatchError.style.display = 'block';
                        this.classList.add('is-invalid');
                    } else {
                        passwordMatchError.style.display = 'none';
                        this.classList.remove('is-invalid');
                    }
                });
            }
        });
    </script>
@endsection