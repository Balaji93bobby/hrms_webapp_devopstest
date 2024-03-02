<?php

    //dd($assignedGoals);

?>
@extends('layouts.master')
@section('css')

    <link href="{{ URL::asset('assets/css/appraisal_review.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('/assets/css/pages_profile.css') }}">
@endsection

@section('content')
    <div class="loader" style="display:none;"></div>
    <div class="employee-review-wrapper"   style="margin-bottom: 120px;" >
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-lg-3 col-xl-3 col-xxl-3 d-flex ">
                        <div class="mb-0 card w-100 border-0 boxshadow_lite4">
                            <div class="card-body  text-center">

                                <div class="d-flex justify-content-center">
                                    <div class="profile-img d-flex  " >
                                        <?php $currentUserDetails = App\Models\User::find($assignedUserDetails->id); ?>
                                        @include('ui-profile-avatar-lg', [
                                            'currentUser' => $currentUserDetails,
                                        ])
                                    </div>
                                </div>

                                <div class="appraisal_userDet mt-3">
                                    <h6>{{ $assignedUserDetails->name.' - '.$assignedUserDetails->user_code  }}</h6>
                                    <p class="f-12 mt-2  text-primary">
                                        {{ $assignedUserDetails->getEmployeeOfficeDetails->designation }}</p>
                                    {{-- <p class="f-12 text-muted mt-2">
                                        {{ }}</p> --}}
                                </div>

                                {{--  --}}
                                <div class="col-md-12 col-sm-12 col-lg-6 col-xl-6 col-xxl-6 d-flex w-100 mt-4">
                                    <div class=" ">

                                            <p class="f-14 ">Business Unit/Process/Function</p>
                                            <p class="mb-2 f-14 fw-bold text-primary">
                                                {{ $assignedUserDepartment->name }}</p>
                                            <p class="f-14 ">Reporting Manager</p>
                                            <p class="mb-2 f-14 fw-bold text-primary ">{{ $assignersName }}</p>
                                            <p class="f-14  ">Review Period</p>
                                            <p class="mb-2 f-14 fw-bold text-primary">{{ $assignedGoals->year }}
                                                {{-- {{ strtoupper($assignedGoals->assignment_period) }}--}}</p>

                                    </div>

                                </div>

                                {{--  --}}

                            </div>
                        </div>
                    </div>

                    @if ($canShowOverallScoreCard_ReviewPage == 'true')

                        <div class="col-md-12 col-sm-12 col-lg-9 col-xl-9 col-xxl-9   d-flex my-3">
                            <div class="card mb-0 w-100 appraisal_rating border-0 boxshadow_lite4">
                                <div class="card-body">
                                    <p class="mb-2 fw-bold f-15 text-primary">Current Rating</p>
                                    <div class="mb-3">

                                        <div class="row mt-4" >
                                            <div class="col-9 ">
                                                <p class="f-14  ">Frequency</p>
                                            </div>
                                            <div class="col-3">
                                                {{-- <span class="text-primary f-15 fw-bold">1/3</span> --}}
                                                <b class="f-15 text-primary">
                                                    {{ ucfirst($assignedGoals->frequency) }}
                                                </b>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="mb-4">

                                        <div class="row mt-3">
                                            <div class="col-9 mt-2">
                                                <p class="f-14  ">Current Period</p>
                                            </div>
                                            <div class="col-3">
                                                {{-- <span class="text-primary f-15 fw-bold">1/3</span> --}}
                                                <b class="f-15 text-primary">
                                                    {{ strtoupper( $assignedGoals->assignment_period ) }}
                                                </b>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="mb-4">

                                        <div class="row mt-3">
                                            <div class="col-9 ">
                                                <p class="f-14  ">Score</p>
                                            </div>
                                            <div class="col-3">
                                                {{-- <span class="text-primary f-15 fw-bold">1/3</span> --}}
                                                <b class="f-15 text-primary">
                                                    @if ($isAllReviewersSubmittedOrNot)
                                                        @if ($ratingDetail)
                                                            {{ $ratingDetail['score'] }}
                                                        @else
                                                            -
                                                        @endif
                                                    @else
                                                       -
                                                    @endif
                                                </b>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row w-full">
                                        {{-- <div class="col-10 mt-2">
                                            <div class="progress">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div> --}}
                                        <div class="col-6">
                                            <p class="f-14  ">Performance Rating</p>
                                        </div>
                                        <div class="col-6">
                                            <b class="f-15 text-primary float-right ">
                                                @if ($isAllReviewersSubmittedOrNot)
                                                    @if ($ratingDetail)
                                                        {{ $ratingDetail['performance_rating'] }}
                                                    @else
                                                        -
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                            </b>
                                        </div>
                                    </div>


                                </div>
                            </div>

                            <div class="card mb-0 w-100 appraisal_rating border-0 boxshadow_lite4 mx-4">
                                <div class="card-body">
                                    <p class="mb-2 fw-bold f-15 text-primary">Overall Ratings</p>
                                    <div class="mb-3">
                                        <p class="f-14 mt-2 ">Overall Annual Score</p>
                                        <div class="row">
                                            <div class="col-10 mt-2">
                                                <div class="progress">
                                                    <div class="progress-bar bg-warning" role="progressbar"
                                                        style="width:25%" aria-valuenow="25" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                {{-- <span class="text-primary f-15 fw-bold">1/3</span> --}}
                                                <b class="f-15 text-primary">
                                                    @if ($isAllReviewersSubmittedOrNot)
                                                        @if ($overallRatingDetails)
                                                            {{ $overallRatingDetails['score'] }}
                                                        @else
                                                            -
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                </b>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="mb-3">
                                        <p class="f-14 mt-2 ">Overall Corresponding ANNUAL PERFORMANCE Rating</p>
                                        <div class="row">
                                            {{-- <div class="col-10 mt-2">
                                            <div class="progress">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div> --}}
                                            <div class="col-12">
                                                <b class="f-15 text-primary">
                                                    @if ($isAllReviewersSubmittedOrNot)
                                                        @if ($overallRatingDetails)
                                                            {{ $overallRatingDetails['performance_rating'] }}
                                                        @else
                                                            -
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                </b>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="f-14 mt-2 ">Overall Ranking</p>
                                        <div class="row">
                                            <div class="col-10 mt-2">
                                                <div class="progress">
                                                    <div class="progress-bar bg-green-400" role="progressbar"
                                                        style="width: 75%" aria-valuenow="75" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <b class="f-15 text-primary">
                                                    @if ($isAllReviewersSubmittedOrNot)
                                                        @if ($overallRatingDetails)
                                                            {{ $overallRatingDetails['rank'] }}
                                                        @else
                                                            -
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                </b>
                                            </div>
                                        </div>

                                    </div>


                                    <div class="row">
                                        <div class="col-12 mt-2  d-flex justify-content-between">
                                            <p class="f-14 "> Overall Recommendation</p>
                                        <div class="col  mr-4">
                                            <b class="f-15 text-primary">
                                            @if ($isAllReviewersSubmittedOrNot)
                                                @if ( $overallRatingDetails)
                                                    {{  $overallRatingDetails['action'] }}
                                                @else
                                                    -
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </b>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{--  --}}




                        </div>
                    @endif
                </div>

                {{-- <div class="row">
                    <div class="col-6">
                        @if ($empSelected)
                            <div class="appraisal-info left-content">
                                <ul class="personal-info">
                                    <li>
                                        <p class="title h5">Employee Name</p>
                                        <p class="text">{{ $assignedUserDetails->name }}</p>
                                    </li>
                                    @if (isset($assignedUserDetails->getEmployeeDetails))
                                        <li>
                                            <p class="title h5"> Employee ID</p>
                                        </li>
                                    @endif
                                    @if (isset($assignedUserDetails->getEmployeeOfficeDetails))
                                        <li>
                                            <p class="title h5">Job Title/Designation</p>
                                            <p class="text">
                                                {{ $assignedUserDetails->getEmployeeOfficeDetails->designation }}</p>
                                        </li>
                                    @endif
                                    @if (isset($assignedUserDetails->getEmployeeOfficeDetails))
                                        <li>
                                            <p class="title h5">Business Unit/Process/Function</p>
                                            <p class="text">
                                                {{ $assignedUserDetails->getEmployeeOfficeDetails->department }}</p>
                                        </li>
                                    @endif
                                    <li>
                                        <p class="title h5">Reporting Manager</p>
                                        <p class="text">{{ $assignersName }}</p>
                                    </li>
                                    <li class="mb-0">
                                        <p class="title h5">Review Period</p>
                                        <p class="text">
                                            {{ $assignedGoals->year }} -
                                            {{ strtoupper($assignedGoals->assignment_period) }}
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="col-6">
                        <div class="card-body">

                            <div class="mb-3 input-wrap">
                                <p>Overall Annual Score</p>
                                <div class="appraisal-box  btn bg-success text-white "><small>
                                        @if ($isAllReviewersSubmittedOrNot)
                                            @if ($ratingDetail)
                                                {{ $ratingDetail['rating'] }}
                                            @else
                                                -
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </small>
                                </div>

                            </div>
                            <div class="mb-3 input-wrap">
                                <p>Corresponding ANNUAL PERFORMANCE Rating</p>
                                <div class="appraisal-box  btn bg-success  text-white"><small>
                                        @if ($isAllReviewersSubmittedOrNot)
                                            @if ($ratingDetail)
                                                {{ $ratingDetail['performance'] }}
                                            @else
                                                -
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </small>
                                </div>
                            </div>
                            <div class="mb-3 input-wrap">
                                <p>Ranking</p>
                                <div class="appraisal-box   btn bg-success text-white "><small>
                                        @if ($isAllReviewersSubmittedOrNot)
                                            @if ($ratingDetail)
                                                {{ $ratingDetail['ranking'] }}
                                            @else
                                                -
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </small>
                                </div>
                            </div>
                            <div class=" input-wrap">
                                <p>Action</p>
                                <div class="appraisal-box btn bg-success text-white"><small>
                                        @if ($isAllReviewersSubmittedOrNot)
                                            @if ($ratingDetail)
                                                {{ $ratingDetail['action'] }}
                                            @else
                                                -
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </small></div>
                            </div>

                        </div>
                    </div>
                </div> --}}
            </div>
        </div>


        <!-- Rejection Modal Starts -->
        <div class="modal fade" id="rejectionCommentModal" role="dialog" aria-hidden="true"
            style="opacity:1; display:none;background:#00000073;">
            <div class="modal-dialog modal-md modal-dialog-centered" id="" aria-hidden="true"
                aria-labelledby="exampleModalToggleLabel2">
                <div class="modal-content">
                    <div class="modal-header border-0 d-flex align-items-center py-2">


                        <h6 class="modal-title text-primary" id="modalHeader">Rejected
                        </h6>
                        <button type="button" class="btn-close btn-close-white close-modal" data-bs-dismiss="modal"
                            aria-label="Close">
                        </button>

                    </div>
                    <div class="modal-body">

                        <h6 class="mb-3" id="modalNot"></h6>
                        <textarea name="reject_comment" id="reject_comment" class="form-control mb-2 w-100 outline-none border-primary h-100"></textarea>
                        <div class="text-end">
                            <button type="button" class="btn btn-primary" id="rejection_submit" disabled>Save</button>
                            <button type="button" class="btn btn-light close-modal"
                                data-bs-dismiss="modal">Close</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- Rejection Modal Ends -->

        <div class="row">
            <div class="col-xl-12 col-md-12 col-sm-12 col-lg-12 col-xxl-12 ">
                <!-- appraisal table -->
                <div class="card mb-0">
                    <div class="card-body pb-2">
                        @if ($enableButton)
                            @if (isset($isAllReviewersSubmittedData) &&
                                count($isAllReviewersSubmittedData) > 0 &&
                                $isAllReviewersSubmittedData[Auth::id()] != '1' &&
                                $assignedGoals->is_assignee_submitted == '1')
                                <div class="row">
                                    <div class="col-12 mt-3">
                                        <form id="upload_form" enctype="multipart/form-data">
                                            <div class="row pull-right mb-3">
                                                @csrf
                                                <input type="hidden" name="kpiFormAssignedId"
                                                    value="{{ $kpiFormAssignedDetails->id }}">
                                                <div class="col">
                                                    <a href="{{ route('download.excelsheet.pmsv2.review.form', [$assignedGoals->vmt_pms_kpiform_assigned_id, '2', $assignedGoals->year . '-' . strtoupper($assignedGoals->assignment_period)]) }}"
                                                        class="btn btn-orange pull-right" id="download-excel">Download</a>
                                                </div>
                                                <div class="col-auto p-0">
                                                    <input type="file" name="upload_file" id="upload_file"
                                                        accept=".xls,.xlsx" class="form-control" required>
                                                </div>
                                                <div class="col">
                                                    <button type="button" class="btn btn-orange pull-right"
                                                        id="upload-goal" disabled>Upload</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        @endif

                        @if (count($kpiRows) > 0)
                            <form id="employee_self_review" method="POST">
                                @csrf
                                <input type="hidden" value="" name="formSubmitType" id="formSubmitType">
                                <input type="hidden" name="assignee_id" value="{{ $assignedUserDetails->id }}">
                                <input type="hidden" name="goal_id" value="{{ $assignedGoals->id }}">
                                <input type="hidden" name="kpiReviewId" value="{{ $assignedGoals->id }}">
                                <div class="table-content table-responsive">
                                    <table id="table_review"
                                        class="table  kpi_appraisal-table appraisal_reviewer  mb-0 table-bordered  "
                                        data-paging="true" data-paging-size="100" data-paging-limit="3"
                                        data-paging-container="#paging-ui-container"
                                        data-paging-count-format="{PF} to {PL}" data-sorting="true"
                                        data-filtering="false" data-empty="No Results"
                                        data-filter-container="#filter-form-container" data-editing-add-text="Add New">
                                        <thead class="thead" id="tHead">
                                            <tr>
                                                <th scope="col" data-name='dimension' data-filterable="false"
                                                    data-visible="{{ $show['dimension'] }}">
                                                    @if (count($headerColumnsDynamic) > 0 && isset($headerColumnsDynamic['dimension']))
                                                        {{ $headerColumnsDynamic['dimension'] }}
                                                    @else
                                                        Dimension
                                                    @endif
                                                </th>
                                                <th scope="col" data-name='kpi' data-filterable="false"
                                                    data-visible="{{ $show['kpi'] }}">
                                                    @if (count($headerColumnsDynamic) > 0 && isset($headerColumnsDynamic['kpi']))
                                                        {{ $headerColumnsDynamic['kpi'] }}
                                                    @else
                                                        KPI
                                                    @endif
                                                </th>
                                                <th scope="col" data-name='operational' data-filterable="false"
                                                    data-visible="{{ $show['operational'] }}">
                                                    @if (count($headerColumnsDynamic) > 0 && isset($headerColumnsDynamic['operational']))
                                                        {{ $headerColumnsDynamic['operational'] }}
                                                    @else
                                                        Operational Definition
                                                    @endif
                                                </th>
                                                <th scope="col" data-name='measure' data-filterable="false"
                                                    data-visible="{{ $show['measure'] }}">
                                                    @if (count($headerColumnsDynamic) > 0 && isset($headerColumnsDynamic['measure']))
                                                        {{ $headerColumnsDynamic['measure'] }}
                                                    @else
                                                        Measure
                                                    @endif
                                                </th>
                                                <th scope="col" data-name='frequency' data-filterable="false"
                                                    data-visible="{{ $show['frequency'] }}">
                                                    @if (count($headerColumnsDynamic) > 0 && isset($headerColumnsDynamic['frequency']))
                                                        {{ $headerColumnsDynamic['frequency'] }}
                                                    @else
                                                        Frequency
                                                    @endif
                                                </th>
                                                <th scope="col" data-name='target' data-filterable="false"
                                                    data-visible="{{ $show['target'] }}">
                                                    @if (count($headerColumnsDynamic) > 0 && isset($headerColumnsDynamic['target']))
                                                        {{ $headerColumnsDynamic['target'] }}
                                                    @else
                                                        Target
                                                    @endif
                                                </th>
                                                <th scope="col" data-name='stretchTarget' data-filterable="false"
                                                    data-visible="{{ $show['stretchTarget'] }}">
                                                    @if (count($headerColumnsDynamic) > 0 && isset($headerColumnsDynamic['stretchTarget']))
                                                        {{ $headerColumnsDynamic['stretchTarget'] }}
                                                    @else
                                                        Stretch Target
                                                    @endif
                                                </th>
                                                <th scope="col" data-name='source' data-filterable="false"
                                                    data-visible="{{ $show['source'] }}">
                                                    @if (count($headerColumnsDynamic) > 0 && isset($headerColumnsDynamic['source']))
                                                        {{ $headerColumnsDynamic['source'] }}
                                                    @else
                                                        Source
                                                    @endif
                                                </th>
                                                <th scope="col" data-name='kpiWeightage' data-filterable="false"
                                                    data-visible="{{ $show['kpiWeightage'] }}">
                                                    @if (count($headerColumnsDynamic) > 0 && isset($headerColumnsDynamic['kpiWeightage']))
                                                        {{ $headerColumnsDynamic['kpiWeightage'] }}
                                                    @else
                                                        KPI Weightage
                                                    @endif
                                                </th>
                                                @if (isset($assignedGoals) && $assignedGoals->is_assignee_submitted == '1')
                                                    <th scope="col" data-name='kpiSelfReview' data-filterable="false"
                                                        data-visible="true">Employee KPI -
                                                        Achievement</th>
                                                    <th scope="col" data-name='kpiSelfAchivement'
                                                        data-filterable="false" data-visible="true">Employee KPI
                                                        Achievement %</th>
                                                    <th scope="col" data-name='comments' data-filterable="false"
                                                        data-visible="true">Employee
                                                        Comments</th>
                                                @endif

                                                @if ($assignedGoals->is_assignee_submitted == '1')
                                                    @foreach ($reviewersId as $reviewersReview)
                                                        @if ($isAllReviewersSubmittedOrNot)
                                                            <th scope="col" data-name='kpiManagerReview'
                                                                data-filterable="false" data-visible=true> KPI -
                                                                Achievement
                                                                Manager Review</th>
                                                            <th scope="col" data-name='kpiManagerAchivement'
                                                                data-filterable="false" data-visible="true">Manager
                                                                KPI
                                                                Achievement % </th>
                                                        @elseif ($reviewersReview == Auth::id())
                                                            <th scope="col" data-name='kpiManagerReview'
                                                                data-filterable="false" data-visible=true> KPI -
                                                                Achievement
                                                                Manager Review</th>
                                                            <th scope="col" data-name='kpiManagerAchivement'
                                                                data-filterable="false" data-visible="true">Manager
                                                                KPI
                                                                Achievement % <br /><span
                                                                    id="overall_manager_kpi_percentage"></span></th>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody class="tbody" id="tbody">
                                            @foreach ($kpiRows as $index => $kpiRow)
                                                <tr>
                                                    <th scope="row" style="border-radius: 0px">
                                                        <div style="width:300px">
                                                            {{ \Str::words($kpiRow->dimension, 15, '') }}
                                                            @if (strlen(substr($kpiRow->dimension, strlen(\Str::words($kpiRow->dimension, 15, '')))) > 0)
                                                                <span class="{{ 'collapse-' . $index }}"
                                                                    style="display: none;">
                                                                    {{ substr($kpiRow->dimension, strlen(\Str::words($kpiRow->dimension, 15, ''))) }}
                                                                </span>
                                                                <span
                                                                    class="btn bg-transparent text-orange outline-none border-0 fw-bold f-12 more_btn"
                                                                    id="less_more-btn-{{ $index }}"
                                                                    onclick="showOrHideDescription('{{ $index }}',this)">...More</span>
                                                            @endif
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div style="width:300px">
                                                            {{ \Str::words($kpiRow->kpi, 15, '') }}
                                                            @if (strlen(substr($kpiRow->kpi, strlen(\Str::words($kpiRow->kpi, 15, '')))) > 0)
                                                                <span class="{{ 'collapse-' . $index }}"
                                                                    style="display: none;">
                                                                    {{ substr($kpiRow->kpi, strlen(\Str::words($kpiRow->kpi, 15, ''))) }}
                                                                </span>
                                                                <span
                                                                    class="btn bg-transparent text-orange outline-none border-0 fw-bold f-12 more_btn"
                                                                    id="less_more-btn-{{ $index }}"
                                                                    onclick="showOrHideDescription('{{ $index }}',this)">...More</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            {{ \Str::words($kpiRow->operational_definition, 15, '') }}

                                                            @if (strlen(substr($kpiRow->operational_definition, strlen(\Str::words($kpiRow->operational_definition, 15, '')))) > 0)
                                                                <span class="{{ 'collapse-' . $index }}"
                                                                    style="display: none;">
                                                                    {{ substr($kpiRow->operational_definition, strlen(\Str::words($kpiRow->operational_definition, 15, ''))) }}
                                                                </span>
                                                                <span
                                                                    class="btn bg-transparent text-orange outline-none border-0 fw-bold f-12 more_btn"
                                                                    id="less_more-btn-{{ $index }}"
                                                                    onclick="showOrHideDescription('{{ $index }}',this)">...More</span>
                                                            @endif


                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            {{ \Str::words($kpiRow->measure, 15, '') }}
                                                            @if (strlen(substr($kpiRow->measure, strlen(\Str::words($kpiRow->measure, 15, '')))) > 0)
                                                                <span class="{{ 'collapse-' . $index }}"
                                                                    style="display: none;">
                                                                    {{ substr($kpiRow->measure, strlen(\Str::words($kpiRow->measure, 15, ''))) }}
                                                                </span>
                                                                <span
                                                                    class="btn bg-transparent text-orange outline-none border-0 fw-bold f-12 more_btn"
                                                                    id="less_more-btn-{{ $index }}"
                                                                    onclick="showOrHideDescription('{{ $index }}',this)">...More</span>
                                                            @endif

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div> {{ $kpiRow->frequency }}</div>
                                                    </td>
                                                    <td>
                                                        <div>{{ $kpiRow->target }}</div>
                                                    </td>
                                                    <td>
                                                        <div>{{ $kpiRow->stretch_target }}</div>
                                                    </td>
                                                    <td>
                                                        <div>{{ $kpiRow->source }}</div>
                                                    </td>
                                                    <td>
                                                        <div>{{ $kpiRow->kpi_weightage }}</div>
                                                    </td>
                                                    @if (isset($assignedGoals) && $assignedGoals->is_assignee_submitted == '1')
                                                        <?php
                                                        $assigneeKPIReview = json_decode($assignedGoals->assignee_kpi_review, true);
                                                        $assigneeKPIPerc = json_decode($assignedGoals->assignee_kpi_percentage, true);
                                                        $assigneeKPIComments = json_decode($assignedGoals->assignee_kpi_comments, true);
                                                        ?>
                                                        <td>
                                                            <div>
                                                                @if (isset($assigneeKPIReview) && isset($assigneeKPIReview[$kpiRow->id]))
                                                                    {{ $assigneeKPIReview[$kpiRow->id] }}
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                @if (isset($assigneeKPIPerc) && isset($assigneeKPIPerc[$kpiRow->id]))
                                                                    {{ round($assigneeKPIPerc[$kpiRow->id]) }}%
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>

                                                            <div style="width:300px">
                                                                @if (isset($assigneeKPIComments) && isset($assigneeKPIComments[$kpiRow->id]))
                                                                    {{-- {{ $assigneeKPIComments[$kpiRow->id] }} --}}

                                                                    {{ \Str::words($assigneeKPIComments[$kpiRow->id] , 15, '') }}
                                                                    @if (strlen(substr($assigneeKPIComments[$kpiRow->id] , strlen(\Str::words($assigneeKPIComments[$kpiRow->id] , 15, '')))) > 0)
                                                                        <span class="{{ 'collapse-' . $index }}"
                                                                            style="display: none;">
                                                                            {{ substr($assigneeKPIComments[$kpiRow->id] , strlen(\Str::words($assigneeKPIComments[$kpiRow->id] , 15, ''))) }}
                                                                        </span>
                                                                        <span
                                                                            class="btn bg-transparent text-orange outline-none border-0 fw-bold f-12 more_btn"
                                                                            id="less_more-btn-{{ $index }}"
                                                                            onclick="showOrHideDescription('{{ $index }}',this)">...More</span>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </td>
                                                    @endif
                                                    <?php
                                                    $decodedKpiReview = json_decode($assignedGoals->reviewer_kpi_review, true);
                                                    $decodedKpiReviewSubmittedStatus = json_decode($assignedGoals->is_reviewer_submitted, true);
                                                    $decodedKpiReviewPerc = json_decode($assignedGoals->reviewer_kpi_percentage, true);
                                                    //dd(Auth::user()->org_role);
                                                    //dd($isAllReviewersSubmittedOrNot);
                                                    ?>
                                                    @if ($assignedGoals->is_assignee_submitted == '1')
                                                        @foreach ($reviewersId as $reviewersReview)
                                                            {{-- When HR/Admin views --}}
                                                            @if ($isAllReviewersSubmittedOrNot)
                                                                <td>
                                                                    <div>
                                                                        @if (isset($decodedKpiReview[$reviewersReview]))
                                                                            {{ $decodedKpiReview[$reviewersReview][$kpiRow->id] }}
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div>
                                                                        @if (isset($decodedKpiReviewPerc[$reviewersReview]))
                                                                            {{ $decodedKpiReviewPerc[$reviewersReview][$kpiRow->id] }}%
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                            @elseif ($reviewersReview == Auth::id())
                                                                <td>
                                                                    @if (isset($assignedGoals->is_assignee_submitted) &&
                                                                        $assignedGoals->is_assignee_submitted == '1' &&
                                                                        $reviewersReview == Auth::id() &&
                                                                        ($decodedKpiReviewSubmittedStatus[$reviewersReview] == '' ||
                                                                            $decodedKpiReviewSubmittedStatus[$reviewersReview] == '0'))
                                                                        <textarea name="reviewer_kpi_review[{{ $reviewersReview }}][{{ $kpiRow->id }}]" data-index="{{ $index }}"
                                                                            data-reviewerid="{{ $reviewersReview }}" data-targetval="{{ $kpiRow->target }}"
                                                                            data-kpiweightageval="{{ $kpiRow->kpi_weightage }}"
                                                                            id="reviewer_kpi_review{{ $index }}-{{ $reviewersReview }}"
                                                                            @if (is_numeric($kpiRow->target)) onkeypress='return (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46' class="form-control  h-100 border-0 outline-none w-100 calculateReviewerKPIPercentage" placeholder="type numbers only" @else placeholder="type here" @endif>
