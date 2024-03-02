@extends('layouts.master')
@section('title')
    @lang('translation.settings')
@endsection
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('/assets/css/leave_policy.css') }}">
@endsection
@section('content')
    <div class="mb-0 tw-card mt-30">
        <h6 class="mb-3 text-lg font-semibold text-gray-900">Leave Policy</h6>
        <div id="policy_carousel" class="carousel slide" data-bs-touch="false" data-bs-interval="false">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="main-page">
                        <div class="sub-page">
                            <div style="display: flex; justify-content:space-between; margin-bottom:12px">
                                <h1>Policy</h1>
                                <img src="../" style="border:1px solid black" alt="Image Not Found">
                            </div>
                            <table class="dunamis_leavePolicy">
                                <tbody>
                                    <tr class="border-yellow-t-b">
                                        <td colspan="1" class="text-yellow ">
                                            <h6>Name of the Policy</h6>
                                        </td>
                                        <td colspan="3" class="">
                                            <span class="text-bolder "> Leave Policy</p>
                                        </td>
                                    </tr>
                                    <tr class="border-yellow-t-b">
                                        <td colspan="1" class="text-yellow ">
                                            <h6>Version Number</h6>
                                        </td>
                                        <td colspan="3" class="">
                                            <p>HR/LEAVE/2021/02</p>
                                        </td>
                                    </tr>
                                    <tr class="border-yellow-t-b">
                                        <td colspan="1" class="text-yellow ">
                                            <h6>Version Date</h6>
                                        </td>
                                        <td colspan="3" class="">
                                            <p>01January 2021</p>
                                        </td>
                                    </tr>
                                    <tr class="border-yellow-t-b">
                                        <td colspan="1" class="text-yellow ">
                                            <h6>Status</h6>
                                        </td>
                                        <td colspan="3" class="">
                                            <p>Final</p>
                                        </td>
                                    </tr>
                                    <tr class="border-yellow-t-b">
                                        <td colspan="1" class="text-yellow ">
                                            <h6>Policy Owner</h6>
                                        </td>
                                        <td colspan="3" class="">
                                            <p>Managing Director</p>
                                        </td>
                                    </tr>
                                    <tr class="border-yellow-t-b">
                                        <td colspan="1" class="text-yellow ">
                                            <h6>Responsibility Matrix</h6>
                                        </td>
                                        <td colspan="3" class="">
                                            <p class="">HR Department: Custodian of Policy, Version Control,
                                                Adhoc Compliance
                                                Monitoring, Maintaining Leave Register</p>
                                            <p class="">Approving Authority: Reporting Manager</p>
                                        </td>
                                    </tr>
                                    <tr class="border-yellow-t-b">
                                        <td colspan="1" class="text-yellow " style="vertical-align:initial;">
                                            <h6>General Guidelines</h6>
                                        </td>
                                        <td colspan="3" class="">
                                            <ul>
                                                <li>
                                                    Awareness and understanding of the policy shall be the responsibility of
                                                    eachemployee</li>
                                                <li>
                                                    Assuring compliance of the policy is the responsibility of Reporting
                                                    Manager/ Head of the Business/Function
                                                </li>
                                                <li>
                                                    The Calendar year system will be followed in all leavecategories
                                                </li>
                                                <li> All 'leaves' should necessarily have prior approval of the Reporting
                                                    Manager before it is availed</li>
                                                <li> Any planned Leave must be applied at least one day in advance. All
                                                    employees are expected to obtain prior sanction before proceeding on
                                                    leave. If prior permission cannot be obtained in person then permission
                                                    can be obtained over email or phone.Any leave taken without prior
                                                    approval will be treated as Leave without Pay / Loss of Pay (LWP/LOP).
                                                    Leave will be treated as unauthorized absence if it is not subsequently
                                                    sanctioned by the Reporting Manager.</li>
                                                <li>
                                                    In case of leave without prior approval, as in an emergency,
                                                    intimation should be sent by phone, or e-mail and the same should be
                                                    regularized with proper approval immediately on resumption ofduty.
                                                </li>
                                                <li> All leaves must be planned and intimated in advance (except during
                                                    exigencies), such that it does not affect day-to-day work. If there is
                                                    neither prior intimation nor any communication for seven or more days of
                                                    absence, the organization holds the right to terminate service for ‘job
                                                    abandonment’ and the employee may not be eligible for rehire. Salary
                                                    will also be withheld with immediate effect from the date ofabsence.
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr class="border-yellow-t-b">
                                        <td colspan="1" class="text-yellow ">
                                            <p>Applicability</p>
                                        </td>
                                        <td colspan="3" class="">
                                            <p>This policy applies to all employees working for Dunamis Machines.</p>
                                        </td>
                                    </tr>
                                    <tr class="border-yellow-t-b">
                                        <td colspan="1" class="text-yellow "
                                            style="padding-top:1.6em;padding-bottom:1.6em;vertical-align:initial">
                                            <h6>Terms</h6>
                                        </td>
                                        <td colspan="3" class="" style="padding-top:1.6em;padding-bottom:1.6em">
                                            <ol type="A"
                                                style="list-style: upper-alpha;padding-left:.8em;padding-bottom:.7em">
                                                <li style="padding-bottom:1.2em">
                                                    <p class="text-bolder" style="padding-left:.8em;padding-bottom:.7em">
                                                        Type of Leaves (Per Calendar Year)</p>
                                                    <ol style="list-style:none; padding-left:3em">
                                                        <li>
                                                            <p>Earned Leave – 15 days</p>

                                                        </li>
                                                        <li>
                                                            <p>Maternity Leave – 26 weeks (as per the Maternity Benefits
                                                                Act)
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <p>
                                                                Adoption Leave – 12 weeks
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <p>
                                                                Paternity Leave – 15 days
                                                            </p>
                                                        </li>
                                                    </ol>

                                                </li>

                                                <li>
                                                    <p class="text-bolder" style="padding-left:.8em;padding-bottom:.7em">
                                                        Core and Stateholidays</p>
                                                    <ol style="list-style:none;">
                                                        <li>
                                                            <p>Dunamis Machines will have 9 holidays per annum classified as
                                                                Core, Centre or State and Optional Holidays distributed as
                                                                below.</p>
                                                        </li>

                                                        <li style="padding:.7em 0 .7em 3em">
                                                            <p>Core Holidays – 5 days</p>
                                                            <p>Centre/ State Holidays – 4 days </p>
                                                        </li>

                                                        <li>
                                                            <p>The list of Core, Center and Optional holidays for a calendar
                                                                year shall be announced prior to beginning of the new
                                                                calendar year.</p>
                                                        </li>
                                                    </ol>

                                                </li>
                                            </ol>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="carousel-item ">
                    <div class="main-page">
                        <div class="sub-page">
                            <div style="display: flex; justify-content:space-between; margin-bottom:12px">
                                <h1>Policy</h1>
                                <img src="../" style="border:1px solid black" alt="Image Not Found">
                            </div>
                            <table class="dunamis_leavePolicy">
                                <tbody>
                                    <tr>
                                        <td colspan="4">
                                            <ol style="">
                                                <li>
                                                    <p class="text-bolder" style="padding-left:.8em;padding-bottom:.7em">
                                                        C. Earnedleave</p>
                                                    <ol style="list-style-type:decimal;padding-left:4em;padding-bottom:1em;"
                                                        type="1">
                                                        <li>
                                                            <p>All employees will be eligible for 15 (Fifteen) days of
                                                                Earned
                                                                leaves (Paid Leaves) perannum</p>
                                                        </li>

                                                        <li style="padding:.8em 0">
                                                            <p>
                                                                All new joiners will be eligible to avail Earned Leave on
                                                                completion of one year (240 days) in the organization from
                                                                their
                                                                date ofjoining.
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <p>
                                                                Earned Leaves will be credited at the rate of 1.25 days on a
                                                                monthlybasis.
                                                            </p>
                                                        </li>
                                                    </ol>

                                                </li>
                                            </ol>
                                            <ol style="padding-top:1.5em">
                                                <li>
                                                    <p class="text-bolder" style="padding-bottom:1em">
                                                        D. Maternity leave</p>
                                                    <ol style="list-style-type:decimal;padding-left:4em;padding-bottom:1em;"
                                                        type="1">
                                                        <li>
                                                            <p> As per the Maternity Benefit Act, all women employees are
                                                                eligible
                                                                to avail twenty-six weeks of Maternity leave for the birth
                                                                of their
                                                                first two children. Maternity leave for children beyond the
                                                                first
                                                                two will continue to be twelve weeks. The employee will be
                                                                eligible
                                                                for the full salary and benefits during this period ofleave.
                                                            </p>
                                                        </li>

                                                        <li style="padding:.8em 0">
                                                            <p>
                                                                In addition to the twenty-six weeks of maternity leave
                                                                (mentioned
                                                                above), an employee can avail extended leave by utilizing
                                                                their
                                                                leave balance (Earned leave /Sick Leave) or leave withoutpay
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <p>
                                                                As per the Maternity Benefit Act, 1961, a woman employee
                                                                will be
                                                                entitled to maternity benefits if she has worked in the
                                                                organization
                                                                for a period of not less than eighty days in the twelve
                                                                months
                                                                preceding the date of her expected delivery (section-5[2]
                                                                ofAct)
                                                            </p>
                                                        </li>
                                                        <li style="padding:.8em 0">
                                                            <p>
                                                                Not more than eight weeks leave, of the twenty six weeks,
                                                                can be
                                                                availed prior to the date of delivery for the birth of first
                                                                two
                                                                children and not more than six weeks leave, of the twelve
                                                                weeks, can
                                                                be availed prior to the date of delivery for the birth of
                                                                children
                                                                beyond the firsttwo.
                                                            </p>
                                                        </li>

                                                        <li>
                                                            <p>
                                                                In case of miscarriage, an employee can avail leave as per
                                                                the
                                                                Maternity Benefits Act, 1961 for a maximum period of 6 weeks
                                                                immediately following the day of miscarriage and should
                                                                produce
                                                                medical certificates supporting thecondition.
                                                            </p>
                                                        </li>
                                                        <li style="padding:.8em 0">
                                                            <p>
                                                                In case of illness arising out of pregnancy, delivery,
                                                                premature
                                                                birth of child or miscarriage , an employee will be entitled
                                                                for
                                                                leave (max period of one month) on production of proof
                                                                prescribed ,
                                                                in addition to the period of leave allowed with the wages as
                                                                per
                                                                Maternity Benefits Act and mentionedabove.
                                                            </p>
                                                        </li>
                                                    </ol>

                                                </li>
                                            </ol>
                                            <ol style="">
                                                <li>
                                                    <p class="text-bolder" style="padding-left:.8em;padding-bottom:.7em">
                                                        E. Paternityleave</p>
                                                    <ol style="list-style-type:decimal;padding-left:4em;padding-bottom:1em;"
                                                        type="1">
                                                        <li>
                                                            <p>
                                                                A total number of seven days leave can be availed as
                                                                Paternity leave to enable the employee to be with his wife
                                                                and child during and after the time ofdelivery.
                                                            </p>
                                                        </li>

                                                        <li style="padding:.8em 0">
                                                            <p>
                                                                This leave can be availed within a period of one month
                                                                either 15 days prior or 15 days post the birth of thechild
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <p>
                                                                The leave can be staggered over four times during the
                                                                course of the above said period and the date of absence has
                                                                to be mentioned in the leaverequest.
                                                            </p>
                                                        </li>
                                                        <li style="padding:.8em 0">
                                                            <p>
                                                                This leave is applicable for the birth of the first two
                                                                childrenonly.
                                                            </p>
                                                        </li>
                                                    </ol>

                                                </li>
                                            </ol>

                                            <ol style="">
                                                <li>
                                                    <p class="text-bolder" style="padding-left:.8em;padding-bottom:.7em">
                                                        F.Adoptionleave</p>
                                                    <ol style="list-style:none;padding-left:4em;padding-bottom:1em;"
                                                        type="1">
                                                        <li>
                                                            <p>
                                                                Women employees who go in for adoption of children or a
                                                                ‘commissioning mother’ can avail 'adoption leave' for a
                                                                maximum of –twelve weeks from the date of adopting a child
                                                                below the age of three months.
                                                            </p>
                                                        </li>
                                                    </ol>
                                                </li>
                                            </ol>

                                            <p style="padding:4em 0">
                                                *” commissioning mother “is defined as a biological mother who uses her egg
                                                to create an embryo planted in any other woman.
                                            </p>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="carousel-item ">
                    <div class="main-page">
                    
                        <div class="sub-page">
                            <div style="display: flex; justify-content:space-between; ">
                                <h1>Policy</h1>
                                <img src="../" style="border:1px solid black" alt="Image Not Found">
                            </div>
                            <table class="dunamis_leavePolicy">
                                <tbody>
                                    <tr>
                                        <td colspan="4">
                                            <ol style="">
                                                <li>
                                                    <p class="text-bolder" style="padding-left:.8em;padding-bottom:.7em">
                                                        G. Sabbatical
                                                    </p>
                                                    <ol style="list-style-type:decimal;padding-left:4em;" type="1">
                                                        <li>
                                                            <p>Employees will not be permitted to take a sabbatical from
                                                                work.</p>
                                                        </li>
                                                    </ol>
                                                </li>
                                            </ol>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <ol style="">
                                                <li>
                                                    <p class="text-bolder" style="padding-left:.8em;padding-bottom:.7em">
                                                        H. Leave Without Pay(LWP)
                                                    </p>
                                                    <ol style="list-style-type:decimal;padding-left:4em;" type="1">
                                                        <li>
                                                            <p> Leave Without Pay is a benefit exclusively extended to
                                                                employees who need serious and continuous medical attention
                                                                or for any genuine reason necessitating a leave of absence
                                                                from work.
                                                            </p>
                                                        </li>

                                                        <li style="padding:.8em 0">
                                                            LWP can be taken provided there is no leave (EL) balance
                                                            in employee’s leaveaccount.
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <p>
                                                                Employee must produce a request to the respective
                                                                Reporting Manager by necessary medical documents issued by a
                                                                registered medicalpractitioner.
                                                            </p>
                                                        </li>


                                                        <li style="padding:.8em 0">
                                                            Employee must submit the request at least 5 working days
                                                            in advance to get approval from the Reporting Manger and the
                                                            Managing Director.
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <p>
                                                                Management reserves the right to ask employees to go
                                                                through a certified medicalcheck-up.
                                                            </p>
                                                        </li>

                                                    </ol>
                                                </li>
                                            </ol>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <ol style="">
                                                <li>
                                                    <p class="text-bolder" style="padding-left:.8em;padding-bottom:.7em">
                                                        I. Work fromhome
                                                    </p>
                                                    <ol style="list-style-type:decimal;padding-left:4em;" type="1">
                                                        <li>
                                                            <p> Employees may be granted a maximum period of 7 days in a
                                                                year to work from home for medical or any genuine reason
                                                                necessitating the employee to work fromhome.</p>
                                                        </li>
                                                        <li style="padding-top:.7em">
                                                            <p>While working from home, a time sheet stating the numbers of
                                                                hours worked and the details of work performed needs to be
                                                                maintained by the employee. Upon returning to work from
                                                                office, the time sheet needs to be approved by the Reporting
                                                                Manager and the Business/FunctionalHead.

                                                            </p>

                                                        </li>
                                                    </ol>
                                                </li>
                                            </ol>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <ol style="">
                                                <li>
                                                    <p class="text-bolder" style="padding-left:.8em;padding-bottom:.7em">
                                                        J. Leave Accumulation and Encashment
                                                    </p>
                                                    <ol style="list-style-type:decimal;padding-left:4em;" type="1">
                                                        <li style="padding-bottom: 0.7em">
                                                            <p class="text-bolder">
                                                                LeaveAccumulation:
                                                            </p>
                                                            <p style="padding-top:.4em;padding-left:1em">
                                                                Earned Leave is subjected to a limit of 15 days per annum
                                                                and
                                                                the maximum Earned leave accumulation limit for an employee
                                                                is
                                                                set as 45days
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <p class="text-bolder">
                                                                Leave Encashment
                                                            </p>
                                                            <p style="padding-top:.4em;padding-left:1em">
                                                                Earned leave will be the only leave category that will be
                                                                considered for leave encashment. Earned leave encashment is
                                                                applicable only during the exit of an employee and will be
                                                                limited to the balance Earned leave held by the employee at
                                                                the
                                                                time ofexit.
                                                            </p>
                                                        </li>
                                                    </ol>
                                                </li>
                                            </ol>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="4">
                                            <ol style="">
                                                <li>
                                                    <p class="text-bolder" style="padding-left:.8em;padding-bottom:.7em">
                                                        K. Compensatory off/Allowance
                                                    </p>
                                                    <ol style="list-style-type:decimal;padding-left:4em;" type="1">
                                                        <li style="padding-bottom: 0.7em">
                                                            <p class="" style="padding-bottom: 0.7em">
                                                                Depending on the requirement of the business, employees
                                                                may
                                                                be required to work on a holiday. In such instances, the
                                                                following shall beapplicable:
                                                            </p>
                                                            <ol style="padding-left:3em;">
                                                                <li style="padding-bottom: 0.7em">
                                                                    <p class="">
                                                                        i. Employees who work for a full day on Sunday shall
                                                                        be eligible to take a compensatory off. In case of
                                                                        compensatory-off, this needs to be availed within 30
                                                                        calendardays.
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p class="">
                                                                        ii. If the working hours of an employee are less
                                                                        than eight hours, the employee will not be eligible
                                                                        for Compensatory Off.
                                                                    </p>
                                                                </li>
                                                            </ol>
                                                        </li>
                                                        <li style="padding-bottom: 0.7em">
                                                            <p class="">
                                                                On a State/National level holiday, if an employee is
                                                                required to work then he/she should have
                                                                prior approval from the Function Head and the Managing
                                                                Director.Anyemployee working on a State level holiday (with
                                                                due approvals) will
                                                                receive double wages for that day.

                                                            </p>
                                                        </li>
                                                        <li style="padding-bottom: 0.7em">
                                                            <p class="" style="padding-bottom: 0.7em">
                                                                Administration of Compensatory-off
                                                            </p>
                                                            <ol style="padding-left:3em;">
                                                                <li style="padding-bottom: 0.7em">
                                                                    <p class="">
                                                                        i. Employees must obtain prior approval from the
                                                                        Reporting Manager availing a Compensatory Off and it
                                                                        should be communicated to the respective Location
                                                                        HR.
                                                                    </p>
                                                                </li>
                                                                <li style="padding-bottom: 0.7em">
                                                                    <p class="">
                                                                        ii. The HR Operations Team shall make note of the
                                                                        compensatory offof the employees.
                                                                    </p>
                                                                </li>
                                                            </ol>
                                                        </li>
                                                    </ol>
                                                </li>
                                            </ol>
                                        </td>

                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="carousel-item ">
                    <div class="main-page">
                        <div style="display: flex; justify-content:space-between; margin-bottom:12px">
                            <h1>Policy</h1>
                            <img src="../" style="border:1px solid black" alt="Image Not Found">
                        </div>
                        <div class="sub-page">
                            <table class="dunamis_leavePolicy">
                                <tbody>
                                    <tr>
                                        <td colspan="4">
                                            <ol style="">
                                                <li>
                                                    <p class="text-bolder" style="padding-left:.8em;padding-bottom:.7em">
                                                        L. Administration of leave
                                                    </p>
                                                    <ol style="list-style-type:decimal;padding-left:4em;" type="1">
                                                        <li>
                                                            <p>
                                                                All leave application and approval are managed through
                                                                the Leave module in HRIS.
                                                            </p>
                                                        </li>
                                                        <li style="padding-top:.7em;padding-bottom:.7em">
                                                            <p>
                                                                When an employee leaves the organization before
                                                                completion of one year of service, the EL would be
                                                                calculated for settlement on a proportionatebasis.
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <p>
                                                                Employees are encouraged to avail their leaves during the
                                                                year considering the business impact & its continuity.
                                                                Employees are advised to spread their utilization of leaves
                                                                across the first and the second half of the year to help
                                                                curtail year-end leaveissues.
                                                            </p>
                                                        </li>
                                                        <li style="padding-top:.7em;padding-bottom:.7em">
                                                            <p>
                                                                Holidays interspersed between leaves will not be construed
                                                                asleave.
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <p>
                                                                When an employee wants to avail leave during notice
                                                                period, he/she must get the approval of the reporting
                                                                manager and Managing Director. If approval is not given, it
                                                                will be considered as
                                                                Loss of Pay.Only Earned leaves can be availed while serving
                                                                notice period,with necessary approval.


                                                            </p>
                                                        </li>

                                                    </ol>
                                                </li>
                                            </ol>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="border-yellow-t-b" style="padding:1em 0">
                                            <p class="text-yellow text-bolder" style="padding-bottom: 0.7em">
                                                Approval Matrix </p>

                                            <p class="text-bolder">
                                                The approvals as per the matrix are applicable only for the exceptions to
                                                the policy and are permitted only when the requirement for the same can be
                                                clearly substantiated.
                                            </p>
                                            <div style="padding: 0.5em 1em">

                                                <table class="controls_table dunamis_leavePolicy"
                                                    style="padding:.5em 1em">
                                                    <tbody>
                                                        <thead>
                                                            <tr>
                                                                <th colspan="1">Policy exceptions</th>
                                                                <th colspan="1">Initiated by</th>
                                                                <th colspan="1">Recommended by</th>
                                                                <th colspan="1">Approved by</th>
                                                            </tr>
                                                        </thead>
                                                        <tr>
                                                            <td colspan="1">Deviation in LeavePolicy</td>
                                                            <td colspan="1">Employee</td>
                                                            <td colspan="1">Head ofBusiness/Function</td>
                                                            <td colspan="1">Managing Director</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>


                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="border-yellow-t-b" style="padding:1em 0">
                                            <p class="text-yellow text-bolder" style="padding-bottom: 0.7em">
                                                Version Control
                                            </p>
                                            <div style="padding: 0.5em 1em">

                                                <table class="controls_table dunamis_leavePolicy"
                                                    style="padding:.5em 1em">
                                                    <tbody>
                                                        <thead>
                                                            <tr>
                                                                <th colspan="1">Version Number</th>
                                                                <th colspan="1">Roll out date</th>
                                                                <th colspan="1">Changes made by</th>
                                                                <th colspan="1">Approved by</th>
                                                            </tr>
                                                        </thead>
                                                        <tr>
                                                            <td colspan="1">02</td>
                                                            <td colspan="1">01-01-2021 </td>
                                                            <td colspan="1">ArdensHR Services
                                                                Augustin Raj A-MD and CEO
                                                            </td>
                                                            <td colspan="1">Dunamis Machines
                                                                Benjamin Doss A – Managing Director
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>


                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="border-yellow-t-b" style="padding:1em 0">
                                            <p class="text-yellow text-bolder" style="padding-bottom: 0.7em">
                                                Version Control
                                            </p>

                                            <p>
                                                Printed copies of this document may not be the latest version and should not
                                                be relied upon. Please check the electronic version posted on intranet to
                                                make sure that you have the most current version. Also, please contact your
                                                manager or Human Resources if you require any further information.
                                            </p>



                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="" style="padding:1em 0">
                                            <p class="text-center text-yellow text-bolder" style="padding-top:10em;">
                                                * &nbsp; * &nbsp; *
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev " type="button" data-bs-target="#policy_carousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-secondary rounded-circle" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#policy_carousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-secondary rounded-circle" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>

            </div>
        </div>

    </div>
@endsection
