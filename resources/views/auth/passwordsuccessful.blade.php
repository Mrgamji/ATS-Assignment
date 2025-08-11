<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Password Reset Successful</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .container {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 8px 32px rgba(37,99,235,0.13), 0 1.5px 6px rgba(0,0,0,0.04);
            padding: 44px 32px 36px 32px;
            max-width: 400px;
            width: 100%;
            text-align: center;
            animation: fadeInUp 0.7s cubic-bezier(.23,1.01,.32,1);
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px);}
            to { opacity: 1; transform: translateY(0);}
        }
        .success-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 18px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #22d3ee 60%, #2563eb 100%);
            border-radius: 50%;
            box-shadow: 0 2px 12px rgba(37,99,235,0.13);
            animation: popIn 0.6s cubic-bezier(.23,1.01,.32,1);
        }
        @keyframes popIn {
            0% { transform: scale(0.5); opacity: 0;}
            80% { transform: scale(1.1);}
            100% { transform: scale(1); opacity: 1;}
        }
        .success-icon svg {
            width: 38px;
            height: 38px;
            color: #fff;
        }
        h2 {
            color: #1e293b;
            margin-bottom: 10px;
            font-weight: 700;
            font-size: 1.5em;
            letter-spacing: 0.01em;
        }
        .message {
            color: #334155;
            font-size: 1.08em;
            margin-bottom: 28px;
            line-height: 1.6;
        }
        .login-btn {
            display: inline-block;
            background: linear-gradient(90deg, #2563eb 60%, #22d3ee 100%);
            color: #fff;
            font-weight: 600;
            font-size: 1.08em;
            padding: 13px 0;
            width: 100%;
            border: none;
            border-radius: 7px;
            box-shadow: 0 2px 8px rgba(37,99,235,0.09);
            cursor: pointer;
            transition: background 0.22s, transform 0.13s;
            text-decoration: none;
            margin-top: 8px;
            letter-spacing: 0.01em;
        }
        .login-btn:hover, .login-btn:focus {
            background: linear-gradient(90deg, #1d4ed8 60%, #0ea5e9 100%);
            transform: translateY(-2px) scale(1.03);
        }
        @media (max-width: 500px) {
            .container {
                padding: 32px 10px 24px 10px;
                max-width: 98vw;
            }
            .success-icon {
                width: 56px;
                height: 56px;
            }
            .success-icon svg {
                width: 28px;
                height: 28px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-icon">
            <svg viewBox="0 0 52 52" fill="none">
                <circle cx="26" cy="26" r="25" stroke="white" stroke-width="2" opacity="0.18"/>
                <path d="M16 27.5L23.5 35L36 20" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <h2>Password Reset Successful</h2>
        <div class="message">
            Your password has been updated.<br>
            You can now log in with your new password.
        </div>
        <a href="{{ route('login') }}" class="login-btn" id="loginBtn">
            Click here to Login
        </a>
    </div>
    <script>
        // Subtle button animation on page load
        window.addEventListener('DOMContentLoaded', function() {
            var btn = document.getElementById('loginBtn');
            btn.style.opacity = 0;
            btn.style.transform = 'translateY(20px)';
            setTimeout(function() {
                btn.style.transition = 'opacity 0.5s, transform 0.5s';
                btn.style.opacity = 1;
                btn.style.transform = 'translateY(0)';
            }, 500);
        });
    </script>
</body>
</html>
