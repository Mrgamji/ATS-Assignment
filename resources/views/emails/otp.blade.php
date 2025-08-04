<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your OTP Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        .container {
            background: #fff;
            max-width: 480px;
            margin: 40px auto;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            padding: 32px 24px;
        }
        .otp-box {
            font-size: 2.2em;
            letter-spacing: 8px;
            font-weight: bold;
            color: #2d3748;
            background: #f1f5f9;
            padding: 18px 0;
            text-align: center;
            border-radius: 6px;
            margin: 24px 0;
        }
        .footer {
            color: #888;
            font-size: 0.95em;
            margin-top: 32px;
            text-align: center;
        }
        .brand {
            font-size: 1.3em;
            color: #2563eb;
            font-weight: bold;
            margin-bottom: 12px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="brand">
            {{ config('app.name', 'HRMS') }}
        </div>
        <h2 style="color:#222;">Your One-Time Password (OTP)</h2>
        <p>
            Thank you for signing up! Please use the OTP below to verify your email address.
        </p>
        <div class="otp-box">
            {{ $otp }}
        </div>
        <p>
            This OTP is valid for 10 minutes. If you did not request this, please ignore this email.
        </p>
        <div class="footer">
            &mdash; The {{ config('app.name', 'HRMS') }} Team
        </div>
    </div>
</body>
</html>
