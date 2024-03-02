<?php

namespace App\Services;
/*
    Custom model used to hold an employee overall leave balance


*/

class VmtEmployeeLeaveModel{

    public $user_id;
    public $employee_name;
    public $array_leave_details;

    function __construct($user_id, $employee_name, $array_leave_details) {
        $this->user_id = $user_id;
        $this->employee_name = $employee_name;
        $this->array_leave_details = $array_leave_details;
    }


}
