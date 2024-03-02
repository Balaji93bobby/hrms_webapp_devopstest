<?php
$client_data = \DB::table('vmt_client_master')->first();
//$employee_name =  \DB::table('users')->where('user_code','=',$employee->EMP_NO)->first('name');
$client_logo = request()->getSchemeAndHttpHost() . '' . $client_data->client_logo;
// dd(request()->getSchemeAndHttpHost()."".$general_info->client_logo);
$bank_names = \DB::table('vmt_banks')->get();

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
    padding: 8px;
" class="mr-3">
        <table class="pms_mailTemplate w-full" bgcolor="#D0DBF0"
            style="margin: 0 auto;font-family: 'Poppins', sans-serif;border-collapse:collapse;width:620px;">
            <tr>
                <td colspan="8">
                    <table
                        style="width: 100%;border-collapse:collapse;font-family: 'Poppins', sans-serif;color:#003056;">
                        <tbody>
                            <tr>
                                <td colspan="8"
                                    style="padding: 20px 30px 10px 30px;display:flex !important;justify-content:space-between ;align-items:center;
                               "
                                    class=" ">
                                    <div class="logo text-center  border" style="width:100%;height:30px;">
                                        <img src="{{ URL::asset('assets/images/client_logos/ardens/evangelist.png') }}"
                                            alt="" class="" style="width:140px;height:30px;">
                                    </div>
                                    <div class=" float-right">
                                        <img class=" border-orange-300 float-right" src="{{ URL::asset($image_view) }}" alt=""
                                            style="width:120px;height:30px;">
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
                <td colspan="8" style="padding: 10px 0 0 0">
                    <table style="width: 100%;color:#003056;border-collapse:collapse;">
                        <tbody style="text-align: center">
                            <tr>
                                <td colspan="8">
                                    <div style="text-align: center">

                                        <h6 style="margin:0;font-size:18px;color:#003056;">Login
                                            to your account
                                        </h6>

                                        <p style="padding:5px 0;margin:0;" class=""><span
                                                style="color: #FF4D00">Note</span>
                                            <span>-</span> Please change
                                            the password immediately when you login
                                        </p>
                                        <div style="display:flex !important; width:100%; justify-content:center !important; align-items:center !important;padding-top:10px;padding-left:100px"
                                            class=" ">

                                            <div style="border-right:1px solid #003056; padding:0 15px 5px 15px  ">
                                                <p style="margin:0;">
                                                    Employee Code
                                                </p>
                                                <p style="padding:5px 0;margin: 0;color:#FF4D00;font-weight:600;">
                                                    @php echo $uEmail; @endphp </b></p>
                                                </p>
                                            </div>
                                            <div style="border-right:1px solid #003056 ; padding:0 15px 5px 15px  ">
                                                <p style="margin: 0;">Employee Password </p>
                                                <p style="padding:5px 0;margin: 0;color:#FF4D00;font-weight:600;">
                                                    @php echo $uPassowrd; @endphp </b></p>
                                                </p>
                                            </div>
                                            <div style=" padding:0 15px 5px 15px ;">
                                                <p style="margin: 0;"> Client Code </p>
                                                <p style="padding:5px 0;margin: 0;color:#FF4D00;font-weight:600;">
                                                    @php echo $client_code; @endphp </b></p>
                                                </p>
                                            </div>


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
                                        "
                                                href="{{ $loginLink }}/login" class="mail-button log-in">Login
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
                                        <a href="https://www.youtube.com/channel/UCgZ7XpBoJvcWWvaiBS5GxHg"
                                            target="_blank" style="color:transparent">
                                            <img src="{{ URL::asset('assets/images/email/twitter.png') }}" alt=""
                                                class="" style="width:24px;height:24px;margin:0 0em 0 1em;">
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="8" class="text-center" style="padding: 5px 0 30px 0px;">
                                    <div class="logo text-center" style="display:block; text-align:center; ">
                                        <span
                                            style="color:#003056;margin-right:.3em; font-size:12px; display:flex;padding: 0 238px; align-items:center !important; ">Copyrights
                                            <span style="color:#003056;margin:0 0.3em;font-size:12px;">&copy;</span>
                                            <a class="text-center" href="{{ $loginLink }}/login"
                                                style="font-size:12px;
                                        text-decoration:none;
                                        color:#003056;
                                        display:block;
                                        text-align:center;">abshrms.com
                                            </a>
                                        </span>


                                        {{-- <img src="{{ URL::asset('assets/images/client_logos/ardens/evangelist.png') }}" --}}
                                        {{-- alt="" class="" style="width:100px;height:24px;"> --}}
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

