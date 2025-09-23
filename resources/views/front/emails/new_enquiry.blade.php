<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RB Corporation Insurance - Enquiry</title>
</head>

<body>
    <div style="margin: 0 auto; width:600px; padding:20px; border:1px solid #ccc; border-raduis:10px;">
        <div style="text-align: center; padding:10px 0 20px">
            <img src="{{ $sitelogo }}" alt="">
        </div>
        <p>Dear: {{ $maildata['userdata']['name'] }}</p>
        <p>Thanks for showing interest in the RB Corporation insurance.</p>

        <table style="width: 100%">
            <tr>
                <td style="border: 1px solid #ccc; padding:5px;">Enquiry ID</td>
                <td style="border: 1px solid #ccc; padding:5px;">{{ $maildata['data']['enq_id'] }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #ccc; padding:5px;">Total Members</td>
                @php
                    $members = json_decode($maildata['data']['members']);
                @endphp
                <td style="border: 1px solid #ccc; padding:5px;">{{ count($members) }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #ccc; padding:5px;">City</td>
                <td style="border: 1px solid #ccc; padding:5px;">{{ $maildata['data']['city'] }}</td>
            </tr>
        </table>

        <p>Please check complete details in the dashboard: {{ url('myaccount') }}</p>
        @if ($maildata['userdata']['type'] == 'new')
            <p><b>Login Credentials</b></p>
            <table>
                <tr>
                    <td style="border: 1px solid #ccc; padding:5px;">Mobile</td>
                    <td style="border: 1px solid #ccc; padding:5px;">{{ $maildata['data']['mobile'] }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #ccc; padding:5px;">Password</td>
                    <td style="border: 1px solid #ccc; padding:5px;">{{ $maildata['data']['mobile'] }}</td>
                </tr>
            </table>
        @endif
        <p>Thanks &amp; Regards</p>
    </div>
</body>

</html>
