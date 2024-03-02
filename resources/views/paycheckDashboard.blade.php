    @extends('layouts.master')
    @section('css')
    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">
    <!-- <link href="{{ URL::asset('assets/css/hr_dashboard.css') }}" rel="stylesheet"> -->
    <link href="{{ URL::asset('assets/css/salary.css') }}" rel="stylesheet">

    <!-- for bootstrap temporary -->

    <style type="text/css">

    </style>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script> -->

    <!-- end -->

    <!-- for font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/employee-directory.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/onboarding.css') }}">
    @endsection
    @section('content')


    <div class="home-wrapper mt-30">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-xl-6 col-lg-6  d-flex">
                <div class="card shadow profile-box card-top-border p-2 w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h6 class="">
                                Your Pay Summary
                            </h6>
                            <!-- <button class="btn btn-primary py-1 px-2"> <i class=" ri-calendar-2-line"></i> </button> -->
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <figure class="pie-chart">
                                    <!-- <figcaption>SVG PIE Chart with CSS animation</figcaption> -->
                                    <svg viewBox="0 0 63.6619772368 63.6619772368">
                                        <circle class="pie1" cx="31.8309886184" cy="31.8309886184" r="15.9154943092" />
                                        <!-- <circle class="pie2" cx="31.8309886184" cy="31.8309886184" r="15.9154943092" /> -->
                                        <circle class="pie3" cx="31.8309886184" cy="31.8309886184" r="15.9154943092" />
                                        <circle class="pie4" cx="31.8309886184" cy="31.8309886184" r="15.9154943092" />
                                    </svg>
                                </figure>
                            </div>
                            <div class="col-8 d-flex align-items-center justify-content-center">

                                <div class="d-flex align-items-center justify-content-between">
                                    <div class=" d-flex align-items-center mx-2 flex-column">
                                        <div class="take-home-bar #17b510"></div>
                                        <span>Take Home</span>
                                        <span class="font-large font-mediumbold f-12">₹{{ json_decode($json_PayCheck)->NET_TAKE_HOME }}</span>
                                    </div>
                                    <div class=" d-flex align-items-center mx-2 flex-column">
                                        <div class="deductions-bar"></div>
                                        <span>Deductions</span>
                                        <span class="font-large font-mediumbold f-12 ">₹{{ json_decode($json_PayCheck)->TOTAL_DEDUCTIONS }}</span>
                                    </div>
                                    <div class=" d-flex align-items-center mx-2 flex-column">
                                        <div class="cross-pay-bar "></div>
                                        <span>Cross Pay</span>
                                        <span class="font-large font-mediumbold f-12 ">₹{{ json_decode($json_PayCheck)->TOTAL_FIXED_GROSS }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="text-right">
                                    <button class="btn btn-primary">
                                        View
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-xl-6 col-lg-6 d-flex">
                <div class="card shadow profile-box card-top-border p-2 flex-fill">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="">
                                EPF Summary
                            </h6>
                            <button class="btn btn-primary px-2 py-1"> <i class=" ri-calendar-2-line"></i> </button>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <ul class="personal-info">
                                    <li>
                                        <div class="title  text-muted ">Total Contribution</div>
                                        <div class="text text-end ">
                                            ₹{{ json_decode($json_PayCheck)->TOTAL_CON }}</div>
                                    </li>
                                    <li>
                                        <div class="title text-muted ">Your Contribution</div>
                                        <div class="text  text-end">
                                            ₹{{ json_decode($json_PayCheck)->epfemployer }}</div>
                                    </li>
                                    <li>
                                        <div class="title text-muted ">Employer Contribution</div>
                                        <div class="text text-end ">
                                            ₹{{ json_decode($json_PayCheck)->your_employee }}</div>
                                    </li>
                                </ul>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="dotted-line pt-2">

                                    <i class="mr-1 text-danger ri-error-warning-fill text-grey"></i>
                                    <span class="opacity-medium f-12">Towards EPF, you contribute 12% of upto ₹
                                        15,000.00 of
                                        your wages (Gross Pay - HRA) and your
                                        employer
                                        contributes another 12% of upto ₹ 15,000.00 of your wages (Gross Pay - HRA).</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-12 col-xl-6 col-lg-6 d-flex">
                <div class="card shadow profile-box card-top-border p-2 flex-fill">
                    <div class="card-body ">
                        <div class="d-flex align-items-center  justify-content-between mb-3">
                            <h6 class="">
                                My Payslip
                            </h6>
                            <div class="btn-group">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class=" ri-calendar-2-line mx-2"></i>FY 2022-23
                                </button>
                                <div class="dropdown-menu">
                                    <p class="dropdown-item" href="#"><i class=" ri-calendar-2-line mx-2"></i>FY
                                        2022-23
                                    </p>
                                    <p class="dropdown-item" href="#"><i class=" ri-calendar-2-line mx-2"></i>FY
                                        2022-23
                                    </p>
                                    <p class="dropdown-item" href="#"><i class=" ri-calendar-2-line mx-2"></i>FY
                                        2022-23</p>
                                </div>

                            </div>

                        </div>
                        <div class="scrollBar" id="wrapper">

                            {{-- <ul class="personal-info force-overflow pr-2">
                                @foreach ($data as $d)
                                <li>
                                    <div class="title text-muted ">

                                        @php
                                        $selectedPaySlipMonth = $d->PAYROLL_MONTH;
                                        @endphp
                                        @php echo $selectedPaySlipMonth; @endphp
                                    </div>

                                    <div class="text h4  text-end">
                                        <a href="{{ url('pdfview/' . $selectedPaySlipMonth) }}"><i class="text-orange fa fa-download"></i></a>
                                        @endforeach

                                    </div>
                                </li>

                            </ul> --}}
                            <div class="text-center">
                                <div class=" row">
                                    <div style="" class="sm-4 mx-auto">
                                        <img src="{{ URL::asset('assets/images/no_dataFile.svg') }}"
                                            class="" alt="" style="height: 150px">
                                    </div>

                                </div>
                                <h4> <span class="text-orange">Sorry !</span> No data</h4>
                            </div>


                        </div>

                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-12 col-xl-6 col-lg-6 ">
                <div class="card shadow profile-box card-top-border p-2 flex-fill">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-">
                            <h6 class="">
                                Tax Complete Sheet
                            </h6>
                            <div class="btn-group">
                                <button class="btn btn-primary btn-sm dropdown-toggle mb-3" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class=" ri-calendar-2-line mx-2"></i>FY 2022-23
                                </button>

                                <div class="dropdown-menu">
                                    <p class="dropdown-item" href="#"><i class=" ri-calendar-2-line mx-2"></i>FY
                                        2022-23
                                    </p>
                                    <p class="dropdown-item" href="#"><i class=" ri-calendar-2-line mx-2"></i>FY
                                        2022-23
                                    </p>
                                    <p class="dropdown-item" href="#"><i class=" ri-calendar-2-line mx-2"></i>FY
                                        2022-23
                                    </p>
                                </div>

                            </div>
                        </div>

                        {{-- <ul class="personal-info">
                            <li>
                                <div class="title f-15 text-muted ">August Salary Slip</div>

                                <div class="text h4  text-end"><i class="text-orange  fa fa-download"></i>
                                </div>
                            </li>
                            <li>
                                <div class="title f-15 text-muted ">September Salary Slip</div>

                                <div class="text h4 text-end "><i class="text-orange fa fa-download"></i>
                                </div>
                            </li>
                            <li>
                                <div class="title f-15 text-muted ">October Salary Slip</div>

                                <div class="text h4 text-end "><i class="text-orange fa fa-download"></i>
                                </div>
                            </li>
                            <li>

                            </li>
                        </ul> --}}

                        <div class="text-center">
                            <div class=" row">
                                <div style="" class="sm-4 mx-auto">
                                    <img src="{{ URL::asset('assets/images/no_dataFile.svg') }}"
                                        class="" alt="" style="height: 150px">
                                </div>

                            </div>
                            <h4> <span class="text-orange">Sorry !</span> No data</h4>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <div class="row">
            <div class="col-sm-12 col-md-12 col-xl-6 col-lg-6 ">
                <div class="card shadow profile-box card-top-border  p-2 ">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="">
                                Tax Deduction TDS/TCS
                            </h6>
                            <div class="btn-group">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class=" ri-calendar-2-line mx-2"></i>FY 2022-23
                                </button>

                                <div class="dropdown-menu">
                                    <p class="dropdown-item" href="#"><i class=" ri-calendar-2-line mx-2"></i>FY
                                        2022-23</p>
                                    <p class="dropdown-item" href="#"><i class=" ri-calendar-2-line mx-2"></i>FY
                                        2022-23</p>
                                    <p class="dropdown-item" href="#"><i class=" ri-calendar-2-line mx-2"></i>FY
                                        2022-23</p>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <ul class="personal-info">
                                    <li>
                                        <div class="title  text-muted f-15 ">Form-16</div>
                                        <div class="text h4 text-end"><i class="text-orange  fa fa-download"></i>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title  text-muted f-15">Form-12BB</div>

                                        <div class="text h4 text-end "><i class="text-orange fa fa-download"></i> </div>
                                    </li>

                                </ul>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-xl-6 col-lg-6 ">
                <div class="card shadow profile-box card-top-border p-2 ">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="">
                                Cost To Company(CTC)
                            </h6>
                            <button class="btn btn-primary "> <i class=" ri-calendar-2-line"></i> </button>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <ul class="personal-info">
                                    <li>
                                        <div class="title">
                                            <div class=" f-15 text-muted ">Total Contribution
                                            </div>
                                            <p class="text-muted mb-0    f-10">(Whole pay structure including all primary
                                                salary
                                                components)</p>
                                        </div>
                                        <div class="text h4 text-end "><i class="text-orange fa fa-download"></i> </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12  col-xl-12 col-md-12 col-lg-12">
                <div class="card declaration-card">
                    <div class="card-body">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active h6" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#declaration" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Declaration</button>
                                <button class="nav-link h6" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Previous Income</button>

                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade" id="declaration" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="card bg-light-red declaration-important-card my-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12  col-xl-12 col-md-12 col-lg-12">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span><i class="ri-alert-fill text-danger"></i>Important</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-12  col-xl-12 col-md-12 col-lg-12">
                                                <ul class="list-style-numbered list-style-circle p-2">
                                                    <li class="text"> '$' - Not considered for exemption if opted for New
                                                        tax regime
                                                        (Section 115BAC).
                                                    </li>
                                                    <li class="text">You can declare your investment amount till 25th of
                                                        every month
                                                        until the cutoff date of Feb 20, 2023.</li>

                                                    <li>Last date for submitting your investment proofs is Feb 20, 2023.
                                                        Not submitting your investment proofs may lead to additional tax
                                                        being deducted in the subsequent months of this fiscal year.!</li>

                                                </ul>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="declaration-tax  mb-n2">
                                    <div class="row">
                                        <div class="col-sm-6 col-xl-3 col-md-4 col-lg-3">
                                            <div class="card  small-card left-line">
                                                <div class="card-body">
                                                    <div class="text-center currency">
                                                        <i class="currency-bg fa fa-rupee"></i>
                                                        <p class="text-muted mb-0">Net Taxable Income</p>
                                                        <h6 class="mb-0">INR 4,66,888</h5>
                                                    </div>
                                                    <p class="text-muted text-end f-10">Income Tax Computation</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xl-3 col-md-4 col-lg-3">
                                            <div class="card  small-card left-line">
                                                <div class="card-body">
                                                    <div class="text-center currency">
                                                        <i class="currency-bg fa fa-rupee"></i>
                                                        <p class="mb-0 text-muted">Total Tax Payable</p>
                                                        <h6>INR 4,66,888</h>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xl-3 col-md-4 col-lg-3">
                                            <div class="card small-card left-line">
                                                <div class="card-body">
                                                    <div class="text-center currency">
                                                        <i class="currency-bg fa fa-rupee"></i>
                                                        <p class="text-muted mb-0">Tax Already Paid</p>
                                                        <h6>INR 4,66,888</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="declaration-wrapper mb-3">
                                    <div class="row">
                                        <div class="col-sm-12  col-xl-12 col-md-12 col-lg-12">
                                            <h6 class="my-2 ">My Declaration</h6>
                                            <div class="table-responsive">
                                                <table class=" table  table-hover  mb-0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th scope="col">Declaration</th>
                                                            <th scope="col">No Of Declaration</th>
                                                            <th scope="col">Amount Declared</th>
                                                            <th scope="col">Proof Submitted</th>
                                                            <th scope="col">Amount Rejected</th>
                                                            <th scope="col">Amount Accepted</th>
                                                    </thead>
                                                    <tbody>

                                                        <tr>

                                                            <td>
                                                                1.5 lac Exemptions
                                                            </td>
                                                            <td>
                                                                3
                                                            </td>
                                                            <td>
                                                                INR 98,897
                                                            </td>
                                                            <td>
                                                                0
                                                            </td>
                                                            <td>
                                                                INR 0
                                                            </td>
                                                            <td>
                                                                INR 65,000
                                                            </td>
                                                        </tr>

                                                        <tr>

                                                            <td>
                                                                Other Exemptions
                                                            </td>
                                                            <td>
                                                                1
                                                            </td>
                                                            <td>
                                                                INR 98,852
                                                            </td>
                                                            <td>
                                                                0
                                                            </td>
                                                            <td>
                                                                INR 0
                                                            </td>
                                                            <td>
                                                                INR 5,600
                                                            </td>
                                                        </tr>
                                                        <tr>

                                                            <td>
                                                                Tax Saving Allowances
                                                            </td>
                                                            <td>
                                                                1
                                                            </td>
                                                            <td>
                                                                INR 98,897
                                                            </td>
                                                            <td>
                                                                0
                                                            </td>
                                                            <td>
                                                                INR 0
                                                            </td>
                                                            <td>
                                                                INR 65,000
                                                            </td>
                                                        </tr>

                                                        <tr>

                                                            <td>
                                                                House Property
                                                            </td>
                                                            <td>
                                                                1
                                                            </td>
                                                            <td>
                                                                INR 98,897
                                                            </td>
                                                            <td>
                                                                0
                                                            </td>
                                                            <td>
                                                                INR 0
                                                            </td>
                                                            <td>
                                                                INR 65,000
                                                            </td>
                                                        </tr>

                                                        <tr>

                                                            <td>
                                                                Income from other sources
                                                            </td>
                                                            <td>
                                                                0 </td>
                                                            <td>
                                                                INR 0
                                                            </td>
                                                            <td>
                                                                0
                                                            </td>
                                                            <td>
                                                                INR 0
                                                            </td>
                                                            <td>
                                                                INR 0
                                                            </td>
                                                        </tr>


                                                    </tbody>

                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tax-deduction-wrapper ">
                                    <h6 class="">Monthly Tax Deduction Details</h6>
                                    <div class="row">
                                        <div class="col-sm-6  col-xl-3 col-md-4 col-lg-3">
                                            <div class="card mini-card-left-line">
                                                <div class="card-body">
                                                    <div class="text-center currency">
                                                        <i class="currency-bg fa fa-rupee"></i>
                                                        <p class="text-muted mb-0">Total Tax Payable</p>
                                                        <h6>INR 48</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6  col-xl-3 col-md-4 col-lg-3">
                                            <div class="card mini-card-left-line">
                                                <div class="card-body">
                                                    <div class="text-center currency">
                                                        <i class="currency-bg fa fa-rupee"></i>
                                                        <p class="text-muted mb-0"> Tax Paid Till Now</p>
                                                        <h6>INR 48</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6  col-xl-3 col-md-4 col-lg-3">
                                            <div class="card  mini-card-left-line">
                                                <div class="card-body">
                                                    <div class="text-center currency">
                                                        <i class="currency-bg fa fa-rupee"></i>
                                                        <p class="text-muted mb-0">Remaining Tax Amount</p>
                                                        <h6>INR 48</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="lac-card-container mb-3">
                                    <div class="title">
                                        <h6 class="mb-0">1.5 Lac Exemptions</h6>
                                        <small class="f-10 text-muted">(The aggregate of deductions under section 80C,section
                                            80CCC and
                                            sub-section (1) of section 80CCD)</small>
                                    </div>
                                    <div class="lac-card-wrapper mt-3">
                                        <div class="row">
                                            <div class="col-sm-6  col-xl-3 col-md-4 col-lg-3">
                                                <div class="card small-card left-line">
                                                    <div class="card-body">
                                                        <div class="text-center currency">
                                                            <i class="currency-bg fa fa-rupee"></i>
                                                            <p class="text-muted mb-0">Max Limit</p>
                                                            <h6>INR 0</h6>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-sm-6  col-xl-3 col-md-4 col-lg-3">
                                                <div class="card declaration-tax-card small-card card-left-bar">
                                                    <div class="card-body">
                                                        <div class="text-center currency">
                                                            <i class="currency-bg fa fa-rupee"></i>
                                                            <p class="text-muted mb-0"> Amount Declared</p>
                                                            <h6>INR 48</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6  col-xl-3 col-md-4 col-lg-3">
                                                <div class="card declaration-tax-card small-card card-left-bar">
                                                    <div class="card-body">
                                                        <div class="text-center currency">
                                                            <i class="currency-bg fa fa-rupee"></i>
                                                            <p class="text-muted mb-0">Auto Approved Amount</p>
                                                            <h6>INR 48</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6  col-xl-3 col-md-4 col-lg-3">
                                                <div class="card declaration-tax-card small-card card-left-bar">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-sm-12  col-xl-12 col-md-12 col-lg-12">
                                                                <div class="d-flex currency justify-content-center flex-column text-center align-items-center">
                                                                    <i class="currency-bg fa fa-rupee"></i>
                                                                    <p class="text-muted mb-0">Amount Accepted</p>
                                                                    <h6>INR 48</h6>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-sm-6  col-xl-3 col-md-4 col-lg-3">
                                                <div class="card declaration-tax-card small-card card-left-bar">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-sm-12  col-xl-12 col-md-12 col-lg-12">
                                                                <div class="d-flex currency justify-content-center flex-column text-center align-items-center">
                                                                    <i class="currency-bg fa fa-rupee"></i>
                                                                    <p class="text-muted mb-0">Amount Rejected</p>
                                                                    <h6>INR 48</h6>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="lac-card-table mt-3">
                                        <div class="lac-content mb-3">

                                        </div>
                                        <div class="lac-table">
                                            <div class="table-responsive tax-table-responsive ">
                                                <table class=" table table-borderd tax-table  mb-0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th scope="col">
                                                                Amount Declared
                                                            </th>
                                                            <th scope="col">
                                                                Deduction Name
                                                            </th>
                                                            <th scope="col">
                                                                Declaration
                                                            </th>
                                                            <th scope="col">
                                                                Proof
                                                            </th>
                                                            <th scope="col">
                                                                Status
                                                            </th>
                                                            <th scope="col">
                                                                Actions
                                                            </th>
                                                    </thead>
                                                    <tbody>

                                                        <tr>

                                                            <td>
                                                                <p>80C</p>
                                                            </td>
                                                            <td>
                                                                <p> PPF</p>
                                                            </td>
                                                            <td>
                                                                <p>INR 34,555</p>
                                                            </td>


                                                            <td>
                                                                <p>No Proof</p>
                                                            </td>

                                                            <td>
                                                                <p>Not Submitted</p>


                                                            </td>
                                                            <td>
                                                                <button class="btn boder-0 p-0 outline-none">
                                                                    <p class="ri-pencil-line text-orange"></p>
                                                                </button>

                                                            </td>
                                                        </tr>


                                                    </tbody>

                                                </table>

                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="month-declaration mb-3">
                                    <!-- <div class="col-sm-12  col-xl-12 col-md-12 col-lg-12"> -->
                                    <div class="table-responsive tax-table-responsive ">
                                        <table class=" table  table-hover tax-table  mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th scope="col">
                                                        <p class=""> Month</p>
                                                    </th>
                                                    <th scope="col">
                                                        <p class=""><span class="mx-1">APR</span>2022
                                                        </p>
                                                    </th>
                                                    <th scope="col">
                                                        <p class=""><span class="mx-1">MAY</span>2022
                                                        </p>
                                                    </th>
                                                    <th scope="col">
                                                        <p class="th-one"><span class="mx-1">JUN</span>2022
                                                        </p>

                                                    </th>
                                                    <th scope="col">
                                                        <p class="th-two"><span class="mx-1">JUL</span>2022
                                                        </p>
                                                    </th>
                                                    <th scope="col">
                                                        <p class="th-three"><span class="mx-1">AUG</span>2022
                                                        </p>

                                                    </th>
                                                    <th scope="col">
                                                        <p class=""><span class="mx-1">SEP</span>2022
                                                        </p>
                                                    </th>
                                                    <th scope="col">
                                                        <p class=""><span class="mx-1">OCT</span>2022
                                                        </p>
                                                    </th>
                                                    <th scope="col">
                                                        <p class=""><span class="mx-1">NOV</span>2022
                                                        </p>
                                                    </th>
                                                    <th scope="col">
                                                        <p class=""><span class="mx-1">DEC</span>2022
                                                        </p>
                                                    </th>
                                                    <th scope="col">
                                                        <p class=""><span class="mx-1">JAN</span>2022
                                                        </p>
                                                    </th>
                                                    <th scope="col">
                                                        <p class=""><span class="mx-1">FEB</span>2022
                                                        </p>
                                                    </th>
                                                    <th scope="col">
                                                        <p class="  "><span class="mx-1">MAR</span>2022
                                                        </p>
                                                    </th>
                                            </thead>
                                            <tbody>

                                                <tr>

                                                    <td>
                                                        Monthly Total Tax
                                                    </td>
                                                    <td>
                                                        INR 0
                                                    </td>
                                                    <td>
                                                        INR 0
                                                    </td>
                                                    <td>
                                                        INR 0
                                                    </td>

                                                    <td>
                                                        INR 0
                                                    </td>
                                                    <td>
                                                        INR 0
                                                    </td>
                                                    <td>
                                                        INR 0
                                                    </td>
                                                    <td>
                                                        INR 0
                                                    </td>
                                                    <td>
                                                        INR 0
                                                    </td>
                                                    <td>
                                                        INR 0
                                                    </td>
                                                    <td>
                                                        INR 0
                                                    </td>
                                                    <td>
                                                        INR 0
                                                    </td>
                                                    <td>
                                                        INR 0
                                                    </td>

                                                </tr>


                                            </tbody>
                                            <tfoot>

                                                <tr>
                                                    <td colspan="15">
                                                        <div class="row tax-details">
                                                            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                                <!-- <div class="d-flex mt-4 align-itemx-center justify-content-start tax-details"> -->
                                                                <p class="tax-one"> Tax deduction from projected salary</p>
                                                            </div>
                                                            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                                <p class="tax-two">Tax deduction from previous employer</p>
                                                            </div>
                                                            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                                <p class="tax-three">Imported tax deduction from current employer</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tfoot>

                                        </table>



                                    </div>
                                </div>
                                <!-- </div> -->
                            </div>

                            <div class="other-card-container mt-3">

                                <div class="title">
                                    <h6 class="mb-0">Other Exemptions</h6>
                                    <small class="text-muted f-10">(Other deductions under chapter VI(A) which is
                                        from 80CCD1(B) to
                                        80U)</small>
                                </div>
                                <div class="other-card-wrapper mt-3">
                                    <div class="row">
                                        <div class="col-sm-6  col-xl-3 col-md-4 col-lg-3">
                                            <div class="card declaration-tax-card small-card card-left-bar">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-12  col-xl-12 col-md-12 col-lg-12">
                                                            <div class="d-flex currency justify-content-center flex-column text-center align-items-center">

                                                                <i class="currency-bg fa fa-rupee"></i>
                                                                <p class="text-muted mb-0">Amount Declared</p>
                                                                <h6>INR 0</h6>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-sm-6  col-xl-3 col-md-4 col-lg-3">
                                            <div class="card declaration-tax-card small-card card-left-bar">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-12  col-xl-12 col-md-12 col-lg-12">
                                                            <div class="d-flex currency  justify-content-center flex-column text-center align-items-center">
                                                                <i class="currency-bg fa fa-rupee"></i>
                                                                <p class="text-muted mb-0">Auto Approved Amount</p>
                                                                <h6>INR 48</h6>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-sm-6  col-xl-3 col-md-4 col-lg-3">
                                            <div class="card declaration-tax-card small-card card-left-bar">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-12  col-xl-12 col-md-12 col-lg-12">
                                                            <div class="d-flex currency justify-content-center flex-column text-center align-items-center">
                                                                <i class="currency-bg fa fa-rupee"></i>
                                                                <p class="text-muted mb-0">Amount Accepted</p>
                                                                <h6>INR 48</h6>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-sm-6  col-xl-3 col-md-4 col-lg-3">
                                            <div class="card declaration-tax-card small-card card-left-bar">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-12  col-xl-12 col-md-12 col-lg-12">
                                                            <div class="d-flex currency justify-content-center flex-column text-center align-items-center">
                                                                <i class="currency-bg fa fa-rupee"></i>
                                                                <p class="text-muted mb-0">Amount Rejected</p>
                                                                <h6>INR 48</h6>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="other-card-table mb-3">

                                    <div class="other-content mb-3">

                                    </div>

                                    <div class="table-responsive other-table-responsive ">
                                        <table class=" table  table-hover onter-table  mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th scope="col">
                                                        Amount Declared
                                                    </th>
                                                    <th scope="col">
                                                        Deduction Name
                                                    </th>
                                                    <th scope="col">
                                                        Max Limit
                                                    </th>
                                                    <th scope="col">
                                                        Declaration
                                                    </th>
                                                    <th scope="col">
                                                        Proof
                                                    </th>
                                                    <th scope="col">
                                                        Status
                                                    </th>
                                                    <th scope="col">
                                                        Actions
                                                    </th>
                                            </thead>
                                            <tbody>

                                                <tr>

                                                    <td>
                                                        <p>80C</p>
                                                    </td>
                                                    <td>
                                                        <p> PPF</p>
                                                    </td>
                                                    <td>
                                                        <p>INR 34,005</p>
                                                    </td>

                                                    <td>
                                                        <p>Not Declared </p>
                                                    </td>

                                                    <td>
                                                        <p>No Proof</p>
                                                    </td>

                                                    <td>
                                                        <p>Not Submitted</p>


                                                    </td>
                                                    <td>
                                                        <button class="btn boder-0 p-0 outline-none">
                                                            <p class="ri-pencil-line text-orange"></p>
                                                        </button>

                                                    </td>
                                                </tr>


                                            </tbody>

                                        </table>


                                    </div>

                                </div>
                            </div>


                            <div class="Tax-card-container">

                                <div class="title">
                                    <h6 class="mb-0">Tax Savings Allowances</h6>
                                    <small class="text-muted f-10">(Following allowance are exempted from gross for
                                        income tax calculation
                                        only when claim is submitted against allowances)</small>
                                </div>
                                <div class="tax-card-wrapper mt-3">
                                    <div class="row">
                                        <div class="col-sm-6  col-xl-3 col-md-4 col-lg-3">
                                            <div class="card declaration-tax-card small-card card-left-bar">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-12  col-xl-12 col-md-12 col-lg-12">
                                                            <div class="d-flex currency justify-content-center flex-column text-center align-items-center">

                                                                <i class="currency-bg fa fa-rupee"></i>
                                                                <p class="text-muted mb-0">Amount Declared</p>
                                                                <h6>INR 0</h6>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-sm-6  col-xl-3 col-md-4 col-lg-3">
                                            <div class="card declaration-tax-card small-card card-left-bar">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-12  col-xl-12 col-md-12 col-lg-12">
                                                            <div class="d-flex currency justify-content-center flex-column text-center align-items-center">

                                                                <i class="currency-bg fa fa-rupee"></i>
                                                                <p class="text-muted mb-0">Auto Approved Amount</p>
                                                                <h6>INR 48</h6>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-sm-6  col-xl-3 col-md-4 col-lg-3">
                                            <div class="card declaration-tax-card small-card card-left-bar">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-12  col-xl-12 col-md-12 col-lg-12">
                                                            <div class="d-flex currency justify-content-center flex-column text-center align-items-center">

                                                                <i class="currency-bg fa fa-rupee"></i>
                                                                <p class="text-muted mb-0">Amount Accepted</p>
                                                                <h6>INR 48</h6>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-sm-6  col-xl-3 col-md-4 col-lg-3">
                                            <div class="card declaration-tax-card small-card card-left-bar">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-12  col-xl-12 col-md-12 col-lg-12">
                                                            <div class="d-flex currency justify-content-center flex-column text-center align-items-center">
                                                                <i class="currency-bg fa fa-rupee"></i>
                                                                <p class="text-muted mb-0">Amount Rejected</p>
                                                                <h6>INR 48</h6>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="other-card-table mb-3">

                                    <div class="other-content mb-3">

                                    </div>

                                    <div class="table-responsive other-table-responsive ">
                                        <table class=" table  table-hover onter-table  mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th scope="col">
                                                        Amount Declared
                                                    </th>
                                                    <th scope="col">
                                                        Deduction Name
                                                    </th>
                                                    <th scope="col">
                                                        Max Limit
                                                    </th>
                                                    <th scope="col">
                                                        Declaration
                                                    </th>
                                                    <th scope="col">
                                                        Proof
                                                    </th>
                                                    <th scope="col">
                                                        Status
                                                    </th>
                                                    <th scope="col">
                                                        Actions
                                                    </th>
                                            </thead>
                                            <tbody>

                                                <tr>

                                                    <td>
                                                        <p>80C</p>
                                                    </td>
                                                    <td>
                                                        <p> PPF</p>
                                                    </td>
                                                    <td>
                                                        <p>INR 34,005</p>
                                                    </td>



                                                    <td>
                                                        <p>Not Declared </p>
                                                    </td>

                                                    <td>
                                                        <p>No Proof</p>
                                                    </td>

                                                    <td>
                                                        <p>Not Submitted</p>


                                                    </td>
                                                    <td>
                                                        <button class="btn boder-0 p-0 outline-none">
                                                            <p class="ri-pencil-line text-orange"></p>
                                                        </button>

                                                    </td>
                                                </tr>


                                            </tbody>

                                        </table>


                                    </div>

                                </div>
                            </div>


                            <div class="house-card-container">
                                <div class="title">
                                    <h6 class="mb-0">House Property</h6>
                                    <small class="text-muted f-10">(Have you can declare all the house property rentend or
                                        owned)</small>
                                </div>
                                <div class="home-card-wrapper mt-3">
                                    <div class="row">
                                        <div class="col-sm-12  col-xl-12 col-md-12 col-lg-12">
                                            <div class="card bg-light-red declaration-important-card ">

                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span><i class="ri-alert-fill text-danger"></i>Important</span>
                                                    </div>
                                                    <ul class="list-style-numbered list-style-circle p-4">
                                                        <li>
                                                            You can add more than one rented property or own property
                                                            for the current
                                                            financial year.
                                                        </li>
                                                        <li>For rented property if the total rent is more than ₹
                                                            1,00,000 then you need
                                                            to provide either PAN of owner or declaration letter.</li>

                                                        <li>For rented property you are eligible for HRA and in case HRA
                                                            is not paid by
                                                            your employer you will be eligible for exemption under 80 GG
                                                        </li>
                                                        <li>For own property/residence you will be for eligible for
                                                            house loan interst
                                                            exemption under Section 24</li>
                                                    </ul>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="other-card-table mb-3">
                                <div class="other-content mb-3">

                                </div>

                                <div class="table-responsive other-table-responsive ">
                                    <table class=" table  table-hover onter-table  mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">
                                                    Month
                                                </th>
                                                <th scope="col">
                                                    City
                                                </th>
                                                <th scope="col">
                                                    No Of Owners
                                                </th>
                                                <th scope="col">
                                                    Status
                                                </th>

                                                <th scope="col">
                                                    Actions
                                                </th>
                                        </thead>
                                        <tbody>

                                            <tr>

                                                <td>
                                                    <p>80C</p>
                                                </td>

                                                <td>
                                                    <p>other non metro</p>
                                                </td>

                                                <td>
                                                    <p>one</p>
                                                </td>


                                                <td>
                                                    <p>one</p>
                                                </td>


                                                <td>
                                                    <button class="btn boder-0 p-0 outline-none">
                                                        <p class="ri-pencil-line text-orange"></p>
                                                    </button>

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="income-card-container">

                                <div class="title">
                                    <h6 class="mb-0">Income From Others Sources</h6>
                                    <small class="text-muted f-10">(Income from other sources is a residual category
                                        used to
                                        classify Income that is not classified as taxed under any other heard of
                                        income)</small>
                                </div>
                                <div class="income-card-wrapper mt-2">
                                    <div class="row">
                                        <div class="col-sm-12  col-xl-12 col-md-12 col-lg-12">
                                            <div class="card bg-medium-red declaration-important-card mb-n1">
                                                <div class="card-body py-2">
                                                    <ul class="list-style-numbered list-style-circle mx-2">
                                                        <li> Income form other sources not added
                                                        </li>

                                                    </ul>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>


                        <!-- <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

                            <div class="previous-income-content my-2">
                                <h5>Previous Employment Details</h5>
                                <small class="text-muted">(Previous Employment details are necessary for income tax
                                    computation when the employees switches the organization in the middle of the
                                    FY.)</small>
                            </div>

                            <div class="table-responsive previous-income-table">
                                <table class=" table  table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">Month</th>
                                            <th scope="col">Gross</th>
                                            <th scope="col">Basic</th>
                                            <th scope="col">House</th>
                                            <th scope="col">Employee</th>
                                            <th scope="col">ESI</th>
                                            <th scope="col">LWF</th>
                                            <th scope="col">LWF Employee</th>
                                            <th scope="col">Professional</th>
                                            <th scope="col">Income Tax</th>
                                            <th scope="col">Other Tax</th>
                                            <th scope="col">Other Tax</th>
                                    </thead>
                                    <tbody>

                                        <tr>

                                            <td>
                                                -
                                            </td>
                                            <td>
                                                -
                                            </td>
                                            <td>
                                                -
                                            </td>
                                            <td>
                                                -
                                            </td>

                                            <td>
                                                -
                                            </td>
                                            <td>
                                                -
                                            </td>

                                            <td>
                                                -
                                            </td>
                                            <td>
                                                -
                                            </td>

                                            <td>
                                                -
                                            </td>
                                            <td>
                                                -
                                            </td>
                                            <td>
                                                -
                                            </td>
                                            <td>
                                                -
                                            </td>
                                        </tr>


                                    </tbody>

                                </table>

                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- <div class="row">
                                                    <div class="col-sm-12  col-xl-12 col-md-12 col-lg-12">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <h5 class="my-2 ">My Declaration</h5>
                                                                <div class="table-responsive">
                                                                    <table class=" table  table-hover">
                                                                        <thead class="table-light">
                                                                            <tr>
                                                                                <th scope="col">Declaration</th>
                                                                                <th scope="col">No Of Declaration</th>
                                                                                <th scope="col">Amount Declared</th>
                                                                                <th scope="col">Proof Submitted</th>
                                                                                <th scope="col">Amount Rejected</th>
                                                                                <th scope="col">Amount Accepted</th>
                                                                        </thead>
                                                                        <tbody>

                                                                            <tr>

                                                                                <td>
                                                                                    1.5 lac
                                                                                </td>
                                                                                <td>
                                                                                    3
                                                                                </td>
                                                                                <td>
                                                                                    INR 98,897
                                                                                </td>
                                                                                <td>
                                                                                    0
                                                                                </td>
                                                                                <td>
                                                                                    INR 0
                                                                                </td>
                                                                                <td>
                                                                                    INR 65,000
                                                                                </td>
                                                                            </tr>


                                                                        </tbody>

                                                                    </table>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->
    <!-- <div>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h5>Monthly Tax Deduction Details</h5>
                                                            <div class="row">
                                                                <div class="col-sm-6  col-xl-3 col-md-4 col-lg-3">
                                                                    <div class="card declaration-tax-card card-left-bar">
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="col-sm-12  col-xl-12 col-md-12 col-lg-12">
                                                                                    <div
                                                                                        class="d-flex justify-content-center flex-column text-center align-items-center">
                                                                                        <p class="text-muted">Total Tax Payable</p>
                                                                                        <h4>INR 48</h4>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="col-sm-6  col-xl-3 col-md-4 col-lg-3">
                                                                    <div class="card declaration-tax-card card-left-bar">
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="col-sm-12  col-xl-12 col-md-12 col-lg-12">
                                                                                    <div
                                                                                        class="d-flex justify-content-center flex-column text-center align-items-center">
                                                                                        <p class="text-muted"> Tax Paid Till Now</p>
                                                                                        <h4>INR 48</h4>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="col-sm-6  col-xl-3 col-md-4 col-lg-3">
                                                                    <div class="card declaration-tax-card card-left-bar">
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="col-sm-12  col-xl-12 col-md-12 col-lg-12">
                                                                                    <div
                                                                                        class="d-flex justify-content-center flex-column text-center align-items-center">
                                                                                        <p class="text-muted">Remaining Tax Amount</p>
                                                                                        <h4>INR 48</h4>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            if (!$.browser.webkit) {
                $('.wrapper').html('<p>Sorry! Non webkit users. :(</p>');
            }
        });
    </script>
    @endsection
    @section('script')
    <!-- ui notifications -->

    <script src="{{ URL::asset('/assets/libs/prismjs/prismjs.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/notifications.init.js') }}"></script>
    <!-- apexcharts -->
    @endsection
