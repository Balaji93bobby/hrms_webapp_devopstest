

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
        -webkit-box-sizing:border-box;
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

    .avatar_table tr,td{
        border: 2px solid #dee2e6 !important;
    }
    .payslip_table {
        width: 100%;
        vertical-align: middle;
        font-family: sans-serif;
    }

    table.payslip_table tr,
    td {
        border: 2px solid #af1888 !important;

    }

    .payslip_table td:last-child {}

    .border-less {
        border: 0px !important;
    }

    .payslip_table tr {
        height: 12.55pt;
    }

    .payslip_table td {
        width: 81.35pt
    }

    .padding-md {
        /* padding: 2pt 0pt; */
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


    .sm {}

    .md {}

    .lg {}

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
</style>

@endsection
@section('content')
@component('components.configuration_breadcrumb')
@slot('li_1')
@endslot
@endcomponent
<div class="container-fluid bg-white  ">
    <div class="fill salary-header nav-tab-header">
        <div>
            <ul class="nav nav-pills    nav-tabs-dashed" id="pills-tab" role="tablist">
                <li class="nav-item active ember-view mx-4" role="presentation">
                    <a class="nav-link active ember-view " id="pills-home-tab" data-bs-toggle="pill" href="" data-bs-target="#appointment" role="tab" aria-controls="pills-home" aria-selected="true">
                        Appointment Letter</a>
                </li>
                <li class="nav-item mx-4 ember-view" role="presentation ">
                    <a class="nav-link ember-view" id="payslips-tab" data-bs-toggle="pill" data-bs-target="#payslips" type="button" role="tab" aria-controls="payslips" aria-selected="false">Pay Slip</a>
                </li>

            </ul>

        </div>

    </div>

    <div class="tab-content " id="pills-tabContent">
        <div class="tab-pane fade show active" id="appointment" role="tabpanel" aria-labelledby="pills-home-tab">
            <div id="indicators" class="carousel slide" data-bs-touch="false" data-bs-interval="false">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#indicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#indicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#indicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#indicators" data-bs-slide-to="3" class="active" aria-current="true" aria-label="Slide 4"></button>
                    <button type="button" data-bs-target="#indicators" data-bs-slide-to="4" aria-label="Slide 5"></button>

                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="container-fluid appointment-letter">
                            <div class="main-page">
                                <div class="sub-page" style="text-align: justify;font-size: 15px;">
                                    <!-- <page size="A4"> -->

                                    <div class="appointment-letter">
                                        <div class="logo" style="width:150px;height: 50px;">

                                            <img src="{{ URL::asset('assets/images/appoinment/brandavatarlogo.png') }}" class=""  style="height:100%;width:100%;">
                                        </div>

                                        <p style="text-align: center;font-size:20px"><b> LETTER OF APPOINTMENT</b>
                                        </p>
                                        <b>
                                            <p> <br>Dear Xyz, </br>
                                        </b></br>
                                        We are glad to appoint you as <b>“Manager – Admin and HR”</b> in our company, <b>Brand Avatar LLP.</b>
                                        </p>
                                        <b>
                                            <p><br> Remuneration </br>
                                        </b></br>
                                        Your total remuneration package per annum will consist of <b>CTC Rs 3,69,696/- per annum (Rupees Three Lakhs
                                            Sixty Nine Thousand Six Hundred Nighty Six Only).</b> The breakup of your compensation package shall be as
                                        detailed in Annexure A.
                                        </p>
                                        <b>
                                            <p><br> Commencement</br>
                                        </b></br>
                                        Your employment with the company <b>Brand Avatar LLP</b> will be with effect from <b>16th August 2022.</b> You
                                        shall initially be placed in <b>Chennai.</b> You may however be required to travel and may be positioned or
                                        deputed outside within India or abroad.
                                        </p>
                                        <b>
                                            <p> <br>Rules and Regulations </br>
                                        </b>
                                        You shall be governed by the policies of the company as specified in <b>Annexure B.</b> You shall serve the
                                        Company and shall carry out such duties which will be explained and defined by your manager (immediate
                                        superior), subject always to the employee policy and the rules and regulations of the Company. Your employment
                                        shall continue to be governed by the terms of this appointment letter in the event of you being deputed or
                                        positioned outside India.
                                        <br> We welcome you to our team. We are confident that you will make an effective contribution to the growth of
                                        the company and will enjoy working with us. </br>

                                        <br>You will be under probation for a period of <b>SIX MONTHS.</b> Your confirmation will be based on the
                                        evaluation during the end of the probation period.</br>

                                        <br>If you are agreeable to the terms and conditions of the appointment (Annexure B), then kindly confirm your
                                        acceptance of the appointment by signing and returning to us the attached copy of this letter.</br>

                                        </p>

                                        <p> <b>Yours faithfully,</b></p>
                                        <p> <b>For Brand Avatar LLP</b></p>

                                        <div style="height:50px;width:100px">
                                            <img src="{{ URL::asset('assets/images/appoinment/sign2.png') }}" class="" alt="user-pic" style="height:100%;width:100%;">
                                        </div>

                                        <b><br>(Hemachandran L)</br>
                                            Founder and CEO of Brand Avatar LLP
                                        </b>

                                        <hr>
                                        <p>
                                            I <b>Xyz</b> have read <b>ANNEXURE A & B,</b> understood, and accept the appointment upon the terms
                                            and conditions as outlined in this appointment letter for my position at <b>Brand Avatar LLP.</b>
                                        </p>


                                        <div style="display: flex;justify-content:space-between ;margin-top:20px;">
                                            <span style="text-align: left;font-size:15px;float: left;">SIGN:
                                            </span>
                                            <span style="text-align: right;font-size:15px;float: right;margin-right: 80px;">DATE:
                                            </span>
                                        </div>

                                    </div>
                                    <hr style="margin-top: 150px;">
                                    <div class="divFooter" style="text-align:center;font-size: 13px;"> <span> <b>Registered Office Address</b> –
                                            Brand Avatar LLP, No-01, Kandasamy Street, Chandrabagh
                                            Avenue Extn, Radhakrishnan Salai, Mylapore, Chennai, Tamilnadu -600 004.</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="container-fluid appointment-letter">
                            <div class="main-page">
                                <div class="sub-page" style="text-align: justify;font-size: 15px;">
                                    <div class="logo" style="width:150px;height: 50px;margin: 10px 0px;">
                                        <img src="{{ URL::asset('assets/images/appoinment/brandavatarlogo.png') }}" class=""  style="height:100%;width:100%;">
                                    </div>
                                    <table cellspacing=2   class="table table-bordered avatar_table">
                                        <tr>
                                            <td colspan="3" style="text-align:center">ANNEXURE A</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="text-align:center">SALARY STRUCTURE</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="text-align:center">Your remuneration shall be paid to you under the following heads
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:40%" class="bg-ash"><b>Name: </b> </td>
                                            <!-- <td><b>Salary</td></b> -->
                                            <td colspan="1"></td>
                                            <td colspan="1"></td>
                                        </tr>
                                        <tr>
                                            <td style="width:40%">Designation </td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td style="width:40%">Department </td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td style="width:40%">Date of Joining </td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td style="width:40%">SALARY COMPONENTS </td>
                                            <td class="bg-ash"><b>Per Month</b></td>
                                            <td class="bg-ash"><b>Per Annum</b></td>
                                        </tr>
                                        <tr>
                                            <td style="width:40%">Basic </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td style="width:40%">HRA </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td style="width:40%">Special Allowance</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td style="width:40%" class="bg-ash"><b>Gross</b></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td style="width:40%">PF (Employer Contribution)</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td style="width:40%">ESI (Employer Contribution)</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td style="width:40%" class="bg-ash"><b>Cost to Company </b></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td style="width:40%">EPF (Employee Contribution)</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td style="width:40%">ESI (Employee Contribution)</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td style="width:40%">Professional Tax</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td style="width:40%" class="bg-ash"><b>Net Income </b></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <td colspan="3" style="width:40%">Income Tax as applicable will be deducted
                                        </td>
                                        </tr>
                                    </table>
                                    <p>
                                        I <b>Xyz S,</b> have read <b>ANNEXURE A & B,</b> understood, and accept the appointment upon the terms
                                        and conditions as outlined in this appointment letter for my position at <b>Brand Avatar LLP.</b>
                                    </p>

                                    <div style="display: flex;justify-content:space-between ;">
                                        <span style="text-align: left;font-size:15px;float: left;">SIGN:
                                        </span>
                                        <span style="text-align: right;font-size:15px;float: right;margin-right: 80px;">DATE:
                                        </span>
                                    </div>



                                    <hr style=" margin-top: 388px;">
                                    <div class="divFooter" style="text-align:center;font-size: 13px;"> <span> <b>Registered Office Address</b> – Brand
                                            Avatar LLP, No-01, Kandasamy Street, Chandrabagh
                                            Avenue Extn, Radhakrishnan Salai, Mylapore, Chennai, Tamilnadu -600 004.</span></div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="container-fluid appointment-letter">
                            <div class="main-page">
                                <div class="sub-page" style="text-align: justify;font-size: 15px;">
                                    <div class="logo" style="width:150px;height: 50px;margin: 10px 0px;">
                                        <img src="{{ URL::asset('assets/images/appoinment/brandavatarlogo.png') }}" class="" alt="user-pic" style="height:100%;width:100%;">
                                    </div>
                                    <div class="appointment-letter" style="text-align: justify;">
                                        <p style="text-align: center;font-size:20px">ANNEXURE B
                                        </p>
                                        <b>
                                            <p>DUTIES</br>
                                        </b></p>
                                        You will devote your full-time skill and attention to the work and business of the Company and shall continue to
                                        work to the best of your ability.
                                        <br>Without the Company’s prior written consent, you will not perform any other work for pay during your
                                        employment term, or will you, alone or with others, directly or indirectly, establish any business, whatever its
                                        form, or take any financial interest in or perform work for such a business, whether or not for
                                        consideration.</br>
                                        You will accept, support, and work within the management, financial, personnel, internal control, and reporting
                                        systems, policies, practices, and procedures as determined by the Company or your Manager, from time to
                                        time.</br>
                                        </p>
                                        <b>
                                            <p>HOURS OF WORK
                                        </b></br></p>
                                        Your actual working hours <b>8.55 AM to 6 PM </b>including working in Shifts and working days (including working
                                        on weekly offs and public holidays) will be often determined by workflow and Company commitments.
                                        Brand Avatar LLP works for 9 hours (Including Break) a day 6 days a week. However, there may be certain work
                                        exigencies that may require you to work beyond the stipulated hours of work.

                                        </p>
                                        </p>
                                        <b>
                                            <p> <br>CONDUCT</br>
                                        </b></p>
                                        You shall conduct yourself in a befitting manner and abide by all the conduct policy, rules, and regulations of
                                        the Company.
                                        </p>
                                        </p>
                                        <b>
                                            <p> <br>REVIEW OF SALARY</br>
                                        </b></p>
                                        Your remuneration shall be reviewed annually and any changes to your remuneration package shall be determined by
                                        considering your performance in the Company, the Company’s performance, and your contribution to the Company.
                                        </p>
                                        <b>
                                            <p> <br>CONFIDENTIALITY OF SALARY</br>
                                        </b></p>
                                        Your salary is the reward for your untiring effort and work. You need to maintain your salary with the utmost
                                        confidentiality. In the event you do not maintain the confidentiality of your salary, you may be subject to
                                        disciplinary action.
                                        <b>
                                            <p> <br>EXPENSES</br>
                                        </b></p>
                                        The Company will compensate you for all expenses that are reasonably incurred and that are directly related to
                                        the performance of your work, but only insofar as that compensation may be provided tax-free compensation of
                                        expenses as contained herein will be made only on the basis of a statement of expenses that have been approved
                                        by the Company.
                                        <b>
                                            <p> <br>PROVIDENT FUND SCHEME AND ESIC</br>
                                        </b></p>
                                        You will be entitled to an employer's contribution of Provident Fund to the extent of 12% of your gross salary
                                        excluding house rent allowance.</br>
                                        You will be eligible to get the ESIC medical benefits for you and your immediate family members if your gross
                                        wages are less than or equal to 21000/-

                                    </div>
                                    <hr style=" margin-top: 42px;">
                                    <div class="divFooter" style="text-align:center;font-size: 13px;"> <span> <b>Registered Office Address</b> – Brand
                                            Avatar LLP, No-01, Kandasamy Street, Chandrabagh
                                            Avenue Extn, Radhakrishnan Salai, Mylapore, Chennai, Tamilnadu -600 004.</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="container-fluid appointment-letter">
                            <div class="main-page">
                                <div class="sub-page" style="text-align: justify;font-size: 15px;">
                                    <div class="logo" style="width:150px;height: 50px;margin: 10px 0px;">
                                        <img src="{{ URL::asset('assets/images/appoinment/brandavatarlogo.png') }}" class="" alt="user-pic" style="height:100%;width:100%;">
                                    </div>
                                    <b>
                                        <p> <br>METHOD OF PAYMENT</br>
                                    </b></p>
                                    Salaries and wages will be paid monthly by electronic funds transfer or will be deposited in your Corporate
                                    Salary Account or any other means on or before the 7th day of each month in arrears. The company reserves its
                                    right to vary this procedure at its option. However, such variance will be communicated to you in due course.
                                    <b>
                                        <p> <br>LEAVE</br>
                                    </b></p>
                                    You will be governed by the leave rules of the Company; your manager has got all rights to decide on your leave
                                    as per the policy and you can avail of 12 days of Casual Leave (CL) in a year and 4 Days of Paid Leave.
                                    <b>
                                        <p> <br>INTELLECTUAL PROPERTY RIGHTS</br>
                                    </b></p>
                                    All Industrial and intellectual property rights, including but not limited to patent rights, design rights,
                                    copyrights, and related rights, database rights, trademark rights, and chip rights, ensuring within the
                                    framework of the work performed by you during your employment with the company, will be exclusively vested in
                                    Company. You may not independently during your employment and subsequent to termination disclose, multiply, use,
                                    manufacture, bring on the market or sell, lease, deliver, or otherwise trade, offer on behalf of any third
                                    party, or commission the registration of the results of your work. To the extent that such inventions are
                                    performed under the Company’s direction, you shall fully, freely, and immediately communicate any invention to
                                    the Company and all rights, title, and interest to any such invention (“Inventions”) shall be the sole property
                                    of the Company.</br>
                                    <br>In pursuance of the above</br>
                                    <br>A. You will give the Company and its solicitors and/or it’s patent attorneys all necessary assistance and
                                    cooperation in connection with the preparation and prosecution of any application for patent, design,
                                    registration, or copyright by the Company in respect of the Invention.</br>
                                    <br>B. You irrevocably appoint the Company and any directors of the Company jointly and severally your true and
                                    lawful attorney to execute all such documents and do all such things as in the opinion of the Company may be
                                    necessary or requisite for any such purpose.</br>
                                    <b>
                                        <p> <br>NON-DISCLOSURE AGREEMENT</br>
                                    </b></p>
                                    During the employment, the employee shall not directly or indirectly carry on, assist, engage in, be concerned,
                                    or participate in any business/activity (whether directly or indirectly, as a partner, shareholder, principal,
                                    agent, director, affiliate, Consultant or in any other capacity or manner whatsoever) which is similar to the
                                    business of the Company, nor engage in any activity that conflicts with the employee's obligations to the
                                    Company.</br>

                                    <br>Solicit Business: During the Term and for a period of 12 months after the Term, the employee shall not
                                    solicit, endeavor to solicit, influence, or attempt to influence any client, customer, or other Person, directly
                                    or indirectly, to direct his or its purchase of the Company's product and/or services, to self or any Person in
                                    competition with the business of the Company.</br><br>Solicit Personnel: During the Term and for a period of 12
                                    months after the Term, the Employee shall not solicit or attempt to influence any person employed or engaged by
                                    the Company (whether as an Employee, Consultant, Advisor, or in any other manner) or engagement with the Company
                                    or become the Consultant of or directly or indirectly offer services in any form or manner to himself or any
                                    person who is a competitor of the Company
                                    <hr style=" margin-top: 60px;">
                                    <div class="divFooter" style="text-align:center;font-size: 13px;"> <span> <b>Registered Office Address</b> – Brand
                                            Avatar LLP, No-01, Kandasamy Street, Chandrabagh
                                            Avenue Extn, Radhakrishnan Salai, Mylapore, Chennai, Tamilnadu -600 004.</span></div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="container-fluid appointment-letter">
                            <div class="main-page">
                                <div class="sub-page" style="text-align: justify;font-size: 15px;">
                                    <div class="logo" style="width:150px;height: 50px;margin: 10px 0px;">
                                        <img src="{{ URL::asset('assets/images/appoinment/brandavatarlogo.png') }}" class="" alt="user-pic" style="height:100%;width:100%;">
                                    </div>
                                    <p><b> TERMINATION
                                        </b> </p>
                                    Your employment may be terminated at any time by yourself, or by the Company, upon providing three (3)
                                    months’ written notice to the other party. </br>
                                    <br>In the case of the Company terminating, you for reasons other than a breach of contract by you or for any
                                    disciplinary reasons against you, the Company shall pay you one month’s salary equal to your notice period not
                                    worked as payment in lieu of notice.</br>
                                    <br>If you seek to terminate your employment with the company, you shall do a proper handover of all the work
                                    and responsibilities that you are handling to your manager and the resource identified for replacing you, to
                                    the satisfaction of your manager. If you are not able to serve the notice period three (3) months of your CTC to
                                    be payable to Brand Avatar LLP </br>
                                    <br>With conflict-of-interest terms and conditions, Employees of Brand Avtar will be refrained from serving as
                                    employees of clients/vendors. In the case of deviation from the above-said agreement, Brand Avatar will claim
                                    compensation of Rs.5 Lakhs for breach of Trust. If defaulted, we will proceed legally. </br>
                                    <br>Upon termination of your employment with the company, you agree not to solicit any other team members in the
                                    company to the new organization that you are going.</br>


                                    <p> <b>DISPUTE RESOLUTION</b>

                                    </p>

                                    Any differences and disputes arising out of this appointment letter would be settled by arbitration conducted in
                                    accordance with the arbitration and conciliation act 1996 with a person nominated by the company as the sole
                                    arbitrator. The arbitrator shall conclude the arbitration within 30 days from the date of reference and shall
                                    pass an award. The award passed by the arbitrator shall be conclusive and binding on the parties and shall not
                                    be appealable before a court of law.
                                    <b>
                                        <p> <br>GOVERNING LAW AND JURISDICTION</br>
                                    </b></p>
                                    This agreement shall be governed by the laws of the Republic of India and courts in Chennai have exclusive
                                    jurisdiction over this agreement.
                                    <b>
                                        <p> <br>RETIREMENT AGE </br>
                                    </b></p>
                                    The general Retirement for employees in the Company is <b>Fifty-Eight (58) years.</b>
                                    <p style=""><b>Yours faithfully,</b> <br />
                                    <p style="margin-top:0px"><b>For Brand Avatar LLP</b> <br />
                                    <div style="height:50px;width:100px">
                                        <img src="{{ URL::asset('assets/images/appoinment/sign2.png') }}" class="" alt="user-pic" style="height:100%;width:100%;">
                                    </div>
                                    <p><b>(Hemachandran L)</br>
                                            Founder and CEO of Brand Avatar LLP
                                        </b>

                                        <hr>
                                    <p>
                                        I <b>Xyz S,</b> have read <b>ANNEXURE A & B,</b> understood, and accept the appointment upon the terms
                                        and conditions as outlined in this appointment letter for my position at <b>Brand Avatar LLP.</b>
                                    </p>
                                    </hr>
                                    <div style="display: flex;justify-content:space-between ;">
                                        <span style="text-align: left;font-size:15px;float: left;">SIGN:
                                        </span>
                                        <span style="text-align: right;font-size:15px;float: right;margin-right: 80px;">DATE:
                                        </span>
                                    </div>
                                    <hr style=" margin-top: 10px;">
                                    <div class="divFooter" style="text-align:center;font-size: 13px;"> <span> <b>Registered Office Address</b> – Brand
                                            Avatar LLP, No-01, Kandasamy Street, Chandrabagh
                                            Avenue Extn, Radhakrishnan Salai, Mylapore, Chennai, Tamilnadu -600 004.</span></div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#indicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-secondary rounded-circle" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#indicators" data-bs-slide="next">
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
                            <table cellspacing="0" cellpadding="0" class="payslip_table" >
                                <tr class="header-row">
                                    <td colspan="8" class="border-less p3">
                                        <div class="header-cotent">

                                            <h6 class="margin-0">Brand Avatar LLP</h6>
                                            <p class="mb-0">NO-01,Kandasamy Street,</p>
                                            <p class="mb-0">Chandrabagh Ave 2nd St, Dr. Radha Krishnan Salai, </p>
                                            <p class="mb-0">Mylapore, Chennai, Tamil Nadu 600004</p>
                                        </div>
                                    </td>
                                    <td colspan="4" class="border-less p3">

                                        <div class="header-img txt-right">
                                            <!-- <img src="" title=""> -->
                                               <img src="{{ URL::asset('assets/images/appoinment/brandavatarlogo.png') }}" class=""  style="height: 40px;width:180px;max-height:100%;" >
                                        </div>


                                    </td>
                                </tr>


                                <tr>
                                    <td colspan="12">
                                        <p class="sub-header txt-center bg-ash text-strong">PAYSLIP FOR THE MONTH OF &ndash;APR-2022</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="bg-ash text-strong">
                                        <p>EMPLOYEE NAME</p>
                                    </td>
                                    <td colspan="3">
                                        <p>xyz</p>
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
                                        <p>xyz</p>
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
                                        <p>xyz</p>
                                    </td>
                                    <td colspan="3" class="bg-ash text-strong">
                                        <p>LOCATION</p>
                                    </td>
                                    <td colspan="3">
                                        <p>xyz</p>
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
                                        <p class="txt-center">This is a computer-generated slip does not require signature</p>
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
