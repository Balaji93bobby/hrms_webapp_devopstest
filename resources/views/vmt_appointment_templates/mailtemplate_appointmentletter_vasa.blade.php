@extends('layouts.master')
@section('title')
    @lang('translation.settings')
@endsection
@section('css')
    <style>
        .main-page {
            width: 210mm;
            min-height: 297mm;
            margin: 10mm auto;
            background: white;
            box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
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
    </style>
@endsection
@section('content')
    @component('components.configuration_breadcrumb')
        @slot('li_1')
        @endslot
    @endcomponent
    <div class="container-fluid bg-white  ">
        <div class="fill salary-header nav-tab-header">
            <div>
                <ul class="nav nav-pills    nav-tabs-dashed" id="pills-tab" role="tablist">
                    <li class="nav-item active ember-view mx-4" role="presentation">
                        <a class="nav-link active ember-view " id="pills-home-tab" data-bs-toggle="pill" href=""
                            data-bs-target="#appointment" role="tab" aria-controls="pills-home" aria-selected="true">
                            Appointment Letter</a>
                    </li>
                    <li class="nav-item mx-4 ember-view" role="presentation ">
                        <a class="nav-link ember-view" id="payslips-tab" data-bs-toggle="pill" data-bs-target="#payslips"
                            type="button" role="tab" aria-controls="payslips" aria-selected="false">Pay Slip</a>
                    </li>

                </ul>

            </div>

        </div>

        <div class="tab-content " id="pills-tabContent">
            <div class="tab-pane fade show active" id="appointment" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="container-fluid appointment-letter h-100">
                    <div class="d-flex align-items-center justify-content-center flex-column">
                        <div class="empty-state-help-centered ind-empty-state">
                            <img src="https://css.zohostatic.in/zfpayroll/zpayrollportal///assets/it-empty-state-68d45ef7fddba0f96b1ec6b7664ace53.svg"
                                class="empty-state-image">

                        </div>
                        <div class="empty-state-content">
                            <h3 class="">No Data</h3>
                        </div>

                    </div>
                </div>


            </div>

            <div class="tab-pane fade  " id="payslips" role="tabpanel" aria-labelledby="pills-home-tab">

                <div class="container-fluid m-2 pdf-container ">
                    <div class="main-page">
                        <div class="sub-page" style="text-align: justify;font-size: 15px;">
                            <div class="table-responsive">
                                <table cellspacing="0" cellpadding="0" class="payslip_table">
                                    <tr class="header-row" aria-rowcount="">
                                        <td colspan="8" class="border-less p3" rowspan="">
                                            <!-- <div class="header-cotent">

                                                        <h6 class="margin-0">Brand Avatar LLP</h6>
                                                        <p class="mb-0">NO-01,Kandasamy Street,</p>
                                                        <p class="mb-0">Chandrabagh Ave 2nd St, Dr. Radha Krishnan Salai, </p>
                                                        <p class="mb-0">Mylapore, Chennai, Tamil Nadu 600004</p>
                                                    </div> -->
                                        </td>
                                        <td colspan="4" class="border-less p3">

                                            <div class="header-img txt-right d-flex align-items-center"
                                                style="height:100px ;">
                                                <img src="" title="">
                                                <img src="{{ URL::asset('assets/images/vasa.jpg') }}" class=""
                                                    alt="" style="height: 100px;width:250px;max-height:100%;">
                                            </div>


                                        </td>
                                    </tr>


                                    <tr>
                                        <td colspan="12">
                                            <p class="sub-header txt-center bg-ash text-strong">PAYSLIP FOR THE MONTH OF
                                                &ndash;APR-2022</p>
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
                                            <p class="txt-center"></p>
                                        </td>
                                        <td colspan="4" class="">
                                            <p class="txt-center"></p>
                                        </td>
                                        <td colspan="4" class="">
                                            <p class="txt-center"></p>
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
                                            <p class="txt-center"></p>
                                        </td>
                                        <td colspan="3" class="">
                                            <p class="txt-center"></p>
                                        </td>
                                        <td colspan="3" class="">
                                            <p class="txt-center"></p>
                                        </td>
                                        <td colspan="3" class="">
                                            <p class="txt-center"></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="bg-ash text-strong">
                                            <p class="txt-center">CL/SL OpenBalance</p>
                                        </td>
                                        <td colspan="2" class="bg-ash text-strong ">
                                            <p class="txt-center">PL OpenBalance</p>
                                        </td>

                                        <td colspan="2" class="bg-ash text-strong">
                                            <p class="txt-center">Availed CL/SL</p>
                                        </td>
                                        <td colspan="2" class="bg-ash text-strong">
                                            <p class="txt-center">Availed PL</p>
                                        </td>
                                        <td colspan="2" class="bg-ash text-strong">
                                            <p class="txt-center">Balance CL/SL</p>
                                        </td>
                                        <td colspan="2" class="bg-ash text-strong">
                                            <p class="txt-center">Balance PL</p>
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
                                            <p class="txt-left text-strong">ESIC</p>
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
                                            <p class="txt-left text-strong">PT</p>
                                        </td>
                                        <td colspan="2" class="">
                                            <p class="txt-right"></p>
                                        </td>


                                    </tr>


                                    <tr>
                                        <td colspan="2" class="">
                                            <p class="txt-left text-strong"> COMMUNICATION ALLOWANCE </p>
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
                                            <p class="txt-left text-strong"> FOOD ALLOWANCE </p>
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
                                            <p class="txt-left text-strong">FOOD DEDUCTION</p>
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
                                            <p class="txt-right"> </p>
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
                                        <td colspan="12">
                                            <p class="txt-center">This is a computer-generated slip does not require
                                                signature</p>
                                        </td>
                                    </tr>

                                    <tr class="border-less">
                                        <td colspan="8" class="border-less">
                                            <p class="txt-left">Please
                                                reach out to us for any payroll queries at -payroll@ardens.in</p>
                                        </td>
                                        <td colspan="2" class="border-less ">
                                            <p class="txt-right">Generated By</p>


                                        </td>
                                        <td colspan="2" class="border-less">
                                            <img src="{{ URL::asset('assets/images/client_logos/ardens/evangelist.png') }}" width="80px" height="15px"
                                            alt="" class="">
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
