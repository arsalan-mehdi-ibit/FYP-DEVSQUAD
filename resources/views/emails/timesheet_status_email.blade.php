<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timesheet Status Update</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }
        .container {
            max-width: 650px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 25px;
            border-radius: 10px;
            border: 1px solid #ddd;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 20px;
            background-color: #28a745;
            color: #ffffff;
            border-radius: 10px 10px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            margin-top: 20px;
            font-size: 16px;
            line-height: 1.5;
        }
        .content p {
            margin-bottom: 15px;
        }
        .content strong {
            color: #333;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
            color: #666;
            padding-top: 15px;
            border-top: 1px solid #ddd;
        }
        .button {
            display: inline-block;
            padding: 12px 25px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            margin-top: 25px;
            text-align: center;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .rejection-message {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h1>Timesheet Status Update</h1>
        </div>

        <div class="content">
            <p>Dear {{ $contractor_name }},</p>

            <p>We would like to inform you that your timesheet for the project <strong>{{ $project_name }}</strong> has been <strong>{{ $status }}</strong> by <strong>{{ $approver_name }}</strong>.</p>

            @if($status == 'rejected')
                <p class="rejection-message">Reason for Rejection: <strong>{{ $rejection_reason }}</strong></p>
            @endif

            <p>If you have any questions or concerns, please don't hesitate to reach out to the project manager.</p>

           
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} TrackPoint. All rights reserved.</p>
        </div>
    </div>

</body>
</html>
