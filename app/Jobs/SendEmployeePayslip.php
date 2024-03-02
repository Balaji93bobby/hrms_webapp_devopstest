<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\VmtEmployeeWorkShifts;
use App\Models\VmtWorkShifts;
use carbon\carbon;
use App\Services\VmtAttendanceService;
use App\Services\VmtEmployeePayCheckService;

class SendEmployeePayslip implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $data;

    public function __construct(array $user_data)
    {

       $this->data = $user_data;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(VmtEmployeePayCheckService $employeePaySlipService ,VmtAttendanceService $serviceVmtAttendanceService)
    {
        //

        $user_details =$this->data;
       
        foreach ($user_details as $key => $single_data) {

         $response=$employeePaySlipService->generatePayslip($single_data['user_code'], $single_data['month'], $single_data['year'], $single_data['type'], $serviceVmtAttendanceService);

      }
      return $response;
}
}
