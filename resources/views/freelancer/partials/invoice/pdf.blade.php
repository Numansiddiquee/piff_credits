<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            margin-right: 3rem;
            padding: 0;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: auto;
            padding: 40px;
        }

        .header-table, .bill-to-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .company-info {
            text-align: left;
            font-size: 12px;
            vertical-align: top;
        }

        .invoice-title-block {
            text-align: right;
            font-size: 12px;
            vertical-align: top;
        }

        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            margin: 0;
        }

        .invoice-meta {
            font-size: 12px;
            color: #555;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 5px;
            margin-bottom: 5px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            font-size: 12px;
        }

        table th, table td {
            padding: 10px;

        }

        .summary-table td, .item-table td {
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #444;
            color: #fff;
            font-weight: bold;
            text-align: left;
        }

        table td.text-right {
            text-align: right !important;
        }

        .summary-table {
            width: 35%;
            margin-left: auto;
            border-collapse: collapse;
            font-size: 12px;
        }

        .summary-table td {
            padding: 10px;
            text-align: right;
        }

        .summary-table td:first-child {
            text-align: left;
        }

        .item-table th:last-child, .item-table td:last-child {
            text-align: right;
        }

        .summary-table tr:last-child {
            font-weight: bold;
        }

        .notes {
            margin-top: 20px;
            font-size: 12px;
            color: #555;
        }

        .notes h4 {
            font-size: 14px;
            margin-bottom: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Header Section -->
    <table class="header-table"> 
        <tr>
            <td class="company-info">
                <b>{{ $invoice->freelancer->name }}</b>
                <div class="invoice-meta">
                    <b>{{ $invoice->freelancer->email }}</b><br>
                    <b>{{ $invoice->freelancer->phone ?? '' }}</b><br>
                </div>
            </td>
            <td class="invoice-title-block">
                <h1 class="invoice-title">INVOICE</h1>
                <div class="invoice-meta">
                    <b># {{ $invoice->invoice_number ?? 'N/A' }}</b><br>
                    <b>Balance Due: <strong>${{ number_format($invoice->total, 2) }}</strong></b>
                </div>
            </td>
        </tr>
    </table>

    <!-- Bill To Section -->
    <table class="bill-to-table">
        <tr>
            <td>
                <h4 class="section-title">Bill To</h4>
                <b>{{ $invoice->client->name ?? 'N/A' }}</b>
            </td>
            <td class="invoice-meta invoice-title-block">
                <b>Invoice Date:</b> {{ $invoice->created_at->format('d M, Y') ?? 'N/A' }}<br>
                <b>Due Date:</b> {{ $invoice->due_date->format('d M, Y') ?? 'N/A' }}
            </td>
        </tr>
    </table>

    <!-- Item Table -->
    <div>
        <table class="item-table">
            <thead>
            <tr>
                <th>#</th>
                <th>Item & Description</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Rate</th>
                <th class="text-right">Amount</th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoice->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $item->item_name }}</strong><br>
                        <span style="color: #555; font-size: 11px;">{{ $item->description }}</span>
                    </td>
                    <td>{{ $item->quantity }} {{ $item->item->unit ?? '' }}</td>
                    <td>$ {{ number_format($item->price, 2) }}</td>
                    <td>$ {{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- Summary Table -->
    <div>
        <table class="summary-table">
            <tr>
                <td>Sub Total</td>
                <td>$ {{ number_format($invoice->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td>Discount</td>
                <td>$ {{$invoice->discounted_amount}}</td>
            </tr>
            <tr>
                <td>Total</td>
                <td>$ {{ number_format($invoice->total, 2) }}</td>
            </tr>
            <tr>
                <td>Balance Due</td>
                <td>$ {{ number_format($invoice->total, 2) }}</td>
            </tr>
        </table>
    </div>

    <!-- Notes Section -->
    <div class="notes">
        <h4>Notes</h4>
        <p>{{ $invoice->notes }}</p>
    </div>
</div>
</body>
</html>
