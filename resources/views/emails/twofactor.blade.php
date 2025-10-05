<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your 2FA Code</title>
    <style>
        /* Base styles for email clients */
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            background-color: #f4f4f4;
            color: #1A1A1A;
            line-height: 1.6;
        }
        a {
            color: #009EF7;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #F5F8FA;
            padding: 20px;
            text-align: center;
        }
        .header img {
            max-width: 150px;
            height: auto;
        }
        .content {
            padding: 30px;
            text-align: center;
        }
        .code {
            font-size: 32px;
            font-weight: bold;
            color: #009EF7;
            letter-spacing: 4px;
            margin: 20px 0;
            padding: 15px;
            background-color: #F5F8FA;
            border-radius: 4px;
            display: inline-block;
        }
        .footer {
            background-color: #F5F8FA;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6B7280;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #009EF7;
            color: #ffffff;
            font-weight: 600;
            border-radius: 4px;
            text-decoration: none;
            margin: 20px 0;
        }
        .button:hover {
            background-color: #007BCE;
        }
        @media only screen and (max-width: 600px) {
            .container {
                margin: 10px;
                border-radius: 4px;
            }
            .content {
                padding: 20px;
            }
            .code {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f4f4f4">
        <tr>
            <td align="center">
                <table class="container" width="100%" border="0" cellspacing="0" cellpadding="0">
                    <!-- Header -->
                    <tr>
                        <td class="header">
                            <img src="{{ asset('metronic/assets/media/logos/default-small.svg') }}" alt="Your App Logo" style="max-width: 150px; height: auto;" />
                        </td>
                    </tr>
                    <!-- Content -->
                    <tr>
                        <td class="content">
                            <h1 style="font-size: 24px; font-weight: 600; color: #1A1A1A; margin: 0 0 10px;">Two-Factor Authentication Code</h1>
                            <p style="font-size: 16px; color: #6B7280; margin: 0 0 20px;">Hello,</p>
                            <p style="font-size: 16px; color: #1A1A1A; margin: 0 0 20px;">Please use the following 6-digit code to complete your two-factor authentication. This code will expire in 10 minutes.</p>
                            <div class="code">{{ $code }}</div>
                            <p style="font-size: 14px; color: #6B7280; margin: 20px 0;">If you didn’t request this code, please ignore this email or <a href="#" style="color: #009EF7;">contact support</a>.</p>
                            <a href="{{ route('verify.2fa') }}" class="button">Verify Now</a>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td class="footer">
                            <p style="margin: 0;">&copy; {{ date('Y') }} Your App Name. All rights reserved.</p>
                            <p style="margin: 5px 0 0;">
                                <a href="#" style="color: #009EF7;">Privacy Policy</a> | 
                                <a href="#" style="color: #009EF7;">Terms of Service</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>