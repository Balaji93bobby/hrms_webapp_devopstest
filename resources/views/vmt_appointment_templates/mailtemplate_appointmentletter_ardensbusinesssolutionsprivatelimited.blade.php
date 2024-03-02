<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>

    <style>
        table.annexure-table tr.bg-ash {
            background-color: #d0d0d0;
        }

        .main-page.view-policy {
            min-height: 200px;
        }

        table.annexure-table tr td {

            height: 25px;
            padding: 2px;
        }


        @page {
            size: A4;
            margin: 0;
        }

        @media print {

            html,
            body {
                width: 210mm;
                height: 297mm;
            }


        }



        .border-less {
            border: 0px !important;
        }



        .fw-600 {
            font-weight: 600;
        }

        table.letter-format tr td,
        table.letter-format tr,
        table.letter-format tr td p,
        table.letter-format tr td ul {
            border: 0;
            font-size: 14px;
            text-align: justify;
        }

        p.a {
            text-align: justify !important;
        }

        .pt-pb-5 {
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .pt-15 {
            padding-top: 15px;
        }

        .pt-20 {
            padding-top: 20px;
        }

        .pt-pb-20 {
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .pt-pb-10 {
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .pt-pb-15 {
            padding-top: 15px;
            padding-bottom: 15px;
        }

        .pt-10 {
            padding-top: 10px;
        }

        .pt-30 {
            padding-top: 30px;
        }

        .pb-10 {
            padding-bottom: 10px;
        }

        .pb-30 {
            padding-bottom: 30px;
        }

        .pt-5 {
            padding-top: 5px !important;
        }
        .pt-pb-5{
            padding-top: 5px !important;
            padding-bottom: 5px !important;
        }



        .border-bottom-line {
            border-bottom: 1px solid !important;
        }

        .txt-left {
            text-align: left !important;
        }

        .txt-right {
            text-align: right !important;
        }

        .txt-center {
            text-align: center !important;
        }

        .txt-justify {
            text-align: justify !important;
        }


        th,
        td {
            height: 30px;
        }

        .appointment-letter table p {
            margin: 0px !important;
            text-align: justify;
        }
    </style>
</head>

<body>

    <div class="main-page appointment-letter">
        <div class="sub-page" style="padding:0px;">
            <tr>
                <td>
                    <div class="logo" style="width:inherit;height:100px;">
                        <img src="{{ URL::asset('assets/images/header.jpg') }}" alt="header-label" class=""
                            style="height:100%;width:100%;">
                    </div>
                </td>
            </tr>
            <table class="letter-format" style="padding:0;">
                <tbody>

                    <tr>
                        <td align="center" style="padding:0px 1cm;">
                            <table class="letter-format">
                                <tbody>
                                    <tr>
                                        <td colspan="12" align="right">
                                            <p class="txt-right">
                                                <b>
                                                    Date:{{ $doj }}
                                                </b>
                                            </p>

                                        </td>

                                    </tr>
                                    <tr>
                                        <td colspan="12" align="center">

                                            <p class="txt-center">
                                                <b class="border-bottom-line">WELCOME
                                                    NOTE</b>

                                            </p>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" style=" " align="left">
                                            <p>Dear <span class="fw-600"> {{ $employee_name }}</span>
                                            </p>
                                            <p class="pt-20">
                                                Congratulations and welcome to ABS Family! We
                                                are delighted to have you as part of our
                                                organization. Your role and association with us
                                                are critical in fulfilling the mission of our
                                                organization. We hope, our association will be
                                                professionally meaningful and mutually
                                                beneficial. You join a group of our 1,500 +
                                                Associate Workers (AW) deputed to our various
                                                clients, in order to partner in their business
                                                success.
                                            </p>
                                            <p class=" pt-pb-10">
                                                Thank you for the information and documentation
                                                provided to ease your on­boarding process. You
                                                can continue to use our online portal to access
                                                and download your monthly payslips, edit
                                                personal details, and download forms required
                                                for registering your employment for various
                                                statutory benefits. The next few pages will give
                                                you more information on your employment with us.
                                            </p>
                                            <p class=" ">
                                                For any queries, please feel free to contact the
                                                ABS Help Desk. The facility is currently
                                                available Monday through Friday, 9:30 am to 6:30
                                                pm. You may contact the Help Desk through one of
                                                the two methods below:
                                            </p>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" class="pt-pb-20">
                                            <p class="txt-left"><img
                                                    src="{{ URL::asset('assets/images/list_style.png') }}"
                                                    alt="" style="padding-right:10px;height:10px;width:10px ">
                                                Log in to <a style="padding-left:2px;text-decoration:none;"
                                                    href="ess.abshrms.com"> ess.abshrms.com</a>

                                            </p>
                                            <p class="txt-left pt-5 "><img
                                                    src="{{ URL::asset('assets/images/list_style.png') }}"
                                                    alt="" style="padding-right:10px;height:10px;width:10px ">
                                                Email us at <a style="padding-left:2px;text-decoration:none;"
                                                    href="payroll@ardens.in">payroll@ardens.in</a>
                                            </p>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" style=" " align="left">
                                            <p class="txt-left a">
                                                <b>Our Core Values:</b>
                                                Our core values are the framework of our
                                                commitment to the client. We developed a 6P
                                                model resuming our core values. It’s good to
                                                know that every ABS employee continues to keep
                                                to and live by these values today. They are
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" align="left">

                                            <ol style="list-style: none">

                                                <li>
                                                    <p class="">
                                                        <img src="{{ URL::asset('assets/images/list_style.png') }}"
                                                            alt=""
                                                            style="padding-right:10px;height:10px;width:10px ">
                                                        <b>Professionalism:</b>
                                                        Our staff expertise responds to high
                                                        complex
                                                        needs
                                                    </p>

                                                </li>
                                                <li>

                                                    <p class="txt-left pt-pb-20  ">
                                                        <img src="{{ URL::asset('assets/images/list_style.png') }}"
                                                            alt=""
                                                            style="padding-right:10px;height:10px;width:10px ">
                                                        <b>Proximity:</b>
                                                        Build open relationships with clients
                                                    </p>
                                                </li>
                                                <li>

                                                    <p class="txt-left ">
                                                        <img src="{{ URL::asset('assets/images/list_style.png') }}"
                                                            alt=""
                                                            style="padding-right:10px;height:10px;width:10px ">
                                                        <b>Proactivity: </b>
                                                        Not only follow the customer demand but
                                                        anticipate and customize intelligent
                                                        solutions
                                                    </p>
                                                </li>
                                                <li>


                                                    <p class="txt-left pt-pb-20 ">
                                                        <img src="{{ URL::asset('assets/images/list_style.png') }}"
                                                            alt=""
                                                            style="padding-right:10px;height:10px;width:10px ">
                                                        <b>Proficiency: </b>
                                                        High standards, ability to use
                                                        innovative
                                                        technology to meet client’s expectations
                                                    </p>
                                                </li>
                                                <li>

                                                    <p class="txt-left">
                                                        <img src="{{ URL::asset('assets/images/list_style.png') }}"
                                                            alt=""
                                                            style="padding-right:10px;height:10px;width:10px ">
                                                        <b>People: </b>
                                                        Finally, payroll is all about people.
                                                        Our
                                                        experts focus their activity to deliver
                                                        accurate
                                                        pay sheets and rapports to facilitate
                                                        the
                                                        employee’s life.
                                                    </p>
                                                </li>
                                                <li>

                                                    <p class="txt-left pt-20 ">
                                                        <img src="{{ URL::asset('assets/images/list_style.png') }}"
                                                            alt=""
                                                            style="padding-right:10px;height:10px;width:10px ">
                                                        <b>Progress: </b>
                                                        Innovation is at the core of our
                                                        business
                                                    </p>
                                                </li>

                                            </ol>


                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12"align="left">
                                            <p class="txt-left pt-10">
                                                I wish you all the very best as you embark on an
                                                exciting journey with ABS while enhancing your
                                                professional stature, along the way.
                                            </p>
                                            <p class="txt-left " style="padding-top:25px;">
                                                <b>For Ardens Business Solutions Private
                                                    Limited</b>
                                            </p>

                                            <p style="padding:8px 0px;">
                                                <img src="{{ URL::asset('assets/images/augustin_sign.png') }}"
                                                    alt="" class="" style="height:60px;width:140px;">
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" style="" align="left">
                                            <p class="txt-left">
                                                <b>Augustin Raj A</b>
                                            </p>
                                            <p class="txt-left">
                                                <b>Managing Director & CEO </b>
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>



                </tbody>

            </table>
            <tr>
                <td colspan="12">
                    <div class="logo" style="width:inherit;height:100px;padding-top:53px;">
                        <img src="{{ URL::asset('assets/images/abs_footer-label.jpg') }}" alt="footer-label"
                            class="" style="height:100%;width:100%;">
                    </div>
                </td>
            </tr>
        </div>

    </div>


    <div class="main-page appointment-letter">
        <div class="sub-page" style="padding:0px;">
            <tr>
                <td>
                    <div class="logo" style="width:inherit;height:100px;">
                        <img src="{{ URL::asset('assets/images/header.jpg') }}" alt="header-label" class=""
                            style="height:100%;width:100%;">
                    </div>
                </td>
            </tr>
            <table class="letter-format">
                <tbody>

                    <tr>
                        <td align="center" style="padding:0.3cm 1cm 0 1cm;">
                            <table class="letter-format">
                                <tbody>
                                    <tr>
                                        <td colspan="12" align="right" class="pt-pb-20">
                                            <p class="fw-600 txt-right">
                                                Date: {{ $doj }}
                                            </p>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" align="center">
                                            <p class="fw-600 txt-center">LETTER OF APPOINTMENT</p>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" align="" class="pt-pb-20">

                                            <p class=" txt-left">
                                                Dear <b>{{ $employee_name }},</b>
                                            </p>


                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="12" align="" class=" ">

                                            <p class="txt-justify ">
                                                We are glad to appoint you as “ <b>:{{ $designation }}</b> ” in
                                                our company, Ardens
                                                Business Solutions Private Limited.
                                            </p>
                                            <p class="pt-pb-20 txt-justify ">
                                                <b> Remuneration:</b>
                                                Your total remuneration package (CTC) per annum
                                                is Rs. {{ $cic }}/- per annum (Rupees
                                                 {{ $ctc_in_words }} Only). The
                                                break-up of your compensation package shall be
                                                as
                                                detailed in Annexure A

                                            </p>
                                            <p class=" txt-justify ">
                                                <b> Commencement:</b>
                                                Your employment with the company Ardens Business Solutions Private
                                                Limited will be with effect from {{ $doj }}. You shall
                                                initially be
                                                placed in Chennai. You may however be required to travel and may be
                                                positioned or deputed outside within India or abroad.
                                            </p>

                                            <p class="pt-pb-20 txt-justify ">
                                                <b> Rules and Regulations: </b>
                                                You shall be governed by the policies of the company as specified in
                                                Annexure B. You shall serve the Company and shall carry out such duties
                                                which will be explained and defined by your manager (immediate
                                                superior), subject always to the employee policy and the rules and
                                                regulations of the Company. Your employment shall continue to be
                                                governed by the terms of this appointment letter in the event of you
                                                being deputed or positioned outside India.
                                            </p>
                                            <p class="pt-20 pb-10 txt-justify ">
                                                <b> Reporting</b>
                                            </p>
                                            <p>
                                                You will report to “Executive Director – Kanchana VG”.
                                            </p>
                                            <p class="pt-pb-20">
                                                We welcome you to our team. We are confident that you will make an
                                                effective contribution to the growth of the company and will enjoy
                                                working with us.
                                            </p>
                                            <p class="">
                                                You will be under probation for a period of six months. Your
                                                confirmation will be based on the evaluation during the end of the
                                                probation period.
                                            </p>

                                            <p class="pt-pb-20">
                                                If you are agreeable to the terms and conditions of the appointment
                                                (Annexure B), then kindly confirm your acceptance of the appointment by
                                                signing and returning to us the attached copy of this letter.
                                            </p>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12"align="left">
                                            <p class="txt-left  ">
                                                Yours truly,
                                            </p>
                                            <p class="txt-left pt-10">
                                                <b>For Ardens Business Solutions Private
                                                    Limited</b>
                                            </p>
                                            <p style="padding:8px 0px;">
                                                <img src="{{ URL::asset('assets/images/augustin_sign.png') }}"
                                                    alt="" class="" style="height:60px;width:140px;">
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" style="" align="left">
                                            <p class="txt-left">
                                                <b>Augustin Raj A</b>
                                            </p>
                                            <p class="txt-left">
                                                <b>Managing Director & CEO </b>
                                            </p>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </td>
                    </tr>


                </tbody>
            </table>
            <tr>
                <td>
                    <div class="logo" style="width:inherit;height:100px;padding-top:73px;">
                        <img src="{{ URL::asset('assets/images/abs_footer-label.jpg') }}" alt="footer-label"
                            class="" style="height:100%;width:100%;">
                    </div>
                </td>
            </tr>
        </div>
    </div>

    <div class="main-page appointment-letter">

        <div class="sub-page" style="padding:0px;">
            <tr>
                <td>
                    <div class="logo" style="width:fit-content;height:100px;">
                        <img src="{{ URL::asset('assets/images/header.jpg') }}" alt="header-label" class=""
                            style="height:100%;width:100%;">
                    </div>
                </td>
            </tr>
            <table style="width:100%">
                <tbody>

                    <tr>
                        <td style="padding:1cm " colspan="3">
                            <table border="1" align="center" class="annexure-table"
                                style="border-collapse: collapse;width: 100%;">
                                <tr class="">
                                    <td colspan="3" align="center" class=" fw-600">
                                        Annexure A
                                    </td>

                                </tr>
                                <tr class="">
                                    <td colspan="3" align="center" class="fw-600">
                                        Assingment Details
                                    </td>

                                </tr>
                                <tr class="">
                                    <td colspan="3" align="center" class="fw-600">
                                        Your remuneration shall be paid to you under the following heads
                                    </td>

                                </tr>
                                <tr class="bg-ash">
                                    <td colspan="1" align="left"><b>Employee
                                            Name:{{ $employee_name }}</b>
                                    </td>
                                    <td colspan="2" style="" align="center">
                                        <b>
                                            Salary
                                        </b>
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="1" align="left"><b>Designation:{{ $designation }}</b>
                                    </td>
                                    <td colspan="1" style="" align="center">
                                        <b>
                                            Per Month
                                        </b>
                                    </td>

                                    <td colspan="1" style="" align="center">
                                        <b>
                                            Per Annum
                                        </b>
                                    </td>
                                </tr>


                                <tr>
                                    <td colspan="1">Basic</td>
                                    <td colspan="1" align="right"><img height="8.5" width="12"
                                            src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                            alt="" style="padding-right:0px;">{{ $basic_monthly }}
                                    <td colspan="1" align="right"><img height="8.5" width="12"
                                            src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                            alt="" style="padding-right:0px;">{{$basic_yearly  }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="1">HRA</td>
                                    <td colspan="1" align="right"><img height="8.5" width="12"
                                            src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                            alt="" style="padding-right:0px;"> {{ $hra_monthly }}</td>
                                    <td colspan="1" align="right"><img height="8.5" width="12"
                                            src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                            alt="" style="padding-right:0px;">{{ $hra_yearly }}</td>
                                </tr>
                                <tr>
                                    <td colspan="1">Child Education Allowance</td>
                                    <td colspan="1" align="right"><img height="8.5" width="12"
                                            src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                            alt="" style="padding-right:0px;">-</td>
                                    <td colspan="1" align="right"><img height="8.5" width="12"
                                            src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                            alt="" style="padding-right:0px;">-
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="1">Leave Travel Allowance</td>
                                    <td colspan="1" align="right"><img height="8.5" width="12"
                                            src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                            alt="" style="padding-right:0px;">-</td>
                                    <td colspan="1" align="right"><img height="8.5" width="12"
                                            src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                            alt="" style="padding-right:0px;">-</td>
                                </tr>
                                <tr>
                                    <td colspan="1">Food Allowance</td>
                                    <td colspan="1" align="right"><img height="8.5" width="12"
                                            src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                            alt="" style="padding-right:0px;">-</td>
                                    <td colspan="1" align="right"><img height="8.5" width="12"
                                            src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                            alt="" style="padding-right:0px;">-</td>
                                </tr>
                                <tr>
                                    <td colspan="1">Special Allowance</td>
                                    <td colspan="1" align="right"><img height="8.5" width="12"
                                            src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                            alt=""
                                            style="padding-right:0px;">{{ $spl_allowance_monthly }}</td>
                                    <td colspan="1" align="right"><img height="8.5" width="12"
                                            src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                            alt=""
                                            style="padding-right:0px;"> {{ $spl_allowance_yearly }}</td>
                                </tr>
                                <tr class="bg-ash">
                                    <td colspan="1" class="fw-600">Gross Salary</td>
                                    <td colspan="1" align="right"><img height="8.5" width="12"
                                            src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                            alt="" style="padding-right:0px;">{{ $gross_monthly }}
                                    </td>
                                    <td colspan="1" align="right"><img height="8.5" width="12"
                                            src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                            alt="" style="padding-right:0px;">  {{ $gross_yearly }}
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="1">PF (Employer Contribution)</td>
                                    <td colspan="1" align="right"><img height="8.5" width="12"
                                            src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                            alt=""
                                            style="padding-right:0px;"> {{ $employer_epf_monthly }}</td>
                                    <td colspan="1" align="right"><img height="8.5" width="12"
                                            src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                            alt=""
                                            style="padding-right:0px;">{{ $employer_epf_yearly }}</td>
                                </tr>
                                <tr>
                                    <td colspan="1">ESI (Employer Contribution)</td>
                                    <td colspan="1" align="right"><img height="8.5" width="12"
                                            src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                            alt=""
                                            style="padding-right:0px;">{{ $employer_esi_monthly}} </td>
                                    <td colspan="1" align="right"><img height="8.5" width="12"
                                            src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                            alt=""
                                            style="padding-right:0px;">{{ $employer_esi_yearly }}</td>
                                </tr>
                                <tr class="bg-ash">
                                    <td colspan="1" class=" "><b>Cost to Company</b></td>
                                    <td colspan="1" class="" align="right"><img height="8.5"
                                            width="12" src="{{ URL::asset('assets/images/inr_png.png') }}"
                                            class="txt-right" alt=""
                                            style="padding-right:0px;">{{ $ctc_monthly }}</td>
                                    <td colspan="1" class="" align="right"><img height="8.5"
                                            width="12" src="{{ URL::asset('assets/images/inr_png.png') }}"
                                            class="txt-right" alt=""
                                            style="padding-right:0px;">{{ $ctc_yearly }}</td>
                                </tr>
                                <tr>
                                    <td colspan="1">
                                        PF (Employee Contribution)
                                    </td>
                                    <td colspan="1" align="right"><img height="8.5" width="12"
                                            src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                            alt=""
                                            style="padding-right:0px;">{{ $employee_epf_monthly }}</td>
                                    <td colspan="1" align="right">{{ $employee_epf_yearly }}</td>
                                </tr>
                                <tr>
                                    <td colspan="1">ESI (Employee Contribution)</td>
                                    <td colspan="1" align="right"><img height="8.5" width="12"
                                            src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                            alt=""
                                            style="padding-right:0px;">{{ $employee_esi_monthly }}</td>
                                    <td colspan="1" align="right"><img height="8.5" width="12"
                                            src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                            alt=""
                                            style="padding-right:0px;"> {{ $employee_esi_yearly }}</td>
                                </tr>
                                <tr>
                                    <td colspan="1">Prof. Tax</td>
                                    <td colspan="1" align="right"><img height="8.5" width="12"
                                            src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                            alt=""
                                            style="padding-right:0px;"> {{ $employer_pt_monthly  }}
                                            </td>
                                    <td colspan="1" align="right"><img height="8.5" width="12"
                                            src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                            alt=""
                                            style="padding-right:0px;">{{ $employer_pt_yearly  }}</td>
                                </tr>
                                <tr class="bg-ash">
                                    <td colspan="1" class=""><b>Net home</b></td>
                                    <td colspan="1" class="a" align="right"><img height="8.5"
                                            width="12" src="{{ URL::asset('assets/images/inr_png.png') }}"
                                            class="txt-right" alt=""
                                            style="padding-right:0px;">{{ $net_take_home_monthly }}
                                            </td>
                                    <td colspan="1" class="a" align="right"><img height="8.5"
                                            width="12" src="{{ URL::asset('assets/images/inr_png.png') }}"
                                            class="txt-right" alt=""
                                            style="padding-right:0px;">{{ $net_take_home_yearly }}</td>
                                </tr>
                                <tr class="">
                                    <td colspan="3" align="center">Income Tax as applicable will be deducted</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 1cm " colspan="3">
                            <table style="width:100%" class="letter-format">
                                <tbody>
                                    <tr>
                                        <td colspan="3">
                                            <p>
                                                I <b>{{ $employee_name }}</b>, have read ANNEXURE A & B,
                                                understood and accept the
                                                appointment upon the terms and conditions as outlined in this
                                                appointment letter for my position at Ardens Business Solutions Privat
                                                Limited
                                            </p>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="padding-top: 1cm;" align="left">
                                            <span class=" fw-600">
                                                Signature:
                                            </span>
                                        </td>
                                        <td colspan="1" style="padding-top: 1cm;" align="center">
                                            <span class=" fw-600">
                                                Date:
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <tr>
                <td>
                    <div class="logo" style="width:inherit;height:100px;padding-top:129px;">
                        <img src="{{ URL::asset('assets/images/abs_footer-label.jpg') }}" alt="footer-label"
                            class="" style="height:100%;width:100%;">
                    </div>
                </td>
            </tr>
        </div>
    </div>

    <div class="main-page appointment-letter">

        <div class="sub-page" style="padding:0px;">
            <tr>
                <td>
                    <div class="logo" style="width:inherit;height:100px;">
                        <img src="{{ URL::asset('assets/images/header.jpg') }}" alt="header-label" class=""
                            style="height:100%;width:100%;">
                    </div>

                </td>
            </tr>
            <table class="letter-format" style="padding:0;">
                <tbody>

                    <tr>
                        <td align="center" style="padding:1cm 1cm 0;">
                            <table class="letter-format">
                                <tbody>
                                    <tr>
                                        <td colspan="12" style="" align="left">
                                            <p class="txt-left ">
                                                <b class="" style="border-bottom:1px solid #000">General Terms &
                                                    Conditions :</b>
                                            </p>
                                            <ol class="txt-justify">
                                                <li>
                                                    <p class="txt-left a pt-10">
                                                        You will have to provide signed copies
                                                        of
                                                        all
                                                        documents and forms in the joining kit
                                                        including
                                                        the signed appointment letter to Ardens
                                                        Business
                                                        Solutions Private Ltd. (ABS) within a
                                                        period
                                                        of
                                                        30 days from your date of joining. The
                                                        documents
                                                        can be either couriered or handed over
                                                        in
                                                        person
                                                        at the designated ABS offices. You will
                                                        not
                                                        be
                                                        eligible for payroll in the subsequent
                                                        months if
                                                        these documents are not received within
                                                        the
                                                        30-day period from your date of joining.
                                                    </p>
                                                </li>
                                                <li>
                                                    <p class="txt-left a pt-pb-15">
                                                        ABS is working towards having a safe
                                                        transaction
                                                        mode for all payments and follows the
                                                        practice
                                                        of remitting salary, reimbursement, F&F,
                                                        and
                                                        other payments directly to your
                                                        designated
                                                        bank
                                                        account. You are required hereby to
                                                        confirm
                                                        your
                                                        acceptance of the same and provide your
                                                        Bank
                                                        Account details with proof (cancelled
                                                        cheque
                                                        or
                                                        copy of bank passbook or bank statement)
                                                        within
                                                        15 days of the date of joining to ABS
                                                        personnel
                                                        at the designated ABS offices or send an
                                                        e­mail
                                                        with a scanned copy of the proofs
                                                        mentioned
                                                        to
                                                        <a href="payroll@ardens.in">payroll@ardens.in</a>
                                                        mentioning "bank account details" in the
                                                        subject
                                                        line of the mail.
                                                    </p>
                                                </li>
                                                <li>
                                                    <p class="txt-left a">
                                                        You will have to provide your PAN card
                                                        details
                                                        within 15 days of your date of joining.
                                                    </p>

                                                    <ol style="list-style: none">
                                                        <li>
                                                            <ul type="circle">

                                                                <li>
                                                                    <p class="txt-left  pt-pb-15">
                                                                        In case, you don’t have
                                                                        a PAN
                                                                        card, you
                                                                        will
                                                                        have to apply and
                                                                        provide the
                                                                        acknowledgment
                                                                        copy within 15 days from
                                                                        the
                                                                        date of
                                                                        joining.
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p class="txt-left ">
                                                                        In case you do not
                                                                        provide PAN
                                                                        card
                                                                        details
                                                                        and
                                                                        your income falls under
                                                                        the
                                                                        taxable
                                                                        limits,
                                                                        you
                                                                        will be paid your
                                                                        monthly salary
                                                                        after
                                                                        the
                                                                        deduction of taxes as
                                                                        per the
                                                                        existing
                                                                        tax
                                                                        laws.
                                                                    </p>

                                                                </li>
                                                            </ul>



                                                        </li>
                                                    </ol>
                                                </li>
                                                <li>
                                                    <p class="txt-left  pt-pb-15">
                                                        Your pay slips will be available online for
                                                        viewing, downloading, and printing. This is
                                                        a
                                                        digitally generated document and does not
                                                        require a physical signature for
                                                        verification.
                                                        The pay slip will be available at the end of
                                                        the
                                                        first week of the month and will be deemed
                                                        to
                                                        have been received and accepted by you. For
                                                        any
                                                        clarifications or queries, regarding the
                                                        same,
                                                        you can send an email to <a
                                                            href="payroll@ardens.in">payroll@ardens.in</a>
                                                        referencing your ABS employee ID. </p>

                                                </li>
                                                <li>
                                                    <p class="txt-left ">
                                                        In case of any reimbursable components
                                                        in
                                                        your
                                                        salary structure, you will be required
                                                        to
                                                        submit
                                                        necessary proofs of payments and bills
                                                        for
                                                        the
                                                        same, failing which the payments will be
                                                        made
                                                        after the deduction of appropriate
                                                        taxes.
                                                    </p>
                                                </li>
                                                <li>
                                                    <p class="txt-left pt-pb-15">
                                                        If you are eligible for ESIC benefits
                                                        and have
                                                        an existing ESIC number, please inform
                                                        in
                                                        advance through the ESIC nomination form
                                                        in your
                                                        joining kit to retain the existing ESIC
                                                        number.
                                                        For PF transfer from an existing PF
                                                        account, you
                                                        will need to fill and submit the PF
                                                        transfer
                                                        form in your joining kit.
                                                    </p>
                                                </li>
                                                <li>
                                                    <p class="txt-left   ">
                                                        ABS do not accept or retain any original
                                                        certificates/ documents pertaining to
                                                        your
                                                        educational and other qualifications.
                                                        You may be
                                                        required to produce the same for
                                                        verification
                                                        purposes only if requested by authorized
                                                        ABS
                                                        personnel.
                                                    </p>
                                                </li>
                                                <li>
                                                    <p class="txt-left pt-pb-15">
                                                        You will have to complete all the exit
                                                        formalities and hand over any assets
                                                        including
                                                        but not limited to ID cards, laptops,
                                                        mobiles,
                                                        etc. in your custody before your Last
                                                        Working
                                                        Day (LWD) in the organization. Your Full
                                                        & Final
                                                        Settlement (F&F) will be completed only
                                                        if the
                                                        exit formalities are done on time, which
                                                        shall
                                                        not exceed 45 days.
                                                    </p>
                                                </li>
                                                <li>
                                                    <p class="txt-left ">
                                                        Your F&F settlement amount will be
                                                        transferred
                                                        to the bank account used for your salary
                                                        transactions. In case, there are dues to
                                                        be
                                                        recovered from you in the F&F
                                                        settlement, you
                                                        will be issued your relieving letter and
                                                        experience letters only on clearance of
                                                        these
                                                        dues.
                                                    </p>

                                                </li>
                                            </ol>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </td>
                    </tr>

                </tbody>

            </table>
            <tr>
                <td>
                    <div class="logo" style="width:inherit;height:100px;padding-top:104px">
                        <img src="{{ URL::asset('assets/images/abs_footer-label.jpg') }}" alt="footer-label"
                            class="" style="height:100%;width:100%;">
                    </div>
                </td>
            </tr>
        </div>

    </div>

    <div class="main-page appointment-letter">

        <div class="sub-page" style="padding:0;">
            <tr>
                <td>
                    <div class="logo" style="width:inherit;height:100px;">
                        <img src="{{ URL::asset('assets/images/header.jpg') }}" alt="header-label" class=""
                            style="height:100%;width:100%;">
                    </div>

                </td>
            </tr>
            <table class="letter-format" style="">
                <tbody>

                    <tr>


                        <td align="center" style="padding: 1cm">
                            <table class="letter-format">
                                <tbody>
                                    <tr>
                                        <td colspan="12">

                                            <p class="txt-left">
                                                As a token of your acceptance of the
                                                above terms
                                                and conditions, you are requested to
                                                sign the
                                                duplicate copy of this letter and return
                                                to us.
                                            </p>


                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="12"align="left">
                                            <p class="txt-left pt-30 ">
                                                Yours faithfully,
                                            </p>
                                            <p class="txt-left">
                                                <b>For Ardens Business Solutions Private
                                                    Limited</b>
                                            </p>
                                            <p style="padding:8px 0px;">
                                                <img src="{{ URL::asset('assets/images/augustin_sign.png') }}"
                                                    alt="" class="" style="height:60px;width:140px;">
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" style="" align="left">
                                            <p class="txt-left">
                                                <b>Augustin Raj A</b>
                                            </p>
                                            <p class="txt-left">
                                                <b>Managing Director & CEO </b>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" align="left">
                                            <hr style="border: 2px solid #757575f5;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" style="padding-top: 0cm;" align="left">
                                            <p>
                                                I <b> {{ $employee_name }}</b>, have understood and
                                                accepted the appointment upon the terms and
                                                conditions as outlined in this appointment
                                                letter for my position at Ardens Business
                                                Solutions Privat Limited
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" style="padding-top: 1cm;" align="left">
                                            <span class=" fw-600">
                                                Signature:
                                            </span>
                                        </td>
                                        <td colspan="4" style="padding-top: 1cm;" align="center">
                                            <span class=" fw-600">
                                                Date:
                                            </span>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </td>
                    </tr>



                </tbody>

            </table>
            <tr>
                <td>
                    <div class="logo" style="width:inherit;height:100px;padding-top:482px">
                        <img src="{{ URL::asset('assets/images/abs_footer-label.jpg') }}" alt="footer-label"
                            class="" style="height:100%;width:100%;">
                    </div>
                </td>
            </tr>
        </div>

    </div>
    <div class="main-page appointment-letter">

        <div class="sub-page" style="padding:0px;">
            <tr>
                <td>
                    <div class="logo" style="width:fit-content;height:100px;">
                        <img src="{{ URL::asset('assets/images/header.jpg') }}" alt="header-label" class=""
                            style="height:100%;width:100%;">
                    </div>
                </td>
            </tr>
            <table class="letter-format" style="">
                <tbody>

                    <tr>
                        <td align="center" style="padding:0 1cm;">
                            <table class="letter-format txt-justify">
                                <tbody>
                                    <tr>
                                        <td colspan="12" align="center">
                                            <p class="fw-600 txt-center pb-10" style="">
                                                Annexure 2:
                                            </p>
                                            <p class="fw-600 txt-center pb-30" style="">
                                                HEALTH AND SAFETY POLICY
                                            </p>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" style=" " align="left">
                                            <p class="fw-600  ">
                                                Introduction
                                            </p>
                                            <p class="txt-justify pt-10">
                                                ABS recognizes people as its most important
                                                asset and is committed to ensuring a safe and
                                                healthy work environment for all its employees
                                                and people visiting its premises. ABS’s
                                                Corporate Policy necessitates a specific Health
                                                & Safety Policy for its outsourced employees.
                                                Given that our AWS a redeputed to various client
                                                sites, where each clients Health & Safety Policy
                                                would be different, it is our commitment to
                                                ensure that our AWs have safe working
                                                conditions, where risks if any, are well managed
                                                and our clients treat all our AWs as they would
                                                treat their direct employees in matters of
                                                health & safety.
                                            </p>
                                            <p class="txt-justify pt-10">
                                                This document is to be read and thoroughly
                                                understood by all ABS AWs at the time of joining
                                                an assignment; it requires them to be aware of
                                                the policy and our recommendations for safe
                                                working practices
                                            </p>
                                            <p class="txt-justify pt-10">
                                                We assure that we will not depute an AW to a
                                                client site, which causes an Occupational Hazard
                                                or risk to Health. We will only work with
                                                clients who are aligned to our Health & Safety
                                                Policy for AWs. Additionally, we advise our AWs
                                                and employees to bring to our notice, situations
                                                that an AW might encounter and could be a
                                                potential health & safety issue.
                                            </p>
                                            <p class="txt-justify pt-10">
                                                We also ask our AWs not to endanger themselves
                                                or their colleagues at work by violating any
                                                safety rules, and to comply with workplace
                                                instructions besides ensuring that they wear
                                                Personal Protective Equipment where advised. Our
                                                AWs are asked not to interfere with or misuse
                                                anything provided for their safety, health and
                                                welfare. This is a condition of employment with
                                                ABS. Management reviews will be held each year
                                                to review implementation of this policy and draw
                                                upon further improvements for the following
                                                year. These improvements will include the policy
                                                itself and the associated business processes to
                                                attain objective of this policy.
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" style=" " align="left">
                                            <p class="pt-10 fw-600">
                                                Health & Safety Policy:
                                            </p>
                                            <p class=" pt-10">
                                                Health & Safety in the work place is every ones
                                                responsibility. ABS regards promotion of Health
                                                & Safety measures as a mutual objective for the
                                                management and employees, including deputed
                                                employees. ABS has factored in statutory
                                                requirements while arriving at this Health &
                                                Safety Policy.
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" style=" " align="left">
                                            <p class="fw-600 pt-10">
                                                General Safety:
                                            </p>

                                            <ol class="txt-justify">
                                                <li class="">Ensure that you are aware of
                                                    your own
                                                    responsibilities in respect of relevant
                                                    health, safety and environmental matters.
                                                </li>
                                                <li style="" class="pt-pb-10">Follow
                                                    instructions the way it is meant to be. Use
                                                    entries and exits, lifts in the manner it is
                                                    meant to be.</li>
                                                <li style="" class="">Ensure you
                                                    have
                                                    your AW ID card on your person at all times
                                                    with your photograph, ABS contact details
                                                    and Nos. displayed in a clear manner.</li>
                                                <li style="" class="pt-pb-10    ">If you have
                                                    a
                                                    visitor, ensure your visitor signs in and
                                                    receives a security pass. Do not take your
                                                    visitor into the client premises without
                                                    permission.</li>


                                                <li class="">

                                                    You
                                                    will not
                                                    enter your work premises while under the
                                                    influence of alcohol, drugs or any
                                                    substance
                                                    which may endanger your health or safety
                                                    and/or that of any other person
                                                </li>
                                                <li class="pt-pb-10">

                                                    of fact
                                                    that many things which may be obvious
                                                    get
                                                    overlooked while working. Thus,
                                                    appropriate
                                                    care and concentration is required at
                                                    work
                                                    to ensure general safety.
                                                </li>
                                            </ol>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" class="" style=" " align="left">
                                            <p class="txt-left ">
                                                <b>Fire Safety:</b>
                                            </p>
                                            <ol class="txt-justify">
                                                <li class="">Ensure familiarity with the
                                                    fire safety
                                                    procedures in work place. Most organizations
                                                    have fire safety training as a statutory
                                                    requirement. Ensure you attend the same,
                                                    after seeking necessary permission from your
                                                    reporting manager.</li>
                                                <li style="" class="pt-pb-10">Understand
                                                    different kinds of firefighting equipment’s
                                                    installed at your work place.</li>

                                            </ol>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>


                </tbody>

            </table>
            <tr>
                <td>
                    <div class="logo" style="width:inherit;height:100px;padding-top:18px">
                        <img src="{{ URL::asset('assets/images/abs_footer-label.jpg') }}" alt="footer-label"
                            class="" style="height:100%;width:100%;">
                    </div>

                </td>
            </tr>
        </div>

    </div>
    <div class="main-page appointment-letter">
        <div class="sub-page" style="padding:0cm">
            <tr>
                <td>
                    <div class="logo" style="width:fit-content;height:100px;">
                        <img src="{{ URL::asset('assets/images/header.jpg') }}" alt="header-label" class=""
                            style="height:100%;width:100%;">
                    </div>
                </td>
            </tr>

            <table class="letter-format" style="padding:0px;margin:0px;">
                <tbody>

                    <tr>
                        <td align="center" style="padding:0cm 1cm 0cm  1cm">
                            <table class="letter-format">
                                <tbody>
                                    <tr>
                                        <td class="" colspan="">
                                            <ol start="3" class="txt-justify">
                                                <li style="" class="">Please
                                                    become
                                                    familiar to the sound of the fire alarm and
                                                    know the emergency/fire exits. These are not
                                                    normal entry/exits. These exits are signed
                                                </li>
                                                <li style="" class="pt-10">Attend fire
                                                    drill if any at your work place and undergo
                                                    evacuation training.</li>
                                                <li style="" class="pt-10">Avoid taking
                                                    personal risks; do not try to tackle fire on
                                                    your own.</li>
                                            </ol>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" style=" " align="left">
                                            <p class="txt-left a">
                                                <b>Accident & First Aid:</b>
                                            </p>
                                            <p class="txt-left a pt-10">
                                                Familiarize yourself with the First Aid
                                                arrangements at your workplace. Do not leave
                                                vehicles or items relating to your work in
                                                places other than that which is designated. This
                                                will help prevent accidents.
                                            </p>

                                            <ol class="txt-justify">
                                                <li class="">Follow rules on speed limit
                                                    and wearing
                                                    safety gear as is prescribed at the work
                                                    environment that you are at.</li>
                                                <li style="" class="pt-pb-5">If your
                                                    office
                                                    premises require you to wear a helmet while
                                                    entering or exiting, comply with the same.
                                                </li>
                                                <li style="" class="">In the event
                                                    of
                                                    an accident, do not handle it on your own;
                                                    follow procedures that you may have been
                                                    trained in; inform the facilities manager or
                                                    emergency numbers provided.</li>
                                                <li style="" class="pt-pb-5">Understand
                                                    accident report procedures at your work
                                                    site.</li>
                                                <li style="" class="">Always let
                                                    someone know, where you are going and your
                                                    expected time of return.</li>
                                            </ol>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" style=" " align="left">
                                            <p class="txt-left fw-600 a">
                                                As a ABS AW, you have the right to:
                                            </p>

                                            <ol class="txt-justify">
                                                <li class="pt-5">Work in places where all the
                                                    risks to your
                                                    health and safety are properly controlled.
                                                </li>
                                                <li style="" class="pt-pb-5">If your
                                                    office
                                                    premises require you to wear a helmet while
                                                    entering or exiting, comply with the same.
                                                </li>
                                                <li style="" class="">To stop
                                                    working
                                                    and leave the area if you think you are in
                                                    danger.</li>
                                                <li style="" class="pt-pb-5">To stop
                                                    working
                                                    and leave the area if you think you are in
                                                    danger.</li>
                                            </ol>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" style=" " align="left">
                                            <p class=" fw-600 a">
                                                Recommendations for Common Safe Working
                                                Practices:
                                            </p>

                                            <ol class="txt-justify">
                                                <li class="pt-5">Do not smoke in areas
                                                    prohibited.</li>
                                                <li style="" class="pt-pb-5">Do not
                                                    expose
                                                    electric conduits/plugs/sockets to water.
                                                </li>
                                                <li style="" class="">If your work
                                                    requires you to lift weight frequently,
                                                    understand load management procedures at
                                                    work.</li>
                                                <li style="" class="pt-pb-5">Do not
                                                    operate
                                                    machinery unless you have been trained and
                                                    authorized to do so.</li>

                                                <li class="">
                                                    If you use tools as part of your work use
                                                    only the right and authorized tools.

                                                </li>
                                                <li class="pt-pb-5 ">
                                                    Report any Health and Safety incidents
                                                    whether they result in injury or not to your
                                                    respective ABS anchor.
                                                </li>
                                                <li class="pb-10 ">
                                                    Cooperate in the investigation of accidents
                                                    with the objective of introducing measures
                                                    to prevent a recurrence.
                                                </li>
                                            </ol>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12"align="left">
                                            <p class="txt-left">
                                                <b>For Ardens Business Solutions Private
                                                    Limited</b>
                                            </p>
                                            <p style="padding:8px 0px;">
                                                <img src="{{ URL::asset('assets/images/augustin_sign.png') }}"
                                                    alt="" class="" style="height:60px;width:140px;">
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" style="" align="left">
                                            <p class="txt-left">
                                                <b>Augustin Raj A</b>
                                            </p>
                                            <p class="txt-left">
                                                <b>Managing Director & CEO </b>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12">
                                            <p>
                                                I <b>{{ $employee_name }}</b>, have read ANNEXURE A & B,
                                                understood and accept the
                                                appointment upon the terms and conditions as outlined in this
                                                appointment letter for my position at Ardens Business Solutions Privat
                                                Limited
                                            </p>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="7"  align="left" class="pt-pb-10">
                                            <span class=" fw-600">
                                                Signature:
                                            </span>
                                        </td>
                                        <td colspan="5"  align="center" class="pt-pb-10">
                                            <span class=" fw-600">
                                                Date:
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </td>
                    </tr>
                </tbody>
            </table>

            <tr>
                <td>
                    <div class="logo" style="width:fit-content;height:100px;padding-top:12px;">
                        <img src="{{ URL::asset('assets/images/abs_footer-label.jpg') }}" alt="footer-label"
                            class="" style="height:100%;width:100%;">
                    </div>
                </td>
            </tr>
        </div>
    </div>

</body>

</html>
