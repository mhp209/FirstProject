<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registration Email</title>
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
        <td align="center" style="padding: 35px 35px 0 35px; background-color: #ffffff;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                <tr>
                    <td align="left" style=" font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 10px;">
                        <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #202020; margin-bottom: 0;">
                            Dear {{ ucfirst($first_name) }} {{ ucfirst($last_name) }},
                        </p>
                    </td>
                </tr>
                <tr>
                    <td align="left">
                        <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #202020; margin-bottom: 0; padding: 12px 0 0 0;">
                            Thank you for registering on RoadSathi! We're delighted to have you join us.
                        </p>
                        <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #202020; margin-bottom: 0; padding: 5px 0 0 0;">
                            If you have any queries or require further assistance, feel free to contact us.
                        </p>
                        <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #202020; margin-bottom: 0; padding: 12px 0 0 0;">
                            Thanks
                        </p>
                        <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #202020; margin-bottom: 0; padding: 0px 0 0 0;">
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
