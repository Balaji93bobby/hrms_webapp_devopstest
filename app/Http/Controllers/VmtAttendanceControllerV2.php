<?php

namespace App\Http\Controllers;

use App\Exports\DetailedAttendanceExport;
use App\Exports\BasicAttendanceExport;
use Illuminate\Http\Request;
use App\Models\VmtEmpAttIntrTable;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\VmtWorkShifts;
use App\Models\VmtEmployeeAttendanceReport;
use Carbon\Carbon;
use App\Services\VmtAttendanceServiceV2;
use App\Services\VmtAttendanceReportsService;
use App\Models\vmtHolidays;
use App\Models\User;
use App\Models\VmtEmployeeAttendance;
use App\Models\VmtEmployeeLeaves;
use App\Models\VmtLeaves;
use App\Models\TrackTaskScheduler;
use App\Models\VmtStaffAttendanceDevice;
use App\Models\VmtClientMaster;
use App\Models\VmtOrgTimePeriod;
use Carbon\CarbonInterval;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\dommimails;
use \Mail;

class VmtAttendanceControllerV2 extends Controller
{

    public function attendanceJob(Request $request, VmtAttendanceServiceV2 $attendance_services)
    {
        //  $current_time = Carbon::now();
        try {
            if (VmtEmpAttIntrTable::exists()) {
                $staff_attendance_query = VmtEmpAttIntrTable::orderBy('id', 'DESC')->first();
                $start_date = Carbon::parse($staff_attendance_query->date)->subDays(2)->format('Y-m-d');
            } else {
                $staff_attendance_query = VmtStaffAttendanceDevice::orderBy('date', 'asc')->first();
                //dd('working');
                if (Carbon::parse(VmtOrgTimePeriod::where('status', 1)->first()->start_date)->lte(Carbon::parse($staff_attendance_query->date))) {
                    $start_date = Carbon::parse($staff_attendance_query->date)->format('Y-m-d');
                } else {
                    $start_date = Carbon::parse(VmtOrgTimePeriod::where('status', 1)->first()->start_date)->format('Y-m-d');
                }
            }
            $end_date = Carbon::now()->format('Y-m-d');
            $current_time = Carbon::now()->format('h:i');
            // dd( $current_time);

            if ($current_time == '12:00') {

                $start_date = Carbon::now()->subMonth()->format('Y-m-26');

            }
            $data = $attendance_services->attendanceJobs($start_date, $end_date);
            return $data;
        } catch (Exception $e) {
            return Mail::to('karthigaiselvan@abshrms.com')->send(new dommimails('Failure', $e->getMessage(), $e->getTraceAsString()));
        }



        //
    }

    public function syncattintrtable(Request $request, VmtAttendanceServiceV2 $attendance_services, VmtAttendanceReportsService $serviceVmtAttendanceReportsService)
    {
        if (VmtEmpAttIntrTable::exists()) {

            $current_time = Carbon::now()->format('h:i');
            // dd( $current_time);

            if ($current_time == '12:00') {

                $start_date = Carbon::now()->subMonth()->format('Y-m-26');

            } else {

                $staff_attendance_query = VmtEmpAttIntrTable::orderBy('id', 'DESC')->first();
                $start_date = Carbon::parse($staff_attendance_query->date)->subDays(2)->format('Y-m-d');
            }
           // $start_date = Carbon::now()->subMonth()->format('Y-m-26'); // For Testing Only


        } else {
            $staff_attendance_query = VmtStaffAttendanceDevice::orderBy('date', 'asc')->first();

            if ($staff_attendance_query != null) {
                if (Carbon::parse(VmtOrgTimePeriod::where('status', 1)->first()->start_date)->lte(Carbon::parse($staff_attendance_query->date))) {
                    $start_date = Carbon::parse($staff_attendance_query->date)->format('Y-m-d');
                } else {
                    $start_date = Carbon::parse(VmtOrgTimePeriod::where('status', 1)->first()->start_date)->format('Y-m-d');
                }
            } else {
                $start_date = Carbon::parse(VmtOrgTimePeriod::where('status', 1)->first()->start_date)->format('Y-m-d');
            }
        }
        $end_date = Carbon::now()->format('Y-m-d');

        $response['attendance_jobs'] = $attendance_services->attendanceJobs($start_date, $end_date);
        $response['Sandwich_data'] = $this->fetchSandwidchReportData($serviceVmtAttendanceReportsService);
        return $response;
    }

