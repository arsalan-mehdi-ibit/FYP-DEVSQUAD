<!DOCTYPE html>
<html>
<head>
    <title>Reset Your Password</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">

    <div style="max-width: 600px; margin: auto; background-color: white; border-radius: 10px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <h2 style="color: #1a2a40;">Hello {{ $data['user_name'] }},</h2>

        <p style="font-size: 16px; color: #333333;">
            {{ $data['message'] }}
        </p>

        <div style="margin: 30px 0; text-align: center;">
            <a href="{{ $data['reset_link'] }}" style="background-color: #1a2a40; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-size: 16px;">
                Reset Password
            </a>
        </div>

        <p style="font-size: 14px; color: #777777;">
            If you did not request a password reset, please ignore this email.
        </p>

        <p style="margin-top: 30px; font-size: 14px; color: #999999;">
            — TrackPoint Team
        </p>
    </div>

</body>
</html>
