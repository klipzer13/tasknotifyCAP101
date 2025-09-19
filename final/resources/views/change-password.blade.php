<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set New Password</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4b6cb7;
            --secondary-color: #182848;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --error-color: #dc3545;
        }

        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .password-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .password-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
        }

        .password-header {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }

        .password-header h2 {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .password-body {
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

        .btn-submit {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 6px;
            padding: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            transition: all 0.3s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .password-requirements {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 15px;
            margin-top: 20px;
            font-size: 0.85rem;
        }

        .requirement {
            margin-bottom: 5px;
            display: flex;
            align-items: center;
        }

        .requirement i {
            margin-right: 8px;
            width: 16px;
        }

        .requirement.valid {
            color: var(--success-color);
        }

        .requirement.invalid {
            color: #6c757d;
        }

        .strength-meter {
            height: 5px;
            border-radius: 3px;
            margin-top: 10px;
            background-color: #e9ecef;
            overflow: hidden;
        }

        .strength-meter-fill {
            height: 100%;
            width: 0;
            border-radius: 3px;
            transition: width 0.3s, background-color 0.3s;
        }

        .password-footer {
            text-align: center;
            margin-top: 20px;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .alert {
            border-radius: 6px;
            padding: 12px 15px;
            margin-bottom: 20px;
            display: none;
        }
    </style>
</head>

<body>
    <div class="password-container">
        <div class="password-card">
            <div class="password-header">
                <h2><i class="fas fa-key me-2"></i>SET NEW PASSWORD</h2>
                <p class="mb-0">Create a strong and secure password</p>
            </div>
            <div class="password-body">
                <!-- Alert for success/error messages -->
                <div id="alertMessage" class="alert alert-dismissible fade show" role="alert">
                    <span id="alertContent"></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

                <form id="passwordForm">
                    <!-- CSRF Token for Laravel -->
                    <input type="hidden" id="csrfToken" value="{{ csrf_token() }}">

                    <!-- User ID (if needed) -->
                    <input type="hidden" id="userId" value="{{ $user->id }}">

                    <div class="mb-4">
                        <label for="password" class="form-label fw-medium">New Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock text-muted"></i></span>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Enter new password" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="strength-meter mt-2">
                            <div class="strength-meter-fill" id="passwordStrength"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-medium">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock text-muted"></i></span>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="Confirm your password" required>
                            <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="mt-1" id="confirmMessage"></div>
                    </div>

                    <div class="password-requirements">
                        <h6 class="mb-3">Password Requirements:</h6>
                        <div class="requirement invalid" id="reqLength">
                            <i class="fas fa-circle"></i>
                            <span>At least 8 characters</span>
                        </div>
                        <div class="requirement invalid" id="reqUppercase">
                            <i class="fas fa-circle"></i>
                            <span>One uppercase letter</span>
                        </div>
                        <div class="requirement invalid" id="reqLowercase">
                            <i class="fas fa-circle"></i>
                            <span>One lowercase letter</span>
                        </div>
                        <div class="requirement invalid" id="reqNumber">
                            <i class="fas fa-circle"></i>
                            <span>One number</span>
                        </div>
                        <div class="requirement invalid" id="reqSpecial">
                            <i class="fas fa-circle"></i>
                            <span>One special character</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-submit btn-block w-100 text-white mt-4">
                        <i class="fas fa-save me-2"></i>UPDATE PASSWORD
                    </button>
                    <div class="password-footer">
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
        document.getElementById('togglePassword').addEventListener('click', function () {
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

        document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password_confirmation');
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

        // Password validation
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');
        const confirmMessage = document.getElementById('confirmMessage');
        const strengthBar = document.getElementById('passwordStrength');

        password.addEventListener('input', function () {
            validatePassword();
            checkPasswordMatch();
            updatePasswordStrength();
        });

        confirmPassword.addEventListener('input', checkPasswordMatch);

        function validatePassword() {
            const passwordValue = password.value;

            // Check length
            document.getElementById('reqLength').className = passwordValue.length >= 8 ?
                'requirement valid' : 'requirement invalid';

            // Check uppercase
            document.getElementById('reqUppercase').className = /[A-Z]/.test(passwordValue) ?
                'requirement valid' : 'requirement invalid';

            // Check lowercase
            document.getElementById('reqLowercase').className = /[a-z]/.test(passwordValue) ?
                'requirement valid' : 'requirement invalid';

            // Check number
            document.getElementById('reqNumber').className = /[0-9]/.test(passwordValue) ?
                'requirement valid' : 'requirement invalid';

            // Check special character
            document.getElementById('reqSpecial').className = /[!@#$%^&*(),.?":{}|<>]/.test(passwordValue) ?
                'requirement valid' : 'requirement invalid';
        }

        function checkPasswordMatch() {
            if (confirmPassword.value === '') {
                confirmMessage.innerHTML = '';
                return;
            }

            if (password.value === confirmPassword.value) {
                confirmMessage.innerHTML = '<span class="text-success"><i class="fas fa-check-circle"></i> Passwords match</span>';
            } else {
                confirmMessage.innerHTML = '<span class="text-danger"><i class="fas fa-times-circle"></i> Passwords do not match</span>';
            }
        }

        function updatePasswordStrength() {
            const passwordValue = password.value;
            let strength = 0;

            if (passwordValue.length >= 8) strength += 20;
            if (/[A-Z]/.test(passwordValue)) strength += 20;
            if (/[a-z]/.test(passwordValue)) strength += 20;
            if (/[0-9]/.test(passwordValue)) strength += 20;
            if (/[!@#$%^&*(),.?":{}|<>]/.test(passwordValue)) strength += 20;

            strengthBar.style.width = strength + '%';

            if (strength < 40) {
                strengthBar.style.backgroundColor = '#dc3545'; // Weak - red
            } else if (strength < 80) {
                strengthBar.style.backgroundColor = '#ffc107'; // Medium - yellow
            } else {
                strengthBar.style.backgroundColor = '#28a745'; // Strong - green
            }
        }

        // Show alert message
        function showAlert(message, type) {
            const alertDiv = document.getElementById('alertMessage');
            const alertContent = document.getElementById('alertContent');

            alertContent.innerHTML = message;
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.style.display = 'block';

            // Auto hide after 5 seconds
            setTimeout(() => {
                hideAlert();
            }, 5000);
        }

        // Hide alert message
        function hideAlert() {
            const alertDiv = document.getElementById('alertMessage');
            alertDiv.style.display = 'none';
        }

        // Form submission
        document.getElementById('passwordForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            // Validate all requirements
            const requirements = document.querySelectorAll('.requirement.valid');
            if (requirements.length !== 5) {
                showAlert('Please ensure your password meets all requirements.', 'danger');
                return;
            }

            if (password.value !== confirmPassword.value) {
                showAlert('Passwords do not match. Please confirm your password.', 'danger');
                return;
            }

            // Get form data
            const formData = {
                password: password.value,
                password_confirmation: confirmPassword.value,
                _token: document.getElementById('csrfToken').value
            };

            // Get user ID if available
            const userId = document.getElementById('userId').value;

            try {
                // Show loading state
                const submitBtn = document.querySelector('.btn-submit');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>UPDATING...';
                submitBtn.disabled = true;

                // Send request to server - use the correct route name
                const response = await fetch(`/users/${userId}/password`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': formData._token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });

                const data = await response.json();

                if (data.success) {
                    showAlert('Password updated successfully! Redirecting to appropriate dashboard...', 'success');

                    // Reset form
                    document.getElementById('passwordForm').reset();
                    // Reset validation UI
                    document.querySelectorAll('.requirement').forEach(el => {
                        el.className = 'requirement invalid';
                    });
                    strengthBar.style.width = '0';
                    confirmMessage.innerHTML = '';

                    // Check if role_id is provided in response
                    if (data.role_id) {
                        // Redirect based on role_id
                        setTimeout(() => {
                            switch (data.role_id) {
                                case 1:
                                    window.location.href = '/admin/dashboard';
                                    break;
                                case 2:
                                    window.location.href = '/chairperson/dashboard';
                                    break;
                                case 3:
                                    window.location.href = '/employee/dashboard';
                                    break;
                                default:
                                    window.location.href = '/home';
                            }
                        }, 2000);
                    } else {
                        // Fallback: redirect to home and let LoginController handle it
                        setTimeout(() => {
                            window.location.href = '/home';
                        }, 2000);
                    }
                } else {
                    // Handle validation errors from server
                    if (data.errors) {
                        const errorMessages = Object.values(data.errors).flat().join('<br>');
                        showAlert(errorMessages, 'danger');
                    } else {
                        showAlert(data.message || 'An error occurred while updating the password.', 'danger');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('Network error. Please try again.', 'danger');
            } finally {
                // Restore button state
                const submitBtn = document.querySelector('.btn-submit');
                submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>UPDATE PASSWORD';
                submitBtn.disabled = false;
            }
        });
    </script>
</body>

</html>