<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to TrackPoint</title>
</head>
<body>
    <h2>Welcome to TrackPoint, {{ $user_name }}!</h2>

    <p>You have been invited to join TrackPoint by {{ $admin_name }}.</p>

    <p>We are excited to have you on board!</p>

    <p>Click the button below to set up your password:</p>

    <a href="{{ $reset_link }}" 
       style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: #ffffff; text-decoration: none; border-radius: 5px;">
       Set Your Password
    </a>

    <p>If you have any questions, feel free to reach out.</p>

    <p>Best Regards,</p>
    <p>TrackPoint Team</p>
</body>
</html>
