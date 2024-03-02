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
            /* background-color: #fff; */
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
        <table class="pms_mailTemplate" bgcolor="#D0DBF0" style="margin: 0 auto;font-family: 'Poppins', sans-serif;">
            <tr>
                <td colspan="4">
                    <table style="width: 100%;border-collapse:collapse;font-family: 'Poppins', sans-serif;"">
                        <tbody>
                            <tr>
                                <td colspan="2" align="left" class=""
                                    style="padding-bottom:20px;
                               ">
                                    <div class="logo text-center" style="width:100%;height:30px;text-align:left;">
                                        <img src="{{ URL::asset('assets/images/client_logos/ardens/evangelist.png') }}"
                                            alt="" class="" style="width:140px;height:30px;">
                                    </div>
                                </td>
                                <td colspan="2" align="right" class=""
                                    style="padding-bottom:20px;
                         ">
                                    <div class="logo text-center" style="width:100%;height:30px;text-align:right;">
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
                <td colspan="4" align="center" style="border-radius:10px;padding:20px 40px 0">
                    <table class="template_mail"
                        style="width:43em;
                        font-weight:600;
                        border-collapse:collapse;
                        font-family: 'Poppins', sans-serif;">
                        <tbody>


                            <tr>
                                <td colspan="4" style="background-color:#fff; border-radius:1.3em; ">
                                    <div class="inner-content">
                                        <table class="template_mail"
                                            style="font-family: 'Poppins', sans-serif;
                                        padding: 20px 40px;">
                                            <tr>
                                                <td colspan="4" align="center">
                                                    <div class="logo text-center">
                                                        <img src="{{ URL::asset('assets/images/reject_icon.jpg') }}"
                                                            alt="" class=""
                                                            style="width:80px;height:70px;">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" align="">
                                                    <p class="text-center"
                                                        style="font-size:2.3em;margin:0;text-align:center;">Hi <b
                                                            class="" style="font-size:1em">Manoj</b></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" align=""style="padding: 1em 0 0 0;">
                                                    <p class="text-justified"
                                                        style="font-size:13px;margin:0;text-align:justify;padding: 0.2fem 0;">
                                                        This is to inform you that your team member Mr./ Ms. {Employee
                                                        Name} has successfully submitted his/her “Self-Review for{Month
                                                        Name/ Quarter Name/ Half Year Name}
                                                    </p>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="4" align="">
                                                    <p class="text-justified"
                                                        style="font-size:13px;margin:0;text-align:justify;padding: 0.2fem 0;">
                                                        Request you to complete the OKR Manager review against OKR /PMS
                                                        forms using the buttons below
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" align="center" style="padding: 1em 0;">
                                                    <button
                                                        style="cursor:pointer;border-radius: 2em;color:#fff;font-weight:500;background-color:#b19600;padding:.5em 1.5em;font-size:1.3em;border:0"><i
                                                            class="fa fa-check" style="padding-right:.5em"></i>
                                                        Review
                                                    </button>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" align="">
                                                    <p class="text-justified"
                                                        style="font-size:13px;margin:0;text-align:justify;padding: 0.2em 0;">
                                                        Also, kindly have a “Great Conversation” with “Mr. / Ms.Employee
                                                        Name” and Complete the OKR/PMS within the time frame
                                                    </p>
                                                </td>
                                            </tr>


                                            <tr>
                                                <td colspan="4" align="" style="";>
                                                    <p class="text-justified"
                                                        style="font-size:13px;margin:0;text-align:justify;padding: 0.2em 0;">
                                                        Kindly visit the HRMS portal for more details
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="4" style="padding:.8em 0">
                                    <p class="text-center"
                                        style="    margin-bottom: 0;
                                    font-size: 13px;
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
                                        ABSpayroll Automated System.
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
                                    padding-top: 10px;font-weight:600">
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
                                    {{-- <div class="logo text-center" style="display:block;text-align:center;">
                                        <span style="color:#b6b3b3;margin-right:.3em;font-size:10px;">Generated
                                            by</span>
                                        <img src="{{ URL::asset('assets/images/client_logos/ardens/evangelist.png') }}"
                                            alt="" class="" style="width:100px;height:24px;">

                                    </div> --}}

                                    <p
                                        style="font-weight:600;text-align:center;color:#003156;margin: 0;font-size: .7em;">
                                        Copyrights &copy;
                                        <a href="" style="color: #003156;text-decoration:none;">abshrms.com</a>
                                    </p>
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



