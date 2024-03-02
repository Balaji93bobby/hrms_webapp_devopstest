<?php

$general_info = \DB::table('vmt_client_master')->first();
//$employee_name =  \DB::table('users')->where('user_code','=',$employee->EMP_NO)->first('name');
$client_logo = request()->getSchemeAndHttpHost() . '' . $general_info->client_logo;

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
    <div style="display:flex;justify-content: center;">
        <table class="pms_mailTemplate" style="margin: 0 auto;font-family: 'Poppins', sans-serif;">
            <tr>
                <td colspan="4">
                    <table style="width: 100%;border-collapse:collapse;font-family: 'Poppins', sans-serif;"">
                        <tbody>
                            <tr>
                                <td colspan="4" class="text-center"
                                    style="padding-bottom:20px;
                                text-align: center;">
                                    <div class="logo text-center" style="width:100%;height:30px;">
                                        <img src="{{ URL::asset('assets/images/client_logos/ardens/evangelist.png') }}"
                                            alt="" class="" style="width:140px;height:30px;">
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="border-t-blue" style=" border-top: 2px solid #003056;" colspan="1">
                                </td>
                                <td class="border-t-orange" style="border-top: 2px solid #FF4D00; " colspan="1">
                                </td>
                                <td class="border-t-blue" style=" border-top: 2px solid #003056;" colspan="1">
                                </td>
                                <td class="border-t-orange" style="border-top: 2px solid #FF4D00; " colspan="1">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="border-radius:10px;padding:20px 40px 0">
                    <table class="template_mail"
                        style="width:500px;
                        border-collapse:collapse;
                        font-family: 'Poppins', sans-serif;">
                        <tbody>


                            <tr>
                                <td colspan="4">
                                    <div class="inner-content">
                                        <table class="template_mail"
                                            style="font-family: 'Poppins', sans-serif;    border: 1px solid #e7e7e7;
                                        border-radius: 20px;
                                        padding: 20px 40px;">

                                            <tr>
                                                <td colspan="4" align="">
                                                    <p class="text-center"
                                                        style="font-size:40px;margin:0;text-align:center;">Hi <b
                                                            class="" style="font-size:1em">
                                                            {{ $employeeName }}</b>
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" align="">
                                                    <p class="text-justified"
                                                        style="font-size:14px;margin:0;text-align:justify;">
                                                        This is to provide you with an update on your recent loan request, Request ID: {{ $requestID }}.
                                                    </p>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="4" align=""
                                                    style="padding-bottom:10px;padding-top:5px;">
                                                    <p class="text-justified"
                                                        style="font-size:14px;margin:0;text-align:justify;">
                                                        After careful consideration, we regret to inform you that your loan request has been {{ $approvalStatus }}. The decision was made based on the reason mentioned in the below.
                                                    </p>
                                                </td>
                                            </tr>

                                            {{-- <tr>
                                                <td colspan="4" align=""
                                                    style="padding-bottom:5px;padding-top:10px;">
                                                    <p class="text-justified"
                                                        style="font-size:14px;margin:0;text-align:justify;">
                                                        Also, kindly have a “Great Conversation” with “Mr. / Ms.
                                                        <b>{{ $employeeName }}</b> ” and Complete the OKR/PMS within the
                                                        time frame.
                                                    </p>
                                                </td>
                                            </tr> --}}
                                            <tr>
                                                <td colspan="4" align="">
                                                    <p class="text-justified"
                                                        style="font-size:14px;margin:0;text-align:justify;">
                                                        Kindly visit the HRMS portal for more details <a
                                                            class="text-center" href={{ $link }}
                                                            style="font-size:12px;
                                                        text-decoration:none;
                                                        color:#FF4D00
                                                        ;margin:0;
                                                        display:block;
                                                        text-align:center;">
                                                            click here
                                                            {{-- HRMS LINK to be Provided --}}
                                                        </a>
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="4">
                                    <p class="text-center"
                                        style="    margin-bottom: 0;
                                    font-size: 14px;
                                    text-align:center;">
                                        Cheers,
                                    </p>
                                    <p class="text-center"
                                        style="font-size: 18px;
                                    color: #FF4D00;
                                    padding-bottom: 0.5em;
                                    text-align:center;
                                    font-weight: 600;
                                    margin:0;">
                                        ABS_OKR Automated System.
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="4">
                    <table style="width: 100%;border-collapse:collapse;">
                        <tbody>
                            <tr>
                                <td class="border-t-blue" style=" border-top: 2px solid #003056" colspan="1">
                                </td>
                                <td class="border-t-orange" style="border-top: 2px solid #FF4D00 " colspan="1"
                                    style="padding-bottom:.5em"></td>
                                <td class="border-t-blue" style=" border-top: 2px solid #003056" colspan="1">
                                </td>
                                <td class="border-t-orange" style="border-top: 2px solid #FF4D00 " colspan="1"
                                    style="padding-bottom:.5em"></td>
                            </tr>

                            <tr>
                                <td colspan="4" class="text-center" style="padding:0 4em;">
                                    <p class="text-center"
                                        style="text-align: center;
                                    font-size: 12px;
                                    margin: 0;
                                    padding-top: 10px;">
                                        This e-mail was generated from ABShrms,if you think is spam,please do report
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
                                <td colspan="4" class="text-center">
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
