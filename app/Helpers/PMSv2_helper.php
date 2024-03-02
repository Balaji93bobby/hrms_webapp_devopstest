<?php

use App\Models\User;
use App\Models\VmtEmployee;
use App\Models\VmtEmployeeOfficeDetails;
use App\Models\VmtPMS_KPIFormAssignedModel;
use App\Models\VmtPMS_KPIFormReviewsModel;
use App\Models\VmtPMSRating;
use App\Models\VmtOrgTimePeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;

// Get User Name by User ID
function getUserDetailsById($userId)
{
    $userDetails = User::findorfail($userId);
    if (!empty($userDetails)) {
        return $userDetails->name;
    }
    return '';
}

// Get KPI Form Assignees's Review Data of Particular Assignee
function getReviewKpiFormDetails($kpiAssignedId, $assigneeId)
{
    $reviewData = VmtPMS_KPIFormReviewsModel::where('vmt_pms_kpiform_assigned_id', $kpiAssignedId)->where('assignee_id', $assigneeId)->first();
    if (!empty($reviewData)) {
        return $reviewData;
    }
    return null;
}

// Get Necessary Details like currentLoggedUserRoleOnKpiForm, ReviewersIds, AssigneesIds
function getPmsKpiAssigneeDetails($pmsKpiAssigneeId)
{
    $pmsKpiAssigneeDetails = VmtPMS_KPIFormAssignedModel::findorfail($pmsKpiAssigneeId);
    $currentLoggedUserRole = '';
    $reviewersIds = isset($pmsKpiAssigneeDetails->reviewer_id) ? explode(',', $pmsKpiAssigneeDetails->reviewer_id) : '';
    $assigneesIds = isset($pmsKpiAssigneeDetails->assignee_id) ? explode(',', $pmsKpiAssigneeDetails->assignee_id) : '';
    if (in_array(Auth::id(), $reviewersIds)) {
        $currentLoggedUserRole = 'reviewer';
    }
    if (in_array(Auth::id(), $assigneesIds)) {
        $currentLoggedUserRole = 'assignee';
    }
    // if(Auth::id() == $pmsKpiAssigneeDetails->assigner_id){
    //     $currentLoggedUserRole = 'assigner';
    // }
    $result = [
        'currentLoggedUserRole' => $currentLoggedUserRole,
        'reviewersIds' => $reviewersIds,
        'assigneesIds' => $assigneesIds,
    ];
    return $result;
}

// check current logged user is Reviewer or Not and Add reviewd or not yet reviewed
function checkCurrentLoggedUserReviewerOrNot($reviewersIds, $currentLoggedUserRole, $kpiAssigneeReviewDetails)
{
    try {
        //dd($reviewersIds);
        $result = '';
        $decodedReviewSubmitted = isset($kpiAssigneeReviewDetails->is_reviewer_submitted) ? json_decode($kpiAssigneeReviewDetails->is_reviewer_submitted, true) : '';
        $decodedReviewAccepted = isset($kpiAssigneeReviewDetails->is_reviewer_accepted) ? json_decode($kpiAssigneeReviewDetails->is_reviewer_accepted, true) : '';

        foreach ($reviewersIds as $singleReviewerId) {
            //Check if reviewer accepted the form or not
            if ($decodedReviewAccepted[$singleReviewerId] == null) {
                $result .= 'Not yet Accepted<br>';
            } elseif ($decodedReviewAccepted[$singleReviewerId] == '0') {
                $result .= 'Rejected<br>';
            } elseif ($decodedReviewAccepted[$singleReviewerId] == '1') //accepted
            {

                //Check if the Reviewer submitted this form or not
                if ($decodedReviewSubmitted[$singleReviewerId] == '1') {
                    $result .= 'Reviewed<br>';
                } else {
                    $result .= 'Not yet Reviewed<br>';
                }
            }
        }

        return $result;
    } catch (Exception $e) {
        Log::info('check Current Logged User Reviewer Or Not helper error: ' . $e->getMessage());
        return '';
    }
}

function calculateAppraisalReviewRating_BasedOnHR()
{
}

/*
    To calculate the overall score for the given user based on
    all reviewed form.

    TODO : Need to do calculation based on the selected year(calendar / financial)
           Logic : Find the frequency and based on that, get all the forms. And then calculate.
*/
// function calculateOverallReviewRating($user_id){

//     $total_reviewedform_count = 0; // total no.of reviewed forms (is_reviewer_submitted)
//     $totalscore_reviewedform = 0; // total of all reviewer score

//     //Get all the assigned form's id for the given user_id
//     $FormIDs_assignedforms = VmtPMS_KPIFormAssignedModel::where('assignee_id',$user_id)->get('id');


//     //Get all the reviewform id for the given assignedform id's
//     $query_reviewedForms_user =  VmtPMS_KPIFormReviewsModel::whereIn('vmt_pms_kpiform_assigned_id',$FormIDs_assignedforms)->get();
//     //dd($query_reviewedForms_user->toArray());

//     if($query_reviewedForms_user->count() > 0)
//     {

