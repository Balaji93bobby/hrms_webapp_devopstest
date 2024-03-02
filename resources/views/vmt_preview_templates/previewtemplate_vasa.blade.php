@extends('layouts.master')
@section('title')
    @lang('translation.settings')
@endsection
@section('css')
    <style>
        .main-page {
            width: 210mm;
            min-height: 297mm;
            margin: 10mm auto;
            background: white;
            box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: bo;
        }

        .sub-page {
            padding: 1cm;

        }

        @media print {
            .main-page {
                page-break-after: always;
            }
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

            .main-page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
        }

        p {
            text-align: justify;

        }

        table {
            width: 100%;
            vertical-align: middle;
            font-family: sans-serif;
        }

        .payslip_table tr,
        td {
            border: 2px solid #004b81;

        }

        table td:last-child {}

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

        p {
            font-size: 9pt;
            margin-top: 3pt;
            margin-bottom: 3pt;
            padding: 0px 5px;
        }



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

        .header-row {
            height: 50px;
        }

        td.bg-ash {
            background-color: #c1c1c1;
        }

        .p3 {
            padding: 3px;
        }

        .fw-600 {
            font-weight: 600;
        }

        table.letter-format tr td,
        table.letter-format tr,
        table.letter-format tr td p {
            border: 0;
            font-size: 14px;
        }

        .pt-pb-5 {
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .pt-pb-10 {
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .pt-10 {
            padding-top: 10px;
        }

        .pt-30 {
            padding-top: 30px;
        }

        .pb-30 {
            padding-bottom: 30px;
        }

        table.salary-table tr td {
            border-collapse: collapse;
            border: 1px solid;
        }

        .border-bottom-line {
            border-bottom: 1px solid;
        }
    </style>
@endsection
@section('content')
    <div class="template-wrapper">
        <div class="card left-line  mb-2">
            <div class="card-body pb-0 pt-1">
                <ul class="nav nav-pills    nav-tabs-dashed" id="pills-tab" role="tablist">
                    <li class="nav-item text-muted me-4" role="presentation">
                        <a class="nav-link active ember-view " id="pills-home-tab" data-bs-toggle="pill" href=""
                            data-bs-target="#appointment" role="tab" aria-controls="pills-home" aria-selected="true">
                            Appointment Letter</a>
                    </li>
                    <li class="nav-item  ember-view" role="presentation ">
                        <a class="nav-link ember-view" id="payslips-tab" data-bs-toggle="pill" data-bs-target="#payslips"
                            type="button" role="tab" aria-controls="payslips" aria-selected="false">Pay Slip</a>
                    </li>

                </ul>

            </div>

        </div>

        <div class="card">
            <div class="tab-content " id="pills-tabContent">
                <div class="tab-pane fade show active" id="appointment" role="tabpanel" aria-labelledby="pills-home-tab">

                    <div id="carouselExampleControlsNoTouching" class="carousel slide" data-bs-touch="false"
                        data-bs-interval="false">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="main-page appointment-letter">
                                    <div class="sub-page" style="text-align: justify;font-size: 15px;">
                                        <table class="letter-format" style="padding:0;">
                                            <tbody>
                                                <tr>
                                                    <td align="center" style="">
                                                        <table class="table-one">
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="8" style=" " align="right">
                                                                        <p class="fw-600 txt-right " style="">
                                                                            Date:
                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="8" style=" " align="center">
                                                                        <p class="fw-600 txt-center " style="">
                                                                            LETTER OF APPOINTMENT

                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="8" style=" " align="left">
                                                                        <p class="fw-600 txt-left " style="">
                                                                            Dear Xyz,
                                                                        </p>
                                                                        <p class="pt-pb-5">We are glad to appoint you as
                                                                            &nbsp;<span class="fw-600 txt-left">" Xyz
                                                                                "</span>&nbsp; in our company, &nbsp;<span
                                                                                class="fw-600 txt-left"> VASA
                                                                                GROUP</span>&nbsp;.</p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="8" style=" " align="left">
                                                                        <p class="fw-600 txt-left " style="">
                                                                            Remuneration

                                                                        </p>
                                                                        <p class="pt-pb-5">
                                                                            Your total remuneration package per annum will
                                                                            consist of &nbsp;<span class="fw-600 txt-left">
                                                                                CTC Rs 5,40,000/- per annum (Rupees Five
                                                                                Lakhs Forty Thousand only)</span>&nbsp;. The
                                                                            breakup of your compensation package shall
                                                                            be as detailed in Annexure A.

                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="8" style=" " align="left">
                                                                        <p class="fw-600 txt-left " style="">
                                                                            Commencement

                                                                        </p>
                                                                        <p class="pt-pb-5">
                                                                            Your employment with the company &nbsp;<span
                                                                                class="fw-600 txt-left"> VASA GROUP
                                                                            </span>&nbsp will
                                                                            be with effect from &nbsp;<span
                                                                                class="fw-600 txt-left"> 25th May
                                                                                2022</span>&nbsp;. You shall
                                                                            initially be placed in &nbsp;<span
                                                                                class="fw-600 txt-left"> Chennai
                                                                            </span>&nbsp;. You may however
                                                                            be required to travel and maybe positioned or
                                                                            deputed outside within India or abroad.

                                                                        </p>

                                                                    </td>
                                                                </tr>


                                                                <tr>
                                                                    <td colspan="8" style=" " align="left">
                                                                        <p class="fw-600 txt-left " style="">
                                                                            Rules and Regulations

                                                                        </p>
                                                                        <p class="pt-pb-5">
                                                                            You shall be governed by the policies of the
                                                                            company as specified in &nbsp;<span
                                                                                class="fw-600 txt-left">Annexure
                                                                                B</span>&nbsp;. You shall
                                                                            serve the Company and shall carry out such
                                                                            duties which will be explained and defined by
                                                                            your manager (immediate superior), subject
                                                                            always to the employee policy and the rules and
                                                                            regulations of the Company. Your employment
                                                                            shall continue to be governed by the terms of
                                                                            this appointment letter in the event of you
                                                                            being deputed or positioned outside India.

                                                                        </p>
                                                                        <p class="pt-pb-5">
                                                                            We welcome you to our team. We are confident
                                                                            that you will make an effective contribution to
                                                                            the growth of the company and will enjoy working
                                                                            with us.
                                                                        </p>
                                                                        <p class="pt-pb-5">
                                                                            You will be under probation for a period of
                                                                            &nbsp;<span class="fw-600 txt-left">SIX
                                                                                MONTHS </span>&nbsp;. Your confirmation will
                                                                            be based on the
                                                                            evaluation during the end of the probation
                                                                            period.


                                                                        </p>
                                                                        <p class="pt-pb-5">
                                                                            If you are agreeable to the terms and conditions
                                                                            of the appointment (Annexure B), then kindly
                                                                            confirm your acceptance of the appointment by
                                                                            signing and returning to us the attached copy of
                                                                            this letter.

                                                                        </p>

                                                                    </td>
                                                                </tr>


                                                                <tr>
                                                                    <td colspan="8" style=" " align="left">
                                                                        <p class="fw-600 pt-30  txt-left " style="">
                                                                            Yours faithfully,
                                                                        </p>
                                                                        <p class="pt-pb-5 pb-30 fw-600">
                                                                            For VASA GROUP

                                                                        </p>
                                                                        <p class="fw-600 pt-10 txt-left "
                                                                            style="border-bottom:1px solid">
                                                                            Founder and CEO of VasaGroup
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="8" style=" " align="left">
                                                                        <p class=" pt-10 txt-left " style="">
                                                                            I M Xyz, have read &nbsp;<span
                                                                                class="fw-600 txt-left">ANNEXURE A &
                                                                                B,</span>&nbsp; understood, and accept the
                                                                            appointment upon the terms and conditions as
                                                                            outlined in this appointment letter for my
                                                                            position at &nbsp;<span
                                                                                class="fw-600 txt-left">VASA GROUP
                                                                            </span>&nbsp;.

                                                                        </p>


                                                                    </td>
                                                                </tr>



                                                                <tr>
                                                                    <td colspan="4" class="pt-30" style=" "
                                                                        align="left">
                                                                        <p class="fw-600 txt-left " style="">
                                                                            Sign:
                                                                        </p>


                                                                    </td>
                                                                    <td colspan="4" style=" " align="right">
                                                                        <p class="fw-600 txt-right " style="">
                                                                            Date:
                                                                        </p>


                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>

                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item ">
                                <div class="main-page appointment-letter">
                                    <div class="sub-page" style="text-align: justify;font-size: 15px;">
                                        <table class="letter-format " style="padding:0;">
                                            <tbody>
                                                <tr>
                                                    <td class="" colspan="8">
                                                        <table class="salary-table">
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="8" style=" "class=""
                                                                        align="center">
                                                                        <p class="fw-600 txt-center " style="">
                                                                            ANNEXURE A
                                                                        </p>

                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td colspan="8" style=" "class=""
                                                                        align="center">
                                                                        <p class="fw-600 txt-center " style="">
                                                                            &nbsp;
                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>

                                                                    <td colspan="4" style=" "class="bg-ash "
                                                                        align="left">
                                                                        <p class="fw-600  txt-left" style="">
                                                                            Name:
                                                                        </p>

                                                                    </td>

                                                                    <td colspan="4" style=" "class="bg-ash ">
                                                                        <p class="fw-600  txt-center" style="">
                                                                            Salary
                                                                        </p>

                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4" style=" "class="bg-ash "
                                                                        align="center">
                                                                        <p class="fw-600  " style="">
                                                                            Designation
                                                                        </p>

                                                                    </td>
                                                                    <td colspan="2" style=" "class="bg-ash ">
                                                                        <p class="fw-600  txt-center" style="">
                                                                            Per Month
                                                                        </p>

                                                                    </td>
                                                                    <td colspan="2" style=" "class="bg-ash ">
                                                                        <p class="fw-600   txt-center   " style="">
                                                                            Per Annum
                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4" style=" "class=" ">
                                                                        <p class=" txt-left " style="">
                                                                            Basic
                                                                        </p>

                                                                    </td>
                                                                    <td colspan="2" style=" "class="">
                                                                        <p class="  txt-right" style="">

                                                                        </p>

                                                                    </td>
                                                                    <td colspan="2" style=" "class="">
                                                                        <p class="   txt-right   " style="">

                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4" style=" "class=" ">
                                                                        <p class=" txt-left " style="">
                                                                            HRA
                                                                        </p>

                                                                    </td>
                                                                    <td colspan="2" style=" "class="">
                                                                        <p class=" txt-right" style="">

                                                                        </p>

                                                                    </td>
                                                                    <td colspan="2" style=" "class="">
                                                                        <p class="   txt-right   " style="">

                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4" style=" "class=" ">
                                                                        <p class=" txt-left " style="">
                                                                            Special Allowance
                                                                        </p>

                                                                    </td>
                                                                    <td colspan="2" style=" "class="">
                                                                        <p class=" txt-right" style="">

                                                                        </p>

                                                                    </td>
                                                                    <td colspan="2" style=" "class="">
                                                                        <p class="   txt-right   " style="">

                                                                        </p>

                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td colspan="4" style=" "class="bg-ash "
                                                                        align="center">
                                                                        <p class="  fw-600" style="">
                                                                            Gross
                                                                        </p>

                                                                    </td>
                                                                    <td colspan="2" style=" "class="bg-ash">
                                                                        <p class="fw-600   txt-center" style="">

                                                                        </p>

                                                                    </td>
                                                                    <td colspan="2" style=" "class="bg-ash">
                                                                        <p class="fw-600   txt-center   " style="">

                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4" style=" "class=" ">
                                                                        <p class="" style="">
                                                                            PF (Employer Contribution)
                                                                        </p>

                                                                    </td>
                                                                    <td colspan="2" style=" "class="">
                                                                        <p class="  txt-center" style="">

                                                                        </p>

                                                                    </td>
                                                                    <td colspan="2" style=" "class="">
                                                                        <p class="   txt-center   " style="">

                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4" style=" "class=" ">
                                                                        <p class=" txt-left " style="">
                                                                            ESI (Employer Contribution)
                                                                        </p>

                                                                    </td>
                                                                    <td colspan="2" style=" "class="">
                                                                        <p class=" txt-right" style="">

                                                                        </p>

                                                                    </td>
                                                                    <td colspan="2" style=" "class="">
                                                                        <p class="  txt-right   " style="">

                                                                        </p>

                                                                    </td>
                                                                </tr>

                                                                <tr class="">
                                                                    <td colspan="4" style=" "class="bg-ash">
                                                                        <p class="fw-600  txt-left" style="">
                                                                            Cost to Company
                                                                        </p>

                                                                    </td>
                                                                    <td colspan="2" style=" "class="bg-ash">
                                                                        <p class="fw-600  txt-right" style="">

                                                                        </p>

                                                                    </td>
                                                                    <td colspan="2" style=" "class="bg-ash">
                                                                        <p class="fw-600   txt-right   " style="">

                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4" style=" "class=" ">
                                                                        <p class="txt-left " style="">
                                                                            EPF (Employee Contribution)
                                                                        </p>

                                                                    </td>
                                                                    <td colspan="2" style=" "class="">
                                                                        <p class="txt-right" style="">

                                                                        </p>

                                                                    </td>
                                                                    <td colspan="2" style=" "class="">
                                                                        <p class="ttxt-right   " style="">

                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4" style=" "class=" ">
                                                                        <p class="txt-left " style="">
                                                                            ESI (Employee Contribution)
                                                                        </p>

                                                                    </td>
                                                                    <td colspan="2" style=" "class="">
                                                                        <p class="txt-right" style="">

                                                                        </p>

                                                                    </td>
                                                                    <td colspan="2" style=" "class="">
                                                                        <p class="txt-right   " style="">

                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4" style=" "class=" ">
                                                                        <p class="txt-left " style="">
                                                                            Professional Tax

                                                                        </p>

                                                                    </td>
                                                                    <td colspan="2" style=" "class="">
                                                                        <p class="txt-right" style="">

                                                                        </p>

                                                                    </td>
                                                                    <td colspan="2" style=" "class="">
                                                                        <p class="ttxt-right   " style="">

                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4" style=" "class="  bg-ash">
                                                                        <p class="txt-left " style="">
                                                                            Net Income
                                                                        </p>

                                                                    </td>
                                                                    <td colspan="2" style=" "class=" bg-ash">
                                                                        <p class="txt-right" style="">

                                                                        </p>

                                                                    </td>
                                                                    <td colspan="2" style=" "class=" bg-ash">
                                                                        <p class="ttxt-right   " style="">

                                                                        </p>

                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8" class="pt-pb-5" style=" ">
                                                        <p class=" txt-left pt-pb-5 " style="">
                                                            <span class="fw-600">Statutory Bonus – </span>
                                                            Will be paid as per the Payment of Bonus Act and
                                                            8.33% or MW whichever is higher if your basic
                                                            salary is less than INR-21000/- per month.

                                                        </p>
                                                        <p class=" txt-left pt-pb-5 " style="">
                                                            <span class="fw-600">Increment and Promotions – </span>
                                                            Shall be based on merit considering your periodic and consistent
                                                            overall performance, business conditions, and other parameters
                                                            fixed from time to time at the discretion of the management and
                                                            shall not be considered merely as a matter of right.



                                                        </p>
                                                        <p class=" txt-left pt-pb-5 " style="">
                                                            <span class="fw-600"> Gratuity- </span>

                                                            Will be paid for those who have completed 5 Years of continuous
                                                            service with our organization as per the Payment of Gratuity Act
                                                            -1972.

                                                        </p>

                                                        <p class=" txt-left pt-pb-5 " style="">
                                                            <span class="fw-600"> Insurance –</span>
                                                            <span> Group Mediclaim policy will be an extended benefits to
                                                                our employees.
                                                                ESIC not covered employees – 3,00,000 GMC (Employee +Spouse
                                                                + Kids Max) – Subject to conditions
                                                            </span>
                                                        <p>ESIC Covered Employees – 1,00,000 GMC (Employee + Spouse + Kids
                                                            Max) – Subject to conditions </p>

                                                        </p>
                                                        <p class=" txt-left pt-pb-5 " style="">
                                                            <span class="fw-600">IncomeTax – </span>
                                                            Income tax will be deducted as per the slab

                                                        </p>

                                                        <p class=" txt-left pt-pb-5 " style="">
                                                            <span class="fw-600">Full and Final Settlement -</span>
                                                            F n F will be settle within 7 working days from the Last working
                                                            day
                                                        </p>


                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8" style=" " align="left">
                                                        <p class=" pt-30 txt-left " style="">
                                                            I Xyz, have read &nbsp;<span class="fw-600 txt-left">ANNEXURE A
                                                                &
                                                                B,</span>&nbsp; understood, and accept the
                                                            appointment upon the terms and conditions as
                                                            outlined in this appointment letter for my
                                                            position at &nbsp;<span class="fw-600 txt-left">VASA GROUP
                                                            </span>&nbsp;.

                                                        </p>


                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="pt-30" style=" " align="left">
                                                        <p class="fw-600 txt-left " style="">
                                                            Sign:
                                                        </p>


                                                    </td>
                                                    <td colspan="4" style=" " align="right">
                                                        <p class="fw-600 txt-right " style="">
                                                            Date:
                                                        </p>


                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item ">
                                <div class="main-page appointment-letter">
                                    <div class="sub-page" style="text-align: justify;font-size: 15px;">
                                        <table class="letter-format " style="padding:0;">
                                            <tbody>
                                                <tr>
                                                    <td colspan="8" style=" "class="" align="center">
                                                        <span class="fw-600  border-bottom-line" style="">
                                                            ANNEXURE B
                                                        </span>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="" style=" "class="" align="center">
                                                        <p class="fw-600  " style="">
                                                            DUTIES
                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="" style=" "class="" align="center">
                                                        <p class="  " style="">
                                                            You will devote your full-time skill and attention to the work
                                                            and business of the Company and shall continue to work to the
                                                            best of your ability.

                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="" style=" "class="" align="center">
                                                        <p class="  " style="">
                                                            You will accept, support, and work within the management,
                                                            financial, personnel, internal control, and reporting systems,
                                                            policies, practices, and procedures as determined by the Company
                                                            or your Manager, from time to time.

                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="" style=" "class="pt-10" align="center">
                                                        <p class="fw-600  " style="">
                                                            HOURS OF WORK
                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="" style=" "class="" align="center">
                                                        <p class=" " style="">
                                                            Your actual working hours &nbsp;<span
                                                                class="fw-600 txt-left">9.45 AM to 6 PM </span>&nbsp;
                                                            including working in
                                                            Shifts and working days (including working on weekly offs and
                                                            public holidays) will be often determined by workflow and
                                                            Company commitments.


                                                        </p>
                                                        <p class=" " style="">
                                                            VASA GROUP works for &nbsp;<span class="fw-600 txt-left">8
                                                                hours</span>&nbsp; (Including Break) a day 5 days a
                                                            week and Saturday &nbsp;<span class="fw-600 txt-left">9.45 AM
                                                                to 4 PM </span>&nbsp; (Including Break). However,
                                                            there may be certain work exigencies that may require you to
                                                            work beyond the stipulated hours of work.

                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="" style=" "class="pt-10" align="center">
                                                        <p class="fw-600  " style="">
                                                            CONDUCT

                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="" style=" "class="" align="center">
                                                        <p class=" " style="">
                                                            You shall conduct yourself in a befitting manner and abide by
                                                            all the conduct policy, the rules, and regulations of the
                                                            Company.

                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="" style=" "class="pt-10">
                                                        <p class=" fw-600" style="">
                                                            REVIEW OF SALARY

                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="" style=" "class="">
                                                        <p class=" " style="">
                                                            Your remuneration shall be reviewed annually and any changes to
                                                            your remuneration package shall be determined by considering
                                                            your performance in the Company, the Company’s performance, and
                                                            your contribution to the Company.


                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="" style=" "class="pt-10">
                                                        <p class=" fw-600" style="">
                                                            CONFIDENTIALITY OF SALARY


                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="" style=" "class="">
                                                        <p class=" " style="">
                                                            Your salary is the reward for your untiring effort and work. You
                                                            need to maintain your salary with the utmost confidentiality. In
                                                            the event you do not maintain the confidentiality of your
                                                            salary, you may be subject to disciplinary action. </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="" style=" "class="pt-10">
                                                        <p class=" fw-600" style="">
                                                            EXPENSES
                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="" style=" "class="">
                                                        <p class="" style="">
                                                            The Company will compensate you for all expenses that are
                                                            reasonably incurred and that are directly related to the
                                                            performance of your work, but only insofar as that compensation
                                                            may be provided tax-free compensation of expenses as contained
                                                            herein will be made only on the basis of a statement of expenses
                                                            that have been approved by the Company.


                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="" style=" "class="pt-10">
                                                        <p class=" fw-600" style="">
                                                            PROVIDENT FUND SCHEME AND ESIC

                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="" style=" "class="">
                                                        <p class=" " style="">
                                                            Employer contributions will be submitted to the Indian
                                                            Government-approved Provident Fund Scheme on your behalf with
                                                            your equal monthly contribution as detailed in &nbsp;<span
                                                                class="fw-600 txt-left"> Annexure A .</span>&nbsp;

                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="" style=" "class="pt-10">
                                                        <p class=" fw-600" style="">
                                                            METHOD OF PAYMENT
                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="" style=" "class="">
                                                        <p class="" style="">
                                                            Salaries and wages will be paid monthly by electronic funds
                                                            transfer or will be deposited in your Salary Account or any
                                                            other means on or before the 7th day of each month in arrears.
                                                            The company reserves its right to vary this procedure at its
                                                            option. However, such variance will be communicated to you in
                                                            due course.

                                                        </p>

                                                    </td>
                                                </tr>



                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item ">
                                <div class="main-page appointment-letter">
                                    <div class="sub-page" style="text-align: justify;">
                                        <table class="letter-format " style="padding:0;">
                                            <tbody>
                                                <tr>
                                                    <td colspan="" style=" "class="">
                                                        <p class="fw-600  " style="">
                                                            LEAVE
                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="" style=" "class="" align="center">
                                                        <p class="  " style="">
                                                        </p>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="" style=" "class="" align="center">
                                                        <p class="fw-600  " style="">
                                                            INTELLECTUAL PROPERTY RIGHTS

                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="" style=" "class="" align="center">
                                                        <p class="  " style="">
                                                            All Industrial and intellectual property rights, including but
                                                            not limited to patent rights, design rights, copyrights, and
                                                            related rights, database rights, trademark rights, and chip
                                                            rights, ensuring within the framework of the work performed by
                                                            you during your employment with the company,
                                                        </p>
                                                        <p class="  " style="">
                                                            will be exclusively vested in Company. You may not independently
                                                            during your employment and subsequent to termination disclose,
                                                            multiply, use, manufacture, bring on the market or sell, lease,
                                                            deliver, or otherwise trade, offer on behalf of any third party,
                                                            or commission the registration of the results of your work. To
                                                            the extent that such inventions are performed under the
                                                            Company’s direction, you shall fully, freely, and immediately
                                                            communicate any invention to the Company and all rights, title,
                                                            and interest to any such invention (“Inventions”) shall be the
                                                            sole property of the Company.

                                                        </p>
                                                        <p class="  " style="">
                                                            In pursuance of the above

                                                        </p>

                                                        <ol type="A" style="text-align: justify">
                                                            <li class="pt-pb-5">You will give the Company and its
                                                                solicitors and/or its
                                                                patent attorneys all necessary assistance and cooperation in
                                                                connection with the preparation and prosecution of any
                                                                application for patent, design, registration, or copyright
                                                                by the Company in respect of the Invention.
                                                            </li>
                                                            <li>TeYou irrevocably appoint the Company and any directors of
                                                                the Company jointly and severally your true and lawful
                                                                attorney to execute all such documents and do all such
                                                                things as in the opinion of the Company may be necessary or
                                                                requisite for any such purpose.</li>

                                                        </ol>


                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="" style=" "class="">
                                                        <p class="fw-600  " style="">
                                                            TERMINATION
                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="" style=" "class="">
                                                        <p class="  " style="">
                                                            Your employment may be terminated at any time by yourself, or by
                                                            the Company, upon providing one (1) month’s written notice to
                                                            the other party. Also, it can be extended according to the
                                                            management’s needs
                                                        </p>
                                                        <p class="pt-pb-5 " style="">
                                                            In the case of the Company terminating, you for reasons other
                                                            than a breach of contract by you or for any disciplinary reasons
                                                            against you, the company shall pay you one month’s salary equal
                                                            to your notice period not worked as payment in lieu of notice.

                                                        </p>
                                                        <p class=" " style="">
                                                            If you seek to terminate your employment with the company, you
                                                            shall do a proper handover of all the work and responsibilities
                                                            that you are handling to your manager and the resource
                                                            identified for replacing you, to the satisfaction of your
                                                            manager. If you are not able to serve the notice period one (1)
                                                            month of your CTC to be payable to VASA GROUP

                                                        </p>
                                                        <p class="pt-pb-5 " style="">
                                                            Upon termination of your employment with the company, you agree
                                                            not to solicit any other team members in the company to the new
                                                            organization that you are going.

                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="" style=" "class="">
                                                        <p class="fw-600  " style="">
                                                            DISPUTE RESOLUTION

                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="" style=" "class="">
                                                        <p class="  " style="">
                                                            Any differences and disputes arising out of this appointment
                                                            letter would be settled by arbitration conducted in accordance
                                                            with the arbitration and conciliation act 1996 with a person
                                                            nominated by the company as the sole arbitrator. The arbitrator
                                                            shall conclude the arbitration within 30 days from the date of
                                                            reference and shall pass an award. The award passed by the
                                                            arbitrator shall be conclusive and binding on the parties and
                                                            shall not be appealable before a court of law.

                                                        </p>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item ">
                                <div class="main-page appointment-letter">
                                    <div class="sub-page" style="text-align: justify;">
                                        <table class="letter-format " style="padding:0;">
                                            <tbody>
                                                <tr>
                                                    <td colspan="8  " style=" "class="">
                                                        <p class="fw-600  " style="">
                                                            GOVERNING LAW AND JURISDICTION

                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8" style=" "class="">
                                                        <p class="  " style="">
                                                            This agreement shall be governed by the laws of the Republic of
                                                            India and courts in Chennai have exclusive jurisdiction over
                                                            this agreement.

                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8" style=" "class="">
                                                        <p class="fw-600  " style="">
                                                            RETIREMENT AGE


                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8" style=" "class="">
                                                        <p class="  " style="">
                                                            The general Retirement for employees in the Company is
                                                            &nbsp;<span class="fw-600 txt-left"> Fifty-Eight (58) years.
                                                            </span>&nbsp;
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8" style=" " align="left">
                                                        <p class="fw-600 pt-30  txt-left " style="">
                                                            Yours faithfully,
                                                        </p>
                                                        <p class="pt-pb-5 pb-30 fw-600">
                                                            For VASA GROUP

                                                        </p>

                                                        <p class="fw-600 pt-10 txt-left " style="border-bottom:1px solid">
                                                            Founder and CEO of VasaGroup
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8" style=" " align="left">
                                                        <p class=" pt-10 txt-left " style="">
                                                            I M Xyz, have read &nbsp;<span class="fw-600 txt-left">ANNEXURE
                                                                A &
                                                                B,</span>&nbsp; understood, and accept the
                                                            appointment upon the terms and conditions as
                                                            outlined in this appointment letter for my
                                                            position at &nbsp;<span class="fw-600 txt-left">VASA GROUP
                                                            </span>&nbsp;.

                                                        </p>


                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="pt-30" style=" " align="left">
                                                        <p class="fw-600 txt-left " style="">
                                                            Sign:
                                                        </p>


                                                    </td>
                                                    <td colspan="4" style=" " align="right">
                                                        <p class="fw-600 txt-right " style="">
                                                            Date:
                                                        </p>


                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>

                        </div>
                        <button class="carousel-control-prev" type="button"
                            data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button"
                            data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="tab-pane fade  " id="payslips" role="tabpanel" aria-labelledby="pills-home-tab">

                    <div class="container-fluid m-2 pdf-container ">
                        <div class="main-page">
                            <div class="sub-page" style="text-align: justify;font-size: 15px;">
                                <div class="table-responsive">
                                    <table cellspacing="0" cellpadding="0" class="payslip_table">
                                        <tr class="header-row" aria-rowcount="">
                                            <td colspan="8" class="border-less p3" rowspan="">
                                                <div class="header-cotent">

                                                    <h6 class="margin-0" style="padding-left: 5px">VASA Group</h6>
                                                    <p class="mb-0">Dugar Towers, 2nd floor,</p>
                                                    <p class="mb-0">#34/123, Marshalls Road, Egmore,</p>
                                                    <p class="mb-0">Chennai, Tamil Nadu, India 600 008. </p>
                                                </div>
                                            </td>
                                            <td colspan="4" class="border-less p3">

                                                <div class="header-img txt-right d-flex align-items-center">

                                                    <img src="{{ URL::asset('assets/images/vasa.jpg') }}" class=""
                                                        alt="" style="height: 100px;width:250px;max-height:100%;">
                                                </div>


                                            </td>
                                        </tr>


                                        <tr>
                                            <td colspan="12" class="bg-ash">
                                                <p class="sub-header txt-center  text-strong">PAYSLIP FOR THE MONTH
                                                    OF
                                                    &ndash; Xyz</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="bg-ash text-strong">
                                                <p>EMPLOYEE NAME</p>
                                            </td>
                                            <td colspan="3">
                                                <p></p>
                                            </td>
                                            <td colspan="3" class="bg-ash text-strong">
                                                <p>EMPLOYEE CODE</p>
                                            </td>
                                            <td colspan="3">
                                                <p></p>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td colspan="3" class="bg-ash text-strong">
                                                <p>DATE OF BIRTH</p>
                                            </td>
                                            <td colspan="3">
                                                <p></p>
                                            </td>
                                            <td colspan="3" class="bg-ash text-strong">
                                                <p>DATE OF JOINING</p>
                                            </td>
                                            <td colspan="3">
                                                <p></p>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td colspan="3" class="bg-ash text-strong">
                                                <p>DESIGNATION</p>
                                            </td>
                                            <td colspan="3">
                                                <p></p>
                                            </td>
                                            <td colspan="3" class="bg-ash text-strong">
                                                <p>LOCATION</p>
                                            </td>
                                            <td colspan="3">
                                                <p></p>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td colspan="3" class="bg-ash text-strong">
                                                <p>EPF NUMBER</p>
                                            </td>
                                            <td colspan="3">
                                                <p></p>
                                            </td>
                                            <td colspan="3" class="bg-ash text-strong">
                                                <p>ESIC NUMBER</p>
                                            </td>
                                            <td colspan="3">
                                                <p></p>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td colspan="3" class="bg-ash text-strong">
                                                <p>UAN</p>
                                            </td>
                                            <td colspan="3">
                                                <p></p>
                                            </td>
                                            <td colspan="3" class="bg-ash text-strong">
                                                <p>PAN</p>
                                            </td>
                                            <td colspan="3">
                                                <p></p>
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
                                                <p class="txt-center"></p>
                                            </td>
                                            <td colspan="4" class="">
                                                <p class="txt-center"></p>
                                            </td>
                                            <td colspan="4" class="">
                                                <p class="txt-center"></p>
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
                                                <p class="txt-center"></p>
                                            </td>
                                            <td colspan="3" class="">
                                                <p class="txt-center"></p>
                                            </td>
                                            <td colspan="3" class="">
                                                <p class="txt-center"></p>
                                            </td>
                                            <td colspan="3" class="">
                                                <p class="txt-center"></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="bg-ash text-strong">
                                                <p class="txt-center">CL/SL OpenBalance</p>
                                            </td>
                                            <td colspan="2" class="bg-ash text-strong ">
                                                <p class="txt-center">PL OpenBalance</p>
                                            </td>

                                            <td colspan="2" class="bg-ash text-strong">
                                                <p class="txt-center">Availed CL/SL</p>
                                            </td>
                                            <td colspan="2" class="bg-ash text-strong">
                                                <p class="txt-center">Availed PL</p>
                                            </td>
                                            <td colspan="2" class="bg-ash text-strong">
                                                <p class="txt-center">Balance CL/SL</p>
                                            </td>
                                            <td colspan="2" class="bg-ash text-strong">
                                                <p class="txt-center">Balance PL</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="">
                                                <p class="txt-center">-</p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-center">-</p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-center">-</p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-center">-</p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-center">-</p>
                                            </td>
                                            <td colspan="2" class="">
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
                                                <p class="txt-center text-strong">AMOUNT</p>
                                            </td>
                                            <td colspan="2" class="bg-ash">
                                                <p class="txt-center text-strong">ARREAR AMOUNT</p>
                                            </td>
                                            <td colspan="2" class="bg-ash">
                                                <p class="txt-center text-strong">EARNED AMOUNT</p>
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
                                                <p class="txt-right"></p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-right"></p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-right"></p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-left text-strong">EPF</p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-right"></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="">
                                                <p class="txt-left text-strong">HRA</p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-right"></p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-right">
                                            <td colspan="2" class="">
                                                <p class="txt-right"></p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-left text-strong">ESIC</p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-right"></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="">
                                                <p class="txt-left text-strong">SPECIAL ALLOWANCE </p>
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
                                                <p class="txt-left text-strong">PT</p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-right"></p>
                                            </td>


                                        </tr>


                                        <tr>
                                            <td colspan="2" class="">
                                                <p class="txt-left text-strong"> COMMUNICATION ALLOWANCE </p>
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
                                                <p class="txt-left text-strong">INCOME TAX</p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-right"></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="">
                                                <p class="txt-left text-strong"> FOOD ALLOWANCE </p>
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
                                                <p class="txt-left text-strong">FOOD DEDUCTION</p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-right"></p>
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
                                                <p class="txt-right"> </p>
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
                                                <p class="txt-right"></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="bg-ash">
                                                <p class="txt-left text-strong">TOTAL EARNINGS</p>
                                            </td>
                                            <td colspan="2" class="bg-ash">
                                                <p class="txt-right"></p>
                                            </td>
                                            <td colspan="2" class="bg-ash">
                                                <p class="txt-right"></p>
                                            </td>

                                            <td colspan="2" class="bg-ash">
                                                <p class="txt-right"></p>
                                            </td>
                                            <td colspan="2" class="bg-ash">
                                                <p class="txt-left text-strong">TOTAL DEDUCTION</p>
                                            </td>
                                            <td colspan="2" class="bg-ash">
                                                <p class="txt-right"></p>
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
                                                <p class="txt-center "></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="bg-ash">
                                                <p class="txt-left text-strong">NET PAY IN WORDS</p>
                                            </td>
                                            <td colspan="8" class="">
                                                <p class="txt-center "></p>
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
                                                <p class="txt-center">This is a computer-generated slip does not require
                                                    signature
                                                </p>
                                            </td>
                                        </tr>

                                        <tr class="border-less">
                                            <td colspan="8" class="border-less">
                                                <p class="txt-left">Please
                                                    reach out to us for any payroll queries at  -hr.admin@imcvasa.in</p>
                                            </td>
                                            <td colspan="2" class="border-less ">
                                                <p class="txt-right">Generated By</p>


                                            </td>
                                            <td colspan="2" class="border-less">
                                                <img src="{{ URL::asset('assets/images/client_logos/ardens/evangelist.png') }}" width="80px" height="15px"
                                                alt="" class="">
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
