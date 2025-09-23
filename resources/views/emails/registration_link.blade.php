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
        <h2>Hello {{ auth()->user()->username }},</h2>
        <p>Thank you for choosing 4050Fit! Here is your registration link for client sign-ups:</p>
        <p><a href="{{ $registrationLink }}">{{ $registrationLink }}</a></p>
        <p>Best regards, <br> 4050Fit Team</p>
    </div>
</body>

</html>
