<?php

use Carbon\Carbon;
use App\Models\VmtEmployeeLeaveBalance;
use App\Models\VmtMasterConfig;
use App\Models\VmtOrgRoles;
use App\Models\User;
use App\Models\VmtWorkShifts;
use App\Models\VmtClientMaster;
use App\Models\VmtEmployee;
use App\Models\VmtBloodGroup;
use App\Models\VmtLeaves;
use App\Models\ConfigPms;
use App\Models\VmtEmployeeLeaves;
use App\Models\VmtEmployeesLeavesAccrued;
use App\Models\VmtEmployeeOfficeDetails;
use App\Models\VmtOrgTimePeriod;



function getLeaveCountDetails($user_id){

    $leaveTypes = VmtLeaves::all()->keyBy('id');

    $leaveCountDetails_user = VmtEmployeeLeaves::select('leave_type_id', DB::raw("SUM(total_leave_datetime) as leave_availed_count"))
                                                ->where('user_id', $user_id)
                                                ->where('status','Approved')
                                                ->where('status','Pending')
                                                ->groupBy('leave_type_id')->get();

    //Add leave names to the array

    foreach($leaveCountDetails_user as $singleData){
        $singleData->leave_name = $leaveTypes[$singleData->leave_type_id]["leave_type"];
    }

    //Create map
    $response = $leaveCountDetails_user->mapWithKeys(function ($item, $key) {
        return [$item['leave_name'] => $item];
    });

    return $response;
}

function getPermissionLeaveTypeIDs(){
    return VmtLeaves::where('leave_type','like','%Permission%')->pluck('id');
}

// Check whether the given ID is permission or leave type
function isPermissionLeaveType($id){
    $type = VmtLeaves::where('id', $id)->where('leave_type', 'like', '%Permission%');

    if ($type->exists())
        return true;
    else
        return false;
}


function getAllLeaveTypes()
{
    return VmtLeaves::all(['id','leave_type']);
}

/*
    Based on user_time, return LC/EG
    TODO : In Future, add $shift_type parameter

    $attendance_type : check-in/check-out
*/
function checkRegularizationType($user_time, $attendance_type){
    $checkin_grace_time = "0";//TODO : In Future
    $shift_timings = VmtWorkShifts::where('shift_type', 'First Shift')->first();


    if($attendance_type == "check-in"){
        $shiftStartTime  = Carbon::parse($shift_timings->shift_start_time);

        $parsedCheckIn_time  = Carbon::parse($user_time);

        //Check whether checkin done on-time
        if($parsedCheckIn_time->gt($shiftStartTime))
        {
            return "LC";
        }
        else
        {
            return null;
        }

    }

}



