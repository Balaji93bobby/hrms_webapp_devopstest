<?php

$general_info = \DB::table('vmt_client_master')->orderBy('id', 'desc')->first();
//$employee_name =  \DB::table('users')->where('user_code','=',$employee->EMP_NO)->first('name');
$client_logo = request()->getSchemeAndHttpHost() . '' . $general_info->client_logo;
// dd(request()->getSchemeAndHttpHost()."".$general_info->client_logo);


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OkR</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">


</head>

<body>
    <div style="display:flex;background-color: #fbfbfb;
    padding: 20px;
">
        <table class="pms_mailTemplate" bgcolor="#D0DBF0"
            style="margin: 0 auto;font-family: 'Poppins', sans-serif;border-collapse:collapse;width:620px;">
            <tr>
                <td colspan="8">
                    <table
                        style="width: 100%;border-collapse:collapse;font-family: 'Poppins', sans-serif;color:#003056;">
                        <tbody>
                            <tr>
                                <td colspan="4"
                                    style="padding: 20px 30px 10px 30px;
                               ">
                                    <div class="logo text-center" style="width:100%;height:30px;">
                                        <img src="{{ URL::asset('assets/images/client_logos/ardens/evangelist.png') }}"
                                            alt="" class="" style="width:140px;height:30px;">
                                    </div>
                                </td>
                                <td colspan="4"
                                style="padding: 20px 30px 10px 30px;
                           ">
                                <div class="logo " style="width:100%;height:30px;text-align:right;">
                                    <img src="{{ $client_logo }}"
                                        alt="" class="" style="width:140px;height:30px;">
                                </div>
                            </td>
                            </tr>

                            <tr>
                                <td colspan="8" style="padding: 0 26px 12px 26px;">
                                    <table style="border-collapse: collapse;width:100%;">
                                        <tbody>
                                            <tr>
                                                <td class="border-t-blue" style=" border-top: 2px solid #003056;"
                                                    colspan="2">
                                                </td>
                                                <td class="border-t-orange" style="border-top: 2px solid #FF4D00; "
                                                    colspan="2">
                                                </td>
                                                <td class="border-t-blue" style=" border-top: 2px solid #003056;"
                                                    colspan="2">
                                                </td>
                                                <td class="border-t-orange" style="border-top: 2px solid #FF4D00; "
                                                    colspan="2">
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
                <td colspan="8" bgcolor="#fff" style="padding:20px 30px;">
                    <table class="template_mail"
                        style="
                        border-collapse:collapse;color:#003056;
                        font-family: 'Poppins', sans-serif;">
                        <tbody>
                            <tr>
                                <td colspan="4"
                                    style="color:#003056;
                                padding: 0 25px 0 0;
                               ">
                                    <h6 style="margin: 0;font-size:20px;">Hi </h6>
                                    <h4 style="font-size: 30px;
                                    margin: 0;">
                                        Welcome
                                    </h4>
                                    <p
                                        style="
                                        padding: 10px 0;
                                        margin: 0 0 16px 0;
                                        font-size: 13px;">
                                        ABShrms would like to invite to you join our organization's employee
                                        portal.Using the portal you can access all your payroll realted
                                        information.Please change the password immediately after login.
                                    </p>
                                    <div style="text-align: right">
                                        <a role="button"
                                        href="https://ardens.in/"
                                            style="
                                        background-color: #003056;
                                        color: #fff;
                                        padding: 6px 20px;
                                        border-radius: 50px;
                                        text-decoration: none;
                                        font-weight: 600;
                                        border: 2px solid #003056;


                                        ">Get
                                            Started
                                        </a>
                                    </div>
                                </td>
                                <td colspan="4">
                                    <div class="" style="width:300px;height:auto">
                                        <img src="{{ URL::asset('assets/images/email/welcome_img1.png') }}"
                                            alt="" class="" style="width:100%;height:100%;">
                                    </div>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="8" style="padding: 20px 30px;text-align:center;">
                    <a role="button"
                    href="https://ardens.in/company/about-us/"
                        style="border:2px solid #003056;
                    color:#003056;
                    background-color:transparent;
                    padding: 6px 20px;
                     border-radius: 50px;
                     text-decoration: none;
                     font-weight: 600;

                    ">Get
                        In Touch
                    </a>

                </td>
            </tr>


            <tr>
                <td colspan="8" style="padding: 0 26px 12px 26px;">
                    <table style="border-collapse: collapse;width:100%;">
                        <tbody>
                            <tr>
                                <td colspan="8" style="border-top: 2px solid #fff">

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>

            </tr>

            <tr>
                <td colspan="8" bgcolor="#D0DBF0" style="padding:20px 30px ">
                    <table class="template_mail"
                        style="
                        border-collapse:collapse;
                        font-family: 'Poppins', sans-serif;color:#003056;">
                        <tbody>
                            <tr>
                                <td colspan="4" style="padding: 0 25px 0 0;
                            ">
                                    <div class="" style="width:250px;height:auto">
                                        <img src="{{ URL::asset('assets/images/email/welcome_img2.png') }}"
                                            alt="" class="" style="width:100%;height:100%;">
                                    </div>

                                </td>
                                <td colspan="4" style="color: #003056;vertical-align: baseline;">
                                    <h6 style="margin:0;white-space: nowrap;font-size:18px;">5 Years Of
                                        Achivements </h6>
                                    <p
                                        style="text-align:left;
                                        padding-bottom:10px;color:#003056;
                                         margin:0;">
                                        The reason why we are loved by our customers is that
                                        we provide professional and affordable legal services for bussiness.
                                    </p>

                                    <div style="padding:10px 0;display:inline-flex;">

                                        <div style="padding: 0 10px 0 10px;text-align:center">
                                            <h5
                                                style="font-size: 15px;margin:0;
                                        color: #ff3900;">
                                                172+</h5>
                                            <p style="margin: 0;color: #003056;">
                                                Enterpreneurs
                                                served
                                            </p>
                                        </div>

                                        <div style="padding: 0 10px 0 10px;text-align:center">
                                            <h5
                                                style="font-size: 15px;
                                                margin:0;
                                        color: #ff3900;">
                                                100+</h5>
                                            <p style="margin: 0;color: #003056;text-align:center">
                                                Clients Served
                                            </p>
                                        </div>
                                        <div style="padding: 0 10px 0 10px;text-align:center">
                                            <h5
                                                style="font-size: 15px;margin:0;
                                        color: #ff3900;">
                                                8+</h5>
                                            <p style="margin: 0;color: #003056;">
                                                Cities
                                            </p>
                                        </div>
                                        <div style="padding: 0 10px 0 10px;text-align:center">
                                            <h5
                                                style="font-size: 15px;margin:0;
                                            color: #ff3900;">
                                                10+</h5>
                                            <p style="margin: 0;color: #003056;">
                                                Partners
                                            </p>
                                        </div>

                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="8" style="padding: 0 26px 12px 26px;">
                    <table style="border-collapse: collapse;width:100%;">
                        <tbody>
                            <tr>
                                <td colspan="8" style="border-top: 2px solid #fff">

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="8">
                    <table style="width: 100%;color:#003056;border-collapse:collapse;">
                        <tbody style="text-align: center">
                            <tr>
                                <td colspan="8">
                                    <div style="text-align: center">
                                        <h6
                                         style="margin:0;font-size:18px;color:#003056;">Login
                                            to your account
                                        </h6>

                                        <p style="padding:5px 0;margin:0;"><span style="color: #FF4D00">Note</span>
                                            <span>-</span> Please change
                                            the password immediately when you login
                                        </p>
                                        <div style="padding-bottom:5px ">
                                            <p style="margin:0;">
                                                Client Email
                                            </p>
                                            <p style="padding:5px 0;margin: 0;color:#FF4D00;font-weight:600;">{{ $uEmail }}</p>
                                        </div>
                                        <div style="padding-bottom:5px ">
                                            <p style="margin: 0;">Client Password </p>
                                            <p style="padding:5px 0;margin: 0;color:#FF4D00;font-weight:600;">{{ $uPassowrd}}</p>
                                        </div>

                                        <div style="padding: 15px 0;">
                                            <a role="button"
                                                style="border:2px solid #003056;
                                        color:#003056;
                                        background-color:transparent;
                                        padding: 6px 20px;
                                         border-radius: 50px;
                                         text-decoration: none;
                                         font-weight: 600;
                                        ">Login
                                            </a>
                                        </div>

                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </td>
            </tr>
            <tr>
                <td colspan="8" style="padding: 0 26px 12px 26px;">
                    <table style="border-collapse: collapse;width:100%;">
                        <tbody>
                            <tr>
                                <td colspan="8" style="border-top: 2px solid #fff">

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="8" style="padding: 0 26px 12px 26px;">
                    <table style="border-collapse: collapse;width:100%;color:#003056;">
                        <tbody>
                            <tr>
                                <td colspan="8" style="text-align: center;    padding: 0 30px 12px 30px;    ">
                                    <h6 style="margin:0;font-size:15px;color:#003056;padding: 0 0 10px 0;">Our
                                        Clients
                                    </h6>
                                    <div
                                        style="padding:5px;background-color:#fff;border-radius:20px;height:auto;width:100%;">

                                        <div style="display: inline-flex;padding-bottom:5px;">
                                            <div style="height:50px;width:50px;">
                                                <img src="{{ URL::asset('assets/images/email/ac.jpg') }}"
                                                    alt="" class="" style="width:100%;height:100%;">
                                            </div>
                                            <div style="height:50px;width:50px;padding:0 5px">
                                                <img src="{{ URL::asset('assets/images/email/agaram.jpg') }}"
                                                    alt="" class="" style="width:100%;height:100%;">
                                            </div>
                                            <div style="height:50px;width:50px;">
                                                <img src="{{ URL::asset('assets/images/email/avatar.jpg') }}"
                                                    alt="" class="" style="width:100%;height:100%;">
                                            </div>
                                            <div style="height:50px;width:50px;padding:0 5px">
                                                <img src="{{ URL::asset('assets/images/email/avatarlive.jpg') }}"
                                                    alt="" class="" style="width:100%;height:100%;">
                                            </div>
                                            <div style="height:50px;width:50px;">
                                                <img src="{{ URL::asset('assets/images/email/htm.jpg') }}"
                                                    alt="" class="" style="width:100%;height:100%;">
                                            </div>

                                            <div style="height:50px;width:50px;padding:0 5px">
                                                <img src="{{ URL::asset('assets/images/email/indchem.jpg') }}"
                                                    alt="" class="" style="width:100%;height:100%;">
                                            </div>
                                            <div style="height:50px;width:50px;">
                                                <img src="{{ URL::asset('assets/images/email/integra.jpg') }}"
                                                    alt="" class="" style="width:100%;height:100%;">
                                            </div>
                                            <div style="height:50px;width:50px;padding:0 0 0 5px">
                                                <img src="{{ URL::asset('assets/images/email/langro.jpg') }}"
                                                    alt="" class="" style="width:100%;height:100%;">
                                            </div>

                                        </div>
                                        <div style="display: inline-flex;">
                                            <div style="height:50px;width:50px;">
                                                <img src="{{ URL::asset('assets/images/email/mad.jpg') }}"
                                                    alt="" class="" style="width:100%;height:100%;">
                                            </div>
                                            <div style="height:50px;width:50px;padding:0 5px">
                                                <img src="{{ URL::asset('assets/images/email/mrf.jpg') }}"
                                                    alt="" class="" style="width:100%;height:100%;">
                                            </div>
                                            <div style="height:50px;width:50px;">
                                                <img src="{{ URL::asset('assets/images/email/precede.jpg') }}"
                                                    alt="" class="" style="width:100%;height:100%;">
                                            </div>
                                            <div style="height:50px;width:50px;padding:0 5px">
                                                <img src="{{ URL::asset('assets/images/email/priti.jpg') }}"
                                                    alt="" class="" style="width:100%;height:100%;">
                                            </div>
                                            <div style="height:50px;width:50px;">
                                                <img src="{{ URL::asset('assets/images/email/tiic.jpg') }}"
                                                    alt="" class="" style="width:100%;height:100%;">
                                            </div>

                                            <div style="height:50px;width:50px;padding:0 5px">
                                                <img src="{{ URL::asset('assets/images/email/vasa.jpg') }}"
                                                    alt="" class="" style="width:100%;height:100%;">
                                            </div>
                                            <div style="height:50px;width:50px;">
                                                <img src="{{ URL::asset('assets/images/protocol_logo.jpg') }}"
                                                    alt="" class="" style="width:100%;height:100%;">
                                            </div>
                                            <div style="height:50px;width:50px;padding:0 0 0 5px">
                                                <img src="{{ URL::asset('assets/images/email/apollo.jpg') }}"
                                                    alt="" class="" style="width:100%;height:100%;">
                                            </div>

                                        </div>

                                    </div>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <table style="width: 100%;border-collapse:collapse;color:#003056">
                        <tbody>
                            <tr>
                                <td colspan="8" style="padding: 0 26px 12px 26px;">
                                    <table style="border-collapse: collapse;width:100%;">
                                        <tbody>
                                            <tr>
                                                <td class="border-t-blue" style=" border-top: 2px solid #003056;"
                                                    colspan="2">
                                                </td>
                                                <td class="border-t-orange" style="border-top: 2px solid #FF4D00; "
                                                    colspan="2">
                                                </td>
                                                <td class="border-t-blue" style=" border-top: 2px solid #003056;"
                                                    colspan="2">
                                                </td>
                                                <td class="border-t-orange" style="border-top: 2px solid #FF4D00; "
                                                    colspan="2">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>

                            </tr>

                            <tr>
                                <td colspan="4" class="text-center" style="padding:0 4em;">
                                    <p class="text-center"
                                        style="text-align: center;
                                    font-size: 12px;
                                    margin: 0;
                                    padding-top: 10px;color:#003056;">
                                        This e-mail was generated from ABShrms,if you think is
                                        spam,please do report
                                        to
                                    </p>
                                    <a class="text-center" href=" info@abshrms.com"
                                        style="font-size:12px;
                                        text-decoration:none;
                                        color:#FF4D00
                                        ;margin:0;
                                        display:block;
                                        text-align:center;">
                                        info@abshrms.com
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-center" style="padding:1em 4em;">
                                    <div style="text-align:center;">
                                        <a href="https://www.linkedin.com/company/ardenshr-services-private-limited/"
                                            target="_blank" style="color:transparent">
                                            <img src="{{ URL::asset('assets/images/linkedin1.png') }}" alt=""
                                                class="" style="width:24px;height:24px;">
                                        </a>
                                        <a href="https://www.instagram.com/ardenshr/" target="_blank"
                                            style="color:transparent">
                                            <img src="{{ URL::asset('assets/images/instagram.png') }}" alt=""
                                                class="" style="width:24px;height:24px;margin:0 1em;">
                                        </a>
                                        <a href="https://www.facebook.com/ArdensHR" target="_blank"
                                            style="color:transparent">
                                            <img src="{{ URL::asset('assets/images/facebook.png') }}" alt=""
                                                class="" style="width:24px;height:24px;">

                                        </a>
                                        <a href="https://www.youtube.com/channel/UCgZ7XpBoJvcWWvaiBS5GxHg"
                                            target="_blank" style="color:transparent">
                                            <img src="{{ URL::asset('assets/images/youtube.png') }}" alt=""
                                                class="" style="width:24px;height:24px;margin:0 0em 0 1em;">
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="8" class="text-center" style="padding: 5px 0 30px 0px;">
                                    <div class="logo text-center" style="display:block;text-align:center;">
                                        <span style="color:#b6b3b3;margin-right:.3em;font-size:10px;">Generated
                                            by</span>
                                        <img src="{{ URL::asset('assets/images/client_logos/ardens/evangelist.png') }}"
                                            alt="" class="" style="width:100px;height:24px;">
                                        {{-- <img src="{{ URL::asset('assets/images/client_logos/ardens/evangelist.png') }}"
                                            alt="" class="" style="width:130px;height:30px;"> --}}
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>









