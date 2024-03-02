<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VmtEmployeeLeaveService;
use App\Models\User;
use Exception;
use App\Imports\ImportLeaveBalance;
use App\Models\VmtEmployeeLeaves;
use App\Models\VmtLeaves;
use PhpParser\Node\Stmt\Catch_;
use App\Models\VmtOrgTimePeriod;
use App\Models\VmtEmployeesLeavesAccrued;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Imports\ImportExistingLeaveBalanceData;


class VmtEmployeeLeaveController extends Controller
{


    public function processEmployeeLeaveBalance(Request $request, VmtEmployeeLeaveService $vmtEmployeeLeaveService)
    {

        $accrued_leave_type_id = VmtLeaves::where('is_accrued', 1)->get('id');
        $response = array();
        $employees = User::where('is_ssa', 0)
            ->where('active', 1)->get('id');

        $response = array();

        foreach ($accrued_leave_type_id as $leave_type_id) {
            $leave_type = array();
            foreach ($employees as $singleemployee) {
                array_push($leave_type, $vmtEmployeeLeaveService->processEmployeeLeaveBalance($singleemployee->id, $leave_type_id->id));
            }
            array_push($response, $leave_type);
            unset($leave_type);
        }





        return $response;
    }


    public function showLeaveBalanceUpload()
    {

        return view('import_leave_balance');
    }

