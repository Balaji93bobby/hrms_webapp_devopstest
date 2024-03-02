<?php

$client_data = \DB::table('vmt_client_master')->first();
//$employee_name =  \DB::table('users')->where('user_code','=',$employee->EMP_NO)->first('name');
$client_logo = request()->getSchemeAndHttpHost() . '' . $client_data->client_logo;
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
            background: #fff;

        }

        @page {
            size: A4 portrait;
        }


        .paySlip_template {
            width: 100%;
            border: 0;
            background-color: #fff;
            white-space: nowrap;
            font-size: .9em;
            border-collapse: collapse
        }

        .paySlip_template tr td p {
            margin: 0;
        }

        /* .paySlip_template , */
        .paySlip_template tr td {
            border: 0;
            whhite-space: nowrap;
            padding-top: .5em;
            padding-bottom: .5em;

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
                <td colspan="6" class="" align="">
                    <p class="text-bolder " style="font-size:1.3em;padding-bottom:.5em;">
                        BREEZEETECH COOLING SYSTEM PRIVATE LIMITED
                    </p>
                    <p class="" style="text-align:left;">
                        Plot No. T 352, SIDCO Women’s Industrial Estate, Kattur,Avadi, <br>
                        Thirumullaivoyal, Chennai,TamilNadu,600062,India.
                    </p>
                </td>
                <td colspan="6" class=" " align="right">
                    <div style="height: 4em;width:10em">
                        <img src="{{ $client_logo }}" class="" alt="" style="height:100%;width:100%;">
                    </div>
                </td>
            </tr>
            <tr class="">
                <td colspan="12" class="" style="border-top:.1em solid #4b48fb;">
                    <p class="text-bolder " style="margin: 0;padding:.5em 0;font-size:1.2em;">
                        Payslip For the Month of :
                        {{ strtoupper(date('F-Y', strtotime($emp_payroll_month->payroll_date))) }}
                    </p>
                </td>
            </tr>
            <tr class="">
                <td colspan="12" class="">
                    <p class="text-bolder " style="font-size:.9em;">
                        EMPLOYEE PAY SUMMARY
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="9" style="padding-bottom:1em;">
                    <table class="paySlip_template">
                        <tbody>
                            <tr>
                                <td colspan="2" class=""  >
                                    <p class="" style="font-weight:600"> Employee Name</p>
                                </td>
                                <td colspan="2" class=""  >
                                    <p> {{ $employee_name }}</p>
                                </td>
                                <td colspan="1" class="" >
                                </td>
                                <td colspan="2" class="">
                                    <p class="" style="font-weight:600">Employee No</p>
                                </td>
                                <td colspan="2" class="">
                                    <p> {{ $employee_code }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="" >
                                    <p class="" style="font-weight:600">Designation </p>
                                </td>
                                <td colspan="2" class="" >
                                    <p> {{ $employee_office_details->designation }}</p>
                                </td>
                                <td colspan="1" class="" >
                                </td>
                                <td colspan="2" class="" >
                                    <p class="" style="font-weight:600">UAN Number </p>
                                </td>
                                <td colspan="2" class="" >
                                    <p>{{ $employee_statutory_details->uan_number }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="" >
                                    <p class="" style="font-weight:600"> Date of Joining</p>
                                </td>
                                <td colspan="2" class="" >
                                    <p> {{ date('d-M-Y', strtotime($employee_details->doj)) }}</p>
                                </td>
                                <td colspan="1" class="" >
                                </td>
                                <td colspan="2" class="" >
                                    <p class="" style="font-weight:600">ESIC Number No</p>
                                </td>
                                <td colspan="2" class="" >
                                    <p>{{ $employee_statutory_details->esic_number ?? '-' }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="" >
                                    <p class="" style="font-weight:600">PF A/C Number</p>
                                </td>
                                <td colspan="2" class="" >
                                    <p>{{ $employee_statutory_details->epf_number }}</p>
                                </td>
                                <td colspan="1" class="" >
                                </td>
                                <td colspan="2" class="" >
                                    <p class="" style="font-weight:600">Bank Account No </p>
                                </td>
                                <td colspan="2" class="" >
                                    <p>{{ $employee_details->bank_account_number }}</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td colspan="1" style="padding-bottom:1em;">

                </td>
                <td colspan="2" style="padding-bottom:1em;">
                    <table class="paySlip_template">
                        <tbody>
                            <tr>
                                <td colspan="1" class=""
                                    style="border:.1em dashed #b2ff78;padding:.4em .2em">
                                    <p>Paid Days</p>
                                </td>
                                <td colspan="1" class=""
                                    style="border:.1em dashed #b2ff78;padding:.4em .2em">
                                    <p>{{ $employee_payslip->worked_Days }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" class=""
                                    style="border:.1em dashed #b2ff78;padding:.4em .2em">
                                    LOP Days
                                </td>
                                <td colspan="1" class=""
                                    style="border:.1em dashed #b2ff78;padding:.4em .2em">
                                    <p>{{ $employee_payslip->lop }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" class="" style="padding:.4em .2em">

                                </td>
                                <td colspan="1" class="" style="padding:.4em .2em">

                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" class="" style="padding:.4em .2em">

                                </td>
                                <td colspan="1" class="" style="padding:.4em .2em">

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="12">
                    <table class="paySlip_template">
                        <tbody>
                            <tr>
                                <td colspan="3" class="" align=""
                                    style="padding:.5em .2em;background-color:#bce2c78c;border-bottom-left-radius: 0px;padding-left:1.5em;">
                                    <p style="color:#015e1c;">EARNINGS</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em .2em;background-color:#bce2c78c;">
                                    <p style="color:#015e1c;">FIXED GROSS</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em .2em;background-color:#bce2c78c;">
                                    <p style="color:#015e1c;">EARNED GROSS</p>
                                </td>
                                <td colspan="3" class="" align=""
                                    style="padding:.5em .2em;background-color:#bce2c78c;">
                                    <p style="color:#015e1c;">DEDUCTIONS</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em .2em;background-color:#bce2c78c;border-bottom-right-radius: 0px;">
                                    <p style="color:#015e1c;">AMOUNT</p>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3" class="" align="" style="padding:.5em .2em">
                                    <p>Basic</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right">{{ number_format(round($employee_payslip->basic), 2) }}</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right">
                                        {{ number_format(round($employee_payslip->earned_basic), 2) }}</p>
                                </td>
                                <td colspan="3" class="" align="" style="padding:.5em .2em;">
                                    <p>EPF Contribution</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right">{{ number_format(round($employee_payslip->epfr), 2) }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="" align="" style="padding:.5em .2em;">
                                    <p>HRA</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right">{{ number_format(round($employee_payslip->hra), 2) }}</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right">{{ number_format(round($employee_payslip->earned_hra), 2) }}
                                    </p>
                                </td>
                                <td colspan="3" class="" align="" style="padding:.5em .2em ;">
                                    <p>ESIC Contribution</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right">
                                        {{ number_format(round($employee_payslip->employee_esic), 2) }}</p>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3" class="" align="" style="padding:.5em .2em;">
                                    <p>Special Allowance</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right">{{ number_format(round($employee_payslip->spl_alw), 2) }}
                                    </p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right">
                                        {{ number_format(round($employee_payslip->earned_spl_alw), 2) }}</p>
                                </td>
                                <td colspan="3" class="" align="" style="padding:.5em .2em;">
                                    <p>Income Tax</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right">{{ number_format(round($employee_payslip->income_tax), 2) }}
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="" align="" style="padding:.5em .2em;">
                                    <p>Overtime Earnings</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right"></p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right">{{ number_format(round($employee_payslip->overtime), 2) }}
                                    </p>
                                </td>
                                <td colspan="3" class="" align="" style="padding:.5em .2em;">
                                    <p>Professional Tax</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right">{{ number_format(round($employee_payslip->prof_tax), 2) }}
                                    </p>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3" class="" align="" style="padding:.5em .2em;">
                                    <p></p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right"></p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right"></p>
                                </td>
                                <td colspan="3" class="" align="" style="padding:.5em .2em;">
                                    <p>Salary Advance</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right">
                                        {{ number_format(round($employee_payslip->sal_adv), 2) }}</p>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3" class="" align="" style="padding:.5em .2em;">
                                    <p></p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right"></p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right"></p>
                                </td>
                                <td colspan="3" class="" align="" style="padding:.5em .2em;">
                                    <p>Canteen Deduction</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right">
                                        {{ number_format(round($employee_payslip->canteen_dedn), 2) }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="" align="" style="padding:.5em .2em;">
                                    <p></p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right"></p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right"></p>
                                </td>
                                <td colspan="3" class="" align="" style="padding:.5em .2em;">
                                    <p>Other Deduction</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right">
                                        {{ number_format(round($employee_payslip->other_deduc), 2) }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="" align=""
                                    style="padding:.5em .2em;border-top:.2em solid #bce2c78c ">
                                    <p>GROSS EARNINGS</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;border-top:.2em solid #bce2c78c ">
                                    <p class="text-right">
                                        {{ number_format(round($employee_payslip->total_fixed_gross), 2) }}</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;border-top:.2em solid #bce2c78c ">
                                    <p class="text-right">
                                        {{ number_format(round($employee_payslip->total_earned_gross), 2) }}</p>
                                </td>
                                <td colspan="3" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;border-top:.2em solid #bce2c78c ">
                                    <p>Total Deduction</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;border-top:.2em solid #bce2c78c ">
                                    <p class="text-right">
                                        {{ number_format(round($employee_payslip->total_deductions), 2) }}</p>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="12" class="" align="" style="padding-top:1em">
                                    <div
                                        style="font-size:1em;line-height:1.8em;padding:1.3em 2em;border:.1em dashed #015e1c;border-radius:1em;text-align:center;">
                                        Total Net Payable <b style="font-size:1.3em;color:#015e1c;">₹
                                            {{ number_format(round($employee_payslip->net_take_home), 2) }}</b>
                                        ({{ $employee_payslip->rupees }}) </br>
                                        **Total Net Payable = Gross Earnings - Total Deductions
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="12" class="" align="" style="padding-bottom:1.3em;">
                                    <p class="text-center">-- This is a system-generatedpayslip, hence the signature is
                                        not required. –

                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="8" class="" align="">
                                    Note - Please reach out to us for any payroll queries at -payroll@ardens.in
                                </td>
                                <td colspan="4" class="" align="right">
                                    <img src="{{ URL::asset('assets/images/client_logos/ardens/evangelist.png') }}"
                                        width="100px" height="18px" alt="" class="">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
