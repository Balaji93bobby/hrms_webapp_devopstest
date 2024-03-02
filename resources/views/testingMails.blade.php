{{-- employee welcome mail --}}

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
                                <td colspan="8"
                                    style="padding: 20px 30px 10px 30px;
                               ">
                                    <div class="logo text-center" style="width:100%;height:30px;">
                                        <img src="{{ URL::asset('assets/images/client_logos/ardens/evangelist.png') }}"
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

                                        <p style="padding:5px 0;margin:0;"><span style="color: #FF4D00">Note</span>
                                            <span>-</span> Please change
                                            the password immediately when you login
                                        </p>
                                        <div style="padding-bottom:5px ">
                                            <p style="margin:0;">
                                                Employee Code
                                            </p>
                                            <p style="padding:5px 0;margin: 0;color:#FF4D00;font-weight:600;"> @php echo $uEmail; @endphp </b></p></p>
                                        </div>
                                        <div style="padding-bottom:5px ">
                                            <p style="margin: 0;">Employee Password </p>
                                            <p style="padding:5px 0;margin: 0;color:#FF4D00;font-weight:600;"> @php echo $uPassowrd; @endphp </b></p>
                                        </p>
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
                                        "  href="{{ $loginLink }}/login"
                                                        class="mail-button log-in">Login
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












{{-- client welcome mail  --}}


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
                                <td colspan="8"
                                    style="padding: 20px 30px 10px 30px;
                               ">
                                    <div class="logo text-center" style="width:100%;height:30px;">
                                        <img src="{{ URL::asset('assets/images/client_logos/ardens/evangelist.png') }}"
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
                                                8+</h5>
                                            <p style="margin: 0;color: #003056;">
                                                cities
                                            </p>
                                        </div>

                                        <div style="padding: 0 10px 0 10px;text-align:center">
                                            <h5
                                                style="font-size: 15px;
                                                margin:0;
                                        color: #ff3900;">
                                                10+</h5>
                                            <p style="margin: 0;color: #003056;text-align:center">
                                                Partners
                                            </p>
                                        </div>
                                        <div style="padding: 0 10px 0 10px;text-align:center">
                                            <h5
                                                style="font-size: 15px;margin:0;
                                        color: #ff3900;">
                                                42+</h5>
                                            <p style="margin: 0;color: #003056;">
                                                Clients Served
                                            </p>
                                        </div>
                                        <div style="padding: 0 10px 0 10px;text-align:center">
                                            <h5
                                                style="font-size: 15px;margin:0;
                                            color: #ff3900;">
                                                100+</h5>
                                            <p style="margin: 0;color: #003056;">
                                                Entrepreneurs
                                                Served
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
                                         style="margin:0;font-size:18px;color:#003056;">Login
                                            to your account
                                        </h6>

                                        <p style="padding:5px 0;margin:0;"><span style="color: #FF4D00">Note</span>
                                            <span>-</span> Please change
                                            the password immediately when you login
                                        </p>
                                        <div style="padding-bottom:5px ">
                                            <p style="margin:0;">
                                                Client Code
                                            </p>
                                            <p style="padding:5px 0;margin: 0;color:#FF4D00;font-weight:600;">EMP</p>
                                        </div>
                                        <div style="padding-bottom:5px ">
                                            <p style="margin: 0;">Client Password </p>
                                            <p style="padding:5px 0;margin: 0;color:#FF4D00;font-weight:600;">EMP</p>
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


{{-- pms --}}


