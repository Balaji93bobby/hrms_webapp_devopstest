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

        .payslip_table-protocol tr,
        .payslip_table-protocol td {
            border: 2px solid #863b28;
        }
        table.payslip_table tr td{
            border: 2px solid #863b28;
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


        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
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

        .border_bottom-brown {
            border-bottom: 2px solid #863b28;
        }

        .border_top-brown {
            border-top: 2px solid #863b28;
        }

        .text-sky_blue {
            color: #24bdf2 !important;
        }

        .f-14 {
            font-size: 14px
        }

        .f-13 {
            font-size: 13px
        }

        .pad-top-10 {
            padding-top: 10px;
        }

        .pad-top-15 {
            padding-top: 15px;
        }

        .pad-top-20 {
            padding-top: 20px;
        }

        .pad-bottom-25 {
            padding-bottom: 25px;
        }

        .pad-top-8 {
            padding-top: 8px;
        }

        .pad-bottom-10 {
            padding-bottom: 10px;
        }

        .pad-top-25 {
            padding-top: 25px;
        }

        .pad-0 {
            padding: 0px;
        }

        .m-0 {
            margin: 0px;
        }

        .text-ash {
            color: #747374;
        }

        .bg-navy_blue {
            background: #0a0370
        }

        table.table_annexure {
            border-collapse: separate;
            border: 1px solid #000;
        }

        table.table_annexure tr,
        table.table_annexure td,
        table.table_annexure th {
            border: 1px solid #000;
            border-radius: 0px;
            font-size: 14px;
            padding-right: 10px;
            padding-left: 10px;
            font-weight: 600;


        }

        .pad-tb-3 {
            padding-right: 3px;
            padding-left: 3px;

        }



        .text-white {
            color: #ffffff;
        }

        .ptb-5 {
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .f-12 {
            font-size: 12px;
        }

        tr:first-child th:last-child,
        tr:first-child th:first-child,
        tr:first-child th:first-child,
        tr:first-child th:last-child,
        tr:last-child td:first-child,
        tr:last-child td:last-child {
            border-radius: 0px;
        }


        /* .border_bottom-ash
                                                                                                                                                                        {
                                                                                                                                                                            border-bottom: 1px solid  #747374;
                                                                                                                                                                        } */
    </style>
@endsection
@section('content')

    <div class="card mt-30">
        <div class="card-body">
            <div class="fill salary-header nav-tab-header">
                <div>
                    <ul class="nav nav-pills    nav-tabs-dashed" id="pills-tab" role="tablist">
                        <li class="nav-item active ember-view me-4" role="presentation">
                            <a class="nav-link active ember-view " id="pills-home-tab" data-bs-toggle="pill" href=""
                                data-bs-target="#appointment" role="tab" aria-controls="pills-home"
                                aria-selected="true">
                                Appointment Letter</a>
                        </li>
                        <li class="nav-item  ember-view" role="presentation ">
                            <a class="nav-link ember-view" id="payslips-tab" data-bs-toggle="pill"
                                data-bs-target="#payslips" type="button" role="tab" aria-controls="payslips"
                                aria-selected="false">Pay Slip</a>
                        </li>

                    </ul>

                </div>

            </div>

            <div class="tab-content " id="pills-tabContent">
                <div class="tab-pane fade show active" id="appointment" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div id="carouselExampleControlsNoTouching" class="carousel slide" data-bs-touch="false"
                        data-bs-interval="false">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="main-page">
                                    <table class="protocol-template-table" style="padding:0;">
                                        <tbody>
                                            <tr class="border_bottom-brown">
                                                <td colspan="2">
                                                    <div class="logo" style="height:110px;width:130px;">
                                                        <img src="{{ URL::asset('assets/images/protocol_logo.jpg') }}"
                                                            alt="" class=""
                                                            style="height:100%;width:100%;margin: 25px 0px 0px 60px;">
                                                    </div>
                                                </td>
                                                <td colspan="6" align="right" style="padding: 0px 80px 0px 0px;">
                                                    <h6 class="text-sky_blue " style="margin-top:50px">Protocol Labels India
                                                        Private Limited</h6>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" style="padding: 20px 80px;">
                                                    <table>
                                                        <tbody>
                                                            <tr class="">
                                                                <td colspan="8" align="right">
                                                                    <b class="f-13"> 09-OCTOBER-2022</b>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="center" class="pad-top-10">
                                                                    <b class="f-13" style="border-bottom:1px solid #000">
                                                                        LETTER OF APPOINTMENT</b>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-10">
                                                                    <b class="f-13" style="">Dear Xyz,</b>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-8">
                                                                    <p class="f-13 m-0 pad-0" style="">We are glad to
                                                                        appoint
                                                                        you as <b>“ RSM – Sales (AIDC & POS)” </b> in our
                                                                        company, <b> Protocol Labels India
                                                                            Private Limited.</b>
                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-8">
                                                                    <b class="f-13">Remuneration</b>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-8">
                                                                    <p class="f-13 m-0 pad-0" style="">Your total
                                                                        remuneration package per annum will consist of<b>CTC
                                                                            Rs 15,00,000/- per annum (Rupees
                                                                            Fifteen Lakhs Only). </b>. The breakup of your
                                                                        compensation package shall be as detailed in
                                                                        Annexure A
                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-8">
                                                                    <b class="f-13">Commencement</b>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-8">
                                                                    <p class="f-13 pad-0" style="">Your employment
                                                                        with the company <b>Protocol Labels India Private
                                                                            Limited</b> will be with effect from
                                                                        <b> 10-OCTOBER-2022</b>. You shall initially be
                                                                        placed at <b>Chennai</b> . You may however be
                                                                        required to travel
                                                                        and may be positioned or deputed outside within
                                                                        India or abroad.
                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-8">
                                                                    <b class="f-13">Rules and Regulations
                                                                    </b>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-8">
                                                                    <p class="p-0 m-0">You shall be governed by the
                                                                        policies of the company
                                                                        as specified in Annexure B. You shall serve
                                                                        the Company and shall carry out such duties which
                                                                        will be explained and defined by your manager
                                                                        (immediate superior), subject always to the employee
                                                                        policy and the rules and regulations of the
                                                                        Company. Your employment shall continue to be
                                                                        governed by the terms of this appointment letter
                                                                        in the event of you being deputed or positioned
                                                                        outside India.
                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-8">
                                                                    <p class="p-0 m-0">
                                                                        We welcome you to our team. We are confident that
                                                                        you will make an effective contribution to the
                                                                        growth of the company and will enjoy working with
                                                                        us.
                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-8">
                                                                    <p class="p-0 m-0">
                                                                        You will be under probation for a period of SIX
                                                                        MONTHS. Your confirmation will be based on the
                                                                        evaluation during the end of the probation period.
                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-8">
                                                                    <p class="p-0 m-0">If you are agreeable to the terms
                                                                        and conditions of the appointment (Annexure B), then
                                                                        kindly
                                                                        confirm your acceptance of the appointment by
                                                                        signing and returning to us the attached copy of
                                                                        this letter

                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-8">
                                                                    <b class="f-13">Yours faithfully,</b>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-8">
                                                                    <b class="f-13">For Protocol Labels India Private
                                                                        Limited</b>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-8">
                                                                    <div class="signature-content"
                                                                        style="height:40px;width:180px;">
                                                                        <img src="{{ URL::asset('assets/images/protocol_ceoSign.svg') }}"
                                                                            alt="" class=""
                                                                            style="height:100%;width:100%;">
                                                                    </div>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="">
                                                                    <p class="p-0 m-0"><b> P D DHANASEKAR</b>
                                                                    </p>

                                                                </td>

                                                            </tr>
                                                            <tr class="" style="border-bottom: 1px solid #000">
                                                                <td colspan="8" align="left" class="">
                                                                    <p class="p-0 m-0"> <b> Managing Director</b></p>

                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-8">
                                                                    <p class="p-0 m-0">
                                                                        <b>I Muthuselvan B</b> , have read <b>ANNEXURE</b> A
                                                                        & B, understood, and accept the appointment upon the
                                                                        terms and conditions as outlined in this appointment
                                                                        letter for my position at <b>Protocol Labels India
                                                                            Private Limited</b> .
                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="4" align="left" class="pad-top-8">
                                                                    <p class="p-0 m-0 text-left">
                                                                        <b class="">Sign:</b>
                                                                        {{-- <b class="text-right">Date:</b> --}}
                                                                    </p>
                                                                </td>
                                                                <td colspan="4" align="" class="pad-top-8">
                                                                    <p class="p-0 m-0 text-right">

                                                                        <b class="">Date:</b>
                                                                    </p>
                                                                </td>

                                                            </tr>

                                                        </tbody>

                                                    </table>
                                                </td>
                                            </tr>
                                            <tr class="border_top-brown">
                                                <td align="center" colspan="8" style="padding: 0px 80px">

                                                    <p style="text-align: unset">
                                                        <span class="text-ash text-strong border_bottom-ash">Registered
                                                            Office Address</span> -<span
                                                            class="text-sky_blue text-strong">Protocol Labels India Private
                                                            Limited</span>, S
                                                        No-166, 3rd Floor, 3A & 3B, Porur
                                                        Kundarthur Main Road, Gerugambakkam, Chennai – 600128, Tamil Nadu,
                                                        India.
                                                        Website - <a href="#"> www.protocollabels.in</a> | E-Mail -
                                                        <a href="#">info@protocollabels.in</a>
                                                    </p>


                                                </td>
                                            </tr>

                                        </tbody>

                                    </table>
                                </div>
                            </div>
                            <div class="carousel-item ">
                                <div class="main-page">
                                    <table class="protocol-template-table" style="padding:0;">
                                        <tbody>
                                            <tr class="border_bottom-brown">
                                                <td colspan="2">
                                                    <div class="logo" style="height:110px;width:130px;">
                                                        <img src="{{ URL::asset('assets/images/protocol_logo.jpg') }}"
                                                            alt="" class=""
                                                            style="height:100%;width:100%;margin: 25px 0px 0px 60px;">
                                                    </div>
                                                </td>
                                                <td colspan="6" align="right" style="padding: 0px 80px 0px 0px;">
                                                    <h6 class="text-sky_blue " style="margin-top:50px">Protocol Labels
                                                        India
                                                        Private Limited</h6>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" style="padding: 35px 80px 10px;">
                                                    <table class="table_annexure" contenteditable="true">
                                                        <tbody>
                                                            <tr>
                                                                <td colspan="12" align="center"
                                                                    class="bg-navy_blue  fw-strong text-white ptb-5">
                                                                    ANNEXURE A - SALARY STRUCTURE
                                                                </td>
                                                            </tr>
                                                            <tr>

                                                                <td colspan="6" align="left"
                                                                    class="bg-navy_blue  fw-strong text-white ptb-5">
                                                                    Name:

                                                                </td>
                                                                <td colspan="6" align="center"
                                                                    class="bg-navy_blue  fw-strong text-white ptb-5">
                                                                    Salary

                                                                </td>
                                                            </tr>
                                                            <tr>

                                                                <td colspan="6" align="left"
                                                                    class="bg-navy_blue pad-tb-3 fw-strong text-white ">
                                                                    Designation: RSM – Sales (AIDC & POS)

                                                                </td>
                                                                <td colspan="3" align="right"
                                                                    class="bg-navy_blue pad-tb-3   fw-strong text-white">
                                                                    Per Month

                                                                </td>
                                                                <td colspan="3" align="right"
                                                                    class="bg-navy_blue pad-tb-3   fw-strong text-white">
                                                                    Per Annum

                                                                </td>
                                                            </tr>

                                                            <tr>

                                                                <td colspan="6" align="left"
                                                                    class=" pad-tb-3 fw-strong  ">

                                                                    Basic
                                                                </td>
                                                                <td colspan="3" align="right"
                                                                    class=" pad-tb-3   fw-strong ">


                                                                </td>
                                                                <td colspan="3" align="right"
                                                                    class=" pad-tb-3   fw-strong ">


                                                                </td>
                                                            </tr>
                                                            <tr>

                                                                <td colspan="6" align="left"
                                                                    class=" pad-tb-3 fw-strong  ">
                                                                    HRA

                                                                </td>
                                                                <td colspan="3" align="right"
                                                                    class=" pad-tb-3   fw-strong ">


                                                                </td>
                                                                <td colspan="3" align="right"
                                                                    class=" pad-tb-3   fw-strong ">


                                                                </td>
                                                            </tr>
                                                            <tr>

                                                                <td colspan="6" align="left"
                                                                    class=" pad-tb-3 fw-strong  ">
                                                                    Communication Allowance

                                                                </td>
                                                                <td colspan="3" align="right"
                                                                    class=" pad-tb-3   fw-strong ">


                                                                </td>
                                                                <td colspan="3" align="right"
                                                                    class=" pad-tb-3   fw-strong ">


                                                                </td>
                                                            </tr>
                                                            <tr>

                                                                <td colspan="6" align="left"
                                                                    class=" pad-tb-3 fw-strong  ">
                                                                    Leave Travel Allowance

                                                                </td>
                                                                <td colspan="3" align="right"
                                                                    class=" pad-tb-3   fw-strong ">


                                                                </td>
                                                                <td colspan="3" align="right"
                                                                    class=" pad-tb-3   fw-strong ">


                                                                </td>
                                                            </tr>
                                                            <tr>

                                                                <td colspan="6" align="left"
                                                                    class=" pad-tb-3 fw-strong  ">
                                                                    Food Allowance

                                                                </td>
                                                                <td colspan="3" align="right"
                                                                    class=" pad-tb-3   fw-strong ">


                                                                </td>
                                                                <td colspan="3" align="right"
                                                                    class=" pad-tb-3   fw-strong ">


                                                                </td>
                                                            </tr>

                                                            <tr>

                                                                <td colspan="6" align="left"
                                                                    class=" pad-tb-3 fw-strong  ">

                                                                    Special Allowance
                                                                </td>
                                                                <td colspan="3" align="right"
                                                                    class=" pad-tb-3   fw-strong ">


                                                                </td>
                                                                <td colspan="3" align="right"
                                                                    class=" pad-tb-3   fw-strong ">


                                                                </td>
                                                            </tr>
                                                            <tr>

                                                                <td colspan="6" align="left"
                                                                    class="bg-navy_blue pad-tb-3 fw-strong text-white ">
                                                                    Gross

                                                                </td>
                                                                <td colspan="3" align="right"
                                                                    class="bg-navy_blue pad-tb-3   fw-strong text-white">


                                                                </td>
                                                                <td colspan="3" align="right"
                                                                    class="bg-navy_blue pad-tb-3   fw-strong text-white">


                                                                </td>
                                                            </tr>
                                                            <tr>

                                                                <td colspan="6" align="left"
                                                                    class=" pad-tb-3 fw-strong  ">
                                                                    PF (Employer Contribution)

                                                                </td>
                                                                <td colspan="3" align="right"
                                                                    class=" pad-tb-3   fw-strong ">


                                                                </td>
                                                                <td colspan="3" align="right"
                                                                    class=" pad-tb-3   fw-strong ">


                                                                </td>
                                                            </tr>
                                                            <tr>

                                                                <td colspan="6" align="left"
                                                                    class=" pad-tb-3 fw-strong  ">

                                                                    ESI (Employer Contribution)
                                                                </td>
                                                                <td colspan="3" align="right"
                                                                    class=" pad-tb-3   fw-strong ">


                                                                </td>
                                                                <td colspan="3" align="right"
                                                                    class=" pad-tb-3   fw-strong ">


                                                                </td>
                                                            </tr>

                                                            <tr>

                                                                <td colspan="6" align="left"
                                                                    class="bg-navy_blue pad-tb-3 fw-strong text-white ">

                                                                    Cost to Company
                                                                </td>
                                                                <td colspan="3" align="right"
                                                                    class="bg-navy_blue pad-tb-3   fw-strong text-white">


                                                                </td>
                                                                <td colspan="3" align="right"
                                                                    class="bg-navy_blue pad-tb-3   fw-strong text-white">


                                                                </td>
                                                            </tr>
                                                            <tr>

                                                                <td colspan="6" align="left"
                                                                    class=" pad-tb-3 fw-strong  ">

                                                                    EPF (Employee Contribution)
                                                                </td>
                                                                <td colspan="3" align="right"
                                                                    class=" pad-tb-3   fw-strong ">


                                                                </td>
                                                                <td colspan="3" align="right"
                                                                    class=" pad-tb-3   fw-strong ">


                                                                </td>
                                                            </tr>
                                                            <tr>

                                                                <td colspan="6" align="left"
                                                                    class=" pad-tb-3 fw-strong  ">
                                                                    ESI (Employee Contribution)

                                                                </td>
                                                                <td colspan="3" align="right"
                                                                    class=" pad-tb-3   fw-strong ">


                                                                </td>
                                                                <td colspan="3" align="right"
                                                                    class=" pad-tb-3   fw-strong ">


                                                                </td>
                                                            </tr>
                                                            <tr>

                                                                <td colspan="6" align="left"
                                                                    class=" pad-tb-3 fw-strong  ">

                                                                    Professional Tax
                                                                </td>
                                                                <td colspan="3" align="right"
                                                                    class=" pad-tb-3   fw-strong ">


                                                                </td>
                                                                <td colspan="3" align="right"
                                                                    class=" pad-tb-3   fw-strong ">


                                                                </td>
                                                            </tr>
                                                            <tr>

                                                                <td colspan="6" align="left"
                                                                    class="bg-navy_blue pad-tb-3 fw-strong text-white ">
                                                                    Net Income

                                                                </td>
                                                                <td colspan="3" align="right"
                                                                    class="bg-navy_blue pad-tb-3   fw-strong text-white">


                                                                </td>
                                                                <td colspan="3" align="right"
                                                                    class="bg-navy_blue pad-tb-3   fw-strong text-white">


                                                                </td>
                                                            </tr>
                                                            <tr>

                                                                <td colspan="12" align="left" class=" pad-tb-3  ">

                                                                    Income Tax as applicable will be deducted based on the
                                                                    Investment Submission

                                                                </td>

                                                            </tr>


                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="8" style="padding: 0px 100px">
                                                    <table style="font-size:13px">
                                                        <tbody>
                                                            <tr>
                                                                <td colspan="8">
                                                                    <span
                                                                        style="border-bottom:1px solid #000;font-weight:600;"
                                                                        class="">Note:</span>

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding: 0px 10px" colspan="8">
                                                                    <ol>
                                                                        <li style="margin-bottom:10px">

                                                                            There will be an additional performance-based
                                                                            sales incentive to the above CTC which will be
                                                                            discussed and disclosed after the successful
                                                                            completion of 6 months, with the targets
                                                                            assigned from there on.
                                                                        </li>
                                                                        <li style="margin-bottom:10px">All the sale revenue
                                                                            targets are counted upon the sales from the POS,
                                                                            Protocol hardware product,
                                                                            and AIDC Solutions - Application Software
                                                                            portfolio, both from the in-house and
                                                                            outsourced.</li>
                                                                        <li style="margin-bottom:10px">This CTC is
                                                                            inclusive of all perks and benefits and there
                                                                            will be deductions on the above CTC against
                                                                            TDS, Professional Tax, and Provident Fund
                                                                            benefit as and when PF benefits comes into
                                                                            effect in the
                                                                            company. The CTC includes the PF contribution
                                                                            portions of the Employee and Employer</li>
                                                                    </ol>

                                                                </td>
                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-8">
                                                                    <p class="p-0 m-0">
                                                                        <b>I Muthuselvan B</b> , have read <b>ANNEXURE</b> A
                                                                        & B, understood, and accept the appointment upon the
                                                                        terms and conditions as outlined in this appointment
                                                                        letter for my position at <b>Protocol Labels India
                                                                            Private Limited</b> .
                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="4" align="left" class="pad-top-8"
                                                                    style="padding-bottom: 40px">
                                                                    <p class="p-0 m-0 text-left">
                                                                        <b class="">Sign:</b>
                                                                        {{-- <b class="text-right">Date:</b> --}}
                                                                    </p>
                                                                </td>
                                                                <td colspan="4" align="" class="pad-top-8"
                                                                    style="padding-bottom: 40px">
                                                                    <p class="p-0 m-0 text-right">

                                                                        <b class="">Date:</b>
                                                                    </p>
                                                                </td>

                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </td>
                                            </tr>




                                            <tr class="border_top-brown">
                                                <td align="center" colspan="8" style="padding: 0px 80px">

                                                    <p style="text-align: unset">
                                                        <span class="text-ash text-strong border_bottom-ash">Registered
                                                            Office Address</span> -<span
                                                            class="text-sky_blue text-strong">Protocol Labels India Private
                                                            Limited</span>, S
                                                        No-166, 3rd Floor, 3A & 3B, Porur
                                                        Kundarthur Main Road, Gerugambakkam, Chennai – 600128, Tamil Nadu,
                                                        India.
                                                        Website - <a href="#"> www.protocollabels.in</a> | E-Mail -
                                                        <a href="#">info@protocollabels.in</a>
                                                    </p>


                                                </td>
                                            </tr>

                                        </tbody>

                                    </table>
                                </div>
                            </div>
                            <div class="carousel-item ">
                                <div class="main-page">
                                    <table class="protocol-template-table" style="padding:0;">
                                        <tbody>
                                            <tr class="border_bottom-brown">
                                                <td colspan="2">
                                                    <div class="logo" style="height:110px;width:130px;">
                                                        <img src="{{ URL::asset('assets/images/protocol_logo.jpg') }}"
                                                            alt="" class=""
                                                            style="height:100%;width:100%;margin: 25px 0px 0px 60px;">
                                                    </div>
                                                </td>
                                                <td colspan="6" align="right" style="padding: 0px 80px 0px 0px;">
                                                    <h6 class="text-sky_blue " style="margin-top:50px">Protocol Labels
                                                        India
                                                        Private Limited</h6>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" style="padding: 20px 80px;">
                                                    <table>
                                                        <tbody>
                                                            <tr class="">
                                                                <td colspan="8" align="center" class="pad-top-10">
                                                                    <b class="f-13"
                                                                        style="border-bottom:1px solid #000">
                                                                        ANNEXURE B
                                                                    </b>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-10">
                                                                    <b class="f-13" style="">DUTIES</b>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="">
                                                                    <p class="f-13 m-0 pad-0" style="">

                                                                        You will devote your full-time skill and attention
                                                                        to the work and business of the Company and shall
                                                                        continue to work to the best of your ability.

                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="">
                                                                    <p class="f-13 m-0 pad-0" style="">
                                                                        Without the Company’s prior written consent, you
                                                                        will not perform any other work for pay during
                                                                        your employment term, or will you, alone or with
                                                                        others, directly or indirectly, establish any
                                                                        business, whatever its form, or take any financial
                                                                        interest in or perform work for such a business,
                                                                        whether or not for consideration
                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="">
                                                                    <p class="f-13 m-0 pad-0" style="">
                                                                        You will accept, support and work within the
                                                                        management, financial, personnel, internal control
                                                                        and reporting systems, policies, practices, and
                                                                        procedures as determined by the Company or your
                                                                        Manager, from time to time.

                                                                    </p>

                                                                </td>

                                                            </tr>




                                                            <tr class="">
                                                                <td colspan="8" align="left" class="">
                                                                    <b class="f-13">HOURS OF WORK</b>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="">
                                                                    <p class="f-13 pad-0" style="">
                                                                        Your actual working hours 9 AM to 6 PM including
                                                                        working in Shifts and working days (including
                                                                        working on weekly offs and public holidays) will be
                                                                        often determined by workflow and Company
                                                                        commitments.
                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="">
                                                                    <b class="f-13">CONDUCT
                                                                    </b>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="">
                                                                    <p class="p-0 m-0">
                                                                        You shall conduct yourself in a befitting manner and
                                                                        abide by all the conduct policies, rules, and
                                                                        regulations of the Company.
                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="">
                                                                    <b class="f-13">REVIEW OF SALARY
                                                                    </b>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="">
                                                                    <p class="p-0 m-0">
                                                                        Your remuneration shall be reviewed annually and any
                                                                        changes to your remuneration package shall
                                                                        be determined by considering your performance in the
                                                                        Company, the Company’s performance, and
                                                                        your contribution to the Company
                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="">
                                                                    <b class="f-13">
                                                                        CONFIDENTIALITY OF SALARY
                                                                    </b>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="">
                                                                    <p class="p-0 m-0">
                                                                        Your salary is the reward for your untiring effort
                                                                        and work. You need to maintain your salary with
                                                                        the utmost confidentiality. In the event of you not
                                                                        maintaining the confidentiality of your salary,
                                                                        you may be subject to disciplinary action.

                                                                    </p>
                                                                </td>
                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="">
                                                                    <b class="f-13">
                                                                        EXPENSES
                                                                    </b>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="">
                                                                    <p class="p-0 m-0">
                                                                        The Company will compensate you for all expenses
                                                                        that are reasonably incurred and that are
                                                                        directly related to the performance of your work,
                                                                        but only insofar as that compensation may be
                                                                        provided tax free compensation of expenses as
                                                                        contained herein will be made only on the basis of
                                                                        a statement of expenses that have been approved by
                                                                        the Company.
                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="">
                                                                    <b class="f-13">
                                                                        PROVIDENT FUND SCHEME AND ESIC
                                                                    </b>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="">
                                                                    <p class="p-0 m-0">
                                                                        Employer contributions will be submitted to the
                                                                        Indian Government-approved Provident Fund
                                                                        Scheme on your behalf with your equal monthly
                                                                        contribution as detailed in <b class="f-13">
                                                                            Annexure A. </b>
                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="">
                                                                    <b class="f-13">
                                                                        METHOD OF PAYMENT

                                                                    </b>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="">
                                                                    <p class="p-0 m-0">
                                                                        Salaries and wages will be paid monthly by
                                                                        electronic funds transfer or will be deposited in
                                                                        your
                                                                        Corporate Salary Account or any other means on or
                                                                        before 5th day of each month in arrears. The
                                                                        company reserves its right to vary this procedure at
                                                                        its option. However, such variance will be
                                                                        communicated to you in due course.

                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="">
                                                                    <b class="f-13">
                                                                        LEAVE
                                                                    </b>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="">
                                                                    <p class="p-0 m-0">
                                                                        You will be governed by the leave rules of the
                                                                        Company; your manager has got all rights to decide
                                                                        on your leave as per the policy and procedure of the
                                                                        Company
                                                                    </p>
                                                                </td>

                                                            </tr>


                                                        </tbody>

                                                    </table>
                                                </td>
                                            </tr>
                                            <tr class="border_top-brown">
                                                <td align="center" colspan="8" style="padding: 0px 80px">

                                                    <p style="text-align: unset">
                                                        <span class="text-ash text-strong border_bottom-ash">Registered
                                                            Office Address</span> -<span
                                                            class="text-sky_blue text-strong">Protocol Labels India Private
                                                            Limited</span>, S
                                                        No-166, 3rd Floor, 3A & 3B, Porur
                                                        Kundarthur Main Road, Gerugambakkam, Chennai – 600128, Tamil Nadu,
                                                        India.
                                                        Website - <a href="#"> www.protocollabels.in</a> | E-Mail -
                                                        <a href="#">info@protocollabels.in</a>
                                                    </p>


                                                </td>
                                            </tr>

                                        </tbody>

                                    </table>
                                </div>
                            </div>
                            <div class="carousel-item ">
                                <div class="main-page">
                                    <table class="protocol-template-table" style="padding:0;">
                                        <tbody>
                                            <tr class="border_bottom-brown">
                                                <td colspan="2">
                                                    <div class="logo" style="height:110px;width:130px;">
                                                        <img src="{{ URL::asset('assets/images/protocol_logo.jpg') }}"
                                                            alt="" class=""
                                                            style="height:100%;width:100%;margin: 25px 0px 0px 60px;">
                                                    </div>
                                                </td>
                                                <td colspan="6" align="right" style="padding: 0px 80px 0px 0px;">
                                                    <h6 class="text-sky_blue " style="margin-top:50px">Protocol Labels
                                                        India
                                                        Private Limited</h6>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" style="padding: 20px 80px;">
                                                    <table>
                                                        <tbody>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-8">
                                                                    <b class="f-13">
                                                                        INTELLECTUAL PROPERTY RIGHTS
                                                                    </b>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-8">
                                                                    <p class="p-0 m-0">
                                                                        All Industrial and intellectual property rights,
                                                                        including but not limited to patent rights, design
                                                                        rights,
                                                                        copyrights, and related rights, database rights,
                                                                        trademark rights, and chip rights, ensuring within
                                                                        the framework of the work performed by you during
                                                                        your employment with the company, will be
                                                                        exclusively vested in Company. You may not
                                                                        independently during your employment and after
                                                                        termination discloses, multiply, use, manufacture,
                                                                        bring on the market or sell, lease, deliver or
                                                                        otherwise trade, offer on behalf of any third party
                                                                        or commission the registration of the results of
                                                                        your work. To the extent that such inventions are
                                                                        performed under the Company’s direction, you
                                                                        shall fully, freely, and immediately communicate any
                                                                        invention to the Company and all rights, title,
                                                                        and interest to any such invention (“Inventions”)
                                                                        shall be the sole property of the Company.
                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-8">
                                                                    <p class="p-0 m-0">
                                                                        In pursuance of the above
                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-8"
                                                                    style="padding-left:13px ">
                                                                    <p class="p-0 m-0">
                                                                        <span style="padding-right:5px ">A.</span>
                                                                        You will give the Company and its solicitors and/or
                                                                        its patent attorneys all necessary
                                                                        assistance and cooperation in connection with the
                                                                        preparation and prosecution of any
                                                                        application for patent, design, registration, or
                                                                        copyright by the Company in respect of the
                                                                        Invention.
                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-8"
                                                                    style="padding-left:13px ">
                                                                    <p class="p-0 m-0">
                                                                        <span style="padding-right:5px ">B.</span>
                                                                        You irrevocably appoint the Company and any
                                                                        directors of the Company jointly and
                                                                        severally your true and lawful attorney to execute
                                                                        all such documents and do all such things
                                                                        as in the opinion of the Company may be necessary or
                                                                        requisite for any such purpose.


                                                                    </p>
                                                                </td>
                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-10">
                                                                    <b class="f-13">
                                                                        NON-DISCLOSURE AGREEMENT
                                                                    </b>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-8">
                                                                    <p class="p-0 m-0">
                                                                        During the employment, the employee shall not
                                                                        directly or indirectly carry on, assist, engage in,
                                                                        be
                                                                        concerned or participate in any business/activity
                                                                        (whether directly or indirectly, as a partner,
                                                                        shareholder, principal, agent, director, affiliate,
                                                                        Consultant or in any other capacity or manner
                                                                        whatsoever) which is similar to the business of the
                                                                        Company, nor engage in any activity that conflicts
                                                                        with the employee's obligations to the Company.

                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-8">
                                                                    <p class="p-0 m-0">
                                                                        Solicit Business: During the Term and for a period
                                                                        of 12 months after the Term, the employee shall
                                                                        not solicit, endeavor to solicit, influence or
                                                                        attempt to influence any client, customer or other
                                                                        Person, directly or indirectly, to direct his or its
                                                                        purchase of the Company's product and/or services,
                                                                        to self or any Person in competition with the
                                                                        business of the Company.
                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-8">
                                                                    <p class="p-0 m-0">
                                                                        Solicit Personnel: During the Term and for a period
                                                                        of 12 months after the Term, the Employee shall
                                                                        not solicit or attempt to influence any person
                                                                        employed or engaged by the Company (whether as
                                                                        an Employee, Consultant, Advisor or in any other
                                                                        manner) or engagement with the Company or
                                                                        become the Consultant of or directly or indirectly
                                                                        offer services in any form or manner to himself or
                                                                        any Person who is a competitor of the Company
                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-8">
                                                                    <b class="f-13">
                                                                        TERMINATION
                                                                    </b>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-8">
                                                                    <p class="p-0 m-0">
                                                                        Your employment may be terminated at any time by
                                                                        yourself, or by the Company, upon providing
                                                                        one (1) month written notice to the other party.
                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-8"
                                                                    style="padding-bottom: 35px">
                                                                    <p class="p-0 m-0">
                                                                        In the case of the Company terminating, you for
                                                                        reasons other than a breach of contract by you or
                                                                        for any disciplinary reasons against you, the
                                                                        Company shall pay you one month’s salary equal to
                                                                        your notice period not worked as payment in lieu of
                                                                        notice.
                                                                    </p>
                                                                </td>

                                                            </tr>
                                                        </tbody>

                                                    </table>
                                                </td>
                                            </tr>
                                            <tr class="border_top-brown">
                                                <td align="center" colspan="8" style="padding: 0px 80px">

                                                    <p style="text-align: unset">
                                                        <span class="text-ash text-strong border_bottom-ash">Registered
                                                            Office Address</span> -<span
                                                            class="text-sky_blue text-strong">Protocol Labels India Private
                                                            Limited</span>, S
                                                        No-166, 3rd Floor, 3A & 3B, Porur
                                                        Kundarthur Main Road, Gerugambakkam, Chennai – 600128, Tamil Nadu,
                                                        India.
                                                        Website - <a href="#"> www.protocollabels.in</a> | E-Mail -
                                                        <a href="#">info@protocollabels.in</a>
                                                    </p>


                                                </td>
                                            </tr>

                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <div class="carousel-item ">
                                <div class="main-page">
                                    <table class="protocol-template-table" style="padding:0;">
                                        <tbody>
                                            <tr class="border_bottom-brown">
                                                <td colspan="2">
                                                    <div class="logo" style="height:110px;width:130px;">
                                                        <img src="{{ URL::asset('assets/images/protocol_logo.jpg') }}"
                                                            alt="" class=""
                                                            style="height:100%;width:100%;margin: 25px 0px 0px 60px;">
                                                    </div>
                                                </td>
                                                <td colspan="6" align="right" style="padding: 0px 80px 0px 0px;">
                                                    <h6 class="text-sky_blue " style="margin-top:50px">Protocol Labels
                                                        India
                                                        Private Limited</h6>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" style="padding: 20px 80px;">
                                                    <table>
                                                        <tbody>

                                                            <tr class="">
                                                                <td colspan="8" align="left"
                                                                    class="pad-bottom-10 pad-top-25">
                                                                    <p class="p-0 m-0">
                                                                        If you seek to terminate your employment with the
                                                                        company, you shall do a proper hand over of all
                                                                        the work and responsibilities that you are handling
                                                                        to your manager and the resource identified for
                                                                        replacing you, to the satisfaction of your manager.
                                                                    </p>
                                                                </td>

                                                            </tr>

                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-bottom-10">
                                                                    <p class="p-0 m-0">
                                                                        In case you are handling a large product or
                                                                        responsibility, you need to give the company
                                                                        sufficient
                                                                        notice of at least 3 months to ensure a smooth
                                                                        transition to your next subordinate or successor.
                                                                    </p>
                                                                </td>

                                                            </tr>

                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-bottom-25">
                                                                    <p class="p-0 m-0">
                                                                        Up on termination of your employment with the
                                                                        company, you agree not to solicit any other team
                                                                        members in the company to the new organization that
                                                                        you are going.

                                                                    </p>
                                                                </td>

                                                            </tr>

                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-bottom-8">
                                                                    <b class="f-13">
                                                                        DISPUTE RESOLUTION
                                                                    </b>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left"
                                                                    class="pad-top-8 pad-bottom-10">
                                                                    <p class="p-0 m-0">
                                                                        Any differences and disputes arising out of this
                                                                        appointment letter would be settled by Arbitration
                                                                        conducted in accordance with the arbitration and
                                                                        conciliation act 1996 with a person nominated by
                                                                        the company as the sole arbitrator. The arbitrator
                                                                        shall conclude the arbitration within 30 days from
                                                                        the date of reference and shall pass an award. The
                                                                        award passed by the arbitrator shall be conclusive
                                                                        and binding on the parties and shall not be
                                                                        appealable before a court of law.

                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-10">
                                                                    <b class="f-13">
                                                                        GOVERNING LAW AND JURISDICTION

                                                                    </b>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-8">
                                                                    <p class="p-0 m-0">
                                                                        This agreement shall be governed by the laws of the
                                                                        republic of India and courts in Chennai have
                                                                        exclusive jurisdiction over this agreement.
                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-25">
                                                                    <b class="f-13">
                                                                        RETIREMENT AGE
                                                                    </b>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-bottom-25">
                                                                    <p class="p-0 m-0">
                                                                        The general Retirement for employees in the Company
                                                                        is Fifty-Eight (58) years.
                                                                    </p>
                                                                </td>

                                                            </tr>

                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-8">
                                                                    <b class="f-13">Yours faithfully,</b>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-8">
                                                                    <b class="f-13">For Protocol Labels India Private
                                                                        Limited</b>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-8">
                                                                    <div class="signature-content"
                                                                        style="height:40px;width:180px;">
                                                                        <img src="{{ URL::asset('assets/images/protocol_ceoSign.svg') }}"
                                                                            alt="" class=""
                                                                            style="height:100%;width:100%;">
                                                                    </div>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="">
                                                                    <p class="p-0 m-0"><b>P D DHANASEKAR</b>
                                                                    </p>

                                                                </td>

                                                            </tr>
                                                            <tr class="" style="">
                                                                <td colspan="8" align="left" class="">
                                                                    <p class="p-0 m-0"> <b> Managing Director</b></p>
                                                                </td>
                                                            </tr>
                                                            <tr class="" style="height: 0px;">
                                                                <td colspan="8" align="left" class=""
                                                                    style="border-bottom: 1px solid #000">
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left" class="pad-top-25">
                                                                    <p class="p-0 m-0">
                                                                        <b>I Muthuselvan B</b> , have read <b>ANNEXURE</b> A
                                                                        & B, understood, and accept the appointment upon the
                                                                        terms and conditions as outlined in this appointment
                                                                        letter for my position at <b>Protocol Labels India
                                                                            Private Limited</b> .
                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="4" align="left" class="pad-top-10"
                                                                    style="padding-bottom:100px ">
                                                                    <p class="p-0 m-0 text-left">
                                                                        <b class="">Sign:</b>

                                                                    </p>
                                                                </td>
                                                                <td colspan="4" align="" class="pad-top-10"
                                                                    style="padding-bottom:100px ">
                                                                    <p class="p-0 m-0 text-right">
                                                                        <b class="">Date:</b>
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr class="border_top-brown">
                                                <td align="center" colspan="8" style="padding: 0px 80px">

                                                    <p style="text-align: unset">
                                                        <span class="text-ash text-strong border_bottom-ash">Registered
                                                            Office Address</span> -<span
                                                            class="text-sky_blue text-strong">Protocol Labels India Private
                                                            Limited</span>, S
                                                        No-166, 3rd Floor, 3A & 3B, Porur
                                                        Kundarthur Main Road, Gerugambakkam, Chennai – 600128, Tamil Nadu,
                                                        India.
                                                        Website - <a href="#"> www.protocollabels.in</a> | E-Mail -
                                                        <a href="#">info@protocollabels.in</a>
                                                    </p>


                                                </td>
                                            </tr>

                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <div class="carousel-item ">
                                <div class="main-page">
                                    <table class="protocol-template-table" style="padding:0;">
                                        <tbody>
                                            <tr class="border_bottom-brown">
                                                <td colspan="2">
                                                    <div class="logo" style="height:110px;width:130px;">
                                                        <img src="{{ URL::asset('assets/images/protocol_logo.jpg') }}"
                                                            alt="" class=""
                                                            style="height:100%;width:100%;margin: 25px 0px 0px 60px;">
                                                    </div>
                                                </td>
                                                <td colspan="6" align="right" style="padding: 0px 80px 0px 0px;">
                                                    <h6 class="text-sky_blue " style="margin-top:50px">Protocol Labels
                                                        India
                                                        Private Limited</h6>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" style="padding: 20px 80px;">
                                                    <table>
                                                        <tbody>
                                                            <tr class="">
                                                                <td colspan="8" align="center" class="pad-top-10">
                                                                    <b class="f-13"
                                                                        style="border-bottom:1px solid #000">
                                                                        Schedule II – OKR
                                                                    </b>
                                                                </td>

                                                            </tr>
                                                            <tr class="">
                                                                <td colspan="8" align="left"
                                                                    class="pad-top-10 pad-bottom-25">
                                                                    <b class="f-13"
                                                                        style="border-bottom:1px solid #000">
                                                                        Objective:

                                                                    </b>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td colspan="8" style="padding: 0px">
                                                                    <table style="font-size:13px" contenteditable="true">
                                                                        <tbody>

                                                                            <tr>
                                                                                <td style="padding: 0px 10px"
                                                                                    colspan="8">
                                                                                    <ol>
                                                                                        <li style="margin-bottom:10px">

                                                                                            Achieve Revenue Targets through
                                                                                            selling Traceability and
                                                                                            Tracking Solutions to large
                                                                                            Manufacturing Industries,
                                                                                            Enterprises of various business
                                                                                            segments, as Turnkey Projects.
                                                                                        </li>
                                                                                        <li style="margin-bottom:10px">
                                                                                            Build lifetime value from
                                                                                            existing and acquiring new
                                                                                            Corporate Key Accounts based on
                                                                                            offering solutions, and
                                                                                            services.</li>
                                                                                        <li style="margin-bottom:10px">
                                                                                            Achieve effective planning for
                                                                                            procurement of outsourced
                                                                                            Hardware, and maintenance of
                                                                                            Hardware stock inventories.
                                                                                            .</li>
                                                                                    </ol>

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
                                                <td colspan="8" style="padding:0px 80px 20px 80px;">
                                                    <table>
                                                        <tbody>

                                                            <tr class="">
                                                                <td colspan="8" align="left"
                                                                    class="pad-top-10 pad-bottom-25">
                                                                    <b class="f-13"
                                                                        style="border-bottom:1px solid #000">
                                                                        Key Results:
                                                                    </b>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td colspan="8" style="padding: 0px">
                                                                    <table style="font-size:13px">
                                                                        <tbody>

                                                                            <tr contenteditable="true">
                                                                                <td style="padding: 0px 10px"
                                                                                    colspan="8">
                                                                                    <ol>
                                                                                        <li style="margin-bottom:10px">
                                                                                            <b>Key Result 1 </b>
                                                                                            – Achieve a Financial year
                                                                                            revenue target of INR 6.5Crores
                                                                                            through your Sale
                                                                                            of Hardware and Software to
                                                                                            Individual Clients,
                                                                                            Key-Accounts, and Turn-Key
                                                                                            Projects.
                                                                                            (INR6.5 Crores is the team
                                                                                            target with a team size of 1+3
                                                                                            Which includes your Individual
                                                                                            Target of INR.3.5Crore
                                                                                        </li>
                                                                                        <li style="margin-bottom:10px">
                                                                                            <b>Key Result 2 </b>
                                                                                            – Achieve an Average Gross
                                                                                            Margin
                                                                                            of a minimum of 12% on the sales
                                                                                            of
                                                                                            Hardware and a 25% Average Gross
                                                                                            Margin on Software Products.
                                                                                        </li>
                                                                                        <li style="margin-bottom:10px">
                                                                                            <b>Key Result 3 </b>
                                                                                            – Expand the market
                                                                                            geographically
                                                                                            across Tamilnadu, and South
                                                                                            India with a
                                                                                            consistent growth percentage
                                                                                            which involves market
                                                                                            penetration & domain dominance
                                                                                            constantly evolving from time to
                                                                                            time.
                                                                                            .
                                                                                        </li>
                                                                                        <li style="margin-bottom:10px">
                                                                                            <b>Key Result 4</b>
                                                                                            – Maintaining a timely
                                                                                            collection of Accounts
                                                                                            Receivable (Outstanding
                                                                                            Payments) before the due dates
                                                                                            of approved credit line of value
                                                                                            and credit period.

                                                                                        </li>
                                                                                    </ol>

                                                                                </td>
                                                                            </tr>

                                                                            <tr class="">
                                                                                <td colspan="8" align="left"
                                                                                    class="pad-top-8">
                                                                                    <b class="f-13">Yours faithfully,</b>
                                                                                </td>

                                                                            </tr>
                                                                            <tr class="">
                                                                                <td colspan="8" align="left"
                                                                                    class="pad-top-8">
                                                                                    <b class="f-13">For Protocol Labels
                                                                                        India Private
                                                                                        Limited</b>
                                                                                </td>

                                                                            </tr>
                                                                            <tr class="">
                                                                                <td colspan="8" align="left"
                                                                                    class="pad-top-8">
                                                                                    <div class="signature-content"
                                                                                        style="height:40px;width:180px;">
                                                                                        <img src="{{ URL::asset('assets/images/protocol_ceoSign.svg') }}"
                                                                                            alt="" class=""
                                                                                            style="height:100%;width:100%;">
                                                                                    </div>
                                                                                </td>

                                                                            </tr>
                                                                            <tr class="">
                                                                                <td colspan="8" align="left"
                                                                                    class="">
                                                                                    <p class="p-0 m-0"><b>P D
                                                                                            DHANASEKAR</b>
                                                                                    </p>

                                                                                </td>

                                                                            </tr>
                                                                            <tr class="" style="">
                                                                                <td colspan="8" align="left"
                                                                                    class="">
                                                                                    <p class="p-0 m-0"> <b> Managing
                                                                                            Director</b></p>
                                                                                </td>
                                                                            </tr>
                                                                            <tr class="" style="height: 0px;">
                                                                                <td colspan="8" align="left"
                                                                                    class=""
                                                                                    style="border-bottom: 1px solid #000">
                                                                                </td>

                                                                            </tr>
                                                                            <tr class="">
                                                                                <td colspan="8" align="left"
                                                                                    class="pad-top-25">
                                                                                    <p class="p-0 m-0">
                                                                                        <b>I Muthuselvan B</b> , have read
                                                                                        <b>ANNEXURE</b> A
                                                                                        & B, understood, and accept the
                                                                                        appointment upon the
                                                                                        terms and conditions as outlined in
                                                                                        this appointment
                                                                                        letter for my position at
                                                                                        <b>Protocol Labels India
                                                                                            Private Limited</b> .
                                                                                    </p>
                                                                                </td>

                                                                            </tr>
                                                                            <tr class="">
                                                                                <td colspan="4" align="left"
                                                                                    class="pad-top-10"
                                                                                    style="padding-bottom:40px ">
                                                                                    <p class="p-0 m-0 text-left">
                                                                                        <b class="">Sign:</b>
                                                                                        {{-- <b class="text-right">Date:</b> --}}
                                                                                    </p>
                                                                                </td>
                                                                                <td colspan="4" align=""
                                                                                    class="pad-top-10"
                                                                                    style="padding-bottom:40px ">
                                                                                    <p class="p-0 m-0 text-right">

                                                                                        <b class="">Date:</b>
                                                                                    </p>
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
                                            <tr class="border_top-brown">
                                                <td align="center" colspan="8" style="padding: 0px 80px">

                                                    <p style="text-align: unset">
                                                        <span class="text-ash text-strong border_bottom-ash">Registered
                                                            Office Address</span> -<span
                                                            class="text-sky_blue text-strong">Protocol Labels India Private
                                                            Limited</span>, S
                                                        No-166, 3rd Floor, 3A & 3B, Porur
                                                        Kundarthur Main Road, Gerugambakkam, Chennai – 600128, Tamil Nadu,
                                                        India.
                                                        Website - <a href="#"> www.protocollabels.in</a> | E-Mail -
                                                        <a href="#">info@protocollabels.in</a>
                                                    </p>


                                                </td>
                                            </tr>

                                        </tbody>

                                    </table>
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
                                        <tr class="border-less">
                                            <td class="border-less " colspan="12" style="padding-bottom:50px">
                                                <img src="{{ URL::asset('assets/images/header_protocolo.svg') }}" class="" alt=""
                                                style="width:100%;height:100%;">
                                            </td>
                                        </tr>
                                        <tr class="header-row" aria-rowcount="">
                                            <td colspan="8" class="  p3" rowspan="" style="border-right: 0px">
                                                <div class="header-cotent">

                                                    <p class="margin-0   text-strong"
                                                        style="color: #002f56;
                                                    font-size: 18px;
                                                    padding-left: 5px;">
                                                        Protocol Labels India Pvt. Ltd.</p>
                                                        <p class="margin_b0">166, Gerugambakkam, Bharathi Nagar,</p>
                                                        <p class="margin_b0">#3rd floor, S plot no 3A&3B, </p>
                                                    <p class="margin_b0">Porur, Chennai, Tamil Nadu 600128.</p>

                                                </div>
                                            </td>
                                            <td colspan="4" class=" " style="border-left: 0px">

                                                <div class="header-img txt-right "
                                                    style="height:100px ;width:100%">

                                                    <img src="{{ URL::asset('assets/images/protocol_logo.png') }}" class="txt-right"
                                                        alt=""
                                                        style="height: 100px;width:110px;margin-top: -36px;
                                                        margin-right: 20px;">
                                                </div>


                                            </td>
                                        </tr>


                                        <tr>
                                            <td colspan="12" class=" bg-ash">
                                                <p class=" txt-center text-navyBlue  text-strong">PAYSLIP FOR THE MONTH OF &ndash;
                                                    </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-navyBlue  bg-ash text-strong">
                                                <p>EMPLOYEE NAME</p>
                                            </td>
                                            <td colspan="3">
                                                <p></p>
                                            </td>
                                            <td colspan="3" class="text-navyBlue  bg-ash text-strong">
                                                <p>EMPLOYEE CODE</p>
                                            </td>
                                            <td colspan="3">
                                                <p></p>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-navyBlue bg-ash text-strong">
                                                <p>DATE OF BIRTH</p>
                                            </td>
                                            <td colspan="3">
                                               <p></p>
                                            </td>
                                            <td colspan="3" class="text-navyBlue bg-ash text-strong">
                                                <p>DATE OF JOINING</p>
                                            </td>
                                            <td colspan="3">
                                              <p></p>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-navyBlue bg-ash text-strong">
                                                <p>DESIGNATION</p>
                                            </td>
                                            <td colspan="3">
                                                <p></p>
                                            </td>
                                            <td colspan="3" class="text-navyBlue bg-ash text-strong">
                                                <p>LOCATION</p>
                                            </td>
                                            <td colspan="3">
                                                <p></p>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-navyBlue bg-ash text-strong">
                                                <p>EPF NUMBER</p>
                                            </td>
                                            <td colspan="3">
                                               <p></p>
                                            </td>
                                            <td colspan="3" class="text-navyBlue bg-ash text-strong">
                                                <p>ESIC NUMBER</p>
                                            </td>
                                            <td colspan="3">
                                               <p></p>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-navyBlue bg-ash text-strong">
                                                <p>UAN</p>
                                            </td>
                                            <td colspan="3">
                                            <p></p>
                                            </td>
                                            <td colspan="3" class="text-navyBlue bg-ash text-strong">
                                                <p>PAN</p>
                                            </td>
                                            <td colspan="3">
                                                <p></p>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-navyBlue bg-ash ">
                                                <p class="text-strong txt-center">BANK NAME</p>
                                            </td>

                                            <td colspan="4" class="text-navyBlue bg-ash ">
                                                <p class="text-strong txt-center">ACCOUNT NUMBER</p>
                                            </td>
                                            <td colspan="4" class="text-navyBlue bg-ash ">
                                                <p class="text-strong txt-center">IFSC CODE</p>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td colspan="4" class="">
                                              <p></p>
                                            </td>
                                            <td colspan="4" class="">
                                               <p></p>
                                            </td>
                                            <td colspan="4" class="">
                                               <p></p>
                                            </td>


                                        </tr>

                                        <tr>
                                            <td colspan="3" class="text-navyBlue bg-ash ">
                                                <p class="text-strong txt-center">MONTH DAYS</p>
                                            </td>

                                            <td colspan="3" class="text-navyBlue bg-ash ">
                                                <p class="text-strong txt-center">WORKED DAYS</p>
                                            </td>
                                            <td colspan="3" class="text-navyBlue bg-ash ">
                                                <p class="text-strong txt-center">LOSS OF PAY</p>
                                            </td>
                                            <td colspan="3" class="text-navyBlue bg-ash ">
                                                <p class="text-strong txt-center">ARREAR DAYS</p>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td colspan="3" class="">
<p></p>
                                            </td>
                                            <td colspan="3" class="">
<p></p>
                                            </td>
                                            <td colspan="3" class="">
<p></p>
                                            </td>
                                            <td colspan="3" class="">
<p></p>
                                            </td>

                                        <tr>
                                            <td colspan="12">
                                                <p class="padding-md">&nbsp; </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-navyBlue bg-ash">
                                                <p class="txt-center text-strong">DESCRIPTION</p>
                                            </td>
                                            <td colspan="2" class="text-navyBlue bg-ash">
                                                <p class="txt-center text-strong">AMOUNT</p>
                                            </td>
                                            <td colspan="2" class="text-navyBlue bg-ash">
                                                <p class="txt-center text-strong">ARREAR AMOUNT</p>
                                            </td>
                                            <td colspan="2" class="text-navyBlue bg-ash">
                                                <p class="txt-center text-strong">EARNED AMOUNT</p>
                                            </td>
                                            <td colspan="2" class="text-navyBlue bg-ash">
                                                <p class="txt-center text-strong">DEDUCTION</p>
                                            </td>
                                            <td colspan="2" class="text-navyBlue bg-ash">
                                                <p class="txt-center text-strong">AMOUNT</p>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td colspan="2" class="">
                                                <p class="txt-left text-strong">BASIC</p>
                                            </td>
                                            <td colspan="2" class="">
                                              <p></p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p></p>
                                            </td>
                                            <td colspan="2" class="">
                                               <p></p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-left text-strong">EPF</p>
                                            </td>
                                            <td colspan="2" class="">
                                               <p></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="">
                                                <p class="txt-left text-strong">HRA</p>
                                            </td>
                                            <td colspan="2" class="">
                                               <p></p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p></p>
                                            </td>
                                            <td colspan="2" class="">
                                               <p></p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-left text-strong">ESIC</p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="">
                                                <p class="txt-left text-strong">SPECIAL ALLOWANCE</p>
                                            </td>
                                            <td colspan="2" class="">
                                               <p></p>
                                            </td>
                                            <td colspan="2" class="">
                                              <p></p>
                                            </td>
                                            <td colspan="2" class="">
                                              <p></p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-left text-strong">PROF TAX</p>
                                            </td>
                                            <td colspan="2" class="">
                                               <p></p>
                                            </td>


                                        </tr>

                                        <tr>
                                            <td colspan="2" class="">
                                                <p class="txt-left text-strong"> OVERTIME</p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-right"></p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-right"></p>
                                            </td>

                                            <td colspan="2" class="">
                                              <p></p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-left text-strong">INCOME TAX</p>
                                            </td>
                                            <td colspan="2" class="">
                                               <p></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="">
                                                <p class="txt-left text-strong"> OTHER EARNINGS</p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-right"></p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-right"></p>
                                            </td>

                                            <td colspan="2" class="">
                                               <p></p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-left text-strong">SALARY ADVANCE</p>
                                            </td>
                                            <td colspan="2" class="">
                                               <p></p>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="2" class="">
                                                <p class="txt-left text-navyBlue text-strong">TRAVAL CONVEYANCE</p>
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
                                                <p class="txt-left text-navyBlue text-strong">OTHER DEDUCTIONS</p>
                                            </td>
                                            <td colspan="2" class="">
                                             <p></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="bg-ash">
                                                <p class="txt-left nav text-strong text-navyBlue">TOTAL EARNINGS</p>
                                            </td>
                                            <td colspan="2" class="bg-ash">
                                             <p></p>
                                            </td>
                                            <td colspan="2" class="bg-ash">
                                                <p class="txt-right"></p>
                                            </td>

                                            <td colspan="2" class="bg-ash">
                                              <p></p>
                                            </td>
                                            <td colspan="2" class="bg-ash">
                                                <p class="txt-left text-strong text-navyBlue">TOTAL DEDUCTION</p>
                                            </td>
                                            <td colspan="2" class="bg-ash">
                                               <p></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="12">
                                                <p class="padding-md">&nbsp; </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-navyBlue bg-ash">
                                                <p class="txt-left text-strong">NET PAY</p>
                                            </td>
                                            <td colspan="8" class="">
                                               <p></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-navyBlue bg-ash">
                                                <p class="txt-left text-strong">NET PAY IN WORDS</p>
                                            </td>
                                            <td colspan="8" class="">
                                             <p></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="12">
                                                <p class="padding-md">&nbsp; </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-navyBlue bg-ash">
                                                <p class="txt-center text-strong">TRANSACTION ID</p>
                                            </td>
                                            <td colspan="3" class="">
                                                <p class="txt-center"></p>
                                            </td>
                                            <td colspan="3" class="text-navyBlue bg-ash">
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
                                            <td colspan="12" class="bg-ash">
                                                <p class="padding-md txt-center">Leave Details</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class=" bg-ash">
                                                <p class="txt-center text-navyBlue text-strong">Leave's Type</p>
                                            </td>
                                            <td colspan="3" class=" bg-ash">
                                                <p class="txt-center text-navyBlue text-strong">Opening Balance</p>
                                            </td>
                                            <td colspan="3" class=" bg-ash">
                                                <p class="txt-center text-navyBlue text-strong">Availed Balance</p>
                                            </td>
                                            <td colspan="3" class=" bg-ash">
                                                <p class="txt-center text-strong">Closing Balance</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class=" bg-ash">
                                                <p class="txt-center text-strong">Casual Leave</p>
                                            </td>
                                            <td colspan="3" class="">
                                                <p class="txt-center"></p>
                                            </td>
                                            <td colspan="3" class="">
                                                <p class="txt-center text-strong"></p>
                                            </td>
                                            <td colspan="3" class="">
                                                <p class="txt-center"></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class=" bg-ash">
                                                <p class="txt-center text-strong">Sick Leave</p>
                                            </td>
                                            <td colspan="3" class="">
                                                <p class="txt-center"></p>
                                            </td>
                                            <td colspan="3" class="">
                                                <p class="txt-center text-strong"></p>
                                            </td>
                                            <td colspan="3" class="">
                                                <p class="txt-center"></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class=" bg-ash">
                                                <p class="txt-center text-strong">Earned Leave</p>
                                            </td>
                                            <td colspan="3" class="">
                                                <p class="txt-center"></p>
                                            </td>
                                            <td colspan="3" class="">
                                                <p class="txt-center text-strong"></p>
                                            </td>
                                            <td colspan="3" class="">
                                                <p class="txt-center"></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="12">
                                                <p class="txt-center">This is a computer-generated slip does not require signature</p>
                                            </td>
                                        </tr>

                                        <tr class="border-less">
                                            <td colspan="8" class="border-less" style="    padding: 10px 0px;">
                                                <p class="txt-left">Please
                                                    reach out to us for any payroll queries at -payroll@ardens.in</p>
                                            </td>
                                            <td colspan="3" class="border-less txt-right" style="    padding: 10px 0px;">
                                                <p>Generated By</p>


                                            </td>
                                            <td colspan="1" class="border-less" style="    padding: 10px 0px;">
                                                <img src="{{ URL::asset('assets/images/client_logos/ardens/evangelist.png') }}" width="80px" height="15px"
                                                alt="" class="">
                                            </td>
                                        </tr>

                                        <tr class="border-less">
                                            <td colspan="12" class="border-less">
                                                <img src="{{ URL::asset('assets/images/footerProtocolImg_payslip.svg') }}" class="" alt=""
                                                style="height:100%;width:100%;">
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
