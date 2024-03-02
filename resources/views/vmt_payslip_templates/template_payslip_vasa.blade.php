<?php

$general_info = \DB::table('vmt_client_master')->first();
//$employee_name =  \DB::table('users')->where('user_code','=',$employee->EMP_NO)->first('name');
$client_logo = request()->getSchemeAndHttpHost() . '' . $general_info->client_logo;
// dd(request()->getSchemeAndHttpHost()."".$general_info->client_logo);
$bank_names = \DB::table('vmt_banks')->get();

?>
<?php
//$client_logo = request()->getSchemeAndHttpHost() . session()->get('client_logo_url');
$bank_names = \DB::table('vmt_banks')->get();
//dd($client_logo);
?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">


    <style>
        table {
            width: 100%;
            vertical-align: middle;
            font-family: sans-serif;
        }

        .payslip_table tr,
        .payslip_table td {
            border: 1.5pt solid #ea141c;

        }

        .navy-blue {
            color: #213060;
        }




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

        .payslip_table tr p,
        .payslip_table td p {
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

        .payslip_table td .bg-ash,.payslip_table tr .bg-ash  {
            background-color: #9e9e9e5c;
        }
    </style>
</head>

<body>
    <table cellspacing="0" cellpadding="0" class="payslip_table">
        <tr class="header-row">
            <td colspan="8" class="" style="border-right:0px;">
                <div class="header-cotent" style="margin: 1px;">
                    <p class=" text-strong"
                    style="color: #002f56;
                    padding-left: 5px;font-size:18px;margin:0px;">Precede
                        Workforce Solutions India Private Limited</p>
                    <p class="" style="margin:0px;">No: 2/29, Vengaivasal Main Road, Santhosapuram,</p>
                    <p class="" style="margin:0px;">East Tambaram, Chennai – 600 073,
                    </p>
                    <p class="" style="margin:0px;">Tamil Nadu, India.</p>
                </div>
            </td>
            <td colspan="4" class="" style="border-left:0px;" align="">
                <div class="header-img txt-right"
                    style="padding-right: 10px;height:55px;width:200px;padding-left:40px;">
                    {{-- <div class="header-img txt-right" style="padding-right: 10px;"> --}}
                    <img src="{{$client_logo }}" class="" alt="logo"
                        style="height:100%;width:100%;">
                </div>
            </td>
        </tr>



        <tr>
            <td colspan="12" class="bg-ash">
                <p class="sub-header navy-blue txt-center text-strong">PAYSLIP FOR THE MONTH OF &ndash;
                    {{-- {{ \Carbon\Carbon::parse($emp_payroll_month->payroll_date)->format('M  y') }} --}}
                    <span style="text-transform:uppercase;">  {{ strtoupper(date('M-Y', strtotime($emp_payroll_month->payroll_date))) }} </span>
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="bg-ash text-strong">
                <p class="navy-blue">EMPLOYEE NAME</p>
            </td>
            <td colspan="3">
                <p>{{ $employee_name }}</p>
            </td>
            <td colspan="3" class="bg-ash text-strong">
                <p class="navy-blue">EMPLOYEE CODE</p>
            </td>
            <td colspan="3">
                <p>{{ $employee_code }}</p>
            </td>

        </tr>
        <tr>
            <td colspan="3" class="bg-ash text-strong">
                <p class="navy-blue">DATE OF BIRTH</p>
            </td>
            <td colspan="3">
                <p>{{ date('d-M-Y', strtotime($employee_details->dob)) }}</p>
            </td>
            <td colspan="3" class="bg-ash text-strong">
                <p class="navy-blue">DATE OF JOINING</p>
            </td>
            <td colspan="3">
                <p>{{ date('d-M-Y', strtotime($employee_details->doj)) }}</p>
            </td>

        </tr>
        <tr>
            <td colspan="3" class="bg-ash text-strong">
                <p class="navy-blue">DESIGNATION</p>
            </td>
            <td colspan="3">
                <p>{{ $employee_office_details->designation }}</p>
            </td>
            <td colspan="3" class="bg-ash text-strong">
                <p class="navy-blue">LOCATION</p>
            </td>
            <td colspan="3">
                <p>{{ $employee_details->location }}</p>
            </td>

                </tr>
                <tr>
                    <td colspan="3" class="bg-ash text-strong">
                        <p>EPF NUMBER</p>
                    </td>
                    <td colspan="3">
                        <p>{{ $employee_statutory_details->epf_number }}</p>
                    </td>
                    <td colspan="3" class="bg-ash text-strong">
                        <p>ESIC NUMBER</p>
                    </td>
                    <td colspan="3">
                        <p>{{ $employee_statutory_details->esic_number }}</p>
                    </td>

                </tr>
                <tr>
                    <td colspan="3" class="bg-ash text-strong">
                        <p>UAN</p>
                    </td>
                    <td colspan="3">
                        <p>{{ $employee_statutory_details->uan_number }}</p>
                    </td>
                    <td colspan="3" class="bg-ash text-strong">
                        <p>PAN</p>
                    </td>
                    <td colspan="3">
                        <p>{{ $employee_details->pan_number }}</p>
                    </td>

        </tr>
        <tr>
            <td colspan="4" class="bg-ash ">
                <p class="text-strong navy-blue txt-center">BANK NAME</p>
            </td>

            <td colspan="4" class="bg-ash ">
                <p class="text-strong navy-blue txt-center">ACCOUNT NUMBER</p>
            </td>
            <td colspan="4" class="bg-ash ">
                <p class="text-strong txt-center navy-blue">IFSC CODE</p>
            </td>

        </tr>
        <tr>
            <td colspan="4" class="">
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
            <td colspan="4" class="">
                <p class="txt-center">{{ $employee_details->bank_account_number }}</p>
            </td>
            <td colspan="4" class="">
                <p class="txt-center">{{ $employee_details->bank_ifsc_code }}</p>
            </td>


        </tr>

        <tr>
            <td colspan="3" class="bg-ash ">
                <p class="text-strong txt-center navy-blue">MONTH DAYS</p>
            </td>

            <td colspan="3" class="bg-ash ">
                <p class="text-strong txt-center navy-blue">WORKED DAYS</p>
            </td>
            <td colspan="3" class="bg-ash ">
                <p class="text-strong txt-center navy-blue">LOSS OF PAY</p>
            </td>
            <td colspan="3" class="bg-ash ">
                <p class="text-strong txt-center navy-blue">ARREAR DAYS</p>
            </td>

        </tr>
        <tr>
            <td colspan="3" class="">
                <p class="txt-center">{{ $employee_payslip->month_days }}</p>
            </td>
            <td colspan="3" class="">
                <p class="txt-center">{{ $employee_payslip->worked_Days }}</p>
            </td>
            <td colspan="3" class="">
                <p class="txt-center">{{ $employee_payslip->lop }}</p>
            </td>
            <td colspan="3" class="">
                <p class="txt-center">{{ $employee_payslip->arrears_Days }}</p>
            </td>
        </tr>
        <tr>

            <td colspan="2" class="bg-ash text-strong ">
                <p class="txt-center navy-blue">SL OpenBalance</p>
            </td>
            <td colspan="2" class="bg-ash text-strong">
                <p class="txt-center navy-blue">CL OpenBalance</p>
            </td>
            <td colspan="2" class="bg-ash text-strong">
                <p class="txt-center navy-blue">Availed SL</p>
            </td>
            <td colspan="2" class="bg-ash text-strong">
                <p class="txt-center navy-blue">Availed CL</p>
            </td>
            <td colspan="2" class="bg-ash text-strong">
                <p class="txt-center navy-blue">Balance SL</p>
            </td>
            <td colspan="2" class="bg-ash text-strong">
                <p class="txt-center navy-blue">Balance CL</p>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="">
                <p class="txt-center">{{ $employee_payslip->sl_opn_bal }}</p>
            </td>
            <td colspan="2" class="">
                <p class="txt-center">-</p>
            </td>
            <td colspan="2" class="">
                <p class="txt-center">{{ $employee_payslip->availed_sl }}</p>
            </td>
            <td colspan="2" class="">
                <p class="txt-center">-</p>
            </td>
            <td colspan="2" class="">
                <p class="txt-center">{{ $employee_payslip->balance_sl }}</p>
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
                <p class="txt-center text-strong navy-blue">DESCRIPTION</p>
            </td>
            <td colspan="2" class="bg-ash">
                <p class="txt-center text-strong navy-blue">FIXED GROSS</p>
            </td>
            <td colspan="2" class="bg-ash">
                <p class="txt-center text-strong navy-blue">ARREAR GROSS</p>
            </td>
            <td colspan="2" class="bg-ash">
                <p class="txt-center text-strong navy-blue">EARNED GROSS</p>
            </td>
            <td colspan="2" class="bg-ash">
                <p class="txt-center text-strong navy-blue">DEDUCTION</p>
            </td>
            <td colspan="2" class="bg-ash">
                <p class="txt-center text-strong navy-blue">AMOUNT</p>
            </td>

        </tr>
        <tr>
            <td colspan="2" class="">
                <p class="txt-left text-strong navy-blue">BASIC</p>
            </td>
            <td colspan="2" class="">
                <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">{{ number_format(round((float) $employee_payslip->basic), 2) }}</p>
            </td>
            <td colspan="2" class="">
                <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">{{ number_format(round((float) $employee_payslip->basic_arrear), 2) }}
                </p>
            </td>
            <td colspan="2" class="">
                <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">{{ number_format(round($employee_payslip->earned_basic), 2) }}</p>
            </td>
            <td colspan="2" class="">
                <p class="txt-left text-strong navy-blue">EPF</p>
            </td>
            <td colspan="2" class="">
                <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">{{ number_format(round($employee_payslip->epfr), 2) }}</p>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="">
                <p class="txt-left text-strong navy-blue">HRA</p>
            </td>
            <td colspan="2" class="">
                <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">{{ number_format(round($employee_payslip->hra), 2) }}</p>
            </td>
            <td colspan="2" class="">
                <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">{{ number_format(round((float) $employee_payslip->hra_arrear), 2) }}
                </p>
            </td>
            <td colspan="2" class="">
                <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">{{ number_format(round($employee_payslip->earned_hra), 2) }}</p>
            </td>
            <td colspan="2" class="">
                <p class="txt-left text-strong  navy-blue">ESIC</p>
            </td>
            <td colspan="2" class="">
                <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">{{ number_format(round((float) $employee_payslip->employee_esic), 2) }}
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="">
                <p class="txt-left text-strong  navy-blue">STATS BONUS</p>
            </td>
            <td colspan="2" class="">
                <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">{{ $employee_payslip->stats_bonus }}</p>

            </td>
            <td colspan="2" class="">
                <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">{{ $employee_payslip->earned_stats_arrear }}</p>
            </td>
            <td colspan="2" class="">
                <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">{{ $employee_payslip->earned_stats_bonus }}</p>

            </td>
            <td colspan="2" class="">
                <p class="txt-left text-strong  navy-blue">PT</p>
            </td>
            <td colspan="2" class="">
                <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">{{ number_format(round($employee_payslip->prof_tax), 2) }}</p>
            </td>


        </tr>
        <tr>
            <td colspan="2" class="">
                <p class="txt-left text-strong  navy-blue">SPECIAL ALLOW</p>
            </td>
            <td colspan="2" class="">
                <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">{{ number_format(round((float) $employee_payslip->spl_alw), 2) }}
                </p>
            </td>
            <td colspan="2" class="">
                <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">{{ number_format(round((float) $employee_payslip->spl_alw_arrear), 2) }}
                </p>
            </td>
            <td colspan="2" class="">
                <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">{{ number_format(round((float) $employee_payslip->earned_spl_alw), 2) }}
                </p>
            </td>
            <td colspan="2" class="">
                <p class="txt-left text-strong  navy-blue">INCOME TAX</p>
            </td>
            <td colspan="2" class="">
                <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">{{ number_format(round((float) $employee_payslip->income_tax), 2) }}
                </p>
                <p class="txt-right"></p>
            </td>


        </tr>

        <tr>
            <td colspan="2" class="">
                <p class="txt-left text-strong  navy-blue"> OVERTIME</p>
            </td>
            <td colspan="2" class="">
                <p class="txt-right"></p>
            </td>
            <td colspan="2" class="">
                <p class="txt-right"></p>
            </td>

            <td colspan="2" class="">
                <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">{{ number_format(round((float) $employee_payslip->overtime), 2) }}
                </p>
            </td>
            <td colspan="2" class="">
                <p class="txt-left text-strong navy-blue">SALARY ADVANCE</p>
            </td>
            <td colspan="2" class="">
                <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;"> {{ number_format(round((float) $employee_payslip->sal_adv), 2) }}
                </p>
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
                <p class="txt-left text-strong navy-blue">OTHER DEDUCTIONS</p>
            </td>
            <td colspan="2" class="">
                <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">{{ number_format(round((float) $employee_payslip->other_deduc), 2) }}
                </p>
            </td>
        </tr>
        <tr class=" text-strong ">
            <td colspan="2" class="bg-ash">
                <p class="txt-left text-strong navy-blue">TOTAL EARNINGS</p>
            </td>
            <td colspan="2" class=" bg-ash">
                <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">{{ number_format(round((float) $employee_payslip->total_fixed_gross), 2) }}
                </p>
            </td>
            <td colspan="2" class="bg-ash">
                <p class="txt-right"></p>
            </td>

            <td colspan="2" class="bg-ash">
                <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">
                    {{ number_format(round((float) $employee_payslip->total_earned_gross), 2) }}</p>
            </td>
            <td colspan="2" class="bg-ash">
                <p class="txt-left text-strong navy-blue">TOTAL DEDUCTION</p>
            </td>
            <td colspan="2" class="bg-ash">
                <p class="txt-right"><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">{{ number_format(round($employee_payslip->total_deductions), 2) }}
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="12">
                <p class="padding-md">&nbsp; </p>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="bg-ash">
                <p class="txt-left text-strong navy-blue">NET PAY</p>
            </td>
            <td colspan="8" class="">
                <p class="txt-center ext-strong "><img height="8.5" width="12"
                        src="{{ URL::asset('assets/images/inr_png.png') }}" class="txt-right" alt=""
                        style="padding-right:0px;">
                    {{ number_format(round($employee_payslip->net_take_home), 2) }}</p>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="bg-ash">
                <p class="txt-left text-strong navy-blue">NET PAY IN WORDS</p>
            </td>
            <td colspan="8" class="">
                <p class="txt-center ">{{ $employee_payslip->rupees }}</p>
            </td>
        </tr>
        <tr>
            <td colspan="12">
                <p class="padding-md">&nbsp; </p>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="bg-ash">
                <p class="txt-center text-strong navy-blue">TRANSACTION ID</p>
            </td>
            <td colspan="3" class="">
                <p class="txt-center"></p>
            </td>
            <td colspan="3" class="bg-ash">
                <p class="txt-center text-strong navy-blue">Paid Date</p>
            </td>
            <td colspan="3" class="">
                <p class="txt-center">{{ \Carbon\Carbon::parse($emp_payroll_month->payroll_date)->format('M  Y') }}
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="12">
                <p class="padding-md">&nbsp; </p>
            </td>
        </tr>

        <tr>
            <td colspan="12">
                <p class="txt-center "> <i class="navy-blue"> This is a computer-generated slip does not require
                        signature</i>
                </p>
            </td>
        </tr>

        <tr class="border-less">
            <td colspan="8" class="border-less" style="    padding: 10px 0px;">
                <p class="txt-left navy-blue text-strong">Please
                    reach out to us for any payroll queries at-info@precedehrsolutions.com</p>
            </td>
            <td colspan="3" class="border-less txt-right" style="    padding: 10px;">
                <p class="navy-blue">Generated By</p>

            </td>
            <td colspan="1" class="border-less" style="    padding: 10px 0px;">
                <img src="{{ URL::asset('assets/images/client_logos/ardens/evangelist.png') }}" width="100px"
                    height="18px" alt="" class="">
            </td>
        </tr>

    </table>

</body>

</html>
