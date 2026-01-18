<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Email Verification Code</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; margin:0; padding:0;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f8f9fa; padding: 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background-color: #ffffff; border-radius: 8px; padding: 30px; text-align: center; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                    <tr>
                        <td style="font-size: 24px; font-weight: bold; color: #dc3545; padding-bottom: 10px;">
                            Lagonoy Building Permit Management System
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 16px; color: #333333; padding-bottom: 20px;">
                            Hello {{ $name }},
                            <br><br>
                            Thank you for registering. Please use the following verification code to confirm your email
                            address:
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 28px; font-weight: bold; color: #dc3545; padding: 20px 0;">
                            {{ $code }}
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px; color: #777777; padding-top: 10px;">
                            If you did not register for this account, please ignore this email.
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px; color: #777777; padding-top: 20px;">
                            &copy; {{ date('Y') }} Lagonoy Building Permit Management System
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
