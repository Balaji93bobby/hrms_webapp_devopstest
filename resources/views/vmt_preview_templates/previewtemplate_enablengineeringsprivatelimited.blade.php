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

        table tr td p {
            text-align: justify !important;
        }

        .payslip_table tr,
        td {
            border: 1.5pt solid #ce081e;

        }

        .precede_primary_color {
            color: #ce081e;
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

        .txt-left {
            text-align: left !important;
        }

        .txt-right {
            text-align: right !important;
        }

        .txt-center {
            text-align: center !important;
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
            padding: 0px 5px;
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


        .bg-ash {
            background-color: #9e9e9e5c;
        }
        .navy-blue {
            color: #213060;
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
                        <div class="carousel-item active">
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
                                                <td colspan="4" class="">
                                                    <p class="fw-600 txt-left " style="">
                                                        Mr. Xyz
                                                    </p>
                                                    <p class="fw-600 txt-left">
                                                        yyy

                                                    </p>

                                                </td>
                                                <td colspan="4" style=" ">
                                                    <p class="fw-600 txt-right " style="">
                                                        Date: DD/MM/YYYY
                                                    </p>


                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" class="pb-pt-5" align="left">
                                                    <p class="fw-600 txt-left " style="">
                                                        Dear Mr. Xyz,
                                                    </p>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="8" class="" align="left">
                                                    <p class=" " style="">
                                                        We at Precede Workforce Solutions India Pvt Ltd would like to create
                                                        an environment and culture committed to cooperation, quality, and
                                                        responsiveness that permeate every activity. We treat business
                                                        ethics no different from personal ethics leading to an atmosphere
                                                        that is exciting, transparent, rewarding, and challenging. Above
                                                        all, we need employees who strongly believe in nurturing a culture
                                                        of ideas, questions, challenges, feedback, and prudent risk-taking.
                                                        It also places a demand upon the employees to be active, and
                                                        innovative with the ability to create, gather and use knowledge.

                                                    </p>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="8" class="pt-pb-10" align="left">
                                                    <p class=" " style="">
                                                        With reference to your application and subsequent discussion, we
                                                        have pleasure in appointing you as a <span class="fw-600 txt-left">
                                                            Xyz </span>&nbsp; and place on
                                                        record the following terms and conditions for your knowledge
                                                        /acceptance:

                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" class="border-bottom-line2 " align="left"
                                                    style="padding-bottom: 57px">
                                                    <ol type="1">
                                                        <li>
                                                            <p class="  fw-600" style="">DATE OF APPOINTMENT:
                                                            </p>
                                                            <p class="  pt-pb-5" style="">
                                                                Your date of appointment is effective from the date of
                                                                joining but not later than &nbsp;<span
                                                                    class="fw-600 ">DD/MM/YYYY</span>&nbsp;
                                                            </p>
                                                            <p class=" " style="">
                                                                At the time of joining, we request you to furnish
                                                                testimonials of your educational qualifications and a
                                                                relieving letter from the previous organization.
                                                            </p>
                                                            <p class="  pt-pb-5" style="">
                                                                This is also conditional upon your being free from any
                                                                contractual restrictions preventing you from accepting this
                                                                offer or starting work on the date of joining.
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <p class="  fw-600" style="">
                                                                TIMINGS:
                                                            </p>
                                                            <p class="  pt-pb-5" style="">
                                                                Your current timings will be from 09:00 am to 7:00 pm from
                                                                Monday to Friday.
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <p class="  fw-600" style="">
                                                                NOTICE PERIOD:

                                                            </p>
                                                            <p class="  pt-pb-5" style="">
                                                                This contract of employment is terminable by either party by
                                                                giving two months notice (60 days) period.

                                                            </p>
                                                            <p class=" " style="">
                                                                The company shall have the right to terminate your
                                                                employment without notice if:
                                                            </p>
                                                            <p>

                                                            <ol type="a">
                                                                <li>

                                                                    <p class="  pt-pb-5" style="">
                                                                        You commit any material breach of any of your duties
                                                                        and responsibilities under this contract.
                                                                    </p>

                                                                </li>
                                                                <li>

                                                                    <p class="  " style="">
                                                                        Any particulars mentioned in your application are
                                                                        found false at any point of time or found to have
                                                                        willfully suppressed any material information.

                                                                    </p>

                                                                </li>
                                                                <li>

                                                                    <p class="  pt-pb-5" style="">
                                                                        You become insolvent or bankrupt or any charged with
                                                                        any criminal offense, which is prejudicial of the
                                                                        interest of the Company.
                                                                    </p>

                                                                </li>
                                                                <li>

                                                                    <p class="  pt-pb-5" style="">
                                                                        If at any time in our opinion, which is final in
                                                                        this matter, you are found guilty of dishonesty,
                                                                        disorderly behavior, negligence, indiscipline, an
                                                                        absence of duty without permission, or any other
                                                                        conduct considered by us as detrimental to the
                                                                        interests of the company.

                                                                    </p>
                                                                </li>
                                                            </ol>
                                                            </p>

                                                        </li>
                                                    </ol>
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
                        <div class="carousel-item ">
                            <div class="main-page appointment-letter">
                                <div class="sub-page"
                                    style="text-align: justify;>
                                    <table class="letter-format"
                                    style="padding:0;">
                                    <table class="letter-format" style="padding:0;">
                                        <tbody>
                                            <tr>
                                                <td align="left" class="pb-30" colspan="8">
                                                    <img src="{{ URL::asset('assets/images/precede.png') }}"
                                                        class="" alt="user-pic" style="height:55px;width:180px;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" class="">
                                                    <p class="fw-600 txt-left " style="">
                                                        4. COMPENSATION PACKAGE:

                                                    </p>
                                                    <p class=" pt-pb-5">
                                                        You will be paid an annual package of &nbsp;<span
                                                            class="fw-600 txt-left"> YYY </span>&nbsp;-and your
                                                        service
                                                        being placed at any one of the
                                                        client locations in Chennai.


                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" class="  pt-pb-5">
                                                    <table class="salary-table" style="padding:0;">
                                                        <tbody>
                                                            <tr>
                                                                <td class="bg-orange" colspan="8">
                                                                    <p class="txt-center fw-600">Salary Structure</p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bg-ash" colspan="4">
                                                                    <p class="txt-left fw-600">Particulars</p>
                                                                </td>
                                                                <td class="bg-ash" colspan="2">
                                                                    <p class="txt-center fw-600">CTC Per Month Rs</p>
                                                                </td>
                                                                <td class="bg-ash" colspan="2">
                                                                    <p class="txt-center fw-600">CTC Per Annum Rs</p>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td class="" colspan="4">
                                                                    <p class="txt-left ">Basic</p>
                                                                </td>
                                                                <td class="" colspan="2">
                                                                    <p class="txt-right "></p>
                                                                </td>
                                                                <td class="" colspan="2">
                                                                    <p class="txt-right "></p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="" colspan="4">
                                                                    <p class="txt-left ">House Rent Allowance </p>
                                                                </td>
                                                                <td class="" colspan="2">
                                                                    <p class="txt-right "></p>
                                                                </td>
                                                                <td class="" colspan="2">
                                                                    <p class="txt-right "></p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="" colspan="4">
                                                                    <p class="txt-left ">Statutory Bonus</p>
                                                                </td>
                                                                <td class="" colspan="2">
                                                                    <p class="txt-right "></p>
                                                                </td>
                                                                <td class="" colspan="2">
                                                                    <p class="txt-right "></p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="" colspan="4">
                                                                    <p class="txt-left ">Special Allowance</p>
                                                                </td>
                                                                <td class="" colspan="2">
                                                                    <p class="txt-right "></p>
                                                                </td>
                                                                <td class="" colspan="2">
                                                                    <p class="txt-right "></p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bg-ash" colspan="4">
                                                                    <p class="txt-left fw-600">Gross</p>
                                                                </td>
                                                                <td class="bg-ash" colspan="2">
                                                                    <p class="txt-right fw-600"></p>
                                                                </td>
                                                                <td class="bg-ash" colspan="2">
                                                                    <p class="txt-right fw-600"></p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="" colspan="4">
                                                                    <p class="txt-left ">Employer EPF</p>
                                                                </td>
                                                                <td class="" colspan="2">
                                                                    <p class="txt-right "></p>
                                                                </td>
                                                                <td class="" colspan="2">
                                                                    <p class="txt-right "></p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="" colspan="4">
                                                                    <p class="txt-left ">Employer ESC</p>
                                                                </td>
                                                                <td class="" colspan="2">
                                                                    <p class="txt-right "></p>
                                                                </td>
                                                                <td class="" colspan="2">
                                                                    <p class="txt-right "></p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bg-ash" colspan="4">
                                                                    <p class="txt-left fw-600">Total Cost to Company</p>
                                                                </td>
                                                                <td class="bg-ash" colspan="2">
                                                                    <p class="txt-right fw-600"></p>
                                                                </td>
                                                                <td class="bg-ash" colspan="2">
                                                                    <p class="txt-right fw-600"></p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="" colspan="4">
                                                                    <p class="txt-left ">Employee EPF </p>
                                                                </td>
                                                                <td class="" colspan="2">
                                                                    <p class="txt-right "></p>
                                                                </td>
                                                                <td class="" colspan="2">
                                                                    <p class="txt-right "></p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="" colspan="4">
                                                                    <p class="txt-left ">Employee ESI </p>
                                                                </td>
                                                                <td class="" colspan="2">
                                                                    <p class="txt-right "></p>
                                                                </td>
                                                                <td class="" colspan="2">
                                                                    <p class="txt-right "></p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bg-ash" colspan="4">
                                                                    <p class="txt-left fw-600">Net Take Home</p>
                                                                </td>
                                                                <td class="bg-ash" colspan="2">
                                                                    <p class="txt-right fw-600"></p>
                                                                </td>
                                                                <td class="bg-ash" colspan="2">
                                                                    <p class="txt-right fw-600"></p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="" style=" ">
                                                    <p class="fw-600 txt-left pt-pb-5" style="">
                                                        5. TRANSFER:
                                                    </p>
                                                    <p class="">
                                                        You will be liable to transfer in such capacity as the Company may
                                                        from time to time determine to
                                                        any other location, department, and establishment of the Company. In
                                                        such a case, you will be
                                                        governed by the terms and conditions of service applicable to the
                                                        new assignment.
                                                    </p>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="" style=" ">
                                                    <p class="fw-600 pt-pb-5 txt-left " style="">
                                                        6. TRAVEL:

                                                    </p>
                                                    <p class="">
                                                        You will be required to undertake travel on Company work and you
                                                        will be reimbursed travel
                                                        expenses for this as per Company rules
                                                    </p>

                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="" class="border-bottom-line2"
                                                    style="padding-bottom: 49px;">
                                                    <p class="fw-600 pt-pb-5 txt-left " style="">
                                                        7. CONFIDENTIAL INFORMATION:

                                                    </p>
                                                    <p class="">
                                                        You shall not during your said employment or at any time thereafter
                                                        divulge to any person
                                                        whosoever or make any use whatsoever for you own purpose or for any
                                                        during your said
                                                        employment as to business or affairs of the Company or its method as
                                                        to any trade secret or secret
                                                        processes of the Company and you shall during the said employment
                                                        also use your best endeavors
                                                        to prevent any other person from doing so
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

                        <div class="carousel-item ">
                            <div class="main-page appointment-letter">
                                <div class="sub-page" style="text-align: justify;font-size: 15px;">
                                    <table class="letter-format" style="padding:0;">
                                        <tbody>
                                            <tr>
                                                <td align="left" class="pb-30" colspan="8">
                                                    <img src="{{ URL::asset('assets/images/precede.png') }}"
                                                        class="" alt="user-pic" style="height:55px;width:180px;">
                                                </td>
                                            </tr>
                                            <tr>

                                                <td colspan="" style=" ">
                                                    <p class="fw-600 txt-left " style="">
                                                        8. PROTECTION OF INTEREST:

                                                    </p>
                                                    <p class="pt-pb-5 ">
                                                        If you conceive any new or advanced methods of improving
                                                        process/systems in relation to the
                                                        operation of the Company, such developments will be fully
                                                        communicated to the Company and will
                                                        be and remain sole right/property of the Company.

                                                    </p>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="" style=" " class="">
                                                    <p class="fw-600 txt-left " style="">
                                                        9. CONFLICT OF INTEREST:


                                                    </p>
                                                    <p class=" pt-pb-5 ">
                                                        The Company has adopted a conflict-of-interest policy in respect of
                                                        its employees. This policy is
                                                        intended to avoid conflict of interest between the personal interest
                                                        of an employee and the interest of the Company in its dealings with
                                                        suppliers, customers and all other organizations or individuals
                                                        doing or seeking to do business with the Company.

                                                    </p>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="" style="border-bottom:5px solid #777171">
                                                    <p class="fw-600">
                                                        10. RETIREMENT / TERMINATION / RESIGNATION:
                                                    </p>
                                                    <p class=" pt-pb-5 ">
                                                        You will be retired from the services of the Company on your
                                                        completing the age of 58 years, or
                                                        such other retiring age the Management may decide.

                                                    </p>
                                                    <p class=" pt-pb-5  ">
                                                        At the time of retirement/termination/resignation, you will
                                                        immediately hand over to the Company
                                                        all correspondence, documentation, data, software, etc. belonging to
                                                        the company or relating to its
                                                        business and shall not make or retain any copies of these items.
                                                    </p>

                                                    <p class=" pb-pt-15 txt-left " style="">
                                                        Yours Sincerely,

                                                    </p>
                                                    <p class=" pt-pb-5 txt-left fw-600" style="">
                                                        For PRECEDE WORKFORCE SOLUTIONS INDIA PVT LTD.

                                                    </p>
                                                    <p class=" pt-pb-5 txt-left fw-600 " style="">
                                                        David Siddharthan (Director)
                                                    </p>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="" style=" " class=" pt-30 pb-30   ">
                                                    <p class="txt-left fw-600"> Acceptance:</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="" style=" " class=" ">
                                                    <p class="txt-left ">I M A ASHVATH have read and hereby accept the
                                                        above-mentioned terms and conditions.
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="" style="border-bottom:5px solid #777171"
                                                    class=" pt-pb-5 ">
                                                    <p class="txt-left fw-600 "> Signature:
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="" style="padding-bottom: 208px;"
                                                    class="border-bottom-line2 ">
                                                    <p class="txt-left "> Please indicate your acceptance of the
                                                        terms by signing and returning the duplicate copy thereof.
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
                                <td colspan="8" class="" style="border-right:0px;">
                                    <div class="header-cotent" style="margin: 10px;">
                                        <p class="margin-0 brand-name "
                                            style="font-size: 16px;font-weight:600;color:#213060;">Precede
                                            Workforce Solutions India Private Limited</p>
                                        <p class="mb-0">No: 2,Vengaivasal main road,</p>
                                        <p class="mb-0"> Santhoshapuram,medavakkam</p>
                                        <p class="mb-0">Chennai -600073,Tamilnadu.</p>
                                    </div>
                                </td>
                                <td colspan="4" class="" style="border-left:0px;" align="">
                                    <div class="header-img txt-right"
                                        style="padding-right: 10px;height:55px;width:200px;padding-left:40px;">
                                        {{-- <div class="header-img txt-right" style="padding-right: 10px;"> --}}
                                        <img src="{{ URL::asset('assets/images/precede.png') }}" class=""
                                            alt="logo" style="height:100%;width:100%;">
                                    </div>
                                </td>
                            </tr>



                            <tr>
                                <td colspan="12" class="bg-ash">
                                    <p class="sub-header navy-blue txt-center text-strong">PAYSLIP FOR THE MONTH OF &ndash;
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="bg-ash text-strong">
                                    <p class="navy-blue">EMPLOYEE NAME</p>
                                </td>
                                <td colspan="3">
                                    <p></p>
                                </td>
                                <td colspan="3" class="bg-ash text-strong">
                                    <p class="navy-blue">EMPLOYEE CODE</p>
                                </td>
                                <td colspan="3">
                                    <p></p>
                                </td>

                            </tr>
                            <tr>
                                <td colspan="3" class="bg-ash text-strong">
                                    <p class="navy-blue">DATE OF BIRTH</p>
                                </td>
                                <td colspan="3">
                                    <p></p>
                                </td>
                                <td colspan="3" class="bg-ash text-strong">
                                    <p class="navy-blue">DATE OF JOINING</p>
                                </td>
                                <td colspan="3">
                                    <p></p>
                                </td>

                            </tr>
                            <tr>
                                <td colspan="3" class="bg-ash text-strong">
                                    <p class="navy-blue">DESIGNATION</p>
                                </td>
                                <td colspan="3">
                                    <p></p>
                                </td>
                                <td colspan="3" class="bg-ash text-strong">
                                    <p class="navy-blue">LOCATION</p>
                                </td>
                                <td colspan="3">
                                    <p></p>
                                </td>

                            </tr>
                            <tr>
                                <td colspan="3" class="bg-ash text-strong">
                                    <p class="navy-blue">EPF NUMBER</p>
                                </td>
                                <td colspan="3">
                                    <p></p>
                                </td>
                                <td colspan="3" class="bg-ash text-strong">
                                    <p class="navy-blue">ESIC NUMBER</p>
                                </td>
                                <td colspan="3">
                                    <p></p>
                                </td>

                            </tr>
                            <tr>
                                <td colspan="3" class="bg-ash text-strong">
                                    <p class="navy-blue">UAN</p>
                                </td>
                                <td colspan="3">
                                    <p></p>
                                </td>
                                <td colspan="3" class="bg-ash text-strong">
                                    <p class="navy-blue">PAN</p>
                                </td>
                                <td colspan="3">
                                    <p></p>
                                </td>

                            </tr>
                            <tr>
                                <td colspan="4" class="bg-ash ">
                                    <p class="text-strong navy-blue txt-center">BANK NAME</p>
                                </td>

                                <td colspan="4" class="bg-ash ">
                                    <p class="text-strong navy-blue txt-center">ACCOUNT NUMBER</p>
                                </td>
                                <td colspan="4" class="bg-ash ">
                                    <p class="text-strong txt-center navy-blue">IFSC CODE</p>
                                </td>

                            </tr>
                            <tr>
                                <td colspan="4" class="">

                                    {{-- <p class="txt-center">{{ $bank_name }}</p> --}}
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
                                    <p class="text-strong txt-center navy-blue">MONTH DAYS</p>
                                </td>

                                <td colspan="3" class="bg-ash ">
                                    <p class="text-strong txt-center navy-blue">WORKED DAYS</p>
                                </td>
                                <td colspan="3" class="bg-ash ">
                                    <p class="text-strong txt-center navy-blue">LOSS OF PAY</p>
                                </td>
                                <td colspan="3" class="bg-ash ">
                                    <p class="text-strong txt-center navy-blue">ARREAR DAYS</p>
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

                                <td colspan="2" class="bg-ash text-strong ">
                                    <p class="txt-center navy-blue">SL OpenBalance</p>
                                </td>
                                <td colspan="2" class="bg-ash text-strong">
                                    <p class="txt-center navy-blue">CL OpenBalance</p>
                                </td>
                                <td colspan="2" class="bg-ash text-strong">
                                    <p class="txt-center navy-blue">Availed SL</p>
                                </td>
                                <td colspan="2" class="bg-ash text-strong">
                                    <p class="txt-center navy-blue">Availed CL</p>
                                </td>
                                <td colspan="2" class="bg-ash text-strong">
                                    <p class="txt-center navy-blue">Balance SL</p>
                                </td>
                                <td colspan="2" class="bg-ash text-strong">
                                    <p class="txt-center navy-blue">Balance CL</p>
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
                                    <p class="txt-center text-strong navy-blue">DESCRIPTION</p>
                                </td>
                                <td colspan="2" class="bg-ash">
                                    <p class="txt-center text-strong navy-blue">AMOUNT</p>
                                </td>
                                <td colspan="2" class="bg-ash">
                                    <p class="txt-center text-strong navy-blue">ARREAR AMOUNT</p>
                                </td>
                                <td colspan="2" class="bg-ash">
                                    <p class="txt-center text-strong navy-blue">EARNED AMOUNT</p>
                                </td>
                                <td colspan="2" class="bg-ash">
                                    <p class="txt-center text-strong navy-blue">DEDUCTION</p>
                                </td>
                                <td colspan="2" class="bg-ash">
                                    <p class="txt-center text-strong navy-blue">AMOUNT</p>
                                </td>

                            </tr>
                            <tr>
                                <td colspan="2" class="">
                                    <p class="txt-left text-strong navy-blue">BASIC</p>
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
                                    <p class="txt-left text-strong navy-blue">EPF</p>
                                </td>
                                <td colspan="2" class="">
                                    <p class="txt-right"></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="">
                                    <p class="txt-left text-strong navy-blue">HRA</p>
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
                                    <p class="txt-left text-strong  navy-blue">ESIC</p>
                                </td>
                                <td colspan="2" class="">
                                    <p class="txt-right"></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="">
                                    <p class="txt-left text-strong  navy-blue">STATS BONUS</p>
                                </td>
                                <td colspan="2" class="">
                                    {{-- <p class="txt-right">{{ number_format(round($employee_details->SPL_ALW), 2) }}</p> --}}
                                    <p class="txt-right"></p>
                                </td>
                                <td colspan="2" class="">
                                    {{-- <p class="txt-right">{{ number_format(round($employee_details->SPL_ALW_ARREAR), 2) }}</p> --}}
                                </td>
                                <td colspan="2" class="">
                                    {{-- <p class="txt-right">{{ number_format(round($employee_details->Earned_SPL_ALW), 2) }}</p> --}}
                                    <p class="txt-right"></p>
                                </td>
                                <td colspan="2" class="">
                                    <p class="txt-left text-strong  navy-blue">PT</p>
                                </td>
                                <td colspan="2" class="">
                                    <p class="txt-right"></p>
                                </td>


                            </tr>
                            <tr>
                                <td colspan="2" class="">
                                    <p class="txt-left text-strong  navy-blue">SPECIAL ALLOW</p>
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
                                    <p class="txt-left text-strong  navy-blue">INCOME TAX</p>
                                </td>
                                <td colspan="2" class="">
                                    {{-- <p class="txt-right">{{ number_format(round($employee_details->PROF_TAX), 2) }}</p> --}}
                                    <p class="txt-right"></p>
                                </td>


                            </tr>

                            <tr>
                                <td colspan="2" class="">
                                    <p class="txt-left text-strong  navy-blue"> OVERTIME</p>
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
                                    <p class="txt-left text-strong navy-blue">SALARY ADVANCE</p>
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
                                    <p class="txt-left text-strong navy-blue">OTHER DEDUCTIONS</p>
                                </td>
                                <td colspan="2" class="">
                                    <p class="txt-right"></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="">
                                    <p class="txt-left text-strong navy-blue">TOTAL EARNINGS</p>
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
                                    <p class="txt-left text-strong navy-blue">TOTAL DEDUCTION</p>
                                </td>
                                <td colspan="2" class="">
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
                                    <p class="txt-left text-strong navy-blue">NET PAY</p>
                                </td>
                                <td colspan="8" class="">
                                    <p class="txt-center ext-strong navy-blue">
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="bg-ash">
                                    <p class="txt-left text-strong navy-blue">NET PAY IN WORDS</p>
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
                                    <p class="txt-center text-strong navy-blue">TRANSACTION ID</p>
                                </td>
                                <td colspan="3" class="">
                                    <p class="txt-center"></p>
                                </td>
                                <td colspan="3" class="bg-ash">
                                    <p class="txt-center text-strong navy-blue">Paid Date</p>
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
                                    <p class="txt-center "> <i class="navy-blue"> This is a computer-generated slip does
                                            not require
                                            signature</i>
                                    </p>
                                </td>
                            </tr>

                            <tr class="border-less">
                                <td colspan="8" class="border-less" style="    padding: 10px 0px;">
                                    <p class="txt-left navy-blue text-strong">Please
                                        reach out to us for any payroll queries at-info@precedehrsolutions.com</p>
                                </td>
                                <td colspan="3" class="border-less txt-right" style="    padding: 10px;">
                                    <p class="navy-blue">Generated By</p>

                                </td>
                                <td colspan="1" class="border-less" style="    padding: 10px 0px;">
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
@endsection
