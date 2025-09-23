<!-- resources/views/emails/send_reset_code.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Password Reset Code</title>
</head>
<body>
    <h2>Your Password Reset Code</h2>
    <p>Use the following code to reset your password:</p>
    <h3>{{ $resetCode }}</h3>
    <p>This code will expire in 15 minutes.</p>
</body>
</html>
