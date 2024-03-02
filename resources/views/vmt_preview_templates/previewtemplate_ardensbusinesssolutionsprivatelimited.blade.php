@extends('layouts.master')
@section('title')
    @lang('translation.settings')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/css/preview_template.css') }}" rel="stylesheet">
    <style>
        table.arderns_salaryTable {
            font-size: 13px !important;
        }

        table.arderns_salaryTable tr td,
        table.arderns_salaryTable tr {
            border: 1px solid #000 !important;
            padding: 0px 10px;
        }

        table {
            width: 100%;
            vertical-align: middle;

        }


        .border-less {
            border: 0px !important;
        }

        tr {
            height: 12.55pt;
        }

        td {
            width: 81.35pt
        }


        .margin-0 {
            margin: 0px;
        }

        .main-page img {
            display: revert !important;
        }

        .payslip_table tr p,
        .payslip_table td p {
            font-size: 9pt;
            margin-top: 3pt;
            margin-bottom: 3pt;
            padding: 0px 5px;
        }

        .header-row {
            height: 50px;
        }

        .payslip_table tr .bg-ash,
        .payslip_table td .bg-ash {
            background-color: #9e9e9e5c;
        }
    </style>
@endsection
@section('content')
    <div class="template-wrapper">
        <div class="card  left-line mb-2 ">
            <div class="card-body pb-0 pt-1">
                <ul class="nav nav-pills    nav-tabs-dashed" id="pills-tab" role="tablist">
                    <li class="nav-item  ember-view me-4" role="presentation">
                        <a class="nav-link active ember-view " id="pills-home-tab" data-bs-toggle="pill" href=""
                            data-bs-target="#appointment" role="tab" aria-controls="pills-home" aria-selected="true">
                            Appointment Letter</a>
                    </li>
                    <li class="nav-item ember-view" role="presentation ">
                        <a class="nav-link ember-view" id="payslips-tab" data-bs-toggle="pill" data-bs-target="#payslips"
                            type="button" role="tab" aria-controls="payslips" aria-selected="false">Pay Slip</a>
                    </li>
                </ul>

            </div>

        </div>


        <div class="card">
            <div class="tab-content " id="pills-tabContent">
                <div class="tab-pane fade show active" id="appointment" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div id="carousel_template" class="carousel slide" data-bs-touch="false" data-bs-interval="false">
                        <div class="carousel-inner">
                            <div class="carousel-item active ">
                                <div class="main-page appointment-letter">

                                    <div class="sub-page" style="padding:0px;">
                                        <table class="letter-format" style="padding:0;">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="logo" style="width:100%;height:100px;">
                                                            <img src="{{ URL::asset('assets/images/header.jpg') }}"
                                                                alt="" class=""
                                                                style="height:100px;width:100%;">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>

                                                    <td align="center" style="padding:0px 1cm;">
                                                        <table class="table-one">
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="12" align="right">
                                                                        <p class="fw-600 txt-right">
                                                                            Date:dd-mm-yyyy
                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="12" align="center">
                                                                        <p class="fw-600 txt-center " style="">
                                                                            <span class="border-bottom-line">WELCOME
                                                                                NOTE</span>
                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="12" style=" " align="left">
                                                                        <p class="txt-left pt-30">
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
                                                                        <p class="txt-left pt-10">
                                                                            Thank you for the information and documentation
                                                                            provided to ease your on­boarding process. You
                                                                            can continue to use our online portal to access
                                                                            and download your monthly payslips, edit
                                                                            personal details, and download forms required
                                                                            for registering your employment for various
                                                                            statutory benefits. The next few pages will give
                                                                            you more information on your employment with us.
                                                                        </p>
                                                                        <p class="txt-left pt-10">
                                                                            For any queries, please feel free to contact the
                                                                            ABS Help Desk. The facility is currently
                                                                            available Monday through Friday, 9:30 am to 6:30
                                                                            pm. You may contact the Help Desk through one of
                                                                            the two methods below:
                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="my-3">
                                                                        <ol style="list-style: none">

                                                                            <li class="my-2">
                                                                                <img src="{{ URL::asset('assets/images/list_style.png') }}"
                                                                                    alt=""
                                                                                    style="padding-right:10px ">
                                                                                <span> Log in to </span><a
                                                                                    href="ess.abshrms.com">ess.abshrms.com</a>
                                                                            </li>
                                                                            <li class="my-2">
                                                                                <img src="{{ URL::asset('assets/images/list_style.png') }}"
                                                                                    alt=""
                                                                                    style="padding-right:10px ">
                                                                                <span> Email</span>
                                                                                us at <a
                                                                                    href="payroll@ardens.in">payroll@ardens.in</a>
                                                                            </li>

                                                                        </ol>
                                                                    </td>
                                                                </tr>
                                                                <tr class="">
                                                                    <td colspan="12" class="my-4" style=" "
                                                                        align="left">
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

                                                                        <ol style="list-style: none" class="">

                                                                            <li>
                                                                                <p class="pt-10">
                                                                                    <img src="{{ URL::asset('assets/images/list_style.png') }}"
                                                                                        alt=""
                                                                                        style="padding-right:10px ">
                                                                                    <b>Professionalism:</b>
                                                                                    Our staff expertise responds to high
                                                                                    complex
                                                                                    needs
                                                                                </p>

                                                                            </li>
                                                                            <li>

                                                                                <p class="txt-left a pt-10">
                                                                                    <img src="{{ URL::asset('assets/images/list_style.png') }}"
                                                                                        alt=""
                                                                                        style="padding-right:10px ">
                                                                                    <b>Proximity:</b>
                                                                                    Build open relationships with clients
                                                                                </p>
                                                                            </li>
                                                                            <li>

                                                                                <p class="txt-left a pt-10">
                                                                                    <img src="{{ URL::asset('assets/images/list_style.png') }}"
                                                                                        alt=""
                                                                                        style="padding-right:10px ">
                                                                                    <b>Proactivity: </b>
                                                                                    Not only follow the customer demand but
                                                                                    anticipate and customize intelligent
                                                                                    solutions
                                                                                </p>
                                                                            </li>
                                                                            <li>


                                                                                <p class="txt-left a pt-10">
                                                                                    <img src="{{ URL::asset('assets/images/list_style.png') }}"
                                                                                        alt=""
                                                                                        style="padding-right:10px ">
                                                                                    <b>Proficiency: </b>
                                                                                    High standards, ability to use
                                                                                    innovative
                                                                                    technology to meet client’s expectations
                                                                                </p>
                                                                            </li>
                                                                            <li>

                                                                                <p class="txt-left a pt-10">
                                                                                    <img src="{{ URL::asset('assets/images/list_style.png') }}"
                                                                                        alt=""
                                                                                        style="padding-right:10px ">
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

                                                                                <p class="txt-left a pt-10">
                                                                                    <img src="{{ URL::asset('assets/images/list_style.png') }}"
                                                                                        alt=""
                                                                                        style="padding-right:10px ">
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
                                                                                alt="" class=""
                                                                                style="height:60px;width:140px;">
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

                                                <tr>
                                                    <td style="padding-top:43px">
                                                        <div class="logo" style="width:100%;height:100px;">
                                                            <img src="{{ URL::asset('assets/images/abs_footer-label.jpg') }}"
                                                                alt="" class=""
                                                                style="height:100px;;width:100%;">
                                                        </div>
                                                    </td>
                                                </tr>

                                            </tbody>

                                        </table>
                                    </div>

                                </div>
                            </div>
                            <div class="carousel-item ">
                                <div class="main-page appointment-letter">

                                    <div class="sub-page" style="padding:0px;">
                                        <table class="letter-format" style="padding:0;">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="logo" style="width:100%;height:100px;">
                                                            <img src="{{ URL::asset('assets/images/header.jpg') }}"
                                                                alt="" class=""
                                                                style="height:100px;;width:100%;">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="center" style="padding:1cm;">
                                                        <table class="table-one">
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="12" align="right">
                                                                        <p class="fw-600 txt-right">
                                                                            Date:dd-mm-yyyy
                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="12" align="center">
                                                                        <p class="fw-600 txt-center " style="">
                                                                            LETTER OF APPOINTMENT
                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="12" style=" " align="left">
                                                                        <p class="fw-600 txt-left pt-30" style="">
                                                                            Dear XYZ,
                                                                        </p>
                                                                        <p class="pt-pb-5">We are glad to appoint you as
                                                                            “<b>Executive - HR</b>” in our company, Ardens
                                                                            Business Solutions Private Limited.</p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="12" style=" " align="left">
                                                                        <p class="txt-left pt-10">
                                                                            <b>Remuneration:</b>
                                                                            Your total remuneration package (CTC) per annum
                                                                            is <b>&emsp; &emsp;</b> per annum (Rupees One
                                                                            Lakhs Eighty Thousand and Forty-Eight Only). The
                                                                            break-up of your compensation package shall be
                                                                            as detailed in Annexure A.
                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="12" align="left">
                                                                        <p class="txt-left a pt-10">
                                                                            <b>Commencement:</b>
                                                                            Your employment with the company Ardens Business
                                                                            Solutions Private Limited will be with effect
                                                                            from <b>dd-mm-yyyy</b>. You shall initially be
                                                                            placed in Chennai. You may however be required
                                                                            to travel and may be positioned or deputed
                                                                            outside within India or abroad.
                                                                        </p>

                                                                    </td>
                                                                </tr>


                                                                <tr>
                                                                    <td colspan="12" style=" " align="left">
                                                                        <p class="txt-left a pt-10">
                                                                            <b>Rules and Regulations:</b>
                                                                            You shall be governed by the policies of the
                                                                            company as specified in Annexure B. You shall
                                                                            serve the Company and shall carry out such
                                                                            duties which will be explained and defined by
                                                                            your manager (immediate superior), subject
                                                                            always to the employee policy and the rules and
                                                                            regulations of the Company. Your employment
                                                                            shall continue to be governed by the terms of
                                                                            this appointment letter in the event of you
                                                                            being deputed or positioned outside India.
                                                                        </p>
                                                                    </td>
                                                                </tr>


                                                                <tr>
                                                                    <td colspan="12" style=" " align="left">
                                                                        <p class="txt-left a pt-10">
                                                                            <b>Reporting</b>
                                                                        </p>
                                                                        <p>
                                                                            You will report to
                                                                            “<b>&emsp;&emsp;&emsp;&emsp;</b>”.
                                                                        </p>
                                                                        <p class="txt-left a pt-5">
                                                                            We welcome you to our team. We are confident
                                                                            that you will make an effective contribution to
                                                                            the growth of the company and will enjoy working
                                                                            with us.
                                                                        </p>
                                                                        <p class="txt-left a pt-5">
                                                                            You will be under probation for a period of six
                                                                            months. Your confirmation will be based on the
                                                                            evaluation during the end of the probation
                                                                            period.
                                                                        </p>
                                                                        <p class="txt-left a pt-5">
                                                                            If you are agreeable to the terms and conditions
                                                                            of the appointment (Annexure B), then kindly
                                                                            confirm your acceptance of the appointment by
                                                                            signing and returning to us the attached copy of
                                                                            this letter.
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
                                                                                alt="" class=""
                                                                                style="height:60px;width:140px;">
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
                                                <tr>
                                                    <td>
                                                        <div class="logo"
                                                            style="width:100%;height:160px;padding-top:61px;">
                                                            <img src="{{ URL::asset('assets/images/abs_footer-label.jpg') }}"
                                                                alt="" class=""
                                                                style="height:100px;width:100%;">
                                                        </div>
                                                    </td>
                                                </tr>

                                            </tbody>

                                        </table>
                                    </div>

                                </div>
                            </div>
                            <div class="carousel-item ">
                                <div class="main-page appointment-letter">

                                    <div class="sub-page" style="padding:0px;">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="logo" style="width:100%;height:100px;">
                                                            <img src="{{ URL::asset('assets/images/header.jpg') }}"
                                                                alt="" class=""
                                                                style="height:100px;width:100%;">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:1cm ">
                                                        <table border="1" align="center"
                                                            class="payslip_table arderns_salaryTable" style="">
                                                            <tr>
                                                                <td colspan="12" align="center"><b>ANNEXURE B</b></td>

                                                            </tr>
                                                            <tr>
                                                                <td colspan="12" align="center"><b>SALARY STRUCTURE</b>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td colspan="12" align="center"><b>Your remuneration
                                                                        shall be paid to
                                                                        you under the following heads</b></td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="4" align="center" class="bg-ash"><b>Name
                                                                    </b></td>
                                                                <td colspan="8" align="center"><b>Salary</b></td>

                                                            </tr>
                                                            <tr class="bg-ash">
                                                                <td colspan="6"><b>Designation: Executive – HR</b></td>
                                                                <td colspan="3" align="center"><b>Per Month</b></td>
                                                                <td colspan="3" align="center"><b>Per Annum</b></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="6">Basic</td>
                                                                <td colspan="3" align="right"></td>
                                                                <td colspan="3" align="right"></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="6">HRA</td>
                                                                <td colspan="3" align="right"></td>
                                                                <td colspan="3" align="right"></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="6">Child Education Allowance</td>
                                                                <td colspan="3" align="right"> </td>
                                                                <td colspan="3" align="right"> </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="6">Leave Travel Allowance</td>
                                                                <td colspan="3" align="right"> </td>
                                                                <td colspan="3" align="right"> </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="6">Food Allowance</td>
                                                                <td colspan="3" align="right"> - </td>
                                                                <td colspan="3" align="right"> - </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="6">Special Allowance</td>
                                                                <td colspan="3" align="right"></td>
                                                                <td colspan="3" align="right"></td>
                                                            </tr>
                                                            <tr class="bg-ash">
                                                                <td colspan="6"><b>Gross</b></td>
                                                                <td colspan="3" align="right"><b></b></td>
                                                                <td colspan="3" align="right"><b></b></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="6">PF (Employer Contribution)</td>
                                                                <td colspan="3" align="right"></td>
                                                                <td colspan="3" align="right"></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="6">ESI (Employer Contribution)</td>
                                                                <td colspan="3" align="right"></td>
                                                                <td colspan="3" align="right"></td>
                                                            </tr>
                                                            <tr class="bg-ash">
                                                                <td colspan="6" class=""><b>Cost to Company</b>
                                                                </td>
                                                                <td colspan="2" class="" align="center"><b></b>
                                                                </td>
                                                                <td colspan="3" class="" align="center"><b></b>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="6">PF (Employer Contribution)</td>
                                                                <td colspan="3" align="center"></td>
                                                                <td colspan="3" align="center"></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="6">ESI (Employer Contribution)</td>
                                                                <td colspan="3" align="center"><b></b></td>
                                                                <td colspan="3" align="center"><b></b></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="6">Prof. Tax</td>
                                                                <td colspan="3" align="center"></td>
                                                                <td colspan="3" align="center"></td>
                                                            </tr>
                                                            <tr class="bg-ash">
                                                                <td colspan="6"><b>Net Income</b></td>
                                                                <td colspan="3" align="center"><b></b></td>
                                                                <td colspan="3" align="center"><b></b></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="12" align="center"><b>Income Tax as
                                                                        applicable will be
                                                                        deducted</b></td>

                                                            </tr>

                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:0cm 1cm ">
                                                        <table style="padding-top: 0.5cm;">
                                                            <tr>
                                                                <td colspan="12" style=" " align="left">
                                                                    <p class="txt-left a">
                                                                        I <b>XYZ</b>, have read ANNEXURE A &
                                                                        B, understood
                                                                        and accept the appointment upon the terms and
                                                                        conditions as outlined
                                                                        in this appointment letter for my position at Ardens
                                                                        Business
                                                                        Solutions Privat Limited
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="6" style="padding-top: 1cm;"
                                                                    align="left">
                                                                    <p class="txt-left">
                                                                        Signature:
                                                                    </p>
                                                                </td>
                                                                <td colspan="6" style="padding-top: 1cm;"
                                                                    align="center">
                                                                    <p class="txt-center">
                                                                        Date:
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="logo" style="width:100%;padding-top:151px;">
                                                            <img src="{{ URL::asset('assets/images/abs_footer-label.jpg') }}"
                                                                alt="" class=""
                                                                style="height:100px;width:100%;">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>


                                    </div>

                                </div>
                            </div>
                            <div class="carousel-item ">
                                <div class="main-page appointment-letter">

                                    <div class="sub-page" style="padding:0px;">
                                        <table class="letter-format" style="padding:0;">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="logo" style="width:100%;height:100px;">
                                                            <img src="{{ URL::asset('assets/images/header.jpg') }}"
                                                                alt="" class=""
                                                                style="height:100px;;width:100%;">
                                                        </div>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="center" style="padding:1cm;">
                                                        <table class="table-one">
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="12" style="" align="left">
                                                                        <p class="txt-left ">
                                                                            <b>General Terms & Conditions :</b>
                                                                        </p>
                                                                        <p class="txt-left a pt-10">
                                                                            You will have to provide signed copies of all
                                                                            documents and forms in the joining kit including
                                                                            the signed appointment letter to Ardens Business
                                                                            Solutions Private Ltd. (ABS) within a period of
                                                                            30 days from your date of joining. The documents
                                                                            can be either couriered or handed over in person
                                                                            at the designated ABS offices. You will not be
                                                                            eligible for payroll in the subsequent months if
                                                                            these documents are not received within the
                                                                            30-day period from your date of joining.
                                                                        </p>
                                                                        <p class="txt-left a pt-10">
                                                                            ABS is working towards having a safe transaction
                                                                            mode for all payments and follows the practice
                                                                            of remitting salary, reimbursement, F&F, and
                                                                            other payments directly to your designated bank
                                                                            account. You are required hereby to confirm your
                                                                            acceptance of the same and provide your Bank
                                                                            Account details with proof (cancelled cheque or
                                                                            copy of bank passbook or bank statement) within
                                                                            15 days of the date of joining to ABS personnel
                                                                            at the designated ABS offices or send an e­mail
                                                                            with a scanned copy of the proofs mentioned to
                                                                            <a
                                                                                href="payroll@ardens.in">payroll@ardens.in</a>
                                                                            mentioning "bank account details" in the subject
                                                                            line of the mail.
                                                                        </p>
                                                                        <p class="txt-left a pt-10">
                                                                            You will have to provide your PAN card details
                                                                            within 15 days of your date of joining.
                                                                        </p>
                                                                        <p class="txt-left a pt-10">
                                                                            In case, you don’t have a PAN card, you will
                                                                            have to apply and provide the acknowledgment
                                                                            copy within 15 days from the date of joining.
                                                                        </p>
                                                                        <p class="txt-left a pt-10">
                                                                            In case you do not provide PAN card details and
                                                                            your income falls under the taxable limits, you
                                                                            will be paid your monthly salary after the
                                                                            deduction of taxes as per the existing tax laws.
                                                                        </p>
                                                                        <p class="txt-left a pt-10">
                                                                            Your pay slips will be available online for
                                                                            viewing, downloading, and printing. This is a
                                                                            digitally generated document and does not
                                                                            require a physical signature for verification.
                                                                            The pay slip will be available at the end of the
                                                                            first week of the month and will be deemed to
                                                                            have been received and accepted by you. For any
                                                                            clarifications or queries, regarding the same,
                                                                            you can send an email to <a
                                                                                href="payroll@ardens.in">payroll@ardens.in</a>
                                                                            referencing your ABS employee ID. </p>
                                                                        <p class="txt-left a pt-10">
                                                                            In case of any reimbursable components in your
                                                                            salary structure, you will be required to submit
                                                                            necessary proofs of payments and bills for the
                                                                            same, failing which the payments will be made
                                                                            after the deduction of appropriate taxes.
                                                                        </p>
                                                                        <p class="txt-left a pt-10">
                                                                            If you are eligible for ESIC benefits and have
                                                                            an existing ESIC number, please inform in
                                                                            advance through the ESIC nomination form in your
                                                                            joining kit to retain the existing ESIC number.
                                                                            For PF transfer from an existing PF account, you
                                                                            will need to fill and submit the PF transfer
                                                                            form in your joining kit.
                                                                        </p>
                                                                        <p class="txt-left a pt-10  ">
                                                                            ABS do not accept or retain any original
                                                                            certificates/ documents pertaining to your
                                                                            educational and other qualifications. You may be
                                                                            required to produce the same for verification
                                                                            purposes only if requested by authorized ABS
                                                                            personnel.
                                                                        </p>
                                                                        <p class="txt-left a pt-10">
                                                                            You will have to complete all the exit
                                                                            formalities and hand over any assets including
                                                                            but not limited to ID cards, laptops, mobiles,
                                                                            etc. in your custody before your Last Working
                                                                            Day (LWD) in the organization. Your Full & Final
                                                                            Settlement (F&F) will be completed only if the
                                                                            exit formalities are done on time, which shall
                                                                            not exceed 45 days.
                                                                        </p>
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top:16px">
                                                        <div class="logo"
                                                            style="width:100%;height:100px;padding-top:12px;">
                                                            <img src="{{ URL::asset('assets/images/abs_footer-label.jpg') }}"
                                                                alt="" class=""
                                                                style="height:100px;;width:100%;">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>

                                        </table>
                                    </div>

                                </div>
                            </div>
                            <div class="carousel-item ">
                                <div class="main-page appointment-letter">

                                    <div class="sub-page" style="padding:0;">
                                        <table class="letter-format" style="">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="logo" style="width:100%;height:100px;">
                                                            <img src="{{ URL::asset('assets/images/header.jpg') }}"
                                                                alt="" class=""
                                                                style="height:100px;;width:100%;">
                                                        </div>

                                                    </td>
                                                </tr>
                                                <tr>


                                                    <td align="center" style="padding: 1cm">
                                                        <table class="table-one">
                                                            <tbody>

                                                                <tr>
                                                                    <td colspan="12" style="" align="left">
                                                                        <p class="txt-left ">
                                                                            Your F&F settlement amount will be transferred
                                                                            to the bank account used for your salary
                                                                            transactions. In case, there are dues to be
                                                                            recovered from you in the F&F settlement, you
                                                                            will be issued your relieving letter and
                                                                            experience letters only on clearance of these
                                                                            dues.
                                                                        </p>
                                                                        <p class="txt-left">
                                                                            As a token of your acceptance of the above terms
                                                                            and conditions, you are requested to sign the
                                                                            duplicate copy of this letter and return to us.
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
                                                                                alt="" class=""
                                                                                style="height:60px;width:140px;">
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
                                                                        <hr style="border: 1px solid black;">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="12" style="padding-top: 0cm;"
                                                                        align="left">
                                                                        <p>
                                                                            I <b>XYZ</b>, have understood and
                                                                            accepted the appointment upon the terms and
                                                                            conditions as outlined in this appointment
                                                                            letter for my position at Ardens Business
                                                                            Solutions Privat Limited
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="6" style="padding-top: 1cm;"
                                                                        align="left">
                                                                        <p class="txt-left">
                                                                            Signature:
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="6" style="padding-top: 1cm;"
                                                                        align="center">
                                                                        <p class="txt-center">
                                                                            Date:
                                                                        </p>
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <div class="logo"
                                                            style="width:100%;height:100px;padding-top:419px;">
                                                            <img src="{{ URL::asset('assets/images/abs_footer-label.jpg') }}"
                                                                alt="" class=""
                                                                style="height:100px;;width:100%;">
                                                        </div>
                                                    </td>
                                                </tr>

                                            </tbody>

                                        </table>
                                    </div>

                                </div>
                            </div>
                            <div class="carousel-item  ">
                                <div class="main-page appointment-letter">

                                    <div class="sub-page" style="padding:0px;">
                                        <table class="letter-format" style="">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="logo" style="width:100%;height:100px;">
                                                            <img src="{{ URL::asset('assets/images/header.jpg') }}"
                                                                alt="" class=""
                                                                style="height:100px;;width:100%;">
                                                        </div>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="center" style="padding:0 1cm;">
                                                        <table class="table-one">
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
                                                                        <p class="text-justify pt-10">
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
                                                                        <p class="text-justify pt-10">
                                                                            This document is to be read and thoroughly
                                                                            understood by all ABS AWs at the time of joining
                                                                            an assignment; it requires them to be aware of
                                                                            the policy and our recommendations for safe
                                                                            working practices
                                                                        </p>
                                                                        <p class="text-justify pt-10">
                                                                            We assure that we will not depute an AW to a
                                                                            client site, which causes an Occupational Hazard
                                                                            or risk to Health. We will only work with
                                                                            clients who are aligned to our Health & Safety
                                                                            Policy for AWs. Additionally, we advise our AWs
                                                                            and employees to bring to our notice, situations
                                                                            that an AW might encounter and could be a
                                                                            potential health & safety issue.
                                                                        </p>
                                                                        <p class="text-justify pt-10">
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
                                                                        <p class="text-justify pt-10">
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

                                                                        <ol>
                                                                            <li class=" text-justify pt-10">Ensure that you
                                                                                are aware of
                                                                                your own
                                                                                responsibilities in respect of relevant
                                                                                health, safety and environmental matters.
                                                                            </li>
                                                                            <li style="" class="text-justify pt-10">
                                                                                Follow
                                                                                instructions the way it is meant to be. Use
                                                                                entries and exits, lifts in the manner it is
                                                                                meant to be.</li>
                                                                            <li style="" class="text-justify pt-10">
                                                                                Ensure you
                                                                                have
                                                                                your AW ID card on your person at all times
                                                                                with your photograph, ABS contact details
                                                                                and Nos. displayed in a clear manner.</li>
                                                                            <li style="" class="text-justify pt-10">
                                                                                If you have
                                                                                a
                                                                                visitor, ensure your visitor signs in and
                                                                                receives a security pass. Do not take your
                                                                                visitor into the client premises without
                                                                                permission.</li>

                                                                        </ol>

                                                                    </td>
                                                                </tr>


                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top:75px">
                                                        <div class="logo"
                                                            style="width:100%;height:100px;padding-top:23px;">
                                                            <img src="{{ URL::asset('assets/images/abs_footer-label.jpg') }}"
                                                                alt="" class=""
                                                                style="height:100px;;width:100%;">
                                                        </div>

                                                    </td>
                                                </tr>

                                            </tbody>

                                        </table>
                                    </div>

                                </div>
                            </div>
                            <div class="carousel-item ">
                                <div class="main-page appointment-letter">

                                    <div class="sub-page" style="padding:0cm">
                                        <table class="letter-format" style="">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="logo" style="width:100%;height:100px;">
                                                            <img src="{{ URL::asset('assets/images/header.jpg') }}"
                                                                alt="" class=""
                                                                style="height:100px;;width:100%;">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="center" style="padding:1cm 1cm 0">
                                                        <table class="table-one">
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <ol style="" start="5">
                                                                            <li class="text-justify">

                                                                                You
                                                                                will not
                                                                                enter your work premises while under the
                                                                                influence of alcohol, drugs or any
                                                                                substance
                                                                                which may endanger your health or safety
                                                                                and/or that of any other person
                                                                            </li>
                                                                            <li class="text-justify">

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
                                                                    <td colspan="12" align="left"
                                                                        style="padding-top:1%">
                                                                        <p class="txt-left a">
                                                                            <b>Fire Safety:</b>
                                                                        </p>

                                                                        <ol class="text-justify">
                                                                            <li class="pt-10 text-justify">Ensure
                                                                                familiarity with the
                                                                                fire safety
                                                                                procedures in work place. Most organizations
                                                                                have fire safety training as a statutory
                                                                                requirement. Ensure you attend the same,
                                                                                after seeking necessary permission from your
                                                                                reporting manager.</li>
                                                                            <li style="" class="pt-10">Understand
                                                                                different kinds of firefighting equipment’s
                                                                                installed at your work place.</li>
                                                                            <li style="" class="pt-10">Please
                                                                                become
                                                                                familiar to the sound of the fire alarm and
                                                                                know the emergency/fire exits. These are not
                                                                                normal entry/exits. These exits are signed
                                                                                with the statutory fire exit signs.</li>
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
                                                                    <td colspan="12" align="left"
                                                                        style="padding-top: 1em">
                                                                        <p class="txt-left a">
                                                                            <b>Accident & First Aid:</b>
                                                                        </p>
                                                                        <p class="text-justify a pt-10">
                                                                            Familiarize yourself with the First Aid
                                                                            arrangements at your workplace. Do not leave
                                                                            vehicles or items relating to your work in
                                                                            places other than that which is designated. This
                                                                            will help prevent accidents.
                                                                        </p>

                                                                        <ol class="text-justify">
                                                                            <li class="pt-10">Follow rules on speed limit
                                                                                and wearing
                                                                                safety gear as is prescribed at the work
                                                                                environment that you are at.</li>
                                                                            <li style="" class="pt-10">If your
                                                                                office
                                                                                premises require you to wear a helmet while
                                                                                entering or exiting, comply with the same.
                                                                            </li>
                                                                            <li style="" class="pt-10">In the event
                                                                                of
                                                                                an accident, do not handle it on your own;
                                                                                follow procedures that you may have been
                                                                                trained in; inform the facilities manager or
                                                                                emergency numbers provided.</li>
                                                                            <li style="" class="pt-10">Understand
                                                                                accident report procedures at your work
                                                                                site.</li>
                                                                            <li style="" class="pt-10">Always let
                                                                                someone know, where you are going and your
                                                                                expected time of return.</li>
                                                                        </ol>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="12" align="left"
                                                                        style="padding-top:1em">

                                                                        <b  style="padding-bottom:1em"> As a ABS AW, you have the right to:</b>



                                                                        <ol class="text-justify">
                                                                            <li class="pt-10">Work in places where all the
                                                                                risks to your
                                                                                health and safety are properly controlled.
                                                                            </li>
                                                                            <li style="" class="pt-10">If your
                                                                                office
                                                                                premises require you to wear a helmet while
                                                                                entering or exiting, comply with the same.
                                                                            </li>
                                                                            <li style="" class="pt-10">To stop
                                                                                working
                                                                                and leave the area if you think you are in
                                                                                danger.</li>
                                                                            <li style="" class="pt-10">To stop
                                                                                working
                                                                                and leave the area if you think you are in
                                                                                danger.</li>
                                                                        </ol>

                                                                    </td>
                                                                </tr>


                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="padding-top: 6.7em;">
                                                        <div class="logo"
                                                            style="width:100%;height:100px;padding-top:84px;">
                                                            <img src="{{ URL::asset('assets/images/abs_footer-label.jpg') }}"
                                                                alt="" class=""
                                                                style="height:100px;;width:100%;">
                                                        </div>
                                                    </td>
                                                </tr>

                                            </tbody>

                                        </table>
                                    </div>

                                </div>
                            </div>
                            <div class="carousel-item ">
                                <div class="main-page appointment-letter">
                                    <div class="sub-page" style="padding:0px;">
                                        <table class="letter-format">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="logo" style="width:100%;height:100px;">
                                                            <img src="{{ URL::asset('assets/images/header.jpg') }}"
                                                                alt="" class=""
                                                                style="height:100px;;width:100%;">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="center" style="padding: 1cm;">
                                                        <table class="table-one">
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="12"  align="left">

                                                                        <b style="padding-bottom: 1em">    Recommendations for Common Safe Working
                                                                            Practices:</b>



                                                                        <ol style="text-align: justify">
                                                                            <li class="pt-10">Do not smoke in areas
                                                                                prohibited.</li>
                                                                            <li style="" class="pt-10">Do not
                                                                                expose
                                                                                electric conduits/plugs/sockets to water.
                                                                            </li>
                                                                            <li style="" class="pt-10">If your work
                                                                                requires you to lift weight frequently,
                                                                                understand load management procedures at
                                                                                work.</li>
                                                                            <li style="" class="pt-10">Do not
                                                                                operate
                                                                                machinery unless you have been trained and
                                                                                authorized to do so.</li>

                                                                            <li class="pt-10">
                                                                                If you use tools as part of your work use
                                                                                only the right and authorized tools.

                                                                            </li>
                                                                            <li class="pt-10">
                                                                                Report any Health and Safety incidents
                                                                                whether they result in injury or not to your
                                                                                respective ABS anchor.
                                                                            </li>
                                                                            <li class="pt-10">
                                                                                Cooperate in the investigation of accidents
                                                                                with the objective of introducing measures
                                                                                to prevent a recurrence.
                                                                            </li>
                                                                        </ol>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="12"align="left" style="padding-top:2em">

                                                                        <p class="txt-left">
                                                                            <b>For Ardens Business Solutions Private
                                                                                Limited</b>
                                                                        </p>
                                                                        <p style="padding:8px 0px;">
                                                                            <img src="{{ URL::asset('assets/images/augustin_sign.png') }}"
                                                                                alt="" class=""
                                                                                style="height:60px;width:140px;">
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
                                                                        <hr style="border: 1px solid black;">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="12" style="padding-top: 0cm;"
                                                                        align="left">
                                                                        <p>
                                                                            I <b>XYZ</b>, have understood and
                                                                            accepted the appointment upon the terms and
                                                                            conditions as outlined in this appointment
                                                                            letter for my position at Ardens Business
                                                                            Solutions Privat Limited
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="6" style="padding-top: 1cm;"
                                                                        align="left">
                                                                        <p class="txt-left">
                                                                            Signature:
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="6" style="padding-top: 1cm;"
                                                                        align="center">
                                                                        <p class="txt-center">
                                                                            Date:
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top:2.3em">
                                                        <div class="logo"
                                                            style="width:100%;height:100px;padding-top:279px;">
                                                            <img src="{{ URL::asset('assets/images/abs_footer-label.jpg') }}"
                                                                alt="" class=""
                                                                style="height:100px;;width:100%;">
                                                        </div>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel_template"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon bg-secondary rounded-circle"
                                aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel_template"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon bg-secondary rounded-circle"
                                aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>

                </div>
                <div class="tab-pane fade  " id="payslips" role="tabpanel" aria-labelledby="pills-home-tab">

                    <div class="main-page">
                        <div class="sub-page" style="text-align: justify;">
                            <table cellspacing="0" cellpadding="0" class="payslip_table ardens">
                                <tr class="header-row">
                                    <td colspan="8" class="border-less">
                                        <div class="header-cotent" style="margin: 1px;">
                                            <p class=" text-strong"
                                                style="color: #002f56;
                                            padding-left: 5px;font-size:17px;margin:0px;">
                                                Ardens Business Solutions Private Limited</p>
                                            <p class="mb-0" style="margin:0px;"> North Phase Industrial Estate</p>
                                            <p class="mb-0" style="margin:0px;">42, 5th Cross St, Kalaimagal
                                                Nagar,Ekkatuthangal</p>
                                            <p class="mb-0" style="margin:0px;"> Chennai, Tamil Nadu 600032 </p>

                                        </div>
                                    </td>
                                    <td colspan="4" class="border-less">

                                        <div class="header-img txt-right" style="">
                                            {{-- <img src={{ $client_logo }} style="height: 50px;width:150px;margin:10px" title=""> --}}
                                            <img src={{ URL::asset('assets/images/client_logos/ardens/evangelist.png') }}
                                                style="height: 35px;width:150px;margin:10px" title="">

                                        </div>


                                    </td>
                                </tr>


                                <tr>
                                    <td colspan="12" class=" bg-ash">
                                        <p class="sub-header txt-center text-strong">PAYSLIP FOR THE MONTH OF &ndash;
                                            <span style="text-transform:uppercase;">
                                                -</span>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="bg-ash text-strong">
                                        <p>EMPLOYEE NAME</p>
                                    </td>
                                    <td colspan="3">
                                        <p>-</p>
                                    </td>
                                    <td colspan="3" class="bg-ash text-strong">
                                        <p>EMPLOYEE CODE</p>
                                    </td>
                                    <td colspan="3">
                                        <p>-</p>
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="3" class="bg-ash text-strong">
                                        <p>DATE OF BIRTH</p>
                                    </td>
                                    <td colspan="3">
                                        <p>-</p>
                                    </td>
                                    <td colspan="3" class="bg-ash text-strong">
                                        <p>DATE OF JOINING</p>
                                    </td>
                                    <td colspan="3">
                                        <p>-</p>
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="3" class="bg-ash text-strong">
                                        <p>DESIGNATION</p>
                                    </td>
                                    <td colspan="3">
                                        <p>-</p>
                                    </td>
                                    <td colspan="3" class="bg-ash text-strong">
                                        <p>LOCATION</p>
                                    </td>
                                    <td colspan="3">
                                        <p>-</p>
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="3" class="bg-ash text-strong">
                                        <p>EPF NUMBER</p>
                                    </td>
                                    <td colspan="3">
                                        <p>-</p>
                                    </td>
                                    <td colspan="3" class="bg-ash text-strong">
                                        <p>ESIC NUMBER</p>
                                    </td>
                                    <td colspan="3">
                                        <p>-</p>
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="3" class="bg-ash text-strong">
                                        <p>UAN</p>
                                    </td>
                                    <td colspan="3">
                                        <p>-</p>
                                    </td>
                                    <td colspan="3" class="bg-ash text-strong">
                                        <p>PAN</p>
                                    </td>
                                    <td colspan="3">
                                        <p>-</p>
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="4" class="bg-ash ">
                                        <p class="text-strong txt-center">BANK NAME</p>
                                    </td>

                                    <td colspan="4" class="bg-ash ">
                                        <p class="text-strong txt-center">ACCOUNT NUMBER</p>
                                    </td>
                                    <td colspan="4" class="bg-ash ">
                                        <p class="text-strong txt-center">IFSC CODE</p>
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="4" class="">

                                        <p class="txt-center">-</p>
                                    </td>
                                    <td colspan="4" class="">
                                        <p class="txt-center">-</p>
                                    </td>
                                    <td colspan="4" class="">
                                        <p class="txt-center">-</p>
                                    </td>


                                </tr>

                                <tr>
                                    <td colspan="3" class="bg-ash ">
                                        <p class="text-strong txt-center">MONTH DAYS</p>
                                    </td>

                                    <td colspan="3" class="bg-ash ">
                                        <p class="text-strong txt-center">WORKED DAYS</p>
                                    </td>
                                    <td colspan="3" class="bg-ash ">
                                        <p class="text-strong txt-center">LOSS OF PAY</p>
                                    </td>
                                    <td colspan="3" class="bg-ash ">
                                        <p class="text-strong txt-center">ARREAR DAYS</p>
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="3" class="">
                                        <p class="txt-center">-</p>
                                    </td>
                                    <td colspan="3" class="">
                                        <p class="txt-center">-</p>
                                    </td>
                                    <td colspan="3" class="">
                                        <p class="txt-center">-</p>
                                    </td>
                                    <td colspan="3" class="">
                                        <p class="txt-center">-</p>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="12">
                                        <p class="padding-md">&nbsp; </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="bg-ash">
                                        <p class="txt-center text-strong">DESCRIPTION</p>
                                    </td>
                                    <td colspan="2" class="bg-ash">
                                        <p class="txt-center text-strong">FIXED GROSS</p>
                                    </td>
                                    <td colspan="2" class="bg-ash">
                                        <p class="txt-center text-strong">ARREAR GROSS</p>
                                    </td>
                                    <td colspan="2" class="bg-ash">
                                        <p class="txt-center text-strong">EARNED GROSS</p>
                                    </td>
                                    <td colspan="2" class="bg-ash">
                                        <p class="txt-center text-strong">DEDUCTION</p>
                                    </td>
                                    <td colspan="2" class="bg-ash">
                                        <p class="txt-center text-strong">AMOUNT</p>
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="2" class="">
                                        <p class="txt-left text-strong">BASIC</p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-right"><img height="8.5" width="12"
                                                src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                                alt="" style="padding-right:0px;">-
                                        </p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-right"><img height="8.5" width="12"
                                                src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                                alt="" style="padding-right:0px;">-
                                        </p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-right"><img height="8.5" width="12"
                                                src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                                alt="" style="padding-right:0px;">-
                                        </p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-left text-strong">EPF</p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-right"><img height="8.5" width="12"
                                                src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                                alt="" style="padding-right:0px;">-
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="">
                                        <p class="txt-left text-strong">HRA</p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-right"><img height="8.5" width="12"
                                                src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                                alt="" style="padding-right:0px;">- </p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-right"><img height="8.5" width="12"
                                                src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                                alt="" style="padding-right:0px;">-
                                        </p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-right"><img height="8.5" width="12"
                                                src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                                alt="" style="padding-right:0px;">-
                                        </p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-left text-strong">ESIC</p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-right"><img height="8.5" width="12"
                                                src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                                alt="" style="padding-right:0px;">-
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="">
                                        <p class="txt-left text-strong">SPECIAL ALLOWANCE</p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-right"><img height="8.5" width="12"
                                                src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                                alt="" style="padding-right:0px;">-
                                        </p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-right"><img height="8.5" width="12"
                                                src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                                alt="" style="padding-right:0px;">-
                                        </p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-right"><img height="8.5" width="12"
                                                src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                                alt="" style="padding-right:0px;">-
                                        </p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-left text-strong">PT</p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-right"><img height="8.5" width="12"
                                                src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                                alt="" style="padding-right:0px;">-
                                        </p>
                                    </td>


                                </tr>

                                <tr>
                                    <td colspan="2" class="">
                                        <p class="txt-left text-strong">COMMUNICATION ALLOWANCE</p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-right"></p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-right"></p>
                                    </td>

                                    <td colspan="2" class="">
                                        <p class="txt-right"><img height="8.5" width="12"
                                                src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                                alt="" style="padding-right:0px;">-
                                        </p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-left text-strong">INCOME TAX</p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-right"><img height="8.5" width="12"
                                                src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                                alt="" style="padding-right:0px;">-
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="">
                                        <p class="txt-left text-strong">FOOD ALLOWANCE </p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-right"></p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-right"></p>
                                    </td>

                                    <td colspan="2" class="">
                                        <p class="txt-right"><img height="8.5" width="12"
                                                src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                                alt="" style="padding-right:0px;">-
                                        </p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-left text-strong">FOOD DEDUCTION</p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-right"><img height="8.5" width="12"
                                                src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                                alt="" style="padding-right:0px;">-
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="">
                                        <p class="txt-left text-strong"> </p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-right"></p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-right"></p>
                                    </td>

                                    <td colspan="2" class="">
                                        <p class="txt-right"></p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-left text-strong">CANT-DEDUCTION</p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-right"> <img height="8.5" width="12"
                                                src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                                alt="" style="padding-right:0px;">-
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="">
                                        <p class="txt-left text-strong"> </p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-right"></p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-right"></p>
                                    </td>

                                    <td colspan="2" class="">
                                        <p class="txt-right"></p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-left text-strong">SALARY ADVANCE</p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-right"> <img height="8.5" width="12"
                                                src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                                alt="" style="padding-right:0px;">-
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="">
                                        <p class="txt-left text-strong"> </p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-right"></p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-right"></p>
                                    </td>

                                    <td colspan="2" class="">
                                        <p class="txt-right"></p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-left text-strong">OTHER DEDUCTIONS</p>
                                    </td>
                                    <td colspan="2" class="">
                                        <p class="txt-right"><img height="8.5" width="12"
                                                src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                                alt="" style="padding-right:0px;">-
                                        </p>
                                    </td>
                                </tr>
                                <tr class="text-strong">
                                    <td colspan="2" class="bg-ash">
                                        <p class="txt-left  text-strong">TOTAL EARNINGS</p>
                                    </td>
                                    <td colspan="2" class="bg-ash">
                                        <p class="txt-right"><img height="8.5" width="12"
                                                src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                                alt="" style="padding-right:0px;">-
                                        </p>
                                    </td>
                                    <td colspan="2" class="bg-ash">
                                        <p class="txt-right"></p>
                                    </td>

                                    <td colspan="2" class="bg-ash">
                                        <p class="txt-right"><img height="8.5" width="12"
                                                src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                                alt="" style="padding-right:0px;">-
                                        </p>
                                    </td>
                                    <td colspan="2" class="bg-ash">
                                        <p class="txt-left text-strong">TOTAL DEDUCTION</p>
                                    </td>
                                    <td colspan="2" class="bg-ash">
                                        <p class="txt-right"><img height="8.5" width="12"
                                                src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                                alt="" style="padding-right:0px;">-
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="12">
                                        <p class="padding-md">&nbsp; </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="bg-ash">
                                        <p class="txt-left text-strong">NET PAY</p>
                                    </td>
                                    <td colspan="8" class="">
                                        <p class="txt-center "><img height="8.5" width="12"
                                                src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right"
                                                alt="" style="padding-right:0px;">-
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="bg-ash">
                                        <p class="txt-left text-strong">NET PAY IN WORDS</p>
                                    </td>
                                    <td colspan="8" class="">
                                        <p class="txt-center ">-</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="12">
                                        <p class="padding-md">&nbsp; </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="bg-ash">
                                        <p class="txt-center text-strong">TRANSACTION ID</p>
                                    </td>
                                    <td colspan="3" class="">
                                        <p class="txt-center"></p>
                                    </td>
                                    <td colspan="3" class="bg-ash">
                                        <p class="txt-center text-strong">Paid Date</p>
                                    </td>
                                    <td colspan="3" class="">
                                        <p class="txt-center"></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="12">
                                        <p class="padding-md">&nbsp; </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="12">
                                        <p class="txt-center">This is a computer-generated slip does not require signature
                                        </p>
                                    </td>
                                </tr>

                                <tr class="border-less">
                                    <td colspan="8" class="border-less border-r-0" style="    padding: 10px 0px;">
                                        <p class="txt-left">Please
                                            reach out to us for any payroll queries at - payroll@ardens.in</p>
                                    </td>
                                    <td colspan="3" class="border-less border-x-0 txt-right"
                                        style="    padding: 10px 0px;">
                                        <p>Generated By</p>


                                    </td>
                                    <td colspan="1" class="border-less border-l-0" style="    padding: 10px 0px;">
                                        <img src="{{ URL::asset('assets/images/client_logos/ardens/evangelist.png') }}"
                                            width="100px" height="18px" alt="" class="">
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>
@endsection
