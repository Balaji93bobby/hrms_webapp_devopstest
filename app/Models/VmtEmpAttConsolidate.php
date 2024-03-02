<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VmtEmpAttConsolidate extends Model
{
    use HasFactory;

    protected $table = 'vmt_emp_att_consol_intrtable';

    protected $fillable = [
        'month',
        'user_id',
        'weekoff',
        'holiday',
        'present',
        'absent',
        'lc_eg_lop',
        'leave',
        'halfday',
        'on_duty',
        'lc',
        'eg',
        'payable_days'
    ];
}
