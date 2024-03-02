<?php

namespace App\Http\Controllers;

use App\Models\VmtEmployeeOfficeDetails;
use App\Models\VmtEmployee;
use App\Services\VmtAttendanceService;
use Illuminate\Http\Request;
use App\Models\VmtEmployeePaySlip;
use App\Models\VmtPayroll;
use App\Models\Compensatory;
use App\Models\VmtEmployeeStatutoryDetails;
use App\Imports\VmtPaySlip;
use App\Models\User;
use Carbon\Carbon;
use Dompdf\Options;
use Dompdf\Dompdf;
use PDF;
use App\Services\VmtPayrollService;

use Illuminate\Support\Facades\DB;
use App\Models\VmtClientMaster;
use App\Services\VmtAttendanceReportsService;
use App\Services\VmtPayrollComponentsService;
use App\Services\VmtEmployeePayCheckService;


class VmtPayrollController extends Controller
{

    public function showPayRunPage(Request $request)
    {
        return view('vmt_uploadPayRunData');
    }


    public function getCurrentPayrollMonth(Request $request, VmtPayrollService $serviceVmtPayrollService)
    {
        return $serviceVmtPayrollService->getCurrentPayrollMonth();
    }


    public function showPayrollClaimsPage(Request $request)
    {
        return view('payRoll_claim');
    }

    public function showPayrollAnalyticsPage(Request $request)
    {
        return view('payRoll');
    }

    public function showPayrollReportsPage(Request $request)
    {
        return view('payRoll_reports');
    }

    public function showPayrollRunPage(Request $request)
    {
        return view('runpayRoll');
    }

    public function showManagePayslipsPage(Request $request)
    {
        if (auth()->user()->can(config('vmt_roles_permissions.permissions.MANAGE_PAYSLIPS_can_view')))
            return view('payroll.manage_payslips');
        else
            return view('page_unauthorized__access');
    }




    public function showPayrollSetup(Request $request)
    {
        return view('payroll.vmt_payroll_setup');
    }

    public function showWorkLocationSetup(Request $request)
    {
        return view('payroll.vmt_work_location');
    }




    public function getExternalAppsList(Request $request,VmtPayrollService $serviceVmtPayrollService){
        return $serviceVmtPayrollService->getExternalAppsList();
    }

    public function generateExternalApp_AccessToken(Request $request,VmtPayrollService $serviceVmtPayrollService){
        return $serviceVmtPayrollService->generateExternalApp_AccessToken($request->client_code, $request->externalapp_internalname, $request->validity);
    }

    public function saveTallyERP_PayrollJournalMappings(Request $request,VmtPayrollService $serviceVmtPayrollService){
        return $serviceVmtPayrollService->saveTallyERP_PayrollJournalMappings($request->client_code, $request->jsonarray_gl_mappings);
    }

    public function getTallyERP_PayrollJournalMappings(Request $request,VmtPayrollService $serviceVmtPayrollService){
        return $serviceVmtPayrollService->getTallyERP_PayrollJournalMappings($request->client_code);
    }

    public function getPayrollJournalData(Request $request,VmtPayrollService $serviceVmtPayrollService){
        return $serviceVmtPayrollService->getPayrollJournalData($request->token, $request->company_name, $request->payroll_date);
    }

    //Returns the default payroll journal data as per Vasa structure.
    public function getDefaultPayrollJournalData(Request $request,VmtPayrollService $serviceVmtPayrollService){
        return $serviceVmtPayrollService->getDefaultPayrollJournalData($request->token, $request->company_name, $request->payroll_date);
    }

    public function saveTallyResponse_onPayrollProcessStatus(Request $request,VmtPayrollService $serviceVmtPayrollService){

        return $serviceVmtPayrollService->saveTallyResponse_onPayrollProcessStatus($request->token, $request->status, $request->data, $request->all());
    }