Email Notification to the Employee, Once the Manager Uploaded their KRA/KPI


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
            /* background-color: #fff; */
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
        <table class="pms_mailTemplate" bgcolor="#D0DBF0" style="margin: 0 auto;font-family: 'Poppins', sans-serif;">
            <tr>
                <td colspan="4">
                    <table style="width: 100%;border-collapse:collapse;font-family: 'Poppins', sans-serif;"">
                        <tbody>
                            <tr>
                                <td colspan="2" align="left" class=""
                                    style="padding-bottom:20px;
                               ">
                                    <div class="logo text-center" style="width:100%;height:30px;text-align:left;">
                                        <img src="{{ URL::asset('assets/images/client_logos/ardens/evangelist.png') }}"
                                            alt="" class="" style="width:140px;height:30px;">
                                    </div>
                                </td>
                                <td colspan="2" align="right" class=""
                                    style="padding-bottom:20px;
                         ">
                                    <div class="logo text-center" style="width:100%;height:30px;text-align:right;">
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
                <td colspan="4" align="center" style="border-radius:10px;padding:20px 40px 0">
                    <table class="template_mail"
                        style="width:43em;
                        font-weight:600;
                        border-collapse:collapse;
                        font-family: 'Poppins', sans-serif;">
                        <tbody>


                            <tr>
                                <td colspan="4" style="background-color:#fff; border-radius:1.3em; ">
                                    <div class="inner-content">
                                        <table class="template_mail"
                                            style="font-family: 'Poppins', sans-serif;
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
                                                        style="font-size:2.3em;margin:0;text-align:center;">Hi <b
                                                            class="" style="font-size:1em">Manoj</b></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" align="">
                                                    <p class="text-justified"
                                                        style="font-size:13px;margin:0;text-align:justify;padding: 0.2fem 0;">
                                                        The purpose of this mail is to inform you that, your respective
                                                        OKR/Goals as well as your reporting manager's expectations and
                                                        directions for {Month Name/ Quarter Name/ Half Year Name}
                                                    </p>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="4" align=""
                                                    style="padding-bottom:1.3em;padding-top:5px;">
                                                    <p class="text-justified"
                                                        style="font-size:13px;margin:0;text-align:justify;padding: 0.2fem 0;">
                                                        Request you to Accept or Reject this OKR/PMS forms using the
                                                        buttons below.
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" align="center">
                                                    <button
                                                        style="border-radius: 2em;color:#fff;font-weight:500;background-color:#47b100;padding:.5em 1.5em;font-size:1.3em;border:0"><i
                                                            class="fa fa-check" style="padding-right:.5em"></i>
                                                        Accept
                                                    </button>

                                                </td>
                                                <td colspan="2" align="center">
                                                    <button
                                                        style="border-radius: 2em;color:#fff;font-weight:500;background-color:#ff0000;padding:.5em 1.5em;font-size:1.3em;border:0"><i
                                                            class="fa fa-check" style="padding-right:.5em"></i>
                                                        Reject
                                                    </button>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" align="" style=" padding-top:1.3em;">
                                                    <p class="text-justified"
                                                        style="font-size:13px;margin:0;text-align:justify;padding: 0.2em 0;">
                                                        Link to be provided
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" align="">
                                                    <p class="text-justified"
                                                        style="font-size:13px;margin:0;text-align:justify;padding: 0.2em 0;">
                                                        We wish you achieve your greatest goals moving forward.
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="4" style="padding:.8em 0">
                                    <p class="text-center"
                                        style="    margin-bottom: 0;
                                    font-size: 13px;
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
                                    padding-top: 10px;font-weight:600">
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
                                    {{-- <div class="logo text-center" style="display:block;text-align:center;">
                                        <span style="color:#b6b3b3;margin-right:.3em;font-size:10px;">Generated
                                            by</span>
                                        <img src="{{ URL::asset('assets/images/client_logos/ardens/evangelist.png') }}"
                                            alt="" class="" style="width:100px;height:24px;">

                                    </div> --}}

                                    <p
                                        style="font-weight:600;text-align:center;color:#003156;margin: 0;font-size: .7em;">
                                        Copyrights &copy;
                                        <a href="" style="color: #003156;text-decoration:none;">abshrms.com</a>
                                    </p>
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


