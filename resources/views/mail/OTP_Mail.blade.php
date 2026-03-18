<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>OTP Mail</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>

<body>

    @include('mail.header')
    <tr>
        <td align="center" style="padding: 0px 35px 0 35px; background-color: #ffffff;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                <tr>
                    <td align="left" style=" font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 10px;">
                        <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #202020; margin-bottom: 0;">
                            Dear {{ ucfirst($first_name ?? '') }} {{ ucfirst($last_name ?? '') }},
                        </p>
                    </td>
                </tr>
                <tr>
                    <td align="left">
                        <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #202020; margin-bottom: 0; padding: 12px 0 0 0;">
                            Your OTP (One-Time Password) for authentication is: {{ $OTP }}. Please enter this code to complete registration process. Do not share this code with anyone for security reasons.
                        </p>
                        <p>
                            Thanks
                        </p>
                        <p>
                            RoadSathi Team
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    @include('mail.footer')

</body>

</body>

</html>