    public function fetchSandwidchReportData(VmtAttendanceReportsService $serviceVmtAttendanceReportsService)
    {

        $start_date = Carbon::now()->subMonth()->format('Y-m-26');
        $end_date = Carbon::now()->startofMonth()->adddays('24')->format('Y-m-d');

        $response = $serviceVmtAttendanceReportsService->fetchSandwidchReportData($start_date, $end_date, $user_id = null);
        return $response;
    }
    public function checkEmployeeSandwichstatus(VmtAttendanceReportsService $serviceVmtAttendanceReportsService)
    {
        $response = $serviceVmtAttendanceReportsService->checkEmployeeSandwichstatus($date = "2024-01-02", $user_id = '162');
        return $response;
    }

    // public function runAttendanceCycleData(VmtAttendanceReportsService $serviceVmtAttendanceReportsService)
    // {

    //     $start_date = Carbon::now()->subMonth()->format('Y-m-26');
    //     $end_date = Carbon::now()->startofMonth()->adddays('24')->format('Y-m-d');

    //     $response =$serviceVmtAttendanceReportsService->fetchSandwidchReportData($start_date, $end_date);
    //     return  $response;
    // }

    public function downloadDetailedAttendanceReport(Request $request, VmtAttendanceServiceV2 $attendance_services)
    {
        if (empty($request->start_date) || empty($request->end_date)) {
            if (empty($request->date)) {
                $date = Carbon::now()->format('Y-m-d');
                $start_date = Carbon::parse($date)->subMonth()->addDay(25)->format('Y-m-d');
                $end_date = Carbon::parse($date)->addDay(24)->format(('Y-m-d'));
            } else {
                $start_date = Carbon::parse($request->date)->subMonth()->addDay(25)->format('Y-m-d');
                $end_date = Carbon::parse($request->date)->addDay(24)->format(('Y-m-d'));
            }
        } else {
            $start_date = Carbon::parse($request->start_date);
            $end_date = Carbon::parse($request->end_date);
        }
        $start_date = '2023-07-26';
        $end_date = '2023-08-25';
        $client_logo_path = session()->get('client_logo_url');
        $public_client_logo_path = public_path($client_logo_path);


        if (empty($request->active_status)) {
            $active_status = 'Active,Resigned,Yet to activate';
        } else {
            $active_status = '';
            foreach ($request->active_status as $single_sts) {
                if ($single_sts == '0') {
                    $active_status = $active_status . 'Yet to activate,';
                } else if ($single_sts == '1') {
                    $active_status = $active_status . 'Active,';
                } else if ($single_sts == '-1') {
                    $active_status = $active_status . 'Resigned,';
                } else {
                }
            }
        }
        // dd($request->all());
        $period = Carbon::parse($start_date)->format('d-M-Y') . ' - ' . Carbon::parse($end_date)->format('d-M-Y');
        // dd($start_date);
        $department_id = '';
        $client_id = '';
        // dd($attendance_services->downloadDetailedAttendanceReport($start_date, $end_date, $department_id, $client_id));
        return Excel::download(new BasicAttendanceExport($attendance_services->downloadDetailedAttendanceReport($start_date, $end_date, $request->department_id, $request->client_id), $public_client_logo_path, $active_status, $period, sessionGetSelectedClientName()), 'Basic Attendance Report c  .xlsx');
    }
}
