<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timesheet Submitted for Approval</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        .header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
        }
        .content {
            margin-top: 20px;
        }
        .content p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 10px;
        }
        .content strong {
            color: #333;
        }
        .button {
            display: inline-block;
            margin-top: 20px;
            background-color: #273c75;
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 5px;
            font-weight: bold;
        }
        .button:hover {
            background-color: #1f2e5a;
        }
        .button-reject {
            background-color: #c0392b;
        }
        .button-reject:hover {
            background-color: #922b21;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 13px;
            color: #888;
        }
    </style>
</head>
<body>

    <div class="container">
        <p class="header">Timesheet Submitted for Approval</p>

        <div class="content">
            <p>Hello {{ $role == 'client' ? 'Client' : 'Admin' }} 👋,</p>

            <p><strong>{{ $contractor_name }}</strong> has submitted a timesheet for the project <strong>{{ $project_name }}</strong> for approval.</p>

            <p><strong>Timesheet:</strong> {{ $timesheet_date }}</p>
            
            <p>Please review the timesheet and take appropriate action. You can approve or reject the timesheet based on your assessment.</p>
            
            <a href="{{ route('timesheet.approve', $timesheet_id) }}" class="button">Approve Timesheet</a>
            <a href="{{ route('timesheet.reject', $timesheet_id) }}" class="button button-reject">Reject Timesheet</a>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} TrackPoint. All rights reserved.</p>
        </div>
    </div>

</body>
</html>
