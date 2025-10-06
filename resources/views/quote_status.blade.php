<!-- resources/views/quotes/status.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quote Status</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 40px; }
        .card { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); max-width: 600px; margin: 0 auto; text-align: center; }
        h1 { font-size: 24px; margin-bottom: 10px; }
        p { font-size: 16px; color: #666; }
        .status { font-size: 18px; font-weight: bold; margin-top: 20px; color: #333; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Quote Status</h1>
        <p>Quote #{{ $quote->quote_number }}</p>
        <p class="status">Current Status: <strong>{{ ucfirst($quote->status) }}</strong></p>
        <p>Thank you for your response!</p>
    </div>
</body>
</html>