Email Notification to the Manager, Once the Employee Rejected his /her KRA/KPI

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
            /* background-color: #fff; */
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
        <table class="pms_mailTemplate" bgcolor="#D0DBF0" style="margin: 0 auto;font-family: 'Poppins', sans-serif;">
            <tr>
                <td colspan="4">
                    <table style="width: 100%;border-collapse:collapse;font-family: 'Poppins', sans-serif;"">
                        <tbody>
                            <tr>
                                <td colspan="2" align="left" class=""
                                    style="padding-bottom:20px;
                               ">
                                    <div class="logo text-center" style="width:100%;height:30px;text-align:left;">
                                        <img src="{{ URL::asset('assets/images/client_logos/ardens/evangelist.png') }}"
                                            alt="" class="" style="width:140px;height:30px;">
                                    </div>
                                </td>
                                <td colspan="2" align="right" class=""
                                    style="padding-bottom:20px;
                         ">
                                    <div class="logo text-center" style="width:100%;height:30px;text-align:right;">
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
                <td colspan="4" align="center" style="border-radius:10px;padding:20px 40px 0">
                    <table class="template_mail"
                        style="width:43em;
                        font-weight:600;
                        border-collapse:collapse;
                        font-family: 'Poppins', sans-serif;">
                        <tbody>


                            <tr>
                                <td colspan="4" style="background-color:#fff; border-radius:1.3em; ">
                                    <div class="inner-content">
                                        <table class="template_mail"
                                            style="font-family: 'Poppins', sans-serif;
                                        padding: 20px 40px;">
                                            <tr>
                                                <td colspan="4" align="center">
                                                    <div class="logo text-center">
                                                        <img src="{{ URL::asset('assets/images/reject_icon.jpg') }}"
                                                            alt="" class=""
                                                            style="width:80px;height:70px;">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" align="">
                                                    <p class="text-center"
                                                        style="font-size:2.3em;margin:0;text-align:center;">Hi <b
                                                            class="" style="font-size:1em">Manoj</b></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" align=""style="padding: 1em 0 0 0;">
                                                    <p class="text-justified"
                                                        style="font-size:13px;margin:0;text-align:justify;padding: 0.2fem 0;">
                                                        This is to inform you that Mr. / Ms. {Employee Name} has been
                                                        rejected his/ her OKR/ PMS forms due to “{Mentioned the
                                                        rejections reason}”.
                                                    </p>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="4" align="" style="padding: 1em 0;">
                                                    <p class="text-justified"
                                                        style="font-size:13px;margin:0;text-align:justify;padding: 0.2fem 0;">
                                                        Request you to kindly have a “Great Conversation” with “Mr. /
                                                        Mrs. Employee Name” and Complete the OKR/PMS within the time
                                                        frame
                                                    </p>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="4" align="" style="";>
                                                    <p class="text-justified"
                                                        style="font-size:13px;margin:0;text-align:justify;padding: 0.2em 0;">
                                                        Kindly visit the HRMS portal for more details
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="4" style="padding:.8em 0">
                                    <p class="text-center"
                                        style="    margin-bottom: 0;
                                    font-size: 13px;
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
                                        ABSpayroll Automated System.
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
                                    padding-top: 10px;font-weight:600">
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
                                    {{-- <div class="logo text-center" style="display:block;text-align:center;">
                                        <span style="color:#b6b3b3;margin-right:.3em;font-size:10px;">Generated
                                            by</span>
                                        <img src="{{ URL::asset('assets/images/client_logos/ardens/evangelist.png') }}"
                                            alt="" class="" style="width:100px;height:24px;">

                                    </div> --}}

                                    <p
                                        style="font-weight:600;text-align:center;color:#003156;margin: 0;font-size: .7em;">
                                        Copyrights &copy;
                                        <a href="" style="color: #003156;text-decoration:none;">abshrms.com</a>
                                    </p>
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