@if (isset($decodedKpiReview[$reviewersReview]))
{{ $decodedKpiReview[$reviewersReview][$kpiRow->id] }}
@endif
</textarea>
                                                                    @else
                                                                        <div>
                                                                            @if (isset($decodedKpiReview[$reviewersReview]))
                                                                                {{ $decodedKpiReview[$reviewersReview][$kpiRow->id] }}
                                                                            @endif
                                                                        </div>
                                                                    @endif

                                                                </td>
                                                                <td>

                                                                    @if (isset($assignedGoals->is_assignee_submitted) &&
                                                                        $assignedGoals->is_assignee_submitted == '1' &&
                                                                        $reviewersReview == Auth::id() &&
                                                                        ($decodedKpiReviewSubmittedStatus[$reviewersReview] == '' ||
                                                                            $decodedKpiReviewSubmittedStatus[$reviewersReview] == '0'))
                                                                        <textarea type="number" class="inp-text form-control h-100 border-0 outline-none w-100 reviewer_kpi_percentage "
                                                                            name="reviewer_kpi_percentage[{{ $reviewersReview }}][{{ $kpiRow->id }}]"
                                                                            id="reviewer_kpi_percentage{{ $index }}-{{ $reviewersReview }}"
                                                                            onkeypress='return (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46'
                                                                            @if(is_numeric($kpiRow->target))
                                                                                readonly placeholder="Calculate based on Target and Manager Review"
                                                                            @else
                                                                                placeholder="type number here"
                                                                                style="background-color:#edebeb;"
                                                                            @endif> @if (isset($decodedKpiReviewPerc[$reviewersReview])){{ $decodedKpiReviewPerc[$reviewersReview][$kpiRow->id] }}@endif</textarea>
                                                                    @else
                                                                        <div>
                                                                            @if (isset($decodedKpiReviewPerc[$reviewersReview]))
                                                                                {{ $decodedKpiReviewPerc[$reviewersReview][$kpiRow->id] }}%
                                                                            @endif
                                                                        </div>
                                                                    @endif
                                                                </td>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Show Appraiser box only when assignee submitted review  --}}
                                @if ($assignedGoals->is_assignee_submitted == '1')
                                    @if ($isAllReviewersSubmittedOrNot)
                                        <div class="row mt-3">
                                            <div class="col-lg-12">
                                                <h6 class="text-muted">
                                                    Appraiser Feedback:
                                                </h6>
                                                <div class="mt-2">
                                                    <span>
                                                        @if (isset($assignedGoals->reviewer_appraisal_comments))
                                                            {{ $assignedGoals->reviewer_appraisal_comments }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif ($reviewersReview == Auth::id() && $decodedKpiReviewSubmittedStatus[$reviewersReview] != '1')
                                            <div class="row mt-3 mb-2">
                                                <div class="col-lg-12">
                                                    <h6 class="text-muted">
                                                        Appraiser Feedback:
                                                    </h6>
                                                    <div class="mt-2">
                                                        <textarea class="form-control w-100 h-100 outline-none" placeholder="Comments here..."
                                                            id="gen-info-description-input" name="appraiser_comments">
@if (isset($assignedGoals->reviewer_appraisal_comments))
{{ $assignedGoals->reviewer_appraisal_comments }}
@endif
</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                    @endif
                                @endif

                            </form>

                                @if (str_contains($assignedGoals->is_reviewer_submitted,'"1"') &&  Str::contains(currentLoggedInUserRole(), ['Super Admin', 'Admin', 'HR'])   )
                                    <div class="buttons d-flex align-items-center justify-content-end ">
                                        <button class="btn btn-orange" id="revoke_form"> Revoke Form</button>
                                    </div>
                                @endif

                            @if ($enableButton)
                                @if ($assignedGoals->is_assignee_submitted == '1')
                                    @if ($decodedKpiReviewSubmittedStatus[Auth::id()] != '1')
                                        <div class="buttons d-flex align-items-center justify-content-end ">
                                            <button class="btn btn-orange" id="save_table">
                                                @if ($decodedKpiReviewSubmittedStatus[Auth::id()] == '')
                                                    Save
                                                @else
                                                    Save
                                                @endif
                                            </button>
                                            &nbsp;&nbsp;
                                            <button class="btn btn-orange" id="publish_table"
                                                @if ($decodedKpiReviewSubmittedStatus[Auth::id()] == '') disabled @endif>Submit</button>
                                        </div>
                                    @endif
                                @else
                                    @if (isset($isAllReviewersAcceptedData) && $isAllReviewersAcceptedData[Auth::id()] == null)
                                        <div class="buttons d-flex align-items-center justify-content-end ">
                                            <button class="btn btn-success me-2" id="accept_review">
                                                <i class="fa fa-check-circle me-2"></i> Approve </button>

                                            <button class="btn btn-danger" id="reject_review"><i
                                                    class="fa fa-times-circle me-2"></i> Reject</button>
                                        </div>
                                    @elseif($isAllReviewersAcceptedData[Auth::id()] == '0')
                                        <h6 class="mt-3 text-muted">You have Already Rejected this review.</h6>
                                    @else
                                        <h6 class="mt-3 text-muted">Employee has not yet submitted this review.</h6>
                                    @endif
                                @endif
                            @endif
                        @else
                            <h4>Goals Not Assigned</h4>
                        @endif
                    </div>
                </div>
            </div>

            @if ($canShowRatingCard == 'true')

                @if ($isAllReviewersSubmittedOrNot && count($pmsRatingDetails) > 0)
                    <div class="col-12">
                        <div class="card mt-3 mb-0">

                            <div class="card-body ">
                                <h6>Best People Rating Grid</h6>


                                <div class="table-content table-responsive mb-1">
                                    <table class="table rating_table align-middle mb-0 table-bordered  " id="table">


                                        <tbody class="tbody" id="tbody">
                                            <tr>
                                                <th scope="col" style="width:350px;border-radius:0px;">Overall Annual
                                                    Score</th>
                                                @foreach ($pmsRatingDetails as $ratingDetails)
                                                    <td scope="col" style="border:1px solid #002f56">
                                                        {{ $ratingDetails->score_range }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <th class="" style="width:350px">
                                                    ANNUAL PERFORMANCE Rating
                                                </th>
                                                @foreach ($pmsRatingDetails as $ratingDetails)
                                                    <td class="" style="border:1px solid #002f56">
                                                        {{ $ratingDetails->performance_rating }}
                                                    </td>
                                                @endforeach
                                            </tr>

                                            <tr>
                                                <th class="" style="width:350px">
                                                    Ranking
                                                </th>
                                                @foreach ($pmsRatingDetails as $ratingDetails)
                                                    <td class="" style="border:1px solid #002f56">
                                                        {{ $ratingDetails->ranking }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>

                                                <th class="" style="width:350px">
                                                    Recommendation
                                                </th>
                                                @foreach ($pmsRatingDetails as $ratingDetails)
                                                    <td class="" style="border:1px solid #002f56">
                                                        {{ $ratingDetails->action }}</td>
                                                @endforeach
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            <!-- Modal -->
            <div class="modal fade flip" id="acceptPMS" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body p-5 text-center">
                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px">
                            </lord-icon>
                            <div class="mt-4 text-center">
                                <h4>You are about to delete a order ?</h4>

                                <p class="text-muted fs-15 mb-4">Deleting your order will remove
                                    all of
                                    your information from our database.</p>
                                <div class="hstack gap-2 justify-content-center remove">
                                    <button class="btn btn-link link-success fw-medium text-decoration-none"
                                        data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                                        Close</button>
                                    <button class="btn btn-danger" id="delete-record">Yes,
                                        Delete It</button>
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
    @yield('script-profile-avatar')

    <!--Sweet alert JS-->
    <script src="{{ URL::asset('/assets/premassets/js/sweetalert.js') }}"></script>
    <script src="{{ URL::asset('/assets/premassets/js/progressbar.min.js') }}"></script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


    <script src="{{ URL::asset('/assets/premassets/js/footable.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/premassets/css/footable.bootstrap.min.css') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            calculateOverallReviewerKpiPercentage();
        });


        /*
         * for calculating Self KPI Achievement % If Target is Number
         * formula :-
         * Self KPI Achievement %' = (KPI - Achievement Self-Review (this) / Target (targetVal)) * KPI Weightage (kpiWeightageVal);
         */
        $(document).on('keyup', '.calculateReviewerKPIPercentage', function() {
            getCalculationResult($(this));
        })
        $(document).on('keyup', '.reviewer_kpi_percentage', function() {
            calculateOverallReviewerKpiPercentage();
        })

        //Revoke PMS form . For now this is done by HR only. In future, Manager too can do this
        $('#revoke_form').click(function(e) {
            e.preventDefault();
            console.log("Revoking the PMS form");

            //$('.loader').show();

            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to revoke this form?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then(function(value) {
                if (value.isConfirmed) {
                    var assigneeGoalId = "{{ $assignedGoals->id }}";

                    //$('.loader').show();
                    $.ajax({
                        type: "GET",
                        url: "{{ route('pms-revokeSubmittedForm') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            assigneeGoalId: assigneeGoalId,
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                Swal.fire("Form revoked successfully", data.message, "success").then(function() {
                                    location.reload();
                                });
                            } else {
                                Swal.fire("Error!", data.message, "error");
                            }
                            $('.loader').hide();
                        },
                        error: function(error) {
                            $('.loader').hide();
                        }
                    });
                }
            });
        });


        function getCalculationResult(idValue) {
            var kpiAchievementReviewerReview = idValue.val();
            var reviewerId = idValue.data("reviewerid");
            var index = idValue.data("index");
            var targetVal = idValue.data("targetval");
            var kpiWeightageVal = idValue.data("kpiweightageval");
            kpiWeightageVal = kpiWeightageVal.replace('%', '');
            //kpiWeightageVal = kpiWeightageVal/100;

            if (kpiAchievementReviewerReview != '') {
                console.log("KPI Achieved Calculation ");
                console.log("kpiAchievementReviewerReview : " + kpiAchievementReviewerReview);
                console.log("targetVal : " + targetVal);
                console.log("kpiWeightageVal : " + kpiWeightageVal);

                var result = (kpiAchievementReviewerReview / targetVal) * kpiWeightageVal;

                //update in 'Manager KPI achievements %' column in this format
                //reviewer_kpi_review  index - reviewersReview
                // var temp = '#reviewer_kpi_review' + index+'-'+reviewerId;
                // console.log("testing id : "+temp);
                $('#reviewer_kpi_percentage' + index + '-' + reviewerId).val(Math.round(result));
                console.log("OUTPUT :: reviewer_kpi_percentage : " + result);
            } else {
                $('#reviewer_kpi_percentage' + index + '-' + kpiAchievementReviewerReview).val('');
            }
            calculateOverallReviewerKpiPercentage();
        }

        function calculateOverallReviewerKpiPercentage() {
            //Get all the 'Self KPI Achievements %' textarea values
            var array_selfKpiAchievementsPercentage = $('.reviewer_kpi_percentage').map((_, element) => $.trim(element
                .value)).get();
            var total_percentage = _.sumBy(array_selfKpiAchievementsPercentage, item => Number(item));

            console.log(" array_selfKpiAchievementsPercentage : " + array_selfKpiAchievementsPercentage);
            console.log("SUM of array_selfKpiAchievementsPercentage : " + total_percentage);
            //Also update Self KPI Achievement %
            $("#overall_manager_kpi_percentage").html("Total : " + Math.round(total_percentage) + "%");

        }

        $('#upload_file').change(function() {
            if ($(this).is(':valid')) {
                $('#upload-goal').removeAttr('disabled');
            } else {
                $('#upload-goal').attr('disabled', true);
            }
        });

        ft = FooTable.init('#table_review');

        $('#upload-goal').click(function() {
            var loggedUserId = {{ Auth::id() }};
            var form_data = new FormData(document.getElementById("upload_form"));
            $('.loader').show();
            $.ajax({
                type: "POST",
                url: "{{ route('upload-file-review') }}",
                dataType: "json",
                contentType: false,
                processData: false,
                data: form_data,
                success: function(data) {
                    if (data.status == true) {
                        // $('.addition-content').html('');
                        $.each(data.result, function(key, value) {
                            var countIndex = data.countStart;
                            $('#reviewer_kpi_review' + key + '-' + loggedUserId).val(value[
                                countIndex]);
                            $('#reviewer_kpi_percentage' + key + '-' + loggedUserId).val(value[
                                countIndex + 1]);
                        });
                    } else {
                        Swal.fire("Error!", data.message, "error");
                    }
                    $('.loader').hide();
                },
                error: function(error) {
                    $('.loader').hide();
                }
            });
        });


        // Save/Draft Assignee Reviews
        $('#save_table').click(function(e) {
            e.preventDefault();
            $('#formSubmitType').val(0);
            // console.log("save trigger");
            // console.log($('#employee_self_review').serialize());
            $('.loader').show();
            $.ajax({
                type: "POST",
                url: "{{ route('saveReviewerReviews') }}",
                data: $('#employee_self_review').serialize(),
                success: function(data) {
                    if (data.status == true) {
                        Swal.fire("Success!", data.message, "success").then(function() {
                            location.reload();
                        });
                    } else {
                        Swal.fire("Error!", data.message, "error");
                    }
                    $('.loader').hide();
                    // window.location.reload();
                },
                error: function(error) {
                    $('.loader').hide();
                }
            });
        });

        // Publish/Confirm Assignee Reviews
        $('#publish_table').click(function(e) {
            e.preventDefault();
            $('#formSubmitType').val(1);
            console.log("save trigger");
            console.log($('#employee_self_review').serialize());
            $('.loader').show();
            $.ajax({
                type: "POST",
                url: "{{ route('saveReviewerReviews') }}",
                data: $('#employee_self_review').serialize(),
                success: function(data) {
                    if (data.status == true) {
                        Swal.fire("Success!", data.message, "success").then(function() {
                            location.reload();
                        });
                    } else {
                        Swal.fire("Error!", data.message, "error");
                    }
                    $('.loader').hide();
                    // window.location.reload();
                },
                error: function(error) {
                    $('.loader').hide();
                }
            });
        });


        // Accept Review
        $('#accept_review').click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to Approve?',
                icon: 'warning',
                buttons: ["Cancel", "Yes!"],
            }).then(function(value) {
                if (value) {
                    var assigneeGoalId = "{{ $assignedGoals->id }}";
                    var isApproveOrReject = '1';
                    $('.loader').show();
                    $.ajax({
                        type: "POST",
                        url: "{{ route('acceptRejectReviewerReview') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            assigneeGoalId: assigneeGoalId,
                            isApproveOrReject: isApproveOrReject,

                        },
                        success: function(data) {
                            if (data.status == true) {
                                Swal.fire("Success!", data.message, "success").then(function() {
                                    location.reload();
                                });
                            } else {
                                Swal.fire("Error!", data.message, "error");
                            }
                            $('.loader').hide();
                        },
                        error: function(error) {
                            $('.loader').hide();
                        }
                    });
                }
            });
        });

        // On click reject Rejection Comments modal should show
        $('#reject_review').click(function(e) {
            $('#modalHeader').html("Rejected");
            $('#modalNot').html(
                "Are you sure you want to reject this Kpi. If yes, please entered the reason in the below command box:"
            );
            $('#rejectionCommentModal').show('modal');
        });

        // close Rejection Comments modal
        $('body').on('click', '.close-modal', function() {
            $('#rejectionCommentModal').hide();
            $('#rejectionCommentModal').addClass('fade');
        });

        // close Rejection Comments modal
        $('body').on("keyup", '#reject_comment', function() {
            if ($(this).val() == '') {
                $('#rejection_submit').attr('disabled', true);
            } else {
                $('#rejection_submit').removeAttr('disabled');
            }
        });

        // Accept Review
        $('#rejection_submit').click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to Reject!',
                icon: 'warning',
                buttons: ["Cancel", "Yes!"],
            }).then(function(value) {
                if (value) {
                    var assigneeGoalId = "{{ $assignedGoals->id }}";
                    var isApproveOrReject = '0';
                    var reject_comment = $('#reject_comment').val();
                    $('.loader').show();
                    $.ajax({
                        type: "POST",
                        url: "{{ route('acceptRejectReviewerReview') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            assigneeGoalId: assigneeGoalId,
                            isApproveOrReject: isApproveOrReject,
                            reject_comment: reject_comment,
                        },
                        success: function(data) {
                            if (data.status == true) {
                                Swal.fire("Success!", data.message, "success").then(function() {
                                    location.reload();
                                });
                            } else {
                                Swal.fire("Error!", data.message, "error");
                            }
                            $('.loader').hide();
                        },
                        error: function(error) {
                            $('.loader').hide();
                        }
                    });
                }
            });
        });


        // show or hide table data
        function showOrHideDescription(rowIndex, element) {

            //$(collapse-'.$index)
            if ($('.collapse-' + rowIndex).css('display') == 'none') {
                $('.collapse-' + rowIndex).css('display', 'inline');

                // element.innerText = "Less"
                console.log(rowIndex + ' Less');

                element.innerText = "Less";
            } else {
                $('.collapse-' + rowIndex).css('display', 'none');
                //element.innerHTML = "More"
                console.log(rowIndex + ' More');
                element.innerText = "...More";

            }
            // console.log("showOrHide : "+element.innerText);

            // console.log("showOrHide :  %o"+element);
        }
    </script>
@endsection
