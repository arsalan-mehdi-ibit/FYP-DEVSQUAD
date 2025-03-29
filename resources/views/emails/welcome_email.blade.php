<!DOCTYPE html>
<html>
<head>
    <title>Welcome to TrackPoint</title>
</head>
<body>
    <h1>Welcome to TrackPoint, {{ $user_name }}!</h1>
    <p>You have been invited to join TrackPoint by <strong>{{ $admin_name }}</strong>.</p>
    <p>We are excited to have you on board!</p>
    <p>Click the button below to get started:</p>
    <a href="{{ url('/') }}" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: #ffffff; text-decoration: none; border-radius: 5px;">Get Started</a>
    <p>If you have any questions, feel free to reach out.</p>
</body>
</html>