//         //Get all the forms that are reviewed
//         foreach($query_reviewedForms_user as $singleReviewedForm){

//             //Check whether the form is reviewed
//             $arrayvalues_is_reviewer_submitted = array_values( json_decode($singleReviewedForm->is_reviewer_submitted, true));

//             if(in_array('0',$arrayvalues_is_reviewer_submitted) || in_array(null,$arrayvalues_is_reviewer_submitted))
//             {
//                 //when form is not reviewed
//             }
//             else
//             {
//                 //when form is reviewed
//                 $total_reviewedform_count++;

//                 $score_reviewedform =  calculateReviewRatings($singleReviewedForm->vmt_pms_kpiform_assigned_id, $user_id)["score"];
//                 $totalscore_reviewedform =  $totalscore_reviewedform + intval( str_replace('%', '', $score_reviewedform));
//             }

//         }

//         //If no forms for this user, then put zero
//         if($total_reviewedform_count != 0)
//             $overallReviewRating = $totalscore_reviewedform/$total_reviewedform_count;
//         else
//             $overallReviewRating = 0;

//         return round($overallReviewRating);
//     }
//     else
//     {
//         //dd("No Review forms the given User ID : ".$user_id);
//         return null;
//     }


//     //dd("--end--");
// }

// get Average rating of particular ReviewedForm and for review given by First Reveiwer for that Kpi Form
function calculateReviewRatings($assigneeReviewTableId, $assigneeId)
{
    try {
        $totalRatingScore = 0;
        $performanceRating = 0;
        $rank = 0;
        $action = 0;


        $assigneeReviewDetails = VmtPMS_KPIFormAssignedModel::where('id', $assigneeReviewTableId)->first();

        if (!empty($assigneeReviewDetails)) {
            $decodedReviewsId = explode(',', $assigneeReviewDetails->reviewer_id);

            $kpi_review_record = VmtPMS_KPIFormReviewsModel::where('assignee_id', $assigneeId)->where('vmt_pms_kpiform_assigned_id', $assigneeReviewTableId)->first();

            if (!empty($kpi_review_record)) {
                $firstReviewerRating = [];

                if (json_decode($kpi_review_record->reviewer_kpi_percentage, true) != '' &&  isset(json_decode($kpi_review_record->reviewer_kpi_percentage, true)[$decodedReviewsId[0]])) {
                    //Get the 'reviewer_kpi_percentage' for the 1st reviewer as Associative array
                    $firstReviewerRating = json_decode($kpi_review_record->reviewer_kpi_percentage, true)[$decodedReviewsId[0]];
                }

                // calculate Rating Based on Table Dynamic Data
                if (count($firstReviewerRating) > 0) {
                    $totalRatingScore = array_sum($firstReviewerRating);

                    $pmsConfigRatingDetails = VmtPMSRating::orderBy('sort_order', 'DESC')->get();

                    /* Use this line to test rating    */
                    //$totalRatingScore=101;
                    if (count($pmsConfigRatingDetails) > 0) {
                        foreach ($pmsConfigRatingDetails as $ratings) {
                            $rangeCheck = explode('-', $ratings->score_range);

                            if ($totalRatingScore >= $rangeCheck[0] && $totalRatingScore <= $rangeCheck[1]) {
                                $rank = $ratings->ranking;
                                $performanceRating = $ratings->performance_rating;
                                $action = $ratings->action;
                                break;
                            } elseif ($totalRatingScore >= 100) {
                                $rank = $ratings->ranking;
                                $performanceRating = $ratings->performance_rating;
                                $action = $ratings->action;
                                break;
                            }
                        }
                    }
                }
            }
        }

        $response = [
            'rank' => $rank,
            'score' => $totalRatingScore . '%',
            'performance_rating' => $performanceRating,
            'action' => $action
        ];

        return $response;
    } catch (Exception $e) {
        Log::info('calculation average rating helper error: ' . $e->getMessage());

        $response = [
            'rank' => 0,
            'score' => '0%',
            'performance_rating' => 0,
            'action' => 0,
            'error' => $e
        ];
    }
}

