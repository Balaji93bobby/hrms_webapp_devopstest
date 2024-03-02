<?php

$general_info = \DB::table('vmt_client_master')->first();
//$employee_name =  \DB::table('users')->where('user_code','=',$employee->EMP_NO)->first('name');
$client_logo = request()->getSchemeAndHttpHost() . '' . $general_info->client_logo;
// dd(request()->getSchemeAndHttpHost()."".$general_info->client_logo);
// $bank_names = \DB::table('vmt_banks')->get();
?>
<?php

// $bank_names = \DB::table('vmt_banks')->get();
?>

<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        .sub-page {
            background: #fff
        }

        @page {
            size: A4 landscape;
        }

        .paySlip_template {
            width: 100%;
            border: 0;
            background-color: #fff;
            white-space: nowrap;
            font-size: .9em;
            border-collapse: collapse;
        }

        .paySlip_template tr td {
            padding-top: .5em;
            padding-bottom: .5em;
            border: 0;
            whhite-space: nowrap;
        }
        
        .paySlip_template tr td p{
            margin:0;
        }


        .text-bolder {
            font-weight: 700;
        }

        .text-center {
            text-align: center;
        }

        .text-rignt {
            text-align: right;
        }

        .border-t-b {
            border-top: 1px solid #b6b3b3 !important;
            border-bottom: 1px solid #b6b3b3 !important;
        }

        .border-b {
            border-bottom: 1px solid #b6b3b3 !important;
        }

        .p-t-b {
            padding-top: .8em;
            padding-bottom: .8em;
        }

        .margin-0: {
            margin: 0;
        }
    </style>
</head>

