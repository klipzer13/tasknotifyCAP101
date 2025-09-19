<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4b6cb7;
            --secondary-color: #182848;
            --success-color: #28a745;
            --error-color: #dc3545;
        }
        
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .login-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            width: 100%;
            max-width: 420px;
        }
        
        .login-header {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        
        .login-header h2 {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .login-body {
            padding: 30px;
            background-color: white;
            border-radius: 0 0 10px 10px;
        }
        
        .form-control {
            border-radius: 6px;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(75, 108, 183, 0.25);
            border-color: var(--primary-color);
        }
        
        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
        }
        
        .input-group .form-control {
            border-left: none;
        }
        
        .btn-login {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 6px;
            padding: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .forgot-link {
            color: var(--primary-color);
            text-decoration: none;
            transition: all 0.2s;
        }
        
        .forgot-link:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }
        
        .login-footer {
            text-align: center;
            margin-top: 20px;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        /* Notification Styles */
        .notification-container {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 350px;
            z-index: 9999;
        }
        
        .notification {
            position: relative;
            padding: 15px 20px;
            margin-bottom: 15px;
            border-radius: 6px;
            color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }
        
        .notification.show {
            opacity: 1;
            transform: translateX(0);
        }
        
        .notification.hide {
            opacity: 0;
            transform: translateX(100%);
        }
        
        .notification-success {
            background-color: var(--success-color);
            border-left: 4px solid #1e7e34;
        }
        
        .notification-error {
            background-color: var(--error-color);
            border-left: 4px solid #bd2130;
        }
        
        .notification-icon {
            margin-right: 15px;
            font-size: 1.5rem;
        }
        
        .notification-content {
            flex: 1;
        }
        
        .notification-title {
            font-weight: 600;
            margin-bottom: 3px;
        }
        
        .notification-message {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .notification-close {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 1.2rem;
            opacity: 0.7;
            transition: opacity 0.2s;
            margin-left: 10px;
        }
        
        .notification-close:hover {
            opacity: 1;
        }
        
        /* Form error styles */
        .is-invalid {
            border-color: var(--error-color) !important;
        }
        
        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: var(--error-color);
        }
        
        .was-validated .form-control:invalid ~ .invalid-feedback,
        .form-control.is-invalid ~ .invalid-feedback {
            display: block;
        }
        
        /* Loading spinner */
        .btn-spinner {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            border: 2px solid transparent;
            border-radius: 50%;
            border-top-color: currentColor;
            animation: spin 0.75s ease infinite;
            margin-right: 0.5rem;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Notification Container -->
    <div class="notification-container" id="notificationContainer">
        <!-- Notifications will be dynamically inserted here -->
    </div>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h2><i class="fas fa-user-shield me-2"></i>ADMIN PORTAL</h2>
                <p class="mb-0">Sign in to continue</p>
            </div>
            <div class="login-body">
                <!-- Display Laravel session messages if they exist -->
                <div id="sessionMessages">
                    <!-- Success message -->
                    @if(session('success'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                showNotification('success', 'Success', '{{ session('success') }}');
                            });
                        </script>
                    @endif
                    
                    <!-- Error message -->
                    @if(session('error'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                showNotification('error', 'Error', '{{ session('error') }}');
                            });
                        </script>
                    @endif
                    
                    <!-- Validation errors -->
                    @if($errors->any())
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                @foreach($errors->all() as $error)
                                    showNotification('error', 'Validation Error', '{{ $error }}');
                                @endforeach
                            });
                        </script>
                    @endif
                </div>
                
                <form id="loginForm" action="{{ route('login') }}" method="POST" novalidate>
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="form-label fw-medium">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope text-muted"></i></span>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="admin@example.com" required>
                        </div>
                        <div class="invalid-feedback" id="emailError">
                            @error('email')
                                {{ $message }}
                            @else
                                Please provide a valid email address.
                            @enderror
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label fw-medium">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock text-muted"></i></span>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="••••••••" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback" id="passwordError">
                            @error('password')
                                {{ $message }}
                            @else
                                Please provide your password.
                            @enderror
                        </div>
                    </div>
                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                    </div>
                    <button type="submit" class="btn btn-login btn-block w-100 text-white">
                        <i class="fas fa-sign-in-alt me-2"></i>LOGIN
                    </button>
                    <div class="login-footer mt-3">
                        <p>© 2023 Admin Dashboard. All rights reserved.</p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Notification system
        function showNotification(type, title, message, duration = 5000) {
            const notificationContainer = document.getElementById('notificationContainer');
            const notificationId = 'notification-' + Date.now();
            
            const notification = document.createElement('div');
            notification.id = notificationId;
            notification.className = `notification notification-${type}`;
            
            let iconClass = 'fa-info-circle';
            if (type === 'success') iconClass = 'fa-check-circle';
            if (type === 'error') iconClass = 'fa-exclamation-circle';
            
            notification.innerHTML = `
                <i class="notification-icon fas ${iconClass}"></i>
                <div class="notification-content">
                    <div class="notification-title">${title}</div>
                    <div class="notification-message">${message}</div>
                </div>
                <button type="button" class="notification-close" onclick="closeNotification('${notificationId}')">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            notificationContainer.appendChild(notification);
            
            // Trigger animation
            setTimeout(() => {
                notification.classList.add('show');
            }, 10);
            
            // Auto close after duration if set
            if (duration > 0) {
                setTimeout(() => {
                    closeNotification(notificationId);
                }, duration);
            }
            
            return notificationId;
        }
        
        function closeNotification(notificationId) {
            const notification = document.getElementById(notificationId);
            if (notification) {
                notification.classList.remove('show');
                notification.classList.add('hide');
                
                // Remove from DOM after animation completes
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }
        }
        
        // Form validation and submission
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault();
            event.stopPropagation();
            
            const form = event.target;
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const submitButton = form.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            
            // Basic validation
            let isValid = true;
            
            if (!email.value || !isValidEmail(email.value)) {
                email.classList.add('is-invalid');
                isValid = false;
            } else {
                email.classList.remove('is-invalid');
            }
            
            if (!password.value) {
                password.classList.add('is-invalid');
                isValid = false;
            } else {
                password.classList.remove('is-invalid');
            }
            
            if (!isValid) {
                showNotification('error', 'Validation Error', 'Please check the form fields and try again.');
                form.classList.add('was-validated');
                return;
            }
            
            // Show loading state
            submitButton.innerHTML = '<span class="btn-spinner"></span> LOGGING IN...';
            submitButton.disabled = true;
            
            // Create FormData object
            const formData = new FormData(form);
            
            // Submit the form via AJAX
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showNotification('success', 'Login Successful', 'Redirecting to dashboard...');
                    // Redirect after a short delay
                    setTimeout(() => {
                        window.location.href = data.redirect || '/dashboard';
                    }, 1500);
                } else {
                    throw new Error(data.message || 'Login failed');
                }
            })
            .catch(error => {
                let errorMessage = 'An error occurred during login';
                
                if (error.errors) {
                    // Handle Laravel validation errors
                    for (let field in error.errors) {
                        if (error.errors.hasOwnProperty(field)) {
                            showNotification('error', 'Validation Error', error.errors[field][0]);
                        }
                    }
                } else if (error.message) {
                    errorMessage = error.message;
                    showNotification('error', 'Login Failed', errorMessage);
                } else {
                    showNotification('error', 'Login Failed', errorMessage);
                }
                
                // Reset button
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            });
        });
        
        function isValidEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
        
        // Display any existing validation errors from Laravel
        document.addEventListener('DOMContentLoaded', function() {
            @if($errors->has('email'))
                document.getElementById('email').classList.add('is-invalid');
            @endif
            
            @if($errors->has('password'))
                document.getElementById('password').classList.add('is-invalid');
            @endif
        });
    </script>
</body>
</html>