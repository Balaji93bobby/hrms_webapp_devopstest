<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DetailedAttendanceExport;
use App\Services\VmtAttendanceReportsService;
use App\Models\VmtClientMaster;

class DetailedAttendanceReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $attendance_data;
    protected $is_lc;
    protected $client_name;
    protected $public_client_logo_path;
    protected $start_date;
    protected $end_date;
    protected $attendance_report_service;
    protected $department_id;
    protected  $client_id;
    public function __construct(VmtAttendanceReportsService $attendance_report_service, $is_lc, $start_date, $end_date, $department_id, $client_id)
    {
        $this->is_lc = $is_lc;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->attendance_report_service = $attendance_report_service;
        $this->department_id = $department_id;
        $this->client_id = $client_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->attendance_data = $this->attendance_report_service->detailedAttendanceReport($this->start_date, $this->end_date, $this->department_id,  $this->client_id);

        $this->client_name = sessionGetSelectedClientName();
        $this->public_client_logo_path = public_path(session()->get('client_logo_url'));
        Excel::download(new DetailedAttendanceExport($this->attendance_data,  $this->is_lc, $this->client_name, $this->public_client_logo_path, $this->start_date, $this->end_date), 'Detailed Attendance Report.xlsx');
    }
}
