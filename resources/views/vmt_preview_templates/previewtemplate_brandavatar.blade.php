@extends('layouts.master')
@section('title')
    @lang('translation.settings')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/css/preview_template.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="template-wrapper">
        <div class="card  left-line mb-2 ">
            <div class="card-body  pt-1 pb-0">
                <ul class="nav nav-pills nav-tabs-dashed" role="tablist">
                    <li class="nav-item text-muted " role="presentation">
                        <a class="nav-link active pb-2" data-bs-toggle="tab" href="#appointment" aria-selected="true"
                            role="tab">
                            Appointment Letter
                        </a>
                    </li>
                    <li class="nav-item text-muted mx-4" role="presentation">
                        <a class="nav-link  pb-2" data-bs-toggle="tab" href="#payslips" aria-selected="true" role="tab">
                            Pay Slip
                        </a>
                    </li>

                </ul>

            </div>
        </div>
        <div class="card mb-0">
            <div class="tab-content " id="pills-tabContent">
                <div class="tab-pane fade  active show " id="appointment" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div id="carousel_template" class="carousel slide" data-bs-touch="false" data-bs-interval="false">
                        <div class="carousel-inner">
                            <div class="carousel-item  active">
                                <div class="main-page appointment-letter">
                                    <div class="sub-page" style="text-align: justify;font-size: 15px;">
                                        <table class="letter-format" style="padding:0;">
                                            <tbody>
                                                <tr>
                                                    <td align="center" style="">
                                                        <table class="table-one">
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="12" class="" align="left">

                                                                        <div style="height: 50px;width:160px">
                                                                            <img src="{{ URL::asset('assets/images/appointment/avatar/brandavatarlogo.png') }}"
                                                                                class="" alt=""
                                                                                style="height:100%;width:100%;">
                                                                        </div>
                                                                    </td>

                                                                </tr>

                                                                <tr>
                                                                    <td colspan="12" style=" " class="pt-30 pb-30"
                                                                        align="center">
                                                                        <p class="fw-500 txt-center "
                                                                            style="font-size:20px">
                                                                            LETTER OF APPOINTMENT

                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="12" style=" " align="left">
                                                                        <p class="fw-500 pad-bottom-5 txt-left "
                                                                            style="">
                                                                            Dear Xyz,
                                                                        </p>
                                                                        <p class="pb-10">We are glad to appoint you as
                                                                            <span class="fw-500 txt-left">“Manager – Admin
                                                                                and HR”</span>&nbsp;
                                                                            in our company,
                                                                            &nbsp;<span class="fw-500 txt-left">Brand Avatar
                                                                                LLP
                                                                            </span>&nbsp;.
                                                                        </p>



                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="12" style=" " align="left">
                                                                        <p class="fw-500  txt-left " style="">
                                                                            Remuneration

                                                                        </p>
                                                                        <p class="pt-pb-5 pb-10">
                                                                            Your total remuneration package per annum will
                                                                            consist of &nbsp;<span class="fw-500 txt-left">
                                                                                CTC Rs Xyz- per annum
                                                                                (xyz)</span>&nbsp;.
                                                                            The breakup of your compensation package shall
                                                                            be as detailed in Annexure A.



                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="12" class="pb-10" style=" "
                                                                        align="left">
                                                                        <p class="fw-500 txt-left " style="">
                                                                            Commencement

                                                                        </p>
                                                                        <p class="pt-pb-5">
                                                                            Your employment with the company &nbsp;<span
                                                                                class="fw-500 txt-left"> Brand Avatar LLP .
                                                                            </span>&nbsp will
                                                                            be with effect from &nbsp;<span
                                                                                class="fw-500 txt-left"> DD-MM-
                                                                                YYYY</span>&nbsp;. You shall
                                                                            initially be placed in &nbsp;<span
                                                                                class="fw-500 txt-left"> YYY
                                                                            </span>&nbsp;. You may however
                                                                            be required to travel and maybe positioned
                                                                            or
                                                                            deputed outside within India or abroad.

                                                                        </p>

                                                                    </td>
                                                                </tr>


                                                                <tr>
                                                                    <td colspan="12" class="pb-10" style=" "
                                                                        align="left">
                                                                        <p class="fw-500 txt-left " style="">
                                                                            Rules and Regulations

                                                                        </p>
                                                                        <p class="pt-5">
                                                                            You shall be governed by the policies of the
                                                                            company as specified in &nbsp;<span
                                                                                class="fw-500 txt-left">Annexure
                                                                                B</span>&nbsp;. You shall
                                                                            serve the Company and shall carry out such
                                                                            duties which will be explained and defined
                                                                            by
                                                                            your manager (immediate superior), subject
                                                                            always to the employee policy and the rules
                                                                            and
                                                                            regulations of the Company. Your employment
                                                                            shall continue to be governed by the terms
                                                                            of
                                                                            this appointment letter in the event of you
                                                                            being deputed or positioned outside India.

                                                                        </p>

                                                                        <p class="pt-pb-5">
                                                                            You will be under probation for a period of
                                                                            &nbsp;<span class="fw-500 txt-left">SIX
                                                                                MONTHS </span>&nbsp;. Your confirmation
                                                                            will
                                                                            be based on the
                                                                            evaluation during the end of the probation
                                                                            period.


                                                                        </p>
                                                                        <p class="pt-pb-5">
                                                                            If you are agreeable to the terms and
                                                                            conditions
                                                                            of the appointment (Annexure B), then kindly
                                                                            confirm your acceptance of the appointment
                                                                            by
                                                                            signing and returning to us the attached
                                                                            copy of
                                                                            this letter.

                                                                        </p>

                                                                    </td>
                                                                </tr>


                                                                <tr class="border-bottom-line-ash">
                                                                    <td colspan="12" style=" " class="pad-bottom-5"
                                                                        align="left">
                                                                        <p class="fw-500 pt-15  txt-left " style="">
                                                                            Yours faithfully,
                                                                        </p>
                                                                        <p class="fw-500 pt-pb-15  txt-left "
                                                                            style="">
                                                                            For Brand Avatar LLP
                                                                        </p>

                                                                        <div style="height:70px;width:140px"
                                                                            class="pt-pb-15">
                                                                            <img src="{{ URL::asset('assets/images/appointment/avatar/sign2.png') }}"
                                                                                class="" alt="signature"
                                                                                style="height:100%;width:100%;">
                                                                        </div>



                                                                        <p class="fw-500 txt-left " style=" ">
                                                                            (Hemachandran L)
                                                                        </p>
                                                                        <p class="fw-500  txt-left " style=" ">
                                                                            Founder and CEO of Brand Avatar LLP
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="12" style=" " align="left">
                                                                        <p class=" pt-10 txt-left " style="">
                                                                            I <span class="fw-500 txt-left">
                                                                                Xyz,</span>&nbsp; have read &nbsp;<span
                                                                                class="fw-500 txt-left">ANNEXURE A &
                                                                                B,</span>&nbsp; understood, and accept
                                                                            the
                                                                            appointment upon the terms and conditions as
                                                                            outlined in this appointment letter for my
                                                                            position at &nbsp;<span
                                                                                class="fw-500 txt-left">Brand Avatar LLP
                                                                            </span>&nbsp;.

                                                                        </p>


                                                                    </td>
                                                                </tr>
                                                                <tr class="border-bottom-line-ash">
                                                                    <td colspan="6" class="pt-30"
                                                                        style="padding-bottom:103px " align="left">
                                                                        <p class="fw-500 txt-left " style="">
                                                                            Sign:
                                                                        </p>


                                                                    </td>
                                                                    <td colspan="6" class="pt-30"
                                                                        style="padding-bottom:103px " align="right">
                                                                        <p class="fw-500 txt-right " style="">
                                                                            Date:
                                                                        </p>


                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td colspan="12">
                                                                        <p class="txt-center">
                                                                            <span class="fw-500 txt-left " style="">
                                                                                Registered Office Address-
                                                                            </span>
                                                                            Brand Avatar LLP, No-01, Kandasamy Street,
                                                                            Chandrabagh Avenue Extn, Radhakrishnan Salai,
                                                                            Mylapore, Chennai, Tamilnadu -600 004.

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
                                                    <td colspan="12" class="pb-10" align="left">
                                                        <div style="height: 50px;width:160px">
                                                            <img src="{{ URL::asset('assets/images/appointment/avatar/brandavatarlogo.png') }}"
                                                                class="" alt=""
                                                                style="height:100%;width:100%;">
                                                        </div>

                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td class="" colspan="12">
                                                        <table class="salary-table avtatar-salary-table"
                                                            style="width: 100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="12" style=" "class=""
                                                                        align="center">
                                                                        <p class="fw-500 txt-center " style="">
                                                                            ANNEXURE A
                                                                        </p>

                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td colspan="12" style=" "class=""
                                                                        align="center">
                                                                        <p class="fw-500 txt-center " style="">
                                                                            SALARY STRUCTURE
                                                                        </p>

                                                                    </td>

                                                                </tr>

                                                                <tr>
                                                                    <td colspan="12" style=" "class=""
                                                                        align="center">
                                                                        <p class="fw-500 txt-center " style="">
                                                                            Your remuneration shall be paid to you under the
                                                                            following heads
                                                                        </p>

                                                                    </td>

                                                                </tr>

                                                                <tr>

                                                                    <td colspan="6" style=" "class="bg-ash "
                                                                        align="left">
                                                                        <p class="fw-500  txt-left" style="">
                                                                            Name:
                                                                        </p>

                                                                    </td>

                                                                    <td colspan="6" style=" "class="bg-ash ">
                                                                        <p class="fw-500  txt-center" style="">
                                                                            Salary
                                                                        </p>

                                                                    </td>

                                                                </tr>
                                                                <tr>

                                                                    <td colspan="6" style=" "class=" "
                                                                        align="left">
                                                                        <p class="fw-500  txt-left" style="">
                                                                            Designation
                                                                        </p>

                                                                    </td>

                                                                    <td colspan="6" style=" "class="">
                                                                        <p class="fw-500  txt-center" style="">

                                                                        </p>

                                                                    </td>

                                                                </tr>
                                                                <tr>

                                                                    <td colspan="6" style=" "class=" "
                                                                        align="left">
                                                                        <p class="fw-500  txt-left" style="">
                                                                            Department
                                                                        </p>

                                                                    </td>

                                                                    <td colspan="6" style=" "class=" ">
                                                                        <p class="fw-500  txt-center" style="">

                                                                        </p>

                                                                    </td>

                                                                </tr>
                                                                <tr>

                                                                    <td colspan="6" style=" "class=""
                                                                        align="left">
                                                                        <p class="fw-500  txt-left" style="">
                                                                            Date of Joining
                                                                        </p>

                                                                    </td>

                                                                    <td colspan="6" style=" "class=" ">
                                                                        <p class="fw-500  txt-center" style="">

                                                                        </p>

                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td colspan="6" style=" "class="bg-ash "
                                                                        align="center">
                                                                        <p class="fw-500  " style="">
                                                                            SALARY COMPONENTS
                                                                        </p>

                                                                    </td>
                                                                    <td colspan="3" style=" "class="bg-ash ">
                                                                        <p class="fw-500  txt-center" style="">
                                                                            Per Month
                                                                        </p>

                                                                    </td>
                                                                    <td colspan="3" style=" "class="bg-ash ">
                                                                        <p class="fw-500   txt-center   " style="">
                                                                            Per Annum
                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="6" style=" "class=" ">
                                                                        <p class=" txt-left " style="">
                                                                            Basic
                                                                        </p>

                                                                    </td>
                                                                    <td colspan="3" style=" "class="">
                                                                        <p class="  txt-right" style="">

                                                                        </p>

                                                                    </td>
                                                                    <td colspan="3" style=" "class="">
                                                                        <p class="   txt-right   " style="">

                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="6" style=" "class=" ">
                                                                        <p class=" txt-left " style="">
                                                                            HRA
                                                                        </p>

                                                                    </td>
                                                                    <td colspan="3" style=" "class="">
                                                                        <p class=" txt-right" style="">

                                                                        </p>

                                                                    </td>
                                                                    <td colspan="3" style=" "class="">
                                                                        <p class="   txt-right   " style="">

                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="6" style=" "class=" ">
                                                                        <p class=" txt-left " style="">
                                                                            Special Allowance
                                                                        </p>

                                                                    </td>
                                                                    <td colspan="3" style=" "class="">
                                                                        <p class=" txt-right" style="">

                                                                        </p>

                                                                    </td>
                                                                    <td colspan="3" style=" "class="">
                                                                        <p class="   txt-right   " style="">

                                                                        </p>

                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td colspan="6" style=" "class="bg-ash "
                                                                        align="center">
                                                                        <p class="  fw-500" style="">
                                                                            Gross
                                                                        </p>

                                                                    </td>
                                                                    <td colspan="3" style=" "class="bg-ash">
                                                                        <p class="fw-500   txt-center" style="">

                                                                        </p>

                                                                    </td>
                                                                    <td colspan="3" style=" "class="bg-ash">
                                                                        <p class="fw-500   txt-center   " style="">

                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="6" style=" "class=" ">
                                                                        <p class="" style="">
                                                                            PF (Employer Contribution)
                                                                        </p>

                                                                    </td>
                                                                    <td colspan="3" style=" "class="">
                                                                        <p class="  txt-center" style="">

                                                                        </p>

                                                                    </td>
                                                                    <td colspan="3" style=" "class="">
                                                                        <p class="   txt-center   " style="">

                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="6" style=" "class=" ">
                                                                        <p class=" txt-left " style="">
                                                                            ESI (Employer Contribution)
                                                                        </p>

                                                                    </td>
                                                                    <td colspan="3" style=" "class="">
                                                                        <p class=" txt-right" style="">

                                                                        </p>

                                                                    </td>
                                                                    <td colspan="3" style=" "class="">
                                                                        <p class="  txt-right   " style="">

                                                                        </p>

                                                                    </td>
                                                                </tr>

                                                                <tr class="">
                                                                    <td colspan="6" style=" "class="bg-ash">
                                                                        <p class="fw-500  txt-left" style="">
                                                                            Cost to Company
                                                                        </p>

                                                                    </td>
                                                                    <td colspan="3" style=" "class="bg-ash">
                                                                        <p class="fw-500  txt-right" style="">

                                                                        </p>

                                                                    </td>
                                                                    <td colspan="3" style=" "class="bg-ash">
                                                                        <p class="fw-500   txt-right   " style="">

                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="6" style=" "class=" ">
                                                                        <p class="txt-left " style="">
                                                                            EPF (Employee Contribution)
                                                                        </p>

                                                                    </td>
                                                                    <td colspan="3" style=" "class="">
                                                                        <p class="txt-right" style="">

                                                                        </p>

                                                                    </td>
                                                                    <td colspan="3" style=" "class="">
                                                                        <p class="ttxt-right   " style="">

                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="6" style=" "class=" ">
                                                                        <p class="txt-left " style="">
                                                                            ESI (Employee Contribution)
                                                                        </p>

                                                                    </td>
                                                                    <td colspan="3" style=" "class="">
                                                                        <p class="txt-right" style="">

                                                                        </p>

                                                                    </td>
                                                                    <td colspan="3" style=" "class="">
                                                                        <p class="txt-right   " style="">

                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="6" style=" "class=" ">
                                                                        <p class="txt-left " style="">
                                                                            Professional Tax

                                                                        </p>

                                                                    </td>
                                                                    <td colspan="3" style=" "class="">
                                                                        <p class="txt-right" style="">

                                                                        </p>

                                                                    </td>
                                                                    <td colspan="3" style=" "class="">
                                                                        <p class="txt-right   " style="">

                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="6" style=" "class="  bg-ash">
                                                                        <p class="txt-left " style="">
                                                                            Net Income
                                                                        </p>

                                                                    </td>
                                                                    <td colspan="3" style=" "class=" bg-ash">
                                                                        <p class="txt-right" style="">

                                                                        </p>

                                                                    </td>
                                                                    <td colspan="3" style=" "class=" bg-ash">
                                                                        <p class="ttxt-right   " style="">

                                                                        </p>

                                                                    </td>
                                                                </tr>


                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="12" style=" " class="pt-30" align="left">
                                                        <p class=" txt-left " style="">
                                                            I <span class="fw-500 txt-left">Xyz </span> have read
                                                            &nbsp;<span class="fw-500 txt-left">ANNEXURE A
                                                                &
                                                                B,</span>&nbsp; understood, and accept the
                                                            appointment upon the terms and conditions as
                                                            outlined in this appointment letter for my
                                                            position at &nbsp;<span class="fw-500 txt-left">Brand Avatar
                                                                LLP
                                                            </span>&nbsp;.

                                                        </p>


                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="6" class=" pt-30 " style="padding-top: 9px;"
                                                        align="left">
                                                        <p class="fw-500 txt-left " style="">
                                                            Sign:
                                                        </p>


                                                    </td>
                                                    <td colspan="6" class="pt-30 " style="padding-top: 9px;"
                                                        align="right">
                                                        <p class="fw-500 txt-right " style="">
                                                            Date:
                                                        </p>


                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12" class="border-bottom-line-ash"
                                                        style="padding-bottom: 208px">

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12">
                                                        <p class="txt-center">
                                                            <span class="fw-500 txt-left " style="">
                                                                Registered Office Address-
                                                            </span>
                                                            Brand Avatar LLP, No-01, Kandasamy Street,
                                                            Chandrabagh Avenue Extn, Radhakrishnan Salai,
                                                            Mylapore, Chennai, Tamilnadu -600 004.

                                                        </p>
                                                    </td>
                                                </tr>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item  ">
                                <div class="main-page appointment-letter">
                                    <div class="sub-page" style="text-align: justify;font-size: 15px;">
                                        <table class="letter-format " style="padding:0;">
                                            <tbody>
                                                <tr>
                                                    <td colspan="12" class="pb-15" align="left">
                                                        <div style="height: 50px;width:160px">
                                                            <img src="{{ URL::asset('assets/images/appointment/avatar/brandavatarlogo.png') }}"
                                                                class="" alt=""
                                                                style="height:100%;width:100%;">
                                                        </div>


                                                    </td>

                                                </tr>


                                                <tr>
                                                    <td colspan="12" style=" "class="" align="center">
                                                        <span class="fw-500  " style="font-size:20px;">
                                                            ANNEXURE B
                                                        </span>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12" style=" "class="pt-20" align="">
                                                        <p class="fw-500  pad-bottom-5" style="">
                                                            DUTIES
                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12" style=" "class="" align="">
                                                        <p class="  " style="">
                                                            You will devote your full-time skill and attention to the work
                                                            and business of the Company and shall continue to work to the
                                                            best of your ability.
                                                            Without the Company’s prior written consent, you will not
                                                            perform any other work for pay during your employment term, or
                                                            will you, alone or with others, directly or indirectly,
                                                            establish any business, whatever its form, or take any financial
                                                            interest in or perform work for such a business, whether or not
                                                            for consideration.
                                                            You will accept, support, and work within the management,
                                                            financial, personnel, internal control, and reporting systems,
                                                            policies, practices, and procedures as determined by the Company
                                                            or your Manager, from time to time.

                                                        </p>

                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="12" style=" "class="pt-10" align="">
                                                        <p class="fw-500  pad-bottom-5" style="">
                                                            HOURS OF WORK
                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12" style=" "class="" align="">
                                                        <p class=" " style="">
                                                            Your actual working hours &nbsp;<span
                                                                class="fw-500 txt-left">8.55 AM to 6 PM </span>&nbsp;
                                                            including working in Shifts and working days (including working
                                                            on weekly offs and public holidays) will be often determined by
                                                            workflow and Company commitments. Brand Avatar LLP works for 9
                                                            hours (Including Break) a day 6 days a week. However, there may
                                                            be certain work exigencies that may require you to work beyond
                                                            the stipulated hours of work.



                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12" style=" "class="pt-10" align="">
                                                        <p class="fw-500  pad-bottom-5" style="">
                                                            CONDUCT

                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12" style=" "class="" align="">
                                                        <p class=" " style="">
                                                            You shall conduct yourself in a befitting manner and abide
                                                            by
                                                            all the conduct policy, the rules, and regulations of the
                                                            Company.

                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12" style=" "class="pt-10">
                                                        <p class=" fw-500 pad-bottom-5" style="">
                                                            REVIEW OF SALARY

                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12" style=" "class="">
                                                        <p class=" " style="">
                                                            Your remuneration shall be reviewed annually and any changes
                                                            to
                                                            your remuneration package shall be determined by considering
                                                            your performance in the Company, the Company’s performance,
                                                            and
                                                            your contribution to the Company.


                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12" style=" "class="pt-10">
                                                        <p class=" fw-500 pad-bottom-5" style="">
                                                            CONFIDENTIALITY OF SALARY


                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12" style=" "class="">
                                                        <p class=" " style="">
                                                            Your salary is the reward for your untiring effort and work.
                                                            You
                                                            need to maintain your salary with the utmost
                                                            confidentiality. In
                                                            the event you do not maintain the confidentiality of your
                                                            salary, you may be subject to disciplinary action. </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12" style=" "class="pt-10">
                                                        <p class=" fw-500 pad-bottom-5" style="">
                                                            EXPENSES
                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12">
                                                        <p class="" style="">
                                                            The Company will compensate you for all expenses that are
                                                            reasonably incurred and that are directly related to the
                                                            performance of your work, but only insofar as that
                                                            compensation
                                                            may be provided tax-free compensation of expenses as
                                                            contained
                                                            herein will be made only on the basis of a statement of
                                                            expenses
                                                            that have been approved by the Company.


                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12" style=" "class="pt-10">
                                                        <p class=" fw-500 pad-bottom-5" style="">
                                                            PROVIDENT FUND SCHEME AND ESIC

                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12" style="padding-bottom:88px;"
                                                        class="border-bottom-line-ash">
                                                        <p class=" pad-bottom-5" style="">
                                                            You will be entitled to an employer's contribution of Provident
                                                            Fund to the extent of 12% of your gross salary excluding house
                                                            rent allowance.
                                                        </p>
                                                        <p class=" " style="">
                                                            You will be eligible to get the ESIC medical benefits for you
                                                            and your immediate family members if your gross wages are less
                                                            than or equal to 21000/-

                                                        </p>


                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="12">
                                                        <p class="txt-center">
                                                            <span class="fw-500 txt-left " style="">
                                                                Registered Office Address-
                                                            </span>
                                                            Brand Avatar LLP, No-01, Kandasamy Street,
                                                            Chandrabagh Avenue Extn, Radhakrishnan Salai,
                                                            Mylapore, Chennai, Tamilnadu -600 004.

                                                        </p>
                                                    </td>
                                                </tr>




                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item  ">
                                <div class="main-page appointment-letter">
                                    <div class="sub-page" style="text-align: justify;font-size: 15px;">
                                        <table class="letter-format " style="padding:0;">
                                            <tbody>
                                                <tr>
                                                    <td colspan="12" class="pb-15" align="left">
                                                        <div style="height:50px;width:160px">
                                                            <img src="{{ URL::asset('assets/images/appointment/avatar/brandavatarlogo.png') }}"
                                                                class="" alt=""
                                                                style="height:100%;width:100%;">


                                                        </div>


                                                    </td>

                                                </tr>



                                                <tr>
                                                    <td colspan="12" style=" "class="pt-20" align="">
                                                        <p class="fw-500  pad-bottom-5" style="">
                                                            METHOD OF PAYMENT
                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12" style=" "class="" align="">
                                                        <p class="  " style="">
                                                            Salaries and wages will be paid monthly by electronic funds
                                                            transfer or will be deposited in your Corporate Salary Account
                                                            or any other means on or before the 7th day of each month in
                                                            arrears. The company reserves its right to vary this procedure
                                                            at its option. However, such variance will be communicated to
                                                            you in due course.


                                                        </p>

                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="12" style=" "class="pt-10" align="">
                                                        <p class="fw-500  pad-bottom-5" style="">
                                                            LEAVE
                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12" style=" "class="" align="">
                                                        <p class=" " style="">
                                                            You will be governed by the leave rules of the Company; your
                                                            manager has got all rights to decide on your leave as per the
                                                            policy and you can avail of 12 days of Casual Leave (CL) in a
                                                            year and 4 Days of Paid Leave.
                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12" style=" "class="pt-10" align="">
                                                        <p class="fw-500  pad-bottom-5" style="">
                                                            INTELLECTUAL PROPERTY RIGHTS

                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12" style=" "class="" align="">
                                                        <p class=" " style="">
                                                            All Industrial and intellectual property rights, including but
                                                            not limited to patent rights, design rights, copyrights, and
                                                            related rights, database rights, trademark rights, and chip
                                                            rights, ensuring within the framework of the work performed by
                                                            you during your employment with the company, will be exclusively
                                                            vested in Company. You may not independently during your
                                                            employment and subsequent to termination disclose, multiply,
                                                            use, manufacture, bring on the market or sell, lease, deliver,
                                                            or otherwise trade, offer on behalf of any third party, or
                                                            commission the registration of the results of your work. To the
                                                            extent that such inventions are performed under the Company’s
                                                            direction, you shall fully, freely, and immediately communicate
                                                            any invention to the Company and all rights, title, and interest
                                                            to any such invention (“Inventions”) shall be the sole property
                                                            of the Company.
                                                        </p>
                                                        <p class=" pt-10" style="">
                                                            In pursuance of the above
                                                        </p>
                                                        <p class=" pt-10" style="">
                                                            A. You will give the Company and its solicitors and/or it’s
                                                            patent attorneys all necessary assistance and cooperation in
                                                            connection with the preparation and prosecution of any
                                                            application for patent, design, registration, or copyright by
                                                            the Company in respect of the Invention.

                                                        </p>
                                                        <p class=" pt-pb-10" style="">
                                                            B. You irrevocably appoint the Company and any directors of the
                                                            Company jointly and severally your true and lawful attorney to
                                                            execute all such documents and do all such things as in the
                                                            opinion of the Company may be necessary or requisite for any
                                                            such purpose.

                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12" style="padding-bottom:82px"
                                                        class="border-bottom-line-ash" align="">
                                                        <p class="fw-500  pad-bottom-5" style="">
                                                            NON-DISCLOSURE AGREEMENT

                                                        </p>
                                                        <p class="pad-bottom-5">
                                                            During the employment, the employee shall not directly or
                                                            indirectly carry on, assist, engage in, be concerned, or
                                                            participate in any business/activity (whether directly or
                                                            indirectly, as a partner, shareholder, principal, agent,
                                                            director, affiliate, Consultant or in any other capacity or
                                                            manner whatsoever) which is similar to the business of the
                                                            Company, nor engage in any activity that conflicts with the
                                                            employee's obligations to the Company.
                                                        </p>
                                                        <p class="pad-bottom-5">
                                                            Solicit Business: During the Term and for a period of 12 months
                                                            after the Term, the employee shall not solicit, endeavor to
                                                            solicit, influence, or attempt to influence any client,
                                                            customer, or other Person, directly or indirectly, to direct his
                                                            or its purchase of the Company's product and/or services, to
                                                            self or any Person in competition with the business of the
                                                            Company.
                                                        </p>
                                                        <p class="pad-bottom-5">
                                                            Solicit Personnel: During the Term and for a period of 12 months
                                                            after the Term, the Employee shall not solicit or attempt to
                                                            influence any person employed or engaged by the Company (whether
                                                            as an Employee, Consultant, Advisor, or in any other manner) or
                                                            engagement with the Company or become the Consultant of or
                                                            directly or indirectly offer services in any form or manner to
                                                            himself or any person who is a competitor of the Company
                                                        </p>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="12">
                                                        <p class="txt-center">
                                                            <span class="fw-500 txt-left " style="">
                                                                Registered Office Address-
                                                            </span>
                                                            Brand Avatar LLP, No-01, Kandasamy Street,
                                                            Chandrabagh Avenue Extn, Radhakrishnan Salai,
                                                            Mylapore, Chennai, Tamilnadu -600 004.

                                                        </p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item  ">
                                <div class="main-page appointment-letter">
                                    <div class="sub-page" style="text-align: justify;font-size: 15px;">
                                        <table class="letter-format " style="padding:0;">
                                            <tbody>
                                                <tr>
                                                    <td colspan="12" class="pb-15" align="left">
                                                        <div style="height:50px;width:160px">
                                                            <img src="{{ URL::asset('assets/images/appointment/avatar/brandavatarlogo.png') }}"
                                                                class="" alt=""
                                                                style="height:100%;width:100%;">
                                                        </div>


                                                    </td>

                                                </tr>



                                                <tr>
                                                    <td colspan="12" style=" "class="pt-20" align="">
                                                        <p class="fw-500  pad-bottom-5" style="">
                                                            TERMINATION
                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12" style=" "class="pad-bottom-10"
                                                        align="">
                                                        <p class="  " style="">
                                                            Your employment may be terminated at any time by yourself, or by
                                                            the Company, upon providing three (3) months’ written notice to
                                                            the other party.

                                                        </p>
                                                        <p class="pad-top-5" style="">
                                                            In the case of the Company terminating, you for reasons other
                                                            than a breach of contract by you or for any disciplinary reasons
                                                            against you, the Company shall pay you one month’s salary equal
                                                            to your notice period not worked as payment in lieu of notice.
                                                        </p>
                                                        <p class="pad-top-5" style="">
                                                            If you seek to terminate your employment with the company, you
                                                            shall do a proper handover of all the work and responsibilities
                                                            that you are handling to your manager and the resource
                                                            identified for replacing you, to the satisfaction of your
                                                            manager. If you are not able to serve the notice period three
                                                            (3) months of your CTC to be payable to Brand Avatar LLP
                                                        </p>
                                                        <p class="pad-top-5" style="">
                                                            With conflict-of-interest terms and conditions, Employees of
                                                            Brand Avtar will be refrained from serving as employees of
                                                            clients/vendors. In the case of deviation from the above-said
                                                            agreement, Brand Avatar will claim compensation of Rs.5 Lakhs
                                                            for breach of Trust. If defaulted, we will proceed legally.
                                                        </p>
                                                        <p class="pad-top-5" style="">
                                                            Upon termination of your employment with the company, you agree
                                                            not to solicit any other team members in the company to the new
                                                            organization that you are going.
                                                        </p>

                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="12" style=" "class="pt-10" align="">
                                                        <p class="fw-500  pad-bottom-5" style="">
                                                            DISPUTE RESOLUTION
                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12" style=" "class="pad-bottom-10"
                                                        align="">
                                                        <p class=" " style="">
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
                                                <tr>
                                                    <td colspan="12" style=" "class="pt-10" align="">
                                                        <p class="fw-500  pad-bottom-5" style="">
                                                            GOVERNING LAW AND JURISDICTION

                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12" style=" "class="" align="">
                                                        <p class=" " style="">
                                                            This agreement shall be governed by the laws of the Republic of
                                                            India and courts in Chennai have exclusive jurisdiction over
                                                            this agreement.

                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <td colspan="12" style=" " class="pt-10 pad-bottom-5"
                                                        align="left">
                                                        <p class="fw-500 pt-15  txt-left " style="">
                                                            RETIREMENT AGE
                                                        </p>
                                                        <p>
                                                            The general Retirement for employees in the Company is <span
                                                                class="fw-500">Fifty-Eight (58) years.</span>
                                                        </p>
                                                    </td>
                                                </tr>



                                                <tr class="border-bottom-line-ash">
                                                    <td colspan="12" style=" " class="pad-bottom-5"
                                                        align="left">
                                                        <p class="fw-500 pt-15  txt-left " style="">
                                                            Yours faithfully,
                                                        </p>
                                                        <p class="fw-500 pt-pb-15  txt-left " style="">
                                                            For Brand Avatar LLP
                                                        </p>

                                                        <div style="height:70px;width:140px" class="pt-pb-15">
                                                            <img src="{{ URL::asset('assets/images/appointment/avatar/sign2.png') }}"
                                                                class="" alt="signature"
                                                                style="height:100%;width:100%;">
                                                        </div>



                                                        <p class="fw-500 txt-left " style=" ">
                                                            (Hemachandran L)
                                                        </p>
                                                        <p class="fw-500  txt-left " style=" ">
                                                            Founder and CEO of Brand Avatar LLP
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12" style=" " align="left">
                                                        <p class=" pt-10 txt-left " style="">
                                                            I <span class="fw-500 txt-left">
                                                                Xyz,</span>&nbsp; have read &nbsp;<span
                                                                class="fw-500 txt-left">ANNEXURE A &
                                                                B,</span>&nbsp; understood, and accept
                                                            the
                                                            appointment upon the terms and conditions as
                                                            outlined in this appointment letter for my
                                                            position at &nbsp;<span class="fw-500 txt-left">Brand Avatar
                                                                LLP
                                                            </span>&nbsp;.

                                                        </p>


                                                    </td>
                                                </tr>
                                                <tr class="border-bottom-line-ash">
                                                    <td colspan="6" class="pt-pb-15" style="padding-bottom:37px" align="left">
                                                        <p class="fw-500 txt-left " style="">
                                                            Sign:
                                                        </p>


                                                    </td>
                                                    <td colspan="6" class="pt-pb-15" style=" padding-bottom:37px" align="right">
                                                        <p class="fw-500 txt-right " style="">
                                                            Date:
                                                        </p>


                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12">
                                                        <p class="txt-center">
                                                            <span class="fw-500 txt-left " style="">
                                                                Registered Office Address-
                                                            </span>
                                                            Brand Avatar LLP, No-01, Kandasamy Street,
                                                            Chandrabagh Avenue Extn, Radhakrishnan Salai,
                                                            Mylapore, Chennai, Tamilnadu -600 004.

                                                        </p>
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

                    <div class="container-fluid m-2 pdf-container ">
                        <div class="main-page">
                            <div class="sub-page" style="text-align: justify;font-size: 15px;">
                                <div class="table-responsive">
                                    <table cellspacing="0" cellpadding="0" class="payslip_table payslip-brandAvatar">
                                        <tr class="header-row">
                                            <td colspan="8" class="border-less p3">
                                                <div class="header-cotent">

                                                    <p class="margin-0"
                                                        style="padding-left:5px;color:#912789;font-size:18px">Brand Avatar
                                                        LLP</p>
                                                    <p class="mb-0">NO-01,Kandasamy Street,</p>
                                                    <p class="mb-0">Chandrabagh Ave 2nd St, Dr. Radha Krishnan Salai,
                                                    </p>
                                                    <p class="mb-0">Mylapore, Chennai, Tamil Nadu 600004</p>
                                                </div>
                                            </td>
                                            <td colspan="4" class="border-less p3">

                                                <div class="header-img txt-right">
                                                    <!-- <img src="" title=""> -->
                                                    <img src="{{ URL::asset('assets/images/appointment/avatar/brandavatarlogo.png') }}"
                                                        class="" style="height: 40px;width:180px;max-height:100%;">
                                                </div>


                                            </td>
                                        </tr>


                                        <tr>
                                            <td colspan="12" class="bg-ash">
                                                <p class="sub-header txt-center  fw-500">PAYSLIP FOR THE MONTH
                                                    OF &ndash;APR-2022</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="bg-ash fw-500">
                                                <p>EMPLOYEE NAME</p>
                                            </td>
                                            <td colspan="3">
                                                <p></p>
                                            </td>
                                            <td colspan="3" class="bg-ash fw-500">
                                                <p>EMPLOYEE CODE</p>
                                            </td>
                                            <td colspan="3">
                                                <p></p>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td colspan="3" class="bg-ash fw-500">
                                                <p>DATE OF BIRTH</p>
                                            </td>
                                            <td colspan="3">
                                                <p></p>
                                            </td>
                                            <td colspan="3" class="bg-ash fw-500">
                                                <p>DATE OF JOINING</p>
                                            </td>
                                            <td colspan="3">
                                                <p></p>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td colspan="3" class="bg-ash fw-500">
                                                <p>DESIGNATION</p>
                                            </td>
                                            <td colspan="3">
                                                <p></p>
                                            </td>
                                            <td colspan="3" class="bg-ash fw-500">
                                                <p>LOCATION</p>
                                            </td>
                                            <td colspan="3">
                                                <p></p>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td colspan="3" class="bg-ash fw-500">
                                                <p>EPF NUMBER</p>
                                            </td>
                                            <td colspan="3">
                                                <p></p>
                                            </td>
                                            <td colspan="3" class="bg-ash fw-500">
                                                <p>ESIC NUMBER</p>
                                            </td>
                                            <td colspan="3">
                                                <p></p>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td colspan="3" class="bg-ash fw-500">
                                                <p>UAN</p>
                                            </td>
                                            <td colspan="3">
                                                <p></p>
                                            </td>
                                            <td colspan="3" class="bg-ash fw-500">
                                                <p>PAN</p>
                                            </td>
                                            <td colspan="3">
                                                <p></p>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td colspan="4" class="bg-ash ">
                                                <p class="fw-500 txt-center">BANK NAME</p>
                                            </td>

                                            <td colspan="4" class="bg-ash ">
                                                <p class="fw-500 txt-center">ACCOUNT NUMBER</p>
                                            </td>
                                            <td colspan="4" class="bg-ash ">
                                                <p class="fw-500 txt-center">IFSC CODE</p>
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
                                                <p class="fw-500 txt-center">MONTH DAYS</p>
                                            </td>

                                            <td colspan="3" class="bg-ash ">
                                                <p class="fw-500 txt-center">WORKED DAYS</p>
                                            </td>
                                            <td colspan="3" class="bg-ash ">
                                                <p class="fw-500 txt-center">LOSS OF PAY</p>
                                            </td>
                                            <td colspan="3" class="bg-ash ">
                                                <p class="fw-500 txt-center">ARREAR DAYS</p>
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
                                            <td colspan="2" class="bg-ash fw-500">
                                                <p class="txt-center">CL/SL OpenBalance</p>
                                            </td>
                                            <td colspan="2" class="bg-ash fw-500 ">
                                                <p class="txt-center">PL OpenBalance</p>
                                            </td>

                                            <td colspan="2" class="bg-ash fw-500">
                                                <p class="txt-center">Availed CL/SL</p>
                                            </td>
                                            <td colspan="2" class="bg-ash fw-500">
                                                <p class="txt-center">Availed PL</p>
                                            </td>
                                            <td colspan="2" class="bg-ash fw-500">
                                                <p class="txt-center">Balance CL/SL</p>
                                            </td>
                                            <td colspan="2" class="bg-ash fw-500">
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
                                                <p class="txt-center fw-500">DESCRIPTION</p>
                                            </td>
                                            <td colspan="2" class="bg-ash">
                                                <p class="txt-center fw-500">AMOUNT</p>
                                            </td>
                                            <td colspan="2" class="bg-ash">
                                                <p class="txt-center fw-500">ARREAR AMOUNT</p>
                                            </td>
                                            <td colspan="2" class="bg-ash">
                                                <p class="txt-center fw-500">EARNED AMOUNT</p>
                                            </td>
                                            <td colspan="2" class="bg-ash">
                                                <p class="txt-center fw-500">DEDUCTION</p>
                                            </td>
                                            <td colspan="2" class="bg-ash">
                                                <p class="txt-center fw-500">AMOUNT</p>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td colspan="2" class="">
                                                <p class="txt-left fw-500">BASIC</p>
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
                                                <p class="txt-left fw-500">EPF</p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-right"></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="">
                                                <p class="txt-left fw-500">HRA</p>
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
                                                <p class="txt-left fw-500">ESIC</p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-right"></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="">
                                                <p class="txt-left fw-500">SPECIAL ALLOWANCE </p>
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
                                                <p class="txt-left fw-500">PT</p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-right"></p>
                                            </td>


                                        </tr>


                                        <tr>
                                            <td colspan="2" class="">
                                                <p class="txt-left fw-500"> COMMUNICATION ALLOWANCE </p>
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
                                                <p class="txt-left fw-500">INCOME TAX</p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-right"></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="">
                                                <p class="txt-left fw-500"> FOOD ALLOWANCE </p>
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
                                                <p class="txt-left fw-500">FOOD DEDUCTION</p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-right"></p>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="2" class="">
                                                <p class="txt-left fw-500"> </p>
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
                                                <p class="txt-left fw-500">SALARY ADVANCE</p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-right"> </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="">
                                                <p class="txt-left fw-500"> </p>
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
                                                <p class="txt-left fw-500">OTHER DEDUCTIONS</p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-right"></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="bg-ash">
                                                <p class="txt-left fw-500">TOTAL EARNINGS</p>
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
                                                <p class="txt-left fw-500">TOTAL DEDUCTION</p>
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
                                                <p class="txt-left fw-500">NET PAY</p>
                                            </td>
                                            <td colspan="8" class="">
                                                <p class="txt-center "></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="bg-ash">
                                                <p class="txt-left fw-500">NET PAY IN WORDS</p>
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
                                                <p class="txt-center fw-500">TRANSACTION ID</p>
                                            </td>
                                            <td colspan="3" class="">
                                                <p class="txt-center"></p>
                                            </td>
                                            <td colspan="3" class="bg-ash">
                                                <p class="txt-center fw-500">Paid Date</p>
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
                                            <td colspan="2" class="border-less ">
                                                <p class="txt-right">Generated By</p>

                                            </td>
                                            <td colspan="2" class="border-less text-left">
                                                <img src="{{ URL::asset('assets/images/client_logos/ardens/evangelist.png') }}"
                                                    width="80px" height="15px" alt="" class="">
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
