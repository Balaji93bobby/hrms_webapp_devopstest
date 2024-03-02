@extends('layouts.master')
@section('title')
    @lang('translation.settings')
@endsection
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('/assets/css/leave_policy.css') }}">
@endsection
@section('content')
    <div class="card mt-30 mb-0">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-2">
                    <h6> Leave Policy Explanation</h6>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <div id="policy_carousel" class="carousel slide" data-bs-touch="false" data-bs-interval="false">
                        <div class="carousel-inner">
                            <div class="carousel-item  active ">
                                <div class="main-page">
                                    <div class="sub-page">
                                        <table class="policy_table  ">
                                            <tbody>
                                                <tr class="">
                                                    <td colspan="8" align="right" class="pad-bottom-25">
                                                        <div class="" style="height: 40px;width:225px;">
                                                            <img src="{{ URL::asset('assets/images/client_logos/vasa/logo_priti.jpg') }}"
                                                                class="" alt="Logo"
                                                                style="height:100%;width:100%">

                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8" align="" class=" pad-bottom-25">
                                                        <table class="policy-version-table">
                                                            <tbody>
                                                                <tr class="border-none-left-right border-bottom-top">
                                                                    <td colspan="4" align="" class=" text-strong ">
                                                                        <p class="">
                                                                            Name of the Policy
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="4" align="" class="text-strong">
                                                                        <p class="">
                                                                            Attendance & Leave Policy
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                                <tr class="bg-blue">
                                                                    <td colspan="4" align=""
                                                                        class="pad-top-5 text-strong">
                                                                        <p class="">
                                                                            Version Number
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="4" align="" class="pad-top-5">
                                                                        <p class=" ">
                                                                            HR/Attendance & Leave/2022/01
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                                <tr class="">
                                                                    <td colspan="4" align=""
                                                                        class="pad-top-5 text-strong">
                                                                        <p class="">
                                                                            Version Date
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="4" align="" class="pad-top-5">
                                                                        <p class=" ">
                                                                            01 April 2022
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                                <tr class="bg-blue">
                                                                    <td colspan="4" align=""
                                                                        class="pad-top-5 text-strong">
                                                                        <p class=" ">
                                                                            Status
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="4" align="" class="pad-top-5">
                                                                        <p class="">
                                                                            Final
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                                <tr class="">
                                                                    <td colspan="4" align=""
                                                                        class="pad-top-5 text-strong">
                                                                        <p class="">
                                                                            Policy Owner
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="4" align="" class="pad-top-5">
                                                                        <p class="">
                                                                            Group CFO
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                                <tr class="bg-blue">
                                                                    <td colspan="4" align=""
                                                                        class="pad-top-5 text-strong">
                                                                        <p class="">
                                                                            Responsibility Matrix
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="4" align="" class="pad-top-5">
                                                                        <p class="   ">
                                                                            HR Department: Custodian of Policy, Version
                                                                            Control, Adhoc Compliance Monitoring,
                                                                            Maintaining Leave Register


                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                                <tr class="border-b">
                                                                    <td colspan="4" align=""
                                                                        class="pad-top-5 text-strong">
                                                                        <p class=" ">
                                                                            Approving Authority
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="4" align="" class="pad-top-5">
                                                                        <p class="">
                                                                            Reporting Manager
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                            </tbody>

                                                        </table>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8" align="" class="pad-bottom-15">
                                                        <span class="border-b   text-strong">
                                                            Purpose:
                                                        </span>
                                                        <p class="pad-top-10">
                                                            The focus of this policy is to properly manage and track the
                                                            attendance and leaves of all the employees of the Priti Sales
                                                            Corporation .
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8" align="" class="pad-bottom-15">
                                                        <span class="border-b   text-strong">
                                                            Scope:
                                                        </span>
                                                        <p class="pad-top-10">
                                                            This policy applies to all the employees of Priti Sales
                                                            Corporation , across all the departments and regardless of the
                                                            job
                                                            position they hold.
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8" align="" class="pad-bottom-15">
                                                        <span class="border-b   text-strong">
                                                            Applicability
                                                        </span>
                                                        <p class="pad-top-10">
                                                            This policy applies to all employees working for Priti Sales
                                                            Corporation
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8" align="" class="pad-bottom-15">
                                                        <span class="border-b   text-strong">
                                                            General Guidelines:
                                                        </span>

                                                    </td>
                                                </tr>
                                                <tr class="
                                                ">
                                                    <td colspan="1" align="" class="pad-bottom-15 ">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-bottom-15">
                                                        <p>Awareness and understanding of the policy shall be the
                                                            responsibility of each employee.</p>
                                                    </td>

                                                </tr>
                                                <tr class="
                                                ">
                                                    <td colspan="1" align="" class="pad-bottom-15 ">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-bottom-15">
                                                        <p>Assuring compliance with the policy is the responsibility of
                                                            the Reporting Manager/ Head of the Business/Function.</p>

                                                    </td>

                                                </tr>
                                                <tr class="
                                                ">
                                                    <td colspan="1" align="" class="pad-bottom-15 ">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-bottom-15">
                                                        <p>The Financial year system will be followed in all leave
                                                            categories.</p>

                                                    </td>

                                                </tr>
                                                <tr class="
                                                ">
                                                    <td colspan="1" align="" class="pad-bottom-15 ">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-bottom-15">
                                                        <p>Any planned leave must be applied in the leave application
                                                            form. Leave will be treated as Leave without Pay / Loss of Pay
                                                            (LWP/LOP)/ Unauthorised Absence if it is not subsequently
                                                            approved by their reporting manager in the application form.</p>

                                                    </td>

                                                </tr>
                                                <tr class="
                                                ">
                                                    <td colspan="1" align=""
                                                        class=" pad-bottom-15  pad-right-10">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-bottom-15">
                                                        <p>In case of leave taken without prior approval, as in
                                                            emergency/sick, an employee can raise their leave request in
                                                            leave form and the same should be approved by the Reporting
                                                            Manager.</p>

                                                    </td>

                                                </tr>
                                                <tr class="
                                                ">
                                                    <td colspan="1" align=""
                                                        class=" pad-bottom-15  pad-right-10">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-bottom-15">
                                                        <p>
                                                            All leaves must be planned and intimated in advance (except
                                                            during exigencies), such that it does not affect day-to-day work
                                                        </p>

                                                    </td>

                                                </tr>
                                                <tr class="
                                                ">
                                                    <td colspan="1" align="" class="pad-bottom-15 pad-right-10">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-bottom-15">
                                                        <p>If there is neither prior intimation nor any communication for
                                                            five days the organisation holds the right to treat them as
                                                            abscond, if more than 7 days of absence, the organization holds
                                                            the right to terminate service for ‘job abandonment’ and the
                                                            employee may not be eligible for rehire.</p>

                                                    </td>

                                                </tr>
                                                <tr class="
                                                ">
                                                    <td colspan="1" align=""
                                                        class="pad-bottom-15  pad-right-10">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-bottom-15">
                                                        <p>Salary will also be withheld with immediate effect from the date
                                                            of absence</p>

                                                    </td>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item  ">
                                <div class="main-page">
                                    <div class="sub-page">
                                        <table class="policy_table  ">
                                            <tbody>
                                                <tr>
                                                    <td colspan="8" align="" class="pad-bottom-15">
                                                        <span class="border-b   text-strong">
                                                            Definition:
                                                        </span>
                                                        <p class="pad-top-10">
                                                            <span class="text-strong">
                                                                A. Absenteeism
                                                            </span>
                                                            is referred to as the act of being unable to perform assigned
                                                            tasks in accordance with a specified schedule without prior
                                                            information.

                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8" align="" class="pad-bottom-10">

                                                        <p class="">
                                                            <span class="text-strong">
                                                                B.Tardiness
                                                            </span>
                                                            is considered when the following circumstances happen:

                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr class="
                                                ">
                                                    <td colspan="1" align="" class=" pad-right-10">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="">
                                                        <p>
                                                            When an employee leaves the workplace before the end of the
                                                            shift without the supervisor’s approval.
                                                        </p>
                                                    </td>

                                                </tr>
                                                <tr class="
                                                ">
                                                    <td colspan="1" align="" class="pad-top-5 pad-right-10">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-top-5">
                                                        <p>When an employee fails to report to work at the assigned
                                                            schedule.</p>
                                                    </td>

                                                </tr>
                                                <tr class="
                                                ">
                                                    <td colspan="1" align="" class="pad-top-5 pad-right-10">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-top-5">
                                                        <p>When an employee over breaks and takes extended hours or
                                                            minutes for meals</p>
                                                    </td>

                                                </tr>
                                                <tr class="
                                                ">
                                                    <td colspan="1" align="" class="pad-top-5 pad-right-10">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-top-5 pad-bottom-10">
                                                        <p>When an employee arrives late or past the time of his/her
                                                            scheduled shift.</p>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td colspan="8" align="" class="pad-bottom-10">
                                                        <span class="border-b   text-strong">
                                                            Eligibility Criteria for Absenteeism & Tardiness:
                                                        </span>

                                                    </td>
                                                </tr>
                                                <tr class="
                                                ">
                                                    <td colspan="1" align="" class=" pad-right-10">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="">
                                                        <p>Employees are expected to have one hundred percent attendance as
                                                            much as possible</p>
                                                    </td>

                                                </tr>
                                                <tr class="
                                                ">
                                                    <td colspan="1" align="" class="pad-top-5 pad-right-10">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-top-5">
                                                        <p>Employees can check their attendance in the HR Team – Calendar on
                                                            a daily basis.</p>
                                                    </td>

                                                </tr>
                                                <tr class="
                                                ">
                                                    <td colspan="1" align="" class="pad-top-5 pad-right-10">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-top-5">
                                                        <p>Employees can regularize their attendance on their own through
                                                            the HR Team if there is any leave/permission taken by them.</p>
                                                    </td>

                                                </tr>
                                                <tr class="
                                                ">
                                                    <td colspan="1" align="" class="pad-top-5 pad-right-10">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-top-5 text-strong">
                                                        <p>Employees are eligible to avail of two permissions per month of
                                                            1.5 hours each per permission. More than 4 permissions in a
                                                            month will be considered a half-day LOP.</p>
                                                    </td>

                                                </tr>
                                                <tr class="
                                                ">
                                                    <td colspan="1" align="" class="pad-top-5 pad-right-10">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-top-5">
                                                        <p><span class="text-strong"> NO CALL NO SHOW </span> is subject to
                                                            disciplinary action and grounds
                                                            for termination</p>
                                                    </td>

                                                </tr>
                                                <tr class="
                                                ">
                                                    <td colspan="1" align="" class="pad-top-5 pad-right-10">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-top-5 pad-bottom-10">
                                                        <p> Attendance will be tracked through the Biometric System, and it
                                                            is visible to all the employee’s payslips.</p>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td colspan="8" align="" class="pad-bottom-10">
                                                        <span class="border-b   text-strong">
                                                            C. Attendance Process in HR Team:
                                                        </span>

                                                    </td>
                                                </tr>
                                                <tr class="
                                                ">
                                                    <td colspan="1" align="" class=" pad-right-10">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class=" pad-bottom-10">
                                                        <p>Attendance will be calculated based on the effective tossed
                                                            hours.</p>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td colspan="8" align="" class=" pad-bottom-10">
                                                        <table class="policy-table">
                                                            <tbody>
                                                                <tr class="border-none-left-right border-bottom-top">
                                                                    <td colspan="2" align=""
                                                                        class="text-strong">
                                                                        <p class="">
                                                                            Particulars
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="2" align=""
                                                                        class="text-strong">
                                                                        <p class="">
                                                                            Attendance input
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="2" align=""
                                                                        class="text-strong ">
                                                                        <p class="">
                                                                            Effective Hours
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="2" align=""
                                                                        class=" text-strong">
                                                                        <p class="">
                                                                            Event Type </p>
                                                                    </td>
                                                                </tr>

                                                                <tr class="border-b bg-blue">
                                                                    <td colspan="2" align=""
                                                                        class="pad-top-5 text-strong">
                                                                        <p class=" ">
                                                                            Employees
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="2" align="" class="pad-top-5">
                                                                        <p class="">
                                                                            Bio Matric
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="2" align="" class="pad-top-5">
                                                                        <p class="">
                                                                            8:00 Hrs/ days
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="2" align="" class="pad-top-5">
                                                                        <p class="">
                                                                            Full-Day Present
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                            </tbody>

                                                        </table>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8" align="" class="pad-bottom-10">
                                                        <span class="border-b   text-strong">
                                                            D. Type of Leaves (Per Financial Year)
                                                        </span>

                                                    </td>
                                                </tr>
                                                <tr class="
                                                ">
                                                    <td colspan="1" align="" class=" pad-right-10">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="">
                                                        <p>Sick Leave / Casual Leave – 12 days</p>
                                                    </td>

                                                </tr>
                                                <tr class="
                                                ">
                                                    <td colspan="1" align="" class="pad-top-5 pad-right-10">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-top-5 ">
                                                        <p>Earned Leave – 12 days</p>
                                                    </td>

                                                </tr>
                                                <tr class="
                                                ">
                                                    <td colspan="1" align="" class="pad-top-5 pad-right-10">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-top-5 ">
                                                        <p>Maternity Leave – 26 weeks (as per the Maternity Benefits Act)
                                                        </p>
                                                    </td>

                                                </tr>
                                                <tr class="
                                                ">
                                                    <td colspan="1" align="" class="pad-top-5 ">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-top-5 ">
                                                        <p> Paternity Leave – 5 days (Only ForMales)</p>
                                                    </td>

                                                </tr>
                                                <tr class="
                                                ">
                                                    <td colspan="1" align="" class="pad-top-5">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-top-5 pad-bottom-10 ">
                                                        <p>Compensatory Leave </p>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td colspan="8" align="" class="pad-bottom-15">
                                                        <span class="border-b   text-strong">
                                                            E. Core, Centre, and Optional holidays
                                                        </span>
                                                        <p class="pad-top-10">
                                                            Priti Sales Corporation will have 11 holidays per annum
                                                            classified as Core, Centre, or State as per the holiday list.
                                                        </p>
                                                        <p class="pad-top-10">
                                                            The list of Core, Centre holidays for a calendar year shall be
                                                            announced prior to the beginning of the new calendar year.
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8" align="" class="pad-top-10 pad-bottom-10">
                                                        <span class="border-b   text-strong">
                                                            F. Sick leave
                                                        </span>

                                                    </td>
                                                </tr>
                                                <tr class="
                                                ">
                                                    <td colspan="1" align="" class=" pad-right-10 ">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class=" ">
                                                        <p>Employees are eligible for one day of SL/CL in the same month
                                                            on which he/she joins the company, but the only criteria are
                                                            he/she should join before 15 of the respective months; if not,
                                                            the leave for that month will not be provided.</p>
                                                    </td>

                                                </tr>
                                                <tr class="
                                                ">
                                                    <td colspan="1" align="" class="pad-top-5 pad-right-10 ">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-top-5 ">
                                                        <p>All existing employees of Priti Sales Corporation are
                                                            eligible for 12 (Twelve) days of Sick leave / Casual Leave per
                                                            annum on the 1st of April every year. </p>
                                                    </td>

                                                </tr>
                                                <tr class="
                                                ">
                                                    <td colspan="1" align="" class="pad-top-5 pad-right-10 ">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-top-5 ">
                                                        <p> Employees joining in the middle of the year will be eligible for
                                                            proportionate leave</p>
                                                    </td>

                                                </tr>
                                                <tr class="
                                                ">
                                                    <td colspan="1" align="" class="pad-top-5 pad-right-10  ">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-top-5 ">
                                                        <p> Employees availing more than 2 days of Sick leave / Casual
                                                            Leave will have to produce a medical certificate to support
                                                            their sick / Casual leave request</p>
                                                    </td>

                                                </tr>
                                                <tr class="
                                                ">
                                                    <td colspan="1" align="" class="pad-top-5 pad-right-10 ">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-top-5 ">
                                                        <p> Sick Leave / Casual Leave cannot be carried forward to next
                                                            year.</p>
                                                    </td>

                                                </tr>
                                                <tr class="
                                                ">
                                                    <td colspan="1" align=""
                                                        class="pad-top-5 pad-bottom-15 pad-right-10 ">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-top-5 ">
                                                        <p>
                                                            Sick Leave / Casual Leave of more than 5 days will get prior
                                                            approval from the HR Department
                                                        </p>
                                                    </td>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item  ">
                                <div class="main-page">
                                    <div class="sub-page">
                                        <table class="policy_table  ">
                                            <tbody>



                                                <tr>
                                                    <td colspan="8" align="" class="pad-bottom-10">
                                                        <span class="border-b   text-strong">
                                                            G. Earned leave
                                                        </span>

                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <td colspan="1" align="" class="pad-top-5 pad-right-10  ">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-top-5 ">
                                                        <p>All employees will be eligible for 12 (twelve) days of Earned
                                                            leaves per annum.</p>
                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <td colspan="1" align="" class="pad-top-5 pad-right-10  ">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-top-5 ">
                                                        <p>All new joiners will be eligible to avail of Earned Leave based
                                                            on their date of joining.</p>
                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <td colspan="1" align="" class="pad-top-5 pad-right-10  ">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-top-5 ">
                                                        <p> Earned Leave will be accrued every month. i.e 1 day per month
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <td colspan="1" align="" class="pad-top-5  pad-right-10 ">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-top-5 ">
                                                        <p>Earned Leave can be carried forward to next year and the maximum
                                                            accumulation will be 24 days and every 2 years accumulated
                                                            earned leave will be encashed.</p>
                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <td colspan="1" align=""
                                                        class="pad-top-5  pad-right-10 pad-bottom-10  ">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-top-5  pad-bottom-10 ">
                                                        <p>Earned Leave taken more than 5 days will get the prior approval
                                                            from the HR Department.</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8" align="" class="pad-bottom-10">
                                                        <span class="border-b   text-strong">
                                                            H. Compensatory Leave
                                                        </span>

                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <td colspan="1" align=""
                                                        class=" pad-right-10  pad-bottom-10 ">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class=" pad-bottom-10">
                                                        <p>This new policy states that if any of our employees worked,
                                                            travelled, or took a business trip on a week off or holiday,
                                                            they will be entitled to compensatory leave (paid leave) within
                                                            60 days of the date of the actual work/travel)</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8" align="" class="pad-bottom-5">
                                                        <span class="  text-strong">
                                                            Leave Accumulation
                                                        </span>

                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <td colspan="1" align="" class="pad-top-5 pad-right-10  ">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-top-5 ">
                                                        <p>Leave Accumulation: Management</p>
                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <td colspan="1" align="" class="pad-top-5 pad-right-10  ">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-top-5 ">
                                                        <p> Earned Leave is subjected to a limit of 12 days per annum and
                                                            the maximum earned leave accumulation limit for an employee is
                                                            set as 22 days up to 2 years</p>
                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <td colspan="1" align=""
                                                        class="pad-top-5 pad-bottom-10 pad-right-10  ">
                                                        ⮚
                                                    </td>
                                                    <td colspan="7" align="" class="pad-top-5 pad-bottom-10 ">
                                                        <p> Un-availed Sick leaves/ Casual leaves at the end of the
                                                            financial year would not be carried forward to the subsequent
                                                            year.</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8" align="" class="pad-bottom-10">
                                                        <span class="  text-strong">
                                                            Approval Matrix
                                                        </span>

                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <td colspan="8" align=""
                                                        class="pad-right-10 pad-bottom-10 ">
                                                        <p>
                                                            The approvals as per the matrix are applicable only for the
                                                            exceptions to the policy and are permitted only when the
                                                            requirement
                                                            for the same can be clearly substantiated
                                                        </p>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td colspan="8" align="" class=" pad-bottom-25">
                                                        <table class="policy-table">
                                                            <tbody>
                                                                <tr class="border-none-left-right border-bottom-top">
                                                                    <td colspan="2" align=""
                                                                        class="text-strong">
                                                                        <p class="">
                                                                            Policy Exceptions
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="2" align=""
                                                                        class="text-strong">
                                                                        <p class="">
                                                                            Initiated By
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="2" align=""
                                                                        class="text-strong ">
                                                                        <p class="">
                                                                            Recommended By
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="2" align=""
                                                                        class=" text-strong">
                                                                        <p class="">
                                                                            Approved By </p>
                                                                    </td>
                                                                </tr>

                                                                <tr class="border-b bg-blue">
                                                                    <td colspan="2" align=""
                                                                        class="pad-top-5 text-strong">
                                                                        <p class=" ">
                                                                            Deviation in Leave
                                                                            Policy

                                                                        </p>
                                                                    </td>
                                                                    <td colspan="2" align="" class="pad-top-5">
                                                                        <p class="">
                                                                            Employee

                                                                        </p>
                                                                    </td>
                                                                    <td colspan="2" align="" class="pad-top-5">
                                                                        <p class="">
                                                                            Head of Business
                                                                            /Function
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="2" align="" class="pad-top-5">
                                                                        <p class="">
                                                                            Group CFO
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                            </tbody>

                                                        </table>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8" align="" class=" pad-bottom-25">
                                                        <p class="text-strong">Version Control</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8" align="" class=" pad-bottom-25">
                                                        <table class="policy-table">
                                                            <tbody>
                                                                <tr class="border-none-left-right border-bottom-top">
                                                                    <td colspan="2" align=""
                                                                        class="text-strong">
                                                                        <p class="">
                                                                            Version Number
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="2" align=""
                                                                        class="text-strong">
                                                                        <p class="">
                                                                            Roll Out Date
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="2" align=""
                                                                        class="text-strong ">
                                                                        <p class="">
                                                                            Changes Made by
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="2" align=""
                                                                        class=" text-strong">
                                                                        <p class="">
                                                                            Approved By </p>
                                                                    </td>
                                                                </tr>

                                                                <tr class="border-b">
                                                                    <td colspan="2" align=""
                                                                        class="pad-top-5 text-strong">
                                                                        <p class=" ">
                                                                            01
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="2" align="" class="pad-top-5">
                                                                        <p class="">
                                                                            1st April 2022
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="2" align="" class="pad-top-5">
                                                                        <p class="">
                                                                            ABShrms
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="2" align="" class="pad-top-5">
                                                                        <p class="">
                                                                            Vasa – CFO
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                                <tr class="border-b ">
                                                                    <td colspan="2" align=""
                                                                        class="pad-top-5 text-strong">
                                                                        <p class=" ">
                                                                            02
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="2" align="" class="pad-top-5">
                                                                        <p class="">
                                                                            28th Jan 2023
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="2" align="" class="pad-top-5">
                                                                        <p class="">
                                                                            ABShrms
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="2" align="" class="pad-top-5">
                                                                        <p class="">
                                                                            Vasa – CFO
                                                                        </p>
                                                                    </td>
                                                                </tr>

                                                                <tr class="border-none-left-right border-b ">
                                                                    <td colspan="2" align=""
                                                                        class="text-strong">
                                                                        <p class="">
                                                                            &nbsp;
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="2" align=""
                                                                        class="text-strong">
                                                                        <p class="">
                                                                            &nbsp;
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="2" align=""
                                                                        class="text-strong ">
                                                                        <p class="">
                                                                            &nbsp;
                                                                        </p>
                                                                    </td>
                                                                    <td colspan="2" align=""
                                                                        class=" text-strong">
                                                                        <p class="">
                                                                            &nbsp;
                                                                        </p>
                                                                    </td>
                                                                </tr>

                                                            </tbody>

                                                        </table>

                                                    </td>
                                                </tr>
                                                <tr>

                                                    <td colspan="8" align=""
                                                        class="pad-top-bottom-5 border-bottom-top">
                                                        <p class="">
                                                            Printed copies of this document may not be the
                                                            latest version and should not be relied upon.
                                                            Also, please contact your manager or Human
                                                            Resources if you require any further information
                                                        </p>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8" style="padding-top: 50px" align="center"
                                                        class=" ">
                                                        * &nbsp; * &nbsp; *
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <button class="carousel-control-prev " type="button" data-bs-target="#policy_carousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon bg-secondary rounded-circle"
                                    aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#policy_carousel"
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
