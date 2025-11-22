<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
</head>

<body style="margin:0; padding:0; background:#f5f7fa; font-family: Arial, sans-serif;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#f5f7fa">
        <tr>
            <td align="center" style="padding: 40px 0;">

                <table width="500" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="border-radius: 10px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">

                    <tr>
                        <td align="center" bgcolor="#4f46e5" style="padding: 20px;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 600;">
                                Email Verification
                            </h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 30px; color: #333333; font-size: 16px; line-height: 24px;">
                            <p style="margin: 0 0 15px;">
                                Hello,
                            </p>
                            <p style="margin: 0 0 15px;">
                                Thank you for registering! Please verify your email using the OTP code below:
                            </p>

                            <div style="text-align: center; margin: 30px 0;">
                                <span style="
                                    display: inline-block;
                                    font-size: 36px;
                                    letter-spacing: 8px;
                                    font-weight: bold;
                                    color: #4f46e5;
                                    border: 2px dashed #4f46e5;
                                    padding: 15px 25px;
                                    border-radius: 8px;
                                ">
                                    {{ $otp }}
                                </span>
                            </div>

                            <p style="margin: 0 0 20px;">
                                Enter this OTP in the website to complete your verification.
                            </p>

                            <p style="color:#777; font-size: 13px; line-height: 20px;">
                                This OTP is valid for a limited time. If you did not create an account, please ignore this email.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td bgcolor="#f3f4f6" align="center" style="padding: 15px; font-size: 12px; color: #888;">
                            © {{ date('Y') }} Your App — All rights reserved.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>
</body>
</html>
