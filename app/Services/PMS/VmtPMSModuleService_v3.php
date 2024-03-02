<?php

namespace App\Services\PMS;

use App\Exports\PMSFormSampleExcelExport;
use App\Exports\VmtPmsMasterReviewsReport;
use App\Exports\VmtPmsReviewsReport;
use App\Exports\VmtPmsFormDetailsReportExport;
use App\Mail\VmtPMSMail_Assignee;
use App\Mail\VmtPMSMail_Reviewer;
use App\Mail\VmtPMSMail_PublishForm;
use App\Models\ConfigPms;
use App\Models\Department;
use App\Models\User;
use App\Models\VmtClientMaster;
use App\Models\VmtConfigPmsV3;
use App\Models\VmtEmployee;
use App\Models\VmtEmployeeOfficeDetails;
use App\Models\VmtOrgTimePeriod;
use App\Models\VmtPMS_KPIFormAssignedModel;
use App\Models\VmtPMS_KPIFormDetailsModel;
use App\Models\VmtPMS_KPIFormModel;
use App\Models\VmtPMS_KPIFormReviewsModel;
use App\Models\VmtPMSassignment_settings_v3;
use App\Models\VmtPmsAssignmentV3;
use App\Models\VmtPmsKpiFormAssignedV3;
use App\Models\VmtPmsKpiFormDetailsV3;
use App\Models\VmtPmsKpiFormReviewsV3;
use App\Models\VmtPmsKpiFormV3;

use App\Models\VmtPmsDefultConfigV3;

use Carbon\CarbonPeriod;
use Database\Factories\VmtEmployeeOfficeDetailsFactory;
use Exception;
use Illuminate\Http\Request;
use App\Services\VmtPMS;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Mail;
use App\Mail\dommimails;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\Mailer\Exception\TransportException;

class VmtPMSModuleService_v3
{

    // 'Employee Kpi - Achivement','Employee Kpi - Achivement %','Employee Comments'

    private $employee_achive = ['kpi_review' => null, 'kpi_percentage' => null, 'kpi_comments' => null];


    /*
        Sends data to New Goals Assign screen.
    */
    public function populateNewGoalsAssignScreenUI($flow_type, $current_user_code)
    {

        $validator = Validator::make(
            $data = [
                "user_code" => $current_user_code,
                "flow_type" => $flow_type,
            ],
            $rules = [
                "user_code" => "required|exists:users,user_code",
                "flow_type" => "required|in:1,2,3",
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid",
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'
            ]);
        }

