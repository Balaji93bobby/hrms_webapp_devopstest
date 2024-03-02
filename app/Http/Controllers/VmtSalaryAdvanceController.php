<?php

namespace App\Http\Controllers;

use App\Models\Compensatory;
use App\Models\Department;
use App\Models\State;
use App\Models\User;
use App\Models\VmtClientMaster;
use App\Models\VmtEmployeeCompensatoryLeave;
use App\Models\VmtEmployeeOfficeDetails;
use Illuminate\Http\Request;
use App\Models\VmtSalaryAdvanceMasterModel;
use App\Models\VmtEmployee;
use App\Models\VmtSalaryAdvSettings;
use App\Models\VmtEmpSalAdvDetails;
use App\Models\VmtEmpAssignSalaryAdvSettings;
use App\Models\VmtInterestFreeLoanSettings;
use App\Models\VmtLoanInterestSettings;
use App\Models\VmtEmployeeInterestFreeLoanDetails;
use App\Services\VmtSalaryAdvanceService;
use Illuminate\Support\Facades\Validator;
use App\imports\VmtLoanExcel;
use Carbon\Carbon;
use Exception;
use Illuminate\Validation\Rule;





class VmtSalaryAdvanceController extends Controller
{

    public function showSAemployeeView()
    {
        return view('salaryAndLoanAdvance.SAEmployee_view');
    }
    public function showSAapprovalView()
    {
        return view('salaryAndLoanAdvance.SA_approval_view');
    }
    public function showSAsettingsView()
    {
        return view('salaryAndLoanAdvance.SA_settings_view');
    }
    public function empLoanAndAdvUploads()
    {

        return view('salaryAndLoanAdvance.employees_previous_loan_adv');
    }

    public function getAllDropdownFilterSetting(Request $request, VmtSalaryAdvanceService $vmtSalaryAdvanceService)
    {


        return $vmtSalaryAdvanceService->getAllDropdownFilterSetting();
    }

    public function SalAdvSettingsTable(Request $request, VmtSalaryAdvanceService $vmtSalaryAdvanceService)
    {
        // dd($request->all());

        return $vmtSalaryAdvanceService->SalAdvSettingsTable($request->department_id, $request->designation, $request->work_location, $request->client_name);
    }

    public function SalAdvShowEmployeeView(Request $request, VmtSalaryAdvanceService $vmtSalaryAdvanceService)
    {
         
        return $vmtSalaryAdvanceService->SalAdvShowEmployeeView(auth()->user()->id);
    }

    public function SalAdvEmpSaveSalaryAmt(Request $request, VmtSalaryAdvanceService $vmtSalaryAdvanceService)
    {

          $user_id = auth()->user()->id;
        return $vmtSalaryAdvanceService->SalAdvEmpSaveSalaryAmt( $user_id,$request->mxe, $request->ra, $request->repdate, $request->reason);
    }
    public function saveSalaryAdvanceSettings(Request $request, VmtSalaryAdvanceService $vmtSalaryAdvanceService)
    {

        //   dd($request->all());
        return $vmtSalaryAdvanceService->saveSalaryAdvanceSettings($request->eligibleEmployee, $request->perOfSalAdvance, $request->deductMethod, $request->approvalflow, $request->payroll_cycle, $request->SA);
    }

    public function settingDetails(Request $request, VmtSalaryAdvanceService $vmtSalaryAdvanceService)
    {
        //   dd($request->all());
        return $vmtSalaryAdvanceService->settingDetails();
    }

    public function SalAdvApproverFlow(Request $request, VmtSalaryAdvanceService $vmtSalaryAdvanceService)
    {

        return $vmtSalaryAdvanceService->SalAdvApproverFlow();
    }
    public function getEmpsaladvDetails(Request $request, VmtSalaryAdvanceService $vmtSalaryAdvanceService)
    {
        if (empty($request->user_id)) {
            $user_id = auth()->user()->id;
        } else {
            $user_id = $request->user_id;
        }
        return $vmtSalaryAdvanceService->getEmpsaladvDetails($user_id, $request->year, $request->month);
    }

