<?php

$general_info = \DB::table('vmt_client_master')->first();
//$employee_name =  \DB::table('users')->where('user_code','=',$employee->EMP_NO)->first('name');
$client_logo = request()->getSchemeAndHttpHost() . '' . $general_info->client_logo;
// dd(request()->getSchemeAndHttpHost()."".$general_info->client_logo);


?>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">


    <style>
        table {
            width: 100%;
            vertical-align: middle;
            border-collapse: collapse;
            border: 1.5pt solid #00678a;
        }

        .payslip_table tr td {
            border: 1.5pt solid #00678a;
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
        <tr class="header-row" aria-rowcount="">
            <td colspan="8" class="border-less p3" rowspan="">
                <div class="header-cotent">

                    <h6 class="margin-0" style="padding-left: 5px">Langro India Private
                        Limited
                    </h6>
                    <p class="mb-0">Dugar Towers, 2nd floor,</p>
                    <p class="mb-0">#34/123, Marshalls Road, Egmore,</p>
                    <p class="mb-0">Chennai, Tamil Nadu, India 600 008. </p>
                </div>
            </td>
            <td colspan="4" class="border-less p3">

                <div class="header-img txt-right d-flex align-items-center">
                    <img src="{{ URL::asset('assets/images/client_logos/vasa/logo_langro.jpg') }}" class=""
                        alt="" style="height: 100px;width:250px;max-height:100%;">
                </div>


            </td>
        </tr>


        <tr>
            <td colspan="12" class=" bg-ash ">
                <p class="sub-header txt-center text-strong">PAYSLIP FOR THE MONTH OF – NOV
                    – 2022</p>
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
                <p class="txt-center">-</p>
            </td>
            <td colspan="4" class="">
                <p class="txt-center">-</p>
            </td>
            <td colspan="4" class="">
                <p class="txt-center">-</p>
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
                <p class="txt-center">-</p>
            </td>
            <td colspan="3" class="">
                <p class="txt-center">-</p>
            </td>
            <td colspan="3" class="">
                <p class="txt-center">-</p>
            </td>
            <td colspan="3" class="">
                <p class="txt-center">-</p>
            </td>
        </tr>

        <tr>
            <td colspan="12">
                <p class="padding-md"></p>
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
                <p class="txt-left text-strong">VPF</p>
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
                <p class="txt-left text-strong">ESIC</p>
            </td>
            <td colspan="2" class="">
                <p class="txt-right"></p>
            </td>


        </tr>
        <tr>
            <td colspan="2" class="">
                <p class="txt-left text-strong">OTHER ALLOWANCE </p>
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
                <p class="txt-left text-strong">PROF TAX</p>
            </td>
            <td colspan="2" class="">
                <p class="txt-right"></p>
            </td>


        </tr>
        <tr>
            <td colspan="2" class="">
                <p class="txt-left text-strong"> OTHER EARNINGS </p>
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
                <p class="txt-left text-strong">OTHERDEDUCTIONS</p>
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
            <td colspan="12" class="bg-ash">
                <p class="txt-center text-strong">Leave Details </p>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="bg-ash">
                <p class="txt-center text-strong">Leave’s Type</p>
            </td>
            <td colspan="3" class="bg-ash">
                <p class="txt-center text-strong">Opening Balance</p>
            </td>
            <td colspan="3" class="bg-ash">
                <p class="txt-center text-strong">Availed Leaves</p>
            </td>
            <td colspan="3" class="bg-ash">
                <p class="txt-center text-strong">Closing Balance</p>
            </td>
        </tr>

        <tr>
            <td colspan="4" class="bg-ash">
                <p class="txt-center text-strong">Casual Leave / Sick Leave</p>
            </td>
            <td colspan="3" class="">
                <p class="txt-center text-strong"></p>
            </td>
            <td colspan="3" class="">
                <p class="txt-center text-strong"></p>
            </td>
            <td colspan="3" class="">
                <p class="txt-center text-strong"></p>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="bg-ash">
                <p class="txt-center text-strong">Earned Leave</p>
            </td>
            <td colspan="3" class="">
                <p class="txt-center text-strong"></p>
            </td>
            <td colspan="3" class="">
                <p class="txt-center text-strong"></p>
            </td>
            <td colspan="3" class="">
                <p class="txt-center text-strong"></p>
            </td>
        </tr>
        <tr>
            <td colspan="12">
                <p class="txt-center">This is a computer-generated slip does not require
                    signature</p>
            </td>
        </tr>

        <tr class="border-less">
            <td colspan="8" class="border-less">
                <p class="txt-left">Please reach out to us for any payroll queries at
                    -hr.admin@imcvasa.in</p>
            </td>
            <td colspan="2" class="border-less ">
                <p class="txt-right">Generated By</p>


            </td>
            <td colspan="2" class="border-less">

                <img src="{{ URL::asset('assets/images/client_logos/ardens/evangelist.png') }}" width="80px"
                    height="15px" alt="" class="">
            </td>
        </tr>

    </table>
</body>

</html>
