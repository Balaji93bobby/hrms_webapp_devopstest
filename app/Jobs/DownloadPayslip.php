<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\VmtAttendanceService;
use App\Services\VmtEmployeePayCheckService;
use App\Notifications\QueueHasLongWaitTime;
use Illuminate\Queue\Events\QueueBusy;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;

class DownloadPayslip implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $data;
    public function __construct()
    {
        //


}


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(VmtEmployeePayCheckService $employeePaySlipService ,VmtAttendanceService $serviceVmtAttendanceService)
    {
        //
        // $user_details =$this->data;

        // foreach ($user_details as $key => $single_data) {

         $response=$employeePaySlipService->downloadBulkEmployeePayslip($serviceVmtAttendanceService);

      //}
      return $response;

}
public function boot()
{
    Event::listen(function (QueueBusy $event) {
        Notification::route('mail', 'dev@example.com')
                ->notify(new QueueHasLongWaitTime(
                    $event->connection,
                    $event->queue,
                    $event->size
                ));
    });
}
}
