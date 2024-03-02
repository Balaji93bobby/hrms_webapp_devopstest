<?php

namespace App\Http\Controllers;

use App\Services\VmtPayRunService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VmtPayRunController extends Controller
{
    public function fetch_attendance_data(Request $request, VmtPayRunService $pay_run_service)
    {
        if (empty($request->start_date)  || empty($request->end_date)) {
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
        return $pay_run_service->fetch_attendance_data($start_date, $end_date, $request->department_id, $request->client_id, $request->type, $request->active_status);
    }
}
