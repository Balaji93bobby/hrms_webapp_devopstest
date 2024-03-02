<?php

namespace App\Console;

use App\Models\VmtWorkShifts;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use App\Http\Controllers\VmtEmployeeBirthdayController;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call('App\Http\Controllers\VmtStaffAttendanceController@syncStaffAttendanceFromDeviceDatabase')->everyThirtyMinutes()->timezone('Asia/Kolkata')->between('09:00', '17:45');

        $schedule->call('App\Http\Controllers\VmtAttendanceControllerV2@attendanceJob')->everyThirtyMinutes()->sendOutputTo('logs/attendance.log');

        $schedule->call(function () {
            try {
                $output = (new VmtEmployeeBirthdayController)->sendBirthdayNotificationtoEmployee();

                Log::channel('birthday')->info('Birthday Mail Send Successfully :

                ',['output' => $output] );

            } catch (\Exception $e) {
                Log::channel('errorlog')->info('Error in first task: '. $e->getMessage()." ".$e->getline());
            }

        })->daily();

        $schedule->call(function () {
            try {
                $output = (new VmtEmployeeBirthdayController)->sendAniversaryNotificationtoEmployee();

                Log::channel('anniversary')->info('Anniversary Mail Send Successfully :

                ',['output' => $output] );

            } catch (\Exception $e) {
                Log::channel('errorlog')->info('Error in first task: '. $e->getMessage()." ".$e->getline());
                // Log::error('Error in first task: ' . $e->getMessage());
            }

        })->daily();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
