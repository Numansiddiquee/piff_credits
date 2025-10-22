<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Quote Sent</title>
    <style>
        body {
            background-color: #fbfbfb;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .container {
            width: 100%;
            padding: 20px;
        }
        .email-wrapper {
            width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        .header {
            text-align: center;
            padding: 20px;
            background: #f5f5f5;
            border-bottom: 1px solid #e0e0e0;
        }
        .header h3 {
            color: #333;
            font-size: 24px;
            margin: 0;
        }
        .content {
            padding: 20px;
            color: #555;
            font-size: 14px;
        }
        .quote-details {
            background-color: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .btn {
            text-decoration: none;
            color: #fff;
            padding: 10px 20px;
            border-radius: 4px;
            margin: 5px;
            display: inline-block;
        }
        .btn-accept {
            background-color: #4dcf59;
            border: 1px solid #49bd54;
            color: white;
        }
        .btn-reject {
            background-color: #f44336;
            border: 1px solid #e53935;
            color: white;
        }
        .footer {
            padding: 20px;
            font-size: 13px;
            color: #777;
            text-align: left;
        }
        .footer i {
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td align="center">
                    <div class="email-wrapper">
                        <div class="header">
                            <h3>New Quote Sent to You</h3>
                        </div>
                        <div class="content">
                            <p>Dear {{ $quote->client->fname }},</p>
                            <p>
                                A new quote has been sent to you by <strong>{{ $quote->freelancer->name }}</strong>.
                                Please review the details below and take action at your earliest convenience.
                            </p>

                            <h2 style="text-align:center; color:#333;">Quote #{{ $quote->quote_number }}</h2>
                            <p style="text-align:center;">Issued on: {{ $quote->created_at->format('d M, Y') ?? 'N/A' }}</p>

                            <div class="quote-details">
                                <p><strong>Expiry Date:</strong> {{ date('d M, Y', strtotime($quote->expiry_date)) ?? 'N/A' }}</p>
                                <p><strong>Quote Amount:</strong> ${{ number_format($quote->grand_total, 2) }}</p>
                                <p><strong>Status:</strong> {{ ucfirst($quote->status) }}</p>
                            </div>

                            <p>To review and respond to this quote, please click one of the options below:</p>
                            <p style="text-align:center;">
                                @php
                                    $hash = \Crypt::encryptString($quote->id);
                                @endphp
                                <a href="{{ route('quotes.accept', $hash) }}" class="btn btn-accept">ACCEPT QUOTE</a>
                                <a href="{{ route('quotes.reject', $hash) }}" class="btn btn-reject">REJECT QUOTE</a>
                            </p>

                            <p>
                                If you have any questions or need clarification, feel free to reach out anytime.
                            </p>
                            <p>Thank you for your time and consideration.</p>
                        </div>
                        <div class="footer">
                            <p>Best regards,</p>
                            <p>{{ $quote->freelancer->name }}<br>{{ $quote->freelancer->company_name ?? config('app.name') }}</p>
                            <p><i>This email was sent automatically — please do not reply directly.</i></p>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
