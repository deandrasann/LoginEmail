<!DOCTYPE html>
<html>
<head>
    <title>Registration Successful</title>
</head>
<body>
    <h1>Welcome, {{ $user->name }}!</h1>
    <p>Thank you for registering with us.</p>
    <p>If you have any questions, feel free to contact us at support@example.com.</p>
    <p>Best Regards,<br>{{ config('app.name') }}</p>
</body>
</html>
