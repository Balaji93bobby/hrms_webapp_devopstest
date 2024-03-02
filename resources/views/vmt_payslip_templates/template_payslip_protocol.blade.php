<?php

$general_info = \DB::table('vmt_client_master')->first();
//$employee_name =  \DB::table('users')->where('user_code','=',$employee_payslip->EMP_NO)->first('name');
//$client_logo = request()->getSchemeAndHttpHost() . '' . $general_info->client_logo;
// dd(request()->getSchemeAndHttpHost()."".$general_info->client_logo);
$bank_names = \DB::table('vmt_banks')->get();

?>
<html>



<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> --}}
</head>

<style>
    table {
        width: 100%;
        vertical-align: middle;
    }

    .page {
        background: #fff;
        display: block;
        margin: 0 auto;
        margin-bottom: 0.5cm;
        /* box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
        font-family: Arial; */
    }

    .page[size="A4"] {
        width: 25cm;
        height: 29.7cm;
    }

    .payslip_table tr,
    .payslip_table td {
        border: 1.5pt solid #903700;
        font-family: Arial;

    }

    .border-less {
        border: 0px !important;
    }

    tr {
        height: 12.55pt;
    }

    table.protocol-payslip-table td p {
        font-size: 9pt;
        margin-top: 3pt;
        margin-bottom: 3pt;
        padding: 0.5px 5px;
    }

    td {
        width: 81.35pt;
        /* color: #002f56; */
        /* padding: 1.5px; */
    }


    .margin-0 {
        margin: 0px;
    }

    .margin_b0 {
        margin-bottom: 0px;
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

    .payslip_table td .bg-ash,
    .payslip_table tr .bg-ash {
        background-color: #9e9e9e5c;
    }
</style>
</head>

<body>
    {{-- <div class="main-page"> --}}
    <div class="page" style="text-align: justify;">

        <table cellspacing="0" cellpadding="0" class="payslip_table protocol-payslip-table">
            {{-- <tr class="border-less">
                    <td class="border-less" colspan="12">
                        <img src="{{ URL::asset('assets/images/header_protocolo.svg') }}" class="" alt=""
                        style="width:100%;height:100%;">
                    </td>
                </tr> --}}
            <tr class="header-row" aria-rowcount="">
                <td colspan="16" class="border-less  " rowspan="">
                    <div class="" style="margin:1px;">
                        <p class=" text-strong"
                            style="color: #002f56;
                            padding-left: 5px;font-size:18px;margin:0px;">
                            Protocol Labels India Pvt. Ltd.</p>
                        <p class="" style="margin:0px;">#3rd floor, S plot no 3A&3B, </p>
                        <p class="" style="margin:0px;">166, Gerugambakkam, Bharathi Nagar,Porur,</p>
                        <p class="" style="margin:0px;"> Chennai, Tamil Nadu 600128.</p>

                    </div>
                </td>
                <td colspan="8" class="border-less ">

                    <div class="header-img txt-right " style="">

                        <img src="{{ URL::asset('assets/images/protocol_logo.png') }}" class="txt-right" alt=""
                            style="height: 100px;width:135px;margin-top: -42px;
                                margin-right: 20px;">
                    </div>


                </td>
            </tr>


            <tr>
                <td colspan="24" class=" bg-ash">
                    <p class=" txt-center   text-strong">PAYSLIP FOR THE MONTH OF &ndash;
                        {{-- {{ \Carbon\Carbon::parse($emp_payroll_month->payroll_date)->format('M  y') }} --}}
                        {{ strtoupper(date('M-Y', strtotime($emp_payroll_month->payroll_date))) }}
                        {{-- strtoupper(substr(date("M"),2));?> --}}
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="6" class="  bg-ash text-strong">
                    <p> EMPLOYEE NAME</p>
                </td>
                <td colspan="6">
                    <p>{{ $employee_name }}</p>
                </td>
                <td colspan="6" class="  bg-ash text-strong">
                    <p> EMPLOYEE CODE</p>
                </td>
                <td colspan="6">
                    <p>{{$employee_code }}</p>
                </td>

            </tr>
            <tr>
                <td colspan="6" class=" bg-ash text-strong">
                    <p>DATE OF BIRTH</p>
                </td>
                <td colspan="6">
                    <p>{{ date('d-M-Y', strtotime($employee_details->dob)) }}</p>
                </td>
                <td colspan="6" class=" bg-ash text-strong">
                    <p>DATE OF JOINING</p>
                </td>
                <td colspan="6">
                    <p>{{ date('d-M-Y', strtotime($employee_details->doj)) }}</p>
                </td>

            </tr>
            <tr>
                <td colspan="6" class=" bg-ash text-strong">
                    <p>DESIGNATION</p>
                </td>
                <td colspan="6">
                    <p>{{ $employee_office_details->designation }}</p>
                </td>
                <td colspan="6" class=" bg-ash text-strong">
                    <p>LOCATION</p>
                </td>
                <td colspan="6">
                    <p>{{ $employee_details->location }}</p>
                </td>

            </tr>
            <tr>
                <td colspan="6" class=" bg-ash text-strong">
                    <p>EPF NUMBER</p>
                </td>
                <td colspan="6">
                    <p>{{ $employee_statutory_details->epf_number ?? '0' }}</p>
                </td>
                <td colspan="6" class=" bg-ash text-strong">
                    <p>ESIC NUMBER</p>
                </td>
                <td colspan="6">
                    <p>{{ $employee_statutory_details->esic_number ?? '0' }}</p>
                </td>

            </tr>
            <tr>
                <td colspan="6" class=" bg-ash text-strong">
                    <p>UAN</p>
                </td>
                <td colspan="6">
                    <p>{{$employee_statutory_details->uan_number ?? '0' }}</p>
                </td>
                <td colspan="6" class=" bg-ash text-strong">
                    <p>PAN</p>
                </td>
                <td colspan="6">
                    <p>{{ $employee_details->pan_number }}</p>
                </td>

            </tr>
            <tr>
                <td colspan="8" class=" bg-ash ">
                    <p class="text-strong txt-center">BANK NAME</p>
                </td>

                <td colspan="8" class=" bg-ash ">
                    <p class="text-strong txt-center">ACCOUNT NUMBER</p>
                </td>
                <td colspan="8" class=" bg-ash ">
                    <p class="text-strong txt-center">IFSC CODE</p>
                </td>

            </tr>
            <tr>
                <td colspan="8" class="">
                    <?php
                    $bank_name = '';
                    foreach ($bank_names as $singleBank) {
                        if ($singleBank->id == $employee_details->bank_id) {
                            $bank_name = $singleBank->bank_name;
                            break;
                        }
                    }
                    ?>
                    <p class="txt-center">{{ $bank_name }}</p>
                </td>
                <td colspan="8" class="">
                    <p class="txt-center">{{ $employee_details->bank_account_number }}</p>
                </td>
                <td colspan="8" class="">
                    <p class="txt-center">{{ $employee_details->bank_ifsc_code }}</p>
                </td>


            </tr>

            <tr>
                <td colspan="6" class=" bg-ash ">
                    <p class="text-strong txt-center">MONTH DAYS</p>
                </td>

                <td colspan="6" class=" bg-ash ">
                    <p class="text-strong txt-center">WORKED DAYS</p>
                </td>
                <td colspan="6" class=" bg-ash ">
                    <p class="text-strong txt-center">LOSS OF PAY</p>
                </td>
                <td colspan="6" class=" bg-ash ">
                    <p class="text-strong txt-center">ARREAR DAYS</p>
                </td>

            </tr>
            <tr>
                <td colspan="6" class="">
                    <p class="txt-center">{{ $employee_payslip->month_days }}</p>
                </td>
                <td colspan="6" class="">
                    <p class="txt-center">{{ $employee_payslip->worked_Days }}</p>
                </td>
                <td colspan="6" class="">
                    <p class="txt-center">{{ $employee_payslip->lop }}</p>
                </td>
                <td colspan="6" class="">
                    <p class="txt-center">{{ $employee_payslip->arrears_Days }}</p>
                </td>

            <tr>
                <td colspan="24">
                    <p class="">&nbsp; </p>
                </td>
            </tr>
            <tr>
                <td colspan="4" class=" bg-ash">
                    <p class="txt-center text-strong">DESCRIPTION</p>
                </td>
                <td colspan="4" class=" bg-ash">
                    <p class="txt-center text-strong">FIXED GROSS</p>
                </td>
                <td colspan="4" class=" bg-ash">
                    <p class="txt-center text-strong">ARREAR GROSS</p>
                </td>
                <td colspan="4" class=" bg-ash">
                    <p class="txt-center text-strong">EARNED GROSS</p>
                </td>
                <td colspan="4" class=" bg-ash">
                    <p class="txt-center text-strong">DEDUCTION</p>
                </td>
                <td colspan="4" class=" bg-ash">
                    <p class="txt-center text-strong">AMOUNT</p>
                </td>

            </tr>
            <tr>
                <td colspan="4" class="">
                    <p class="txt-left text-strong">BASIC</p>
                </td>
                <td colspan="4" class="">
                    <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">
                        {{ number_format((int) $employee_payslip->basic, 2) }}</p>
                </td>
                <td colspan="4" class="">
                    <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">
                        {{ number_format(round($employee_payslip->basic_arrear), 2) }}</p>
                </td>
                <td colspan="4" class="">
                    <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">
                        {{ number_format(round($employee_payslip->earned_basic), 2) }}</p>
                </td>
                <td colspan="4" class="">
                    <p class="txt-left text-strong">EPF</p>
                </td>
                <td colspan="4" class="">
                    <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">
                        {{ number_format(round($employee_payslip->epfr), 2) }}</p>
                </td>
            </tr>
            <tr>
                <td colspan="4" class="">
                    <p class="txt-left text-strong">HRA</p>
                </td>
                <td colspan="4" class="">
                    <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">
                        {{ number_format((int) $employee_payslip->hra, 2) }}</p>
                </td>
                <td colspan="4" class="">
                    <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">
                        {{ number_format(round($employee_payslip->hra_arrear), 2) }}</p>
                </td>
                <td colspan="4" class="">
                    <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">
                        {{ number_format(round($employee_payslip->earned_hra), 2) }}</p>
                </td>
                <td colspan="4" class="">
                    <p class="txt-left text-strong">ESIC</p>
                </td>
                <td colspan="4" class="">
                    <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">
                        {{ number_format(round($employee_payslip->employee_esic), 2) }}</p>
                </td>
            </tr>
            <tr>
                <td colspan="4" class="">
                    <p class="txt-left text-strong">SPECIAL ALLOWANCE</p>
                </td>
                <td colspan="4" class="">
                    <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">
                        {{ number_format(round($employee_payslip->spl_alw), 2) }}</p>
                </td>
                <td colspan="4" class="">
                    <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">
                        {{ number_format(round($employee_payslip->spl_alw_arrear), 2) }}</p>
                </td>
                <td colspan="4" class="">
                    <p class="txt-right">
                        <img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">
                        {{ number_format(round($employee_payslip->earned_spl_alw), 2) }}</p>
                </td>
                <td colspan="4" class="">
                    <p class="txt-left text-strong">PROF TAX</p>
                </td>
                <td colspan="4" class="">
                    <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">
                        {{ number_format(round($employee_payslip->prof_tax), 2) }}</p>
                </td>


            </tr>

            <tr>
                <td colspan="4" class="">
                    <p class="txt-left text-strong"> OVERTIME</p>
                </td>
                <td colspan="4" class="">
                    <p class="txt-right"></p>
                </td>
                <td colspan="4" class="">
                    <p class="txt-right"></p>
                </td>

                <td colspan="4" class="">
                    <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">
                        {{ number_format(round($employee_payslip->overtime), 2) }}</p>
                </td>
                <td colspan="4" class="">
                    <p class="txt-left text-strong">INCOME TAX</p>
                </td>
                <td colspan="4" class="">
                    <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">
                        {{ number_format(round($employee_payslip->income_tax), 2) }}</p>
                </td>
            </tr>
            <tr>
                <td colspan="4" class="">
                    <p class="txt-left text-strong">OTHER EARNINGS</p>
                </td>
                <td colspan="4" class="">
                    <p class="txt-right"></p>
                </td>
                <td colspan="4" class="">
                    <p class="txt-right"></p>
                </td>

                <td colspan="4" class="">
                    <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">
                        {{ number_format(round($employee_payslip->other_earnings ), 2) }}
                    </p>
                </td>
                <td colspan="4" class="">
                    <p class="txt-left text-strong">SALARY ADVANCE</p>
                </td>
                <td colspan="4" class="">
                    <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">
                        {{ number_format(round($employee_payslip->sal_adv), 2) }}
                    </p>
                </td>
            </tr>

            <tr>
                <td colspan="4" class="">
                    <p class="txt-left  text-strong">TRAVAL CONVEYANCE</p>
                </td>
                <td colspan="4" class="">
                    <p class="txt-right"></p>
                </td>
                <td colspan="4" class="">
                    <p class="txt-right"></p>
                </td>

                <td colspan="4" class="">
                    <p class="txt-right"></p>
                </td>
                <td colspan="4" class="">
                    <p class="txt-left  text-strong">OTHER DEDUCTIONS</p>
                </td>
                <td colspan="4" class="">
                    <p class="txt-right "><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">
                        {{ number_format(round($employee_payslip->other_deduc), 2) }}</p>
                </td>
            </tr>
            <tr class="bg-ash text-strong">
                <td colspan="4" class="bg-ash">
                    <p class="txt-left  text-strong ">TOTAL EARNINGS</p>
                </td>
                <td colspan="4" class="bg-ash">
                    <p class="txt-right  ">
                        <img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">
                        {{ number_format(round($employee_payslip->total_fixed_gross ), 2) }}</p>
                </td>
                <td colspan="4" class="bg-ash">
                    <p class="txt-right"></p>
                </td>

                <td colspan="4" class="bg-ash">
                    <p class="txt-right ">
                        <img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">
                        {{ number_format(round($employee_payslip->total_earned_gross), 2) }}
                    </p>
                </td>
                <td colspan="4" class="bg-ash">
                    <p class="txt-left text-strong ">TOTAL DEDUCTION</p>
                </td>
                <td colspan="4" class="bg-ash">
                    <p class="txt-right "><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">
                        {{ number_format(round($employee_payslip->total_deductions), 2) }}</p>
                </td>
            </tr>
            <tr>
                <td colspan="24">
                    <p class="">&nbsp;</p>
                </td>
            </tr>
            <tr>
                <td colspan="8" class=" bg-ash">
                    <p class="txt-left text-strong">NET PAY</p>
                </td>
                <td colspan="16" class="">
                    <p class="txt-center "> <img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">  {{ number_format(round($employee_payslip->net_take_home), 2) }}</p>
                </td>
            </tr>
            <tr>
                <td colspan="8" class=" bg-ash">
                    <p class="txt-left text-strong">NET PAY IN WORDS</p>
                </td>
                <td colspan="16" class="">
                    <p class="txt-center ">{{ $employee_payslip->rupees }}</p>
                </td>
            </tr>
            <tr>
                <td colspan="24">
                    <p class="">&nbsp;</p>
                </td>
            </tr>
            <tr>
                <td colspan="6" class=" bg-ash">
                    <p class="txt-center text-strong">TRANSACTION ID</p>
                </td>
                <td colspan="6" class="">
                    <p class="txt-center"></p>
                </td>
                <td colspan="6" class=" bg-ash">
                    <p class="txt-center text-strong">Paid Date</p>
                </td>
                <td colspan="6" class="">
                    <p class="txt-center"></p>
                </td>
            </tr>
            <tr>
                <td colspan="24">
                    <p class="">&nbsp;</p>
                </td>
            </tr>
            <tr>
                <td colspan="24" class="bg-ash">
                    <p class=" text-strong txt-center">Leave Details</p>
                </td>
            </tr>
            <tr>
                <td colspan="6" class=" bg-ash">
                    <p class="txt-center  text-strong">Leave's Type</p>
                </td>
                <td colspan="6" class=" bg-ash">
                    <p class="txt-center  text-strong">Opening Balance</p>
                </td>
                <td colspan="6" class=" bg-ash">
                    <p class="txt-center  text-strong">Availed Balance</p>
                </td>
                <td colspan="6" class=" bg-ash">
                    <p class="txt-center text-strong">Closing Balance</p>
                </td>
            </tr>
            <tr>
                <td colspan="6" class=" bg-ash">
                    <p class="txt-center text-strong">Casual Leave</p>
                </td>
                <td colspan="6" class="">
                    <p class="txt-center">{{ $employee_payslip->sl_opn_bal }}</p>
                </td>
                <td colspan="6" class="">
                    <p class="txt-center">{{ $employee_payslip->availed_sl }}</p>
                </td>
                <td colspan="6" class="">
                    <p class="txt-center">{{ $employee_payslip->balance_sl }}</p>
                </td>
            </tr>
            <tr>
                <td colspan="6" class=" bg-ash">
                    <p class="txt-center text-strong">Sick Leave</p>
                </td>
                <td colspan="6" class="">
                    <p class="txt-center">{{ $employee_payslip->sl_opn_bal }}</p>
                </td>
                <td colspan="6" class="">
                    <p class="txt-center">{{ $employee_payslip->availed_sl }}</p>
                </td>
                <td colspan="6" class="">
                    <p class="txt-center">{{ $employee_payslip->balance_sl }}</p>
                </td>
            </tr>
            <tr>
                <td colspan="6" class=" bg-ash">
                    <p class="txt-center text-strong">Earned Leave</p>
                </td>
                <td colspan="6" class="">
                    <p class="txt-center">{{ $employee_payslip->el_opn_bal }}</p>
                </td>
                <td colspan="6" class="">
                    <p class="txt-center">{{ $employee_payslip->availed_el }}</p>
                </td>
                <td colspan="6" class="">
                    <p class="txt-center">{{ $employee_payslip->balance_el }}</p>
                </td>
            </tr>
            <tr>
                <td colspan="24">
                    <p class="txt-center">This is a computer-generated slip does not require signature</p>
                </td>
            </tr>

            <tr class="border-less">
                <td colspan="18" class="border-less" style="    padding: 10px 0px;">
                    <p class="txt-left">Please
                        reach out to us for any payroll queries at -payroll@ardens.in</p>
                </td>
                <td colspan="4" class="border-less txt-right" style="    padding: 10px 0px;">
                    <p>Generated By</p>

                </td>
                <td colspan="2" class="border-less" style="    padding: 10px 0px;">
                    <img src="{{ URL::asset('assets/images/client_logos/ardens/evangelist.png') }}" width="100px"
                        height="18px" alt="" class="">
                </td>

            </tr>

            {{-- <tr class="border-less">
                    <td colspan="12" class="border-less">
                        <img src="{{ URL::asset('assets/images/footerProtocolImg_payslip.svg') }}" class="" alt=""
                        style="height:100%;width:100%;">
                    </td>
                </tr> --}}

        </table>

    </div>
    {{-- </div> --}}

</body>

</html>