{{-- Accepted --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">


    <style>
        .pms_mailTemplate {
            border-radius: 1em;
            padding: 2em;
            text-align: justify;
        }


        .template_mail {
            width: 100%;
        }


        @page {
            size: A4;
        }


        .pms_mailTemplate {
            width: 100%;
            border: 0;
            background-color: #fff;
            /* white-space: nowrap; */
            font-size: .9em;
        }

        .pms_mailTemplate .inner-content {
            /* box-shadow: rgba(0, 0, 0, 0.15) 0px 2px 8px; */
            box-shadow: rgba(17, 17, 26, 0.1) 0px 4px 16px, rgba(17, 17, 26, 0.1) 0px 8px 24px, rgba(17, 17, 26, 0.1) 0px 16px 56px;
            width: 100%;
            height: auto;
            border-radius: 1em;
        }


        .pms_mailTemplate td {
            border: 0;
            whhite-space: nowrap;
        }

        .text-bolder {
            font-weight: 700;
        }

        .text-center {
            text-align: center;
        }

        .text-rignt {
            text-align: right;
        }

        .text-justified {
            text-align: justify;
        }

        .border-t-b {
            border-top: 1px solid #b6b3b3 !important;
            border-bottom: 1px solid #b6b3b3 !important;
        }

        .border-b {
            border-bottom: 1px solid #b6b3b3 !important;
        }

        .p-t-b {
            padding-top: .8em;
            padding-bottom: .8em;
        }

        .p-t-b-1.5 {
            padding-top: 1.5em;
            padding-bottom: 1.5em;
        }

        .p-b-1.5 {
            padding-bottom: 1.5em;
        }

        .margin-0: {
            margin: 0;
        }

        .border-t-blue {
            border-top: .3em solid #003056 !important;
        }

        .border-t-orange {
            border-top: .3em solid #FF4D00 !important;
        }
    </style>
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
                                                <td colspan="4" align="center">
                                                    <div class="logo text-center">
                                                        <img src="{{ URL::asset('assets/images/accp_icon.jpg') }}"
                                                            alt="" class=""
                                                            style="width:80px;height:70px;">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" align="">
                                                    <p class="text-center"
                                                        style="font-size:40px;margin:0;text-align:center;">Hi <b
                                                            class="" style="font-size:1em">Manoj</b></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" align="">
                                                    <p class="text-justified"
                                                        style="font-size:14px;margin:0;text-align:justify;">
                                                        This is to inform you that Mr. / Ms. {Employee Name} has
                                                        accepted his/
                                                        her
                                                        OKR/ PMS forms
                                                    </p>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="4" align=""
                                                    style="padding-bottom:10px;padding-top:5px;">
                                                    <p class="text-justified"
                                                        style="font-size:14px;margin:0;text-align:justify;">
                                                        Request you to kindly have a “Great Conversation” with “Mr.
                                                        / Mrs.
                                                        Employee
                                                        Name” and Complete the OKR/PMS within the time frame.
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" align="">
                                                    <p class="text-justified"
                                                        style="font-size:14px;margin:0;text-align:justify;">
                                                        Kindly visit the HRMS portal for more details HRMS LINK to
                                                        be Provided
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



{{-- self review --}}

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
                                                        This is to inform you that your team member Mr./ Ms. <b>
                                                            {{ $employeeName }}</b> has successfully submitted his/her
                                                        “Self-Review for<b>{{ $appraisal_period }} </b>
                                                    </p>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="4" align=""
                                                    style="padding-bottom:10px;padding-top:5px;">
                                                    <p class="text-justified"
                                                        style="font-size:14px;margin:0;text-align:justify;">
                                                        Request you to complete the OKR Manager review against OKR /PMS
                                                        forms using the buttons below.
                                                    </p>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="4" align="">
                                                    <a role="button" href="{{ $loginLink }}/team-appraisal"
                                                        style="font-weight: 600;
                                                        color: #fff;
                                                        border-radius: 50px;
                                                        background-color: #ffaf03;
                                                        border: 1px solid #ccc;
                                                        padding: 8px 40px;
                                                        text-decoration: none;
                                                        ">
                                                        Review
                                                    </a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="4" align=""
                                                    style="padding-bottom:5px;padding-top:10px;">
                                                    <p class="text-justified"
                                                        style="font-size:14px;margin:0;text-align:justify;">
                                                        Also, kindly have a “Great Conversation” with “Mr. / Ms.
                                                        <b>{{ $employeeName }}</b> ” and Complete the OKR/PMS within the
                                                        time frame.
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" align="">
                                                    <p class="text-justified"
                                                        style="font-size:14px;margin:0;text-align:justify;">
                                                        Kindly visit the HRMS portal for more details <a
                                                            class="text-center" href=" info@abshrms.com"
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




{{-- approve and reject --}}

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
                                                        This is to inform you that your team member Mr./ Ms. <b>
                                                            {{ $employeeName }}</b> has successfully submitted his/her
                                                        “Self-Review for<b>{{ $appraisal_period }} </b>
                                                    </p>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="4" align=""
                                                    style="padding-bottom:10px;padding-top:5px;">
                                                    <p class="text-justified"
                                                        style="font-size:14px;margin:0;text-align:justify;">
                                                        Request you to complete the OKR Manager review against OKR /PMS
                                                        forms using the buttons below.
                                                    </p>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="2" align="left">
                                                    <a role="button" href="{{ $login_Link }}/employee-appraisal"
                                                        style="font-weight: 600;
                                                        color: #fff;
                                                        border-radius: 50px;
                                                        background-color: #14a701;
                                                        border: 1px solid #ccc;
                                                        padding: 8px 40px;
                                                        text-decoration: none;
                                                        ">
                                                        Approve
                                                    </a>
                                                </td>
                                                <td colspan="2" align="right">
                                                    <a role="button"    href="{{ $login_Link }}/employee-appraisal"
                                                        style="font-weight: 600;
                                                        color: #fff;
                                                        border-radius: 50px;
                                                        background-color: #ff2500;
                                                        border: 1px solid #ccc;
                                                        padding: 8px 40px;
                                                        text-decoration: none;
                                                        ">
                                                        Reject
                                                    </a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="4" align=""
                                                    style="padding-bottom:5px;padding-top:10px;">
                                                    <p class="text-justified"
                                                        style="font-size:14px;margin:0;text-align:justify;">
                                                        Also, kindly have a “Great Conversation” with “Mr. / Ms.
                                                        <b>{{ $employeeName }}</b> ” and Complete the OKR/PMS within the
                                                        time frame.
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" align="">
                                                    <p class="text-justified"
                                                        style="font-size:14px;margin:0;text-align:justify;">
                                                        Kindly visit the HRMS portal for more details <a
                                                            class="text-center" href=" info@abshrms.com"
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
