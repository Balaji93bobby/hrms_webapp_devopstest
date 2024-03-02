<?php use Carbon\Carbon; ?>
@extends('layouts.master')
@section('css')


<link href="{{ URL::asset('public\assets\css\payCheck.css') }}" rel="stylesheet">


@endsection
@section('content')

<div class="mt-30 salary-details-wrapper ">
    <div class="card">
        <div class="card-body">
    <h6>Internal - Show All Salaries</h6>
    <div class="mb-3 fill salary-header nav-tab-header">

            <ul class="nav nav-pills nav-tabs-dashed" id="pills-tab" role="tablist">
                {{-- <li class="mx-4 nav-item active ember-view" role="presentation">
                    <a class="nav-link active ember-view " id="pills-home-tab" data-bs-toggle="pill" href="" data-bs-target="#salary-structure" role="tab" aria-controls="pills-home" aria-selected="true">
                        Salary Structure</a>
                </li> --}}
                <li class="nav-item me-4 ember-view" role="presentation ">
                    <a class="nav-link active show ember-view" id="payslips-tab" data-bs-toggle="pill" data-bs-target="#payslips" type="button" role="tab" aria-controls="payslips" aria-selected="false">Payslips</a>
                </li>
            </ul>



    </div>

    <div class="tab-content " id="pills-tabContent">
        {{-- <div class="tab-pane fade show active" id="salary-structure" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="zp-container nav-tab-body-top">
                <div class="fill body scroll-x scroll-y scrollbox">
                    <!---->
                    <div class="salary-details-summary-band">
                        <div class="salary-summary-chart">
                            <div id="ember192" class="ember-view"><svg width="100%" height="135" viewBox="0 0 135 135" preserveAspectRatio="xMidYMid meet">
                                    <g class="pie-container" transform="translate(67.5, 67.5)">
                                        <path d="M4.133182947122317e-15,-67.5A67.5,67.5 0 1,1 -29.505314248938,-60.70985448073003L-20.762998915919333,-42.721749449402616A47.5,47.5 0 1,0 2.9085361479749637e-15,-47.5Z" class="cursor-pointer arc" style="fill: #002f56;"></path>
                                        <path d="M-29.505314248938,-60.70985448073003A67.5,67.5 0 0,1 -29.505314248938,-60.70985448073003L-20.762998915919333,-42.721749449402616A47.5,47.5 0 0,0 -20.762998915919333,-42.721749449402616Z" class="cursor-pointer arc" style="fill: rgb(71, 178, 255);"></path>
                                        <path d="M-29.505314248938,-60.70985448073003A67.5,67.5 0 0,1 -1.2399548841366951e-14,-67.5L-8.72560844392489e-15,-47.5A47.5,47.5 0 0,0 -20.762998915919333,-42.721749449402616Z" class="cursor-pointer arc" style="fill: rgb(255, 209, 99);"></path>
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
                                        <a class="font-sm font-regular text-secondary" data-ember-action="" data-ember-action-193="193">

                                            <i class="icon icon-lg ri-download-2-line"></i>

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
                                        <td width="25%" class="font-medium text-right font-mediumbold ">
                                            ₹{{$result['BASIC']}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="75%" class="text-grey text-muted">
                                            House Rent Allowance
                                        </td>
                                        <td width="25%" class="font-medium text-right font-mediumbold ">
                                            ₹{{$result['HRA']}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="75%" class="text-grey text-muted">
                                            Fixed Allowance
                                        </td>
                                        <td width="25%" class="font-medium text-right font-mediumbold">
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
                                        <td class="font-medium text-right font-mediumbold">
                                            ₹{{$compensatory && $compensatory->epf_employer_contribution ? $compensatory->epf_employer_contribution : 0}}
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="1">
                                            <div class="pull-right">
                                                <span class="mx-2 vertical-align-text-bottom ctc-label">Monthly
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
            <div class="bg-white zp-container nav-tab-body-top">
                <div>
                    {{-- <div class="fill body payslip-filter-container ">
                        <i class="icon icon-blue icon-xlg vertical-align-text-bottom text-secondary ri-filter-2-fill"> </i>
                        <div class="cursor-pointer dropdown payslip-dropdown">
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
                        <div class="p-0 fill body payslip-list-body scroll scroll-x scroll-y scrollbox ">
                            <table class="table zp-table paystub-table">
                                <thead class="fw-bold text-muted h5">
                                    <tr>
                                        <th width="">Month</th>
                                        <th width="">Employee Name</th>
                                        {{-- <th width="">Gross Pay</th>
                                        <th width="">Reimbursements</th>
                                        <th width="">Deductions</th>
                                        <th width="">Take Home</th> --}}
                                        <th width="" class="text-capitalize">payslip</th>
                                        <th width="">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $d)
                                    <tr data-ember-action="" data-ember-action-131="131">
                                        <td>
                                            <a href="#/salary-details/payslips/335214000001040001/details" id="ember132" class="ember-view text-secondary">
                                                {{   Carbon::parse($d->PAYROLL_MONTH)->format('M-y') }}
                                            </a>

                                            <span class="status-label">
                                                <!---->
                                            </span>
                                        </td>
                                        <td>
                                            EMP name
                                        </td>
                                        {{-- <td>₹{{$d->TOTAL_EARNED_GROSS}}
                                        </td>
                                        <td>₹0.00</td>
                                        <td>₹{{$d->TOTAL_DEDUCTIONS}}</td>
                                        <td>₹{{$d->NET_TAKE_HOME}}</td> --}}
                                        <td>
                                            <div data="{{$d->PAYROLL_MONTH}}" data-url="{{route('ShowSelectedPayslip',['user_id'=>$user_id])}}" style="cursor: pointer" class="ember-view paySlipView text-info">
                                                View
                                            </div>
                                        </td>
                                        <td>
                                            @php

                                            $selectedPaySlipMonth = $d->PAYROLL_MONTH;
                                            @endphp
                                            <a href="{{ url('pdfview/'.strtoupper($d->EMP_NO).'/'.strtoupper($selectedPaySlipMonth)) }}" class="text-info">Download</a>

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
    </div>



<div id="payslipModal" class="modal custom-modal fade" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content profile-box">
            <div class="modal-header ">
                <h6 class="p-0 m-0 modal-title text-primary">Pay Slip
                </h6>
                <button type="button" class="border-0 close h3" data-bs-dismiss="modal" aria-label="Close">
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
            $.ajax({
                type: "GET",
                url: url,
                data: {
                    selectedPaySlipMonth: t_paySlipMonth
                },
                success: function(data) {
                    var content = '<div class="row " style=""><div class=""><div class="mb-4 fill body payslip-filter-pdf"> <i class="icon icon-blue icon-xlg vertical-align-text-bottom text-secondary ri-filter-2-fill"> </i> <div class="cursor-pointer dropdown payslip-dropdown"><div id="ember127" class="ember-view"><div class="dropdown-toggle" data-toggle="dropdown"><span>Financial Year : </span><span class="font-semibold fw-bold text-dark h5">2022 - 23</span><span class="caret "></span></div><ul class="dropdown-menu dropdown-menu-right"><li data-ember-action="" data-ember-action-129="129"><a>2022 - 23</a></li> </ul></div></div></div></div><div class="">' + data + '</div></div>';
                    $("#slipAfterView").html(content);
                    $('#payslipModal').modal('show');
                    console.log("Clicked View ");
                }
            });
        });
    });
</script>
@endsection
