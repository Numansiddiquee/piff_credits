<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quote {{ ucfirst($status) }}</title>
    <style>
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
        a:hover { text-decoration: underline; }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header { background-color: #F5F8FA; padding: 20px; text-align: center; }
        .header img { max-width: 150px; height: auto; }
        .content { padding: 30px; text-align: center; }
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
        .button:hover { background-color: #007BCE; }
        .details {
            text-align: left;
            margin: 20px 0;
            padding: 15px;
            background-color: #F5F8FA;
            border-radius: 4px;
        }
        .details p { margin: 5px 0; font-size: 16px; }
        .footer {
            background-color: #F5F8FA;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6B7280;
        }
        @media only screen and (max-width: 600px) {
            .container { margin: 10px; border-radius: 4px; }
            .content { padding: 20px; }
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
                            <img src="{{ Storage::url(setting('platform_logo')) }}" alt="Your App Logo" />
                        </td>
                    </tr>
                    <!-- Content -->
                    <tr>
                        <td class="content">
                            <h1 style="font-size: 24px; font-weight: 600; color: #1A1A1A; margin: 0 0 10px;">
                                Quote {{ ucfirst($status) }}
                            </h1>
                            <p style="font-size: 16px; color: #6B7280; margin: 0 0 20px;">
                                Hello {{ $quote->freelancer->name }},
                            </p>
                            <p style="font-size: 16px; color: #1A1A1A; margin: 0 0 20px;">
                                Your quote with ID <strong>{{ $quote->quote_number }}</strong> has been <strong>{{ $status }}</strong> by the client.
                            </p>

                            <div class="details">
                                <p><strong>Client:</strong> {{ $quote->client->name }} ({{ $quote->client->email }})</p>
                                <p><strong>Subject:</strong> {{ $quote->subject }}</p>
                                <p><strong>Grand Total:</strong> ${{ number_format($quote->grand_total, 2) }}</p>
                            </div>

                            <p style="font-size: 16px; color: #1A1A1A;">
                                You can view the quote in your portal for more details.
                            </p>
                            <a href="{{ route('freelancer.quotes') }}" class="button">View Quote</a>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td class="footer">
                            <p>&copy; {{ date('Y') }} Your App Name. All rights reserved.</p>
                            <p>
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
