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
            <div class="card-body pb-0 pt-1">

                <ul class="nav nav-pills nav-tabs-dashed" role="tablist">
                    <li class="nav-item text-muted" role="presentation">
                        <a class="nav-link active pb-2" data-bs-toggle="tab" href="#appointment" aria-selected="true"
                            role="tab">
                            Appointment Letter
                        </a>
                    </li>
                    <li class="nav-item mx-4 text-muted" role="presentation">
                        <a class="nav-link  pb-2" data-bs-toggle="tab" href="#payslips" aria-selected="true" role="tab">
                            Pay Slip
                        </a>
                    </li>
                    {{-- <li class="nav-item text-muted" role="presentation">
                        <a class="nav-link  pb-2" data-bs-toggle="tab" href="#disclose" aria-selected="true" role="tab">
                            Disclosure Agreement
                        </a>
                    </li> --}}
                </ul>

            </div>
        </div>

        <div class="card mb-0">

            <div class="tab-content " id="pills-tabContent">
                <div class="tab-pane fade show active" id="appointment" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="tab-pane fade show active" id="appointment" role="tabpanel"
                        aria-labelledby="pills-home-tab">
                        {{-- <div class="col-md-4 mx-auto d-flex justify-content-center text-center flex-column">
                        <img src="{{ URL::asset('assets/images/no_dataFile.svg') }}" class="">
                        <h4> <span class="text-orange">Sorry !</span> No data</h4>


                    </div> --}}
                        <div id="carousel_template" class="carousel slide" data-bs-touch="false" data-bs-interval="false">
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
                                                                        <td colspan="12" class="pb-30" align="right">
                                                                            <img src="{{ URL::asset('assets/images/client_logos/vasa/logo_priti.jpg') }}"
                                                                                class="" alt=""
                                                                                style="height: 35px;width:200px;">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="12" style=" " align="right">
                                                                            <p class="fw-600 txt-right " style="">
                                                                                Date:
                                                                            </p>

                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="12" style=" " align="center">
                                                                            <p class="fw-600 txt-center " style="">
                                                                                LETTER OF APPOINTMENT

                                                                            </p>

                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="12" style=" " align="left">
                                                                            <p class="fw-600 txt-left " style="">
                                                                                Dear Xyz,
                                                                            </p>
                                                                            <p class="pt-pb-5">We are glad to appoint you as
                                                                                &nbsp;<span class="fw-600 txt-left">" Xyz
                                                                                    "</span>&nbsp; in our company,
                                                                                &nbsp;<span class="fw-600 txt-left">Priti
                                                                                    Sales Corporation
                                                                                </span>&nbsp;.</p>

                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="12" style=" " align="left">
                                                                            <p class="fw-600 txt-left " style="">
                                                                                Remuneration

                                                                            </p>
                                                                            <p class="pt-pb-5">
                                                                                Your total remuneration package per annum
                                                                                will
                                                                                consist of &nbsp;<span
                                                                                    class="fw-600 txt-left">
                                                                                    CTC Rs Xyz- per annum
                                                                                    (xyz)</span>&nbsp;.
                                                                                The
                                                                                breakup of your compensation package shall
                                                                                be as detailed in Annexure A.

                                                                            </p>

                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="12" style=" " align="left">
                                                                            <p class="fw-600 txt-left " style="">
                                                                                Commencement

                                                                            </p>
                                                                            <p class="pt-pb-5">
                                                                                Your employment with the company &nbsp;<span
                                                                                    class="fw-600 txt-left"> PRITI SALES
                                                                                    CORPORATION
                                                                                </span>&nbsp will
                                                                                be with effect from &nbsp;<span
                                                                                    class="fw-600 txt-left"> DD-MM-
                                                                                    YYYY</span>&nbsp;. You shall
                                                                                initially be placed in &nbsp;<span
                                                                                    class="fw-600 txt-left"> YYY
                                                                                </span>&nbsp;. You may however
                                                                                be required to travel and maybe positioned
                                                                                or
                                                                                deputed outside within India or abroad.

                                                                            </p>

                                                                        </td>
                                                                    </tr>


                                                                    <tr>
                                                                        <td colspan="12" style=" " align="left">
                                                                            <p class="fw-600 txt-left " style="">
                                                                                Rules and Regulations

                                                                            </p>
                                                                            <p class="pt-pb-5">
                                                                                You shall be governed by the policies of the
                                                                                company as specified in &nbsp;<span
                                                                                    class="fw-600 txt-left">Annexure
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
                                                                                We welcome you to our team. We are confident
                                                                                that you will make an effective contribution
                                                                                to
                                                                                the growth of the company and will enjoy
                                                                                working
                                                                                with us.
                                                                            </p>
                                                                            <p class="pt-pb-5">
                                                                                You will be under probation for a period of
                                                                                &nbsp;<span class="fw-600 txt-left">SIX
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


                                                                    <tr>
                                                                        <td colspan="12" style=" " align="left">
                                                                            <p class="fw-600 pt-30  txt-left "
                                                                                style="">
                                                                                Yours faithfully,
                                                                            </p>
                                                                            <p class=" pb-30 fw-600">
                                                                                For PRITI SALES CORPORATION

                                                                            </p>
                                                                            <p class="fw-600 pt-10 txt-left "
                                                                                style=" ">
                                                                                Founder and CEO of Priti Sales Corporation
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="12" style=" " align="left">
                                                                            <p class=" pt-10 txt-left " style="">
                                                                                I M Xyz, have read &nbsp;<span
                                                                                    class="fw-600 txt-left">ANNEXURE A &
                                                                                    B,</span>&nbsp; understood, and accept
                                                                                the
                                                                                appointment upon the terms and conditions as
                                                                                outlined in this appointment letter for my
                                                                                position at &nbsp;<span
                                                                                    class="fw-600 txt-left">PRITI SALES
                                                                                    CORPORATION
                                                                                </span>&nbsp;.

                                                                            </p>


                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="6" class="pt-30" style=" "
                                                                            align="left">
                                                                            <p class="fw-600 txt-left " style="">
                                                                                Sign:
                                                                            </p>


                                                                        </td>
                                                                        <td colspan="6" class="pt-30" style=" "
                                                                            align="right">
                                                                            <p class="fw-600 txt-right " style="">
                                                                                Date:
                                                                            </p>


                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="12"
                                                                            style="padding-bottom: 30px;
                                                                        "
                                                                            class="pt-pb-5 border-bottom-line "
                                                                            align="">
                                                                            <p class="fw-600  " style="">
                                                                                PRITI SALES CORPORATION
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="4" class="" align="">
                                                                            <p class=" "
                                                                                style="text-align:initial;width:263px;">
                                                                                <span class="fw-600 txt-left"> HeadOffice:
                                                                                </span>&nbsp;#34/123,Dugar
                                                                                Towers 2nd Floor
                                                                                MarshallsRoad,
                                                                                Egmore,Chennai-600008
                                                                                E-mail:admin@pritisales.in
                                                                                /info@pritisales.in
                                                                                Ph:044-42661403I45558608I8609


                                                                            </p>
                                                                        </td>

                                                                        <td colspan="8" class="" align="">
                                                                            <p class=" "
                                                                                style="text-align:initial;width:326px;">
                                                                                <span class="fw-600 txt-left">
                                                                                    WareHouse:</span>&nbsp;
                                                                                No:63,SidcoIndustrialEstate,
                                                                                Sipcot,
                                                                                Ranipet-632403.
                                                                                Ph:246168
                                                                                No:114/1,BhangiShoptoVenkatasamuthiramRoad,
                                                                                LabbaiMankuppam Village ThuthipetAmbur
                                                                                635811
                                                                                No.3/1,JalalRoadExtension,
                                                                                MalligaiThoppu,Ambur-635802.
                                                                                Ph:04174240330

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
                                        <div class="sub-page" style="text-align: justify;">
                                            <table class="letter-format " style="padding:0;">
                                                <tbody>
                                                    <tr>
                                                        <td colspan="12" class="pb" align="right">

                                                            <img src="{{ URL::asset('assets/images/client_logos/vasa/logo_priti.jpg') }}"
                                                                class="" alt=""
                                                                style="height: 35px;width:200px;">

                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td class="" colspan="12">
                                                            <table class="salary-table" style="width: 100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="12" style=" "class=""
                                                                            align="center">
                                                                            <p class="fw-600 txt-center " style="">
                                                                                ANNEXURE A
                                                                            </p>

                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="12" style=" "class=""
                                                                            align="center">
                                                                            <p class="fw-600 txt-center " style="">
                                                                                SALARY STRUCTURE
                                                                            </p>

                                                                        </td>

                                                                    </tr>

                                                                    <tr>

                                                                        <td colspan="6" style=" "class="bg-ash "
                                                                            align="left">
                                                                            <p class="fw-600  txt-left" style="">
                                                                                Name:
                                                                            </p>

                                                                        </td>

                                                                        <td colspan="6" style=" "class="bg-ash ">
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
                                                                        <td colspan="4" style=" "class="bg-ash ">
                                                                            <p class="fw-600  txt-center" style="">
                                                                                Per Month
                                                                            </p>

                                                                        </td>
                                                                        <td colspan="4" style=" "class="bg-ash ">
                                                                            <p class="fw-600   txt-center   "
                                                                                style="">
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
                                                                        <td colspan="4" style=" "class="">
                                                                            <p class="  txt-right" style="">

                                                                            </p>

                                                                        </td>
                                                                        <td colspan="4" style=" "class="">
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
                                                                        <td colspan="4" style=" "class="">
                                                                            <p class=" txt-right" style="">

                                                                            </p>

                                                                        </td>
                                                                        <td colspan="4" style=" "class="">
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
                                                                        <td colspan="4" style=" "class="">
                                                                            <p class=" txt-right" style="">

                                                                            </p>

                                                                        </td>
                                                                        <td colspan="4" style=" "class="">
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
                                                                        <td colspan="4" style=" "class="bg-ash">
                                                                            <p class="fw-600   txt-center" style="">

                                                                            </p>

                                                                        </td>
                                                                        <td colspan="4" style=" "class="bg-ash">
                                                                            <p class="fw-600   txt-center   "
                                                                                style="">

                                                                            </p>

                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="4" style=" "class=" ">
                                                                            <p class="" style="">
                                                                                PF (Employer Contribution)
                                                                            </p>

                                                                        </td>
                                                                        <td colspan="4" style=" "class="">
                                                                            <p class="  txt-center" style="">

                                                                            </p>

                                                                        </td>
                                                                        <td colspan="4" style=" "class="">
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
                                                                        <td colspan="4" style=" "class="">
                                                                            <p class=" txt-right" style="">

                                                                            </p>

                                                                        </td>
                                                                        <td colspan="4" style=" "class="">
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
                                                                        <td colspan="4" style=" "class="bg-ash">
                                                                            <p class="fw-600  txt-right" style="">

                                                                            </p>

                                                                        </td>
                                                                        <td colspan="4" style=" "class="bg-ash">
                                                                            <p class="fw-600   txt-right   "
                                                                                style="">

                                                                            </p>

                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="4" style=" "class=" ">
                                                                            <p class="txt-left " style="">
                                                                                EPF (Employee Contribution)
                                                                            </p>

                                                                        </td>
                                                                        <td colspan="4" style=" "class="">
                                                                            <p class="txt-right" style="">

                                                                            </p>

                                                                        </td>
                                                                        <td colspan="4" style=" "class="">
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
                                                                        <td colspan="4" style=" "class="">
                                                                            <p class="txt-right" style="">

                                                                            </p>

                                                                        </td>
                                                                        <td colspan="4" style=" "class="">
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
                                                                        <td colspan="4" style=" "class="">
                                                                            <p class="txt-right" style="">

                                                                            </p>

                                                                        </td>
                                                                        <td colspan="4" style=" "class="">
                                                                            <p class="ttxt-right   " style="">

                                                                            </p>

                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="4"
                                                                            style=" "class="  bg-ash">
                                                                            <p class="txt-left " style="">
                                                                                Net Income
                                                                            </p>

                                                                        </td>
                                                                        <td colspan="4" style=" "class=" bg-ash">
                                                                            <p class="txt-right" style="">

                                                                            </p>

                                                                        </td>
                                                                        <td colspan="4" style=" "class=" bg-ash">
                                                                            <p class="ttxt-right   " style="">

                                                                            </p>

                                                                        </td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="12" class="pt-pb-5" style=" ">
                                                            <p class=" txt-left pt-pb-5 " style="">
                                                                <span class="fw-600">Statutory Bonus – </span>
                                                                Will be paid as per the Payment of Bonus Act and
                                                                8.33% or MW whichever is higher if your basic
                                                                salary is less than INR-21000/- per month.

                                                            </p>
                                                            <p class=" txt-left pt-pb-5 " style="">
                                                                <span class="fw-600">Increment and Promotions – </span>
                                                                Shall be based on merit considering your periodic and
                                                                consistent
                                                                overall performance, business conditions, and other
                                                                parameters
                                                                fixed from time to time at the discretion of the management
                                                                and
                                                                shall not be considered merely as a matter of right.



                                                            </p>
                                                            <p class=" txt-left pt-pb-5 " style="">
                                                                <span class="fw-600"> Gratuity- </span>

                                                                Will be paid for those who have completed 5 Years of
                                                                continuous
                                                                service with our organization as per the Payment of Gratuity
                                                                Act
                                                                -1972.

                                                            </p>

                                                            <p class=" txt-left pt-pb-5 " style="">
                                                                <span class="fw-600"> Insurance –</span>
                                                                <span> Group Mediclaim policy will be an extended benefits
                                                                    to
                                                                    our employees.
                                                                    ESIC not covered employees – 3,00,000 GMC (Employee
                                                                    +Spouse
                                                                    + Kids Max) – Subject to conditions
                                                                </span>
                                                            <p>ESIC Covered Employees – 1,00,000 GMC (Employee + Spouse +
                                                                Kids
                                                                Max) – Subject to conditions </p>

                                                            </p>
                                                            <p class=" txt-left pt-pb-5 " style="">
                                                                <span class="fw-600">IncomeTax – </span>
                                                                Income tax will be deducted as per the slab

                                                            </p>

                                                            <p class=" txt-left pt-pb-5 " style="">
                                                                <span class="fw-600">Full and Final Settlement -</span>
                                                                F n F will be settle within 7 working days from the Last
                                                                working
                                                                day
                                                            </p>


                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="12" style=" " align="left">
                                                            <p class=" txt-left " style="">
                                                                I Xyz, have read &nbsp;<span
                                                                    class="fw-600 txt-left">ANNEXURE A
                                                                    &
                                                                    B,</span>&nbsp; understood, and accept the
                                                                appointment upon the terms and conditions as
                                                                outlined in this appointment letter for my
                                                                position at &nbsp;<span class="fw-600 txt-left">PRITI SALES
                                                                    CORPORATION
                                                                </span>&nbsp;.

                                                            </p>


                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" class=" pt-10" style="" align="left">
                                                            <p class="fw-600 txt-left " style="">
                                                                Sign:
                                                            </p>


                                                        </td>
                                                        <td colspan="6" class="pt-10" style="" align="right">
                                                            <p class="fw-600 txt-right " style="">
                                                                Date:
                                                            </p>


                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="12"
                                                            style="padding-bottom:px;
                                                        "
                                                            class="pt-pb-5 border-bottom-line " align="">
                                                            <p class="fw-600  " style="">
                                                                PRITI SALES CORPORATION
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="" align="">
                                                            <p class=" " style="text-align:initial;width:263px;">
                                                                <span class="fw-600 txt-left"> HeadOffice:
                                                                </span>&nbsp;#34/123,Dugar
                                                                Towers 2nd Floor
                                                                MarshallsRoad,
                                                                Egmore,Chennai-600008
                                                                E-mail:admin@pritisales.in
                                                                /info@pritisales.in
                                                                Ph:044-42661403I45558608I8609


                                                            </p>
                                                        </td>

                                                        <td colspan="8" class="" align="">
                                                            <p class=" " style="text-align:initial;width:326px;">
                                                                <span class="fw-600 txt-left">
                                                                    WareHouse:</span>&nbsp;
                                                                No:63,SidcoIndustrialEstate,
                                                                Sipcot,
                                                                Ranipet-632403.
                                                                Ph:246168
                                                                No:114/1,BhangiShoptoVenkatasamuthiramRoad,
                                                                LabbaiMankuppam Village ThuthipetAmbur
                                                                635811
                                                                No.3/1,JalalRoadExtension,
                                                                MalligaiThoppu,Ambur-635802.
                                                                Ph:04174240330

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
                                                        <td colspan="12" class="pb-30" align="right">

                                                            <img src="{{ URL::asset('assets/images/client_logos/vasa/logo_priti.jpg') }}"
                                                                class="" alt=""
                                                                style="height: 35px;width:200px;">

                                                        </td>

                                                    </tr>

                                                    <tr>
                                                        <td colspan="12" style=" "class="pt-30" align="center">
                                                            <span class="fw-600  border-bottom-line" style="">
                                                                ANNEXURE B
                                                            </span>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="12" style=" "class="pt-20" align="">
                                                            <p class="fw-600  " style="">
                                                                DUTIES
                                                            </p>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="12" style=" "class="" align="">
                                                            <p class="  " style="">
                                                                You will devote your full-time skill and attention to the
                                                                work
                                                                and business of the Company and shall continue to work to
                                                                the
                                                                best of your ability.

                                                            </p>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="12" style=" "class="" align="">
                                                            <p class="  " style="">
                                                                You will accept, support, and work within the management,
                                                                financial, personnel, internal control, and reporting
                                                                systems,
                                                                policies, practices, and procedures as determined by the
                                                                Company
                                                                or your Manager, from time to time.

                                                            </p>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="12" style=" "class="pt-10" align="">
                                                            <p class="fw-600  " style="">
                                                                HOURS OF WORK
                                                            </p>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="12" style=" "class="" align="">
                                                            <p class=" " style="">
                                                                Your actual working hours &nbsp;<span
                                                                    class="fw-600 txt-left">9.45 AM to 6 PM </span>&nbsp;
                                                                including working in
                                                                Shifts and working days (including working on weekly offs
                                                                and
                                                                public holidays) will be often determined by workflow and
                                                                Company commitments.


                                                            </p>
                                                            <p class="12 " style="">
                                                                PRITI SALES CORPORATION works for &nbsp;<span
                                                                    class="fw-600 txt-left">8
                                                                    hours</span>&nbsp; (Including Break) a day 5 days a
                                                                week and Saturday &nbsp;<span class="fw-600 txt-left">9.45
                                                                    AM
                                                                    to 4 PM </span>&nbsp; (Including Break). However,
                                                                there may be certain work exigencies that may require you to
                                                                work beyond the stipulated hours of work.

                                                            </p>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="12" style=" "class="pt-10" align="">
                                                            <p class="fw-600  " style="">
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
                                                            <p class=" fw-600" style="">
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
                                                            <p class=" fw-600" style="">
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
                                                            <p class=" fw-600" style="">
                                                                EXPENSES
                                                            </p>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="12" style="padding-bottom:75px;"
                                                            class="border-bottom-line ">
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
                                                        <td colspan="4" class="" align="">
                                                            <p class=" " style="text-align:initial;width:263px;">
                                                                <span class="fw-600 txt-left"> HeadOffice:
                                                                </span>&nbsp;#34/123,Dugar
                                                                Towers 2nd Floor
                                                                MarshallsRoad,
                                                                Egmore,Chennai-600008
                                                                E-mail:admin@pritisales.in
                                                                /info@pritisales.in
                                                                Ph:044-42661403I45558608I8609


                                                            </p>
                                                        </td>

                                                        <td colspan="8" class="" align="">
                                                            <p class=" " style="text-align:initial;width:326px;">
                                                                <span class="fw-600 txt-left">
                                                                    WareHouse:</span>&nbsp;
                                                                No:63,SidcoIndustrialEstate,
                                                                Sipcot,
                                                                Ranipet-632403.
                                                                Ph:246168
                                                                No:114/1,BhangiShoptoVenkatasamuthiramRoad,
                                                                LabbaiMankuppam Village ThuthipetAmbur
                                                                635811
                                                                No.3/1,JalalRoadExtension,
                                                                MalligaiThoppu,Ambur-635802.
                                                                Ph:04174240330

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
                                                        <td colspan="12" class="pb-30" align="right">

                                                            <img src="{{ URL::asset('assets/images/client_logos/vasa/logo_priti.jpg') }}"
                                                                class="" alt=""
                                                                style="height: 35px;width:200px;">


                                                        </td>

                                                    </tr>

                                                    <tr>
                                                        <td colspan="12" style=" "class="pt-10">
                                                            <p class=" fw-600" style="">
                                                                PROVIDENT FUND SCHEME AND ESIC

                                                            </p>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="12" style=" "class="">
                                                            <p class=" " style="">
                                                                Employer contributions will be submitted to the Indian
                                                                Government-approved Provident Fund Scheme on your behalf
                                                                with
                                                                your equal monthly contribution as detailed in &nbsp;<span
                                                                    class="fw-600 txt-left"> Annexure A .</span>&nbsp;

                                                            </p>

                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="12" style=" "class="pt-10">
                                                            <p class=" fw-600" style="">
                                                                METHOD OF PAYMENT
                                                            </p>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="12" style=" "class="">
                                                            <p class="" style="">
                                                                Salaries and wages will be paid monthly by electronic funds
                                                                transfer or will be deposited in your Salary Account or any
                                                                other means on or before the 7th day of each month in
                                                                arrears.
                                                                The company reserves its right to vary this procedure at its
                                                                option. However, such variance will be communicated to you
                                                                in
                                                                due course.

                                                            </p>

                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="12" style=" "class="pt-10">
                                                            <p class="fw-600  " style="">
                                                                LEAVE
                                                            </p>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="12" style=" "class="" align="">
                                                            <p class="  " style="">
                                                                Leave will be granted as per the prevailing Company's
                                                                policy. The current Leave Policy is available in the
                                                                employeehandbook
                                                            </p>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="12" style=" "class="pt-10" align="">
                                                            <p class="fw-600  " style="">
                                                                INTELLECTUAL PROPERTY RIGHTS

                                                            </p>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="12" style=" "class="" align="">
                                                            <p class="  " style="">
                                                                All Industrial and intellectual property rights, including
                                                                but
                                                                not limited to patent rights, design rights, copyrights, and
                                                                related rights, database rights, trademark rights, and chip
                                                                rights, ensuring within the framework of the work performed
                                                                by
                                                                you during your employment with the company,
                                                            </p>
                                                            <p class="  " style="">
                                                                will be exclusively vested in Company. You may not
                                                                independently
                                                                during your employment and subsequent to termination
                                                                disclose,
                                                                multiply, use, manufacture, bring on the market or sell,
                                                                lease,
                                                                deliver, or otherwise trade, offer on behalf of any third
                                                                party,
                                                                or commission the registration of the results of your work.
                                                                To
                                                                the extent that such inventions are performed under the
                                                                Company’s direction, you shall fully, freely, and
                                                                immediately
                                                                communicate any invention to the Company and all rights,
                                                                title,
                                                                and interest to any such invention (“Inventions”) shall be
                                                                the
                                                                sole property of the Company.

                                                            </p>
                                                            <p class="  " style="">
                                                                In pursuance of the above

                                                            </p>

                                                            <ol type="A" style="text-align: justify">
                                                                <li class="pt-pb-5">You will give the Company and its
                                                                    solicitors and/or its
                                                                    patent attorneys all necessary assistance and
                                                                    cooperation in
                                                                    connection with the preparation and prosecution of any
                                                                    application for patent, design, registration, or
                                                                    copyright
                                                                    by the Company in respect of the Invention.
                                                                </li>
                                                                <li>TeYou irrevocably appoint the Company and any directors
                                                                    of
                                                                    the Company jointly and severally your true and lawful
                                                                    attorney to execute all such documents and do all such
                                                                    things as in the opinion of the Company may be necessary
                                                                    or
                                                                    requisite for any such purpose.</li>

                                                            </ol>


                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="" style=" "class="pt-10">
                                                            <p class="fw-600  " style="">
                                                                TERMINATION
                                                            </p>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="12" style="padding-bottom:28px;"
                                                            class=" border-bottom-line ">
                                                            <p class="  " style="">
                                                                Your employment may be terminated at any time by yourself,
                                                                or by
                                                                the Company, upon providing one (1) month’s written notice
                                                                to
                                                                the other party. Also, it can be extended according to the
                                                                management’s needs
                                                            </p>
                                                            <p class="pt-pb-5 " style="">
                                                                In the case of the Company terminating, you for reasons
                                                                other
                                                                than a breach of contract by you or for any disciplinary
                                                                reasons
                                                                against you, the company shall pay you one month’s salary
                                                                equal
                                                                to your notice period not worked as payment in lieu of
                                                                notice.

                                                            </p>

                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <td colspan="4" class="" align="">
                                                            <p class=" " style="text-align:initial;width:263px;">
                                                                <span class="fw-600 txt-left"> HeadOffice:
                                                                </span>&nbsp;#34/123,Dugar
                                                                Towers 2nd Floor
                                                                MarshallsRoad,
                                                                Egmore,Chennai-600008
                                                                E-mail:admin@pritisales.in
                                                                /info@pritisales.in
                                                                Ph:044-42661403I45558608I8609


                                                            </p>
                                                        </td>

                                                        <td colspan="8" class="" align="">
                                                            <p class=" " style="text-align:initial;width:326px;">
                                                                <span class="fw-600 txt-left">
                                                                    WareHouse:</span>&nbsp;
                                                                No:63,SidcoIndustrialEstate,
                                                                Sipcot,
                                                                Ranipet-632403.
                                                                Ph:246168
                                                                No:114/1,BhangiShoptoVenkatasamuthiramRoad,
                                                                LabbaiMankuppam Village ThuthipetAmbur
                                                                635811
                                                                No.3/1,JalalRoadExtension,
                                                                MalligaiThoppu,Ambur-635802.
                                                                Ph:04174240330

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
                                                        <td colspan="12" class="pb-30" align="right">

                                                            <img src="{{ URL::asset('assets/images/client_logos/vasa/logo_priti.jpg') }}"
                                                                class="" alt=""
                                                                style="height: 35px;width:200px;">


                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td colspan="12 " style=" "class="">
                                                            <p class=" " style="">
                                                                If you seek to terminate your employment with the company,
                                                                you
                                                                shall do a proper handover of all the work and
                                                                responsibilities
                                                                that you are handling to your manager and the resource
                                                                identified for replacing you, to the satisfaction of your
                                                                manager. If you are not able to serve the notice period one
                                                                (1)
                                                                month of your CTC to be payable to PRITI SALES CORPORATION

                                                            </p>
                                                            <p class="pt-pb-5 " style="">
                                                                Upon termination of your employment with the company, you
                                                                agree
                                                                not to solicit any other team members in the company to the
                                                                new
                                                                organization that you are going.

                                                            </p>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td colspan="12" style=" "class="pt-10">
                                                            <p class="fw-600  " style="">
                                                                DISPUTE RESOLUTION
                                                            </p>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="12" style=" "class="">
                                                            <p class="  " style="">
                                                                Any differences and disputes arising out of this appointment
                                                                letter would be settled by arbitration conducted in
                                                                accordance
                                                                with the arbitration and conciliation act 1996 with a person
                                                                nominated by the company as the sole arbitrator. The
                                                                arbitrator
                                                                shall conclude the arbitration within 30 days from the date
                                                                of
                                                                reference and shall pass an award. The award passed by the
                                                                arbitrator shall be conclusive and binding on the parties
                                                                and
                                                                shall not be appealable before a court of law.

                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="12 " style=" "class="pt-10">
                                                            <p class="fw-600  " style="">
                                                                GOVERNING LAW AND JURISDICTION

                                                            </p>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="12" style=" "class="">
                                                            <p class="  " style="">
                                                                This agreement shall be governed by the laws of the Republic
                                                                of
                                                                India and courts in Chennai have exclusive jurisdiction over
                                                                this agreement.

                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="12" style=" "class="pt-10">
                                                            <p class="fw-600  " style="">
                                                                RETIREMENT AGE


                                                            </p>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="12" style=" "class="">
                                                            <p class="  " style="">
                                                                The general Retirement for employees in the Company is
                                                                &nbsp;<span class="fw-600 txt-left"> Fifty-Eight (58)
                                                                    years.
                                                                </span>&nbsp;
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="12" style=" " align="">
                                                            <p class="fw-600 pt-30  txt-left " style="">
                                                                Yours faithfully,
                                                            </p>
                                                            <p class="pt-pb-5 pb-30 fw-600">
                                                                For PRITI SALES CORPORATION

                                                            </p>

                                                            <p class="fw-600 pt-10 txt-left " style="">
                                                                Founder and CEO of Priti Sales Corporation
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="12" style=" " align="left">
                                                            <p class=" pt-10 txt-left " style="">
                                                                I M Xyz, have read &nbsp;<span
                                                                    class="fw-600 txt-left">ANNEXURE
                                                                    A &
                                                                    B,</span>&nbsp; understood, and accept the
                                                                appointment upon the terms and conditions as
                                                                outlined in this appointment letter for my
                                                                position at &nbsp;<span class="fw-600 txt-left">PRITI SALES
                                                                    CORPORATION
                                                                </span>&nbsp;.

                                                            </p>


                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" class="pt-30" style=" " align="left">
                                                            <p class="fw-600 txt-left " style="">
                                                                Sign:
                                                            </p>


                                                        </td>
                                                        <td colspan="6" class="pt-30" style="" align="right">
                                                            <p class="fw-600 txt-right " style="">
                                                                Date:
                                                            </p>


                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="12"
                                                            style="text-align:initial;padding-bottom:183px;"
                                                            class="pt-pb-5 border-bottom-line " align="">
                                                            <p class="fw-600  " style="">
                                                                PRITI SALES CORPORATION
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="" align="">
                                                            <p class=" " style="text-align:initial;width:263px;">
                                                                <span class="fw-600 txt-left"> HeadOffice:
                                                                </span>&nbsp;#34/123,Dugar
                                                                Towers 2nd Floor
                                                                MarshallsRoad,
                                                                Egmore,Chennai-600008
                                                                E-mail:admin@pritisales.in
                                                                /info@pritisales.in
                                                                Ph:044-42661403I45558608I8609


                                                            </p>
                                                        </td>

                                                        <td colspan="8" class="" align="">
                                                            <p class=" " style="text-align:initial;width:326px;">
                                                                <span class="fw-600 txt-left">
                                                                    WareHouse:</span>&nbsp;
                                                                No:63,SidcoIndustrialEstate,
                                                                Sipcot,
                                                                Ranipet-632403.
                                                                Ph:246168
                                                                No:114/1,BhangiShoptoVenkatasamuthiramRoad,
                                                                LabbaiMankuppam Village ThuthipetAmbur
                                                                635811
                                                                No.3/1,JalalRoadExtension,
                                                                MalligaiThoppu,Ambur-635802.
                                                                Ph:04174240330

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
                                            <table class="letter-format" style="padding:0;">
                                                <tbody>
                                                    <tr>
                                                        <td align="center" style="">
                                                            <table class="table-one">
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="12" class="pb-30" align="right">
                                                                            <img src="{{ URL::asset('assets/images/client_logos/vasa/logo_priti.jpg') }}"
                                                                                class="" alt=""
                                                                                style="height: 35px;width:200px;">
                                                                        </td>

                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="12" style=" " align="center">
                                                                            <p class="fw-600 txt-center pb-30 "
                                                                                style="">
                                                                                DISCLOSURE AGREEMENT
                                                                            </p>

                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="3" style=" " align="">
                                                                            <p class="fw-600 txt-left " style="">
                                                                                Name<span class="">:</span>
                                                                            </p>

                                                                        </td>
                                                                        <td colspan="3" style=" " align="">
                                                                            <p class="txt-left " style="">

                                                                            </p>

                                                                        </td>
                                                                        <td colspan="3" style=" " align="">
                                                                            <p class="fw-600 txt-left " style="">
                                                                                Date <span class="">:</span>
                                                                            </p>

                                                                        </td>
                                                                        <td colspan="3" style=" " align="">
                                                                            <p class=" txt-left " style="">

                                                                            </p>

                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="6" style=" " align="">
                                                                            <p class="fw-600 txt-left pt-20 "
                                                                                style="">
                                                                                No <span class="">:</span>
                                                                            </p>

                                                                        </td>
                                                                        <td colspan="6" style=" " align="">
                                                                            <p class="txt-left pt-20 " style="">
                                                                                {{-- <span class="">:</span> --}}
                                                                            </p>

                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="12" style=" " align="">
                                                                            <p class=" pb-30 txt-left pt-20 "
                                                                                style="">
                                                                                I have read and agree to comply with the terms
                                                                                of the attached NDA. I have signed and
                                                                                handed over the original copy of the NDA to HR.
                                                                            </p>

                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="12"
                                                                            style="padding-right: 20px;padding-left: 20px;"
                                                                            align="">
                                                                            <p class=" txt-left" style="">
                                                                                I have read and agree to comply with the terms
                                                                                of the attached policies governing the

                                                                            </p>

                                                                            <p class=" txt-left pt-20 " style="">

                                                                                use of “Computer network and Internet access” of
                                                                                <span class="fw-600  " style="">
                                                                                     PRITI MARKETING AGENCIES </span>. I
                                                                            </p>
                                                                            <p class=" txt-left pt-20 " style="">
                                                                                understand that violation of this policy may
                                                                                result in disciplinary action, including

                                                                            </p>
                                                                            <p class=" txt-left pt-20 pb-30 "
                                                                                style="">
                                                                                possible termination. Also I have received a
                                                                                copy of the above policies.

                                                                            </p>

                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="12">
                                                                            <p class=" txt-left pt-20 " style="">

                                                                                Signature of the Employee
                                                                            </p>

                                                                        </td>
                                                                    </tr>




                                                                    <tr>
                                                                        <td class="" colspan="12"
                                                                            style="padding-top: 432px">
                                                                            <table style="border-top: 1px solid #000">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td colspan="4" class="" align="">
                                                                                            <p class=" "
                                                                                                style="text-align:initial;width:;">
                                                                                                <span class="fw-600 txt-left"> HeadOffice:
                                                                                                </span>&nbsp;#34/123,Dugar
                                                                                                Towers 2nd Floor
                                                                                                MarshallsRoad,
                                                                                                Egmore,Chennai-600008
                                                                                                E-mail:admin@pritisales.in
                                                                                                /info@pritisales.in
                                                                                                Ph:044-42661403I45558608I8609


                                                                                            </p>
                                                                                        </td>

                                                                                        <td colspan="8" class="" align="">
                                                                                            <p class=" "
                                                                                                style="text-align:initial;width:326px;">
                                                                                                <span class="fw-600 txt-left">
                                                                                                    WareHouse:</span>&nbsp;
                                                                                                No:63,SidcoIndustrialEstate,
                                                                                                Sipcot,
                                                                                                Ranipet-632403.
                                                                                                Ph:246168
                                                                                                No:114/1,BhangiShoptoVenkatasamuthiramRoad,
                                                                                                LabbaiMankuppam Village ThuthipetAmbur
                                                                                                635811
                                                                                                No.3/1,JalalRoadExtension,
                                                                                                MalligaiThoppu,Ambur-635802.
                                                                                                Ph:04174240330

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
                                                        <td align="center" style="">
                                                            <table class="table-one">
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="12" class="pb-30" align="right">
                                                                            <img src="{{ URL::asset('assets/images/client_logos/vasa/logo_priti.jpg') }}"
                                                                                class="" alt=""
                                                                                style="height: 35px;width:200px;">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="12" style=" " align="center">
                                                                            <p class="fw-600 txt-center pb-30 "
                                                                                style="">
                                                                                NON – DISCLOSURE AGREEMENT
                                                                            </p>

                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="12" style=" ">
                                                                            <p class=" txt-left " style="">
                                                                                This
                                                                                <span class="fw-600"> NON-DISCLOSURE AGREEMENT
                                                                                </span>
                                                                                is made at Chennai
                                                                                on this September 1st, day
                                                                                of 2021 by and between   Priti Sales Corporation
                                                                                and Associate of Vasa Group
                                                                                of Companies, India hereinafter referred to as
                                                                                “Langro” (which expression unless
                                                                                repugnant to the context shall mean and include
                                                                                its successors and assigns) and
                                                                                _________________________________ hereinafter
                                                                                referred to as <span class="fw-600">
                                                                                    “Recipient” </span>
                                                                                (which expression unless repugnant to the
                                                                                context shall mean and include its
                                                                                successors and assigns).

                                                                            </p>
                                                                            <p class=" txt-left pt-20" style="">
                                                                                Whereas it is anticipated that, it may be
                                                                                necessary for Indchemto disclose certain
                                                                                confidential and proprietary information in
                                                                                written, oral, visual and/or
                                                                                physical/sample form to the Recipient or the
                                                                                Recipient may otherwise come into
                                                                                control or possession of certain information,
                                                                                including those of the customers of
                                                                                Indchemwhich is considered as confidential by
                                                                                Indchem(collectively “Confidential
                                                                                Information” and as defined herein).
                                                                            </p>

                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="12" class="" align="right">
                                                                            <p class=" txt-left pt-20" style="">
                                                                                Accordingly, the parties agree as follows:
                                                                            </p>
                                                                            <ol type="1">
                                                                                <li>
                                                                                    <p class=" txt-left  pt-20 "
                                                                                        style="">
                                                                                        <span class="fw-600">Confidential
                                                                                            Information:</span>
                                                                                        Confidential Information shall mean and
                                                                                        include
                                                                                        any information disclosed by  Priti to
                                                                                        the Recipient, either directly or
                                                                                        indirectly, either orally or in writing,
                                                                                        by inspection of tangible objects
                                                                                        (including, without limitation,
                                                                                        documents, prototypes, samples, media,
                                                                                        documentation, discs and code).
                                                                                        Confidential Information shall include,
                                                                                        without limitation, any building plans,
                                                                                        site maps, security features,
                                                                                        materials, trade secrets, intellectual
                                                                                        property rights, know-how, formulae,
                                                                                        processes, algorithms, ideas,
                                                                                        strategies, inventions, data, network
                                                                                        configurations, system architecture,
                                                                                        designs, flow charts, drawings,
                                                                                        hardware, software, media and the
                                                                                        contents thereof, proprietary
                                                                                        information, business and marketing
                                                                                        plans, financial and operational
                                                                                        information, information about customers
                                                                                        (either present, past or
                                                                                        prospective) of Langro, information
                                                                                        regarded as confidential by such
                                                                                        customers of Langro, all non-public
                                                                                        information, material or date relating
                                                                                        to
                                                                                        the current and/or future business and
                                                                                        operations of  Priti and analysis,
                                                                                        compilations, studies, summaries,
                                                                                        extracts or other documentation
                                                                                        prepared by the Recipient based on
                                                                                        information disclosed by  Priti and any
                                                                                        other information considered as
                                                                                        confidential information by Langro.
                                                                                        Confidential Information shall also
                                                                                        include information disclosed to the
                                                                                        Recipient by third parties on behalf of
                                                                                         Priti or that may otherwise come
                                                                                        into the possession and / or control of
                                                                                        the Recipient. The term Confidential
                                                                                        Information shall also include any
                                                                                        derivatives made out of any Confidential
                                                                                        Information of  Priti and also any
                                                                                        information gathered by the use or
                                                                                        inspection of the Confidential
                                                                                        Information of Langro.

                                                                                    </p>


                                                                                </li>
                                                                                <li>
                                                                                    <p class=" txt-left  pt-10 "
                                                                                        style="">
                                                                                        <span class="fw-600">Scope:</span>
                                                                                         Priti retains the sole and exclusive
                                                                                        ownership
                                                                                        and intellectual
                                                                                        property rights in the Confidential
                                                                                        Information
                                                                                        and no license or any other
                                                                                        interest is granted to the Recipient by
                                                                                        virtue
                                                                                        of this Agreement or any other
                                                                                        agreement between the parties, unless
                                                                                        expressly
                                                                                        agreed to the contrary by
                                                                                         Priti in writing prior to such
                                                                                        disclosure.
                                                                                    </p>
                                                                                </li>
                                                                            </ol>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="" colspan="12"
                                                                            style="padding-top: 20px">
                                                                            <table style="border-top: 1px solid #000">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td colspan="4" class="" align="">
                                                                                            <p class=" "
                                                                                                style="text-align:initial;width:;">
                                                                                                <span class="fw-600 txt-left"> HeadOffice:
                                                                                                </span>&nbsp;#34/123,Dugar
                                                                                                Towers 2nd Floor
                                                                                                MarshallsRoad,
                                                                                                Egmore,Chennai-600008
                                                                                                E-mail:admin@pritisales.in
                                                                                                /info@pritisales.in
                                                                                                Ph:044-42661403I45558608I8609


                                                                                            </p>
                                                                                        </td>

                                                                                        <td colspan="8" class="" align="">
                                                                                            <p class=" "
                                                                                                style="text-align:initial;width:326px;">
                                                                                                <span class="fw-600 txt-left">
                                                                                                    WareHouse:</span>&nbsp;
                                                                                                No:63,SidcoIndustrialEstate,
                                                                                                Sipcot,
                                                                                                Ranipet-632403.
                                                                                                Ph:246168
                                                                                                No:114/1,BhangiShoptoVenkatasamuthiramRoad,
                                                                                                LabbaiMankuppam Village ThuthipetAmbur
                                                                                                635811
                                                                                                No.3/1,JalalRoadExtension,
                                                                                                MalligaiThoppu,Ambur-635802.
                                                                                                Ph:04174240330

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
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item  ">
                                    <div class="main-page appointment-letter">
                                        <div class="sub-page" style="text-align: justify;font-size: 15px;">
                                            <table class="letter-format" style="padding:0;">
                                                <tbody>
                                                    <tr>
                                                        <td align="center" style="">
                                                            <table class="table-one">
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="12" class="pb-30" align="right">
                                                                            <img src="{{ URL::asset('assets/images/client_logos/vasa/logo_priti.jpg') }}"
                                                                                class="" alt=""
                                                                                style="height: 35px;width:200px;">
                                                                        </td>

                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="12" class="" align="right">
                                                                            <p class=" txt-left  pt-10 " style="">3.
                                                                                <span class="fw-600">Term:</span>
                                                                                The term of this Agreement shall commence
                                                                                from and continue for
                                                                                five years there from September 1st, 2021
                                                                                notwithstanding the foregoing
                                                                                and without prejudice, the confidentiality
                                                                                obligations undertaken by the
                                                                                Recipient hereunder shall survive the expiry of
                                                                                this
                                                                                Agreement for a period
                                                                                of five years from the date of the latest of the
                                                                                disclosures made under this
                                                                                Agreement.
                                                                                Upon the expiry of the term of this Agreement or
                                                                                upon earlier request of
                                                                                Langro, the Recipient shall return all
                                                                                Confidential
                                                                                Information to Langro
                                                                                without retaining any copies of such
                                                                                Confidential
                                                                                Information. Any copies
                                                                                that cannot be so returned shall be immediately
                                                                                destroyed under certificate
                                                                                to  Priti in such a manner that they can never
                                                                                be
                                                                                retrieved by whatsoever
                                                                                method and in whatsoever form subsequent to such
                                                                                destruction.
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="12" class="" align="right">
                                                                            <p class=" txt-left  pt-10 " style="">4.
                                                                                <span class="fw-600"> Restrictions:</span>
                                                                                The Recipient undertakes to protect the
                                                                                Confidential
                                                                                Information with the same degree of care as used
                                                                                to protect its own
                                                                                Confidential Information, which degree of care
                                                                                shall be at least a
                                                                                reasonable degree of care to protect the
                                                                                Confidential Information received
                                                                                by under this Agreement. In addition to such
                                                                                degree of care, the Recipient
                                                                                agrees not to in any way disclose, copy,
                                                                                reproduce, modify, use, or
                                                                                otherwise transfer (including temporary
                                                                                transfer) the Confidential
                                                                                Information or any media containing the
                                                                                Confidential Information to any
                                                                                other person or entity without obtaining prior
                                                                                express written consent from
                                                                                Langro. The Recipient shall not reverse
                                                                                engineer, disassemble or reverse
                                                                                compile any prototypes, software or other
                                                                                tangible objects which embody
                                                                                the Confidential Information and which are
                                                                                provided to the Recipient
                                                                                hereunder. The Recipient shall at no time create
                                                                                any charge, lien or
                                                                                encumbrance of whatsoever nature on the
                                                                                Confidential Information. These
                                                                                shall be in addition to any other restrictions
                                                                                that  Priti may stipulate from
                                                                                time to time, which shall be binding upon the
                                                                                Recipient. These restrictions
                                                                                also apply to any media containing the
                                                                                Confidential Information.

                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="12" class="" align="right">
                                                                            <p class=" txt-left  pt-10 " style="">5.
                                                                                <span class="fw-600"> No Obligation:</span>
                                                                                Nothing herein shall obligate  Priti to
                                                                                disclose
                                                                                any

                                                                                information under this Agreement or to proceed
                                                                                with any transaction with
                                                                                the Recipient or enter into any other contract
                                                                                with the Recipient.


                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="12" class="" align="right">
                                                                            <p class=" txt-left  pt-10 " style="">6.
                                                                                <span class="fw-600"> Enforcement:</span>
                                                                                The Recipient also agrees that all the
                                                                                provisions of this
                                                                                Agreement shall be specifically enforceable by
                                                                                 Priti against the Recipient
                                                                                and its agents, employees and/or representatives
                                                                                by injunctive and other
                                                                                relief, including equitable relief. All the
                                                                                provisions hereof employees
                                                                                and/or representatives who have or may have
                                                                                access to the Confidential
                                                                                Information shall be bound by contracts
                                                                                whereupon it is made imperative
                                                                                upon them that the confidentiality of the
                                                                                Confidential Information shall be
                                                                                maintained and other restrictions imposed under
                                                                                this Agreement in relation
                                                                                to the Confidential Information with respect to
                                                                                the Recipient are observed
                                                                                and compiled by them, as if they were parties to
                                                                                this Agreement. The
                                                                                Recipients are observed and compiled by them, as
                                                                                if they were parties to
                                                                                this Agreement. The Recipient shall, whenever
                                                                                requested by Langro,
                                                                                provide documentary proof to show that the
                                                                                Recipient is complying with the
                                                                                provision of the clause in a manner satisfactory
                                                                                to Langro.
                                                                            </p>
                                                                        </td>
                                                                    </tr>


                                                                    <tr>
                                                                        <td class="" colspan="12"
                                                                            style="padding-top:119px ">
                                                                            <table style="border-top: 1px solid #000">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td colspan="4" class="" align="">
                                                                                            <p class=" "
                                                                                                style="text-align:initial;width:;">
                                                                                                <span class="fw-600 txt-left"> HeadOffice:
                                                                                                </span>&nbsp;#34/123,Dugar
                                                                                                Towers 2nd Floor
                                                                                                MarshallsRoad,
                                                                                                Egmore,Chennai-600008
                                                                                                E-mail:admin@pritisales.in
                                                                                                /info@pritisales.in
                                                                                                Ph:044-42661403I45558608I8609


                                                                                            </p>
                                                                                        </td>

                                                                                        <td colspan="8" class="" align="">
                                                                                            <p class=" "
                                                                                                style="text-align:initial;width:326px;">
                                                                                                <span class="fw-600 txt-left">
                                                                                                    WareHouse:</span>&nbsp;
                                                                                                No:63,SidcoIndustrialEstate,
                                                                                                Sipcot,
                                                                                                Ranipet-632403.
                                                                                                Ph:246168
                                                                                                No:114/1,BhangiShoptoVenkatasamuthiramRoad,
                                                                                                LabbaiMankuppam Village ThuthipetAmbur
                                                                                                635811
                                                                                                No.3/1,JalalRoadExtension,
                                                                                                MalligaiThoppu,Ambur-635802.
                                                                                                Ph:04174240330

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

                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item  ">
                                    <div class="main-page appointment-letter">
                                        <div class="sub-page" style="text-align: justify;font-size: 15px;">
                                            <table class="letter-format" style="padding:0;">
                                                <tbody>
                                                    <tr>
                                                        <td align="center" style="">
                                                            <table class="table-one">
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="12" class="pb-30" align="right">
                                                                            <img src="{{ URL::asset('assets/images/client_logos/vasa/logo_priti.jpg') }}"
                                                                                class="" alt=""
                                                                                style="height: 35px;width:200px;">
                                                                        </td>

                                                                    </tr>


                                                                    <tr>
                                                                        <td colspan="12" class="" align="right">
                                                                            <p class=" txt-left  pt-10 " style="">7.
                                                                                <span class="fw-600">Compensation:</span>
                                                                                The Recipient agrees that monetary damages would
                                                                                be
                                                                                inadequate compensation to  Priti in the event
                                                                                the Recipient breaches any
                                                                                provisions of this Agreement. Therefore the
                                                                                parties agree that in the event
                                                                                of a breach or threatened breach of
                                                                                confidentiality or any term of this
                                                                                Agreement,  Priti shall be, without prejudice
                                                                                to
                                                                                any other remedies that it
                                                                                may have in this regard, and notwithstanding the
                                                                                arbitration provision
                                                                                contained in clause 8 below, entitled to
                                                                                specific performance and injunctive
                                                                                or other equitable relief as a remedy for any
                                                                                such breach or anticipated
                                                                                breach

                                                                            </p>
                                                                            <p class=" txt-left pt-pb-5 " style="">
                                                                                The recipient hereby specifically agrees to be
                                                                                liable for all damages and loss
                                                                                (both direct and indirect) sustained or Langro
                                                                                may sustain that as a result of
                                                                                or as a consequence of breach of the terms of
                                                                                this Agreement by the
                                                                                Recipient.

                                                                            </p>

                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="12" class="" align="right">
                                                                            <p class=" txt-left  pt-10 " style="">8
                                                                                <span class="fw-600">
                                                                                    Arbitration/Venue/Governing Law:</span>
                                                                                Any disputes between the parties shall
                                                                                be resolved by mutual discussions. Unresolved
                                                                                disputes, if any, shall be
                                                                                subject to resolution by arbitration by a sole
                                                                                arbitrator to be appointed by
                                                                                Langro. The language of the arbitration shall be
                                                                                English and the decision of
                                                                                the arbitrator shall be final and binding on the
                                                                                parties. The venue of
                                                                                Arbitration shall be Chennai and shall be
                                                                                conducted under the provision of
                                                                                the Arbitration and Conciliation Act, 1996. The
                                                                                laws of India shall govern
                                                                                this Agreement and shall be subject to the
                                                                                jurisdiction of the Courts at
                                                                                Chennai.

                                                                            </p>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="12" class="" align="right">
                                                                            <p class=" txt-left  pt-10 " style="">9.
                                                                                <span class="fw-600">Assignment:</span>
                                                                                : Recipient shall not have the right to assign
                                                                                or otherwise
                                                                                transfer, in whole or in part, any of its rights
                                                                                or obligations under this
                                                                                Agreement without obtaining prior written
                                                                                consent from Langro.


                                                                            </p>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="12" class="" align="right">
                                                                            <p class=" txt-left  pt-10 " style="">10.
                                                                                <span class="fw-600">Validity:</span>
                                                                                : If any provision hereof is found by a court to
                                                                                be invalid, void or
                                                                                unenforceable, the remaining provisions shall
                                                                                remain in full force and
                                                                                effect.


                                                                            </p>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="12" class="" align="right">
                                                                            <p class=" txt-left  pt-10 " style="">
                                                                                In addition to the above conditions, if required
                                                                                you may be subjected to certain
                                                                                project specific conditions in future, which
                                                                                should be adhered to as per the
                                                                                project requirement.
                                                                            </p>
                                                                            <p class=" txt-left  pt-10 " style="">
                                                                                IN WITNESS WHEREOF, the parties have executed
                                                                                this Agreement on the date
                                                                                first written above.
                                                                            </p>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="12" class="" align="right">
                                                                            <p class=" txt-left  pt-30 pb-30 "
                                                                                style="">
                                                                                Signature :

                                                                            </p>
                                                                        </td>
                                                                    </tr>






                                                                    <tr>
                                                                        <td class="" colspan="12"
                                                                            style="padding-top:217px">
                                                                            <table style="border-top: 1px solid #000">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td colspan="4" class="" align="">
                                                                                            <p class=" "
                                                                                                style="text-align:initial;width:;">
                                                                                                <span class="fw-600 txt-left"> HeadOffice:
                                                                                                </span>&nbsp;#34/123,Dugar
                                                                                                Towers 2nd Floor
                                                                                                MarshallsRoad,
                                                                                                Egmore,Chennai-600008
                                                                                                E-mail:admin@pritisales.in
                                                                                                /info@pritisales.in
                                                                                                Ph:044-42661403I45558608I8609


                                                                                            </p>
                                                                                        </td>

                                                                                        <td colspan="8" class="" align="">
                                                                                            <p class=" "
                                                                                                style="text-align:initial;width:326px;">
                                                                                                <span class="fw-600 txt-left">
                                                                                                    WareHouse:</span>&nbsp;
                                                                                                No:63,SidcoIndustrialEstate,
                                                                                                Sipcot,
                                                                                                Ranipet-632403.
                                                                                                Ph:246168
                                                                                                No:114/1,BhangiShoptoVenkatasamuthiramRoad,
                                                                                                LabbaiMankuppam Village ThuthipetAmbur
                                                                                                635811
                                                                                                No.3/1,JalalRoadExtension,
                                                                                                MalligaiThoppu,Ambur-635802.
                                                                                                Ph:04174240330

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

                                                    <h6 class="margin-0" style="padding-left: 5px">Priti Sales Corporation
                                                    </h6>
                                                    <p class="mb-0">Dugar Towers, 2nd floor,</p>
                                                    <p class="mb-0">#34/123, Marshalls Road, Egmore,</p>
                                                    <p class="mb-0">Chennai, Tamil Nadu, India 600 008. </p>
                                                </div>
                                            </td>
                                            <td colspan="4" class="border-less p3">

                                                <div class="header-img txt-right d-flex align-items-center">
                                                    <img src="{{ URL::asset('assets/images/client_logos/vasa/logo_priti.jpg') }}"
                                                        class="" alt=""
                                                        style="height: 40px;width:250px;max-height:100%;">
                                                </div>


                                            </td>
                                        </tr>


                                        <tr>
                                            <td colspan="12" class=" bg-ash ">
                                                <p class="sub-header txt-center text-strong">PAYSLIP FOR THE MONTH OF – NOV
                                                    – 2022</p>
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
                                                <p class="padding-md"></p>
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
                                                <p class="txt-left text-strong">VPF</p>
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
                                                <p class="txt-left text-strong">ESIC</p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-right"></p>
                                            </td>


                                        </tr>
                                        <tr>
                                            <td colspan="2" class="">
                                                <p class="txt-left text-strong">OTHER ALLOWANCE </p>
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
                                                <p class="txt-left text-strong">PROF TAX</p>
                                            </td>
                                            <td colspan="2" class="">
                                                <p class="txt-right"></p>
                                            </td>


                                        </tr>
                                        <tr>
                                            <td colspan="2" class="">
                                                <p class="txt-left text-strong">OTHER EARNINGS </p>
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
                                                <p class="txt-left text-strong"> TRAVEL CONVEYANCE </p>
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
                                                <p class="txt-left text-strong">OTHERDEDUCTIONS</p>
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
                                            <td colspan="12" class="bg-ash">
                                                <p class="txt-center text-strong">Leave Details </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="bg-ash">
                                                <p class="txt-center text-strong">Leave’s Type</p>
                                            </td>
                                            <td colspan="3" class="bg-ash">
                                                <p class="txt-center text-strong">Opening Balance</p>
                                            </td>
                                            <td colspan="3" class="bg-ash">
                                                <p class="txt-center text-strong">Availed Leaves</p>
                                            </td>
                                            <td colspan="3" class="bg-ash">
                                                <p class="txt-center text-strong">Closing Balance</p>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="4" class="bg-ash">
                                                <p class="txt-center text-strong">Casual Leave / Sick Leave</p>
                                            </td>
                                            <td colspan="3" class="">
                                                <p class="txt-center text-strong"></p>
                                            </td>
                                            <td colspan="3" class="">
                                                <p class="txt-center text-strong"></p>
                                            </td>
                                            <td colspan="3" class="">
                                                <p class="txt-center text-strong"></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="bg-ash">
                                                <p class="txt-center text-strong">Earned Leave</p>
                                            </td>
                                            <td colspan="3" class="">
                                                <p class="txt-center text-strong"></p>
                                            </td>
                                            <td colspan="3" class="">
                                                <p class="txt-center text-strong"></p>
                                            </td>
                                            <td colspan="3" class="">
                                                <p class="txt-center text-strong"></p>
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
                                                <p class="txt-left">Please reach out to us for any payroll queries at
                                                    -hr.admin@imcvasa.in</p>
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
                <div class="tab-pane fade " id="disclose" role="tabpanel" aria-labelledby="pills-home-tab">

                    <div id="disclosure_template" class="carousel slide" data-bs-touch="false"
                        data-bs-interval="false">
                        <div class="carousel-inner">
                            {{-- <div class="carousel-item active">
                                <div class="main-page appointment-letter">
                                    <div class="sub-page" style="text-align: justify;font-size: 15px;">
                                        <table class="letter-format" style="padding:0;">
                                            <tbody>
                                                <tr>
                                                    <td align="center" style="">
                                                        <table class="table-one">
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="12" class="pb-30" align="right">
                                                                        <img src="{{ URL::asset('assets/images/client_logos/vasa/logo_priti.jpg') }}"
                                                                            class="" alt=""
                                                                            style="height: 35px;width:200px;">
                                                                    </td>

                                                                </tr>

                                                                <tr>
                                                                    <td colspan="12" style=" " align="center">
                                                                        <p class="fw-600 txt-center pb-30 "
                                                                            style="">
                                                                            DISCLOSURE AGREEMENT
                                                                        </p>

                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td colspan="3" style=" " align="">
                                                                        <p class="fw-600 txt-left " style="">
                                                                            Name<span class="">:</span>
                                                                        </p>

                                                                    </td>
                                                                    <td colspan="3" style=" " align="">
                                                                        <p class="txt-left " style="">

                                                                        </p>

                                                                    </td>
                                                                    <td colspan="3" style=" " align="">
                                                                        <p class="fw-600 txt-left " style="">
                                                                            Date <span class="">:</span>
                                                                        </p>

                                                                    </td>
                                                                    <td colspan="3" style=" " align="">
                                                                        <p class=" txt-left " style="">

                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="6" style=" " align="">
                                                                        <p class="fw-600 txt-left pt-20 "
                                                                            style="">
                                                                            No <span class="">:</span>
                                                                        </p>

                                                                    </td>
                                                                    <td colspan="6" style=" " align="">
                                                                        <p class="txt-left pt-20 " style="">

                                                                        </p>

                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td colspan="12" style=" " align="">
                                                                        <p class=" pb-30 txt-left pt-20 "
                                                                            style="">
                                                                            I have read and agree to comply with the terms
                                                                            of the attached NDA. I have signed and
                                                                            handed over the original copy of the NDA to HR.
                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="12"
                                                                        style="padding-right: 20px;padding-left: 20px;"
                                                                        align="">
                                                                        <p class=" txt-left" style="">
                                                                            I have read and agree to comply with the terms
                                                                            of the attached policies governing the

                                                                        </p>

                                                                        <p class=" txt-left pt-20 " style="">

                                                                            use of “Computer network and Internet access” of
                                                                            <span class="fw-600  " style="">
                                                                                 PRITI MARKETING AGENCIES </span>. I
                                                                        </p>
                                                                        <p class=" txt-left pt-20 " style="">
                                                                            understand that violation of this policy may
                                                                            result in disciplinary action, including

                                                                        </p>
                                                                        <p class=" txt-left pt-20 pb-30 "
                                                                            style="">
                                                                            possible termination. Also I have received a
                                                                            copy of the above policies.

                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="12">
                                                                        <p class=" txt-left pt-20 " style="">

                                                                            Signature of the Employee
                                                                        </p>

                                                                    </td>
                                                                </tr>




                                                                <tr>
                                                                    <td class="" colspan="12"
                                                                        style="padding-top: 432px">
                                                                        <table style="border-top: 1px solid #000">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td colspan="4" class="" align="">
                                                                                        <p class=" "
                                                                                            style="text-align:initial;width:;">
                                                                                            <span class="fw-600 txt-left"> HeadOffice:
                                                                                            </span>&nbsp;#34/123,Dugar
                                                                                            Towers 2nd Floor
                                                                                            MarshallsRoad,
                                                                                            Egmore,Chennai-600008
                                                                                            E-mail:admin@pritisales.in
                                                                                            /info@pritisales.in
                                                                                            Ph:044-42661403I45558608I8609


                                                                                        </p>
                                                                                    </td>

                                                                                    <td colspan="8" class="" align="">
                                                                                        <p class=" "
                                                                                            style="text-align:initial;width:326px;">
                                                                                            <span class="fw-600 txt-left">
                                                                                                WareHouse:</span>&nbsp;
                                                                                            No:63,SidcoIndustrialEstate,
                                                                                            Sipcot,
                                                                                            Ranipet-632403.
                                                                                            Ph:246168
                                                                                            No:114/1,BhangiShoptoVenkatasamuthiramRoad,
                                                                                            LabbaiMankuppam Village ThuthipetAmbur
                                                                                            635811
                                                                                            No.3/1,JalalRoadExtension,
                                                                                            MalligaiThoppu,Ambur-635802.
                                                                                            Ph:04174240330

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
                                                    <td align="center" style="">
                                                        <table class="table-one">
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="12" class="pb-30" align="right">
                                                                        <img src="{{ URL::asset('assets/images/client_logos/vasa/logo_priti.jpg') }}"
                                                                            class="" alt=""
                                                                            style="height: 35px;width:200px;">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="12" style=" " align="center">
                                                                        <p class="fw-600 txt-center pb-30 "
                                                                            style="">
                                                                            NON – DISCLOSURE AGREEMENT
                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="12" style=" ">
                                                                        <p class=" txt-left " style="">
                                                                            This
                                                                            <span class="fw-600"> NON-DISCLOSURE AGREEMENT
                                                                            </span>
                                                                            is made at Chennai
                                                                            on this September 1st, day
                                                                            of 2021 by and between   Priti Sales Corporation
                                                                            and Associate of Vasa Group
                                                                            of Companies, India hereinafter referred to as
                                                                            “Langro” (which expression unless
                                                                            repugnant to the context shall mean and include
                                                                            its successors and assigns) and
                                                                            _________________________________ hereinafter
                                                                            referred to as <span class="fw-600">
                                                                                “Recipient” </span>
                                                                            (which expression unless repugnant to the
                                                                            context shall mean and include its
                                                                            successors and assigns).

                                                                        </p>
                                                                        <p class=" txt-left pt-20" style="">
                                                                            Whereas it is anticipated that, it may be
                                                                            necessary for Indchemto disclose certain
                                                                            confidential and proprietary information in
                                                                            written, oral, visual and/or
                                                                            physical/sample form to the Recipient or the
                                                                            Recipient may otherwise come into
                                                                            control or possession of certain information,
                                                                            including those of the customers of
                                                                            Indchemwhich is considered as confidential by
                                                                            Indchem(collectively “Confidential
                                                                            Information” and as defined herein).
                                                                        </p>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="12" class="" align="right">
                                                                        <p class=" txt-left pt-20" style="">
                                                                            Accordingly, the parties agree as follows:
                                                                        </p>
                                                                        <ol type="1">
                                                                            <li>
                                                                                <p class=" txt-left  pt-20 "
                                                                                    style="">
                                                                                    <span class="fw-600">Confidential
                                                                                        Information:</span>
                                                                                    Confidential Information shall mean and
                                                                                    include
                                                                                    any information disclosed by  Priti to
                                                                                    the Recipient, either directly or
                                                                                    indirectly, either orally or in writing,
                                                                                    by inspection of tangible objects
                                                                                    (including, without limitation,
                                                                                    documents, prototypes, samples, media,
                                                                                    documentation, discs and code).
                                                                                    Confidential Information shall include,
                                                                                    without limitation, any building plans,
                                                                                    site maps, security features,
                                                                                    materials, trade secrets, intellectual
                                                                                    property rights, know-how, formulae,
                                                                                    processes, algorithms, ideas,
                                                                                    strategies, inventions, data, network
                                                                                    configurations, system architecture,
                                                                                    designs, flow charts, drawings,
                                                                                    hardware, software, media and the
                                                                                    contents thereof, proprietary
                                                                                    information, business and marketing
                                                                                    plans, financial and operational
                                                                                    information, information about customers
                                                                                    (either present, past or
                                                                                    prospective) of Langro, information
                                                                                    regarded as confidential by such
                                                                                    customers of Langro, all non-public
                                                                                    information, material or date relating
                                                                                    to
                                                                                    the current and/or future business and
                                                                                    operations of  Priti and analysis,
                                                                                    compilations, studies, summaries,
                                                                                    extracts or other documentation
                                                                                    prepared by the Recipient based on
                                                                                    information disclosed by  Priti and any
                                                                                    other information considered as
                                                                                    confidential information by Langro.
                                                                                    Confidential Information shall also
                                                                                    include information disclosed to the
                                                                                    Recipient by third parties on behalf of
                                                                                     Priti or that may otherwise come
                                                                                    into the possession and / or control of
                                                                                    the Recipient. The term Confidential
                                                                                    Information shall also include any
                                                                                    derivatives made out of any Confidential
                                                                                    Information of  Priti and also any
                                                                                    information gathered by the use or
                                                                                    inspection of the Confidential
                                                                                    Information of Langro.

                                                                                </p>


                                                                            </li>
                                                                            <li>
                                                                                <p class=" txt-left  pt-10 "
                                                                                    style="">
                                                                                    <span class="fw-600">Scope:</span>
                                                                                     Priti retains the sole and exclusive
                                                                                    ownership
                                                                                    and intellectual
                                                                                    property rights in the Confidential
                                                                                    Information
                                                                                    and no license or any other
                                                                                    interest is granted to the Recipient by
                                                                                    virtue
                                                                                    of this Agreement or any other
                                                                                    agreement between the parties, unless
                                                                                    expressly
                                                                                    agreed to the contrary by
                                                                                     Priti in writing prior to such
                                                                                    disclosure.
                                                                                </p>
                                                                            </li>
                                                                        </ol>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="" colspan="12"
                                                                        style="padding-top: 20px">
                                                                        <table style="border-top: 1px solid #000">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td colspan="4" class="" align="">
                                                                                        <p class=" "
                                                                                            style="text-align:initial;width:;">
                                                                                            <span class="fw-600 txt-left"> HeadOffice:
                                                                                            </span>&nbsp;#34/123,Dugar
                                                                                            Towers 2nd Floor
                                                                                            MarshallsRoad,
                                                                                            Egmore,Chennai-600008
                                                                                            E-mail:admin@pritisales.in
                                                                                            /info@pritisales.in
                                                                                            Ph:044-42661403I45558608I8609


                                                                                        </p>
                                                                                    </td>

                                                                                    <td colspan="8" class="" align="">
                                                                                        <p class=" "
                                                                                            style="text-align:initial;width:326px;">
                                                                                            <span class="fw-600 txt-left">
                                                                                                WareHouse:</span>&nbsp;
                                                                                            No:63,SidcoIndustrialEstate,
                                                                                            Sipcot,
                                                                                            Ranipet-632403.
                                                                                            Ph:246168
                                                                                            No:114/1,BhangiShoptoVenkatasamuthiramRoad,
                                                                                            LabbaiMankuppam Village ThuthipetAmbur
                                                                                            635811
                                                                                            No.3/1,JalalRoadExtension,
                                                                                            MalligaiThoppu,Ambur-635802.
                                                                                            Ph:04174240330

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
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item  ">
                                <div class="main-page appointment-letter">
                                    <div class="sub-page" style="text-align: justify;font-size: 15px;">
                                        <table class="letter-format" style="padding:0;">
                                            <tbody>
                                                <tr>
                                                    <td align="center" style="">
                                                        <table class="table-one">
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="12" class="pb-30" align="right">
                                                                        <img src="{{ URL::asset('assets/images/client_logos/vasa/logo_priti.jpg') }}"
                                                                            class="" alt=""
                                                                            style="height: 35px;width:200px;">
                                                                    </td>

                                                                </tr>

                                                                <tr>
                                                                    <td colspan="12" class="" align="right">
                                                                        <p class=" txt-left  pt-10 " style="">3.
                                                                            <span class="fw-600">Term:</span>
                                                                            The term of this Agreement shall commence
                                                                            from and continue for
                                                                            five years there from September 1st, 2021
                                                                            notwithstanding the foregoing
                                                                            and without prejudice, the confidentiality
                                                                            obligations undertaken by the
                                                                            Recipient hereunder shall survive the expiry of
                                                                            this
                                                                            Agreement for a period
                                                                            of five years from the date of the latest of the
                                                                            disclosures made under this
                                                                            Agreement.
                                                                            Upon the expiry of the term of this Agreement or
                                                                            upon earlier request of
                                                                            Langro, the Recipient shall return all
                                                                            Confidential
                                                                            Information to Langro
                                                                            without retaining any copies of such
                                                                            Confidential
                                                                            Information. Any copies
                                                                            that cannot be so returned shall be immediately
                                                                            destroyed under certificate
                                                                            to  Priti in such a manner that they can never
                                                                            be
                                                                            retrieved by whatsoever
                                                                            method and in whatsoever form subsequent to such
                                                                            destruction.
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="12" class="" align="right">
                                                                        <p class=" txt-left  pt-10 " style="">4.
                                                                            <span class="fw-600"> Restrictions:</span>
                                                                            The Recipient undertakes to protect the
                                                                            Confidential
                                                                            Information with the same degree of care as used
                                                                            to protect its own
                                                                            Confidential Information, which degree of care
                                                                            shall be at least a
                                                                            reasonable degree of care to protect the
                                                                            Confidential Information received
                                                                            by under this Agreement. In addition to such
                                                                            degree of care, the Recipient
                                                                            agrees not to in any way disclose, copy,
                                                                            reproduce, modify, use, or
                                                                            otherwise transfer (including temporary
                                                                            transfer) the Confidential
                                                                            Information or any media containing the
                                                                            Confidential Information to any
                                                                            other person or entity without obtaining prior
                                                                            express written consent from
                                                                            Langro. The Recipient shall not reverse
                                                                            engineer, disassemble or reverse
                                                                            compile any prototypes, software or other
                                                                            tangible objects which embody
                                                                            the Confidential Information and which are
                                                                            provided to the Recipient
                                                                            hereunder. The Recipient shall at no time create
                                                                            any charge, lien or
                                                                            encumbrance of whatsoever nature on the
                                                                            Confidential Information. These
                                                                            shall be in addition to any other restrictions
                                                                            that  Priti may stipulate from
                                                                            time to time, which shall be binding upon the
                                                                            Recipient. These restrictions
                                                                            also apply to any media containing the
                                                                            Confidential Information.

                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="12" class="" align="right">
                                                                        <p class=" txt-left  pt-10 " style="">5.
                                                                            <span class="fw-600"> No Obligation:</span>
                                                                            Nothing herein shall obligate  Priti to
                                                                            disclose
                                                                            any

                                                                            information under this Agreement or to proceed
                                                                            with any transaction with
                                                                            the Recipient or enter into any other contract
                                                                            with the Recipient.


                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="12" class="" align="right">
                                                                        <p class=" txt-left  pt-10 " style="">6.
                                                                            <span class="fw-600"> Enforcement:</span>
                                                                            The Recipient also agrees that all the
                                                                            provisions of this
                                                                            Agreement shall be specifically enforceable by
                                                                             Priti against the Recipient
                                                                            and its agents, employees and/or representatives
                                                                            by injunctive and other
                                                                            relief, including equitable relief. All the
                                                                            provisions hereof employees
                                                                            and/or representatives who have or may have
                                                                            access to the Confidential
                                                                            Information shall be bound by contracts
                                                                            whereupon it is made imperative
                                                                            upon them that the confidentiality of the
                                                                            Confidential Information shall be
                                                                            maintained and other restrictions imposed under
                                                                            this Agreement in relation
                                                                            to the Confidential Information with respect to
                                                                            the Recipient are observed
                                                                            and compiled by them, as if they were parties to
                                                                            this Agreement. The
                                                                            Recipients are observed and compiled by them, as
                                                                            if they were parties to
                                                                            this Agreement. The Recipient shall, whenever
                                                                            requested by Langro,
                                                                            provide documentary proof to show that the
                                                                            Recipient is complying with the
                                                                            provision of the clause in a manner satisfactory
                                                                            to Langro.
                                                                        </p>
                                                                    </td>
                                                                </tr>


                                                                <tr>
                                                                    <td class="" colspan="12"
                                                                        style="padding-top:119px ">
                                                                        <table style="border-top: 1px solid #000">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td colspan="4" class="" align="">
                                                                                        <p class=" "
                                                                                            style="text-align:initial;width:;">
                                                                                            <span class="fw-600 txt-left"> HeadOffice:
                                                                                            </span>&nbsp;#34/123,Dugar
                                                                                            Towers 2nd Floor
                                                                                            MarshallsRoad,
                                                                                            Egmore,Chennai-600008
                                                                                            E-mail:admin@pritisales.in
                                                                                            /info@pritisales.in
                                                                                            Ph:044-42661403I45558608I8609


                                                                                        </p>
                                                                                    </td>

                                                                                    <td colspan="8" class="" align="">
                                                                                        <p class=" "
                                                                                            style="text-align:initial;width:326px;">
                                                                                            <span class="fw-600 txt-left">
                                                                                                WareHouse:</span>&nbsp;
                                                                                            No:63,SidcoIndustrialEstate,
                                                                                            Sipcot,
                                                                                            Ranipet-632403.
                                                                                            Ph:246168
                                                                                            No:114/1,BhangiShoptoVenkatasamuthiramRoad,
                                                                                            LabbaiMankuppam Village ThuthipetAmbur
                                                                                            635811
                                                                                            No.3/1,JalalRoadExtension,
                                                                                            MalligaiThoppu,Ambur-635802.
                                                                                            Ph:04174240330

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

                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item  ">
                                <div class="main-page appointment-letter">
                                    <div class="sub-page" style="text-align: justify;font-size: 15px;">
                                        <table class="letter-format" style="padding:0;">
                                            <tbody>
                                                <tr>
                                                    <td align="center" style="">
                                                        <table class="table-one">
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="12" class="pb-30" align="right">
                                                                        <img src="{{ URL::asset('assets/images/client_logos/vasa/logo_priti.jpg') }}"
                                                                            class="" alt=""
                                                                            style="height: 35px;width:200px;">
                                                                    </td>

                                                                </tr>


                                                                <tr>
                                                                    <td colspan="12" class="" align="right">
                                                                        <p class=" txt-left  pt-10 " style="">7.
                                                                            <span class="fw-600">Compensation:</span>
                                                                            The Recipient agrees that monetary damages would
                                                                            be
                                                                            inadequate compensation to  Priti in the event
                                                                            the Recipient breaches any
                                                                            provisions of this Agreement. Therefore the
                                                                            parties agree that in the event
                                                                            of a breach or threatened breach of
                                                                            confidentiality or any term of this
                                                                            Agreement,  Priti shall be, without prejudice
                                                                            to
                                                                            any other remedies that it
                                                                            may have in this regard, and notwithstanding the
                                                                            arbitration provision
                                                                            contained in clause 8 below, entitled to
                                                                            specific performance and injunctive
                                                                            or other equitable relief as a remedy for any
                                                                            such breach or anticipated
                                                                            breach

                                                                        </p>
                                                                        <p class=" txt-left pt-pb-5 " style="">
                                                                            The recipient hereby specifically agrees to be
                                                                            liable for all damages and loss
                                                                            (both direct and indirect) sustained or Langro
                                                                            may sustain that as a result of
                                                                            or as a consequence of breach of the terms of
                                                                            this Agreement by the
                                                                            Recipient.

                                                                        </p>

                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td colspan="12" class="" align="right">
                                                                        <p class=" txt-left  pt-10 " style="">8
                                                                            <span class="fw-600">
                                                                                Arbitration/Venue/Governing Law:</span>
                                                                            Any disputes between the parties shall
                                                                            be resolved by mutual discussions. Unresolved
                                                                            disputes, if any, shall be
                                                                            subject to resolution by arbitration by a sole
                                                                            arbitrator to be appointed by
                                                                            Langro. The language of the arbitration shall be
                                                                            English and the decision of
                                                                            the arbitrator shall be final and binding on the
                                                                            parties. The venue of
                                                                            Arbitration shall be Chennai and shall be
                                                                            conducted under the provision of
                                                                            the Arbitration and Conciliation Act, 1996. The
                                                                            laws of India shall govern
                                                                            this Agreement and shall be subject to the
                                                                            jurisdiction of the Courts at
                                                                            Chennai.

                                                                        </p>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td colspan="12" class="" align="right">
                                                                        <p class=" txt-left  pt-10 " style="">9.
                                                                            <span class="fw-600">Assignment:</span>
                                                                            : Recipient shall not have the right to assign
                                                                            or otherwise
                                                                            transfer, in whole or in part, any of its rights
                                                                            or obligations under this
                                                                            Agreement without obtaining prior written
                                                                            consent from Langro.


                                                                        </p>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td colspan="12" class="" align="right">
                                                                        <p class=" txt-left  pt-10 " style="">10.
                                                                            <span class="fw-600">Validity:</span>
                                                                            : If any provision hereof is found by a court to
                                                                            be invalid, void or
                                                                            unenforceable, the remaining provisions shall
                                                                            remain in full force and
                                                                            effect.


                                                                        </p>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td colspan="12" class="" align="right">
                                                                        <p class=" txt-left  pt-10 " style="">
                                                                            In addition to the above conditions, if required
                                                                            you may be subjected to certain
                                                                            project specific conditions in future, which
                                                                            should be adhered to as per the
                                                                            project requirement.
                                                                        </p>
                                                                        <p class=" txt-left  pt-10 " style="">
                                                                            IN WITNESS WHEREOF, the parties have executed
                                                                            this Agreement on the date
                                                                            first written above.
                                                                        </p>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td colspan="12" class="" align="right">
                                                                        <p class=" txt-left  pt-30 pb-30 "
                                                                            style="">
                                                                            Signature :

                                                                        </p>
                                                                    </td>
                                                                </tr>






                                                                <tr>
                                                                    <td class="" colspan="12"
                                                                        style="padding-top:217px">
                                                                        <table style="border-top: 1px solid #000">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td colspan="4" class="" align="">
                                                                                        <p class=" "
                                                                                            style="text-align:initial;width:;">
                                                                                            <span class="fw-600 txt-left"> HeadOffice:
                                                                                            </span>&nbsp;#34/123,Dugar
                                                                                            Towers 2nd Floor
                                                                                            MarshallsRoad,
                                                                                            Egmore,Chennai-600008
                                                                                            E-mail:admin@pritisales.in
                                                                                            /info@pritisales.in
                                                                                            Ph:044-42661403I45558608I8609


                                                                                        </p>
                                                                                    </td>

                                                                                    <td colspan="8" class="" align="">
                                                                                        <p class=" "
                                                                                            style="text-align:initial;width:326px;">
                                                                                            <span class="fw-600 txt-left">
                                                                                                WareHouse:</span>&nbsp;
                                                                                            No:63,SidcoIndustrialEstate,
                                                                                            Sipcot,
                                                                                            Ranipet-632403.
                                                                                            Ph:246168
                                                                                            No:114/1,BhangiShoptoVenkatasamuthiramRoad,
                                                                                            LabbaiMankuppam Village ThuthipetAmbur
                                                                                            635811
                                                                                            No.3/1,JalalRoadExtension,
                                                                                            MalligaiThoppu,Ambur-635802.
                                                                                            Ph:04174240330

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

                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div> --}}
                            <button class="carousel-control-prev" type="button" data-bs-target="#disclosure_template"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon bg-secondary rounded-circle"
                                    aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#disclosure_template"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon bg-secondary rounded-circle"
                                    aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
