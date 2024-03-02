<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResignationSetting extends Model
{
    use HasFactory;
    protected $table = 'vmt_resignation_setting';
    protected $fillable = [
        'client_id',
        'emp_can_apply_resignation',
        'manager_can_submit_resignation_for_emp',
        'hr_can_submit_resignation_for_emp',
        'emp_can_edit_last_working_day',
        'resignation_auto_approve',
        'resignation_approver_flow',
        'email_reminder_for_resignation'
    ];
}