{{--
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

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

        .padding-t_0 {
            padding-top: 0px;
        }

        .padding-b_0 {
            padding-bottom: 0px;
        }

        .margin-t-b_0 {
            margin-top: 0px;
            margin-bottom: 0px;
        }
        .margin-t_0 {
            margin-top: 0px;

        }
        .padding-t-b_0 {
            padding-bottom: 0px;
            padding-top: 0px;
        }

        .mail-button {
            font-size: 16px;
            text-decoration: none;
            font-weight: 600;
            width: 100px;
            height: 20px;
            padding: 6px 15px;
            background: transparent;
            border-radius: 100px;
            color: #fa9530 !important;
            border: 2px solid #fa9530;

        }

        .mail-button.get-touch:hover {
            background: #fa9530;
            color: #ffffff;

        }
    </style>
</head>


<body>
    <table id="wrapper" cellpadding="0" cellspacing="0" width="552"
        style="max-width:552px; height: auto; margin: 0 auto;   font-size: 14px !important; color: #403e3c; line-height: 24px;table-layout:fixed; width:100%;border:1px solid rgba(44, 43, 43, 0.185);border-radius:5px;padding:10px">
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
                                                <td colspan="4" align="center" class="border-less" style="">

                                                    <p style="font-size:25px;font-weight:600;color:#fa9530;"
                                                        class="margin-t-b_0 ">Get
                                                        Started</p>

                                                    <p>ABShrms would like to invite you to join our organisation's
                                                        employee portal. Using the portal you can access all your
                                                        payroll related information. You can:
                                                        Please change the password immediately after login.

                                                    </p>



                                                </td>

                                            </tr>
                                            <tr>
                                                <td class="padding-t_0" align="center">
                                                    <a href="" class="mail-button get-touch">Get in touch</a>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </td>
                            </tr>


                            <tr>
                                <td class="" align="center">
                                    <table class="" width="400"
                                        style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;padding:20px">
                                        <tbody>

                                            <tr>
                                                <td align="center" class="padding-t-b_0 ">
                                                    <p class="margin-t-b_0 " style="font-size:20px;font-weight:600"
                                                        class="center">Login to
                                                        your account</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <p><span style="color:#fa9530;">Note -</span>Please change the
                                                        password immediately when you login</p>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <p class="margin-t-b_0">Client Name</p>
                                                    <p class="margin-t-b_0"><b>
                                                        @php echo $clientName; @endphp </b></p>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <p class="margin-t-b_0">Employee Code</p>
                                                    <p class="margin-t-b_0"><b>
                                                        @php echo $uEmail; @endphp </b></p>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <p class="margin-t-b_0">Employee Password</p>
                                                    <p class="margin-t_0"><b>
                                                        @php echo $uPassowrd; @endphp </b></p>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="" align="center" style="padding-top: 25px">
                                                    <a  href="{{$loginLink}}"
                                                        class="mail-button log-in">Log In</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td class="padding-t-b_0">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td align="center" style="">
                                                    This e-mail was generated from ABShrms if you think this is
                                                    SPAM,please do report to <a href="info@abshrms.com"
                                                        style="text-decoration: none;color:none;">info<span
                                                            style="color:#fa9530;">@abshrms.com</span></a>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-bottom: 10px;padding-top:10px;">
                                    <table style="text-align:center; width:100%; padding:10px 0px;">
                                        <tbody>
                                            <tr>
                                                <td align="right" colspan="4" style="padding: 0;">
                                                    <a href="#" class="">
                                                        <img src="{{ URL::asset('assets/images/apple_play_store.png') }}"
                                                            alt="" class=""
                                                            style="margin:0px 0px 0px 20px;">
                                                    </a>

                                                </td>
                                                <td align="left" colspan="4" style="padding: 0;">
                                                    <a href="#" class="">
                                                        <img src="{{ URL::asset('assets/images/Google_Play_Store.png') }}"
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
                                                <td align="center" width="100%" style="padding-bottom:0px !important;"
                                                    style="margin-right: 10px">
                                                    <div class="fm-sm-container">
                                                        <a href="https://www.linkedin.com/company/ardenshr-services-private-limited/"
                                                            target="_blank" style="margin-right: 20px"><img
                                                                src="https://abs-website-assets.s3.ap-south-1.amazonaws.com/common-assets/social-media-ic/sm-ic-001.png"
                                                                alt="LinkedIn"></a>
                                                        <a href="https://www.instagram.com/ardenshr/" target="_blank"
                                                            style="margin-right: 20px"><img
                                                                src="https://abs-website-assets.s3.ap-south-1.amazonaws.com/common-assets/social-media-ic/sm-ic-002.png"
                                                                alt="Instagram"></a>
                                                        <a href="https://www.facebook.com/ArdensHR" target="_blank"
                                                            style="margin-right: 20px"><img
                                                                src="https://abs-website-assets.s3.ap-south-1.amazonaws.com/common-assets/social-media-ic/sm-ic-004.png"
                                                                alt="Facebook"></a>
                                                        <a href="https://www.youtube.com/channel/UCgZ7XpBoJvcWWvaiBS5GxHg"
                                                            target="_blank"><img
                                                                src="https://abs-website-assets.s3.ap-south-1.amazonaws.com/common-assets/social-media-ic/sm-ic-003.png"
                                                                alt="Youtube"></a>
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

</html> --}}
