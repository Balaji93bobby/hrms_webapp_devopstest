<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VmtEmployeeResignation extends Model
{
    use HasFactory;
    protected $table = 'vmt_employee_resignation';
    protected $fillable = [
        'request_date',
        'vmt_resignation_type_id',
        'resignation_reason',
        'notice_period_date',
        'expected_last_working_day',
        'last_payroll_date',
        'reason_for_dol_change',
        'approval_status'
    ];
}
