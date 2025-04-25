<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrackPoint Notification</title>
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
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
        }
        .email-content {
            font-size: 16px;
            color: #555;
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
            @if($role === 'client')
                <p>We're excited to let you know that a new project titled <strong>"{{ $project_name }}"</strong> has been created, and you have been added as the <strong>Client</strong>.</p>
                <p>You can now follow the progress, share inputs, and collaborate with your team through TrackPoint.</p>
            @elseif($role === 'consultant')
                <p>You have been assigned as the <strong>Consultant</strong> for the project <strong>"{{ $project_name }}"</strong>.</p>
                <p>Your insights and direction will guide the successful execution of this project.</p>
            @elseif($role === 'contractor')
                <p>You’ve been selected as a <strong>Contractor</strong> for the project <strong>"{{ $project_name }}"</strong>.</p>
                <p>Please review your assigned responsibilities and get started promptly.</p>
            @else
                <p>You have a new update related to the project <strong>"{{ $project_name }}"</strong>.</p>
            @endif

            @if($reset_link)
                <p>Click below to set your password and access your TrackPoint dashboard:</p>
                <a href="{{ $reset_link }}" class="btn">Set Your Password</a>
            @endif

            <p>Best regards,<br><strong>{{ $admin_name }}</strong><br>TrackPoint Team</p>
        </div>

        <p class="email-footer">
            &copy; {{ date('Y') }} TrackPoint. All rights reserved.
        </p>
    </div>
</body>
</html>
