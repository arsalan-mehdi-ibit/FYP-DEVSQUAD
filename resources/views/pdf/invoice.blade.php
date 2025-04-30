<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        .header { text-align: center; margin-bottom: 30px; }
        .section { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #000; text-align: left; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Invoice #{{ $payment->id }}</h2>
        <p>Date: {{ $payment->created_at->format('d M Y') }}</p>
    </div>

    <div class="section">
        <strong>Project:</strong> {{ $payment->timesheet->project->name ?? 'N/A' }}<br>
        <strong>Timesheet Week:</strong> {{ $payment->timesheet->week_start_date ?? 'N/A' }}<br>
        <strong>Contractor:</strong> {{ $payment->contractor->firstname ?? 'N/A' }}<br>
        <strong>Client:</strong> {{ $payment->client->firstname ?? 'N/A' }}
    </div>

    <div class="section">
        <table>
            <tr>
                <th>Description</th>
                <th>Amount ($)</th>
            </tr>
            <tr>
                <td>Contractor Paid</td>
                <td>{{ number_format($payment->contractor_paid, 2) }}</td>
            </tr>
            <tr>
                <td>Admin Received</td>
                <td>{{ number_format($payment->admin_received, 2) }}</td>
            </tr>
        </table>
    </div>

</body>
</html>
