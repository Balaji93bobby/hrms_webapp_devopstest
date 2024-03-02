<?php

namespace App\Http\Controllers\Api;

use App\Services\VmtAttendanceService;
use App\Services\VmtSalaryAdvanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class VmtAPILoanAndSalaryAdvanceController extends Controller
{
    public function getEmpLoanAndSalaryAdvance(Request $request, VmtSalaryAdvanceService $vmtsalaryAdvanceService)
    {


        $validator = Validator::make(
            $data = [
                "loan_type" => $request->loan_type,
                "user_code" => $request->user_code
            ],
            $rules = [
                "loan_type" => "required",
                "user_code" => "required|exists:users,user_code"
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid"
            ]
        );

        try {
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->all()
                ]);
            }

            $users_detail = User::where('user_code', $request->user_code)->first();
            $response = $vmtsalaryAdvanceService->isEligibleForLoanAndAdvance($request->loan_type, $users_detail->id, $users_detail->client_id);
            $response = json_encode($response);
            $response = json_decode($response, true);

            if ($request->loan_type == 'int_free_loan') {
                $employee_loan_history = $vmtsalaryAdvanceService->EmployeeLoanHistory($users_detail->id, 'InterestFreeLoan');
                $eligible_loan_details = $vmtsalaryAdvanceService->showEligibleInterestFreeLoanDetails('InterestFreeLoan', $users_detail->id, $users_detail->client_id);
                if ($eligible_loan_details != null) {
                    $eligible_loan_details = json_encode($eligible_loan_details);
                    $eligible_loan_details = json_decode($eligible_loan_details, true);
                    $eligible_loan_details = $eligible_loan_details['original'];
                }
            } else if ($request->loan_type == 'loan_with_int') {
                $employee_loan_history = $vmtsalaryAdvanceService->EmployeeLoanHistory($users_detail->id, 'InterestWithLoan');
                $eligible_loan_details = $vmtsalaryAdvanceService->showEligibleInterestFreeLoanDetails('InterestWithLoan', $users_detail->id, $users_detail->client_id);
            } else if ($request->loan_type == 'sal_adv') {
                $employee_loan_history = $vmtsalaryAdvanceService->getEmpsaladvDetails($users_detail->id);
                $eligible_loan_details = $vmtsalaryAdvanceService->SalAdvShowEmployeeView();
                if ($eligible_loan_details != null) {
                    $eligible_loan_details = json_encode($eligible_loan_details);
                    $eligible_loan_details = json_decode($eligible_loan_details, true);
                    $eligible_loan_details = $eligible_loan_details['original'];
                }
                // dd( $eligible_loan_details);
            }

            $emp_dash = $vmtsalaryAdvanceService->employeeDashboardLoanAndAdvance($request->loan_type, $users_detail->id);
            $emp_dash = json_encode($emp_dash, true);
            $emp_dash = json_decode($emp_dash, true);
            $emp_dash_data = $emp_dash['original']['data'];


            if ($response['original']['data'] == 0) {
                return [
                    "status" => "success",
                    "message" => "Not eligible",
                    "loan_history" =>  $employee_loan_history,
                    "employee_dashboard" => $emp_dash_data,
                    "eligible_borrow_amount" => []
                ];
            } else if ($response['original']['data'] == 1) {
                return [
                    "status" => "success",
                    "message" => "eligible",
                    "loan_history" => $employee_loan_history,
                    "employee_dashboard" =>   $emp_dash_data,
                    "eligible_borrow_amount" => $eligible_loan_details

                ];
            }
            return $response;
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "Error[ getEmpLoanAndSalaryAdvance() ] : Error while fetching data ",
                'data' => $e
            ]);
        }
    }
    public function getEmployeeLoanSalaryAdvanceStatsAndEligibilityDetails(Request $request, VmtSalaryAdvanceService $vmtsalaryAdvanceService)
    {
        $validator = Validator::make(
            $data = [
                "loan_type" => $request->loan_type,
                "user_code" => $request->user_code,
                "month" => $request->month,
                "year" => $request->year
            ],
            $rules = [
                'loan_type' => ['required', Rule::in(['loan_with_int', 'int_free_loan', 'sal_adv'])],
                "month" => "nullable",
                "year" => "nullable",
                "user_code" => "required|exists:users,user_code"
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid"
            ]
        );

        try {
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->all()
                ]);
            }
            $response = array();
            $stats  = json_decode($vmtsalaryAdvanceService->employeeDashboardLoanAndAdvance($request->loan_type, User::where('user_code', $request->user_code)->first()->id, $request->year, $request->month)->content(), true);
            if ($stats['status'] == 'success') {
                $response['total_borrowed_amt'] = $stats['data']['total_borrowed_amt'];
                $response['balance_amt'] = $stats['data']['balance_amt'];
                $response['total_repaid_amt'] = $stats['data']['total_repaid_amt'];
                $response['pending_request'] = $stats['data']['pending_request'];
                $response['compeleted_request'] = $stats['data']['compeleted_request'];
            }
            $eligiblity_details = json_decode($vmtsalaryAdvanceService->SalAdvShowEmployeeView(User::where('user_code', $request->user_code)->first()->id)->content(), true);
            $response['eligible'] = $eligiblity_details['eligible'];
            $response['percent_salary_amt'] = $eligiblity_details['percent_salary_amt'];
            $response['your_monthly_income'] = $eligiblity_details['your_monthly_income'];
            $response['max_eligible_amount'] = $eligiblity_details['max_eligible_amount'];
            $response['Repayment_date'] = $eligiblity_details['Repayment_date'];
            return response()->json([
                'status' => 'success',
                'data' =>  $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "Error[ getEmployeeLoanSalaryAdvanceStats() ] : Error while fetching data ",
                'data' => $e->getTraceAsString()
            ]);
        }
    }
    public function getEmployeeLoanAndSalaryAdvanceDetails(Request $request, VmtSalaryAdvanceService $vmtsalaryAdvanceService)
    {
        $validator = Validator::make(
            $data = [
                "loan_type" => $request->loan_type,
                "user_code" => $request->user_code,
                "month" => $request->month,
                "year" => $request->year
            ],
            $rules = [
                'loan_type' => ['required', Rule::in(['loan_with_int', 'int_free_loan', 'sal_adv'])],
                "month" => "nullable",
                "year" => "nullable",
                "user_code" => "required|exists:users,user_code"
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
            if ($request->loan_type == 'sal_adv') {
                $loan_and_saladv_details = $vmtsalaryAdvanceService->getEmpsaladvDetails(User::where('user_code', $request->user_code)->first()->id, $request->year, $request->month);
            } else if ($request->loan_type == 'int_free_loan') {
                $loan_and_saladv_details = $vmtsalaryAdvanceService->EmployeeLoanHistory(User::where('user_code', $request->user_code)->first()->id, 'InterestFreeLoan', $request->year, $request->month);
            } else if ($request->loan_type == 'loan_with_int') {
                $loan_and_saladv_details = $vmtsalaryAdvanceService->EmployeeLoanHistory(User::where('user_code', $request->user_code)->first()->id, 'InterestWithLoan', $request->year, $request->month);
            }
            return response()->json([
                'status' => 'success',
                'data' => $loan_and_saladv_details
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "Error[ getEmployeeLoanAndSalaryAdvanceDetails() ] : Error while fetching data ",
                'error' => $e->getMessage(),
                'data' => $e->getTraceAsString()
            ]);
        }
    }
    public function getEligibleSalraryAdvanceDetails(Request $request, VmtSalaryAdvanceService $vmtSalaryAdvanceService)
    {
        $validator = Validator::make(
            $data = [
                "user_code" => $request->user_code,
            ],
            $rules = [
                "user_code" => "required|exists:users,user_code"
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

            return response()->json([
                'status' => 'success',
                'data' => json_decode($vmtSalaryAdvanceService->SalAdvShowEmployeeView(User::where('user_code', $request->user_code)->first()->id)->content(), true)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "Error[ getEligibleSalraryAdvanceDetails() ] ",
                'error' => $e->getMessage(),
                'data' => $e->getTraceAsString()
            ]);
        }
    }
    public function applySalaryAdvance(Request $request, VmtSalaryAdvanceService $vmtSalaryAdvanceService)
    {
        $validator = Validator::make(
            $data = [
                "user_code" => $request->user_code,
                "eligible_amount" => $request->eligible_amount,
                "borrowed_amount" =>  $request->borrowed_amount,
                "dedction_date" => $request->dedction_date,
                "reason" => $request->reason
            ],
            $rules = [
                "user_code" => "required|exists:users,user_code",
                "eligible_amount" => "required",
                "borrowed_amount" => "required",
                "dedction_date" => "required",
                "reason" => "required"
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
            return $vmtSalaryAdvanceService->SalAdvEmpSaveSalaryAmt(User::where('user_code', $request->user_code)->first()->id, $request->eligible_amount, $request->borrowed_amount, $request->dedction_date, $request->reason);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "Error[ applySalaryAdvance() ] ",
                'error' => $e->getMessage(),
                'data' => $e->getTraceAsString()
            ]);
        }
    }
    public function loanAndSalaryAdvanceTimeline(Request $request, VmtSalaryAdvanceService $vmtSalaryAdvanceService)
    {
        $validator = Validator::make(
            $data = [
                "request_id" => $request->request_id,
                "loan_type" => $request->loan_type,
            ],
            $rules = [
                "request_id" => "required",
                'loan_type' => ['required', Rule::in(['loan_with_int', 'int_free_loan', 'sal_adv'])],
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
            return $vmtSalaryAdvanceService->loanAndSalaryAdvanceTimeline($request->loan_type, $request->request_id);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "Error[ loanAndSalaryAdvanceTimeline() ] ",
                'error' => $e->getMessage(),
                'data' => $e->getTraceAsString()
            ]);
        }
    }
}
