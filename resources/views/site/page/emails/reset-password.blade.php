<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">

    <div style="max-width: 600px; margin: auto; background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <h2 style="text-align: center; color: #007bff;">Reset Your Password</h2>

        <p style="font-size: 16px; text-align: center;">Hi {{ $user->name ?? 'User' }},</p>

        <p style="font-size: 16px;">We received a request to reset your password. Click the button below to reset it:</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $resetLink }}/{{ $email }}" style="background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-size: 16px;">Reset Password</a>
        </div>

        <p style="font-size: 14px; color: #6c757d;">This password reset link will expire in 60 minutes.</p>

        <p style="font-size: 14px;">If you didn’t request a password reset, you can safely ignore this email.</p>

        <hr style="margin: 30px 0;">

        <p style="text-align: center; font-size: 14px; color: #6c757d;">
            &copy; {{ date('Y') }} itsamagri. All rights reserved.
        </p>
    </div>

</body>
</html>
