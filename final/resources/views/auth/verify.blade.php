<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Factor Authentication | TASKNOTIFY</title>
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
            --error-red: #dc3545;    /* For error states */
            --success-green: #28a745; /* For success states */
            --card-width: 480px;
            --glass-blur: 12px;
            --input-height: 52px;
            --border-radius: 10px;
        }

        body {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                        url('/image/psubuilding.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow-x: hidden;
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
            transform: scale(1.05);
        }

        /* Notification container */
        .notification-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            width: 100%;
            max-width: 400px;
        }

        /* Auth card */
        .auth-card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            overflow: hidden;
            width: var(--card-width);
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: 1px solid rgba(255, 255, 255, 0.25);
            position: relative;
            z-index: 1;
            transition: transform 0.3s ease;
        }

        .auth-card:hover {
            transform: translateY(-5px);
        }

        .auth-header {
            background: linear-gradient(135deg, var(--primary-blue), var(--accent-blue));
            color: white;
            padding: 25px 30px;
            text-align: center;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .auth-header::after {
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

        .auth-header h2 {
            font-weight: 700;
            margin-bottom: 5px;
            font-size: 1.8rem;
            letter-spacing: 1px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            z-index: 2;
        }

        .auth-header p {
            font-size: 1rem;
            opacity: 0.9;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            margin-bottom: 0;
            z-index: 2;
        }

        .auth-body {
            padding: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 0 0 var(--border-radius) var(--border-radius);
        }

        /* Form elements */
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
            text-align: center;
            letter-spacing: 10px;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .form-control.error {
            border-color: var(--error-red);
            background-color: rgba(220, 53, 69, 0.1);
        }

        .form-control.success {
            border-color: var(--success-green);
            background-color: rgba(40, 167, 69, 0.1);
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

        .input-group.error {
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.2);
        }

        .input-group.success {
            box-shadow: 0 2px 8px rgba(40, 167, 69, 0.2);
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
            padding-right: 15px;
        }

        /* Error message styling */
        .error-message {
            color: var(--error-red);
            font-size: 0.85rem;
            margin-top: 5px;
            font-weight: 500;
            text-shadow: none;
            display: none;
        }

        /* Button styles */
        .btn-verify {
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
            width: 100%;
        }

        .btn-verify::before {
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

        .btn-verify:hover::before {
            left: 0;
        }

        .btn-verify:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 20px rgba(0, 0, 0, 0.3);
        }

        .btn-verify span {
            position: relative;
            z-index: 1;
            color: white;
        }

        /* Code input container */
        .code-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            gap: 10px;
        }

        .code-input {
            width: 50px;
            height: 70px;
            text-align: center;
            font-size: 2rem;
            font-weight: bold;
            border: 2px solid rgba(255, 255, 255, 0.4);
            border-radius: var(--border-radius);
            background: rgba(255, 255, 255, 0.9);
            transition: all 0.3s;
            flex: 1;
        }

        .code-input.error {
            border-color: var(--error-red);
            background-color: rgba(220, 53, 69, 0.1);
            animation: shake 0.5s;
        }

        .code-input.success {
            border-color: var(--success-green);
            background-color: rgba(40, 167, 69, 0.1);
        }

        .code-input:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(26, 75, 140, 0.3);
            outline: none;
        }

        /* Resend code link */
        .resend-link {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: all 0.2s;
            font-weight: 500;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }

        .resend-link:hover {
            color: var(--primary-yellow);
            text-decoration: underline;
        }

        .resend-link.disabled {
            color: rgba(255, 255, 255, 0.5);
            cursor: not-allowed;
            text-decoration: none;
        }

        /* Footer text */
        .auth-footer {
            text-align: center;
            margin-top: 25px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        /* Animations */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-5px); }
            40%, 80% { transform: translateX(5px); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Notification styles */
        .alert-notification {
            animation: fadeIn 0.3s ease-out;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border: none;
            border-left: 4px solid;
        }

        .alert-notification .btn-close {
            padding: 0.5rem;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            :root {
                --card-width: 95%;
                --glass-blur: 8px;
                --input-height: 48px;
            }
            
            body {
                padding: 10px;
            }
            
            .auth-header {
                padding: 20px;
            }
            
            .auth-body {
                padding: 25px;
            }

            .logo-img {
                width: 60px;
                height: 60px;
            }

            .code-input {
                width: 40px;
                height: 60px;
                font-size: 1.5rem;
            }

            .notification-container {
                top: 10px;
                right: 10px;
                max-width: calc(100% - 20px);
            }
        }

        @media (max-width: 480px) {
            .code-input {
                width: 35px;
                height: 50px;
                font-size: 1.2rem;
            }
        }
    </style>
</head>

<body>
    <!-- Notification Container -->
    <div class="notification-container">
        @if(session('success'))
            <div class="alert alert-success alert-notification alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('status'))
            <div class="alert alert-success alert-notification alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-notification alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if($errors->any())
            <div class="alert alert-danger alert-notification alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <div class="auth-card">
        <div class="auth-header">
            <img src="/image/logo.png" alt="Company Logo" class="logo-img">
            <h2><i class="fas fa-shield-alt me-2"></i>TWO-FACTOR AUTHENTICATION</h2>
            <p>Enter your verification code to continue</p>
        </div>
        
        <div class="auth-body">
            <form method="POST" action="{{ route('send') }}" id="verificationForm">
                @csrf
                
                <!-- Display email address being verified -->
                <div class="mb-4 text-center text-white">
                    <p>A 6-digit verification code has been sent to:</p>
                    <h5 class="fw-bold">{{ auth()->user()->email ?? 'user@example.com' }}</h5>
                    <p class="small mt-1">The code will expire in 30 minutes</p>
                </div>
                
                <!-- 6 separate digit inputs -->
                <div class="mb-4">
                    <label class="form-label">Enter 6-digit verification code</label>
                    <div class="code-container">
                        @for ($i = 1; $i <= 6; $i++)
                            <input type="text" class="code-input @error('code') error @enderror" 
                                   name="code[]" maxlength="1" data-index="{{ $i }}" 
                                   pattern="\d" inputmode="numeric" required
                                   @if($i === 1) autofocus @endif>
                        @endfor
                    </div>
                    @error('code')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
               
                <button type="submit" class="btn btn-verify mb-3" id="verifyButton">
                    <span><i class="fas fa-check-circle me-2"></i>VERIFY & CONTINUE</span>
                </button>
                
                <div class="text-center mt-3">
                    <p class="text-white">Didn't receive a code? 
                        <a href="{{ route('resendcode') }}" class="resend-link" id="resendLink">
                            Resend Code
                        </a>
                        <span id="countdown" class="d-none">(0:30)</span>
                    </p>
                </div>
            </form>
            
            <div class="auth-footer">
                <p class="mb-0">Having trouble? <a href="" class="text-white">Contact support</a></p>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-focus and move between code inputs
            const codeInputs = document.querySelectorAll('.code-input');
            const form = document.getElementById('verificationForm');
            const verifyButton = document.getElementById('verifyButton');
            
            // Focus first input on load
            if (codeInputs.length > 0) {
                codeInputs[0].focus();
                
                codeInputs.forEach((input, index) => {
                    input.addEventListener('input', function() {
                        // Remove any non-digit characters
                        this.value = this.value.replace(/\D/g, '');
                        
                        // Validate input
                        if (this.value.length === 1) {
                            this.classList.remove('error');
                            
                            // Move to next input if a digit was entered
                            if (index < codeInputs.length - 1) {
                                codeInputs[index + 1].focus();
                            } else {
                                // If last input, attempt submit
                                verifyButton.click();
                            }
                        }
                    });
                    
                    // Handle backspace to move to previous input
                    input.addEventListener('keydown', function(e) {
                        if (e.key === 'Backspace' && this.value.length === 0 && index > 0) {
                            codeInputs[index - 1].focus();
                        }
                    });
                    
                    // Handle paste event for pasting the full code
                    input.addEventListener('paste', function(e) {
                        e.preventDefault();
                        const pasteData = e.clipboardData.getData('text').replace(/\D/g, '');
                        
                        if (pasteData.length === 6) {
                            for (let i = 0; i < 6; i++) {
                                if (codeInputs[i]) {
                                    codeInputs[i].value = pasteData[i];
                                }
                            }
                            verifyButton.click();
                        }
                    });
                });
            }
            
            // Form submission handler
            form.addEventListener('submit', function(e) {
                let isValid = true;
                
                // Validate all code inputs are filled
                codeInputs.forEach(input => {
                    if (!input.value) {
                        input.classList.add('error');
                        isValid = false;
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    document.querySelector('.error-message').style.display = 'block';
                    document.querySelector('.error-message').textContent = 'Please enter the full 6-digit code';
                    
                    // Focus first empty input
                    for (let input of codeInputs) {
                        if (!input.value) {
                            input.focus();
                            break;
                        }
                    }
                } else {
                    // Show loading state
                    verifyButton.disabled = true;
                    verifyButton.innerHTML = '<span><i class="fas fa-spinner fa-spin me-2"></i>VERIFYING...</span>';
                }
            });
            
            // Resend code countdown timer
            const resendLink = document.getElementById('resendLink');
            const countdown = document.getElementById('countdown');
            
            if (resendLink && countdown) {
                let timeLeft = 30;
                
                // Start with resend disabled
                resendLink.classList.add('disabled');
                countdown.classList.remove('d-none');
                
                const updateCountdown = () => {
                    const minutes = Math.floor(timeLeft / 60);
                    const seconds = timeLeft % 60;
                    countdown.textContent = `(${minutes}:${seconds.toString().padStart(2, '0')})`;
                };
                
                updateCountdown();
                
                const timer = setInterval(() => {
                    timeLeft--;
                    updateCountdown();
                    
                    if (timeLeft <= 0) {
                        clearInterval(timer);
                        resendLink.classList.remove('disabled');
                        countdown.classList.add('d-none');
                    }
                }, 1000);
                
                resendLink.addEventListener('click', function(e) {
                    if (this.classList.contains('disabled')) {
                        e.preventDefault();
                    } else {
                        // Show loading state
                        const originalText = this.innerHTML;
                        this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Sending...';
                        
                        // Reset countdown
                        timeLeft = 30;
                        this.classList.add('disabled');
                        countdown.classList.remove('d-none');
                        updateCountdown();
                        
                        const timer = setInterval(() => {
                            timeLeft--;
                            updateCountdown();
                            
                            if (timeLeft <= 0) {
                                clearInterval(timer);
                                resendLink.classList.remove('disabled');
                                countdown.classList.add('d-none');
                            }
                        }, 1000);
                        
                        // Restore original text after a delay (in case the page doesn't reload)
                        setTimeout(() => {
                            this.innerHTML = originalText;
                        }, 3000);
                    }
                });
            }
            
            // Auto-dismiss notifications after 5 seconds
            const alerts = document.querySelectorAll('.alert-notification');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
    
</body>
</html>