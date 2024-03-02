<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

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

        .payslip_table tr,
        td {
            border: 2px solid #004b81;

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


        .margin-0 {
            margin: 0px;
        }

        p {
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

        .p3 {
            padding: 3px;
        }

        .fw-600 {
            font-weight: 600;
        }

        table.letter-format tr td,
        table.letter-format tr,
        table.letter-format tr td p {
            border: 0;
            font-size: 14px;
        }

        .pt-pb-5 {
            padding-top: 5px;
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

        table.salary-table tr td {
            border-collapse: collapse;
            border: 1px solid;
        }

        .border-bottom-line {
            border-bottom: 1px solid;
        }
        @page {
        size: 4in 6in;
       }

    </style>
</head>

<body>

    <div class="main-page appointment-letter">
        <div class="sub-page" style="text-align: justify;font-size: 15px;">
            <table class="letter-format" style="padding:0;">
                <tbody>
                    <tr>
                        <td align="center" style="">
                            <table class="table-one">
                                <tbody>
                                    <tr>
                                        <td colspan="8" style=" " align="right">
                                            <p class="fw-600 txt-right " style="margin-right:100px">
                                                Date: {{ $doj }}
                                            </p>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" style=" " align="center">
                                            <p class="fw-600 txt-center " style="">
                                                LETTER OF APPOINTMENT

                                            </p>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" style=" " align="left">
                                            <p class="fw-600 txt-left " style="">
                                                Dear <span class="fw-600 txt-left">{{ $employee_name }}</span>&nbsp;,
                                            </p>
                                            <p class="pt-pb-5">We are glad to appoint you as
                                                &nbsp;<span class="fw-600 txt-left">" {{ $designation  }}
                                                    "</span>&nbsp; in our company, &nbsp;<span
                                                    class="fw-600 txt-left"> VASA
                                                    GROUP</span>&nbsp;.</p>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" style=" " align="left">
                                            <p class="fw-600 txt-left " style="">
                                                Remuneration

                                            </p>
                                            <p class="pt-pb-5">
                                                Your total remuneration package per annum will
                                                consist of &nbsp;<span class="fw-600 txt-left">
                                                    CTC Rs {{ $ctc_yearly }}- per annum ({{ $ctc_in_words }})</span>&nbsp;. The
                                                breakup of your compensation package shall
                                                be as detailed in Annexure A.

                                            </p>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" style=" " align="left">
                                            <p class="fw-600 txt-left " style="">
                                                Commencement

                                            </p>
                                            <p class="pt-pb-5">
                                                Your employment with the company &nbsp;<span
                                                    class="fw-600 txt-left"> VASA GROUP
                                                </span>&nbsp will
                                                be with effect from &nbsp;<span
                                                    class="fw-600 txt-left">   {{ $doj }}</span>&nbsp;. You shall
                                                initially be placed in &nbsp;<span
                                                    class="fw-600 txt-left"> {{ $work_location }}
                                                </span>&nbsp;. You may however
                                                be required to travel and maybe positioned or
                                                deputed outside within India or abroad.

                                            </p>

                                        </td>
                                    </tr>


                                    <tr>
                                        <td colspan="8" style=" " align="left">
                                            <p class="fw-600 txt-left " style="">
                                                Rules and Regulations

                                            </p>
                                            <p class="pt-pb-5">
                                                You shall be governed by the policies of the
                                                company as specified in &nbsp;<span
                                                    class="fw-600 txt-left">Annexure
                                                    B</span>&nbsp;. You shall
                                                serve the Company and shall carry out such
                                                duties which will be explained and defined by
                                                your manager (immediate superior), subject
                                                always to the employee policy and the rules and
                                                regulations of the Company. Your employment
                                                shall continue to be governed by the terms of
                                                this appointment letter in the event of you
                                                being deputed or positioned outside India.

                                            </p>
                                            <p class="pt-pb-5">
                                                We welcome you to our team. We are confident
                                                that you will make an effective contribution to
                                                the growth of the company and will enjoy working
                                                with us.
                                            </p>
                                            <p class="pt-pb-5">
                                                You will be under probation for a period of
                                                &nbsp;<span class="fw-600 txt-left">SIX
                                                    MONTHS </span>&nbsp;. Your confirmation will
                                                be based on the
                                                evaluation during the end of the probation
                                                period.


                                            </p>
                                            <p class="pt-pb-5">
                                                If you are agreeable to the terms and conditions
                                                of the appointment (Annexure B), then kindly
                                                confirm your acceptance of the appointment by
                                                signing and returning to us the attached copy of
                                                this letter.

                                            </p>

                                        </td>
                                    </tr>


                                    <tr>
                                        <td colspan="8" style=" " align="left">
                                            <p class="fw-600 pt-30  txt-left " style="">
                                                Yours faithfully,
                                            </p>
                                            <p class="pt-pb-5 pb-30 fw-600">
                                                For VASA GROUP

                                            </p>
                                            <p class="fw-600 pt-10 txt-left "
                                                style="border-bottom:1px solid">
                                                Founder and CEO of VasaGroup
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" style=" " align="left">
                                            <p class=" pt-10 txt-left " style="">
                                                I M <span class="fw-600 txt-left">{{ $employee_name }}</span>&nbsp;, have read &nbsp;<span
                                                    class="fw-600 txt-left">ANNEXURE A &
                                                    B,</span>&nbsp; understood, and accept the
                                                appointment upon the terms and conditions as
                                                outlined in this appointment letter for my
                                                position at &nbsp;<span
                                                    class="fw-600 txt-left">VASA GROUP
                                                </span>&nbsp;.

                                            </p>


                                        </td>
                                    </tr>



                                    <tr>
                                        <td colspan="4" class="pt-30" style=" "
                                            align="left">
                                            <p class="fw-600 txt-left " style="">
                                                Sign:
                                            </p>


                                        </td>
                                        <td colspan="4" style=" " align="right">
                                            <p class="fw-600 txt-right " style="  margin-right:100px">
                                                Date:
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

    <div class="main-page appointment-letter">
        <div class="sub-page" style="text-align: justify;font-size: 15px;">
            <table class="letter-format " style="padding:0;">
                <tbody>
                    <tr>
                        <td class="" colspan="8">
                            <table class="salary-table">
                                <tbody>
                                    <tr>
                                        <td colspan="8" style=" "class=""
                                            align="center">
                                            <p class="fw-600 txt-center " style="">
                                                ANNEXURE A
                                            </p>

                                        </td>

                                    </tr>
                                    <tr>
                                        <td colspan="8" style=" "class=""
                                            align="center">
                                            <p class="fw-600 txt-center " style="">
                                                &nbsp;
                                            </p>

                                        </td>
                                    </tr>
                                    <tr>

                                        <td colspan="4" style=" "class="bg-ash "
                                            align="left">
                                            <p class="fw-600  txt-left" style="">
                                                Name : {{ $employee_name }}
                                            </p>

                                        </td>

                                        <td colspan="4" style=" "class="bg-ash ">
                                            <p class="fw-600  txt-center" style="">
                                                Salary
                                            </p>

                                        </td>

                                    </tr>
                                    <tr>
                                        <td colspan="4" style=" "class="bg-ash "
                                            align="center">
                                            <p class="fw-600  " style="">
                                                Designation : {{ $designation  }}
                                            </p>

                                        </td>
                                        <td colspan="2" style=" "class="bg-ash ">
                                            <p class="fw-600  txt-center" style="">
                                                Per Month
                                            </p>

                                        </td>
                                        <td colspan="2" style=" "class="bg-ash ">
                                            <p class="fw-600   txt-center   " style="">
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
                                        <td colspan="2" style=" "class="">
                                            <p class="  txt-right" style="">
                                                {{ $basic_monthly }}

                                            </p>

                                        </td>
                                        <td colspan="2" style=" "class="">
                                            <p class="   txt-right   " style="">
                                                {{$basic_yearly  }}

                                            </p>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style=" "class=" ">
                                            <p class=" txt-left " style="">
                                                HRA
                                            </p>

                                        </td>
                                        <td colspan="2" style=" "class="">
                                            <p class=" txt-right" style="">
                                                {{ $hra_monthly }}

                                            </p>

                                        </td>
                                        <td colspan="2" style=" "class="">
                                            <p class="   txt-right   " style="">
                                                {{ $hra_yearly }}
                                            </p>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style=" "class=" ">
                                            <p class=" txt-left " style="">
                                                Special Allowance
                                            </p>

                                        </td>
                                        <td colspan="2" style=" "class="">
                                            <p class=" txt-right" style="">
                                                {{ $spl_allowance_monthly }}

                                            </p>

                                        </td>
                                        <td colspan="2" style=" "class="">
                                            <p class="   txt-right   " style="">
                                                {{ $spl_allowance_yearly }}

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
                                        <td colspan="2" style=" "class="bg-ash">
                                            <p class="fw-600  txt-right" style="">
                                                {{ $gross_monthly }}

                                            </p>

                                        </td>
                                        <td colspan="2" style=" "class="bg-ash">
                                            <p class="fw-600   txt-right   " style="">
                                                {{ $gross_yearly }}
                                            </p>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style=" "class=" ">
                                            <p class="" style="">
                                                PF (Employer Contribution)
                                            </p>

                                        </td>
                                        <td colspan="2" style=" "class="">
                                            <p class="   txt-right" style="">
                                                {{ $employer_epf_monthly }}

                                            </p>

                                        </td>
                                        <td colspan="2" style=" "class="">
                                            <p class="   txt-right   " style="">
                                                {{ $employer_epf_yearly }}

                                            </p>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style=" "class=" ">
                                            <p class=" txt-left " style="">
                                                ESI (Employer Contribution)
                                            </p>

                                        </td>
                                        <td colspan="2" style=" "class="">
                                            <p class=" txt-right" style="">
                                                {{ $employer_esi_monthly}}

                                            </p>

                                        </td>
                                        <td colspan="2" style=" "class="">
                                            <p class="  txt-right   " style="">
                                                {{ $employer_esi_yearly }}
                                            </p>

                                        </td>
                                    </tr>

                                    <tr class="">
                                        <td colspan="4" style=" "class="bg-ash">
                                            <p class="fw-600  txt-left" style="">
                                                Cost to Company
                                            </p>

                                        </td>
                                        <td colspan="2" style=" "class="bg-ash">
                                            <p class="fw-600  txt-right" style="">
                                                {{ $ctc_monthly }}

                                            </p>

                                        </td>
                                        <td colspan="2" style=" "class="bg-ash">
                                            <p class="fw-600   txt-right   " style="">

                                                {{ $ctc_yearly }}
                                            </p>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style=" "class=" ">
                                            <p class="txt-left " style="">
                                                EPF (Employee Contribution)
                                            </p>

                                        </td>
                                        <td colspan="2" style=" "class="">
                                            <p class="txt-right" style="">
                                                {{ $employee_epf_monthly }}

                                            </p>

                                        </td>
                                        <td colspan="2" style=" "class="">
                                            <p class="txt-right   " style="">
                                                {{ $employee_epf_yearly }}

                                            </p>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style=" "class=" ">
                                            <p class="txt-left " style="">
                                                ESI (Employee Contribution)
                                            </p>

                                        </td>
                                        <td colspan="2" style=" "class="">
                                            <p class="txt-right" style="">
                                                {{ $employee_esi_monthly }}

                                            </p>

                                        </td>
                                        <td colspan="2" style=" "class="">
                                            <p class="txt-right   " style="">
                                                {{ $employee_esi_yearly }}

                                            </p>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style=" "class=" ">
                                            <p class="txt-left " style="">
                                                Professional Tax

                                            </p>

                                        </td>
                                        <td colspan="2" style=" "class="">
                                            <p class="txt-right" style="">
                                                {{ $employer_pt_monthly  }}
                                            </p>

                                        </td>
                                        <td colspan="2" style=" "class="">
                                            <p class="txt-right   " style="">

                                                {{$employer_pt_yearly  }}
                                            </p>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style=" "class="  bg-ash">
                                            <p class="txt-left " style="">
                                                Net Income
                                            </p>

                                        </td>
                                        <td colspan="2" style=" "class=" bg-ash">
                                            <p class="txt-right" style="">
                                                {{ $net_take_home_monthly }}

                                            </p>

                                        </td>
                                        <td colspan="2" style=" "class=" bg-ash">
                                            <p class="txt-right   " style="">
                                                {{ $net_take_home_yearly}}
                                            </p>

                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8" class="pt-pb-5" style=" ">
                            <p class=" txt-left pt-pb-5 " style="">
                                <span class="fw-600">Statutory Bonus – </span>
                                Will be paid as per the Payment of Bonus Act and
                                8.33% or MW whichever is higher if your basic
                                salary is less than INR-21000/- per month.

                            </p>
                            <p class=" txt-left pt-pb-5 " style="">
                                <span class="fw-600">Increment and Promotions – </span>
                                Shall be based on merit considering your periodic and consistent
                                overall performance, business conditions, and other parameters
                                fixed from time to time at the discretion of the management and
                                shall not be considered merely as a matter of right.



                            </p>
                            <p class=" txt-left pt-pb-5 " style="">
                                <span class="fw-600"> Gratuity- </span>

                                Will be paid for those who have completed 5 Years of continuous
                                service with our organization as per the Payment of Gratuity Act
                                -1972.

                            </p>

                            <p class=" txt-left pt-pb-5 " style="">
                                <span class="fw-600"> Insurance –</span>
                                <span> Group Mediclaim policy will be an extended benefits to
                                    our employees.
                                    ESIC not covered employees – 3,00,000 GMC (Employee +Spouse
                                    + Kids Max) – Subject to conditions
                                </span>
                            <p>ESIC Covered Employees – 1,00,000 GMC (Employee + Spouse + Kids
                                Max) – Subject to conditions </p>

                            </p>
                            <p class=" txt-left pt-pb-5 " style="">
                                <span class="fw-600">IncomeTax – </span>
                                Income tax will be deducted as per the slab

                            </p>

                            <p class=" txt-left pt-pb-5 " style="">
                                <span class="fw-600">Full and Final Settlement -</span>
                                F n F will be settle within 7 working days from the Last working
                                day
                            </p>


                        </td>
                    </tr>
                    <tr>
                        <td colspan="8" style=" " align="left">
                            <p class=" pt-30 txt-left " style="">
                                I<span class="fw-600 txt-left">{{ $employee_name }}</span>&nbsp;, have read &nbsp;<span class="fw-600 txt-left">ANNEXURE A
                                    &
                                    B,</span>&nbsp; understood, and accept the
                                appointment upon the terms and conditions as
                                outlined in this appointment letter for my
                                position at &nbsp;<span class="fw-600 txt-left">VASA GROUP
                                </span>&nbsp;.

                            </p>


                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="pt-30" style=" " align="left">
                            <p class="fw-600 txt-left " style="">
                                Sign:
                            </p>


                        </td>
                        <td colspan="4" style=" " align="right">
                            <p class="fw-600 txt-right " style="margin-right:100px">
                                Date:
                            </p>


                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="main-page appointment-letter">
        <div class="sub-page" style="text-align: justify;font-size: 15px;">
            <table class="letter-format " style="padding:0;">
                <tbody>
                    <tr>
                        <td colspan="8" style=" "class="" align="center">
                            <span class="fw-600  border-bottom-line" style="">
                                ANNEXURE B
                            </span>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="" style=" "class="" align="center">
                            <p class="fw-600  " style="">
                                DUTIES
                            </p>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="" style=" "class="" align="center">
                            <p class="  " style="">
                                You will devote your full-time skill and attention to the work
                                and business of the Company and shall continue to work to the
                                best of your ability.

                            </p>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="" style=" "class="" align="center">
                            <p class="  " style="">
                                You will accept, support, and work within the management,
                                financial, personnel, internal control, and reporting systems,
                                policies, practices, and procedures as determined by the Company
                                or your Manager, from time to time.

                            </p>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="" style=" "class="pt-10" align="center">
                            <p class="fw-600  " style="">
                                HOURS OF WORK
                            </p>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="" style=" "class="" align="center">
                            <p class=" " style="">
                                Your actual working hours &nbsp;<span
                                    class="fw-600 txt-left">9.45 AM to 6 PM </span>&nbsp;
                                including working in
                                Shifts and working days (including working on weekly offs and
                                public holidays) will be often determined by workflow and
                                Company commitments.


                            </p>
                            <p class=" " style="">
                                VASA GROUP works for &nbsp;<span class="fw-600 txt-left">8
                                    hours</span>&nbsp; (Including Break) a day 5 days a
                                week and Saturday &nbsp;<span class="fw-600 txt-left">9.45 AM
                                    to 4 PM </span>&nbsp; (Including Break). However,
                                there may be certain work exigencies that may require you to
                                work beyond the stipulated hours of work.

                            </p>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="" style=" "class="pt-10" align="center">
                            <p class="fw-600  " style="">
                                CONDUCT

                            </p>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="" style=" "class="" align="center">
                            <p class=" " style="">
                                You shall conduct yourself in a befitting manner and abide by
                                all the conduct policy, the rules, and regulations of the
                                Company.

                            </p>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="" style=" "class="pt-10">
                            <p class=" fw-600" style="">
                                REVIEW OF SALARY

                            </p>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="" style=" "class="">
                            <p class=" " style="">
                                Your remuneration shall be reviewed annually and any changes to
                                your remuneration package shall be determined by considering
                                your performance in the Company, the Company’s performance, and
                                your contribution to the Company.


                            </p>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="" style=" "class="pt-10">
                            <p class=" fw-600" style="">
                                CONFIDENTIALITY OF SALARY


                            </p>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="" style=" "class="">
                            <p class=" " style="">
                                Your salary is the reward for your untiring effort and work. You
                                need to maintain your salary with the utmost confidentiality. In
                                the event you do not maintain the confidentiality of your
                                salary, you may be subject to disciplinary action. </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="" style=" "class="pt-10">
                            <p class=" fw-600" style="">
                                EXPENSES
                            </p>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="" style=" "class="">
                            <p class="" style="">
                                The Company will compensate you for all expenses that are
                                reasonably incurred and that are directly related to the
                                performance of your work, but only insofar as that compensation
                                may be provided tax-free compensation of expenses as contained
                                herein will be made only on the basis of a statement of expenses
                                that have been approved by the Company.


                            </p>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="" style=" "class="pt-10">
                            <p class=" fw-600" style="">
                                PROVIDENT FUND SCHEME AND ESIC

                            </p>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="" style=" "class="">
                            <p class=" " style="">
                                Employer contributions will be submitted to the Indian
                                Government-approved Provident Fund Scheme on your behalf with
                                your equal monthly contribution as detailed in &nbsp;<span
                                    class="fw-600 txt-left"> Annexure A .</span>&nbsp;

                            </p>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="" style=" "class="pt-10">
                            <p class=" fw-600" style="">
                                METHOD OF PAYMENT
                            </p>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="" style=" "class="">
                            <p class="" style="">
                                Salaries and wages will be paid monthly by electronic funds
                                transfer or will be deposited in your Salary Account or any
                                other means on or before the 7th day of each month in arrears.
                                The company reserves its right to vary this procedure at its
                                option. However, such variance will be communicated to you in
                                due course.

                            </p>

                        </td>
                    </tr>



                </tbody>
            </table>
        </div>
    </div>

    <div class="main-page appointment-letter">
        <div class="sub-page" style="text-align: justify;">
            <table class="letter-format " style="padding:0;">
                <tbody>
                    <tr>
                        <td colspan="" style=" "class="">
                            <p class="fw-600  " style="">
                                LEAVE
                            </p>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="" style=" "class="" align="center">
                            <p class="  " style="">
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="" style=" "class="" align="center">
                            <p class="fw-600  " style="">
                                INTELLECTUAL PROPERTY RIGHTS

                            </p>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="" style=" "class="" align="center">
                            <p class="  " style="">
                                All Industrial and intellectual property rights, including but
                                not limited to patent rights, design rights, copyrights, and
                                related rights, database rights, trademark rights, and chip
                                rights, ensuring within the framework of the work performed by
                                you during your employment with the company,
                            </p>
                            <p class="  " style="">
                                will be exclusively vested in Company. You may not independently
                                during your employment and subsequent to termination disclose,
                                multiply, use, manufacture, bring on the market or sell, lease,
                                deliver, or otherwise trade, offer on behalf of any third party,
                                or commission the registration of the results of your work. To
                                the extent that such inventions are performed under the
                                Company’s direction, you shall fully, freely, and immediately
                                communicate any invention to the Company and all rights, title,
                                and interest to any such invention (“Inventions”) shall be the
                                sole property of the Company.

                            </p>
                            <p class="  " style="">
                                In pursuance of the above

                            </p>

                            <ol type="A" style="text-align: justify">
                                <li class="pt-pb-5">You will give the Company and its
                                    solicitors and/or its
                                    patent attorneys all necessary assistance and cooperation in
                                    connection with the preparation and prosecution of any
                                    application for patent, design, registration, or copyright
                                    by the Company in respect of the Invention.
                                </li>
                                <li>TeYou irrevocably appoint the Company and any directors of
                                    the Company jointly and severally your true and lawful
                                    attorney to execute all such documents and do all such
                                    things as in the opinion of the Company may be necessary or
                                    requisite for any such purpose.</li>

                            </ol>


                        </td>
                    </tr>
                    <tr>
                        <td colspan="" style=" "class="">
                            <p class="fw-600  " style="">
                                TERMINATION
                            </p>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="" style=" "class="">
                            <p class="  " style="">
                                Your employment may be terminated at any time by yourself, or by
                                the Company, upon providing one (1) month’s written notice to
                                the other party. Also, it can be extended according to the
                                management’s needs
                            </p>
                            <p class="pt-pb-5 " style="">
                                In the case of the Company terminating, you for reasons other
                                than a breach of contract by you or for any disciplinary reasons
                                against you, the company shall pay you one month’s salary equal
                                to your notice period not worked as payment in lieu of notice.

                            </p>
                            <p class=" " style="">
                                If you seek to terminate your employment with the company, you
                                shall do a proper handover of all the work and responsibilities
                                that you are handling to your manager and the resource
                                identified for replacing you, to the satisfaction of your
                                manager. If you are not able to serve the notice period one (1)
                                month of your CTC to be payable to VASA GROUP

                            </p>
                            <p class="pt-pb-5 " style="">
                                Upon termination of your employment with the company, you agree
                                not to solicit any other team members in the company to the new
                                organization that you are going.

                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="" style=" "class="">
                            <p class="fw-600  " style="">
                                DISPUTE RESOLUTION

                            </p>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="" style=" "class="">
                            <p class="  " style="">
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

                </tbody>
            </table>
        </div>
    </div>

    <div class="main-page appointment-letter">
        <div class="sub-page" style="text-align: justify;">
            <table class="letter-format " style="padding:0;">
                <tbody>
                    <tr>
                        <td colspan="8  " style=" "class="">
                            <p class="fw-600  " style="">
                                GOVERNING LAW AND JURISDICTION

                            </p>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="8" style=" "class="">
                            <p class="  " style="">
                                This agreement shall be governed by the laws of the Republic of
                                India and courts in Chennai have exclusive jurisdiction over
                                this agreement.

                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8" style=" "class="">
                            <p class="fw-600  " style="">
                                RETIREMENT AGE


                            </p>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="8" style=" "class="">
                            <p class="  " style="">
                                The general Retirement for employees in the Company is
                                &nbsp;<span class="fw-600 txt-left"> Fifty-Eight (58) years.
                                </span>&nbsp;
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8" style=" " align="left">
                            <p class="fw-600 pt-30  txt-left " style="">
                                Yours faithfully,
                            </p>
                            <p class="pt-pb-5 pb-30 fw-600">
                                For VASA GROUP

                            </p>

                            <p class="fw-600 pt-10 txt-left " style="border-bottom:1px solid">
                                Founder and CEO of VasaGroup
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8" style=" " align="left">
                            <p class=" pt-10 txt-left " style="">
                                I M <span class="fw-600 txt-left">{{ $employee_name }}</span>&nbsp;, have read &nbsp;<span class="fw-600 txt-left">ANNEXURE
                                    A &
                                    B,</span>&nbsp; understood, and accept the
                                appointment upon the terms and conditions as
                                outlined in this appointment letter for my
                                position at &nbsp;<span class="fw-600 txt-left">VASA GROUP
                                </span>&nbsp;.

                            </p>


                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="pt-30" style=" " align="left">
                            <p class="fw-600 txt-left " style="">
                                Sign:
                            </p>


                        </td>
                        <td colspan="4" style=" " align="right">
                            <p class="fw-600 txt-right " style="margin-right:100px">
                                Date:
                            </p>


                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

</body>

</html>
