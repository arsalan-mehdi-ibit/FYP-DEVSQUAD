<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submitted Timesheet Reminder</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 30px;
        }
        .container {
            max-width: 600px;
            background: #ffffff;
            padding: 40px;
            border-radius: 8px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.06);
        }
        .header {
            font-size: 24px;
            font-weight: bold;
            color: #273c75;
            margin-bottom: 20px;
        }
        .content {
            font-size: 16px;
            color: #333;
            line-height: 1.6;
        }
        .button {
            display: inline-block;
            margin-top: 20px;
            background-color: #273c75;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 5px;
            font-weight: bold;
        }
        .footer {
            font-size: 13px;
            color: #888;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Timesheet Submitted Successfully</div>

        <div class="content">
            <p>Dear {{ $timesheet->client->name ?? 'Client' }},</p>

            <p>This is a reminder that your timesheet has been <strong>successfully submitted</strong>.</p>

            <ul>
                <li><strong>Timesheet ID:</strong> {{ $timesheet->id }}</li>
                <li><strong>Project Name:</strong> {{ $timesheet->project->name ?? 'N/A' }}</li>
                <li><strong>Submitted On:</strong> {{ \Carbon\Carbon::parse($timesheet->submitted_at)->format('F j, Y') ?? 'N/A' }}</li>
                <li><strong>Status:</strong> {{ ucfirst($timesheet->status) }}</li>
            </ul>

          
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>
</html>