    public function salAdvSettingEdit(Request $request, VmtSalaryAdvanceService $vmtSalaryAdvanceService)
    {

        return $vmtSalaryAdvanceService->salAdvSettingEdit();
    }

    public function salAdvSettingDelete(Request $request, VmtSalaryAdvanceService $vmtSalaryAdvanceService)
    {

        return $vmtSalaryAdvanceService->salAdvSettingDelete();
    }
    public function salAdvAmtApprovedEmp(Request $request, VmtSalaryAdvanceService $vmtSalaryAdvanceService)
    {

        return $vmtSalaryAdvanceService->salAdvAmtApprovedEmp();
    }


    public function saveTravelAdvanceSettings(Request $request)
    {
        dd($request->all());
    }

    public function saveIntersetAndIntersetFreeLoanSettings(Request $request, VmtSalaryAdvanceService $vmtSalaryAdvanceService)
    {


        $response = $vmtSalaryAdvanceService->saveIntersetAndIntersetFreeLoanSettings(
            $request->loan_type,
            $request->selectClientID,
            $request->name,
            $request->precent_Or_Amt,
            $request->minEligibile,
            $request->max_loan_limit,
            $request->availPerInCtc,
            $request->loan_amt_interest,
            $request->deductMethod,
            $request->maxTenure,
            $request->approvalflow
        );

        return $response;
    }


    public function showEligibleInterestFreeLoanDetails(Request $request, VmtSalaryAdvanceService $vmtSalaryAdvanceService)
    {
        // $request->loan_type = "InterestFreeLoan";
        $user_id = auth()->user()->id;
        $client_id = sessionGetSelectedClientid();
        $response = $vmtSalaryAdvanceService->showEligibleInterestFreeLoanDetails($request->loan_type, $user_id, $client_id);
        return  $response;
    }

    //Gettings Clients Based on Login
    public function getClientForLoanAndAdv(Request $request)
    {
        //dd($request->status);
        $column = 'vmt_loan_sal_adv_master.' . $request->status;
        if (VmtClientMaster::count() == 1) {
            return VmtClientMaster::join('vmt_loan_sal_adv_master', '.client_id', '=', 'vmt_client_master.id')
                ->where('vmt_client_master.id', sessionGetSelectedClientid())->get([
                    'vmt_client_master.id as id',
                    'vmt_client_master.abs_client_code as abs_client_code',
                    'vmt_client_master.client_code as client_code',
                    'vmt_client_master.client_name as client_name',
                    $column . ' as status',
                ]);
        } else {
            if (sessionGetSelectedClientid() == 1) {
                $client_details_query =  VmtClientMaster::join('vmt_loan_sal_adv_master', '.client_id', '=', 'vmt_client_master.id')->get([
                    'vmt_client_master.id as id',
                    'vmt_client_master.abs_client_code as abs_client_code',
                    'vmt_client_master.client_code as client_code',
                    'vmt_client_master.client_name as client_name',
                    $column . ' as status',
                ]);
                $client_details = array();
                foreach ($client_details_query  as $single_details) {
                    if ($single_details->id != 1) {
                        array_push($client_details, $single_details);
                    }
                }
                return  $client_details;
            } else {
                return VmtClientMaster::join('vmt_loan_sal_adv_master', '.client_id', '=', 'vmt_client_master.id')
                    ->where('vmt_client_master.id', sessionGetSelectedClientid())->get([
                        'vmt_client_master.id as id',
                        'vmt_client_master.abs_client_code as abs_client_code',
                        'vmt_client_master.client_code as client_code',
                        'vmt_client_master.client_name as client_name',
                        $column . ' as status',
                    ]);
            }
        }
    }