    public function importLeaveBalanceData(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx'
        ]);

        $importDataArry = \Excel::toArray(new ImportLeaveBalance, request()->file('file'))[0];
        // dd($importDataArry);
        //Active year start month
        $org_period = VmtOrgTimePeriod::where('status', 1)->first();
        //  $start_date =  Carbon::parse($org_period->start_date);
        // $end_date = $org_period->end_date;
        for ($i = 1; $i < count($importDataArry); $i++) {
            try {
                $user = User::where('user_code', $importDataArry[$i]['employee_code']);
                if ($user->exists()) {
                    $importDataArry[$i]['effective_month'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($importDataArry[$i]['effective_month'])->format('Y-m-d');
                    $start_date =  Carbon::parse($importDataArry[$i]['effective_month'])->subMonths($importDataArry[$i]['opening_balance'])->format('Y-m-d');
                    $total_months = Carbon::parse($start_date)->diffInMonths(Carbon::parse($importDataArry[$i]['effective_month']));
                    $end_date = Carbon::parse($importDataArry[$i]['effective_month'])->subMonth();
                    $leave = VmtLeaves::where('leave_type', $importDataArry[$i]['leave_type']);
                    if (!$leave->exists()) {
                        return response()->json([
                            'status' => 'failure',
                            'message' => 'Error while uploading Excel data',
                            'error_fields' =>  $importDataArry[$i]['leave_type'] . ' leave_type Not Exists',
                        ]);
                    }

                    $j = 0;
                    while ($end_date->gte(Carbon::parse($start_date)->addMonths($j))) {
                        $temp_date =  Carbon::parse($start_date)->addMonths($j);
                        $year =  $temp_date->format('Y');
                        $month = $temp_date->format('m');

                        if (!VmtEmployeesLeavesAccrued::where('user_id', $user->first()->id)
                            ->whereYear('date', $year)
                            ->whereMonth('date', $month)
                            ->where('leave_type_id', $leave->first()->id)->exists()) {
                            $leave_accrued = new VmtEmployeesLeavesAccrued;
                            $leave_accrued->user_id = $user->first()->id;
                            $leave_accrued->date = $year . '-' . $month . '-15';
                            $leave_accrued->leave_type_id = $leave->first()->id;
                            $leave_accrued->accrued_leave_count = 1;
                            $leave_accrued->save();
                        }
                        $j = $j + 1;
                    }
                    $leave_req_year = Carbon::parse($importDataArry[$i]['effective_month'])->format('Y');
                    $leave_req_month = Carbon::parse($importDataArry[$i]['effective_month'])->format('m');
                    $leave_req_date = Carbon::parse($importDataArry[$i]['effective_month'])->format('d');
                    if (!VmtEmployeeLeaves::where('user_id', $user->first()->id)
                        ->where('total_leave_datetime', $importDataArry[$i]['availed'])
                        ->whereYear('leaverequest_date',  $leave_req_year)
                        ->whereMonth('leaverequest_date', $leave_req_month)
                        ->whereDay('leaverequest_date', $leave_req_date)->exists()) {
                        $emp_leaves = new VmtEmployeeLeaves;
                        $emp_leaves->user_id =  $user->first()->id;
                        $emp_leaves->leaverequest_date = $importDataArry[$i]['effective_month'];
                        $emp_leaves->total_leave_datetime = $importDataArry[$i]['availed'];
                        $emp_leaves->save();
                    }
                } else {
                    return response()->json([
                        'status' => 'failure',
                        'message' => 'Error while uploading Excel data',
                        'error_fields' =>  $importDataArry[$i]['employee_code'] . ' Employee Code Not Exists',
                    ]);
                }
            } catch (Exception $e) {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Error while uploading Excel data',
                    'error_fields' =>  $e->getMessage() . " " . $e->getline(),
                ]);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Leave Balance Uploaded Sucessfully',
        ]);
    }

    public function showEmployeeLeaveBalanceDatapage()
    {

        return view('vmt_importEmployeeLeaveBalancedata');
    }

    // public function ImportExistingLeaveBalanceData(Request $request)
    // {

    //     $request->validate([
    //         'file' => 'required|file|mimes:xls,xlsx'
    //     ]);

    //     $importDataArry = \Excel::toArray(new ImportExistingLeaveBalanceData, request()->file('file'));

    //     return $this->updateEmployeeLeaveBalanceData($importDataArry);
    // }


    public function updateEmployeeLeaveBalanceData(Request $request)
    {

        try {
            $data = $request->all();
            $updated_details = array();

            foreach ($data as $key => $single_data) {

                $update_emp_CL_leave = $this->updateSingleEmployeeLeaveBalanceData($single_data['employee_code'], $single_data['date'], $single_data['Casual_Leave'], "Casual Leave");
                $update_emp_SL_leave = $this->updateSingleEmployeeLeaveBalanceData($single_data['employee_code'], $single_data['date'], $single_data['Sick_Leave'], "Sick Leave");
                $update_emp_EL_leave = $this->updateSingleEmployeeLeaveBalanceData($single_data['employee_code'], $single_data['date'], $single_data['Earned_Leave'], "Earned Leave");
                if($update_emp_CL_leave['status']=='success'&& $update_emp_SL_leave['status']=='success'&& $update_emp_EL_leave['status']=='success'){

                    array_push($updated_details, $update_emp_EL_leave);
                }else{
                    array_push($updated_details, $update_emp_EL_leave);
                }
            }

            return $response = ([
                'status' => 'success',
                'message' => 'Data saved successfully',
                'data' => $updated_details ?? " ",
            ]);
        } catch (\Exception $e) {
            return $response = ([
                'status' => 'failure',
                'message' => 'Error while saving data',
                'data' => $e->getmessage(),
            ]);
        }
    }
    public function updateSingleEmployeeLeaveBalanceData($emplyeee_code, $date, $leave_count, $leave_type)
    {

        try {

            $start_date = Carbon::parse($date);
            $no_of_leaves = (int)$leave_count;
            $end_date =  Carbon::parse($date)->subMonths($no_of_leaves);
            $end_date = Carbon::parse($end_date);

            $date_range = CarbonPeriod::create($end_date->startOfMonth()->format('Y-m-d'), '1 month', $start_date->endOfMonth()->format('Y-m-d'),);

            $monthWise_leave_date = array();

            foreach ($date_range as $single_date) {

                $monthWise_leave_date[] = $single_date->format('Y-m-15');
            }

            $user_data = User::where('user_code', $emplyeee_code)->first();

            $leave_type = VmtLeaves::where('leave_type', $leave_type)->first();

            foreach ($monthWise_leave_date as $key => $single_month) {

                if (!empty($user_data)) {

                    $emp_leave_details = VmtEmployeesLeavesAccrued::where('user_id', $user_data->id)->where('date', $single_month)->where('leave_type_id', $leave_type->id)->first();

                    if (empty($emp_leave_details)) {
                        $update_leave_details = new VmtEmployeesLeavesAccrued;
                        $update_leave_details->user_id = $user_data->id;
                        $update_leave_details->date = $single_month;
                        $update_leave_details->leave_type_id = $leave_type->id;
                        $update_leave_details->accrued_leave_count = 1;
                        $update_leave_details->save();
                    }
                }
            }
            return $response = ([
                'status' => 'success',
                'message' => 'Data saved successfully',
                'Employee_Name' => $user_data->name,
                'data' => '',
            ]);
        } catch (\Exception $e) {
            return $response = ([
                'status' => 'failure',
                'message' => 'Error while saving data',
                'data' => $e->getmessage(),
            ]);
        }
    }
}
