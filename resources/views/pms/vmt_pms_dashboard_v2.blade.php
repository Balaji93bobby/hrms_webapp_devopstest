@extends('layouts.master')
@section('css')
<link href="{{ URL::asset('assets/css/appraisal_review.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::asset('/assets/css/pages_profile.css') }}">
<link rel="stylesheet" href="{{ URL::asset('/assets/css/assign_goals.css') }}">

<style>
    .modal-backdrop {
        width: 0;
    }
</style>

@endsection


@section('content')
    <div class="loader" style="display:none;"></div>




    <div class="container-fluid assign-goal-wrapper mt-30">
        <div class="cards-wrapper">
            @if (Str::contains(currentLoggedInUserRole(), ['Super Admin', 'Admin', 'HR', 'Manager']))

                <div class="row">
                    <div class="col-sm-12 col-md-6 col-xl-3 col-xxl-3 col-lg-3">
                        <div class="card pms-card  left-line">
                            <div class="card-body p-0">
                                <div class=" row">
                                    <div class="col-sm-6 col-5 col-md-5 col-xl-5 col-xxl-5 col-lg-5 text-center">
                                        <img src="{{ URL::asset('assets/images/employee_goals.png') }}" alt=""
                                            class="">

                                    </div>
                                    <div
                                        class="col-sm-6  col-7 col-md-7 mt-3 col-xl-7 col-xxl-7 ps-0 col-lg-7 align-items-center flex-column d-flex">
                                        <p class="mb-1 text-center">Employee Goals</p>
                                        <p class="fw-bold mt-1 f-18 text-center">
                                            {{ $dashboardCountersData['employeesGoalsSetCount'] . '/' . $dashboardCountersData['totalEmployeesCount'] }}
                                        </p>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-xl-3 col-xxl-3 col-lg-3">
                        <div class="card pms-card  left-line">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-sm-6 col-5 col-md-5 col-xl-5 col-xxl-5 col-lg-5 text-center">
                                        <img src="{{ URL::asset('assets/images/self_review.png') }}" alt=""
                                            class="">
                                    </div>
                                    <div
                                        class="col-sm-6  col-7 col-md-7 mt-3 col-xl-7 col-xxl-7 ps-0 col-lg-7 align-items-center flex-column d-flex">
                                        <p class="mb-1 text-center">Self Review</p>
                                        <p class="fw-bold text-center mt-1 f-18">
                                            {{ $dashboardCountersData['selfReviewCount'] . '/' . $dashboardCountersData['employeesGoalsSetCount'] }}
                                        </p>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-sm-12 col-md-6 col-xl-3 col-xxl-3 col-lg-3">
                        <div class="card pms-card left-line">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-sm-6 col-5 col-md-5 col-xl-5 col-xxl-5 col-lg-5 text-center">
                                        <img src="{{ URL::asset('assets/images/employees_assessed.png') }}" alt=""
                                            class="">
                                    </div>
                                    <div
                                        class="col-sm-6  col-7 col-md-7 mt-3 col-xl-7 col-xxl-7 ps-0 col-lg-7 align-items-center flex-column d-flex">
                                        <p class="mb-1 text-center">Employees Assessed</p>
                                        <p class="fw-bold text-center mt-1 f-18">
                                            {{ $dashboardCountersData['employeesAssessedCount'] . '/' . $dashboardCountersData['selfReviewCount'] }}
                                        </p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-xl-3 col-xxl-3 col-lg-3">
                        <div class="card pms-card left-line">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-sm-6 col-5 col-md-5 col-xl-5 col-xxl-5 col-lg-5 text-center">
                                        <img src="{{ URL::asset('assets/images/pms_rating.png') }}" alt=""
                                            class="">
                                    </div>
                                    <div
                                        class="col-sm-6  col-7 col-md-7 mt-3 col-xl-7 col-xxl-7 ps-0 col-lg-7 align-items-center flex-column d-flex">
                                        <p class="mb-1 text-center">Final Score Published</p>

                                        <p class="fw-bold text-center mt-1 f-18">
                                            {{ $dashboardCountersData['finalScoreCount'] . '/' . $dashboardCountersData['employeesAssessedCount'] }}
                                        </p>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @elseif(Str::contains(currentLoggedInUserRole(), ['Employee']))
                {{-- <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 d-flex col-sm-12 col-lg-6 col-xl-6 col-xxl-6">
                            <div class="card w-100  appraisal-left-content">
                                <div class="card-body">
                                        <div class="appraisal-info left-content">
                                            <ul class="personal-info">
                                                <li>
                                                    <p class="title h5">Employee Name</p>
                                                    <p class="text">{{ !empty($assignedUserDetails) ? $assignedUserDetails->name : ''}}</p>
                                                </li>
                                                <li>
                                                    <p class="title h5"> Employee ID</p>
                                                    <p class="text">{{ !empty($assignedUserDetails) ? $assignedUserDetails->user_code : ''}}</p>
                                                </li>
                                                <li>
                                                    <p class="title h5">Job Title/Designation</p>
                                                    <p class="text">{{ !empty($assignedUserDetails) ? $assignedUserDetails->designation  : ''}}</p>
                                                </li>
                                                <li>
                                                    <p class="title h5">Business Unit/Process/Function</p>
                                                    <p class="text">{{   !empty($assignedUserDetails) ? $assignedUserDetails->department : ""}}</p>
                                                </li>
                                                <li>
                                                    <p class="title h5">Reporting Manager</p>
                                                    <p class="text">{{ !empty($reportingManagerName) ? $reportingManagerName : ''}}</p>
                                                </li>
                                                <li class="mb-0">
                                                    <p class="title h5">Review Period</p>
                                                    <p class="text">
                                                        {{ !empty($assignedUserDetails) ? $assignedUserDetails->assignment_period : ''}}
                                                    </p>
                                                </li>
                                            </ul>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6  col-sm-12 col-lg-6 col-xl-6 col-xxl-6">
                            <div class="card   appraisal-right-content">
                                <div class="card-body">

                                    <div class="mb-3 input-wrap">
                                        <p>Overall Annual Score</p> <div class="appraisal-box  btn bg-success text-white "><small>
                                                @if ($ratingDetail){{$ratingDetail['rating']}}@else - @endif</small></div>

                                    </div>
                                    <div class="mb-3 input-wrap">
                                        <p>Corresponding ANNUAL PERFORMANCE Rating </p><div class="appraisal-box  btn bg-success  text-white"><small>
                                           @if ($ratingDetail){{$ratingDetail['performance']}}@else - @endif</small></div>
                                    </div>
                                    <div class="mb-3 input-wrap">
                                        <p>Ranking</p>
                                        <div class="appraisal-box   btn bg-success text-white "><small>
                                           @if ($ratingDetail){{$ratingDetail['ranking']}}@else - @endif</small></div>
                                    </div>
                                    <div class=" input-wrap">
                                        <p>Action</p>
                                        <div class="appraisal-box btn bg-success text-white"><small>
                                           @if ($ratingDetail){{$ratingDetail['action']}}@else - @endif</small></div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div> --}}



                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-lg-3 col-xl-3 col-xxl-3 d-flex ">
                                <div class="mb-0 card w-100 border-0 boxshadow_lite4">
                                    <div class="card-body  text-center">
                                        <div class="d-flex justify-content-center">
                                            <div class="profile-img d-flex">
                                                <?php $currentUserDetails = App\Models\User::find(auth()->user()->id); ?>
                                                @include('ui-profile-avatar-lg', [
                                                    'currentUser' => $currentUserDetails,
                                                ])
                                            </div>
                                        </div>
                                        <?php //dd($assignedUserDetails);
                                        ?>
                                        <div class="appraisal_userDet mt-3">
                                            <h6>{{ $assignedUserDetails->name ?? '-'}}</h6>
                                            <p class="f-14 mt-2  text-primary">
                                                {{ $assignedUserDetails->designation ?? '-' }}
                                            </p>
                                            <p class="f-12 text-muted mt-2">
                                                {{ $assignedUserDetails->user_code ?? '-' }}</p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-lg-4 col-xl-4 col-xxl-4 d-flex  ">
                                <div class="card mb-0 w-100 border-0 boxshadow_lite4">
                                    <div class="card-body">
                                        <p class="f-14 text-ash  ">Business Unit/Process/Function</p>
                                        <p class="mb-4 f-15 fw-bold text-primary">
                                            {{ $assignedUserDetails->department_id ?? '-' }}</p>
                                        <p class="f-14 text-ash  ">Reporting Manager</p>
                                        <p class="mb-4 f-15 fw-bold text-primary ">
                                            {{ $assignedUserDetails->l1_manager_code ?? '-' }}</p>
                                    </div>
                                </div>

                            </div>
                            @if ($canShowOverallScoreCard_SelfAppraisal_Dashboard == 'true')
                                <div class="col-md-12 col-sm-12 col-lg-5 col-xl-5 col-xxl-5 d-flex my-3">
                                    <div class="card mb-0 w-100 appraisal_rating border-0 boxshadow_lite4">
                                        <div class="card-body">
                                            <p class="mb-2 fw-bold f-14 text-primary">Ratings</p>
                                            <div class="mb-3">
                                                <p class="f-14 text-ash mt-2 ">Overall Annual Score</p>
                                                <div class="row">
                                                    <div class="col-10 mt-2">
                                                        <div class="progress">
                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                style="width:25%" aria-valuenow="25" aria-valuemin="0"
                                                                aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-2">
                                                        {{-- <span class="text-primary f-15 fw-bold">1/3</span> --}}
                                                        <b class="f-15 text-primary">
                                                                {{-- {{ calculateOverallReviewRating(auth()->user()->id) ."%" }} --}}
                                                        </b>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="mb-3">
                                                <p class="f-14 text-ash mt-2 ">Corresponding ANNUAL PERFORMANCE Rating</p>
                                                <div class="row">
                                                    {{-- <div class="col-10 mt-2">
                                                <div class="progress">
                                                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                                        aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div> --}}
                                                    <div class="col-12">
                                                        <b class="f-15 text-primary">
                                                            @if (!empty($isAllReviewersSubmittedOrNot))
                                                                @if ($ratingDetail)
                                                                    {{ $ratingDetail['performance'] }}
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
                                                <p class="f-14 text-ash mt-2 ">Ranking</p>
                                                <div class="row">
                                                    <div class="col-10 mt-2">
                                                        <div class="progress">
                                                            <div class="progress-bar bg-warning" role="progressbar"
                                                                style="width: 75%" aria-valuenow="75" aria-valuemin="0"
                                                                aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-2">
                                                        <b class="f-15 text-primary">
                                                            @if (!empty($isAllReviewersSubmittedOrNot))
                                                                @if ($ratingDetail)
                                                                    {{ $ratingDetail['ranking'] }}
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
                                                <p class="f-14 text-ash mt-2 ">Review Period</p>
                                                <div class="row">
                                                    <div class="col-10 mt-2">
                                                        <div class="progress">
                                                            <div class="progress-bar bg-danger" role="progressbar"
                                                                style="width: 100%" aria-valuenow="100" aria-valuemin="0"
                                                                aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-2">
                                                        <b class="f-15 text-primary">
                                                            @if (!empty($isAllReviewersSubmittedOrNot))
                                                                @if ($ratingDetail)
                                                                    {{ $ratingDetail['action'] }}
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
                                    </div>

                                </div>
                            @endif
                        </div>

                    </div>
                </div>



            @endif




            @if (count($pmsKpiAssigneeDetails) == 0)
                <div class="mt-2 " id="initial-section">
                    <div class="row ">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center p-0 ">
                            <div class="p-3 justify-content-center d-flex align-items-center"><img
                                    src="{{ URL::asset('assets/images/assign_goals.png') }}"
                                    style="width:280px;min-height:250px;"></div>
                            <h6 class="fw-bold">Assign Goals for your employees</h6>
                            <button id="add-goals" class="btn btn-orange mt-1">
                                <i class="text-white fa fa-plus me-1"></i>
                                Add
                            </button>

                        </div>
                    </div>
                </div>
            @else
                <div class="card mb-2">
                    <div class="card-body py-1 ">
                        <ul class="nav nav-pills nav-tabs-dashed" role="tablist">
                            <li class="nav-item text-muted me-3" role="presentation">
                                <a class="nav-link active pb-2" data-bs-toggle="tab" href="#review_current"
                                    aria-selected="true" role="tab">Current
                                </a>
                            </li>
                            <li class="nav-item text-muted " role="presentation">
                                <a class="nav-link pb-2" data-bs-toggle="tab" href="#review_completed"
                                    aria-selected="false" tabindex="-1" role="tab">Completed
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div id="review_current" class="tab-pane fade show active">
                        <div class="card mb-0" style="position:relative;">
                            <div class="card-body">
                                <button id="add-goals" class="btn btn-orange add-goals "  style="z-index:1 "><i
                                        class="text-white fa fa-plus mx-1 "></i>Add
                                    Goals</button>
                                <div class="table-responsive">
                                    <table id='empTable' class=' table Fem table-borderd w-100  mb-0 '
                                        style="width:revert !important">
                                        <thead class="table-light">
                                            <tr>
                                                <td class="d-none">Serial No</td>
                                                <th scope="col">Employee Name</th>
                                                <th scope="col">Employee ID</th>

                                                <th scope="col">Manager</th>
                                                <!-- <th scope="col">Employee name</th> -->

                                                <th scope="col">Assignment Period</th>
                                                <th scope="col">Employee Status</th>
                                                <th scope="col">Manager Status</th>
                                                <th scope="col">Score</th>
                                                <th scope="col">Review </th>
                                                @if (Str::contains(currentLoggedInUserRole(), ['Super Admin', 'Admin', 'HR']))
                                                    <th scope="col">Action </th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- pms kpi assigned details foreach  -->
                                            @foreach ($pmsKpiAssigneeDetails as $key1 => $pmsKpiAssignee)
                                                <!-- gte kpi pms assignee details like currentLoggedUserRole, $decoded assigneeIds and reviewersIds -->
                                                @php $pmsKpiAssigneeData = getPmsKpiAssigneeDetails($pmsKpiAssignee->id); @endphp
                                                <!-- pms kpi assigned details assignees ids foreach  -->
                                                @foreach ($pmsKpiAssigneeData['assigneesIds'] as $key => $assigneeId)
                                                    <!-- check if Role is Assignee then check Own assignee id otherwise will show all Assignees -->
                                                    @if (($pmsKpiAssigneeData['currentLoggedUserRole'] == 'assignee' && $assigneeId == Auth::id()) ||
                                                        $pmsKpiAssigneeData['currentLoggedUserRole'] != 'assignee')
                                                        <?php
                                                        // get KpiPmsReview Details
                                                        $kpiFormAssigneeReview = getReviewKpiFormDetails($pmsKpiAssignee->id, $assigneeId);

                                                        ?>
                                                        @if ($kpiFormAssigneeReview && !isFormReviewCompleted($kpiFormAssigneeReview))
                                                            <tr>
                                                                <td class="d-none">{{ $key1 }}</td>
                                                                <td class="">
                                                                    {{-- <div class="td_content_center">{{ $pmsKpiAssignee->getUserDetails($assigneeId)['userNames'] }}</div> --}}
                                                                    <div class="row page-header-user-dropdown ms-4 align-items-center"
                                                                        style="width:200px;min-width: 230px;">
                                                                        <?php
                                                                        $employee_icon = json_decode(getEmployeeAvatarOrShortName($assigneeId));
                                                                        //    dd($employee_icon);
                                                                        ?>
                                                                        @if (!empty($employee_icon))
                                                                            @if ($employee_icon->type == 'shortname')
                                                                                <div class="col-auto p-0 me-1">
                                                                                    <span
                                                                                        class="rounded-circle user-profile  ml-2  {{ $employee_icon->color }} "
                                                                                        id="">
                                                                                        <i id="topbar_username"
                                                                                            class="align-middle ">{{ $employee_icon->data }}</i>
                                                                                    </span>
                                                                                </div>
                                                                            @elseif($employee_icon->type == 'avatar')
                                                                                <div class="col-auto p-0 me-1">
                                                                                    <img class="rounded-circle header-profile-user"
                                                                                        src=" {{ URL::asset('images/' . $employee_icon->data) }}"
                                                                                        alt="--">
                                                                                </div>
                                                                            @endif
                                                                        @endif
                                                                        <div class="col-auto me-1 p-0">
                                                                            <span class="f-12 ml-3">
                                                                                <span class="">
                                                                                    {{ $pmsKpiAssignee->getUserDetails($assigneeId)['userNames'] }}</span>
                                                                                {{-- <span
                                                                        class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text"></span> --}}

                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="">
                                                                    <div class="td_content_center">
                                                                        {{ $pmsKpiAssignee->getUserDetails($assigneeId)['userEmpIds'] }}
                                                                    </div>
                                                                </td>
                                                                <td class="" style="min-width: 150px;">
                                                                    @foreach ($pmsKpiAssigneeData['reviewersIds'] as $keyCheck => $reviewer)
                                                                        @if ($pmsKpiAssigneeData['currentLoggedUserRole'] == 'reviewer' && $reviewer == Auth::id())
                                                                            <div class=" col-auto td_content_center">
                                                                                {{ getUserDetailsById($reviewer) }}</div>
                                                                        @elseif($pmsKpiAssigneeData['currentLoggedUserRole'] != 'reviewer')
                                                                            @if ($keyCheck != 0)
                                                                                <br>
                                                                            @endif

                                                                            <div class="col-auto td_content_center">
                                                                                {{ getUserDetailsById($reviewer) }}</div>
                                                                        @endif
                                                                    @endforeach

                                                                </td>
                                                                <td class="">
                                                                    <div class="td_content_center">
                                                                        {{ strtoupper($pmsKpiAssignee->assignment_period) }}
                                                                    </div>
                                                                </td>
                                                                <td class="">
                                                                    <div class="td_content_center">
                                                                        @if (!empty($kpiFormAssigneeReview) && $kpiFormAssigneeReview->is_assignee_accepted == '0')
                                                                            Rejected
                                                                        @else
                                                                            @if (!empty($kpiFormAssigneeReview) && $kpiFormAssigneeReview->is_assignee_submitted == '1')
                                                                                Submitted
                                                                            @else
                                                                                Not yet submitted
                                                                            @endif
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                                <td class="">

                                                                    <div class="td_content_center">
                                                                        <?php echo checkCurrentLoggedUserReviewerOrNot($pmsKpiAssigneeData['reviewersIds'], $pmsKpiAssigneeData['currentLoggedUserRole'], $kpiFormAssigneeReview); ?>
                                                                    </div>
                                                                </td>
                                                                <td class="">
                                                                    <div class="td_content_center">
                                                                        @if (!empty($kpiFormAssigneeReview) && $kpiFormAssigneeReview->is_reviewer_submitted == '1')
                                                                            <?php echo calculateReviewRatings($pmsKpiAssignee->id, $assigneeId)['score']; ?>
                                                                        @else
                                                                            -
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    $checkViewReviewText = checkViewReviewText($pmsKpiAssigneeData['currentLoggedUserRole'], $kpiFormAssigneeReview);
                                                                    ?>
                                                                    <div class="td_content_center">
                                                                        <a target="_self"
                                                                            @if ($checkViewReviewText == 'Edit') href="{{ route('republishForm', $pmsKpiAssignee->id) }}" @else href="{{ url('pms-showReviewPage?assignedFormid=' . $pmsKpiAssignee->id . '&assigneeId=' . $assigneeId) }}" @endif><button
                                                                                class="btn btn-orange py-0 px-2 "
                                                                                style="min-width: 95px;"> <span
                                                                                    class="mr-10 icon"></span>
                                                                                <?php
                                                                                echo $checkViewReviewText;
                                                                                ?>
                                                                            </button></a>
                                                                    </div>
                                                                </td>
                                                                @if (Str::contains(currentLoggedInUserRole(), ['Super Admin', 'Admin', 'HR']))
                                                                    <td>

                                                                        <div class="dropdown investment_dropDown">
                                                                            <button
                                                                                class="btn  bg-transparent outline-none border-0 dropdown-toggle"
                                                                                type="button" id="dropdownMenuButton"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                <i class="fa fa-ellipsis-v f-14 text-muted"
                                                                                    aria-hidden="true"></i>
                                                                            </button>
                                                                            <div class="dropdown-menu"
                                                                                aria-labelledby="dropdownMenuButton">
                                                                                <a target="_self"
                                                                                    href="{{ route('republishForm', $pmsKpiAssignee->id) }}"
                                                                                    class="dropdown-item"
                                                                                    href="#"><i
                                                                                        class="fa fa-pencil-square-o text-info me-2"
                                                                                        aria-hidden="true"></i> Edit</a>
                                                                                <a class="dropdown-item" href="#"
                                                                                    onclick="deleteAssignedKPIForm({{ $pmsKpiAssignee->id }})"><i
                                                                                        class="fa fa-trash text-danger me-2"
                                                                                        aria-hidden="true"></i> Delete</a>
                                                                                <a class="dropdown-item"
                                                                                    href="#"></a>
                                                                            </div>
                                                                        </div>

                                                                    </td>
                                                                @endif

                                                            </tr>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="review_completed" class="tab-pane fade ">
                        <div class="card mb-0" style="position:relative;">
                            <div class="card-body">
                                {{-- <button id="add-goals" class="btn btn-orange add-goals"><i
                                        class="text-white fa fa-plus mx-1"></i>Add
                                    Goals</button> --}}
                                <div class="table-responsive">
                                    <table id='reviewCompleted_table' class=' table Fem table-borderd w-100  mb-0 '
                                        style="width:revert !important">
                                        <thead class="table-light">
                                            <tr>
                                                <td class="d-none">Serial No</td>
                                                <th scope="col">Employee Name</th>
                                                <th scope="col">Employee ID</th>

                                                <th scope="col">Manager</th>
                                                <!-- <th scope="col">Employee name</th> -->

                                                <th scope="col">Assignment Period</th>
                                                <th scope="col">Employee Status</th>
                                                <th scope="col">Manager Status</th>
                                                <th scope="col">Score</th>
                                                <th scope="col">Review </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- pms kpi assigned details foreach  -->
                                            @foreach ($pmsKpiAssigneeDetails as $key1 => $pmsKpiAssignee)
                                                <!-- gte kpi pms assignee details like currentLoggedUserRole, $decoded assigneeIds and reviewersIds -->
                                                @php $pmsKpiAssigneeData = getPmsKpiAssigneeDetails($pmsKpiAssignee->id); @endphp
                                                <!-- pms kpi assigned details assignees ids foreach  -->
                                                @foreach ($pmsKpiAssigneeData['assigneesIds'] as $key => $assigneeId)
                                                    <!-- check if Role is Assignee then check Own assignee id otherwise will show all Assignees -->
                                                    @if (($pmsKpiAssigneeData['currentLoggedUserRole'] == 'assignee' && $assigneeId == Auth::id()) ||
                                                        $pmsKpiAssigneeData['currentLoggedUserRole'] != 'assignee')
                                                        <?php
                                                        // get KpiPmsReview Details
                                                        $kpiFormAssigneeReview = getReviewKpiFormDetails($pmsKpiAssignee->id, $assigneeId);

                                                        //dd(isFormReviewCompleted($kpiFormAssigneeReview));

                                                        ?>

                                                        @if ($kpiFormAssigneeReview && isFormReviewCompleted($kpiFormAssigneeReview))
                                                            <tr>
                                                                <td class="d-none">{{ $key1 }}</td>
                                                                <td class="" style="min-width: 185px;">
                                                                    {{-- <div class="td_content_center">{{ $pmsKpiAssignee->getUserDetails($assigneeId)['userNames'] }}</div> --}}
                                                                    <div
                                                                        class="row page-header-user-dropdown align-items-center">
                                                                        <?php
                                                                        $employee_icon = json_decode(getEmployeeAvatarOrShortName($assigneeId));
                                                                        ?>
                                                                        @if (!empty($employee_icon))
                                                                            @if ($employee_icon->type == 'shortname')
                                                                                <div class="col-auto p-0">
                                                                                    <span
                                                                                        class="rounded-circle user-profile   me-1  {{ $employee_icon->color }}"
                                                                                        id="">
                                                                                        <i id="topbar_username"
                                                                                            class="align-middle ">{{ $employee_icon->data }}</i>
                                                                                    </span>
                                                                                </div>
                                                                            @elseif($employee_icon->type == 'avatar')
                                                                                <div class="col-auto p-0">
                                                                                    <img class="rounded-circle header-profile-user"
                                                                                        src=" {{ URL::asset('images/' . $employee_icon->data) }}"
                                                                                        alt="--">
                                                                                </div>
                                                                            @endif
                                                                        @endif
                                                                        <div class="col-auto p-0">
                                                                            <span class="f-12 ml-3">
                                                                                <span class="">
                                                                                    {{ $pmsKpiAssignee->getUserDetails($assigneeId)['userNames'] }}</span>
                                                                                {{-- <span
                                                                        class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text"></span> --}}

                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="">
                                                                    <div class="td_content_center">
                                                                        {{ $pmsKpiAssignee->getUserDetails($assigneeId)['userEmpIds'] }}
                                                                    </div>
                                                                </td>
                                                                <td class="" style="min-width: 130px;">
                                                                    @foreach ($pmsKpiAssigneeData['reviewersIds'] as $keyCheck => $reviewer)
                                                                        @if ($pmsKpiAssigneeData['currentLoggedUserRole'] == 'reviewer' && $reviewer == Auth::id())
                                                                            <div class=" col-auto td_content_center">
                                                                                {{ getUserDetailsById($reviewer) }}</div>
                                                                        @elseif($pmsKpiAssigneeData['currentLoggedUserRole'] != 'reviewer')
                                                                            @if ($keyCheck != 0)
                                                                                <br>
                                                                            @endif

                                                                            <div class="col-auto td_content_center">
                                                                                {{ getUserDetailsById($reviewer) }}</div>
                                                                        @endif
                                                                    @endforeach

                                                                </td>
                                                                <td class="">
                                                                    <div class="td_content_center">
                                                                        {{ strtoupper($pmsKpiAssignee->assignment_period) }}
                                                                    </div>
                                                                </td>
                                                                <td class="">
                                                                    <div class="td_content_center">

                                                                        @if (!empty($kpiFormAssigneeReview) && $kpiFormAssigneeReview->is_assignee_submitted == '1')
                                                                            Submitted
                                                                        @else
                                                                            Not yet submitted
                                                                        @endif

                                                                    </div>
                                                                </td>
                                                                <td class="">

                                                                    <div class="td_content_center">
                                                                        <?php echo checkCurrentLoggedUserReviewerOrNot($pmsKpiAssigneeData['reviewersIds'], $pmsKpiAssigneeData['currentLoggedUserRole'], $kpiFormAssigneeReview); ?>
                                                                    </div>
                                                                </td>
                                                                <td class="">
                                                                    <div class="td_content_center">
                                                                        <?php echo calculateReviewRatings($pmsKpiAssignee->id, $assigneeId)['score']; ?>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    $checkViewReviewText = checkViewReviewText($pmsKpiAssigneeData['currentLoggedUserRole'], $kpiFormAssigneeReview);
                                                                    ?>
                                                                    <div class="td_content_center">
                                                                        <a target="_self"
                                                                            @if ($checkViewReviewText == 'Edit') href="{{ route('republishForm', $pmsKpiAssignee->id) }}" @else href="{{ url('pms-showReviewPage?assignedFormid=' . $pmsKpiAssignee->id . '&assigneeId=' . $assigneeId) }}" @endif><button
                                                                                class="btn btn-orange py-0 px-2 "
                                                                                style="min-width: 95px;"> <span
                                                                                    class="mr-10 icon"></span>
                                                                                <?php
                                                                                echo $checkViewReviewText;
                                                                                ?>
                                                                            </button></a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif


        </div>
    </div>

    <div id="add-goals-modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable  modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header py-2 new-role-header border-0 d-flex align-items-center">
                    <h6 class="modal-title">
                        New Assign Goals</h6>
                    <button type="button" class="close outline-none bg-transparent border-0 h3" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>

                </div>
                <div class="modal-body">
                    <div class="card profile-box p-2 top-line">
                        <div class="card-body">

                            <form id="goalForm">
                                <input type="hidden" name="goal_id" id="goal_id">
                                @csrf
                                <input type="hidden" name="flowCheck" id="flowCheck" value="{{ $flowCheck }}">
                                <input type="hidden" name="kpitable_id" id="kpitable_id">

                                <!-- <input type="hidden" name="reviewer" id="sel_reviewer"> -->
                                <input type="hidden" name="assignment_period_year" id="assignment_period_year"
                                    value="<?php echo date('Y'); ?>">


                                <div class="row ">
                                    <div class=" col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-4  mb-2">
                                        <label for="calendar_type">Calendar Type</label>
                                        <span id="spanCalenderType" class="form-control">{{ $calendar_type }}</span>
                                        <input type="hidden" name="calendar_type" id="calendar_type"
                                            value="{{ $calendar_type }}">

                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-4  mb-2">
                                        <label class="" for="year">Year</label>
                                        <input name="hidden_calendar_year" id="hidden_calendar_year" class="form-control"
                                            value="{{ $year }}" readonly>

                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-4  mb-2">
                                        <label class="" for="frequency">Frequency</label>
                                        <span id="spanFrequency" class="form-control">{{ $frequency }}</span>

                                        <input type="hidden" name="frequency" id="frequency"
                                            value="{{ $frequency }}">

                                    </div>
                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4  mb-2">
                                        <label class="" for="assignment_period_start">Assignment Period</label>
                                        <span class="form-control">{{ ucfirst($assignment_period) }}</span>

                                        <input type="hidden" name="assignment_period_start" id="assignment_period_start"
                                            class="form-control "value="{{ $assignment_period }}">


                                    </div>




                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4  mb-2">
                                        <label class="" for="department">Department</label>
                                        <select name="department" id="department" class="form-control form-select">
                                            <option value="" selected disabled>Select Department</option>
                                            @foreach ($departments as $dept)
                                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="row">
                                        <!-- employee Selection portion starts -->
                                        @if (!empty($parentReviewerIds) && !empty($parentReviewerNames))
                                            <!-- flow 1 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-4  mb-2">
                                                <label class="" for="">Employees</label>
                                                <input type="hidden" id="hidden_selectedEmployees" name="employees"
                                                    value="{{ $loggedInUser->id }}">
                                                <input type="text" disabled class="form-control increment-input"
                                                    placeholder="Employee" value="{{ $loggedInUser->name }}">
                                            </div>
                                        @else
                                            <!-- flow 2 & 3 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-4  mb-2">
                                                <label class="" for="">Employees</label>
                                                <div class="employee-selection-section">

                                                </div>
                                                <input type="hidden" name="employees" id="employeesSelectedValues">
                                            </div>
                                        @endif
                                        <!-- employee Selection portion Ends -->

                                        <!-- Reviewer Selection Portion Starts -->
                                        @if (isset($parentReviewerIds) && isset($parentReviewerNames))
                                            <!-- flow 3 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-4  mb-2">
                                                <label class="" for="">Reviewer</label>
                                                <input type="hidden" class="form-control" name="reviewer"
                                                    value="{{ $parentReviewerIds }}">
                                                <input type="text" disabled class="form-control increment-input"
                                                    placeholder="Reviewer" value="{{ $parentReviewerNames }}">
                                            </div>
                                        @elseif(isset($loggedManagerEmployees))
                                            <!-- flow 2 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-4  mb-2">
                                                <label class="" for="">Reviewer</label>
                                                @if (isset($getSameLevelManagers) && count($getSameLevelManagers) > 0)
                                                    <select
                                                        class="select-reviewer-dropdown form-select form-control form-select"
                                                        name="reviewer">
                                                        <option value="" selected disabled>Reviewer</option>
                                                        @foreach ($getSameLevelManagers as $sameLevelManager)
                                                            <option @if ($sameLevelManager->id == Auth::id()) selected @endif
                                                                value="{{ $sameLevelManager->id }}">
                                                                {{ $sameLevelManager->name }}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <input type="hidden" name="reviewer"
                                                        value="{{ $loggedUserDetails->id }}">
                                                    <input type="text" disabled class="form-control increment-input"
                                                        placeholder="Reviewer" value="{{ $loggedUserDetails->name }}">
                                                @endif
                                            </div>
                                        @else
                                            <!-- flow 1 -->
                                            <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 col-xxl-3  mb-2">

                                                <label class="" for="">Reviewer</label>

                                                <select
                                                    class="select-multiple-reviewer search-bar form-select form-control"
                                                    name="reviewer[]" multiple="multiple">
                                                    @if (isset($allEmployeesList) && count($allEmployeesList) > 0)
                                                        @foreach ($allEmployeesList as $employeeData)
                                                            <option value="{{ $employeeData->id }}">
                                                                {{ $employeeData->name }}</option>
                                                        @endforeach
                                                    @else
                                                        <option value="">Select Reviewer</option>
                                                    @endif
                                                </select>

                                            </div>
                                            <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1 col-xxl-1   ">
                                                <label class="" for=""></label>
                                                <button id="" type="button" target="#reviewerReplaceSameLevel"
                                                    class="btn py-1 px-3 btn btn-orange increment-btn  reviewerReplace">Change</button>
                                            </div>

                                            <div class=" col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4  mb-3">
                                                <label class="" for="">Final Reviewer</label>
                                                <select class="form-control form-select select-hr-dropdown"
                                                    name="hr_id">
                                                    @if (isset($allEmployeesList) && count($allEmployeesList) > 0)
                                                        @foreach ($allEmployeesList as $employeeData)
                                                            <option value="{{ $employeeData->id }}">
                                                                {{ $employeeData->name }}</option>
                                                        @endforeach
                                                    @else
                                                        <option value="">Select Reviewer</option>
                                                    @endif
                                                </select>
                                            </div>


                                        @endif
                                        <!-- Reviewer Selection Portion Ends -->
                                    </div>
                                </div>

                                {{-- </form> --}}
                        </div>
                    </div>
                    <div class="card  profile-box p-2 top-line ">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xxl-12 col-xl-12">
                                    <h5 class="text-start">Goals / Areas of development</h5>
                                </div>
                                <div class="col-sm-12 col-md-5 col-lg-5 col-xxl-5 col-xl-5">
                                    <label class="form-label">Select existing form from the Dropdown</label>
                                </div>
                                <div class="col-sm-8 col-md-6 col-lg-6 col-xl-6 col-xl-6 w-80">
                                    {{-- <form id="kpiTableForm"> --}}
                                    @csrf

                                    <select name="selected_kpi_form_id" id="selected_kpi_form_id"
                                        class="ms-2 selectedKpiFormClass form-select form-control mb-2">

                                    </select>

                                </div>
                                <div
                                    class="col-sm-8 col-md-1 col-lg-1 col-xxl-1 col-xl-1 d-flex align-items-center text-start ">
                                    <i class="fa fa-refresh	refreshKPIFormDetails" aria-hidden="true"></i>
                                </div>
                                <div
                                    class="col-sm-12 col-md-1 col-lg-1 col-xxl-1 col-xl-1 d-flex align-items-center text-start w-40">
                                    <button class="btn btn-orange mt-2 w-40" id="view-form">View Form</button>
                                </div>
                                </form>
                                <div
                                    class="col-sm-12 col-md-6 col-lg-6 col-xxl-6 col-xl-6 d-flex align-items-center text-start">

                                    <!-- <a href="{{ route('showKPICreateForm') }}" target="_blank"> -->
                                    <a class="createKpiFromOnClick cursor-pointer plus-sign" target="_self">
                                        <i class="fa fa-plus-circle me-2"></i>Create
                                        KPI Form</a>

                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xxl-6 col-xl-6 text-end">
                                    <button class="btn btn-orange mt-2" id="publish-goal">Publish</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>

    <!-- Change Reviewer window -->

    <div id="reviewerReplaceSameLevel" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable fad  modal-md" role="document">
            <div class="modal-content top-line">
                <div class="modal-header py-2 new-role-header border-0 d-flex align-items-center">
                    <h6 class="modal-title ">
                        Change Reviewer</h6>
                    <button type="button" class="close outline-none bg-transparent border-0 h3" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="changeReviewForm" action="{{ route('changeReviewerSelection') }}" method="POST">
                        @csrf
                        <h6 for="FormSelectDefault" class="form-label text-muted">Reviewer</h6>
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12 col-xxl-12 col-xl-12">
                                <label class="" for="">Existing Reviewer</label>
                                <select class="change-exiting-reviewer form-control" name="oldReviewerName">

                                </select>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12 col-xxl-12 col-xl-12">
                                <label class="" for="">New Reviewer</label>
                                <select class="with-new-reviewer form-control" name="newReviewerName">

                                </select>
                                <span style="color: red;" id="reviewerChangeError"></span>
                            </div>
                        </div>
                        <div class="content-footer text-end">
                            <button class="btn btn-orange waves-effect waves-light" type="submit">
                                Save
                            </button>

                        </div>
                </div>
                </form>

            </div>
        </div>
    </div>
    <!-- add employee  Modal-->
    </div>

    <!-- Vertically Centered -->
    <div id="notificationModal" class="modal custom-modal fade" role="dialog" aria-hidden="true"
        style="opacity:1; display:none;background:#00000073;">
        <div class="modal-dialog modal-dialog-centered   modal-md" role="document">
            <div class="modal-content top-line">
                <div class="modal-header py-2 new-role-header border-0 d-flex align-items-center">
                    <h6 class="modal-title ">
                        Success</h6>
                    <button type="button" class="close outline-none bg-transparent border-0 h3" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <h4 class="mb-3" id="modalNot">Data Saved Successfully!</h4>
                    <p class="text-muted mb-2" id="modalBody"> Table Saved, Please publish goals.</p>
                    <div class="modal-footer p-0 border-0">
                        <button type="button" class="btn btn-light close-modal" data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- employee edit modal starts -->
    <div id="employeeSelectionModal" class="modal custom-modal fade" role="dialog" aria-hidden="true"
        style="opacity:1; display:none;background:#00000073;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable  modal-md" role="document">
            <div class="modal-content top-line">
                <div class="modal-header py-2 new-role-header border-0 d-flex align-items-center">
                    <h6 class="modal-title ">
                        Edit Employee</h6>
                    <button type="button" id="closebtn_editEmployees"
                        class="close outline-none bg-transparent border-0 h3 " data-bs-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    @if (isset($loggedManagerEmployees))
                        <!-- flow 2 -->
                        <div class="row">
                            <div class="col-8">
                                <select class="select-employee-dropdown form-control" name="employees[]"
                                    multiple="multiple">
                                    @foreach ($loggedManagerEmployees as $employeesSelection)
                                        <option selected value="{{ $employeesSelection->id }}">
                                            {{ $employeesSelection->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4 text-end">
                                <button class="btn btn-primary py-0 px-2" onclick="resetEmployeesList()">Reset
                                    Employees</button>
                            </div>
                        </div>
                    @else
                        <!-- flow 1 -->
                        <div class="col-8 ">
                            <select class="select-employee-dropdown form-control form-select"
                                id="selectedEmployeeDropdownId" name="employees[]" multiple="multiple">
                                @if (isset($allEmployeesWithoutLoggedUserList) && count($allEmployeesWithoutLoggedUserList) > 0)
                                    @foreach ($allEmployeesWithoutLoggedUserList as $employeeList)
                                        <option value="{{ $employeeList->id }}">{{ $employeeList->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    @endif

                    @if (isset($loggedManagerEmployees))
                        <div class="buttons text-end mt-4 ">
                            <!-- <button type="button" class="btn btn-border-orange close-modal " data-bs-dismiss="modal">Close</button> -->
                            <button class="btn btn-primary ml-2" id="edit-employee">Save</button>
                        </div>
                    @else
                        <div class="buttons text-end mt-4 ">
                            <!-- <button type="button" class="btn btn-border-orange close-modal" data-bs-dismiss="modal">Close</button> -->
                            <button class="btn btn-orange ml-2" id="edit-employee-based-on-reviewer">Save</button>
                        </div>
                    @endif
                    <span id="edit-employee-error-message">
                </div>
            </div>
        </div>
    </div>


    <div style="z-index: 11">
        <div id="errorMessageNotif1" class="toast toast-border-danger overflow-hidden mt-3" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="toast-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-2">
                        <i class="ri-alert-line align-middle"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0">Something is very wrong! <a href="javascript:void(0);"
                                class="text-decoration-underline">See detailed report.</a></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>



    </div>
@endsection




@section('script')
    @yield('script-profile-avatar')




    <script src="{{ URL::asset('/assets/premassets/js/footable.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/premassets/css/footable.bootstrap.min.css') }}"></script>


    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

    <!-- Prem assets ends -->

    <!-- for date and time -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <?php if(isset($loggedManagerEmployeesIDs)){?>
    <script>
        function resetEmployeesList() {
            var loggedManagerEmployeesIDs = [<?php echo $loggedManagerEmployeesIDs; ?>];
            if (loggedManagerEmployeesIDs.length > 0) {

                $(".select-employee-dropdown").val(loggedManagerEmployeesIDs);
                $('.select-employee-dropdown').trigger('change');
            }
        }
    </script>
    <?php } ?>
    <script>
        function deleteAssignedKPIForm(assignedKPIFormID) {

            console.log("Deleting Assigned KPI Form");

            Swal.fire({
                title: 'Are you sure you want to delete?',
                text: "The data cannot be retrieved",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        type: "POST",
                        url: "{{ route('deleteAssignedKPIForm') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "assignedKPIFormID": assignedKPIFormID,
                        },
                        success: function(data) {
                            if (data.status == 'success') {

                                Swal.fire(
                                    'Deleted!',
                                    'Assigned KPI Form has been deleted.',
                                    'success'
                                ).then((result) => {
                                    window.location.reload();
                                });
                            } else {

                                if (data.status == 'success') {

                                    Swal.fire(
                                        'Error!',
                                        'Failed to delete the assigned KPI Form',
                                        'failure'
                                    )
                                }
                            }
                        },
                        error: function(error) {
                            console.log('something went wrong');
                        }
                    });
                } else {
                    return false;
                }
            });

        }


        function generateProfileShortName_Topbar() {
            var username =
                '{{ auth()->user()->name ??
                    '
                                                                                                                                                                                                                                                                                                                                                                                                ' }}';
            const splitArray = username.split(" ");
            var finalname = "empty111";

            if (splitArray.length == 1) {
                finalname = splitArray[0][0] + "" + splitArray[0][1];
            } else {
                if (splitArray[0].length == 1)
                    finalname = splitArray[0][0] + "" + splitArray[1][0];
                else
                    finalname = splitArray[0][0] + "" + splitArray[0][1];
            }

            var a = $('#topbar_username').text(finalname.toUpperCase());
        }


        $('.refreshKPIFormDetails').click(function() {
            $('.loader').show();
            getKPIFormDetails();
        })

        getKPIFormDetails();



        function getKPIFormDetails() {
            $.ajax({
                type: "GET",
                url: "{{ route('getKPIFormNameInDropdown') }}",
                success: function(data) {
                    if (data.status == true) {
                        var finalResult = '<option value="">Select KPI Form</option>'
                        $.each(data.result, function(key, val) {
                            finalResult += '<option value="' + val.id + '">' + val.form_name +
                                '</option>';
                        })
                        $('.selectedKpiFormClass').html(finalResult);
                    } else {
                        Swal.fire('Wrong!', data.message, 'error');
                    }
                    $('.loader').hide();
                },
                error: function(error) {
                    console.log('somethig went wrong');
                    $('.loader').hide();
                }
            });
        }

        var selectedEmployeesId = $('.select-employee-dropdown').val();
        changeAssigneeProfilePicOnSelection(selectedEmployeesId);

        function changeAssigneeProfilePicOnSelection(selectedEmployeesId) {
            var selectedEmployeesId = selectedEmployeesId;
            $.ajax({
                type: "POST",
                url: "{{ route('changeEmployeeProfileIconsOnEdit') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    selectedEmployeesId: selectedEmployeesId,
                },
                success: function(data) {
                    if (data.status == true) {
                        $('.employee-selection-section').html(data.html);
                        //$('.employeeEditButton').css({"background-color": "#ee6a04"});
                        $('#employeeSelectionModal').hide();
                        $('#employeeSelectionModal').addClass('fade');
                        $('#employeesSelectedValues').val(selectedEmployeesId);

                    }
                },
                error: function(error) {
                    console.log('something went wrong');
                }
            });
        }

        $(document).on("click", ".employeeEditButton", function() {
            var assignmentPeriod = $('#assignment_period_start').val();
            console.log(assignmentPeriod);

            if (assignmentPeriod && assignmentPeriod != '') {
                $("#add-goals-modal").modal('hide');
                $('#employeeSelectionModal').show();
                $('#employeeSelectionModal').removeClass('fade');
            } else {
                console.log("Error : Please select the assignment period.")
            }
        })


        $(document).on('click', '#employeeSelectionModal .close', function() {
            $('#employeeSelectionModal').hide();
            $('#employeeSelectionModal').addClass('fade');

            $('#add-goals-modal').modal('show');
        })

        $('#edit-employee').click(function() {
            var selectedEmployeesId = $('.select-employee-dropdown').val();
            // getReviewerOfSelectedEmployee(selectedEmployeesId);
            $('#add-goals-modal').modal('show');
            changeAssigneeProfilePicOnSelection(selectedEmployeesId);
        });

        //Called when EDIT EMPLOYEES modal's close button is pressed instead of SAVE button.
        //This will update the profile pics in Add Goals modal
        $('#closebtn_editEmployees').click(function() {
            var selectedEmployeesId = $('.select-employee-dropdown').val();
            changeAssigneeProfilePicOnSelection(selectedEmployeesId);
        });

        $('#edit-employee-based-on-reviewer').click(function() {

            var selectedEmployeesId = $('.select-employee-dropdown').val();
            var assignmentPeriod = $('#assignment_period_start').val();
            var year = $('#hidden_calendar_year').val();

            console.log("Checking if KPI already assigned :: ")
            console.log("assignmentPeriod : " + assignmentPeriod);
            console.log("Year : " + year);

            $(document).on("click", ".employeeEditButton", function() {
                var assignmentPeriod = $('#assignment_period_start').val();

                console.log(assignmentPeriod);

                if (assignmentPeriod && assignmentPeriod != '') {
                    $("#add-goals-modal").modal('hide');
                    $('#employeeSelectionModal').show();
                    $('#employeeSelectionModal').removeClass('fade');
                } else {
                    console.log("Error : Please select the assignment period.")
                }
            });

            /*
            Need to check whether KPI Goals are already assigned for the selected 'Assignment Period and Year'.
            If already assigned, then show error and ask the user to remove those emps
            */
            isKPIAlreadyAssignedForGivenAssignmentPeriod(selectedEmployeesId, assignmentPeriod, year, true);


            // getReviewerOfSelectedEmployee(selectedEmployeesId);

        });
    </script>

    <script>
        $(document).ready(function() {

            $('.reviewerReplace').hide();

            $('.createKpiFromOnClick').click(function() {
                console.log("Create KPI button clicked");

                var assignmentPeriod = $('#assignment_period_start').val();
                var year = $('#year').val();
                if (assignmentPeriod != '' && year != '') {
                    var YearText = $("#year option:selected").text();
                    var url = '{{ route('showKPICreateForm', ':year') }}';
                    url = url.replace(':year', YearText);
                    // alert(url);
                    window.open(url, "_self");
                    return false;
                } else {
                    alert("Please enter Assignment Period and Year ");
                }

            });


            $('.selectedKpiFormClass').select2({
                dropdownParent: $("#add-goals-modal"),
                width: '98%'
            });

            $('.select-employee-dropdown').select2({
                dropdownParent: $("#employeeSelectionModal"),
                width: '100%'
            });

            $('#select-employee-dropdown').on('select2:opening select2:closing', function(event) {
                var $searchfield = $(this).parent().find('.select2-search__field');
                $searchfield.prop('disabled', true);
            });

            $('.select-reviewer-dropdown').select2({
                dropdownParent: $("#add-goals-modal"),
                width: '100%'
            });
            $('.change-exiting-reviewer').select2({
                dropdownParent: $("#reviewerReplaceSameLevel"),
                width: '100%'
            });
            $('.with-new-reviewer').select2({
                dropdownParent: $("#reviewerReplaceSameLevel"),
                width: '100%'
            });

            $('.select-multiple-reviewer').select2({
                dropdownParent: $("#add-goals-modal"),
                width: '100%'
            });
            $('.select-hr-dropdown').select2({
                dropdownParent: $("#add-goals-modal"),
                width: '100%'
            });



        });

        var prevReviewerCount = '';
        var prevReviewerList = [];
        var currentReviewerCount = $('.select-multiple-reviewer').val().length;
        var currentReviewerList = $('.select-multiple-reviewer').val();

        // $(".select-multiple-reviewer").on("select2:select", function (e) {
        //     // var select_val = $(e.currentTarget).val();
        //     var selected_element = $(e.currentTarget);
        //     var select_val = selected_element.val();
        //     alert(select_val);
        // });
        $('.select-multiple-reviewer').change(function(e) {
            console.log(e);
            prevReviewerCount = currentReviewerCount;
            prevReviewerList = currentReviewerList;
            currentReviewerCount = $(this).val().length;
            currentReviewerList = $(this).val();

            var latest_value = $(this).val();
            checkReviewersExistOrNot();
            if (currentReviewerCount > prevReviewerCount) {

                var selectedReviewer = '';

                $.each(currentReviewerList, function(key, val) {
                    if ($.inArray(val, prevReviewerList) <= -1) {
                        selectedReviewer = val;
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('getEmployeesOfReviewer') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        selectedReviewer: selectedReviewer,
                    },
                    success: function(data) {

                        $.each(data.result, function(i, value) {
                            var existingEmployeesId = $('#selectedEmployeeDropdownId').val();
                            existingEmployeesId.push(value.id);
                            $('#selectedEmployeeDropdownId').val(existingEmployeesId);
                            $('#selectedEmployeeDropdownId').trigger('change');
                        });
                        var selectedEmployeesId = $('#selectedEmployeeDropdownId').val();
                        changeAssigneeProfilePicOnSelection(selectedEmployeesId);

                    },
                    error: function(error) {
                        console.log('something went wrong');
                    }
                });
            }
        })

        /*
            For the selected employees,Check whether the KPI is already assigned
            for the assignment period.

            canUpdateReviewer - Updates the Reviewer name based on given employees.

        */
        function isKPIAlreadyAssignedForGivenAssignmentPeriod(t_selectedEmployeeId, assignmentPeriod, year,
            canUpdateReviewer) {

            $.ajax({
                url: "{{ route('isKPIAlreadyAssignedForGivenAssignmentPeriod') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    selectedEmployeeId: t_selectedEmployeeId,
                    assignmentPeriod: assignmentPeriod,
                    year: year
                },
                success: function(data) {
                    console.log(data);

                    if (data) {
                        $('#edit-employee-error-message').html('');

                        //If KPI's already assigned to the selected emps, then show their names
                        if (data.status == true) {
                            $('#edit-employee-error-message').append("<b><u>" + data.message + "</u></b><br/>");
                            $('#edit-employee-error-message').append("<ul>");

                            $.each(data.result, function(i, value) {
                                $('#edit-employee-error-message').append("<li>" + value + "</li>");
                            });

                            $('#edit-employee-error-message').append("</ul>");
                            $('#edit-employee-error-message').append(
                                "<b>Please remove these employees before proceeding.</b>");

                        } else
                        if (data.status == false || data.status ==
                            'error'
                        ) // if no KPIs already assigned to the selected Emps for the given assignment period, then no issues.
                        {
                            console.log("No KPIs assigned to selected users");
                            $('#edit-employee-error-message').append('');

                            changeAssigneeProfilePicOnSelection(selectedEmployeesId);

                            //Update reviewer box if TRUE, else leave it.FALSE is used while using this function on  PUBLISH button click
                            getReviewerOfSelectedEmployee(t_selectedEmployeeId);

                            // if (canUpdateReviewer == true)
                            //     getReviewerOfSelectedEmployee(t_selectedEmployeeId);
                            // else
                            // {
                            //     $('#add-goals-modal').modal('show');
                            //     var afterUpdateEmployee = $('.select-employee-dropdown').val();
                            //     changeAssigneeProfilePicOnSelection(afterUpdateEmployee);
                            // }

                        }
                        // else
                        // if(data.status == 'error')// if any error occurs .
                        // {
                        //     $('#edit-employee-error-message').append(data.message);
                        // }
                    } else {
                        console.log("ERROR :: isKPIAlreadyAssignedForGivenAssignmentPeriod  : " + data);
                    }
                },
                error: function(error) {
                    console.log("ERROR(Ajax Failed) :: isKPIAlreadyAssignedForGivenAssignmentPeriod  ");
                }
            });
        }

        // $('.select-employee-dropdown').change(function(){
        function getReviewerOfSelectedEmployee(selectedEmployeeId) {
            var selectedEmployeeId = selectedEmployeeId;
            $.ajax({
                type: "POST",
                url: "{{ route('getReviewerOfSelectedEmployee') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    selectedEmployeeId: selectedEmployeeId,
                },
                success: function(data) {

                    if (data.status == true) {
                        $.each(data.result.removeSelectedEmployee, function(i, value) {
                            $(".select-employee-dropdown option[value=" + value + "]").remove();
                        });
                        $(".select-multiple-reviewer").val(data.result.reviewerIds);
                        $('.select-multiple-reviewer').trigger('change.select2');


                        $("#reviewersAccordingAssignee").val(data.result.reviewerNames.join(","));
                        $("#selectedReviewIds").val(data.result.reviewerIds.join(","));
                        var afterUpdateEmployee = $('.select-employee-dropdown').val();
                    } else {
                        console.log('no reviewer');
                        $('.select-multiple-reviewer').val('')
                        $('.select-multiple-reviewer').trigger('change.select2');
                        $("#selectedReviewIds").val('');
                    }
                    $('#add-goals-modal').modal('show');
                    checkReviewersExistOrNot();
                    changeAssigneeProfilePicOnSelection(afterUpdateEmployee);
                },
                error: function(error) {
                    console.log('something went wrong');
                }
            });
        }
    </script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // $('#select-reviewer').select2({
            //     dropdownParent: '#createEmployee',
            //     minimumResultsForSearch: Infinity,
            // 	width: '100%'
            // });



            ft = FooTable.init('#kpiTable', {});

            $('body').on('keyup', '.bockquote', function() {
                var val = $(this).html();
                var id = $(this).attr('data-id');
                $('#' + id).val(val);
            })

            $(document).on('#select-reviewer:open', () => {
                $('.select2-search__field').focus();
            });

            $('#empTable').DataTable({

            });
            $('#reviewCompleted_table').DataTable({

            });


            $('#assignment_period_start').change(function() {
                //When assignment period has value, then change EDIT button color to orange
                $('.employeeEditButton').css({
                    "background-color": "#ee6a04"
                });
            });

        });

        $(function() {
            $("#kpiTable").sortable({
                items: 'tr',
                cursor: 'pointer',
                axis: 'y',
                dropOnEmpty: false,
                start: function(e, ui) {
                    ui.item.addClass("selected");
                },
                stop: function(e, ui) {
                    ui.item.removeClass("selected");
                    $(this).find("tr").each(function(index) {
                        // if (index > 0) {
                        //     $(this).find("td").eq(1).html(index);
                        // }
                    });
                }
            });
        });
    </script>
    <script>
        // $("#select-reviewer").select2({
        //     dropdownParent: $("#createEmployee")
        // });
        // $('.reviewerButton').click(function() {
        //     $('#createEmployee').show();
        //     $('#createEmployee').removeClass('fade');
        // });
        $('.close-reviewerButton').click(function() {
            $('#add-goals-modal').modal('show');

            $('#reviewerReplaceSameLevel').hide();
            $('#reviewerReplaceSameLevel').addClass('fade');
        });


        $('#add-goals').click(function() {

            //Reset the old values in 'add-goals-model'
            $('.select-employee-dropdown').val('');
            // $('#calendar_type').val('');
            // $('#assignment_period_start').val('');
            // $('#year').val('');
            // $('#frequency').val('');
            $('#department').val('');

            // For Calender Type input Field
            var calenderType = $("#calendar_type").val();
            if (calenderType == "financial_year") {
                $("#spanCalenderType").text("Financial Year");

            } else if (calenderType == "calendar_year") {
                $("#spanCalenderType").text("Calendar  Year");
            }


            //// For frequency Type input Field
            var frequencyType = $("#frequency").val();

            if (frequencyType == "monthly") {
                $("#spanFrequency").text("Monthly");
            } else if (frequencyType == "quarterly") {
                $("#spanFrequency").text("Quarterly");
            } else if (frequencyType == "halfYearly") {
                $("#spanFrequency").text("Half Yearly");
            } else if (
                frequencyType == "yearly") {
                $("#spanFrequency").text("Yearly");
            }
            // console.log("Testing"+$("#spanFrequency").text("Monthly"););


            $('#add-goals-modal').modal('show');




            //Inside Add goals modal, Change employees Add button color if assignment-period not yet selected
            var assignmentPeriod = $('#assignment_period_start').val();
            console.log('assignmentPeriod : ' + assignmentPeriod);

            if (!assignmentPeriod || assignmentPeriod == '') {
                $('.employeeEditButton').css({
                    "background-color": "#B0B0B0"
                });
            }

        });



        $('body').on('click', '.close-modal', function() {
            $('#notificationModal').hide();
            $('#notificationModal').addClass('fade');
            window.location.reload();
        })

        $('body').on('click', '.close-modal-employee', function() {
            $('#employeeSelectionModal').hide();
            $('#employeeSelectionModal').addClass('fade');
        })

        // check reviewers are exists or not in reviewers textbox except logged in user
        function checkReviewersExistOrNot() {
            var values = [];
            var selectedReviewersVal = $(".select-multiple-reviewer").val();

            console.log(selectedReviewersVal);
            $.each(selectedReviewersVal, function(key, val) {
                console.log(key);
                if ('{{ $loggedInUser->id }}' != val) {
                    values.push(val);
                }
            });
            if (values.length > 0) {
                $('.reviewerReplace').show();
            } else {
                $('.reviewerReplace').hide();
            }
        }

        $('.reviewerReplace').click(function() {
            var result = '';
            $.each($(".select-multiple-reviewer option:selected"), function() {
                if ($(this).val() != '{{ $loggedInUser->id }}') {
                    result += '<option value="' + $(this).val() + '">' + $(this).text() + '</option>';
                }
            });

            $('.change-exiting-reviewer').html(result);

            $('#add-goals-modal').modal('hide');

            $('#reviewerReplaceSameLevel').show();
            $('#reviewerReplaceSameLevel').removeClass('fade');
            changeExitingReviewer();

            // var selectedReviewersNames = $('#reviewersAccordingAssignee').val();
            // var selectedReviewersIds = $('#selectedReviewIds').val();
            // alert(selectedReviewersNames+' - '+selectedReviewersIds);
            // if(selectedReviewersIds != null && selectedReviewersIds != ''){
            //     var result = '';
            //     var selectedReviewersIds = selectedReviewersIds.split(',');
            //     var selectedReviewersNames = selectedReviewersNames.split(',');
            //     $.each(selectedReviewersIds, function(key, value){
            //         if(value != {{ Auth::id() }}){
            //             result += '<option value="'+value+'">'+selectedReviewersNames[key]+'</option>';
            //         }
            //     });

            //     $('.change-exiting-reviewer').html(result);
            //     $('#reviewerReplaceSameLevel').show();
            //     $('#reviewerReplaceSameLevel').removeClass('fade');
            //     changeExitingReviewer();
            // }
        })

        $('.change-exiting-reviewer').change(function() {
            changeExitingReviewer();
        })

        function changeExitingReviewer() {
            $('#reviewerChangeError').html('');
            var reviewerId = $('.change-exiting-reviewer').val();
            $.ajax({
                type: "POST",
                url: "{{ route('getSameLevelOfReviewer') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'reviewerId': reviewerId,
                },
                success: function(data) {
                    if (data.status == true) {
                        var result = '';
                        $.each(data.result.getSameLevelManagers, function(key, value) {
                            result += '<option value="' + value.id + '">' + value.name + '</option>';
                        });
                        $('.with-new-reviewer').html(result);
                    } else {
                        $('#reviewerChangeError').html(data.message);
                    }
                }
            });
        }

        $('body').on('change', '#department', function() {
            $.ajax({
                type: "POST",
                url: "{{ route('department') }}",
                data: {
                    'id': $('#department').val(),
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    var optionHtml = "";
                    var empSelected = [];
                    $.each(data['emp'], function(i, tempdata) {
                        empSelected.push(tempdata.id);
                        // optionHtml = optionHtml+"<option value="+tempdata.id+" selected>"+tempdata.name+"</option>";
                        optionHtml = optionHtml +
                            "<div class='col-3'><input type='checkbox' name='employees" +
                            tempdata.id + "' id='employees" + tempdata.id + "' value=" +
                            tempdata.id + " class='employee mr-1' checked>" + tempdata.name +
                            "</div>";
                    });

                    $('#select-employees').html(optionHtml);
                    // if (data['rev']) {
                    var reviewer = [];
                    var reviewerId = [];
                    $.each(data['rev'], function(i, val) {
                        reviewer.push(val.name);
                        reviewerId.push(val.id);
                        // $('#reviewer-name').html(data['rev'].name);
                        // $('#reviewer-email').html(data['rev'].email);
                    });
                    $("#sel_reviewer").val(reviewerId.join());
                    $('#selected_reviewer').val(reviewer.join());
                    $('#select-employees').val(employees.join());

                    // $.each($('.reviewer'), function() {

                    //     if($.inArray(parseInt($(this).val()), reviewerId) > -1){
                    //         $(this).attr('checked', true);
                    //     } else {
                    //         $(this).removeAttr('checked');
                    //     }
                    // });
                    changeEmployee1(data['emp']);
                    var rev = {!! json_encode($employees) !!};
                    var optionHtml = "";
                    $.each(rev, function(i, tempdata) {
                        if ($.inArray(tempdata.id, reviewerId) > -1 && !$.inArray(tempdata.id,
                                reviewerId) > -1) {
                            optionHtml = optionHtml +
                                "<div class='col-3'><input type='checkbox' name='reviewer" +
                                tempdata.id + "' id='reviewer" + tempdata.id + "' value=" +
                                tempdata.id + " class='reviewer mr-1' checked>" + tempdata
                                .emp_name + "</div>";
                        } else {
                            optionHtml = optionHtml +
                                "<div class='col-3'><input type='checkbox' name='reviewer" +
                                tempdata.id + "' id='reviewer" + tempdata.id + "' value=" +
                                tempdata.id + " class='reviewer mr-1'>" + tempdata.emp_name +
                                "</div>";
                        }
                    });
                    $('#select-reviewer').html(optionHtml);


                    // $('#select-reviewer').val(reviewer).trigger('change');

                }
            });
        });

        function changeEmployee1(employees) {
            // var employeeSelected = $('#select-employees').val();
            var employeeSelected = [];
            $.each($('.employee'), function() {
                if ($(this).is(':checked')) {
                    employeeSelected.push($(this).val());
                }
            });
            @if (Str::contains(currentLoggedInUserRole(), ['Employee']))
            @else
                // var imgHtml ="";
                // var count = 0;
                var employeeArray = [];
                var employeeIdArray = [];
                $.each(employees, function(i, data) {
                    if ($.inArray(data.id.toString(), employeeSelected) > -1) {
                        employeeArray.push(data.name);
                        employeeIdArray.push(data.id);
                        // if (count < 4) {
                        //     imgHtml = imgHtml+"<a class='avatar'><img src='assets/images/"+data.avatar+"' alt='' class='rounded-circle p-0'></a>";
                        // }
                        // count++;
                    }
                });

                $("#sel_employees").val(employeeIdArray.join());
                $('#selected_employee').val(employeeArray.join());
                $('#group-employee').html(employeeArray.join());
                $('#changeEmployee').css('display', 'none');
                // $('.avatar-group-item').html(imgHtml);
            @endif
        }

        $("#view-form").click(function(e) {
            e.preventDefault();

            console.log("hi")
            let selected_kpi_form_id = $('#selected_kpi_form_id').val();
            console.log("Viewing PMS form of "+selected_kpi_form_id);
        });

        //
        $("#publish-goal").click(function(e) {
            console.log("Publish button clicked");
            $('#publish-goal').attr("disabled", true);

            e.preventDefault();
            var t_selectedEmployeesId = $('.select-employee-dropdown').val();

            //For flow 3, fetch from 'employees' elementname
            if (t_selectedEmployeesId == '') {
                t_selectedEmployeesId = [$('#hidden_selectedEmployees').val()];
                console.log("Fetched selected employees from hidden vars : " + t_selectedEmployeesId);
            } else
                console.log("Selected Employees : " + t_selectedEmployeesId);


            var assignmentPeriod = $('#assignment_period_start').val();
            var year = $('#hidden_calendar_year').val();

            $.ajax({
                url: "{{ route('isKPIAlreadyAssignedForGivenAssignmentPeriod') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    selectedEmployeeId: t_selectedEmployeesId,
                    assignmentPeriod: assignmentPeriod,
                    year: year
                },
                success: function(data) {


                    if (data) {
                        $('#edit-employee-error-message').html('');
                        console.log("[ isKPIAlreadyAssignedForGivenAssignmentPeriod ] : " + data);

                        //If KPI's already assigned to the selected emps, then show their names
                        if (data.status == true) {
                            console.log("KPI already assigned...! ");

                            if ($('#flowCheck').val() == '3') {
                                console.log("PMS Flow 3 : Show Error message");

                                Swal.fire(
                                    '<b>Error</b>',
                                    '<span>KPI Form has already been assigned for the selected Assignment Period.<br/> Please check your <b>Current/Completed</b> tabs in PMS dashboard</span>',
                                    'warning'
                                );

                            } else {
                                $('#edit-employee-error-message').append("<b><u>" + data.message +
                                    "</u></b><br/>");
                                $('#edit-employee-error-message').append("<ul>");

                                $.each(data.result, function(i, value) {
                                    $('#edit-employee-error-message').append("<li>" + value +
                                        "</li>");
                                });

                                $('#edit-employee-error-message').append("</ul>");
                                $('#edit-employee-error-message').append(
                                    "<b>Please remove these employees before proceeding.</b>");

                                //Open the Employee Edit Modal
                                $("#add-goals-modal").modal('hide');
                                $('#employeeSelectionModal').show();
                                $('#employeeSelectionModal').removeClass('fade');
                            }

                        } else
                        if (data.status == false || data.status ==
                            'error'
                        ) // if no KPIs already assigned to the selected Emps for the given assignment period, then no issues.
                        {
                            $('#edit-employee-error-message').append('');
                            console.log("Publishing the form.......");
                            publishForm();
                        }
                    }

                },
                error: function(error) {
                    console.log('something went wrong');
                }
            });

            //Enable Publish button after a small delay to prevent double clicks
            setTimeout(function() {
                $('#publish-goal').removeAttr("disabled");
                console.log("timeout completed");
            }, 2000);

        });

        function publishForm() {
            $('.loader').show();
            // if ($('#kpitable_id').val()) {
            $.ajax({
                type: "POST",
                url: "{{ url('publishKPIForm') }}",
                data: $('#goalForm').serialize(),
                success: function(data) {
                    $('.loader').hide();
                    if (data.status == true) {
                        $("#kpiTableForm :input").prop("disabled", true);
                        $(".table-btn").prop('disabled', true);

                        @if (Str::contains(currentLoggedInUserRole(), ['Employee']))
                            $('#modalBody').html("Goals published. Email Sent to your Manager");
                            $('#notificationModal').show();
                            $('#notificationModal').removeClass('fade');
                        @else
                            $('#modalBody').html("Goals published. Email Sent to your Employees");
                            $('#notificationModal').show();
                            $('#notificationModal').removeClass('fade');
                        @endif

                        $("kpitable_id").val(data.table_id);
                    } else {
                        Swal.fire('Wrong!', data.message, 'error');
                    }
                }
            });
        }
    </script>
    <script>
        if ($("#changeReviewForm").length > 0) {
            $('#changeReviewForm').validate({
                rules: {
                    oldReviewerName: {
                        required: true
                    },
                    newReviewerName: {
                        required: true
                    },
                },
                messages: {
                    oldReviewerName: {
                        required: "Existing Reviewer Name is required",
                    },
                    newReviewerName: {
                        required: "New Reviewer Name is required",
                    },
                }
            });
        }

        $("#changeReviewForm").submit(function(e) {

            // var reviewersName =$("#reviewersAccordingAssignee").val();
            // var reviewersIds =$("#selectedReviewIds").val();

            e.preventDefault();
            var oldReviewerId = $('.change-exiting-reviewer').val();
            var newReviewerId = $('.with-new-reviewer').val();
            console.log(oldReviewerId);
            console.log(newReviewerId);

            var existingValues = $(".select-multiple-reviewer").val();
            console.log(existingValues);

            var result = existingValues.filter(function(elem) {
                return elem != oldReviewerId;
            });

            result.push(newReviewerId);

            $('.select-multiple-reviewer').val(null).trigger('change');
            $(".select-multiple-reviewer").val(result);
            $('.select-multiple-reviewer').trigger('change.select2');


            $('#reviewerReplaceSameLevel').hide();
            $('#reviewerReplaceSameLevel').addClass('fade');

            $('#add-goals-modal').modal('show');
            checkReviewersExistOrNot();
        })
    </script>
@endsection
