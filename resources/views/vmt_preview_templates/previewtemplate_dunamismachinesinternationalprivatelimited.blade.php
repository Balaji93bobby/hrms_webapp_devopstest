@extends('layouts.master')
@section('title')
    @lang('translation.settings')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/css/preview_template.css') }}" rel="stylesheet">
    <style>
        table.dunamis_table tr td,
        table.dunamis_table tr {
            border: 1px solid #000 !important;
            padding: 0px 10px;
            font-size: 14px;
            border-radius: 0px !important;
        }

        .bg-blue {
            background: #6292CF;
        }

        .txt-white {
            color: #fff;
        }

        .main-page img {
            display: revert !important;
        }

        table.letter-format td,
        table.letter-format td p {
            text-align: justify !important;
        }

        table.letter-format ol li,
        table.letter-format ol {
            padding-top: .8em;
            padding-bottom: .8em;
            list-style: revert !important;
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
                                                                        <p class="fw-600 "
                                                                            style="text-align: right !important">
                                                                            Date:dd-mm-yyyy
                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="12" align="center"
                                                                        style="text-align: center !important">
                                                                        <b class="border-bottom-line">WELCOME
                                                                            NOTE</b>


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
                                                                        <ul style="list-style: none">

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

                                                                        </ul>
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

                                                                        <ul style="list-style: none" class="">

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

                                                                        </ul>


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
                                                                style="height:100%;width:100%;">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="center" style="padding:0cm 1cm 0 1cm;">
                                                        <table class="table-one">
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="12" align="right">
                                                                        <p class="fw-600 "
                                                                            style="padding-bottom: 1.5em;text-align:right !important;">
                                                                            Date:dd-mm-yyyy
                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="12" align="" class="pb-10">
                                                                        <p class="fw-600 txt-left">
                                                                            To,
                                                                        </p>
                                                                        <p class="fw-600 pt-5 txt-left">
                                                                            Mr.XYZ
                                                                        </p>
                                                                        <p class="fw-600 pt-5 txt-left">
                                                                            Employee Code -XYZ
                                                                        </p>

                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td colspan="12" align="center"
                                                                        style="padding-bottom: 1.5em;text-align:center !important;">
                                                                        <b>
                                                                            FIXED-TERM CONTRACT OF EMPLOYMENT
                                                                        </b>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="12" align="">
                                                                        <p class=" pb-10" style="">
                                                                            We are pleased to appoint you to our
                                                                            organization as SENIOR EXCUTIVE, for a fixed
                                                                            period of employment, on the following terms and
                                                                            conditions:
                                                                        </p>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td colspan="12" align="">
                                                                        <ol>
                                                                            <li class="">Your contract of employment
                                                                                shall be valid
                                                                                for a period of 1 year from
                                                                                <b>dd-mm-yyyy</b> to
                                                                                <b>dd-mm-yyyy</b> Notwithstanding this, in
                                                                                the
                                                                                event of the project/ work for which you are
                                                                                being employed comes to an end before the
                                                                                aforementioned period, this contract shall
                                                                                be co- terminus with the aforementioned
                                                                                project/work. At the end of the above
                                                                                referred period, the contract will stand
                                                                                terminated automatically without any notice
                                                                                or communication to you, unless they are
                                                                                explicitly extended by us by a letter
                                                                                inwriting

                                                                            </li>
                                                                            <li class="pt-5">
                                                                                Notwithstanding anything above, depending
                                                                                upon the aforementioned project/work, the
                                                                                Company reserves its right to extend your
                                                                                temporary appointment for such period or
                                                                                periods as may be necessary depending upon
                                                                                the exigencies relatable to the work for
                                                                                which you are hereby engaged. In that event,
                                                                                the Company shall in writing extend your
                                                                                temporary assignment on the terms as may be
                                                                                indicated in such letter, and in the event
                                                                                of your acceptance of the such extension of
                                                                                the assignment, you shall be governed by
                                                                                such terms and conditions as may be
                                                                                indicated therein.
                                                                            </li>
                                                                            <li class="pt-5">
                                                                                During the period of the fixed contract,
                                                                                your services could be deputed at the sole
                                                                                discretion of the Management to any of our
                                                                                client’s companies or locations to do work
                                                                                pertaining to or incidental to the client's
                                                                                business.
                                                                            </li>
                                                                            <li class="pt-5">
                                                                                Details of your salary break up with
                                                                                components are as per <span class="fw-600">
                                                                                    Annexure1</span>
                                                                            </li>
                                                                            <li class="pt-5">
                                                                                You will be entitled to an employer's
                                                                                contribution to the Provident Fund to the
                                                                                extent of 12% or 1800/- restricted wages of
                                                                                your gross salary excluding house rent
                                                                                allowance.
                                                                            </li>
                                                                            <li class="pt-5">
                                                                                You will be eligible to get the ESIC medical
                                                                                benefits for you and your immediate family
                                                                                members if your gross wages are less than or
                                                                                equal to 21000/-.
                                                                            </li>
                                                                            <li class="pt-5">
                                                                                You will be eligible for leave as per the
                                                                                client's company policy, during the period
                                                                                of your contract of employment.
                                                                            </li>
                                                                            <li class="pt-5">
                                                                                You will be entitled to all other statutory
                                                                                benefits wherever applicable during the
                                                                                fixed period ofthe contract.
                                                                            </li>
                                                                            <li class="pt-5"
                                                                               >
                                                                                You are advised to read and understand ABS
                                                                                Health & Safety Policy for associates
                                                                                (Annexure 2) and comply with relevant
                                                                                policies that are in practice at Ardens
                                                                                Business Solutions Private Limited.
                                                                                Adherence to the stated and relevant
                                                                                policies is a condition of employment with
                                                                                ABS. In the event you are found to be
                                                                                non-compliant with any of the applicable
                                                                                policies, ABS reserves the right to take
                                                                                necessary action against you.

                                                                            </li>
                                                                            <li class="pt-5">

                                                                                    This contract shall be terminable by
                                                                                    either
                                                                                    party giving 30 day's notice in writing
                                                                                    or
                                                                                    salary in lieu of notice, to the other.

                                                                            </li>
                                                                        </ol>
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top:4.6em">
                                                        <div class="logo" style="width:100%;height:fit-content;">
                                                            <img src="{{ URL::asset('assets/images/abs_footer-label.jpg') }}"
                                                                alt="" class=""
                                                                style="height:100%;width:100%;">
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
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="logo" style="width:100%;height:100px;">
                                                            <img src="{{ URL::asset('assets/images/header.jpg') }}"
                                                                alt="" class=""
                                                                style="height:100%;width:100%;">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="center" style="padding:1cm 1cm 0 1cm;">
                                                        <table class="table-one">
                                                            <tbody>

                                                                <tr>
                                                                    <td colspan="12" align="" class="pt-10">
                                                                        <p class="txt-left a pt-10">
                                                                            We are consciously endeavoring to build an
                                                                            atmosphere of trust, openness, responsiveness,
                                                                            autonomy, and growth among all members of the
                                                                            ABS family. As a new entrant, we would like you
                                                                            to wholeheartedly contribute to this process.
                                                                        </p>
                                                                        <p class="txt-left a pt-10">
                                                                            As a token of your acceptance of the above terms
                                                                            and conditions, you are requested to sign the
                                                                            duplicate copy of this letter and return it to
                                                                            us.
                                                                        </p>

                                                                        <p class="pt-10 ">
                                                                            Wishing you the very best!
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="12"align="left">
                                                                        <p class="txt-left pt-30 ">
                                                                            Yours truly,
                                                                        </p>
                                                                        <p class="txt-left pt-10">
                                                                            <b>For Ardens Business Solutions Private
                                                                                Limited</b>
                                                                        </p>
                                                                        <div
                                                                            style="padding:8px 0px;width:185px;height:77px">
                                                                            <img src="{{ URL::asset('assets/images/augustin_sign.png') }}"
                                                                                alt="" class=""
                                                                                style="height:60px;width:140px;">
                                                                        </div>
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
                                                                    <td colspan="12" align="left">
                                                                        <p class="txt-left pt-30 fw-600 ">

                                                                            Acceptance
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="6" style="padding-top: 1cm;"
                                                                        align="left">
                                                                        <p class="txt-left fw-600">
                                                                            Signature:
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="6" style="padding-top: 1cm;"
                                                                        align="center">
                                                                        <p class="txt-right fw-600">
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
                                                            style="width:100%;height:fit-content;padding-top:297px;">
                                                            <img src="{{ URL::asset('assets/images/abs_footer-label.jpg') }}"
                                                                alt="" class=""
                                                                style="height:100%;width:100%;">
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
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="logo" style="width:100%;height:100px;">
                                                            <img src="{{ URL::asset('assets/images/header.jpg') }}"
                                                                alt="" class=""
                                                                style="height:100%;width:100%;">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="center" style="padding:1cm 1cm 0 1cm;">
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
                                                                    <td colspan="12" align="" class="pb-10">
                                                                        <p class="fw-600 txt-left">
                                                                            To,
                                                                        </p>
                                                                        <p class="fw-600 pt-5 txt-left">
                                                                            Mr.XYZ
                                                                        </p>
                                                                        <p class="fw-600 pt-5 txt-left">
                                                                            Employee Code -XYZ
                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="12" align="" class="pt-pb-10 ">
                                                                        <p class="txt-center"> <span
                                                                                class="fw-600 border-bottom-line">
                                                                                DEPUTATION LETTER
                                                                            </span>
                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="12" align="" class="pt-pb-10 ">

                                                                        <p class="pb-10">
                                                                            Further to clause 3 of your letter of
                                                                            employment, we are pleased to advise you that
                                                                            your services are
                                                                            being deputed to Dunamis Machines International
                                                                            Private Limited with effect from dd-mm-yyyy at
                                                                            their Chennai office.
                                                                        </p>
                                                                        <p class="">
                                                                            Your total remuneration package (CTC) per annum
                                                                            is Rs. <b>XYZ</b> per annum (Rupees Rupees Four
                                                                            Lac
                                                                            Five Thousand Six Hundred Ninety Six Only). The
                                                                            break-up of your compensation package shall be
                                                                            as
                                                                            detailed in Annexure A

                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="12" align="" class="pt-pb-10 ">
                                                                        <ol>
                                                                            <li class="pt-10">
                                                                                <p> You will, with effect from
                                                                                    <b>dd-mm-yyyy</b> be required to work at
                                                                                    our
                                                                                    client's office/ premises at any of
                                                                                    their locations. During the tenure of
                                                                                    the
                                                                                    deputation, you will continue to be an
                                                                                    employee of Ardens
                                                                                    Business Solutions
                                                                                </p>
                                                                            </li>
                                                                            <li class="pt-10">
                                                                                <p>
                                                                                    . In the day-to-day functioning or
                                                                                    carrying
                                                                                    out all responsibilities, you will
                                                                                    receive
                                                                                    instructions from
                                                                                    Dunamis Machines International Private
                                                                                    Limited and will undertake to abide by
                                                                                    any
                                                                                    suggestions,
                                                                                    etc. given by any assigned person(s).
                                                                                </p>

                                                                            </li>
                                                                            <li class="pt-10">
                                                                                <p>
                                                                                    You shall also abide by any training
                                                                                    that
                                                                                    may be offered to you by Dunamis
                                                                                    Machines
                                                                                    International
                                                                                    Private Limited. You shall be bound to
                                                                                    follow the working hours of DMIPL
                                                                                </p>

                                                                            </li>
                                                                            <li class="pt-10">
                                                                                <p>You shall take care not to disclose
                                                                                    confidential information/trade secrets,
                                                                                    etc. that you may come
                                                                                    across in the course of your
                                                                                    responsibilities to anyone outside
                                                                                    Dunamis Machines International
                                                                                    Private Limited and use such information
                                                                                    only in connection with the service
                                                                                    provided to Dunamis
                                                                                    Machines International Private Limited
                                                                                </p>
                                                                            </li>
                                                                            <li class="pt-10">
                                                                                <p>You shall at no point of time stake any
                                                                                    claim or right to claim employment,
                                                                                    damage, loss, or
                                                                                    compensation of any sort whatsoever
                                                                                    against Dunamis Machines International
                                                                                    Private Limited.
                                                                                    This arrangement is purely a contractual
                                                                                    agreement between Ardens Business
                                                                                    Solutions Private
                                                                                    Limited and Dunamis Machines
                                                                                    International Private Limited for the
                                                                                    timespecified.</p>
                                                                            </li>

                                                                            <li>
                                                                                <p class="pt-10">
                                                                                    You shall not engage in any act
                                                                                    subversive of discipline in the course
                                                                                    of your duty/lies in the property
                                                                                    of Dunamis Machines International
                                                                                    Private Limited or outside, and if you
                                                                                    were at any time found
                                                                                    indulging in such act/s, we reserve the
                                                                                    right to initiate disciplinary action as
                                                                                    is deemed fit, against
                                                                                    you.
                                                                                </p>
                                                                            </li>
                                                                            <li>
                                                                                <p class="pt-10">
                                                                                    You shall be responsible for protecting
                                                                                    the property of Dunamis Machines
                                                                                    International Private
                                                                                    Limited entrusted to you in the due
                                                                                    discharge of your duties and shall
                                                                                    indemnify Dunamis Machines
                                                                                    International Private Limited when there
                                                                                    is a loss of any kind to the said
                                                                                    property.

                                                                                </p>
                                                                            </li>

                                                                        </ol>
                                                                    </td>
                                                                </tr>


                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <div class="logo"
                                                            style="width:100%;height:fit-content;padding-top:55px">
                                                            <img src="{{ URL::asset('assets/images/abs_footer-label.jpg') }}"
                                                                alt="" class=""
                                                                style="height:100%;width:100%;">
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
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="logo" style="width:100%;height:100px;">
                                                            <img src="{{ URL::asset('assets/images/header.jpg') }}"
                                                                alt="" class=""
                                                                style="height:100%;width:100%;">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="center" style="padding:1cm 1cm 0 1cm;">
                                                        <table class="table-one">
                                                            <tbody>

                                                                <tr>
                                                                    <td colspan="12" align="" class=" ">
                                                                        <p class="pb-30">
                                                                            All the other terms and conditions of your
                                                                            employment remain unchanged. As a token of your
                                                                            acceptance of the above terms and conditions,
                                                                            you are requested to sign the duplicate copy of
                                                                            this
                                                                            letter and return it to us.
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
                                                                    <td colspan="12" align="left">
                                                                        <p class="txt-left pt-30 fw-600 ">
                                                                            <span class="border-bottom-line">
                                                                                Acceptance</span>
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="6" style="padding-top: 1cm;"
                                                                        align="">
                                                                        <p class="txt-left fw-600">
                                                                            Signature:
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="6" style="padding-top: 1cm;"
                                                                        align="">
                                                                        <p class="txt-right fw-600">
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
                                                            style="width:100%;height:fit-content;padding-top:473px;">
                                                            <img src="{{ URL::asset('assets/images/abs_footer-label.jpg') }}"
                                                                alt="" class=""
                                                                style="height:100%;width:100%;">
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
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="logo" style="width:100%;height:100px;">
                                                            <img src="{{ URL::asset('assets/images/header.jpg') }}"
                                                                alt="" class=""
                                                                style="height:100%;width:100%;">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:1cm ">
                                                        <table border="1" align="center" class="dunamis_table"
                                                            style="border-collapse: collapse;width: 100%;padding-bottom: 1cm;;">
                                                            <tr class="bg-blue">
                                                                <td colspan="3" align="center"
                                                                    class="txt-white fw-600">
                                                                    Annexure A
                                                                </td>

                                                            </tr>
                                                            <tr class="bg-blue txt-white c">
                                                                <td colspan="3" align="center" class="fw-600">
                                                                    Assingment Details
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td colspan="1" align="left"><b>Employee Name</b>
                                                                </td>
                                                                <td colspan="2" style="" align="center"><b></b>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td colspan="1"><b>Client Name</b></td>
                                                                <td colspan="2" align="center"></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="1"><b>Place of deputed</b></td>
                                                                <td colspan="2" align="center"> </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="1">
                                                                    <b>Desingnation</b>
                                                                </td>
                                                                <td colspan="2" align="center"></td>

                                                            </tr>
                                                            <tr>
                                                                <td colspan="1">
                                                                    <b>Start date of Assingment</b>
                                                                </td>
                                                                <td colspan="2" align="center"></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="1"><b>End date of Assingment</b></td>
                                                                <td colspan="2" align="center"></td>
                                                            </tr>
                                                            <tr class="bg-ash">
                                                                <td colspan="3" align="center" class="bg-ash">
                                                                    <b>Salary Break Up Details</b>
                                                                </td>
                                                            </tr>
                                                            <tr class="bg-blue txt-white">
                                                                <td class="a" align="center"><b>Component</b></td>
                                                                <td class="a" align="center"><b>Monthly</b></td>
                                                                <td class="a" align="center"><b>Yearly</b></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Basic</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>House Rent Allowance</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Special Allowance</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr class="bg-blue">
                                                                <td class="txt-white fw-600">Gross Salary</td>
                                                                <td class="a"></td>
                                                                <td class="a"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Employer'scintribution to ESI</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Employer'scintribution to EPF</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr class="bg-blue">
                                                                <td class="fw-600 txt-white"><b>CTC(Cost of the
                                                                        Company)</b></td>
                                                                <td class="a"></td>
                                                                <td class="a"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Employee's Contribution to EPF
                                                                </td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Employee's Contribution to ESI</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Employee's Contribution to PT</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr class="bg-blue">
                                                                <td class="txt-white"><b>Net Take home</b></td>
                                                                <td class="a"></td>
                                                                <td class="a"></td>
                                                            </tr>
                                                        </table>



                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:0  1cm ">
                                                        <table>
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="12" style=" " align="left">
                                                                        <p class="txt-left">
                                                                            * Income tax, Professional Tax and LWF as
                                                                            applicable will be deducted. All taxes will be
                                                                            deducted as
                                                                            applicable by law.
                                                                        </p>
                                                                        <p class="pt-10">
                                                                            * Your salary is strictly confidential.
                                                                        </p>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td colspan="6"align="left">
                                                                        <p class="txt-left pt-30 fw-600">
                                                                            For Ardens Business Solutions Private
                                                                            Limited
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="6">
                                                                        <p class="txt-right fw-600 pt-30">
                                                                            Accepted By
                                                                        </p>


                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <img src="{{ URL::asset('assets/images/augustin_sign.png') }}"
                                                                            alt="" class=""
                                                                            style="height:60px;width:140px;padding:8px 0px;">

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="6" style="" align="left">
                                                                        <p class="txt-left fw-600">
                                                                            Augustin Raj A - Managing Director
                                                                        </p>

                                                                    </td>
                                                                    <td colspan="6" style="" align="left">
                                                                        <p class="txt-right fw-600">
                                                                            -
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
                                                            style="width:100%;height:fit-content;padding-top:10px;">
                                                            <img src="{{ URL::asset('assets/images/abs_footer-label.jpg') }}"
                                                                alt="" class=""
                                                                style="height:100%;width:100%;">
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
                                                                style="height:100%;width:100%;">
                                                        </div>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="center" style="padding:1cm 1cm 0;">
                                                        <table class="table-one">
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="12" style="" align="left">
                                                                        <p class="txt-left ">
                                                                            <b>General Terms & Conditions :</b>
                                                                        </p>
                                                                        <ol>
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
                                                                                <p class="txt-left a pt-10">
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
                                                                                    <a
                                                                                        href="payroll@ardens.in">payroll@ardens.in</a>
                                                                                    mentioning "bank account details" in the
                                                                                    subject
                                                                                    line of the mail.
                                                                                </p>
                                                                            </li>
                                                                            <li>
                                                                                <p class="txt-left a pt-10">
                                                                                    You will have to provide your PAN card
                                                                                    details
                                                                                    within 15 days of your date of joining.
                                                                                </p>

                                                                                <ol style="list-style: none">
                                                                                    <li>
                                                                                        <ul type="circle">

                                                                                            <li>
                                                                                                <p
                                                                                                    class="txt-left a pt-10">
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
                                                                                                <p
                                                                                                    class="txt-left a pt-10">
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

                                                                            <p class="txt-left a pt-10">
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
                                                                            <li>
                                                                                <p class="txt-left a pt-10">
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
                                                                                <p class="txt-left a pt-10">
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
                                                                                <p class="txt-left a pt-10  ">
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
                                                                                <p class="txt-left a pt-10">
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
                                                                        </ol>
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="logo"
                                                            style="width:100%;height:fit-content;padding-top:12px;">
                                                            <img src="{{ URL::asset('assets/images/abs_footer-label.jpg') }}"
                                                                alt="" class=""
                                                                style="height:100%;width:100%;">
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
                                                                style="height:100%;width:100%;">
                                                        </div>

                                                    </td>
                                                </tr>
                                                <tr>


                                                    <td align="center" style="padding: 1cm">
                                                        <table class="table-one">
                                                            <tbody>

                                                                <tr>
                                                                    <td colspan="12" style="" align="left">
                                                                        <ol start="9" type="1">
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

                                                                <tr>
                                                                    <td>

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
                                                            style="width:100%;height:fit-content;padding-top:403px;">
                                                            <img src="{{ URL::asset('assets/images/abs_footer-label.jpg') }}"
                                                                alt="" class=""
                                                                style="height:100%;width:100%;">
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
                                                                style="height:100%;width:100%;">
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
                                                                        <p class="txt-left pt-10">
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
                                                                        <p class="txt-left pt-10">
                                                                            This document is to be read and thoroughly
                                                                            understood by all ABS AWs at the time of joining
                                                                            an assignment; it requires them to be aware of
                                                                            the policy and our recommendations for safe
                                                                            working practices
                                                                        </p>
                                                                        <p class="txt-left pt-10">
                                                                            We assure that we will not depute an AW to a
                                                                            client site, which causes an Occupational Hazard
                                                                            or risk to Health. We will only work with
                                                                            clients who are aligned to our Health & Safety
                                                                            Policy for AWs. Additionally, we advise our AWs
                                                                            and employees to bring to our notice, situations
                                                                            that an AW might encounter and could be a
                                                                            potential health & safety issue.
                                                                        </p>
                                                                        <p class="txt-left pt-10">
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

                                                                        <ol>
                                                                            <li class="pt-10">Ensure that you are aware of
                                                                                your own
                                                                                responsibilities in respect of relevant
                                                                                health, safety and environmental matters.
                                                                            </li>
                                                                            <li style="" class="pt-10">Follow
                                                                                instructions the way it is meant to be. Use
                                                                                entries and exits, lifts in the manner it is
                                                                                meant to be.</li>
                                                                            <li style="" class="pt-10">Ensure you
                                                                                have
                                                                                your AW ID card on your person at all times
                                                                                with your photograph, ABS contact details
                                                                                and Nos. displayed in a clear manner.</li>
                                                                            <li style="" class="pt-10">If you have
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
                                                    <td>
                                                        <div class="logo"
                                                            style="width:100%;height:fit-content;padding-top:23px;">
                                                            <img src="{{ URL::asset('assets/images/abs_footer-label.jpg') }}"
                                                                alt="" class=""
                                                                style="height:100%;width:100%;">
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

                                                                        <b style="padding-bottom:1em"> As a ABS AW, you
                                                                            have the right to:</b>



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
                                                                    <td colspan="12" align="left">

                                                                        <b style="padding-bottom: 1em"> Recommendations for
                                                                            Common Safe Working
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
                                                                    <td colspan="12"align="left"
                                                                        style="padding-top:2em">

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
