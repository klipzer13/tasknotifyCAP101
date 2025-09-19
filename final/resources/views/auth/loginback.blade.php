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
            --primary-blue: #1a4b8c;  /* Deep blue */
            --accent-blue: #3a7bd5;   /* Medium blue */
            --light-blue: #e6f0ff;    /* Very light blue */
            --primary-yellow: #ffc107; /* Golden yellow */
            --dark-yellow: #ffab00;   /* Darker yellow */
            --card-width: 480px;
            --glass-blur: 12px;
            --input-height: 52px;
            --border-radius: 10px;
        }

        body {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                        url('/image/psubuilding.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        /* Background blur overlay */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: inherit;
            filter: blur(8px) brightness(0.7);
            z-index: -1;
            transform: scale(1.05); /* Prevents blur edge artifacts */
        }

        .login-card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            overflow: hidden;
            width: var(--card-width);
            /* Enhanced glass effect */
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: 1px solid rgba(255, 255, 255, 0.25);
            position: relative;
            z-index: 1;
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary-blue), var(--accent-blue));
            color: white;
            padding: 25px 30px;
            text-align: center;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            /* Glass effect border */
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .login-header::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 0;
            right: 0;
            height: 40px;
            background: var(--primary-yellow);
            transform: rotate(-2deg);
            z-index: 1;
        }

        .logo-img {
            width: 80px;
            height: 80px;
            margin-bottom: 15px;
            object-fit: contain;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
            z-index: 2;
        }

        .login-header h2 {
            font-weight: 700;
            margin-bottom: 5px;
            font-size: 1.8rem;
            letter-spacing: 1px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            z-index: 2;
        }

        .login-header p {
            font-size: 1rem;
            opacity: 0.9;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            margin-bottom: 0;
            z-index: 2;
        }

        .login-body {
            padding: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 0 0 var(--border-radius) var(--border-radius);
        }

        /* Enhanced Form Controls */
        .form-label {
            font-weight: 600;
            color: white;
            margin-bottom: 8px;
            display: block;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        .form-control {
            border-radius: var(--border-radius);
            padding: 14px 20px;
            border: 2px solid rgba(255, 255, 255, 0.4);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            font-size: 1rem;
            height: var(--input-height);
            background-color: rgba(255, 255, 255, 0.9);
            color: #333;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(26, 75, 140, 0.3);
            border-color: var(--primary-blue);
            background-color: white;
            outline: none;
        }

        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: var(--border-radius);
            transition: all 0.3s ease;
        }

        .input-group:focus-within {
            box-shadow: 0 4px 12px rgba(26, 75, 140, 0.2);
            transform: translateY(-2px);
        }

        .input-group-text {
            background-color: var(--primary-blue);
            border: none;
            padding: 0 20px;
            font-size: 1.1rem;
            color: white;
            border-radius: var(--border-radius) 0 0 var(--border-radius) !important;
            width: 55px;
            display: flex;
            justify-content: center;
            transition: all 0.3s;
        }

        .input-group:focus-within .input-group-text {
            background-color: var(--accent-blue);
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 var(--border-radius) var(--border-radius) 0 !important;
            padding-left: 15px;
            padding-right: 50px; /* Make space for the toggle button */
        }

        /* Password toggle button - now inside the input */
        .password-toggle-container {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: var(--primary-blue);
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
            transition: all 0.2s;
            z-index: 5;
        }

        .password-toggle:hover {
            color: var(--accent-blue);
            background: rgba(0, 0, 0, 0.05);
        }

        .password-toggle:active {
            background: rgba(0, 0, 0, 0.1);
        }

        /* Login Button */
        .btn-login {
            background: linear-gradient(to right, var(--primary-blue), var(--accent-blue));
            border: none;
            border-radius: var(--border-radius);
            padding: 14px;
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: all 0.3s;
            height: var(--input-height);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, var(--primary-yellow), var(--dark-yellow));
            transition: all 0.4s;
            z-index: 0;
        }

        .btn-login:hover::before {
            left: 0;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 20px rgba(0, 0, 0, 0.3);
        }

        .btn-login span {
            position: relative;
            z-index: 1;
            color: white;
        }

        /* Remember me & Forgot password */
        .form-check-input {
            width: 1.2em;
            height: 1.2em;
            margin-top: 0.1em;
            border: 2px solid rgba(255, 255, 255, 0.5);
        }

        .form-check-input:checked {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
        }

        .form-check-label {
            font-weight: 500;
            color: white;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        .forgot-link {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: all 0.2s;
            font-weight: 500;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        .forgot-link:hover {
            color: var(--primary-yellow);
            text-decoration: underline;
        }

        .login-footer {
            text-align: center;
            margin-top: 25px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        /* Floating label animation */
        .form-floating>label {
            transition: all 0.2s;
            color: rgba(0, 0, 0, 0.6);
        }

        .form-floating>.form-control:focus~label,
        .form-floating>.form-control:not(:placeholder-shown)~label {
            transform: scale(0.85) translateY(-0.8rem) translateX(0.15rem);
            color: var(--primary-blue);
            background: white;
            padding: 0 6px;
            border-radius: 4px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            :root {
                --card-width: 90%;
                --glass-blur: 8px;
                --input-height: 48px;
            }
            
            .login-header {
                padding: 20px;
            }
            
            .login-body {
                padding: 25px;
            }

            .logo-img {
                width: 60px;
                height: 60px;
            }
        }

        /* Highlight effect for focused inputs */
        .input-highlight {
            position: relative;
        }

        .input-highlight:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 0;
            height: 2px;
            background-color: var(--primary-yellow);
            transition: width 0.4s ease;
        }

        .input-highlight:focus-within:after {
            width: 100%;
        }
        
        /* 2FA Verification Styles */
        .verification-code-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        
        .verification-code-input {
            width: 50px;
            height: 60px;
            text-align: center;
            font-size: 1.5rem;
            border-radius: var(--border-radius);
            border: 2px solid rgba(255, 255, 255, 0.4);
            background-color: rgba(255, 255, 255, 0.9);
            color: #333;
        }
        
        .verification-code-input:focus {
            border-color: var(--primary-blue);
            outline: none;
            box-shadow: 0 0 0 3px rgba(26, 75, 140, 0.3);
        }
        
        .resend-code {
            color: var(--primary-yellow);
            cursor: pointer;
            text-decoration: underline;
            font-weight: 500;
            margin-top: 10px;
            display: inline-block;
        }
        
        .resend-code:hover {
            color: var(--dark-yellow);
        }
        
        .timer {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            margin-top: 10px;
        }
        
        /* Hidden elements */
        .hidden {
            display: none;
        }
        
        /* Error message */
        .error-message {
            color: #ff6b6b;
            background-color: rgba(255, 255, 255, 0.2);
            padding: 10px 15px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
            display: none;
        }
        
        /* Success message */
        .success-message {
            color: #51cf66;
            background-color: rgba(255, 255, 255, 0.2);
            padding: 10px 15px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
            display: none;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="login-header">
            <img src="/image/logo.png" alt="Company Logo" class="logo-img">
            <h2><i class="fas fa-bell me-2"></i>TASKNOTIFY</h2>
            <p id="login-message">Please sign in to continue</p>
        </div>
        
        <div class="login-body">
            <!-- Error and success messages -->
            <div class="error-message" id="error-message"></div>
            <div class="success-message" id="success-message"></div>
            
            <!-- Step 1: Email and Password Form -->
            <form id="login-form" method="POST" action="{{ route('login') }}" class="login-step" data-step="1">
                @csrf
                <div class="mb-4 input-highlight">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="admin@example.com" required autofocus>
                    </div>
                </div>
                <div class="mb-4 input-highlight">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group password-toggle-container">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="••••••••" required>
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                    @endif
                </div>
                <button type="submit" class="btn btn-login btn-block w-100 mb-3">
                    <span><i class="fas fa-sign-in-alt me-2"></i>LOGIN</span>
                </button>
            </form>
            
            <!-- Step 2: Verification Code Form -->
            <form id="verification-form" class="login-step hidden" data-step="2">
                @csrf
                <div class="mb-4 text-center">
                    <p class="text-white">We've sent a verification code to your email.</p>
                    <p class="text-white">Please enter the 6-digit code below:</p>
                </div>
                
                <div class="mb-4">
                    <div class="verification-code-container">
                        <input type="text" class="verification-code-input" maxlength="1" data-index="1" autofocus>
                        <input type="text" class="verification-code-input" maxlength="1" data-index="2">
                        <input type="text" class="verification-code-input" maxlength="1" data-index="3">
                        <input type="text" class="verification-code-input" maxlength="1" data-index="4">
                        <input type="text" class="verification-code-input" maxlength="1" data-index="5">
                        <input type="text" class="verification-code-input" maxlength="1" data-index="6">
                    </div>
                    <input type="hidden" id="verification-code" name="verification_code">
                    <input type="hidden" id="verification-email" name="email">
                    <input type="hidden" id="verification-password" name="password">
                    <input type="hidden" id="verification-remember" name="remember">
                    
                    <div class="text-center">
                        <span class="timer" id="timer">Resend code in 2:00</span>
                        <span class="resend-code hidden" id="resend-code">Resend code</span>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-login btn-block w-100 mb-3">
                    <span><i class="fas fa-check-circle me-2"></i>VERIFY</span>
                </button>
                
                <div class="text-center">
                    <a href="#" class="forgot-link" id="back-to-login"><i class="fas fa-arrow-left me-2"></i>Back to login</a>
                </div>
            </form>
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
        
        // Add animation to input groups on focus
        document.querySelectorAll('.input-group').forEach(group => {
            const input = group.querySelector('.form-control');
            
            input.addEventListener('focus', () => {
                group.style.transform = 'translateY(-2px)';
            });
            
            input.addEventListener('blur', () => {
                group.style.transform = '';
            });
        });
        
        // 2FA Verification Code Handling
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('login-form');
            const verificationForm = document.getElementById('verification-form');
            const backToLogin = document.getElementById('back-to-login');
            const resendCode = document.getElementById('resend-code');
            const timer = document.getElementById('timer');
            const errorMessage = document.getElementById('error-message');
            const successMessage = document.getElementById('success-message');
            const loginMessage = document.getElementById('login-message');
            
            // Verification code inputs
            const codeInputs = document.querySelectorAll('.verification-code-input');
            const fullCodeInput = document.getElementById('verification-code');
            
            // Handle login form submission
            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Simulate sending verification code (in a real app, this would be an AJAX call)
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;
                const remember = document.getElementById('remember').checked;
                
                // Store credentials for verification step
                document.getElementById('verification-email').value = email;
                document.getElementById('verification-password').value = password;
                document.getElementById('verification-remember').value = remember ? '1' : '0';
                
                // Show verification step
                showVerificationStep();
                
                // In a real app, you would make an AJAX call to your backend to send the code
                // For this example, we'll simulate it with a random code
                const verificationCode = Math.floor(100000 + Math.random() * 900000).toString();
                console.log('Simulated verification code sent to email:', verificationCode);
                
                // Show success message
                showMessage('success', `Verification code sent to ${email}`);
                
                // Start the resend timer
                startResendTimer();
            });
            
            // Handle verification form submission
            verificationForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Get the full code from individual inputs
                let fullCode = '';
                codeInputs.forEach(input => {
                    fullCode += input.value;
                });
                
                // In a real app, you would verify this code with your backend
                // For this example, we'll just log it
                console.log('Verification code submitted:', fullCode);
                
                // Show error if code is not 6 digits
                if (fullCode.length !== 6) {
                    showMessage('error', 'Please enter a 6-digit verification code');
                    return;
                }
                
                // In a real app, you would submit the form to your backend
                // For this example, we'll simulate a successful verification
                showMessage('success', 'Verification successful! Logging in...');
                
                // After a delay, submit the original login form
                setTimeout(() => {
                    loginForm.submit();
                }, 1500);
            });
            
            // Back to login button
            backToLogin.addEventListener('click', function(e) {
                e.preventDefault();
                showLoginStep();
            });
            
            // Resend code button
            resendCode.addEventListener('click', function() {
                // In a real app, you would make an AJAX call to resend the code
                console.log('Resending verification code...');
                
                // Generate a new random code
                const verificationCode = Math.floor(100000 + Math.random() * 900000).toString();
                console.log('New verification code:', verificationCode);
                
                showMessage('success', 'New verification code sent!');
                startResendTimer();
            });
            
            // Handle verification code input
            codeInputs.forEach((input, index) => {
                input.addEventListener('input', function() {
                    if (this.value.length === 1) {
                        if (index < codeInputs.length - 1) {
                            codeInputs[index + 1].focus();
                        } else {
                            // Last input - focus the verify button
                            document.querySelector('#verification-form button[type="submit"]').focus();
                        }
                    }
                    
                    // Update the hidden full code input
                    updateFullCode();
                });
                
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && this.value.length === 0) {
                        if (index > 0) {
                            codeInputs[index - 1].focus();
                        }
                    }
                });
            });
            
            function updateFullCode() {
                let fullCode = '';
                codeInputs.forEach(input => {
                    fullCode += input.value;
                });
                fullCodeInput.value = fullCode;
            }
            
            function showVerificationStep() {
                document.querySelectorAll('.login-step').forEach(step => {
                    step.classList.add('hidden');
                });
                verificationForm.classList.remove('hidden');
                loginMessage.textContent = 'Enter your verification code';
                
                // Focus first code input
                codeInputs[0].focus();
            }
            
            function showLoginStep() {
                document.querySelectorAll('.login-step').forEach(step => {
                    step.classList.add('hidden');
                });
                loginForm.classList.remove('hidden');
                loginMessage.textContent = 'Please sign in to continue';
                
                // Clear any messages
                hideMessages();
            }
            
            function showMessage(type, text) {
                hideMessages();
                
                if (type === 'error') {
                    errorMessage.textContent = text;
                    errorMessage.style.display = 'block';
                } else if (type === 'success') {
                    successMessage.textContent = text;
                    successMessage.style.display = 'block';
                }
                
                // Auto-hide after 5 seconds
                setTimeout(hideMessages, 5000);
            }
            
            function hideMessages() {
                errorMessage.style.display = 'none';
                successMessage.style.display = 'none';
            }
            
            function startResendTimer() {
                let timeLeft = 120; // 2 minutes in seconds
                
                resendCode.classList.add('hidden');
                timer.classList.remove('hidden');
                
                const timerInterval = setInterval(() => {
                    const minutes = Math.floor(timeLeft / 60);
                    const seconds = timeLeft % 60;
                    
                    timer.textContent = `Resend code in ${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                    
                    if (timeLeft <= 0) {
                        clearInterval(timerInterval);
                        timer.classList.add('hidden');
                        resendCode.classList.remove('hidden');
                    }
                    
                    timeLeft--;
                }, 1000);
            }
        });
    </script>
</body>
</html>