Email Notification to the Employee, Once the Manager Rejected his /her KRA/KPI

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
            /* background-color: #fff; */
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
        <table class="pms_mailTemplate" bgcolor="#D0DBF0" style="margin: 0 auto;font-family: 'Poppins', sans-serif;">
            <tr>
                <td colspan="4">
                    <table style="width: 100%;border-collapse:collapse;font-family: 'Poppins', sans-serif;"">
                        <tbody>
                            <tr>
                                <td colspan="2" align="left" class=""
                                    style="padding-bottom:20px;
                               ">
                                    <div class="logo text-center" style="width:100%;height:30px;text-align:left;">
                                        <img src="{{ URL::asset('assets/images/client_logos/ardens/evangelist.png') }}"
                                            alt="" class="" style="width:140px;height:30px;">
                                    </div>
                                </td>
                                <td colspan="2" align="right" class=""
                                    style="padding-bottom:20px;
                         ">
                                    <div class="logo text-center" style="width:100%;height:30px;text-align:right;">
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
                <td colspan="4" align="center" style="border-radius:10px;padding:20px 40px 0">
                    <table class="template_mail"
                        style="width:43em;
                        font-weight:600;
                        border-collapse:collapse;
                        font-family: 'Poppins', sans-serif;">
                        <tbody>


                            <tr>
                                <td colspan="4" style="background-color:#fff; border-radius:1.3em; ">
                                    <div class="inner-content">
                                        <table class="template_mail"
                                            style="font-family: 'Poppins', sans-serif;
                                        padding: 20px 40px;">
                                            <tr>
                                                <td colspan="4" align="center">
                                                    <div class="logo text-center">
                                                        <img src="{{ URL::asset('assets/images/reject_icon.jpg') }}"
                                                            alt="" class=""
                                                            style="width:80px;height:70px;">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" align="">
                                                    <p class="text-center"
                                                        style="font-size:2.3em;margin:0;text-align:center;">Hi <b
                                                            class="" style="font-size:1em">Manoj</b></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" align=""style="padding: 1em 0 0 0;">
                                                    <p class="text-justified"
                                                        style="font-size:13px;margin:0;text-align:justify;padding: 0.2fem 0;">
                                                        This is to inform you that, Mr. / Ms. {Employee Name} (Line
                                                        Manager) has rejected your OKR/ PMS forms due to “{Mentioned the
                                                        rejections reason}”.
                                                    </p>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="4" align="" style="padding: 1em 0;">
                                                    <p class="text-justified"
                                                        style="font-size:13px;margin:0;text-align:justify;padding: 0.2fem 0;">
                                                        Request you to kindly have a “Great Conversation” with “Mr. /
                                                        Mrs. Manager Name” and Complete the OKR/PMS within the time
                                                        frame
                                                    </p>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="4" align="" style="";>
                                                    <p class="text-justified"
                                                        style="font-size:13px;margin:0;text-align:justify;padding: 0.2em 0;">
                                                        Kindly visit the HRMS portal for more details
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="4" style="padding:.8em 0">
                                    <p class="text-center"
                                        style="    margin-bottom: 0;
                                    font-size: 13px;
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
                                        ABSpayroll Automated System.
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
                                    padding-top: 10px;font-weight:600">
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
                                    {{-- <div class="logo text-center" style="display:block;text-align:center;">
                                        <span style="color:#b6b3b3;margin-right:.3em;font-size:10px;">Generated
                                            by</span>
                                        <img src="{{ URL::asset('assets/images/client_logos/ardens/evangelist.png') }}"
                                            alt="" class="" style="width:100px;height:24px;">

                                    </div> --}}

                                    <p
                                        style="font-weight:600;text-align:center;color:#003156;margin: 0;font-size: .7em;">
                                        Copyrights &copy;
                                        <a href="" style="color: #003156;text-decoration:none;">abshrms.com</a>
                                    </p>
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


{{-- Accepted employee to manager--}}

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
            /* background-color: #fff; */
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
        <table class="pms_mailTemplate" bgcolor="#D0DBF0" style="margin: 0 auto;font-family: 'Poppins', sans-serif;">
            <tr>
                <td colspan="4">
                    <table style="width: 100%;border-collapse:collapse;font-family: 'Poppins', sans-serif;"">
                        <tbody>
                            <tr>
                                <td colspan="2" align="left" class=""
                                    style="padding-bottom:20px;
                               ">
                                    <div class="logo text-center" style="width:100%;height:30px;text-align:left;">
                                        <img src="{{ URL::asset('assets/images/client_logos/ardens/evangelist.png') }}"
                                            alt="" class="" style="width:140px;height:30px;">
                                    </div>
                                </td>
                                <td colspan="2" align="right" class=""
                                    style="padding-bottom:20px;
                         ">
                                    <div class="logo text-center" style="width:100%;height:30px;text-align:right;">
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
                <td colspan="4" align="center" style="border-radius:10px;padding:20px 40px 0">
                    <table class="template_mail"
                        style="width:43em;
                        font-weight:600;
                        border-collapse:collapse;
                        font-family: 'Poppins', sans-serif;">
                        <tbody>


                            <tr>
                                <td colspan="4" style="background-color:#fff; border-radius:1.3em; ">
                                    <div class="inner-content">
                                        <table class="template_mail"
                                            style="font-family: 'Poppins', sans-serif;
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
                                                        style="font-size:2.3em;margin:0;text-align:center;">Hi <b
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
                                <td colspan="4" style="padding:.8em 0">
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
                                        ABSparroll Automated System.
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
                                    padding-top: 10px;font-weight:600">
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
                                    {{-- <div class="logo text-center" style="display:block;text-align:center;">
                                        <span style="color:#b6b3b3;margin-right:.3em;font-size:10px;">Generated
                                            by</span>
                                        <img src="{{ URL::asset('assets/images/client_logos/ardens/evangelist.png') }}"
                                            alt="" class="" style="width:100px;height:24px;">

                                    </div> --}}

                                    <p style="font-weight:600;text-align:center;color:#003156;margin: 0;font-size: .7em;">Copyrights &copy;
                                        <a href="" style="color: #003156;text-decoration:none;">abshrms.com</a>
                                    </p>
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
                                                        <b>{{ $employeeName }}</b> ” and Complete the OKR/PMS within
                                                        the
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
