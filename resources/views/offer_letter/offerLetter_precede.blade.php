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

        table {
            width: 100%;
            vertical-align: middle;
            font-family: sans-serif;
        }

        .payslip_table tr,
        td {
            border: 1.5pt solid #ce081e;

        }

        .precede_primary_color {
            color: #ce081e;
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

        .header-cotent p.brand-name {
            font-weight: 600;
            color: #ce081e;
            font-size: 16px;
        }

        .f-11 {
            font-size: 11px !important;
        }

        .brand-name {
            color: #ce081e;
        }

        .fw-600 {
            font-weight: 600;
        }

        table.letter-format tr td,
        table.letter-format tr {

            border: 0;
            font-size: 14px;
        }

        table.letter-format tr td p {
            font-size: 14px;

            margin-top: 3pt;
            margin-bottom: 3pt;
            padding-right: 5px;
            padding-left: 5px;
        }

        .pt-pb-5 {
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .pb-5 {

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

        .pb-pt-15 {
            padding-bottom: 15px;
            padding-top: 15px;
        }


        table.salary-table tr td {
            border-collapse: collapse;
            border: 1px solid;
            border-radius: 0px !important;
        }

        .border-bottom-line {
            border-bottom: 1px solid #000 !important;
        }

        .border-bottom-line2 {
            border-bottom: 2px solid #000 !important;
        }

        .margin-0 {
            margin: 0px;
        }

        .padding-0 {
            padding: 0px;
        }

        .bg-orange {
            background-color: #ff761b;

        }

        .bg-dark_ash {
            background-color: #777171;
        }

        .bg-dark_blue {
            background-color: #002160;
        }

        .c_white {
            color: #ffffff;
        }
    </style>
@endsection
@section('content')
    <div class="card left-line mt-30 mb-2 ">
        <div class="card-body pb-0 pt-1 ">

            <ul class="nav nav-pills    nav-tabs-dashed" id="pills-tab" role="tablist">
                <li class="nav-item active ember-view me-4" role="presentation">
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
    <div class="card mb-0">
        <div class="tab-content ">
            <div class="tab-pane fade show active" id="appointment" role="tabpanel" aria-labelledby="pills-home-tab">
                <div id="carouselExampleControlsNoTouching" class="carousel slide" data-bs-touch="false"
                    data-bs-interval="false">
                    <div class="carousel-inner">
                        <div class="carousel-item ">
                            <div class="main-page appointment-letter">
                                <div class="sub-page" style="text-align: justify;font-size: 15px;">
                                    <table class="letter-format" style="padding:0;" contenteditable="true">
                                        <tbody>
                                            <tr>
                                                <td align="left" class="pb-30" colspan="8">
                                                    <img src="{{ URL::asset('assets/images/precede.png') }}" class=""
                                                        alt="user-pic" style="height:55px;width:180px;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" style=" " align="left">
                                                    <p class="fw-600 pt-pb-5 txt-left " style="">
                                                        Date: <span class="fw-600 ">MM/DD/YYYY</span>
                                                    </p>
                                                    <p class="fw-600 pb-pt-15 ">To,</p>
                                                    <p class=" fw-600" style="">
                                                        Xyz
                                                    </p>
                                                    <p class="fw-600  " style="">
                                                        Yyy
                                                    </p>


                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="8" style=" " class="pt-pb-10" align="left">
                                                    <span class="fw-600 border-bottom-line  txt-left " style="">
                                                        Sub: Offer Letter

                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" style=" " class="" align="left">
                                                    <p class="">We are pleased to offer you the position of
                                                        &nbsp;<span class="fw-600 txt-left"> Xyz </span>&nbsp; with our
                                                        client &nbsp;<span class="fw-600 txt-left"> &nbsp;<span
                                                                class="fw-600 txt-left"> Leather Sector Skill
                                                                Council.</span>&nbsp;
                                                            We are all excited about the potential that you will bring to
                                                            our
                                                            organization.

                                                    </p>
                                                    <p class="pt-pb-10">
                                                        As we discussed during your interviews, you will be functionally
                                                        reporting to the &nbsp;<span class="fw-600 txt-left"> Functional
                                                            Head, at Leather Sector Skill Council,
                                                            Nungambakkam </span>&nbsp; Office
                                                    </p>
                                                    <p class="">
                                                        Your initial compensation package includes an annual salary of INR ₹
                                                        &nbsp;<span class="fw-600 txt-left"> Xyz </span>&nbsp;


                                                    </p>
                                                    <p class=" pt-pb-10">
                                                        You are required to join us latest by the &nbsp;<span
                                                            class="fw-600 txt-left"> MM-DD-YYYY </span>&nbsp;, beyond which
                                                        this offers stands canceled unless otherwise, either party
                                                        communicates the said delay beforehand.

                                                    </p>
                                                    <p class="">
                                                        We look forward to your arrival as an employee of our organization
                                                        and are confident that you will play a key role in our company’s
                                                        expansion into national and international markets

                                                    </p>
                                                    <p class=" pt-pb-10">
                                                        Your detailed appointment letter will be issued to you at the time
                                                        of your joining. If this employment offer is acceptable to you,
                                                        please sign a copy of this letter and return it to us by &nbsp;<span
                                                            class="fw-600 txt-left"> MM-DD-YYYY </span>&nbsp;

                                                    </p>
                                                    <p class="pb-pt-15 ">
                                                        Yours truly,

                                                    </p>
                                                    <p>
                                                        For &nbsp;<span class="fw-600 txt-left"> Precede Workforce Solutions
                                                            India Private Limited,</span>&nbsp;
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" style=" " class="" align="left">

                                                    <div style="margin-right:10px;"> <img
                                                        src="{{ URL::asset('assets/images/appointment/precede/signature.png') }}"
                                                        class="" alt=""
                                                        style="height:50px;width:150px;"> </div>

                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="8" style=" " class="" align="left">
                                                    <p class="fw-600">David Siddharthan </p>
                                                    <p class="fw-600">Director
                                                    </p>

                                                </td>

                                            </tr>

                                            <tr>
                                                <td colspan="8" style=" " class="" align="left">
                                                    <p class=" pb-pt-15 ">I accept the above-mentioned employment offer and
                                                        acknowledge receiving a copy of the same.</p>


                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="8" style=" " class=" border-bottom-line2"
                                                    align="left">
                                                    <p class=" ">Signature</p>
                                                    <p class=" pb-pt-15 ">
                                                        Name: Xyz
                                                    </p>
                                                    <p>
                                                        Date

                                                    </p>

                                                </td>

                                            </tr>

                                            <tr>
                                                <td colspan="8" style=" " class="">
                                                    <p class="fw-600 txt-center  margin-0" style="font-size:">
                                                        PRECEDE WORKFORCE SOLUTIONS INDIA PRIVATE LIMITED
                                                    </p>
                                                    <p class=" txt-center margin-0"> <span class="f-11"> <span
                                                                class="precede_primary_color f-11 fw-600">CIN -
                                                            </span>U74900TN2015PTC100900</span> &nbsp; <span
                                                            class="f-11"> <span
                                                                class="precede_primary_color f-11  fw-600"> GSTIN -
                                                            </span>33AAICP1477F1ZH</span></p>
                                                    <p class="margin-0 txt-center"><span class="fw-600 ">Corporate Office:
                                                        </span>No-2/29, Vengaivasal Main Road, Santhosapuram, East Tambaram,
                                                        Chennai-600 073. </p>
                                                    <p class="margin-0 txt-center"><span class="fw-600 ">Branch Office:
                                                        </span> No-606, 1st B Main Road, Domlur, Bangalore -560071,
                                                        Karnataka, India.</p>
                                                    <div style="padding: 0px 5px;display:flex;font-size:95%;">
                                                        <div style="margin-right:10px;"> <img
                                                                src="{{ URL::asset('assets/images/appointment/precede/phone.jpg') }}"
                                                                class="" alt=""
                                                                style="height:20px;width:20px;">+91-44-2278 2288 </div>
                                                        <div style="margin-right:10px;"> <img
                                                                src="{{ URL::asset('assets/images/appointment/precede/mobile.jpg') }}"
                                                                class="" alt=""
                                                                style="height:20px;width:20px;">+91-97898 37408 </div>
                                                        <div style="margin-right:10px;"> <img
                                                                src="{{ URL::asset('assets/images/appointment/precede/mail.jpg') }}"
                                                                class="" alt=""
                                                                style="height:20px;width:20px;">info@precedehrsolutions.com
                                                        </div>
                                                        <div> <img
                                                                src="{{ URL::asset('assets/images/appointment/precede/computer.jpg') }}"
                                                                class="" alt=""
                                                                style="height:20px;width:20px;">www.precedehrsolutions.com
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>



                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item active">
                            <div class="main-page appointment-letter">
                                <div class="sub-page" style="text-align: justify;font-size: 15px;">
                                    <table class="letter-format" style="padding:0;" contenteditable="true">
                                        <tbody>
                                            <tr>
                                                <td align="left" class="pb-30" colspan="8">
                                                    <img src="{{ URL::asset('assets/images/precede.png') }}"
                                                        class="" alt="user-pic" style="height:55px;width:180px;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" style=" " align="left">

                                                    <table class="salary-table " style="padding:0;"
                                                        contenteditable="true">
                                                        <tbody>
                                                            <tr>
                                                                <td align="" class="" colspan="8">
                                                                    <p class="fw-600  txt-center " style="">
                                                                        ANNEXURE A
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="" class="" colspan="8">
                                                                    <p class="fw-600  txt-center " style="">
                                                                        SALARY STRUCTURE
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="" class="" colspan="8">
                                                                    <p class="fw-600  txt-center  " style="">
                                                                        Your remuneration shall be paid to you under the
                                                                        following heads
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="" class="bg-dark_blue" colspan="4">
                                                                    <p class="fw-600  txt-left c_white" style="">
                                                                        Name:
                                                                    </p>
                                                                </td>
                                                                <td align="" class="bg-dark_blue " colspan="4">
                                                                    <p class="fw-600  txt-center c_white " style="">
                                                                        Salary
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="" class="bg-dark_blue" colspan="6">
                                                                    <p class="fw-600 c_white txt-left " style="">
                                                                        Designation: Executive - Designing


                                                                    </p>
                                                                </td>
                                                                <td align="" class="bg-dark_blue" colspan="1">
                                                                    <p class="fw-600 c_white txt-center " style="">
                                                                        Per Month


                                                                    </p>
                                                                </td>
                                                                <td align="" class="bg-dark_blue" colspan="1">
                                                                    <p class="fw-600  c_white txt-center " style="">
                                                                        Per Annum


                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td align="" class="" colspan="6">
                                                                    <p class="  txt-left " style="">
                                                                        Basic


                                                                    </p>
                                                                </td>
                                                                <td align="" class="" colspan="1">
                                                                    <p class="  txt-right " style="">



                                                                    </p>
                                                                </td>
                                                                <td align="" class="" colspan="1">
                                                                    <p class="  txt-right " style="">

                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td align="" class="" colspan="6">
                                                                    <p class=" txt-left " style="">
                                                                        HRA
                                                                    </p>
                                                                </td>
                                                                <td align="" class="" colspan="1">
                                                                    <p class=" txt-right " style="">


                                                                    </p>
                                                                </td>
                                                                <td align="" class="" colspan="1">
                                                                    <p class="  txt-right " style="">

                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td align="" class="" colspan="6">
                                                                    <p class=" txt-left " style="">
                                                                        Special Allowance
                                                                    </p>
                                                                </td>
                                                                <td align="" class="" colspan="1">
                                                                    <p class=" txt-right " style="">


                                                                    </p>
                                                                </td>
                                                                <td align="" class="" colspan="1">
                                                                    <p class="  txt-right " style="">

                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td align="" class="" colspan="6">
                                                                    <p class=" txt-left " style="">
                                                                        Stats Bonus
                                                                    </p>
                                                                </td>
                                                                <td align="" class="" colspan="1">
                                                                    <p class=" txt-right " style="">


                                                                    </p>
                                                                </td>
                                                                <td align="" class="" colspan="1">
                                                                    <p class="  txt-right " style="">

                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td align="" class="bg-dark_blue " colspan="6">
                                                                    <p class="fw-600 c_white  txt-left " style="">
                                                                        Gross
                                                                    </p>
                                                                </td>
                                                                <td align="" class="bg-dark_blue" colspan="1">
                                                                    <p class="fw-600 c_white txt-right " style="">



                                                                    </p>
                                                                </td>
                                                                <td align="" class="bg-dark_blue" colspan="1">
                                                                    <p class="fw-600 c_white  txt-right " style="">



                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td align="" class="" colspan="6">
                                                                    <p class=" txt-left " style="">
                                                                        PF (Employer Contribution)
                                                                    </p>
                                                                </td>
                                                                <td align="" class="" colspan="1">
                                                                    <p class=" txt-right " style="">


                                                                    </p>
                                                                </td>
                                                                <td align="" class="" colspan="1">
                                                                    <p class="  txt-right " style="">

                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td align="" class="" colspan="6">
                                                                    <p class=" txt-left " style="">
                                                                        ESI (Employer Contribution)
                                                                    </p>
                                                                </td>
                                                                <td align="" class="" colspan="1">
                                                                    <p class=" txt-right " style="">


                                                                    </p>
                                                                </td>
                                                                <td align="" class="" colspan="1">
                                                                    <p class="  txt-right " style="">

                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td align="" class="bg-dark_blue" colspan="6">
                                                                    <p class="fw-600  txt-left c_white" style="">
                                                                        Cost to Company
                                                                    </p>
                                                                </td>
                                                                <td align="" class="bg-dark_blue" colspan="1">
                                                                    <p class="fw-600  txt-right c_white " style="">

                                                                    </p>
                                                                </td>
                                                                <td align="" class="bg-dark_blue" colspan="1">
                                                                    <p class="fw-600  txt-right c_white" style="">

                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td align="" class="" colspan="6">
                                                                    <p class=" txt-left " style="">
                                                                        EPF (Employee Contribution)
                                                                    </p>
                                                                </td>
                                                                <td align="" class="" colspan="1">
                                                                    <p class=" txt-right " style="">


                                                                    </p>
                                                                </td>
                                                                <td align="" class="" colspan="1">
                                                                    <p class="  txt-right " style="">

                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td align="" class="" colspan="6">
                                                                    <p class=" txt-left " style="">
                                                                        ESI (Employee Contribution)
                                                                    </p>
                                                                </td>
                                                                <td align="" class="" colspan="1">
                                                                    <p class=" txt-right " style="">


                                                                    </p>
                                                                </td>
                                                                <td align="" class="" colspan="1">
                                                                    <p class="  txt-right " style="">

                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td align="" class="" colspan="6">
                                                                    <p class=" txt-left " style="">
                                                                        Professional Tax
                                                                    </p>
                                                                </td>
                                                                <td align="" class="" colspan="1">
                                                                    <p class=" txt-right " style="">


                                                                    </p>
                                                                </td>
                                                                <td align="" class="" colspan="1">
                                                                    <p class="  txt-right " style="">

                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td align="" class="bg-dark_blue" colspan="6">
                                                                    <p class="fw-600  txt-left c_white" style="">
                                                                        Net Income
                                                                    </p>
                                                                </td>
                                                                <td align="" class="bg-dark_blue" colspan="1">
                                                                    <p class="fw-600  txt-right c_white " style="">

                                                                    </p>
                                                                </td>
                                                                <td align="" class="bg-dark_blue" colspan="1">
                                                                    <p class="fw-600  txt-right c_white" style="">

                                                                    </p>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td align="" class="" colspan="8">
                                                                    <p class=" txt-center " style="">
                                                                        Income Tax as applicable will be deducted
                                                                    </p>
                                                                </td>
                                                            </tr>

                                                        </tbody>

                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" class="pb-pt-15" style="border-bottom:2px solid #ff761b" align="left">
                                                    <p class="  txt-left " style="">
                                                        I &nbsp;<span class="fw-600 txt-left">Xyz</span>&nbsp;, have read ANNEXURE A & B, understood, and accept the offer
                                                        upon the terms and conditions as outlined in this offer letter for
                                                        my position at Leather Sector Skill Council.

                                                    </p>
                                                </td>
                                            </tr>
                                            <tr class="">
                                                <td colspan="4" class="pt-30 border-bottom-line2 " style="padding-bottom:152px"
                                                    >
                                                    <p class="fw-600 txt-left " style="">
                                                        Sign:
                                                    </p>


                                                </td>
                                                <td colspan="4" class="border-bottom-line2 " style="padding-bottom:152px">
                                                    <p class="fw-600 txt-right " style="">
                                                        Date:
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" style=" " class="">
                                                    <p class="fw-600 txt-center  margin-0" style="font-size:">
                                                        PRECEDE WORKFORCE SOLUTIONS INDIA PRIVATE LIMITED
                                                    </p>
                                                    <p class=" txt-center margin-0"> <span class="f-11"> <span
                                                                class="precede_primary_color f-11 fw-600">CIN -
                                                            </span>U74900TN2015PTC100900</span> &nbsp; <span
                                                            class="f-11"> <span
                                                                class="precede_primary_color f-11  fw-600"> GSTIN -
                                                            </span>33AAICP1477F1ZH</span></p>
                                                    <p class="margin-0 txt-center"><span class="fw-600 ">Corporate Office:
                                                        </span>No-2/29, Vengaivasal Main Road, Santhosapuram, East Tambaram,
                                                        Chennai-600 073. </p>
                                                    <p class="margin-0 txt-center"><span class="fw-600 ">Branch Office:
                                                        </span> No-606, 1st B Main Road, Domlur, Bangalore -560071,
                                                        Karnataka, India.</p>
                                                    <div style="padding: 0px 5px;display:flex;font-size:95%;">
                                                        <div style="margin-right:10px;"> <img
                                                                src="{{ URL::asset('assets/images/appointment/precede/phone.jpg') }}"
                                                                class="" alt=""
                                                                style="height:20px;width:20px;">+91-44-2278 2288 </div>
                                                        <div style="margin-right:10px;"> <img
                                                                src="{{ URL::asset('assets/images/appointment/precede/mobile.jpg') }}"
                                                                class="" alt=""
                                                                style="height:20px;width:20px;">+91-97898 37408 </div>
                                                        <div style="margin-right:10px;"> <img
                                                                src="{{ URL::asset('assets/images/appointment/precede/mail.jpg') }}"
                                                                class="" alt=""
                                                                style="height:20px;width:20px;">info@precedehrsolutions.com</div>
                                                        <div > <img
                                                                src="{{ URL::asset('assets/images/appointment/precede/computer.jpg') }}"
                                                                class="" alt=""
                                                                style="height:20px;width:20px;">www.precedehrsolutions.com</div>
                                                    </div>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <button class="carousel-control-prev" type="button"
                            data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon bg-secondary rounded-circle"
                                aria-hidden="true"></span>
                            <span class="visually-hidden ">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button"
                            data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="next">
                            <span class="carousel-control-next-icon bg-secondary rounded-circle"
                                aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>

                    </div>
                </div>
            </div>
            <div class="tab-pane fade  " id="payslips" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="main-page">
                    <div class="sub-page" style="text-align: justify;">
                        <table cellspacing="0" cellpadding="0" class="payslip_table">
                            <tr class="header-row">
                                <td colspan="8" class="border-less">
                                    <div class="header-cotent" style="margin: 10px;">
                                        <p class="margin-0 brand-name ">Precede Workforce Solutions</p>
                                        <p class="mb-0">No: 2,Vengaivasal main road,</p>
                                        <p class="mb-0"> Santhoshapuram,medavakkam</p>
                                        <p class="mb-0">Chennai -600073,Tamilnadu.</p>
                                    </div>
                                </td>
                                <td colspan="4" class="border-less">

                                    <div class="header-img txt-right"
                                        style="height: 100%;width:100%;max-height:100%;padding-right: 10px;">

                                        <img src="{{ URL::asset('assets/images/precede.png') }}" class=""
                                            alt="user-pic" style="height:55px;width:180px;">
                                    </div>


                                </td>
                            </tr>


                            <tr>
                                <td colspan="12" class="bg-ash">
                                    <p class="sub-header txt-center  text-strong">PAYSLIP FOR THE MONTH OF &ndash; Xyz
                                    </p>
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
                            </tr>
                            <tr>

                                <td colspan="2" class="bg-ash text-strong ">
                                    <p class="txt-center">SL OpenBalance</p>
                                </td>
                                <td colspan="2" class="bg-ash text-strong">
                                    <p class="txt-center">CL OpenBalance</p>
                                </td>
                                <td colspan="2" class="bg-ash text-strong">
                                    <p class="txt-center">Availed SL</p>
                                </td>
                                <td colspan="2" class="bg-ash text-strong">
                                    <p class="txt-center">Availed CL</p>
                                </td>
                                <td colspan="2" class="bg-ash text-strong">
                                    <p class="txt-center">Balance SL</p>
                                </td>
                                <td colspan="2" class="bg-ash text-strong">
                                    <p class="txt-center">Balance CL</p>
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
                                    <p class="txt-left text-strong">SPECIAL ALLOW</p>
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
                                    <p class="txt-left text-strong">PT</p>
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
                                    <p class="txt-left text-strong">TDS</p>
                                </td>
                                <td colspan="2" class="">
                                    <p></p>
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
                                    <div class="tab-pane fade  " id="payslips" role="tabpanel"
                                        aria-labelledby="pills-home-tab">

                                    </div </td>
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
                                    <p></p>
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
                                    <p></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="">
                                    <p class="txt-left text-strong">TOTAL EARNINGS</p>
                                </td>
                                <td colspan="2" class="">
                                    <p></p>
                                </td>
                                <td colspan="2" class="">
                                    <p class="txt-right"></p>
                                </td>

                                <td colspan="2" class="">
                                    <p class="txt-right"></p>
                                </td>
                                <td colspan="2" class="">
                                    <p class="txt-left text-strong">TOTAL DEDUCTION</p>
                                </td>
                                <td colspan="2" class="">
                                    <p></p>
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
                                    <p></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="bg-ash">
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
                                    <p class="txt-center">11-MAY-2022</p>
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
                                <td colspan="8" class="border-less" style="    padding: 10px 0px;">
                                    <p class="txt-left">Please
                                        reach out to us for any payroll queries at -payroll@ardens.in</p>
                                </td>
                                <td colspan="3" class="border-less txt-right" style="    padding: 10px 0px;">
                                    <p>Generated By</p>


                                </td>
                                <td colspan="1" class="border-less" style="    padding: 10px 0px;">
                                    <img src="{{ URL::asset('assets/images/footer_logo.png') }}" alt=""
                                        class="" style="height: 16px;width:95px;">
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
