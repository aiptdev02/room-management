<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registation OTP - RB Corporation Insurance</title>
</head>

<body>
    <div style="margin: 0 auto; width:600px; padding:20px; border:1px solid #ccc; border-raduis:10px;">
        <div style="text-align: center; padding:10px 0 20px">
            <img src="{{ $sitelogo }}" alt="">
        </div>
        <p>Dear: {{ $maildata['userdata']['name'] }}</p>
        <p>Thanks for showing interest in the RB Corporation insurance.</p>

        <b>The account verification OTP is:</b>
        <table style="width: 100%">
            <tr>
                <td style="border: 1px solid #ccc; padding:5px;">OTP</td>
                <td style="border: 1px solid #ccc; padding:5px;">{{ $maildata['otp'] }}</td>
            </tr>
        </table>

        <p>Thanks &amp; Regards</p>
    </div>
</body>

</html>
