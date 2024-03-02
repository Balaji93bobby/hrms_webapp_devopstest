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


        }

        .border-less {
            border: 0px !important;
        }

        .payslip_table {
            border-collapse: collapse;

        }

        table.payslip_table tr p,
        table.payslip_table td p {
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

        .header-cotent p.brand-name {
            font-weight: 600;
            color: #002f56;
            font-size: 16px;
        }

        table.payslip_table tr,
        table.payslip_table td {
            border: 2px solid #ff5a38 ;
        }

        .gen_terms-table tr td ul li {
            padding: 10px 0px;
        }

        .gen_terms-table tr td ol li {
            padding: 2px 0px;
        }

        table.payslip_table td.bg-ash {
            background-color: #c1c1c1;
        }

        .sub-page {
            padding: 10px 30px;
            height: 297mm;
        }

        #ass_details_table {
            border: 1px solid #000;
        }

        .paratag {
            margin: 5px 0px;
            /* font-size: 15px; */
        }

        .table-one tr,
        .table-one th,
        .table-one td,
        .table-one td p {
            /* font-size: 14px; */
        }

        table tr td,
        table tr td p,
        table tbody th,
        table tbody tr td,
        table tr td ul li p {
            /* color: #7b68ee; */
            font-size: 13px;
        }

        table span {
            font-weight: bold;
        }

        .core {
            margin: 7px;
        }

        .core li {
            margin-bottom: 10px;
            font-size: 14px;
        }

        .cont-list {
            list-style: decimal;
        }

        .cont-list p {
            /* font-size: 15px; */
        }




        .assign-table {
            width: 100%;
        }

        #ass_details_table tr,
        #ass_details_table td,
        #ass_details_table th {
            font-size: 13px;
            padding: 3px 8px;

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

        .color-link-blue {
            color: #0065c2;
        }

        ul>li::marker {
            font-weight: bolder;
            margin: 2px;
            font-size: 15px;
        }
    </style>
