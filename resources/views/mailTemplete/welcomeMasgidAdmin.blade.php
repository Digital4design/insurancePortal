<?php
// dd($content);
?>

<body style="margin:0; padding:15px; background-color:#F4F6F8">
    <center>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#F4F6F8" class="wrapper">
            <tr>
                <td align="center" height="100%" valign="top" width="100%">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;margin:0" bgcolor="#F4F6F8">
                        <tr>
                            <td height="15" style="font-size:15px; line-height:10px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="center" valign="top">
                                <!-- <a href="{{ url('') }}"><img src="{{ asset('public/images/logo.png') }}" alt="Insight" width="110" height="30"></a> -->
                                <a href="{{ url('/login') }}"><img src="{{ asset('public/assets/admin/images/logo_new.png') }}" alt="InsurancePortal" width="110" height="30"></a>
                            </td>
                        </tr>
                        <tr>
                            <td height="20" style="font-size:20px; line-height:10px;">&nbsp;</td>
                        </tr>
                    </table>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;padding: 30px;" bgcolor="#FFFFFF">
                        <tr>
                            <td align="center" valign="top">
                                <p style="font-size: 24px;line-height:32px;font-family: Helvetica, Arial, sans-serif;text-align: left;color:#222222;margin: 0 0 15px 0;padding:0;font-weight: bold;">Welcome Mail From Insurance Portal</p>
                                <p style="font-size: 16px;line-height:26px;font-family: Helvetica, Arial, sans-serif;text-align: left;color:#444444;margin: 0 0 15px 0;padding:0;">Hi {{ $username }},</p>
                                <p style="font-size: 16px;line-height:26px;font-family: Helvetica, Arial, sans-serif;text-align: left;color:#444444;margin: 0 0 15px 0;padding:0;">Your are successfully Registered on Insurance Portal.</p>
                                <p style="font-size: 16px;line-height:26px;font-family: Helvetica, Arial, sans-serif;text-align: left;color:#444444;margin: 0 0 15px 0;padding:0;">Please check your login details.</p>
                                <p style="font-size: 16px;line-height:26px;font-family: Helvetica, Arial, sans-serif;text-align: left;color:#444444;margin: 0 0 15px 0;padding:0;">Email : {{ $useremail }}</p>
                                <p style="font-size: 16px;line-height:26px;font-family: Helvetica, Arial, sans-serif;text-align: left;color:#444444;margin: 0 0 15px 0;padding:0;">Password : {{ $userPassword }}</p>
                                <!-- Button -->
                                <table width="100%">
                                    <tr>
                                        <td>
                                            <table width="180" height="38" cellpadding="0" cellspacing="0" border="0" bgcolor="#0078D7" align="left" style="border-radius:19px;margin:10px 0 25px 0;">
                                                <tr>
                                                    <td align="center" valign="middle" height="38" style="font-family: Arial, sans-serif; font-size:16px; font-weight:normal;">
                                                        <a href="{{ url('/login') }}" target="_blank" style="font-family: Arial, sans-serif; color:#FFFFFF; display: inline-block; text-decoration: none; line-height:38px; width:180px; font-weight:normal;">Login Now</a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <!-- End Button -->
                            </td>
                        </tr>
                    </table>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;margin: 0 0 0" bgcolor="#F4F6F8">
                        <tr>
                            <td height="20" style="font-size:20px; line-height:10px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="center" valign="top">
                                <!-- <p style="font-size: 12px;line-height:18px;font-family: Helvetica, Arial, sans-serif;text-align: center;color:#666666;margin: 0 0 30px 0;padding:0;">© 2019 {{ config('app.name') }} &nbsp;•&nbsp;  <a href="{{ url('') }}" style="color:#0078D7;">Terms</a> &nbsp;•&nbsp;  <a href=" {{ url('') }}" style="color:#0078D7;">Privacy</p> -->
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </center>
</body>