    public function loanAndSalAdvCurrentStatus(Request $request)
    {
        $column = $request->Status;

        if (VmtClientMaster::count() == 1) {
            $setting_status = VmtClientMaster::join('vmt_loan_sal_adv_master', '.client_id', '=', 'vmt_client_master.id')
                ->where('vmt_client_master.id', sessionGetSelectedClientid())->pluck($column);
        } else {
            if (sessionGetSelectedClientid() == 1) {
                $setting_status_query = VmtClientMaster::join('vmt_loan_sal_adv_master', '.client_id', '=', 'vmt_client_master.id')->pluck($column);
                $setting_status = 0;
                foreach ($setting_status_query as $single_sts) {

                    if ($single_sts == 1) {
                        $setting_status = 1;
                    }
                }
            } else {
                $setting_status = VmtClientMaster::join('vmt_loan_sal_adv_master', '.client_id', '=', 'vmt_client_master.id')
                    ->where('vmt_client_master.id', sessionGetSelectedClientid())->pluck($column);
            }
            $response['status'] = $setting_status;
            return $response;
        }

        return response()->json([
            'status' =>  $setting_status,
        ]);
    }

    public function loanAndAvanceMasterSettings(Request $request)
    {
        $client_id = $request->client_id;
        //here we tell which tab (sal adv,loan, interest loan, travel adv)
        $column = 'sal_adv';
        foreach ($client_id as $single_client_id) {
            try {
                $vmt_loan_sal_adv_master = new VmtSalaryAdvanceMasterModel;
                $vmt_loan_sal_adv_master->client_id = $single_client_id;
                if ($column == 'sal_adv') {
                    $vmt_loan_sal_adv_master->sal_adv = 1;
                } else if ($column == 'int_free_loan') {
                    $vmt_loan_sal_adv_master->int_free_loan = 1;
                } else if ($column == 'loan_with_int') {
                    $vmt_loan_sal_adv_master->loan_with_int = 1;
                } else if ($column == 'travel_adv') {
                    $vmt_loan_sal_adv_master->travel_adv;
                }
            } catch (Exception $e) {
                return response()->json([
                    "status" => "failure",
                    "message" => "Failed to save interest Free loan setting",
                    "data" => $e->getMessage(),
                ]);
            }
        }
    }

    public function applyLoan(Request $request, VmtSalaryAdvanceService $vmtSalaryAdvanceService)
    {
        $loan_type = $request->loan_type;
        $loan_setting_id = $request->details['loan_settings_id'];
        $eligible_amount = $request->minEligibile;
        $borrowed_amount = $request->required_amount;
        $interest_rate = $request->Interest_rate;
        $deduction_starting_month = $request->EMI_Start_Month;
        $deduction_ending_month = $request->EMI_End_Month;
        $emi_per_month = $request->M_EMI;
        $tenure_months = $request->Term;
        $reason = $request->Reason;

        // dd($request->all());
        $response = $vmtSalaryAdvanceService->applyLoan(
            $loan_type,
            $loan_setting_id,
            $eligible_amount,
            $borrowed_amount,
            $interest_rate,
            $deduction_starting_month,
            $deduction_ending_month,
            $emi_per_month,
            $tenure_months,
            $reason,
        );
        return $response;
    }
    public function fetchEmployeeForLoanApprovals(Request $request, VmtSalaryAdvanceService $vmtSalaryAdvanceService)
    {
        $loan_type = $request->loan_type;
        // $loan_type = 'InterestFreeLoan';

        $response = $vmtSalaryAdvanceService->fetchEmployeeForLoanApprovals($loan_type);
        return $response;
    }

    public function rejectOrApproveLoan(Request $request, VmtSalaryAdvanceService $vmtSalaryAdvanceService)
    {
        // dd($request->all());
        $response = $vmtSalaryAdvanceService->rejectOrApproveLoan(
            $request->loan_type,
            $request->record_id,
            $request->status,
            $request->reviewer_comments
        );

        return $response;
    }

    public function rejectOrApprovedSaladv(Request $request, VmtSalaryAdvanceService $vmtSalaryAdvanceService)
    {

        // $request->record_id = 17;
        // $request->status = 1;
        // dd($request->all());

        return $vmtSalaryAdvanceService->rejectOrApprovedSaladv(
            $request->record_id,
            $request->status,
            $request->reviewer_comments
        );
    }

    public function EmployeeLoanHistory(Request $request, VmtSalaryAdvanceService $vmtSalaryAdvanceService)
    {
        $loan_type = $request->loan_type;
        $user_id = auth()->user()->id;
        $response = $vmtSalaryAdvanceService->EmployeeLoanHistory($user_id, $loan_type, $request->year, $request->month);
        return $response;
    }