@endsection
@section('content')
    <div class="card mt-30 mb-2">
        <div class="card-body px-0 py-1">

            <ul class="nav nav-pills    nav-tabs-dashed" id="pills-tab" role="tablist">
                <li class="nav-item active ember-view mx-4" role="presentation">
                    <a class="nav-link active ember-view " id="pills-home-tab" data-bs-toggle="pill" href=""
                        data-bs-target="#appointment" role="tab" aria-controls="pills-home" aria-selected="true">
                        Appointment Letter</a>
                </li>
                <li class="nav-item mx-4 ember-view" role="presentation ">
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
                            <div class="main-page">
                                <table class="t-parent table-one" style="padding:0;">
                                    <tbody>
                                        <tr>
                                            <td>

                                                <div class="logo" style="width:100%;height:fit-content;">
                                                    <img src="{{ URL::asset('assets/images/header.jpg') }}" alt=""
                                                        class="" style="height:100%;width:100%;">
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td align="center" style="padding:0px 50px">
                                                <table class="table-one">
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="" style=" ">
                                                                <p style="font-weight: 600;text-align:end;"><span
                                                                        class=""
                                                                        style="margin-right:3px;font-size: 14px;">Date:</span>
                                                                    <span style="font-size: 14px;"></span>
                                                                </p>

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding:10px 0px;" align="center">
                                                                <span
                                                                    style="border-bottom:1px solid #000000;font-size: 14px;">Welcome
                                                                    Note </span>

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p style="text-align: left; margin: 8px 0px;">Dear <span
                                                                        style="font-weight:bold;"> , </span></p>
                                                                <p class="paratag">
                                                                    Congratulations and welcome to the ABS Family! We are
                                                                    delighted to have you as part of our
                                                                    organization.
                                                                    Your role and association with us are critical in
                                                                    fulfilling the mission of our organization. We
                                                                    hope, our
                                                                    association will be professionally meaningful and
                                                                    mutually beneficial. You join a group of our
                                                                    1,500 +
                                                                    Associate Workers (AW) deputed to our various clients,
                                                                    in order to partner in their business
                                                                    success.

                                                                </p>
                                                            </td>


                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p class="paratag">
                                                                    Thank you for the information and documentation provided
                                                                    to ease your on-boarding process. You can
                                                                    continue to use our online portal to access and download
                                                                    your monthly payslips, edit personal
                                                                    details,
                                                                    and download forms required for registering your
                                                                    employment for various statutory benefits. The
                                                                    next
                                                                    few pages will give you more information on your
                                                                    employment with us
                                                                </p>
                                                            </td>

                                                        </tr>

                                                        <tr>
                                                            <td>

                                                                <p class="paratag"> For any queries, please feel free to
                                                                    contact the ABS Help Desk. The facility is
                                                                    currently available
                                                                    Monday
                                                                    through Friday, 9:30 am to 6:30 pm. You may contact the
                                                                    Help Desk through one of the two methods
                                                                    below:
                                                                </p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding: 0px 10px;">
                                                                <ul class="core" style="list-style:none;">
                                                                    <li> <img
                                                                            src="{{ URL::asset('assets/images/list_style.png') }}"
                                                                            alt="" class=""
                                                                            style="height:12px;width:12px;margin-right:4px;">
                                                                        Log in to <a href="https://ess.abshrms.com/"
                                                                            class="color-link-blue">https://ess.abshrms.com</a>
                                                                    </li>
                                                                    <li><img src="{{ URL::asset('assets/images/list_style.png') }}"
                                                                            alt="" class=""
                                                                            style="height:12px;width:12px;margin-right:4px;">
                                                                        Email us at <a href="payroll@ardens.in"
                                                                            class="color-link-blue">payroll@ardens.in</a>
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                <p class="paratag">
                                                                    <span> Our Core Values:</span> Our core values are the
                                                                    framework of our commitment to the client.
                                                                    We developed a
                                                                    6P
                                                                    model resuming our core values. It’s good to know that
                                                                    every ABS employee continues to keep to and
                                                                    live
                                                                    by these values today. They are
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding: 0px 10px;">
                                                                <ul class="core" style="list-style: none;">
                                                                    <li><img src="{{ URL::asset('assets/images/list_style.png') }}"
                                                                            alt="" class=""
                                                                            style="height:12px;width:12px;margin-right:4px;">
                                                                        <span> Professionalism:</span> Our staff expertise
                                                                        responds to high complex needs
                                                                    </li>
                                                                    <li><img src="{{ URL::asset('assets/images/list_style.png') }}"
                                                                            alt="" class=""
                                                                            style="height:12px;width:12px;margin-right:4px;">
                                                                        <span> Proximity:</span> Build open relationships
                                                                        with clients
                                                                    </li>
                                                                    <li><img src="{{ URL::asset('assets/images/list_style.png') }}"
                                                                            alt="" class=""
                                                                            style="height:12px;width:12px;margin-right:4px;">
                                                                        <span> Proactivity:</span> Not only follow the
                                                                        customer demand but anticipate and customize
                                                                        intelligent</span>
                                                                        solution
                                                                    </li>
                                                                    <li><img src="{{ URL::asset('assets/images/list_style.png') }}"
                                                                            alt="" class=""
                                                                            style="height:12px;width:12px;margin-right:4px;">
                                                                        <span>Proficiency:</span> High standards, ability to
                                                                        use innovative technology to meet
                                                                        client’s expectations
                                                                    </li>
                                                                    <li><img src="{{ URL::asset('assets/images/list_style.png') }}"
                                                                            alt="" class=""
                                                                            style="height:12px;width:12px;margin-right:4px;">
                                                                        <span> People:</span> Finally, payroll is all about
                                                                        people. Our experts focus their activity
                                                                        to deliver accurate
                                                                        pay sheets and rapports to facilitate the employee’s
                                                                        life.
                                                                    </li>
                                                                    <li><img src="{{ URL::asset('assets/images/list_style.png') }}"
                                                                            alt="" class=""
                                                                            style="height:12px;width:12px;margin-right:4px;">
                                                                        <span> Progress:</span> Innovation is at the core of
                                                                        our business</span>
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-bottom:20px;">
                                                                <p class="paratag">I wish you all the very best as you
                                                                    embark on an
                                                                    exciting journey with ABS while enhancing your
                                                                    professional stature, along the way.
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-weight:bold;font-size:14px ">
                                                                For Ardens Business Solutions Pvt Ltd
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="font-weight:bold;padding:10px 0px;">
                                                                <img src="{{ URL::asset('assets/images/augustin_sign.png') }}"
                                                                    alt="" class=""
                                                                    style="height:50px;width:130px;">
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td> <span> Augustin Raj A <br>
                                                                    Managing Director and CEO </span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="    padding: 31px 0px 0px;">

                                                <div class="logo" style="width:100%;height:fit-content;">
                                                    <img src="{{ URL::asset('assets/images/footer.jpg') }}"
                                                        alt="" class="" style="height:100%;width:100%;">
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>


                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="main-page">
                                <table class="t-parent" style="padding:0;">
                                    <tbody>
                                        <tr>
                                            <td>

                                                <div class="logo" style="width:100%;height:fit-content;">
                                                    <img src="{{ URL::asset('assets/images/header.jpg') }}"
                                                        alt="" class="" style="height:100%;width:100%;">
                                                </div>
                                            </td>
                                        </tr>



                                        <tr>
                                            <td align="center" style="padding:0px 50px">

                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="" style=" ">
                                                                <p style="font-weight: 600;text-align:end;"><span
                                                                        class=""
                                                                        style="margin-right:3px;font-size: 14px;">Date:</span>
                                                                    <span style="font-size: 14px;"></span>
                                                                </p>

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding:0px;">

                                                                <p style="text-align:left;">To,</p>
                                                                <p style="text-align:left;">Ms. <span
                                                                        style="font-weight:600;"></span></p>
                                                                <p style="text-align:left;">Employee code -<span
                                                                        style="font-weight:600;"></span></p>

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p style="text-align: center; margin: 8px 0px;"><span
                                                                        style="font-weight:bold;border-bottom:1px solid #000000">
                                                                        FIXED-TERM CONTRACT OF EMPLOYMENT</span></p>

                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p class="paratag">
                                                                    We are pleased to appoint you to our organization as
                                                                    RETAINER, for a fixed period of employment,
                                                                    on the following terms and conditions:

                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding:0px 0px 0px 25px;">


                                                                <ul class="cont-list">
                                                                    <li>
                                                                        <p class="paratag">
                                                                            Your contract of employment shall be valid for a
                                                                            period of 1 year from 01/Apr/2022 to
                                                                            31/Mar/2023 Notwithstanding this, in the event
                                                                            of the project/ work for which you are being
                                                                            employed comes to an end before the
                                                                            aforementioned period, this contract shall be
                                                                            co- terminus
                                                                            with the aforementioned project/work. At the end
                                                                            of the above referred period, the contract
                                                                            will
                                                                            stand terminated automatically without any
                                                                            notice or communication to you, unless they are
                                                                            explicitly extended by us by a letter in
                                                                            writing.
                                                                        </p>
                                                                    </li>
                                                                    <li>
                                                                        <p class="paratag">
                                                                            Notwithstanding anything above, depending upon
                                                                            the aforementioned project/work, the Company
                                                                            reserves its right to extend your temporary
                                                                            appointment for such period or periods as may be
                                                                            necessary depending upon the exigencies
                                                                            relatable to the work for which you are hereby
                                                                            engaged. In that event, the Company shall in
                                                                            writing extend your temporary assignment on the
                                                                            terms as may be indicated in such letter, and in
                                                                            the event of your acceptance of the such
                                                                            extension of the assignment, you shall be
                                                                            governed by such terms and conditions as may be
                                                                            indicated therein.
                                                                        </p>

                                                                    </li>
                                                                    <li>
                                                                        <p class="paratag">
                                                                            During the period of the fixed contract, your
                                                                            services could be deputed at the sole discretion
                                                                            of
                                                                            the
                                                                            Management to any of our client’s companies or
                                                                            locations to do work pertaining to or
                                                                            incidental to
                                                                            the client's business.
                                                                        </p>
                                                                    </li>
                                                                    <li>
                                                                        <p class="paratag">
                                                                            Details of your salary break up with components
                                                                            are as per <span> Annexure1 </span>
                                                                        </p>
                                                                    </li>
                                                                    <li>
                                                                        <p class="paratag">
                                                                            You will be entitled to an employer's
                                                                            contribution to the Provident Fund to the extent
                                                                            of 12%
                                                                            or
                                                                            1800/- restricted wages of your gross salary
                                                                            excluding house rent allowance.

                                                                        </p>
                                                                    </li>
                                                                    <li>
                                                                        <p class="paratag"> You will be eligible to get the
                                                                            ESIC medical benefits for you and your
                                                                            immediate
                                                                            family members if
                                                                            your gross wages are less than or equal to
                                                                            21000/-.
                                                                        </p>
                                                                    </li>
                                                                    <li>
                                                                        <p class="paratag">
                                                                            . You will be eligible for leave as per the
                                                                            client's company policy, during the period of
                                                                            your
                                                                            contract of
                                                                            employment.
                                                                        </p>
                                                                    </li>
                                                                    <li>
                                                                        <p class="paratag">. You will be entitled to all
                                                                            other statutory benefits wherever applicable
                                                                            during
                                                                            the fixed period ofthe
                                                                            contract.</p>
                                                                    </li>
                                                                    <li>
                                                                        <p class="paratag">
                                                                            You are advised to read and understand ABS
                                                                            Health & Safety Policy for associates (Annexure
                                                                            2)
                                                                            and
                                                                            comply with relevant policies that are in
                                                                            practice at Ardens Business Solutions Private
                                                                            Limited.
                                                                            Adherence to the stated and relevant policies is
                                                                            a condition of employment with ABS. In the
                                                                            event
                                                                            you are found to be non-compliant with any of
                                                                            the applicable policies, ABS reserves the right
                                                                            to
                                                                            take necessary action against you
                                                                        </p>
                                                                    </li>
                                                                    <li>
                                                                        <p class="paratag">
                                                                            This contract shall be terminable by either
                                                                            party giving 15 days’ notice in writing or
                                                                            salary
                                                                            in lieu of
                                                                            notice, to theother
                                                                        </p>
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="padding-top:71px;">

                                                <div class="logo" style="width:100%;height:fit-content;">
                                                    <img src="{{ URL::asset('assets/images/footer.jpg') }}"
                                                        alt="" class="" style="height:100%;width:100%;">
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>


                            </div>
                        </div>
                        <div class="carousel-item ">

                            <div class="main-page">
                                <table class="t-parent" style="padding:0;">
                                    <tbody>
                                        <tr>
                                            <td style="padding-bottom:20px">
                                                <div class="logo" style="">
                                                    <img src="{{ URL::asset('assets/images/header.jpg') }}"
                                                        alt="" class="" style="height:100%;width:100%;">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="padding:0px 50px ">
                                                <table>
                                                    <tbody>

                                                        <tr>
                                                            <td colspan="6">
                                                                <p class="paratag">
                                                                    We are consciously endeavoring to build an atmosphere of
                                                                    trust, openness, responsiveness,
                                                                    autonomy,
                                                                    and growth among all members of the ABS family. As a new
                                                                    entrant, we would like you to
                                                                    wholeheartedly
                                                                    contribute to this process.
                                                                </p>
                                                            </td>
                                                        </tr>


                                                        <tr>
                                                            <td colspan="6">
                                                                <p class="paratag">
                                                                    As a token of your acceptance of the above terms and
                                                                    conditions, you are requested to sign the
                                                                    duplicate
                                                                    copy of this letter and return it to us.

                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-bottom: 10px;" colspan="6">
                                                                <p class="paratag">
                                                                    Wishing you the very best!
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="6">
                                                                <p class="paratag">
                                                                    Yours truly,
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-weight:bold;font-size:14px " colspan="6">
                                                                For Ardens Business Solutions Pvt Ltd
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="font-weight:bold;padding:10px 0px; "
                                                                colspan="6">
                                                                <img src="{{ URL::asset('assets/images/augustin_sign.png') }}"
                                                                    alt="" class=""
                                                                    style="height:50px;width:130px;">
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td colspan="6">
                                                                <p style="font-weight: 600;"> Augustin Raj A -
                                                                    Managing Director and CEO</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="6">
                                                                <hr
                                                                    style="border:1px solid #999999 ;height: 3px;background: #999999;margin: 0px 0px 5px 0px;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="6">
                                                                <p class="paratag">
                                                                    I <span style="font-weight: 600;"> </span>, have
                                                                    understood and accepted the appointment upon the terms
                                                                    and
                                                                    conditions as outlined in this appointment letter for my
                                                                    position at Ardens Business Solutions Privat
                                                                    Limited
                                                                </p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding: 15px 0px;" colspan="6">
                                                                <p style="text-decoration:underline;font-weight:600;">
                                                                    Acceptance:</p>

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4">
                                                                <p>
                                                                    Signature:

                                                                </p>

                                                            </td>
                                                            <td colspan=" 2">
                                                                <p>
                                                                    Date:
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="4" style="padding-top:482px ;">

                                                <div class="logo" style="width:100%;height:fit-content;">
                                                    <img src="{{ URL::asset('assets/images/footer.jpg') }}"
                                                        alt="" class="" style="height:100%;width:100%;">
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="carousel-item ">
                            <div class="main-page">
                                <table class="t-parent" style="padding:0;">
                                    <tbody>
                                        <tr>
                                            <td style="padding-bottom: 20px;">

                                                <div class="logo" style="width:100%;height:fit-content;">
                                                    <img src="{{ URL::asset('assets/images/header.jpg') }}"
                                                        alt="" class="" style="height:100%;width:100%;">
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td align="center" style="padding:0px 50px">

                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <td style="padding:0px;">
                                                                <p style="text-align:left;margin: 0;">
                                                                    <span>Ms. </span> <br>
                                                                    <span>Employee Code - </span>

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p style="text-align: center; margin: 8px 0px;"><span
                                                                        style="font-weight:bold;text-decoration: underline;">
                                                                        DEPUTATION LETTER</span></p>
                                                                <p class="paratag">
                                                                    Further to clause 3 of your letter of employment, we are
                                                                    pleased to advise you that your services
                                                                    are
                                                                    being deputed to <span> Dunamis Machines International
                                                                        Private Limited </span> with effect from
                                                                    <span> 01/Apr/2022 </span> at
                                                                    their Chennai office.

                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>

                                                            <td>

                                                                <p class="paratag">
                                                                    Your total remuneration package (CTC) per annum is
                                                                    <span> Rs. 187572/-</span> per annum
                                                                    <span>(Rupees Rupees One Lac
                                                                        Eighty Seven Thousand Five Hundred Seventy Two
                                                                        Only)</span>. The break-up of your compensation
                                                                    package shall
                                                                    be as detailed in <span> Annexure A </span>
                                                                </p>
                                                            </td>


                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <ol class="Deputa-list number-list">
                                                                    <li>
                                                                        <p class="paratag">
                                                                            . You will, with effect from <b> 01/Apr/2022</b>
                                                                            be required to work at our client's office/
                                                                            premises at any of
                                                                            their locations. During the tenure of the
                                                                            deputation, you will continue to be an employee
                                                                            of Ardens
                                                                            Business Solutions.


                                                                        </p>
                                                                    </li>

                                                                    <li>
                                                                        <p class="paratag">
                                                                            In the day-to-day functioning or carrying out
                                                                            all responsibilities, you will receive
                                                                            instructions from
                                                                            <b> Dunamis Machines International Private
                                                                                Limited </b> and will undertake to abide by
                                                                            any
                                                                            suggestions,
                                                                            etc. given by any assigned person(s)
                                                                        </p>

                                                                    </li>




                                                                    <li>
                                                                        <p class="paratag">
                                                                            You shall also abide by any training that may be
                                                                            offered to you by <b> Dunamis Machines
                                                                                International
                                                                                Private Limited</b>. You shall be bound to
                                                                            follow the working hours of <b>DMIPL</b>
                                                                        </p>
                                                                    </li>




                                                                    <li>
                                                                        <p class="paratag">
                                                                            You shall take care not to disclose confidential
                                                                            information/trade secrets, etc. that you may
                                                                            come
                                                                            across in the course of your responsibilities to
                                                                            anyone outside <b> Dunamis Machines
                                                                                International
                                                                                Private Limited</b> and use such information
                                                                            only in connection with the service provided to
                                                                            <b> Dunamis
                                                                                Machines International Private Limited.</b>
                                                                        </p>
                                                                    </li>



                                                                    <li>
                                                                        <p class="paratag">
                                                                            You shall at no point of time stake any claim or
                                                                            right to claim employment, damage, loss, or
                                                                            compensation of any sort whatsoever against
                                                                            <b>Dunamis Machines International Private
                                                                                Limited.</b>
                                                                            This arrangement is purely a contractual
                                                                            agreement between<b> Ardens Business Solutions
                                                                                Private
                                                                                Limited</b> and </b>Dunamis Machines
                                                                            International Private Limited</b> for the
                                                                            timespecified.

                                                                        </p>
                                                                    </li>



                                                                    <li>
                                                                        <p class="paratag">. You shall not engage in any
                                                                            act subversive of discipline in the course of
                                                                            your duty/lies in the property
                                                                            of Dunamis Machines International Private
                                                                            Limited or outside, and if you were at any time
                                                                            found
                                                                            indulging in such act/s, we reserve the right to
                                                                            initiate disciplinary action as is deemed
                                                                            fit, against
                                                                            you
                                                                        </p>
                                                                    </li>



                                                                    <li>
                                                                        <p class="paratag">
                                                                            You shall be responsible for protecting the
                                                                            property of< b> Dunamis Machines International
                                                                                Private
                                                                                Limite</>d entrusted to you in the due
                                                                            discharge of your duties and shall indemnify <b>
                                                                                Dunamis Machines
                                                                                International Private Limited </b> when
                                                                            there is a loss of any kind to the said
                                                                            property.
                                                                        </p>
                                                                    </li>

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p class="paratag">
                                                                    All the other terms and conditions of your employment
                                                                    remain unchanged. As a token of your
                                                                    acceptance of the above terms and conditions, you are
                                                                    requested to sign the duplicate copy of this
                                                                    letter and return it to us.
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="">
                                                                <p class="paratag">
                                                                    Yours truly,
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-weight:bold;font-size:14px ">
                                                                For Ardens Business Solutions Pvt Ltd
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="font-weight:bold;padding:10px 0px;">
                                                                <img src="{{ URL::asset('assets/images/augustin_sign.png') }}"
                                                                    alt="" class=""
                                                                    style="height:50px;width:130px;">
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td style="padding-bottom:0;"> <span> Augustin Raj A -
                                                                    Managing Director and CEO </span>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 29px;">

                                                <div class="logo" style="width:100%;height:fit-content;">
                                                    <img src="{{ URL::asset('assets/images/footer.jpg') }}"
                                                        alt="" class="" style="height:100%;width:100%;">
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="carousel-item ">
                            <div class="main-page">
                                <table class="t-parent" style="padding:0;">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="logo" style="">
                                                    <img src="{{ URL::asset('assets/images/header.jpg') }}"
                                                        alt="" class="" style="height:100%;width:100%;">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="padding:50px 50px 12px ">
                                                <table border="1" id="ass_details_table" class="assign-table"
                                                    style="border-collapse: collapse;">
                                                    <tbody>
                                                        <tr style="border: 1px solid #000;">
                                                            <th align="center"
                                                                style="text-align:center;background-color:dodgerblue;font-weight: bold;padding:2px 0px;border-radius:0px !important"
                                                                colspan="12">
                                                                Annexure A
                                                            </th>
                                                        </tr>

                                                        <tr>
                                                            <th align="center"
                                                                style="text-align:center;background-color:dodgerblue;font-weight: bold;padding:2px 0px;color:#ffffff"
                                                                colspan="12">
                                                                Assignment Details
                                                            </th>
                                                        </tr>
                                                        <tr style="border:1px solid #000">
                                                            <td style="border:1px solid #000;font-weight: 600;"
                                                                colspan="6">Employee Name</td>
                                                            <td colspan="6"
                                                                style="border:1px solid #000;font-weight: 600;text-align:center;">
                                                            </td>
                                                        </tr>

                                                        <tr style="border:1px solid #000">
                                                            <td style="border:1px solid #000;font-weight: 600;"
                                                                colspan="6">Client Name</td>
                                                            <td style="border:1px solid #000;text-align:center;"
                                                                colspan="6">
                                                            </td>
                                                        </tr>
                                                        <tr style="border:1px solid #000">
                                                            <td style="border:1px solid #000;font-weight: 600;"
                                                                colspan="6">Place of Deputed</td>
                                                            <td style="border:1px solid #000;text-align:center;"
                                                                colspan="6">
                                                            </td>
                                                        </tr>
                                                        <tr style="border:1px solid #000">
                                                            <td style="border:1px solid #000;font-weight: 600;"
                                                                colspan="6">Designation</td>
                                                            <td style="border:1px solid #000;text-align:center;"
                                                                colspan="6">
                                                            </td>
                                                        </tr>
                                                        <tr style="border:1px solid #000">
                                                            <td style="border:1px solid #000;font-weight: 600;"
                                                                colspan="6">Start date of Assignment</td>
                                                            <td style="border:1px solid #000;text-align:center;"
                                                                colspan="6">
                                                            </td>
                                                        </tr>
                                                        <tr style="border:1px solid #000">
                                                            <td style="border:1px solid #000;font-weight: 600;"
                                                                colspan="6">End date of Assignment</td>
                                                            <td style="border:1px solid #000;text-align:center;"
                                                                colspan="6">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th style="font-size:13px;background-color:gainsboro;font-weight: bold;text-align:center;"
                                                                colspan="12">
                                                                Salary Break Up Details
                                                            </th>
                                                        </tr>
                                                        <tr style="border:1px solid #000">
                                                            <th colspan="4"
                                                                style="background-color:dodgerblue;color: white;;text-align:center;border:1px solid #000">
                                                                Components</th>
                                                            <th colspan="4"
                                                                style="background-color:dodgerblue;color: white;;text-align:center;border:1px solid #000">
                                                                Monthly</th>
                                                            <th colspan="4"
                                                                style="background-color:dodgerblue;color: white;text-align:center;border:1px solid #000">
                                                                Yearly</th>
                                                        </tr>
                                                        <tr style="border:1px solid #000">
                                                            <td colspan="4" class="data-center"
                                                                style="text-align:left;border:1px solid #000;font-weight:500;">
                                                                Basic </td>
                                                            <td colspan="4" class="data-center"
                                                                style="text-align:right;border:1px solid #000;font-weight:500;">
                                                            </td>
                                                            <td colspan="4" class="data-center"
                                                                style="text-align:right;border:1px solid #000;font-weight:500;">
                                                            </td>
                                                        </tr>
                                                        <tr style="border:1px solid #000">
                                                            <td colspan="4" class="data-center"
                                                                style="text-align:left;border:1px solid #000;font-weight:500;">
                                                                House Rent Allowance </td>
                                                            <td colspan="4" class="data-center"
                                                                style="text-align:right;border:1px solid #000;font-weight:500;">
                                                            </td>
                                                            <td colspan="4" class="data-center"
                                                                style="text-align:right;border:1px solid #000;font-weight:500;">
                                                            </td>
                                                        </tr>
                                                        <tr style="border:1px solid #000">
                                                            <td colspan="4" class="data-center"
                                                                style="text-align:left;border:1px solid #000;font-weight:500;">
                                                                Special Allowance </td>
                                                            <td colspan="4" class="data-center"
                                                                style="text-align:right;border:1px solid #000;font-weight:500;">
                                                            </td>
                                                            <td colspan="4" class="data-center"
                                                                style="text-align:right;border:1px solid #000;font-weight:500;">
                                                            </td>
                                                        </tr>
                                                        <tr style="border:1px solid #000">
                                                            <td colspan="4" class="data-center"
                                                                style="text-align:left;border:1px solid #000;font-weight:500;">
                                                                Basic </td>
                                                            <td colspan="4" class="data-center"
                                                                style="text-align:right;border:1px solid #000;font-weight:500;">
                                                            </td>
                                                            <td colspan="4" class="data-center"
                                                                style="text-align:right;border:1px solid #000;font-weight:500;">
                                                            </td>
                                                        </tr>
                                                        <tr style="border:1px solid #000">
                                                            <th colspan="4"
                                                                style="background-color:dodgerblue;color: white;text-align:left;border:1px solid #000">
                                                                Gross Salary</th>
                                                            <th colspan="4"
                                                                style="background-color:dodgerblue;color: white;text-align:center;border:1px solid #000">
                                                            </th>
                                                            <th colspan="4"
                                                                style="background-color:dodgerblue;color: white;text-align:center;border:1px solid #000">
                                                            </th>
                                                        </tr>
                                                        <tr style="border:1px solid #000">
                                                            <td colspan="4" class="data-center"
                                                                style="text-align:left;border:1px solid #000;font-weight:500;">
                                                                Employer's Contribution to ESI </td>
                                                            <td colspan="4" class="data-center"
                                                                style="text-align:right;border:1px solid #000;font-weight:500;">
                                                            </td>
                                                            <td colspan="4" class="data-center"
                                                                style="text-align:right;border:1px solid #000;font-weight:500;">
                                                            </td>
                                                        </tr>
                                                        <tr style="border:1px solid #000">
                                                            <td colspan="4" class="data-center"
                                                                style="text-align:left;border:1px solid #000;font-weight:500;padding:2px 5px;text-align:left">
                                                                Employer's Contribution to EPF </td>
                                                            <td colspan="4" class="data-center"
                                                                style="text-align:right;border:1px solid #000;font-weight:500;padding:2px 5px;text-align:right;">
                                                            </td>
                                                            <td colspan="4" class="data-center"
                                                                style="text-align:right;border:1px solid #000;font-weight:500;padding:2px 5px;text-align:right;">
                                                            </td>
                                                        </tr>
                                                        <tr style="border:1px solid #000">
                                                            <th colspan="4"
                                                                style="background-color:dodgerblue;color: white;padding: 2px 5px;text-align:center;border:1px solid #000;text-align:left">
                                                                CTC (Cost to the company) </th>
                                                            <th colspan="4"
                                                                style="background-color:dodgerblue;color: white;padding: 2px 5px;text-align:center;border:1px solid #000;text-align:right">
                                                            </th>
                                                            <th colspan="4"
                                                                style="background-color:dodgerblue;color: white;padding: 2px 5px;text-align:center;border:1px solid #000;text-align:right">
                                                            </th>
                                                        </tr>



                                                        <tr style="border:1px solid #000">
                                                            <td colspan="4" class="data-center"
                                                                style="text-align:left;border:1px solid #000;font-weight:500;padding:2px 5px;text-align:left">
                                                                Employee's Contribution to EPF </td>
                                                            <td colspan="4" class="data-center"
                                                                style="text-align:right;border:1px solid #000;font-weight:500;padding:2px 5px;text-align:right">
                                                            </td>
                                                            <td colspan="4" class="data-center"
                                                                style="text-align:right;border:1px solid #000;font-weight:500;padding:2px 5px;text-align:right">
                                                            </td>
                                                        </tr>
                                                        <tr style="border:1px solid #000">
                                                            <td colspan="4" class="data-center"
                                                                style="text-align:left;border:1px solid #000;font-weight:500;padding:2px 5px;text-align:left">
                                                                Employee's Contribution to ESI </td>
                                                            <td colspan="4" class="data-center"
                                                                style="text-align:right;border:1px solid #000;font-weight:500;padding:2px 5px;text-align:right">
                                                            </td>
                                                            <td colspan="4" class="data-center"
                                                                style="text-align:right;border:1px solid #000;font-weight:500;padding:2px 5px;text-align:right">
                                                            </td>
                                                        </tr>
                                                        <tr style="border:1px solid #000">
                                                            <td colspan="4" class="data-center"
                                                                style="text-align:left;border:1px solid #000;font-weight:500;padding:2px 5px;text-align:left">
                                                                Employee's Contribution to PT </td>
                                                            <td colspan="4" class="data-center"
                                                                style="text-align:right;border:1px solid #000;font-weight:500;padding:2px 5px;text-align:right">
                                                            </td>
                                                            <td colspan="4" class="data-center"
                                                                style="text-align:right;border:1px solid #000;font-weight:500;padding:2px 5px;text-align:right">
                                                            </td>
                                                        </tr>
                                                        <tr style="border:1px solid #000">
                                                            <th colspan="4"
                                                                style="background-color:dodgerblue;color: white;padding: 2px 5px;text-align:left;border:1px solid #000">
                                                                Net Take Home</th>
                                                            <th colspan="4"
                                                                style="background-color:dodgerblue;color: white;padding: 2px 5px;text-align:right;border:1px solid #000">
                                                            </th>
                                                            <th colspan="4"
                                                                style="background-color:dodgerblue;color: white;padding: 2px 5px;text-align:right;border:1px solid #000">
                                                            </th>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:0px 50px ;">
                                                <ul style="padding: 0px 0px 0px 8px; list-style: '*' outside none;">
                                                    <li>
                                                        <p class="paratag" style="margin: 0px 5px;">
                                                            Income tax, Professional Tax and LWF as applicable will be
                                                            deducted. All taxes will be deducted as
                                                            applicable by law </p>
                                                    </li>
                                                    <li>
                                                        <p class="paratag" style="    margin: 12px 5px;">
                                                            Your salary is strictly confidential.
                                                        </p>
                                                    </li>
                                                </ul>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 0px 50px;">
                                                <table style="width: 100%;">
                                                    <tbody>
                                                        <tr>
                                                            <td style="font-weight:bold;font-size:14px " colspan="6">
                                                                For Ardens Business Solutions Pvt Ltd
                                                            </td>
                                                            <td colspan="2">
                                                                <p style="font-weight: 600;"> Accepted by</p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="font-weight:bold;padding:10px 0px;" colspan="8">
                                                                <img src="{{ URL::asset('assets/images/augustin_sign.png') }}"
                                                                    alt="" class=""
                                                                    style="height:50px;width:130px;">
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td colspan="8">
                                                                <p style="font-weight: 600;"> Augustin Raj A -
                                                                    Managing Director and CEO</p>
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td colspan="8">
                                                                <hr
                                                                    style="border:1px solid #999999 ; margin: 0px 0px 5px 0px;">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td style="padding-top: 89px;">

                                                <div class="logo" style="width:100%;height:fit-content;">
                                                    <img src="{{ URL::asset('assets/images/footer.jpg') }}"
                                                        alt="" class="" style="height:100%;width:100%;">
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>


                            </div>
                        </div>
                        <div class="carousel-item">

                            <div class="main-page">
                                <table class="t-parent" style="padding:0;">
                                    <tbody>
                                        <tr>
                                            <td style="padding-bottom:20px">

                                                <div class="logo" style="width:100%;height:fit-content;">
                                                    <img src="{{ URL::asset('assets/images/header.jpg') }}"
                                                        alt="" class="" style="height:100%;width:100%;">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="padding:0px 50px">
                                                <table class="gen_terms-table">
                                                    <tbody>
                                                        <tr>
                                                            <td style="padding-bottom:10px;">
                                                                <p
                                                                    style="text-align:left;margin: 0;text-decoration: underline;font-weight: bold;">
                                                                    General Terms &
                                                                    Conditions</p>

                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding-right:15px;">
                                                                <ol style="list-style:;">
                                                                    <li>
                                                                        <p class="paratag">
                                                                            You will have to provide signed copies of all
                                                                            documents and forms in the joining kit including
                                                                            the
                                                                            signed appointment letter to Ardens Business
                                                                            Solutions Private Ltd. (ABS) within a period of
                                                                            30 days
                                                                            from your date of joining. The documents can be
                                                                            either couriered or handed over in person at
                                                                            the
                                                                            designated ABS offices. You will not be eligible
                                                                            for payroll in the subsequent months if these
                                                                            documents are not received within the 30-day
                                                                            period from your date of joining.
                                                                        </p>
                                                                    </li>

                                                                    <li>
                                                                        <p class="paratag">
                                                                            ABS is working towards having a safe transaction
                                                                            mode for all payments and follows the
                                                                            practice of
                                                                            remitting salary, reimbursement, F&F, and other
                                                                            payments directly to your designated bank
                                                                            account. You are required hereby to confirm your
                                                                            acceptance of the same and provide your Bank
                                                                            Account details with proof (cancelled cheque or
                                                                            copy of bank pass book or bank statement)
                                                                            within
                                                                            15 days of the date of joining to ABS personnel
                                                                            at the designated ABS offices or send an
                                                                            e-mail with
                                                                            scanned copy of the proofs mentioned to <a
                                                                                href="payroll@ardens.in">payroll@ardens.in</a>
                                                                            mentioning "bank account details" in
                                                                            the subject line of the mail
                                                                        </p>

                                                                    </li>
                                                                    <li>
                                                                        <p class="paratag">
                                                                            You will have to provide your PAN card details
                                                                            within 15 days of your date of joining

                                                                        </p>
                                                                        <ul style="padding-left:20px" type="circle">
                                                                            <li>You will have to provide your PAN card
                                                                                details within 15 days of your date of
                                                                                joining
                                                                            </li>
                                                                            <li>In case you do not provide PAN card details
                                                                                and your income falls under the taxable
                                                                                limits, you will be paid your monthly salary
                                                                                after deduction of taxes as per the existing
                                                                                tax laws.</li>
                                                                        </ul>
                                                                    </li>




                                                                    <li>
                                                                        <p class="paratag">
                                                                            Your pay slips will be available online for
                                                                            viewing, downloading, and printing. This is a
                                                                            digitally
                                                                            generated document and does not require a
                                                                            physical signature for verification. The pay
                                                                            slip
                                                                            will be
                                                                            available at the end of first week of the month
                                                                            and will be deemed to have been received and
                                                                            accepted by you. For any clarifications or
                                                                            queries, regarding the same you can send an
                                                                            email
                                                                            to
                                                                            payroll@ardens.in referencing your ABS
                                                                            employeeID
                                                                        </p>
                                                                    </li>



                                                                    <li>
                                                                        <p class="paratag">
                                                                            In case of any reimbursable components in your
                                                                            salary structure, you will be required to
                                                                            submit
                                                                            necessary proofs of payments and bills for the
                                                                            same, failing which the payments will be made
                                                                            after
                                                                            deduction of appropriate taxes.

                                                                        </p>
                                                                    </li>



                                                                    <li>
                                                                        <p class="paratag"> If you are eligible for ESIC
                                                                            benefits and have an existing ESIC number,
                                                                            please inform in advance
                                                                            through the ESIC nomination form in your joining
                                                                            kit to retain the existing ESIC number. For
                                                                            PF
                                                                            transfer from an existing PF account, you will
                                                                            need to fill and submit the PF transfer form in
                                                                            your
                                                                            joiningkit.
                                                                        </p>
                                                                    </li>



                                                                    <li>
                                                                        <p class="paratag">
                                                                            . ABS do not accept or retain any original
                                                                            certificates/ documents pertaining to your
                                                                            educational
                                                                            and other qualifications. You may be required to
                                                                            produce the same for verification purposes
                                                                            only
                                                                            if requested by authorized ABS personnel.
                                                                        </p>
                                                                    </li>




                                                                    <li>
                                                                        <p class="paratag">You will have to complete all
                                                                            the exit formalities and hand over any assets
                                                                            including but not limited
                                                                            to ID cards, laptops, mobiles, etc. in your
                                                                            custody before your Last Working Day (LWD) in
                                                                            the
                                                                            organization. Your Full & Final Settlement (F&F)
                                                                            will be completed only if the exit
                                                                            formalities are
                                                                            done on time, which shall not exceed 45 days</p>
                                                                    </li>
                                                                    <li>
                                                                        <p class="paratag">
                                                                            Your F&F settlement amount will be transferred
                                                                            to the bank account used for your salary
                                                                            transactions. In case, there are dues to be
                                                                            recovered from you in the F&F settlement, you
                                                                            will
                                                                            be
                                                                            issued your relieving letter and experience
                                                                            letters only on clearance of these dues.
                                                                        </p>
                                                                    </li>
                                                                </ol>
                                                            </td>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="padding-top:;">
                                                <div class="logo" style="width:100%;height:fit-content;">
                                                    <img src="{{ URL::asset('assets/images/footer.jpg') }}"
                                                        alt="" class="" style="height:100%;width:100%;">
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>


                            </div>
                        </div>
                        <div class="carousel-item ">
                            <div class="main-page">
                                <table class="t-parent" style="padding:0;">
                                    <tbody>
                                        <tr>
                                            <td style="padding-bottom:20px ;">
                                                <div class="logo" style="width:100%;height:fit-content;">
                                                    <img src="{{ URL::asset('assets/images/header.jpg') }}"
                                                        alt="" class="" style="height:100%;width:100%;">
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td align="center" style="padding:0px 50px 300px">
                                                <table>
                                                    <tbody>
                                                        <!-- <tr>
                                                                    <td>
                                                                        <ul style="list-style:decimal ;">
                                                                            <li>
                                                                                <p class="paratag">
                                                                                    Your F&F settlement amount will be transferred to the bank account used for your salary
                                                                                    transactions. In case, there are dues to be recovered from you in the F&F settlement, you will
                                                                                    be
                                                                                    issued your relieving letter and experience letters only on clearance of these dues.
                                                                                </p>
                                                                            </li>

                                                                    </td>
                                                                </tr> -->
                                                        <tr>
                                                            <td colspan="6">
                                                                <p class="paratag">
                                                                    As a token of your acceptance of the above terms and
                                                                    conditions, you are requested to sign the
                                                                    duplicate
                                                                    copy of this letter and return it to us.

                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-bottom: 10px;" colspan="6">
                                                                <p class="paratag">
                                                                    Wishing you the very best!
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="6">
                                                                <p class="paratag">
                                                                    Yours truly,
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-weight:bold;font-size:14px " colspan="6">
                                                                For Ardens Business Solutions Pvt Ltd
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="font-weight:bold;padding:10px 0px; "
                                                                colspan="6">
                                                                <img src="{{ URL::asset('assets/images/augustin_sign.png') }}"
                                                                    alt="" class=""
                                                                    style="height:50px;width:130px;">
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td colspan="6">
                                                                <p style="font-weight: 600;"> Augustin Raj A -
                                                                    Managing Director and CEO</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="6">
                                                                <hr
                                                                    style="border:1px solid #999999 ;height: 3px;background: #999999;margin: 0px 0px 5px 0px;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="6">
                                                                <p class="paratag">
                                                                    I <span style="font-weight: 600;"> </span>, have
                                                                    understood and accepted the appointment upon the terms
                                                                    and
                                                                    conditions as outlined in this appointment letter for my
                                                                    position at Ardens Business Solutions Privat
                                                                    Limited
                                                                </p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding: 15px 0px;" colspan="6">
                                                                <p style="text-decoration:underline;font-weight:600;">
                                                                    Acceptance:</p>

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4">
                                                                <p>
                                                                    Signature:

                                                                </p>

                                                            </td>
                                                            <td colspan=" 2">
                                                                <p>
                                                                    Date:
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>



                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="padding:205px 0px 10px 0px;">
                                                <hr style="height: 3px  ; background-color:gainsboro; border: none;">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">

                                                <div class="logo" style="width:100%;height:fit-content;">
                                                    <img src="{{ URL::asset('assets/images/footer.jpg') }}"
                                                        alt="" class="" style="height:100%;width:100%;">
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>


                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="main-page">
                                <table class="t-parent" style="padding:0;">
                                    <tbody>
                                        <tr>
                                            <td style="padding-bottom: 20px;">
                                                <div class="logo" style="width:100%;height:fit-content;">
                                                    <img src="{{ URL::asset('assets/images/header.jpg') }}"
                                                        alt="" class="" style="height:100%;width:100%;">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="padding:0px 50px">
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <p
                                                                    style="text-align: center;font-weight:bold;text-decoration: underline; margin: 0;">
                                                                    Annexure 2: HEALTH AND SAFETY POLICY</style=>
                                                                </p>

                                                            </td>

                                                        </tr>

                                                        <tr>
                                                            <td style="padding-bottom:10px;">
                                                                <p style="text-align:left;margin: 0;font-weight: bold;">
                                                                    1.Introduction</p>

                                                            </td>
                                                        </tr>
                                                        <tr>

                                                        <tr>
                                                            <td>
                                                                <ul style="list-style:none ;">
                                                                    <li>
                                                                        <p class="paratag">
                                                                            ABS recognizes people as its most important
                                                                            asset and is committed to ensuring safe and
                                                                            healthy work
                                                                            environment for all its employees and people
                                                                            visiting its premises. ABS’s Corporate Policy
                                                                            necessitates
                                                                            a specific Health & Safety Policy for its
                                                                            outsourced employees. Given that our AWs a
                                                                            re-deputed to
                                                                            various client sites, where each clients Health
                                                                            & Safety Policy would be different, it is our
                                                                            commitment
                                                                            to ensure that our AWs have safe working
                                                                            conditions, where risks if any, are well managed
                                                                            and
                                                                            our
                                                                            clients treat all our AWs as they would treat
                                                                            their direct employees in matters of health &
                                                                            safety.
                                                                        </p>
                                                                    </li>

                                                                    <li>
                                                                        <p class="paratag">
                                                                            This document is to be read and thoroughly
                                                                            understood by all ABS AWs at the time of joining
                                                                            an
                                                                            assignment; it requires them to be aware of the
                                                                            policy and our recommendations for safe
                                                                            working
                                                                            practices.
                                                                            We assure that we will not depute an AW to a
                                                                            client site, which causes an Occupational Hazard
                                                                            or risk
                                                                            to Health. We will only work with clients who
                                                                            are aligned with our Health & Safety Policy for
                                                                            AWs.
                                                                            Additionally, we advise our AWs and employees to
                                                                            bring to our notice, situations that an AW
                                                                            might
                                                                            encounter and could be a potential health &
                                                                            safety issue.
                                                                        </p>

                                                                    </li>




                                                                    <li>
                                                                        <p class="paratag">
                                                                            We also ask our AWs not to endanger themselves
                                                                            or their colleagues at work by violating any
                                                                            safety
                                                                            rules and to comply with workplace instructions
                                                                            besides ensuring that they wear Personal
                                                                            Protective
                                                                            Equipment where advised. Our AWs are asked not
                                                                            to interfere with or misuse anything provided
                                                                            for
                                                                            their safety, health, and welfare. This is a
                                                                            condition of employment with ABS. Management
                                                                            reviews
                                                                            will be held each year to review the
                                                                            implementation of this policy and draw upon
                                                                            further
                                                                            improvements for the following year. These
                                                                            improvements will include the policy itself and
                                                                            the
                                                                            associated business processes to attain the
                                                                            objective of this policy.
                                                                        </p>
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding-bottom:10px;">
                                                                <p style="text-align:left;margin: 0;font-weight: bold;">2.
                                                                    Health & Safety Policy
                                                                </p>



                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p class="paratag">Health & Safety in the workplace is
                                                                    everyone’s responsibility. ABS regards the
                                                                    promotion of Health &
                                                                    Safety measures as a mutual objective for the management
                                                                    and employees, including deputed
                                                                    employees. ABS has factored in statutory requirements
                                                                    while arriving at this Health &
                                                                    SafetyPolicy.
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-bottom:10px;">
                                                                <p style="text-align:left;margin: 0;font-weight: bold;">
                                                                    General Safety
                                                                </p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding-left:40px">
                                                                <ul class="cont-list"style=";">
                                                                    <li>
                                                                        <p class="paratag">
                                                                            Ensure that you are aware of your own
                                                                            responsibilities in respect of relevant health,
                                                                            safety,
                                                                            and
                                                                            environmental matters.
                                                                        </p>
                                                                    </li>

                                                                    <li>
                                                                        <p class="paratag">
                                                                            . Follow instructions the way it is meant to be.
                                                                            Use entries and exits, and lifts in the
                                                                            manner it is meant
                                                                            tobe
                                                                        </p>

                                                                    </li>

                                                                    <li>
                                                                        <p class="paratag">
                                                                            Ensure you always have your AW ID card on your
                                                                            person with your photograph, ABS contact
                                                                            details
                                                                            and Nos. displayed in a clearmanner.
                                                                        </p>
                                                                    </li>

                                                                    <li>
                                                                        <p class="paratag">
                                                                            If you have a visitor, ensure your visitor signs
                                                                            in, and receives a security pass. Do not take
                                                                            your
                                                                            visitor into the client premises without
                                                                            permission.

                                                                        </p>
                                                                    </li>

                                                                    <li>
                                                                        <p class="paratag">
                                                                            You will not enter your work premises while
                                                                            under the influence of alcohol, drugs or any
                                                                            substance
                                                                            which may endanger your health or safety and/or
                                                                            that of any other person.

                                                                        </p>
                                                                    </li>



                                                                </ul>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                <p class="paratag">
                                                                    Beware of fact that many things which may be obvious get
                                                                    overlooked while working. Thus,
                                                                    appropriate care and concentration is required at work
                                                                    to ensure generalsafety.
                                                                </p>
                                                            </td>
                                                        </tr>



                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <tr>
                                    <td colspan="4" style="padding-top:49px ;">

                                        <div class="logo" style="width:100%;height:fit-content;">
                                            <img src="{{ URL::asset('assets/images/footer.jpg') }}" alt=""
                                                class="" style="height:100%;width:100%;">
                                        </div>
                                    </td>
                                </tr>
                                </tbody>

                                </table>


                            </div>

                        </div>

                        <div class="carousel-item">
                            <div class="main-page">
                                <table class="t-parent" style="padding:0;">
                                    <tbody>
                                        <tr>
                                            <td colspan="4" style="padding-bottom: 20px;">

                                                <div class="logo" style="width:100%;height:fit-content;">
                                                    <img src="{{ URL::asset('assets/images/header.jpg') }}"
                                                        alt="" class="" style="height:100%;width:100%;">
                                                </div>
                                            </td>
                                        </tr>



                                        <tr>
                                            <td align="center" style="padding:0px 50px">

                                                <table>
                                                    <tbody>

                                                        <tr>
                                                            <td style="padding:0px;">
                                                                <p style="text-align:left;margin: 0;font-weight: bold;">
                                                                    Fire Safety</p>

                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                <ul style="margin: -6px;list-style: decimal  ;">
                                                                    <li>
                                                                        <p class="paratag">
                                                                            Ensure familiarity with the fire safety
                                                                            procedures in workplace. Most organizations have
                                                                            fire
                                                                            safety
                                                                            training as a statutory requirement. Ensure you
                                                                            attend the same, after seeking necessary
                                                                            permission from your reporting manager.
                                                                        </p>
                                                                    </li>

                                                                    <li>
                                                                        <p class="paratag">
                                                                            Understand different kinds of firefighting
                                                                            equipment’s installed at your workplace.
                                                                        </p>

                                                                    </li>

                                                                    <li>
                                                                        <p class="paratag">
                                                                            Please become familiar to the sound of the fire
                                                                            alarm and know the emergency/fire exits. These
                                                                            are
                                                                            not normal entry/exits. These exits are signed
                                                                            with the statutory fire exitsigns.
                                                                        </p>
                                                                    </li>

                                                                    <li>
                                                                        <p class="paratag">
                                                                            Attend fire drill if any at your workplace and
                                                                            undergo evacuation training

                                                                        </p>
                                                                    </li>

                                                                    <li>
                                                                        <p class="paratag">
                                                                            Avoid taking personal risks; do not try to
                                                                            tackle fire on your own.

                                                                        </p>
                                                                    </li>



                                                                </ul>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding:0px;">
                                                                <p style="text-align:left;margin: 0;font-weight: bold;">
                                                                    Accident & First Aid</p>

                                                                <p class="paratag">
                                                                    Familiarize yourself with the First Aid arrangements at
                                                                    your workplace. Do not leave vehicles or
                                                                    items
                                                                    relating to your work in places other than that which is
                                                                    designated. This will help prevent
                                                                    accidents.
                                                                </p>

                                                            </td>
                                                        </tr>


                                                        <tr>
                                                            <td>
                                                                <ul class="cont-list" style="margin: -6px;">
                                                                    <li>
                                                                        <p class="paratag">
                                                                            Follow rules on speed limit and wearing safety
                                                                            gear as is prescribed at the work environment
                                                                            that you
                                                                            are at.
                                                                        </p>
                                                                    </li>

                                                                    <li>
                                                                        <p class="paratag">
                                                                            If your office premises require you to wear a
                                                                            helmet while entering or exiting, comply with
                                                                            the same.
                                                                        </p>

                                                                    </li>

                                                                    <li>
                                                                        <p class="paratag">
                                                                            In the event of an accident, do not handle it on
                                                                            your own; follow procedures that you may
                                                                            have been
                                                                            trained in; inform the facilities manager or
                                                                            emergency numbers provided.
                                                                        </p>
                                                                    </li>

                                                                    <li>
                                                                        <p class="paratag">
                                                                            Understand accident report procedures at your
                                                                            work site.

                                                                        </p>
                                                                    </li>

                                                                    <li>
                                                                        <p class="paratag">
                                                                            Always let someone know, where you are going and
                                                                            your expected time ofreturn.

                                                                        </p>
                                                                    </li>



                                                                </ul>
                                                            </td>
                                                        </tr>


                                                        <td style="padding:0px;">
                                                            <p style="text-align:left;margin: 0;font-weight: bold;">As a
                                                                ABS AW, you have the right to:</p>
                                                        </td>
                                        </tr>


                                        <tr>
                                            <td>
                                                <ul class="cont-list" style="margin: -6px;">
                                                    <li>
                                                        <p class="paratag">
                                                            Work in places where all the risks to your health and safety are
                                                            properly controlled.
                                                        </p>
                                                    </li>

                                                    <li>
                                                        <p class="paratag">
                                                            If your office premises require you to wear a helmet while
                                                            entering or exiting, comply with the same.
                                                        </p>

                                                    </li>

                                                    <li>
                                                        <p class="paratag">
                                                            To stop working and leave the area if you think you are
                                                            indanger.
                                                        </p>
                                                    </li>

                                                    <li>
                                                        <p class="paratag">
                                                            To inform your employer about health and safety issues or
                                                            concerns.

                                                        </p>
                                                    </li>


                                                </ul>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td style="padding:0px;">
                                                <p style="text-align:left;margin: 0;font-weight: bold;">Recommendations for
                                                    Common Safe Working Practices
                                                </p>



                                            </td>
                                        </tr>


                                        <tr>
                                            <td>
                                                <ul class="cont-list" style="margin: -6px;">
                                                    <li>
                                                        <p class="paratag">
                                                            Do not smoke in areas prohibited.
                                                        </p>
                                                    </li>

                                                    <li>
                                                        <p class="paratag">
                                                            Do not expose electric conduits/plugs/sockets to water.

                                                        </p>

                                                    </li>

                                                    <li>
                                                        <p class="paratag">
                                                            If your work requires you to lift weight frequently, understand
                                                            load management procedures at
                                                            work.
                                                        </p>
                                                    </li>

                                                    <li>
                                                        <p class="paratag">
                                                            Do not operate machinery unless you have been trained and
                                                            authorized to do so

                                                        </p>
                                                    </li>

                                                    <li>
                                                        <p class="paratag">
                                                            If you use tools as part of your work, use only the right and
                                                            authorized tools.

                                                        </p>
                                                    </li>

                                                    <li>
                                                        <p class="paratag">
                                                            . Report any Health and Safety incidents whether they result in
                                                            injury or not to your respective ABS
                                                            anchor
                                                        </p>
                                                    </li>

                                                    <li>
                                                        <p class="paratag">
                                                            Cooperate in the investigation of accidents with the objective
                                                            of introducing measures to prevent
                                                            a recurrence.

                                                        </p>
                                                    </li>



                                                </ul>
                                            </td>
                                        </tr>

                                        <tr>

                                            <td style="font-weight:bold;font-size:14px ">
                                                For Ardens Business Solutions Pvt Ltd
                                            </td>

                                        </tr>

                                        <tr>
                                            <td style="font-weight:bold;padding:10px 0px;">
                                                <img src="{{ URL::asset('assets/images/augustin_sign.png') }}"
                                                    alt="" class="" style="height:50px;width:130px;">
                                            </td>

                                        </tr>

                                        <tr>
                                            <td> <span> Augustin Raj A -
                                                    Managing Director and CEO </span>
                                            </td>
                                        </tr>


                                        </td>
                                    </tbody>
                                </table>
                                </td>
                                </tr>

                                <tr>
                                    <td colspan="4" style="padding-top: 40px ;">

                                        <div class="logo" style="width:100%;height:fit-content;">
                                            <img src="{{ URL::asset('assets/images/footer.jpg') }}" alt=""
                                                class="" style="height:100%;width:100%;">
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
                        <span class="carousel-control-prev-icon bg-secondary rounded-circle" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button"
                        data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-secondary rounded-circle" aria-hidden="true"></span>
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
                                            <!-- <div class="header-cotent">

                                                        <h6 class="margin-0">Brand Avatar LLP</h6>
                                                        <p class="mb-0">NO-01,Kandasamy Street,</p>
                                                        <p class="mb-0">Chandrabagh Ave 2nd St, Dr. Radha Krishnan Salai, </p>
                                                        <p class="mb-0">Mylapore, Chennai, Tamil Nadu 600004</p>
                                                    </div> -->
                                        </td>
                                        <td colspan="4" class="border-less p3">

                                            <div class="header-img txt-right d-flex align-items-center"
                                                style="height:100px ;">
                                                <img src="" title="">
                                                <img src="{{ URL::asset('assets/images/logo.png') }}" class=""
                                                    alt="" style="height: 50px;width:180px;max-height:100%;">
                                            </div>


                                        </td>
                                    </tr>


                                    <tr>
                                        <td colspan="12">
                                            <p class="sub-header txt-center bg-ash text-strong">PAYSLIP FOR THE MONTH OF
                                                &ndash;APR-2022</p>
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
                                            <p class="txt-right">638.00</p>
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
                                                signature</p>
                                        </td>
                                    </tr>

                                    <tr class="border-less">
                                        <td colspan="8" class="border-less">
                                            <p class="txt-left">Please
                                                reach out to us for any payroll queries at -payroll@ardens.in</p>
                                        </td>
                                        <td colspan="2" class="border-less txt-right">
                                            <p>Generated By</p>


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
@endsection
