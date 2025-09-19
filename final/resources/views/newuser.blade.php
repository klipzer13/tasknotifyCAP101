<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Team</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }

        .email-header {
            padding: 20px;
            text-align: center;
            background-color: #f8f9fa;
            border-bottom: 1px solid #eaeaea;
        }

        .email-body {
            padding: 30px;
        }

        .email-footer {
            padding: 20px;
            text-align: center;
            background-color: #f8f9fa;
            border-top: 1px solid #eaeaea;
            font-size: 12px;
            color: #666666;
        }

        .logo {
            max-height: 60px;
        }

        .welcome-text {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .credentials-box {
            background-color: #f8f9fa;
            border-left: 4px solid #4e73df;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .credentials-label {
            font-weight: 600;
            color: #4e73df;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4e73df;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
            margin: 15px 0;
        }

        .security-note {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 4px;
            padding: 15px;
            margin: 20px 0;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            @if(file_exists(public_path('image/logo.png')))
                <img src="{{ $message->embed(public_path('image/logo.png')) }}" alt="{{ config('app.name') }} Logo"
                    style="max-height: 80px;">
            @else
                <h2 style="color: #333; margin: 0;">{{ config('app.name') }}</h2>
            @endif
        </div>

        <div class="email-body">
            <h2>Welcome to the Team!</h2>

            <p class="welcome-text">Dear {{ $user->name ?? 'Team Member' }},</p>

            <p class="welcome-text">We are excited to welcome you to Tasknotify! Your account has been
                successfully created, and you now have access to our platform.</p>

            <p>Below are your login credentials:</p>

            <div class="credentials-box">
                <p><span class="credentials-label">Username/Email:</span> {{ $user->email ?? 'Your registered email' }}
                </p>
                <p><span class="credentials-label">Temporary Password:</span> {{ $passwordPlain }}</p>
            </div>

            <div class="security-note">
                <strong>Security Recommendation:</strong> For your account's security, we strongly recommend that you
                change your password after your first login.
            </div>

            <p>To get started, please log in to the platform:</p>

            <div style="text-align: center;">
                <a href="{{ url('/login') }}" class="button">Login to Your Account</a>
            </div>

            <p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>

            <p>Best regards,<br>The Tasknotify Team</p>
        </div>

        <div class="email-footer">
            <p>© {{ date('Y') }} Tasknotify. All rights reserved.</p>
            <p>If you did not expect this email, please contact our support team immediately.</p>
        </div>
    </div>
</body>

</html>