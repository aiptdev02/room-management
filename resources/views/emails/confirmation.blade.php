<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: #28a745;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hello {{ $user['first_name'] }},</h2>
        <p>Thank you for registering! Please confirm your email address by clicking the button below to activate your account:</p>
        <p>
            <a href="{{ $activation_link }}" class="button">Activate Account</a>
        </p>
        <p>If you're unable to click the button, copy and paste the link below into your browser:</p>
        <p>{{ $activation_link }}</p>
        <p>Thank you,<br>The Team</p>
    </div>
</body>
</html>
