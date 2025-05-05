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
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
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

            <p><strong>{{ $contractor_name }}</strong> has submitted a timesheet for the project
                <strong>{{ $project_name }}</strong> for approval.</p>

            <p><strong>Timesheet:</strong> {{ $timesheet_date }}</p>

            <p>Please review the timesheet and take appropriate action.</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} TrackPoint. All rights reserved.</p>
        </div>
    </div>

</body>

</html>