function calculateOverallReviewRating($assigneeId)
{
    $totalRatingScore = 0;
    $performanceRating = 0;
    $rank = 0;
    $action = 0;
    $over_all_score = 0;
    $org_time_period_id = VmtOrgTimePeriod::where('status', 0)->first()->id;
    $all_frequency_review_ratings = VmtPMS_KPIFormAssignedModel::join('vmt_pms_kpiform_reviews', 'vmt_pms_kpiform_reviews.vmt_pms_kpiform_assigned_id', '=', 'vmt_pms_kpiform_assigned.id')
        ->where('vmt_pms_kpiform_assigned.assignee_id', $assigneeId)->where('vmt_pms_kpiform_assigned.vmt_org_time_period_id', $org_time_period_id)
        ->where('vmt_pms_kpiform_reviews.is_reviewer_submitted', 'like', '%"1"}')->get();

    $review_count = count($all_frequency_review_ratings);
    for ($i = 0; $i <count($all_frequency_review_ratings); $i++) {
        $over_all_score =   $over_all_score + substr(calculateReviewRatings($all_frequency_review_ratings[$i]->vmt_pms_kpiform_assigned_id, $assigneeId)['score'], 0, -1);
    }

    $annual_avarge_of_review_rating =  $i != 0 ? ceil($over_all_score / $i) : 0;



    $pmsConfigRatingDetails = VmtPMSRating::orderBy('sort_order', 'DESC')->get();

    /* Use this line to test rating    */
    //$totalRatingScore=101;
    if (count($pmsConfigRatingDetails) > 0) {
        foreach ($pmsConfigRatingDetails as $ratings) {
            $rangeCheck = explode('-', $ratings->score_range);

            if ($annual_avarge_of_review_rating >= $rangeCheck[0] &&    $annual_avarge_of_review_rating <= $rangeCheck[1]) {
                $rank = $ratings->ranking;
                $performanceRating = $ratings->performance_rating;
                $action = $ratings->action;
                break;
            } elseif ($annual_avarge_of_review_rating >= 100) {
                $rank = $ratings->ranking;
                $performanceRating = $ratings->performance_rating;
                $action = $ratings->action;
                break;
            }
        }
    }
    $response = [
        'rank' => $rank,
        'score' =>   $annual_avarge_of_review_rating . '%',
        'performance_rating' => $performanceRating,
        'action' => $action
    ];

    return $response;
}

// function for get View, Review and Self Review Text Change of Kpi Pms Form
function checkViewReviewText($loggedUserRole, $kpiFormReviewDetails)
{
    // dD("S");
    try {
        $result = '';
        // $arrayReviewerAccepted = isset($kpiFormReviewDetails->is_assignee_accepted) ? json_decode($kpiFormReviewDetails->is_assignee_accepted,true) : [];
        $isAllReviewersAcceptedData = [];
        $isAllReviewersAcceptedOrNot = false;
        if (isset($kpiFormReviewDetails->is_reviewer_accepted)) {
            $isAllReviewersAcceptedData = json_decode($kpiFormReviewDetails->is_reviewer_accepted, true);
            if (!in_array('0', $isAllReviewersAcceptedData)) {
                $isAllReviewersAcceptedOrNot = true;
            }
        }

        if ($loggedUserRole == 'assignee') {
            if ($isAllReviewersAcceptedOrNot == false) {
                $result = 'Edit';
            } else {
                if (isset($kpiFormReviewDetails->is_assignee_submitted) && $kpiFormReviewDetails->is_assignee_submitted == '1') {
                    $result = 'View';
                } else {
                    $result = 'Self-Review';
                }
            }
        } elseif ($loggedUserRole == 'reviewer') {

            if (isset($kpiFormReviewDetails) && $kpiFormReviewDetails->is_assignee_accepted == '0') {
                $result = 'Edit';
            } else {
                $decodedReview = isset($kpiFormReviewDetails->is_reviewer_submitted) ? json_decode($kpiFormReviewDetails->is_reviewer_submitted, true) : [];
                if (isset($decodedReview[Auth::id()]) && $decodedReview[Auth::id()] == '1') {
                    $result = 'View';
                } else {
                    $result = 'Review';
                }
            }
        } else {
            $result = 'Review';
            if ($isAllReviewersAcceptedOrNot == false) {
                $result = 'Edit';
            }
        }
        return $result;
    } catch (Exception $e) {
        Log::info('get View, Review and Self Review Text Change of Kpi Pms Form helper error: ' . $e->getMessage());
        return 'Review';
    }
}

function getEmployeeManager($selectedEmployeeId)
{
    // dD($selectedEmployeeId);
    $currentEmpCode = VmtEmployeeOfficeDetails::whereIn('user_id', $selectedEmployeeId)
        ->select('l1_manager_code')
        ->groupBy('l1_manager_code')
        ->pluck('l1_manager_code');

    $users = VmtEmployee::leftJoin('users', 'users.id', '=', 'vmt_employee_details.userid')
        ->select(
            'users.name',
            'users.id as id',
            'users.user_code as code',
        )
        ->orderBy('users.name', 'ASC')
        ->whereIn('users.user_code', $currentEmpCode);
    return $users;
}


function isFormReviewCompleted($data_VmtPMS_KPIFormReviewsModel)
{

    $output = $data_VmtPMS_KPIFormReviewsModel->is_reviewer_submitted;

    $array_reviewers_submitted_values = array_values(json_decode($output, true));

    // dd($array_reviewers_submitted_values);

    //Check if reviewer_submitted value has '0' or null value.
    if (in_array(null, $array_reviewers_submitted_values, true) || in_array("0", $array_reviewers_submitted_values, true)) {
        return false;
    } else {
        return true;
    }
}

// PMS V2 API Responses
//function showing success response....
function sendResponse($result, $message)
{
    $response = [
        'status'  => true,
        'data'    => $result,
        'message' => $message,
    ];
    return response()->json($response);
}

//function showing error showing....
function sendError($errorMessages = [], $code = false)
{
    $response = [
        'status' => false,
        'message' => $errorMessages,
    ];
    return response()->json($response);
}
