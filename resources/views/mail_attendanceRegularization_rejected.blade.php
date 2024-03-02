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
        .txt-left {
            text-align: left;
        }

        .txt-right {
            text-align: right;
        }

        .txt-center {
            text-align: center;
        }

        .text-strong {
            font-weight: 600;
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
                                                <td colspan="4" align="center" class="border-less">
                                                    <img src={{ $client_logo }} style="height:45px;width:150px;"
                                                        title="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" align="left" class="border-less"
                                                    style="padding:10px ;">
                                                    SUB – Attendance Regularization Request Rejected  - Mr/Ms/Mrs Xyz
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" align="left" class="border-less"
                                                    style="padding:10px ;">

                                                    <p class="text-strong " style="margin: 0px 0px 0px ">Dear Xyz,</p>
                                                    <p class="" style="  ">
                                                        This is to inform you that your “Attendance Regularizations” request has been rejected by your line manager due to .</p>
                                                    </p>


                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center"
                                    style="padding:0px 40px 0px;"
                                    colspan="">
                                    <div class=""
                                        style="height:auto;width:90%;border-radius:5px;padding:10px;margin:auto;">
                                        <table style="table-layout:fixed; width:100%;border:1px solid rgba(44, 43, 43, 0.185);border-radius:5px;padding:10px">
                                            <tbody>

                                                <tr>
                                                    <td colspan="8"
                                                        style="color:#002f56;font-weight:600;font-size:20px;padding-bottom:20px;"
                                                        align="center">
                                                        Regularizations Rejected
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8" align="center">


                                                        <table>
                                                            <tbody>
                                                                <tr>
                                                                    <td align="center"
                                                                        style="height: 100px;
                                                                    width: 100px;
                                                                    background:#1b7df7;color:#ffffff;
                                                                    border-radius: 50%;font-size:20px;font-weight:600;">
                                                                        MX</td>
                                                                </tr>
                                                            </tbody>

                                                        </table>
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
                                                    <td colspan="8" style="" align="center">
                                                        Kindly visit the HRMS portal for more details.
                                                        <a class="" type="button" href="#"
                                                            style="text-decoration:none;cursor: pointer;font-weight:600">
                                                            demo.abshrms.com
                                                        </a>
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
                                                <td align="center" style="padding:10px 0px 0px 0px">
                                                    This e-mail was generatd from ABShrms if you think this is
                                                    SPAM,please do report to<a
                                                        href="https://mail.google.com/mail/u/0/#sent?compose=new"
                                                        style="text-decoration: none;color:none;"> info<span
                                                            style="color:#fa9530;">@abshrms.com</span></a>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-bottom: 10px">
                                    <table style="text-align:center; width:100%; padding:10px 0px;">
                                        <tbody>
                                            <tr>
                                                <td align="right" colspan="4" style="padding: 0;">
                                                    <a href="#" class="">
                                                        <img src="{{ URL::asset('assets/images/Google_Play_Store.png') }}"
                                                            alt="" class=""
                                                            style="margin:0px 20px 0px 0px">
                                                    </a>

                                                </td>
                                                <td align="left" colspan="4" style="padding: 0;">
                                                    <a href="#" class="">
                                                        <img src="{{ URL::asset('assets/images/apple_play_store.png') }}"
                                                            alt="" class=""
                                                            style="margin:0px 0px 0px 20px;">
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:0 !important;">
                                    <table align="center" style="text-align:center;width:100%" width="100%">
                                        <tbody>
                                            <tr>
                                                <td align="center" width="100%"
                                                    style="padding-bottom:0px !important;">
                                                    <div class="d-flex justify-content-center social-icons-wrapper">
                                                        <a href="https://accounts.google.com/signin" class=""
                                                            style="margin-right: 50px;text-decoration:none;">

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
                                                            style="margin:0px 0px 0px 50px;text-decoration:none;">

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
