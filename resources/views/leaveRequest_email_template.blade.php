<?php

$general_info = \DB::table('vmt_client_master')->first();
//$employee_name =  \DB::table('users')->where('user_code','=',$employee->EMP_NO)->first('name');
$client_logo = request()->getSchemeAndHttpHost() . '' . $general_info->client_logo;
// dd(request()->getSchemeAndHttpHost()."".$general_info->client_logo);
$bank_names = \DB::table('vmt_banks')->get();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        @import url(https://fonts.googleapis.com/css?family=Open+Sans:700,300,600,400);

        .welcome {
            background: url(email_bg.jpg);
        }
    </style>
</head>

<body style="background-color:; padding: 5px; margin: 0;">
    <table id="wrapper" cellpadding="0" cellspacing="0" width="552"
        style="max-width:552px; height: auto; margin: 0 auto;   font-size: 14px !important; color: #403e3c; line-height: 24px;">
        <tbody>
            <tr>
                <td>
                    <table border="0" cellpadding="24" cellspacing="0" bgcolor="#ffffff"
                        style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;padding-top:0px;">
                        <tbody>
                            <tr>
                                <td align="center" style="padding:0;">

                                    <table cellpadding="20" cellspacing="0" width="100%" align="center">
                                        <tbody>
                                            <tr>
                                                <td colspan="4" align="center" class="border-less"
                                                    style="padding-top:10px;padding-bottom:10px;">
                                                    <div class="header-img txt-right" style="">
                                                        <img src={{ $client_logo }} style="height:40px;width:150px;"
                                                            title="">
                                                    </div>

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" style="padding:0px 40px 40px;" colspan="">
                                    <div class=""
                                        style="height:auto;width:90%;border-radius:5px;box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;padding:10px;margin:auto;">
                                        <table style="table-layout:fixed; width:100%;">
                                            <tbody>

                                                <tr>
                                                    <td colspan="8"
                                                        style="color:#002f56;font-weight:600;font-size:20px;padding-bottom:20px;"
                                                        align="center">
                                                        Leave Request Form
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8"
                                                        style="color:#002f56;font-weight:600;font-size:20px;padding-bottom:5px;"
                                                        align="center">
                                                        <div
                                                            style="display:flex;height:100px;width:100px;border-radius:50%;background:#1b7df7;color:#ffffff;justify-content:center;align-items:center;">
                                                            <span style="font-weight: 600;">
                                                                MS
                                                            </span>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td colspan="8"
                                                        style="color:#002f56;font-weight:600;font-size:20px;padding-bottom:20px;"
                                                        align="center">
                                                        Max Srirni
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4"
                                                        style="color:#002f56;font-weight:600;font-size:20px;border-right:1px solid #c1c1c1;"
                                                        align="center">
                                                        <div
                                                            style="display:flex;justify-content:center;align-items:center;flex-direction:column;">
                                                            <p
                                                                style="font-weight:500;color:#c1c1c1;margin-bottom:0px;margin-top:0px;font-size:12px">
                                                                Requested on
                                                            </p>
                                                            <p
                                                                style="font-weight:600;color:#002f56;margin-bottom:0px;margin-top:0px;font-size:14px">
                                                                <span>Apr</span>
                                                                <span>21,2022</span>
                                                                <span>11:33am</span>
                                                            </p>
                                                            <p
                                                                style="font-weight:500;color:#c1c1c1;margin-bottom:0px;margin-top:0px;font-size:12px">
                                                                (Thursday)
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td colspan="4"
                                                        style="color:#002f56;font-weight:600;font-size:20px;padding-bottom:10px"
                                                        align="center">
                                                        <div
                                                            style="display:flex;justify-content:center;align-items:center;flex-direction:column;">
                                                            <p
                                                                style="font-weight:500;color:#c1c1c1;margin-bottom:0px;margin-top:0px;font-size:12px">
                                                                Requested on
                                                            </p>
                                                            <p
                                                                style="font-weight:600;color:#002f56;margin-bottom:0px;margin-top:0px;font-size:14px">

                                                                <span>Apr</span>
                                                                <span>22,2022</span>
                                                                <span>-</span>
                                                                <span>Apr</span>
                                                                <span>27,2022</span>
                                                            </p>

                                                            <p
                                                                style="font-weight:500;color:#c1c1c1;margin-bottom:0px;margin-top:0px;font-size:12px">
                                                                <span
                                                                    style="text-align:left ;margin-right:10px;">(Thursday)</span>
                                                                <span
                                                                    style="text-align:right;margin-left:10px;">(Friday)</span>
                                                            </p>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="8"
                                                        style="color:#002f56;font-weight:600;font-size:20px;padding-bottom:25px;"
                                                        align="center">
                                                        <div
                                                            style="display:flex;justify-content:center;align-items:center;flex-direction:column;">
                                                            <p
                                                                style="font-weight:500;color:#c1c1c1;margin-bottom:0px;margin-top:0px;font-size:12px">
                                                                Reason
                                                            </p>
                                                            <p
                                                                style="font-weight:600;color:#002f56;margin-bottom:0px;margin-top:0px;font-size:14px">
                                                                2 Day of sick leave
                                                            </p>

                                                            <p
                                                                style="font-weight:500;color:#c1c1c1;margin-bottom:0px;margin-top:0px;font-size:12px">
                                                                (Personal Emergency)
                                                            </p>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="" align="right">

                                                        <button class=""
                                                            style="margin: 0px 20px 0px 0px;color:#ffffff;padding: 8px 40px;border: 2px solid #90f10c;background: #90f10c;border-radius: 4px;font-weight:600">
                                                            Approve
                                                        </button>
                                                    </td>
                                                    <td colspan="4" style="" align="left">

                                                        <button class=""
                                                            style="margin: 0px 0px 0px 20px;color:#ffffff;padding: 8px 40px;border: 2px solid #f12d0c;background: #ff2500;border-radius: 4px;font-weight:600">
                                                            Reject
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>

                                        </table>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 0px;">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td align="center" style="padding:0px 30px">
                                                    This e-mail was generatd from ABShrms if you think this is
                                                    SPAM,please do report to
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <a href="https://mail.google.com/mail/u/0/#sent?compose=new"
                                                        style="text-decoration: none;color:none;"> info<span
                                                            style="color:#fa9530;">@abshrms.com</span></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                        </tbody>
                    </table>

                </td>
            </tr>
            <tr>
                <td>
                    <table style="text-align:center; width:100%; padding-top:20px;padding-bottom:20px;" width="100%">
                        <tbody>
                            <tr>
                                <td align="right" colspan="4" style="padding: 0;">
                                    <a href="#" class="">
                                        <img src="{{ URL::asset('assets/images/Google_Play_Store.png') }}"
                                            alt="" class="" style="margin:0px 20px 0px 0px">
                                    </a>

                                </td>
                                <td align="left" colspan="4" style="padding: 0;">
                                    <a href="#" class="">
                                        <img src="{{ URL::asset('assets/images/apple_play_store.png') }}"
                                            alt="" class="" style="margin:0px 0px 0px 20px;">
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table cellpadding="0" cellspacing="0" width="100%"
                        style="table-layout:fixed;padding:0 0 0px !important;margin:0 auto;width:100%;background-color:#F3F5F7;"
                        bgcolor="#F3F5F7">
                        <tbody>
                            <tr>
                                <td style="padding:0 !important;">
                                    <table align="center" style="text-align:center;width:100%" width="100%">
                                        <tbody>
                                            <tr>
                                                <td align="center" width="100%"
                                                    style="padding-bottom:0px !important;">
                                                    <div
                                                        class="d-flex align-items-center justify-content-center social-icons-wrapper">
                                                        <a href="https://accounts.google.com/signin" class=""
                                                            style="margin-right: 30px;text-decoration:none;">

                                                            <img src="http://127.0.0.1:8000/assets/images/login_img/google.png"
                                                                alt="" class=""
                                                                style="height:20px;width:20px;">
                                                        </a>
                                                        <a href="https://www.linkedin.com/login" class=""
                                                            style="margin:0px 30px;text-decoration:none;">

                                                            <img src="http://127.0.0.1:8000/assets/images/login_img/linkedIn_PNG39.png"
                                                                alt="" class=""
                                                                style="height: 20px;width:20px;">
                                                        </a>
                                                        <a class=""
                                                            href="https://login.live.com/login.srf?wa=wsignin1.0&amp;rpsnv=13&amp;ct=1658217648&amp;rver=7.0.6738.0&amp;wp=MBI_SSL&amp;wreply=https:%2F%2Faccount.microsoft.com%2Fauth%2Fcomplete-signin%3Fru%3Dhttps%253A%252F%252Faccount.microsoft.com%252F%253Frefp%253Dsignedout-index%2526refd%253D127.0.0.1&amp;lc=1033&amp;id=292666&amp;lw=1&amp;fl=easi2"
                                                            style="margin:0px 30px;text-decoration:none;">

                                                            <img src="http://127.0.0.1:8000/assets/images/login_img/microsoft_PNG18.png"
                                                                alt="" class=""
                                                                style="height: 20px;width:20px;">
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

        </tbody>
    </table>
</body>

</html>