        try {
            $response = array();
            $client_code = VmtClientMaster::find(User::where('user_code', $current_user_code)->first()->client_id)->client_code;

            $config_settings = $this->getPMSConfig_ForGivenAssignmentPeriod($client_code, $current_user_code);
            $response['pms_config'] = $config_settings;

            $user_completed_records = VmtPmsKpiFormReviewsV3::where('assignee_id', User::where('user_code', $current_user_code)->first()->id)->where('is_reviewer_submitted', '1')->get()->count();
            $user_all_records = VmtPmsKpiFormReviewsV3::where('assignee_id', User::where('user_code', $current_user_code)->first()->id)->get()->count();

            // can show add goal button
            if ($user_all_records == $user_completed_records) {
                $status = 0;
            } else {
                $status = 1;
            }


            $currentPmsflow = $this->currentPmsFlowDetails($flow_type, $current_user_code, $config_settings)->getData(true)['data'];

            $response['department'] = $currentPmsflow['department'];
            $response['department_id'] = $currentPmsflow['department_id'];
            $response['manager_details'] = $currentPmsflow['reviewer_list'];
            $response['employee_details'] = $currentPmsflow['assignee_list'];
            $response['add_btn_status'] = $status;

            return response()->json([
                'status' => 'success',
                'message' => '',
                'data' => $response
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance',
                "error" => $e->getMessage() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getTraceAsString(),
            ]);
        }
    }
    private function getPMSConfig_ForGivenAssignmentPeriod($client_code, $current_user_code)
    {

        try {
            $client_id = VmtClientMaster::where('client_code', $client_code)->first()->id;
            $user_id = User::where('user_code', $current_user_code)->first()->id;


            $pmscurrent_settings = VmtPMSassignment_settings_v3::join('vmt_pms_assignment_v3', 'vmt_pms_assignment_v3.pms_assignment_settings_id', '=', 'vmt_pms_assignment_settings_v3.id')
                ->where('vmt_pms_assignment_settings_v3.client_id', $client_id)
                ->whereDate('vmt_pms_assignment_v3.assignment_start_date', '<=', Carbon::now())
                ->whereDate('vmt_pms_assignment_v3.assignment_end_date', '>=', Carbon::now())->first();

            $check_assigned_period = VmtPmsKpiFormAssignedV3::join('vmt_pms_kpiform_reviews_v3', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id', '=', 'vmt_pms_kpiform_assigned_v3.id')
                ->where('vmt_pms_kpiform_assigned_v3.assignee_id', $user_id)->where('vmt_pms_assignment_v3_id', $pmscurrent_settings->id);

            if (($check_assigned_period)->exists()) {
                $checked_assinged_period = $check_assigned_period->where('is_reviewer_submitted', '1')->first();
                if ($checked_assinged_period != null) {
                    $pmsSetting = VmtPMSassignment_settings_v3::join('vmt_pms_assignment_v3', 'vmt_pms_assignment_v3.pms_assignment_settings_id', '=', 'vmt_pms_assignment_settings_v3.id')
                        ->where('vmt_pms_assignment_settings_v3.client_id', $client_id)
                        ->whereDate('vmt_pms_assignment_v3.assignment_start_date', '<=', Carbon::parse($pmscurrent_settings->assignment_end_date)->addDay())
                        ->whereDate('vmt_pms_assignment_v3.assignment_end_date', '>=', Carbon::parse($pmscurrent_settings->assignment_end_date)->addDay())->first();
                    if ($pmsSetting == null) {
                        return response()->json([
                            'status' => 'failure',
                            'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance',
                            "error" => "can't find settings",
                            // "error_verbose" => $e->getTraceAsString(),
                        ]);
                    }
                } else {
                    $pmsSetting = $pmscurrent_settings;
                }
            } else {
                $pmsSetting = $pmscurrent_settings;
            }

            if ($pmsSetting->calendar_type == 'financial_year') {
                $cal_type_full_year = 'Apr-' . $pmsSetting->year . ' - Mar-' . Carbon::parse('01-01-' . $pmsSetting->year)->addYear()->format('Y');
            } else if ($pmsSetting->calendar_type == 'calendar_year') {
                $cal_type_full_year = 'Jan-' . $pmsSetting->year . ' - Dec-' . $pmsSetting->year;
            }
            $config['assignment_id'] = $pmsSetting->id;
            $config['calendar_type'] = $pmsSetting->calendar_type;
            // $config['year'] = $pmsSetting->year;
            $config['year'] = $cal_type_full_year;
            $config['frequency'] = $pmsSetting->frequency;

            $config['assignment_period'] = $this->getProcessedAssignmentPeriod($pmsSetting->assignment_period, $pmsSetting->frequency, $pmsSetting->assignment_start_date, $pmsSetting->assignment_end_date);

            $selected_header = json_decode($pmsSetting->selected_headers, true);

            // selected headers
            foreach ($selected_header as $key => $value) {
                if ($value['is_selected'] == '1') {
                    $temp[] = $value;
                }
            }

            $config['selected_header'] = $temp;

            return $config;
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance',
                "error" => $e->getMessage() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getTraceAsString(),
            ]);
        }
    }

    private function getProcessedAssignmentPeriod($assignment_period, $frequency, $assignment_start_date, $assignment_end_date)
    {

        $start_date = Carbon::parse($assignment_start_date);
        $end_date = Carbon::parse($assignment_end_date);

        if ($frequency == "weekly") {
            $assignment_period = $assignment_period . " st week of " . $start_date->format('M-Y');
        } elseif ($frequency == "monthly") {
            $assignment_period = $assignment_period . "- " . $start_date->format('M-Y');
        } elseif ($frequency == "quarterly") {
            $assignment_period = $assignment_period . "- " . $start_date->format('M-y') . " to " . $end_date->format('M-y');
        } elseif ($frequency == "half_yearly") {
            $assignment_period = $assignment_period . "- " . $start_date->format('M-y') . " to " . $end_date->format('M-y');
        } elseif ($frequency == "yearly") {
            $assignment_period = "Annual" . " - " . $start_date->format('M-y') . " to " . $end_date->format('M-y');
        }

        return $assignment_period;
    }

    public function getExistingAssignmentPeriodsList($client_code, $selected_year)
    {
        $validator = Validator::make(
            $data = [
                "client_code" => $client_code,
                "selected_year" => $selected_year,
            ],
            $rules = [
                "client_code" => 'required|exists:vmt_client_master,client_code',
                "selected_year" => "required",
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid",
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'
            ]);
        }

        try {

            $client_id = VmtClientMaster::where('client_code', $client_code)->first()->id;
            $vmt_pms_assignment_v3_query = VmtPMSassignment_settings_v3::join('vmt_pms_assignment_v3', 'vmt_pms_assignment_v3.pms_assignment_settings_id', '=', 'vmt_pms_assignment_settings_v3.id')
                ->where('year', $selected_year)
                ->where('vmt_pms_assignment_settings_v3.client_id', $client_id)->get();

            $assignment_period_list = [];
            foreach ($vmt_pms_assignment_v3_query as $key => $single_assignment) {
                $assignment_period = $this->getProcessedAssignmentPeriod($single_assignment['assignment_period'], $single_assignment['frequency'], $single_assignment['assignment_start_date'], $single_assignment['assignment_end_date']);

                if ((Carbon::parse($assignment_period))->lte(Carbon::now())) {
                    // $temp['assingnment_period'] = $assignment_period;
                    array_push($assignment_period_list, $assignment_period);
                }
            }

            return response()->json([
                "status" => "success",
                "data" => $assignment_period_list
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => $e->getMessage(),
            ], 400);
        }

    }

    private function getDepartments()
    {

        try {

            $all_dept = Department::get(['id', 'name']);

            return $all_dept;
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance',
                "error" => $e->getMessage() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getTraceAsString(),
            ]);
        }
    }


    private function currentPmsFlowDetails($flow_type, $current_loggedin_usercode, $config_settings)
    {

        $validator = Validator::make(
            $data = [
                "user_code" => $current_loggedin_usercode,
                "flow_type" => $flow_type,
            ],
            $rules = [
                "user_code" => "required|exists:users,user_code",
                "flow_type" => "required|in:1,2,3",
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid",
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'

            ]);
        }

        try {
            $current_loggedin_user = User::where('user_code', $current_loggedin_usercode)->first();
            $get_login_user_office = VmtEmployeeOfficeDetails::where('user_id', $current_loggedin_user->id)->first();
            // dd($get_login_user_office);
            $l1_manager_details = $this->getL1ManagerDetails($current_loggedin_usercode);
            $assigned_users = VmtPmsKpiFormAssignedV3::where('vmt_pms_assignment_v3_id', $config_settings['assignment_id'])->get()->groupBy('assignee_id')->toArray();

            switch ($flow_type) {
                case "3":
                    $response['reviewer_list'] = ['id' => $l1_manager_details['id'], 'name' => $l1_manager_details['name']] ?? null;
                    $response['assignee_list'] = ['id' => $current_loggedin_user->id, 'name' => $current_loggedin_user->name] ?? null;
                    $response['department_id'] = Department::where('id', $get_login_user_office->department_id)->get('id')->toarray();
                    $response['department'] = $this->getDepartments();
                    break;

                case "2":

                    $assingee_list = User::join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')->where('vmt_employee_office_details.l1_manager_code', $current_loggedin_usercode)->where('users.is_ssa', '0')->where('users.active', '1')->get(['users.id', 'name', 'department_id'])->toarray();

                    for ($i = 0; $i < count($assingee_list); $i++) {
                        if (array_key_exists($assingee_list[$i]['id'], $assigned_users)) {
                            $assingee_list[$i]['form_assigned'] = '1';
                        } else {
                            $assingee_list[$i]['form_assigned'] = '0';
                        }
                    }
                    $response['reviewer_list'] = ['id' => $current_loggedin_user->id, 'name' => $current_loggedin_user->name];
                    $response['assignee_list'] = $assingee_list;
                    $department_emp = User::join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')->where('vmt_employee_office_details.l1_manager_code', $current_loggedin_usercode)->distinct('department_id')->pluck('department_id');
                    $response['department_id'] = null;
                    $response['department'] = Department::whereIn('id', $department_emp)->get(['id', 'name']);
                    break;

                case "1":

                    $assingee_list = User::join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')->where('users.is_ssa', '0')->where('users.active', '1')->get(['users.id', 'name', 'department_id'])->toarray();
                    $users = User::where('users.is_ssa', '0')->where('users.active', '1')->get(['id', 'user_code'])->toArray();
                    $arr = [];
                    foreach ($users as $single_users) {
                        $temp['employee_id'] = $single_users['id'];
                        $temp['manager_name'] = $this->getL1ManagerDetails($single_users['user_code'])['name'] ?? null;
                        array_push($arr, $temp);
                    }
                    for ($i = 0; $i < count($assingee_list); $i++) {
                        if (array_key_exists($assingee_list[$i]['id'], $assigned_users)) {
                            $assingee_list[$i]['form_assigned'] = '1';
                        } else {
                            $assingee_list[$i]['form_assigned'] = '0';
                        }
                    }

                    $response['reviewer_list'] = $arr;
                    $response['assignee_list'] = $assingee_list;
                    $response['department_id'] = null;
                    $response['department'] = $this->getDepartments();
                    break;
            }

            return response()->json([
                "status" => "success",
                "message" => "Form created successfully",
                "data" => $response
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance',
                "error" => $e->getMessage() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getTraceAsString(),
            ]);
        }
    }


    public function saveOrUpdateKpiFormDetails($author_usercode, $form_name, $form_details, $form_id)
    {

        /*
         $form_details  = [
           [ 'kpi' => 'Responsible of Office Neet and Clean...',
            'frequency' => 'q1',
            'target' => '100',
            'kpi_weightage' => '50%',
            ],
            [
            'kpi' => 'Responsible of Office Neet and Clean...',
            'frequency' => 'q1',
            'target' => '100',
            'kpi_weightage' => '50%',
            ]
            ];
        */

        $validator = Validator::make(
            $data = [
                "author_usercode" => $author_usercode,
                "form_name" => $form_name,
                "form_details" => $form_details,
                "form_id" => $form_id,
            ],
            $rules = [
                "author_usercode" => "required|exists:users,user_code",
                "form_name" => "required",
                "form_details" => "required|array",
                "form_id" => "nullable",
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid",
                "array" => "Field :attribute datatype is mismatch",
            ]
        );


        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance',
                'data' => $validator->errors()->all()
            ]);
        }

        try {

            if (empty($form_id)) {

                //If $form_id is NULL, then we create new form
                //Check if formname exists
                $existing_form_name = VmtPmsKpiFormV3::where('form_name', $form_name)->first();

                if (!empty($existing_form_name)) {
                    return response()->json([
                        'status' => 'failure',
                        'message' => 'Form name is already exist',
                        'form_id' => '',
                    ]);
                }



                $users_query = User::where('user_code', $author_usercode)->first();
                $user_id = $users_query->id;
                $vmt_pms_assignment_v3_query = VmtPMSassignment_settings_v3::join('vmt_pms_assignment_v3', 'vmt_pms_assignment_v3.pms_assignment_settings_id', '=', 'vmt_pms_assignment_settings_v3.id')
                    ->where('vmt_pms_assignment_settings_v3.client_id', $users_query->client_id)
                    ->whereDate('vmt_pms_assignment_v3.assignment_start_date', '<=', Carbon::now())
                    ->whereDate('vmt_pms_assignment_v3.assignment_end_date', '>=', Carbon::now())->first();
                $all_headers_json = json_decode($vmt_pms_assignment_v3_query->selected_headers, true);

                $selected_header = [];
                foreach ($all_headers_json as $single_value) {
                    if ($single_value['is_selected'] == 1) {
                        unset($single_value['is_selected']);
                        array_push($selected_header, $single_value);
                    }
                }

                $selected_header_str = json_encode($selected_header, true);

                //Creating entry in vmt_pms_kpiform_v3 table
                $kpiTable = new VmtPmsKpiFormV3;
                $kpiTable->form_name = $form_name;
                $kpiTable->selected_headers = $selected_header_str;
                $kpiTable->author_id = $user_id;
                $kpiTable->save();

                foreach ($form_details as $single_form) {
                    $kpiRow = new VmtPmsKpiFormDetailsV3;
                    $kpiRow->vmt_pms_kpiform_v3_id = $kpiTable->id;
                    $kpiRow->objective_values = json_encode($single_form);
                    $kpiRow->save();
                }
            } else {
                //If $form_id is NOT NULL, then we update existing form


                //Here We Check This From Assigned To User
                if (VmtPmsKpiFormAssignedV3::where('vmt_pms_kpiform_v3_id', $form_id)->exists()) {
                    $reviewer_detail_encoded_json = VmtPmsKpiFormAssignedV3::join('vmt_pms_kpiform_reviews_v3', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id', 'vmt_pms_kpiform_assigned_v3.id')->first()->reviewer_details;
                    $reviewer_detail_json = json_decode($reviewer_detail_encoded_json, true);
                    $reviewer_accept_sts = 0;
                    foreach ($reviewer_detail_json as $single_flow) {
                        if ($single_flow['review_order'] == 1) {
                            $reviewer_accept_sts = $single_flow['is_accepted'];
                            break;
                        }
                    }
                    if ($reviewer_accept_sts == -1) {
                        //delete old row for that existing form
                        VmtPmsKpiFormDetailsV3::where('vmt_pms_kpiform_v3_id', $form_id)->delete();
                        foreach ($form_details as $single_form) {
                            $kpiRow = new VmtPmsKpiFormDetailsV3;
                            $kpiRow->vmt_pms_kpiform_v3_id = $form_id;
                            $kpiRow->objective_values = json_encode($single_form);
                            $kpiRow->save();
                        }
                        return response()->json([
                            "status" => "success",
                            "message" => "The OKR/ PMS form has been updated successfully",
                            "data" => $form_id
                        ], 200);
                    } else {

                        VmtPmsKpiFormDetailsV3::where('vmt_pms_kpiform_v3_id', $form_id)->delete();
                        foreach ($form_details as $single_form) {
                            $kpiRow = new VmtPmsKpiFormDetailsV3;
                            $kpiRow->vmt_pms_kpiform_v3_id = $form_id;
                            $kpiRow->objective_values = json_encode($single_form);
                            $kpiRow->save();
                        }
                        return response()->json([
                            "status" => "success",
                            "message" => "The OKR/ PMS form has been updated successfully",
                            "data" => $form_id
                        ], 200);

                    }
                } else {
                    //delete old row for that existing form
                    VmtPmsKpiFormDetailsV3::where('vmt_pms_kpiform_v3_id', $form_id)->delete();
                    foreach ($form_details as $single_form) {
                        $kpiRow = new VmtPmsKpiFormDetailsV3;
                        $kpiRow->vmt_pms_kpiform_v3_id = $form_id;
                        $kpiRow->objective_values = json_encode($single_form);
                        $kpiRow->save();
                    }
                    return response()->json([
                        "status" => "success",
                        "message" => "The OKR/ PMS form has been updated successfully",
                        "data" => $form_id
                    ], 200);
                }
            }


            return response()->json([
                "status" => "success",
                "message" => "The OKR/ PMS form has been created successfully",
                "data" => $kpiTable->id
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Error while saving KPI form details',
                "error" => $e->getMessage() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getTraceAsString(),
            ], 400);
        }
    }


    public function getKPIFormsList($user_code)
    {

        $validator = Validator::make(
            $data = [
                "user_code" => $user_code,
            ],
            $rules = [
                "user_code" => "required|exists:users,user_code",
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid",
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'
            ]);
        }


        try {
            $user_id = User::where('user_code', $user_code)->first()->id;
            $kpi_form_list = VmtPmsKpiFormV3::where('author_id', $user_id)->get(['id', 'form_name']);
            $get_allassigned_form = VmtPmsKpiFormAssignedV3::get()->groupBy('vmt_pms_kpiform_v3_id')->toArray();

            for ($i = 0; $i < count($kpi_form_list); $i++) {
                if (array_key_exists($kpi_form_list[$i]['id'], $get_allassigned_form)) {
                    $kpi_form_list[$i]['is_assigned'] = "1";
                } else {
                    $kpi_form_list[$i]['is_assigned'] = "0";
                }
            }

            return response()->json([
                'status' => 'success',
                'data' => $kpi_form_list,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance',
                "error" => $e->getMessage() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getTraceAsString(),
            ], 400);
        }
    }

    public function getSelectedKPIForm($form_id)
    {

        $validator = Validator::make(
            $data = [
                "form_id" => $form_id,
            ],
            $rules = [
                "form_id" => "required|exists:vmt_pms_kpiform_v3,id",
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid",
            ]
        );


        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'
            ]);
        }


        try {

            $get_form = VmtPmsKpiFormV3::where('id', $form_id)->first();
            $form_details = VmtPmsKpiFormDetailsV3::where('vmt_pms_kpiform_v3_id', $get_form->id)->get();

            $form_data = array();

            //dd($form_details);
            foreach ($form_details as $single_form) {
                $temp = json_decode($single_form['objective_values'], true);

                $temp['record_id'] = $single_form['id'];

                //finally store in another array
                array_push($form_data, $temp);
            }

            $response['form_name'] = $get_form->form_name;
            $response['form_data'] = $form_data;

            return $response;
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance',
                "error" => $e->getMessage() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getTraceAsString(),
            ]);
        }
    }

    /*
        Save the edited row details in the PMS create/view form page.

        Validations :
            For,
                $record_id : check in vmt_pms_kpiform_details_v3 table
                $json_form_details : Check if its proper JSON. Then check whether the 'valid selected header' are sent
    */
    public function updateFormRowDetails($record_id, $json_formrow_details)
    {
        $validator = Validator::make(
            $data = [
                "record_id" => $record_id,
                "json_formrow_details" => $json_formrow_details,
            ],
            $rules = [
                "record_id" => "required|exists:vmt_pms_kpiform_details_v3,id",
                "json_formrow_details" => "required"
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid",
            ]
        );


        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'
            ]);
        }


        try {
            $existing_formrow_details = VmtPmsKpiFormDetailsV3::find($record_id);

            //TODO : Need to check whether the $json_form_details headers matches the PMS selected headers
            $existing_formrow_details->objective_values = $json_formrow_details;
            $existing_formrow_details->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Form row details updated successfully',
                'data' => '',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Error while updating form row details',
                "error" => $e->getMessage() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getTraceAsString(),
            ], 400);
        }
    }

    /*
        Deletes the selected form row details for a given formdetails row ID

        TODO :  When deleting formrow , check whether the form is already assigned to someone.
                If already assigned, throw error.

    */
    public function deleteFormRowDetails($record_id)
    {
        $validator = Validator::make(
            $data = [
                "record_id" => $record_id,
            ],
            $rules = [
                "record_id" => "required|exists:vmt_pms_kpiform_details_v3,id",
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid",
            ]
        );


        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'
            ]);
        }

        try {


            $kpi_form_assigned = VmtPmsKpiFormAssignedV3::where('vmt_pms_kpiform_v3_id', $record_id);

            if ($kpi_form_assigned->exists()) {

                return $response = ([
                    'status' => 'failure',
                    'message' => 'Form is already assigned, it cant be deleted',
                    'data' => '',
                ]);
            }

            $existing_formrow_details = VmtPmsKpiFormDetailsV3::find($record_id);

            //TODO : Need to check whether this form is already assigned. If already assigned, then show
            $existing_formrow_details->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Form row detail deleted successfully',
                'data' => '',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Error while deleting form row details',
                "error" => $e->getMessage() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getTraceAsString(),
            ], 400);
        }
    }

    private function getL1ManagerDetails($user_code)
    {

        $validator = Validator::make(
            $data = [
                "user_code" => $user_code
            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'
            ]);
        }

        try {


            $getuser = User::join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')->where('users.user_code', $user_code)->first();

            if ($getuser) {
                $manager_details = User::join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')->where('user_code', $getuser->l1_manager_code)->first();
                return $manager_details;
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Unable to find the given L1 manager user_code : ' . $getuser->l1_manager_code,
                    'data' => null,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Error while fetching L1 manager for the given user-code : ' . $user_code,
                'data' => null,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function getEmployeeHierarchyManagerCodes($assignee_user_code, $levels = 3)
    {

        $validator = Validator::make(
            $data = [
                "user_code" => $assignee_user_code
            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid"
            ]
        );


        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'
            ]);
        }


        // $emp_code = 'PSC0018';

        $manager_usercodes = [];
        $current_emp_code = $assignee_user_code;


        $getuser = User::join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')->where('users.user_code', $current_emp_code)->first();

        if ($getuser) {
            $getmanagers_L1 = User::where('user_code', $getuser->l1_manager_code)->first()->user_code ?? null;
            if ($getmanagers_L1 != null) {
                $manager_usercodes['L1'] = $getmanagers_L1;
            }
        }


        if (!empty($getmanagers_L1)) {
            $getuser_1 = User::join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')->where('users.user_code', $getmanagers_L1)->first();
            if ($getuser_1) {
                $getmanagers_L2 = User::where('user_code', $getuser_1->l1_manager_code)->first()->user_code ?? null;
                if ($getmanagers_L2 != null) {
                    $manager_usercodes['L2'] = $getmanagers_L2;
                }
            }
        }

        if (!empty($getmanagers_L2)) {
            $getuser_2 = User::join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')->where('users.user_code', $getmanagers_L2)->first();
            if ($getuser_2) {
                $getmanagers_L3 = User::where('user_code', $getuser_2->l1_manager_code)->first()->user_code ?? null;
                if ($getmanagers_L3 != null) {
                    $manager_usercodes['L3'] = $getmanagers_L3;
                }
            }
        }

        return $manager_usercodes;
    }


    public function createReviewerFlowDetails($emp_code, $flow_type, $pms_assignment_id)
    {


        $validator = Validator::make(
            $data = [
                "user_code" => $emp_code,
                "flow_type" => $flow_type,
                "pms_assignment_id" => $pms_assignment_id
            ],
            $rules = [
                "user_code" => "required|exists:users,user_code",
                "flow_type" => "required",
                "pms_assignment_id" => "required"
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid",
                "in" => "Field :attribute is invalid",
            ]
        );


        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'
            ]);
        }

        // $pms_config = VmtConfigPmsV3::first();

        /*
            Reviewers Flow JSON structure in Config PMS
            [
                {"order":"1","reviewer_level":"L1"},
                {"order":"2","reviewer_level":"L2"},
                {"order":"3","reviewer_level":"L3"}
            ]

        */

        $pms_assignment_setting = VmtPmsAssignmentV3::where('id', $pms_assignment_id)->first();

        $reviewers_flow = json_decode($pms_assignment_setting->reviewers_flow, true);

        $manager_usercodes = $this->getEmployeeHierarchyManagerCodes($emp_code);

        $temp = array();
        $res = array();
        foreach ($reviewers_flow as $single_level) {

            $t_reviewer_level = $single_level['reviewer_level'];

            if (isset($manager_usercodes[$t_reviewer_level])) {

                $temp["reviewer_id"] = User::where('user_code', $manager_usercodes[$t_reviewer_level])->first()->id;
                $temp["reviewer_user_code"] = $manager_usercodes[$t_reviewer_level];
                $temp["review_order"] = $single_level['order'];
                $temp["reviewer_level"] = $t_reviewer_level;

                if ($flow_type == 3 && $pms_assignment_setting->should_mgr_appr_rej_goals == "1") {
                    $temp["is_accepted"] = 0;
                } else {
                    $temp["is_accepted"] = 1;
                }

                $temp["is_reviewed"] = 0;
                $temp["acceptreject_date"] = "";
                $temp["reviewed_date"] = "";
                $temp["rejection_comments"] = "";
                $temp["reviewer_score"] = "";

                array_push($res, $temp);
            }
        }

        return json_encode($res);
    }

    private function setEmptyAssigneeReview($assingee_id)
    {

        $validator = Validator::make(
            $data = [
                "assingee_id" => $assingee_id
            ],
            $rules = [
                "assingee_id" => "required|exists:users,id"
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid"
            ]
        );


        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'

            ]);
        }

        try {

            $response["assignee_id"] = $assingee_id;
            $response["assignee_user_code"] = User::where('id', $assingee_id)->first()->user_code ?? null;
            $response["assignee_kpi"] = null;

            return json_encode($response);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'failure',
                'data' => $e->getMessage(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance',
                'line' => $e->getLine()
            ]);
        }
    }

    private function setEmptyReviewerReview($assingee_id, $pms_assignment_id)
    {

        $validator = Validator::make(
            $data = [
                "assingee_id" => $assingee_id,
                "pms_assignment_id" => $pms_assignment_id
            ],
            $rules = [
                "assingee_id" => "required|exists:users,id",
                "pms_assignment_id" => "required"
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid"
            ]
        );


        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'

            ]);
        }

        try {

            $users_details = user::where('id', $assingee_id)->first();

            $reviewers_flow = VmtPmsAssignmentV3::where('id', $pms_assignment_id)->first()->reviewers_flow;
            $reviewers_flow = json_decode($reviewers_flow, true);
            $manager_usercodes = $this->getEmployeeHierarchyManagerCodes($users_details->user_code);

            $temp = array();
            $reviewerReviews = array();
            foreach ($reviewers_flow as $single_level) {
                if (isset($manager_usercodes[$single_level['reviewer_level']])) {
                    $response['reviewer_id'] = user::where('user_code', $manager_usercodes[$single_level['reviewer_level']])->first()->id;
                    $response['reviewer_user_code'] = $manager_usercodes[$single_level['reviewer_level']];
                    $response['reviewer_kpi'] = null;
                    array_push($reviewerReviews, $response);
                }
            }

            return json_encode($reviewerReviews);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'failure',
                'data' => $e->getMessage(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance',
                'line' => $e->getLine()
            ]);
        }

    }

    private function publishSelfAppraisalForm($kpiformid, $assignee_id, $reviewer_id, $department, $flow_type, $pms_assignment_id)
    {
        $validator = Validator::make(
            $data = [
                "vmt_pms_kpiform_v3_id" => $kpiformid,
                "assignee_id" => $assignee_id,
                "reviewer_id" => $reviewer_id,
                "department_id" => $department,
                'flow_type' => $flow_type,
                "pms_assignment_id" => $pms_assignment_id
            ],
            $rules = [
                "vmt_pms_kpiform_v3_id" => 'required',
                "assignee_id" => "required",
                "reviewer_id" => 'required',
                "department_id" => 'required',
                'flow_type' => 'required',
                "pms_assignment_id" => 'required'
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid"
            ]
        );


        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'

            ]);
        }

        try {

            $assignment = VmtPmsAssignmentV3::where('id', $pms_assignment_id)->first();

            $publishform = new VmtPmsKpiFormAssignedV3;
            $publishform->vmt_pms_kpiform_v3_id = $kpiformid;
            $publishform->assignee_id = $assignee_id;
            $publishform->reviewer_id = $reviewer_id;
            $publishform->assigner_id = $assignee_id;
            $publishform->goal_initiated_date = carbon::now()->format('Y-m-d');
            $publishform->department_id = $department;
            $publishform->vmt_pms_assignment_v3_id = $pms_assignment_id;
            $publishform->flow_type = $flow_type;
            // $publishform->org_time_period_id = $org_time_period_id;
            $publishform->save();

            $reviewer = new VmtPmsKpiFormReviewsV3;
            $reviewer->vmt_kpiform_assigned_v3_id = $publishform->id;
            $reviewer->assignee_id = $assignee_id;
            $reviewer->is_assignee_accepted = '1';
            $reviewer->reviewer_details = $this->createReviewerFlowDetails(User::where('id', $assignee_id)->first()->user_code, $flow_type, $pms_assignment_id);
            $reviewer->assignee_kpi_review = $this->setEmptyAssigneeReview($assignee_id);
            $reviewer->reviewer_kpi_review = $this->setEmptyReviewerReview($assignee_id, $pms_assignment_id);
            if ($assignment->should_mgr_appr_rej_goals == "0") {
                $reviewer->is_reviewer_accepted = "1";
            }
            $reviewer->save();



            //  form publish mail to L1manager
            $users_details = user::join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->where('users.id', $assignee_id)->first();
            $managers_details = $this->getL1ManagerDetails($users_details->user_code);
            // $hr_details = $this->getL1ManagerDetails(user::where('id', $users_details->hr_user_id)->first()->user_code);
            $login_Link = request()->getSchemeAndHttpHost();
            $comments_employee = '';
            $emp_avatar = json_decode(newgetEmployeeAvatarOrShortName($managers_details['user_id']), true);
            $emp_neutralgender = getGenderNeutralTerm($assignee_id);
            // dd($emp_avatar);
            // send mail to L1 manager

            $sent_mail = Mail::to($managers_details['officical_mail'])
                // ->cc($hr_details['officical_mail'])
                ->send(
                    new VmtPMSMail_Assignee(
                        "publish",
                        $flow_type,
                        $users_details->name,
                        "2023",
                        $managers_details['name'],
                        $comments_employee,
                        $login_Link,
                        $emp_avatar,
                        $emp_neutralgender
                    )
                );

            return response()->json([
                "status" => "success",
                "message" => "Your team's OKR/KPI form has been successfully published for the period of " . Carbon::parse($assignment->assignment_start_date)->format('F') . " . Wishing your team all the best as you take action to achieve this goal!",
                "data" => "kpi form published successfully",
            ]);
        } catch (TransportException $e) {
            return response()->json([
                "status" => "success",
                "message" => "Your team's OKR/KPI form has been successfully published for the period of " . Carbon::parse($assignment->assignment_start_date)->format('F') . " . Wishing your team all the best as you take action to achieve this goal!. due to some techinal error mail not send",
                "mail_status" => "due to some techinal error mail not send",
                "data" => "kpi form published successfully",
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failure',
                'data' => $e->getMessage(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance',
                'line_string' => $e->getTraceAsString(),
                'line' => $e->getLine()
            ]);
        }
    }

    private function publishTeamAppraisalForm($kpiformid, $assignee_id, $reviewer_id, $department, $flow_type, $pms_assignment_id)
    {

        $validator = Validator::make(
            $data = [
                "vmt_pms_kpiform_v3_id" => $kpiformid,
                "assignee_id" => $assignee_id,
                "reviewer_id" => $reviewer_id,
                "department_id" => $department,
                "flow_type" => $flow_type,
                "pms_assignment_id" => $pms_assignment_id
            ],
            $rules = [
                "vmt_pms_kpiform_v3_id" => 'required',
                "assignee_id" => "required",
                "reviewer_id" => 'required',
                "department_id" => 'required',
                "flow_type" => 'required',
                "pms_assignment_id" => 'required'
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid"
            ]
        );


        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'
            ]);
        }


        try {

            $assignment = VmtPmsAssignmentV3::where('id', $pms_assignment_id)->first();

            foreach ($assignee_id as $single_assigne) {

                $publishform = new VmtPmsKpiFormAssignedV3;
                $publishform->vmt_pms_kpiform_v3_id = $kpiformid;
                $publishform->assignee_id = $single_assigne['id'];
                $publishform->reviewer_id = $reviewer_id;
                $publishform->assigner_id = $reviewer_id;
                $publishform->goal_initiated_date = carbon::now()->format('Y-m-d');
                $publishform->department_id = VmtEmployeeOfficeDetails::where('user_id', $single_assigne['id'])->first()->department_id ?? null;
                $publishform->vmt_pms_assignment_v3_id = $pms_assignment_id;
                $publishform->flow_type = $flow_type;
                $publishform->save();

                $reviewer = new VmtPmsKpiFormReviewsV3;
                $reviewer->vmt_kpiform_assigned_v3_id = $publishform->id;
                $reviewer->assignee_id = $single_assigne['id'];
                $reviewer->is_reviewer_accepted = '1';
                $reviewer->reviewer_details = $this->createReviewerFlowDetails(User::where('id', $single_assigne['id'])->first()->user_code, $flow_type, $pms_assignment_id);
                $reviewer->assignee_kpi_review = $this->setEmptyAssigneeReview($single_assigne['id']);
                $reviewer->reviewer_kpi_review = $this->setEmptyReviewerReview($single_assigne['id'], $pms_assignment_id);
                if ($assignment->should_emp_acp_rej_goals == "0") {
                    $reviewer->is_assignee_accepted = "1";
                }
                $reviewer->save();

                //  form publish mail to L1manager
                $users_details = user::join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                    ->where('users.id', $single_assigne['id'])->first();
                $managers_details = $this->getL1ManagerDetails($users_details->user_code);
                // $hr_details = $this->getL1ManagerDetails(user::where('id', $users_details->hr_user_id)->first()->user_code);
                $login_Link = request()->getSchemeAndHttpHost();
                $comments_employee = '';
                $emp_avatar = json_decode(newgetEmployeeAvatarOrShortName($single_assigne['id']), true);
                $emp_neutralgender = getGenderNeutralTerm($single_assigne['id']);

                // send mail to Employee
                $sent_mail = Mail::to($users_details->officical_mail)
                    // ->cc($hr_details['officical_mail'])
                    ->queue(
                        new VmtPMSMail_PublishForm(
                            "publish",
                            $users_details->name,
                            "2023",
                            "Apr 2023 - Mar 2024",
                            $managers_details['name'],
                            $comments_employee,
                            $flow_type,
                            $login_Link,
                            $emp_avatar,
                            $emp_neutralgender
                        )
                    );

            }

            return response()->json([
                "status" => "success",
                "message" => "Your team's OKR/KPI form has been successfully published for the period of " . Carbon::parse($assignment->assignment_start_date)->format('F') . " . Wishing your team all the best as you take action to achieve this goal!",
                "data" => "kpi form published successfully",
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failure',
                'data' => $e->getMessage(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance',
                'line' => $e->getLine()
            ]);
        }
    }


    private function publishOrgAppraisalForm($kpiformid, $assignee_id, $reviewer_id, $department, $flow_type, $pms_assignment_id)
    {

        $validator = Validator::make(
            $data = [
                "vmt_pms_kpiform_v3_id" => $kpiformid,
                "assignee_id" => $assignee_id,
                // "reviewer_id" => $reviewer_id,
                "department_id" => $department,
                "pms_assignment_id" => $pms_assignment_id,
                "flow_type" => $flow_type
            ],
            $rules = [
                "vmt_pms_kpiform_v3_id" => 'required',
                "assignee_id" => "required",
                // "reviewer_id" => 'required',
                "department_id" => 'required',
                "flow_type" => 'required',
                "pms_assignment_id" => 'required'

            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'
            ]);
        }


        try {

            foreach ($assignee_id as $single_assigne) {

                $users_details = user::join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                    ->where('users.id', $single_assigne['id'])->first();
                $manager_details = $this->getL1ManagerDetails($users_details->user_code);
                $manager_user_id = $manager_details['user_id'];
                $manager_name = $manager_details['name'];
                $manager_officical_mail = $manager_details['officical_mail'];

                $publishform = new VmtPmsKpiFormAssignedV3;
                $publishform->vmt_pms_kpiform_v3_id = $kpiformid;
                $publishform->assignee_id = $single_assigne['id'];
                $publishform->reviewer_id = $manager_user_id;
                $publishform->assigner_id = $manager_user_id;
                $publishform->goal_initiated_date = carbon::now()->format('Y-m-d');
                $publishform->department_id = VmtEmployeeOfficeDetails::where('user_id', $single_assigne['id'])->first()->department_id ?? null;
                $publishform->vmt_pms_assignment_v3_id = $pms_assignment_id;
                $publishform->flow_type = $flow_type;
                $publishform->save();

                $reviewer = new VmtPmsKpiFormReviewsV3;
                $reviewer->vmt_kpiform_assigned_v3_id = $publishform->id;
                $reviewer->assignee_id = $single_assigne['id'];
                $reviewer->is_assignee_accepted = '1';
                $reviewer->is_reviewer_accepted = '1';
                $reviewer->reviewer_details = $this->createReviewerFlowDetails(User::where('id', $single_assigne['id'])->first()->user_code, $flow_type, $pms_assignment_id);
                $reviewer->assignee_kpi_review = $this->setEmptyAssigneeReview($single_assigne['id']);
                $reviewer->reviewer_kpi_review = $this->setEmptyReviewerReview($single_assigne['id'], $pms_assignment_id);
                $reviewer->save();

                //  form publish mail to L1manager

                $login_Link = request()->getSchemeAndHttpHost();
                $comments_employee = '';
                $emp_avatar = json_decode(newgetEmployeeAvatarOrShortName($single_assigne['id']), true);
                $emp_neutralgender = getGenderNeutralTerm($single_assigne['id']);

                // send mail to Employee
                $sent_mail = Mail::to($users_details->officical_mail)
                    ->cc($manager_officical_mail)
                    ->queue(
                        new VmtPMSMail_PublishForm(
                            "publish",
                            $users_details->name,
                            "2023",
                            "Apr 2023 - Mar 2024",
                            $manager_name,
                            $comments_employee,
                            $flow_type,
                            $login_Link,
                            $emp_avatar,
                            $emp_neutralgender
                        )
                    );

            }

            $assignment = VmtPmsAssignmentV3::where('id', $pms_assignment_id)->first();

            return response()->json([
                "status" => "success",
                "message" => "Your team's OKR/KPI form has been successfully published for the period of " . Carbon::parse($assignment->assignment_start_date)->format('F') . " . Wishing your team all the best as you take action to achieve this goal!",
                "data" => "kpi form published successfully",
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failure',
                'data' => $e->getMessage(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance',
                'line' => $e->getLine()
            ]);
        }
    }


    public function publishKpiform($kpiformid, $assignee_id, $reviewer_id, $department, $flow_type, $pms_assignment_id)
    {

        $validator = Validator::make(
            $data = [
                "vmt_pms_kpiform_v3_id" => $kpiformid,
                "assignee_id" => $assignee_id,
                "reviewer_id" => $reviewer_id,
                // "calendar_type" => $calender_type,
                // "year" => $year,
                // "frequency" => $frequency,
                // "assignment_period" => $assignment_period,
                "department_id" => $department,
                "flow_type" => $flow_type,
                "pms_assignment_id" => $pms_assignment_id
            ],
            $rules = [
                "vmt_pms_kpiform_v3_id" => 'required',
                "assignee_id" => "required",
                // "reviewer_id" => 'required',
                // "calendar_type" => 'required',
                // "year" => 'required',
                // "frequency" => 'required',
                // "assignment_period" => 'required',
                "department_id" => 'required',
                "flow_type" => 'required|in:1,2,3',
                "pms_assignment_id" => 'required'
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid"
            ]
        );


        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'
            ]);
        }

        try {
            if (VmtPmsKpiFormAssignedV3::where('assignee_id', $assignee_id)->where('vmt_pms_assignment_v3_id', $pms_assignment_id)->exists()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'This employee has already been allocated the OKR/ PMS form for the designated assignment period.'
                ]);
            }

            $get_current_assingement_setting = VmtPmsAssignmentV3::where('id', $pms_assignment_id)->first();
            $get_who_can_setgoal = json_decode($get_current_assingement_setting->who_can_set_goal, true);

            switch ($flow_type) {
                case "1":
                    $response = $this->publishOrgAppraisalForm($kpiformid, $assignee_id, $reviewer_id, $department, $flow_type, $pms_assignment_id);

                    break;
                case "2":
                    $response = $this->publishTeamAppraisalForm($kpiformid, $assignee_id, $reviewer_id, $department, $flow_type, $pms_assignment_id);
                    break;
                case "3":
                    if (in_array('EMP', $get_who_can_setgoal)) {
                        $response = $this->publishSelfAppraisalForm($kpiformid, $assignee_id, $reviewer_id, $department, $flow_type, $pms_assignment_id);
                    } else {
                        $setgoal_roles = implode(',', $get_who_can_setgoal);
                        return response()->json([
                            'status' => 'failure',
                            'message' => 'Goal assign permission only for ' . $setgoal_roles . '.',
                        ]);
                    }
                    break;
            }

            return $response;
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failure',
                'data' => $e->getMessage(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance',
                'line' => $e->getTraceAsString()
            ]);
        }
    }



    public function ApproveOrReject($user_code, $record_id, $status, $reviewer_comments)
    {

        // $record_id = '1';
        // $status = '1'; // approve or reject
        // $reviewer_comments = '';

        $validator = Validator::make(
            $data = [
                "user_code" => $user_code,
                "record_id" => $record_id,
                "status" => $status,
                "reviewer_comments" => $reviewer_comments
            ],
            $rules = [
                "user_code" => "required|exists:users,user_code",
                "record_id" => "required|exists:vmt_pms_kpiform_assigned_v3,id",
                "status" => "required|in:1,-1",
                "reviewer_comments" => "nullable"
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid",
                "in" => "Field :attribute is invalid"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'
            ]);
        }

        try {

            $user_id = User::where('user_code', $user_code)->first()->id;
            $get_record = VmtPmsKpiFormReviewsV3::join('vmt_pms_kpiform_assigned_v3', 'vmt_pms_kpiform_assigned_v3.id', '=', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id')
                ->where('vmt_pms_kpiform_assigned_v3.id', $record_id)->first();
            // dd($get_record);
            $reviewer_details = json_decode($get_record->reviewer_details, true);
            for ($i = 0; $i < count($reviewer_details); $i++) {
                if ($reviewer_details[$i]['reviewer_id'] == $user_id) {
                    $reviewer_details[$i]['is_accepted'] = $status;
                    $reviewer_details[$i]['acceptreject_date'] = carbon::now()->format('Y-m-d');
                    $reviewer_details[$i]['rejection_comments'] = $reviewer_comments;
                } else {
                    $reviewer_details[$i]['is_accepted'] = $status;
                }
            }

            $result = json_encode($reviewer_details);

            $approved_form = VmtPmsKpiFormReviewsV3::where('vmt_kpiform_assigned_v3_id', $get_record->vmt_kpiform_assigned_v3_id)->first();
            $approved_form->reviewer_details = $result;
            $approved_form->is_reviewer_accepted = $status;
            $approved_form->save();

            // mail manager approve / reject
            $mail_condition = $status == '1' ? 'approved' : 'rejected';
            $users_details = user::join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->where('user_id', $get_record->assignee_id)->first(['users.id', 'users.name', 'users.user_code', 'vmt_employee_office_details.hr_user_id', 'vmt_employee_office_details.officical_mail']);
            $managers_details = $this->getL1ManagerDetails($users_details->user_code);
            // $hr_details = $this->getL1ManagerDetails(user::where('id', $users_details->hr_user_id)->first()->user_code);
            $login_Link = request()->getSchemeAndHttpHost();
            $emp_avatar = json_decode(newgetEmployeeAvatarOrShortName($users_details->id), true);
            $emp_neutralgender = getGenderNeutralTerm($user_id);

            Mail::to($users_details->officical_mail)
                // ->cc($hr_details->officical_mail)
                ->queue(
                    new VmtPMSMail_Reviewer(
                        $mail_condition,
                        $users_details->name,
                        "2023",
                        "2023",
                        $managers_details->name,
                        $reviewer_comments,
                        $login_Link,
                        $emp_neutralgender,
                        $emp_avatar
                    )
                );

            return response()->json([
                "status" => "success",
                "message" => $status == '1' ? "Approved successfully" : "Rejected successfully",
            ]);
        } catch (TransportException $e) {
            return response()->json([
                "status" => "success",
                "message" => $status == '1' ? "Approved successfully. due to some techinal error mail not send" : "Rejected successfully. due to some techinal error mail not send",
                "mail_status" => "due to some techinal error mail not send",
                "data" => "kpi form published successfully",
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failure',
                'data' => $e->getMessage(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance',
                'line' => $e->getTraceAsString()
            ]);
        }
    }

    public function AcceptOrReject($user_id, $record_id, $status, $assignee_comments)
    {

        // $record_id = '1';
        // $status = '1'; // approve or reject
        // $reviewer_comments = '';

        $validator = Validator::make(
            $data = [
                "record_id" => $record_id,
                "status" => $status,
                "reviewer_comments" => $assignee_comments
            ],
            $rules = [
                "record_id" => "required|exists:vmt_pms_kpiform_assigned_v3,id",
                "status" => "required|in:1,-1",
                "reviewer_comments" => "nullable"
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid",
                "in" => "Field :attribute is invalid"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'
            ]);
        }

        try {

            $user_records = VmtPmsKpiFormReviewsV3::where('vmt_kpiform_assigned_v3_id', $record_id)->first();

            $user_records->is_assignee_accepted = $status;
            $user_records->assignee_acceptreject_date = Carbon::now()->format("Y-m-d");
            $user_records->assignee_rejection_comments = $assignee_comments;
            $user_records->save();

            // for mail
            $mail_condition = $status == '1' ? 'accepted' : 'rejected';
            $flowType = "2";
            $users_details = user::join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->where('user_id', $user_records->assignee_id)->first();
            $managers_details = $this->getL1ManagerDetails($users_details->user_code);
            $login_Link = request()->getSchemeAndHttpHost();
            $emp_avatar = json_decode(newgetEmployeeAvatarOrShortName($managers_details['user_id']), true);

            $emp_neutralgender = getGenderNeutralTerm($users_details->user_id);
            // dd($emp_neutralgender);
            // send mail to L1 manager
            $mail_status = Mail::to($users_details->officical_mail)->queue(new VmtPMSMail_Assignee($mail_condition, $flowType, $users_details->name, $users_details->year, $managers_details->name, '', $login_Link, $emp_avatar, $emp_neutralgender));

            return response()->json([
                "status" => "success",
                "data" => $status == '1' ? "Accepted successfully" : "rejected successfully",
                // "Mail_status" => $mail_status ? "Mail send successfully" : "Mail send failed some technical issue",
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => "failure",
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance',
                "error_verbose" => $e->getMessage(),
            ]);
        }
    }

    public function TeamAppraisalReviewerFlow($user_code, $date)
    {

        try {

            // if(is_array($assignment_setting_id)){
            //     foreach($assignment_setting_id as $single_vlaue){
            //         $array_assignment_id[] = ($single_vlaue['id']);
            //     }
            //  }else{
            //     $array_assignment_id =  [$assignment_setting_id];
            //  }

            $Explode_date =  explode(' - ', $date);

            $start_date = $Explode_date[0];
            $end_date = $Explode_date[1];

            $gt = VmtPmsKpiFormReviewsV3::join('vmt_pms_kpiform_assigned_v3', 'vmt_pms_kpiform_assigned_v3.id', '=', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id')
                ->join('vmt_pms_assignment_v3', 'vmt_pms_assignment_v3.id', '=', 'vmt_pms_kpiform_assigned_v3.vmt_pms_assignment_v3_id')
                ->join('vmt_pms_assignment_settings_v3', 'vmt_pms_assignment_settings_v3.id', '=', 'vmt_pms_assignment_v3.pms_assignment_settings_id')
                // ->whereIn('vmt_pms_assignment_settings_v3.id', $array_assignment_id)
                ->where('vmt_pms_kpiform_assigned_v3.goal_initiated_date','>=',Carbon::parse($start_date))
                ->where('vmt_pms_kpiform_assigned_v3.goal_initiated_date','<=',Carbon::parse($end_date)->endOfMonth())
                ->orderBy('vmt_pms_kpiform_assigned_v3.id', 'desc')
                ->get([
                    'vmt_pms_kpiform_assigned_v3.id as id',
                    'vmt_pms_kpiform_assigned_v3.assignee_id as assignee_id',
                    'vmt_pms_assignment_v3.assignment_period as assignment_period',
                    'vmt_pms_assignment_settings_v3.frequency as frequency',
                    'vmt_pms_assignment_v3.assignment_start_date',
                    'vmt_pms_assignment_v3.assignment_end_date',
                    'vmt_pms_kpiform_assigned_v3.vmt_pms_kpiform_v3_id as vmt_pms_kpiform_v3_id',
                    'vmt_pms_kpiform_assigned_v3.flow_type as flow_type',
                    'vmt_pms_kpiform_reviews_v3.is_assignee_accepted as is_assignee_accepted',
                    'vmt_pms_kpiform_reviews_v3.is_assignee_submitted as is_assignee_submitted',
                    'vmt_pms_kpiform_reviews_v3.assignee_kpi_review as assignee_kpi_review',
                    'vmt_pms_kpiform_reviews_v3.reviewer_details as reviewer_details',
                    'vmt_pms_kpiform_reviews_v3.is_reviewer_accepted as is_reviewer_accepted',
                    'vmt_pms_kpiform_reviews_v3.is_reviewer_submitted as is_reviewer_submitted',
                    'vmt_pms_kpiform_reviews_v3.reviewer_kpi_review as reviewer_kpi_review',
                    'vmt_pms_kpiform_reviews_v3.reviewer_kpi_percentage as reviewer_kpi_percentage',
                    'vmt_pms_kpiform_reviews_v3.reviewer_kpi_comments as reviewer_kpi_comments'
                ])
                ->toarray();
            // dd($gt);
            $user_id = user::where('user_code', $user_code)->first()->id;
            $getAllRecords = array();
            foreach ($gt as $key => $single_value) {
                // dd($single_value);
                $getAllRecords[$key]['id'] = $single_value['id'];
                $getAllRecords[$key]['assignee_id'] = $single_value['assignee_id'];
                $getAllRecords[$key]['assignee_name'] = user::where('id', $single_value['assignee_id'])->first()->name;
                $getAllRecords[$key]['avatar_or_shortname'] = json_decode(newgetEmployeeAvatarOrShortName($single_value['assignee_id']));
                $getAllRecords[$key]['assignee_code'] = user::where('id', $single_value['assignee_id'])->first()->user_code;
                $getAllRecords[$key]['score'] = $this->recordFormFinalKpiScore($single_value['id']);
                $getAllRecords[$key]['manager_name'] = $this->getL1ManagerDetails(User::where('id', $single_value['assignee_id'])->first()->user_code)['name'] ?? 'error';
                $getAllRecords[$key]['manager_code'] = $this->getL1ManagerDetails(User::where('id', $single_value['assignee_id'])->first()->user_code)['user_code'] ?? 'error';
                $getAllRecords[$key]['assignment_period'] = $this->getProcessedAssignmentPeriod($single_value['assignment_period'], $single_value['frequency'], $single_value['assignment_start_date'], $single_value['assignment_end_date']);
                $getAllRecords[$key]['is_assignee_accepted'] = $single_value['is_assignee_accepted'];
                $getAllRecords[$key]['is_assignee_submitted'] = $single_value['is_assignee_submitted'];
                $getAllRecords[$key]['assignee_kpi_review'] = json_decode($single_value['assignee_kpi_review'], true);
                $getAllRecords[$key]['reviewer_details'] = (json_decode($single_value['reviewer_details'], true));
                $getAllRecords[$key]['is_reviewer_accepted'] = $single_value['is_reviewer_accepted'];
                $getAllRecords[$key]['is_reviewer_submitted'] = $single_value['is_reviewer_submitted'];
                $getAllRecords[$key]['reviewer_kpi_review'] = json_decode($single_value['reviewer_kpi_review'], true);
                $getAllRecords[$key]['reviewer_kpi_percentage'] = $single_value['reviewer_kpi_percentage'];
                $getAllRecords[$key]['reviewer_kpi_comments'] = $single_value['reviewer_kpi_comments'];



                //Logic For Form Status
                if ($single_value['is_reviewer_accepted'] == '') {
                    $getAllRecords[$key]['status'] = 'Approval Pending';
                } else if ($single_value['is_reviewer_accepted'] == -1) {
                    $getAllRecords[$key]['status'] = 'Rejected';
                } else if ($single_value['is_assignee_accepted'] == '') {
                    $getAllRecords[$key]['status'] = 'Accept Pending';
                } elseif ($single_value['is_reviewer_accepted'] == '1' && $single_value['is_assignee_accepted'] == '1' && $single_value['is_assignee_submitted'] == '') {
                    $getAllRecords[$key]['status'] = 'Goal Published';
                } elseif ($single_value['is_assignee_submitted'] == '1' && $single_value['is_reviewer_submitted'] == '') {
                    $getAllRecords[$key]['status'] = 'Employee Self Reviewed';
                }else if($single_value['is_assignee_submitted'] == '1' && $single_value['is_reviewer_submitted'] == '1'){
                    $getAllRecords[$key]['status'] = 'Completed';
                }


                // dd($single_value);
                $form_header = VmtPmsKpiFormV3::where('id', $single_value['vmt_pms_kpiform_v3_id'])->first();
                // dd($form_header);
                $getAllRecords[$key]['form_header'] = json_decode($form_header->selected_headers, true);

                $form_details = VmtPmsKpiFormDetailsV3::where('vmt_pms_kpiform_v3_id', $single_value['vmt_pms_kpiform_v3_id'])
                    ->join('vmt_pms_kpiform_v3', 'vmt_pms_kpiform_v3.id', '=', 'vmt_pms_kpiform_details_v3.vmt_pms_kpiform_v3_id')
                    ->get(['vmt_pms_kpiform_details_v3.id', 'objective_values'])->toarray();

                $temp_arr = [];
                foreach ($form_details as $key1 => $single_value) {
                    $temp_arr[$key1] = json_decode($single_value['objective_values'], true);
                    $temp_arr[$key1]['id'] = $single_value['id'];
                }

                $getAllRecords[$key]['kpi_form_details'] = ['form_name' => $form_header->form_name, "form_id" => $form_header->id, 'form_details' => $temp_arr];
            }

            // return ($getAllRecords);
            //dd($getAllRecords);
            $pending_records = [];
            foreach ($getAllRecords as $single_record) {
                $arr = [];
                foreach ($single_record['reviewer_details'] as $key => $single_approvers) {
                    $arr[$single_approvers['review_order']] = $single_approvers;
                }

                foreach ($arr as $single_arr) {
                    if ($user_id == $single_arr['reviewer_id']) {
                        $current_user_order = $single_arr['review_order'];


                        if ($current_user_order == 1) {

                            // L1 manager  approve / reject flow
                            if (($arr[$current_user_order]['is_accepted'] == 0 || $arr[$current_user_order]['is_accepted'] == 1) && $single_record['is_assignee_submitted'] == '') {

                                array_push($pending_records, $single_record);

                                // L1 manager reviewer flow
                            } elseif (($arr[$current_user_order]['is_reviewed'] == 0 || $arr[$current_user_order]['is_reviewed'] == 1) && $single_record['is_assignee_submitted'] == '1') {
                                // dd($single_record);
                                $assigne_reviews = $single_record['assignee_kpi_review']['assignee_kpi'];
                                $L1reviews = $single_record['reviewer_kpi_review'][0]['reviewer_kpi'];
                                $assigne_details = user::where('id', $single_record['assignee_kpi_review']['assignee_id'])->first();
                                $L1reviwers_details = user::where('id', $single_record['reviewer_kpi_review'][0]['reviewer_id'])->first();

                                foreach ($single_record['kpi_form_details']['form_details'] as $key1 => $single_form) {

                                    if (($single_form['id'] == isset($assigne_reviews[$key1]['form_details_id']))) {
                                        $single_record['kpi_form_details']['form_details'][$key1]['assignee_review'] = array_merge($assigne_reviews[$key1], ['assignee_code' => $assigne_details->user_code, 'assignee_name' => $assigne_details->name, 'reviewer_level' => 'Self Review']) ?? $this->employee_achive;
                                    } else {
                                        $single_record['kpi_form_details']['form_details'][$key1]['assignee_review'] = array_merge($this->employee_achive, ['assignee_code' => $assigne_details->user_code, 'assignee_name' => $assigne_details->name, 'reviewer_level' => 'Self Review']);
                                    }

                                    if (!is_null($L1reviews)) {
                                        if (($single_form['id'] == isset($L1reviews[$key1]['form_details_id']))) {
                                            $single_record['kpi_form_details']['form_details'][$key1]['reviews_review'][] = array_merge($L1reviews[$key1], ['reviewer_code' => $L1reviwers_details->user_code, 'reviewer_name' => $L1reviwers_details->name, 'reviewer_level' => 'L1 Manager Reviews']) ?? $this->employee_achive;
                                        } else {
                                            $single_record['kpi_form_details']['form_details'][$key1]['reviews_review'][] = array_merge($this->employee_achive, ['reviewer_code' => $L1reviwers_details->user_code, 'reviewer_name' => $L1reviwers_details->name, 'reviewer_level' => 'L1 Manager Reviews']);
                                        }
                                    } else {
                                        $single_record['kpi_form_details']['form_details'][$key1]['reviews_review'][] = array_merge($this->employee_achive, ['reviewer_code' => $L1reviwers_details->user_code, "reviewer_name" => $L1reviwers_details->name, 'reviewer_level' => 'L1 Manager Reviews']);
                                    }
                                }

                                array_push($pending_records, $single_record);

                            }
                        } elseif ($current_user_order == 2) {

                            if ($arr[$current_user_order - 1]['is_reviewed'] == 1 && ($arr[$current_user_order]['is_reviewed'] == 0 || $arr[$current_user_order]['is_reviewed'] == 1) && $single_record['is_assignee_submitted'] == '1') {

                                $assigne_reviews = $single_record['assignee_kpi_review']['assignee_kpi'];
                                $L1reviews = $single_record['reviewer_kpi_review'][0]['reviewer_kpi'];
                                $L2reviews = $single_record['reviewer_kpi_review'][1]['reviewer_kpi'] ?? null;
                                $assigne_details = user::where('id', $single_record['assignee_kpi_review']['assignee_id'])->first();
                                $L1reviwers_details = user::where('id', $single_record['reviewer_kpi_review'][0]['reviewer_id'])->first();
                                $L2reviwers_details = user::where('id', $single_record['reviewer_kpi_review'][1]['reviewer_id'])->first();

                                foreach ($single_record['kpi_form_details']['form_details'] as $key1 => $single_form) {

                                    if (($single_form['id'] == isset($assigne_reviews[$key1]['form_details_id']))) {
                                        $single_record['kpi_form_details']['form_details'][$key1]['assignee_review'] = array_merge($assigne_reviews[$key1], ['assignee_code' => $assigne_details->user_code, 'assignee_name' => $assigne_details->name, 'reviewer_level' => 'Self Reviews']) ?? $this->employee_achive;
                                        $single_record['kpi_form_details']['form_details'][$key1]['reviews_review'][] = array_merge($L1reviews[$key1], ['reviewer_code' => $L1reviwers_details->user_code, 'reviewer_name' => $L1reviwers_details->name, 'reviewer_level' => 'L1 Manager Reviews']) ?? $this->employee_achive;
                                    } else {
                                        $single_record['kpi_form_details']['form_details'][$key1]['assignee_review'] = array_merge($this->employee_achive, ['assignee_code' => $assigne_details->user_code, 'assignee_name' => $assigne_details->name, 'reviewer_level' => 'Self Reviews']);
                                        $single_record['kpi_form_details']['form_details'][$key1]['reviews_review'][] = array_merge($this->employee_achive, ['reviewer_code' => $assigne_details->user_code, 'reviewer_name' => $assigne_details->name, 'reviewer_level' => 'L1 Manager Reviews']);
                                    }

                                    if (!is_null($L2reviews)) {
                                        if (($single_form['id'] == isset($L2reviews[$key1]['form_details_id']))) {
                                            $single_record['kpi_form_details']['form_details'][$key1]['reviews_review'][] = array_merge($L2reviews[$key1], ['reviewer_code' => $L2reviwers_details->user_code, 'reviewer_name' => $L2reviwers_details->name, 'reviewer_level' => 'L2 Manager Reviews']) ?? $this->employee_achive;
                                        } else {
                                            $single_record['kpi_form_details']['form_details'][$key1]['reviews_review'][] = array_merge($this->employee_achive, ['reviewer_code' => $L2reviwers_details->user_code, 'reviewer_name' => $L2reviwers_details->name, 'reviewer_level' => 'L2 Manager Reviews']);
                                        }
                                    } else {
                                        $single_record['kpi_form_details']['form_details'][$key1]['reviews_review'][] = array_merge($this->employee_achive, ['reviewer_code' => $L2reviwers_details->user_code, "reviewer_name" => $L2reviwers_details->name, 'reviewer_level' => 'L2 Manager Reviews']);
                                    }
                                }


                                array_push($pending_records, $single_record);
                            }

                        } elseif ($current_user_order == 3) {

                            // if (L2 manager reviewed) after L3 manager reviewer flow
                            if ($arr[$current_user_order - 1]['is_reviewed'] == 1 && ($arr[$current_user_order]['is_reviewed'] == 0 || $arr[$current_user_order]['is_reviewed'] == 1) && $single_record['is_assignee_submitted'] == '1') {

                                $assigne_reviews = $single_record['assignee_kpi_review']['assignee_kpi'];
                                $L1reviews = $single_record['reviewer_kpi_review'][0]['reviewer_kpi'];
                                $L2reviews = $single_record['reviewer_kpi_review'][1]['reviewer_kpi'] ?? null;
                                $L3reviews = $single_record['reviewer_kpi_review'][2]['reviewer_kpi'] ?? null;
                                $assigne_details = user::where('id', $single_record['assignee_kpi_review']['assignee_id'])->first();
                                $L1reviwers_details = user::where('id', $single_record['reviewer_kpi_review'][0]['reviewer_id'])->first();
                                $L2reviwers_details = user::where('id', $single_record['reviewer_kpi_review'][1]['reviewer_id'])->first();
                                $L3reviwers_details = user::where('id', $single_record['reviewer_kpi_review'][2]['reviewer_id'])->first();

                                foreach ($single_record['kpi_form_details']['form_details'] as $key1 => $single_form) {

                                    if (($single_form['id'] == isset($assigne_reviews[$key1]['form_details_id']))) {
                                        $single_record['kpi_form_details']['form_details'][$key1]['assignee_review'] = array_merge($assigne_reviews[$key1], ['assignee_code' => $assigne_details->user_code, 'assignee_name' => $assigne_details->name, 'reviewer_level' => 'Self Reviews']) ?? $this->employee_achive;
                                        $single_record['kpi_form_details']['form_details'][$key1]['reviews_review'][] = array_merge($L1reviews[$key1], ['reviewer_code' => $L1reviwers_details->user_code, 'reviewer_name' => $L1reviwers_details->name, 'reviewer_level' => 'L1 Manager Reviews']) ?? $this->employee_achive;
                                        $single_record['kpi_form_details']['form_details'][$key1]['reviews_review'][] = array_merge($L2reviews[$key1], ['reviewer_code' => $L2reviwers_details->user_code, 'reviewer_name' => $L2reviwers_details->name, 'reviewer_level' => 'L2 Manager Reviews']) ?? $this->employee_achive;
                                    } else {
                                        $single_record['kpi_form_details']['form_details'][$key1]['assignee_review'] = array_merge($this->employee_achive, ['assignee_code' => $assigne_details->user_code, 'assignee_name' => $assigne_details->name, 'reviewer_level' => 'Self Reviews']);
                                        $single_record['kpi_form_details']['form_details'][$key1]['reviews_review'][] = array_merge($this->employee_achive, ['reviewer_code' => $L1reviwers_details->user_code, 'reviewer_name' => $L1reviwers_details->name, 'reviewer_level' => 'L1 Manager Reviews']);
                                        $single_record['kpi_form_details']['form_details'][$key1]['reviews_review'][] = array_merge($this->employee_achive, ['reviewer_code' => $L2reviwers_details->user_code, 'reviewer_name' => $L2reviwers_details->name, 'reviewer_level' => 'L2 Manager Reviews']);
                                    }

                                    if (!is_null($L3reviews)) {
                                        if (($single_form['id'] == isset($L3reviews[$key1]['form_details_id']))) {
                                            $single_record['kpi_form_details']['form_details'][$key1]['reviews_review'][] = array_merge($L3reviews[$key1], ['reviewer_code' => $L3reviwers_details->user_code, 'reviewer_name' => $L3reviwers_details->name, 'reviewer_level' => 'L3 Manager Reviews']) ?? $this->employee_achive;
                                        } else {
                                            $single_record['kpi_form_details']['form_details'][$key1]['reviews_review'][] = array_merge($this->employee_achive, ['reviewer_code' => $L3reviwers_details->user_code, 'reviewer_name' => $L3reviwers_details->name, 'reviewer_level' => 'L3 Manager Reviews']);
                                        }
                                    } else {
                                        $single_record['kpi_form_details']['form_details'][$key1]['reviews_review'][] = array_merge($this->employee_achive, ['reviewer_code' => $L3reviwers_details->user_code, "reviewer_name" => $L3reviwers_details->name, 'reviewer_level' => 'L3 Manager Reviews']);
                                    }
                                }

                                array_push($pending_records, $single_record);
                            }

                        } elseif ($current_user_order == 4) {
                            if ($arr[$current_user_order - 1]['is_accepted'] == 1 && ($arr[$current_user_order]['is_accepted'] == 0 || $arr[$current_user_order]['is_accepted'] == 1) && $single_record['is_assignee_submitted'] == '') {
                                array_push($pending_records, 'simma');
                            }
                        }
                    }
                }
            }

            // dd($pending_records);

            return response()->json([
                "status" => "success",
                "data" => empty($pending_records) ? [] : $pending_records,

            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => "failure",
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance',
                "error_verbose" => $e->getMessage(),
                "error_line" => $e->getLine(),
            ]);
        }
    }

    // public function getAssignedPMSFormsList_selfAppraisal($user_code, $year, $assignment_period)
    // {

    //     try {
    //         $user = User::where('user_code', $user_code)->first();

    //         $gt = VmtPmsKpiFormReviewsV3::join('vmt_pms_kpiform_assigned_v3', 'vmt_pms_kpiform_assigned_v3.id', '=', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id')
    //             ->join('vmt_pms_assignment_v3', 'vmt_pms_assignment_v3.id', '=', 'vmt_pms_kpiform_assigned_v3.vmt_pms_assignment_v3_id')
    //             ->join('vmt_pms_assignment_settings_v3', 'vmt_pms_assignment_settings_v3.id', '=', 'vmt_pms_assignment_v3.pms_assignment_settings_id')
    //             ->where('vmt_pms_kpiform_assigned_v3.assignee_id', $user->id)
    //             ->where('vmt_pms_assignment_settings_v3.year', $year)
    //             ->where('vmt_pms_assignment_v3.assignment_period', $assignment_period)
    //             ->get([
    //                 'vmt_pms_kpiform_assigned_v3.id as id',
    //                 'vmt_pms_kpiform_assigned_v3.assignee_id as assignee_id',
    //                 'vmt_pms_assignment_v3.assignment_period as assignment_period',
    //                 'vmt_pms_assignment_settings_v3.frequency as frequency',
    //                 'vmt_pms_assignment_v3.assignment_start_date',
    //                 'vmt_pms_assignment_v3.assignment_end_date',
    //                 'vmt_pms_kpiform_assigned_v3.vmt_pms_kpiform_v3_id as vmt_pms_kpiform_v3_id',
    //                 'vmt_pms_kpiform_assigned_v3.flow_type as flow_type',
    //                 'vmt_pms_kpiform_reviews_v3.is_assignee_accepted as is_assignee_accepted',
    //                 'vmt_pms_kpiform_reviews_v3.is_assignee_submitted as is_assignee_submitted',
    //                 'vmt_pms_kpiform_reviews_v3.assignee_kpi_review as assignee_kpi_review',
    //                 'vmt_pms_kpiform_reviews_v3.reviewer_details as reviewer_details',
    //                 'vmt_pms_kpiform_reviews_v3.is_reviewer_accepted as is_reviewer_accepted',
    //                 'vmt_pms_kpiform_reviews_v3.is_reviewer_submitted as is_reviewer_submitted',
    //                 'vmt_pms_kpiform_reviews_v3.reviewer_kpi_review as reviewer_kpi_review',
    //                 'vmt_pms_kpiform_reviews_v3.reviewer_kpi_percentage as reviewer_kpi_percentage',
    //                 'vmt_pms_kpiform_reviews_v3.reviewer_kpi_comments as reviewer_kpi_comments'
    //             ])
    //             ->toarray();

    //         if (empty($gt)) {
    //             return response()->json([
    //                 "status" => "success",
    //                 "message" => "No records",
    //                 "data" => [],

    //             ]);
    //         }

    //         $getAllRecords = array();
    //         foreach ($gt as $key => $single_value) {
    //             $getAllRecords[$key]['id'] = $single_value['id'];
    //             $getAllRecords[$key]['assignee_id'] = $single_value['assignee_id'];
    //             $getAllRecords[$key]['assignee_name'] = user::where('id', $single_value['assignee_id'])->first()->name;
    //             $getAllRecords[$key]['assignee_code'] = user::where('id', $single_value['assignee_id'])->first()->user_code;
    //             $getAllRecords[$key]['manager_name'] = $this->getL1ManagerDetails(User::where('id', $single_value['assignee_id'])->first()->user_code)['name'] ?? 'error';
    //             $getAllRecords[$key]['assignment_period'] = $this->getProcessedAssignmentPeriod($single_value['assignment_period'], $single_value['frequency'], $single_value['assignment_start_date'], $single_value['assignment_end_date']);
    //             $getAllRecords[$key]['is_assignee_accepted'] = $single_value['is_assignee_accepted'];
    //             $getAllRecords[$key]['is_assignee_submitted'] = $single_value['is_assignee_submitted'];
    //             $getAllRecords[$key]['reviewer_details'] = (json_decode($single_value['reviewer_details'], true));
    //             $getAllRecords[$key]['is_reviewer_accepted'] = $single_value['is_reviewer_accepted'];
    //             $getAllRecords[$key]['is_reviewer_submitted'] = $single_value['is_reviewer_submitted'];

    //             //Logic For Form Status

    //             if ($single_value['flow_type'] == 3) {
    //                 if ($single_value['is_reviewer_accepted'] == 1) {
    //                     $getAllRecords[$key]['status'] = 'Goal Published';
    //                 } else if ($single_value['is_reviewer_accepted'] == -1) {
    //                     $getAllRecords[$key]['status'] = 'Rejected';
    //                 } else {
    //                     $getAllRecords[$key]['status'] = 'Approval Pending';
    //                 }
    //             } else if ($single_value['flow_type'] == 2) {
    //                 if ($single_value['is_assignee_accepted'] == 1) {
    //                     $getAllRecords[$key]['status'] = 'Accepted';
    //                 } else if ($single_value['is_assignee_accepted'] == -1) {
    //                     $getAllRecords[$key]['status'] = 'Rejected';
    //                 } else {
    //                     $getAllRecords[$key]['status'] = 'Accept Pending';
    //                 }
    //             } else if ($single_value['flow_type'] == 1) {
    //                 $getAllRecords[$key]['status'] = 'Goal Published';
    //             }
    //             $form_header = VmtPmsKpiFormV3::where('id', $single_value['vmt_pms_kpiform_v3_id'])->first();
    //             $getAllRecords[$key]['form_id'] = $form_header->id;
    //         }

    //         return response()->json([
    //             'status' => 'success',
    //             "data" => $getAllRecords,
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'failure',
    //             'message' => 'Error while fetching self Dashboard details',
    //             "error" => $e->getMessage() . ' | Line : ' . $e->getLine(),
    //             "error_verbose" => $e->getTraceAsString(),
    //         ]);
    //     }
    // }

    // public function getAssignedPMSFormsList_TeamAppraisal()
    // {

    // }

    // public function getAssignedPMSFormsList_orgAppraisal()
    // {

    // }


    public function getSelfAppraisalFormDetails($user_code, $date)
    {
        $validator = Validator::make(
            $data = [
                "user_code" => $user_code,
                "date" => $date
            ],
            $rules = [
                "user_code" => "required|exists:users,user_code",
                "date" => "required",
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid",
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'
            ]);
        }

        try {

            // if(is_array($assignment_setting_id)){
            //     foreach($assignment_setting_id as $single_vlaue){
            //         $array_assignment_id[] = ($single_vlaue['id']);
            //     }
            //  }else{
            //     $array_assignment_id =  [$assignment_setting_id];
            //  }

           $Explode_date =  explode(' - ', $date);

           $start_date = $Explode_date[0];
           $end_date = $Explode_date[1];

            $user = User::where('user_code', $user_code)->first();

            $gt = VmtPmsKpiFormReviewsV3::join('vmt_pms_kpiform_assigned_v3', 'vmt_pms_kpiform_assigned_v3.id', '=', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id')
                ->join('vmt_pms_assignment_v3', 'vmt_pms_assignment_v3.id', '=', 'vmt_pms_kpiform_assigned_v3.vmt_pms_assignment_v3_id')
                ->join('vmt_pms_assignment_settings_v3', 'vmt_pms_assignment_settings_v3.id', '=', 'vmt_pms_assignment_v3.pms_assignment_settings_id')
                ->where('vmt_pms_kpiform_assigned_v3.assignee_id', $user->id)
                ->where('vmt_pms_kpiform_assigned_v3.goal_initiated_date','>=',Carbon::parse($start_date))
                ->where('vmt_pms_kpiform_assigned_v3.goal_initiated_date','<=',Carbon::parse($end_date)->endOfMonth())
                ->orderBy('vmt_pms_kpiform_assigned_v3.id', 'desc')
                ->get([
                    'vmt_pms_kpiform_assigned_v3.id as id',
                    'vmt_pms_kpiform_assigned_v3.assignee_id as assignee_id',
                    'vmt_pms_assignment_v3.assignment_period as assignment_period',
                    'vmt_pms_assignment_settings_v3.frequency as frequency',
                    'vmt_pms_assignment_v3.assignment_start_date',
                    'vmt_pms_assignment_v3.assignment_end_date',
                    'vmt_pms_kpiform_assigned_v3.vmt_pms_kpiform_v3_id as vmt_pms_kpiform_v3_id',
                    'vmt_pms_kpiform_assigned_v3.flow_type as flow_type',
                    'vmt_pms_kpiform_reviews_v3.is_assignee_accepted as is_assignee_accepted',
                    'vmt_pms_kpiform_reviews_v3.is_assignee_submitted as is_assignee_submitted',
                    'vmt_pms_kpiform_reviews_v3.assignee_kpi_review as assignee_kpi_review',
                    'vmt_pms_kpiform_reviews_v3.reviewer_details as reviewer_details',
                    'vmt_pms_kpiform_reviews_v3.is_reviewer_accepted as is_reviewer_accepted',
                    'vmt_pms_kpiform_reviews_v3.is_reviewer_submitted as is_reviewer_submitted',
                    'vmt_pms_kpiform_reviews_v3.reviewer_kpi_review as reviewer_kpi_review',
                    'vmt_pms_kpiform_reviews_v3.reviewer_kpi_percentage as reviewer_kpi_percentage',
                    'vmt_pms_kpiform_reviews_v3.reviewer_kpi_comments as reviewer_kpi_comments'
                ])
                ->toarray();

            if (empty($gt)) {
                return response()->json([
                    "status" => "success",
                    "message" => "No records",
                    "data" => [],

                ]);
            }

            $getAllRecords = array();
            foreach ($gt as $key => $single_value) {
                $reviewer_details = json_decode($single_value['reviewer_details'], true);
                $user_details = user::where('id', $single_value['assignee_id'])->first();
                $getAllRecords[$key]['id'] = $single_value['id'];
                $getAllRecords[$key]['assignee_id'] = $single_value['assignee_id'];
                $getAllRecords[$key]['assignee_name'] = $user_details->name;
                $getAllRecords[$key]['avatar_or_shortname'] = json_decode(newgetEmployeeAvatarOrShortName($single_value['assignee_id']));
                $getAllRecords[$key]['assignee_code'] = $user_details->user_code;
                $getAllRecords[$key]['manager_name'] = $this->getL1ManagerDetails(User::where('id', $single_value['assignee_id'])->first()->user_code)['name'] ?? 'error';
                $getAllRecords[$key]['manager_code'] = $this->getL1ManagerDetails(User::where('id', $single_value['assignee_id'])->first()->user_code)['user_code'] ?? 'error';
                $getAllRecords[$key]['assignment_period'] = $this->getProcessedAssignmentPeriod($single_value['assignment_period'], $single_value['frequency'], $single_value['assignment_start_date'], $single_value['assignment_end_date']);
                $getAllRecords[$key]['is_assignee_accepted'] = $single_value['is_assignee_accepted'];
                $getAllRecords[$key]['is_assignee_submitted'] = $single_value['is_assignee_submitted'];
                $getAllRecords[$key]['assignee_kpi_review'] = json_decode($single_value['assignee_kpi_review'], true);
                $getAllRecords[$key]['reviewer_details'] = $reviewer_details;
                $getAllRecords[$key]['score'] = $this->recordFormFinalKpiScore($single_value['id']);
                $getAllRecords[$key]['is_reviewer_accepted'] = $single_value['is_reviewer_accepted'];
                $getAllRecords[$key]['is_reviewer_submitted'] = $single_value['is_reviewer_submitted'];
                $getAllRecords[$key]['reviewer_kpi_review'] = json_decode($single_value['reviewer_kpi_review'], true);
                $getAllRecords[$key]['reviewer_kpi_percentage'] = $single_value['reviewer_kpi_percentage'];
                $getAllRecords[$key]['reviewer_kpi_comments'] = $single_value['reviewer_kpi_comments'];

                //Logic For Form Status
                if ($single_value['is_reviewer_accepted'] == '') {
                    $getAllRecords[$key]['status'] = 'Approval Pending';
                } else if ($single_value['is_reviewer_accepted'] == -1) {
                    $getAllRecords[$key]['status'] = 'Rejected';
                } else if ($single_value['is_assignee_accepted'] == '') {
                    $getAllRecords[$key]['status'] = 'Accept Pending';
                } elseif ($single_value['is_reviewer_accepted'] == '1' && $single_value['is_assignee_accepted'] == '1' && $single_value['is_assignee_submitted'] == '') {
                    $getAllRecords[$key]['status'] = 'Goal Published';
                } elseif ($single_value['is_assignee_submitted'] == '1' && $single_value['is_reviewer_submitted'] == '') {
                    $getAllRecords[$key]['status'] = 'Employee Self Reviewed';
                }else if($single_value['is_assignee_submitted'] == '1' && $single_value['is_reviewer_submitted'] == '1'){
                    $getAllRecords[$key]['status'] = 'Completed';
                }

                // dd($single_value);
                $form_header = VmtPmsKpiFormV3::where('id', $single_value['vmt_pms_kpiform_v3_id'])->first();
                // dd($form_header);
                $getAllRecords[$key]['form_header'] = json_decode($form_header->selected_headers, true);

                $form_details = VmtPmsKpiFormDetailsV3::where('vmt_pms_kpiform_v3_id', $single_value['vmt_pms_kpiform_v3_id'])
                    ->join('vmt_pms_kpiform_v3', 'vmt_pms_kpiform_v3.id', '=', 'vmt_pms_kpiform_details_v3.vmt_pms_kpiform_v3_id')
                    ->get(['vmt_pms_kpiform_details_v3.id', 'objective_values'])->toarray();

                $temp_arr = [];
                foreach ($form_details as $key1 => $single_value) {
                    $temp_arr[$key1] = json_decode($single_value['objective_values'], true);
                    $temp_arr[$key1]['id'] = $single_value['id'];
                }

                $getAllRecords[$key]['kpi_form_details'] = ['form_name' => $form_header->form_name, 'form_id' => $form_header->id, 'form_details' => $temp_arr];
            }

            // return $getAllRecords;

            $self_array = [];
            foreach ($getAllRecords as $key => $single_record) {

                // show assignee created form
                if ($single_record['is_assignee_accepted'] == '1' && $single_record['is_reviewer_accepted'] == '') {

                    array_push($self_array, $single_record);

                    // show assignee accepted or rejected
                } else if ($single_record['is_reviewer_accepted'] == '1' && $single_record['is_assignee_accepted'] == '') {

                    array_push($self_array, $single_record);

                    // show assignee fill reviewer score
                } else if ($single_record['is_reviewer_accepted'] == '-1' && $single_record['is_assignee_accepted'] == '1') {

                    array_push($self_array, $single_record);

                } else if ($single_record['is_reviewer_accepted'] == '1' && $single_record['is_assignee_accepted'] == '1' && ($single_record['is_assignee_submitted'] == '' || $single_record['is_assignee_submitted'] == '1') && $single_record['is_reviewer_submitted'] == '') {

                    $users_details = User::where('id', $single_record['assignee_kpi_review']['assignee_id'])->first();
                    // dd($single_record);

                    if (!is_null($single_record['assignee_kpi_review']['assignee_kpi'])) {
                        $assigne_reviews = $single_record['assignee_kpi_review']['assignee_kpi'];

                        foreach ($single_record['kpi_form_details']['form_details'] as $key1 => $single_form) {
                            if (($single_form['id'] == isset($assigne_reviews[$key1]['form_details_id']))) {

                                $single_record['kpi_form_details']['form_details'][$key1]['assignee_review'] = array_merge($assigne_reviews[$key1], ['assignee_code' => $users_details->user_code, 'assignee_name' => $users_details->name, 'reviewer_level' => 'Self Review']) ?? $this->employee_achive;
                            } else {
                                $single_record['kpi_form_details']['form_details'][$key1]['assignee_review'] = array_merge($this->employee_achive, ['assignee_code' => $users_details->user_code, 'assignee_name' => $users_details->name, 'reviewer_level' => 'Self Review']);
                            }

                            // if(($single_form['id'] == isset($assigne_reviews[$key1]['form_details_id']))){

                            //     $single_record['kpi_form_details']['form_details'][$key1]['assignee_review'] = array_merge($assigne_reviews[$key1], ['assignee_code' => $users_details->user_code, 'assignee_name' => $users_details->name]) ?? $this->employee_achive;
                            // } else {
                            //     $single_record['kpi_form_details']['form_details'][$key1]['assignee_review'] = array_merge($this->employee_achive, ['assignee_code' => $users_details->user_code, 'assignee_name' => $users_details->name]);
                            // }
                        }
                    } else {

                        foreach ($single_record['kpi_form_details']['form_details'] as $key1 => $single_form) {
                            $single_record['kpi_form_details']['form_details'][$key1]['assignee_review'] = array_merge($this->employee_achive, ['assignee_code' => $users_details->user_code, "assignee_name" => $users_details->name, 'reviewer_level' => 'Self Review']);
                        }
                    }
                    array_push($self_array, $single_record);

                    // show reviewer reviews to assignee page
                } elseif ($single_record['is_reviewer_accepted'] == '1' && $single_record['is_assignee_accepted'] == '1' && $single_record['is_assignee_submitted'] == '1' && $single_record['is_reviewer_submitted'] == '1') {

                    $users_details = User::where('id', $single_record['assignee_kpi_review']['assignee_id'])->first();

                    if (!is_null($single_record['assignee_kpi_review']['assignee_kpi'])) {

                        $assigne_reviews = $single_record['assignee_kpi_review']['assignee_kpi'];
                        $reviewer_reviews = $single_record['reviewer_kpi_review'];
                        foreach ($single_record['kpi_form_details']['form_details'] as $key1 => $single_form) {

                            if (($single_form['id'] == isset($assigne_reviews[$key1]['form_details_id']))) {
                                $single_record['kpi_form_details']['form_details'][$key1]['assignee_review'] = array_merge($assigne_reviews[$key1], ['assignee_code' => $users_details->user_code, 'assignee_name' => $users_details->name, 'reviewer_level' => 'Self Review']) ?? $this->employee_achive;

                                foreach ($reviewer_reviews as $key5 => $single_reviews_details) {
                                    // dd($single_reviews_details);
                                    foreach ($single_reviews_details['reviewer_kpi'] as $key6 => $single_kpi_value) {
                                        $temp[$key6]['reviewer_code'] = $single_reviews_details['reviewer_user_code'];
                                        $temp[$key6]['reviewer_name'] = User::where('user_code', $single_reviews_details['reviewer_user_code'])->first()->name;
                                        $temp[$key6]['reviewer_level'] = $getAllRecords[$key]['reviewer_details'][$key5]['reviewer_level'] == 'HR' ? $getAllRecords[$key]['reviewer_details'][$key5]['reviewer_level'] . " Reviews" : $getAllRecords[$key]['reviewer_details'][$key5]['reviewer_level'] . " Manager Reviews";
                                        $temp[$key6]['form_details_id'] = $single_kpi_value['form_details_id'];
                                        $temp[$key6]['kpi_review'] = $single_kpi_value['kpi_review'];
                                        $temp[$key6]['kpi_percentage'] = $single_kpi_value['kpi_percentage'];
                                        $temp[$key6]['kpi_comments'] = $single_kpi_value['kpi_comments'];
                                    }
                                    $single_record['kpi_form_details']['form_details'][$key1]['reviews_review'][] = $temp[$key1];
                                }
                            }
                        }

                    } else {

                        foreach ($single_record['kpi_form_details']['form_details'] as $key1 => $single_form) {
                            $single_record['kpi_form_details']['form_details'][$key1]['assignee_review'] = array_merge($this->employee_achive, ['assignee_code' => $users_details->user_code, "assignee_name" => $users_details->name]);
                        }
                    }
                    array_push($self_array, $single_record);
                }
            }

            return response()->json([
                'status' => 'success',
                'data' => $self_array,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Error while fetching self Dashboard details',
                "error" => $e->getMessage() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getTraceAsString(),
            ]);
        }
    }

    public function getDashboardCardDetails_TeamAppraisal($user_code, $type)
    {

        if ($type == 2) {

            $user_details = User::where('user_code', $user_code)->first();

            $vmt_pms_assignment_v3_query = VmtPMSassignment_settings_v3::join('vmt_pms_assignment_v3', 'vmt_pms_assignment_v3.pms_assignment_settings_id', '=', 'vmt_pms_assignment_settings_v3.id')
                ->where('vmt_pms_assignment_settings_v3.client_id', $user_details->client_id)
                ->whereDate('vmt_pms_assignment_v3.assignment_start_date', '<=', Carbon::now())
                ->whereDate('vmt_pms_assignment_v3.assignment_end_date', '>=', Carbon::now())->first() ?? null;

            $employees = User::join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->where('vmt_employee_office_details.l1_manager_code', $user_code)->where('active', '1')->where('is_ssa', '0');

            $employee_count = $employees->get()->count();
            $employee_pluck_id = $employees->pluck('user_id')->toArray();

            $emp_goal_assigned = VmtPmsKpiFormAssignedV3::whereIn('assignee_id', $employee_pluck_id)->where('vmt_pms_assignment_v3_id', $vmt_pms_assignment_v3_query->id)->get()->count() ?? '0';
            $emp_self_reviewed = VmtPmsKpiFormReviewsV3::join('vmt_pms_kpiform_assigned_v3', 'vmt_pms_kpiform_assigned_v3.id', '=', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id')->whereIn('vmt_pms_kpiform_assigned_v3.assignee_id', $employee_pluck_id)->where('vmt_pms_assignment_v3_id', $vmt_pms_assignment_v3_query->id)
                ->where('is_assignee_submitted', '1')->get()->count();

            $emp_final_review = VmtPmsKpiFormReviewsV3::join('vmt_pms_kpiform_assigned_v3', 'vmt_pms_kpiform_assigned_v3.id', '=', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id')->whereIn('vmt_pms_kpiform_assigned_v3.assignee_id', $employee_pluck_id)->where('vmt_pms_assignment_v3_id', $vmt_pms_assignment_v3_query->id)
                ->where('is_reviewer_submitted', '1')->get()->count();

            $top_counters = [
                ["title" => "Employee Goals", "total_count" => $employee_count, "actual_count" => $emp_goal_assigned],
                ["title" => "Self review", "total_count" => $emp_goal_assigned, "actual_count" => $emp_self_reviewed],
                ["title" => "Employee Assessed", "total_count" => $emp_self_reviewed, "actual_count" => $emp_final_review],
                ["title" => "Final Score Published", "total_count" => $emp_final_review, "actual_count" => $emp_final_review],
            ];

        } elseif ($type == 1) {

            $users = User::where('is_ssa', '0')->where('active', '1');
            $users_id = $users->pluck('id')->toarray();
            $total_users = $users->get()->count();

            // dd($total_users);
            $vmt_pms_assignment_v3_query = VmtPMSassignment_settings_v3::join('vmt_pms_assignment_v3', 'vmt_pms_assignment_v3.pms_assignment_settings_id', '=', 'vmt_pms_assignment_settings_v3.id')
                ->whereDate('vmt_pms_assignment_v3.assignment_start_date', '<=', Carbon::now())
                ->whereDate('vmt_pms_assignment_v3.assignment_end_date', '>=', Carbon::now())->pluck('vmt_pms_assignment_v3.id');


            $emp_assigned_details = VmtPmsKpiFormReviewsV3::join('vmt_pms_kpiform_assigned_v3', 'vmt_pms_kpiform_assigned_v3.id', '=', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id')
                ->whereIn('vmt_pms_kpiform_assigned_v3.assignee_id', $users_id)
                ->whereIn('vmt_pms_assignment_v3_id', $vmt_pms_assignment_v3_query);

            $goal_initiated = $emp_assigned_details->get()->count();
            $goal_approvedaccepts = $emp_assigned_details->where('is_assignee_accepted', '1')->where('is_reviewer_accepted', '1')->get()->count();
            $goal_self_reviewed = $emp_assigned_details->where('is_assignee_submitted', '1')->get()->count();
            $goal_reviewer_reviewed = $emp_assigned_details->where('is_reviewer_submitted', '1')->get()->count();

            $top_counters = [
                ["title" => "Goals Initiated", "total_count" => $total_users, "actual_count" => $goal_initiated],
                ["title" => "Approvals", "total_count" => $goal_initiated, "actual_count" => $goal_approvedaccepts],
                ["title" => "Self-Review", "total_count" => $goal_approvedaccepts, "actual_count" => $goal_self_reviewed],
                ["title" => "Manager-Reivew", "total_count" => $goal_self_reviewed, "actual_count" => $goal_reviewer_reviewed],
                ["title" => "Final Score", "total_count" => $goal_reviewer_reviewed, "actual_count" => $goal_reviewer_reviewed],
            ];


        }

        return $top_counters;
    }

    public function saveAssigneeReview($assignee_user_code, $assigned_form_id, $assignee_reviews, $assignee_is_submitted)
    {

        $validator = Validator::make(
            $data = [
                "assignee_user_code" => $assignee_user_code,
                "assignee_reviews" => $assignee_reviews,
                "assignee_is_submitted" => $assignee_is_submitted,
                "assigned_form_id" => $assigned_form_id,
            ],
            $rules = [
                "assignee_user_code" => "required|exists:users,user_code",
                "assignee_reviews" => "required",
                "assignee_is_submitted" => "nullable",
                "assigned_form_id" => "required|exists:vmt_pms_kpiform_assigned_v3,id"
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid",
                "in" => "Field :attribute is invalid"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'
            ]);
        }

        try {


            $user_records = VmtPmsKpiFormReviewsV3::where('vmt_kpiform_assigned_v3_id', $assigned_form_id)->first();

            $assignee_kpi_reviews = json_decode($user_records->assignee_kpi_review, true);
            $assignee_kpi_reviews['assignee_kpi'] = $assignee_reviews;

            // dd(json_encode($assignee_kpi_reviews));

            /*
                Final JSON structure

                {
                    "form_details_id" : "",
                    "target": "",
                    "kpi_weightage": null,
                    "comments": null,
                },
            */
            $reviews_score = 0;
            foreach ($assignee_reviews as $single_reviewdetails) {
                $reviews_score += (int) $single_reviewdetails['kpi_percentage'];
            }

            $user_records->assignee_kpi_review = json_encode($assignee_kpi_reviews);
            $user_records->is_assignee_submitted = $assignee_is_submitted;
            $user_records->reviewer_score = $reviews_score;
            $user_records->assignee_reviewed_date = date("Y-m-d");
            $user_records->save();

            //  form publish mail to L1manager
            $user_id = User::where('user_code', $assignee_user_code)->first()->id;
            $users_details = user::join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->where('user_id', User::where('user_code', $assignee_user_code)->first()->id)->first();
            $managers_details = $this->getL1ManagerDetails($users_details->user_code);
            //   $hr_details = $this->getL1ManagerDetails(user::where('id', $users_details->hr_user_id)->first()->user_code);
            $login_Link = request()->getSchemeAndHttpHost();
            $comments_employee = '';
            $emp_avatar = json_decode(newgetEmployeeAvatarOrShortName($managers_details['user_id']), true);
            // dd($emp_avatar);
            $emp_neutralgender = getGenderNeutralTerm($user_id);
            $flow_type = "2";
            // send mail to L1 manager
            if ($assignee_is_submitted == "1") {
                $sent_mail = Mail::to($managers_details['officical_mail'])
                    //   ->cc($hr_details['officical_mail'])
                    ->queue(
                        new VmtPMSMail_Assignee(
                            "completed",
                            $flow_type,
                            $users_details->name,
                            "2023",
                            $managers_details['name'],
                            $comments_employee,
                            $login_Link,
                            $emp_avatar,
                            $emp_neutralgender
                        )
                    );
            }

            return response()->json([
                'status' => 'success',
                'message' => $assignee_is_submitted == '1' ? "Assignee review has been submitted successfully" : "Saved Draft",
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance',
                "error" => $e->getMessage() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getTraceAsString(),
            ], 400);
        }
    }


    public function saveReviewsReview($reviewer_user_code, $assigned_form_id, $reviewer_review, $reviewer_is_submited)
    {

        $validator = Validator::make(
            $data = [
                "reviewer_user_code" => $reviewer_user_code,
                "reviewer_review" => $reviewer_review,
                "reviewer_is_submited" => $reviewer_is_submited,
                "assigned_form_id" => $assigned_form_id,
            ],
            $rules = [
                "reviewer_user_code" => "required|exists:users,user_code",
                "reviewer_review" => "required",
                "reviewer_is_submited" => "required",
                "assigned_form_id" => "required|exists:vmt_pms_kpiform_assigned_v3,id"
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid",
                "in" => "Field :attribute is invalid"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'
            ]);
        }

        try {

            $reviewer = user::where('user_code', $reviewer_user_code)->first();
            $reviewer_records = VmtPmsKpiFormReviewsV3::where('vmt_kpiform_assigned_v3_id', $assigned_form_id)->first();
            $get_assign_records = VmtPmsKpiFormAssignedV3::where('id', $reviewer_records->vmt_kpiform_assigned_v3_id)->first();
            $get_assign_v3 = VmtPmsAssignmentV3::where('id', $get_assign_records->vmt_pms_assignment_v3_id)->first();
            $get_settings_details = VmtPMSassignment_settings_v3::where('id', $get_assign_v3->pms_assignment_settings_id)->first();
            $decode_reviews = json_decode($reviewer_records->reviewer_kpi_review, true);
            $reviewers_details = json_decode($reviewer_records->reviewer_details, true);

            $reviews_score = 0;
            $count = 0;
            foreach ($reviewer_review as $single_reviewdetails) {
                $reviews_score += (int) $single_reviewdetails['kpi_percentage'];
                $count++;
            }

            for ($i = 0; $i < count($decode_reviews); $i++) {
                if ($decode_reviews[$i]['reviewer_user_code'] == $reviewer_user_code) {
                    $decode_reviews[$i]['reviewer_kpi'] = $reviewer_review;
                }
            }

            for ($i = 0; $i < count($reviewers_details); $i++) {
                if ($reviewers_details[$i]['reviewer_user_code'] == $reviewer_user_code) {
                    $reviewers_details[$i]['is_reviewed'] = $reviewer_is_submited;
                    $reviewers_details[$i]['reviewer_score'] = $reviews_score;
                    $reviewers_details[$i]['reviewed_date'] = Carbon::now()->format('Y-m-d');
                }
            }

            $reviewer_records->reviewer_kpi_review = json_encode($decode_reviews);
            $reviewer_records->reviewer_details = json_encode($reviewers_details);
            $reviewer_records->save();

            // if check all reviewer reviewed is_reviewed column "1" ;

            $reviewed_record = VmtPmsKpiFormReviewsV3::where('vmt_kpiform_assigned_v3_id', $assigned_form_id)->first();

            $reviewer_detail = collect(json_decode($reviewed_record->reviewer_details, true));
            $check_reviews = $reviewer_detail->where('is_reviewed', '1')->count();
            if (count($reviewer_detail) == $check_reviews) {
                $reviewed_record->is_reviewer_submitted = "1";
                $reviewed_record->save();
            }

            //  form publish mail to employee
            $reviewers = user::where('user_code', $reviewer_user_code)->first();
            $reviewer_office_details = VmtEmployeeOfficeDetails::where('user_id', $reviewers->id)->first();
            $assigne_details = user::join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->where('user_id', $reviewer_records->assignee_id)->first();
            $reviewers_details = $this->getL1ManagerDetails($reviewer_user_code);
            //  $hr_details = $this->getL1ManagerDetails(user::where('id', $assigne_details->hr_user_id)->first()->user_code);
            $login_Link = request()->getSchemeAndHttpHost();
            $comments_employee = '';
            $emp_avatar = json_decode(newgetEmployeeAvatarOrShortName($reviewer_records->assignee_id), true);
            $reviewer_neutralgender = getGenderNeutralTerm($reviewers->id);
            // send mail to employee
            if ($reviewer_is_submited == "1") {
                \Mail::to($assigne_details->officical_mail)
                    ->cc($reviewer_office_details->officical_mail)
                    ->send(
                        new VmtPMSMail_Reviewer(
                            "completed",
                            $assigne_details->name,
                            "2023",
                            "Apr 2023 - Mar 2024",
                            $reviewers->name,
                            "",
                            $login_Link,
                            $reviewer_neutralgender,
                            $emp_avatar
                        )
                    );
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Reviewer review has been submitted successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'Line' => $e->getLine(),
            ]);
        }

    }

    /*
        Fetch data from the following table,
            vmt_pms_settings_v3
            vmt_pms_assignment_settings_v3
            vmt_pms_assignment_v3
            vmt_pms_notify_settings_v3
            vmt_default_configs_v3

    */
    public function getPmsConfigSettings($client_code)
    {


        $validator = Validator::make(
            $data = [
                "client_code" => $client_code
            ],
            $rules = [
                "client_code" => 'required|exists:vmt_client_master,client_code',
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'Error while fetching PMS config details'
            ]);
        }

        try {

            $client_id = VmtClientMaster::where('client_code', $client_code)->first()->id;

            $vmt_pms_assignment_v3_query = VmtPMSassignment_settings_v3::join('vmt_pms_assignment_v3', 'vmt_pms_assignment_v3.pms_assignment_settings_id', '=', 'vmt_pms_assignment_settings_v3.id')
                ->where('vmt_pms_assignment_settings_v3.client_id', $client_id)
                ->whereDate('vmt_pms_assignment_v3.assignment_start_date', '<=', Carbon::now())
                ->whereDate('vmt_pms_assignment_v3.assignment_end_date', '>=', Carbon::now())->first() ?? null;

            if ($vmt_pms_assignment_v3_query != null) {

                //basic setting
                $get_basic_setting_arr['can_assign_upcoming_goals'] = $vmt_pms_assignment_v3_query->can_assign_upcoming_goals;
                $get_basic_setting_arr['annual_score_cal_method'] = $vmt_pms_assignment_v3_query->annual_score_calc_method;
                $get_basic_setting_arr['can_emp_proceed_nextpms_wo_currpms_completion'] = $vmt_pms_assignment_v3_query->can_emp_proceed_next_pms;
                $get_basic_setting_arr['can_org_proceed_nextpms_wo_currpms_completion'] = $vmt_pms_assignment_v3_query->can_org_proceed_next_pms;

                //pms_dashboard_page
                $pms_dashboard_page['can_show_overall_score_in_selfappr_dashboard'] = $vmt_pms_assignment_v3_query->show_overall_score_self_app_scrn;
                $pms_dashboard_page['can_show_rating_card_in_review_page'] = $vmt_pms_assignment_v3_query->show_rating_card_review_page;
                $pms_dashboard_page['can_show_overall_scr_card_in_review_page'] = $vmt_pms_assignment_v3_query->show_overall_scr_review_page;

                //notify setting
                $notify_setting['can_alert_emp_bfr_duedate'] = json_decode($vmt_pms_assignment_v3_query->notif_emp_bfr_duedate, true);
                $notify_setting['can_alert_emp_for_overduedate'] = json_decode($vmt_pms_assignment_v3_query->notif_emp_for_overduedate, true);
                $notify_setting['can_alert_mgr_bfr_duedate'] = json_decode($vmt_pms_assignment_v3_query->notif_mgr_bfr_duedate, true);
                $notify_setting['can_alert_mgr_for_overduedate'] = json_decode($vmt_pms_assignment_v3_query->notif_mgr_for_overduedate, true);

                // pms metrics
                $pms_metrics['pms_metrics'] = json_decode($vmt_pms_assignment_v3_query->selected_headers, true);

                // pms rating score cards
                $pms_rating_score_cards['score_card'] = json_decode($vmt_pms_assignment_v3_query->pms_rating_card, true);

                // pms calender setting
                $pms_calendar_settings['calendar_type'] = $vmt_pms_assignment_v3_query->calendar_type;
                $pms_calendar_settings['current_year'] = $vmt_pms_assignment_v3_query->current_year;
                $pms_calendar_settings['frequency'] = $vmt_pms_assignment_v3_query->frequency;


                //goal_settings
                $goal_settings['who_can_set_goal'] = json_decode($vmt_pms_assignment_v3_query->who_can_set_goal, true);
                $goal_settings['final_kpi_score_based_on'] = $vmt_pms_assignment_v3_query->final_kpi_score_based_on;
                $goal_settings['should_mgr_appr_rej_goals'] = $vmt_pms_assignment_v3_query->should_mgr_appr_rej_goals;
                $goal_settings['should_emp_acp_rej_goals'] = $vmt_pms_assignment_v3_query->should_emp_acp_rej_goals;
                $goal_settings['duedate_goal_initiate'] = $vmt_pms_assignment_v3_query->duedate_goal_settigns;
                $goal_settings['duedate_approval_acceptance'] = $vmt_pms_assignment_v3_query->duedate_emp_mgr_approval;
                $goal_settings['duedate_self_review'] = $vmt_pms_assignment_v3_query->duedate_self_review;
                $goal_settings['duedate_mgr_review'] = $vmt_pms_assignment_v3_query->duedate_mgr_review;
                $goal_settings['duedate_hr_review'] = $vmt_pms_assignment_v3_query->duedate_hr_review;
                $goal_settings['reviewers_flow'] = json_decode($vmt_pms_assignment_v3_query->reviewers_flow, true);

                // response
                $response['pms_basic_settings'] = $get_basic_setting_arr;
                $response['pms_dashboard_page'] = $pms_dashboard_page;
                $response['remainder_alert'] = $notify_setting;
                $response['pms_calendar_settings'] = $pms_calendar_settings;
                $response['goal_settings'] = $goal_settings;
                $response['score_card'] = $pms_rating_score_cards;
                $response['pms_metrics'] = $pms_metrics;
                // $response['can_freeze_calender_sett'] = "1";

                return $response;
            } else {

                return $this->getDefaultConfigSetting();
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Error while fetching PMS config data',
                'error' => $e->getMessage(),
                'line' => $e->getLine()
            ]);
        }
    }

    public function savePmsConfigSetting($pms_calendar_settings, $pms_basic_settings, $pms_dashboard_page, $remainder_alert, $pms_metrics, $goal_settings, $score_card, $client_id, $assignment_id)
    {

        $validator = Validator::make(
            $data = [
                "client_id" => $client_id,
                "can_assign_upcoming_goals" => $pms_basic_settings['can_assign_upcoming_goals'],
                "annual_score_cal_method" => $pms_basic_settings['annual_score_cal_method'],
                "can_emp_proceed_nextpms_wo_currpms_completion" => $pms_basic_settings['can_emp_proceed_nextpms_wo_currpms_completion'],
                "can_org_proceed_nextpms_wo_currpms_completion" => $pms_basic_settings['can_org_proceed_nextpms_wo_currpms_completion'],
                "can_show_overall_score_in_selfappr_dashboard" => $pms_dashboard_page['can_show_overall_score_in_selfappr_dashboard'],
                "can_show_rating_card_in_review_page" => $pms_dashboard_page['can_show_rating_card_in_review_page'],
                "can_show_overall_scr_card_in_review_page" => $pms_dashboard_page['can_show_overall_scr_card_in_review_page'],
                "can_alert_emp_bfr_duedate" => $remainder_alert['can_alert_emp_bfr_duedate'],
                "can_alert_emp_for_overduedate" => $remainder_alert['can_alert_emp_for_overduedate'],
                "can_alert_mgr_bfr_duedate" => $remainder_alert['can_alert_mgr_bfr_duedate'],
                "can_alert_mgr_for_overduedate" => $remainder_alert['can_alert_mgr_for_overduedate'],
                "pms_metrics" => $pms_metrics,
                "score_card" => $score_card,
                "calendar_type" => $pms_calendar_settings['calendar_type'],
                "current_year" => $pms_calendar_settings['year'],
                "frequency" => $pms_calendar_settings['frequency'],
                "who_can_set_goal" => $goal_settings['who_can_set_goal'],
                "final_kpi_score_based_on" => $goal_settings['final_kpi_score_based_on'],
                "should_mgr_appr_rej_goals" => $goal_settings['should_mgr_appr_rej_goals'],
                "should_emp_acp_rej_goals" => $goal_settings['should_emp_acp_rej_goals'],
                "duedate_goal_initiate" => $goal_settings['duedate_goal_initiate'],
                "duedate_approval_acceptance" => $goal_settings['duedate_approval_acceptance'],
                "duedate_self_review" => $goal_settings['duedate_self_review'],
                "duedate_mgr_review" => $goal_settings['duedate_mgr_review'],
                "duedate_hr_review" => $goal_settings['duedate_hr_review'],
                "reviewers_flow" => $goal_settings['reviewers_flow'],
            ],
            $rules = [
                "client_id" => 'required|exists:vmt_client_master,id',
                "can_assign_upcoming_goals" => 'required|in:auto,manual',
                "annual_score_cal_method" => 'required|in:average,sum',
                "can_emp_proceed_nextpms_wo_currpms_completion" => 'required|in:0,1',
                "can_org_proceed_nextpms_wo_currpms_completion" => 'required|in:0,1',
                "can_show_overall_score_in_selfappr_dashboard" => 'required|in:0,1',
                "can_show_rating_card_in_review_page" => 'required|in:0,1',
                "can_show_overall_scr_card_in_review_page" => 'required|in:0,1',
                "can_alert_emp_bfr_duedate" => 'required|array',
                "can_alert_emp_for_overduedate" => 'required|array',
                "can_alert_mgr_bfr_duedate" => 'required|array',
                "can_alert_mgr_for_overduedate" => 'required|array',
                "pms_metrics" => 'required|array',
                "score_card" => 'required|array',
                "calendar_type" => 'required|in:financial_year,calendar_year',
                // "current_year" => 'required',
                "frequency" => 'required|in:weekly,monthly,quarterly,half_yearly,yearly',
                "who_can_set_goal" => 'required|array',
                "final_kpi_score_based_on" => 'required|in:L1,L2,L3,HR',
                "should_mgr_appr_rej_goals" => 'required|in:0,1',
                "should_emp_acp_rej_goals" => 'required|in:0,1',
                "duedate_goal_initiate" => 'required|integer',
                "duedate_approval_acceptance" => 'required|integer',
                "duedate_self_review" => 'required|integer',
                "duedate_mgr_review" => 'required|integer',
                "duedate_hr_review" => 'required|integer',
                "reviewers_flow" => 'required|array',

            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid",
                "array" => "Field :attribute is datatype mismatch",
                "in" => "Field :attribute should have the following values : :values .",
                "integer" => "Field :attribute should be integer",
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => $validator->errors()->all()
            ]);
        }

        try {


            if (!is_int($pms_calendar_settings['assignment_period'])) {

                if(VmtPMSassignment_settings_v3::where('client_id',$client_id)
                ->where('year',Carbon::parse(explode(' - ',$pms_calendar_settings['cal_type_full_year'])[0])
                ->format('Y'))->exists())
                {
                    return [
                        'status' => 'warning',
                        'message' => 'already settigns here in the given frequency year',
                    ];
                }

                $vmtpms_assignment_settings = new VmtPMSassignment_settings_v3;
                $vmtpms_assignment_settings->client_id = $client_id;
                $vmtpms_assignment_settings->calendar_type = $pms_calendar_settings['calendar_type'];
                $vmtpms_assignment_settings->year = Carbon::parse(explode(' - ',$pms_calendar_settings['cal_type_full_year'])[0])->format('Y');
                $vmtpms_assignment_settings->frequency = $pms_calendar_settings['frequency'];
                $vmtpms_assignment_settings->pms_rating_card = json_encode($score_card) ?? null;
                $vmtpms_assignment_settings->can_assign_upcoming_goals = $pms_basic_settings['can_assign_upcoming_goals'] ?? null;
                $vmtpms_assignment_settings->annual_score_calc_method = $pms_basic_settings['annual_score_cal_method'] ?? null;
                $vmtpms_assignment_settings->can_emp_proceed_next_pms = $pms_basic_settings['can_emp_proceed_nextpms_wo_currpms_completion'] ?? null;
                $vmtpms_assignment_settings->can_org_proceed_next_pms = $pms_basic_settings['can_org_proceed_nextpms_wo_currpms_completion'] ?? null;
                $vmtpms_assignment_settings->show_overall_score_self_app_scrn = $pms_dashboard_page['can_show_overall_score_in_selfappr_dashboard'] ?? null;
                $vmtpms_assignment_settings->show_rating_card_review_page = $pms_dashboard_page['can_show_rating_card_in_review_page'] ?? null;
                $vmtpms_assignment_settings->show_overall_scr_review_page = $pms_dashboard_page['can_show_overall_scr_card_in_review_page'] ?? null;
                $vmtpms_assignment_settings->save();

                $setting_assignment_generator = $this->pmsKpiAssingmentGenerator($vmtpms_assignment_settings->calendar_type, $vmtpms_assignment_settings->frequency);
                foreach ($setting_assignment_generator as $key => $value) {

                    $vmt_assigment_setting = new VmtPmsAssignmentV3;
                    $vmt_assigment_setting->pms_assignment_settings_id = $vmtpms_assignment_settings->id;
                    $vmt_assigment_setting->assignment_period = $value['assignment_period'];
                    $vmt_assigment_setting->assignment_start_date = Carbon::parse($value['assignment_start_date']);
                    $vmt_assigment_setting->assignment_end_date = Carbon::parse($value['assignment_end_date']);
                    // $vmt_assigment_setting->active = $active ?? '0';
                    $vmt_assigment_setting->selected_headers = json_encode($pms_metrics) ?? null;
                    $vmt_assigment_setting->who_can_set_goal = json_encode($goal_settings['who_can_set_goal']) ?? null;
                    $vmt_assigment_setting->final_kpi_score_based_on = $goal_settings['final_kpi_score_based_on'] ?? null;
                    $vmt_assigment_setting->should_mgr_appr_rej_goals = $goal_settings['should_mgr_appr_rej_goals'] ?? null;
                    $vmt_assigment_setting->should_emp_acp_rej_goals = $goal_settings['should_emp_acp_rej_goals'] ?? null;
                    $vmt_assigment_setting->duedate_goal_initiate = $goal_settings['duedate_goal_initiate'] ?? null;
                    $vmt_assigment_setting->duedate_emp_mgr_approval = $goal_settings['duedate_approval_acceptance'] ?? null;
                    $vmt_assigment_setting->duedate_self_review = $goal_settings['duedate_self_review'] ?? null;
                    $vmt_assigment_setting->duedate_mgr_review = $goal_settings['duedate_mgr_review'] ?? null;
                    $vmt_assigment_setting->duedate_hr_review = $goal_settings['duedate_hr_review'] ?? null;
                    $vmt_assigment_setting->reviewers_flow = json_encode($goal_settings['reviewers_flow']) ?? null;
                    $vmt_assigment_setting->notif_emp_bfr_duedate = json_encode($remainder_alert['can_alert_emp_bfr_duedate']) ?? null;
                    $vmt_assigment_setting->notif_emp_for_overduedate = json_encode($remainder_alert['can_alert_emp_for_overduedate']) ?? null;
                    $vmt_assigment_setting->notif_mgr_bfr_duedate = json_encode($remainder_alert['can_alert_mgr_bfr_duedate']) ?? null;
                    $vmt_assigment_setting->notif_mgr_for_overduedate = json_encode($remainder_alert['can_alert_mgr_for_overduedate']) ?? null;
                    $vmt_assigment_setting->save();
                }
            } else {

                $vmtpms_assignment_settings = VmtPMSassignment_settings_v3::where('year', Carbon::parse(explode(' - ',$pms_calendar_settings['cal_type_full_year'])[0])->format('Y'))->where('client_id', $client_id)->first();

                $vmtpms_assignment_settings->pms_rating_card = json_encode($score_card) ?? null;
                $vmtpms_assignment_settings->can_assign_upcoming_goals = $pms_basic_settings['can_assign_upcoming_goals'] ?? null;
                $vmtpms_assignment_settings->annual_score_calc_method = $pms_basic_settings['annual_score_cal_method'] ?? null;
                $vmtpms_assignment_settings->can_emp_proceed_next_pms = $pms_basic_settings['can_emp_proceed_nextpms_wo_currpms_completion'] ?? null;
                $vmtpms_assignment_settings->can_org_proceed_next_pms = $pms_basic_settings['can_org_proceed_nextpms_wo_currpms_completion'] ?? null;
                $vmtpms_assignment_settings->show_overall_score_self_app_scrn = $pms_dashboard_page['can_show_overall_score_in_selfappr_dashboard'] ?? null;
                $vmtpms_assignment_settings->show_rating_card_review_page = $pms_dashboard_page['can_show_rating_card_in_review_page'] ?? null;
                $vmtpms_assignment_settings->show_overall_scr_review_page = $pms_dashboard_page['can_show_overall_scr_card_in_review_page'] ?? null;
                $vmtpms_assignment_settings->save();

                $assignment_v3 = VmtPmsAssignmentV3::where('id', $pms_calendar_settings['assignment_period'])->first();

                // $assignment_v3->active = $active ?? '0';
                $assignment_v3->selected_headers = json_encode($pms_metrics) ?? null;
                $assignment_v3->who_can_set_goal = json_encode($goal_settings['who_can_set_goal']) ?? null;
                $assignment_v3->final_kpi_score_based_on = $goal_settings['final_kpi_score_based_on'] ?? null;
                $assignment_v3->should_mgr_appr_rej_goals = $goal_settings['should_mgr_appr_rej_goals'] ?? null;
                $assignment_v3->should_emp_acp_rej_goals = $goal_settings['should_emp_acp_rej_goals'] ?? null;
                $assignment_v3->duedate_goal_initiate = $goal_settings['duedate_goal_initiate'] ?? null;
                $assignment_v3->duedate_emp_mgr_approval = $goal_settings['duedate_approval_acceptance'] ?? null;
                $assignment_v3->duedate_self_review = $goal_settings['duedate_self_review'] ?? null;
                $assignment_v3->duedate_mgr_review = $goal_settings['duedate_mgr_review'] ?? null;
                $assignment_v3->duedate_hr_review = $goal_settings['duedate_hr_review'] ?? null;
                $assignment_v3->reviewers_flow = json_encode($goal_settings['reviewers_flow']) ?? null;
                $assignment_v3->notif_emp_bfr_duedate = json_encode($remainder_alert['can_alert_emp_bfr_duedate']) ?? null;
                $assignment_v3->notif_emp_for_overduedate = json_encode($remainder_alert['can_alert_emp_for_overduedate']) ?? null;
                $assignment_v3->notif_mgr_bfr_duedate = json_encode($remainder_alert['can_alert_mgr_bfr_duedate']) ?? null;
                $assignment_v3->notif_mgr_for_overduedate = json_encode($remainder_alert['can_alert_mgr_for_overduedate']) ?? null;
                $assignment_v3->save();

            }

            return response()->json([
                "status" => "success",
                "message" => "config saved successfully",
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "This pertains to a system error; please reach out to your HR team for additional assistance",
                'error' => $e->getMessage(),
                'line' => $e->getLine()
            ]);
        }
    }


    private function pmsKpiAssingmentGenerator($calendar_type, $frequency)
    {

        // $calendar_type = 'financial_year';
        // $frequency = 'weekly';

        if ($calendar_type == 'calendar_year') {
            if ($frequency == 'weekly') {
                $date_range = CarbonPeriod::create(Carbon::now()->startOfYear(), '1 week', Carbon::now()->endOfYear());
            } elseif ($frequency == 'monthly') {
                $date_range = CarbonPeriod::create(Carbon::now()->startOfYear(), '1 month', Carbon::now()->endOfYear());
            } elseif ($frequency == 'quarterly') {
                $date_range = CarbonPeriod::create(Carbon::now()->startOfYear(), '4 month', Carbon::now()->endOfYear());
            } elseif ($frequency == 'half_yearly') {
                $date_range = CarbonPeriod::create(Carbon::now()->startOfYear(), '6 month', Carbon::now()->endOfYear());
            } elseif ($frequency == 'yearly') {
                $date_range = CarbonPeriod::create(Carbon::now()->startOfYear(), '12 month', Carbon::now()->endOfYear());
            }
        } elseif ($calendar_type == 'financial_year') {

            $financial_year = VmtOrgTimePeriod::where('status', '1')->first();

            if ($frequency == 'weekly') {
                $date_range = CarbonPeriod::create(Carbon::parse($financial_year->start_date), '1 week', Carbon::parse($financial_year->end_date));
            } elseif ($frequency == 'monthly') {
                $date_range = CarbonPeriod::create(Carbon::parse($financial_year->start_date), '1 month', Carbon::parse($financial_year->end_date));
            } elseif ($frequency == 'quarterly') {
                $date_range = CarbonPeriod::create(Carbon::parse($financial_year->start_date), '4 month', Carbon::parse($financial_year->end_date));
            } elseif ($frequency == 'half_yearly') {
                $date_range = CarbonPeriod::create(Carbon::parse($financial_year->start_date), '6 month', Carbon::parse($financial_year->end_date));
            } elseif ($frequency == 'yearly') {
                $date_range = CarbonPeriod::create(Carbon::parse($financial_year->start_date), '12 month', Carbon::parse($financial_year->end_date));
            }
        }

        $calender_type = [];
        foreach ($date_range as $key => $single_value) {
            if ($frequency == 'weekly') {
                $temp['assignment_period'] = "W" . $key + 1;
                $temp['assignment_start_date'] = $single_value->format('d-m-Y');
                $temp['assignment_end_date'] = $single_value->addDay(6)->format('d-m-Y');
            } elseif ($frequency == 'monthly') {
                $temp['assignment_period'] = "M" . $key + 1;
                $temp['assignment_start_date'] = $single_value->format('d-m-Y');
                $temp['assignment_end_date'] = $single_value->endOfMonth()->format('d-m-Y');
            } elseif ($frequency == 'quarterly') {
                $temp['assignment_period'] = "Q" . $key + 1;
                $temp['assignment_start_date'] = $single_value->format('d-m-Y');
                $temp['assignment_end_date'] = $single_value->addMonths(3)->endOfMonth()->format('d-m-Y');
            } elseif ($frequency == 'half_yearly') {
                $temp['assignment_period'] = "H" . $key + 1;
                $temp['assignment_start_date'] = $single_value->format('d-m-Y');
                $temp['assignment_end_date'] = $single_value->addMonths(5)->endOfMonth()->format('d-m-Y');
            } elseif ($frequency == 'yearly') {
                $temp['assignment_period'] = "Y" . $key + 1;
                $temp['assignment_start_date'] = $single_value->format('d-m-Y');
                $temp['assignment_end_date'] = $single_value->addMonths(11)->endOfMonth()->format('d-m-Y');
            }
            array_push($calender_type, $temp);
        }
        return ($calender_type);
    }

    private function getEmployeeCardDetails($user_code)
    {

        $validator = Validator::make(
            $data = [
                "user_code" => $user_code
            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'
            ]);
        }

        try {

            $users_query = User::where('user_code', $user_code)->first();
            $manager_query = $this->getL1ManagerDetails($users_query->user_code);

            $user_id = $users_query->id;
            $vmt_pms_assignment_v3_query = VmtPMSassignment_settings_v3::join('vmt_pms_assignment_v3', 'vmt_pms_assignment_v3.pms_assignment_settings_id', '=', 'vmt_pms_assignment_settings_v3.id')
                ->where('vmt_pms_assignment_settings_v3.client_id', $users_query->client_id)
                ->whereDate('vmt_pms_assignment_v3.assignment_start_date', '<=', Carbon::now())
                ->whereDate('vmt_pms_assignment_v3.assignment_end_date', '>=', Carbon::now())->first();

            $response['name'] = $users_query->name;
            $response['user_code'] = $users_query->user_code;
            $response['designation'] = VmtEmployeeOfficeDetails::where('user_id', $user_id)->first()->designation;
            $response['reporting_manager'] = $manager_query['name'] ?? null;
            $response['reporting_manager_usercode'] = $manager_query['user_code'] ?? null;

            if ($vmt_pms_assignment_v3_query->calendar_type == 'financial_year') {
                $response['review_period'] = 'Apr-' . $vmt_pms_assignment_v3_query->year . ' - Mar-' . Carbon::parse('01-01-' . $vmt_pms_assignment_v3_query->year)->addYear()->format('Y');
            } else if ($vmt_pms_assignment_v3_query->calendar_type == 'calendar_year') {
                $response['review_period'] = 'Jan-' . $vmt_pms_assignment_v3_query->year . ' - Dec-' . $vmt_pms_assignment_v3_query->year;
            }
            $response['avatar_or_shortname'] = json_decode(newgetEmployeeAvatarOrShortName($user_id));


            return $response;
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failure',
                'data' => null,
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance',
                'error' => $e->getMessage()
            ]);
        }
    }

    private function getCurrentRatingDetails_selfAppraisal($user_code, $assinged_record_id)
    {

        $validator = Validator::make(
            $data = [
                "user_code" => $user_code,
            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'
            ]);
        }

        if (empty($assinged_record_id)) {

            $users_query = User::where('user_code', $user_code)->first();
            $user_id = $users_query->id;
            $vmt_pms_assignment_v3_query = VmtPMSassignment_settings_v3::join('vmt_pms_assignment_v3', 'vmt_pms_assignment_v3.pms_assignment_settings_id', '=', 'vmt_pms_assignment_settings_v3.id')
                ->where('vmt_pms_assignment_settings_v3.client_id', $users_query->client_id)
                ->whereDate('vmt_pms_assignment_v3.assignment_start_date', '<=', Carbon::now())
                ->whereDate('vmt_pms_assignment_v3.assignment_end_date', '>=', Carbon::now())->first();
        } else {

            $get_assigned_form = VmtPmsKpiFormAssignedV3::join('vmt_pms_kpiform_reviews_v3', 'vmt_pms_kpiform_assigned_v3.id', '=', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id')
                ->where('vmt_pms_kpiform_assigned_v3.id', $assinged_record_id)->first();
            $user_details = User::where('id', $get_assigned_form->assignee_id)->first();
            $user_id = $user_details->id;
            $vmt_pms_assignment_v3_query = VmtPMSassignment_settings_v3::join('vmt_pms_assignment_v3', 'vmt_pms_assignment_v3.pms_assignment_settings_id', '=', 'vmt_pms_assignment_settings_v3.id')
                ->where('vmt_pms_assignment_v3.id', $get_assigned_form->vmt_pms_assignment_v3_id)->first();
        }
        // dd($vmt_pms_assignment_v3_query);

        $response['frequency'] = ucfirst($vmt_pms_assignment_v3_query->frequency) ?? null;
        $response['period'] = $this->getProcessedAssignmentPeriod($vmt_pms_assignment_v3_query->assignment_period, $vmt_pms_assignment_v3_query->frequency, $vmt_pms_assignment_v3_query->assignment_start_date, $vmt_pms_assignment_v3_query->assignment_end_date);
        $response['score'] = $this->getKPIFinalReviewScore($user_id, $vmt_pms_assignment_v3_query->id);

        return $response;
    }

    /*
        Get the final review score for the given user for the given assignment period.
        It is also based on the final score settings in PMS settings

    */
    public function getKPIFinalReviewScore($user_id, $vmt_pms_assignment_v3_query_id)
    {

        $get_assignment = VmtPmsKpiFormAssignedV3::join('vmt_pms_kpiform_reviews_v3', 'vmt_pms_kpiform_assigned_v3.id', '=', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id')
            ->where('vmt_pms_kpiform_assigned_v3.assignee_id', $user_id)->where('vmt_pms_kpiform_assigned_v3.vmt_pms_assignment_v3_id', $vmt_pms_assignment_v3_query_id)
            ->first() ?? null;
        $status = [
            'self_score' => '0',
            'l1_reviewers_score' => '0',
            'l2_reviewers_score' => '0',
            'l3_reviewers_score' => '0',
            'hr_score' => '0'
        ];

        if ($get_assignment != null) {

            $reviewer_details = json_decode($get_assignment->reviewer_details, true);

            if ($get_assignment->is_assignee_submitted == '1') {
                $status["self_score"] = $get_assignment->reviewer_score;

                foreach ($reviewer_details as $single_details) {
                    if ($single_details['reviewer_level'] == 'L1') {
                        $status["l1_reviewers_score"] = $single_details['reviewer_score'];
                    } else if ($single_details['reviewer_level'] == 'L2') {
                        $status["l2_reviewers_score"] = $single_details['reviewer_score'];
                    } else if ($single_details['reviewer_level'] == 'L3') {
                        $status["l3_reviewers_score"] = $single_details['reviewer_score'];
                    } else if ($single_details['reviewer_level'] == 'HR') {
                        $status["hr_score"] = $single_details['reviewer_score'];
                    }
                }
                return $status;
            } else {
                return $status;
            }
        } else {
            return $status;
        }
    }

    private function getOverallRatingsDetails($user_code, $assignment_setting_id)
    {

        $validator = Validator::make(
            $data = [
                "user_code" => $user_code,
                "assignment_setting_id" => $assignment_setting_id,
            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',
                "assignment_setting_id" => 'required',
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'
            ]);
        }

        $users_query = User::where('user_code', $user_code)->first();
        $user_id = $users_query->id;
        $get_pmsassignment_settings = VmtPMSassignment_settings_v3::where('client_id', $users_query->client_id)->where('id', $assignment_setting_id)->first();
        $get_assingmentv3 = VmtPmsAssignmentV3::where('pms_assignment_settings_id', $get_pmsassignment_settings->id)->pluck('vmt_pms_assignment_v3.id');

        $overall_ratings = $this->overall_AnnualScore($user_id, $get_assingmentv3, $get_pmsassignment_settings->pms_rating_card);

        $response['overall_perform_rating'] = $overall_ratings;

        return $response;
    }


    public function overall_AnnualScore($user_id, $vmt_pms_assignment_v3_query, $pms_rating_card)
    {

        $get_assigned_form = VmtPmsKpiFormAssignedV3::join('vmt_pms_kpiform_reviews_v3', 'vmt_pms_kpiform_assigned_v3.id', '=', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id')
            ->whereIn('vmt_pms_assignment_v3_id', $vmt_pms_assignment_v3_query)->where('vmt_pms_kpiform_assigned_v3.assignee_id', $user_id)
            ->where('vmt_pms_kpiform_reviews_v3.is_reviewer_submitted', '1')->get()->toarray();
        $kpi_score = 0;
        $i = 0;
        if (!empty($get_assigned_form)) {
            foreach ($get_assigned_form as $single_form_details) {
                $final_kpi_score = VmtPmsAssignmentV3::where('id', $single_form_details['vmt_pms_assignment_v3_id'])->first()->final_kpi_score_based_on;
                $json_details = json_decode($single_form_details['reviewer_details'], true);

                $collct_reviewer = collect($json_details)->where('reviewer_level', $final_kpi_score);

                if (empty($collct_reviewer->toArray())) {
                    return [
                        'status' => 'failure',
                        'massage' => "can't find final reviewer " . $final_kpi_score . ". please set valid reviewer",
                    ];
                }

                foreach ($json_details as $single_reviewer) {
                    if ($single_reviewer['reviewer_level'] == $final_kpi_score) {
                        if ($single_reviewer['is_reviewed'] == '1') {
                            $kpi_score += (int) $single_reviewer['reviewer_score'];
                            $i++;
                        }
                    }
                }

                $Annual_kpi_score = $kpi_score / $i;

                $decode_rating = json_decode($pms_rating_card, true);

                if (count($decode_rating) > 0) {
                    foreach ($decode_rating as $ratings) {
                        $rangeCheck = explode('-', $ratings['score_range']);

                        if ($Annual_kpi_score >= $rangeCheck[0] && $Annual_kpi_score <= $rangeCheck[1]) {
                            $rank = $ratings['ranking'];
                            $performanceRating = $ratings['performance_rating'];
                            $action = $ratings['action'];
                            break;
                        } elseif ($Annual_kpi_score >= 100) {
                            $rank = $ratings['ranking'];
                            $performanceRating = $ratings['performance_rating'];
                            $action = $ratings['action'];
                            break;
                        }
                    }
                }
            }
        } else {
            $Annual_kpi_score = 0;
            $rank = 0;
            $performanceRating = 0;
            $action = 0;
        }
        $response['annual_score'] = round($Annual_kpi_score);
        $response['rank'] = $rank ?? null;
        $response['perfomance'] = $performanceRating ?? null;
        $response['action'] = $action ?? null;

        return $response;


    }

    public function getAssignedTimelineDetails($assigned_form_id)
    {

        $validator = Validator::make(
            $data = [
                "assigned_form_id" => $assigned_form_id
            ],
            $rules = [
                "assigned_form_id" => 'nullable',
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'Error while fetching the form timeline data'
            ]);
        }


        try {


            $json_timeline_flow_type_1 = [
                'Goal Published' => ['title' => 'Goal Published', 'expected_date' => '', 'actual_date' => '', 'is_overdue' => '0', 'status' => '0'],
                'Self-Review' => ['title' => 'Self-Review', 'expected_date' => '', 'actual_date' => '', 'is_overdue' => '0', 'status' => '0'],
                'Manager-Review' => ['title' => 'Manager-Review', 'expected_date' => '', 'actual_date' => '', 'is_overdue' => '0', 'status' => '0'],
                'l2_Manager-Review' => ['title' => 'L2-Manager-Review', 'expected_date' => '', 'actual_date' => '', 'is_overdue' => '0', 'status' => '0'],
                'l3_Manager-Review' => ['title' => 'L3-Manager-Review', 'expected_date' => '', 'actual_date' => '', 'is_overdue' => '0', 'status' => '0'],
                'HR-Review' => ['title' => 'HR-Review', 'expected_date' => '', 'actual_date' => '', 'is_overdue' => '0', 'status' => '0']
            ];

            $json_timeline_flow_type_2 = [
                'Goal Published' => ['title' => 'Goal Published', 'expected_date' => '', 'actual_date' => '', 'is_overdue' => '0', 'status' => '0'],
                'Employee-Accepted' => ['title' => 'Employee-Accepted', 'expected_date' => '', 'actual_date' => '', 'is_overdue' => '0', 'status' => '0'],
                'Self-Review' => ['title' => 'Self-Review', 'expected_date' => '', 'actual_date' => '', 'is_overdue' => '0', 'status' => '0'],
                'Manager-Review' => ['title' => 'Manager-Review', 'expected_date' => '', 'actual_date' => '', 'is_overdue' => '0', 'status' => '0'],
                'l2_Manager-Review' => ['title' => 'L2-Manager-Review', 'expected_date' => '', 'actual_date' => '', 'is_overdue' => '0', 'status' => '0'],
                'l3_Manager-Review' => ['title' => 'L3-Manager-Review', 'expected_date' => '', 'actual_date' => '', 'is_overdue' => '0', 'status' => '0'],
                'HR-Review' => ['title' => 'HR-Review', 'expected_date' => '', 'actual_date' => '', 'is_overdue' => '0', 'status' => '0']
            ];


            $json_timeline_flow_type_3 = [
                'Goal Published' => ['title' => 'Goal Published', 'expected_date' => '', 'actual_date' => '', 'is_overdue' => '0', 'status' => '0'],
                'Manager-Approval' => ['title' => 'Manager-Approval', 'expected_date' => '', 'actual_date' => '', 'is_overdue' => '0', 'status' => '0'],
                'Self-Review' => ['title' => 'Self-Review', 'expected_date' => '', 'actual_date' => '', 'is_overdue' => '0', 'status' => '0'],
                'Manager-Review' => ['title' => 'Manager-Review', 'expected_date' => '', 'actual_date' => '', 'is_overdue' => '0', 'status' => '0'],
                'l2_Manager-Review' => ['title' => 'L2-Manager-Review', 'expected_date' => '', 'actual_date' => '', 'is_overdue' => '0', 'status' => '0'],
                'l3_Manager-Review' => ['title' => 'L3-Manager-Review', 'expected_date' => '', 'actual_date' => '', 'is_overdue' => '0', 'status' => '0'],
                'HR-Review' => ['title' => 'HR-Review', 'expected_date' => '', 'actual_date' => '', 'is_overdue' => '0', 'status' => '0']
            ];

            if (empty($assigned_form_id)) {
                $flow_type = 3;
            } else {

                $query_assignedform_details = VmtPmsKpiFormAssignedV3::find($assigned_form_id);

                $flow_type = $query_assignedform_details->flow_type;
            }

            $response = '';

            if ($flow_type == 1) {

                $data = $this->getSelfAppraisalFormTimeline_details($json_timeline_flow_type_1, $assigned_form_id);
            }
            if ($flow_type == 2) {

                $data = $this->getSelfAppraisalFormTimeline_details($json_timeline_flow_type_2, $assigned_form_id);
            }
            if ($flow_type == 3) {

                $data = $this->getSelfAppraisalFormTimeline_details($json_timeline_flow_type_3, $assigned_form_id);
            }

            return $data;

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Error while fetching the form timeline data',
                'error' => $e->getMessage(),
                'line' => $e->getLine()
            ]);
        }
    }

    public function getSelfAppraisalFormTimeline_details($flow_type, $assigned_form_id)
    {

        $validator = Validator::make(
            $data = [
                "flow_type" => $flow_type,
                "assigned_form_id" => $assigned_form_id
            ],
            $rules = [
                "flow_type" => 'nullable',
                "assigned_form_id" => 'nullable',
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'Error while fetching the form timeline data'
            ]);
        }


        try {

            $assigned_form_status = array();
            if (empty($assigned_form_id)) {

                // getAssignmentPeriodDropdown($user_code);

                // $expected_complete_date = VmtPmsAssignmentV3::where('id',$assigned_records->vmt_pms_assignment_v3_id)->first() ?? null;

                $timeline_flow_deadlines = [
                    'Goal Published' => $duedate_goal_initiate ?? null,
                    'Manager-Approval' => $duedate_emp_mgr_approval ?? null,
                    'Self-Review' => $duedate_self_review ?? null,
                    'Manager-Review' => $duedate_mgr_review ?? null,
                    'HR-Review' => $duedate_hr_review ?? null,
                ];

                // dd($timeline_flow_deadlines);
                $j = 0;

                foreach ($flow_type as $flow_key => $single_flow_type) {

                    if (in_array($flow_key, array_keys($timeline_flow_deadlines))) {

                        $assigned_form_status[$j] = $flow_type[$flow_key];
                        $assigned_form_status[$j]['expected_date'] = $timeline_flow_deadlines[$flow_key] ?? '';
                        if ($flow_key == 'Goal Published') {
                            $assigned_form_status[$j]['status'] = 0;
                        } else {
                            $assigned_form_status[$j]['status'] = -1;
                        }
                    }
                    $j++;
                }

                return $assigned_form_status;
            }


            //Check whether the timeline related settings(Due dates) are available in PMS settings
            $assigned_records = VmtPmsKpiFormAssignedV3::join('vmt_pms_kpiform_reviews_v3', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id', '=', 'vmt_pms_kpiform_assigned_v3.id')->where('vmt_pms_kpiform_assigned_v3.id', $assigned_form_id)->first() ?? null;

            $expected_complete_date = VmtPmsAssignmentV3::where('id', $assigned_records->vmt_pms_assignment_v3_id)->first() ?? null;

            $error_array = [];

            if (empty($expected_complete_date->duedate_goal_initiate))
                array_push($error_array, 'Due Date : Goal Initiate');
            if (empty($expected_complete_date->duedate_emp_mgr_approval))
                array_push($error_array, 'Due Date : Approval/Acceptance');
            if (empty($expected_complete_date->duedate_self_review))
                array_push($error_array, 'Due Date : Self Review');
            if (empty($expected_complete_date->duedate_mgr_review))
                array_push($error_array, 'Due Date : Manager Review');
            if (empty($expected_complete_date->duedate_hr_review))
                array_push($error_array, 'Due Date : HR Review');

            //If any of the due date settings are not set , then throw error
            if (count($error_array) > 0) {

                return response()->json([
                    'status' => 'failure',
                    'message' => 'Unable to show form timeline since due dates are not set for the below options. Kindly set them PMS Settings page.\n',
                    'data' => $error_array
                ], 400);

            }

            $start_date_of_month = Carbon::parse($expected_complete_date->assignment_start_date);
            $end_date_of_month = Carbon::parse($expected_complete_date->assignment_end_date);
            $current_date = Carbon::now()->format('d-M-Y');


            $duedate_goal_initiate = "";
            $duedate_emp_mgr_approval = "";

            $duedate_goal_initiate = $start_date_of_month->clone()->addDays($expected_complete_date->duedate_goal_initiate)->format('d-M-Y');
            $duedate_emp_mgr_approval = $start_date_of_month->clone()->addDays($expected_complete_date->duedate_goal_initiate + $expected_complete_date->duedate_emp_mgr_approval)->format('d-M-Y');
            $duedate_self_review = $end_date_of_month->clone()->subDays($expected_complete_date->duedate_self_review)->format('d-M-Y');
            $duedate_mgr_review = Carbon::createFromFormat('d-M-Y', $duedate_self_review)->addDays($expected_complete_date->duedate_mgr_review)->format('d-M-Y');
            $duedate_hr_review = Carbon::createFromFormat('d-M-Y', $duedate_mgr_review)->addDays($expected_complete_date->duedate_hr_review)->format('d-M-Y');

            $goal_initiated_date = VmtPmsKpiFormAssignedV3::where('id', $assigned_form_id);
            $form_approve_details = VmtPmsKpiFormReviewsV3::where('vmt_kpiform_assigned_v3_id', $assigned_form_id)->first();

            $form_review_details = json_decode($form_approve_details->reviewer_details, true);

            $hr_manager_reviewed_date = "";
            $L1_manager_reviewed_date = "";
            $L2_manager_reviewed_date = "";
            $L3_manager_reviewed_date = "";


            //  dd($form_review_details);
            $reviewer_array = array();
            array_push($reviewer_array, 'Employee-Accepted', 'Goal Published', 'Manager-Approval', 'Self-Review');

            foreach ($form_review_details as $key => $single_review_details) {

                if ($single_review_details['reviewer_level'] == 'L1') {

                    $L1_manager_approved_date = $single_review_details['acceptreject_date'];
                    $L1_manager_reviewed_date = $single_review_details['is_reviewed'] == 1 ? $single_review_details['reviewed_date'] : '';
                    $L1_manager_reviewed_status = $single_review_details['is_reviewed'];
                    $L1_manager_accepted_status = $single_review_details['is_accepted'];

                    array_push($reviewer_array, 'Manager-Review');
                }


                if ($single_review_details['reviewer_level'] == 'L2') {

                    $L2_manager_approved_date = $single_review_details['acceptreject_date'];
                    $L2_manager_reviewed_date = $single_review_details['is_reviewed'] == 1 ? $single_review_details['reviewed_date'] : '';
                    $L2_manager_reviewed_status = $single_review_details['is_reviewed'];
                    array_push($reviewer_array, 'l2_Manager-Review');
                }

                if ($single_review_details['reviewer_level'] == 'L3') {

                    $L3_manager_approved_date = $single_review_details['acceptreject_date'];
                    $L3_manager_reviewed_date = $single_review_details['is_reviewed'] == 1 ? $single_review_details['reviewed_date'] : '';
                    $L3_manager_reviewed_status = $single_review_details['is_reviewed'];
                    array_push($reviewer_array, 'l3_Manager-Review');
                }

                if ($single_review_details['reviewer_level'] == 'HR') {

                    $hr_manager_reviewed_date = $single_review_details['is_reviewed'] == 1 ? $single_review_details['reviewed_date'] : '';
                    array_push($reviewer_array, 'HR-Review');
                }

            }

            if ($goal_initiated_date->exists()) {

                $goal_initiated_date = $goal_initiated_date->first();
            }

            $goal_published_status = "";
            $manager_approval_status = "";
            $self_review_status = "";
            $manager_review_status = "";
            $hr_review_status = "";
            $employee_accepted_status = "";
            $i = 0;

            // return ($reviewer_array);

            foreach ($flow_type as $flow_key => $single_flow_type) {

                if (in_array($flow_key, $reviewer_array)) {


                    if ($flow_key == "Goal Published") {

                        $actual_date = !empty($goal_initiated_date->goal_initiated_date) ? Carbon::parse($goal_initiated_date->goal_initiated_date)->format('d-M-Y') : '';

                        $is_overdue = !empty($actual_date) ? $actual_date > $duedate_goal_initiate ? 1 : 0 : 0;

                        $assigned_form_status[$i] = $flow_type[$flow_key];
                        $assigned_form_status[$i] = $flow_type[$flow_key];
                        $assigned_form_status[$i]['expected_date'] = $duedate_goal_initiate ?? '';
                        $assigned_form_status[$i]['actual_date'] = $actual_date;
                        $assigned_form_status[$i]['is_overdue'] = $is_overdue;
                        $assigned_form_status[$i]['status'] = !empty($goal_initiated_date->goal_initiated_date) ? 1 : 0;

                        $goal_published_status = $assigned_form_status[$i]['status'];
                    }

                    if ($flow_key == "Manager-Approval") {

                        $approve_actual_date = !empty($L1_manager_approved_date) ? Carbon::parse($L1_manager_approved_date)->format('d-M-Y') : '';
                        $is_overdue = !empty($approve_actual_date) ? $approve_actual_date > $duedate_emp_mgr_approval ? 1 : 0 : 0;

                        $assigned_form_status[$i] = $flow_type[$flow_key];
                        $assigned_form_status[$i] = $flow_type[$flow_key];
                        $assigned_form_status[$i]['expected_date'] = $duedate_emp_mgr_approval ?? '';
                        $assigned_form_status[$i]['actual_date'] = $approve_actual_date;
                        $assigned_form_status[$i]['is_overdue'] = $is_overdue;
                        $assigned_form_status[$i]['status'] = $goal_published_status == 1 ? $L1_manager_accepted_status == 1 ? 1 : 0 : -1;

                        $manager_approval_status = $assigned_form_status[$i]['status'];
                    }


                    if ($flow_key == "Employee-Accepted") {

                        $emp_actual_date = !empty($form_approve_details->assignee_acceptreject_date) ? Carbon::parse($form_approve_details->assignee_acceptreject_date)->format('d-M-Y') : '';
                        $is_overdue = !empty($actual_date) ? $emp_actual_date > $duedate_emp_mgr_approval ? 1 : 0 : 0;

                        $assigned_form_status[$i] = $flow_type[$flow_key];
                        $assigned_form_status[$i] = $flow_type[$flow_key];
                        $assigned_form_status[$i]['expected_date'] = $duedate_emp_mgr_approval ?? '';
                        $assigned_form_status[$i]['actual_date'] = $emp_actual_date;
                        $assigned_form_status[$i]['is_overdue'] = $is_overdue;
                        $assigned_form_status[$i]['status'] = $goal_published_status == 1 ? ($form_approve_details->is_assignee_accepted == 1 ? 1 : 0) : -1;
                        $employee_accepted_status = $assigned_form_status[$i]['status'];
                    }


                    if ($flow_key == "Self-Review") {

                        $self_actual_date = !empty($form_approve_details->assignee_reviewed_date) ? Carbon::parse($form_approve_details->assignee_reviewed_date)->format('d-M-Y') : '';
                        $is_overdue = !empty($self_actual_date) ? $self_actual_date > $duedate_self_review ? 1 : 0 : 0;
                        //  dd($self_actual_date);
                        $assigned_form_status[$i] = $flow_type[$flow_key];
                        $assigned_form_status[$i]['expected_date'] = $duedate_self_review ?? '';
                        $assigned_form_status[$i]['actual_date'] = $self_actual_date;
                        $assigned_form_status[$i]['is_overdue'] = $is_overdue;

                        if ($goal_initiated_date->flow_type == 3) {
                            $assigned_form_status[$i]['status'] = $manager_approval_status == 1 ? ($form_approve_details->is_assignee_submitted == 1 ? 1 : 0) : -1;
                        } elseif ($goal_initiated_date->flow_type == 1) {
                            $assigned_form_status[$i]['status'] = $goal_published_status == 1 ? ($form_approve_details->is_assignee_submitted == 1 ? 1 : 0) : -1;
                        } else {
                            $assigned_form_status[$i]['status'] = $employee_accepted_status == 1 ? ($form_approve_details->is_assignee_submitted == 1 ? 1 : 0) : -1;
                        }

                        $self_review_status = $assigned_form_status[$i]['status'];
                        // dd($self_review_status);
                    }

                    if ($flow_key == "Manager-Review") {
                        // dd($L1_manager_reviewed_date);
                        $l1_actual_date = !empty($L1_manager_reviewed_date) ? Carbon::parse($L1_manager_reviewed_date)->format('d-M-Y') : '';
                        $is_overdue = !empty($l1_actual_date) ? $l1_actual_date > $duedate_mgr_review ? 1 : 0 : 0;
                        $assigned_form_status[$i] = $flow_type[$flow_key];
                        $assigned_form_status[$i]['expected_date'] = $duedate_mgr_review ?? '';
                        $assigned_form_status[$i]['actual_date'] = $l1_actual_date;
                        $assigned_form_status[$i]['is_overdue'] = $is_overdue;
                        $assigned_form_status[$i]['status'] = $self_review_status == 1 ? ($L1_manager_reviewed_status == 1 ? 1 : 0) : -1;

                        $L1_manager_review_status = $assigned_form_status[$i]['status'];
                    }
                    if ($flow_key == "l2_Manager-Review") {

                        $l2_actual_date = !empty($L2_manager_reviewed_date) ? Carbon::parse($L2_manager_reviewed_date)->format('d-M-Y') : '';
                        $is_overdue = !empty($l2_actual_date) ? $l2_actual_date > $duedate_mgr_review ? 1 : 0 : 0;
                        $assigned_form_status[$i] = $flow_type[$flow_key];
                        $assigned_form_status[$i]['expected_date'] = $duedate_mgr_review ?? '';
                        $assigned_form_status[$i]['actual_date'] = $l2_actual_date;
                        $assigned_form_status[$i]['is_overdue'] = $is_overdue;
                        $assigned_form_status[$i]['status'] = $L1_manager_review_status == 1 ? ($L2_manager_reviewed_status == 1 ? 1 : 0) : -1;

                        $L2_manager_review_status = $assigned_form_status[$i]['status'];
                    }

                    if ($flow_key == "l3_Manager-Review") {

                        $l3_actual_date = !empty($L3_manager_reviewed_date) ? Carbon::parse($L3_manager_reviewed_date)->format('d-M-Y') : '';
                        $is_overdue = !empty($l3_actual_date) ? $l3_actual_date > $duedate_mgr_review ? 1 : 0 : 0;
                        $assigned_form_status[$i] = $flow_type[$flow_key];
                        $assigned_form_status[$i]['expected_date'] = $duedate_mgr_review ?? '';
                        $assigned_form_status[$i]['actual_date'] = $l3_actual_date;
                        $assigned_form_status[$i]['is_overdue'] = $is_overdue;
                        $assigned_form_status[$i]['status'] = $L2_manager_review_status == 1 ? ($L2_manager_reviewed_status == 1 ? 1 : 0) : -1;

                        $manager_review_status = $assigned_form_status[$i]['status'];
                    }
                    if ($flow_key == "HR-Review") {
                        $hr_actual_date = !empty($hr_manager_reviewed_date) ? Carbon::parse($hr_manager_reviewed_date)->format('d-M-Y') : '';
                        $is_overdue = !empty($hr_actual_date) ? $hr_actual_date > $duedate_hr_review ? 1 : 0 : 0;
                        $assigned_form_status[$i] = $flow_type[$flow_key];
                        $assigned_form_status[$i]['expected_date'] = $duedate_hr_review ?? '';
                        $assigned_form_status[$i]['actual_date'] = $hr_actual_date;
                        $assigned_form_status[$i]['is_overdue'] = $is_overdue;
                        $assigned_form_status[$i]['status'] = $manager_review_status == 1 ? (!empty($hr_manager_reviewed_date) ? 1 : 0) : (!empty($hr_manager_reviewed_date) ? 1 : -1);

                        $hr_review_status = $assigned_form_status[$i]['status'];
                    }

                    $i++;
                }
            }

            return $assigned_form_status;
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Error while fetching the form timeline data',
                'error' => $e->getMessage(),
                'line' => $e->getLine()
            ]);
        }
    }


    public function pmsSampleKpiFormExcellV3($user_code)
    {

        $validator = Validator::make(
            $data = [
                "user_code" => $user_code
            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'
            ]);
        }
        try {
            $users_query = User::where('user_code', $user_code)->first();
            $user_id = $users_query->id;
            $selected_headers = array();
            $vmt_assignment_v3 = VmtPMSassignment_settings_v3::join('vmt_pms_assignment_v3', 'vmt_pms_assignment_v3.pms_assignment_settings_id', '=', 'vmt_pms_assignment_settings_v3.id')
                ->where('vmt_pms_assignment_settings_v3.client_id', $users_query->client_id)
                ->whereDate('vmt_pms_assignment_v3.assignment_start_date', '<=', Carbon::now())
                ->whereDate('vmt_pms_assignment_v3.assignment_end_date', '>=', Carbon::now());
            if ($vmt_assignment_v3->exists()) {
                $vmt_assignment_v3 = $vmt_assignment_v3->first();
                $assignment_start_date = Carbon::parse($vmt_assignment_v3->assignment_start_date)->format('d/M/Y');
                $assignment_end_date = Carbon::parse($vmt_assignment_v3->assignment_end_date)->format('d/M/Y');
                $assignment_date = $assignment_start_date . ' - ' . $assignment_end_date;
                $assignment = '(' . $assignment_date . ')';
                $frequency = ucfirst($vmt_assignment_v3->frequency);
                $headers = json_decode($vmt_assignment_v3->selected_headers, true);
                foreach ($headers as $single_headers) {
                    if (!empty($single_headers['alias_name'])) {
                        array_push($selected_headers, $single_headers['alias_name']);
                    } else {
                        array_push($selected_headers, $single_headers['header_label']);
                    }
                }
                $client_name = VmtClientMaster::find($users_query->client_id)->client_name;
                $client_logo_path = VmtClientMaster::where('id', $users_query->client_id)->first()->client_logo;
                $public_client_logo_path = public_path($client_logo_path);
                if (!file_exists($public_client_logo_path)) {
                    $public_client_logo_path = public_path('/assets/clients/ess/logos/logo_abs.png');
                }
                //  dd(file_exists($public_client_logo_path));
                return Excel::download(new PMSFormSampleExcelExport($selected_headers, $client_name, $frequency, $assignment, $assignment_date, $public_client_logo_path), 'PMS Sample Excel.xlsx');
            } else {
                return response()->json([
                    "status" => "failure",
                    "message" => 'No Active Assignment Period'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance',
                'error' => $e->getMessage(),
                'line' => $e->getTraceAsString()
            ]);
        }
    }

    public function getDashboardCardDetails_SelfAppraisal($user_code, $assignment_setting_id, $assinged_record_id)
    {

        $validator = Validator::make(
            $data = [
                "user_code" => $user_code,
                'assignment_setting_id' => $assignment_setting_id,
                'assinged_record_id' => $assinged_record_id
            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',
                "assignment_setting_id" => 'required',
                "assinged_record_id" => 'nullable',
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'
            ]);
        }

        try {

            $response['employee_details'] = $this->getEmployeeCardDetails($user_code) ?? null;
            $response['current_form_rating'] = $this->getCurrentRatingDetails_selfAppraisal($user_code, $assinged_record_id) ?? null;
            $response['overall_rating'] = $this->getOverallRatingsDetails($user_code, $assignment_setting_id) ?? null;

            return response()->json([
                "status" => "success",
                "data" => $response
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failure',
                'data' => $e->getMessage(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance',
                'error' => $e->getTraceAsString()
            ]);
        }
    }

    private function canManagerRevokeForm($assigned_form_id)
    {

        $validator = Validator::make(
            $data = [
                "assigned_form_id" => $assigned_form_id
            ],
            $rules = [
                "assigned_form_id" => 'required|exists:vmt_pms_assignment_v3,id',
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'
            ]);
        }

        try {

            $employee_assigned_form_data = VmtPmsKpiFormReviewsV3::leftjoin('vmt_pms_assignment_v3', 'vmt_pms_assignment_v3.id', '=', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id')
                ->where('vmt_pms_assignment_v3.id', $assigned_form_id)
                ->first();


            $reviews_flow = json_decode($employee_assigned_form_data->reviewer_details, true);

            foreach ($reviews_flow as $key => $single_data) {

                if ($single_data['reviewer_level'] == 'L1') {


                    if ($single_data['is_accepted'] != '-1') {

                        return true;
                        //  $response['canManagerRevokeForm']=1;

                    } else {
                        return false;
                        // $response['canManagerRevokeForm']=0;
                    }
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failure',
                'data' => $e->getMessage(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance',
                'error' => $e->getTraceAsString()
            ]);
        }
    }

    // private function canEmployeeWithdrawForm($assigned_form_id)
    // {

    //     $validator = Validator::make(
    //         $data = [
    //             "assigned_form_id" => $assigned_form_id
    //         ],
    //         $rules = [
    //             "assigned_form_id" => 'required|exists:vmt_pms_assignment_v3,id',
    //         ],
    //         $messages = [
    //             "required" => "Field :attribute is missing",
    //             "exists" => "Field :attribute is invalid"
    //         ]
    //     );

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 'failure',
    //             'data' => $validator->errors()->all(),
    //             'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'
    //         ]);
    //     }

    //     try {

    //           $employee_assigned_form_data = VmtPmsKpiFormReviewsV3::leftjoin('vmt_pms_assignment_v3','vmt_pms_assignment_v3.id','=','vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id')
    //                                           ->where('vmt_pms_assignment_v3.id',$assigned_form_id)
    //                                           ->first();

    //             $reviews_flow  =  json_decode($employee_assigned_form_data->reviewer_details, true);

    //             foreach ($reviews_flow as $key => $single_data) {

    //                 if($single_data['reviewer_level'] == 'L1') {


    //                     if($single_data['is_accepted'] == -1){

    //                        return true;
    //                     }else{
    //                       return false;
    //                     }
    //                 }

    //             }

    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => 'failure',
    //             'data' => $e->getMessage(),
    //             'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance',
    //             'error' => $e->getTraceAsString()
    //         ]);
    //     }
    // }
    // private function canEmployeeEditForm($assigned_form_id)
    // {

    //     $validator = Validator::make(
    //         $data = [
    //             "assigned_form_id" => $assigned_form_id
    //         ],
    //         $rules = [
    //             "assigned_form_id" => 'required|exists:vmt_pms_assignment_v3,id',
    //         ],
    //         $messages = [
    //             "required" => "Field :attribute is missing",
    //             "exists" => "Field :attribute is invalid"
    //         ]
    //     );

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 'failure',
    //             'data' => $validator->errors()->all(),
    //             'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'
    //         ]);
    //     }

    //     try {

    //         $employee_assigned_form_data = VmtPmsKpiFormReviewsV3::leftjoin('vmt_pms_assignment_v3', 'vmt_pms_assignment_v3.id', '=', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id')
    //             ->where('vmt_pms_assignment_v3.id', $assigned_form_id)
    //             ->first();


    //         $reviews_flow  =  json_decode($employee_assigned_form_data->reviewer_details, true);

    //         foreach ($reviews_flow as $key => $single_data) {

    //             if ($single_data['reviewer_level'] == 'L1') {

    //                 if ($single_data['is_accepted'] == 0) {

    //                     return true;
    //                 } else {
    //                     return false;
    //                 }
    //             }
    //         }
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => 'failure',
    //             'data' => $e->getMessage(),
    //             'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance',
    //             'error' => $e->getTraceAsString()
    //         ]);
    //     }
    // }
    public function withdrawEmployeeAssignedForm($assigned_record_id)
    {
        $validator = Validator::make(
            $data = [
                "assigned_record_id" => $assigned_record_id
            ],
            $rules = [
                // "assigned_record_id" => 'required|exists:vmt_pms_kpiform_assigned_v3,id',
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'
            ]);
        }

        try {

            $assigne_forms = VmtPmsKpiFormAssignedV3::where('id', $assigned_record_id)->first();

            $delete_reviews_forms = VmtPmsKpiFormReviewsV3::where('vmt_kpiform_assigned_v3_id', $assigned_record_id);

            if ($delete_reviews_forms->exists()) {
                $delete_reviews_forms->delete();
                $delete_assigne_forms = VmtPmsKpiFormAssignedV3::where('id', $assigned_record_id)->delete();

                $flow_type = "3";
                $users_details = user::join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                    ->where('user_id', $assigne_forms->assignee_id)->first();
                $managers_details = $this->getL1ManagerDetails($users_details->user_code);
                // $hr_details = $this->getL1ManagerDetails(user::where('id', $users_details->hr_user_id)->first()->user_code);
                $login_Link = request()->getSchemeAndHttpHost();
                $comments_employee = '';
                $emp_avatar = json_decode(newgetEmployeeAvatarOrShortName($assigne_forms->assignee_id), true);
                $emp_neutralgender = getGenderNeutralTerm($assigne_forms->assignee_id);

                // send mail to L1 manager
                $sent_mail = Mail::to($managers_details['officical_mail'])
                    // ->cc($hr_details['officical_mail'])
                    ->queue(
                        new VmtPMSMail_Assignee(
                            "withdraw",
                            $flow_type,
                            $users_details->name,
                            "2023",
                            $managers_details['name'],
                            $comments_employee,
                            $login_Link,
                            $emp_avatar,
                            $emp_neutralgender
                        )
                    );


                return response()->json([
                    'status' => 'success',
                    'message' => 'Form withdraw successfully',
                    'data' => [],
                ]);
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => "Record Doesn't exist",
                    'data' => [],
                ]);
            }
            // } catch (TransportException $e) {
            //     return response()->json([
            //         "status" => "success",
            //         "message" => "Form withdraw successfully. due to some techinal error mail not send",
            //         "mail_status" => "due to some techinal error mail not send",
            //         "data" => [],
            //     ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failure',
                'data' => $e->getMessage(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance',
                'error' => $e->getTraceAsString()
            ]);
        }
    }
    public function managerRevokeApprovedOrRejectedAssignedForm($assigned_form_id, $type)
    {

        $validator = Validator::make(
            $data = [
                "assigned_form_id" => $assigned_form_id,
                "type" => $type,
            ],
            $rules = [
                "assigned_form_id" => 'required|exists:vmt_pms_kpiform_assigned_v3,id',
                "type" => 'required',
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'
            ]);
        }

        try {

            $employee_assigned_form_data = VmtPmsKpiFormReviewsV3::where('vmt_kpiform_assigned_v3_id', $assigned_form_id)->first();

            if ($type == 'approve_reject') {

                $reviews_flow = json_decode($employee_assigned_form_data->reviewer_details, true);

                foreach ($reviews_flow as $key => $single_data) {
                    $reviews_flow[$key]['is_accepted'] = '0';
                }

                $employee_assigned_form_data->reviewer_details = json_encode($reviews_flow);
                $employee_assigned_form_data->is_reviewer_accepted = null;
                $employee_assigned_form_data->save();

            } elseif ($type == 'self_review') {

                $employee_assigned_form_data->assignee_reviewed_date = null;
                $employee_assigned_form_data->is_assignee_submitted = '';
                $employee_assigned_form_data->save();

            }

            return response()->json([
                'status' => 'success',
                'message' => 'Form revoked successfully',
                'data' => '',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failure',
                'data' => $e->getMessage(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance',
                'error' => $e->getTraceAsString()
            ]);
        }
    }

    public function getDefaultConfigSetting()
    {

        $get_config = VmtPmsDefultConfigV3::get();

        $defult_value = ['pms_default_ratings' => [], 'pms_default_form_headers' => [], 'can_freeze_calender_sett' => 0];
        foreach ($get_config as $key => $value) {
            $temp['config_name'] = $value['config_name'];
            $temp['config_value'] = json_decode($value['config_value'], true);
            array_push($defult_value[$value['config_name']], $temp);
        }

        return $defult_value;
    }

    public function pmsformReminders()
    {

        $employee_assigned_form_data = VmtPmsKpiFormReviewsV3::join('vmt_pms_kpiform_assigned_v3', 'vmt_pms_kpiform_assigned_v3.id', '=', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id')
            ->join('vmt_pms_assignment_v3', 'vmt_pms_assignment_v3.id', '=', 'vmt_pms_kpiform_assigned_v3.vmt_pms_assignment_v3_id')
            ->join('vmt_pms_assignment_settings_v3', 'vmt_pms_assignment_settings_v3.id', '=', 'vmt_pms_assignment_v3.pms_assignment_settings_id')
            ->get([
                'vmt_pms_kpiform_assigned_v3.id as id',
                'vmt_pms_kpiform_assigned_v3.assignee_id as assignee_id',
                'vmt_pms_assignment_settings_v3.client_id',
                'vmt_pms_kpiform_assigned_v3.flow_type as flow_type',
                'vmt_pms_kpiform_reviews_v3.is_assignee_accepted as is_assignee_accepted',
                'vmt_pms_kpiform_reviews_v3.is_assignee_submitted as is_assignee_submitted',
                'vmt_pms_kpiform_reviews_v3.reviewer_details as reviewer_details',
                'vmt_pms_kpiform_reviews_v3.is_reviewer_accepted as is_reviewer_accepted',
                'vmt_pms_kpiform_reviews_v3.is_reviewer_submitted as is_reviewer_submitted',
                'vmt_pms_assignment_v3.assignment_start_date',
                'vmt_pms_assignment_v3.assignment_end_date',
                'vmt_pms_assignment_v3.duedate_goal_initiate',
                'vmt_pms_assignment_v3.duedate_emp_mgr_approval',
                'vmt_pms_assignment_v3.duedate_self_review',
                'vmt_pms_assignment_v3.duedate_mgr_review',
                'vmt_pms_assignment_v3.duedate_hr_review',
            ]);

        foreach ($employee_assigned_form_data as $key => $single_value) {
            $records_data[$key]['id'] = $single_value['id'];
            $records_data[$key]['assignee_id'] = $single_value['assignee_id'];
            $records_data[$key]['flow_type'] = $single_value['flow_type'];
            $records_data[$key]['client_id'] = $single_value['client_id'];
            $records_data[$key]['is_assignee_accepted'] = $single_value['is_assignee_accepted'];
            $records_data[$key]['is_assignee_submitted'] = $single_value['is_assignee_submitted'];
            $records_data[$key]['reviewer_details'] = json_decode($single_value['reviewer_details'], true);
            $records_data[$key]['is_reviewer_accepted'] = $single_value['is_reviewer_accepted'];
            $records_data[$key]['is_reviewer_submitted'] = $single_value['is_reviewer_submitted'];
            $records_data[$key]['assignment_start_date'] = $single_value['assignment_start_date'];
            $records_data[$key]['assignment_end_date'] = $single_value['assignment_end_date'];
            $goal_initiate_due_days = $single_value['duedate_goal_initiate'];
            $emp_mgr_appr_due_days = ($single_value['duedate_goal_initiate'] + $single_value['duedate_emp_mgr_approval']);
            $emp_self_reviews_due_days = ($single_value['duedate_self_review'] + $single_value['duedate_mgr_review'] + $single_value['duedate_hr_review']);
            $mgr_reviewa_due_days = ($single_value['duedate_mgr_review'] + $single_value['duedate_hr_review']);
            $hr_reviews_due_days = $single_value['duedate_hr_review'];
            $records_data[$key]['duedate_goal_initiate'] = carbon::parse($single_value['assignment_start_date'])->addDays($goal_initiate_due_days)->format('Y-m-d');
            $records_data[$key]['duedate_emp_mgr_approval'] = carbon::parse($single_value['assignment_start_date'])->addDays($emp_mgr_appr_due_days)->format('Y-m-d');
            $records_data[$key]['duedate_self_review'] = carbon::parse($single_value['assignment_end_date'])->subDays($emp_self_reviews_due_days)->format('Y-m-d');
            $records_data[$key]['duedate_mgr_review'] = carbon::parse($single_value['assignment_end_date'])->subDays($mgr_reviewa_due_days)->format('Y-m-d');
            $records_data[$key]['duedate_hr_review'] = carbon::parse($single_value['assignment_end_date'])->subDays($hr_reviews_due_days)->format('Y-m-d');
            $records_data[$key]['notifyreminder'] = $this->notifyreminder($single_value['client_id']);
        }


        foreach ($records_data as $single_value) {

            // yet to approve / reject reminders
            if ($single_value['is_assignee_accepted'] == '1' && $single_value['is_reviewer_accepted'] == '') {
                if (Carbon::parse($single_value['duedate_emp_mgr_approval'])->subDay()->format('Y-m-d') == Carbon::now()->format('Y-m-d')) {
                    if ($single_value['notifyreminder']['notif_mgr_bfr_duedate']['active'] == '1') {
                        if (in_array('Mail', $single_value['notifyreminder']['notif_mgr_bfr_duedate']['notif_mode'])) {

                        }
                    }
                } elseif (Carbon::parse($single_value['duedate_emp_mgr_approval'])->addDay()->format('Y-m-d') <= Carbon::now()->format('Y-m-d')) {
                    if ($single_value['notifyreminder']['notif_mgr_for_overduedate']['active'] == '1') {
                        if (in_array('Mail', $single_value['notifyreminder']['notif_mgr_for_overduedate']['notif_mode'])) {
                            // dd($single_value);
                            Mail::to('')->send(
                                new dommimails(
                                    "please approve forms",
                                    "not a error",
                                    "not a error",
                                )
                            );
                        }
                    }
                }
                // yet to accept / reject reminders
            } elseif ($single_value['is_assignee_accepted'] == '' && $single_value['is_reviewer_accepted'] == '1') {
                if (Carbon::parse($single_value['duedate_emp_mgr_approval'])->subDay()->format('Y-m-d') == Carbon::now()->format('Y-m-d')) {
                    if ($single_value['notifyreminder']['notif_emp_bfr_duedate']['active'] == '1') {
                        if (in_array('Mail', $single_value['notifyreminder']['notif_emp_bfr_duedate']['notif_mode'])) {
                            // dd($single_value);
                        }
                    }
                } elseif (Carbon::parse($single_value['duedate_emp_mgr_approval'])->addDay()->format('Y-m-d') <= Carbon::now()->format('Y-m-d')) {
                    if ($single_value['notifyreminder']['notif_emp_for_overduedate']['active'] == '1') {
                        if (in_array('Mail', $single_value['notifyreminder']['notif_emp_for_overduedate']['notif_mode'])) {
                            // dd($single_value);
                        }
                    }
                }
                // yet to self reviews reminders
            } elseif ($single_value['is_assignee_accepted'] == '1' && $single_value['is_reviewer_accepted'] == '1' && $single_value['is_assignee_submitted'] == '') {

                if (Carbon::parse($single_value['duedate_self_review'])->subDay()->format('Y-m-d') == Carbon::now()->format('Y-m-d')) {
                    if ($single_value['notifyreminder']['notif_emp_bfr_duedate']['active'] == '1') {
                        if (in_array('Mail', $single_value['notifyreminder']['notif_emp_bfr_duedate']['notif_mode'])) {
                            // dd($single_value);
                        }
                    }
                } elseif (Carbon::parse($single_value['duedate_self_review'])->addDay()->format('Y-m-d') <= Carbon::now()->format('Y-m-d')) {
                    if ($single_value['notifyreminder']['notif_emp_for_overduedate']['active'] == '1') {
                        if (in_array('Mail', $single_value['notifyreminder']['notif_emp_for_overduedate']['notif_mode'])) {
                            // dd($single_value);
                        }
                    }
                }
                // yet to manager reviews reminders
            } elseif ($single_value['is_assignee_accepted'] == '1' && $single_value['is_reviewer_accepted'] == '1' && $single_value['is_assignee_submitted'] == '1' && $single_value['is_reviewer_submitted'] == '') {

                $review_details = [];
                foreach ($single_value['reviewer_details'] as $reviewer_flow) {
                    $review_details[$reviewer_flow['review_order']] = $reviewer_flow;
                }

                foreach ($review_details as $order => $single_reviews) {
                    // dd($review_details[$order]);
                    if ($order == 1) {

                        if ($review_details[$order]['review_order'] == 1 && $review_details[$order]['is_reviewed'] == 0) {
                            // dd($single_value);
                            if (Carbon::parse($single_value['duedate_mgr_review'])->subDay()->format('Y-m-d') == Carbon::now()->format('Y-m-d')) {
                                if ($single_value['notifyreminder']['notif_mgr_bfr_duedate']['active'] == '1') {
                                    if (in_array('Mail', $single_value['notifyreminder']['notif_mgr_bfr_duedate']['notif_mode'])) {
                                        // dd($single_value);
                                    }
                                }
                            } elseif (Carbon::parse($single_value['duedate_mgr_review'])->addDay()->format('Y-m-d') <= Carbon::now()->format('Y-m-d')) {
                                if ($single_value['notifyreminder']['notif_mgr_for_overduedate']['active'] == '1') {
                                    if (in_array('Mail', $single_value['notifyreminder']['notif_mgr_for_overduedate']['notif_mode'])) {
                                        // dd($single_value);
                                    }
                                }
                            }
                        }
                    } elseif ($order == 2) {

                        if ($review_details[$order - 1]['is_reviewed'] == 1 && $review_details[$order]['is_reviewed'] == 0) {
                            // dd($single_value);
                            if (Carbon::parse($single_value['duedate_mgr_review'])->subDay()->format('Y-m-d') == Carbon::now()->format('Y-m-d')) {
                                if ($single_value['notifyreminder']['notif_mgr_bfr_duedate']['active'] == '1') {
                                    if (in_array('Mail', $single_value['notifyreminder']['notif_mgr_bfr_duedate']['notif_mode'])) {
                                        // dd($single_value);
                                    }
                                }
                            } elseif (Carbon::parse($single_value['duedate_mgr_review'])->addDay()->format('Y-m-d') <= Carbon::now()->format('Y-m-d')) {
                                if ($single_value['notifyreminder']['notif_mgr_for_overduedate']['active'] == '1') {
                                    if (in_array('Mail', $single_value['notifyreminder']['notif_mgr_for_overduedate']['notif_mode'])) {
                                        // dd($single_value);
                                    }
                                }
                            }
                        }
                    } elseif ($order == 3) {

                        if ($review_details[$order - 1]['is_reviewed'] == 1 && $review_details[$order]['is_reviewed'] == 0) {
                            if (Carbon::parse($single_value['duedate_mgr_review'])->subDay()->format('Y-m-d') == Carbon::now()->format('Y-m-d')) {
                                if ($single_value['notifyreminder']['notif_mgr_bfr_duedate']['active'] == '1') {
                                    if (in_array('Mail', $single_value['notifyreminder']['notif_mgr_bfr_duedate']['notif_mode'])) {
                                        // dd($single_value);
                                    }
                                }
                            } elseif (Carbon::parse($single_value['duedate_mgr_review'])->addDay()->format('Y-m-d') <= Carbon::now()->format('Y-m-d')) {
                                if ($single_value['notifyreminder']['notif_mgr_for_overduedate']['active'] == '1') {
                                    if (in_array('Mail', $single_value['notifyreminder']['notif_mgr_for_overduedate']['notif_mode'])) {
                                        // dd($single_value);
                                    }
                                }
                            }
                        }

                    }
                }
            }
        }

    }

    private function notifyreminder($client_id)
    {
        $getnotifyreminder = VmtPmsNotifySettingsV3::where('client_id', $client_id)->get() ?? null;
        foreach ($getnotifyreminder as $single_reminder) {
            $temp['notif_emp_bfr_duedate'] = json_decode($single_reminder['notif_emp_bfr_duedate'], true);
            $temp['notif_emp_for_overduedate'] = json_decode($single_reminder['notif_emp_for_overduedate'], true);
            $temp['notif_mgr_bfr_duedate'] = json_decode($single_reminder['notif_mgr_bfr_duedate'], true);
            $temp['notif_mgr_for_overduedate'] = json_decode($single_reminder['notif_mgr_for_overduedate'], true);
        }
        return $temp;
    }

    /*
        Get the month range based on the given
        calendar type and year

    */
    private function getFinancial_CalendarYear_Range($calendar_type, $year)
    {


        $validator = Validator::make(
            $data = [
                "calendar_type" => $calendar_type,
                "year" => $year
            ],
            $rules = [
                "calendar_type" => 'required|in:financial_year,calendar_year',
                "year" => 'required|integer',
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid",
                "in" => "Field :attribute is invalid"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
            ]);
        }

        try {

            switch ($calendar_type) {
                case "financial_year":
                  return [
                    "start_date" => $year . '-04-01',
                    "end_date" => ($year + 1). '-03-31',
                ];
                case "calendar_year":
                    return [
                        "start_date" => $year . '-01-01',
                        "end_date" => $year . '-12-31',
                    ];

            }




        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'data' => $e->getMessage(),
                'message' => 'ERROR [ getFinancial_CalendarYear_Range() ] : ',
                'error' => $e->getTraceAsString()
            ]);
        }


    }

    public function getAllAssignmentSettings($client_code, $year, $month)
    {

        $month = Carbon::now()->format('m');


        $requested_date = Carbon::parse($year . '-' . $month . '-01');

        $recent_pmsassign_settings_range = null;

        $client_id = VmtClientMaster::where('client_code', $client_code)->first()->id;

        $query_recent_pmsassign_settings = VmtPMSassignment_settings_v3::where('client_id', $client_id)
            ->orderBy('year', 'DESC')->first();

            if($query_recent_pmsassign_settings == null){
                return "No PMS Assignment Settings found for the given Year/Month. So we need to create new one";
            }

        $recent_pmsassign_settings_range = $this->getFinancial_CalendarYear_Range($query_recent_pmsassign_settings->calendar_type, $query_recent_pmsassign_settings->year);

        if (
            !$requested_date->between(
                Carbon::parse($recent_pmsassign_settings_range["start_date"]),
                Carbon::parse($recent_pmsassign_settings_range["end_date"])
            )
        ) {
            return "No PMS Assignment Settings found for the given Year/Month. So we need to create new one";
        }


        $assignment_settings = VmtPMSassignment_settings_v3::find($query_recent_pmsassign_settings->id);
        $assignments_records = VmtPmsAssignmentV3::where('pms_assignment_settings_id', $assignment_settings->id)->get();

        if (!empty($assignment_settings)) {

            $get_assinged = VmtPmsKpiFormAssignedV3::get()->groupBy('vmt_pms_assignment_v3_id')->toArray();

            foreach ($assignments_records as $key => $single_value) {

                $start_date = Carbon::parse($single_value['assignment_start_date'])->format('d-m-Y');
                $end_date = Carbon::parse($single_value['assignment_end_date'])->format('d-m-Y');
                $temp[$key]['assignment_period'] = $single_value['assignment_period'] . '-(' . $start_date . ' - ' . $end_date . ')';
                $temp[$key]['assignment_period_id'] = $single_value['id'];
                if (array_key_exists($single_value['id'], $get_assinged)) {
                    $temp[$key]['is_assigned'] = '1';
                } else {
                    $temp[$key]['is_assigned'] = '0';
                }
                $temp[$key]['start_date'] = $start_date;
                $temp[$key]['end_date'] = $end_date;

            }

            if ($assignment_settings->calendar_type == 'financial_year') {
                $cal_type_full_year = 'Apr-' . $assignment_settings->year . ' - Mar-' . Carbon::parse('01-01-' . $assignment_settings->year)->addYear()->format('Y');
            } else if ($assignment_settings->calendar_type == 'calendar_year') {
                $cal_type_full_year = 'Jan-' . $assignment_settings->year . ' - Dec-' . $assignment_settings->year;
            }

            $response['calendar_type'] = $assignment_settings->calendar_type;
            $response['year'] = $cal_type_full_year;
            $response['frequency'] = $assignment_settings->frequency;
            $response['can_freeze_calender_sett'] = 1;
            $response['assignment_period'] = '';
            $response['assignment_period_list'] = $temp;

            return response()->json([
                'status' => 'success',
                'data' => $response,
            ]);

        } else {

            return $this->getDefaultConfigSetting();

        }

    }

    public function getPMSSetting_forGivenAssignmentPeriod($asignement_period_id)
    {

        $vmt_pms_assignment_settings = VmtPMSassignment_settings_v3::join('vmt_pms_assignment_v3', 'vmt_pms_assignment_v3.pms_assignment_settings_id', '=', 'vmt_pms_assignment_settings_v3.id')
            ->where('vmt_pms_assignment_v3.id', $asignement_period_id)->first();

        if ($vmt_pms_assignment_settings != null) {

            //basic setting
            $get_basic_setting_arr['can_assign_upcoming_goals'] = $vmt_pms_assignment_settings->can_assign_upcoming_goals;
            $get_basic_setting_arr['annual_score_cal_method'] = $vmt_pms_assignment_settings->annual_score_calc_method;
            $get_basic_setting_arr['can_emp_proceed_nextpms_wo_currpms_completion'] = $vmt_pms_assignment_settings->can_emp_proceed_next_pms;
            $get_basic_setting_arr['can_org_proceed_nextpms_wo_currpms_completion'] = $vmt_pms_assignment_settings->can_org_proceed_next_pms;

            //pms_dashboard_page
            $pms_dashboard_page['can_show_overall_score_in_selfappr_dashboard'] = $vmt_pms_assignment_settings->show_overall_score_self_app_scrn;
            $pms_dashboard_page['can_show_rating_card_in_review_page'] = $vmt_pms_assignment_settings->show_rating_card_review_page;
            $pms_dashboard_page['can_show_overall_scr_card_in_review_page'] = $vmt_pms_assignment_settings->show_overall_scr_review_page;

            //notify setting
            $notify_setting['can_alert_emp_bfr_duedate'] = json_decode($vmt_pms_assignment_settings->notif_emp_bfr_duedate, true);
            $notify_setting['can_alert_emp_for_overduedate'] = json_decode($vmt_pms_assignment_settings->notif_emp_for_overduedate, true);
            $notify_setting['can_alert_mgr_bfr_duedate'] = json_decode($vmt_pms_assignment_settings->notif_mgr_bfr_duedate, true);
            $notify_setting['can_alert_mgr_for_overduedate'] = json_decode($vmt_pms_assignment_settings->notif_mgr_for_overduedate, true);

            // pms metrics
            $pms_metrics = json_decode($vmt_pms_assignment_settings->selected_headers, true);
            if ($pms_metrics) {
                $i = 0;
                for ($i = 0; $i < count($pms_metrics); $i++) {
                    $pms_metrics[$i]['alias_name'] = '';
                }
            }
            // pms rating score cards
            $pms_rating_score_cards = json_decode($vmt_pms_assignment_settings->pms_rating_card, true);

            // pms existing column settings
            $existing_columns = VmtPmsDefultConfigV3::where('config_name', 'pms_default_form_headers')->first() ?? null;
            $pms_decode_column = json_decode($existing_columns->config_value, true);

            //    // pms calender setting
            $pms_calendar_settings['calendar_type'] = $vmt_pms_assignment_settings->calendar_type;
            $pms_calendar_settings['assignment_period'] = $vmt_pms_assignment_settings->id;
            $pms_calendar_settings['frequency'] = $vmt_pms_assignment_settings->frequency;

            if ($vmt_pms_assignment_settings->calendar_type == 'financial_year') {
                $pms_calendar_settings['year'] = 'Apr-' . $vmt_pms_assignment_settings->year . ' - Mar-' . Carbon::parse('01-01-' . $vmt_pms_assignment_settings->year)->addYear()->format('Y');
            } else if ($vmt_pms_assignment_settings->calendar_type == 'calendar_year') {
                $pms_calendar_settings['year'] = 'Jan-' . $vmt_pms_assignment_settings->year . ' - Dec-' . $vmt_pms_assignment_settings->year;
            }


            //goal_settings
            $goal_settings['who_can_set_goal'] = json_decode($vmt_pms_assignment_settings->who_can_set_goal, true);
            $goal_settings['final_kpi_score_based_on'] = $vmt_pms_assignment_settings->final_kpi_score_based_on;
            $goal_settings['should_mgr_appr_rej_goals'] = $vmt_pms_assignment_settings->should_mgr_appr_rej_goals;
            $goal_settings['should_emp_acp_rej_goals'] = $vmt_pms_assignment_settings->should_emp_acp_rej_goals;
            $goal_settings['duedate_goal_initiate'] = $vmt_pms_assignment_settings->duedate_goal_initiate;
            $goal_settings['duedate_approval_acceptance'] = $vmt_pms_assignment_settings->duedate_emp_mgr_approval;
            $goal_settings['duedate_self_review'] = $vmt_pms_assignment_settings->duedate_self_review;
            $goal_settings['duedate_mgr_review'] = $vmt_pms_assignment_settings->duedate_mgr_review;
            $goal_settings['duedate_hr_review'] = $vmt_pms_assignment_settings->duedate_hr_review;
            $goal_settings['reviewers_flow'] = json_decode($vmt_pms_assignment_settings->reviewers_flow, true);

            // response
            $response['pms_basic_settings'] = $get_basic_setting_arr;
            $response['pms_dashboard_page'] = $pms_dashboard_page;
            $response['remainder_alert'] = $notify_setting;
            $response['pms_calendar_settings'] = $pms_calendar_settings;
            $response['goal_settings'] = $goal_settings;
            $response['score_card'] = $pms_rating_score_cards;
            $response['pms_metrics'] = $pms_metrics ? $pms_metrics : [];
            $response['existings_metrics'] = $pms_decode_column;
            //    $response['can_freeze_calender_sett'] = 1;

            return $response;
        } else {

            return $this->getDefaultConfigSetting();

        }

    }

    public function selfAppraisalEditedFormPublish($assigned_record_id)
    {


        $validator = Validator::make(
            $data = [
                "assigned_record_id" => $assigned_record_id
            ],
            $rules = [
                "assigned_record_id" => 'required|exists:vmt_pms_kpiform_reviews_v3,vmt_kpiform_assigned_v3_id',
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'data' => $validator->errors()->all(),
                'message' => 'This pertains to a system error; please reach out to your HR team for additional assistance'
            ]);
        }


        $single_details = VmtPmsKpiFormReviewsV3::where('vmt_kpiform_assigned_v3_id', $assigned_record_id)->first();
        $json_reviewers = json_decode($single_details->reviewer_details, true);

        for ($i = 0; $i < count($json_reviewers); $i++) {
            $json_reviewers[$i]['is_accepted'] = '0';
            $json_reviewers[$i]['rejection_comments'] = '';
        }

        $single_details->reviewer_details = json_encode($json_reviewers);
        $single_details->is_reviewer_accepted = null;
        $single_details->save();

        return response()->json([
            'status' => 'success',
            'data' => 'Republish the forms',
        ]);

    }

    public function recordFormFinalKpiScore($record_id)
    {

        $final_kpi_score = 0;

        if (empty($record_id)) {
            $response['final_kpi_score'] = $final_kpi_score;
            return $response;
        }

        $get_assignment = VmtPmsKpiFormAssignedV3::join('vmt_pms_kpiform_reviews_v3', 'vmt_pms_kpiform_assigned_v3.id', '=', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id')
            ->where('vmt_pms_kpiform_assigned_v3.id', $record_id)->first();

        $json_reviewer = json_decode($get_assignment->reviewer_details, true);

        $get_assigned_settings = VmtPmsAssignmentV3::where('id', $get_assignment->vmt_pms_assignment_v3_id)->first();

        foreach ($json_reviewer as $single_reviewer) {
            if ($single_reviewer['reviewer_level'] == 'L1') {
                $final_kpi_score += (int) $single_reviewer['reviewer_score'];
            } else {
                $final_kpi_score = 0;
            }
        }

        return $final_kpi_score;

    }

    public function getAssignmentPeriodDropdown($user_code,$client_id)
    {
        $arr = [];
        $client = VmtClientMaster::where('id', $client_id)->first();

        if($client->client_fullname == 'All'){

        $client_id = VmtClientMaster::all(['id']);
        $pmsyear = VmtPMSassignment_settings_v3::whereIn('client_id', $client_id)->distinct('year')->get(['year','calendar_type'])->toarray();

        foreach($pmsyear as $key1 => $single_year){
            if ($single_year['calendar_type'] == 'financial_year') {
                $cal_type_full_year['assignment_period'] = 'Apr-' . $single_year['year']  . ' - Mar-' . Carbon::parse('01-01-' . $single_year['year'] )->addYear()->format('Y');
                $cal_type_full_year['assignment_id'] = VmtPMSassignment_settings_v3::where('year', $single_year['year'])->get('id')->toarray();
            } else if ($single_year['calendar_type'] == 'calendar_year') {
                $cal_type_full_year['assignment_period'] = 'Jan-' . $single_year['year'] . ' - Dec-' . $single_year['year'];
                $cal_type_full_year['assignment_id'] = VmtPMSassignment_settings_v3::where('year', $single_year['year'])->get('id')->toarray();
            }
                array_push($arr,$cal_type_full_year);
            }

         } else {

            $pmsSetting = VmtPMSassignment_settings_v3::where('client_id', $client->id)->distinct('year')->get();

        foreach ($pmsSetting as $key => $single_period) {
            if ($single_period->calendar_type == 'financial_year') {
                $cal_type_full_year['assignment_period'] = 'Apr-' . $single_period->year . ' - Mar-' . Carbon::parse('01-01-' . $single_period->year)->addYear()->format('Y');
                $cal_type_full_year['assignment_id'] = $single_period['id'];
            } else if ($single_period->calendar_type == 'calendar_year') {
                $cal_type_full_year['assignment_period'] = 'Jan-' . $single_period->year . ' - Dec-' . $single_period->year;
                $cal_type_full_year['assignment_id'] = $single_period['id'];
            }
            array_push($arr,$cal_type_full_year);
        }
    }
        for($i=0;$i<count($arr);$i++){
            $getassigned_settings = explode(" - ", $arr[$i]['assignment_period']);
            if ((carbon::parse($getassigned_settings[0]))->lte(Carbon::now()) && (carbon::parse($getassigned_settings[1])->endOfMonth())->gte(Carbon::now())) {
                $arr[$i]['current_period'] = '1';
            } else {
                $arr[$i]['current_period'] = '0';
            }
        }

        return $arr;
    }


    public function PerformanceRatingGraph($user_code, $assignment_id, $status)
    {

        $users_query = User::where('user_code', $user_code)->first();
        $user_id = $users_query->id;
        // dd($user_id);
        $get_pmsassignment_settings = VmtPMSassignment_settings_v3::where('client_id', $users_query->client_id)->where('id', $assignment_id)->first();
        $get_assingmentv3 = VmtPmsAssignmentV3::where('pms_assignment_settings_id', $get_pmsassignment_settings->id)->get();

        foreach ($get_assingmentv3 as $single_period) {


            $split_period = substr($single_period['assignment_period'], 1);
            $start_date = Carbon::parse($single_period['assignment_start_date'])->format("M - Y");
            $end_date = Carbon::parse($single_period['assignment_end_date'])->format("M - Y");

            if ($get_pmsassignment_settings->frequency == "weekly") {
                $assignment_period = $split_period . " st week of " . $start_date;
            } elseif ($get_pmsassignment_settings->frequency == "monthly") {
                $assignment_period = $start_date;
            } elseif ($get_pmsassignment_settings->frequency == "quarterly") {
                $assignment_period = $single_period['assignment_period'];
            } elseif ($get_pmsassignment_settings->frequency == "half_yearly") {
                $assignment_period = $split_period . " st Half Year - " . $start_date . " - " . $end_date;
            } elseif ($get_pmsassignment_settings->frequency == "yearly") {
                $assignment_period = $start_date . " - " . $end_date;
            }


            $graph_data['label'][] = $assignment_period;

            // if ($status == 'Self') {

            //     $check_assigned_period = VmtPmsKpiFormAssignedV3::join('vmt_pms_kpiform_reviews_v3', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id', '=', 'vmt_pms_kpiform_assigned_v3.id')
            //         ->where('vmt_pms_kpiform_assigned_v3.assignee_id', $user_id)->where('vmt_pms_assignment_v3_id', $single_period['id'])->first(['vmt_pms_kpiform_assigned_v3.id', 'vmt_pms_kpiform_reviews_v3.reviewer_score']) ?? null;

            //     if ($check_assigned_period != null) {
            //         $graph_data['reviewer']['score'][] = $this->recordFormFinalKpiScore($check_assigned_period->id);
            //         $graph_data['assignee']['score'][] = (int) $check_assigned_period->reviewer_score;

            //     } else {
            //         $graph_data['reviewer']['score'][] = 0;
            //         $graph_data['assignee']['score'][] = 0;
            //     }
            // } elseif ($status == 'Team') {

            //     $check_assigned_period[] = VmtPmsKpiFormAssignedV3::join('vmt_pms_kpiform_reviews_v3', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id', '=', 'vmt_pms_kpiform_assigned_v3.id')
            //         ->where('vmt_pms_kpiform_assigned_v3.reviewer_id', $user_id)->where('vmt_pms_assignment_v3_id', $single_period['id'])->get(['vmt_pms_kpiform_assigned_v3.id', 'vmt_pms_kpiform_reviews_v3.reviewer_score'])->toArray() ?? null;

            //     if (!empty($check_assigned_period)) {
            //         $k = 0;
            //         foreach ($check_assigned_period as $single_value) {
            //             $self_score = 0;
            //             $l1_reviewer_score = 0;
            //             $i = 0;
            //             $j = 0;

            //             if (!empty($single_value)) {
            //                 foreach ($single_value as $single_period) {

            //                     if (!empty($single_period['reviewer_score'])) {
            //                         $self_score += (int)($single_period['reviewer_score']);
            //                         $l1_reviewer_score +=  $this->recordFormFinalKpiScore($single_period['id']);
            //                         $i++;
            //                     }
            //             }
            //         }
            //             if($i>0){
            //               $score = $self_score/$i;
            //               $l1_reviewer = $l1_reviewer_score/$i;
            //             }else{
            //                 $score = $self_score;
            //                 $l1_reviewer = $l1_reviewer_score;
            //             }

            //             $graph_data['assignee']['score'][$k] = round($score);
            //             $graph_data['reviewer']['score'][$k] = round($l1_reviewer);
            //             $k++;
            //         }
            //     }else{
            //         $graph_data['reviewer']['score'][] = 0;
            //         $graph_data['assignee']['score'][] = 0;
            //     }

            // } elseif ($status == 'Org') {

            //     $check_assigned_period[] = VmtPmsKpiFormAssignedV3::join('vmt_pms_kpiform_reviews_v3', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id', '=', 'vmt_pms_kpiform_assigned_v3.id')
            //     ->where('vmt_pms_assignment_v3_id', $single_period['id'])->get(['vmt_pms_kpiform_assigned_v3.id', 'vmt_pms_kpiform_reviews_v3.reviewer_score'])->toArray() ?? null;

            // if (!empty($check_assigned_period)) {
            //     $k = 0;
            //     foreach ($check_assigned_period as $single_value) {
            //         $self_score = 0;
            //         $l1_reviewer_score = 0;
            //         $i = 0;
            //         $j = 0;

            //         if (!empty($single_value)) {
            //             foreach ($single_value as $single_period) {

            //                 if (!empty($single_period['reviewer_score'])) {
            //                     $self_score += (int)($single_period['reviewer_score']);
            //                     $l1_reviewer_score +=  $this->recordFormFinalKpiScore($single_period['id']);
            //                     $i++;
            //                 }
            //         }
            //     }
            //         if($i>0){
            //           $score = $self_score/$i;
            //           $l1_reviewer = $l1_reviewer_score/$i;
            //         }else{
            //             $score = $self_score;
            //             $l1_reviewer = $l1_reviewer_score;
            //         }

            //         $graph_data['assignee']['score'][$k] = round($score);
            //         $graph_data['reviewer']['score'][$k] = round($l1_reviewer);
            //         $k++;
            //     }
            // }else{
            //     $graph_data['reviewer']['score'][] = 0;
            //     $graph_data['assignee']['score'][] = 0;
            // }


            // }

        }

        $graph_data['reviewer']['labels_name'] = 'Reviewer Score';
        $graph_data['assignee']['labels_name'] = 'Self Review Score';

        return $graph_data;
    }

    public function pmsDashboardSelfReviewsScore($user_code, $assignment_id, $status)
    {

        if(is_array($assignment_id)){
            foreach($assignment_id as $single_vlaue){
                $array_assignment_id[] = ($single_vlaue['id']);
            }
         }else{
            $array_assignment_id =  [$assignment_id];
         }

        $users_query = User::where('user_code', $user_code)->first();
        $user_id = $users_query->id;
        $get_pmsassignment_settings = VmtPMSassignment_settings_v3::where('client_id', $users_query->client_id)->whereIn('id', $array_assignment_id)->first();
        $get_assingmentv3 = VmtPmsAssignmentV3::where('pms_assignment_settings_id', $get_pmsassignment_settings->id)->get();

        $i = 0;
        $self_score = 0;
        foreach ($get_assingmentv3 as $single_period) {

            if ($status == "Self") {

                $check_assigned_period = VmtPmsKpiFormAssignedV3::join('vmt_pms_kpiform_reviews_v3', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id', '=', 'vmt_pms_kpiform_assigned_v3.id')
                    ->where('vmt_pms_kpiform_assigned_v3.assignee_id', $user_id)->where('vmt_pms_assignment_v3_id', $single_period['id'])->first(['vmt_pms_kpiform_assigned_v3.id', 'vmt_pms_kpiform_reviews_v3.reviewer_score']) ?? null;

                if ($check_assigned_period != null) {
                    $self_score += (int) $check_assigned_period->reviewer_score;
                    $i++;
                }

            } else if ($status == "Team") {

                $check_assigned_period[] = VmtPmsKpiFormAssignedV3::join('vmt_pms_kpiform_reviews_v3', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id', '=', 'vmt_pms_kpiform_assigned_v3.id')
                    ->where('vmt_pms_kpiform_assigned_v3.reviewer_id', $user_id)->where('vmt_pms_assignment_v3_id', $single_period['id'])->get(['vmt_pms_kpiform_assigned_v3.id', 'vmt_pms_kpiform_reviews_v3.reviewer_score'])->toArray() ?? null;

                foreach ($check_assigned_period as $single_value) {
                    if (!empty($single_value)) {
                        foreach ($single_value as $single_period) {
                            $self_score += $single_period['reviewer_score'];
                            $i++;
                        }
                    }
                }

            } else if ($status == "Org") {

                $check_assigned_period[] = VmtPmsKpiFormAssignedV3::join('vmt_pms_kpiform_reviews_v3', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id', '=', 'vmt_pms_kpiform_assigned_v3.id')
                    ->where('vmt_pms_assignment_v3_id', $single_period['id'])->get(['vmt_pms_kpiform_assigned_v3.id', 'vmt_pms_kpiform_reviews_v3.reviewer_score'])->toArray() ?? null;

                foreach ($check_assigned_period as $single_value) {
                    if (!empty($single_value)) {
                        foreach ($single_value as $single_period) {
                            $self_score += $single_period['reviewer_score'];
                            $i++;
                        }
                    }
                }

            }
        }

        if ($i > 0) {
            $score = $self_score / $i++;
        } else {
            $score = $self_score;
        }
        return round($score);
    }

    public function pmsDashboardReviewerScore($user_code, $assignment_id, $status)
    {


        $users_query = User::where('user_code', $user_code)->first();
        $user_id = $users_query->id;
        $get_pmsassignment_settings = VmtPMSassignment_settings_v3::where('client_id', $users_query->client_id)->where('id', $assignment_id)->first();
        $get_assingmentv3 = VmtPmsAssignmentV3::where('pms_assignment_settings_id', $get_pmsassignment_settings->id)->get();
        $i = 0;
        $l1_reviewer_score = 0;
        foreach ($get_assingmentv3 as $single_period) {

            if ($status == 'Self') {

                $check_assigned_period = VmtPmsKpiFormAssignedV3::join('vmt_pms_kpiform_reviews_v3', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id', '=', 'vmt_pms_kpiform_assigned_v3.id')
                    ->where('vmt_pms_kpiform_assigned_v3.assignee_id', $user_id)->where('vmt_pms_assignment_v3_id', $single_period['id'])->first(['vmt_pms_kpiform_assigned_v3.id', 'vmt_pms_kpiform_reviews_v3.reviewer_details']) ?? null;

                if ($check_assigned_period != null) {
                    $json_details = json_decode($check_assigned_period['reviewer_details'], true);
                    foreach ($json_details as $single_reviewer) {
                        if ($single_reviewer['reviewer_level'] == 'L1') {
                            if ($single_reviewer['is_reviewed'] == '1') {
                                $l1_reviewer_score += (int) $single_reviewer['reviewer_score'];
                                $i++;
                            }
                        }
                    }
                }
            } else if ($status == 'Team') {

                $check_assigned_period[] = VmtPmsKpiFormAssignedV3::join('vmt_pms_kpiform_reviews_v3', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id', '=', 'vmt_pms_kpiform_assigned_v3.id')
                    ->where('vmt_pms_kpiform_assigned_v3.reviewer_id', $user_id)->where('vmt_pms_assignment_v3_id', $single_period['id'])->get(['vmt_pms_kpiform_assigned_v3.id', 'vmt_pms_kpiform_reviews_v3.reviewer_details'])->toArray() ?? null;

                if (!empty($check_assigned_period)) {
                    foreach ($check_assigned_period as $single_value) {
                        if (!empty($single_value)) {
                            foreach ($single_value as $single_period) {
                                $json_details = json_decode($single_period['reviewer_details'], true);
                                foreach ($json_details as $single_reviewer) {
                                    if ($single_reviewer['reviewer_level'] == 'L1') {
                                        if ($single_reviewer['is_reviewed'] == '1') {
                                            $l1_reviewer_score += (int) $single_reviewer['reviewer_score'];
                                            $i++;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

            } else if ($status == 'Org') {

                $check_assigned_period[] = VmtPmsKpiFormAssignedV3::join('vmt_pms_kpiform_reviews_v3', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id', '=', 'vmt_pms_kpiform_assigned_v3.id')
                    ->where('vmt_pms_assignment_v3_id', $single_period['id'])->get(['vmt_pms_kpiform_assigned_v3.id', 'vmt_pms_kpiform_reviews_v3.reviewer_details'])->toArray() ?? null;

                if (!empty($check_assigned_period)) {
                    foreach ($check_assigned_period as $single_value) {
                        if (!empty($single_value)) {
                            foreach ($single_value as $single_period) {
                                $json_details = json_decode($single_period['reviewer_details'], true);
                                foreach ($json_details as $single_reviewer) {
                                    if ($single_reviewer['reviewer_level'] == 'L1') {
                                        if ($single_reviewer['is_reviewed'] == '1') {
                                            $l1_reviewer_score += (int) $single_reviewer['reviewer_score'];
                                            $i++;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }



        if ($i > 0) {
            $score = $l1_reviewer_score / $i++;
        } else {
            $score = $l1_reviewer_score;
        }
        return round($score);

    }

    public function pmsDashboardQuaterlyScoreCard($user_code, $assignment_id,$status)
    {

        $users_query = User::where('user_code', $user_code)->first();
        $user_id = $users_query->id;
        $get_pmsassignment_settings = VmtPMSassignment_settings_v3::where('id', $assignment_id)->first();
        $get_assingmentv3 = VmtPmsAssignmentV3::where('pms_assignment_settings_id', $assignment_id)->get()->toArray();
                    // dd($get_pmsassignment_settings,$get_assingmentv3);
        $i = 0;
        $j = 0;
        $get_quarterly_self = [];
        foreach ($get_assingmentv3 as $single_period) {
            if ($get_pmsassignment_settings->frequency == 'monthly') {

            if($status == 'Self'){

                if ($i % 3 == 0) {
                    $j++;
                }
                $self_reviews[$j][$i] = VmtPmsKpiFormAssignedV3::join('vmt_pms_kpiform_reviews_v3', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id', '=', 'vmt_pms_kpiform_assigned_v3.id')
                    ->where('vmt_pms_kpiform_assigned_v3.assignee_id', $user_id)->where('vmt_pms_assignment_v3_id', $single_period['id'])->first(['vmt_pms_kpiform_reviews_v3.reviewer_score']) ?? null;
                $reviewer = VmtPmsKpiFormAssignedV3::where('assignee_id', $user_id)->where('vmt_pms_assignment_v3_id', $single_period['id'])->first() ?? null;
                if ($reviewer != null) {
                    $reviews[$j][$i] = $this->recordFormFinalKpiScore($reviewer->id);
                } else {
                    $reviews[$j][$i] = null;
                }
                $i++;

            }elseif($status == 'Team'){

                if ($i % 3 == 0) {
                    $j++;
                }
                $self_reviews[$j][$i] = VmtPmsKpiFormAssignedV3::join('vmt_pms_kpiform_reviews_v3', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id', '=', 'vmt_pms_kpiform_assigned_v3.id')
                    ->where('vmt_pms_kpiform_assigned_v3.reviewer_id', $user_id)->where('vmt_pms_assignment_v3_id', $single_period['id'])->get(['vmt_pms_kpiform_reviews_v3.reviewer_score'])->toarray() ?? null;
                $reviewer = VmtPmsKpiFormAssignedV3::where('reviewer_id', $user_id)->where('vmt_pms_assignment_v3_id', $single_period['id'])->get('id')->toArray() ?? null;
                // dd($reviewer);
                if (!empty($reviewer)) {
                    foreach($reviewer as $single_value){
                    $reviewer_review[$j][$i][] = $this->recordFormFinalKpiScore($single_value['id']);
                    }
                } else {
                    $reviewer_review[$j][$i][] = null;
                }
                $i++;

            }elseif($status == 'Org'){

                if ($i % 3 == 0) {
                    $j++;
                }
                $self_reviews[$j][$i] = VmtPmsKpiFormAssignedV3::join('vmt_pms_kpiform_reviews_v3', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id', '=', 'vmt_pms_kpiform_assigned_v3.id')
                    ->where('vmt_pms_assignment_v3_id', $single_period['id'])->get(['vmt_pms_kpiform_reviews_v3.reviewer_score'])->toarray() ?? null;
                $reviewer = VmtPmsKpiFormAssignedV3::where('vmt_pms_assignment_v3_id', $single_period['id'])->get('id')->toArray() ?? null;
                // dd($reviewer);
                if (!empty($reviewer)) {
                    foreach($reviewer as $single_value){
                    $reviewer_review[$j][$i][] = $this->recordFormFinalKpiScore($single_value['id']);
                    }
                } else {
                    $reviewer_review[$j][$i][] = null;
                }
                $i++;

            }


            } elseif ($get_pmsassignment_settings->frequency == 'quarterly') {

                if($status == "Self"){

                $reviewer_score = VmtPmsKpiFormAssignedV3::join('vmt_pms_kpiform_reviews_v3', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id', '=', 'vmt_pms_kpiform_assigned_v3.id')
                    ->where('vmt_pms_kpiform_assigned_v3.assignee_id', $user_id)->where('vmt_pms_assignment_v3_id', $single_period['id'])->first()->reviewer_score ?? 0;
                array_push($get_quarterly_self, (int)$reviewer_score);
                $reviewer = VmtPmsKpiFormAssignedV3::where('assignee_id', $user_id)->where('vmt_pms_assignment_v3_id', $single_period['id'])->first() ?? null;
                if ($reviewer != null) {
                    $reviews[] = $this->recordFormFinalKpiScore($reviewer->id);
                } else {
                    $reviews[] = 0;
                }

                }elseif($status == "Team"){

                    $reviewer_score = VmtPmsKpiFormAssignedV3::join('vmt_pms_kpiform_reviews_v3', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id', '=', 'vmt_pms_kpiform_assigned_v3.id')
                    ->where('vmt_pms_kpiform_assigned_v3.reviewer_id', $user_id)->where('vmt_pms_assignment_v3_id', $single_period['id'])->get('reviewer_score') ?? 0;
                array_push($get_quarterly_self, $reviewer_score);
                $reviewer = VmtPmsKpiFormAssignedV3::where('reviewer_id', $user_id)->where('vmt_pms_assignment_v3_id', $single_period['id'])->get() ?? null;

                $reviewers_value = 0;
                $j=0;
                foreach($reviewer as $single_reviews){
                    $reviewers_value += $this->recordFormFinalKpiScore($single_reviews->id);
                    $j++;
            }

                $review_score[]  = $j == 0 ? $reviewers_value : round($reviewers_value / $j);

                }elseif($status == "Org"){

                    $reviewer_score = VmtPmsKpiFormAssignedV3::join('vmt_pms_kpiform_reviews_v3', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id', '=', 'vmt_pms_kpiform_assigned_v3.id')
                    ->where('vmt_pms_assignment_v3_id', $single_period['id'])->get('reviewer_score') ?? 0;
                array_push($get_quarterly_self, $reviewer_score);
                $reviewer = VmtPmsKpiFormAssignedV3::where('vmt_pms_assignment_v3_id', $single_period['id'])->get() ?? null;

                $reviewers_value = 0;
                $j=0;
                foreach($reviewer as $single_reviews){
                    $reviewers_value += $this->recordFormFinalKpiScore($single_reviews->id);
                    $j++;
            }

                $review_score[]  = $j == 0 ? $reviewers_value : round($reviewers_value / $j);

                }
            }
        }


        if ($get_pmsassignment_settings->frequency == 'monthly') {

            if($status == 'Self'){

            foreach ($self_reviews as $single_value) {
                $k = 0;
                $selfreview_score = 0;
                foreach ($single_value as $value) {
                    if (isset($value['reviewer_score']) != null) {
                        $selfreview_score += $value['reviewer_score'];
                        $k++;
                    }
                }

                if ($k > 0) {
                    $self_score = $selfreview_score / $k;
                } else {
                    $self_score = $selfreview_score;
                }

                $final_score['self_review'][] = round($self_score);
            }

            foreach ($reviews as $single_review) {
                $l = 0;
                $review_score = 0;
                foreach ($single_review as $review_value) {
                    if ($review_value != null) {
                        $review_score += $review_value;
                        $l++;
                    }

                if ($l > 0) {
                    $reviewer_score = $review_score / $l;
                } else {
                    $reviewer_score = $review_score;
                }
            }

                $final_score['reviewer_review'][] = round($reviewer_score);
            }

        }elseif($status == 'Team'){

            // self review team score
            foreach($self_reviews as $single_quarterly_reviews){
                $k=0;
                $single_period_value =0;
                foreach($single_quarterly_reviews as $single_period){
                    $i=0;
                    $single_team=0;
                    foreach($single_period as $single_value){
                        $single_team += $single_value['reviewer_score'];
                        $i++;
                    }

                    if ($i > 0) {
                        $single_period_value += $single_team / $i;
                    } else {
                        $single_period_value += $single_team;
                    }
                  $k++;
                }
                $get_quarterly_self[] = (int)round($single_period_value / $k);
            }

            // reviewer review team score
            foreach($reviewer_review as $single_quarterly_manager_review){
                $l=0;
                $single_period_value =0;
                foreach($single_quarterly_manager_review as $single_manager_review){
                    $m=0;
                    $single_team=0;
                    foreach($single_manager_review as $single_value){

                        $single_team += $single_value ?? 0;
                        $m++;
                    }

                    if ($m > 0) {
                        $single_period_value += $single_team / $m;
                    } else {
                        $single_period_value += $single_team;
                    }
                  $l++;
                }
                $get_quarterly_team[] = (int)round($single_period_value / $l);
            }

            $final_score['self_review'] = $get_quarterly_self ?? [];
            $final_score['reviewer_review'] = $get_quarterly_team ?? [];


        }elseif($status == 'Org'){

            // dd($self_reviews);

            // self review team score
            foreach($self_reviews as $single_quarterly_reviews){
                $k=0;
                $single_period_value =0;
                foreach($single_quarterly_reviews as $single_period){
                    $i=0;
                    $single_team=0;
                    foreach($single_period as $single_value){
                        $single_team += $single_value['reviewer_score'];
                        $i++;
                    }

                    if ($i > 0) {
                        $single_period_value += $single_team / $i;
                    } else {
                        $single_period_value += $single_team;
                    }
                  $k++;
                }
                $get_quarterly_self[] = (int)round($single_period_value / $k);
            }

            // reviewer review team score
            foreach($reviewer_review as $single_quarterly_manager_review){
                $l=0;
                $single_period_value =0;
                foreach($single_quarterly_manager_review as $single_manager_review){
                    $m=0;
                    $single_team=0;
                    foreach($single_manager_review as $single_value){

                        $single_team += $single_value ?? 0;
                        $m++;
                    }

                    if ($m > 0) {
                        $single_period_value += $single_team / $m;
                    } else {
                        $single_period_value += $single_team;
                    }
                  $l++;
                }
                $get_quarterly_team[] = (int)round($single_period_value / $l);
            }

            $final_score['self_review'] = $get_quarterly_self ?? [];
            $final_score['reviewer_review'] = $get_quarterly_team ?? [];



        }

        } elseif ($get_pmsassignment_settings->frequency == 'quarterly') {

            if($status == 'Self'){
            $final_score['self_review'] = $get_quarterly_self;
            $final_score['reviewer_review'] = $reviews;
            }else if ($status == 'Team'){

                foreach($get_quarterly_self as $single_value){
                    $i=0;
                    $team_qua = 0;
                    foreach($single_value as $single_period){
                        $team_qua += $single_period['reviewer_score'];
                        $i++;
                    }
                    $final_score['self_review'][] = $i == 0 ? $team_qua : round($team_qua / $i);
                    $final_score['reviewer_review'] = $review_score;
                }
            }else if($status == 'Org'){

                foreach($get_quarterly_self as $single_value){
                    $i=0;
                    $team_qua = 0;
                    foreach($single_value as $single_period){
                        $team_qua += $single_period['reviewer_score'];
                        $i++;
                    }
                    $final_score['self_review'][] = $i == 0 ? $team_qua : round($team_qua / $i);
                    $final_score['reviewer_review'] = $review_score;
                }

            }
        }

        $final_score['label'] = ['Q1', 'Q2', 'Q3', 'Q4'];
        return $final_score;
    }


    public function pmsSelfReviewOnTime($user_code, $assignment_id)
    {

        $users_query = User::where('user_code', $user_code)->first();
        $user_id = $users_query->id;
        $get_pmsassignment_settings = VmtPMSassignment_settings_v3::where('client_id', $users_query->client_id)->where('id', $assignment_id)->first();
        $get_assingmentv3 = VmtPmsAssignmentV3::where('pms_assignment_settings_id', $get_pmsassignment_settings->id)->get();

        foreach ($get_assingmentv3 as $single_period) {

            if ($get_pmsassignment_settings->frequency == "weekly") {
                $assignment_period = $single_period['assignment_period'];
            } elseif ($get_pmsassignment_settings->frequency == "monthly") {
                $assignment_period = $single_period['assignment_period'];
            } elseif ($get_pmsassignment_settings->frequency == "quarterly") {
                $assignment_period = $single_period['assignment_period'];
            } elseif ($get_pmsassignment_settings->frequency == "half_yearly") {
                $assignment_period = $single_period['assignment_period'];
            } elseif ($get_pmsassignment_settings->frequency == "yearly") {
                $assignment_period = $single_period['assignment_period'];
            }

            $graph_data['label'][] = $assignment_period;

            $check_assigned_period = VmtPmsKpiFormAssignedV3::join('vmt_pms_kpiform_reviews_v3', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id', '=', 'vmt_pms_kpiform_assigned_v3.id')
                ->join('vmt_pms_assignment_v3', 'vmt_pms_kpiform_assigned_v3.vmt_pms_assignment_v3_id', 'vmt_pms_assignment_v3.id')
                ->where('vmt_pms_kpiform_assigned_v3.assignee_id', $user_id)
                ->where('vmt_pms_assignment_v3_id', $single_period['id'])
                ->first() ?? null;

            $reminder_dates = VmtPmsAssignmentV3::where('id', $single_period['id'])->first() ?? null;

            if ($reminder_dates != null) {

                $hr_date = $reminder_dates->duedate_hr_review == '' ? 0 : $reminder_dates->duedate_hr_review;
                $mrg_date = $reminder_dates->duedate_mgr_review == '' ? 0 : $reminder_dates->duedate_mgr_review;
                $self_date = $reminder_dates->duedate_self_review == '' ? 0 : $reminder_dates->duedate_self_review;

                if ($self_date != 0) {
                    $date[] = (int) Carbon::parse($reminder_dates->assignment_end_date)->subDays(($self_date + $mrg_date + $hr_date))->format('d');
                } else {
                    $date[] = 0;
                }
            } else {
                $date[] = 0;
            }

            if ($check_assigned_period != null) {

                if ($check_assigned_period->assignee_reviewed_date != null) {
                    $self_reviewer_date[] = (int) Carbon::parse($check_assigned_period->assignee_reviewed_date)->format('d');
                } else {
                    $self_reviewer_date[] = 0;
                }

            } else {
                $self_reviewer_date[] = 0;
            }
        }

        $graph_data['on_time_line'] = $date;
        $graph_data['self_review'] = $self_reviewer_date;

        return $graph_data;

    }

    public function pmsReviewerReviewOnTime($user_code, $assignment_id)
    {

        $users_query = User::where('user_code', $user_code)->first();
        $user_id = $users_query->id;
        $get_pmsassignment_settings = VmtPMSassignment_settings_v3::where('client_id', $users_query->client_id)->where('id', $assignment_id)->first();
        $get_assingmentv3 = VmtPmsAssignmentV3::where('pms_assignment_settings_id', $get_pmsassignment_settings->id)->get();

        foreach ($get_assingmentv3 as $single_period) {

            if ($get_pmsassignment_settings->frequency == "weekly") {
                $assignment_period = $single_period['assignment_period'];
            } elseif ($get_pmsassignment_settings->frequency == "monthly") {
                $assignment_period = $single_period['assignment_period'];
            } elseif ($get_pmsassignment_settings->frequency == "quarterly") {
                $assignment_period = $single_period['assignment_period'];
            } elseif ($get_pmsassignment_settings->frequency == "half_yearly") {
                $assignment_period = $single_period['assignment_period'];
            } elseif ($get_pmsassignment_settings->frequency == "yearly") {
                $assignment_period = $single_period['assignment_period'];
            }


            $graph_data['label'][] = $assignment_period;

            $check_assigned_period = VmtPmsKpiFormAssignedV3::join('vmt_pms_kpiform_reviews_v3', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id', '=', 'vmt_pms_kpiform_assigned_v3.id')
                ->join('vmt_pms_assignment_v3', 'vmt_pms_kpiform_assigned_v3.vmt_pms_assignment_v3_id', 'vmt_pms_assignment_v3.id')
                ->where('vmt_pms_kpiform_assigned_v3.assignee_id', $user_id)
                ->where('vmt_pms_assignment_v3_id', $single_period['id'])
                ->first() ?? null;

            $reminder_dates = VmtPmsAssignmentV3::where('id', $single_period['id'])->first() ?? null;

            if ($reminder_dates != null) {

                $hr_date = $reminder_dates->duedate_hr_review == '' ? 0 : $reminder_dates->duedate_hr_review;
                $mrg_date = $reminder_dates->duedate_mgr_review == '' ? 0 : $reminder_dates->duedate_mgr_review;

                if ($mrg_date != 0) {
                    $date[] = (int) Carbon::parse($reminder_dates->assignment_end_date)->subDays(($mrg_date + $hr_date))->format('d');
                } else {
                    $date[] = 0;
                }
            } else {
                $date[] = 0;
            }

            if ($check_assigned_period != null) {

                if ($check_assigned_period->reviewer_details) {
                    $json_value = json_decode($check_assigned_period->reviewer_details, true);
                    foreach ($json_value as $single_value) {
                        if ($single_value['reviewer_level'] == 'L1') {
                            if ($single_value['reviewed_date'] != '') {
                                $reviewer_review_date[] = (int) Carbon::parse($single_value['reviewed_date'])->format('d');
                            } else {
                                $reviewer_review_date[] = 0;
                            }
                        }
                    }
                }

            } else {

                $reviewer_review_date[] = 0;
            }
        }

        $graph_data['on_time_line'] = $date;
        $graph_data['reviewer_review'] = $reviewer_review_date;

        return $graph_data;

    }

    public function pmsDashboardprocess($user_code, $assignment_id,$status)
    {

        $users_query = User::where('user_code', $user_code)->first();
        $user_id = $users_query->id;

        if($status == 'Self'){

        $get_pmsassignment_settings = VmtPMSassignment_settings_v3::where('client_id', $users_query->client_id)->where('id', $assignment_id)->first();
        $get_assingmentv3 = VmtPmsAssignmentV3::where('pms_assignment_settings_id', $get_pmsassignment_settings->id)->pluck('id')->toArray();
        $get_assingmentv3_count = VmtPmsAssignmentV3::where('pms_assignment_settings_id', $get_pmsassignment_settings->id)->get()->count();

        $check_assigned_period = VmtPmsKpiFormAssignedV3::join('vmt_pms_kpiform_reviews_v3', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id', '=', 'vmt_pms_kpiform_assigned_v3.id')
            ->whereIn('vmt_pms_kpiform_assigned_v3.vmt_pms_assignment_v3_id', $get_assingmentv3)
            ->where('vmt_pms_kpiform_assigned_v3.assignee_id', $user_id);

        if ($check_assigned_period->exists()) {
            $goal_initiated = $check_assigned_period->get()->count();
            $self_reviews = $check_assigned_period->where('is_assignee_submitted', '1')->get()->count();
            $reviewer_reviews = $check_assigned_period->where('is_reviewer_submitted', '1')->get()->count();
        } else {
            $goal_initiated = 0;
            $self_reviews = 0;
            $reviewer_reviews = 0;
        }

        $response['labels_name'] = ['Initiated', 'Self-Review', 'Manager-Review'];
        $response['labels_value'] = [$goal_initiated, $self_reviews, $reviewer_reviews];
        $response['list'] = ['goal_initiated' => round(($goal_initiated / $get_assingmentv3_count) * 100), 'self_reviews' => round(($self_reviews / $get_assingmentv3_count) * 100), 'reviewer_reviews' => round(($reviewer_reviews / $get_assingmentv3_count) * 100)];

    }elseif($status == 'Team'){

      $employee = VmtEmployeeOfficeDetails::where('l1_manager_code',$users_query->user_code);
      $employee_id = $employee->pluck('user_id');
      $employee_count = $employee->get()->count();

        $check_assigned_period = VmtPmsKpiFormAssignedV3::join('vmt_pms_kpiform_reviews_v3', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id', '=', 'vmt_pms_kpiform_assigned_v3.id')
            ->where('vmt_pms_kpiform_assigned_v3.vmt_pms_assignment_v3_id', $assignment_id)
            ->whereIn('vmt_pms_kpiform_assigned_v3.assignee_id', $employee_id);

        if ($check_assigned_period->exists()) {
            $goal_initiated = $check_assigned_period->get()->count();
            $self_reviews = $check_assigned_period->where('is_assignee_submitted', '1')->get()->count();
            $reviewer_reviews = $check_assigned_period->where('is_reviewer_submitted', '1')->get()->count();
        } else {
            $goal_initiated = 0;
            $self_reviews = 0;
            $reviewer_reviews = 0;
        }

        $response['labels_name'] = ['Initiated', 'Self-Review', 'Manager-Review'];
        $response['labels_value'] = [$goal_initiated, $self_reviews, $reviewer_reviews];
        $response['list'] = ['goal_initiated' => round(($goal_initiated / $employee_count) * 100), 'self_reviews' => round(($self_reviews / $employee_count) * 100), 'reviewer_reviews' => round(($reviewer_reviews / $employee_count) * 100)];

    }elseif($status == 'Org'){

        $get_assingmentv3_id = VmtPmsAssignmentV3::where('id', $assignment_id)->first()->pms_assignment_settings_id;
        $get_pmsassignment_settings = VmtPMSassignment_settings_v3::where('id',$get_assingmentv3_id)->first();

        $employee = User::where('is_ssa','0')->where('active','1')->where('client_id',$get_pmsassignment_settings->client_id);
        $employee_id = $employee->pluck('id');
        $employee_count = $employee->get()->count();

          $check_assigned_period = VmtPmsKpiFormAssignedV3::join('vmt_pms_kpiform_reviews_v3', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id', '=', 'vmt_pms_kpiform_assigned_v3.id')
              ->where('vmt_pms_kpiform_assigned_v3.vmt_pms_assignment_v3_id', $assignment_id)
              ->whereIn('vmt_pms_kpiform_assigned_v3.assignee_id', $employee_id);

          if ($check_assigned_period->exists()) {
              $goal_initiated = $check_assigned_period->get()->count();
              $self_reviews = $check_assigned_period->where('is_assignee_submitted', '1')->get()->count();
              $reviewer_reviews = $check_assigned_period->where('is_reviewer_submitted', '1')->get()->count();
          } else {
              $goal_initiated = 0;
              $self_reviews = 0;
              $reviewer_reviews = 0;
          }

          $response['labels_name'] = ['Initiated', 'Self-Review', 'Manager-Review'];
          $response['labels_value'] = [$goal_initiated, $self_reviews, $reviewer_reviews];
          $response['list'] = ['goal_initiated' => round(($goal_initiated / $employee_count) * 100), 'self_reviews' => round(($self_reviews / $employee_count) * 100), 'reviewer_reviews' => round(($reviewer_reviews / $employee_count) * 100)];

    }

        return $response;

    }

    public function pmsDashboardsTendListAssingement_Period($user_code, $assignment_setting_id)
    {

        $current_settings = VmtPMSassignment_settings_v3::where('id', $assignment_setting_id)->first();
        $assinged_period = VmtPmsAssignmentV3::where('pms_assignment_settings_id', $current_settings->id)->get();

        $arr = [];

        foreach ($assinged_period as $single_period) {

            if ($current_settings->frequency == "weekly") {
                $temp['assignment_period'] = $single_period->assignment_period;
                $temp['start_date'] = $single_period->assignment_start_date;
                $temp['end_date'] = $single_period->assignment_end_date;
                $temp['assignment_id'] = $single_period->id;
            } elseif ($current_settings->frequency == "monthly") {
                $temp['assignment_period'] = Carbon::parse($single_period->assignment_start_date)->format("F");
                $temp['start_date'] = $single_period->assignment_start_date;
                $temp['end_date'] = $single_period->assignment_end_date;
                $temp['assignment_id'] = $single_period->id;
            } elseif ($current_settings->frequency == "quarterly") {
                $temp['assignment_period'] = $single_period->assignment_period;
                $temp['start_date'] = $single_period->assignment_start_date;
                $temp['end_date'] = $single_period->assignment_end_date;
                $temp['assignment_id'] = $single_period->id;
            } elseif ($current_settings->frequency == "half_yearly") {
                $temp['assignment_period'] = $single_period->assignment_period;
                $temp['start_date'] = $single_period->assignment_start_date;
                $temp['end_date'] = $single_period->assignment_end_date;
                $temp['assignment_id'] = $single_period->id;
            } elseif ($current_settings->frequency == "yearly") {
                $temp['assignment_period'] = $single_period->assignment_period;
                $temp['start_date'] = $single_period->assignment_start_date;
                $temp['end_date'] = $single_period->assignment_end_date;
                $temp['assignment_id'] = $single_period->id;
            }
            array_push($arr, $temp);
        }

        return $arr;
    }

    public function pmsDashboardsTendList($user_code, $assignmentv3_id)
    {

        $user_id = User::where('user_code', $user_code)->first()->id;

        $check_assigned_period = VmtPmsKpiFormAssignedV3::join('vmt_pms_kpiform_reviews_v3', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id', '=', 'vmt_pms_kpiform_assigned_v3.id')
            ->where('vmt_pms_kpiform_assigned_v3.vmt_pms_assignment_v3_id', $assignmentv3_id)
            ->where('vmt_pms_kpiform_assigned_v3.assignee_id', $user_id)->first();

        if ($check_assigned_period != null) {

            $json_tend_list_flow_type_1 = [
                'Goal Published' => ['process' => 'Goal Published', 'status' => '-', 'days' => '-', 'is_overdue' => '0'],
                'Self-Review' => ['process' => 'Self-Review', 'status' => '-', 'days' => '-', 'is_overdue' => '0'],
                'Manager-Review' => ['process' => 'Manager-Review', 'status' => '-', 'days' => '-', 'is_overdue' => '0'],
                'l2_Manager-Review' => ['process' => 'L2-Manager-Review', 'status' => '-', 'days' => '-', 'is_overdue' => '0'],
                'l3_Manager-Review' => ['process' => 'L3-Manager-Review', 'status' => '-', 'days' => '-', 'is_overdue' => '0'],
                'HR-Review' => ['process' => 'HR-Review', 'status' => '-', 'days' => '-', 'is_overdue' => '0']
            ];

            $json_tend_list_flow_type_2 = [
                'Goal Published' => ['process' => 'Goal Published', 'status' => '-', 'days' => '-', 'is_overdue' => '0'],
                'Employee-Accepted' => ['process' => 'Employee-Accepted', 'status' => '-', 'days' => '-', 'is_overdue' => '0'],
                'Self-Review' => ['process' => 'Self-Review', 'status' => '-', 'days' => '-', 'is_overdue' => '0'],
                'Manager-Review' => ['process' => 'Manager-Review', 'status' => '-', 'days' => '-', 'is_overdue' => '0'],
                'l2_Manager-Review' => ['process' => 'L2-Manager-Review', 'status' => '-', 'days' => '-', 'is_overdue' => '0'],
                'l3_Manager-Review' => ['process' => 'L3-Manager-Review', 'status' => '-', 'days' => '-', 'is_overdue' => '0'],
                'HR-Review' => ['process' => 'HR-Review', 'status' => '-', 'days' => '-', 'is_overdue' => '0']
            ];


            $json_tend_list_flow_type_3 = [
                'Goal Published' => ['process' => 'Goal Published', 'status' => '-', 'days' => '-', 'is_overdue' => '0'],
                'Manager-Approval' => ['process' => 'Manager-Approval', 'status' => '-', 'days' => '-', 'is_overdue' => '0'],
                'Self-Review' => ['process' => 'Self-Review', 'status' => '-', 'days' => '-', 'is_overdue' => '0'],
                'Manager-Review' => ['process' => 'Manager-Review', 'status' => '-', 'days' => '-', 'is_overdue' => '0'],
                'l2_Manager-Review' => ['process' => 'L2-Manager-Review', 'status' => '-', 'days' => '-', 'is_overdue' => '0'],
                'l3_Manager-Review' => ['process' => 'L3-Manager-Review', 'status' => '-', 'days' => '-', 'is_overdue' => '0'],
                'HR-Review' => ['process' => 'HR-Review', 'status' => '-', 'days' => '-', 'is_overdue' => '0']
            ];

            if ($check_assigned_period->flow_type == '3') {
                $basic_structure = $json_tend_list_flow_type_3;
            } elseif ($check_assigned_period->flow_type == '2') {
                $basic_structure = $json_tend_list_flow_type_2;
            } elseif ($check_assigned_period->flow_type == '1') {
                $basic_structure = $json_tend_list_flow_type_1;
            }

            //Check whether the tendlist related settings(Due dates) are available in PMS settings
            $assigned_records = VmtPmsKpiFormAssignedV3::join('vmt_pms_kpiform_reviews_v3', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id', '=', 'vmt_pms_kpiform_assigned_v3.id')->where('vmt_pms_kpiform_assigned_v3.id', $check_assigned_period->vmt_kpiform_assigned_v3_id)->first() ?? null;
            // dd($assigned_records->reviewer_details);
            $expected_complete_date = VmtPmsAssignmentV3::where('id', $assigned_records->vmt_pms_assignment_v3_id)->first() ?? null;

            $error_array = [];

            if (empty($expected_complete_date->duedate_goal_initiate))
                array_push($error_array, 'Due Date : Goal Initiate');
            if (empty($expected_complete_date->duedate_emp_mgr_approval))
                array_push($error_array, 'Due Date : Approval/Acceptance');
            if (empty($expected_complete_date->duedate_self_review))
                array_push($error_array, 'Due Date : Self Review');
            if (empty($expected_complete_date->duedate_mgr_review))
                array_push($error_array, 'Due Date : Manager Review');
            if (empty($expected_complete_date->duedate_hr_review))
                array_push($error_array, 'Due Date : HR Review');

            //If any of the due date settings are not set , then throw error
            if (count($error_array) > 0) {

                return response()->json([
                    'status' => 'failure',
                    'message' => 'Unable to show form timeline since due dates are not set for the below options. Kindly set them PMS Settings page.\n',
                    'data' => $error_array
                ], 400);

            }


            $start_date_of_month = Carbon::parse($expected_complete_date->assignment_start_date);
            $end_date_of_month = Carbon::parse($expected_complete_date->assignment_end_date);
            $current_date = Carbon::now()->format('d-M-Y');


            $duedate_goal_initiate = "";
            $duedate_emp_mgr_approval = "";

            $duedate_goal_initiate = $start_date_of_month->clone()->addDays($expected_complete_date->duedate_goal_initiate)->format('d-M-Y');
            $duedate_emp_mgr_approval = $start_date_of_month->clone()->addDays($expected_complete_date->duedate_goal_initiate + $expected_complete_date->duedate_emp_mgr_approval)->format('d-M-Y');
            $duedate_self_review = $end_date_of_month->clone()->subDays($expected_complete_date->duedate_self_review)->format('d-M-Y');
            $duedate_mgr_review = Carbon::createFromFormat('d-M-Y', $duedate_self_review)->addDays($expected_complete_date->duedate_mgr_review)->format('d-M-Y');
            $duedate_hr_review = Carbon::createFromFormat('d-M-Y', $duedate_mgr_review)->addDays($expected_complete_date->duedate_hr_review)->format('d-M-Y');

            $goal_initiated_date = VmtPmsKpiFormAssignedV3::where('id', $assigned_records->vmt_kpiform_assigned_v3_id)->first();

            $form_approve_details = VmtPmsKpiFormReviewsV3::where('vmt_kpiform_assigned_v3_id', $goal_initiated_date->id)->first();

            $form_review_details = json_decode($form_approve_details->reviewer_details, true);

            $hr_manager_reviewed_date = "";
            $L1_manager_reviewed_date = "";
            $L2_manager_reviewed_date = "";
            $L3_manager_reviewed_date = "";

            $reviewer_array = array();
            array_push($reviewer_array, 'Employee-Accepted', 'Goal Published', 'Manager-Approval', 'Self-Review');

            foreach ($form_review_details as $key => $single_review_details) {

                if ($single_review_details['reviewer_level'] == 'L1') {

                    $L1_manager_approved_date = $single_review_details['acceptreject_date'];
                    $L1_manager_reviewed_date = $single_review_details['is_reviewed'] == 1 ? $single_review_details['reviewed_date'] : '';
                    $L1_manager_reviewed_status = $single_review_details['is_reviewed'];
                    $L1_manager_accepted_status = $single_review_details['is_accepted'];

                    array_push($reviewer_array, 'Manager-Review');
                }


                if ($single_review_details['reviewer_level'] == 'L2') {

                    $L2_manager_approved_date = $single_review_details['acceptreject_date'];
                    $L2_manager_reviewed_date = $single_review_details['is_reviewed'] == 1 ? $single_review_details['reviewed_date'] : '';
                    $L2_manager_reviewed_status = $single_review_details['is_reviewed'];
                    array_push($reviewer_array, 'l2_Manager-Review');
                }

                if ($single_review_details['reviewer_level'] == 'L3') {

                    $L3_manager_approved_date = $single_review_details['acceptreject_date'];
                    $L3_manager_reviewed_date = $single_review_details['is_reviewed'] == 1 ? $single_review_details['reviewed_date'] : '';
                    $L3_manager_reviewed_status = $single_review_details['is_reviewed'];
                    array_push($reviewer_array, 'l3_Manager-Review');
                }

                if ($single_review_details['reviewer_level'] == 'HR') {

                    $hr_manager_reviewed_date = $single_review_details['is_reviewed'] == 1 ? $single_review_details['reviewed_date'] : '';
                    array_push($reviewer_array, 'HR-Review');
                }

            }

            //  dd($reviewer_array);

            $goal_published_status = "";
            $manager_approval_status = "";
            $self_review_status = "";
            $manager_review_status = "";
            $hr_review_status = "";
            $employee_accepted_status = "";


            $i = 0;
            foreach ($basic_structure as $flow_key => $single_flow_type) {

                if (in_array($flow_key, $reviewer_array)) {


                    if ($flow_key == "Goal Published") {

                        $actual_date = !empty($goal_initiated_date->goal_initiated_date) ? Carbon::parse($goal_initiated_date->goal_initiated_date)->format('d-M-Y') : '';

                        $status = !empty($actual_date) ? $actual_date <= $duedate_goal_initiate ? 'On-Time' : 'Over-Time' : '-';
                        $is_overdue = !empty($actual_date) ? $actual_date <= $duedate_goal_initiate ? '0' : '1' : '-';
                        $days = !empty($actual_date) ? $actual_date <= $duedate_goal_initiate ? '- ' . Carbon::parse($actual_date)->diffInDays(Carbon::parse($duedate_goal_initiate)) . 'Days' : '+ ' . Carbon::parse($actual_date)->diffInDays(Carbon::parse($duedate_goal_initiate)) . ' Days' : '-';

                        $assigned_form_status[$i] = $basic_structure[$flow_key];
                        $assigned_form_status[$i]['status'] = $status;
                        $assigned_form_status[$i]['days'] = $days;
                        $assigned_form_status[$i]['is_overdue'] = $is_overdue;

                    }

                    if ($flow_key == "Manager-Approval") {

                        $approve_actual_date = !empty($L1_manager_approved_date) ? Carbon::parse($L1_manager_approved_date)->format('d-M-Y') : '';

                        $status = !empty($approve_actual_date) ? $approve_actual_date <= $duedate_emp_mgr_approval ? 'On-Time' : 'Over-Time' : '-';
                        $is_overdue = !empty($approve_actual_date) ? $approve_actual_date <= $duedate_emp_mgr_approval ? '0' : '1' : '-';
                        $days = !empty($approve_actual_date) ? $approve_actual_date <= $duedate_emp_mgr_approval ? '- ' . Carbon::parse($approve_actual_date)->diffInDays(Carbon::parse($duedate_emp_mgr_approval)) . ' Days' : '+ ' . Carbon::parse($approve_actual_date)->diffInDays(Carbon::parse($duedate_emp_mgr_approval)) . ' Days' : '-';

                        $assigned_form_status[$i] = $basic_structure[$flow_key];
                        $assigned_form_status[$i]['status'] = $status;
                        $assigned_form_status[$i]['days'] = $days;
                        $assigned_form_status[$i]['is_overdue'] = $is_overdue;

                    }


                    if ($flow_key == "Employee-Accepted") {

                        $emp_actual_date = !empty($form_approve_details->assignee_acceptreject_date) ? Carbon::parse($form_approve_details->assignee_acceptreject_date)->format('d-M-Y') : '';

                        $status = !empty($emp_actual_date) ? $emp_actual_date <= $duedate_emp_mgr_approval ? 'On-Time' : 'Over-Time' : '-';
                        $is_overdue = !empty($emp_actual_date) ? $emp_actual_date <= $duedate_emp_mgr_approval ? '0' : '1' : '-';
                        $days = !empty($emp_actual_date) ? $emp_actual_date <= $duedate_emp_mgr_approval ? '- ' . Carbon::parse($emp_actual_date)->diffInDays(Carbon::parse($duedate_emp_mgr_approval)) . ' Days' : '+ ' . Carbon::parse($emp_actual_date)->diffInDays(Carbon::parse($duedate_emp_mgr_approval)) . ' Days' : '-';

                        $assigned_form_status[$i] = $basic_structure[$flow_key];
                        $assigned_form_status[$i]['status'] = $status ?? '-';
                        $assigned_form_status[$i]['days'] = $days;
                        $assigned_form_status[$i]['is_overdue'] = $is_overdue;

                    }


                    if ($flow_key == "Self-Review") {

                        $self_actual_date = !empty($form_approve_details->assignee_reviewed_date) ? Carbon::parse($form_approve_details->assignee_reviewed_date)->format('d-M-Y') : '';

                        $status = !empty($self_actual_date) ? $self_actual_date <= $duedate_self_review ? 'On-Time' : 'Over-Time' : '-';
                        $is_overdue = !empty($self_actual_date) ? $self_actual_date <= $duedate_self_review ? '0' : '1' : '-';
                        $days = !empty($self_actual_date) ? $self_actual_date <= $duedate_self_review ? '- ' . Carbon::parse($self_actual_date)->diffInDays(Carbon::parse($duedate_self_review)) . ' Days' : '+ ' . Carbon::parse($self_actual_date)->diffInDays(Carbon::parse($duedate_self_review)) . ' Days' : '-';


                        $assigned_form_status[$i] = $basic_structure[$flow_key];
                        $assigned_form_status[$i]['status'] = $status ?? '-';
                        $assigned_form_status[$i]['days'] = $days;
                        $assigned_form_status[$i]['is_overdue'] = $is_overdue;

                    }

                    if ($flow_key == "Manager-Review") {

                        $l1_actual_date = !empty($L1_manager_reviewed_date) ? Carbon::parse($L1_manager_reviewed_date)->format('d-M-Y') : '';

                        $status = !empty($l1_actual_date) ? $l1_actual_date <= $duedate_mgr_review ? 'On-Time' : 'Over-Time' : '-';
                        $is_overdue = !empty($l1_actual_date) ? $l1_actual_date <= $duedate_mgr_review ? '0' : '1' : '-';
                        $days = !empty($l1_actual_date) ? $l1_actual_date <= $duedate_mgr_review ? '- ' . Carbon::parse($l1_actual_date)->diffInDays(Carbon::parse($duedate_mgr_review)) . ' Days' : '+ ' . Carbon::parse($l1_actual_date)->diffInDays(Carbon::parse($duedate_mgr_review)) . " Days" : '-';

                        $assigned_form_status[$i] = $basic_structure[$flow_key];
                        $assigned_form_status[$i]['status'] = $status ?? '-';
                        $assigned_form_status[$i]['days'] = $days;
                        $assigned_form_status[$i]['is_overdue'] = $is_overdue;

                    }
                    if ($flow_key == "l2_Manager-Review") {

                        $l2_actual_date = !empty($L2_manager_reviewed_date) ? Carbon::parse($L2_manager_reviewed_date)->format('d-M-Y') : '';

                        $status = !empty($l2_actual_date) ? $l2_actual_date <= $duedate_mgr_review ? 'On-Time' : 'Over-Time' : '-';
                        $is_overdue = !empty($l2_actual_date) ? $l2_actual_date <= $duedate_mgr_review ? '0' : '1' : '-';
                        $days = !empty($l2_actual_date) ? $l2_actual_date <= $duedate_mgr_review ? '- ' . Carbon::parse($l2_actual_date)->diffInDays(Carbon::parse($duedate_mgr_review)) . ' Days' : '+ ' . Carbon::parse($l2_actual_date)->diffInDays(Carbon::parse($duedate_mgr_review)) . ' Days' : '-';

                        $assigned_form_status[$i] = $basic_structure[$flow_key];
                        $assigned_form_status[$i]['status'] = $status ?? '-';
                        $assigned_form_status[$i]['days'] = $days;
                        $assigned_form_status[$i]['is_overdue'] = $is_overdue;

                    }

                    if ($flow_key == "l3_Manager-Review") {

                        $l3_actual_date = !empty($L3_manager_reviewed_date) ? Carbon::parse($L3_manager_reviewed_date)->format('d-M-Y') : '';

                        $status = !empty($l3_actual_date) ? $l3_actual_date <= $duedate_mgr_review ? 'On-Time' : 'Over-Time' : '-';
                        $is_overdue = !empty($l3_actual_date) ? $l3_actual_date <= $duedate_mgr_review ? '0' : '1' : '-';
                        $days = !empty($l3_actual_date) ? $l3_actual_date <= $duedate_mgr_review ? '- ' . Carbon::parse($l3_actual_date)->diffInDays(Carbon::parse($duedate_mgr_review)) . ' Days' : '+ ' . Carbon::parse($l3_actual_date)->diffInDays(Carbon::parse($duedate_mgr_review)) . ' Days' : '-';

                        $assigned_form_status[$i] = $basic_structure[$flow_key];
                        $assigned_form_status[$i]['status'] = $status ?? '';
                        $assigned_form_status[$i]['days'] = $days;
                        $assigned_form_status[$i]['is_overdue'] = $is_overdue;

                    }
                    if ($flow_key == "HR-Review") {
                        $hr_actual_date = !empty($hr_manager_reviewed_date) ? Carbon::parse($hr_manager_reviewed_date)->format('d-M-Y') : '';

                        $status = !empty($hr_actual_date) ? $hr_actual_date <= $duedate_hr_review ? 'On-Time' : 'Over-Time' : '-';
                        $is_overdue = !empty($hr_actual_date) ? $hr_actual_date <= $duedate_hr_review ? '0' : '1' : '-';
                        $days = !empty($hr_actual_date) ? $hr_actual_date <= $duedate_hr_review ? '- ' . Carbon::parse($hr_actual_date)->diffInDays(Carbon::parse($duedate_hr_review)) . ' Days' : '+ ' . Carbon::parse($hr_actual_date)->diffInDays(Carbon::parse($duedate_hr_review)) . " Days" : '-';

                        $assigned_form_status[$i] = $basic_structure[$flow_key];
                        $assigned_form_status[$i]['status'] = $status ?? '';
                        $assigned_form_status[$i]['days'] = $days;
                        $assigned_form_status[$i]['is_overdue'] = $is_overdue;

                    }

                    $i++;
                }
            }

            return response()->json([
                'status' => 'success',
                'data' => $assigned_form_status,
            ]);

        } else {

            return response()->json([
                'status' => 'failure',
                'data' => [],
            ]);

        }


    }


    public function orgAppraisalFlow($date)
    {

        $Explode_date =  explode(' - ', $date);

        $start_date = $Explode_date[0];
        $end_date = $Explode_date[1];


        $gt = VmtPmsKpiFormReviewsV3::join('vmt_pms_kpiform_assigned_v3', 'vmt_pms_kpiform_assigned_v3.id', '=', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id')
            ->join('vmt_pms_assignment_v3', 'vmt_pms_assignment_v3.id', '=', 'vmt_pms_kpiform_assigned_v3.vmt_pms_assignment_v3_id')
            ->join('vmt_pms_assignment_settings_v3', 'vmt_pms_assignment_settings_v3.id', '=', 'vmt_pms_assignment_v3.pms_assignment_settings_id')
            ->where('vmt_pms_kpiform_assigned_v3.goal_initiated_date','>=',Carbon::parse($start_date))
            ->where('vmt_pms_kpiform_assigned_v3.goal_initiated_date','<=',Carbon::parse($end_date)->endOfMonth())
            ->orderBy('vmt_pms_kpiform_assigned_v3.id', 'desc')
            ->get([
                'vmt_pms_kpiform_assigned_v3.id as id',
                'vmt_pms_kpiform_assigned_v3.assignee_id as assignee_id',
                'vmt_pms_assignment_v3.assignment_period as assignment_period',
                'vmt_pms_assignment_settings_v3.frequency as frequency',
                'vmt_pms_assignment_v3.assignment_start_date',
                'vmt_pms_assignment_v3.assignment_end_date',
                'vmt_pms_kpiform_assigned_v3.vmt_pms_kpiform_v3_id as vmt_pms_kpiform_v3_id',
                'vmt_pms_kpiform_assigned_v3.flow_type as flow_type',
                'vmt_pms_kpiform_reviews_v3.is_assignee_accepted as is_assignee_accepted',
                'vmt_pms_kpiform_reviews_v3.is_assignee_submitted as is_assignee_submitted',
                'vmt_pms_kpiform_reviews_v3.assignee_kpi_review as assignee_kpi_review',
                'vmt_pms_kpiform_reviews_v3.reviewer_details as reviewer_details',
                'vmt_pms_kpiform_reviews_v3.is_reviewer_accepted as is_reviewer_accepted',
                'vmt_pms_kpiform_reviews_v3.is_reviewer_submitted as is_reviewer_submitted',
                'vmt_pms_kpiform_reviews_v3.reviewer_kpi_review as reviewer_kpi_review',
                'vmt_pms_kpiform_reviews_v3.reviewer_kpi_percentage as reviewer_kpi_percentage',
                'vmt_pms_kpiform_reviews_v3.reviewer_kpi_comments as reviewer_kpi_comments'
            ])
            ->toarray();

        $getAllRecords = array();
        foreach ($gt as $key => $single_value) {
            // dd($single_value);
            $getAllRecords[$key]['id'] = $single_value['id'];
            $getAllRecords[$key]['assignee_id'] = $single_value['assignee_id'];
            $getAllRecords[$key]['assignee_name'] = user::where('id', $single_value['assignee_id'])->first()->name;
            $getAllRecords[$key]['avatar_or_shortname'] = json_decode(newgetEmployeeAvatarOrShortName($single_value['assignee_id']));
            $getAllRecords[$key]['assignee_code'] = user::where('id', $single_value['assignee_id'])->first()->user_code;
            $getAllRecords[$key]['score'] = $this->recordFormFinalKpiScore($single_value['id']);
            $getAllRecords[$key]['manager_name'] = $this->getL1ManagerDetails(User::where('id', $single_value['assignee_id'])->first()->user_code)['name'] ?? 'error';
            $getAllRecords[$key]['manager_code'] = $this->getL1ManagerDetails(User::where('id', $single_value['assignee_id'])->first()->user_code)['user_code'] ?? 'error';
            $getAllRecords[$key]['assignment_period'] = $this->getProcessedAssignmentPeriod($single_value['assignment_period'], $single_value['frequency'], $single_value['assignment_start_date'], $single_value['assignment_end_date']);
            $getAllRecords[$key]['is_assignee_accepted'] = $single_value['is_assignee_accepted'];
            $getAllRecords[$key]['is_assignee_submitted'] = $single_value['is_assignee_submitted'];
            $getAllRecords[$key]['assignee_kpi_review'] = json_decode($single_value['assignee_kpi_review'], true);
            $getAllRecords[$key]['reviewer_details'] = (json_decode($single_value['reviewer_details'], true));
            $getAllRecords[$key]['is_reviewer_accepted'] = $single_value['is_reviewer_accepted'];
            $getAllRecords[$key]['is_reviewer_submitted'] = $single_value['is_reviewer_submitted'];
            $getAllRecords[$key]['reviewer_kpi_review'] = json_decode($single_value['reviewer_kpi_review'], true);
            $getAllRecords[$key]['reviewer_kpi_percentage'] = $single_value['reviewer_kpi_percentage'];
            $getAllRecords[$key]['reviewer_kpi_comments'] = $single_value['reviewer_kpi_comments'];

            //Logic For Form Status
            if ($single_value['is_reviewer_accepted'] == '') {
                $getAllRecords[$key]['status'] = 'Approval Pending';
            } else if ($single_value['is_reviewer_accepted'] == -1) {
                $getAllRecords[$key]['status'] = 'Rejected';
            } else if ($single_value['is_assignee_accepted'] == '') {
                $getAllRecords[$key]['status'] = 'Accept Pending';
            } elseif ($single_value['is_reviewer_accepted'] == '1' && $single_value['is_assignee_accepted'] == '1' && $single_value['is_assignee_submitted'] == '') {
                $getAllRecords[$key]['status'] = 'Goal Published';
            } elseif ($single_value['is_assignee_submitted'] == '1' && $single_value['is_reviewer_submitted'] == '') {
                $getAllRecords[$key]['status'] = 'Employee Self Reviewed';
            }else if($single_value['is_assignee_submitted'] == '1' && $single_value['is_reviewer_submitted'] == '1'){
                $getAllRecords[$key]['status'] = 'Completed';
            }

            $form_header = VmtPmsKpiFormV3::where('id', $single_value['vmt_pms_kpiform_v3_id'])->first();
            $getAllRecords[$key]['form_header'] = json_decode($form_header->selected_headers, true);

            $form_details = VmtPmsKpiFormDetailsV3::where('vmt_pms_kpiform_v3_id', $single_value['vmt_pms_kpiform_v3_id'])
                ->join('vmt_pms_kpiform_v3', 'vmt_pms_kpiform_v3.id', '=', 'vmt_pms_kpiform_details_v3.vmt_pms_kpiform_v3_id')
                ->get(['vmt_pms_kpiform_details_v3.id', 'objective_values'])->toarray();

            $temp_arr = [];
            foreach ($form_details as $key1 => $single_value) {
                $temp_arr[$key1] = json_decode($single_value['objective_values'], true);
                $temp_arr[$key1]['id'] = $single_value['id'];
            }

            $getAllRecords[$key]['kpi_form_details'] = ['form_name' => $form_header->form_name, "form_id" => $form_header->id, 'form_details' => $temp_arr];
        }


        $self_array = [];
        foreach ($getAllRecords as $key => $single_record) {

            // show assignee created form
            if ($single_record['is_assignee_accepted'] == '1' && $single_record['is_reviewer_accepted'] == '') {

                array_push($self_array, $single_record);

                // show assignee accepted or rejected
            } else if ($single_record['is_reviewer_accepted'] == '1' && $single_record['is_assignee_accepted'] == '') {

                array_push($self_array, $single_record);

                // show assignee fill reviewer score
            } else if ($single_record['is_reviewer_accepted'] == '-1' && $single_record['is_assignee_accepted'] == '1') {

                array_push($self_array, $single_record);

            } else if ($single_record['is_reviewer_accepted'] == '1' && $single_record['is_assignee_accepted'] == '1' && ($single_record['is_assignee_submitted'] == '' || $single_record['is_assignee_submitted'] == '1') && $single_record['is_reviewer_submitted'] == '') {

                $users_details = User::where('id', $single_record['assignee_kpi_review']['assignee_id'])->first();
                // dd($single_record);

                if (!is_null($single_record['assignee_kpi_review']['assignee_kpi'])) {
                    $assigne_reviews = $single_record['assignee_kpi_review']['assignee_kpi'];

                    foreach ($single_record['kpi_form_details']['form_details'] as $key1 => $single_form) {
                        if (($single_form['id'] == isset($assigne_reviews[$key1]['form_details_id']))) {

                            $single_record['kpi_form_details']['form_details'][$key1]['assignee_review'] = array_merge($assigne_reviews[$key1], ['assignee_code' => $users_details->user_code, 'assignee_name' => $users_details->name, 'reviewer_level' => 'Self Review']) ?? $this->employee_achive;
                        } else {
                            $single_record['kpi_form_details']['form_details'][$key1]['assignee_review'] = array_merge($this->employee_achive, ['assignee_code' => $users_details->user_code, 'assignee_name' => $users_details->name, 'reviewer_level' => 'Self Review']);
                        }

                    }
                } else {

                    foreach ($single_record['kpi_form_details']['form_details'] as $key1 => $single_form) {
                        $single_record['kpi_form_details']['form_details'][$key1]['assignee_review'] = array_merge($this->employee_achive, ['assignee_code' => $users_details->user_code, "assignee_name" => $users_details->name, 'reviewer_level' => 'Self Review']);
                    }
                }
                array_push($self_array, $single_record);

                // show reviewer reviews to assignee page
            } elseif ($single_record['is_reviewer_accepted'] == '1' && $single_record['is_assignee_accepted'] == '1' && $single_record['is_assignee_submitted'] == '1' && $single_record['is_reviewer_submitted'] == '1') {

                $users_details = User::where('id', $single_record['assignee_kpi_review']['assignee_id'])->first();

                if (!is_null($single_record['assignee_kpi_review']['assignee_kpi'])) {

                    $assigne_reviews = $single_record['assignee_kpi_review']['assignee_kpi'];
                    $reviewer_reviews = $single_record['reviewer_kpi_review'];
                    foreach ($single_record['kpi_form_details']['form_details'] as $key1 => $single_form) {

                        if (($single_form['id'] == isset($assigne_reviews[$key1]['form_details_id']))) {
                            $single_record['kpi_form_details']['form_details'][$key1]['assignee_review'] = array_merge($assigne_reviews[$key1], ['assignee_code' => $users_details->user_code, 'assignee_name' => $users_details->name, 'reviewer_level' => 'Self Review']) ?? $this->employee_achive;

                            foreach ($reviewer_reviews as $key5 => $single_reviews_details) {
                                // dd($single_reviews_details);
                                foreach ($single_reviews_details['reviewer_kpi'] as $key6 => $single_kpi_value) {
                                    $temp[$key6]['reviewer_code'] = $single_reviews_details['reviewer_user_code'];
                                    $temp[$key6]['reviewer_name'] = User::where('user_code', $single_reviews_details['reviewer_user_code'])->first()->name;
                                    $temp[$key6]['reviewer_level'] = $getAllRecords[$key]['reviewer_details'][$key5]['reviewer_level'] == 'HR' ? $getAllRecords[$key]['reviewer_details'][$key5]['reviewer_level'] . " Reviews" : $getAllRecords[$key]['reviewer_details'][$key5]['reviewer_level'] . " Manager Reviews";
                                    $temp[$key6]['form_details_id'] = $single_kpi_value['form_details_id'];
                                    $temp[$key6]['kpi_review'] = $single_kpi_value['kpi_review'];
                                    $temp[$key6]['kpi_percentage'] = $single_kpi_value['kpi_percentage'];
                                    $temp[$key6]['kpi_comments'] = $single_kpi_value['kpi_comments'];
                                }
                                $single_record['kpi_form_details']['form_details'][$key1]['reviews_review'][] = $temp[$key1];
                            }
                        }
                    }

                } else {

                    foreach ($single_record['kpi_form_details']['form_details'] as $key1 => $single_form) {
                        $single_record['kpi_form_details']['form_details'][$key1]['assignee_review'] = array_merge($this->employee_achive, ['assignee_code' => $users_details->user_code, "assignee_name" => $users_details->name]);
                    }
                }
                array_push($self_array, $single_record);
            }

        }

        return $self_array;

    }

    public function pmsScoreExportReport($assignment_setting_id,$client_id,$type){

        if(is_array($assignment_setting_id)){
            foreach($assignment_setting_id as $single_vlaue){
                $array_assignment_id[] = ($single_vlaue['id']);
            }
         }else{
            $array_assignment_id =  [$assignment_setting_id];
         }


        $gt = VmtPmsKpiFormReviewsV3::join('vmt_pms_kpiform_assigned_v3', 'vmt_pms_kpiform_assigned_v3.id', '=', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id')
            ->join('vmt_pms_assignment_v3', 'vmt_pms_assignment_v3.id', '=', 'vmt_pms_kpiform_assigned_v3.vmt_pms_assignment_v3_id')
            ->join('vmt_pms_assignment_settings_v3', 'vmt_pms_assignment_settings_v3.id', '=', 'vmt_pms_assignment_v3.pms_assignment_settings_id')
            ->whereIn('vmt_pms_assignment_settings_v3.id', $array_assignment_id)
            ->orderBy('vmt_pms_kpiform_assigned_v3.id', 'desc')
            ->get([
                'vmt_pms_kpiform_assigned_v3.id as id',
                'vmt_pms_kpiform_assigned_v3.assignee_id as assignee_id',
                'vmt_pms_assignment_v3.assignment_period as assignment_period',
                'vmt_pms_assignment_settings_v3.frequency as frequency',
                'vmt_pms_assignment_v3.assignment_start_date',
                'vmt_pms_assignment_settings_v3.calendar_type',
                'vmt_pms_assignment_settings_v3.year',
                'vmt_pms_assignment_v3.assignment_end_date',
                'vmt_pms_kpiform_assigned_v3.vmt_pms_kpiform_v3_id as vmt_pms_kpiform_v3_id',
                'vmt_pms_kpiform_assigned_v3.flow_type as flow_type',
                'vmt_pms_kpiform_reviews_v3.is_assignee_accepted as is_assignee_accepted',
                'vmt_pms_kpiform_reviews_v3.is_assignee_submitted as is_assignee_submitted',
                'vmt_pms_kpiform_reviews_v3.assignee_kpi_review as assignee_kpi_review',
                'vmt_pms_kpiform_reviews_v3.reviewer_details as reviewer_details',
                'vmt_pms_kpiform_reviews_v3.is_reviewer_accepted as is_reviewer_accepted',
                'vmt_pms_kpiform_reviews_v3.is_reviewer_submitted as is_reviewer_submitted',
                'vmt_pms_kpiform_reviews_v3.reviewer_kpi_review as reviewer_kpi_review',
                'vmt_pms_kpiform_reviews_v3.reviewer_kpi_percentage as reviewer_kpi_percentage',
                'vmt_pms_kpiform_reviews_v3.reviewer_kpi_comments as reviewer_kpi_comments',
                'vmt_pms_kpiform_reviews_v3.reviewer_score'
            ])
            ->toarray();

            $getAllRecords = array();
            foreach ($gt as $key => $single_value) {
                $getAllRecords[$key]['Employee Name'] = user::where('id', $single_value['assignee_id'])->first()->name;
                $getAllRecords[$key]['Employee Code'] = user::where('id', $single_value['assignee_id'])->first()->user_code;
                 $getAllRecords[$key]['Manager Name'] = $this->getL1ManagerDetails(User::where('id', $single_value['assignee_id'])->first()->user_code)['name'] ?? 'error';
                $getAllRecords[$key]['Calendar Type'] = ucwords(str_replace("_"," ",$single_value['calendar_type']));
                if ($single_value['calendar_type'] == 'financial_year') {
                    $getAllRecords[$key]['Year'] = 'Apr-' . $single_value['year'] . ' - Mar-' . Carbon::parse('01-01-' . $single_value['year'])->addYear()->format('Y');
                } else if ($single_value['calendar_type'] == 'calendar_year') {
                    $getAllRecords[$key]['Year'] = 'Jan-' . $single_value['year'] . ' - Dec-' . $single_value['year'];
                }

                $getAllRecords[$key]['Frequency'] = $single_value['frequency'];
                $getAllRecords[$key]['Assignment Period'] = $this->getProcessedAssignmentPeriod($single_value['assignment_period'],$single_value['frequency'],$single_value['assignment_start_date'],$single_value['assignment_end_date']);

                if ($single_value['flow_type'] == 3) {
                    if ($single_value['is_reviewer_accepted'] == 1 && $single_value['is_assignee_submitted'] == '') {
                        $getAllRecords[$key]['Form Status'] = 'Goal Published';
                    } else if ($single_value['is_reviewer_accepted'] == -1 && $single_value['is_assignee_submitted'] == '') {
                        $getAllRecords[$key]['Form Status'] = 'Rejected';
                    } else if ($single_value['is_reviewer_accepted'] == '') {
                        $getAllRecords[$key]['Form Status'] = 'Approval Pending';
                    } elseif ($single_value['is_assignee_submitted'] == '1' && $single_value['is_reviewer_submitted'] == '') {
                        $getAllRecords[$key]['Form Status'] = 'Employee Reviewed';
                    } elseif ($single_value['is_assignee_submitted'] == '1' && $single_value['is_reviewer_submitted'] == '1') {
                        $getAllRecords[$key]['Form Status'] = 'Completed';
                    }
                } else if ($single_value['flow_type'] == 2) {
                    if ($single_value['is_assignee_accepted'] == 1) {
                        $getAllRecords[$key]['Form Status'] = 'Accepted';
                    } else if ($single_value['is_assignee_accepted'] == -1) {
                        $getAllRecords[$key]['Form Status'] = 'Rejected';
                    } else {
                        $getAllRecords[$key]['Form Status'] = 'Accept Pending';
                    }
                } else if ($single_value['flow_type'] == 1) {
                    if ($single_value['is_reviewer_accepted'] == 1 && $single_value['is_assignee_submitted'] == '') {
                        $getAllRecords[$key]['Form Status'] = 'Goal Published';
                    } else if ($single_value['is_reviewer_accepted'] == -1 && $single_value['is_assignee_submitted'] == '') {
                        $getAllRecords[$key]['Form Status'] = 'Rejected';
                    } else if ($single_value['is_reviewer_accepted'] == '') {
                        $getAllRecords[$key]['Form Status'] = 'Approval Pending';
                    } elseif ($single_value['is_assignee_submitted'] == '1' && $single_value['is_reviewer_submitted'] == '') {
                        $getAllRecords[$key]['Form Status'] = 'Employee Reviewed';
                    } elseif ($single_value['is_assignee_submitted'] == '1' && $single_value['is_reviewer_submitted'] == '1') {
                        $getAllRecords[$key]['Form Status'] = 'Completed';
                    }
                }

                $getAllRecords[$key]['Employee Score'] = $single_value['reviewer_score'] == null ? '-' :  $single_value['reviewer_score'];
                  $reviewer_details = json_decode($single_value['reviewer_details'],true);
                  $manager_score = '-';
               foreach($reviewer_details as $single_value){
                        if(isset($single_value['reviewer_level']) == 'L1'){
                            $manager_score = $single_value['reviewer_score'] == '' ? '-' : $single_value['reviewer_score'];
                        }else{
                            $manager_score = '-';
                        }
               }

                $getAllRecords[$key]['Manager Score'] = $manager_score;

            }

            foreach($getAllRecords[0] as $key => $single_value){
                    $arrayheading[] = $key;
            }

            if($type == 'json'){

            return $response = [
                'status' => 'Success',
                'data' => [
                    'header' => $arrayheading,
                    'value' => $getAllRecords,
                ],
            ];

        }
            $client_details = VmtClientMaster::where('id', $client_id)->first();
            $public_client_logo_path = public_path($client_details->client_logo);

            return Excel::download(new VmtPmsReviewsReport($arrayheading,$getAllRecords,$public_client_logo_path,$client_details->client_name), 'Pms Report.xlsx');

    }


    public function pmsFormExcellExport($assinged_formid){


        $gt = VmtPmsKpiFormReviewsV3::join('vmt_pms_kpiform_assigned_v3', 'vmt_pms_kpiform_assigned_v3.id', '=', 'vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id')
            ->join('vmt_pms_assignment_v3', 'vmt_pms_assignment_v3.id', '=', 'vmt_pms_kpiform_assigned_v3.vmt_pms_assignment_v3_id')
            ->join('vmt_pms_assignment_settings_v3', 'vmt_pms_assignment_settings_v3.id', '=', 'vmt_pms_assignment_v3.pms_assignment_settings_id')
            ->join('vmt_pms_kpiform_v3','vmt_pms_kpiform_assigned_v3.vmt_pms_kpiform_v3_id','=','vmt_pms_kpiform_v3.id')
            ->where('vmt_pms_kpiform_assigned_v3.id', $assinged_formid)
            ->first([
                'vmt_pms_kpiform_v3.id',
                'vmt_pms_kpiform_v3.form_name',
                'vmt_pms_assignment_settings_v3.client_id',
                'vmt_pms_kpiform_reviews_v3.assignee_kpi_review',
                'vmt_pms_kpiform_reviews_v3.reviewer_kpi_review'
            ]);

            $form_name = $gt->form_name;
            $form_details = VmtPmsKpiFormDetailsV3::where('vmt_pms_kpiform_v3_id', $gt->id)->get();
            $json_value = json_decode($gt->assignee_kpi_review,true);
            $assignee_score = ($json_value['assignee_kpi']);
            $reviews_score = json_decode($gt->reviewer_kpi_review,true);
            $l1_manager_review = $reviews_score[0]['reviewer_kpi'];

            $i=0;
            foreach($form_details as $single_value){
                  $response[$i] = json_decode($single_value->objective_values,true);
                  if(isset($assignee_score[$i]['form_details_id']) == $single_value->id){
                        $response[$i]['Employee_Achieved_target'] =  $assignee_score[$i]['kpi_review'];
                        $response[$i]['Employee_Achieved_Kpi_Weightage'] = $assignee_score[$i]['kpi_percentage'] . "%";
                        $response[$i]['Employee_Comments'] = $assignee_score[$i]['kpi_comments'];
                  }else{
                    $response[$i]['Employee_Achieved_target'] =  '-';
                    $response[$i]['Employee_Achieved_Kpi_Weightage'] = '-';
                    $response[$i]['Employee_Comments'] = '-';
                  }

                  if(isset($l1_manager_review[$i]['form_details_id']) == $single_value->id){
                    $response[$i]['L1_Manage_target'] =  $l1_manager_review[$i]['kpi_review'];
                    $response[$i]['L1_Manage_Kpi_Weightage'] = $l1_manager_review[$i]['kpi_percentage'] . "%";
                    $response[$i]['L1_Manager_Comments'] = $l1_manager_review[$i]['kpi_comments'];
                  }else{
                    $response[$i]['L1_Manage_target'] =  '-';
                    $response[$i]['L1_Manage_Kpi_Weightage'] = '-';
                    $response[$i]['L1_Manager_Comments'] = '-';
                  }

                  $i++;
            }

            foreach($response[0] as $key => $single_value){
                    $arrayheading[] = ucwords(str_replace("_"," ",$key));
            }

            $client_details = VmtClientMaster::where('id', $gt->client_id)->first();
            $public_client_logo_path = public_path($client_details->client_logo);

            return Excel::download(new VmtPmsFormDetailsReportExport($arrayheading,$response,$public_client_logo_path,$client_details->client_name,$form_name), 'Pms Form Report.xlsx');

    }

    public function pmsMasterReportExcellExport($client_id,$assignment_setting_id,$type){

        if(is_array($assignment_setting_id)){
            foreach($assignment_setting_id as $single_vlaue){
                $array_assignment_id[] = ($single_vlaue['id']);
            }
         }else{
            $array_assignment_id =  [$assignment_setting_id];
         }

      $users = User::where('client_id',$client_id)->get();
      $get_assingment_settings =  VmtPmsAssignmentV3::whereIn('pms_assignment_settings_id',$array_assignment_id)->get();

      foreach($users as $key => $single_user){
        foreach($get_assingment_settings as $key1 => $single_period){
                $arr_value[$key]['user_name'] = $single_user->name;
                $arr_value[$key][$single_period->assignment_period. '_Employee Score'] = $this->getPmsScoreForExcell($single_period->id,$single_user->id)['self_score'];
                $arr_value[$key][$single_period->assignment_period. '_Manager Score'] = $this->getPmsScoreForExcell($single_period->id,$single_user->id)['manager_score'];
                }
            }


            $i=1;
            foreach($get_assingment_settings as $key1 => $single_value1){
                      $pms_settings = VmtPMSassignment_settings_v3::where('id',$single_value1->pms_assignment_settings_id)->first();
                $array_header1[0] = 'Employee_details';
                $array_header1[$i] = $this->getProcessedAssignmentPeriod($single_value1->assignment_period, $pms_settings->frequency, $single_value1->assignment_start_date, $single_value1->assignment_end_date);
                $i++;
            }
                // dd($array_header1);
            foreach($arr_value[0] as $key => $single_value){
                    $array_header2[] =  explode('_',$key)[1];
            }

            if($type == 'json'){

                return $response = [
                    'status' => 'Success',
                    'data' => [
                        'header1' => $array_header2,
                        'header2' => $array_header1,
                        'value' => $arr_value,
                    ],
                ];
            }

        $client_details = VmtClientMaster::where('id', $client_id)->first();
        $public_client_logo_path = public_path($client_details->client_logo);


            return Excel::download(new VmtPmsMasterReviewsReport($array_header2,$arr_value,$array_header1,$public_client_logo_path,$client_details->client_name), 'Pms Master Report.xlsx');

    }

    private function getPmsScoreForExcell($assignment_period_id,$user_id){

                      $pms_period_score = VmtPmsKpiFormAssignedV3::join('vmt_pms_kpiform_reviews_v3','vmt_pms_kpiform_reviews_v3.vmt_kpiform_assigned_v3_id','=','vmt_pms_kpiform_assigned_v3.id')
                                        ->where('vmt_pms_kpiform_assigned_v3.vmt_pms_assignment_v3_id',$assignment_period_id)->where('vmt_pms_kpiform_assigned_v3.assignee_id',$user_id)
                                        ->first(['reviewer_score','reviewer_details']) ?? null;

                        if($pms_period_score != null){
                        $response['self_score'] = $pms_period_score->reviewer_score . '%';
                        $response['manager_score'] = json_decode($pms_period_score->reviewer_details,true)[0]['reviewer_score'] . '%';
                        }else{
                            $response['self_score'] = '-';
                            $response['manager_score'] = '-';
                        }

                        return $response;
            }

}
