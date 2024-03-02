<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Api\HRMSBaseAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\VmtEmployee;
use App\Models\VmtEmployeeOfficeDetails;
use App\Models\VmtPMS_KPIFormAssignedModel;
use App\Models\VmtPMS_KPIFormDetailsModel;
use App\Models\VmtPMS_KPIFormReviewsModel;
use App\Models\VmtPMS_KPIFormModel;
use App\Mail\NotifyPMSManager;
use App\Models\VmtPMSRating;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ViewNotification;
use App\Services\VmtPMSModuleService_v3;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class VmtAPIPMSModuleController extends HRMSBaseAPIController
{

    public function showEmployeeApraisalReviewList(Request $request)
    {

        $pmsKpiAssigneeDetails = VmtPMS_KPIFormAssignedModel::with('getPmsKpiFormReviews')
            ->WhereRaw("find_in_set(" . auth()->user()->id . ", reviewer_id)")
            ->orWhereRaw("find_in_set(" . auth()->user()->id . ", assignee_id)")
            ->orWhere('assigner_id', auth()->user()->id)
            ->orderBy('id', 'DESC')->get();

        return response()->json([
            'status' => true,
            'message' => '',
            'data'   => $pmsKpiAssigneeDetails
        ]);
    }

    public function getAssigneeReviews(Request $request)
    {
        // Flow 1 HR creates Form and Assignee
        $kpiFormAssignedDetails = VmtPMS_KPIFormAssignedModel::where('id', $request->assignedFormid)
            ->with('getPmsKpiFormReviews')
            ->with('getPmsKpiFormColumnDetails.getPmsKpiFormDetails')
            ->first();


        $config = VmtPMS_KPIFormModel::findorfail($kpiFormAssignedDetails->vmt_pms_kpiform_id);
        $show['dimension'] = 'true';
        $show['kpi'] = 'true';
        $show['operational'] = 'true';
        $show['measure'] = 'true';
        $show['frequency'] = 'true';
        $show['target'] = 'true';
        $show['stretchTarget'] = 'true';
        $show['source'] = 'true';
        $show['kpiWeightage'] = 'true';
        $show['appraiser'] = false;
        $show['manager'] = false;

        if ($config) {
            $config->header = json_decode($config->column_header, true);
            $show['dimension'] = $config->available_columns && in_array('dimension', explode(',', $config->available_columns)) ? 'true' : 'false';
            $show['kpi'] = $config->available_columns && in_array('kpi', explode(',', $config->available_columns)) ? 'true' : 'false';
            $show['operational'] = $config->available_columns && in_array('operational', explode(',', $config->available_columns)) ? 'true' : 'false';
            $show['measure'] = $config->available_columns && in_array('measure', explode(',', $config->available_columns)) ? 'true' : 'false';
            $show['frequency'] = $config->available_columns && in_array('frequency', explode(',', $config->available_columns)) ? 'true' : 'false';
            $show['target'] = $config->available_columns && in_array('target', explode(',', $config->available_columns)) ? 'true' : 'false';
            $show['stretchTarget'] = $config->available_columns && in_array('stretchTarget', explode(',', $config->available_columns)) ? 'true' : 'false';
            $show['source'] = $config->available_columns && in_array('source', explode(',', $config->available_columns)) ? 'true' : 'false';
            $show['kpiWeightage'] = $config->available_columns && in_array('kpiWeightage', explode(',', $config->available_columns)) ? 'true' : 'false';
        }

        $assignersName = User::whereRaw("id IN($kpiFormAssignedDetails->reviewer_id)")->pluck('name')->toArray();
        if ($assignersName) {
            $assignersName = implode(',', $assignersName);
        }
        //dd($assignersName);

        //\DB::enableQueryLog();
        $review  =  VmtPMS_KPIFormAssignedModel::join('vmt_pms_kpiform_details', 'vmt_pms_kpiform_details.vmt_pms_kpiform_id', '=', 'vmt_pms_kpiform_assigned.vmt_pms_kpiform_id')
            ->join('vmt_pms_kpiform_reviews', 'vmt_pms_kpiform_reviews.vmt_pms_kpiform_assigned_id', '=', 'vmt_pms_kpiform_assigned.id')
            ->where('vmt_pms_kpiform_reviews.assignee_id', '=', auth::user()->id)
            ->get();

        //\Log::error(\DB::getQueryLog());

        foreach ($review as $ff) {
            $assignersName = User::whereRaw("id IN($ff->reviewer_id)")->pluck('name')->toArray();
            if ($assignersName) {
                $assignersName = implode(',', $assignersName);
            }
            if ($ff->reviewer_kpi_review != null) {
                $reviewArray = (json_decode($ff->reviewer_kpi_review, true)) ? (json_decode($ff->reviewer_kpi_review, true)) : [];
                $percentArray = (json_decode($ff->reviewer_kpi_percentage, true)) ? (json_decode($ff->reviewer_kpi_percentage, true)) : [];
                $commentArray = (json_decode($ff->reviewer_kpi_comments, true)) ? (json_decode($ff->reviewer_kpi_comments, true)) : [];
            }
            $kpiRows      =  VmtPMS_KPIFormDetailsModel::where('vmt_pms_kpiform_id', $ff->vmt_pms_kpiform_id)->get();
            $reviewCompleted = false;
            $kpiRowsId = VmtPMS_KPIFormDetailsModel::where('vmt_pms_kpiform_id', $ff->vmt_pms_kpiform_id)->pluck('id')->toArray();
        }

        if (count($review) > 0) {
            $kpiRowsId = implode(',', $kpiRowsId);
        }


        // Get assigned Details
        $assignedGoals  = VmtPMS_KPIFormAssignedModel::where('vmt_pms_kpiform_assigned.id', $request->assignedFormid)->where('vmt_pms_kpiform_reviews.assignee_id', $request->assigneeId)->join('vmt_pms_kpiform_reviews', 'vmt_pms_kpiform_reviews.vmt_pms_kpiform_assigned_id', '=', 'vmt_pms_kpiform_assigned.id')->first();

        // rating details
        $ratingDetail['performance'] = '-';
        $ratingDetail['ranking'] = '-';
        $ratingDetail['action'] = '-';
        $ratingDetail['rating'] = '-';
        if ($assignedGoals != '') {

            // Calculation and check All Reviewers Rating
            // dD($assignedGoals->reviewer_kpi_percentage);
            $percentageVal = 0;
            $howManyPercCount = 0;
            $allReviewerPercentages = isset($assignedGoals->reviewer_kpi_percentage) ? json_decode($assignedGoals->reviewer_kpi_percentage, true) : [];
            if (count($allReviewerPercentages) > 0) {
                foreach ($allReviewerPercentages as $percentage) {
                    $arraySumPercentage = array_sum($percentage);
                    $percentageVal += $arraySumPercentage;
                    $howManyPercCount += count($percentage);
                }
            }
            if ($howManyPercCount > 0) {
                $ratingDetail['rating'] = $percentageVal / $howManyPercCount;
                if ($ratingDetail['rating'] < 60) {
                    $ratingDetail['performance'] = "Needs Action";
                    $ratingDetail['ranking'] = 1;
                    $ratingDetail['action'] = 'Exit';
                } elseif ($ratingDetail['rating'] >= 60 && $ratingDetail['rating'] < 70) {
                    $ratingDetail['performance'] = "Below Expectations";
                    $ratingDetail['ranking'] = 2;
                    $ratingDetail['action'] = 'PIP';
                } elseif ($ratingDetail['rating'] >= 70 && $ratingDetail['rating'] < 80) {
                    $ratingDetail['performance'] = "Meet Expectations";
                    $ratingDetail['ranking'] = 3;
                    $ratingDetail['action'] = '10%';
                } elseif ($ratingDetail['rating'] >= 80 && $ratingDetail['rating'] < 90) {
                    $ratingDetail['performance'] = "Exceeds Expectations";
                    $ratingDetail['ranking'] = 4;
                    $ratingDetail['action'] = '15%';
                } elseif ($ratingDetail['rating'] >= 90) {
                    $ratingDetail['performance'] = "Exceptionally Exceeds Expectations";
                    $ratingDetail['ranking'] = 5;
                    $ratingDetail['action'] = '20%';
                } else {
                    $ratingDetail['performance'] = "error";
                    $ratingDetail['ranking'] = 000;
                    $ratingDetail['action'] = '0000%';
                }
            }
        }

        $assignedUserDetails = User::where('id', auth::user()->id)->with('getEmployeeDetails', 'getEmployeeOfficeDetails')->first();
        $assignedEmployee_Userdata = User::where('id',  auth::user()->id)->first();
        $assignedEmployeeOfficeDetails = VmtEmployeeOfficeDetails::where('user_id', auth::user()->id)->first();
        $empSelected = true;
        $employeeData = VmtEmployee::where('userid', auth::user()->id)->first();

        if ($assignedGoals != '') {
            $reviewersId = explode(',', $assignedGoals->reviewer_id);
        } else {
            $reviewersId = [];
        }

        // check if all reviewers has submitted the review or not
        $isAllReviewersSubmittedData = [];
        $isAllReviewersSubmittedOrNot = false;
        if (isset($assignedGoals->is_reviewer_submitted)) {
            $isAllReviewersSubmittedData = json_decode($assignedGoals->is_reviewer_submitted, true);
            if (!in_array('0', $isAllReviewersSubmittedData) && !in_array(null, $isAllReviewersSubmittedData)) {
                $isAllReviewersSubmittedOrNot = true;
            }
        }

        $responseData = array(
            'review'  => $review,
            'assignedUserDetails'  => $assignedUserDetails,
            'assignedGoals'  => $assignedGoals,
            'empSelected'  => $empSelected,
            'assignersName'  => $assignersName,
            'config'  => $config,
            'show'  => $show,
            'ratingDetail'  => $ratingDetail,
            'reviewersId'  => $reviewersId,
            'isAllReviewersSubmittedOrNot' => $isAllReviewersSubmittedOrNot,
            'isAllReviewersSubmittedData'  => $isAllReviewersSubmittedData
        );

        return response()->json([
            'status' => true,
            'message' => '',
            'data'   => $responseData
        ]);
    }



    /*
        Save Assignees Review for KPI Form Assigned

            DB Table : vmt_pms_kpiform_assigned (check form assigned ID)
            DB Table : vmt_pms_kpiform_reviews (add reviews for particular assignee)
            Input params : assignedFormId, assigneeId

            formSubmitType == 0 ? "Save Review" : "Publish Review"

        Logic : Using assignedFormId & assigneeId, we will check review details for that assignee and update

    */
    public function saveAssigneeReviews(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'assignedFormId' => 'required',
            //'assigneeId' => 'required',
            'assignee_kpi_review' => 'required',
            'assignee_kpi_percentage' => 'required',
            'assignee_kpi_comments' => 'required',
            'formSubmitType' => 'required',
        ], [
            'assignedFormId.required' => 'Assigned Form Id is Required',
            //'assigneeId.required' => 'Assignee Id is Required',
            'assignee_kpi_review.required' => 'Assignee KPI Review is Required',
            'assignee_kpi_percentage.required' => 'Assignee KPI Percentage is Required',
            'assignee_kpi_comments.required' => 'Assignee KPI Comment is Required',
            'formSubmitType.required' => 'Form Submit Type is Required, 0 & 1',
        ]);

        if ($validation->fails()) {
            return sendError($validation->errors()->first());
        }

        try {
            // check logged user id and assigneeId
            // if(Auth::id() != $request->assigneeId){
            //     return sendError('Assignee Id is not your Id');
            // }

            // check review available or not
            $assignedReviewCheck = VmtPMS_KPIFormReviewsModel::where('vmt_pms_kpiform_assigned_id', $request->assignedFormId)->where('assignee_id', Auth::id())->with('getPmsKpiFormAssigned')->first();
            if (empty($assignedReviewCheck)) {
                return sendError('Review Data Not Found');
            }

            // check assignee has rejected kpi form or not
            if ($assignedReviewCheck->is_assignee_accepted == '0') {
                return sendError('You have Rejected KPI Form!');
            }

            // check assignee has Accepted kpi form or not
            if ($assignedReviewCheck->is_assignee_accepted == null) {
                return sendError('You have Not Accepted KPI Form Yet!');
            }

            // check assignee has Already submitted or not kpi form or not
            if ($assignedReviewCheck->is_assignee_submitted == '1') {
                return sendError('You have Already This Submitted KPI Form!');
            }

            $assignedReviewCheck->assignee_kpi_review = $request->assignee_kpi_review;
            $assignedReviewCheck->assignee_kpi_percentage = $request->assignee_kpi_percentage;
            $assignedReviewCheck->assignee_kpi_comments = $request->assignee_kpi_comments;

            if ($request->formSubmitType == 0) {
                $assignedReviewCheck->is_assignee_submitted =  '0';
                $assignedReviewCheck->update();
                return response()->json(['status' => true, 'message' => 'Saved as draft']);
            } else {
                $assignedReviewCheck->is_assignee_submitted =  '1';
                $assignedReviewCheck->update();

                $kpiFormAssignedReviewers = [];
                $kpiFormAssignedReviewersOfficialMails = [];
                if (isset($assignedReviewCheck->getPmsKpiFormAssigned)) {
                    $kpiFormAssignedReviewers = explode(',', $assignedReviewCheck->getPmsKpiFormAssigned->reviewer_id);
                }

                $assigneeDetails = User::findorfail(Auth::id());

                // check Multiple Reviewers
                if (count($kpiFormAssignedReviewers) > 0) {
                    foreach ($kpiFormAssignedReviewers as $reviewer) {
                        $userEmployeeDetails = User::where('id', $reviewer)->with('getEmployeeOfficeDetails')->first();
                        if (isset($userEmployeeDetails->getEmployeeOfficeDetails) && !empty($userEmployeeDetails->getEmployeeOfficeDetails->officical_mail)) {

                            // office details of assignee employee
                            $currentUser_empDetails = VmtEmployeeOfficeDetails::where('user_id', $assigneeDetails->id)->first();
                            array_push($kpiFormAssignedReviewersOfficialMails, $userEmployeeDetails->getEmployeeOfficeDetails->officical_mail);

                            // Send mail to All Reviewers
                            // \Mail::to($userEmployeeDetails->getEmployeeOfficeDetails->officical_mail)->send(new NotifyPMSManager($assigneeDetails->name, $currentUser_empDetails->designation, $userEmployeeDetails->name,$assignedReviewCheck->year ));
                            // $message = "Employee has submitted KPI Assessment.  ";
                            // Send notification to All Revie
                            //    Notification::send($assigneeDetails ,new ViewNotification($message.$assigneeDetails->name));
                        }
                    }
                }
                // all reviewers office mails
                $kpiFormAssignedReviewersOfficialMails = implode(',', $kpiFormAssignedReviewersOfficialMails);
                if (!empty($kpiFormAssignedReviewersOfficialMails)) {
                    return response()->json(['status' => true, 'message' => "Published Review successfully.Sent mail to manager " . $kpiFormAssignedReviewersOfficialMails]);
                }
                return response()->json(['status' => true, 'message' => 'Published Review successfully']);
            }
        } catch (Exception $e) {
            Log::info('saveAssigneeReviews API Error: ' . $e->getMessage());
            return sendError($e->getMessage());
        }
    }

    /*
        Get all the KPI forms assigned for the given user.

            DB Table : vmt_pms_kpiform_assigned
            Input params : assignee_id

        Logic : Using assignee_id, we will search the assignee_id, reviewer_id

            is_manager_submitted
            (1 => Submitted else Not Submitted)
            is_manager_accepted
            (1 => Accpted, 0=> Rejected, else Not Viewed Yet)
        &&
            is_employee_submitted
            (1 => Submitted else Not Submitted)
            is_employee_accepted
            (1 => Accpted, 0=> Rejected, else Not Viewed Yet)
    */
    public function getAssigneeKPIForms(Request $request)
    {
        // $validation = Validator::make($request->all(), [
        //     'assignee_id' => 'required',
        // ],[
        //     'assignee_id.required' => 'Assignee Id is Required',
        // ]);

        // if ($validation->fails()) {
        //     return sendError($validation->errors()->first());
        // }
        $userId  = auth::user()->id;
        //dd($userId);
        // if($request->assignee_id != $userId){
        //     return sendError('Assignee Id is not matched');
        // }

        $assigneeDetails = User::where('id', $userId)->first();

        //dd($assigneeDetails);

        // check user id in Assignee, Assigner and Reviewer
        $pmsKpiAssigneeDetails = VmtPMS_KPIFormAssignedModel::where("assignee_id", $userId)
            ->orderBy('id', 'DESC')
            ->get();

        //dd($pmsKpiAssigneeDetails);
        $result = [];

        // get necessary details for display in V2 dashboard of assignees data
        foreach ($pmsKpiAssigneeDetails as $key => $kpiAssignee) {
            $Kpi_form_name = VmtPMS_KPIFormModel::where('id', $kpiAssignee->vmt_pms_kpiform_id)->first();
            $arrayReviewers = explode(',', $kpiAssignee->reviewer_id);

            $result[$key]['vmt_pms_kpiform_assigned_id'] = $kpiAssignee->id;
            $result[$key]['vmt_pms_kpiform_assigned_form_id'] = (int)$kpiAssignee->vmt_pms_kpiform_id;
            $result[$key]['assignment_period'] = $kpiAssignee->assignment_period;
            $result[$key]['form_name'] = $Kpi_form_name->form_name;

            $result[$key]['employee_name'] = $assigneeDetails->name;
            $result[$key]['employee_emp_id'] = isset($assigneeDetails->getEmployeeDetails) ? (string)$assigneeDetails->user_code : '';
            $isAssigneeAccepted = '';
            $isAssigneeSubmitted = '';
            $rating = '';
            if (isset($kpiAssignee->getPmsKpiFormReviews)) {
                foreach ($kpiAssignee->getPmsKpiFormReviews as $reviewData) {

                    if ($reviewData->assignee_id == $userId) {
                        $isAssigneeAccepted = (int)$reviewData->is_assignee_accepted ?? 0;
                        $isAssigneeSubmitted = (int)$reviewData->is_assignee_submitted ?? 0;

                        $arrayIsReviewerSubmitted = json_decode($reviewData->is_reviewer_submitted, true);
                        $arrayIsReviewerAccepted = json_decode($reviewData->is_reviewer_accepted, true);
                        $i = 0;
                        foreach ($arrayIsReviewerSubmitted as $reviewerId => $isSubmittedStatus) {
                            $result[$key]['manager'][$i]['is_manager_submitted'] = (int)$isSubmittedStatus;
                            $result[$key]['manager'][$i]['is_manager_accepted'] = isset($arrayIsReviewerAccepted[$reviewerId]) ? (int)$arrayIsReviewerAccepted[$reviewerId] : '';
                            $i++;
                        }
                    }

                    // $rating = calculateOverallReviewRatings($kpiAssignee->id, $userId);
                }
            }

            $result[$key]['is_employee_submitted'] = isEmpty($isAssigneeSubmitted) ? 0 : $isAssigneeSubmitted;
            $result[$key]['is_employee_accepted'] = isEmpty($isAssigneeAccepted) ? 0 : $isAssigneeAccepted;

            $result[$key]['rating'] = (int)$rating;
            $result[$key]['completion_status'] = 55; //Hard-coded for now.Need to write logic
            foreach ($arrayReviewers as $reviewerKey => $reviewer) {
                $reviewerDetails = User::where('id', $reviewer)->with('getEmployeeDetails')->first();
                $result[$key]['manager'][$reviewerKey]['manager_id'] = $reviewer;
                $result[$key]['manager'][$reviewerKey]['manager_name'] = $reviewerDetails->name;
                $result[$key]['manager'][$reviewerKey]['manager_emp_id'] = isset($reviewerDetails->getEmployeeDetails) ? (string)$reviewerDetails->user_code : '';
            }
        }

        return response()->json([
            'status' => true,
            'message' => '',
            'data'   => $result
        ]);
    }
    /*
        Get all the KPI forms reviewer by given user.

            DB Table : vmt_pms_kpiform_assigned
            Input params : reviewer_id

        Logic : Using reviewer_id, we will search the reviewer_id, reviewer_id


            is_manager_submitted
            (1 => Submitted else Not Submitted)
            is_manager_accepted
            (1 => Accpted, 0=> Rejected, else Not Viewed Yet)
        &&
            is_employee_submitted
            (1 => Submitted else Not Submitted)
            is_employee_accepted
            (1 => Accpted, 0=> Rejected, else Not Viewed Yet)

    */
    public function getReviewerKPIForms(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'reviewer_id' => 'required',
        ], [
            'reviewer_id.required' => 'Reviewer Id is Required',
        ]);

        if ($validation->fails()) {
            return sendError($validation->errors()->first());
        }
        $userId  = auth::user()->id;
        if ($request->reviewer_id != $userId) {
            return sendError('Reviewer Id is not matched');
        }

        // check user id in Assignee, Assigner and Reviewer
        $pmsKpiAssigneeDetails = VmtPMS_KPIFormAssignedModel::with('getPmsKpiFormReviews.getUserAssigneeDetails.getEmployeeDetails')->WhereRaw("find_in_set(" . $userId . ", reviewer_id)")
            ->orderBy('id', 'DESC')
            ->get();

        $reviewerDetails = User::where('id', $userId)->with('getEmployeeDetails')->first();
        $result = [];
        $i = 0;
        foreach ($pmsKpiAssigneeDetails as $key => $kpiAssignee) {
            $arrayAssignees = explode(',', $kpiAssignee->assignee_id);
            foreach ($arrayAssignees as $assigneeKey => $assignee) {
                $assigneeDetails = User::where('id', $assignee)->with('getEmployeeDetails')->first();

                $result[$i]['vmt_pms_kpiform_assigned_id'] = $kpiAssignee->id;
                $result[$i]['employee_id'] = $assignee;
                $result[$i]['employee_name'] = $assigneeDetails->name;
                $result[$i]['employee_emp_id'] = isset($assigneeDetails->getEmployeeDetails) ? (string)$assigneeDetails->user_code : '';

                $result[$i]['manager_name'] = $reviewerDetails->name;
                $result[$i]['manager_emp_id'] = isset($reviewerDetails->getEmployeeDetails) ? (string)$reviewerDetails->user_code : '';
                $result[$i]['assignment_period'] = $kpiAssignee->assignment_period;
                $rating = '';

                foreach ($kpiAssignee->getPmsKpiFormReviews as $reviewData) {


                    $arrayIsReviewerSubmitted = json_decode($reviewData->is_reviewer_submitted, true);
                    $arrayIsReviewerAccepted = json_decode($reviewData->is_reviewer_accepted, true);
                    foreach ($arrayIsReviewerSubmitted as $reviewerId => $reviewerSubmitted) {
                        if ($reviewerId == $userId && $reviewData->assignee_id == $assignee) {
                            $result[$i]['is_manager_submitted'] = (int)$reviewerSubmitted;

                            $result[$i]['is_manager_accepted'] = (int)$arrayIsReviewerAccepted[$reviewerId];
                        }
                    }
                    if ($reviewData->assignee_id == $assignee) {
                        $result[$i]['is_employee_submitted'] = (int)$reviewData->is_assignee_submitted ?? 0;
                        $result[$i]['is_employee_accepted'] = (int)$reviewData->is_assignee_accepted ?? 0;

                        $rating = calculateOverallReviewRatings($kpiAssignee->id, $assignee);
                        $result[$i]['rating'] = $rating;
                    }
                }

                $i++;
            }
        }
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data'   => $result
        ]);
    }

    /*
        Get details the KPI forms review details.

            DB Table : vmt_pms_kpiform_assigned
            Input params : review_kpiform_id

        Logic : Using review_kpiform_id, we will get the details assignee , details of kpi form and reviews

    */
    public function getReviewerReviews(Request $request)
    {
        $userId = auth::user()->id;
        $kpiReviewFormId = $request->review_kpiform_id;
        $data  =  VmtPMS_KPIFormAssignedModel::join(
            'vmt_pms_kpiform_reviews',
            'vmt_pms_kpiform_reviews.vmt_pms_kpiform_assigned_id',
            '=',
            'vmt_pms_kpiform_assigned.id'
        )
            ->leftJoin('users', 'users.id', '=', 'vmt_pms_kpiform_reviews.assignee_id')
            ->where('vmt_pms_kpiform_reviews.id', $kpiReviewFormId)
            ->select(
                'vmt_pms_kpiform_reviews.assignee_kpi_review',
                'vmt_pms_kpiform_reviews.assignee_kpi_percentage',
                'vmt_pms_kpiform_reviews.assignee_kpi_comments',
                'vmt_pms_kpiform_reviews.reviewer_kpi_review',
                'vmt_pms_kpiform_reviews.reviewer_kpi_percentage',
                'vmt_pms_kpiform_reviews.reviewer_kpi_comments',
                'vmt_pms_kpiform_reviews.reviewer_appraisal_comments',
                'vmt_pms_kpiform_reviews.assigner_kpi_review',
                'vmt_pms_kpiform_reviews.assigner_kpi_percentage',
                'vmt_pms_kpiform_reviews.assigner_kpi_comments',
                'vmt_pms_kpiform_reviews.assignee_kpi_status',
                'vmt_pms_kpiform_reviews.is_assignee_submitted',
                'vmt_pms_kpiform_reviews.is_assignee_accepted',
                'vmt_pms_kpiform_reviews.reviewer_kpi_status',
                'vmt_pms_kpiform_reviews.is_reviewer_submitted',
                'vmt_pms_kpiform_reviews.is_reviewer_accepted',
                'vmt_pms_kpiform_reviews.assignee_rejection_comments',
                'vmt_pms_kpiform_reviews.reviewer_rejection_comments',
                'vmt_pms_kpiform_reviews.overall_score',
                'vmt_pms_kpiform_reviews.assignee_id as assignee_user_id',
                'vmt_pms_kpiform_assigned.*',
                'users.name as assignee_name',
                'users.user_code as assignee_code'
            )->orderBy('id', 'DESC')->first();

        $ratingDetail['performance'] = '-';
        $ratingDetail['ranking'] = '-';
        $ratingDetail['action'] = '-';
        $ratingDetail['rating'] = '-';

        $show['dimension'] = 'true';
        $show['kpi'] = 'true';
        $show['operational'] = 'true';
        $show['measure'] = 'true';
        $show['frequency'] = 'true';
        $show['target'] = 'true';
        $show['stretchTarget'] = 'true';
        $show['source'] = 'true';
        $show['kpiWeightage'] = 'true';
        $show['appraiser'] = false;
        $show['manager'] = false;

        $kpiRowsId  = '';
        if ($data) {
            $config = VmtPMS_KPIFormModel::findorfail($data->vmt_pms_kpiform_id);
            if ($config) {
                $config->header = json_decode($config->column_header, true);
                $show['dimension'] = $config->available_columns && in_array('dimension', explode(',', $config->available_columns)) ? 'true' : 'false';
                $show['kpi'] = $config->available_columns && in_array('kpi', explode(',', $config->available_columns)) ? 'true' : 'false';
                $show['operational'] = $config->available_columns && in_array('operational', explode(',', $config->available_columns)) ? 'true' : 'false';
                $show['measure'] = $config->available_columns && in_array('measure', explode(',', $config->available_columns)) ? 'true' : 'false';
                $show['frequency'] = $config->available_columns && in_array('frequency', explode(',', $config->available_columns)) ? 'true' : 'false';
                $show['target'] = $config->available_columns && in_array('target', explode(',', $config->available_columns)) ? 'true' : 'false';
                $show['stretchTarget'] = $config->available_columns && in_array('stretchTarget', explode(',', $config->available_columns)) ? 'true' : 'false';
                $show['source'] = $config->available_columns && in_array('source', explode(',', $config->available_columns)) ? 'true' : 'false';
                $show['kpiWeightage'] = $config->available_columns && in_array('kpiWeightage', explode(',', $config->available_columns)) ? 'true' : 'false';
            }

            // KPI Rows
            $reviewCompleted = false;
            $assignersName = User::whereRaw("id IN($data->reviewer_id)")->pluck('name')->toArray();
            $kpiFormDetails = VmtPMS_KPIFormDetailsModel::select(
                "id",
                "vmt_pms_kpiform_id",
                "dimension",
                "kpi",
                "operational_definition",
                "measure",
                "frequency",
                "target",
                "stretch_target",
                "source",
                "kpi_weightage",
            )->where('vmt_pms_kpiform_id', $data->vmt_pms_kpiform_id)->first();

            $assigneeEmployeeOfficeDetails = VmtEmployeeOfficeDetails::select('department_id', 'process', 'designation', 'user_id')->where('user_id', $data->assignee_user_id)->first();
        }



        return response()->json([
            'status' => true,
            'message' => '',
            'data'   => [
                "review" => $data,
                "show" => $show,
                "kpiFormDetails" => $kpiFormDetails,
                "assignersName"  => $assignersName,
                "ratingDetail"   => $ratingDetail,
                "assigneeEmployeeOfficeDetails" => $assigneeEmployeeOfficeDetails
            ]
        ]);
    }


    /*
        Save review given by the reviewer.
            DB Table : vmt_pms_kpiform_reviews
            Input params : review_kpiform_id, 'reviewer_kpi_review', 'reviewer_kpi_percentage', formSubmitType

            formSubmitType == 0 ? "Save Review" : "Publish Review"

        Logic : Using review_kpiform_id, we will get the details of assigned kpi form and will store the reviews in the vmt_pms_kpiform_reviews table

    */
    public function saveReviewerReviews(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'assignedFormId' => 'required',
            'reviewer_id' => 'required',
            'assignee_id' => 'required',
            'reviewer_kpi_review' => 'required',
            'reviewer_kpi_percentage' => 'required',
            'formSubmitType' => 'required',
        ], [
            'assignedFormId.required' => 'Assigned Form Id is Required',
            'reviewer_id.required' => 'Reviewer Id is Required',
            'assignee_id.required' => 'Assignee Id is Required',
            'reviewer_kpi_review.required' => 'Reviewer KPI Review is Required',
            'reviewer_kpi_percentage.required' => 'Reviewer KPI Percentage is Required',
            'formSubmitType.required' => 'Form Submit Type is Required, 0 & 1',
        ]);

        if ($validation->fails()) {
            return sendError($validation->errors()->first());
        }
        try {
            $currentLoggedUser = Auth::user();
            // check logged user id and reviewer_id
            if ($currentLoggedUser->id != $request->reviewer_id) {
                return sendError('Assignee Id is not your Id');
            }

            // check assigned KPI Form exists or not
            $assignedKpiForm = VmtPMS_KPIFormAssignedModel::findorfail($request->assignedFormId);
            if (empty($assignedKpiForm)) {
                return sendError('Assigned Form data not found');
            }

            // check reviewer or not
            $decodedReviewersId = explode(',', $assignedKpiForm->reviewer_id);
            if (!in_array($currentLoggedUser->id, $decodedReviewersId)) {
                return sendError('Your are not reviewer for this KPI Form');
            }

            // check review available or not
            $assignedReviewCheck = VmtPMS_KPIFormReviewsModel::where('vmt_pms_kpiform_assigned_id', $request->assignedFormId)->where('assignee_id', $request->assignee_id)->with('getPmsKpiFormAssigned')->first();
            if (empty($assignedReviewCheck)) {
                return sendError('Review Data Not Found');
            }

            // check assignee has Accepted kpi form or not
            if ($assignedReviewCheck->is_assignee_accepted == '0') {
                return sendError('Assignee have rejected KPI Form!');
            }

            // check assignee has Already submitted or not kpi form or not
            if ($assignedReviewCheck->is_assignee_submitted != '1') {
                return sendError('Assignee has not submitted KPI Form Yet!');
            }

            $decodedKpiReviewerReview = json_decode($assignedReviewCheck->reviewer_kpi_review, true);
            $decodedKpiReviewerPerc = json_decode($assignedReviewCheck->reviewer_kpi_percentage, true);
            $decodedIsKpiReviewerSubmitted = json_decode($assignedReviewCheck->is_reviewer_submitted, true);
            $decodedIsKpiReviewerAccepted = json_decode($assignedReviewCheck->is_reviewer_accepted, true);

            if ($decodedIsKpiReviewerAccepted[$currentLoggedUser->id] != '1') {
                return sendError('You have not accepted KPI form Yet!');
            }

            $decodedKpiReviewerReview[Auth::id()] = json_decode($request->reviewer_kpi_review, true);
            $decodedKpiReviewerPerc[Auth::id()] = json_decode($request->reviewer_kpi_percentage);

            // dD(json_encode($decodedKpiReviewerReview));
            $assignedReviewCheck->reviewer_kpi_review = $decodedKpiReviewerReview;
            $assignedReviewCheck->reviewer_kpi_percentage = $decodedKpiReviewerPerc;
            if ($request->formSubmitType == 0) {
                $decodedIsKpiReviewerSubmitted[Auth::id()] = '0';
                $assignedReviewCheck->is_reviewer_submitted = $decodedIsKpiReviewerSubmitted;
                $assignedReviewCheck->update();
                return response()->json(['status' => true, 'message' => 'Saved as draft']);
            } else {
                $decodedIsKpiReviewerSubmitted[Auth::id()] = '1';
                $assignedReviewCheck->is_reviewer_submitted = $decodedIsKpiReviewerSubmitted;
                $assignedReviewCheck->update();

                // dD($kpiForAssignedDetails);
                $hrReview = User::find($assignedKpiForm->assigner_id);

                $currentUser_empDetails = VmtEmployeeOfficeDetails::where('user_id', auth::user()->id)->first();

                $hrList =  User::role(['HR', 'admin', 'Admin'])->get();
                $hrUsers = $hrList->pluck('id');
                $officialMailList =   VmtEmployeeOfficeDetails::whereIn('user_id', $hrUsers)->pluck('officical_mail');

                $notification_user = User::where('id', auth::user()->id)->first();
                //dd($officialMailList);
                \Mail::to($officialMailList)->send(new NotifyPMSManager(auth::user()->name,  $currentUser_empDetails->designation, $hrReview->name, $assignedReviewCheck->year));
                $message = "Employee has submitted KPI Assessment.  ";
                Notification::send($notification_user, new ViewNotification($message . auth()->user()->name));

                return response()->json(['status' => true, 'message' => "Published Review successfully. Sent mail to HR " . $officialMailList]);
            }
        } catch (Exception $e) {
            Log::info('save or submit reviewer review API error: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }


    // function use for calculating overall rating

    public function calculateOverallReviewRatings($assigneeReviewTableId = null, $assigneeId)
    {
        try {
            $assigneeReviewDetails = VmtPMS_KPIFormAssignedModel::where('id', $assigneeReviewTableId)->first();
            $finalRating = 0;

            if (!empty($assigneeReviewDetails)) {
                $decodedReviewsId = explode(',', $assigneeReviewDetails->reviewer_id);
                $assigneeReviewerReview = VmtPMS_KPIFormReviewsModel::where('assignee_id', $assigneeId)->where('vmt_pms_kpiform_assigned_id', $assigneeReviewTableId)->first();
                if (!empty($assigneeReviewerReview)) {
                    $firstReviewRating = [];
                    if (json_decode($assigneeReviewerReview->reviewer_kpi_percentage, true) != '' && isset(json_decode($assigneeReviewerReview->reviewer_kpi_percentage, true)[$decodedReviewsId[0]])) {
                        $firstReviewRating = json_decode($assigneeReviewerReview->reviewer_kpi_percentage, true)[$decodedReviewsId[0]];
                    }

                    if (count($firstReviewRating) > 0) {
                        $ratingCheck = array_sum($firstReviewRating) / count($firstReviewRating);
                        if ($ratingCheck < 60) {
                            $finalRating = 1;
                        } elseif ($ratingCheck >= 60 && $ratingCheck < 70) {
                            $finalRating = 2;
                        } elseif ($ratingCheck >= 70 && $ratingCheck < 80) {
                            $finalRating = 3;
                        } elseif ($ratingCheck >= 80 && $ratingCheck < 90) {
                            $finalRating = 4;
                        } elseif ($ratingCheck >= 90) {
                            $finalRating = 5;
                        } else {
                            $finalRating = 0;
                        }
                    }
                }
            }
            return $finalRating;
        } catch (Exception $e) {
            Log::info('calculation average rating helper error: ' . $e->getMessage());
            return 0;
        }
    }


    public function getPMSConfig(Request $request,VmtPMSModuleService_v3 $pmsModuleService)
    {
        return $pmsModuleService->getPMSConfig();
    }
    public function getEmployeeListForManger($User_id,VmtPMSModuleService_v3 $pmsModuleService)
    {
        return $pmsModuleService->getEmployeeListForManger($User_id);
    }
    public function getManagersListForEmployees($User_id,VmtPMSModuleService_v3 $pmsModuleService)
    {
        return $pmsModuleService->getManagersListForEmployees($User_id);
    }
    public function saveKPIForm(Request $request,VmtPMSModuleService_v3 $pmsModuleService)
    {
        return $pmsModuleService->saveKPIForm($request->all());
    }
    public function getKpiFormAsDropdown($author_id,VmtPMSModuleService_v3 $pmsModuleService)
    {
        return $pmsModuleService->getKPIFormAsDropdown($author_id);
    }

    public function getKPIFormDetails($form_id,VmtPMSModuleService_v3 $pmsModuleService)
    {
        return $pmsModuleService->getKPIFormDetails($form_id);

    }
    // public function selfDashboardDetails($author_id, VmtPMSModuleService_v3 $pmsModuleService)
    // {
    //     return $pmsModuleService->selfDashboardDetails($author_id);

    // }

// new pms v3


}
