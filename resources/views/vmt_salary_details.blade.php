<?php use Carbon\Carbon; ?>
@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('public\assets\css\payCheck.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="mt-30 salary-details-wrapper ">

        <div class="card mb-2 left-line">
            <div class="card-body pt-1 pb-0">
                {{-- <div class="fill salary-header mb-3 nav-tab-header"> --}}


                    <ul class="nav nav-pills    nav-tabs-dashed" id="pills-tab" role="tablist">
                        {{-- <li class="nav-item active ember-view mx-4" role="presentation">
                    <a class="nav-link active ember-view " id="pills-home-tab" data-bs-toggle="pill" href="" data-bs-target="#salary-structure" role="tab" aria-controls="pills-home" aria-selected="true">
                        Salary Structure</a>
                </li> --}}
                        <li class="nav-item me-4 ember-view" role="presentation ">
                            <a class="nav-link  active  show ember-view" id="payslips-tab" data-bs-toggle="pill"
                                data-bs-target="#payslips" type="button" role="tab" aria-controls="payslips"
                                aria-selected="false">Payslips</a>
                        </li>
                        <!--<li class="nav-item mx-4 ember-view" role="presentation ">-->
                        <!--    <a class="nav-link ember-view" id="annual-earnings-tab" data-bs-toggle="pill"-->
                        <!--        data-bs-target="#annual-earnings" type="button" role="tab"-->
                        <!--        aria-controls="annual-earnings" aria-selected="false"> Annual Earnings</a>-->
                        <!--</li>-->
                        <!--<li class="nav-item mx-4 ember-view" role="presentation">-->
                        <!--    <a class="nav-link ember-view" id="annual-earnings-tab" data-bs-toggle="pill"-->
                        <!--        data-bs-target="#epf-contribution" type="button" role="tab"-->
                        <!--        aria-controls="annual-earnings" aria-selected="false"> EPF Contribution Summar</a>-->
                        <!--</li>-->
                    </ul>
                {{-- </div> --}}
            </div>
        </div>
        <div class="card">
            <div class="card-body">



                <div class="tab-content " id="pills-tabContent">
                    {{-- <div class="tab-pane fade show active" id="salary-structure" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="zp-container nav-tab-body-top">
                <div class="fill body scroll-x scroll-y scrollbox">
                    <!---->
                    <div class="salary-details-summary-band">
                        <div class="salary-summary-chart">
                            <div id="ember192" class="ember-view"><svg width="100%" height="135" viewBox="0 0 135 135" preserveAspectRatio="xMidYMid meet">
                                    <g class="pie-container" transform="translate(67.5, 67.5)">
                                        <path d="M4.133182947122317e-15,-67.5A67.5,67.5 0 1,1 -29.505314248938,-60.70985448073003L-20.762998915919333,-42.721749449402616A47.5,47.5 0 1,0 2.9085361479749637e-15,-47.5Z" class="arc cursor-pointer" style="fill: #002f56;"></path>
                                        <path d="M-29.505314248938,-60.70985448073003A67.5,67.5 0 0,1 -29.505314248938,-60.70985448073003L-20.762998915919333,-42.721749449402616A47.5,47.5 0 0,0 -20.762998915919333,-42.721749449402616Z" class="arc cursor-pointer" style="fill: rgb(71, 178, 255);"></path>
                                        <path d="M-29.505314248938,-60.70985448073003A67.5,67.5 0 0,1 -1.2399548841366951e-14,-67.5L-8.72560844392489e-15,-47.5A47.5,47.5 0 0,0 -20.762998915919333,-42.721749449402616Z" class="arc cursor-pointer" style="fill: rgb(255, 209, 99);"></path>
                                    </g><text class="default-text" dx="67.5" dy="70.5">Salary Breakup</text>
                                </svg></div>
                        </div>
                        <div class="summary-content w-100">
                            <div class="row">
                                <div class="col-xs-4 pull-right">
                                    <!---->
                                </div>
                                <div class="col-xs-12">
                                    <p class="text-light-black font-moderate font-mediumbold" style="margin-bottom: 4px;">
                                        Monthly CTC: <span>₹{{($result['CTC'])/12}}</span>
                                        <span class="separation-line"></span>
                                        <a class="font-sm  font-regular text-secondary" data-ember-action="" data-ember-action-193="193">

                                            <i class="icon icon-lg  ri-download-2-line"></i>

                                            Download
                                        </a>
                                    </p>
                                    <div class="group font-small text-light-grey">
                                        Yearly CTC: ₹{{$result['CTC']}}
                                    </div>
                                    <div class="salary-components-section">
                                        <div class="salary-component-item earnings">
                                            <p class=" font-mm text-grey">Earnings</p>
                                            <p class="font-medium">₹{{$result['TOTAL_EARNED_GROSS']}}</p>
                                        </div>
                                        <div class="salary-component-item reimbursements">
                                            <p class=" font-mm text-grey">Reimbursements</p>
                                            <p class="font-medium">₹0.00</p>
                                        </div>
                                        <div class="salary-component-item deductions">
                                            <p class=" font-mm text-grey">Deductions</p>
                                            <p class="font-medium">₹{{$result['TOTAL_DEDUCTIONS']}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="salary-details-content">
                        <div class="group">
                            <table class="table zp-table salary-details-table">
                                <tbody>
                                    <tr>
                                        <td colspan="2" class="row-group ">
                                            <h5 class="fw-bold">Earnings </h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="75%" class="text-grey text-muted">
                                            Basic
                                        </td>
                                        <td width="25%" class="text-right font-medium font-mediumbold ">
                                            ₹{{$result['BASIC']}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="75%" class="text-grey text-muted">
                                            House Rent Allowance
                                        </td>
                                        <td width="25%" class="text-right font-medium font-mediumbold ">
                                            ₹{{$result['HRA']}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="75%" class="text-grey text-muted">
                                            Fixed Allowance
                                        </td>
                                        <td width="25%" class="text-right font-medium font-mediumbold">
                                            ₹{{$result['TOTAL_FIXED_GROSS']}}
                                        </td>
                                    </tr>
                                    <!---->
                                    <!---->
                                    <tr>
                                        <td colspan="2" class="row-group">
                                            <h5 class="fw-bold">Deductions </h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-grey text-muted">
                                            EPF - Employer Contribution
                                        </td>
                                        <td class="text-right font-medium font-mediumbold">
                                            ₹{{$compensatory && $compensatory->epf_employer_contribution ? $compensatory->epf_employer_contribution : 0}}
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="1">
                                            <div class="pull-right">
                                                <span class="vertical-align-text-bottom ctc-label mx-2">Monthly
                                                    CTC</span>

                                            </div>
                                        </td>
                                        <td>
                                            <span class="font-mediumbold font-moderate">
                                                ₹{{($result['CTC'])/12}}
                                            </span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!---->
                        <!---->
                    </div>
                </div>

                <div class="split-up-view split-up-slider salary-revision-split-up ">
                    <!---->
                </div>

            </div>
        </div> --}}
                    <div class="tab-pane show active fade" id="payslips" role="tabpanel" aria-labelledby="payslips-tab">
                        <div class="zp-container bg-white nav-tab-body-top">
                            <div>
                                {{-- <div class="fill body payslip-filter-container ">
                        <i class="icon icon-blue icon-xlg vertical-align-text-bottom text-secondary ri-filter-2-fill"> </i>
                        <div class="dropdown cursor-pointer payslip-dropdown">
                            <div id="ember127" class="ember-view">
                                <div class="dropdown-toggle" data-toggle="dropdown">
                                    <span>Financial Year : </span>
                                    <span class="font-semibold fw-bold text-dark h5">2022 - 23</span>
                                    <span class="caret "></span>
                                </div>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li data-ember-action="" data-ember-action-129="129"><a>2022 - 23</a></li>

                                </ul>
                            </div>
                        </div>
                    </div> --}}
                                <div id="ember130 " class="ember-view">
                                    <div class="fill body p-0 payslip-list-body scroll scroll-x scroll-y scrollbox ">
                                        <table class="table zp-table paystub-table">
                                            <thead class="fw-bold text-muted h5">
                                                <tr>
                                                    <th width="">Month</th>
                                                    <th width="">Gross Pay</th>
                                                    <th width="">Reimbursements</th>
                                                    <th width="">Deductions</th>
                                                    <th width="">Take Home</th>
                                                    <th width="" class="text-capitalize">payslip</th>
                                                    <!--<th width="">Tax Worksheet</th>-->
                                                    <th width="">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $d)
                                                    <?php //dd($data->toArray()); ?>


                                                    <tr data-ember-action="" data-ember-action-131="131">
                                                        <td>
                                                            <span>
                                                                {{ Carbon::parse($d->PAYROLL_MONTH)->format('M-y') }}
                                                            </span>

                                                        </td>
                                                        <td>₹{{ $d->TOTAL_EARNED_GROSS }}
                                                        </td>
                                                        <td>₹0.00</td>
                                                        <td>₹{{ $d->TOTAL_DEDUCTIONS }}</td>
                                                        <td>₹{{ $d->NET_TAKE_HOME }}</td>
                                                        <td>
                                                            <div data="{{ $d->PAYROLL_MONTH }}"
                                                                data-url="{{ route('vmt_paycheck_employee_payslip_htmlview') }}"
                                                                style="cursor: pointer"
                                                                class="ember-view  paySlipView text-info">

                                                                View
                                                            </div>
                                                        </td>
                                                        <!--<td>-->
                                                        <!--    <a href=""-->
                                                        <!--        class="ember-view  text-info">-->
                                                        <!--        View-->
                                                        <!--    </a>-->
                                                        <!--</td>-->
                                                        <td>
                                                            @php
                                                                $selectedPaySlipMonth = $d->PAYROLL_MONTH;
                                                            @endphp
                                                            {{-- <div data="{{ $d->PAYROLL_MONTH }}"
                                                                data-url="{{ route('vmt_paycheck_employee_payslip_pdf') }}"
                                                                style="cursor: pointer"
                                                                class="ember-view  paySlipPDF text-info">
                                                                Download PDF
                                                            </div> --}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane " id="annual-earnings" role="tabpanel" aria-labelledby="annual-earnings-tab">
                        <div class="zp-container bg-white nav-tab-body-top">
                            <div class="fill body content scroll-x scroll-y salary-details-container">
                                <div>
                                    <div class="ytd-summary-column">
                                        <div class="row group">
                                            <h4 class="col-md-7 col-sm-12 col-xs-12 font-semibold font-moderate">For the
                                                financial year: 2022 - 23</h4>
                                            <div class="col-md-5 col-sm-12 col-xs-12 m-0 ytd-chart-filter text-right">


                                                <i
                                                    class="icon text-secondary icon-blue icon-xlg vertical-align-text-bottom  ri-filter-2-fill"></i>

                                                <div class="dropdown cursor-pointer payslip-dropdown">
                                                    <div id="ember139" class="ember-view">
                                                        <div class="dropdown-toggle" data-toggle="dropdown">
                                                            <span>Financial Year : </span>
                                                            <span class="font-semibold">2022 - 23</span>
                                                            <span class="caret "></span>
                                                        </div>
                                                        <ul class="dropdown-menu dropdown-menu-right">
                                                            <li data-ember-action="" data-ember-action-141="141"><a>2022 -
                                                                    23</a></li>

                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="ytd-chart-section ytd-summary-column">
                                        <div class="ytd-chart">
                                            <div id="ember142" class="ember-view">
                                                <svg style=" height:300px;width:100%;" viewBox="0 0 900 300"
                                                    preserveAspectRatio="xMinYMid meet">
                                                    <g class="line-container" transform="translate(75, 10)">
                                                        <g class="line-paths">
                                                            <path class="line-path" d="M72,0Z"
                                                                style="stroke: rgb(32, 142, 255); stroke-width: 3px; fill: none;">
                                                            </path>
                                                            <path class="area-path" d="M72,0ZL72,247ZZ"
                                                                style="fill: rgb(248, 251, 255);"></path>
                                                        </g>
                                                        <g class="y-axis">
                                                            <g class="tick" transform="translate(0,250)"
                                                                style="opacity: 1;">
                                                                <line x2="0" y2="0"></line><text
                                                                    dy="0" x="-40" y="0"
                                                                    style="text-anchor: end;">0</text>
                                                            </g>
                                                            <g class="tick" transform="translate(0,192)"
                                                                style="opacity: 1;">
                                                                <line x2="0" y2="0"></line><text
                                                                    dy="0" x="-40" y="0"
                                                                    style="text-anchor: end;">5 K</text>
                                                            </g>
                                                            <g class="tick" transform="translate(0,133)"
                                                                style="opacity: 1;">
                                                                <line x2="0" y2="0"></line><text
                                                                    dy="0" x="-40" y="0"
                                                                    style="text-anchor: end;">10 K</text>
                                                            </g>
                                                            <g class="tick" transform="translate(0,75)"
                                                                style="opacity: 1;">
                                                                <line x2="0" y2="0"></line><text
                                                                    dy="0" x="-40" y="0"
                                                                    style="text-anchor: end;">15 K</text>
                                                            </g>
                                                            <g class="tick" transform="translate(0,16)"
                                                                style="opacity: 1;">
                                                                <line x2="0" y2="0"></line><text
                                                                    dy="0" x="-40" y="0"
                                                                    style="text-anchor: end;">20 K</text>
                                                            </g>
                                                            <path class="domain" d="M0,0H0V250H0"></path>
                                                        </g>
                                                        <g class="x-axis" transform="translate(0,250)">
                                                            <g class="tick" transform="translate(0,0)"
                                                                style="opacity: 1;">
                                                                <line y2="-250" x2="0"
                                                                    class="line line-0 cursor-pointer">
                                                                </line><text dy="0" y="20" x="0"
                                                                    style="text-anchor: middle;">
                                                                    <tspan style="font-size: 12px;">Apr</tspan>
                                                                    <tspan x="0" dy="16"
                                                                        style="font-size: 10px;">2022
                                                                    </tspan>
                                                                </text>
                                                            </g>
                                                            <g class="tick" transform="translate(72,0)"
                                                                style="opacity: 1;">
                                                                <line y2="-250" x2="0"
                                                                    class="line line-1 cursor-pointer">
                                                                </line><text dy="0" y="20" x="0"
                                                                    style="text-anchor: middle;">
                                                                    <tspan style="font-size: 12px;">May</tspan>
                                                                    <tspan x="0" dy="16"
                                                                        style="font-size: 10px;">2022
                                                                    </tspan>
                                                                </text>
                                                            </g>
                                                            <g class="tick" transform="translate(147,0)"
                                                                style="opacity: 1;">
                                                                <line y2="-250" x2="0"
                                                                    class="line line-2 cursor-pointer">
                                                                </line><text dy="0" y="20" x="0"
                                                                    style="text-anchor: middle;">
                                                                    <tspan style="font-size: 12px;">Jun</tspan>
                                                                    <tspan x="0" dy="16"
                                                                        style="font-size: 10px;">2022
                                                                    </tspan>
                                                                </text>
                                                            </g>
                                                            <g class="tick" transform="translate(219,0)"
                                                                style="opacity: 1;">
                                                                <line y2="-250" x2="0"
                                                                    class="line line-3 cursor-pointer">
                                                                </line><text dy="0" y="20" x="0"
                                                                    style="text-anchor: middle;">
                                                                    <tspan style="font-size: 12px;">Jul</tspan>
                                                                    <tspan x="0" dy="16"
                                                                        style="font-size: 10px;">2022
                                                                    </tspan>
                                                                </text>
                                                            </g>
                                                            <g class="tick" transform="translate(294,0)"
                                                                style="opacity: 1;">
                                                                <line y2="-250" x2="0"
                                                                    class="line line-4 cursor-pointer">
                                                                </line><text dy="0" y="20" x="0"
                                                                    style="text-anchor: middle;">
                                                                    <tspan style="font-size: 12px;">Aug</tspan>
                                                                    <tspan x="0" dy="16"
                                                                        style="font-size: 10px;">2022
                                                                    </tspan>
                                                                </text>
                                                            </g>
                                                            <g class="tick" transform="translate(369,0)"
                                                                style="opacity: 1;">
                                                                <line y2="-250" x2="0"
                                                                    class="line line-5 cursor-pointer">
                                                                </line><text dy="0" y="20" x="0"
                                                                    style="text-anchor: middle;">
                                                                    <tspan style="font-size: 12px;">Sep</tspan>
                                                                    <tspan x="0" dy="16"
                                                                        style="font-size: 10px;">2022
                                                                    </tspan>
                                                                </text>
                                                            </g>
                                                            <g class="tick" transform="translate(441,0)"
                                                                style="opacity: 1;">
                                                                <line y2="-250" x2="0"
                                                                    class="line line-6 cursor-pointer">
                                                                </line><text dy="0" y="20" x="0"
                                                                    style="text-anchor: middle;">
                                                                    <tspan style="font-size: 12px;">Oct</tspan>
                                                                    <tspan x="0" dy="16"
                                                                        style="font-size: 10px;">2022
                                                                    </tspan>
                                                                </text>
                                                            </g>
                                                            <g class="tick" transform="translate(516,0)"
                                                                style="opacity: 1;">
                                                                <line y2="-250" x2="0"
                                                                    class="line line-7 cursor-pointer">
                                                                </line><text dy="0" y="20" x="0"
                                                                    style="text-anchor: middle;">
                                                                    <tspan style="font-size: 12px;">Nov</tspan>
                                                                    <tspan x="0" dy="16"
                                                                        style="font-size: 10px;">2022
                                                                    </tspan>
                                                                </text>
                                                            </g>
                                                            <g class="tick" transform="translate(588,0)"
                                                                style="opacity: 1;">
                                                                <line y2="-250" x2="0"
                                                                    class="line line-8 cursor-pointer">
                                                                </line><text dy="0" y="20" x="0"
                                                                    style="text-anchor: middle;">
                                                                    <tspan style="font-size: 12px;">Dec</tspan>
                                                                    <tspan x="0" dy="16"
                                                                        style="font-size: 10px;">2022
                                                                    </tspan>
                                                                </text>
                                                            </g>
                                                            <g class="tick" transform="translate(663,0)"
                                                                style="opacity: 1;">
                                                                <line y2="-250" x2="0"
                                                                    class="line line-9 cursor-pointer">
                                                                </line><text dy="0" y="20" x="0"
                                                                    style="text-anchor: middle;">
                                                                    <tspan style="font-size: 12px;">Jan</tspan>
                                                                    <tspan x="0" dy="16"
                                                                        style="font-size: 10px;">2023
                                                                    </tspan>
                                                                </text>
                                                            </g>
                                                            <g class="tick" transform="translate(738,0)"
                                                                style="opacity: 1;">
                                                                <line y2="-250" x2="0"
                                                                    class="line line-10 cursor-pointer">
                                                                </line><text dy="0" y="20" x="0"
                                                                    style="text-anchor: middle;">
                                                                    <tspan style="font-size: 12px;">Feb</tspan>
                                                                    <tspan x="0" dy="16"
                                                                        style="font-size: 10px;">2023
                                                                    </tspan>
                                                                </text>
                                                            </g>
                                                            <g class="tick" transform="translate(805,0)"
                                                                style="opacity: 1;">
                                                                <line y2="-250" x2="0"
                                                                    class="line line-11 cursor-pointer">
                                                                </line><text dy="0" y="20" x="0"
                                                                    style="text-anchor: middle;">
                                                                    <tspan style="font-size: 12px;">Mar</tspan>
                                                                    <tspan x="0" dy="16"
                                                                        style="font-size: 10px;">2023
                                                                    </tspan>
                                                                </text>
                                                            </g>
                                                            <path class="domain" d="M0,-250V0H805V-250"></path>
                                                        </g>
                                                        <g id="points">
                                                            <circle class="point point-0 cursor-pointer" cx="0"
                                                                cy="250" r="0"
                                                                style="stroke: rgb(32, 142, 255);"></circle>
                                                            <circle class="point point-1 cursor-pointer" cx="72"
                                                                cy="0" r="3"
                                                                style="stroke: rgb(32, 142, 255);"></circle>
                                                            <circle class="point point-2 cursor-pointer" cx="147"
                                                                cy="250" r="0"
                                                                style="stroke: rgb(32, 142, 255);"></circle>
                                                            <circle class="point point-3 cursor-pointer" cx="219"
                                                                cy="250" r="0"
                                                                style="stroke: rgb(32, 142, 255);"></circle>
                                                            <circle class="point point-4 cursor-pointer" cx="294"
                                                                cy="250" r="0"
                                                                style="stroke: rgb(32, 142, 255);"></circle>
                                                            <circle class="point point-5 cursor-pointer" cx="369"
                                                                cy="250" r="0"
                                                                style="stroke: rgb(32, 142, 255);"></circle>
                                                            <circle class="point point-6 cursor-pointer" cx="441"
                                                                cy="250" r="0"
                                                                style="stroke: rgb(32, 142, 255);"></circle>
                                                            <circle class="point point-7 cursor-pointer" cx="516"
                                                                cy="250" r="0"
                                                                style="stroke: rgb(32, 142, 255);"></circle>
                                                            <circle class="point point-8 cursor-pointer" cx="588"
                                                                cy="250" r="0"
                                                                style="stroke: rgb(32, 142, 255);"></circle>
                                                            <circle class="point point-9 cursor-pointer" cx="663"
                                                                cy="250" r="0"
                                                                style="stroke: rgb(32, 142, 255);"></circle>
                                                            <circle class="point point-10 cursor-pointer" cx="738"
                                                                cy="250" r="0"
                                                                style="stroke: rgb(32, 142, 255);"></circle>
                                                            <circle class="point point-11 cursor-pointer" cx="805"
                                                                cy="250" r="0"
                                                                style="stroke: rgb(32, 142, 255);"></circle>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ytd-details-section">
                                        <table class="table zp-table ytd-summary-table">
                                            <tbody>
                                                <tr>
                                                    <td class="label-column">
                                                        <table class="table zp-table ytd-summary-column-table">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="ytd-components-header">
                                                                        Earnings
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="component-name">
                                                                        Basic
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="component-name">
                                                                        House Rent Allowance
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="component-name">
                                                                        Fixed Allowance
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="font-mediumbold total-header">
                                                                        Total Earnings
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="ytd-components-header">
                                                                        Contributions
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="component-name">
                                                                        EPF Contribution
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="font-mediumbold total-header">
                                                                        Total Statutories
                                                                    </td>
                                                                </tr>

                                                                <!---->
                                                                <!---->
                                                                <!---->
                                                                <tr>
                                                                    <td class="ytd-components-header">
                                                                        Take Home
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </td>
                                                    <td class="amount-column label-column ytd-amount-column">
                                                        <table class="table zp-table ytd-summary-column-table ">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-right ">
                                                                        <span class="period-header font-semibold">YTD
                                                                            Total</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right">
                                                                        ₹{{ $result['BASIC'] }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right">
                                                                        ₹{{ $result['HRA'] }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right">
                                                                        ₹{{ $result['TOTAL_FIXED_GROSS'] }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="total-header font-mediumbold text-right">
                                                                        ₹{{ $result['TOTAL_EARNED_GROSS'] }}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="empty-cell"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right">
                                                                        ₹{{ $compensatory && $compensatory->epf_employee ? $compensatory->epf_employee : 0 }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="total-header font-mediumbold text-right">
                                                                        ₹--</td>
                                                                </tr>

                                                                <!---->
                                                                <!---->
                                                                <!---->
                                                                <tr>
                                                                    <td class="font-semibold text-right net-pay-field">
                                                                        ₹{{ $result['NET_TAKE_HOME'] }}
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>

                                                    </td>
                                                    <td>
                                                        <div id="ember144" class="ember-view scrollable-table-section">
                                                            <table class="table zp-table monthly-summary-table">
                                                                <tbody>
                                                                    <tr>
                                                                        <!---->
                                                                        <!---->
                                                                        <!---->
                                                                        <!---->
                                                                        <!---->
                                                                        <!---->
                                                                        <!---->
                                                                        <!---->
                                                                        <!---->
                                                                        <!---->
                                                                        <td class="amount-column">
                                                                            <table
                                                                                class="table zp-table ytd-summary-column-table month-table">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td
                                                                                            class="text-right month-header">
                                                                                            <span
                                                                                                class="period-header font-semibold">₹{{ $result['PAYROLL_MONTH'] }}</span>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="text-right">
                                                                                            ₹{{ $result['BASIC'] }}
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="text-right">
                                                                                            ₹{{ $result['HRA'] }}
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="text-right">
                                                                                            ₹{{ $result['TOTAL_FIXED_GROSS'] }}
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td
                                                                                            class="total-header font-mediumbold text-right">
                                                                                            ₹{{ $result['TOTAL_EARNED_GROSS'] }}
                                                                                        </td>
                                                                                    </tr>

                                                                                    <tr>
                                                                                        <td class="empty-cell"></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="text-right">
                                                                                            ₹{{ $compensatory && $compensatory->epf_employee ? $compensatory->epf_employee : 0 }}
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td
                                                                                            class="total-header font-mediumbold text-right">
                                                                                            ₹--</td>
                                                                                    </tr>

                                                                                    <!---->
                                                                                    <!---->
                                                                                    <!---->
                                                                                    <tr>
                                                                                        <td
                                                                                            class="font-semibold text-right net-pay-field">
                                                                                            ₹{{ $result['NET_TAKE_HOME'] }}
                                                                                        </td>
                                                                                    </tr>

                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                        <!---->
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                            <!---->
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="tab-pane fade " id="epf-contribution" role="tabpanel"
                        aria-labelledby="annual-earnings-tab">
                        <div class="zp-container nav-tab-body-top">
                            <div class="fill body scroll-x scroll-y scrollbox salary-details-container">
                                <div id="ember147" class="ember-view">
                                    <div class="benefit-report-container">
                                        <div class="benefit-report-header-block">
                                            {{-- <div class="row group">
                                    <div class="col-xs-10">
                                        <span class="benefit-report-header pull-left">
                                            <span class="report-name font-semibold font-moderate text-overflow">EPF
                                                Contribution Summary</span>
                                            <span class="separation-line"></span>
                                        </span>
                                        <div class="dropdown cursor-pointer benefit-report-filter-dropdown">

                                            <i class="icon icon-blue icon-xlg vertical-align-text-bottom text-secondary  ri-filter-2-fill"></i>

                                            <div id="ember148" class="ember-view pull-left mx-4">
                                                <div class="dropdown-toggle my-1" data-toggle="dropdown">
                                                    <span>Financial Year : </span>
                                                    <span class="font-semibold">2022 - 23</span>
                                                    <span class="caret "></span>
                                                </div>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li data-ember-action="" data-ember-action-150="150"><a>2022
                                                            - 23</a></li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                            <div class="row form-group mb-0">
                                                <div class="col-xs-3 col-lg-3 ps-0 col-md-3 col-xl-3  col-sm-3">
                                                    <div class="media">
                                                        <div class="media-left vertical-align-middle">
                                                            <div class="svg-circled">
                                                                <svg version="1.1" id="Layer_1"
                                                                    xmlns="http://www.w3.org/2000/svg" x="0"
                                                                    y="0" viewBox="0 0 512 512"
                                                                    xml:space="preserve" class="icon icon-xxlg">
                                                                    <path
                                                                        d="M501.6 216l-39-14.7c-10.2-23.4-27-45-48.7-62.8-1.9-1.8-21.9-21-19.6-43.8 2.3-22.5 20.2-34.4 22.2-35.7 4.8-3 6.9-8.9 5.3-14.3-1.7-5.4-6.8-9-12.4-8.8-30.2 1.1-58.8 11.8-80.5 29.9-8 6.7-15.2 14.4-21.3 23-11.3-.7-33.4-1.9-47.2-1.9-56.6 0-109.9 17.4-150.2 48.9-34.5 27-56 61.7-62 99.3-.4.7-1 1.4-1.8 2.2-4.2 4-10.9 4.5-14.2 2.4-4.9-3-7.5-14.8-.7-26.4 3.5-5.9 1.5-13.6-4.4-17.1-5.9-3.5-13.6-1.5-17.1 4.4-6.3 10.6-8.8 22.7-7.2 33.9 1.7 11.6 7.6 21.2 16.3 26.5 5.3 3.2 11.5 4.8 17.8 4.8 3.2 0 6.5-.4 9.7-1.2 2.2 41.2 22.7 79.8 58.4 109.7 1.1 4.9 3.8 19.8 9.3 64.4 2.6 21.2 20.8 37.2 42.2 37.2h46.4c12.4 0 22.5-10.1 22.5-22.5V421c10.3.7 24.5 1.5 35 1.5 8.8 0 17.5-.4 26.2-1.3 0 7.1 0 17.6-.1 32.1-.1 6 2.3 11.7 6.5 16s9.9 6.7 16 6.7h47.9c20.5 0 38-14.6 41.8-34.7 8.6-46.2 12.5-60.2 13.9-64.2 16.4-13.5 35.8-37.2 43.9-47.4l22.9-.1c5.9 0 11-4.2 12.2-10l18-89.3c1.1-6.1-2.2-12.1-8-14.3zM469 304.6l-18.7.1c-3.9 0-7.5 1.8-9.8 4.9-.3.3-26.8 34.9-45.4 49.5-4.5 3.5-7.5 5.9-20.9 77.6-1.5 8.3-8.8 14.3-17.2 14.3h-45.3c.1-7.8.1-17.9.1-26.5 0-5.3-.1-9.4-.1-12.4-.2-5.9-.3-10.5-4.7-14.3-2.8-2.4-6.5-3.5-10.1-2.9-11.9 1.8-24.1 2.7-36.3 2.7-17.1 0-46.2-2.4-46.5-2.5-3.5-.3-6.9.9-9.5 3.3-2.6 2.4-4 5.7-4 9.2V451h-43.9c-8.8 0-16.3-6.6-17.4-15.3-2.3-18.4-4.3-33.6-6.1-45.2-3.9-26.4-5.2-29.7-9.6-33.2-33.6-27.2-52.1-62.7-52.1-100 0-80.1 84.8-145.2 189-145.2 17.9 0 52.3 2.2 52.7 2.3 4.6.3 8.9-1.9 11.4-5.8 5.7-8.9 12.5-16.8 20.5-23.4 10.4-8.7 21.5-14.2 31.9-17.8-3.6 7-6.4 15.4-7.4 25-3.7 36.6 26.7 64 28 65.1.1.1.3.2.4.3 20.2 16.4 35.3 36.5 43.7 58 1.3 3.3 3.9 5.9 7.2 7.2l34.2 12.9-14.1 68.7z">
                                                                    </path>
                                                                    <path fill="#FF8911"
                                                                        d="M288.1 157.5c-14.2-5-36.6-9.9-62.9-5-15.7 2.9-30.4 8.9-43.9 17.7-5.8 3.8-7.4 11.5-3.6 17.3 2.4 3.7 6.4 5.7 10.5 5.7 2.3 0 4.7-.7 6.8-2 10.7-7 22.4-11.7 34.8-14 20.9-3.9 38.7 0 50 4 6.5 2.3 13.7-1.1 15.9-7.6 2.3-6.7-1.1-13.8-7.6-16.1z">
                                                                    </path>
                                                                    <circle cx="383.9" cy="202.5" r="17.5">
                                                                    </circle>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="media-body">
                                                            <label class="text-grey">
                                                                Total Contribution
                                                            </label>
                                                            <div class="font-semibold f-15">
                                                                ₹{{ $compensatory && $compensatory->epf_employer_contribution ? $compensatory->epf_employee + $compensatory->epf_employer_contribution : 0 }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="col-xs-6 col-lg-6 col-md-6 col-xl-6  col-sm-6 contribution-stats ">
                                                    <div class="text-grey mt-1 f-14 mb-2"
                                                        style="margin-top:3px;margin-bottom:8px;">
                                                        Total Employer Contribution : <span
                                                            class="text-black font-medium font-mediumbold">₹{{ $compensatory && $compensatory->epf_employer_contribution ? $compensatory->epf_employer_contribution : 0 }}</span>
                                                    </div>
                                                    <div class="text-grey f-14 mt-1 mb-2">
                                                        Total Employee Contribution : <span
                                                            class="text-black font-medium font-mediumbold">₹{{ $compensatory && $compensatory->epf_employee ? $compensatory->epf_employee : 0 }}</span>
                                                    </div>
                                                </div>
                                                {{-- <div class="col-xs-3 col-lg-3 col-md-3 col-xl-3  col-sm-3">
                                        <button class="btn btn-primary pull-right" data-ember-action="" data-ember-action-151="151">Export PDF</button>
                                    </div> --}}
                                            </div>
                                        </div>
                                        <div class="benefit-report-content-block me-0 mw-100 p-0">
                                            <div class="statutory-details-block my-4">
                                                <div class="statutory-detail-title font-mm text-light-grey">
                                                    <div class="text-uppercase p-0">
                                                        Statutory Details
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="text-light-grey font-mm">PF Account Number</label>
                                                    <div>-</div>
                                                </div>
                                                <div>
                                                    <label class="text-light-grey font-mm">UAN</label>
                                                    <div>-</div>
                                                </div>
                                            </div>
                                            <table class="table zp-table w-100 reports-table">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2">Month</th>
                                                        <th rowspan="2" class="text-right">PF Wages</th>
                                                        <th colspan="2" class="text-center">Employee Contribution</th>
                                                        <th colspan="2" class="text-center">Employer Contribution</th>
                                                        <th rowspan="2" class="text-right">Total Contribution</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-right">EPF</th>
                                                        <th class="text-right">VPF</th>
                                                        <th class="text-right">EPF</th>
                                                        <th class="text-right">EPS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data as $d)
                                                        <tr>
                                                            <td>{{ $d->PAYROLL_MONTH }}</td>
                                                            <td class="text-right">₹{{ $d->PF_WAGES }}</td>
                                                            <td class="text-right">
                                                                ₹{{ $compensatory && $compensatory->epf_employee ? $compensatory->epf_employee : 0 }}
                                                            </td>
                                                            <td class="text-right">
                                                                ₹{{ $compensatory && $compensatory->esic_employee ? $compensatory->esic_employee : 0 }}
                                                            </td>
                                                            <td class="text-right">
                                                                ₹{{ $compensatory && $compensatory->epf_employer_contribution ? $compensatory->epf_employer_contribution : 0 }}
                                                            </td>
                                                            <td class="text-right">
                                                                ₹{{ $compensatory && $compensatory->esic_employer_contribution ? $compensatory->esic_employer_contribution : 0 }}
                                                            </td>
                                                            <td class="text-right">
                                                                ₹{{ $compensatory && $compensatory->epf_employer_contribution ? $compensatory->epf_employee + $compensatory->epf_employer_contribution : 0 }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr class="font-semibold">
                                                        <td>Total</td>
                                                        <td class="text-right">₹{{ $result['TOTAL_PF_WAGES'] }}</td>
                                                        <td class="text-right">
                                                            ₹{{ $compensatory && $compensatory->epf_employee ? $compensatory->epf_employee * count($data) : 0 }}
                                                        </td>
                                                        <td class="text-right">
                                                            ₹{{ $compensatory && $compensatory->esic_employee ? $compensatory->esic_employee * count($data) : 0 }}
                                                        </td>
                                                        <td class="text-right">
                                                            ₹{{ $compensatory && $compensatory->epf_employer_contribution ? $compensatory->epf_employer_contribution * count($data) : 0 }}
                                                        </td>
                                                        <td class="text-right">
                                                            ₹{{ $compensatory && $compensatory->esic_employer_contribution ? $compensatory->esic_employer_contribution * count($data) : 0 }}
                                                        </td>
                                                        <td class="text-right">
                                                            ₹{{ $compensatory && $compensatory->epf_employer_contribution ? ($compensatory->epf_employee + $compensatory->epf_employer_contribution) * count($data) : 0 }}
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>

                                        </div>
                                    </div>





                                </div>
                            </div>
                            <!---->
                        </div>
                    </div>
                </div>



                <div id="payslipModal" class="modal custom-modal fade" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content profile-box">
                            <div class="modal-header  ">
                                <h6 class="modal-title">Pay Slip
                                </h6>
                                <button type="button" class="close  border-0 h3" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div id="slipAfterView">


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- ui notifications -->

    <script src="{{ URL::asset('/assets/libs/prismjs/prismjs.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/notifications.init.js') }}"></script>
    <!-- apexcharts -->

    <!-- dashboard init -->
    <script>
        $(document).ready(function() {

            $('.paySlipView').on('click', function() {
                var url = $(this).attr('data-url');
                var t_paySlipMonth = $(this).attr('data');
                var year = t_paySlipMonth.substring(0,4);
                var month = t_paySlipMonth.substring(5,7);
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        year: year,
                        month:month,
                        uid: "{{ $enc_user_id }}",
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        var content =
                            '<div class="row " style=""><div class=""><div class="fill body payslip-filter-pdf mb-4"> <i class="icon icon-blue icon-xlg vertical-align-text-bottom text-secondary ri-filter-2-fill"> </i> <div class="dropdown cursor-pointer payslip-dropdown"><div id="ember127" class="ember-view"><div class="dropdown-toggle" data-toggle="dropdown"><span>Financial Year : </span><span class="font-semibold fw-bold text-dark h5">2022 - 23</span><span class="caret "></span></div><ul class="dropdown-menu dropdown-menu-right"><li data-ember-action="" data-ember-action-129="129"><a>2022 - 23</a></li> </ul></div></div></div></div><div class="">' +
                            data + '</div></div>';
                        $("#slipAfterView").html(content);
                        $('#payslipModal').modal('show');
                        console.log("Clicked View ");
                    }
                });
            });

            $('.paySlipPDF').on('click', function() {
                var url = $(this).attr('data-url');
                let t_paySlipMonth = $(this).attr('data');
                let enc_userid =  "{{ $enc_user_id }}";

                window.open(url+"?selectedPaySlipMonth="+t_paySlipMonth+"&enc_user_id="+enc_userid,'_blank');
            });

        });
    </script>
@endsection