    public function changeClientIdStsForLoan(Request $request)
    {
        $column = $request->loanType;
        $client_id = $request->client_status;
        $all_client_id = VmtSalaryAdvanceMasterModel::pluck('client_id');
        try {
            foreach ($all_client_id as $single_id) {
                if (in_array($single_id,  $client_id)) {
                    $loan_and_sal_adv_settings = VmtSalaryAdvanceMasterModel::where('client_id', $single_id)->first();
                    $loan_and_sal_adv_settings->$column =  1;
                    $loan_and_sal_adv_settings->save();
                } else {
                    $loan_and_sal_adv_settings = VmtSalaryAdvanceMasterModel::where('client_id', $single_id)->first();
                    $loan_and_sal_adv_settings->$column =  0;
                    $loan_and_sal_adv_settings->save();
                }
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "changeClientIdStsForLoan",
                "data" => $e->getMessage(),
            ]);
        }
        return response()->json([
            "status" => "success",
            "message" => "changeClientIdStsForLoan",

        ]);
    }

    public function interestAndInterestfreeLoanSettingsDetails(Request $request, VmtSalaryAdvanceService $vmtSalaryAdvanceService)
    {
        $loan_type = $request->Status;
        //  $loan_type = 'InterestFreeLoan';
        $response = $vmtSalaryAdvanceService->interestAndInterestfreeLoanSettingsDetails($loan_type);
        return  $response;
    }
    //this is for interest and interest free transection record
    public function loanTransectionRecord(Request $request, VmtSalaryAdvanceService $vmtSalaryAdvanceService)
    {
        //$loan_type = $request->loan_type;
        $loan_type = 'InterestFreeLoan';
        $loan_details_id = 2;
        $response = $vmtSalaryAdvanceService->loanTransectionRecord($loan_type, $loan_details_id);
    }

    public function enableOrDisableLoanSettings(Request $request, VmtSalaryAdvanceService $vmtSalaryAdvanceService)
    {
        $loan_type = $request->loanType;
        $status = $request->Status;
        $loan_id = $request->loan_ID;
        // dd($request->all());
        // $loan_id=6;
        $response = $vmtSalaryAdvanceService->enableOrDisableLoanSettings($loan_type, $loan_id, $status);
        return $response;
    }
    public function getApprovedRequestedForLoanAndAdvance(Request $request, VmtSalaryAdvanceService $vmtSalaryAdvanceService)
    {
        $response = $vmtSalaryAdvanceService->getApprovedRequestedForLoanAndAdvance();
        return $response;
    }



    public function isEligibleForLoanAndAdvance(Request $request, VmtSalaryAdvanceService $vmtSalaryAdvanceService)
    {
        $loan_type = $request->eligible;
        $user_id = auth()->user()->id;
        $client_id = sessionGetSelectedClientid();
        $response = $vmtSalaryAdvanceService->isEligibleForLoanAndAdvance($loan_type, $user_id, $client_id);

        return $response;
    }

    public function employeeDashboardLoanAndAdvance(Request $request, VmtSalaryAdvanceService $vmtSalaryAdvanceService)
    {
        $validator = Validator::make(
            $data = [
                "loan_type" => $request->loan_type,
                //  "user_code" => $request->user_code
                "month" => $request->month,
                "year" => $request->year
            ],
            $rules = [
                'loan_type' => ['required', Rule::in(['loan_with_int', 'int_free_loan', 'sal_adv'])],
                //  "user_code" => "required|exists:users,user_code"
                "month" => $request->month,
                "year" => $request->year
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid"
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }
        try {
            $loan_type = $request->loan_type;
            $user_id = auth()->user()->id;
            $response = $vmtSalaryAdvanceService->employeeDashboardLoanAndAdvance($loan_type, $user_id, $request->year, $request->month);
            return   $response;
        } catch (Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "employeeDashboardLoanAndAdvance",
                "data" => $e->getMessage(),
            ]);
        }
    }
}
