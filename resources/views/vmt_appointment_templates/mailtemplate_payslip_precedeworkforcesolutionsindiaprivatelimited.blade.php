<?php

$general_info = \DB::table('vmt_client_master')->first();
//$employee_name =  \DB::table('users')->where('user_code','=',$employee->EMP_NO)->first('name');
$client_logo = request()->getSchemeAndHttpHost() . '' . $general_info->client_logo;
// dd(request()->getSchemeAndHttpHost()."".$general_info->client_logo);
$bank_names = \DB::table('vmt_banks')->get();

?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">


    <style>
        table {
            width: 100%;
            vertical-align: middle;
            border-collapse: collapse;
            border: 1.5pt solid #c33a36;

        }

        .payslip_table tr td {
            border: 1.5pt solid #c33a36;
            padding: 0px 4px;

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
    </style>
</head>

<body>
    <table cellspacing="0" cellpadding="0" class="payslip_table">
        <tr class="header-row">
            <td colspan="8" class="border-less">
                <div class="header-cotent" style="margin: 10px;">
                    <p class="margin-0 brand-name " style="font-size: 18px;">Precede Workforce Solutions</p>
                    <p class="mb-0">No: 2,Vengaivasal main road,</p>
                    <p class="mb-0"> Santhoshapuram,medavakkam</p>
                    <p class="mb-0">Chennai -600073,Tamilnadu.</p>
                </div>
            </td>
            <td colspan="4" class="border-less">

                <div class="header-img txt-right" style="padding-right: 10px;">

                    <img src="{{ URL::asset('assets/images/precede.png') }}" class="" alt="logo"
                        style="height:55px;width:180px;">
                </div>


            </td>
        </tr>


        <tr>
            <td colspan="12" class="bg-ash">
                <p class="sub-header txt-center  text-strong">PAYSLIP FOR THE MONTH OF &ndash; Xyz
                </p>
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
                <p></p>
            </td>
            <td colspan="4" class="">
                <p></p>
            </td>
            <td colspan="4" class="">
                <p></p>
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
                <p></p>
            </td>
            <td colspan="3" class="">
                <p></p>
            </td>
            <td colspan="3" class="">
                <p></p>
            </td>
            <td colspan="3" class="">
                <p></p>
            </td>
        </tr>
        <tr>

            <td colspan="2" class="bg-ash text-strong ">
                <p class="txt-center">SL OpenBalance</p>
            </td>
            <td colspan="2" class="bg-ash text-strong">
                <p class="txt-center">CL OpenBalance</p>
            </td>
            <td colspan="2" class="bg-ash text-strong">
                <p class="txt-center">Availed SL</p>
            </td>
            <td colspan="2" class="bg-ash text-strong">
                <p class="txt-center">Availed CL</p>
            </td>
            <td colspan="2" class="bg-ash text-strong">
                <p class="txt-center">Balance SL</p>
            </td>
            <td colspan="2" class="bg-ash text-strong">
                <p class="txt-center">Balance CL</p>
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
                <p></p>
            </td>
            <td colspan="2" class="">
                <p></p>
            </td>
            <td colspan="2" class="">
                <p></p>
            </td>
            <td colspan="2" class="">
                <p class="txt-left text-strong">EPF</p>
            </td>
            <td colspan="2" class="">
                <p></p>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="">
                <p class="txt-left text-strong">HRA</p>
            </td>
            <td colspan="2" class="">
                <p></p>
            </td>
            <td colspan="2" class="">
                <p></p>
            </td>
            <td colspan="2" class="">
                <p></p>
            </td>
            <td colspan="2" class="">
                <p class="txt-left text-strong">ESIC</p>
            </td>
            <td colspan="2" class="">
                <p></p>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="">
                <p class="txt-left text-strong">SPECIAL ALLOW</p>
            </td>
            <td colspan="2" class="">
                <p></p>
            </td>
            <td colspan="2" class="">
                <p></p>
            </td>
            <td colspan="2" class="">
                <p></p>
            </td>
            <td colspan="2" class="">
                <p class="txt-left text-strong">PT</p>
            </td>
            <td colspan="2" class="">
                <p></p>
            </td>


        </tr>

        <tr>
            <td colspan="2" class="">
                <p class="txt-left text-strong"> OVERTIME</p>
            </td>
            <td colspan="2" class="">
                <p class="txt-right"></p>
            </td>
            <td colspan="2" class="">
                <p class="txt-right"></p>
            </td>

            <td colspan="2" class="">
                <p></p>
            </td>
            <td colspan="2" class="">
                <p class="txt-left text-strong">TDS</p>
            </td>
            <td colspan="2" class="">
                <p></p>
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
                <p class="txt-left text-strong">CANT-DEDUCTION</p>
            </td>
            <td colspan="2" class="">
                <div class="tab-pane fade  " id="payslips" role="tabpanel" aria-labelledby="pills-home-tab">

                </div </td>
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
                <p></p>
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
                <p></p>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="">
                <p class="txt-left text-strong">TOTAL EARNINGS</p>
            </td>
            <td colspan="2" class="">
                <p></p>
            </td>
            <td colspan="2" class="">
                <p class="txt-right"></p>
            </td>

            <td colspan="2" class="">
                <p class="txt-right"></p>
            </td>
            <td colspan="2" class="">
                <p class="txt-left text-strong">TOTAL DEDUCTION</p>
            </td>
            <td colspan="2" class="">
                <p></p>
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
                <p></p>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="bg-ash">
                <p class="txt-left text-strong">NET PAY IN WORDS</p>
            </td>
            <td colspan="8" class="">
                <p></p>
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
                <p class="txt-center">11-MAY-2022</p>
            </td>
        </tr>
        <tr>
            <td colspan="12">
                <p class="padding-md">&nbsp; </p>
            </td>
        </tr>
        <tr>
            <td colspan="12">
                <p class="txt-center">This is a computer-generated slip does not require signature
                </p>
            </td>
        </tr>

        <tr class="border-less">
            <td colspan="8" class="border-less" style="    padding: 10px 0px;">
                <p class="txt-left">Please
                    reach out to us for any payroll queries at -payroll@ardens.in</p>
            </td>
            <td colspan="3" class="border-less txt-right" style="    padding: 10px;">
                <p>Generated By</p>


            </td>
            <td colspan="1" class="border-less" style="    padding: 10px 0px;">
                <img src="{{ URL::asset('assets/images/client_logos/ardens/evangelist.png') }}" width="80px"
                    height="15px" alt="" class="">
            </td>
        </tr>

    </table>

</body>

</html>
