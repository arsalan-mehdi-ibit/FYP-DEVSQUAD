<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Timesheet Approval Reminder</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 30px;
        }
        .container {
            background-color: #ffffff;
            max-width: 600px;
            margin: auto;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }
        .header {
            color: #2f3640;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .content {
            font-size: 15px;
            color: #333;
            line-height: 1.6;
        }
        .details {
            margin: 20px 0;
            padding: 15px;
            background: #f1f2f6;
            border-radius: 5px;
        }
        .details strong {
            display: inline-block;
            width: 140px;
            color: #2f3640;
        }
        .footer {
            font-size: 13px;
            color: #888;
            margin-top: 30px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">Timesheet Approval Reminder</div>

    <div class="content">
        <p>Dear {{ $client_name }},</p>

        <p>This is a gentle reminder that the following timesheet is awaiting your review and approval:</p>

        <div class="details">
            <p><strong>Project Name:</strong> {{ $project_name }}</p>
            <p><strong>Submitted On:</strong> {{ $submitted_at }}</p>
            <p><strong>Status:</strong> {{ $status }}</p>
        </div>

        <p>Please log in to your dashboard to take necessary action.</p>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </div>
</div>
</body>
</html>