    public function getPayrollOutcomes(Request $request, VmtPayrollService $serviceVmtPayrollService)
    {

        $outcome_selected_month=$serviceVmtPayrollService->getPayrollOutcomes($request->client_code, $request->payroll_date);

        if($outcome_selected_month['status']=='failure'){

            return response()->json( $outcome_selected_month);

        }else{
           // dd($outcome_selected_month['data']['payroll_stats']['total_payroll_cost']);
            $previous_date =Carbon::createFromFormat('Y-m-d', $request->payroll_date)->subMonth()->format('Y-m-d');
            $is_previous_data_exists = VmtPayroll::where('payroll_date',$previous_date);
            if( $is_previous_data_exists->exists()){
                $outcome_previous_month=$serviceVmtPayrollService->getPayrollOutcomes($request->client_code, $previous_date);
                $outcome_selected_month['data']['payroll_stats']['previous_month']=Carbon::createFromFormat('Y-m-d', $request->payroll_date)->subMonth()->format('M');

                $outcome_selected_month['data']['payroll_stats']['pre_month_cost'] = $outcome_selected_month['data']['payroll_stats']['total_payroll_cost'] - $outcome_previous_month['data']['payroll_stats']['total_payroll_cost'];
                $outcome_selected_month['data']['payroll_stats']['pre_month_deposit'] = $outcome_selected_month['data']['payroll_stats']['employee_deposit'] - $outcome_previous_month['data']['payroll_stats']['employee_deposit'];
                $outcome_selected_month['data']['payroll_stats']['pre_month_deduction'] = $outcome_selected_month['data']['payroll_stats']['total_deductions'] - $outcome_previous_month['data']['payroll_stats']['total_deductions'];
                $outcome_selected_month['data']['payroll_stats']['pre_month_contribution'] = $outcome_selected_month['data']['payroll_stats']['total_contributions'] - $outcome_previous_month['data']['payroll_stats']['total_contributions'];
            }else{
                $outcome_selected_month['data']['payroll_stats']['pre_month_cost'] = $outcome_selected_month['data']['payroll_stats']['total_payroll_cost'] - 0;
                $outcome_selected_month['data']['payroll_stats']['pre_month_deposit'] = $outcome_selected_month['data']['payroll_stats']['employee_deposit'] - 0;
                $outcome_selected_month['data']['payroll_stats']['pre_month_deduction'] = $outcome_selected_month['data']['payroll_stats']['total_deductions'] - 0;
                $outcome_selected_month['data']['payroll_stats']['pre_month_contribution'] = $outcome_selected_month['data']['payroll_stats']['total_contributions'] - 0;
            }




            return response()->json( $outcome_selected_month);
        }
    }

    public function getOrgPayrollMonths(Request $request, VmtPayrollService $serviceVmtPayrollService)
    {
        return $serviceVmtPayrollService->getOrgPayrollMonths($request->client_id);
    }
    public function getAllEmployeesLeaveFilterDetails(Request $request, VmtAttendanceService $serviceVmtAttendanceService, VmtPayrollService $serviceVmtPayrollService)
    {
        $response =  $serviceVmtPayrollService->getAllEmployeesLeaveFilterDetails($request->filter_month, $request->filter_year, $request->filter_leave_status, $request->client_id,$serviceVmtAttendanceService);

        return response()->json($response);
    }
    public function getAllEmployeesConsolidatedMonthlyAttendanceDetails(Request $request, VmtPayrollService $serviceVmtPayrollService)
    {
        return $serviceVmtPayrollService->getAllEmployeesConsolidatedMonthlyAttendanceDetails($request->month, $request->year, $request->client_id);
    }
    public function getclientleavetypes(Request $request, VmtPayrollService $serviceVmtAttendanceService)
    {
        return $serviceVmtAttendanceService->getclientleavetypes();
    }
    // public function getEmployeeLopSummaryDetail(Request $request,VmtPayrollService $serviceVmtAttendanceService)
    // {
    //     return $serviceVmtAttendanceService->getEmployeeLopSummaryDetail($request->client_id,$request->current_month,$request->payroll_year);
    // }
    public function getNewJoineesDetails(Request $request,VmtPayrollService $serviceVmtAttendanceService)
    {

        return $serviceVmtAttendanceService->getNewJoineesDetails( $request->end_date);
    }
    public function getExitEmployeeDetails(Request $request,VmtPayrollService $serviceVmtAttendanceService)
    {

        return $serviceVmtAttendanceService->getExitEmployeeDetails( $request->end_date);
    }
    public function getEmployeeLopdetail(Request $request,VmtPayrollService $serviceVmtPayrollService)
    {
        return $serviceVmtPayrollService->getEmployeeLopdetail($request->start_date, $request->end_date);

    }
    public function getEmployeeRevokeLopDetails(Request $request ,VmtPayrollService $serviceVmtPayrollService)
    {
        return $serviceVmtPayrollService->getEmployeeRevokeLopDetails($request->start_date,$request->end_date);
    }
    public function fetchAttendanceReport(Request $request, VmtPayrollService $serviceVmtPayrollService, VmtAttendanceService $vmtAttendanceServices)
    {
    //    dd('adc');
        $response = $serviceVmtPayrollService->fetchAttendanceReport($request->user_code, $request->year, $request->month,$request->start_date,$request->end_date,$vmtAttendanceServices);
        return response()->json($response);

    }
    public function updateCompensatoryDataToNewtable(Request $request, VmtPayrollService $serviceVmtPayrollService, VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    {
    //    dd('adc');
        $response = $serviceVmtPayrollService->updateCompensatoryDataToNewtable( $serviceVmtPayrollComponentsService);
        return response()->json($response);

    }
}
