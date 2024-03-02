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
            background: #fff;

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
        }

        .paySlip_template tr td {
            /* padding-top: .7em;
            padding-bottom: .7em; */

        }

        /* .paySlip_template , */
        .paySlip_template td {
            border: 0;
            whhite-space: nowrap;
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
                    <p class="text-bolder " style="margin:0;font-size:1.3em;">
                        BREEZEETECH COOLING SYSTEM PRIVATE LIMITED
                    </p>
                    <span class="text-right">
                        Plot No. T 352, SIDCO Women’s Industrial Estate, Kattur,Avadi, <br>
                        Thirumullaivoyal, Chennai,TamilNadu,600062,India.
                    </span>

                </td>
                <td colspan="6" class=" " align="right">
                    <div class="text-right" style="height: 50px;width:100px;max-height:100%;">
                        <img src="{{ $client_logo }}" class="" alt="" style="height:100%;width:100%;">
                    </div>
                </td>
            </tr>
            <tr class="">
                <td colspan="12" class="" style="border-top:.1em solid #4b48fb;">
                    <p class="text-bolder " style="margin: 0;padding:.7em 0;font-size:1.2em;">
                        Payslip For the Month of :
                        {{ strtoupper(date('F-Y', strtotime($emp_payroll_month->payroll_date))) }}
                    </p>
                </td>
            </tr>
            <tr class="">
                <td colspan="12" class="">
                    <p class="text-bolder " style="margin: 0;padding:.6em 0 0 0;font-size:.9em;">
                        EMPLOYEE PAY SUMMARY
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="9" style="padding-bottom:1em;">
                    <table class="paySlip_template">
                        <tbody>
                            <tr>
                                <td colspan="2" class="" style="padding:.4em .2em">
                                    <p class="" style="font-weight:600"> Employee Name</p>
                                </td>
                                <td colspan="2" class="" style="padding:.4em .2em">
                                    <p> {{ $employee_name }}</p>
                                </td>
                                <td colspan="1" class="" style="padding:.4em .2em">
                                </td>
                                <td colspan="2" class="" style="padding:.4em .2em">
                                    <p class="" style="font-weight:600">Employee No</p>
                                </td>
                                <td colspan="2" class="" style="padding:.4em .2em">
                                    <p> {{ $employee_code }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="" style="padding:.4em .2em">
                                    <p class="" style="font-weight:600">Designation </p>
                                </td>
                                <td colspan="2" class="" style="padding:.4em .2em">
                                    <p> {{ $employee_office_details->designation }}</p>
                                </td>
                                <td colspan="1" class="" style="padding:.4em .2em">
                                </td>
                                <td colspan="2" class="" style="padding:.4em .2em">
                                    <p class="" style="font-weight:600">UAN Number </p>
                                </td>
                                <td colspan="2" class="" style="padding:.4em .2em">
                                    <p>{{ $employee_statutory_details->uan_number }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="" style="padding:.4em .2em">
                                    <p class="" style="font-weight:600"> Date of Joining</p>
                                </td>
                                <td colspan="2" class="" style="padding:.4em .2em">
                                    <p> {{ date('d-M-Y', strtotime($employee_details->doj)) }}</p>
                                </td>
                                <td colspan="1" class="" style="padding:.4em .2em">
                                </td>
                                <td colspan="2" class="" style="padding:.4em .2em">
                                    <p class="" style="font-weight:600">ESIC Number No</p>
                                </td>
                                <td colspan="2" class="" style="padding:.4em .2em">
                                    <p>{{ $employee_statutory_details->esic_number ?? '-' }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="" style="padding:.4em .2em">
                                    <p class="" style="font-weight:600">PF A/C Number</p>
                                </td>
                                <td colspan="2" class="" style="padding:.4em .2em">
                                    <p>{{ $employee_statutory_details->epf_number }}</p>
                                </td>
                                <td colspan="1" class="" style="padding:.4em .2em">
                                </td>
                                <td colspan="2" class="" style="padding:.4em .2em">
                                    <p class="" style="font-weight:600">Bank Account No </p>
                                </td>
                                <td colspan="2" class="" style="padding:.4em .2em">
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
                                    <p>1</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" class=""
                                    style="border:.1em dashed #b2ff78;padding:.4em .2em">
                                    LOP Days
                                </td>
                                <td colspan="1" class=""
                                    style="border:.1em dashed #b2ff78;padding:.4em .2em">
                                    <p>2</p>
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
                                    <p style="color:#015e1c;">EARNING GROSS</p>
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
                                    <p class="text-right">sdfsd</p>
                                </td>
                                <td colspan="3" class="" align="" style="padding:.5em .2em;">
                                    <p>EPF Contribution</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right">sdfsd</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="" align="" style="padding:.5em .2em;">
                                    <p>HRA</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right">sdfsd</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right">sdfsd</p>
                                </td>
                                <td colspan="3" class="" align="" style="padding:.5em .2em ;">
                                    <p>ESIC Contribution</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right">sdfsd</p>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3" class="" align="" style="padding:.5em .2em;">
                                    <p>Special Allowance</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right">sdfsd</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right">sdfsd</p>
                                </td>
                                <td colspan="3" class="" align="" style="padding:.5em .2em;">
                                    <p>Income Tax</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right">sdfsd</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="" align="" style="padding:.5em .2em;">
                                    <p>Overtime Earnings</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right">sdfsd</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right">sdfsd</p>
                                </td>
                                <td colspan="3" class="" align="" style="padding:.5em .2em;">
                                    <p>Professional Tax</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right">sdfsd</p>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3" class="" align="" style="padding:.5em .2em;">
                                    <p>Incentive</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right">sdfsd</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right">sdfsd</p>
                                </td>
                                <td colspan="3" class="" align="" style="padding:.5em .2em;">
                                    <p>Other Deduction</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;">
                                    <p class="text-right">sdfsd</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="" align=""
                                    style="padding:.5em .2em;border-top:.2em solid #bce2c78c ">
                                    <p>GROSS EARNINGS</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;border-top:.2em solid #bce2c78c ">
                                    <p class="text-right">sdfsd</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;border-top:.2em solid #bce2c78c ">
                                    <p class="text-right">sdfsd</p>
                                </td>
                                <td colspan="3" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;border-top:.2em solid #bce2c78c ">
                                    <p>Other Deduction</p>
                                </td>
                                <td colspan="2" class="" align=""
                                    style="padding:.5em 1.5em .2em .5em;border-top:.2em solid #bce2c78c ">
                                    <p class="text-right">sdfsd</p>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="12" class="" align="" style="padding-top:1em">
                                    <div
                                        style="padding:1.3em 2em;border:.1em dashed #015e1c;border-radius:1em;text-align:center;">
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
                                <td colspan="4" class="" align="">
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