<body>
    <table class="paySlip_template">
        <tbody>
            <tr>
                <td colspan="4" class=" ">
                    <div class="">
                        <img src="{{ $client_logo }}" class="" alt=""
                            style="height: 40px;width:250px;max-height:100%;">
                    </div>

                </td>

                <td colspan="3" class="text-rignt" align="right">
                    <p class="text-bolder text-right" style="margin:0">
                        eTeam Infoservices Pvt Ltd
                    </p>
                    <span class="text-right">
                        208/W, Seth B. N. Agarwal,<br>
                        Shyamkamal A CHS Ltd, Tejpal Road,<br>
                        Vile Parle East, Mumbai-400057, India
                    </span>

                </td>

            </tr>
            <tr class="">
                <td colspan="7" class="  border-t-b">
                    <p class="text-bolder " style="margin: 0;padding:.7em 0;">
                        Payslip For the Month of :
                        {{ strtoupper(date('F-Y', strtotime($emp_payroll_month->payroll_date))) }}
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="7" style="padding-bottom:1em;">
                    <table class="paySlip_template">
                        <tbody>
                            <tr>
                                <td colspan="1" style="font-weight:600;">
                                    Employee code
                                </td>
                                <td colspan="1" style="">
                                    {{ $employee_code }}
                                </td>
                                <td colspan="1" style="font-weight:600;">
                                    Designation
                                </td>
                                <td colspan="1" style="">
                                    {{ $employee_office_details->designation }}
                                </td>
                                <td colspan="1" style="font-weight:600;" class="text-bolder ">
                                    LeaveType
                                </td>
                                <td colspan="1" style="font-weight:600;" class="text-bolder">
                                    Leave Taken
                                </td>
                                <td colspan="1" style="font-weight:600;" class="text-bolder">
                                    Available Leave
                                </td>
                            </tr>

                            <tr>
                                <td colspan="1" style="font-weight:600;">
                                    Employee Name
                                </td>
                                <td colspan="1" style="">
                                    {{ $employee_name }}
                                </td>
                                <td colspan="1" style="font-weight:600;">
                                    Bank Name
                                </td>
                                <td colspan="1" style="">
                                    {{ $employee_name }}
                                </td>

                                <td colspan="1" style="font-weight:600;">
                                    PL
                                </td>
                                <td colspan="1" style="">
                                    1.00
                                </td>
                                <td colspan="1" style="">
                                    1.50
                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" style="font-weight:600;">
                                    UAN
                                </td>
                                <td colspan="1" style="">
                                    {{ $employee_statutory_details->uan_number }}
                                </td>
                                <td colspan="1" style="font-weight:600;">
                                    Bank Account No
                                </td>
                                <td colspan="1" style="">
                                    {{ $employee_details->bank_account_number }}
                                </td>
                                <td colspan="1" style="">

                                </td>
                                <td colspan="1" style="">

                                </td>
                                <td colspan="1" style="">

                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" style="font-weight:600;">
                                    Location
                                </td>
                                <td colspan="1" style="">
                                    <p>{{ $employee_payslip->LOCATION ?? "-"}}</p>
                                </td>
                                <td colspan="1" style="font-weight:600;">
                                    PAN No
                                </td>
                                <td colspan="1" style="">
                                    <p>{{ $employee_details->pan_number ?? "-" }}</p>
                                </td>
                                <td colspan="1" style="">

                                </td>
                                <td colspan="1" style="">

                                </td>
                                <td colspan="1" style="">

                                </td>
                            </tr>

                            <tr>
                                <td colspan="1" style="font-weight:600;">
                                    PF No
                                </td>
                                <td colspan="1" style="">
                                    <p>{{ $employee_statutory_details->epf_number ?? "-" }}</p>
                                </td>
                                <td colspan="1" style="font-weight:600;">
                                    Joining Date
                                </td>
                                <td colspan="1" style="">
                                    {{ date('d-M-Y', strtotime($employee_details->doj)) }}
                                </td>
                                <td colspan="1" style="">

                                </td>
                                <td colspan="1" style="">

                                </td>
                                <td colspan="1" style="">

                                </td>
                            </tr>

                            <tr>
                                <td colspan="1" style="font-weight:600;">
                                    Paid Days
                                </td>
                                <td colspan="1" style="">
                                    <p class="txt-center">{{ $employee_payslip->worked_Days }}</p>
                                </td>
                                <td colspan="1" style="font-weight:600;">
                                    ESI No
                                </td>
                                <td colspan="1" style="">
                                    <p>{{ $employee_statutory_details->esic_number ?? "-" }}</p>
                                </td>
                                <td colspan="1" style="">

                                </td>
                                <td colspan="1" style="">

                                </td>
                                <td colspan="1" style="">

                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" style="font-weight:600;">
                                    Leave Balance
                                </td>
                                <td colspan="1" style="">
                                    28.00
                                </td>
                                <td colspan="1" style="">
                                    Arrear Days
                                </td>
                                <td colspan="1" style="">
                                    <p class="txt-center">{{ $employee_payslip->arrears_Days }}</p>
                                </td>
                                <td colspan="1" style="">

                                </td>
                                <td colspan="1" style="">

                                </td>
                                <td colspan="1" style="">

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="7" class="border-t-b" style="padding:.3em 0">
                </td>
            </tr>
            <tr class="">
                <td colspan="4" style="padding-right:1em;padding-top:0.3em;">
                    <table class="paySlip_template">
                        <tr>
                            <td colspan="4">
                                <p class="text-bolder">
                                    Earnings
                                </p>
                            </td>
                        </tr>

                        <tr class="border-b">
                            <td class="border-b" style="font-weight:600;" colspan="1">
                                Description
                            </td>
                            <td class="border-b" style="font-weight:600;" colspan="1">
                                Fixed Gross
                            </td>
                            <td class="border-b" style="font-weight:600;" colspan="1">
                                Earned Gross
                            </td>
                            <td class="border-b" style="padding-right:1em;font-weight:600;
                             " colspan="1">
                                Arrear
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="">Basic</td>
                            <td colspan="1" style="">
                                {{ number_format(round($employee_payslip->basic), 2) }}
                            </td>
                            <td colspan="1" style="">
                                {{ number_format(round($employee_payslip->earned_basic), 2) }}
                            </td>
                            <td colspan="1" style="padding-right:1em ">
                                {{ number_format(round($employee_payslip->basic_arrear), 2) }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="">HRA</td>
                            <td colspan="1" style="">
                                {{ number_format(round($employee_payslip->hra), 2) }}
                            </td>
                            <td colspan="1" style="">
                                {{ number_format(round($employee_payslip->earned_hra), 2) }}
                            </td>
                            <td colspan="1" style="padding-right:1em ">
                                {{ number_format(round($employee_payslip->hra_arrear), 2) }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="">Spl_Allowance
                            </td>
                            <td colspan="1" style="">
                                {{ number_format(round($employee_payslip->spl_alw), 2) }}</td>
                            <td colspan="1" style="">
                                {{ number_format(round($employee_payslip->earned_spl_alw), 2) }}</td>
                            <td colspan="1" style="padding-right:1em ">
                                {{ number_format(round($employee_payslip->spl_alw_arrear), 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="1" style="">Statutory Bonus
                            </td>
                            <td colspan="1" style="">11600.00</td>
                            <td colspan="1" style="">11600.00</td>
                            <td colspan="1" style="">0.00</td>
                        </tr>
                        <tr class="border-t-b">
                            <td colspan="1" style="padding:.5em 0;" class="border-t-b">
                            </td>
                            <td colspan="1" style="padding:.5em 0;" class="border-t-b">11600.00</td>
                            <td colspan="1" style="padding:.5em 0;" class="border-t-b">11600.00</td>
                            <td colspan="1" style="padding:.5em 0;" class="border-t-b"></td>
                        </tr>

                    </table>
                </td>
                <td colspan="3" style="padding-left:1em;padding-top:0.3em;">
                    <table class="paySlip_template">
                        <tr>
                            <td colspan="3">
                                <p class="text-bolder" style="margin:">
                                    Deductions
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="border-b" style="" colspan="1">Deductions
                            </td>
                            <td class="border-b" style="" colspan="1">Monthly
                            </td>
                            <td class="border-b" style="" colspan="1">Arrear</td>


                        </tr>
                        <tr>
                            <td colspan="1" style="">PF</td>
                            <td colspan="1" style="">
                                {{ $employee_payslip->epfr ?? '-' }}</td>
                            <td colspan="1" style="">1800.00</td>

                        </tr>
                        <tr>
                            <td colspan="1" style="">PT</td>
                            <td colspan="1" style="">
                                {{ number_format(round($employee_payslip->prof_tax), 2) }}</td>
                            <td colspan="1" style="">1800.00</td>

                        </tr>
                        <tr>
                            <td colspan="1" style="">&nbsp;</td>
                            <td colspan="1" style="">&nbsp;</td>
                            <td colspan="1" style="">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="1" style="">&nbsp;</td>
                            <td colspan="1" style="">&nbsp;</td>
                            <td colspan="1" style="">&nbsp;</td>
                        </tr>
                        <tr class="border-t-b">
                            <td colspan="1" style="padding:.5em 0;" class="border-t-b">Total Deductions</td>
                            <td colspan="1" style="padding:.5em 0;" class="border-t-b">
                                {{ number_format(round($employee_payslip->total_deductions), 2) }}</td>
                            <td colspan="1" style="padding:.5em 0;" class="border-t-b"></td>
                        </tr>

                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="7">
                    <p class=" text-bolder" style="padding-bottom:.2em;">Payable Salary &nbsp;
                            {{ number_format(round($employee_payslip->total_earned_gross), 2) }}
                       
                                        </p>
                    <p class="margin-0">
                    Net Amount in words:
                            {{ $employee_payslip->rupees }} Only
                    </p>
                </td>
            </tr>

            <tr>
                <td colspan="7">
                    <p class=" text-bolder" style="margin:.1em 0">THIS IS A SYSTEM GENERATED PAYSLIP, DOES
                        NOT REQUIRE ANY
                        SIGNATURE AND/OR COMPANY SEAL</p>
                </td>
            </tr>
            <tr>
                <td colspan="5">

                </td>
                <td colspan="1" class=" " style="padding-right:.2em">

                </td>
                <td colspan="1" class="text-right" align="right" style="padding:.3em 0">

                    <span>Generated By</span>
                    <img style="display: revert"
                        src="{{ URL::asset('assets/images/client_logos/ardens/evangelist.png') }}" width="80px"
                        height="18px" alt="logo" class="">

                </td>
            </tr>

        </tbody>
    </table>
</body>

</html>
