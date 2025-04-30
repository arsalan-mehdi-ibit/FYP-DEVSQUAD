<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Payment Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }
        .email-container {
            max-width: 600px;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            margin: 0 auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        .email-header {
            font-size: 22px;
            font-weight: bold;
            color: #273c75;
        }
        .email-content {
            font-size: 16px;
            color: #333;
            margin-top: 20px;
            line-height: 1.6;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            background-color: #273c75;
            color: #fff !important;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 5px;
            font-weight: bold;
        }
        .email-footer {
            margin-top: 30px;
            font-size: 13px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <p class="email-header">Hello {{ $user_name }} 👋</p>

        <div class="email-content">
            @if($role === 'contractor')
                <p>Your invoice for <strong>{{ $timesheet_name }}</strong> (project: <strong>{{ $project_name }}</strong>) has been marked as <strong>Paid</strong> by <strong>{{ $admin_name }}</strong>.</p>
                <p>The total paid to you is: <strong>${{ number_format($contractor_paid, 2) }}</strong>.</p>
            @elseif($role === 'client')
                <p>You have successfully paid <strong>${{ number_format($admin_received, 2) }}</strong> for the invoice related to <strong>{{ $timesheet_name }}</strong> under the project <strong>{{ $project_name }}</strong>.</p>
            @elseif($role === 'admin')
                <p>The invoice for <strong>{{ $timesheet_name }}</strong> (project: <strong>{{ $project_name }}</strong>) has been marked as <strong>Paid</strong>.</p>
                <p>Contractor: <strong>{{ $contractor_name }}</strong><br>
                Client: <strong>{{ $client_name }}</strong></p>
            @else
                <p>There is an update regarding invoice payment for <strong>{{ $timesheet_name }}</strong>.</p>
            @endif

           

            <p>Thank you for using <strong>TrackPoint</strong>.<br>Best regards,<br><strong>{{ $admin_name }}</strong><br>TrackPoint Team</p>
        </div>

        <p class="email-footer">
            &copy; {{ date('Y') }} TrackPoint. All rights reserved.
        </p>
    </div>
</body>
</html>
