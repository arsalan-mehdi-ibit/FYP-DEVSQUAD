<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to TrackPoint</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
        }

        .email-container {
            max-width: 600px;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            font-size: 22px;
            font-weight: bold;
            color: #333;
        }

        .email-content {
            font-size: 16px;
            color: #555;
            margin-top: 10px;
        }

        .btn {
            display: inline-block;
            background-color: rgb(10, 2, 75);
            color: #ffffff !important;
            padding: 12px 18px;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            margin-top: 15px;
            font-weight: bold;
        }

        .btn:hover {
            background-color: rgb(23, 3, 90);
        }

        .email-footer {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <p class="email-header">👋 Welcome to TrackPoint, {{ $user_name }}!</p>

        <p class="email-content">
            You have been invited to join TrackPoint by <strong>{{ $admin_name }}</strong>. <br>
            We're excited to have you on board! 🚀
        </p>

        <p class="email-content">Click the button below to set up your password:</p>

        <a href="{{ $reset_link }}" class="btn">Set Your Password</a>

        <p class="email-footer">
            If you have any questions, feel free to reach out.<br>
            <strong>TrackPoint</strong>
        </p>
    </div>
</body>

</html>
